<?php
$post_status        =   get_post_status($post->ID);
$edit_link          =   wpestate_get_template_link('user_dashboard_add_agent.php');
$edit_link          =   esc_url_raw(add_query_arg( 'listing_edit', $post->ID, $edit_link )) ;
$defaults = array(
          'echo'   => false,
      );
?>
<div class="btn-group">
  <button type="button" class="btn btn-default dropdown-toggle property_dashboard_actions_button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <?php esc_html_e('Actions','wpresidence');?> <span class="caret"></span>
  </button>
  <ul class="dropdown-menu ">

    <li>
      <a href="<?php  print esc_url($edit_link);?>"><?php esc_html_e('Edit Agent','wpresidence');?></a>
    </li>

    <li>
      <a  class="dashboad-tooltip" onclick="return confirm(' <?php echo esc_html__('Are you sure you wish to delete ','wpresidence').the_title_attribute($defaults); ?>?')" href="<?php print esc_url_raw(add_query_arg( 'delete_id', $post->ID,  wpestate_get_template_link('user_dashboard_agent_list.php')   ) );?>"><?php esc_html_e('Delete Agent','wpresidence');?></a>
    </li>

    <li>
      <?php
          if( $post_status == 'publish' ){
              print '<a href="" class="dashboad-tooltip disable_listing disable_agent disabledx" data-postid="'.intval($post->ID).'" >'.esc_html__('Disable Agent','wpresidence').'</a>';
          }else if($post_status=='disabled') {
              print '<a href="" class="dashboad-tooltip disable_listing disable_agent" data-postid="'.intval($post->ID).'" >'.esc_html__('Enable Agent','wpresidence').'</a>';
          }
      ?>
    </li>


  </ul>
</div>
