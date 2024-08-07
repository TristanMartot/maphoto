<?php

// Enqueue styles and custom scripts
add_action('wp_enqueue_scripts', 'theme_enqueue_assets', 20);

function theme_enqueue_assets() {
    // Register and enqueue custom styles
    wp_register_style('space-mono', get_stylesheet_directory_uri() . '/style.css');
    wp_register_style('poppins', get_stylesheet_directory_uri() . '/style.css');
    wp_enqueue_style('space-mono');
    wp_enqueue_style('poppins');

    // Enqueue custom scripts
    wp_enqueue_script('lightbox', get_stylesheet_directory_uri() . '/js/lightbox.js', [], '', true);
    wp_enqueue_script('navigation', get_stylesheet_directory_uri() . '/js/navigation.js', [], '', true);
    wp_enqueue_script('modale', get_stylesheet_directory_uri() . '/js/modale.js', [], '', true);
    wp_enqueue_script('selects_home', get_stylesheet_directory_uri() . '/js/selects_home.js', [], '', true);

    // Enqueue and localize custom script
    wp_enqueue_script('custom-script', get_stylesheet_directory_uri() . '/js/ajax_home_photo.js', ['jquery'], '', true);
    wp_localize_script('custom-script', 'ajax_object', [
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('mota_load_photo')
    ]);
}

// Add custom image size for slider
add_action('after_setup_theme', 'add_custom_image_size');

function add_custom_image_size() {
    add_theme_support('post-thumbnails');
    add_image_size('previous', 70);
}

// Get the next post by date
function get_next_post_by_date() {
    global $post;

    $current_post_date = get_the_date('Y-m-d H:i:s', $post->ID);

    $args = [
        'post_type' => 'photo',
        'posts_per_page' => 1,
        'orderby' => 'date',
        'order' => 'ASC',
        'post_status' => 'publish',
        'date_query' => [
            'after' => $current_post_date,
            'inclusive' => false,
        ],
    ];

    $next_post_query = new WP_Query($args);

    if ($next_post_query->have_posts()) {
        while ($next_post_query->have_posts()) {
            $next_post_query->the_post();
            $next_post_id = get_the_ID();
            wp_reset_postdata();
            return $next_post_id;
        }
    } else {
        echo '';
    }
}

// Get the previous post by date
function get_previous_post_by_date() {
    global $post;

    $current_post_date = get_the_date('Y-m-d H:i:s', $post->ID);

    $args = [
        'post_type' => 'photo',
        'posts_per_page' => 1,
        'orderby' => 'date',
        'order' => 'DESC',
        'post_status' => 'publish',
        'date_query' => [
            'before' => $current_post_date,
            'inclusive' => false,
        ],
    ];

    $previous_post_query = new WP_Query($args);

    if ($previous_post_query->have_posts()) {
        while ($previous_post_query->have_posts()) {
            $previous_post_query->the_post();
            $previous_post_id = get_the_ID();
            wp_reset_postdata();
            return $previous_post_id;
        }
    } else {
        echo '';
    }
}

// AJAX action for loading initial photos
add_action('wp_ajax_mota_load_initial_photos', 'mota_load_initial_photos');
add_action('wp_ajax_nopriv_mota_load_initial_photos', 'mota_load_initial_photos');

function mota_load_initial_photos() {
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'mota_load_photo')) {
        wp_send_json_error("Unauthorized action", 403);
    }

    $postsPerPage = isset($_POST['post']) ? intval($_POST['post']) : 8;

    $args = [
        'post_type' => 'photo',
        'posts_per_page' => $postsPerPage,
        'orderby' => 'date',
        'order' => 'DESC',
    ];

    set_query_var('args', $args);

    ob_start();
    get_template_part('templates_parts/photo_block');
    $html = ob_get_clean();

    wp_send_json_success($html);
}

// AJAX action for loading sorted photos
add_action('wp_ajax_mota_load_sorted_photos', 'mota_load_sorted_photos');
add_action('wp_ajax_nopriv_mota_load_sorted_photos', 'mota_load_sorted_photos');

function mota_load_sorted_photos() {
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'mota_load_photo')) {
        wp_send_json_error("Unauthorized action", 403);
    }

    $postsPerPage = isset($_POST['post']) ? intval($_POST['post']) : 8;
    $date_order = isset($_POST['date_order']) ? $_POST['date_order'] : 'DESC';
    $category = isset($_POST['category']) ? $_POST['category'] : '';
    $format = isset($_POST['format']) ? $_POST['format'] : '';

    $args = [
        'post_type' => 'photo',
        'posts_per_page' => $postsPerPage,
        'orderby' => 'date',
        'order' => $date_order,
    ];

    if (!empty($category)) {
        $args['tax_query'][] = [
            'taxonomy' => 'categorie',
            'field' => 'slug',
            'terms' => $category,
        ];
    }

    if (!empty($format)) {
        $args['tax_query'][] = [
            'taxonomy' => 'format',
            'field' => 'slug',
            'terms' => $format,
        ];
    }

    set_query_var('args', $args);

    ob_start();
    get_template_part('templates_parts/photo_block');
    $html = ob_get_clean();

    wp_send_json_success($html);
}

// AJAX action for loading more photos
add_action('wp_ajax_mota_load_more_photos', 'mota_load_more_photos');
add_action('wp_ajax_nopriv_mota_load_more_photos', 'mota_load_more_photos');

function mota_load_more_photos() {
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'mota_load_photo')) {
        wp_send_json_error("Unauthorized action", 403);
    }

    $postsPerPage = isset($_POST['post']) ? intval($_POST['post']) : 8;
    $offset = isset($_POST['offset']) ? intval($_POST['offset']) : 0;
    $date_order = isset($_POST['date_order']) ? $_POST['date_order'] : 'DESC';
    $category = isset($_POST['category']) ? $_POST['category'] : '';
    $format = isset($_POST['format']) ? $_POST['format'] : '';

    $args = [
        'post_type' => 'photo',
        'posts_per_page' => $postsPerPage,
        'offset' => $offset,
        'orderby' => 'date',
        'order' => $date_order,
    ];

    if (!empty($category)) {
        $args['tax_query'][] = [
            'taxonomy' => 'category',
            'field' => 'slug',
            'terms' => $category,
        ];
    }

    if (!empty($format)) {
        $args['tax_query'][] = [
            'taxonomy' => 'format',
            'field' => 'slug',
            'terms' => $format,
        ];
    }

    set_query_var('args', $args);

    ob_start();
    get_template_part('templates_parts/photo_block');
    $html = ob_get_clean();

    wp_send_json_success($html);
}
?>
