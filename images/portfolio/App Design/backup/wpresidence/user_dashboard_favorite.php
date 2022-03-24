<?php
// Template Name: User Dashboard Favorite
// Wp Estate Pack
wpestate_dashboard_header_permissions();
$current_user   = wp_get_current_user();
$curent_fav     = wpestate_return_favorite_listings_per_user();
$is_dasboard_fav= true;
get_header();
$wpestate_options=wpestate_page_details($post->ID);



?>

<div class="row row_user_dashboard">

    <?php  get_template_part('templates/dashboard-templates/dashboard-left-col'); ?>

    <div class="col-md-9 dashboard-margin">
        <?php
        wpestate_show_dashboard_title(get_the_title());
        $agent_list[]   =   $current_user->ID;
        ?>

        <div class="col-md-12 wpestate_dash_coluns">
          <div class="wpestate_dashboard_content_wrapper">
            <?php
              $order_by       = '';
              if(isset($_GET['orderby'])){
                $order_by       = intval($_GET['orderby']);
              }
              $status_value='';
              if(isset($_GET['status'])){
                $status_value   = intval($_GET['status']);
              }


              print '<div class="wpestate_dashboard_table_list_header row">';
                    print '<div class="col-md-4">'.esc_html__('Property','wpresidence').'</div>';
                    print '<div class="col-md-2">'.esc_html__('Category','wpresidence').'</div>';
                    print '<div class="col-md-2">'.esc_html__('Status','wpresidence').'</div>';
                    print '<div class="col-md-2">'.esc_html__('Price','wpresidence').'</div>';
                    print '<div class="col-md-2">'.esc_html__('Actions','wpresidence').'</div>';
                  print'</div>';


              if( !empty($curent_fav)){
                   $args = array(
                       'post_type'        => 'estate_property',
                       'post_status'      => 'publish',
                       'posts_per_page'   => -1 ,
                       'post__in'         => $curent_fav
                   );


                   $prop_selection = new WP_Query($args);



                   while ($prop_selection->have_posts()): $prop_selection->the_post();
                      include( locate_template('templates/dashboard-templates/dashboard_listing_unit.php'));
                   endwhile;

              }else{

                  print '<h4>'.esc_html__('You don\'t have any favorite properties yet!','wpresidence').'</h4>';

              }
            ?>
          </div>
        </div>
    </div>
</div>


<?php get_footer(); ?>
