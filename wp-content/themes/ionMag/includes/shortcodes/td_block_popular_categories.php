<?php

class td_block_popular_categories extends td_block {


    /**
     * Disable loop block features. This block does not use a loop and it dosn't need to run a query.
     */
    function __construct() {
        parent::disable_loop_block_features();
    }



    function render($atts, $content = null){
        parent::render($atts);

        $buffy = '';

        extract(shortcode_atts(
            array(
                'limit' => '6', // show only 6 categories by default
                'custom_title' => '',
                'custom_url' => '',
                'hide_title' => '',
                'header_color' => ''
            ), $atts));

        $cat_args = array(
            'show_count' => true,
            'orderby' => 'count',
            'hide_empty' => false,
            'order' => 'DESC',
            'number' => $limit,
            'exclude' => get_cat_ID(TD_FEATURED_CAT)
        );


        // exclude categories from the demo
        if (TD_DEPLOY_MODE == 'demo' or TD_DEPLOY_MODE == 'dev') {
            $cat_args['exclude'] = '19, 20, 21, 22, 23, 24, 25, 26, 27, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 59, 60, 61, 62, 63, 64, 65, 66, 67, 68, 69, 70, 71, 72, 73, 74, 75, 76, 77, 78, 79, 80, 81, 82' . get_cat_ID(TD_FEATURED_CAT);
        }

        $categories = get_categories($cat_args); // has a limit of 6 by default

        $buffy .= '<div class="' . $this->get_block_classes(array('widget', 'widget_categories')) . '" ' . $this->get_block_html_atts() . '>';

        //get the block css
        $buffy .= $this->get_block_css();

        $buffy .= $this->get_block_title();

        if (!empty($categories)) {
            $buffy .= '<ul>';
            foreach ($categories as $category) {
                if (strtolower($category->cat_name) != 'uncategorized') {
                    $buffy .= '<li><a href="' . get_category_link($category->cat_ID) . '">' . $category->name . '<span class="td-cat-no">' . $category->count . '</span></a></li>';
                }
            }
            $buffy .= '</ul>';
        }
        $buffy .= '</div> <!-- ./block -->';
        return $buffy;
    }

    function inner($posts, $td_column_number = '') {

    }
}