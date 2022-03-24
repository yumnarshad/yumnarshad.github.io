<?php
// Template Name: User Dashboard
// Wp Estate Pack
wpestate_dashboard_header_permissions();


$current_user                   =   wp_get_current_user();
$userID                         =   $current_user->ID;
$user_login                     =   $current_user->user_login;
$user_pack                      =   get_the_author_meta('package_id', $userID);
$user_registered                =   get_the_author_meta('user_registered', $userID);
$user_package_activation        =   get_the_author_meta('package_activation', $userID);
$paid_submission_status         =   esc_html(wpresidence_get_option('wp_estate_paid_submission', ''));
$price_submission               =   floatval(wpresidence_get_option('wp_estate_price_submission', ''));
$submission_curency_status      =   esc_html(wpresidence_get_option('wp_estate_submission_curency', ''));
$edit_link                      =   wpestate_get_template_link('user_dashboard_add.php');
$processor_link                 =   wpestate_get_template_link('processor.php');
$agent_list                     =  (array)get_user_meta($userID, 'current_agent_list', true);
$user_pack                      =   get_the_author_meta( 'package_id' , $userID );
$remaining_lists                =   wpestate_get_remain_listing_user($userID,$user_pack);

$user_agent_id          =   intval(get_user_meta($userID, 'user_agent_id', true));
$status                 =   get_post_status($user_agent_id);

if ($status==='pending' || $status==='disabled') {
    wp_redirect(esc_url(home_url('/')));
    exit;
}

if (isset($_GET['featured_edit'])) {
    wpestate_make_featured_dashboard($_GET['featured_edit']);
}


if (isset($_GET['delete_id'])) {
    wpestate_delete_listing_dashboard($_GET['delete_id'], $current_user, $agent_list);
}

if (isset($_GET['duplicate']) && intval($_GET['duplicate'])!=0) {

    if(  $paid_submission_status != 'membership'  || ( $paid_submission_status == 'membership' && $remaining_lists > 0 ) || ( $paid_submission_status == 'membership' && $remaining_lists ==-1 )  ) {
      wpestate_duplicate_listing($_GET['duplicate']);
    }
}

get_header();
?>



<div class="row row_user_dashboard">

    <?php  get_template_part('templates/dashboard-templates/dashboard-left-col');?>

    <div class="col-md-9 dashboard-margin">

        <?php
        wpestate_show_dashboard_title(get_the_title());
        $agent_list[]   =   $current_user->ID;
        ?>

        <div class="col-md-12 wpestate_dash_coluns">
          <div class="wpestate_dashboard_content_wrapper dashboard_property_list">
            <?php
              $status_value='';
              $order_by='3';
              if (isset($_GET['orderby'])) {
                  $order_by       = intval($_GET['orderby']);
              }
              if (isset($_GET['status'])) {
                  $status_value   = intval($_GET['status']);
              }
              wpestate_dashboard_property_list($agent_list, $order_by, $status_value);
            ?>
          </div>
        </div>
    </div>
</div>


<?php
$ajax_nonce = wp_create_nonce("wpestate_tab_stats");
$ajax_nonce1 = wp_create_nonce("wpestate_property_actions");
print ' <input type="hidden" id="wpestate_tab_stats" value="'.esc_html($ajax_nonce).'" />';
print ' <input type="hidden" id="wpestate_property_actions" value="'.esc_html($ajax_nonce1).'" />';

$ajax_nonce = wp_create_nonce( "wpresidence_simple_pay_actions_nonce" );
print'<input type="hidden" id="wpresidence_simple_pay_actions_nonce" value="'.esc_html($ajax_nonce).'" />    ';

get_footer();
