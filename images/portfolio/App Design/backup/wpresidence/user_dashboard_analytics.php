<?php
// Template Name: User Dashboard Stats
// Wp Estate Pack
wpestate_dashboard_header_permissions();


$current_user                   =   wp_get_current_user();
$userID                         =   $current_user->ID;
$user_login                     =   $current_user->user_login;
$agent_list                     =  (array)get_user_meta($userID, 'current_agent_list', true);
$agent_list[]           =   $current_user->ID;
$user_agent_id          =   intval(get_user_meta($userID, 'user_agent_id', true));
$status                 =   get_post_status($user_agent_id);

if ($status==='pending' || $status==='disabled') {
    wp_redirect(esc_url(home_url('/')));
    exit;
}

$analytics_id=0;
if(isset($_GET['analytics_id']) ){
  $analytics_id=intval($_GET['analytics_id']);
}

$author_id           =  wpsestate_get_author($analytics_id);

if( !in_array( $author_id,$agent_list) ){
  wp_redirect(esc_url(home_url('/')));
  exit;
}

get_header();

?>



<div class="row row_user_dashboard">

    <?php  get_template_part('templates/dashboard-templates/dashboard-left-col');?>

    <div class="col-md-9 dashboard-margin">

        <?php
        $title         = esc_html__('Analytics', 'wpresidence');
        wpestate_show_dashboard_title($title, '','');
        $agent_list[]   =   $current_user->ID;
        ?>

        <div class="col-md-12 wpestate_dash_coluns">
          <div class="wpestate_dashboard_content_wrapper">


            <?php
            $no_views                   =   intval( get_post_meta($analytics_id, 'wpestate_total_views', true));
            if($analytics_id > 0){ ?>


                <div class="statistics_wrapper_dashboard">

                  <a href="<?php echo esc_url( wpestate_get_template_link('user_dashboard.php') );?>" class="back_prop_list"><?php esc_html_e('Back to properties list','wpresidence');?></a>

                  <div class="statistics_wrapper_total_views">
                      <?php esc_html_e('Total number of views:','wpresidence'); echo ' '.esc_html($no_views); ?>
                  </div>

                  <canvas class="my_chart_dash" id="myChart_<?php echo esc_html($analytics_id);?>"></canvas>
                </div>
            <?php } ?>




          </div>
        </div>

    </div>
</div>



<script type="text/javascript">
  //<![CDATA[
    jQuery(document).ready(function(){
        wpestate_load_stats(<?php print intval($analytics_id); ?>);
    });
  //]]>
</script>


























<?php

$ajax_nonce = wp_create_nonce("wpestate_tab_stats");
$ajax_nonce1 = wp_create_nonce("wpestate_property_actions");
print ' <input type="hidden" id="wpestate_tab_stats" value="'.esc_html($ajax_nonce).'" />';
print ' <input type="hidden" id="wpestate_property_actions" value="'.esc_html($ajax_nonce1).'" />';
get_footer();
