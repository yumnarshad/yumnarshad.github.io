<?php
/*
*
* User for grid elementor widget only
*
*/
$place_id                       =   intval($place_id);
$category_attach_id             =   '';
$category_tax                   =   '';
$category_featured_image        =   '';
$category_featured_image_url    =   '';
$term_meta                      =   get_option("taxonomy_$place_id");



if (isset($term_meta['category_featured_image'])) {
    $category_featured_image=$term_meta['category_featured_image'];
}

if (isset($term_meta['category_attach_id'])) {
    $category_attach_id=$term_meta['category_attach_id'];
    $category_featured_image= wp_get_attachment_image_src($category_attach_id, 'property_full');
    $category_featured_image_url=$category_featured_image[0];
}




$term_link =  get_term_link($place_id, $category_tax);
if (is_wp_error($term_link)) {
    $term_link='';
}
$inline_style=" background-image: url(".esc_attr($category_featured_image_url).");";

if ($category_featured_image_url=='') {
    $inline_style=" background-color: #ddd;";
}

?>



<div class="listing_wrapper elementor_places_wrapper"  <?php echo esc_attr($item_height_style);?> >

    <div class="property_listing places_listing" data-link="<?php echo esc_attr($term_link);?>"    style="<?php echo trim($inline_style);?>" >

        <h4><a href="<?php echo esc_url($term_link); ?>">
            <?php
                echo mb_substr($category_name, 0, 44);
                if (mb_strlen($category_name)>44) {
                    echo '...';
                }
            ?>
            </a>
        </h4>

        <div class="property_location">
            <?php
          
            printf(  _n('%d listing', '%d listings', $category_count, 'wpresidence'), $category_count );
            $protocol = is_ssl() ? 'https' : 'http';
            ?>
        </div>



    </div>
</div>
