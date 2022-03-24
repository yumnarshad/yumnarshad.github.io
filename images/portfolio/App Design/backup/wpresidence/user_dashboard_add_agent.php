<?php
// Template Name: User Dashboard Add agent
// Wp Estate Pack
wpestate_dashboard_header_permissions();
$current_user       =   wp_get_current_user();
$userID             =   $current_user->ID;
$user_role          =   get_user_meta( $current_user->ID, 'user_estate_role', true) ;
$user_agent_id      =   intval(get_user_meta($userID, 'user_agent_id', true));
$status             =   get_post_status($user_agent_id);

get_header();
$wpestate_options    =   wpestate_page_details($post->ID);

if($user_role!=3 && $user_role !=4){
    wp_redirect(   esc_url(home_url('/')) );exit;
}

if ($status==='pending' || $status==='disabled') {
    wp_redirect(esc_url(home_url('/')));
    exit;
}
global $listing_edit;
global $is_edit;

//edit
$listing_edit=0;
$is_edit=0;
if(isset($_GET['listing_edit'])){
    $listing_edit=intval($_GET['listing_edit']);
    $is_edit=1;
}
?>

<div class="row row_user_dashboard">

  <?php  get_template_part('templates/dashboard-templates/dashboard-left-col'); ?>

    <div class="col-md-9 dashboard-margin">
        <?php
            wpestate_show_dashboard_title(get_the_title());
        ?>

        <?php include( locate_template('templates/dashboard-templates/add_new_agent_template.php') ); ?>

    </div>
</div>
<?php get_footer(); ?>
