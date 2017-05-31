<?php
/**
 * Setup and Process submit and search forms
 * @package CAMPUS_DIRECTORY
 * @since WPAS 4.0
 */
if (!defined('ABSPATH')) exit;
if (is_admin()) {
	add_action('wp_ajax_campus_directory_submit_ajax_form', 'campus_directory_submit_ajax_form');
	add_action('wp_ajax_nopriv_campus_directory_submit_ajax_form', 'campus_directory_submit_ajax_form');
	add_action('wp_ajax_nopriv_emd_check_unique', 'emd_check_unique');
	add_action('wp_ajax_emd_get_pagenum', 'emd_get_pagenum');
	add_action('wp_ajax_nopriv_emd_get_pagenum', 'emd_get_pagenum');
}
/**
 * Process ajax submit form
 * @since WPAS 4.0
 */
function campus_directory_submit_ajax_form() {
	$form_name = isset($_POST['form_name']) ? sanitize_text_field($_POST['form_name']) : '';
	$vals = isset($_POST['vals']) ? $_POST['vals'] : '';
	if (!empty($vals)) {
		parse_str(stripslashes($vals) , $post_array);
		foreach ($post_array as $pkey => $mypost) {
			$_POST[$pkey] = $mypost;
		}
	}
	$form_init_variables = get_option('campus_directory_glob_forms_init_list');
	$form_variables = get_option('campus_directory_glob_forms_list');
	switch ($form_name) {
		case 'people_search':
			$noresult_msg = (isset($form_variables['people_search']['noresult_msg']) ? $form_variables['people_search']['noresult_msg'] : $form_init_variables['people_search']['noresult_msg']);
			emd_search_ajax_form('people_search', 'campus_directory', 'emd_person', $noresult_msg, 'search_people');
		break;
	}
}
add_action('init', 'campus_directory_form_shortcodes', -2);
/**
 * Start session and setup upload idr and current user id
 * @since WPAS 4.0
 *
 */
function campus_directory_form_shortcodes() {
	global $file_upload_dir;
	$upload_dir = wp_upload_dir();
	$file_upload_dir = $upload_dir['basedir'];
	if (!empty($_POST['emd_action'])) {
		if ($_POST['emd_action'] == 'campus_directory_user_login' && wp_verify_nonce($_POST['emd_login_nonce'], 'emd-login-nonce')) {
			emd_process_login($_POST, 'campus_directory');
		} elseif ($_POST['emd_action'] == 'campus_directory_user_register' && wp_verify_nonce($_POST['emd_register_nonce'], 'emd-register-nonce')) {
			emd_process_register($_POST, 'campus_directory');
		}
	}
}
add_shortcode('people_search', 'campus_directory_process_people_search');
/**
 * Set each form field(attr,tax and rels) and render form
 *
 * @since WPAS 4.0
 *
 * @return object $form
 */
