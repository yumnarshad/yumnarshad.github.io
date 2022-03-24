  <?php
  $post_status                =   get_post_status($post_id);
  if($post_status=='expired'){
      $status=esc_html__('Expired','wpresidence');
  }else if($post_status=='publish'){
      $link= esc_url( get_permalink() );
      $status=esc_html__('Published','wpresidence');
  }else if($post_status=='disabled'){
      $link='';
      $status=esc_html__('Disabled','wpresidence');
  }else if($post_status=='draft'){
        $link='';
        $status=esc_html__('Draft','wpresidence');
  }else{
      $link='';
      $status=esc_html__('Waiting for approval','wpresidence');
  }

  if ($paid_submission_status=='per listing'){
      $pay_status    = get_post_meta($post_id, 'pay_status', true);
      if($pay_status=='paid'){
          $is_pay_status.=esc_html__('Paid','wpresidence');
      }else{
          $is_pay_status.=esc_html__('Not Paid','wpresidence');
      }
  }


print '<div class=" property_list_status_label '.sanitize_key($status).'">'.esc_html($status).'</div>';
