<?php
// Template Name: User Dashboard Main
// Wp Estate Pack
wpestate_dashboard_header_permissions();
get_header();
$current_user                   =   wp_get_current_user();
$userID                         =   $current_user->ID;
$user_login                     =   $current_user->user_login;
$agent_list                     =  (array)get_user_meta($userID, 'current_agent_list', true);
?>

<div class="row row_user_dashboard">
    <?php  get_template_part('templates/dashboard-templates/dashboard-left-col'); ?>
    <div class="col-md-9 dashboard-margin">

        <?php
        $agent_list[]   =   $current_user->ID;
        wpestate_show_dashboard_title(get_the_title());
        ?>

        <div class="col-md-8 wpestate_dashboard_holder">
          <?php
            print wpestate_dashboard_account_summary($userID,$agent_list);
            print wpestate_dashboard_widget_top_ten($agent_list);
            print wpestate_dashboard_widget_top_ten_contacted($agent_list);
            print wpestate_display_total_visits_listings();
            ?>
        </div>

        <div class="col-md-4 wpestate_dashboard_holder">
          <?php print wpestate_dashboard_widget_history($agent_list); ?>
        </div>


        </div>
    </div>
</div>


<?php get_footer(); ?>
