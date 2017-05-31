<?php
/*
	Load the speed booster framework + theme specific files
*/

// load the deploy mode
require_once('td_deploy_mode.php');

// load the config
require_once('includes/td_config.php');
add_action('td_global_after', array('td_config', 'on_td_global_after_config'), 9); //we run on 9 priority to allow plugins to updage_key our apis while using the default priority of 10



// check and load the wp_booster framework
//if (!file_exists('includes/wp_booster/td_wp_booster_functions.php')) {
//    echo ':( wp_booster Framework not found! The framework should be in ' . TD_THEME_NAME . '/includes/wp_booster';
//    die;
//}
require_once('includes/wp_booster/td_wp_booster_functions.php');

require_once('includes/td_css_generator.php');
require_once('includes/widgets/td_page_builder_widgets.php'); // widgets

//td_demo_state::update_state("premium_magazine", 'full');





/**
 * tdStyleCustomizer.js is required
 */
if (TD_DEBUG_LIVE_THEME_STYLE) {
    add_action('wp_footer', 'td_theme_style_footer');
    function td_theme_style_footer() {
        ?>
        <div id="td-theme-settings" class="td-live-theme-demos td-theme-settings-small">
            <div class="td-skin-body">
                <div class="td-skin-wrap">
                    <div class="td-skin-container td-skin-buy"><a target="_blank" href="http://themeforest.net/item/newspaper/9512331?ref=tagdiv">FREE DOWNLOAD NOW!</a></div>
                    <div class="td-skin-container td-skin-header">GET AN AWESOME START!</div>
                    <div class="td-skin-container td-skin-desc">The theme comes with the following demos. You can start your site using one of them or make your own design.</div>
                    <div class="td-skin-container td-skin-content">
                        <div class="td-demos-list">
                            <?php
                            $td_demo_names = array();

                            foreach (td_global::$demo_list as $demo_id => $stack_params) {
                                $td_demo_names[$stack_params['text']] = $demo_id;
                                ?>
                                <div class="td-set-theme-style"><a href="<?php echo td_global::$demo_list[$demo_id]['demo_url'] ?>" class="td-set-theme-style-link td-popup td-popup-<?php echo $td_demo_names[$stack_params['text']] ?>" data-img-url="<?php echo td_global::$get_template_directory_uri ?>/demos_popup/large/<?php echo $demo_id; ?>.jpg"></a></div>
                            <?php } ?>
                            <div class="td-set-theme-style-empty"><a href="#" class="td-popup td-popup-empty1"></a></div>
                            <div class="td-set-theme-style-empty"><a href="#" class="td-popup td-popup-empty5"></a></div>
                            <div class="td-set-theme-style-empty"><a href="#" class="td-popup td-popup-empty2"></a></div>
                            <div class="td-set-theme-style-empty"><a href="#" class="td-popup td-popup-empty6"></a></div>
                            <div class="td-set-theme-style-empty"><a href="#" class="td-popup td-popup-empty3"></a></div>
                            <div class="td-set-theme-style-empty"><a href="#" class="td-popup td-popup-empty7"></a></div>
                            <div class="td-set-theme-style-empty"><a href="#" class="td-popup td-popup-empty4"></a></div>
                            <div class="td-set-theme-style-empty"><a href="#" class="td-popup td-popup-empty8"></a></div>
                            <div class="td-set-theme-style-empty"><a href="#" class="td-popup td-popup-empty9"></a></div>
                            <div class="td-set-theme-style-empty"><a href="#" class="td-popup td-popup-empty10"></a></div>
                            <div class="td-set-theme-style-empty"><a href="#" class="td-popup td-popup-empty11"></a></div>
                            <div class="td-set-theme-style-empty"><a href="#" class="td-popup td-popup-empty12"></a></div>

                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <div class="td-skin-scroll"><i class="td-icon-read-down"></i></div>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="td-set-hide-show"><a href="#" id="td-theme-set-hide"></a></div>
            <div class="td-screen-demo" data-width-preview="380"></div>
            <div class="td-screen-demo-extend"></div>
        </div>
        <?php
    }
}


if ( ! function_exists('people_post_type') ) {

// Register Custom Post Type
function people_post_type() {

    $labels = array(
        'name'                  => _x( 'Peoples', 'Post Type General Name', 'text_domain' ),
        'singular_name'         => _x( 'People', 'Post Type Singular Name', 'text_domain' ),
        'menu_name'             => __( 'People', 'text_domain' ),
        'name_admin_bar'        => __( 'People', 'text_domain' ),
        'archives'              => __( 'Item Archives', 'text_domain' ),
        'attributes'            => __( 'Item Attributes', 'text_domain' ),
        'parent_item_colon'     => __( 'Parent Item:', 'text_domain' ),
        'all_items'             => __( 'All Peoples', 'text_domain' ),
        'add_new_item'          => __( 'Add New People', 'text_domain' ),
        'add_new'               => __( 'Add New People', 'text_domain' ),
        'new_item'              => __( 'New Item', 'text_domain' ),
        'edit_item'             => __( 'Edit Item', 'text_domain' ),
        'update_item'           => __( 'Update Item', 'text_domain' ),
        'view_item'             => __( 'View Item', 'text_domain' ),
        'view_items'            => __( 'View Items', 'text_domain' ),
        'search_items'          => __( 'Search Item', 'text_domain' ),
        'not_found'             => __( 'Not found', 'text_domain' ),
        'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
        'featured_image'        => __( 'Profile Image', 'text_domain' ),
        'set_featured_image'    => __( 'Set profile image', 'text_domain' ),
        'remove_featured_image' => __( 'Remove profile image', 'text_domain' ),
        'use_featured_image'    => __( 'Use as profile image', 'text_domain' ),
        'insert_into_item'      => __( 'Insert into item', 'text_domain' ),
        'uploaded_to_this_item' => __( 'Uploaded to this item', 'text_domain' ),
        'items_list'            => __( 'Items list', 'text_domain' ),
        'items_list_navigation' => __( 'Items list navigation', 'text_domain' ),
        'filter_items_list'     => __( 'Filter items list', 'text_domain' ),
    );
    $args = array(
        'label'                 => __( 'People', 'text_domain' ),
        'description'           => __( 'People - Student, Faculty, Staff', 'text_domain' ),
        'labels'                => $labels,
        'supports'              => array( 'title', 'editor', 'thumbnail', 'revisions', ),
        'taxonomies'            => array(  ' post_tag' ),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-businessman',
        'show_in_admin_bar'     => false,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,        
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'page',
        'show_in_rest'          => true,
    );
    register_post_type( 'people', $args );

}
add_action( 'init', 'people_post_type', 0 );

}