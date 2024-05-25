<?php

// action pour faire entrer en file d'attente le style.css du thème parent
add_action('wp_enqueue_scripts', 'theme_enqueue_styles', 20);

function theme_enqueue_styles() {
wp_enqueue_style( 'style', get_template_directory_uri() . '/style.css' );
}


?>