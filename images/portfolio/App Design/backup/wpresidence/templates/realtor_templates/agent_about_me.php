<?php 
if ( 'estate_agent' == get_post_type($post->ID)) { ?>

    <div class="agent_content col-md-12">
        <h4><?php esc_html_e('About Me ','wpresidence'); ?></h4>    
        <?php the_content();?>
    </div>

<?php 
} 
?>