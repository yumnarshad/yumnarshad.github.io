<?php
$property_list_link     =   wpestate_get_template_link('user_dashboard.php');
$order_label            =   esc_html__('Order By','wpresidence');


$values_dropdown=array(
    0 => array(
                      'label' =>  esc_html__('Default Order','wpresidence'),
                      'value' =>  0
                    ),
    1 => array(
                        'label' =>  esc_html__('Price -  High to Low','wpresidence'),
                        'value' =>  1
                      ),
    2 => array(
                      'label' =>  esc_html__('Price -  Low to High','wpresidence'),
                      'value' =>  2
                    ),
    7 => array(
                        'label' =>  esc_html__('Bathrooms -  High to Low','wpresidence'),
                        'value' =>  7
                      ),
  8 => array(
                      'label' =>  esc_html__('Bathrooms -Low to High','wpresidence'),
                      'value' =>  8
                    ),
    4 => array(
                        'label' =>  esc_html__('Date - Old to New','wpresidence'),
                        'value' =>  4
                      ),
    3=> array(
                        'label' =>  esc_html__('Date - New to Old','wpresidence'),
                        'value' =>  3
                      ),

);

if( isset($_GET['status']) && intval( $_GET['status'])!=0 ){
  $property_list_link = add_query_arg( 'status', intval( $_GET['status']) ,  $property_list_link );
}

if( isset($_GET['orderby']) && intval( $_GET['orderby'])!=0 ){
  $order_label=$values_dropdown[intval( $_GET['orderby'])]['label'];
}

?>
<div class="btn-group wpestate_dashhboard_filter">
  <button type="button" class="btn btn-default dropdown-toggle property_dashboard_actions_button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <?php print esc_html($order_label); ?> <span class="caret"></span>
  </button>

  <ul class="dropdown-menu ">
    <?php foreach ($values_dropdown as $key => $item) {?>
        <li>
          <a class="dashboad-tooltip" href="<?php  print  esc_url_raw(add_query_arg( 'orderby', $item['value'],  $property_list_link ) ) ;?>">
            <?php echo esc_html( $item['label']);?>
          </a>
        </li>
    <?php }?>
  </ul>
</div>
