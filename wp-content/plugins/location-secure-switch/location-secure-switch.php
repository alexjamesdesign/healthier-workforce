<?php
/**
 * Plugin Name: Location Switch – Safe Base (loc-only, content-only)
 * Description: Replaces {{location}} tokens in content using an ID from ?loc=... via Cloudflare Worker (flat JSON).
 * Version:     0.5.0
 */

if (!defined('ABSPATH')) exit;

/* ------------------------------------------------------------------
   GLOBAL SETTINGS (shared by class + helpers)
------------------------------------------------------------------- */
define('LSS_MAP_OPT_KEY', 'lss_map_api_opts'); // single options array
define('LSS_MAP_API_BASE', 'https://lss-api.location-license-server.workers.dev/'); // hardcoded base (must end with /)

if (!defined('LSS_MAP_DEFAULTS')) {
  define('LSS_MAP_DEFAULTS', json_encode([
  // 'api_token' is gone – we don’t store it in the DB anymore
  'fallback_location' => 'your area',
  'param_name'        => 'loc',
  'site_id'           => '',
  'activation_key'    => '',
]));

}

if (!defined('LSS_API_BEARER')) {
  define('LSS_API_BEARER', '04df68e299a567b38702cc25b5926b4c67387b57abb2662eddf56c7ff3b08e00');
}


/** Merge saved options with defaults */
function lss_map_get_opts(): array {
  $saved = get_option(LSS_MAP_OPT_KEY, []);
  $defs  = json_decode(LSS_MAP_DEFAULTS, true);
  return array_merge($defs, is_array($saved) ? $saved : []);
}

/* ------------------------------------------------------------------
   SETTINGS PAGE (Settings → LSS Map)
------------------------------------------------------------------- */
add_action('admin_init', function () {
  register_setting(LSS_MAP_OPT_KEY, LSS_MAP_OPT_KEY, [
  'type' => 'array',
  'sanitize_callback' => function ($in) {
    $o = lss_map_get_opts();
    $out = $o;

    // Fallback location text
    if (isset($in['fallback_location'])) {
      $out['fallback_location'] = sanitize_text_field($in['fallback_location']);
    }

    // Query parameter (?loc= or ?lid=)
    if (isset($in['param_name'])) {
      $pn = sanitize_text_field($in['param_name']);
      $pn = preg_replace('/[^a-z0-9_\-]/i', '', $pn);
      if ($pn !== '') $out['param_name'] = $pn;
    }

    // NEW: Site ID – simple slug-like string
    if (isset($in['site_id'])) {
      $out['site_id'] = preg_replace(
        '/[^a-z0-9_\-]/i',
        '',
        sanitize_text_field($in['site_id'])
      );
    }

    // NEW: Activation key – we just clean basic whitespace; can be long
    if (isset($in['activation_key'])) {
      $out['activation_key'] = trim(sanitize_text_field($in['activation_key']));
    }

    return $out;
  },
  'default' => json_decode(LSS_MAP_DEFAULTS, true),
]);


  add_settings_section('lss_map_sec', 'LSS Map API', '__return_false', LSS_MAP_OPT_KEY);

  add_settings_field('fallback_location', 'Fallback Location', function () {
    $o = lss_map_get_opts();
    printf(
      '<input type="text" name="%1$s[fallback_location]" value="%2$s" size="40" />',
      esc_attr(LSS_MAP_OPT_KEY), esc_attr($o['fallback_location'])
    );
  }, LSS_MAP_OPT_KEY, 'lss_map_sec');

  add_settings_field('param_name', 'Query Parameter Name', function () {
    $o = lss_map_get_opts();
    printf(
      '<input type="text" name="%1$s[param_name]" value="%2$s" size="20" />' .
      '<p class="description">Default: <code>loc</code> (so URLs look like <code>?loc=1006458</code>).</p>',
      esc_attr(LSS_MAP_OPT_KEY), esc_attr($o['param_name'])
    );
  }, LSS_MAP_OPT_KEY, 'lss_map_sec');
});

