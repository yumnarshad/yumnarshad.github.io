<?php
if(!function_exists('wpestate_return_filtered_query')):
function wpestate_return_filtered_query($args,$do_filter){
	if($args['orderby']=='ID'){
		$do_filter='no';
	}


	if( isset($args['meta_key']) && $args['meta_key']=='prop_featured'){
			 $do_filter='yes';
 	 }



	if($do_filter=='yes'){
		add_filter( 'posts_orderby', 'wpestate_my_order' );
	}
	$recent_posts = new WP_Query($args);

	if($do_filter=='yes'){
		remove_filter( 'posts_orderby', 'wpestate_my_order' );
	}
	return $recent_posts;
}
endif;

/*
*
* create query arguments
*
*
*
*
*/

if(!function_exists('wpestate_create_query_arguments')):
function wpestate_create_query_arguments($all_arguments){
	 $transient_appendix = '';

    $order_array        = wpestate_create_query_order_by_array($all_arguments['order']);
    $tax_array_query    = wpestate_create_query_taxonomies($all_arguments['tax_arguments']);
    $meta_array_query   = wpestate_create_query_meta_by_array($all_arguments['meta_query']);

    $paged = ($all_arguments['paged']) ? $all_arguments['paged'] : 1;
    if( is_front_page() ){
        $paged= ($all_arguments['paged']) ? $all_arguments['paged'] : 1;
    }


    $args = array(
        'post_type'         => $all_arguments['post_type'],
        'post_status'       => $all_arguments['post_status'],
        'paged'             => $paged,
        'posts_per_page'    => $all_arguments['posts_per_page'],
        'meta_query'        => $meta_array_query['meta_query_array'],
        'tax_query'         => $tax_array_query['taxonomy_array']
    );
    // set order data
    $args =array_merge($args,$order_array['order_array']);

    // create transient name
    $transient_appendix.= '_'.$tax_array_query['transient_appendix'];
    $transient_appendix.='_'.$order_array['transient_appendix'];
    $transient_appendix.='_paged_'.$paged;
    if ( defined( 'ICL_LANGUAGE_CODE' ) ) {
        $transient_appendix.='_'. ICL_LANGUAGE_CODE;
    }

    return $args=array( 'query_arguments'   =>  $args ,
                        'transient_appendix'=>  $transient_appendix,
                        );

}
endif;


/*
*
* return tax array to be used in wp_query
*
*
*
*
*/
if(!function_exists('wpestate_create_query_meta_by_array')):
function wpestate_create_query_meta_by_array($meta_data){

    $meta_query_array=array();

    foreach($meta_data as $meta_name=>$meta_info){

        $compare_type='numeric';

        if( !is_numeric( $meta_info['value'] ) ){
            $compare_type='';
        }

        if( $meta_name =='property_price_max') $meta_name ='property_price';

        $temp_array=array(
          'key'     =>   $meta_info['key'],
          'value'   =>  $meta_info['value'],
          'type'    =>  $compare_type,
          'compare' =>  $meta_info['compare'],
        );
        $meta_query_array[]=  $temp_array;
    }

    return array(
      'meta_query_array'=>  $meta_query_array
    );

}
endif;

/*
*
* return tax array to be used in wp_query
*
*
*
*
*/
if(!function_exists('wpestate_create_query_order_by_array')):
function wpestate_create_query_order_by_array($order){

   $meta_directions    =   'DESC';
   $meta_order         =   'prop_featured';
   $order_by           =   'meta_value_num';



   switch ($order){
             case 1:
                 $meta_order='property_price';
                 $meta_directions='DESC';
                 $order_by='meta_value_num';
                 break;
             case 2:
                 $meta_order='property_price';
                 $meta_directions='ASC';
                 $order_by='meta_value_num';
                 break;
             case 3:
                 $meta_order='';
                 $meta_directions='DESC';
                 $order_by='ID';
                 break;
             case 4:
                 $meta_order='';
                 $meta_directions='ASC';
                 $order_by='ID';
                 break;
             case 5:
                 $meta_order='property_bedrooms';
                 $meta_directions='DESC';
                 $order_by='meta_value_num';
                 break;
             case 6:
                 $meta_order='property_bedrooms';
                 $meta_directions='ASC';
                 $order_by='meta_value_num';
                 break;
             case 7:
                 $meta_order='property_bathrooms';
                 $meta_directions='DESC';
                 $order_by='meta_value_num';
                 break;
             case 8:
                 $meta_order='property_bathrooms';
                 $meta_directions='ASC';
                 $order_by='meta_value_num';
                 break;
						case 99:
							$meta_order='';
							$meta_directions='';
							$order_by='rand';
							break;
         }
     $transient_appendix='_'.$meta_order.'_'.$meta_directions;

     if( $order==0 ){
         $transient_appendix.='_myorder';
     }

     $order_array=array(
          'orderby'           => $order_by,
    	);

		 if($meta_order!=''){
			 $order_array['meta_key']=$meta_order;
		 }
		 if($meta_directions!=''){
			 $order_array['order']=$meta_directions;
		 }



     return $return_array= array(
       'order_array'        =>  $order_array,
       'transient_appendix' => $transient_appendix
     );
}
endif;



