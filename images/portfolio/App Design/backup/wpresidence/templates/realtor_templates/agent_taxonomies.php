<div class="developer_taxonomy agent_taxonomy">
           
    <h4><?php esc_html_e('Specialties & Service Areas','wpresidence');?></h4>
    <?php

    print  get_the_term_list($post->ID, 'property_county_state_agent', '', '', '') ;
    print  get_the_term_list($post->ID, 'property_city_agent', '', '', '') ;
    print  get_the_term_list($post->ID, 'property_area_agent', '', '', '');
    print  get_the_term_list($post->ID, 'property_category_agent', '', '', '') ;
    print  get_the_term_list($post->ID, 'property_action_category_agent', '', '', '');  
    ?>
</div>    