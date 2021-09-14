<?php
/*Ajouter la prise en charge des images mises en avant*/
add_theme_support('post-thumbnails');

/*Ajouter automatiquement le titre du site dans l'en-tête du site*/
add_theme_support('title-tag');

function al_semantic_register_assets()
{
    // JS de semantic
    wp_enqueue_script(
        'al_semantic_js',
        // get_stylesheet_directory_uri donne le bon chemin dans le dossier des assets
        get_stylesheet_directory_uri() . '/semantic-ui/semantic.min.js',
        ['jquery'], // dependance
        '1.0'
    );

    // style
    wp_enqueue_style('al_semantic_css', get_stylesheet_directory_uri() . '/semantic-ui/semantic.min.css');
};
add_action('wp_enqueue_scripts', 'al_semantic_register_assets');

function register_my_menus()
{
    register_nav_menus(
        array(
            'main' => __('Menu principal'),
            'footer' => __('Menu bas de page'),
            'main_country' =>  __('Menu Country'),
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

function al_codex_artiste_init()
{
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
        'rewrite'            => ['slug' => 'artiste'],
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 2,
        'supports'           => ['title', 'editor', 'author', 'thumbnail'],
    ];

    register_post_type('artiste', $args);
}

add_action('init', 'al_codex_artiste_init');

// taxonomie
function create_country_hierarchical_taxonomy()
{

    $labels = [
        'name' => "pays",
        'singular_name' => "Pays",
        'search_items' =>  "rechercher un pays",
        'all_items' => "Tous les pays",
        'parent_item' => "Le parent de pays",
        'parent_item_colon' => "Pays:",
        'edit_item' => "Editer un pays",
        'update_item' => "Mettre à jour un pays",
        'add_new_item' => "ajouter un pays",
        'new_item_name' => "Nous pays",
        'menu_name' => "Pays",
    ];

    // Créer la taxonomy est l'associer à un/des CPT ou post
    register_taxonomy('country', ['artiste'], [
        'hierarchical' => true, // ou false si c'est faux alors c'est comme des étiquettes ou tags
        'labels' => $labels,
        'show_ui' => true,
        'show_in_rest' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => ['slug' => 'countries'],
    ]);
}

add_action('init', 'create_country_hierarchical_taxonomy');

// HOOK

function al_wp_cpt($query)
{

    // boucle principale qui affiche les contenus dans le templating de WP
    // On précise que l'on souhaite afficher les CPT en page d'accueil
    if (is_home() && $query->is_main_query()) {
        $query->set('post_type', ['artiste']);
        // die("MAIN QUERY");

        return $query; // pensez à retourner la query pour les autres fonctions puissent travailler avec éventuellement
    }
}

// Permet d'afficher les CPT et les contenus 
add_action('pre_get_posts', 'al_wp_cpt');
