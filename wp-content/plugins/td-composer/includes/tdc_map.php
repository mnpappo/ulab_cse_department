<?php
/**
 * Created by ra.
 * Date: 3/31/2016
 * Internal map file
 */


// map the blocks from our themes
add_action('td_wp_booster_loaded', 'tdc_map_theme_blocks', 10002);
function tdc_map_theme_blocks() {
	foreach (td_api_block::get_all() as $block) {
		if (isset($block['map_in_visual_composer']) && $block['map_in_visual_composer'] === true) { // map only shortcodes that have to appear in the composer
			tdc_mapper::map_shortcode($block);
		}
	}

	tdc_mapper::map_block_templates(td_api_block_template::get_all());
}


/**
 * overwrites the shortcode from the theme or just loads the shortcodes that come with the plugin
 * !!! USES THEME CODE
 * @see td_global_blocks is from wp booster
 */
add_action('td_wp_booster_loaded', 'tdc_load_internal_shortcodes',  10002);
function tdc_load_internal_shortcodes() {
	td_global_blocks::add_lazy_shortcode('vc_row');
	td_global_blocks::add_lazy_shortcode('vc_column');
	td_global_blocks::add_lazy_shortcode('vc_row_inner');
	td_global_blocks::add_lazy_shortcode('vc_column_inner');

	td_global_blocks::add_lazy_shortcode('vc_column_text');
	td_global_blocks::add_lazy_shortcode('vc_raw_html');
	td_global_blocks::add_lazy_shortcode('vc_empty_space');
	td_global_blocks::add_lazy_shortcode('vc_widget_sidebar');
	td_global_blocks::add_lazy_shortcode('vc_single_image');
	td_global_blocks::add_lazy_shortcode('vc_separator');
	td_global_blocks::add_lazy_shortcode('vc_wp_recentcomments');
}



tdc_mapper::map_shortcode(array(
	'base' => 'vc_row',
	'name' => __('Row' , 'td_composer'),
	'is_container' => true,
	'icon' => 'tdc-icon-row',
	'category' => __('Content', 'td_composer'),
	'description' => __('Row description', 'td_composer'),
	'params' => array(



		// internal modifier - does not update atts
		array (
			'param_name' => 'tdc_row_columns_modifier',
			'heading' => 'Layout',
			'type' => 'dropdown',
			'value' => array (
				'1/1' => '11',
				'2/3 + 1/3' => '23_13',
				'1/3 + 2/3' => '13_23',
				'1/3 + 1/3 + 1/3' => '13_13_13'
			),
			'class' => 'tdc-row-col-dropdown tdc-dropdown-extrabig',
		),

		array (
			'param_name' => 'full_width',
			'heading' => 'Row stretch',
			'type' => 'dropdown',
			'value' => array (
				'Default' => '',
				'Stretch row' => 'stretch_row',
				'Stretch row and content' => 'stretch_row_content td-stretch-content',
				'Stretch row and content (with paddings)' => 'stretch_row_content_no_space td-stretch-content',
			),
			'class' => 'tdc-row-stretch-dropdown tdc-dropdown-extrabig',
		),

		array(
			'type' => 'textfield', // should have been vc_el_id but we use textfield
			'heading' => 'Row ID',
			'param_name' => 'el_id',
			'description' => 'Make sure that this is unique on the page',
			'class' => 'tdc-textfield-extrabig',
		),
		array(
			'type' => 'textfield',
			'heading' => 'Extra class',
			'param_name' => 'el_class',
			'description' => 'Add a class to this row',
			'class' => 'tdc-textfield-extrabig',
		),

		array (
			'param_name' => 'css',
			'value' => '',
			'type' => 'css_editor',
			'heading' => 'Css',
			'group' => 'Design options',
		),
		array (
            'param_name' => 'tdc_css',
            'value' => '',
            'type' => 'tdc_css_editor',
            'heading' => '',
            'group' => 'Design options',
        ),
	)
));


