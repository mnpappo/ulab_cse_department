<?php global $people_grid_count, $people_grid_filter, $people_grid_set_list;
$real_post = $post;
$ent_attrs = get_option('campus_directory_attr_list');
?>
<div class="emdcol span_1_of_5">
    <a href="<?php echo get_permalink(); ?>" title="<?php echo esc_html(emd_mb_meta('emd_person_fname')); ?>
 <?php echo esc_html(emd_mb_meta('emd_person_lname')); ?>
">
        <div class="emdlabel inside bottom" data-label="<?php echo esc_html(emd_mb_meta('emd_person_fname')); ?>
 <?php echo esc_html(emd_mb_meta('emd_person_lname')); ?>
"> <?php if (get_post_meta($post->ID, 'emd_person_photo')) {
	$sval = get_post_meta($post->ID, 'emd_person_photo');
	$thumb = wp_get_attachment_image_src($sval[0], 'thumbnail');
	echo '<img class="emd-img thumb" src="' . $thumb[0] . '" width="' . $thumb[1] . '" height="' . $thumb[2] . '" alt="' . get_post_meta($sval[0], '_wp_attachment_image_alt', true) . '"/>';
} ?> </div>
    </a>
</div>