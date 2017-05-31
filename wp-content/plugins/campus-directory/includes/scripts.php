<?php
/**
 * Enqueue Scripts Functions
 *
 * @package CAMPUS_DIRECTORY
 * @since WPAS 4.0
 */
if (!defined('ABSPATH')) exit;
add_action('admin_enqueue_scripts', 'campus_directory_load_admin_enq');
/**
 * Enqueue style and js for each admin entity pages and settings
 *
 * @since WPAS 4.0
 * @param string $hook
 *
 */
function campus_directory_load_admin_enq($hook) {
	global $typenow;
	$dir_url = CAMPUS_DIRECTORY_PLUGIN_URL;
	do_action('emd_ext_admin_enq', 'campus_directory', $hook);
	$min_trigger = get_option('campus_directory_show_rateme_plugin_min', 0);
	$tracking_optin = get_option('campus_directory_tracking_optin', 0);
	if (-1 !== intval($tracking_optin) || - 1 !== intval($min_trigger)) {
		wp_enqueue_style('emd-plugin-rateme-css', $dir_url . 'assets/css/emd-plugin-rateme.css');
		wp_enqueue_script('emd-plugin-rateme-js', $dir_url . 'assets/js/emd-plugin-rateme.js');
	}
	if ($hook == 'edit-tags.php') {
		return;
	}
	if (isset($_GET['page']) && in_array($_GET['page'], Array(
		'campus_directory_notify',
		'campus_directory_settings'
	))) {
		wp_enqueue_script('accordion');
		wp_enqueue_style('codemirror-css', $dir_url . 'assets/ext/codemirror/codemirror.css');
		wp_enqueue_script('codemirror-js', $dir_url . 'assets/ext/codemirror/codemirror.js', array() , '', true);
		wp_enqueue_script('codemirror-css-js', $dir_url . 'assets/ext/codemirror/css.js', array() , '', true);
		return;
	} else if (isset($_GET['page']) && $_GET['page'] == 'campus_directory') {
		wp_enqueue_style('lazyYT-css', $dir_url . 'assets/ext/lazyyt/lazyYT.min.css');
		wp_enqueue_script('lazyYT-js', $dir_url . 'assets/ext/lazyyt/lazyYT.min.js');
		wp_enqueue_script('getting-started-js', $dir_url . 'assets/js/getting-started.js');
		return;
	} else if (isset($_GET['page']) && in_array($_GET['page'], Array(
		'campus_directory_store',
		'campus_directory_designs',
		'campus_directory_support'
	))) {
		wp_enqueue_style('admin-tabs', $dir_url . 'assets/css/admin-store.css');
		return;
	}
	if (in_array($typenow, Array(
		'emd_person'
	))) {
		$theme_changer_enq = 1;
		$sing_enq = 0;
		$tab_enq = 0;
		if ($hook == 'post.php' || $hook == 'post-new.php') {
			$unique_vars['msg'] = __('Please enter a unique value.', 'campus-directory');
			$unique_vars['reqtxt'] = __('required', 'campus-directory');
			$unique_vars['app_name'] = 'campus_directory';
			$ent_list = get_option('campus_directory_ent_list');
			if (!empty($ent_list[$typenow])) {
				$unique_vars['keys'] = $ent_list[$typenow]['unique_keys'];
				if (!empty($ent_list[$typenow]['req_blt'])) {
					$unique_vars['req_blt_tax'] = $ent_list[$typenow]['req_blt'];
				}
			}
			$tax_list = get_option('campus_directory_tax_list');
			if (!empty($tax_list[$typenow])) {
				foreach ($tax_list[$typenow] as $txn_name => $txn_val) {
					if ($txn_val['required'] == 1) {
						$unique_vars['req_blt_tax'][$txn_name] = Array(
							'hier' => $txn_val['hier'],
							'type' => $txn_val['type'],
							'label' => $txn_val['label'] . ' ' . __('Taxonomy', 'campus-directory')
						);
					}
				}
			}
			wp_enqueue_script('unique_validate-js', $dir_url . 'assets/js/unique_validate.js', array(
				'jquery',
				'jquery-validate'
			) , CAMPUS_DIRECTORY_VERSION, true);
			wp_localize_script("unique_validate-js", 'unique_vars', $unique_vars);
		} elseif ($hook == 'edit.php') {
			wp_enqueue_style('campus-directory-allview-css', CAMPUS_DIRECTORY_PLUGIN_URL . '/assets/css/allview.css');
		}
		switch ($typenow) {
			case 'emd_person':
			break;
		}
	}
}
add_action('wp_enqueue_scripts', 'campus_directory_frontend_scripts');
/**
 * Enqueue style and js for each frontend entity pages and components
 *
 * @since WPAS 4.0
 *
 */
