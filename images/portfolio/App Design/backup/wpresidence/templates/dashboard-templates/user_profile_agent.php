<?php
$current_user           =   wp_get_current_user();
$userID                 =   $current_user->ID;
$user_login             =   $current_user->user_login;
$agent_id               =   get_the_author_meta('user_agent_id',$userID);
$agent_custom_data      =   get_post_meta($agent_id, 'agent_custom_data', true);
$author = get_post_field( 'post_author', $agent_id );
$agency_post = get_the_author_meta('user_agent_id',$author);
$agency_post_type = get_post_type($agency_post) ;


$agent_contact_information_fields=array(
  'firstname' => array(
                  'label' =>  esc_html__('First Name','wpresidence'),
                   'meta_name' =>  'first_name',
                   'type' =>  'post_meta',
                ),
  'secondname' => array(
                  'label' =>  esc_html__('Last Name','wpresidence'),
                   'meta_name' =>  'last_name',
                   'type' =>  'post_meta',
                ),
  'userphone' => array(
                  'label' =>  esc_html__('Phone','wpresidence'),
                  'meta_name' =>  'agent_phone',
                  'type' =>  'post_meta',
                ),
  'useremail' => array(
                  'label' =>  esc_html__('Email','wpresidence'),
                  'bypass'=>$userID,
                  'meta' =>  'user_email',
                  'type' =>  'user_meta',
                ),
  'usermobile' => array(
                    'label' =>  esc_html__('Mobile','wpresidence'),
                    'meta_name' =>  'agent_mobile',
                    'type' =>  'post_meta',
                  ),
  'userskype' => array(
                  'label' =>  esc_html__('Skype','wpresidence'),
                  'meta_name' =>  'agent_skype',
                  'type' =>  'post_meta',
                ),

  'agent_member' => array(
                  'label' =>  esc_html__('Member of','wpresidence'),
                  'meta_name' =>  'agent_member',
                  'type' =>  'post_meta',
                ),
);

if(wpresidence_get_option('wp_estate_enable_hubspot_integration_for_all','')=='yes' && $agency_post_type!='estate_agency' && $agency_post_type!='estate_developer'){
  $agent_contact_information_fields[ 'hubspot_api'] =  array(
                                            'label' =>  esc_html__('HubSpot Api Key','wpresidence'),
                                            'meta_name' =>  'hubspot_api',
                                            'type' =>  'post_meta',
                                          );
}


$agent_social_information_fields=array(
  'userfacebook' => array(
                  'label' =>  esc_html__('Facebook Url','wpresidence'),
                   'meta_name' =>  'agent_facebook',
                   'type' =>  'post_meta',
                ),
  'userinstagram' => array(
                    'label' =>  esc_html__('Instagram Url','wpresidence'),
                     'meta_name' =>  'agent_instagram',
                     'type' =>  'post_meta',
                  ),
  'usertwitter' => array(
                    'label' =>  esc_html__('Twitter Url','wpresidence'),
                     'meta_name' =>  'agent_twitter',
                     'type' =>  'post_meta',
                  ),
  'userpinterest' => array(
                    'label' =>  esc_html__('Pinterest Url','wpresidence'),
                     'meta_name' =>  'agent_pinterest',
                     'type' =>  'post_meta',
                  ),
  'userlinkedin' => array(
                    'label' =>  esc_html__('Linkedin Url','wpresidence'),
                     'meta_name' =>  'agent_linkedin',
                     'type' =>  'post_meta',
                  ),
    'website' => array(
                'label' =>  esc_html__('Website Url (without http)', 'wpresidence'),
                'meta_name' =>  'agent_website',
                'type' =>  'post_meta',
              ),

);


$agent_location_fields = array(
  'agent_city' => array(
                  'label' =>  esc_html__('City','wpresidence'),
                  'meta' =>  'last_name',
                  'type' =>  'taxonomy_name',
                  'tax_name'=>'property_city_agent'
                ),
  'agent_county' => array(
                  'label' =>  esc_html__('State/County','wpresidence'),
                  'meta' =>  'last_name',
                  'type' =>  'taxonomy_name',
                  'tax_name'=>'property_county_state_agent'
                ),
  'agent_area' => array(
                  'label' =>  esc_html__('Area','wpresidence'),
                  'meta' =>  'last_name',
                  'type' =>  'taxonomy_name',
                  'tax_name'=>'property_area_agent'
                ),
);



