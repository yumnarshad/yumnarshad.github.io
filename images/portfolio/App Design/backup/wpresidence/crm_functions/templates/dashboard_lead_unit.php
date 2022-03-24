<div class="row property_wrapper_dash">
    <div class="col-md-2 wpestate_crm_lead_id dashbard_unit_title">
      <?php echo esc_html__('Lead no ','wpresidence').' '.$post_id?>.
    </div>

    <div class="col-md-2 wpestate_crm_lead_from">
       <?php
         $contact_id      = get_post_meta($post_id,'lead_contact',true);
         $crm_first_name  = get_post_meta($contact_id , 'crm_first_name', true);
         $lead_from_email = get_post_meta($post_id , 'lead_from_email', true);

         $lead_contact    =   get_post_meta($post_id,'lead_contact',true);
         $edit_link       =   wpestate_get_template_link('wpestate-crm-dashboard_contacts.php');
         $edit_link       =   esc_url_raw(add_query_arg( 'contact_edit', $lead_contact, $edit_link )) ;

         if(trim($crm_first_name)!=''){
           print '<a href="'.$edit_link .'" >'.esc_html($crm_first_name);
           // if( $lead_from_email!=='' ){
           //   print ' ('.$lead_from_email.')';
           // }
           print '</a>';
         }else{
           esc_html_e('added manually','wpresidence');
         }
       ?>
    </div>


    <div class="col-md-2 wpestate_crm_lead_agent_in_charge">
        <?php
        $agent_id=intval( get_post_meta($post_id , 'crm_handler', true) );
        if($agent_id!=0){
            echo get_the_title($agent_id);
        }

        $agent_email = get_post_meta($agent_id,'agent_email',true);
        if($agent_email!=''){
          print '</br>';
          print $agent_email;
        }

        ?>
    </div>


    <div class="col-md-2 wpestate_crm_lead_date">
      <?php echo get_the_date('Y-m-d H:i',$post_id)?>
    </div>




    <div class="col-md-2 wpestate_crm_lead_status wpestate_crm_contact_status">

        <?php
             $status= strip_tags( get_the_term_list( $post_id , 'wpestate-crm-lead-status', '', ', ', '') );
             if($status==''){
                $status= esc_html__('New','wpresidence');
             }
            print '<div class=" property_list_status_label anycrm '.strtolower($status).'">';
            print   $status;
            print '</div>';
        ?>

    </div>

    <div class="col-md-2 wpestate_crm_lead_actions">
      <?php
        include(locate_template('crm_functions/templates/crm_lead_unit_actions.php'));
      ?>
    </div>

</div>
