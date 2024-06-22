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

    <div class="page_parent_container">
        <div class="select_container">
            <div class="custom-select">
                <button class="select-button" role="combobox" aria-labelledby="select button" aria-haspopup="listbox" aria-expanded="false" aria-controls="select-dropdown">
                    <span class="selected-value">CATEGORIES</span>
                    <span class="arrow"></span>
                </button>
                <ul class="select-dropdown" role="listbox" id="select-dropdown">
                    <li role="option">
                        <label for="select-category">
                            <input id="select-category" name="category" value="" type="radio" />
                            <i class="bx bxl-reddit"></i>Toutes les catégories
                        </label>
                    </li>
                    <?php
                    $categories = get_terms(array(
                        'taxonomy' => 'categorie',
                        'hide_empty' => false,
                    ));
                    foreach ($categories as $category) {
                        $input_id = 'select-category-' . esc_attr($category->slug); // Créer un ID unique pour chaque input
                        echo '<li role="option">
                                <label for="' . $input_id . '">
                                    <input id="' . $input_id . '" name="category" value="' . esc_attr($category->slug) . '" type="radio" />
                                    <i class="bx bxl-reddit"></i>' . esc_html($category->name) . '
                                </label>
                            </li>';
                        }
                    ?>
                </ul>
        </div>

        <div class="custom-select">
            <button class="select-button" role="combobox" aria-labelledby="select button" aria-haspopup="listbox" aria-expanded="false" aria-controls="select-dropdown">
                <span class="selected-value">FORMATS</span>
                <span class="arrow"></span>
            </button>
            <ul class="select-dropdown" role="listbox" id="select-dropdown">
                    <li role="option">
                        <label for="select-format">
                            <input id="select-format" name="format" value="" type="radio" />
                            <i class="bx bxl-reddit"></i>Tous les formats
                        </label>
                    </li>
                <?php
                    $formats = get_terms(array(
                        'taxonomy' => 'format',
                        'hide_empty' => false,
                    ));
                    foreach ($formats as $format) {
                    $input_id = 'select-format-' . esc_attr($format->slug); // Créer un ID unique pour chaque input
                    echo '<li role="option">
                            <label for="' . $input_id . '">
                                <input id="' . $input_id . '" name="format" value="' . esc_attr($format->slug) . '" type="radio" />
                                <i class="bx bxl-reddit"></i>' . esc_html($format->name) . '
                            </label>
                        </li>';
                    }
                ?>
            </ul>
        </div>
        <div></div>
        <div class="custom-select">
            <button class="select-button" role="combobox" aria-labelledby="select button" aria-haspopup="listbox" aria-expanded="false" aria-controls="select-dropdown">
                <span class="selected-value">TRIER PAR</span>
                <span class="arrow"></span>
            </button>
            <ul class="select-dropdown" role="listbox" id="select-dropdown">
                <li role="option">
                    <label for="select-date-order-desc">
                        <input id="select-date-order-desc" name="date-order" value="DESC" type="radio" />
                        <i class="bx bxl-reddit"></i>A partir des plus récentes
                    </label>
                </li>
                <li role="option">
                    <label for="select-date-order-asc">
                        <input id="select-date-order-asc" name="date-order" value="ASC" type="radio" />
                        <i class="bx bxl-reddit"></i>A partir des plus anciennes
                    </label>
                </li>
            </ul>
        </div>    
    </div>
    <div class="home_container_photo_block">
        <div id="photos-container">
        </div>
    </div>        
        <button
            class="js-load-photo"
            data-post-on-page="<?php get_option('posts_per_page') ?>"
            data-nonce="<?php echo wp_create_nonce('capitaine_load_photo'); ?>"
            data-action="capitaine_load_photo"
            data-ajaxurl="<?php echo admin_url('admin-ajax.php'); ?>">
            Charger plus
        </button>
    </div>
</main><!-- #main -->

<?php
get_footer(); // Inclut le footer.php du thème
?>