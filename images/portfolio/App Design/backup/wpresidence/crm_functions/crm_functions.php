<?php
/*
 *  insert a contact post type
 *
 *
 *
 *
 */

if(!function_exists('wpestate_show_lead_details_dashboard')):
function wpestate_show_lead_details_dashboard($lead_id){
  global $leads_post_array;

  print '<h2>'.esc_html__('Lead Info','wpresidence').'</h2>';
  foreach ($leads_post_array as $key => $item) {
    print '<div class="contact_crm_detail">';

    print '<label>'.$item['label'].': </label>';

    if($key=='crm_handler'){

      $crm_handler=get_post_meta($lead_id,'crm_handler',true);
      print get_the_title($crm_handler);

    }else if($key=="status"){

      $status= strip_tags( get_the_term_list( $lead_id , 'wpestate-crm-lead-status', '', ', ', '') );
      if($status==''){
         $status= esc_html__('New','wpresidence');
      }
      print $status;
    }else if($key=="crm_lead_content"){
      print get_post_field('post_content', $lead_id);
    }else{
      print $value=get_post_meta($lead_id,$key,true);
    }

    print '</div>';
  }




}
endif;






/*
 *  insert a contact post type
 *
 *
 *
 *
 */
if(!function_exists('wpestate_create_crm_lead_dashboard')):
function   wpestate_create_crm_lead_dashboard($arguments,$agent_list,$lead_id=''){

    // check if contact inside db- via email
    global $leads_post_array;
    $current_user           =   wp_get_current_user();
    $userID                 =   $current_user->ID;

    $contact_id='';

    if(intval($lead_id)==0){

      $post = array(
              'post_content'	=> '',
              'post_status'	  => 'publish',
              'post_type'     => 'wpestate_crm_lead' ,
              'post_author' => $userID,
      );
      $lead_id =  wp_insert_post($post );
      if ( ! is_wp_error( $lead_id ) ) {
          $post   =  array(
                          'ID'           => $lead_id,
                          'post_title'   => 'Lead message no: ' . $lead_id,
                      );
          wp_update_post($post);
        }



    }else{

        $post_author_id = get_post_field( 'post_author', $lead_id );

        if( in_array($post_author_id,$agent_list) || current_user_can('administrator') ){
            wp_delete_object_term_relationships( $lead_id, 'wpestate-crm-lead-status' );
        }else{
          print esc_html__('You are not allowed to edit this!!!','wpresidence');
          exit();
        }

    }




    foreach ($leads_post_array as $key => $item) {
      if( $item['type']=='taxonomy' ){
          wp_set_object_terms($lead_id, $arguments[$key], 'wpestate-crm-lead-status');
      }


      if( $item['type']!='taxonomy' && $key!='crm_lead_permalink' && $key!='crm_lead_content' ){
        update_post_meta($lead_id,$key,      sanitize_text_field( $arguments[$key]) );
      }

    }
    //    update_post_meta($post_id,'crm_handler', intval( $arguments['agent_id']) );

    $contact_id=intval($_POST['wpestate_crm_manual_contact']);
    update_post_meta($contact_id,'lead_contact',   intval($lead_id));
    update_post_meta($lead_id,'lead_contact',   intval($contact_id));
    update_post_meta($contact_id,'lead_contact_to_id',   intval($lead_id));


}

endif;




/*
 *  Add CRM contact comment
 *
 *
 *
 *
 */
 add_action( 'wp_ajax_wpestate_crm_add_comment_dashboard', 'wpestate_crm_add_comment_dashboard' );
 function wpestate_crm_add_comment_dashboard(){
     check_ajax_referer( 'wpestate_crm_insert_note', 'security' );
     if ( !is_user_logged_in() ) {
         exit('out pls');
     }
     $agent_list      =   wpestate_return_agent_list();
     $current_user    =   wp_get_current_user();
     $content         =   esc_html($_POST['content']);
     $post_id         =   intval($_POST['item_id']);
     $post_author_id  =   get_post_field( 'post_author', $post_id );

     if( in_array($post_author_id,$agent_list) || current_user_can('administrator') ){

            $comment_arg = array(
                    'comment_post_ID'      => $post_id,
                    'user_id'              => $current_user->ID,
                    'comment_author'       => $current_user->user_nicename,
                    'comment_author_email' => $current_user->user_email,
                    'comment_content'      => $content,
                    'comment_date'         => current_time('mysql'),
                    'comment_approved'     => 1,
            );

            wp_insert_comment( $comment_arg );
            print 'ok';
     }else{
       print esc_html__('You are not allowed to delete this !','wpresidence');
     }


     die();
 }