add_action('admin_menu', function () {
  add_options_page('LSS Map', 'LSS Map', 'manage_options', 'lss-map', function () {
    if (!current_user_can('manage_options')) return; ?>
    <div class="wrap">
      <h1>LSS Map Settings</h1>
      <form method="post" action="options.php">
        <?php
          settings_fields(LSS_MAP_OPT_KEY);
          do_settings_sections(LSS_MAP_OPT_KEY);
          submit_button('Save Settings');
        ?>
      </form>
    </div>
  <?php });
});

/** Clear cached transients when settings change */
add_action('update_option_' . LSS_MAP_OPT_KEY, function () {
  global $wpdb;
  $wpdb->query(
    "DELETE FROM {$wpdb->options} WHERE option_name LIKE '_transient_lss_map_%' OR option_name LIKE '_transient_timeout_lss_map_%'"
  );
}, 10, 0);

/* ------------------------------------------------------------------
   REMOTE LOOKUP (shared)
------------------------------------------------------------------- */
/**
 * Calls Worker /loc?id=<ID>, caches JSON: { id, location, name, country_code, type }
 * Returns array or null.
 */
function lss_map_fetch_record_by_id(?string $id): ?array {
  if (!$id || !preg_match('/^\d+$/', $id)) return null;

  $token = LSS_API_BEARER; // ← instead of reading option
  if (!$token) return null;

  $cache_key  = 'lss_map_' . $id;

  // Hard-coded TTL: 10 minutes
  $ttlMinutes = 10;
  $ttl        = $ttlMinutes * MINUTE_IN_SECONDS;

  if ($ttl > 0) {
    $cached = get_transient($cache_key);
    if (is_array($cached)) return $cached;
  }


    $endpoint = trailingslashit(LSS_MAP_API_BASE) . 'loc';
  $url = add_query_arg(['id' => $id], $endpoint);

  // Licensing headers
  $site_opts = lss_map_get_opts();
  $site_id   = $site_opts['site_id'] ?? '';
  $license   = $site_opts['activation_key'] ?? '';
  $host      = $_SERVER['HTTP_HOST'] ?? '';

  $resp = wp_remote_get($url, [
    'timeout' => 5,
    'headers' => [
      'Accept'        => 'application/json',
      'Authorization' => 'Bearer ' . $token, // transport security
      'X-LSS-Site'    => $site_id,
      'X-LSS-Key'     => $license,
      'X-LSS-Host'    => $host,
    ],
  ]);

  if (is_wp_error($resp)) return null;
  if (wp_remote_retrieve_response_code($resp) !== 200) return null;

  $data = json_decode(wp_remote_retrieve_body($resp), true);
  if (!is_array($data) || empty($data['location'])) return null;

  if ($ttl > 0) set_transient($cache_key, $data, $ttl);
  return $data;
}

/**
 * Calls Worker /ctm?id=<ID>, returns dial string or null.
 * Uses the same API base + Bearer token as the location lookup.
 */
function lss_map_fetch_ctm_dial_by_id(?string $id): ?string {
  if (!$id || !preg_match('/^\d+$/', $id)) return null;

  $token = LSS_API_BEARER;
  if (!$token) return null;

    $endpoint = trailingslashit(LSS_MAP_API_BASE) . 'ctm';
  $url = add_query_arg(['id' => $id], $endpoint);

  $site_opts = lss_map_get_opts();
  $site_id   = $site_opts['site_id'] ?? '';
  $license   = $site_opts['activation_key'] ?? '';
  $host      = $_SERVER['HTTP_HOST'] ?? '';

  $resp = wp_remote_get($url, [
    'timeout' => 5,
    'headers' => [
      'Accept'        => 'application/json',
      'Authorization' => 'Bearer ' . $token,
      'X-LSS-Site'    => $site_id,
      'X-LSS-Key'     => $license,
      'X-LSS-Host'    => $host,
    ],
  ]);

  if (is_wp_error($resp)) return null;

  $code = wp_remote_retrieve_response_code($resp);
  if ($code !== 200) return null;

  $data = json_decode(wp_remote_retrieve_body($resp), true);
  if (!is_array($data) || empty($data['dial'])) return null;

  return (string) $data['dial'];
}


