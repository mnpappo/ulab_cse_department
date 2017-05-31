
<div class="form-alerts">
<?php
echo (isset($zf_error) ? $zf_error : (isset($error) ? $error : ''));
$form_list = get_option('campus_directory_glob_forms_list');
$form_list_init = get_option('campus_directory_glob_forms_init_list');
if (!empty($form_list['people_search'])) {
	$form_variables = $form_list['people_search'];
}
$form_variables_init = $form_list_init['people_search'];
$max_row = count($form_variables_init);
foreach ($form_variables_init as $fkey => $fval) {
	if (empty($form_variables[$fkey])) {
		$form_variables[$fkey] = $form_variables_init[$fkey];
	}
}
$ext_inputs = Array();
$ext_inputs = apply_filters('emd_ext_form_inputs', $ext_inputs, 'campus_directory', 'people_search');
$form_variables = apply_filters('emd_ext_form_var_init', $form_variables, 'campus_directory', 'people_search');
$req_hide_vars = emd_get_form_req_hide_vars('campus_directory', 'people_search');
$glob_list = get_option('campus_directory_glob_list');
?>
</div>
<fieldset>
<?php wp_nonce_field('people_search', 'people_search_nonce'); ?>
<input type="hidden" name="form_name" id="form_name" value="people_search">
<div class="people_search-btn-fields container-fluid">
<!-- people_search Form Attributes -->
<div class="people_search_attributes">
<div id="row1" class="row ">
<!-- text input-->
<?php if ($form_variables['emd_person_fname']['show'] == 1) { ?>
<div class="col-md-<?php echo $form_variables['emd_person_fname']['size']; ?> woptdiv">
<div class="form-group">
<label id="label_emd_person_fname" class="control-label" for="emd_person_fname">
<?php _e('First Name', 'campus-directory'); ?>
<span style="display: inline-flex;right: 0px; position: relative; top:-6px;">
<?php if (in_array('emd_person_fname', $req_hide_vars['req'])) { ?>
<a href="#" data-html="true" data-toggle="tooltip" title="<?php _e('First Name field is required', 'campus-directory'); ?>" id="info_emd_person_fname" class="helptip">
<span class="field-icons icons-required"></span>
</a>
<?php
	} ?>
</span>
</label>
<?php echo $emd_person_fname; ?>
</div>
</div>
<?php
} ?>
</div>
<div id="row2" class="row ">
<!-- text input-->
<?php if ($form_variables['emd_person_lname']['show'] == 1) { ?>
<div class="col-md-<?php echo $form_variables['emd_person_lname']['size']; ?> woptdiv">
<div class="form-group">
<label id="label_emd_person_lname" class="control-label" for="emd_person_lname">
<?php _e('Last Name', 'campus-directory'); ?>
<span style="display: inline-flex;right: 0px; position: relative; top:-6px;">
<?php if (in_array('emd_person_lname', $req_hide_vars['req'])) { ?>
<a href="#" data-html="true" data-toggle="tooltip" title="<?php _e('Last Name field is required', 'campus-directory'); ?>" id="info_emd_person_lname" class="helptip">
<span class="field-icons icons-required"></span>
</a>
<?php
	} ?>
</span>
</label>
<?php echo $emd_person_lname; ?>
</div>
</div>
<?php
} ?>
</div>
<div id="row3" class="row ">
<!-- selectadv input-->
<?php if ($form_variables['emd_person_type']['show'] == 1) { ?>
<div class="col-md-<?php echo $form_variables['emd_person_type']['size']; ?>">
<div class="form-group">
<label id="label_emd_person_type" class="control-label" for="emd_person_type">
<?php _e('Person Type', 'campus-directory'); ?>
<span style="display: inline-flex;right: 0px; position: relative; top:-6px;">
<?php if (in_array('emd_person_type', $req_hide_vars['req'])) { ?>
<a href="#" data-html="true" data-toggle="tooltip" title="<?php _e('Person Type field is required', 'campus-directory'); ?>" id="info_emd_person_type" class="helptip">
<span class="field-icons icons-required"></span>
</a>
<?php
	} ?>
</span>
</label>
<div id="input_emd_person_type">
<?php echo $emd_person_type; ?>
</div>
</div>
</div>
<?php
} ?>
</div>
<div id="row4" class="row ">
<!-- text input-->
<?php if ($form_variables['emd_person_office']['show'] == 1) { ?>
<div class="col-md-<?php echo $form_variables['emd_person_office']['size']; ?> woptdiv">
<div class="form-group">
<label id="label_emd_person_office" class="control-label" for="emd_person_office">
<?php _e('Office', 'campus-directory'); ?>
<span style="display: inline-flex;right: 0px; position: relative; top:-6px;">
<?php if (in_array('emd_person_office', $req_hide_vars['req'])) { ?>
<a href="#" data-html="true" data-toggle="tooltip" title="<?php _e('Office field is required', 'campus-directory'); ?>" id="info_emd_person_office" class="helptip">
<span class="field-icons icons-required"></span>
</a>
<?php
	} ?>
</span>
</label>
<?php echo $emd_person_office; ?>
</div>
</div>
<?php
} ?>
</div>
<div id="row5" class="row ">
<!-- text input-->
<?php if ($form_variables['emd_person_email']['show'] == 1) { ?>
<div class="col-md-<?php echo $form_variables['emd_person_email']['size']; ?> woptdiv">
<div class="form-group">
<label id="label_emd_person_email" class="control-label" for="emd_person_email">
<?php _e('Email', 'campus-directory'); ?>
<span style="display: inline-flex;right: 0px; position: relative; top:-6px;">
<?php if (in_array('emd_person_email', $req_hide_vars['req'])) { ?>
<a href="#" data-html="true" data-toggle="tooltip" title="<?php _e('Email field is required', 'campus-directory'); ?>" id="info_emd_person_email" class="helptip">
<span class="field-icons icons-required"></span>
</a>
<?php
	} ?>
</span>
</label>
<?php echo $emd_person_email; ?>
</div>
</div>
<?php
} ?>
</div>
<div id="row6" class="row ">
<!-- Taxonomy input-->
<?php if ($form_variables['person_area']['show'] == 1) { ?>
<div class="col-md-<?php echo $form_variables['person_area']['size']; ?>">
<div class="form-group">
<label id="label_person_area" class="control-label" for="person_area">
<?php _e('Academic Area', 'campus-directory'); ?>
<span style="display: inline-flex;right: 0px; position: relative; top:-6px;">
<a data-html="true" href="#" data-toggle="tooltip" title="<?php _e('Academic area of expertise', 'campus-directory'); ?>" id="info_person_area" class="helptip"><span class="field-icons icons-help"></span></a>
<?php if (in_array('person_area', $req_hide_vars['req'])) { ?>
<a href="#" data-html="true" data-toggle="tooltip" title="<?php _e('Academic Area field is required', 'campus-directory'); ?>" id="info_person_area" class="helptip">
<span class="field-icons icons-required"></span>
</a>
<?php
	} ?>
</span>
</label>
<?php echo $person_area; ?>
</div>
</div>
<?php
} ?>
</div>
<div id="row7" class="row ">
<!-- Taxonomy input-->
<?php if ($form_variables['person_rareas']['show'] == 1) { ?>
<div class="col-md-<?php echo $form_variables['person_rareas']['size']; ?>">
<div class="form-group">
<label id="label_person_rareas" class="control-label" for="person_rareas">
<?php _e('Research Area', 'campus-directory'); ?>
<span style="display: inline-flex;right: 0px; position: relative; top:-6px;">
<?php if (in_array('person_rareas', $req_hide_vars['req'])) { ?>
<a href="#" data-html="true" data-toggle="tooltip" title="<?php _e('Research Area field is required', 'campus-directory'); ?>" id="info_person_rareas" class="helptip">
<span class="field-icons icons-required"></span>
</a>
<?php
	} ?>
</span>
</label>
<?php echo $person_rareas; ?>
</div>
</div>
<?php
} ?>
</div>
<div id="row8" class="row ">
<!-- Taxonomy input-->
<?php if ($form_variables['directory_tag']['show'] == 1) { ?>
<div class="col-md-<?php echo $form_variables['directory_tag']['size']; ?>">
<div class="form-group">
<label id="label_directory_tag" class="control-label" for="directory_tag">
<?php _e('Directory Tag', 'campus-directory'); ?>
<span style="display: inline-flex;right: 0px; position: relative; top:-6px;">
<a data-html="true" href="#" data-toggle="tooltip" title="<?php _e('Generic taxonomy which binds people, courses and publications together.', 'campus-directory'); ?>" id="info_directory_tag" class="helptip"><span class="field-icons icons-help"></span></a>
<?php if (in_array('directory_tag', $req_hide_vars['req'])) { ?>
<a href="#" data-html="true" data-toggle="tooltip" title="<?php _e('Directory Tag field is required', 'campus-directory'); ?>" id="info_directory_tag" class="helptip">
<span class="field-icons icons-required"></span>
</a>
<?php
	} ?>
</span>
</label>
<?php echo $directory_tag; ?>
</div>
</div>
<?php
} ?>
</div>
</div><!--form-attributes-->
<?php if ($show_captcha == 1) { ?>
<div class="row">
<div class="col-xs-12">
<div id="captcha-group" class="form-group">
<?php echo $captcha_image; ?>
<label style="padding:0px;" id="label_captcha_code" class="control-label" for="captcha_code">
<a id="info_captcha_code_help" class="helptip" data-html="true" data-toggle="tooltip" href="#" title="<?php _e('Please enter the characters with black color in the image above.', 'campus-directory'); ?>">
<span class="field-icons icons-help"></span>
</a>
<a id="info_captcha_code_req" class="helptip" title="<?php _e('Security Code field is required', 'campus-directory'); ?>" data-toggle="tooltip" href="#">
<span class="field-icons icons-required"></span>
</a>
</label>
<?php echo $captcha_code; ?>
</div>
</div>
</div>
<?php
} ?>
<!-- Button -->
<div class="row">
<div class="col-md-12">
<div class="wpas-form-actions">
<?php echo $singlebutton_people_search; ?>
</div>
</div>
</div>
</div><!--form-btn-fields-->
</fieldset>