$agent_about_details_fields= array(

  'usertitle' => array(
                  'label' =>  esc_html__('Title/Position','wpresidence'),
                   'meta_name' =>  'agent_position',
                   'type' =>  'post_meta',
                   'bootstral_length'=>12,
                  ),
    'about_me' => array(
                    'label' =>  esc_html__('About Me','wpresidence'),
                     'meta' =>  'about_me',
                     'inputype'=>'textarea',
                     'type' =>  'wpestate_description',
                      'bootstral_length'=>12,
                    ),
);

$user_email             =   get_the_author_meta( 'user_email' , $userID );
$user_title             =   get_the_author_meta( 'title' , $userID );
$user_small_picture     =   get_the_author_meta( 'small_custom_picture' , $userID );
$image_id               =   get_the_author_meta( 'small_custom_picture',$userID);
$user_custom_picture    =   get_the_post_thumbnail_url($agent_id,'user_picture_profile');
$agent_id              =   get_the_author_meta('user_agent_id',$userID);
$first_name            =   esc_html(get_post_meta($agent_id, 'first_name', true));
$last_name             =   esc_html(get_post_meta($agent_id, 'last_name', true));
$agent_title           =   get_the_title($agent_id);
$agent_description     =   get_post_field('post_content', $agent_id);
$agent_email           =   esc_html(get_post_meta($agent_id, 'agent_email', true));
$agent_phone           =   esc_html(get_post_meta($agent_id, 'agent_phone', true));
$agent_mobile          =   esc_html(get_post_meta($agent_id, 'agent_mobile', true));
$agent_skype           =   esc_html(get_post_meta($agent_id, 'agent_skype', true));
$agent_facebook        =   esc_html(get_post_meta($agent_id, 'agent_facebook', true));
$agent_twitter         =   esc_html(get_post_meta($agent_id, 'agent_twitter', true));
$agent_linkedin        =   esc_html(get_post_meta($agent_id, 'agent_linkedin', true));
$agent_pinterest       =   esc_html(get_post_meta($agent_id, 'agent_pinterest', true));
$agent_instagram       =   esc_html(get_post_meta($agent_id, 'agent_instagram', true));
$agent_address         =   esc_html(get_post_meta($agent_id, 'agent_address', true));
$agent_languages       =   esc_html(get_post_meta($agent_id, 'agent_languages', true));
$agent_license         =   esc_html(get_post_meta($agent_id, 'agent_license', true));
$agent_taxes           =   esc_html(get_post_meta($agent_id, 'agent_taxes', true));
$agent_lat             =   esc_html(get_post_meta($agent_id, 'agent_lat', true));
$agent_long            =   esc_html(get_post_meta($agent_id, 'agent_long', true));
$agent_website         =   esc_html(get_post_meta($agent_id, 'agent_website', true));
$agent_member          =   esc_html(get_post_meta($agent_id, 'agent_member', true));
$agent_position        =   esc_html(get_post_meta($agent_id, 'agent_position', true));



$agent_city='';
$agent_city_array     =   get_the_terms($agent_id, 'property_city_agent');
if(isset($agent_city_array[0])){
    $agent_city         =   $agent_city_array[0]->name;
}

$agent_area='';
$agent_area_array     =   get_the_terms($agent_id, 'property_area_agent');
if(isset($agent_area_array[0])){
    $agent_area          =   $agent_area_array[0]->name;
}

$agent_county='';
$agent_county_array     =   get_the_terms($agent_id, 'property_county_state_agent');
if(isset($agent_county_array[0])){
    $agent_county          =   $agent_county_array[0]->name;
}


if($user_custom_picture==''){
    $user_custom_picture=get_theme_file_uri('/img/default_user.png');
}
$user_agent_id          =   intval( get_user_meta($userID,'user_agent_id',true));
?>