/** Convenience: decide current desired display string */
function lss_map_resolve_display(): string {
  $o = lss_map_get_opts();
  $param = $o['param_name'] ?: 'loc';
  $incoming = isset($_GET[$param]) ? trim((string)$_GET[$param]) : '';

  // Prefer remote value if valid
  if ($incoming !== '') {
    $rec = lss_map_fetch_record_by_id($incoming);
    if ($rec && !empty($rec['location'])) return (string)$rec['location'];
    if ($rec && !empty($rec['name']))     return (string)$rec['name'];
  }

  // Then cookie (if present)
  if (isset($_COOKIE[LSS_Base_Safe::COOKIE])) {
    $c = sanitize_text_field(wp_unslash($_COOKIE[LSS_Base_Safe::COOKIE]));
    if ($c !== '') return $c;
  }

  // Fallback
  return $o['fallback_location'] ?: 'your area';
}

/* ------------------------------------------------------------------
   ORIGINAL CLASS (cleaned) — now uses the shared resolver above
------------------------------------------------------------------- */
if (!class_exists('LSS_Base_Safe')) {
  class LSS_Base_Safe {
    const COOKIE = 'lss_loc_base';
    private $fallback_name = 'your area';
    private $cookie_days   = 90;
    private $resolved      = null;

    function __construct() {
      $opts = get_option('lss_base_safe_opts');
      if (is_array($opts)) {
        $this->fallback_name = isset($opts['fallback_name']) ? (string)$opts['fallback_name'] : $this->fallback_name;
        $this->cookie_days   = isset($opts['cookie_days'])   ? (int)$opts['cookie_days']      : $this->cookie_days;
      }

      add_action('admin_menu',  [$this,'menu']);
      add_action('admin_init',  [$this,'save']);

      add_action('init',        [$this,'resolve_once']);
      add_filter('the_content', [$this,'replace_tokens'], 11);

      add_shortcode('loc',      [$this,'shortcode']); // [loc case="title" default="your area"]
    }

    /** Admin menu */
    function menu() {
      add_options_page('Location Switch','Location Switch','manage_options','lss-base-safe',[$this,'page']);
    }

/** Admin page (UNIFIED: Location Switch + API fields) */
function page() {
  if (!current_user_can('manage_options')) return;

  // Current values from both options
  $base_opts = [
    'fallback_name' => $this->fallback_name,
    'cookie_days'   => $this->cookie_days,
  ];
  $map_opts = function_exists('lss_map_get_opts') ? lss_map_get_opts() : [
  'fallback_location' => $this->fallback_name,
  'param_name'        => 'loc',
  'site_id'           => '',
  'activation_key'    => '',
];
  ?>
  <div class="wrap">
    <h1>Location Switch – Settings</h1>
    <form method="post">
      <?php wp_nonce_field('lss_base_safe','lss_base_safe'); ?>

      <h2>Display & Cookie</h2>
      <table class="form-table">
        <tr>
          <th><label for="fallback_name">Fallback location</label></th>
          <td><input name="fallback_name" id="fallback_name" type="text" value="<?php echo esc_attr($base_opts['fallback_name']); ?>" class="regular-text"></td>
        </tr>
        <tr>
          <th><label for="cookie_days">Cookie days (default 90)</label></th>
          <td><input name="cookie_days" id="cookie_days" type="number" min="1" value="<?php echo (int)$base_opts['cookie_days']; ?>" class="small-text"></td>
        </tr>
      </table>

<h2>Cloudflare Licence & API Settings</h2>
<table class="form-table">
  <tr>
    <th><label for="site_id">Site ID</label></th>
    <td>
      <input name="site_id" id="site_id" type="text"
             value="<?php echo esc_attr($map_opts['site_id'] ?? ''); ?>"
             class="regular-text">
      <p class="description">
        Short identifier you issue for this site (e.g. <code>TECHMONZA</code>).<br>
        Must match a <code>site:&lt;ID&gt;</code> entry in your Cloudflare <code>SITES</code> KV.
      </p>
    </td>
  </tr>

  <tr>
    <th><label for="activation_key">Activation Key</label></th>
    <td>
      <input name="activation_key" id="activation_key" type="password"
             value="<?php echo esc_attr($map_opts['activation_key'] ?? ''); ?>"
             size="60" autocomplete="off">
      <p class="description">
        Licence key you generate for this site. Used to enable/disable access.
      </p>
    </td>
  </tr>
  <tr>
    <th><label for="param_name">Query Parameter</label></th>
    <td>
      <input name="param_name" id="param_name" type="text"
             value="<?php echo esc_attr($map_opts['param_name'] ?? 'loc'); ?>"
             class="small-text">
      <span class="description">
        Default <code>loc</code> → URLs like <code>?loc=1006458</code>
      </span>
    </td>
  </tr>
</table>



      <p><button class="button button-primary">Save changes</button></p>
    </form>
  </div>
  <?php
}


/** Admin save (UNIFIED: saves both base + API settings) */
function save() {
  if (!is_admin() || !current_user_can('manage_options')) return;
  if (!isset($_POST['lss_base_safe']) || !wp_verify_nonce($_POST['lss_base_safe'], 'lss_base_safe')) return;

  // Save base settings
  $new_base = [
    'fallback_name' => isset($_POST['fallback_name']) ? sanitize_text_field($_POST['fallback_name']) : 'your area',
    'cookie_days'   => isset($_POST['cookie_days'])   ? max(1, intval($_POST['cookie_days']))        : 90,
  ];
  update_option('lss_base_safe_opts', $new_base);
  $this->fallback_name = $new_base['fallback_name'];
  $this->cookie_days   = $new_base['cookie_days'];

  // Save API (LSS Map) settings into the existing LSS_MAP_OPT_KEY option
$map_opts = function_exists('lss_map_get_opts') ? lss_map_get_opts() : [
  'fallback_location' => $this->fallback_name,
  'param_name'        => 'loc',
  'site_id'           => '',
  'activation_key'    => '',
];

// Query parameter (?loc= / ?lid=)
if (isset($_POST['param_name'])) {
  $pn = sanitize_text_field($_POST['param_name']);
  $pn = preg_replace('/[^a-z0-9_\-]/i', '', $pn);
  if ($pn !== '') {
    $map_opts['param_name'] = $pn;
  }
}

// Site ID
if (isset($_POST['site_id'])) {
  $map_opts['site_id'] = preg_replace(
    '/[^a-z0-9_\-]/i',
    '',
    sanitize_text_field($_POST['site_id'])
  );
}

// Activation key
if (isset($_POST['activation_key'])) {
  $map_opts['activation_key'] = trim(sanitize_text_field($_POST['activation_key']));
}

// Keep fallbacks in sync: use the display fallback for map fallback too
$map_opts['fallback_location'] = $this->fallback_name;

update_option(LSS_MAP_OPT_KEY, $map_opts);


  // Best-effort: clear API transients when settings change
  global $wpdb;
  $wpdb->query(
    "DELETE FROM {$wpdb->options} WHERE option_name LIKE '_transient_lss_map_%' OR option_name LIKE '_transient_timeout_lss_map_%'"
  );

  add_action('admin_notices', function(){
    echo '<div class="notice notice-success is-dismissible"><p>Location Switch settings saved.</p></div>';
  });
}


  function resolve_once() {
    if ($this->resolved !== null) return;

    $display = lss_map_resolve_display(); // shared resolver

    // If a URL ID was present, persist final display value to cookie
    $o       = lss_map_get_opts();
    $param   = $o['param_name'] ?: 'loc';
    $incoming = isset($_GET[$param]) ? trim((string)$_GET[$param]) : '';

    if ($incoming !== '') {
      $this->set_cookie($display);
    }

    $this->resolved = $display ?: ($this->fallback_name ?: 'your area');
  }




    /** Cookie helper */
    private function set_cookie($value) {
      if (headers_sent()) return;
      $days   = max(1, (int)$this->cookie_days);
      $path   = defined('COOKIEPATH')    ? COOKIEPATH    : '/';
      $domain = defined('COOKIE_DOMAIN') ? COOKIE_DOMAIN : '';
      $secure = is_ssl();
      setcookie(self::COOKIE, $value, time() + 86400 * $days, $path, $domain, $secure, true);
    }

    /** Replace tokens in content */
    function replace_tokens($html) {
      if (is_admin()) return $html;
      $this->resolve_once();
      return $this->do_replace($html, $this->resolved);
    }

    /** Shortcode: [loc case="title" default="your area"] */
    function shortcode($atts = []) {
      $this->resolve_once();
      $a = shortcode_atts(['case'=>'title','default'=>$this->fallback_name], $atts, 'loc');
      $val = $this->resolved ?: $a['default'];
      $c = strtolower((string)$a['case']);
      if ($c === 'upper') return esc_html(function_exists('mb_strtoupper') ? mb_strtoupper($val,'UTF-8') : strtoupper($val));
      if ($c === 'lower') return esc_html(function_exists('mb_strtolower') ? mb_strtolower($val,'UTF-8') : strtolower($val));
      return esc_html($this->titlecase($val));
    }

    /** Helpers */
    private function do_replace($s, $val) {
      $repls = [
        '{{location}}' => $val,
        '{{Location}}' => $this->titlecase($val),
        '{{LOCATION}}' => (function_exists('mb_strtoupper') ? mb_strtoupper($val,'UTF-8') : strtoupper($val)),
      ];
      return strtr($s, $repls);
    }

    private function titlecase($s) {
      if (function_exists('mb_strtolower')) {
        $s = mb_strtolower($s,'UTF-8');
        return preg_replace_callback('/\b\p{L}/u', function($m){ return mb_strtoupper($m[0],'UTF-8'); }, $s);
      }
      $s = strtolower($s);
      return preg_replace_callback('/\b[a-z]/', function($m){ return strtoupper($m[0]); }, $s);
    }
  }
  new LSS_Base_Safe();
}

