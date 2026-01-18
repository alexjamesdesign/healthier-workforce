<?php
/**
 * Prevent PHP session locking from breaking wp-admin/admin-ajax concurrency.
 */

function ajd_close_php_session_lock()
{
    if (session_status() === PHP_SESSION_ACTIVE) {
        @session_write_close();
    }
}

add_action('muplugins_loaded', function () {
    if (is_admin() || (defined('DOING_AJAX') && DOING_AJAX)) {
        ajd_close_php_session_lock();
    }
}, 0);

add_action('init', function () {
    if (is_admin() || (defined('DOING_AJAX') && DOING_AJAX)) {
        ajd_close_php_session_lock();
    }
}, 0);

// Catch anything that starts a session later in the request
add_action('shutdown', function () {
    if (is_admin() || (defined('DOING_AJAX') && DOING_AJAX)) {
        ajd_close_php_session_lock();
    }
}, 0);