function campus_directory_set_people_search($atts) {
	global $file_upload_dir;
	$show_captcha = 0;
	$form_variables = get_option('campus_directory_glob_forms_list');
	$form_init_variables = get_option('campus_directory_glob_forms_init_list');
	if (!empty($atts['set'])) {
		$set_arrs = emd_parse_set_filter($atts['set']);
	}
	if (!empty($form_variables['people_search']['captcha'])) {
		switch ($form_variables['people_search']['captcha']) {
			case 'never-show':
				$show_captcha = 0;
			break;
			case 'show-always':
				$show_captcha = 1;
			break;
			case 'show-to-visitors':
				if (is_user_logged_in()) {
					$show_captcha = 0;
				} else {
					$show_captcha = 1;
				}
			break;
		}
	}
	$req_hide_vars = emd_get_form_req_hide_vars('campus_directory', 'people_search');
	$form = new Zebra_Form('people_search', 2, 'POST', '', array(
		'class' => 'form-container wpas-form wpas-form-stacked',
		'session_obj' => CAMPUS_DIRECTORY()->session
	));
	$csrf_storage_method = (isset($form_variables['people_search']['csrf']) ? $form_variables['people_search']['csrf'] : $form_init_variables['people_search']['csrf']);
	if ($csrf_storage_method == 0) {
		$form->form_properties['csrf_storage_method'] = false;
	}
	if (!in_array('emd_person_fname', $req_hide_vars['hide'])) {
		//text
		$form->add('label', 'label_emd_person_fname', 'emd_person_fname', __('First Name', 'campus-directory') , array(
			'class' => 'control-label'
		));
		$attrs = array(
			'class' => 'input-md form-control',
			'placeholder' => __('First Name', 'campus-directory')
		);
		if (!empty($_GET['emd_person_fname'])) {
			$attrs['value'] = sanitize_text_field($_GET['emd_person_fname']);
		} elseif (!empty($set_arrs['attr']['emd_person_fname'])) {
			$attrs['value'] = $set_arrs['attr']['emd_person_fname'];
		}
		$obj = $form->add('text', 'emd_person_fname', '', $attrs);
		$zrule = Array(
			'dependencies' => array() ,
		);
		if (in_array('emd_person_fname', $req_hide_vars['req'])) {
			$zrule = array_merge($zrule, Array(
				'required' => array(
					'error',
					__('First Name is required', 'campus-directory')
				)
			));
		}
		$obj->set_rule($zrule);
	}
	if (!in_array('emd_person_lname', $req_hide_vars['hide'])) {
		//text
		$form->add('label', 'label_emd_person_lname', 'emd_person_lname', __('Last Name', 'campus-directory') , array(
			'class' => 'control-label'
		));
		$attrs = array(
			'class' => 'input-md form-control',
			'placeholder' => __('Last Name', 'campus-directory')
		);
		if (!empty($_GET['emd_person_lname'])) {
			$attrs['value'] = sanitize_text_field($_GET['emd_person_lname']);
		} elseif (!empty($set_arrs['attr']['emd_person_lname'])) {
			$attrs['value'] = $set_arrs['attr']['emd_person_lname'];
		}
		$obj = $form->add('text', 'emd_person_lname', '', $attrs);
		$zrule = Array(
			'dependencies' => array() ,
		);
		if (in_array('emd_person_lname', $req_hide_vars['req'])) {
			$zrule = array_merge($zrule, Array(
				'required' => array(
					'error',
					__('Last Name is required', 'campus-directory')
				)
			));
		}
		$obj->set_rule($zrule);
	}
	if (!in_array('emd_person_type', $req_hide_vars['hide'])) {
		//selectadv
		$form->add('label', 'label_emd_person_type', 'emd_person_type', __('Person Type', 'campus-directory') , array(
			'class' => 'control-label'
		));
		$attrs = array(
			'multiple' => 'multiple',
			'class' => 'input-md'
		);
		if (!empty($_GET['emd_person_type'])) {
			$attrs['value'] = sanitize_text_field($_GET['emd_person_type']);
		} elseif (!empty($set_arrs['attr']['emd_person_type'])) {
			$attrs['value'] = $set_arrs['attr']['emd_person_type'];
		}
		$obj = $form->add('selectadv', 'emd_person_type[]', '', $attrs, '', '{"allowClear":true,"placeholder":" ' . __('Please Select', 'campus-directory') . ' ","placeholderOption":"first"}');
		$obj->add_options(array(
			'faculty' => __('Faculty', 'campus-directory') ,
			'graduate-student' => __('Graduate Student', 'campus-directory') ,
			'staff' => __('Staff', 'campus-directory') ,
			'undergraduate-student' => __('Undergraduate Student', 'campus-directory')
		));
		$zrule = Array(
			'dependencies' => array() ,
		);
		if (in_array('emd_person_type', $req_hide_vars['req'])) {
			$zrule = array_merge($zrule, Array(
				'required' => array(
					'error',
					__('Person Type is required', 'campus-directory')
				)
			));
		}
		$obj->set_rule($zrule);
	}
	if (!in_array('emd_person_office', $req_hide_vars['hide'])) {
		//text
		$form->add('label', 'label_emd_person_office', 'emd_person_office', __('Office', 'campus-directory') , array(
			'class' => 'control-label'
		));
		$attrs = array(
			'class' => 'input-md form-control',
			'placeholder' => __('Office', 'campus-directory')
		);
		if (!empty($_GET['emd_person_office'])) {
			$attrs['value'] = sanitize_text_field($_GET['emd_person_office']);
		} elseif (!empty($set_arrs['attr']['emd_person_office'])) {
			$attrs['value'] = $set_arrs['attr']['emd_person_office'];
		}
		$obj = $form->add('text', 'emd_person_office', '', $attrs);
		$zrule = Array(
			'dependencies' => array() ,
		);
		if (in_array('emd_person_office', $req_hide_vars['req'])) {
			$zrule = array_merge($zrule, Array(
				'required' => array(
					'error',
					__('Office is required', 'campus-directory')
				)
			));
		}
		$obj->set_rule($zrule);
	}
	if (!in_array('emd_person_email', $req_hide_vars['hide'])) {
		//text
		$form->add('label', 'label_emd_person_email', 'emd_person_email', __('Email', 'campus-directory') , array(
			'class' => 'control-label'
		));
		$attrs = array(
			'class' => 'input-md form-control',
			'placeholder' => __('Email', 'campus-directory')
		);
		if (!empty($_GET['emd_person_email'])) {
			$attrs['value'] = sanitize_email($_GET['emd_person_email']);
		} elseif (!empty($set_arrs['attr']['emd_person_email'])) {
			$attrs['value'] = $set_arrs['attr']['emd_person_email'];
		}
		$obj = $form->add('text', 'emd_person_email', '', $attrs);
		$zrule = Array(
			'dependencies' => array() ,
			'email' => array(
				'error',
				__('Email: Please enter a valid email address', 'campus-directory')
			) ,
		);
		if (in_array('emd_person_email', $req_hide_vars['req'])) {
			$zrule = array_merge($zrule, Array(
				'required' => array(
					'error',
					__('Email is required', 'campus-directory')
				)
			));
		}
		$obj->set_rule($zrule);
	}
	if (!in_array('person_area', $req_hide_vars['hide'])) {
		$form->add('label', 'label_person_area', 'person_area', __('Academic Area', 'campus-directory') , array(
			'class' => 'control-label'
		));
		$attrs = array(
			'multiple' => 'multiple',
			'class' => 'input-md'
		);
		if (!empty($_GET['person_area'])) {
			$attrs['value'] = sanitize_text_field($_GET['person_area']);
		} elseif (!empty($set_arrs['tax']['person_area'])) {
			$attrs['value'] = $set_arrs['tax']['person_area'];
		}
		$obj = $form->add('selectadv', 'person_area[]', '', $attrs, '', '{"allowClear":true,"placeholder":"' . __("Please Select", "campus-directory") . '","placeholderOption":"first"}');
		//get taxonomy values
		$txn_arr = Array();
		$txn_obj = get_terms('person_area', array(
			'hide_empty' => 0
		));
		foreach ($txn_obj as $txn) {
			$txn_arr[$txn->slug] = $txn->name;
		}
		$obj->add_options($txn_arr);
		$zrule = Array(
			'dependencies' => array() ,
		);
		if (in_array('person_area', $req_hide_vars['req'])) {
			$zrule = array_merge($zrule, Array(
				'required' => array(
					'error',
					__('Academic Area is required!', 'campus-directory')
				)
			));
		}
		$obj->set_rule($zrule);
	}
	if (!in_array('person_rareas', $req_hide_vars['hide'])) {
		$form->add('label', 'label_person_rareas', 'person_rareas', __('Research Area', 'campus-directory') , array(
			'class' => 'control-label'
		));
		$attrs = array(
			'multiple' => 'multiple',
			'class' => 'input-md'
		);
		if (!empty($_GET['person_rareas'])) {
			$attrs['value'] = sanitize_text_field($_GET['person_rareas']);
		} elseif (!empty($set_arrs['tax']['person_rareas'])) {
			$attrs['value'] = $set_arrs['tax']['person_rareas'];
		}
		$obj = $form->add('selectadv', 'person_rareas[]', '', $attrs, '', '{"allowClear":true,"placeholder":"' . __("Please Select", "campus-directory") . '","placeholderOption":"first"}');
		//get taxonomy values
		$txn_arr = Array();
		$txn_obj = get_terms('person_rareas', array(
			'hide_empty' => 0
		));
		foreach ($txn_obj as $txn) {
			$txn_arr[$txn->slug] = $txn->name;
		}
		$obj->add_options($txn_arr);
		$zrule = Array(
			'dependencies' => array() ,
		);
		if (in_array('person_rareas', $req_hide_vars['req'])) {
			$zrule = array_merge($zrule, Array(
				'required' => array(
					'error',
					__('Research Area is required!', 'campus-directory')
				)
			));
		}
		$obj->set_rule($zrule);
	}
	if (!in_array('directory_tag', $req_hide_vars['hide'])) {
		$form->add('label', 'label_directory_tag', 'directory_tag', __('Directory Tag', 'campus-directory') , array(
			'class' => 'control-label'
		));
		$attrs = array(
			'multiple' => 'multiple',
			'class' => 'input-md'
		);
		if (!empty($_GET['directory_tag'])) {
			$attrs['value'] = sanitize_text_field($_GET['directory_tag']);
		} elseif (!empty($set_arrs['tax']['directory_tag'])) {
			$attrs['value'] = $set_arrs['tax']['directory_tag'];
		}
		$obj = $form->add('selectadv', 'directory_tag[]', '', $attrs, '', '{"allowClear":true,"placeholder":"' . __("Please Select", "campus-directory") . '","placeholderOption":"first"}');
		//get taxonomy values
		$txn_arr = Array();
		$txn_obj = get_terms('directory_tag', array(
			'hide_empty' => 0
		));
		foreach ($txn_obj as $txn) {
			$txn_arr[$txn->slug] = $txn->name;
		}
		$obj->add_options($txn_arr);
		$zrule = Array(
			'dependencies' => array() ,
		);
		if (in_array('directory_tag', $req_hide_vars['req'])) {
			$zrule = array_merge($zrule, Array(
				'required' => array(
					'error',
					__('Directory Tag is required!', 'campus-directory')
				)
			));
		}
		$obj->set_rule($zrule);
	}
	$cust_fields = Array();
	$cust_fields = apply_filters('emd_get_cust_fields', $cust_fields, 'emd_person');
	foreach ($cust_fields as $ckey => $clabel) {
		if (!in_array($ckey, $req_hide_vars['hide'])) {
			$form->add('label', 'label_' . $ckey, $ckey, $clabel, array(
				'class' => 'control-label'
			));
			$obj = $form->add('text', $ckey, '', array(
				'class' => 'input-md form-control',
				'placeholder' => $clabel
			));
			if (in_array($ckey, $req_hide_vars['req'])) {
				$zrule = Array(
					'required' => array(
						'error',
						$clabel . __(' is required', 'campus-directory')
					)
				);
				$obj->set_rule($zrule);
			}
		}
	}
	$form->assign('show_captcha', $show_captcha);
	if ($show_captcha == 1) {
		//Captcha
		$form->add('captcha', 'captcha_image', 'captcha_code', '', '<span style="font-weight:bold;" class="refresh-txt">Refresh</span>', 'refcapt');
		$form->add('label', 'label_captcha_code', 'captcha_code', __('Please enter the characters with black color.', 'campus-directory'));
		$obj = $form->add('text', 'captcha_code', '', array(
			'placeholder' => __('Code', 'campus-directory')
		));
		$obj->set_rule(array(
			'required' => array(
				'error',
				__('Captcha is required', 'campus-directory')
			) ,
			'captcha' => array(
				'error',
				__('Characters from captcha image entered incorrectly!', 'campus-directory')
			)
		));
	}
	$form->add('submit', 'singlebutton_people_search', '' . __('Search', 'campus-directory') . ' ', array(
		'class' => 'wpas-button wpas-juibutton-primary wpas-button-large  col-md-12 col-lg-12 col-xs-12 col-sm-12'
	));
	return $form;
}
/**
 * Process each form and show error or success
 *
 * @since WPAS 4.0
 *
 * @return html
 */
