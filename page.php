<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that other
 * 'pages' on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage Motaphoto
 * @since Motaphoto 1.0
 */

get_header(); // Inclut le header.php du thème
?>

<main id="main" class="site-main">
    <?php 
// 1. On définit les arguments pour définir ce que l'on souhaite récupérer
$args = array(
    'post_type' => 'photo',
    'posts_per_page' => 1,
    'orderby' => 'rand',
);

// 2. On exécute la WP Query
$my_query = new WP_Query( $args );

// 3. On lance la boucle !
if( $my_query->have_posts() ) : 
    while( $my_query->have_posts() ) : 
        $my_query->the_post();
        
        $image_url = esc_url(wp_get_attachment_image_src(get_post_thumbnail_id(), "full")[0]);

        echo '<div class="hero" style="background-image: url(' . $image_url . ');">';

    endwhile;
endif;

// 4. On réinitialise à la requête principale (important)
wp_reset_postdata();
?>
<h1>Photographe Event</h1>
</div>
</main><!-- #main -->

<?php
get_footer(); // Inclut le footer.php du thème
?>