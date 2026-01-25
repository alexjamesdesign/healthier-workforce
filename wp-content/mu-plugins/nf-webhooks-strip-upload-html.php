<?php
/**
 * Ninja Forms Webhooks Add-on: strip <a> tags in upload fields and output only relative paths.
 */

function hwf_nf_extract_upload_relpaths_from_html($html)
{
    if (!is_string($html) || $html === '')
        return $html;

    // Only bother if it looks like Ninja upload HTML
    if (stripos($html, 'wp-content/uploads/ninja-forms') === false)
        return $html;

    preg_match_all(
        '#href=["\'](https?://[^"\']+/wp-content/uploads/ninja-forms/[^"\']+)#i',
        $html,
        $m
    );

    if (empty($m[1]))
        return $html;

    $paths = array_map(function ($url) {
        $path = parse_url($url, PHP_URL_PATH);
        return ltrim($path, '/');
    }, $m[1]);

    // One per line (Sheets-friendly)
    return implode("\n", $paths);
}

/**
 * Hook into the Webhooks add-on "request data" right before sending.
 *
 * The exact filter name can vary slightly by version, so we register a few common ones.
 */
$filters = [
    'ninja_forms_webhooks_request_data',
    'ninja_forms_webhooks_request_args',
    'nf_webhooks_request_data',
    'nf_webhooks_request_args',
];

foreach ($filters as $f) {
    add_filter($f, function ($payload) {

        // Payload could be array of args OR could be string body
        if (is_array($payload)) {
            foreach ($payload as $k => $v) {
                if (is_string($v)) {
                    $payload[$k] = hwf_nf_extract_upload_relpaths_from_html($v);
                }
            }
            return $payload;
        }

        if (is_string($payload)) {
            // If it’s JSON encoded body, we can attempt decode/encode
            $decoded = json_decode($payload, true);
            if (is_array($decoded)) {
                foreach ($decoded as $k => $v) {
                    if (is_string($v)) {
                        $decoded[$k] = hwf_nf_extract_upload_relpaths_from_html($v);
                    }
                }
                return wp_json_encode($decoded);
            }

            // If it’s a query string style body, just return as-is (we can handle later)
            return $payload;
        }

        return $payload;
    }, 9999);
}
