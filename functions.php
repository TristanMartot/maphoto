<?php

// action pour faire entrer en file d'attente le style.css du thème parent
add_action('wp_enqueue_scripts', 'theme_enqueue_styles', 20);

function theme_enqueue_styles() {
wp_enqueue_style( 'style', get_template_directory_uri() . '/style.css' );
wp_register_style( 'Space Mono', get_stylesheet_directory_uri().'/style.css' );
wp_register_style( 'Poppins', get_stylesheet_directory_uri().'/style.css' );
wp_enqueue_style( 'Space Mono' );
wp_enqueue_style( 'Poppins' );
wp_enqueue_script( 'script' , get_stylesheet_directory_uri() . '/js/scripts.js', [],'', array('strategy' => 'defer') );

}


?>