function campus_directory_frontend_scripts() {
	$dir_url = CAMPUS_DIRECTORY_PLUGIN_URL;
	wp_register_style('campus-directory-allview-css', $dir_url . '/assets/css/allview.css');
	$grid_vars = Array();
	$local_vars['ajax_url'] = admin_url('admin-ajax.php');
	$local_vars['validate_msg']['required'] = __('This field is required.', 'emd-plugins');
	$local_vars['validate_msg']['remote'] = __('Please fix this field.', 'emd-plugins');
	$local_vars['validate_msg']['email'] = __('Please enter a valid email address.', 'emd-plugins');
	$local_vars['validate_msg']['url'] = __('Please enter a valid URL.', 'emd-plugins');
	$local_vars['validate_msg']['date'] = __('Please enter a valid date.', 'emd-plugins');
	$local_vars['validate_msg']['dateISO'] = __('Please enter a valid date ( ISO )', 'emd-plugins');
	$local_vars['validate_msg']['number'] = __('Please enter a valid number.', 'emd-plugins');
	$local_vars['validate_msg']['digits'] = __('Please enter only digits.', 'emd-plugins');
	$local_vars['validate_msg']['creditcard'] = __('Please enter a valid credit card number.', 'emd-plugins');
	$local_vars['validate_msg']['equalTo'] = __('Please enter the same value again.', 'emd-plugins');
	$local_vars['validate_msg']['maxlength'] = __('Please enter no more than {0} characters.', 'emd-plugins');
	$local_vars['validate_msg']['minlength'] = __('Please enter at least {0} characters.', 'emd-plugins');
	$local_vars['validate_msg']['rangelength'] = __('Please enter a value between {0} and {1} characters long.', 'emd-plugins');
	$local_vars['validate_msg']['range'] = __('Please enter a value between {0} and {1}.', 'emd-plugins');
	$local_vars['validate_msg']['max'] = __('Please enter a value less than or equal to {0}.', 'emd-plugins');
	$local_vars['validate_msg']['min'] = __('Please enter a value greater than or equal to {0}.', 'emd-plugins');
	$local_vars['unique_msg'] = __('Please enter a unique value.', 'emd-plugins');
	$wpas_shc_list = get_option('campus_directory_shc_list');
	$local_vars['people_search'] = emd_get_form_req_hide_vars('campus_directory', 'people_search');
	wp_register_style('people-search-forms', $dir_url . 'assets/css/people-search-forms.css');
	wp_register_script('people-search-forms-js', $dir_url . 'assets/js/people-search-forms.js');
	wp_localize_script('people-search-forms-js', 'people_search_vars', $local_vars);
	wp_register_style('view-search-people-cdn', $dir_url . 'assets/css/view-search-people.css');
	wp_register_style('person-archive', $dir_url . 'assets/css/person-archive.css');
	wp_register_script('wpas-jvalidate-js', $dir_url . 'assets/ext/jvalidate1150/wpas.validate.min.js', array(
		'jquery'
	));
	wp_register_style('view-people-grid', $dir_url . 'assets/css/view-people-grid.css');
	wp_register_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
	wp_register_style('wpas-boot', $dir_url . 'assets/ext/wpas/wpas-bootstrap.min.css');
	wp_register_script('wpas-boot-js', $dir_url . 'assets/ext/wpas/bootstrap.min.js', array(
		'jquery'
	));
	wp_register_style('wpasui', CAMPUS_DIRECTORY_PLUGIN_URL . 'assets/ext/wpas-jui/wpas-jui.min.css');
	if (is_tax('person_title')) {
		wp_enqueue_style('dashicons');
		wp_enqueue_style('person-archive');
		wp_enqueue_style('campus-directory-allview-css');
		campus_directory_enq_custom_css();
		return;
	}
	if (is_tax('person_rareas')) {
		wp_enqueue_style('dashicons');
		wp_enqueue_style('person-archive');
		wp_enqueue_style('campus-directory-allview-css');
		campus_directory_enq_custom_css();
		return;
	}
	if (is_tax('person_location')) {
		wp_enqueue_style('dashicons');
		wp_enqueue_style('person-archive');
		wp_enqueue_style('campus-directory-allview-css');
		campus_directory_enq_custom_css();
		return;
	}
	if (is_tax('person_area')) {
		wp_enqueue_style('dashicons');
		wp_enqueue_style('person-archive');
		wp_enqueue_style('campus-directory-allview-css');
		campus_directory_enq_custom_css();
		return;
	}
	if (is_tax('directory_tag')) {
		wp_enqueue_style('dashicons');
		wp_enqueue_style('person-archive');
		wp_enqueue_style('campus-directory-allview-css');
		campus_directory_enq_custom_css();
		return;
	}
	if (is_post_type_archive('emd_person')) {
		wp_enqueue_style('dashicons');
		wp_enqueue_style('person-archive');
		wp_enqueue_style('campus-directory-allview-css');
		campus_directory_enq_custom_css();
		return;
	}
	if (is_single() && get_post_type() == 'emd_person') {
		campus_directory_enq_bootstrap();
		wp_enqueue_style('font-awesome');
		wp_enqueue_style('dashicons');
		wp_enqueue_style('campus-directory-allview-css');
		campus_directory_enq_custom_css();
		return;
	}
}
function campus_directory_enq_bootstrap($type = '') {
	$misc_settings = get_option('campus_directory_misc_settings');
	if ($type == 'css' || $type == '') {
		if (empty($misc_settings) || (isset($misc_settings['disable_bs_css']) && $misc_settings['disable_bs_css'] == 0)) {
			wp_enqueue_style('wpas-boot');
		}
	}
	if ($type == 'js' || $type == '') {
		if (empty($misc_settings) || (isset($misc_settings['disable_bs_js']) && $misc_settings['disable_bs_js'] == 0)) {
			wp_enqueue_script('wpas-boot-js');
		}
	}
}
/**
 * Enqueue custom css if set in settings tool tab
 *
 * @since WPAS 5.3
 *
 */