tdc_mapper::map_shortcode(
	array(
		'base' => 'vc_column',
		'name' => __('Column', 'td_composer' ),
		'icon' => 'tdc-icon-column',
		'is_container' => true,
		'content_element' => false, // hide from the list of elements on the ui
		'description' => __( 'Place content elements inside the column', 'td_composer' ),
		'params' => array(
			array(
				'type' => 'textfield',
				'heading' => 'Extra class',
				'param_name' => 'el_class',
				'description' => 'Add a class to this column',
				'class' => 'tdc-textfield-extrabig'
			),
			array (
				'param_name' => 'css',
				'value' => '',
				'type' => 'css_editor',
				'heading' => 'Css',
				'group' => 'Design options',
			),
			array (
	            'param_name' => 'tdc_css',
	            'value' => '',
	            'type' => 'tdc_css_editor',
	            'heading' => '',
	            'group' => 'Design options',
	        ),
		)
	)
);


tdc_mapper::map_shortcode(
	array(
		'base' => 'vc_row_inner',
		'name' => __('Inner Row', 'td_composer'),
		'content_element' => false, // hide from the list of elements on the ui
		'is_container' => true,
		'icon' => 'icon-wpb-row',
		'description' => __('Place content elements inside the inner row', 'td_composer'),
		'params' => array(

			// internal modifier - does not update atts
			array (
				'param_name' => 'tdc_inner_row_columns_modifier',
				'heading' => 'Layout',
				'type' => 'dropdown',
				'value' => array (
					'1/1' => '11',
					'1/2 + 1/2' => '12_12',
					'2/3 + 1/3' => '23_13',
					'1/3 + 2/3' => '13_23',
					'1/3 + 1/3 + 1/3' => '13_13_13'
				),
				'class' => 'tdc-innerRow-col-dropdown tdc-dropdown-extrabig'
			),

			array(
				'type' => 'textfield', // should have been vc_el_id but we use textfield
				'heading' => 'Row ID',
				'param_name' => 'el_id',
				'description' => 'Make sure that this is unique on the page',
				'class' => 'tdc-textfield-extrabig',
			),
			array(
				'type' => 'textfield',
				'heading' => 'Extra class',
				'param_name' => 'el_class',
				'description' => 'Add a class to this row',
				'class' => 'tdc-textfield-extrabig',
			),


			array (
				'param_name' => 'css',
				'value' => '',
				'type' => 'css_editor',
				'heading' => 'Css',
				'group' => 'Design options',
			),
			array (
	            'param_name' => 'tdc_css',
	            'value' => '',
	            'type' => 'tdc_css_editor',
	            'heading' => '',
	            'group' => 'Design options',
	        ),
		)
	)
);


tdc_mapper::map_shortcode(
	array(
		'base' => 'vc_column_inner',
		'name' => __( 'Inner Column', 'td_composer' ),
		'icon' => 'icon-wpb-row',
		'allowed_container_element' => false, // if it can contain other container elements (other blocks that have is_container = true)
		'content_element' => false, // hide from the list of elements on the ui
		'is_container' => true,
		'description' => __( 'Place content elements inside the inner column', 'td_composer' ),
		'params' => array(
			array(
				'type' => 'textfield',
				'heading' => 'Extra class',
				'param_name' => 'el_class',
				'description' => 'Add a class to this inner column',
				'class' => 'tdc-textfield-extrabig',
			),
			array (
				'param_name' => 'css',
				'value' => '',
				'type' => 'css_editor',
				'heading' => 'Css',
				'group' => 'Design options',
			),
			array (
	            'param_name' => 'tdc_css',
	            'value' => '',
	            'type' => 'tdc_css_editor',
	            'heading' => '',
	            'group' => 'Design options',
	        ),
		)
	)
);

