<?php

namespace Gutenkit\Admin\Api;

class ActivePluginData {
	public $request = null;

	public function __construct() {
		add_action('rest_api_init', function() {
			register_rest_route('gutenkit/v1', 'active-plugin',
				array(
					'methods'             => \WP_REST_Server::READABLE,
					'callback'            => [$this, 'action_get_active_plugin'],
					'permission_callback' => '__return_true',
				),
			);
		});
	}

	public function action_get_active_plugin($request) {
		/**
		* turn on this section when fully functional from frontend and need Nonce check Permission check 
		*/
		if (!wp_verify_nonce($request->get_header('X-WP-Nonce'), 'wp_rest')) {
			return [
				'status'  => 'fail',
				'message' => ['Nonce mismatch.'],
			];
		}

		if (!is_user_logged_in() || !current_user_can('manage_options')) {
			return [
				'status'  => 'fail',
				'message' => ['Access denied.'],
			];
		}

		$plugin_name = $request->get_param('plugin');
		
		$result_data = $this->is_plugin_active($plugin_name.'/'.$plugin_name.'.php');

		return [
			'status'  => 'success',
			'is_active' => $result_data,
			'message' => [
				'Plugin active data fetched successfully.',
			],
		];
	}

	public function is_plugin_active( $plugin ) {
		return in_array( $plugin, (array) get_option( 'active_plugins', array() ), true ) || $this->is_plugin_active_for_network( $plugin );
	}

	public function is_plugin_active_for_network( $plugin ) {
		if ( ! is_multisite() ) {
			return false;
		}
	
		$plugins = get_site_option( 'active_sitewide_plugins' );
		if ( isset( $plugins[ $plugin ] ) ) {
			return true;
		}
	
		return false;
	}
}