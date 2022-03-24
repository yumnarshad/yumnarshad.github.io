<?php
$property_fields=wpestate_unset_nonsubmit_fields($property_fields_raw);
$property_fields_category = array_filter($property_fields, function($k) {
    return $k['section'] == 'category';
});
$wpestate_submission_page_fields=   wpresidence_get_option('wp_estate_submission_page_fields','');
$edit_id='';
if(isset($_GET['listing_edit'])){
  $edit_id  =  intval ($_GET['listing_edit']);
}
?>



<div class="wpestate_dashboard_content_wrapper">
    <div class="wpestate_dashboard_section_title"><?php esc_html_e('Select Categories','wpresidence');?></div>
    <?php  print wpestate_dashnoard_display_form_fields($property_fields_category,$edit_id,'property');  ?>

</div>