tdc_mapper::map_shortcode(
	array(
		'map_in_visual_composer' => true,
		'base' => 'vc_column_text',
		'name' => __( 'Column text', 'td_composer' ),
		'icon' => 'icon-wpb-column-text',
		'category' => __( 'Content', 'td_composer' ),
		'description' => __( 'Column text description', 'td_composer' ),
		'params' => array_merge(
			td_config::get_map_block_general_array(),
			array(
				array(
					"param_name" => "content",
					"type" => "textarea_html",
					"holder" => "div",
					'class' => '',
					"heading" => 'Text',
					"value" => __('Html code here! Replace this with any non empty html code and that\'s it', 'td_composer' ),
					"description" => 'Enter your content'
				),
				array(
					"param_name" => "separator",
					"type" => "horizontal_separator",
					"value" => "",
					"class" => ""
				),
				array(
					'type' => 'textfield',
					'heading' => __( 'Extra class', 'td_composer' ),
					'param_name' => 'el_class',
					'description' => __( 'Style particular content element differently - add a class name and refer to it in custom CSS', 'td_composer' ),
					'value' => '',
					'class' => '',
				),

				array (
					'param_name' => 'css',
					'value' => '',
					'type' => 'css_editor',
					'heading' => 'Css',
					'group' => 'Design options',
				),
				array (
		            'param_name' => 'tdc_css',
		            'value' => '',
		            'type' => 'tdc_css_editor',
		            'heading' => '',
		            'group' => 'Design options',
		        ),
			)
		),
	)
);

tdc_mapper::map_shortcode(
	array(
		'map_in_visual_composer' => true,
		'base' => 'vc_raw_html',
		'name' => __( 'Raw html', 'td_composer' ),
		'icon' => 'icon-wpb-raw-html',
		'category' => __( 'Content', 'td_composer' ),
		'description' => __( 'Raw html description', 'td_composer' ),
		'params' => array(
			array(
				"param_name" => "content",
				"type" => "textarea_raw_html",
				"holder" => "div",
				'class' => '',
				"heading" => 'Text',
				"value" => base64_encode(__('Html code here! Replace this with any non empty raw html code and that\'s it', 'td_composer' ) ),
				"description" => 'Enter your content.'
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Extra class', 'td_composer' ),
				'param_name' => 'el_class',
				'description' => __( 'Style particular content element differently - add a class name and refer to it in custom CSS', 'td_composer' ),
				'value' => '',
				'class' => 'tdc-textfield-extrabig',
			),

			array (
				'param_name' => 'css',
				'value' => '',
				'type' => 'css_editor',
				'heading' => 'Css',
				'group' => 'Design options',
			),
			array (
	            'param_name' => 'tdc_css',
	            'value' => '',
	            'type' => 'tdc_css_editor',
	            'heading' => '',
	            'group' => 'Design options',
	        ),
		),
	)
);

tdc_mapper::map_shortcode(
	array(
		'map_in_visual_composer' => true,
		'base' => 'vc_empty_space',
		'name' => __( 'Empty space', 'td_composer' ),
		'icon' => 'icon-wpb-empty-space',
		'category' => __( 'Content', 'td_composer' ),
		'description' => __( 'Empty space description', 'td_composer' ),
		'params' => array(
			array(
				'type' => 'textfield',
				'heading' => __( 'Height', 'td_composer' ),
				'param_name' => 'height',
				'description' => __( 'Custom height of the empty space', 'td_composer' ),
				'value' => '32px',
				'class' => 'tdc-textfield-extrabig',
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Extra class', 'td_composer' ),
				'param_name' => 'el_class',
				'description' => __( 'Style particular content element differently - add a class name and refer to it in custom CSS', 'td_composer' ),
				'value' => '',
				'class' => 'tdc-textfield-extrabig',
			),

			array (
				'param_name' => 'css',
				'value' => '',
				'type' => 'css_editor',
				'heading' => 'Css',
				'group' => 'Design options',
			),
			array (
	            'param_name' => 'tdc_css',
	            'value' => '',
	            'type' => 'tdc_css_editor',
	            'heading' => '',
	            'group' => 'Design options',
	        ),
		),
	)
);


