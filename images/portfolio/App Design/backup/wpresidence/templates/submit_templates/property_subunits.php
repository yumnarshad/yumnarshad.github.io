<?php

global $wpestate_submission_page_fields;
if( isset( $_GET['listing_edit'] ) && is_numeric( $_GET['listing_edit']) ) {
      $edit_id                    =   intval( $_GET['listing_edit'] );
      $property_has_subunits      =   intval      (get_post_meta($edit_id, 'property_has_subunits', true)) ;
      $property_subunits_list     =   get_post_meta($edit_id, 'property_subunits_list', true);
}



if(isset($_POST['property_subunits_list'])){
    $property_subunits_list         =     ($_POST['property_subunits_list']);
}
if(isset($_POST['property_has_subunits'])){
    $property_has_subunits          =   wp_kses( esc_html($_POST['property_has_subunits']),$allowed_html);
}

?>

<?php if(   is_array($wpestate_submission_page_fields) && in_array('property_subunits_list', $wpestate_submission_page_fields)) { ?>
  <div class="profile-onprofile row">
        <div class="wpestate_dashboard_section_title"><?php esc_html_e('Subunits','wpresidence');?></div>

            <div class="col-md-3">
                <input type="hidden" name="property_has_subunits" value="">
                <input type="checkbox"  id="property_has_subunits" name="property_has_subunits" value="1"
                    <?php
                        if ($property_has_subunits == 1) {
                            print'checked="checked"';
                        }
                    ?>
                    />
                <label class="checklabel" for="property_has_subunits"><?php esc_html_e('Enable ','wpresidence');?></label>
            </div>


            <div class="col-md-9">

                    <label for="property_subunits_list"><?php esc_html_e('Select Subunits From the list: ','wpresidence'); ?></label>
                    <?php



                        $current_user   =   wp_get_current_user();
                        $userID         =   $current_user->ID;
                        $post__not_in   =   array();
                        $post__not_in[] =   $edit_id;
                        $args = array(
                                    'post_type'                 =>  'estate_property',
                                    'post_status'               => 'publish',
                                    'nopaging'                  =>  'true',
                                    'post__not_in'              =>  $post__not_in,
                                    'cache_results'             =>  false,
                                    'update_post_meta_cache'    =>  false,
                                    'update_post_term_cache'    =>  false,
                                    'author'                    =>  $userID,
                                    'cache_results'             =>  false,
                                    'update_post_meta_cache'    =>  false,
                                    'update_post_term_cache'    =>  false,

                            );


                        $recent_posts = new WP_Query($args);
                        print '<select name="property_subunits_list[]"  style="height:350px;" id="property_subunits_list"  multiple="multiple">';
                        while ($recent_posts->have_posts()): $recent_posts->the_post();
                             $theid=get_the_ID();
                             print '<option value="'.$theid.'" ';
                             if( is_array($property_subunits_list) && in_array($theid, $property_subunits_list) ){
                                 print ' selected="selected" ';
                             }
                             print'>'.get_the_title().'</option>';
                        endwhile;
                        print '</select>';


                    ?>


            </div>

    </div>

<?php } ?>
