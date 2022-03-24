<?php
global $wpestate_submission_page_fields;
$enable_autocomplete_status= esc_html ( wpresidence_get_option('wp_estate_enable_autocomplete','') );

$property_county_state='';
if( isset( $get_listing_edit ) && is_numeric( $get_listing_edit) ) {
      $post_id = intval( $get_listing_edit );
      $property_city_values    =    get_the_terms( $post_id, 'property_city');
      if(!empty($property_city_values)){
           foreach ($property_city_values as $key=>$term){
               $property_city=esc_html($term->name);
           }
       }

       $property_area_values    =    get_the_terms( $post_id, 'property_area');
       if(!empty($property_area_values)){
            foreach ($property_area_values as $key=>$term){
                $property_area=esc_html($term->name);
            }
        }


        $property_county_values    =    get_the_terms( $post_id, 'property_county_state');
        if(!empty($property_county_values)){
             foreach ($property_county_values as $key=>$term){
                 $property_county_state=esc_html($term->name);
             }
         }

}


if( isset($_POST['property_city']) ) {
   $property_city  =   wp_kses(esc_html($_POST['property_city']),$allowed_html);
}

if( isset($_POST['property_area']) ) {
   $property_area  =   wp_kses(esc_html($_POST['property_area']),$allowed_html);
}

if( isset($_POST['property_county']) ) {
  $property_county_state  =   wp_kses(esc_html($_POST['property_county']),$allowed_html);
}



$country_selected=wpestate_submit_return_value('property_country',$get_listing_edit,'');

$google_view                    =   wpestate_submit_return_value('property_google_view',$get_listing_edit,'');;

if($google_view==1){
   $google_view_check  =' checked="checked" ';
}else{
    $google_view_check =' ';
}


?>