tdc_mapper::map_shortcode(
	array(
		'map_in_visual_composer' => true,
		'base' => 'vc_widget_sidebar',
		'name' => __( 'Widget sidebar', 'td_composer' ),
		'icon' => 'icon-wpb-layout_sidebar',
		'category' => __( 'Content', 'td_composer' ),
		'description' => __( 'Widget sidebar description', 'td_composer' ),
		'params' => array(
			array(
				'type' => 'textfield',
				'heading' => __( 'Widget title', 'td_composer' ),
				'param_name' => 'title',
				'description' => __( 'Enter text used as widget title (Note: located above content element)', 'td_composer' ),
				'value' => '',
				'class' => 'tdc-textfield-extrabig',
			),
			array (
				'param_name' => 'sidebar_id',
				'heading' => 'Sidebar',
				'type' => 'dropdown',

				// The parameter is set at 'admin_head' action, there the global $wp_registered_sidebars being set (otherwise it could be set at 'init')
				// Important! Here is too early to use the global $wp_registered_sidebars, because it isn't set
				'value' => array(),
				'class' => 'tdc-widget-sidebar-dropdown tdc-dropdown-extrabig',
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Extra class', 'td_composer' ),
				'param_name' => 'el_class',
				'description' => __( 'Style particular content element differently - add a class name and refer to it in custom CSS', 'td_composer' ),
				'value' => '',
				'class' => 'tdc-textfield-extrabig',
			),
		),
	)
);


tdc_mapper::map_shortcode(
	array(
		'map_in_visual_composer' => true,
		'base' => 'vc_single_image',
		'name' => __( 'Single image', 'td_composer' ),
		'icon' => 'icon-wpb-empty-space',
		'category' => __( 'Content', 'td_composer' ),
		'description' => __( 'Single image description', 'td_composer' ),
		'params' => array(
			array(
                "param_name" => "image",
                "type" => "attach_image",
                "value" => '',
                "heading" => __( "Image", 'td_composer' ),
                "description" => "",
                "holder" => "div",
                "class" => "",
            ),
			array(
                "param_name" => "image_url",
                "type" => "textfield",
                "value" => '',
                "heading" => __( "Image url", 'td_composer' ),
                "description" => "",
                "holder" => "div",
                "class" => "tdc-textfield-extrabig"
            ),
			array(
                "param_name" => "open_in_new_window",
                "type" => "checkbox",
                "value" => '',
                "heading" => __( "Open in new window",  'td_composer' ),
                "description" => "",
                "holder" => "div",
                "class" => "",
            ),
			array(
                "param_name" => "height",
                "type" => "textfield",
                "value" => '200',
                "heading" => __( 'Image height', 'td_composer' ),
                "description" => "",
                "holder" => "div",
                "class" => "tdc-textfield-small"
            ),
            array(
                "param_name" => "alignment",
                "type" => "dropdown",
                "value" => array(
                    'Top' => 'top',
                    'Center' => '',
                    'Bottom' => 'bottom'
                ),
                "heading" => __( 'Image alignment', 'td_composer' ),
                "description" => "",
                "holder" => "div",
                "class" => "tdc-dropdown-big",
            ),
			array(
                "param_name" => "style",
                "type" => "dropdown",
                "value" => array(
                    'Default' => '',
                    'Rounded' => 'style-rounded',
                    'Border' => 'style-border',
                    'Outline' => 'style-outline',
                    'Shadow' => 'style-shadow',
                    'Bordered Shadow' => 'style-bordered-shadow',
                    '3D Shadow' => 'style-3d-shadow',
                    'Round' => 'style-round',
                    'Round Border' => 'style-round-border',
                    'Round Outline' => 'style-round-outline',
                    'Round Shadow' => 'style-round-shadow',
                    'Round Border Shadow' => 'style-round-border-shadow',
                    'Circle' => 'style-circle',
                    'Circle Border' => 'style-circle-border',
                    'Circle Outline' => 'style-circle-outline',
                    'Circle Shadow' => 'style-circle-shadow',
                    'Circle Border Shadow' => 'style-circle-border-shadow',
                ),
                "heading" => __( 'Box style', 'td_composer' ),
                "description" => "",
                "holder" => "div",
                "class" => "tdc-dropdown-big",
            ),
			array(
                'param_name' => 'el_class',
                'type' => 'textfield',
                'value' => '',
                'heading' => 'Extra class',
                'description' => 'Style particular content element differently - add a class name and refer to it in custom CSS',
                'class' => 'tdc-textfield-extrabig'
            ),

			array (
                'param_name' => 'css',
                'value' => '',
                'type' => 'css_editor',
                'heading' => 'Css',
                'group' => 'Design options',
            ),
            array (
                'param_name' => 'tdc_css',
                'value' => '',
                'type' => 'tdc_css_editor',
                'heading' => '',
                'group' => 'Design options',
            ),
		),
	)
);