/*
 *  Delete CRM contact
 *
 *
 *
 *
 */


if(!function_exists('wpestate_crm_delete_contact')):
function   wpestate_crm_delete_contact($delete_contact_id,$agent_list  ){

          $post_author_id = get_post_field( 'post_author', $delete_contact_id );

          if( in_array($post_author_id,$agent_list) || current_user_can('administrator') ){
            wp_delete_post($delete_contact_id);
          }else{
            print esc_html__('You are not allowed to delete this !','wpresidence');
            exit();
          }


}
endif;
/*
 *  insert a contact post type
 *
 *
 *
 *
 */
if(!function_exists('wpestate_create_crm_contact_dashboard')):
function   wpestate_create_crm_contact_dashboard($arguments,$agent_list,$lead_id=''){

    // check if contact inside db- via email
    global $contact_post_array;
    $current_user           =   wp_get_current_user();
    $userID                 =   $current_user->ID;

    if(intval($lead_id)==0){

      $post = array(
              'post_title'	=> sanitize_text_field($arguments['crm_first_name']),
              'post_status'	=> 'publish',
              'post_type'   => 'wpestate_crm_contact',
              'post_author' => $userID,
      );
      $post_id =  wp_insert_post($post );

    }else{

        $post_author_id = get_post_field( 'post_author', $lead_id );

        if( in_array($post_author_id,$agent_list) || current_user_can('administrator') ){
            $post = array(
                    'post_title'	=> sanitize_text_field($arguments['crm_first_name']),
                    'ID'           => intval($lead_id),
            );
            $post_id  = wp_update_post($post );
            $post_id  = intval($lead_id);
            wp_delete_object_term_relationships( $post_id, 'wpestate-crm-contact-status' );
        }else{
          print esc_html__('You are not allowed to edit this!!!','wpresidence');
          exit();
        }

    }




    foreach ($contact_post_array as $key => $item) {
      if( $item['type']!='taxonomy' ){
        update_post_meta($post_id,$key,      sanitize_text_field( $arguments[$key]) );
      }else{

        wp_set_object_terms($post_id, $arguments[$key], 'wpestate-crm-contact-status');
      }
    }
    update_post_meta($post_id,'lead_contact',   intval($lead_id));
    update_post_meta($lead_id,'lead_contact',   intval($post_id));



}

endif;

/*
 *  check action type for crm dashboard pages (leads or contacts)
 *
 *
 *
 *
 */


if(!function_exists('wpestate_show_crm_data_split')):
function wpestate_show_crm_data_split($agent_list){
    $action=0;
    if(isset($_GET['actions'])){
      $action = intval($_GET['actions']);
    }


    if($action==0){
      wpestate_show_crm_data_leads($agent_list);
    }else if($action==1){
      wpestate_show_crm_data_contacts($agent_list);
    }
}
endif;

/*
 * show list of leads
 *
 *
 *
 *
 */

