<?php
// Template Name: User Dashboard Submit
// Wp Estate Pack
wpestate_dashboard_header_permissions();

$current_user           =   wp_get_current_user();
$userID                 =   $current_user->ID;
$user_agent_id          =   intval( get_user_meta($userID,'user_agent_id',true));
$status                 =   get_post_status($user_agent_id);

if( $status==='pending' || $status==='disabled' ){
    wp_redirect(  esc_url(home_url('/')));
    exit;
}

add_filter('wp_kses_allowed_html', 'wpestate_add_allowed_tags');

$user_pack                      =   get_the_author_meta( 'package_id' , $userID );
$allowed_html                   =   array();
$wpestate_submission_page_fields=   wpresidence_get_option('wp_estate_submission_page_fields','');
$all_submission_fields          =   wpestate_return_all_fields();
$agent_list                     =   (array)get_user_meta($userID,'current_agent_list',true);

global $wpestate_show_err;
global $wpestate_submission_page_fields;
global $all_submission_fields;

$property_features  =   get_terms( array(
                          'taxonomy' => 'property_features',
                          'hide_empty' => false,
                        ));
$errors=array();
$allowed_html_desc=array(
    'a' => array(
        'href' => array(),
        'title' => array()
    ),
    'br'        =>  array(),
    'em'        =>  array(),
    'strong'    =>  array(),
    'ul'        =>  array('li'),
    'li'        =>  array(),
    'code'      =>  array(),
    'ol'        =>  array('li'),
    'del'       =>  array(
                    'datetime'=>array()
                    ),
    'blockquote'=> array(),
    'ins'       =>  array(),
);

if( isset( $_GET['listing_edit'] ) && is_numeric( $_GET['listing_edit'] ) ){
    $edit_id                        =  intval ($_GET['listing_edit']);
    $action                         =   'edit';
}else{
    $action                         =   'view';
}



///////////////////////////////////////////////////////////////////////////////////////////
/////// Submit Code
///////////////////////////////////////////////////////////////////////////////////////////


