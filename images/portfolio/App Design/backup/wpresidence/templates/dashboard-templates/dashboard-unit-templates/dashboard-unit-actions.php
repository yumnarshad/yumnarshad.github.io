<?php
$edit_link                  =   wpestate_get_template_link('user_dashboard_add.php');
$list_link                  =   wpestate_get_template_link('user_dashboard.php');
$analytics_link             =   wpestate_get_template_link('user_dashboard_analytics.php');
$analytics_link             =   add_query_arg( 'analytics_id', $post_id, $analytics_link );
$featured_link              =   add_query_arg( 'featured_edit', $post_id, $list_link );
$duplicate_link             =   add_query_arg( 'duplicate', $post_id,  $list_link );

$edit_link                  =   esc_url_raw(add_query_arg( 'listing_edit', $post_id, $edit_link )) ;
$floor_link                 =   esc_url_raw(add_query_arg( 'floor_edit', $post_id,  $floor_link )) ;
$no_views                   =   intval( get_post_meta($post_id, 'wpestate_total_views', true));
$defaults = array(
               'echo'   => false,
           );
$post_status                =   get_post_status($post_id);

$paid_submission_status =    esc_html ( wpresidence_get_option('wp_estate_paid_submission','') );
$current_user           =   wp_get_current_user();
$userID                 =   $current_user->ID;
$user_pack              =   get_the_author_meta( 'package_id' , $userID );
$remaining_lists        =   wpestate_get_remain_listing_user($userID,$user_pack);

?>
<div class="btn-group">
  <button type="button" class="btn btn-default dropdown-toggle property_dashboard_actions_button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <?php esc_html_e('Actions','wpresidence');?> <span class="caret"></span>
  </button>
  <ul class="dropdown-menu ">
    <li>
      <a class="dashboad-tooltip" href="<?php  print esc_url($edit_link);?>">
        <?php esc_html_e('Edit property','wpresidence');?>
      </a>
    </li>
    <li>
      <a class="dashboad-tooltip" onclick="return confirm(' <?php echo esc_html__('Are you sure you wish to delete ','wpresidence').the_title_attribute($defaults); ?>?')" href="<?php print esc_url_raw(add_query_arg( 'delete_id', $post_id, wpestate_get_template_link('user_dashboard.php') ) );?>">
          <?php esc_html_e('Delete property','wpresidence');?>
      </a>
    </li>



    <?php

    if(  $paid_submission_status != 'membership'  || ( $paid_submission_status == 'membership' && $remaining_lists > 0 ) || ( $paid_submission_status == 'membership' && $remaining_lists ==-1 )) {
    ?>
    <li>
      <a class="dashboad-tooltip" href="<?php  print esc_url($duplicate_link);?>">
        <?php esc_html_e('Duplicate Property','wpresidence');?>
      </a>
    </li>
    <?php
      }else{
    ?>
    <li>
      <a  class="dashboad-tooltip not_"  href="#">
        <?php esc_html_e('Not enough listings to duplicate ','wpresidence');?>
      </a>
    </li>
  <?php
  }
  ?>
  <li>
    <a  class="dashboad-tooltip "  href="<?php print esc_url($analytics_link);?>">
      <?php esc_html_e('Views Stats','wpresidence');?>
    </a>
  </li>

    <?php
    if( $post_status == 'expired' ){ ?>
        <li><a  class="dashboad-tooltip resend_pending" data-listingid="<?php echo intval($post_id);?>">
          <?php esc_html_e('Resend for approval','wpresidence');?>
        </a></li>
    <?php
      }
    ?>

    <?php

    if ($paid_submission_status=='per listing'){
        if (strtolower($pay_status)=='paid') {
            if( intval(get_post_meta($post_id, 'prop_featured', true))==1){
              print '<li><a>'.esc_html__('Paid & Featured','wpresidence').'</a></li>';
            }else{
              print '<li><a href="" class="per_listing_payment" data-listingid="'. intval($post_id).'">'.esc_html__('Upgrade to Featured','wpresidence').'</a></li>';
            }
        }else{
          print '<li><a href="" class="per_listing_payment" data-listingid="'. intval($post_id).'">'.esc_html__('Pay','wpresidence').'</a></li>';
        }
    }
    ?>


    <?php
      if( $post_status == 'publish' ){ ?>
        <li><a href="#"  class="dashboad-tooltip disable_listing disabledx" data-postid="<?php echo intval($post_id);?>">
          <?php esc_html_e('Disable Listing','wpresidence');?>
        </a></li>
      <?php }else if($post_status=='disabled') { ?>
        <li> <a href="#"  class="dashboad-tooltip disable_listing" data-postid="<?php echo intval($post_id);?>" >
          <?php esc_html_e('Enable Listing','wpresidence');?>
        </a></li>
      <?php
      }
      ?>



      <?php
        $paid_submission_status     =   esc_html ( wpresidence_get_option('wp_estate_paid_submission','') );

       if($paid_submission_status=='membership'){

           if ( intval(get_post_meta($post_id, 'prop_featured', true))==1){
              //  print '<span class="label label-success">'.esc_html__('Property is featured','wpresidence').'</span>';
           }else{
             print '<li><a  data-original-title="'.esc_attr__('Set as featured,  *Listings set as featured are subtracted from your package','wpresidence').'" class="dashboad-tooltip make_featured" href="'.esc_url($featured_link).'" >'.esc_html__('Set as featured','wpresidence').'</a></li>';
           }
       }
       ?>



  </ul>
</div>