tdc_mapper::map_shortcode(
	array(
		'map_in_visual_composer' => true,
		'base' => 'vc_separator',
		'name' => __( 'Separator', 'td_composer' ),
		'icon' => 'icon-wpb-empty-space',
		'category' => __( 'Content', 'td_composer' ),
		'description' => __( 'Separator description', 'td_composer' ),
		'params' => array(
			array(
                "param_name" => "color",
                "type" => "colorpicker",
                "value" => '#EBEBEB',
                "heading" => __( "Color", 'td_composer' ),
                "description" => "",
                "holder" => "div",
                "class" => "",
            ),
			array(
                "param_name" => "align",
                "type" => "dropdown",
                "value" => array(
                    'Center' => 'align_center',
                    'Left' => 'align_left',
                    'Right' => 'align_right',
                ),
                "heading" => __( "Alignment", 'td_composer' ),
                "description" => "",
                "holder" => "div",
                "class" => "tdc-dropdown-big"
            ),
			array(
                "param_name" => "style",
                "type" => "dropdown",
                "value" => array(
                    'Border' => 'solid',
                    'Dashed' => 'dashed',
                    'Dotted' => 'dotted',
                    'Double' => 'double',
                    'Shadow' => 'shadow',
                ),
                "heading" => __( "Style", 'td_composer' ),
                "description" => "",
                "holder" => "div",
                "class" => "tdc-dropdown-big"
            ),
			array(
                "param_name" => "border_width",
                "type" => "dropdown",
                "value" => array(
                    '1px' => '1',
                    '2px' => '2',
                    '3px' => '3',
                    '4px' => '4',
                    '5px' => '5',
                    '6px' => '6',
                    '7px' => '7',
                    '8px' => '8',
                    '9px' => '9',
                    '10px' => '10',
                ),
                "heading" => __( "Border width", 'td_composer' ),
                "description" => "",
                "holder" => "div",
                "class" => "tdc-dropdown-big"
            ),
			array(
                "param_name" => "el_width",
                "type" => "dropdown",
                "value" => array(
                    '100%' => '',
                    '90%' => '90',
                    '80%' => '80',
                    '70%' => '70',
                    '60%' => '60',
                    '50%' => '50',
                    '40%' => '40',
                    '30%' => '30',
                    '20%' => '20',
                    '10%' => '10',
                ),
                "heading" => __( "Element width", 'td_composer' ),
                "description" => "",
                "holder" => "div",
                "class" => "tdc-dropdown-big"
            ),

			array(
                'param_name' => 'el_class',
                'type' => 'textfield',
                'value' => '',
                'heading' => 'Extra class',
                'description' => 'Style particular content element differently - add a class name and refer to it in custom CSS',
                'class' => 'tdc-textfield-extrabig'
            ),

			array (
                'param_name' => 'css',
                'value' => '',
                'type' => 'css_editor',
                'heading' => 'Css',
                'group' => 'Design options',
            ),
            array (
                'param_name' => 'tdc_css',
                'value' => '',
                'type' => 'tdc_css_editor',
                'heading' => '',
                'group' => 'Design options',
            ),
		),
	)
);

