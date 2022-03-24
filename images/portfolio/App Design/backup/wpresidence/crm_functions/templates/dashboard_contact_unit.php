<div class="row property_wrapper_dash">
    <div class="col-md-2 wpestate_crm_contact_name dashbard_unit_title">
      <?php
      $post_author_id = get_post_field( 'post_author', $post_id );
      $contact_id = get_post_meta($post_id,'lead_contact',true);
      echo esc_html( ucwords( get_post_meta($post_id , 'crm_first_name', true) ) );
      ?>
    </div>
    <div class="col-md-2 wpestate_crm_contact_email ">
      <?php   echo get_post_meta($post_id , 'crm_email', true); ?>
    </div>
      <div class="col-md-2 wpestate_crm_contact_phone">
       <?php
             echo get_post_meta($post_id , 'crm_mobile', true);
       ?>
      </div>

      <div class="col-md-2 wpestate_crm_contact_added_on">
          <?php echo get_the_date('Y-m-d H:i',$post_id)?>
      </div>

      <div class="col-md-2 wpestate_crm_contact_status">
        <?php
             $status= strip_tags( get_the_term_list( $post_id , 'wpestate-crm-contact-status', '', ', ', '') );
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
        include(locate_template('crm_functions/templates/crm_contact_unit_actions.php'));
        ?>
      </div>
  </div>