<div class="col-md-8 user_profile_div ">
    <div class="wpestate_dashboard_content_wrapper">
        <div id="profile_message"></div>
          <div class="add-estate profile-page profile-onprofile row">
            <div class="wpestate_dashboard_section_title"><?php esc_html_e('Contact Information','wpresidence');?></div>
              <?php  print wpestate_dashnoard_display_form_fields($agent_contact_information_fields,$agent_id);  ?>
              <?php   wp_nonce_field( 'profile_ajax_nonce', 'security-profile' );   ?>
          </div>
    </div>

    <div class="wpestate_dashboard_content_wrapper">
      <div class="add-estate profile-page profile-onprofile row">
        <div class="wpestate_dashboard_section_title"><?php esc_html_e('Social Information','wpresidence');?></div>
        <?php  print wpestate_dashnoard_display_form_fields($agent_social_information_fields,$agent_id);  ?>
      </div>


      <div class="add-estate profile-page profile-onprofile row">
            <div class="wpestate_dashboard_section_title"><?php esc_html_e('Agent Area/Categories','wpresidence');?></div>
            <div class="col-md-6 ">
                <p>
                    <label for="agent_city"><?php esc_html_e('Category','wpresidence');?></label>


                <?php
                $agent_action_selected      =   '';
                $agent_action_array         =   get_the_terms($agent_id, 'property_action_category_agent');
                if(isset($agent_action_array[0])){
                    $agent_action_selected   =   $agent_action_array[0]->term_id;
                }

                $agent_category_selected    =   '';
                $agent_category_array       =   get_the_terms($agent_id, 'property_category_agent');
                if(isset($agent_category_array[0])){
                  $agent_category_selected   =   $agent_category_array[0]->term_id;
                }



                    $args=array(
                        'class'       => 'select-submit2',
                        'hide_empty'  => false,
                        'selected'    => $agent_category_selected,
                        'name'        => 'agent_category_submit',
                        'id'          => 'agent_category_submit',
                        'orderby'     => 'NAME',
                        'order'       => 'ASC',
                        'show_option_none'   => esc_html__('None','wpresidence'),
                        'taxonomy'    => 'property_category_agent',
                        'hierarchical'=> true
                    );
                    wp_dropdown_categories( $args ); ?>

                </p>
            </div>
          <div class="col-md-6 ">
                <p>
                  <label for="agent_city"><?php esc_html_e('Action Category','wpresidence');?></label>
                 <?php
                  $args=array(
                      'class'       => 'select-submit2',
                      'hide_empty'  => false,
                      'selected'    => $agent_action_selected,
                      'name'        => 'agent_action_submit',
                      'id'          => 'agent_action_submit',
                      'orderby'     => 'NAME',
                      'order'       => 'ASC',
                      'show_option_none'   => esc_html__('None','wpresidence'),
                      'taxonomy'    => 'property_action_category_agent',
                      'hierarchical'=> true
                  );
                  wp_dropdown_categories( $args ); ?>

              </p>
          </div>
      </div>



      <div class="add-estate profile-page profile-onprofile row">
        <div class="wpestate_dashboard_section_title"><?php esc_html_e('Agent Custom Data','wpresidence');?></div>
        <div class="add_custom_data_cont">
             <div class="cliche_row">
                <div class="col-md-5">
                    <label for="agent_custom_label"><?php esc_html_e('Parameter Label','wpresidence');?></label>
                    <input type="text"  class="form-control agent_custom_label" value=""  name="agent_custom_label[]">
                </div>
                <div class="col-md-5">
                    <label for="agent_custom_value"><?php esc_html_e('Parameter Value','wpresidence');?></label>
                    <input type="text"  class="form-control agent_custom_value" value=""  name="agent_custom_value[]">
                </div>
                <div class="col-md-2">
                    <button type="button" class="wpresidence_button remove_parameter_button"  ><?php esc_html_e('Remove','wpresidence');?></button>
                </div>
            </div>




            <?php
            if( is_array( $agent_custom_data) && count( $agent_custom_data )  > 0   ){
              for( $i=0; $i<count( $agent_custom_data ); $i++ ){
                ?>
                  <div class="single_parameter_row">
                     <div class="col-md-5">
                          <label for="agent_custom_label"><?php esc_html_e('Parameter Label','wpresidence');?></label>
                          <input type="text"  class="form-control agent_custom_label" value="<?php print esc_html($agent_custom_data[$i]['label']);?>"   >
                      </div>
                      <div class="col-md-5">
                          <label for="agent_custom_value"><?php esc_html_e('Parameter Value','wpresidence');?></label>
                          <input type="text"  class="form-control agent_custom_value" value="<?php print esc_html($agent_custom_data[$i]['value']);?>"  name="agent_custom_value[]">
                      </div>
                      <div class="col-md-2">
                          <button type="button" class="wpresidence_button remove_parameter_button"  ><?php esc_html_e('Remove','wpresidence');?></button>
                      </div>
                  </div>
              <?php
              }
            }
            ?>
            <button type="button" class="wpresidence_button add_custom_parameter"  ><?php esc_html_e('Add Custom Field','wpresidence');?></button>
        </div>
      </div>

      <div class="add-estate profile-page profile-onprofile row">
          <div class="wpestate_dashboard_section_title"><?php esc_html_e('Agent Location','wpresidence');?></div>
          <?php  print wpestate_dashnoard_display_form_fields($agent_location_fields,$agent_id);  ?>
      </div>

      <div class="add-estate profile-page profile-onprofile row">
          <div class="wpestate_dashboard_section_title"><?php esc_html_e('Agent Details','wpresidence');?></div>
          <?php  print wpestate_dashnoard_display_form_fields($agent_about_details_fields,$agent_id);  ?>
      </div>





    <div class="add-estate profile-page profile-onprofile row">
        <button class="wpresidence_button" id="update_profile"><?php esc_html_e('Update profile', 'wpresidence'); ?></button>

        <?php
        $ajax_nonce = wp_create_nonce( "wpestate_update_profile_nonce" );
        print'<input type="hidden" id="wpestate_update_profile_nonce" value="'.esc_html($ajax_nonce).'" />    ';

        $user_agent_id          =   intval( get_user_meta($userID,'user_agent_id',true));
        if ( $user_agent_id!=0 && get_post_status($user_agent_id)=='publish'  ){
            print'<a href='. esc_url ( get_permalink($user_agent_id) ).' class="wpresidence_button view_public_profile">'.esc_html__('View public profile', 'wpresidence').'</a>';
        }
        ?>

        <button class="wpresidence_button" id="delete_profile"><?php esc_html_e('Delete profile', 'wpresidence'); ?></button>
    </div>

    </div>




