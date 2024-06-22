<?php
/**
 * The template for displaying all single posts
 *
 * @package WordPress
 * @subpackage Motaphoto
 * @since Motaphoto 1.0
 */

get_header(); // Inclut le header.php du thème
?>
<?php 

$post = get_post();
$postId = $post->ID;
$next_post_id = get_next_post_by_date();
$previous_post_id = get_previous_post_by_date();
?>

<main class="site-main">
    <div class="parent_container">
        <div id="single-photo">
            <div class="left">
                <div id="description">
                    <h2><?php echo str_replace(' ', '<br>', get_the_title()); ?></h2>
                    <p>Référence : <span id="reference"><?php echo get_field('reference', $postId); ?></span></p>
                    <p>Catégorie : <?php $terms = get_field('categorie', $postId);      
                        foreach ( $terms as $term ) {
                            echo  $term->name  ;
                        } ?>
                    </p>
                    <p>Format : <?php $terms2 = get_field('format', $postId);      
                        foreach ( $terms2 as $term ) {
                        echo  $term->name  ;
                        } ?>
                    </p>
                    <p>Type : <?php echo get_field('type', $postId); ?></p>
                    <p>Année : <?php echo the_time('Y'); ?></p>
                </div>
                <div id="contact">
                    <p>Cette photo vous intéresse ?</p>
                    <p><a id="open" href="#">Contact</a></p>
                </div>
            </div>
            <div class="right">
                <div id="image">
                    <?php echo get_the_post_thumbnail(); ?>
                </div>
                <div id="next">
                    <div class="arrow">
                        <a class="hover-title" href="<?php echo get_permalink($previous_post_id) ?>">
                            <img src="<?php echo get_stylesheet_directory_uri().'/assets/left.png' ?>">
                            <div class="hover-image-left">
                                <img src="<?php echo wp_get_attachment_image_src(get_post_thumbnail_id($previous_post_id),'previous')[0]; ?>">
                            </div>
                        </a>
                        <a class="hover-title" href="<?php echo get_permalink($next_post_id) ?>">
                            <img src="<?php echo get_stylesheet_directory_uri().'/assets/right.png' ?>">
                            <div class="hover-image">
                                <img src="<?php echo wp_get_attachment_image_src(get_post_thumbnail_id($next_post_id),'previous')[0]; ?>">
                            </div>
                        </a>
                    </div>
                </div>
            </div>    
        </div>
        <h3 class="maybe">Vous aimerez aussi :</h3>
        <div class="container_photo_block">  
            <? 
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
            
            // Passer les arguments à photo_block.php
            set_query_var('args', $args);
            get_template_part('templates_parts/photo_block'); ?>
        </div>
    </div>
</main><!-- #main -->
<?php
get_footer(); // Inclut le footer.php du thème
?>