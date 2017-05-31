<?php
/**
 * Install and Deactivate Plugin Functions
 * @package CAMPUS_DIRECTORY
 * @since WPAS 4.0
 */
if (!defined('ABSPATH')) exit;
if (!class_exists('Campus_Directory_Install_Deactivate')):
	/**
	 * Campus_Directory_Install_Deactivate Class
	 * @since WPAS 4.0
	 */
	class Campus_Directory_Install_Deactivate {
		private $option_name;
		/**
		 * Hooks for install and deactivation and create options
		 * @since WPAS 4.0
		 */
		public function __construct() {
			$this->option_name = 'campus_directory';
			add_action('init', array(
				$this,
				'check_update'
			));
			register_activation_hook(CAMPUS_DIRECTORY_PLUGIN_FILE, array(
				$this,
				'install'
			));
			register_deactivation_hook(CAMPUS_DIRECTORY_PLUGIN_FILE, array(
				$this,
				'deactivate'
			));
			add_action('wp_head', array(
				$this,
				'version_in_header'
			));
			add_action('admin_init', array(
				$this,
				'setup_pages'
			));
			add_action('admin_notices', array(
				$this,
				'install_notice'
			));
			add_action('generate_rewrite_rules', 'emd_create_rewrite_rules');
			add_filter('query_vars', 'emd_query_vars');
			add_action('admin_init', array(
				$this,
				'register_settings'
			) , 0);
			add_action('before_delete_post', array(
				$this,
				'delete_post_file_att'
			));
			add_filter('tiny_mce_before_init', array(
				$this,
				'tinymce_fix'
			));
			add_action('init', array(
				$this,
				'init_extensions'
			) , 99);
			do_action('emd_ext_actions', $this->option_name);
		}
		public function check_update() {
			$curr_version = get_option($this->option_name . '_version', 1);
			$new_version = constant(strtoupper($this->option_name) . '_VERSION');
			if (version_compare($curr_version, $new_version, '<')) {
				P2P_Storage::install();
				$this->set_options();
				$this->set_roles_caps();
				if (!get_option($this->option_name . '_activation_date')) {
					$triggerdate = mktime(0, 0, 0, date('m') , date('d') + 7, date('Y'));
					add_option($this->option_name . '_activation_date', $triggerdate);
				}
				set_transient($this->option_name . '_activate_redirect', true, 30);
				do_action($this->option_name . '_upgrade', $new_version);
				update_option($this->option_name . '_version', $new_version);
			}
		}
		public function version_in_header() {
			$version = constant(strtoupper($this->option_name) . '_VERSION');
			$name = constant(strtoupper($this->option_name) . '_NAME');
			echo '<meta name="generator" content="' . $name . ' v' . $version . ' - https://emdplugins.com" />' . "\n";
		}
		public function init_extensions() {
			do_action('emd_ext_init', $this->option_name);
		}
		/**
		 * Runs on plugin install to setup custom post types and taxonomies
		 * flushing rewrite rules, populates settings and options
		 * creates roles and assign capabilities
		 * @since WPAS 4.0
		 *
		 */
		public function install() {
			P2P_Storage::install();
			$this->set_options();
			Emd_Person::register();
			flush_rewrite_rules();
			$this->set_roles_caps();
			set_transient($this->option_name . '_activate_redirect', true, 30);
			do_action('emd_ext_install_hook', $this->option_name);
		}
		/**
		 * Runs on plugin deactivate to remove options, caps and roles
		 * flushing rewrite rules
		 * @since WPAS 4.0
		 *
		 */
		public function deactivate() {
			flush_rewrite_rules();
			$this->remove_caps_roles();
			$this->reset_options();
			do_action('emd_ext_deactivate', $this->option_name);
		}
		/**
		 * Register notification and/or license settings
		 * @since WPAS 4.0
		 *
		 */
		public function register_settings() {
			do_action('emd_ext_register', $this->option_name);
			if (!get_transient($this->option_name . '_activate_redirect')) {
				return;
			}
			// Delete the redirect transient.
			delete_transient($this->option_name . '_activate_redirect');
			$query_args = array(
				'page' => $this->option_name
			);
			wp_safe_redirect(add_query_arg($query_args, admin_url('admin.php')));
		}
		/**
		 * Sets caps and roles
		 *
		 * @since WPAS 4.0
		 *
		 */
		public function set_roles_caps() {
			global $wp_roles;
			if (class_exists('WP_Roles')) {
				if (!isset($wp_roles)) {
					$wp_roles = new WP_Roles();
				}
			}
			if (is_object($wp_roles)) {
				$this->set_reset_caps($wp_roles, 'add');
			}
		}
		/**
		 * Removes caps and roles
		 *
		 * @since WPAS 4.0
		 *
		 */
		public function remove_caps_roles() {
			global $wp_roles;
			if (class_exists('WP_Roles')) {
				if (!isset($wp_roles)) {
					$wp_roles = new WP_Roles();
				}
			}
			if (is_object($wp_roles)) {
				$this->set_reset_caps($wp_roles, 'remove');
			}
		}
		/**
		 * Set  capabilities
		 *
		 * @since WPAS 4.0
		 * @param object $wp_roles
		 * @param string $type
		 *
		 */
		public function set_reset_caps($wp_roles, $type) {
			$caps['enable'] = Array(
				'delete_person_area' => Array(
					'administrator'
				) ,
				'manage_operations_emd_persons' => Array(
					'administrator'
				) ,
				'assign_person_area' => Array(
					'administrator'
				) ,
				'edit_person_title' => Array(
					'administrator'
				) ,
				'delete_person_location' => Array(
					'administrator'
				) ,
				'view_campus_directory_dashboard' => Array(
					'administrator'
				) ,
				'manage_person_area' => Array(
					'administrator'
				) ,
				'manage_person_location' => Array(
					'administrator'
				) ,
				'manage_person_rareas' => Array(
					'administrator'
				) ,
				'assign_person_title' => Array(
					'administrator'
				) ,
				'edit_person_area' => Array(
					'administrator'
				) ,
				'assign_person_location' => Array(
					'administrator'
				) ,
				'edit_person_location' => Array(
					'administrator'
				) ,
				'edit_person_rareas' => Array(
					'administrator'
				) ,
				'delete_person_title' => Array(
					'administrator'
				) ,
				'edit_emd_persons' => Array(
					'administrator'
				) ,
				'delete_person_rareas' => Array(
					'administrator'
				) ,
				'assign_person_rareas' => Array(
					'administrator'
				) ,
				'manage_person_title' => Array(
					'administrator'
				) ,
			);
			$caps['enable'] = apply_filters('emd_ext_get_caps', $caps['enable'], $this->option_name);
			foreach ($caps as $stat => $role_caps) {
				foreach ($role_caps as $mycap => $roles) {
					foreach ($roles as $myrole) {
						if (($type == 'add' && $stat == 'enable') || ($stat == 'disable' && $type == 'remove')) {
							$wp_roles->add_cap($myrole, $mycap);
						} else if (($type == 'remove' && $stat == 'enable') || ($type == 'add' && $stat == 'disable')) {
							$wp_roles->remove_cap($myrole, $mycap);
						}
					}
				}
			}
		}
		/**
		 * Set app specific options
		 *
		 * @since WPAS 4.0
		 *
		 */
		private function set_options() {
			$access_views = Array();
			update_option($this->option_name . '_setup_pages', 1);
			$ent_list = Array(
				'emd_person' => Array(
					'label' => __('People', 'campus-directory') ,
					'rewrite' => 'emd_person',
					'archive_view' => 1,
					'sortable' => 0,
					'searchable' => 1,
					'unique_keys' => Array(
						'emd_person_fname',
						'emd_person_lname'
					) ,
				) ,
			);
			update_option($this->option_name . '_ent_list', $ent_list);
			$shc_list['app'] = 'Campus Directory';
			$shc_list['has_gmap'] = 0;
			$shc_list['has_bs'] = 1;
			$shc_list['remove_vis'] = 0;
			$shc_list['forms']['people_search'] = Array(
				'name' => 'people_search',
				'type' => 'search',
				'ent' => 'emd_person',
				'page_title' => __('Search People', 'campus-directory')
			);
			$shc_list['shcs']['people_grid'] = Array(
				"class_name" => "emd_person",
				"type" => "std",
				'page_title' => __('People Grid', 'campus-directory') ,
			);
			if (!empty($shc_list)) {
				update_option($this->option_name . '_shc_list', $shc_list);
			}
			$attr_list['emd_person']['emd_person_photo'] = Array(
				'label' => __('Photo', 'campus-directory') ,
				'display_type' => 'image',
				'required' => 0,
				'srequired' => 0,
				'filterable' => 0,
				'list_visible' => 1,
				'mid' => 'emd_person_info_emd_person_0',
				'desc' => __('For best results choose a photo close to 150x150px dimensions with crop thumbnail to exact dimensions option selected in WordPress media settings', 'campus-directory') ,
				'type' => 'char',
				'max_file_uploads' => 1,
			);
			$attr_list['emd_person']['emd_person_fname'] = Array(
				'label' => __('First Name', 'campus-directory') ,
				'display_type' => 'text',
				'required' => 1,
				'srequired' => 0,
				'filterable' => 1,
				'list_visible' => 0,
				'mid' => 'emd_person_info_emd_person_0',
				'type' => 'char',
				'uniqueAttr' => true,
				'user_map' => 'user_firstname',
			);
			$attr_list['emd_person']['emd_person_lname'] = Array(
				'label' => __('Last Name', 'campus-directory') ,
				'display_type' => 'text',
				'required' => 1,
				'srequired' => 0,
				'filterable' => 1,
				'list_visible' => 0,
				'mid' => 'emd_person_info_emd_person_0',
				'type' => 'char',
				'uniqueAttr' => true,
				'user_map' => 'user_lastname',
			);
			$attr_list['emd_person']['emd_person_type'] = Array(
				'label' => __('Person Type', 'campus-directory') ,
				'display_type' => 'radio',
				'required' => 1,
				'srequired' => 0,
				'filterable' => 1,
				'list_visible' => 1,
				'mid' => 'emd_person_info_emd_person_0',
				'type' => 'char',
				'options' => array(
					'faculty' => __('Faculty', 'campus-directory') ,
					'graduate-student' => __('Graduate Student', 'campus-directory') ,
					'staff' => __('Staff', 'campus-directory') ,
					'undergraduate-student' => __('Undergraduate Student', 'campus-directory')
				) ,
			);
			$attr_list['emd_person']['emd_person_bio'] = Array(
				'label' => __('Bio', 'campus-directory') ,
				'display_type' => 'wysiwyg',
				'required' => 0,
				'srequired' => 0,
				'filterable' => 0,
				'list_visible' => 0,
				'mid' => 'emd_person_info_emd_person_0',
				'type' => 'char',
				'options' => array(
					'media_buttons' => false
				) ,
			);
			$attr_list['emd_person']['emd_person_office'] = Array(
				'label' => __('Office', 'campus-directory') ,
				'display_type' => 'text',
				'required' => 0,
				'srequired' => 0,
				'filterable' => 1,
				'list_visible' => 0,
				'mid' => 'emd_person_info_emd_person_0',
				'type' => 'char',
			);
			$attr_list['emd_person']['emd_person_address'] = Array(
				'label' => __('Address', 'campus-directory') ,
				'display_type' => 'textarea',
				'required' => 0,
				'srequired' => 0,
				'filterable' => 0,
				'list_visible' => 0,
				'mid' => 'emd_person_info_emd_person_0',
				'desc' => __('The mailing address of this person', 'campus-directory') ,
				'type' => 'char',
			);
			$attr_list['emd_person']['emd_person_email'] = Array(
				'label' => __('Email', 'campus-directory') ,
				'display_type' => 'text',
				'required' => 0,
				'srequired' => 0,
				'filterable' => 1,
				'list_visible' => 1,
				'mid' => 'emd_person_info_emd_person_0',
				'type' => 'char',
				'email' => true,
			);
			$attr_list['emd_person']['emd_person_phone'] = Array(
				'label' => __('Phone', 'campus-directory') ,
				'display_type' => 'text',
				'required' => 0,
				'srequired' => 0,
				'filterable' => 1,
				'list_visible' => 0,
				'mid' => 'emd_person_info_emd_person_0',
				'type' => 'char',
			);
			$attr_list['emd_person']['emd_person_website'] = Array(
				'label' => __('Website', 'campus-directory') ,
				'display_type' => 'text',
				'required' => 0,
				'srequired' => 0,
				'filterable' => 0,
				'list_visible' => 0,
				'mid' => 'emd_person_info_emd_person_0',
				'type' => 'char',
				'url' => true,
			);
			$attr_list['emd_person']['emd_person_pwebsite'] = Array(
				'label' => __('Personal Website', 'campus-directory') ,
				'display_type' => 'text',
				'required' => 0,
				'srequired' => 0,
				'filterable' => 0,
				'list_visible' => 0,
				'mid' => 'emd_person_info_emd_person_0',
				'type' => 'char',
				'url' => true,
			);
			$attr_list['emd_person']['emd_person_linkedin'] = Array(
				'label' => __('Linkedin', 'campus-directory') ,
				'display_type' => 'text',
				'required' => 0,
				'srequired' => 0,
				'filterable' => 0,
				'list_visible' => 0,
				'mid' => 'emd_person_info_emd_person_0',
				'type' => 'char',
				'url' => true,
			);
			$attr_list['emd_person']['emd_person_twitter'] = Array(
				'label' => __('Twitter', 'campus-directory') ,
				'display_type' => 'text',
				'required' => 0,
				'srequired' => 0,
				'filterable' => 0,
				'list_visible' => 0,
				'mid' => 'emd_person_info_emd_person_0',
				'type' => 'char',
				'url' => true,
			);
			$attr_list['emd_person']['emd_person_cv'] = Array(
				'label' => __('Curriculum Vitae', 'campus-directory') ,
				'display_type' => 'file',
				'required' => 0,
				'srequired' => 0,
				'filterable' => 0,
				'list_visible' => 0,
				'mid' => 'emd_person_info_emd_person_0',
				'type' => 'char',
				'max_file_uploads' => 1,
			);
			$attr_list['emd_person']['emd_person_education'] = Array(
				'label' => __('Education', 'campus-directory') ,
				'display_type' => 'wysiwyg',
				'required' => 0,
				'srequired' => 0,
				'filterable' => 0,
				'list_visible' => 0,
				'mid' => 'emd_person_info_emd_person_0',
				'type' => 'char',
				'options' => array(
					'media_buttons' => false
				) ,
			);
			$attr_list['emd_person']['emd_person_awards'] = Array(
				'label' => __('Awards and Honors', 'campus-directory') ,
				'display_type' => 'wysiwyg',
				'required' => 0,
				'srequired' => 0,
				'filterable' => 0,
				'list_visible' => 0,
				'mid' => 'emd_person_info_emd_person_0',
				'type' => 'char',
				'options' => array(
					'media_buttons' => false
				) ,
			);
			$attr_list['emd_person']['emd_person_appointments'] = Array(
				'label' => __('Academic Appointments', 'campus-directory') ,
				'display_type' => 'wysiwyg',
				'required' => 0,
				'srequired' => 0,
				'filterable' => 0,
				'list_visible' => 0,
				'mid' => 'emd_person_info_emd_person_0',
				'type' => 'char',
				'options' => array(
					'media_buttons' => false
				) ,
			);
			$attr_list = apply_filters('emd_ext_attr_list', $attr_list, $this->option_name);
			if (!empty($attr_list)) {
				update_option($this->option_name . '_attr_list', $attr_list);
			}
			update_option($this->option_name . '_glob_init_list', Array());
			$glob_forms_list['people_search']['captcha'] = 'never-show';
			$glob_forms_list['people_search']['noaccess_msg'] = 'You do not have access to this page';
			$glob_forms_list['people_search']['login_reg'] = 'none';
			$glob_forms_list['people_search']['noresult_msg'] = 'No results matching your search were found.';
			$glob_forms_list['people_search']['csrf'] = 0;
			$glob_forms_list['people_search']['emd_person_fname'] = Array(
				'show' => 1,
				'row' => 1,
				'req' => 0,
				'size' => 12,
			);
			$glob_forms_list['people_search']['emd_person_lname'] = Array(
				'show' => 1,
				'row' => 2,
				'req' => 0,
				'size' => 12,
			);
			$glob_forms_list['people_search']['emd_person_type'] = Array(
				'show' => 1,
				'row' => 3,
				'req' => 0,
				'size' => 12,
			);
			$glob_forms_list['people_search']['emd_person_office'] = Array(
				'show' => 1,
				'row' => 4,
				'req' => 0,
				'size' => 12,
			);
			$glob_forms_list['people_search']['emd_person_email'] = Array(
				'show' => 1,
				'row' => 5,
				'req' => 0,
				'size' => 12,
			);
			$glob_forms_list['people_search']['person_area'] = Array(
				'show' => 1,
				'row' => 6,
				'req' => 0,
				'size' => 12,
			);
			$glob_forms_list['people_search']['person_rareas'] = Array(
				'show' => 1,
				'row' => 7,
				'req' => 0,
				'size' => 12,
			);
			$glob_forms_list['people_search']['directory_tag'] = Array(
				'show' => 1,
				'row' => 8,
				'req' => 0,
				'size' => 12,
			);
			if (!empty($glob_forms_list)) {
				update_option($this->option_name . '_glob_forms_init_list', $glob_forms_list);
				if (get_option($this->option_name . '_glob_forms_list') === false) {
					update_option($this->option_name . '_glob_forms_list', $glob_forms_list);
				}
			}
			$tax_list['emd_person']['person_area'] = Array(
				'archive_view' => 1,
				'label' => __('Academic Areas', 'campus-directory') ,
				'default' => '',
				'type' => 'multi',
				'hier' => 0,
				'sortable' => 0,
				'list_visible' => 0,
				'required' => 0,
				'srequired' => 0,
				'rewrite' => 'person_area'
			);
			$tax_list['emd_person']['person_title'] = Array(
				'archive_view' => 1,
				'label' => __('Titles', 'campus-directory') ,
				'default' => '',
				'type' => 'multi',
				'hier' => 0,
				'sortable' => 0,
				'list_visible' => 0,
				'required' => 0,
				'srequired' => 0,
				'rewrite' => 'person_title'
			);
			$tax_list['emd_person']['person_rareas'] = Array(
				'archive_view' => 1,
				'label' => __('Research Areas', 'campus-directory') ,
				'default' => '',
				'type' => 'multi',
				'hier' => 0,
				'sortable' => 0,
				'list_visible' => 0,
				'required' => 0,
				'srequired' => 0,
				'rewrite' => 'person_rareas'
			);
			$tax_list['emd_person']['person_location'] = Array(
				'archive_view' => 1,
				'label' => __('Locations', 'campus-directory') ,
				'default' => '',
				'type' => 'multi',
				'hier' => 0,
				'sortable' => 0,
				'list_visible' => 0,
				'required' => 0,
				'srequired' => 0,
				'rewrite' => 'person_location'
			);
			$tax_list['emd_person']['directory_tag'] = Array(
				'archive_view' => 1,
				'label' => __('Directory Tags', 'campus-directory') ,
				'default' => '',
				'type' => 'multi',
				'hier' => 0,
				'sortable' => 0,
				'list_visible' => 0,
				'required' => 0,
				'srequired' => 0,
				'rewrite' => 'directory_tag'
			);
			if (!empty($tax_list)) {
				update_option($this->option_name . '_tax_list', $tax_list);
			}
			$rel_list['rel_supervisor'] = Array(
				'from' => 'emd_person',
				'to' => 'emd_person',
				'type' => 'many-to-many',
				'from_title' => __('Advisees', 'campus-directory') ,
				'to_title' => __('Advisor', 'campus-directory') ,
				'required' => 0,
				'srequired' => 0,
				'show' => 'to',
				'filter' => ''
			);
			$rel_list['rel_support_staff'] = Array(
				'from' => 'emd_person',
				'to' => 'emd_person',
				'type' => 'many-to-many',
				'from_title' => __('Support Staff', 'campus-directory') ,
				'to_title' => __('Supported Faculty', 'campus-directory') ,
				'required' => 0,
				'srequired' => 0,
				'show' => 'from',
				'filter' => ''
			);
			if (!empty($rel_list)) {
				update_option($this->option_name . '_rel_list', $rel_list);
			}
			$emd_activated_plugins = get_option('emd_activated_plugins');
			if (!$emd_activated_plugins) {
				update_option('emd_activated_plugins', Array(
					'campus-directory'
				));
			} elseif (!in_array('campus-directory', $emd_activated_plugins)) {
				array_push($emd_activated_plugins, 'campus-directory');
				update_option('emd_activated_plugins', $emd_activated_plugins);
			}
			//conf parameters for incoming email
			//conf parameters for inline entity
			//conf parameters for calendar
			//conf parameters for ldap
			$has_ldap = Array(
				'person_ldap' => 'emd_person'
			);
			update_option($this->option_name . '_has_ldap', $has_ldap);
			//action to configure different extension conf parameters for this plugin
			do_action('emd_ext_set_conf', 'campus-directory');
		}
		/**
		 * Reset app specific options
		 *
		 * @since WPAS 4.0
		 *
		 */
		private function reset_options() {
			delete_option($this->option_name . '_shc_list');
			delete_option($this->option_name . '_has_ldap');
			do_action('emd_ext_reset_conf', 'campus-directory');
		}
		/**
		 * Show admin notices
		 *
		 * @since WPAS 4.0
		 *
		 * @return html
		 */
		public function install_notice() {
			if (isset($_GET[$this->option_name . '_adm_notice1'])) {
				update_option($this->option_name . '_adm_notice1', true);
			}
			if (current_user_can('manage_options') && get_option($this->option_name . '_adm_notice1') != 1) {
?>
<div class="updated">
<?php
				printf('<p><a href="%1s" target="_blank"> %2$s </a>%3$s<a style="float:right;" href="%4$s"><span class="dashicons dashicons-dismiss" style="font-size:15px;"></span>%5$s</a></p>', 'https://docs.emdplugins.com/docs/campus-directory-community-documentation/?pk_campaign=campus-directory&pk_source=plugin&pk_medium=link&pk_content=notice', __('New To Campus Directory? Review the documentation!', 'wpas') , __('&#187;', 'wpas') , esc_url(add_query_arg($this->option_name . '_adm_notice1', true)) , __('Dismiss', 'wpas'));
?>
</div>
<?php
			}
			if (isset($_GET[$this->option_name . '_adm_notice2'])) {
				update_option($this->option_name . '_adm_notice2', true);
			}
			if (current_user_can('manage_options') && get_option($this->option_name . '_adm_notice2') != 1) {
?>
<div class="updated">
<?php
				printf('<p><a href="%1s" target="_blank"> %2$s </a>%3$s<a style="float:right;" href="%4$s"><span class="dashicons dashicons-dismiss" style="font-size:15px;"></span>%5$s</a></p>', 'https://emdplugins.com/plugin_tag/campus-directory?pk_campaign=campus-directory&pk_source=plugin&pk_medium=link&pk_content=notice', __('Upgrade to Professional Version Now!', 'wpas') , __('&#187;', 'wpas') , esc_url(add_query_arg($this->option_name . '_adm_notice2', true)) , __('Dismiss', 'wpas'));
?>
</div>
<?php
			}
			if (current_user_can('manage_options') && get_option($this->option_name . '_setup_pages') == 1) {
				echo "<div id=\"message\" class=\"updated\"><p><strong>" . __('Welcome to Campus Directory', 'campus-directory') . "</strong></p>
           <p class=\"submit\"><a href=\"" . add_query_arg('setup_campus_directory_pages', 'true', admin_url('index.php')) . "\" class=\"button-primary\">" . __('Setup Campus Directory Pages', 'campus-directory') . "</a> <a class=\"skip button-primary\" href=\"" . add_query_arg('skip_setup_campus_directory_pages', 'true', admin_url('index.php')) . "\">" . __('Skip setup', 'campus-directory') . "</a></p>
         </div>";
			}
		}
		/**
		 * Setup pages for components and redirect to dashboard
		 *
		 * @since WPAS 4.0
		 *
		 */
		public function setup_pages() {
			if (!is_admin()) {
				return;
			}
			if (!empty($_GET['setup_' . $this->option_name . '_pages'])) {
				$shc_list = get_option($this->option_name . '_shc_list');
				emd_create_install_pages($this->option_name, $shc_list);
				delete_option($this->option_name . '_setup_pages');
				wp_redirect(admin_url('admin.php?page=' . $this->option_name . '_settings&campus-directory-installed=true'));
				exit;
			}
			if (!empty($_GET['skip_setup_' . $this->option_name . '_pages'])) {
				delete_option($this->option_name . '_setup_pages');
				wp_redirect(admin_url('admin.php?page=' . $this->option_name . '_settings'));
				exit;
			}
		}
		/**
		 * Delete file attachments when a post is deleted
		 *
		 * @since WPAS 4.0
		 * @param $pid
		 *
		 * @return bool
		 */
		public function delete_post_file_att($pid) {
			$entity_fields = get_option($this->option_name . '_attr_list');
			$post_type = get_post_type($pid);
			if (!empty($entity_fields[$post_type])) {
				//Delete fields
				foreach (array_keys($entity_fields[$post_type]) as $myfield) {
					if (in_array($entity_fields[$post_type][$myfield]['display_type'], Array(
						'file',
						'image',
						'plupload_image',
						'thickbox_image'
					))) {
						$pmeta = get_post_meta($pid, $myfield);
						if (!empty($pmeta)) {
							foreach ($pmeta as $file_id) {
								wp_delete_attachment($file_id);
							}
						}
					}
				}
			}
			return true;
		}
		public function tinymce_fix($init) {
			$init['wpautop'] = false;
			return $init;
		}
	}
endif;
return new Campus_Directory_Install_Deactivate();
