<?php

// action pour faire entrer en file d'attente le style.css du thème parent
add_action('wp_enqueue_scripts', 'theme_enqueue_styles', 20);

function theme_enqueue_styles() {
wp_enqueue_style( 'style', get_template_directory_uri() . '/style.css' );
wp_register_style( 'Space Mono', get_stylesheet_directory_uri().'/style.css' );
wp_register_style( 'Poppins', get_stylesheet_directory_uri().'/style.css' );
wp_enqueue_style( 'Space Mono' );
wp_enqueue_style( 'Poppins' );
wp_enqueue_script( 'script' , get_stylesheet_directory_uri() . '/js/scripts.js', array( 'jquery' ),'', array('strategy' => 'defer') );

}


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
