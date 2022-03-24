<?php
global $edit_link;
global $token;
global $processor_link;
global $paid_submission_status;
global $submission_curency_status;
global $price_submission;
global $floor_link;
global $user_pack;
global $user_login;

$post_id                    =   get_the_ID();
$title                      =   get_the_title();
$featured                   =   intval  ( get_post_meta($post_id, 'prop_featured', true) );
$preview                    =   wp_get_attachment_image_src(get_post_thumbnail_id($post_id), 'widget_thumb');
$edit_link                  =   esc_url_raw(add_query_arg( 'listing_edit', $post_id, $edit_link )) ;
$floor_link                 =   esc_url_raw(add_query_arg( 'floor_edit', $post_id,  $floor_link )) ;
$post_status                =   get_post_status($post_id);
$status                     =   '';
$link                       =   get_permalink();
$pay_status                 =   '';
$is_pay_status              =   '';
$price_submission           =   floatval( wpresidence_get_option('wp_estate_price_submission','') );
$price_featured_submission  =   floatval( wpresidence_get_option('wp_estate_price_featured_submission','') );
$th_separator               =   stripslashes ( wpresidence_get_option('wp_estate_prices_th_separator','') );
$no_views                   =   intval( get_post_meta($post_id, 'wpestate_total_views', true));
$featured                   =   intval  ( get_post_meta($post_id, 'prop_featured', true) );
$free_feat_list_expiration  =   intval ( wpresidence_get_option('wp_estate_free_feat_list_expiration','') );
$pfx_date                   =   strtotime ( get_the_date("Y-m-d",  $post_id ) );
$expiration_date            =   $pfx_date+$free_feat_list_expiration*24*60*60;
$paid_submission_status     =    esc_html ( wpresidence_get_option('wp_estate_paid_submission','') );
$image_class=4;
if ($paid_submission_status=='per listing'){
  $image_class=3;
}


if( $preview[0] =='' ){
  $preview[0]=get_theme_file_uri('/img/default_listing_105.png');
}

?>



<div class="row property_wrapper_dash">
      <div class="blog_listing_image col-md-<?php echo esc_attr($image_class);?>">
         <?php
          // add featured label
          if($featured==1){
              print '<div class="featured_div">'.esc_html__('Featured','wpresidence').'</div>';
          }

        //  if (has_post_thumbnail($post_id)){
          ?>
              <a class="dashbard_unit_image" href="<?php print esc_url($link); ?>"><img  src="<?php  print esc_url($preview[0]); ?>" /></a>

              <div class="property_dashboard_location_wrapper">
                <a class="dashbard_unit_title" href="<?php print esc_url($link); ?>"><?php echo esc_html($title); ?></a>

                <div class="property_dashboard_location">
                    <?php
                     $property_location = get_the_term_list($post_id, 'property_city', '', ', ', '').', '. get_the_term_list($post_id, 'property_area', '', ', ', '');
                     print trim($property_location,',');
                     ?>
                </div>

                <div class="property_dashboard_status_unit">
                  <?php
                  if( !isset($is_dasboard_fav) ){
                    $paid_submission_status     =   esc_html ( wpresidence_get_option('wp_estate_paid_submission','') );
                    if ( $paid_submission_status=='membership' && $user_pack=='') {
                        if(!wpestate_check_if_developer_or_agency(get_the_author_meta('ID'))){
                            esc_html_e('Expires on ','wpresidence');echo date("Y-m-d",$expiration_date);
                        }
                    }
                  }
                  ?>
                </div>

              </div>
          <?php
        //  }
          ?>
      </div>


      <div class="col-md-2 property_dashboard_types">
          <?php
          $property_types          =   get_the_term_list($post_id, 'property_category', '', ', ', '').', '. get_the_term_list($post_id, 'property_action_category', '', ', ', '');
          print trim($property_types,',');
          ?>
      </div>


      <?php
        if ($paid_submission_status=='per listing'){ ?>
          <div class="col-md-2 property_dashboard_status"><?php include(locate_template('templates/dashboard-templates/dashboard-unit-templates/dashboard-unit-status.php')); ?></div>
          <div class="col-md-2 property_dashboard_status"><?php include(locate_template('templates/dashboard-templates/dashboard-unit-templates/dashboard-unit-paystatus.php')); ?></div>
          <div class="col-md-1 property_dashboard_price"><?php include(locate_template('templates/dashboard-templates/dashboard-unit-templates/dashboard-unit-price.php')); ?></div>

        <?php }else{ ?>
          <div class="col-md-2 property_dashboard_status"><?php include(locate_template('templates/dashboard-templates/dashboard-unit-templates/dashboard-unit-status.php')); ?></div>
          <div class="col-md-2 property_dashboard_price"><?php include(locate_template('templates/dashboard-templates/dashboard-unit-templates/dashboard-unit-price.php')); ?></div>

        <?php }
      ?>

      <div class="col-md-2 property_dashboard_action">
        <?php
        if( !isset($is_dasboard_fav) ){
          include(locate_template('templates/dashboard-templates/dashboard-unit-templates/dashboard-unit-actions.php'));
        }else{
          print '<div class="remove_fav_dash  wpresidence_button " data-postid="'.intval($post->ID).'"  >'.esc_html__('Remove From Favorites','wpresidence').'</div>';
        }?></div>



<?php include(locate_template('templates/dashboard-templates/dashboard-unit-templates/per_listing_pay.php')); ?>

</div>
