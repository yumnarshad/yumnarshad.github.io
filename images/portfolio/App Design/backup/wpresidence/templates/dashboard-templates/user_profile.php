<?php
$current_user           =   wp_get_current_user();
$userID                 =   $current_user->ID;
$user_login             =   $current_user->user_login;
$description            =   get_the_author_meta( 'description' , $userID );
$agent_custom_data      =   get_the_author_meta( 'agent_custom_data' , $userID );
$user_custom_picture    =   get_the_author_meta( 'custom_picture' , $userID );
$user_small_picture     =   get_the_author_meta( 'small_custom_picture' , $userID );
$image_id               =   get_the_author_meta( 'small_custom_picture',$userID);
$about_me               =   get_the_author_meta( 'description' , $userID );
if($user_custom_picture==''){
    $user_custom_picture=get_theme_file_uri('/img/default_user.png');
}


$contact_information_fields=array(
  'firstname' => array(
                  'label' =>  esc_html__('First Name','wpresidence'),
                   'meta' =>  'first_name',
                   'type' =>  'user_meta',
                ),
  'secondname' => array(
                  'label' =>  esc_html__('Last Name','wpresidence'),
                  'meta' =>  'last_name',
                  'type' =>  'user_meta',
                ),
  'useremail' => array(
                  'label' =>  esc_html__('Email','wpresidence'),
                  'meta' =>  'user_email',
                  'type' =>  'user_meta',
                ),
  'userphone' => array(
                  'label' =>  esc_html__('Phone','wpresidence'),
                  'meta' =>  'phone',
                  'type' =>  'user_meta',
                ),
  'usermobile' => array(
                  'label' =>  esc_html__('Mobile','wpresidence'),
                  'meta' =>  'mobile',
                  'type' =>  'user_meta',
                ),
  'userskype' => array(
                  'label' =>  esc_html__('Skype','wpresidence'),
                  'meta' =>  'skype',
                  'type' =>  'user_meta',
                ),
);


$social_media_information_fields=array(
  'userfacebook' => array(
                'label' =>  esc_html__('Facebook Url','wpresidence'),
                 'meta' =>  'facebook',
                 'type' =>  'user_meta',
              ),
  'usertwitter' => array(
                  'label' =>  esc_html__('Twitter Url','wpresidence'),
                   'meta' =>  'twitter',
                   'type' =>  'user_meta',
                ),
  'userlinkedin' => array(
                  'label' =>  esc_html__('Linkedin Url','wpresidence'),
                   'meta' =>  'linkedin',
                   'type' =>  'user_meta',
                ),
  'userinstagram' => array(
                  'label' =>  esc_html__('Instagram Url','wpresidence'),
                   'meta' =>  'instagram',
                   'type' =>  'user_meta',
                ),
  'userpinterest' => array(
                  'label' =>  esc_html__('Pinterest Url','wpresidence'),
                   'meta' =>  'pinterest',
                   'type' =>  'user_meta',
                ),

  'website' => array(
                'label' =>  esc_html__('Website Url (without http)','wpresidence'),
                 'meta' =>  'website',
                 'type' =>  'user_meta',
              ),

);

$user_details_information_fields=array(
  'usertitle' => array(
                'label' =>  esc_html__('Title/Position','wpresidence'),
                 'meta' =>  'title',
                 'type' =>  'user_meta',
              ),
);

?>





<div class="col-md-8 user_profile_div ">
    <div class="wpestate_dashboard_content_wrapper">

      <div id="profile_message"></div>

      <div class="add-estate profile-page profile-onprofile row">
        <div class="wpestate_dashboard_section_title"><?php esc_html_e('Contact Information','wpresidence');?></div>
        <?php  print wpestate_dashnoard_display_form_fields($contact_information_fields,$userID);  ?>
        <?php  wp_nonce_field( 'profile_ajax_nonce', 'security-profile' );   ?>
      </div>

      <div class="add-estate profile-page profile-onprofile row">
          <div class="wpestate_dashboard_section_title"><?php esc_html_e('Social Media','wpresidence');?></div>
          <?php  print wpestate_dashnoard_display_form_fields($social_media_information_fields,$userID);  ?>
      </div>

      <div class="add-estate profile-page profile-onprofile row">

              <div class="wpestate_dashboard_section_title"><?php esc_html_e('User Details','wpresidence');?></div>

               <?php  print wpestate_dashnoard_display_form_fields($user_details_information_fields,$userID);  ?>

              <p class="fullp-button">
                  <button class="wpresidence_button" id="update_profile"><?php esc_html_e('Update profile', 'wpresidence'); ?></button>
                  <button class="wpresidence_button" id="delete_profile"><?php esc_html_e('Delete profile', 'wpresidence'); ?></button>
                  <?php
                  $ajax_nonce = wp_create_nonce( "wpestate_update_profile_nonce" );
                  print'<input type="hidden" id="wpestate_update_profile_nonce" value="'.esc_html($ajax_nonce).'" />    ';
                  ?>
              </p>

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


<div class="col-md-8 change_pass_wrapper">
  <div class="wpestate_dashboard_content_wrapper">
      <?php   get_template_part('templates/dashboard-templates/change_pass_template'); ?>
  </div>
</div>