</div>




<div class="col-md-4 user-profile-dashboard-wrapper">
    <div class="wpestate_dashboard_content_wrapper">
      <div class="add-estate profile-page profile-onprofile row">
          <div class="wpestate_dashboard_section_title"><?php esc_html_e('Photo','wpresidence');?></div>
          <div class="profile_div" id="profile-div">
              <?php print '<img id="profile-image" src="'.esc_url($user_custom_picture).'" alt="'.esc_html__('user image','wpresidence').'" data-profileurl="'.esc_attr($user_custom_picture).'" data-smallprofileurl="'.esc_attr($image_id).'" >';?>

              <div id="upload-container">
                  <div id="aaiu-upload-container">
                      <button id="aaiu-uploader" class="wpresidence_button wpresidence_success"><?php esc_html_e('Upload  profile image.','wpresidence');?></button>
                      <div id="aaiu-upload-imagelist">
                          <ul id="aaiu-ul-list" class="aaiu-upload-list"></ul>
                      </div>
                  </div>
              </div>
              <div id="imagelist-profile"></div>
              <span class="upload_explain"><?php esc_html_e('*minimum 500px x 500px','wpresidence');?></span>
          </div>
      </div>
    </div>
</div>



















    <?php
    if ( wp_is_mobile() ) {
        echo '<div class="add-estate profile-page profile-onprofile">';

            if ( $user_agent_id!=0 && get_post_status($user_agent_id)=='pending'  ){
                echo '<div class="user_dashboard_app">'.esc_html__('Your account is pending approval. Please wait for admin to approve it. ','wpresidence').'</div>';
            }
            if ( $user_agent_id!=0 && get_post_status($user_agent_id)=='disabled' ){
                echo '<div class="user_dashboard_app">'.esc_html__('Your account is disabled.','wpresidence').'</div>';
            }

        echo '</div>';

    }
    ?>




    <div class="col-md-8 change_pass_wrapper">
      <div class="wpestate_dashboard_content_wrapper">
          <?php   get_template_part('templates/dashboard-templates/change_pass_template'); ?>
      </div>
    </div>

</div>
