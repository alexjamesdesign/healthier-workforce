<?php
/**
 * Local compatibility shim for plugins expecting newer WordPress core helpers.
 *
 * Remove this once core is upgraded to a version that defines the function.
 */

if ( ! function_exists( 'wp_is_serving_rest_request' ) ) {
	/**
	 * Determine whether the current request is a REST API request.
	 *
	 * WordPress 6.3 does not provide this helper, but newer Yoast versions call it.
	 *
	 * @return bool
	 */
	function wp_is_serving_rest_request() {
		return defined( 'REST_REQUEST' ) && REST_REQUEST;
	}
}