if( isset($_POST) && isset($_POST['action'])  && $_POST['action']=='view' ) {

    if (    ! isset( $_POST['dashboard_property_front_nonce'] )  || ! wp_verify_nonce( $_POST['dashboard_property_front_nonce'], 'dashboard_property_front_action' ) ) {
        esc_html_e('Sorry, your nonce did not verify.','wpresidence');
        exit;
    }
    $parent_userID              =   wpestate_check_for_agency($userID);
    $paid_submission_status    =    esc_html ( wpresidence_get_option('wp_estate_paid_submission','') );

    if ( $paid_submission_status!='membership' || ( $paid_submission_status== 'membership' || wpestate_get_current_user_listings($parent_userID) > 0)  ){ // if user can submit

        if ( !isset($_POST['new_estate']) || !wp_verify_nonce($_POST['new_estate'],'submit_new_estate') ){
           exit('Sorry, your not submiting from site');
        }

        $wpestate_show_err              =   '';
        $post_id                        =   '';
        $has_errors                     =   false;
        $errors                         =   array();

        if($_POST['wpestate_title']==''){
            $has_errors=true;
            $errors[]=esc_html__('Please submit a title for your property','wpresidence');
        }

        $check_mandatory_field = wpestate_check_mandatory_fields();

        if(!empty($check_mandatory_field)){
            $has_errors=true;
            $errors=array_merge($errors,$check_mandatory_field);
        }


        if($has_errors){
            foreach($errors as $key=>$value){
                $wpestate_show_err.=$value.'</br>';
            }
        }else{
            $paid_submission_status = esc_html ( wpresidence_get_option('wp_estate_paid_submission','') );
            $new_status             = 'pending';

            $admin_submission_status= esc_html ( wpresidence_get_option('wp_estate_admin_submission','') );
            if($admin_submission_status=='no' && $paid_submission_status!='per listing'){
               $new_status='publish';
            }
            if(isset($_POST['save_draft']) && $_POST['save_draft']== esc_html__('Save as Draft', 'wpresidence') ){
               $new_status='draft';
            }


            $post = array(
                'post_title'    =>  wp_kses( esc_html($_POST['wpestate_title']) ,$allowed_html),
                'post_content'  =>  wp_kses( $_POST['wpestate_description'],$allowed_html_desc),
                'post_status'	  => $new_status,
                'post_type'     => 'estate_property' ,
                'post_author'   => $current_user->ID
            );
            $post_id =  wp_insert_post($post );

            if( $paid_submission_status == 'membership'){ // update pack status
                wpestate_update_listing_no($parent_userID);
            }

        }





        if($post_id) {
            wpestate_upload_images_dashboard($post_id,$_POST['attachid'],$_POST['attachthumb'],'edit');

            //defaults
            update_post_meta($post_id, 'sidebar_agent_option', 'global');
            update_post_meta($post_id, 'local_pgpr_slider_type', 'global');
            update_post_meta($post_id, 'local_pgpr_content_type', 'global');
            update_post_meta($post_id, 'prop_featured', 0);
            update_post_meta($post_id, 'pay_status', 'not paid');
            update_post_meta($post_id, 'page_custom_zoom', 16);

            wpestate_save_property_dashboard_data($post_id,$_POST,$property_fields_raw);
            wpestate_update_city_area_county_dashboard($post_id,$_POST);

            $user_id_agent            =   get_the_author_meta( 'user_agent_id' , $current_user->ID  );
            update_post_meta($post_id, 'property_agent', $user_id_agent);


            // save custom fields
            wpestate_save_custom_fields_dasboard($post_id,$_POST);

            // save flor plans
            wpestate_save_floor_plan_data($post_id,$_POST);

            // features &amm
            if(is_array($property_features)){
                foreach($property_features as $key => $term){
                    $feature_name   =   $term->slug;
                    //$feature_name   =   str_replace('%','', $feature_name);
                    if(isset($_POST[$feature_name]) && $_POST[$feature_name]==1){
                        wp_set_object_terms($post_id,trim($term->name),'property_features',true);
                        $moving_array[]=$feature_name;
                    }
                }
            }

            // proeprty status
            wp_set_object_terms($post_id, sanitize_text_field($_POST['property_status']) , 'property_status',true);

            wpestate_update_hiddent_address_single($post_id);

            // get user dashboard link
            $redirect = wpestate_get_template_link('user_dashboard.php');

            $arguments=array(
                'new_listing_url'   => esc_url( get_permalink($post_id) ),
                'new_listing_title' => $submit_title
            );
            wpestate_select_email_type(get_option('admin_email'),'new_listing_submission',$arguments);

            wp_reset_query();
            wp_redirect( $redirect);
            exit;
        }

        }//end if user can submit
} // end post