/**
 * CTM integration:
 * If we have ?loc=<id> (or whatever param_name is) and no &ctm= yet,
 * look up dial via CTM_MAP and redirect once to add &ctm=<dial>.
 */
function lss_ctm_maybe_add_param() {
  if (is_admin()) return;

  $o = lss_map_get_opts();
  $param = $o['param_name'] ?: 'loc'; // default ?loc=1007266

  // Already has ctm? Do nothing
  if (!empty($_GET['ctm'])) return;

  // No location ID? Do nothing
  if (empty($_GET[$param])) return;

  $id = trim((string) $_GET[$param]);
  if ($id === '' || !preg_match('/^\d+$/', $id)) return;

  // Call Worker for CTM dial
  $dial = lss_map_fetch_ctm_dial_by_id($id);
  if (!$dial) {
    // Optional: log for debugging
    // error_log('LSS CTM: no dial for id ' . $id);
    return;
  }

  // Add ctm=<dial>, preserving everything else (utm, gclid, etc.)
  $new_url = add_query_arg('ctm', rawurlencode($dial));

  wp_redirect($new_url, 302);
  exit;
}
add_action('template_redirect', 'lss_ctm_maybe_add_param', 1);


/* ------------------------------------------------------------------
   EXTRA OUTPUT: [lss_location] shortcode (same resolver)
------------------------------------------------------------------- */
add_shortcode('lss_location', function () {
  return esc_html(lss_map_resolve_display());
});

/* Also replace {{location}} directly via content filter, if class didn’t run */
add_filter('the_content', function ($content) {
  if (strpos($content, '{{location}}') === false) return $content;
  $val = lss_map_resolve_display();
  $repls = [
    '{{location}}' => $val,
    '{{Location}}' => (function_exists('mb_convert_case') ? mb_convert_case($val, MB_CASE_TITLE, 'UTF-8') : ucwords(strtolower($val))),
    '{{LOCATION}}' => (function_exists('mb_strtoupper') ? mb_strtoupper($val,'UTF-8') : strtoupper($val)),
  ];
  return strtr($content, $repls);
}, 12);

// Hide the separate "LSS Map" settings page if it's registered elsewhere
add_action('admin_menu', function () {
  remove_submenu_page('options-general.php', 'lss-map');
}, 999);