tdc_mapper::map_shortcode(
	array(
		'map_in_visual_composer' => true,
		'base' => 'vc_wp_recentcomments',
		'name' => __( 'Recent comments', 'td_composer' ),
		'icon' => 'icon-wpb-empty-space',
		'category' => __( 'Content', 'td_composer' ),
		'description' => __( 'Description', 'td_composer' ),
		'params' => array(
			array(
                "param_name" => "custom_title",
				"type" => "textfield",
				"value" => "Block title",
				"heading" => 'Custom title for this block:',
				"description" => "Optional - a title for this block, if you leave it blank the block will not have a title",
				"holder" => "div",
				"class" => "",
            ),
			array(
				"param_name" => "block_template_id",
				"type" => "dropdown",
				"value" => td_util::get_block_template_ids(),
				"heading" => 'Header template:',
				"description" => "Header template used by the current block",
				"holder" => "div",
				"class" => "tdc-dropdown-big",
			),
			array(
                "param_name" => "number",
				"type" => "textfield",
				"value" => "",
				"heading" => 'Number of comments:',
				"description" => "Optional - a title for this block, if you leave it blank the block will not have a title",
				"holder" => "div",
				"class" => "",
				'class' => 'tdc-textfield-small'
            ),
			array(
                'param_name' => 'el_class',
                'type' => 'textfield',
                'value' => '',
                'heading' => 'Extra class',
                'description' => 'Style particular content element differently - add a class name and refer to it in custom CSS',
                'class' => 'tdc-textfield-extrabig'
            ),

			array (
                'param_name' => 'css',
                'value' => '',
                'type' => 'css_editor',
                'heading' => 'Css',
                'group' => 'Design options',
            ),
            array (
                'param_name' => 'tdc_css',
                'value' => '',
                'type' => 'tdc_css_editor',
                'heading' => '',
                'group' => 'Design options',
            ),
		),
	)
);


function register_external_shortcodes() {

	require_once('shortcodes/rev_slider.php' );

	add_action('td_wp_booster_loaded', 'tdc_load_external_shortcodes',  10002);
	function tdc_load_external_shortcodes() {
		td_global_blocks::add_lazy_shortcode('rev_slider');
	}

	tdc_mapper::map_shortcode(
		array(
			'map_in_visual_composer' => true,
			'base' => 'rev_slider',
			'name' => __( 'Revolution Slider', 'td_composer' ),
			'icon' => 'icon-wpb-revslider',
			'category' => __( 'Content', 'td_composer' ),
			'description' => __( 'Place Revolution slider', 'td_composer' ),
			'params' => array(
				array(
					'type' => 'textfield',
					'heading' => __( 'Widget title', 'td_composer' ),
					'param_name' => 'title',
					'description' => __( 'Enter text used as widget title (Note: located above content element)', 'td_composer' ),
					'value' => '',
					'class' => 'tdc-textfield-extrabig',
				),
				array(
					'type' => 'textfield',
					'heading' => __( 'Slider', 'td_composer' ),
					'param_name' => 'alias',
					'admin_label' => true,
					'value' => '',
					'save_always' => true,
					'description' => __( 'Select your Revolution Slider', 'td_composer' ),
					'class' => 'tdc-textfield-extrabig',
				),
				array(
					'type' => 'textfield',
					'heading' => __( 'Extra class', 'td_composer' ),
					'param_name' => 'el_class',
					'description' => __( 'Style particular content element differently - add a class name and refer to it in custom CSS', 'td_composer' ),
					'value' => '',
					'class' => 'tdc-textfield-extrabig',
				),
			),
		)
	);
}

