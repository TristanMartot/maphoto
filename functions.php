<?php

// action pour faire entrer en file d'attente le style.css du thème parent
add_action('wp_enqueue_scripts', 'theme_enqueue_styles', 20);

function theme_enqueue_styles() {
wp_enqueue_style( 'style', get_template_directory_uri() . '/style.css' );
wp_register_style( 'Space Mono', get_stylesheet_directory_uri().'/style.css' );
wp_register_style( 'Poppins', get_stylesheet_directory_uri().'/style.css' );
wp_enqueue_style( 'Space Mono' );
wp_enqueue_style( 'Poppins' );

}

function enqueue_custom_scripts() {
    // Enqueuer le script avec 'jquery' comme dépendance
    wp_enqueue_script(
        'custom-script',
        get_stylesheet_directory_uri() . '/js/scripts.js',
        array('jquery'),
        '',
        true // Charge le script en pied de page
    );

    // Localiser le script pour passer des variables PHP à JavaScript
    wp_localize_script(
        'custom-script',
        'ajax_object',
        array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('capitaine_load_photo')
        )
    );
}
add_action('wp_enqueue_scripts', 'enqueue_custom_scripts');


function get_next_post_by_date() {
    global $post;
    
    // Get current post date
    $current_post_date = get_the_date('Y-m-d H:i:s', $post->ID);
    
    // Setup WP_Query arguments
    $args = array(
        'post_type'      => 'photo', // You can change this to your custom post type
        'posts_per_page' => 1,
        'orderby'        => 'date',
        'order'          => 'ASC',
        'post_status'    => 'publish',
        'date_query'     => array(
            'after' => $current_post_date,
            'inclusive' => false,
        ),
    );
    
    // Perform the query
    $next_post_query = new WP_Query($args);
    
    // Check if there's a post found
    if ($next_post_query->have_posts()) {
        while ($next_post_query->have_posts()) {
                $next_post_query->the_post(); // Préparer les données du post
                $next_post_id = get_the_ID(); // Récupérer l'ID du post
                wp_reset_postdata(); // Réinitialiser les données de post
                return $next_post_id; // Retourner l'ID du post
        }
    } else {
        echo 'No next post found.';
    }
}

function get_previous_post_by_date() {
    global $post;
    
    // Get current post date
    $current_post_date = get_the_date('Y-m-d H:i:s', $post->ID);
    
    // Setup WP_Query arguments
    $args = array(
        'post_type'      => 'photo', // You can change this to your custom post type
        'posts_per_page' => 1,
        'orderby'        => 'date',
        'order'          => 'DESC',
        'post_status'    => 'publish',
        'date_query'     => array(
            'before' => $current_post_date,
            'inclusive' => false,
        ),
    );
    
    // Perform the query
    $previous_post_query = new WP_Query($args);
    
    // Check if there's a post found
    if ($previous_post_query->have_posts()) {
        while ($previous_post_query->have_posts()) {
                $previous_post_query->the_post(); // Préparer les données du post
                $previous_post_id = get_the_ID(); // Récupérer l'ID du post
                wp_reset_postdata(); // Réinitialiser les données de post
                return $previous_post_id; // Retourner l'ID du post
        }
    } else {
        echo 'No next post found.';
    }
}

function add_size_slider_image() {
    add_theme_support( 'post-thumbnails' );
	add_image_size('previous', 70);
}
add_action( 'after_setup_theme', 'add_size_slider_image' );


function capitaine_load_initial_photos() {
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'capitaine_load_photo')) {
        wp_send_json_error("Unauthorized action", 403);
    }

    $postsPerPage = isset($_POST['post']) ? intval($_POST['post']) : 8;

    $args = array(
        'post_type' => 'photo',
        'posts_per_page' => $postsPerPage,
        'orderby' => 'date',
        'order' => 'DESC',
    );

    set_query_var('args', $args);

    ob_start();
    get_template_part('templates_parts/photo_block');
    $html = ob_get_clean();

    wp_send_json_success($html);
}

function capitaine_load_sorted_photos() {
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'capitaine_load_photo')) {
        wp_send_json_error("Unauthorized action", 403);
    }

    $postsPerPage = isset($_POST['post']) ? intval($_POST['post']) : 8;
    $date_order = isset($_POST['date_order']) ? $_POST['date_order'] : 'DESC';
    $category = isset($_POST['category']) ? $_POST['category'] : '';
    $format = isset($_POST['format']) ? $_POST['format'] : '';

    $args = array(
        'post_type' => 'photo',
        'posts_per_page' => $postsPerPage,
        'orderby' => 'date',
        'order' => $date_order,
    );

    if (!empty($category)) {
        $args['tax_query'][] = array(
            'taxonomy' => 'categorie',
            'field' => 'slug',
            'terms' => $category,
        );
    }

    if (!empty($format)) {
        $args['tax_query'][] = array(
            'taxonomy' => 'format',
            'field' => 'slug',
            'terms' => $format,
        );
    }

    set_query_var('args', $args);

    ob_start();
    get_template_part('templates_parts/photo_block');
    $html = ob_get_clean();

    wp_send_json_success($html);
}

function capitaine_load_more_photos() {
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'capitaine_load_photo')) {
        wp_send_json_error("Unauthorized action", 403);
    }

    $postsPerPage = isset($_POST['post']) ? intval($_POST['post']) : 8;
    $offset = isset($_POST['offset']) ? intval($_POST['offset']) : 0;
    $date_order = isset($_POST['date_order']) ? $_POST['date_order'] : 'DESC';
    $category = isset($_POST['category']) ? $_POST['category'] : '';
    $format = isset($_POST['format']) ? $_POST['format'] : '';

    $args = array(
        'post_type' => 'photo',
        'posts_per_page' => $postsPerPage,
        'offset' => $offset,
        'orderby' => 'date',
        'order' => $date_order,
    );

    if (!empty($category)) {
        $args['tax_query'][] = array(
            'taxonomy' => 'category',
            'field' => 'slug',
            'terms' => $category,
        );
    }

    if (!empty($format)) {
        $args['tax_query'][] = array(
            'taxonomy' => 'format',
            'field' => 'slug',
            'terms' => $format,
        );
    }

    set_query_var('args', $args);

    ob_start();
    get_template_part('templates_parts/photo_block');
    $html = ob_get_clean();

    wp_send_json_success($html);
}

add_action('wp_ajax_capitaine_load_initial_photos', 'capitaine_load_initial_photos');
add_action('wp_ajax_nopriv_capitaine_load_initial_photos', 'capitaine_load_initial_photos');
add_action('wp_ajax_capitaine_load_sorted_photos', 'capitaine_load_sorted_photos');
add_action('wp_ajax_nopriv_capitaine_load_sorted_photos', 'capitaine_load_sorted_photos');
add_action('wp_ajax_capitaine_load_more_photos', 'capitaine_load_more_photos');
add_action('wp_ajax_nopriv_capitaine_load_more_photos', 'capitaine_load_more_photos');

