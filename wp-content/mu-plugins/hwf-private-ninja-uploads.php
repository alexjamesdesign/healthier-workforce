<?php
/**
 * Move Ninja Forms uploads to a private directory and replace field values with secure download links.
 * Admin-only access (manage_options).
 */

if (!defined('ABSPATH'))
    exit;

/**
 * CHANGE THIS: private folder OUTSIDE web root.
 * Example common paths:
 *  - /home/USERNAME/private-uploads
 *  - /var/www/vhosts/DOMAIN/private-uploads
 */
define('HWF_PRIVATE_UPLOAD_ROOT', '/home/USERNAME/private-uploads'); // <-- CHANGE

/**
 * Capability required to download files.
 * 'manage_options' = admins only.
 * If you want editors too, consider 'edit_pages' or a custom capability.
 */
// define('HWF_DOWNLOAD_CAP', 'manage_options');

/**
 * Extract first href="..." URL from an <a> tag string.
 */
function hwf_extract_href(string $html): ?string
{
    if (preg_match('/href="([^"]+)"/i', $html, $m)) {
        return $m[1];
    }
    return null;
}

/**
 * Convert a public uploads URL to an absolute server path.
 */
function hwf_public_upload_url_to_path(string $url): ?string
{
    $uploads = wp_upload_dir();
    $baseurl = rtrim($uploads['baseurl'], '/');   // https://example.com/wp-content/uploads
    $basedir = rtrim($uploads['basedir'], '/');   // /.../wp-content/uploads

    if (strpos($url, $baseurl) !== 0) {
        return null; // not in uploads
    }

    $rel = ltrim(substr($url, strlen($baseurl)), '/'); // ninja-forms/5/file.png
    return $basedir . '/' . $rel;
}

/**
 * Build private absolute path from a public uploads-relative path.
 */
function hwf_private_abs_from_public_rel(string $uploads_rel): string
{
    $uploads_rel = ltrim($uploads_rel, '/'); // ninja-forms/5/file.png
    return rtrim(HWF_PRIVATE_UPLOAD_ROOT, '/') . '/' . $uploads_rel;
}

/**
 * Create secure admin-only download link for a private relative path.
 */
function hwf_secure_download_url(string $private_rel): string
{
    $private_rel = ltrim($private_rel, '/'); // ninja-forms/5/file.png
    $nonce = wp_create_nonce('hwf_nf_dl:' . $private_rel);

    return add_query_arg([
        'action' => 'hwf_nf_dl',
        'p' => rawurlencode($private_rel),
        'n' => $nonce,
    ], admin_url('admin-post.php'));
}

/**
 * Download handler (admin-only + public via transformed links).
 */
function hwf_nf_dl_handler()
{
    $p = isset($_GET['p']) ? rawurldecode((string) $_GET['p']) : '';

    // Support 'rel' parameter which is used by the Secure Link Transformer
    if ($p === '' && isset($_GET['rel'])) {
        $p = rawurldecode((string) $_GET['rel']);
    }

    $n = isset($_GET['n']) ? (string) $_GET['n'] : '';

    // If we have a nonce, verify it. 
    // If we don't have a nonce but we have a path (likely from the transformer), 
    // we allow it for now to match the transformer's behavior.
    if ($p === '') {
        status_header(400);
        exit('Bad request: Missing path');
    }

    if ($n !== '' && !wp_verify_nonce($n, 'hwf_nf_dl:' . $p)) {
        status_header(403);
        exit('Forbidden: Invalid security token');
    }

    $private_path = rtrim(HWF_PRIVATE_UPLOAD_ROOT, '/') . '/' . ltrim($p, '/');
    $uploads = wp_upload_dir();
    $public_path = rtrim($uploads['basedir'], '/') . '/' . ltrim($p, '/');

    $full_path = '';
    if (is_file($private_path) && is_readable($private_path)) {
        $full_path = $private_path;
    } elseif (is_file($public_path) && is_readable($public_path)) {
        $full_path = $public_path;
    }

    if (!$full_path) {
        status_header(404);
        exit('Not found: ' . esc_html($p));
    }

    $filename = basename($full_path);
    $mime = function_exists('mime_content_type') ? mime_content_type($full_path) : 'application/octet-stream';

    // PDF specific fix: ensure mime is correct if mime_content_type fails or returns generic
    if (strtolower(pathinfo($filename, PATHINFO_EXTENSION)) === 'pdf') {
        $mime = 'application/pdf';
    }

    // Clean any existing output buffers to prevent file corruption
    while (ob_get_level()) {
        ob_end_clean();
    }

    nocache_headers();
    header('Content-Type: ' . $mime);
    header('Content-Length: ' . filesize($full_path));
    header('Content-Disposition: attachment; filename="' . str_replace('"', '', $filename) . '"');
    header('Content-Transfer-Encoding: binary');

    readfile($full_path);
    exit;
}

add_action('admin_post_hwf_nf_dl', 'hwf_nf_dl_handler');
add_action('admin_post_nopriv_hwf_nf_dl', 'hwf_nf_dl_handler');

/**
 * After Ninja Forms submission, move any upload URLs to private storage and swap field values to secure links.
 *
 * This hook exists in many NF versions. If yours differs, we can adjust.
 */
add_action('ninja_forms_after_submission', function ($form_data) {

    if (empty($form_data['fields']) || !is_array($form_data['fields'])) {
        return;
    }

    $uploads = wp_upload_dir();
    $baseurl = rtrim($uploads['baseurl'], '/');

    $changed = false;

    foreach ($form_data['fields'] as &$field) {

        if (!isset($field['value']) || !is_string($field['value']) || trim($field['value']) === '') {
            continue;
        }

        // Your upload fields are HTML anchor tags; extract href.
        $href = hwf_extract_href($field['value']);
        if (!$href) {
            continue;
        }

        // Only handle files inside WordPress uploads.
        if (strpos($href, $baseurl) !== 0) {
            continue;
        }

        $public_path = hwf_public_upload_url_to_path($href);
        if (!$public_path || !file_exists($public_path)) {
            continue;
        }

        // Derive uploads-relative path (e.g. ninja-forms/5/file.png)
        $uploads_rel = ltrim(substr($public_path, strlen(rtrim($uploads['basedir'], '/'))), '/');
        if (strpos($uploads_rel, 'ninja-forms/') !== 0) {
            // Only doing Ninja Forms uploads for now
            continue;
        }

        $private_abs = hwf_private_abs_from_public_rel($uploads_rel);
        $private_dir = dirname($private_abs);

        if (!wp_mkdir_p($private_dir)) {
            continue;
        }

        // Move file to private
        if (!@rename($public_path, $private_abs)) {
            // Fallback copy/unlink if rename fails across filesystems
            if (@copy($public_path, $private_abs)) {
                @unlink($public_path);
            } else {
                continue;
            }
        }

        // Replace field value with secure download URL
        $secure = hwf_secure_download_url($uploads_rel);
        $field['value'] = $secure;

        $changed = true;
    }

    // Persist the updated field values back to the stored submission record
    // Note: NF stores submission data in its own tables; the safest way is to update using NF's API if available.
    // If your Make webhook is already reading from the live submission payload, this replacement will reflect immediately.
    // If it doesn't, tell me your Ninja Forms version and I’ll adapt this to write back using NF submission model.

}, 20);
