<?php
/**
 * Ninja Forms – Convert upload field HTML to relative paths
 * Applies to ALL file upload fields and ALL forms
 */

add_filter('ninja_forms_submit_data', function ($data) {

    if (empty($data['fields'])) {
        return $data;
    }

    foreach ($data['fields'] as &$field) {

        if (empty($field['value']) || !is_string($field['value'])) {
            continue;
        }

        // Only touch fields that contain upload HTML
        if (strpos($field['value'], 'wp-content/uploads/ninja-forms') === false) {
            continue;
        }

        $value = $field['value'];

        // Extract all href URLs
        preg_match_all(
            '#href=["\'](https?://[^"\']+/wp-content/uploads/ninja-forms/[^"\']+)#i',
            $value,
            $matches
        );

        if (empty($matches[1])) {
            continue;
        }

        // Convert to relative paths
        $relative_paths = array_map(function ($url) {
            return ltrim(parse_url($url, PHP_URL_PATH), '/');
        }, $matches[1]);

        // One path per line (Sheets-friendly)
        $field['value'] = implode("\n", $relative_paths);
    }

    return $data;
});
