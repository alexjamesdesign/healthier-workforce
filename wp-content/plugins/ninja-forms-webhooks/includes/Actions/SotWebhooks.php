<?php
if (!defined('ABSPATH') || !class_exists('NinjaForms\\Includes\\Abstracts\SotAction'))
    exit;

use NinjaForms\Includes\Abstracts\SotAction;
use NinjaForms\Includes\Traits\SotGetActionProperties;
use NinjaForms\Includes\Interfaces\SotAction as InterfacesSotAction;

/**
 * Class NF_Action_Webhooks
 */
final class NF_Webhooks_Actions_SotWebhooks extends SotAction implements InterfacesSotAction
{

    use SotGetActionProperties;

    /**
     * @var array
     */
    protected $_tags = array();

    /**
     * @var array
     */
    protected $_debug = array();

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();

        $this->_name = 'webhooks';
        $this->_timing = 'late';
        $this->_priority = '10';

        add_action('init', [$this, 'initHook']);
    }

    public function initHook()
    {
        $this->_nicename = __('Webhooks', 'ninja-forms-webhooks');

        add_action('admin_init', array($this, 'init_settings'));

        add_action('ninja_forms_builder_templates', array($this, 'builder_templates'));
    }

    /*
    * PUBLIC METHODS
    */

    public function save(array $action_settings)
    {
        // Intentionally left empty.
    }

    public function init_settings()
    {
        $settings = NF_Webhooks::config('ActionWebhooksSettings');
        $this->_settings = array_merge($this->_settings, $settings);
    }

    public function builder_templates()
    {
        NF_Webhooks::template('args-repeater-row.html.php');
    }


    public function process(array $action_settings, int $form_id, array $data): array
    {
        $json_encode     = $action_settings['wh-encode-json'];
        $json_use_arg    = $action_settings['wh-json-use-arg'];
        $json_arg        = $action_settings['wh-json-arg'];
        $remote_url      = $action_settings['wh-remote-url'];
        $remote_method   = $action_settings['wh-remote-method'];
        $debug           = $action_settings['wh-debug-mode'];
        $wh_args         = $action_settings['wh-args'];

        if (! isset($remote_url)) return $data;

        $test_url = explode('://', $remote_url);
        // Prevent access to local network machines.
        if(isset($test_url[1]) && substr($test_url[1], 0, 8) === '169.254.') return $data;

        // If making a GET request, ensure we encode properly when required.
        if ('get' == $remote_method) $json_use_arg = 1;

        $args = array();
        foreach ($wh_args as $arg_data) {
            $args[$arg_data['key']] = $arg_data['value'];
        }

        $args = $this->maybe_encode($json_encode, $json_use_arg, $json_arg, $args);

        // Handle GET
        if ('get' == $remote_method) {
            $remote_url = $this->append_args($remote_url, $args, $form_id);
            $response = wp_safe_remote_get($remote_url, apply_filters('nf_remote_get_args', array(), $form_id));
            do_action('nf_remote_get', $response, $form_id);
            $data['actions']['webhooks']['remote_url'] = $remote_url;
            $data['actions']['webhooks']['response'] = $response;
            // Maybe output debug data
            if (1 == $debug) {
                $data['debug']['form']['webhooks_response'] = $this->output_request($remote_url);
                $data['debug']['form']['webhooks_response'] .= $this->output_response($response);
            }
        } // Handle POST
        else {
            $remote_url = apply_filters('nf_remote_post_url', $remote_url, $form_id);
            $post_headers = $this->construct_headers(array(), $json_encode, $json_use_arg);
            $post_body = $this->construct_body($args);
            $request = array_merge($post_headers, $post_body);
            $response = wp_safe_remote_post($remote_url, $request);
            do_action('nf_remote_post', $response, $form_id);
            $data['actions']['webhooks']['args'] = $args;
            $data['actions']['webhooks']['request'] = $request;
            $data['actions']['webhooks']['response'] = $response;
            // Maybe output debug data
            if (1 == $debug) {
                $data['debug']['form']['webhooks_response'] = $this->output_request($remote_url, $args);
                $data['debug']['form']['webhooks_response'] .= $this->output_response($response);
            }
        }

        return $data;
    }

    /**
     * Encode our args if necessary.
     * 
     * @param Integer $json_encode Whether or not to encode the args.
     * @param Integer $json_use_arg Whether to encode the json as a single variable.
     * @param String $json_arg The name of the single json variable, if provided.
     * @param Array $args The arguments to be encoded.
     * 
     * @return Mixed Array || String
     */
    protected function maybe_encode($json_encode, $json_use_arg, $json_arg, $args)
    {
        if (1 != $json_encode) {
            return $args;
        }
        if (1 == $json_use_arg) {
            // Set a default $json_arg if none was provided.
            if (empty($json_arg)) {
                $json_arg = 'json';
            }
            $args = array($json_arg => json_encode($args));
        } else {
            $args = json_encode($args);
        }
        return $args;
    }

    /**
     * Construct the visual representation of the webhook request for output.
     * 
     * @param String $remote_url The requested URL.
     * @param Array $args The arguments sent with the request.
     * 
     * @return String
     */
    protected function output_request($remote_url, $args = array())
    {
        $message = "<dl>";
        $message .= "<dt><strong>Remote URL: </strong></dt>" . "<dd>" . $remote_url . "</dd>";
        // TODO: If $args is json encoded, this never fires.
        if (! empty($args) && is_array($args)) {
            $message .= "<dt><strong>Args: </strong></dt>";

            if (is_array($args)) {
                foreach ($args as $key => $value) {
                    $message .= "<dd>" . $key . ' => ' . $value . "</dd>";
                }
            } else {
                $message .= "<dd>" . $args . "</dd>";
            }
        }
        return $message;
    }

    /**
     * Construct the visual representation of the webhook response for output.
     * 
     * @param Mixed $response The response from the webhook request.
     *                        WP_Error || Array
     * 
     * @return String
     */
    protected function output_response($response)
    {
        if (is_wp_error($response)) {
            $message = $response->get_error_message();
        } else {
            $message = "<dt><strong>Response: </strong></dt>";
            foreach ($response['headers'] as $key => $value) {
                $message .= "<dd>" . $key . ' => ' . $value . "</dd>";
            }
            $message .= "<strong>Body: </strong>" . "<dd>" . $response['body'] . "</dd>";
            $message .= "<dt><strong>Response Code: </strong></dt>";
            foreach ($response['response'] as $key => $value) {
                $message .= "<dd>" . $key . ' => ' . $value . "</dd>";
            }
            $message .= "</dl>";
        }
        return $message;
    }

    /**
     * Update remote URL for GET request.
     * 
     * @param String $remote_url The target URL for the request.
     * @param Mixed $args The arguments to be appended to the request.
     *                    Array || String
     * @param Integer $form_id The ID of the current form.
     * 
     * @return String
     */
    protected function append_args($remote_url, $args, $form_id)
    {
        $args = apply_filters('nf_remote_get_args', $args, $form_id);
        if (is_array($args)) {
            $args = http_build_query($args);
        }
        if (strpos($remote_url, '?') === false) {
            $remote_url .= '?';
        } else {
            if (substr($remote_url, -1) !== '?') {
                $remote_url .= '&';
            }
        }
        $remote_url = apply_filters('nf_remote_get_url', $remote_url . $args, $form_id);
        return $remote_url;
    }

    /**
     * Construct the POST request body.
     * 
     * @param Mixed $args The arguments to be used in the POST request.
     *                    Array || String
     * 
     * @return Array
     */
    protected function construct_body($args)
    {
        return apply_filters('nf_remote_post_args', array('body' => $args));
    }

    /**
     * Construct the POST request headers.
     * 
     * @param Array $headers The headers for the POST request.
     * @param Integer $json_encode Whether or not this is a JSON encoded request.
     * @param Integer $json_use_arg Whether JSON encoded args are a single variable.
     * 
     * @return Array
     */
    protected function construct_headers($headers, $json_encode, $json_use_arg)
    {
        // If this is a fully JSON encoded request body, set the content-type to JSON.
        if (1 == $json_encode && 1 != $json_use_arg) {
            $headers['content-type'] = 'application/json';
        }
        return apply_filters('nf_remote_post_headers', array('headers' => $headers));
    }
}
