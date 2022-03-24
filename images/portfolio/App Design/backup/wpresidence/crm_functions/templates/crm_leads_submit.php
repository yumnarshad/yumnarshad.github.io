<h2>
  <?php esc_html_e('Lead Information','wpresidence');?>
</h2>
<input type="hidden" name="is_user_submit" value="1">

<div class="profile-onprofile row">
    <?php print wpestate_crm_show_details($leads_post_array,$contact_edit); ?>

    <div class="half-content col-md-6">
      <label style="margin-top:10px;" for="content"><?php esc_html_e('Contact','wpresidence'); ?></label>
      <select name="wpestate_crm_manual_contact">
        <?php print wpestate_list_select_contacts($contact_edit); ?>
      </select>
    </div>
</div>

<?php

function wpestate_list_select_contacts($contact_edit){
  $return          =  '';
  $current_user    =  wp_get_current_user();
  $userID          =  $current_user->ID;
  $agent_list      = wpestate_return_agent_list();
  $args = array(
          'post_type'         =>  'wpestate_crm_contact',
          'author__in'        =>  $agent_list,
          'posts_per_page'    =>  -1,
  );

  $selct_contact=get_post_meta($contact_edit,'lead_contact', true);

  $lead_selection = new WP_Query($args);
  while ($lead_selection->have_posts()): $lead_selection->the_post();
        $post_id=get_the_ID();
        $return.='<option value="'.$post_id.'"';
        if($selct_contact==$post_id){
          $return.=" selected ";
        }
        $return.='>'.get_the_title($post_id).'</value>';
  endwhile;

  return $return;
}
?>
