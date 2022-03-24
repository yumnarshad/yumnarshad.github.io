<?php
// Template Name: User Dashboard Agent List
// Wp Estate Pack
wpestate_dashboard_header_permissions();

if (   isset( $_POST['dashboard_agent_search_nonce'] )  && ! wp_verify_nonce( $_POST['dashboard_agent_search_nonce'], 'dashboard_agent_search' ) ) {
    esc_html_e('Sorry, your nonce did not verify.','wpresidence');
    exit;
}

$current_user                   =   wp_get_current_user();
$userID                         =   $current_user->ID;
$user_login                     =   $current_user->user_login;
$user_registered                =   get_the_author_meta( 'user_registered' , $userID );
$edit_link                      =   wpestate_get_template_link('user_dashboard_agent_list.php');
$user_role              =   get_user_meta( $current_user->ID, 'user_estate_role', true) ;
$user_agent_id          =   intval(get_user_meta($userID, 'user_agent_id', true));
$status                 =   get_post_status($user_agent_id);


if($user_role!=3 && $user_role !=4){
    wp_redirect(   esc_url(home_url('/')) );exit;
}

if ($status==='pending' || $status==='disabled') {
    wp_redirect(esc_url(home_url('/')));
    exit;
}


if( isset( $_GET['delete_id'] ) ) {
    if( !is_numeric($_GET['delete_id'] ) ){
        exit('you don\'t have the right to delete this');
    }else{
        $delete_id  =   intval($_GET['delete_id']);
        $the_post   =   get_post( $delete_id);

        $user_to_delete =   get_post_meta($delete_id, 'user_meda_id',true );

        if( $current_user->ID != $the_post->post_author ) {
            exit('you don\'t have the right to delete this');
        }else{

            $arguments = array(
                'numberposts'   => -1,
                'post_type'     => array('attachment','estate_property'),
                'author'        => $user_to_delete,
                'post_status'   => 'any'
            );


            $user_list = new WP_Query($arguments);

            $owner_id=get_user_meta($userID,'user_agent_id',true);
            if($user_list->have_posts() ):
                while($user_list->have_posts()):
                    $user_list->the_post();

                    $change_arg = array(
                        'ID'          => get_the_ID(),
                        'post_author' => $userID,
                    );
                    wp_update_post( $change_arg );
                    update_post_meta( get_the_ID(), 'property_agent', $owner_id);
                endwhile;

            endif;
            if(!function_exists('wp_delete_user')){
                require_once(ABSPATH.'wp-admin/includes/user.php');
            }
            wp_delete_user($user_to_delete);
            wp_delete_post( $delete_id );
            wp_redirect(  wpestate_get_template_link('user_dashboard_agent_list.php') );
            exit;
        }

    }

}

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
          <div class="wpestate_dashboard_content_wrapper dashboard_agent_list">
            <?php
              $order_by='';
              if(isset($_GET['orderby'])){
                $order_by       = intval($_GET['orderby']);
              }

              $status_value='';
              if(isset($_GET['status'])){
                $status_value   = intval($_GET['status']);
              }
              wpestate_dashboard_agent_list( $status_value);
            ?>
          </div>
        </div>
    </div>
</div>


<?php
$ajax_nonce = wp_create_nonce( "wpestate_agent_actions" );
print ' <input type="hidden" id="wpestate_agent_actions" value="'.esc_html($ajax_nonce).'" />';
get_footer();
?>
