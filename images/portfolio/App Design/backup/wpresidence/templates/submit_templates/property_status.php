<?php
global $wpestate_submission_page_fields;

$property_status_array          =   get_terms( array(
                                    'taxonomy' => 'property_status',
                                    'hide_empty' => false,
                                ));

$prop_stat                   =   '';
if( isset( $_GET['listing_edit'] ) && is_numeric( $_GET['listing_edit']) ) {
      $post_id = intval( $_GET['listing_edit'] );
      $property_status_values    =    get_the_terms( $post_id, 'property_status');
      if(!empty($property_status_values)){
           foreach ($property_status_values as $key=>$term){
               $prop_stat=esc_html($term->name);
           }
       }

}

if(isset($_POST['property_status'])){
    $prop_stat                      =   wp_kses( $_POST['property_status'],$allowed_html);
}

$property_status='';
if(is_array($property_status_array)){
           foreach ($property_status_array as $key=>$term) {
               $property_status.='<option value="' . $term->name . '"';
               if ($term->name == $prop_stat) {
                   $property_status.='selected="selected"';
               }
               $property_status.='>' .stripslashes($term->name) . '</option>';
           }
       }
?>

<?php if ( is_array($wpestate_submission_page_fields) && in_array('property_status', $wpestate_submission_page_fields) ) { ?>
  <div class="profile-onprofile row">
        <div class="wpestate_dashboard_section_title"><?php esc_html_e('Select Property Status','wpresidence');?></div>

            <div class="col-md-6">
                    <label for="property_status"><?php esc_html_e('Property Status','wpresidence');?></label>
                    <select id="property_status" name="property_status" class="select-submit">
                        <option value=""><?php esc_html_e('no status','wpresidence');?></option>
                        <?php print trim($property_status); ?>
                    </select>
           </div>



    </div>
<?php }?>
