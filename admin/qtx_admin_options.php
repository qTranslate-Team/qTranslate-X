<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once( QTRANSLATE_DIR . '/admin/qtx_admin_utils.php' );

/**
 * @param $ops
 */
function qtranxf_admin_set_default_options( &$ops ) {
	//options processed in a standardized way
	$ops['admin'] = [];

	$ops['admin']['int'] = [
		'editor_mode'    => QTX_EDITOR_MODE_LSB,
		'highlight_mode' => QTX_HIGHLIGHT_MODE_BORDER_LEFT,
	];

	$ops['admin']['bool'] = [
		'auto_update_mo' => true,// automatically update .mo files
	];

	//single line options
	$ops['admin']['str'] = [
		'lsb_style'              => 'Simple_Buttons.css',
		'lsb_style_wrap_class'   => 'qtranxf_default_lsb_style_wrap_class',
		'lsb_style_active_class' => 'qtranxf_default_lsb_style_active_class',
	];

	//multi-line options
	$ops['admin']['text'] = [
		'highlight_mode_custom_css' => null, // qtranxf_get_admin_highlight_css
	];

	$ops['admin']['array'] = [
		'config_files'         => [ './i18n-config.json' ],
		'admin_config'         => [],
		'custom_i18n_config'   => [],
		'custom_fields'        => [],
		'custom_field_classes' => [],
		//'custom_pages' => array(),
		'post_type_excluded'   => [],
	];

	//options processed in a special way

	/**
	 * A chance to add additional options
	 */
	$ops = apply_filters( 'qtranslate_option_config_admin', $ops );
}

/**
 * Load enabled languages properties from  database
 *
 * @since 3.3
 */
function qtranxf_default_lsb_style_wrap_class() {
	global $q_config;
	switch ( $q_config['lsb_style'] ) {
		case 'Tabs_in_Block.css':
			return 'qtranxs-lang-switch-wrap wp-ui-primary';
		default:
			return 'qtranxs-lang-switch-wrap';
	}
}

/**
 * Load enabled languages properties from  database
 *
 * @since 3.3
 */
function qtranxf_default_lsb_style_active_class() {
	global $q_config;
	switch ( $q_config['lsb_style'] ) {
		case 'Tabs_in_Block.css':
			return 'wp-ui-highlight';
		default:
			return 'active';
	}
}

function qtranxf_admin_loadConfig() {
	global $q_config, $qtranslate_options;
	qtranxf_admin_set_default_options( $qtranslate_options );

	foreach ( $qtranslate_options['admin']['int'] as $nm => $def ) {
		qtranxf_load_option( $nm, $def );
	}

	foreach ( $qtranslate_options['admin']['bool'] as $nm => $def ) {
		qtranxf_load_option_bool( $nm, $def );
	}

	foreach ( $qtranslate_options['admin']['str'] as $nm => $def ) {
		qtranxf_load_option( $nm, $def );
	}

	foreach ( $qtranslate_options['admin']['text'] as $nm => $def ) {
		qtranxf_load_option( $nm, $def );
	}

	foreach ( $qtranslate_options['admin']['array'] as $nm => $def ) {
		qtranxf_load_option_array( $nm, $def );
	}

	if ( empty( $q_config['admin_config'] ) ) {
		require_once( QTRANSLATE_DIR . '/admin/qtx_admin_options_update.php' );
		qtranxf_update_i18n_config();
	}

	/**
	 * Opportunity to load additional admin features.
	 */
	do_action( 'qtranslate_admin_loadConfig' );

	qtranxf_add_conf_filters();
}