function campus_directory_enq_custom_css() {
	$tools = get_option('campus_directory_tools');
	if (!empty($tools['custom_css'])) {
		$url = home_url();
		if (is_ssl()) {
			$url = home_url('/', 'https');
		}
		wp_enqueue_style('campus-directory-custom', add_query_arg(array(
			'campus-directory-css' => 1
		) , $url));
	}
}
/**
 * If app custom css query var is set, print custom css
 */
function campus_directory_print_css() {
	// Only print CSS if this is a stylesheet request
	if (!isset($_GET['campus-directory-css']) || intval($_GET['campus-directory-css']) !== 1) {
		return;
	}
	ob_start();
	header('Content-type: text/css');
	$tools = get_option('campus_directory_tools');
	$raw_content = isset($tools['custom_css']) ? $tools['custom_css'] : '';
	$content = wp_kses($raw_content, array(
		'\'',
		'\"'
	));
	$content = str_replace('&gt;', '>', $content);
	echo $content; //xss okay
	die();
}
add_action('plugins_loaded', 'campus_directory_print_css');
/**
 * Enqueue if allview css is not enqueued
 *
 * @since WPAS 4.5
 *
 */
function campus_directory_enq_allview() {
	if (!wp_style_is('campus-directory-allview-css', 'enqueued')) {
		wp_enqueue_style('campus-directory-allview-css');
	}
}