<?php if(   is_array($wpestate_submission_page_fields) &&
           (    in_array('property_address', $wpestate_submission_page_fields) ||
                in_array('property_city_submit', $wpestate_submission_page_fields) ||
                in_array('property_area', $wpestate_submission_page_fields) ||
                in_array('property_zip', $wpestate_submission_page_fields) ||
                in_array('property_county', $wpestate_submission_page_fields) ||
                in_array('property_country', $wpestate_submission_page_fields) ||
                in_array('property_map', $wpestate_submission_page_fields) ||
                in_array('property_latitude', $wpestate_submission_page_fields) ||
                in_array('property_longitude', $wpestate_submission_page_fields) ||
                in_array('google_camera_angle', $wpestate_submission_page_fields) ||
                in_array('property_google_view', $wpestate_submission_page_fields)
            )
        ) { ?>



    <div class="profile-onprofile row">
          <div class="wpestate_dashboard_section_title"><?php esc_html_e('Listing Location','wpresidence');?></div>

          <?php if( is_array($wpestate_submission_page_fields) && in_array('property_address', $wpestate_submission_page_fields)) { ?>
              <div class="col-md-12">
                  <label for="property_address"><?php esc_html_e('*Address','wpresidence');?></label>
                  <input type="text" placeholder="<?php esc_html_e('Enter address','wpresidence')?>" id="property_address" class="form-control" size="40" name="property_address" rows="3" cols="42"
                        value="<?php print stripslashes(wpestate_submit_return_value('property_address',$get_listing_edit,'') ) ; ?>">
              </div>
          <?php }?>


				<?php if ( is_array($wpestate_submission_page_fields) && in_array('property_county', $wpestate_submission_page_fields) ) { ?>
                    <div class="col-md-6" >
                        <label for="property_county"><?php esc_html_e('County / State','wpresidence');?></label>
                        <?php
                        if($enable_autocomplete_status=='no'){
                            $selected_county_id =   -1;
                            $select_state       =   '';
                            $taxonomy           =   'property_county_state';
							              $args_tax = array('hide_empty'        => false );
                            $tax_terms          =   get_terms($taxonomy,$args_tax);

                            $args=array(
                                'class'       => 'select-submit2',
                                'hide_empty'  => false,
                                'selected'    => $property_county_state,
                                'name'        => 'property_county',
                                'id'          => 'property_county',
                                'orderby'     => 'NAME',
                                'order'       => 'ASC',
                                'show_option_none'   => esc_html__('None','wpresidence'),
                                'taxonomy'    => 'property_county_state',
                                'hierarchical'=> true,
                                'value_field' => 'name'
                              );
                              wp_dropdown_categories( $args );

                        }else{
                        ?>
                            <input type="text" id="property_county" class="form-control"  size="40" name="property_county" value="<?php print esc_html($property_county_state);?>">
                        <?php
                        }
                        ?>
                    </div>
                <?php } ?>

                <?php if(   is_array($wpestate_submission_page_fields) && in_array('property_city', $wpestate_submission_page_fields)) { ?>
                    <div class="advanced_city_div col-md-6">
                    <label for="property_city"><?php  esc_html_e('City','wpresidence');?></label>

                        <?php

                        if($enable_autocomplete_status=='no'){
                            $selected_city_id=-1;

                            $select_city='';
                            $taxonomy = 'property_city';
                            $args_tax = array('hide_empty'        => false );
                            $tax_terms = get_terms($taxonomy,$args_tax);

                            foreach ($tax_terms as $tax_term) {
                                $term_meta=  get_option( "taxonomy_$tax_term->term_id");

                								if( isset($term_meta['stateparent']) && $term_meta['stateparent'] != '' ){
                									$parent_val = $term_meta['stateparent'];
                								}else{
                									$parent_val = '';
                								}

                                $select_city.= '<option value="' . $tax_term->name . '" data-parentcounty="'.esc_attr($parent_val).'"';
                                    if($property_city==$tax_term->name ){
                                          $select_city.= ' selected="selected" ';
                                    }
                                $select_city.= '>' . $tax_term->name . '</option>';
                            }
							?>

							<select id="property_city_submit" name="property_city"  class="cd-select">
							   <option data-parentcounty="none" value="none"><?php  esc_html_e('None','wpresidence'); ?></option>
							   <option data-parentcounty="all" value="all"><?php   esc_html_e('Cities','wpresidence'); ?></option>
							   <?php  echo trim($select_city); ?>
							</select>

							<select id="property_city_submit_hidden" name="property_city_hidden"  class="cd-select">
								<option data-parentcounty="none" value="none"><?php  esc_html_e('None','wpresidence'); ?></option>
								<option data-parentcounty="all" value="all"><?php  esc_html_e('Cities','wpresidence'); ?></option>
								<?php  echo trim($select_city); ?>
							</select>

							<?php

                        }else{
                        ?>
                            <input type="text" id="property_city_submit" name="property_city" class="form-control" placeholder="<?php esc_html_e('Enter city','wpresidence')?>" size="40" value="<?php print esc_html($property_city);?>" >
                        <?php
                        }
                        ?>
                    </div>

                <?php }?>


                <?php if ( is_array($wpestate_submission_page_fields) && in_array('property_area', $wpestate_submission_page_fields) ) { ?>
                    <div class="advanced_area_div col-md-6 ">
                        <label for="property_area"><?php esc_html_e('Neighborhood','wpresidence');?></label>

                        <?php
                        if($enable_autocomplete_status=='no'){
                            $select_area='';
                            $taxonomy = 'property_area';
                            $args_tax = array('hide_empty'        => false );
                            $tax_terms = get_terms($taxonomy,$args_tax);

                            foreach ($tax_terms as $tax_term) {
                                $term_meta=  get_option( "taxonomy_$tax_term->term_id");
                                $select_area.= '<option value="'.$tax_term->name.'" ';
                                if(isset($term_meta['cityparent'])){
                                    $select_area.= ' data-parentcity="'.esc_attr($term_meta['cityparent']).'" ';
                                }
                                if($property_area==$tax_term->name ){
                                    $select_area.= ' selected="selected" ';
                                }
                                $select_area.= '>' . $tax_term->name . '</option>';
                            }
                        ?>

                        <select id="property_area_submit" name="property_area"  class="cd-select">
                           <option data-parentcity="none" value="none"><?php  esc_html_e('None','wpresidence'); ?></option>
                           <option data-parentcity="all" value="all"><?php   esc_html_e('Areas','wpresidence'); ?></option>
                           <?php  echo trim($select_area); ?>
                        </select>

                        <select id="property_area_submit_hidden" name="property_area_hidden"  class="cd-select">
                            <option data-parentcity="none" value="none"><?php  esc_html_e('None','wpresidence'); ?></option>
                            <option data-parentcity="all" value="all"><?php  esc_html_e('Areas','wpresidence'); ?></option>
                            <?php  echo trim($select_area); ?>
                        </select>
                        <?php
                        } else {
                        ?>
                            <input type="text" id="property_area" name="property_area" class="form-control" size="40" value="<?php print esc_html($property_area);?>">
                        <?php
                        }
                        ?>

                    </div>

                <?php } ?>


                <?php if ( is_array($wpestate_submission_page_fields) && in_array('property_zip', $wpestate_submission_page_fields) ) { ?>
                    <div class="col-md-6">
                        <label for="property_zip"><?php esc_html_e('Zip ','wpresidence');?></label>
                        <input type="text" id="property_zip" class="form-control" size="40" name="property_zip"
                        value="<?php print stripslashes(wpestate_submit_return_value('property_zip',$get_listing_edit,'') ) ; ?>">
                    </div>
                <?php } ?>







                <?php if ( is_array($wpestate_submission_page_fields) && in_array('property_country', $wpestate_submission_page_fields) ) { ?>
                    <div class="col-md-6">
                        <label for="property_country"><?php esc_html_e('Country ','wpresidence'); ?></label>
                        <?php print wpestate_country_list($country_selected,'select-submit2'); ?>
                    </div>
                <?php } ?>


                <?php if ( is_array($wpestate_submission_page_fields) && in_array('property_map', $wpestate_submission_page_fields) ) { ?>
                    <?php if( $enable_autocomplete_status=='no'){?>
                        <div class="col-md-12" style="float:left;">
                            <button id="google_capture"  class="wpresidence_button wpresidence_success"><?php esc_html_e('Place Pin with Property Address','wpresidence');?></button>
                        </div>
                    <?php } ?>
                   <div class="col-md-12">
                        <div id="googleMapsubmit" ></div>
                    </div>

                <?php } ?>



                <?php if ( is_array($wpestate_submission_page_fields) && in_array('property_latitude', $wpestate_submission_page_fields) ) { ?>
                    <div class="col-md-6">
                    <label for="property_latitude"><?php esc_html_e('Latitude (for Google Maps)','wpresidence'); ?></label>
                         <input type="text" id="property_latitude" class="form-control" style="margin-right:20px;" size="40" name="property_latitude"
                          value="<?php print stripslashes(wpestate_submit_return_value('property_latitude',$get_listing_edit,'numeric') ) ; ?>">
                    </div>
                <?php } ?>


                <?php if ( is_array($wpestate_submission_page_fields) && in_array('property_longitude', $wpestate_submission_page_fields) ) { ?>
                    <div class="col-md-6 ">
                        <label for="property_longitude"><?php esc_html_e('Longitude (for Google Maps)','wpresidence');?></label>
                        <input type="text" id="property_longitude" class="form-control" style="margin-right:20px;" size="40" name="property_longitude"
                        value="<?php print stripslashes(wpestate_submit_return_value('property_longitude',$get_listing_edit,'numeric') ) ; ?>">
                    </div>
                 <?php } ?>

                <?php if ( is_array($wpestate_submission_page_fields) && in_array('google_camera_angle', $wpestate_submission_page_fields) ) { ?>
                    <div class="col-md-6">
                        <label for="property_google_view"><?php esc_html_e('Enable Google Street View','wpresidence');?></label>
                        <input type="hidden"    name="property_google_view" value="">
                        <input type="checkbox"  id="property_google_view"  name="property_google_view" value="1" <?php print esc_html($google_view_check);?> >
                    </div></br>
                <?php } ?>


                <?php if ( is_array($wpestate_submission_page_fields) && in_array('property_google_view', $wpestate_submission_page_fields) ) { ?>
                    <div class="col-md-6 ">
                        <label for="google_camera_angle"><?php esc_html_e('Google Street View - Camera Angle (value from 0 to 360)','wpresidence');?></label>
                        <input type="text" id="google_camera_angle" class="form-control" style="margin-right:0px;" size="5" name="google_camera_angle"
                          value="<?php print stripslashes(wpestate_submit_return_value('google_camera_angle',$get_listing_edit,'') ) ; ?>">
                    </div>
                <?php } ?>



    </div>

<?php } ?>
