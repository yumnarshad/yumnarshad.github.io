<?php

global $wpestate_submission_page_fields;
$show_settings_value=   1;
$measure_sys        =   wpestate_get_meaurement_unit_formated( $show_settings_value );
$custom_fields_show =   '';
$custom_fields      =   wpresidence_get_option( 'wp_estate_custom_fields', '');
$i                  =   0;

if( !empty($custom_fields)){
   while($i< count($custom_fields) ){
      $name    =   $custom_fields[$i][0];
      $type    =   $custom_fields[$i][1];
      $slug    =   str_replace(' ','_',$name);
      $slug    =   wpestate_limit45(sanitize_title( $name ));
      $slug    =   sanitize_key($slug);
      if(isset($_POST[$slug])){
       $custom_fields_array[$slug]= wp_kses( esc_html($_POST[$slug]),$allowed_html);
      }
      $i++;
   }
}

$i=0;
if( !empty($custom_fields)):
    while($i< count($custom_fields) ){
        $name               =   $custom_fields[$i][0];
        $label              =   stripslashes( $custom_fields[$i][1] );
        $type               =   $custom_fields[$i][2];
        $order              =   $custom_fields[$i][3];
        $dropdown_values    =   $custom_fields[$i][4];
        $slug         =     $prslig            =   str_replace(' ','_',$name);
        $prslig1      =     htmlspecialchars ( str_replace(' ','_', trim($name) ) , ENT_QUOTES );
        $slug         =   wpestate_limit45(sanitize_title( $name ));
        $slug         =   sanitize_key($slug);
        $post_id      =     $post->ID;
        if( isset( $get_listing_edit ) && is_numeric( $get_listing_edit) ) {
            $post_id = intval( $get_listing_edit );
        }
        $show         =     1;
        $i++;

        if (function_exists('icl_translate') ){
            $label     =   icl_translate('wpestate','wp_estate_property_custom_front_'.$label, $label ) ;
        }

        $custom_fields_show.= '<div class="col-md-6">';
        $value='';
        if(isset($custom_fields_array[$slug])){
            $value=$custom_fields_array[$slug];
        }

        if(is_array($wpestate_submission_page_fields) && ( in_array($prslig, $wpestate_submission_page_fields) ||  in_array($prslig1, $wpestate_submission_page_fields))  ) {
          $custom_fields_show.=  wpestate_show_custom_field(0,$slug,$name,$label,$type,$order,$dropdown_values,$post_id,$value);
        }

        $custom_fields_show.= '</div>';


   }
endif;
?>


<?php if(   is_array($wpestate_submission_page_fields) &&
           (    in_array('property_size', $wpestate_submission_page_fields) ||
                in_array('property_lot_size', $wpestate_submission_page_fields) ||
                in_array('property_rooms', $wpestate_submission_page_fields) ||
                in_array('property_bedrooms', $wpestate_submission_page_fields) ||
                in_array('property_bathrooms', $wpestate_submission_page_fields) ||
                in_array('owner_notes', $wpestate_submission_page_fields) ||
                $custom_fields_show !=  ''

            )
        ) { ?>


<div class="profile-onprofile row">
    <div class="wpestate_dashboard_section_title"><?php esc_html_e('Listing Details', 'wpresidence');?></div>

            <?php if(   is_array($wpestate_submission_page_fields) && in_array('property_size', $wpestate_submission_page_fields)) { ?>
                <div class="col-md-6">
                    <label for="property_size"> <?php esc_html_e('Size in','wpresidence');print ' '.$measure_sys.'  '.esc_html__(' (*only numbers)','wpresidence');?></label>
                    <input type="text" id="property_size" size="40" class="form-control"  name="property_size"
                        value="<?php print stripslashes(wpestate_submit_return_value('property_size',$get_listing_edit,'numeric') ) ; ?>">
                </div>
            <?php }?>

            <?php if(   is_array($wpestate_submission_page_fields) && in_array('property_lot_size', $wpestate_submission_page_fields)) { ?>
                <div class="col-md-6 ">
                    <label for="property_lot_size"> <?php  esc_html_e('Lot Size in','wpresidence');print ' '.$measure_sys.' '.esc_html__(' (*only numbers)','wpresidence');?> </label>
                    <input type="text" id="property_lot_size" size="40" class="form-control"  name="property_lot_size"
                    value="<?php print stripslashes(wpestate_submit_return_value('property_lot_size',$get_listing_edit,'numeric') ) ; ?>">
                </div>
            <?php }?>

            <?php if(   is_array($wpestate_submission_page_fields) && in_array('property_rooms', $wpestate_submission_page_fields)) { ?>
                <div class="col-md-6 ">
                    <label for="property_rooms"><?php esc_html_e('Rooms (*only numbers)','wpresidence');?></label>
                    <input type="text" id="property_rooms" size="40" class="form-control"  name="property_rooms"
                      value="<?php print stripslashes(wpestate_submit_return_value('property_rooms',$get_listing_edit,'numeric') ) ; ?>">
                </div>
            <?php }?>

            <?php if(   is_array($wpestate_submission_page_fields) && in_array('property_bedrooms', $wpestate_submission_page_fields)) { ?>
                <div class="col-md-6 ">
                    <label for="property_bedrooms "><?php esc_html_e('Bedrooms (*only numbers)','wpresidence');?></label>
                    <input type="text" id="property_bedrooms" size="40" class="form-control"  name="property_bedrooms"
                      value="<?php print stripslashes(wpestate_submit_return_value('property_bedrooms',$get_listing_edit,'numeric') ) ; ?>">
                </div>
            <?php }?>

            <?php if(   is_array($wpestate_submission_page_fields) && in_array('property_bathrooms', $wpestate_submission_page_fields)) { ?>
                <div class="col-md-6 ">
                    <label for="property_bathrooms"><?php esc_html_e('Bathrooms (*only numbers)','wpresidence');?></label>
                    <input type="text" id="property_bathrooms" size="40" class="form-control"  name="property_bathrooms"
                      value="<?php print stripslashes(wpestate_submit_return_value('property_bathrooms',$get_listing_edit,'numeric') ) ; ?>">
                </div>
            <?php }?>

            <!-- Add custom details -->
            <?php
            print trim($custom_fields_show);
            ?>


            <?php if(   is_array($wpestate_submission_page_fields) && in_array('owner_notes', $wpestate_submission_page_fields)) { ?>
                <div class="col-md-12 ">
                    <label for="owner_notes"><?php esc_html_e('Owner/Agent notes (*not visible on front end)','wpresidence');?></label>
                    <textarea id="owner_notes" class="form-control"  name="owner_notes"><?php print esc_html(wpestate_submit_return_value('owner_notes',$get_listing_edit,''));?></textarea>
                </div>
            <?php } ?>


</div>

<?php }?>
