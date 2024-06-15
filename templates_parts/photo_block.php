<?php 
$post = get_post();
$postId = $post->ID;
$category = get_field('categorie', $postId);
// 1. On définit les arguments pour définir ce que l'on souhaite récupérer
$args = array(
    'post_type' => 'photo',
    'categorie' => $category[0]->slug,
    'posts_per_page' => 2,
    'orderby' => 'rand',
);

// 2. On exécute la WP Query
$my_query = new WP_Query( $args );

// 3. On lance la boucle !
if( $my_query->have_posts() ) : while( $my_query->have_posts() ) : $my_query->the_post();
    
echo '<div class="photo-container">
        <div class="block_image">
            <img src="' . esc_url(wp_get_attachment_image_src(get_post_thumbnail_id(), "large")[0]) . '">
        </div>
        <div class="block_info">
            <div class="info_reference">' . esc_html(get_field('reference')) . '</div>
            <div class="info_category">' . esc_html($category[0]->name) . '</div>
            <div class="eye_lightbox"><img src="' . esc_url(get_stylesheet_directory_uri()) . '/assets/eye.png" href="#"></div>
            <div class="full_screen_lightbox"><img src="' . esc_url(get_stylesheet_directory_uri()) . '/assets/fullscreen.png" href="#"></div>
        </div>
    </div>';

endwhile;
endif;

// 4. On réinitialise à la requête principale (important)
wp_reset_postdata();
?>
