# WordPress 

## Custom post type

Nous allons découvrir les cpt

## Défintion 

Des contenus persnnalisés, ajoute à WP une meilleur sémantique pour administrer les contenus

```php

// Une fonction de callback qui sera appelée par le HOOK qui va créer le CPT artiste
function al_codex_artiste_init() {
    // les labels vont apparaître dans l'administration
    $labels = [
        'name'                  => "artiste",
        'singular_name'         => "artiste",
        'menu_name'             => "artiste",
        'name_admin_bar'        => "ajouter artiste",
        'add_new'               => "add new artiste",
        'add_new_item'          => "add item artiste",
    ];
    
    $args = [
        'labels'             => $labels, // labels définis plus haut
        'public'             => true, // si on veut que cela s'affiche dans le site et l'admin de WP
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => [ 'slug' => 'artiste' ], // SEO
        'capability_type'    => 'post', // attribue des droits sur l'administration de ces contenus les même que les articles
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 2, // définit la position dans le menu position 2 ils apparaîtront sous les articles
        'supports'           => [ 'title', 'editor', 'author', 'thumbnail', 'excerpt' ], // les attributs de votre CPT
    ];
    
    // la création du CPT il faut lui donner un nom autre que post, post c'est les articles de WP
    register_post_type( 'artiste', $args );
}

// HOOK init et qui permet de lancer une fonction qui va faire quelque chose dans le noyau de WP
add_action( 'init', 'al_codex_artiste_init' );
```