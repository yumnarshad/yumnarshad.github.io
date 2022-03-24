<?php

$agent_custom_data = get_post_meta( $post->ID, 'agent_custom_data', true );
    
if( is_array( $agent_custom_data) ){
    if( count( $agent_custom_data )  > 0 ){
        print '<div class="custom_parameter_wrapper">';
        for( $i=0; $i<count( $agent_custom_data ); $i++ ){
            ?>  
            <div class="col-md-4">
                <span class="custom_parameter_label">
                    <?php print esc_html($agent_custom_data[$i]['label']); ?>
                </span>
                <span class="custom_parameter_value">
                    <?php print esc_html($agent_custom_data[$i]['value']); ?>
                </span>
            </div>
            <?php
        }
        print '</div>';
    }
}