function campus_directory_process_people_search($atts) {
	$show_form = 1;
	$access_views = get_option('campus_directory_access_views', Array());
	if (!current_user_can('view_people_search') && !empty($access_views['forms']) && in_array('people_search', $access_views['forms'])) {
		$show_form = 0;
	}
	$form_init_variables = get_option('campus_directory_glob_forms_init_list');
	$form_variables = get_option('campus_directory_glob_forms_list');
	if ($show_form == 1) {
		if (!empty($form_init_variables['people_search']['login_reg'])) {
			$show_login_register = (isset($form_variables['people_search']['login_reg']) ? $form_variables['people_search']['login_reg'] : $form_init_variables['people_search']['login_reg']);
			if (!is_user_logged_in() && $show_login_register != 'none') {
				do_action('emd_show_login_register_forms', 'campus_directory', 'people_search', $show_login_register);
				return;
			}
		}
		wp_enqueue_script('wpas-jvalidate-js');
		wp_enqueue_style('wpasui');
		wp_enqueue_style('people-search-forms');
		wp_enqueue_script('people-search-forms-js');
		wp_enqueue_style('view-search-people-cdn');
		wp_enqueue_style('campus-directory-allview-css');
		campus_directory_enq_custom_css();
		do_action('emd_ext_form_enq', 'campus_directory', 'people_search');
		$noresult_msg = (isset($form_variables['people_search']['noresult_msg']) ? $form_variables['people_search']['noresult_msg'] : $form_init_variables['people_search']['noresult_msg']);
		return emd_search_php_form('people_search', 'campus_directory', 'emd_person', $noresult_msg, 'search_people', $atts);
	} else {
		$noaccess_msg = (isset($form_variables['people_search']['noaccess_msg']) ? $form_variables['people_search']['noaccess_msg'] : $form_init_variables['people_search']['noaccess_msg']);
		return "<div class='alert alert-info not-authorized'>" . $noaccess_msg . "</div>";
	}
}