///////////////////////////////////////////////////////////////////////////////////////////
/////// Edit Part Code
///////////////////////////////////////////////////////////////////////////////////////////
if( isset($_POST) && isset($_POST['action'])  &&  $_POST['action']=='edit' ) {
        if (    ! isset( $_POST['dashboard_property_front_nonce'] )  || ! wp_verify_nonce( $_POST['dashboard_property_front_nonce'], 'dashboard_property_front_action' ) ) {
          esc_html_e('Sorry, your nonce did not verify.','wpresidence');
          exit;
       }

        if ( !isset($_POST['new_estate']) || !wp_verify_nonce($_POST['new_estate'],'submit_new_estate') ){
            exit('Sorry, your not submiting from site');
        }
        $has_errors                     =   false;
        $wpestate_show_err                       =   '';
        $edited                         =   0;
        $edit_id                        =   intval( $_POST['edit_id'] );
        $post                           =   get_post( $edit_id );
        $author_id                      =   $post->post_author ;
        if($current_user->ID !=  $author_id   &&  !in_array($the_post->post_author , $agent_list) ){
            exit('you don\'t have the rights to edit');
        }


        wpestat_delete_images_onedit($_POST['images_todelete'],$current_user,$agent_list);
        wpestate_upload_images_dashboard($edit_id,$_POST['attachid'],$_POST['attachthumb'],'edit');

        if($_POST['wpestate_title']==''){
            $has_errors=true;
            $errors[]=esc_html__('Please submit a title for your property','wpresidence');
        }

        $check_mandatory_field=wpestate_check_mandatory_fields();


        if(!empty($check_mandatory_field)){
            $has_errors=true;
            $errors=array_merge($errors,$check_mandatory_field);
        }

        wp_reset_query();
        if($has_errors){
            foreach($errors as $key=>$value){
                $wpestate_show_err.=$value.'</br>';
            }

        }else{
            $new_status='pending';
            $admin_submission_status = esc_html ( wpresidence_get_option('wp_estate_admin_submission','') );
            $paid_submission_status  = esc_html ( wpresidence_get_option('wp_estate_paid_submission','') );


            if($admin_submission_status=='no' ){
               $new_status=get_post_status($edit_id);

               if($new_status=='draft'){
                 $new_status='pending';
                 if($admin_submission_status=='no' && $paid_submission_status!='per listing'){
                    $new_status='publish';
                 }

               }
            }

            if(isset($_POST['save_draft']) && $_POST['save_draft']== esc_html__('Save as Draft', 'wpresidence') ){
               $new_status='draft';
            }


            $post = array(
                    'ID'            => $edit_id,
                    'post_title'    =>  wp_kses( esc_html($_POST['wpestate_title']) ,$allowed_html),
                    'post_content'  =>  wp_kses( $_POST['wpestate_description'],$allowed_html_desc),
                    'post_type'     => 'estate_property',
                    'post_status'   => $new_status
            );



            $post_id =  wp_update_post($post );
            $edited=1;
        }

        if( $edited==1) {


            wpestate_save_property_dashboard_data($post_id,$_POST,$property_fields_raw);
            wpestate_update_city_area_county_dashboard($post_id,$_POST);

            wpestate_save_floor_plan_data($post_id,$_POST);
            wpestate_save_property_features_dasboard($post_id,$_POST );

            wp_delete_object_term_relationships( $post_id, 'property_status' );
            wp_set_object_terms($post_id, sanitize_text_field($_POST['property_status']) , 'property_status',true);


            // save custom fields
            wpestate_save_custom_fields_dasboard($post_id,$_POST );

            wpestate_update_hiddent_address_single($post_id);

            // get user dashboard link
            $redirect = wpestate_get_template_link('user_dashboard.php');
            wp_reset_query();

            $arguments=array(
                'editing_listing_url'   => esc_url( get_permalink($post_id) ),
                'editing_listing_title' => sanitize_text_field($_POST['wpestate_title'])
            );
            wpestate_select_email_type(get_option('admin_email'),'listing_edit',$arguments);

           wp_redirect( $redirect);
           exit;
        }// end if edited
}




get_header();
$wpestate_options=wpestate_page_details($post->ID);



///////////////////////////////////////////////////////////////////////////////////////////
/////// Html Form Code below
///////////////////////////////////////////////////////////////////////////////////////////
?>

<div id="cover"></div>
<div class="row row_user_dashboard">

    <?php  get_template_part('templates/dashboard-templates/dashboard-left-col'); ?>

    <div class="col-md-9 dashboard-margin">
        <?php
            wpestate_show_dashboard_title(get_the_title());
        ?>

        <?php   include( locate_template('templates/front_end_submission.php') );  ?>

    </div>
</div>
<?php
if(function_exists('wpestate_disable_filtering')){
    wpestate_disable_filtering('wp_kses_allowed_html', 'wpestate_add_allowed_tags');
}
get_footer();
?>
