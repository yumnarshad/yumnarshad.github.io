  <?php
  if ($paid_submission_status=='per listing'){
      $pay_status    = get_post_meta($post_id, 'pay_status', true);
      if($pay_status=='paid'){
          $pay_status=esc_html__('Paid','wpresidence');
      }else{
          $pay_status=esc_html__('Not Paid','wpresidence');
      }
  }
print '<div class=" property_list_status_label '.sanitize_key($pay_status).'">'.esc_html($pay_status).'</div>';