if(!function_exists('wpestate_show_crm_data_contacts')):
  function wpestate_show_crm_data_contacts($agent_list){
        $prop_no      =   intval( wpresidence_get_option('wp_estate_prop_no', '') );
        $paged        =   (get_query_var('paged')) ? get_query_var('paged') : 1;
        $autofill     =   '';

        $args = array(
                'post_type'         =>  'wpestate_crm_contact',
                'author__in'        =>  $agent_list,
                'paged'             =>  $paged,
                'posts_per_page'    =>  $prop_no,
                //  'post_status'       =>  wpestate_set_status_parameter_property($status_value)
        );

        $lead_selection = new WP_Query($args);
        print '<div class="wpestate_dashboard_section_title inbox_title">'.esc_html__('Your Contacts','wpresidence').'</div>';

        print '<a id="westate_crm_create_contact" class="wpresidence_button" href="'.wpestate_get_template_link('wpestate-crm-dashboard_contacts.php').'">'.esc_html__('Create Contact','wpresidence').'</a>';
        print '<div class="wpestate_dashboard_table_list_header row">';
        print '<div class="col-md-2">'.esc_html__('Name','wpresidence').'</div>';
        print '<div class="col-md-2">'.esc_html__('Email','wpresidence').'</div>';
        print '<div class="col-md-2">'.esc_html__('Phone','wpresidence').'</div>';
        print '<div class="col-md-2">'.esc_html__('Added on','wpresidence').'</div>';
        print '<div class="col-md-2">'.esc_html__('Status','wpresidence').'</div>';
        print '<div class="col-md-2">'.esc_html__('Actions','wpresidence').'</div>';
        print '</div>';

        if( !$lead_selection->have_posts() ){
            print '<h4 style="margin-top:30px">'.esc_html__('You don\'t have any Leads!','wpresidence').'</h4>';
        }else{

            while ($lead_selection->have_posts()): $lead_selection->the_post();
                  $post_id=get_the_ID();
                  include( locate_template('crm_functions/templates/dashboard_contact_unit.php'));
            endwhile;
            wpestate_pagination($lead_selection->max_num_pages, $range =2);
      }

    }
endif;
/*
 * show list of leads
 *
 *
 *
 *
 */

if(!function_exists('wpestate_show_crm_data_leads')):
  function wpestate_show_crm_data_leads($agent_list){
        $prop_no      =   intval( wpresidence_get_option('wp_estate_prop_no', '') );
        $paged        =   (get_query_var('paged')) ? get_query_var('paged') : 1;
        $autofill     =   '';

        $args = array(
                'post_type'         =>  'wpestate_crm_lead',
                'author__in'        =>  $agent_list,
                'paged'             =>  $paged,
                'posts_per_page'    =>  $prop_no,
                //  'post_status'       =>  wpestate_set_status_parameter_property($status_value)
        );

        $lead_selection = new WP_Query($args);
        print '<div class="wpestate_dashboard_section_title inbox_title">'.esc_html__('Your Leads/Deals','wpresidence').'</div>';
        print '<a id="westate_crm_create_lead" class="wpresidence_button" href="'.wpestate_get_template_link('wpestate-crm-dashboard_leads.php').'">'.esc_html__('Add New Lead/Deal','wpresidence').'</a>';

        print '<div class="wpestate_dashboard_table_list_header row">';
        print '<div class="col-md-2">'.esc_html__('Lead No','wpresidence').'</div>';
        print '<div class="col-md-2">'.esc_html__('Request By','wpresidence').'</div>';
        print '<div class="col-md-2">'.esc_html__('Agent in Charge','wpresidence').'</div>';
        print '<div class="col-md-2">'.esc_html__('Date','wpresidence').'</div>';


        print '<div class="col-md-2">'.esc_html__('Status','wpresidence').'</div>';
        print '<div class="col-md-2">'.esc_html__('Actions','wpresidence').'</div>';
        print '</div>';

        if( !$lead_selection->have_posts() ){
            print '<h4 style="margin-top:30px">'.esc_html__('You don\'t have any Leads!','wpresidence').'</h4>';
        }else{

            while ($lead_selection->have_posts()): $lead_selection->the_post();
                  $post_id=get_the_ID();
                  include( locate_template('crm_functions/templates/dashboard_lead_unit.php'));
            endwhile;
            wpestate_pagination($lead_selection->max_num_pages, $range =2);
      }

    }
endif;
?>
