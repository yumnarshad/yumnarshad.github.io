<?php
// Template Name: User Dashboard Inbox
// Wp Estate Pack
wpestate_dashboard_header_permissions();

$current_user       = wp_get_current_user();
$dash_profile_link  = wpestate_get_template_link('user_dashboard_profile.php');

get_header();
$wpestate_options    =   wpestate_page_details($post->ID);
$user_role  =   get_user_meta( $current_user->ID, 'user_estate_role', true) ;
$userID     =   $current_user->ID;
?>


<div class="row row_user_dashboard">

    <?php  get_template_part('templates/dashboard-templates/dashboard-left-col');?>

    <div class="col-md-9 dashboard-margin">

        <?php
        wpestate_show_dashboard_title(get_the_title());
        ?>

        <div class="col-md-12 wpestate_dash_coluns">
          <div class="wpestate_dashboard_content_wrapper">
            <div class="wpestate_dashboard_section_title inbox_title">
                <?php
                $no_unread=  intval(get_user_meta($userID,'unread_mess',true));
                echo esc_html__('You have','wpresidence').' '.intval($no_unread).' '.esc_html__('unread messages','wpresidence');
                ?>
            </div>

              <?php
              print wpestate_dashboard_inbox_list($userID);
              ?>

          </div>
        </div>
    </div>
</div>


<?php
$ajax_nonce = wp_create_nonce( "wpestate_inbox_actions" );
print ' <input type="hidden" id="wpestate_inbox_actions" value="'.esc_html($ajax_nonce).'" />';

get_footer(); ?>
