<?php
global $submit_title;
global $submit_description;
global $property_price;
global $property_label;
global $property_label_before;
global $property_hoa;
global $property_year_tax;
global $wpestate_submission_page_fields;
$current_user           =   wp_get_current_user();
$userID                 =   $current_user->ID;

$property_fields=wpestate_unset_nonsubmit_fields($property_fields_raw);
$property_fields_description = array_filter($property_fields, function($k) {
    return $k['section'] == 'description';
});

$wpestate_submission_page_fields=   wpresidence_get_option('wp_estate_submission_page_fields','');
$edit_id='';
if(isset($_GET['listing_edit'])){
  $edit_id  =  intval ($_GET['listing_edit']);
}
?>

<div class="wpestate_dashboard_content_wrapper">
    <div class="wpestate_dashboard_section_title"><?php esc_html_e('Property Description','wpresidence');?></div>
    <?php  print wpestate_dashnoard_display_form_fields($property_fields_description,$edit_id,'property');  ?>
    <input type="hidden" name="is_user_submit" value="1">
</div>
