<?php
// Template Name: User Dashboard Invoices
// Wp Estate Pack
wpestate_dashboard_header_permissions();

$current_user                   =   wp_get_current_user();
$paid_submission_status         =   esc_html ( wpresidence_get_option('wp_estate_paid_submission','') );
$price_submission               =   floatval( wpresidence_get_option('wp_estate_price_submission','') );
$submission_curency_status      =   esc_html( wpresidence_get_option('wp_estate_submission_curency','') );
$userID                         =   $current_user->ID;
$curent_fav                     =    wpestate_return_favorite_listings_per_user();
$show_remove_fav                =   1;
$show_compare                   =   1;
$show_compare_only              =   'no';
$wpestate_currency              =   esc_html( wpresidence_get_option('wp_estate_currency_symbol', '') );
$where_currency                 =   esc_html( wpresidence_get_option('wp_estate_where_currency_symbol', '') );
$wpestate_options               =   wpestate_page_details($post->ID);
get_header();
?>



<div class="row row_user_dashboard">

    <?php  get_template_part('templates/dashboard-templates/dashboard-left-col');?>

    <div class="col-md-9 dashboard-margin">

        <?php
        wpestate_show_dashboard_title(get_the_title());
        ?>

        <div class="col-md-12 wpestate_dash_coluns">
          <div class="wpestate_dashboard_content_wrapper">
            <?php
            wpestate_dashboard_invoice_list();
            ?>
          </div>
        </div>
    </div>
</div>





<?php
$ajax_nonce = wp_create_nonce( "wpestate_invoices_actions" );
print ' <input type="hidden" id="wpestate_invoices_actions" value="'.esc_html($ajax_nonce).'" />';
get_footer(); ?>
