<?php
$property_list_link                  =   wpestate_get_template_link('user_dashboard.php');
$values_dropdown_property_status=array(
    0 => array(
                      'label' =>  esc_html__('All','wpresidence'),
                      'value' =>  0
                    ),
    1 => array(
                        'label' =>  esc_html__('Published','wpresidence'),
                        'value' =>  1
                      ),
    2 => array(
                      'label' =>  esc_html__('Disabled','wpresidence'),
                      'value' =>  2
                    ),
    3 => array(
                        'label' =>  esc_html__('Expired','wpresidence'),
                        'value' =>  3
                      ),
    4 => array(
                      'label' =>  esc_html__('Draft','wpresidence'),
                      'value' =>  4
                    ),
    5 => array(
                        'label' =>  esc_html__('Waiting for approval','wpresidence'),
                        'value' =>  5
                      ),
);

if( isset($_GET['orderby']) && intval( $_GET['orderby'])!=0 ){
  $property_list_link = add_query_arg( 'orderby', intval( $_GET['orderby']) ,  $property_list_link );
}

$order_label  = esc_html__('Filter By Status','wpresidence');
if( isset($_GET['status']) && intval( $_GET['status'])!=0 ){
  $order_label=$values_dropdown_property_status[intval( $_GET['status'])]['label'];
}

?>

<div class="btn-group wpestate_dashhboard_filter">
  <button type="button" class="btn btn-default dropdown-toggle property_dashboard_actions_button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <?php  print esc_html($order_label); ?> <span class="caret"></span>
  </button>


  <ul class="dropdown-menu ">
    <?php foreach ($values_dropdown_property_status as $key => $item) {?>
        <li>
          <a class="dashboad-tooltip" href="<?php  print  esc_url_raw(add_query_arg( 'status', $item['value'],  $property_list_link ) ) ;?>">
            <?php echo esc_html( $item['label']);?>
          </a>
        </li>
    <?php }?>
  </ul>
</div>