/*
*
* return tax array to be used in wp_query
*
*
*
*
*/
if(!function_exists('wpestate_create_query_taxonomies')):
function wpestate_create_query_taxonomies($tax_arguments){

  $transient_appendix   =   '';
  $tax_array            =   array( 'relation' => 'AND');
  $tax_array_to_return  =   array();
  $by_field             =   'slug';
  if( isset($tax_arguments['by_field']) ){
      $by_field=$tax_arguments['by_field'];
      unset($tax_arguments['by_field']);
  }


  if(is_array($tax_arguments) && !empty($tax_arguments) )
  foreach ($tax_arguments as $taxonomy => $taxonomy_terms):
      $taxcateg_include=array();
      if( is_array( $taxonomy_terms) && !empty($taxonomy_terms) && $taxonomy_terms[0]!='all' ) {
        foreach($taxonomy_terms as $key=>$value){
              if($value!=''){
                $taxcateg_include[]   = sanitize_title($value);
                $transient_appendix   .='_'.sanitize_title($value);
              }


        }
      }

      if(!empty($taxcateg_include)){
          $temp_array=array(
              'taxonomy'  => $taxonomy,
              'field'     => $by_field,
              'terms'     => $taxcateg_include
         );
         $tax_array[]=$temp_array;
      }

  endforeach;

  $tax_array_to_return =array(
    'taxonomy_array'      =>    $tax_array,
    'transient_appendix'  =>    $transient_appendix
  );
  return  $tax_array_to_return;


}
endif;






/*
*
* prepare aguments for shortcode
*
*
*
*
*/
if( !function_exists('wpestate_prepare_arguments_shortcode') ):

function wpestate_prepare_arguments_shortcode($attributes){
  $return_array=array();

  if ( isset($attributes['title']) ){
      $return_array['title']=$attributes['title'];
  }
  if ( isset($attributes['type']) ){
      $return_array['type']=$attributes['type'];
  }
  if ( isset($attributes['arrows']) ){
      $return_array['arrows']=$attributes['arrows'];
  }

  if ( isset($attributes['category_ids']) ){
    $return_array['category']=$attributes['category_ids'];
  }

  if ( isset($attributes['action_ids']) ){
      $return_array['action']=$attributes['action_ids'];
  }

  if ( isset($attributes['city_ids']) ){
      $return_array['city']=$attributes['city_ids'];
  }

  if ( isset($attributes['area_ids']) ){
      $return_array['area']=$attributes['area_ids'];
  }

  if ( isset($attributes['state_ids']) ){
      $return_array['state']=$attributes['state_ids'];
  }

  if ( isset($attributes['status_ids']) ){
    $return_array['status']=$attributes['status_ids'];
  }

  if ( isset($attributes['number']) ){
      $return_array['number']=intval ( $attributes['number'] );
  }

  if ( isset($attributes['price_min']) ){
      $return_array['price_min']=floatval ( $attributes['price_min'] );
  }

  if ( isset($attributes['price_max']) ){
      $return_array['price_max']=floatval ( $attributes['price_max'] );
  }


    if ( isset($attributes['sort_by']) ){
        $return_array['sort_by']=intval ( $attributes['sort_by'] );
    }

  if ( isset($attributes['show_featured_only']) ){
      $return_array['show_featured_only']=$attributes['show_featured_only'];
  }
  if ( isset($attributes['random_pick']) ){
      $return_array['random_pick']= ( $attributes['random_pick'] );
  }

  if ( isset($attributes['autoscroll']) ){
      $return_array['autoscroll']=intval ( $attributes['autoscroll'] );
  }


  if ( isset($attributes['rownumber']) ){
    $return_array['row_number']        = $attributes['rownumber'];
  }

  if ( isset($attributes['align']) ){
    $return_array['align']        = $attributes['align'];
  }


  if ( isset($attributes['link']) ){
    $return_array['link']        = $attributes['link'];
  }

  if ( isset($attributes['control_terms_id']) ){
    $return_array['control_terms_id']        = $attributes['control_terms_id'];
  }

  if (isset($attributes['featured_first'])){
    $return_array['featured_first']=   $attributes['featured_first'];
  }

  if ( isset($attributes['systemx']) ){
      $return_array['systemx']=$attributes['systemx'];
  }
	if ( isset($attributes['card_version']) ){
	      $return_array['card_version']=$attributes['card_version'];
  }
	if ( isset($attributes['post_number_total']) ){
	      $return_array['post_number_total']=$attributes['post_number_total'];
  }
	if ( isset($attributes['is_autoscroll']) ){
	      $return_array['is_autoscroll']=$attributes['is_autoscroll'];
  }

  return $return_array;
}
endif;


/*
*
*
*
*
*
*
*/
