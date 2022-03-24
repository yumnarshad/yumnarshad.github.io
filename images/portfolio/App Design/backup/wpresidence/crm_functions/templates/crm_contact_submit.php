<div class="wpestate_dashboard_section_title"><?php esc_html_e('Contact Information','wpresidence');?></div>
<input type="hidden" name="is_user_submit" value="1">

<div class="profile-onprofile row">
  <?php
  $edit_id_submit='';
  if(isset($edit_id)){
      $edit_id_submit=$edit_id;
  }
   print wpestate_crm_show_details($contact_post_array,$edit_id_submit);
   ?>
</div>
