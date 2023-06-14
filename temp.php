<?php

public function __construct() {
	add_action( 'admin_init', array( $this, 'send_plugin_update_info' ) );
}

public function send_plugin_update_info() {
	$plugins = get_site_transient( 'update_plugins' );
	$all_plugins_info = array();
	if ( ! empty( $plugins->response) ) {
		foreach ( $plugins->response as $key => $item ) {
			$all_plugins_info[] = $this->get_plugin_info( $key );
		}
	}
}

public function get_plugin_info( $plugin ) {
	return array_merge(
		array( 'Plugin' => $plugin ),
		get_file_data(
			ABSPATH . 'wp-content/plugins/' . $plugin,
			array(
				'Name'    => 'Plugin Name',
				'Version' => 'Version'
			),
			'plugin'
		)
	);
}
