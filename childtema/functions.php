<?php 
function hello_elementor_child_styles() {
    /* Länka först in förälder-temats stilmall */
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );

    /* Och sedan länka in child-temats stilmall */
    wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css');

    /* Länka in en Google-font */
    wp_enqueue_style('Paytone one', 'https://fonts.googleapis.com/css2?family=Paytone+One&display=swap');
    wp_enqueue_style('Arvo', 'https://fonts.googleapis.com/css2?family=Arvo:ital,wght@0,400;0,700;1,400;1,700&display=swap');
    
}
/* Kör funktionen för att hämta in stilarna */ 
add_action( 'wp_enqueue_scripts', 'hello_elementor_child_styles' );
 
?>