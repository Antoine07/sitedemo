<?php
/*Ajouter la prise en charge des images mises en avant*/
add_theme_support('post-thumbnails');

/*Ajouter automatiquement le titre du site dans l'en-tête du site*/
add_theme_support('title-tag');

function atypikhouseSite_register_assets()
{
    /*Déclarer jQuery*/
    wp_enqueue_script('jquery');

    /*Déclarer style.css à la racine du thème*/
    wp_enqueue_style(
        'atypikhouseSite',
        get_stylesheet_uri(),
        array(),
        '1.0'
    );
};
add_action('wp_enqueue_scripts', 'atypikhouseSite_register_assets');


function register_my_menus()
{
    register_nav_menus(
        array(
            'main' => __('Menu principal'),
            'footer' => __('Menu bas de page')
        )
    );
}
add_action('init', 'register_my_menus');


// Hook qui permet de modifier le comportement de votre 
// pensez à pré-fixer le nom de fonction pour éviter la collision des noms de fonctions entre les différents 
// plugins de WordPress, widgets ...
function al_excerpt_more($more)
{
    global $post;
    return '<a class="moretag" href="' . get_permalink($post->ID) . '"> En lire plus ...</a>';
}
add_filter('excerpt_more', 'al_excerpt_more');


// CUSTOM POST TYPE

function al_codex_artiste_init() {
    $labels = [
        'name'                  => "artiste",
        'singular_name'         => "artiste",
        'menu_name'             => "artiste",
        'name_admin_bar'        => "ajouter artiste",
        'add_new'               => "add new artiste",
        'add_new_item'          => "add item artiste",
    ];
 
    $args = [
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => [ 'slug' => 'artiste' ],
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => [ 'title', 'editor', 'author', 'thumbnail', 'excerpt' ],
    ];
 
    register_post_type( 'artiste', $args );
}
 
add_action( 'init', 'al_codex_artiste_init' );