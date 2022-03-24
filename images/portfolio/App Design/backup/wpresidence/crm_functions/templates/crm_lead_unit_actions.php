<?php
global $wp;
$list_link= home_url( $wp->request );
//$list_link              =   wpestate_get_template_link('wpestate-crm-dashboard.php');
$list_link              =   esc_url_raw(add_query_arg( 'actions', 1, $list_link  )) ;
$edit_link              =   wpestate_get_template_link('wpestate-crm-dashboard_leads.php');
$edit_link              =   esc_url_raw(add_query_arg( 'lead_edit', $post_id, $edit_link )) ;
$delete_link            =   esc_url_raw(add_query_arg( 'delete_lead_id', $post_id, $list_link )) ;


?>
<div class="btn-group">
  <button type="button" class="btn btn-default dropdown-toggle property_dashboard_actions_button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <?php esc_html_e('Actions','wpresidence');?> <span class="caret"></span>
  </button>
  <ul class="dropdown-menu ">
    <li>
      <a class="dashboad-tooltip" href="<?php  print esc_url($edit_link);?>">
        <?php esc_html_e('View/Edit Lead','wpresidence');?>
      </a>
    </li>
    <li>
      <a class="dashboad-tooltip" onclick="return confirm(' <?php echo esc_html__('Are you sure you wish to delete ','wpresidence'); ?>')"
          href="<?php print esc_url( $delete_link ); ?>">
          <?php esc_html_e('Delete Lead','wpresidence');?>
      </a>
    </li>

  </ul>
</div>
