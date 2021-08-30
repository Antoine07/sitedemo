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

## Taxonomy

Ils créent des termes permettant de catégoriser des contenus sous forme d'étiquette ou de hierarchie. Par exemple les articles dans WP peuvent être ranger dans une catégorie, c'est un terme de la taxonomie générique qu'est la catégorie.

```js

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
		'add_new_item' =>"ajouter un pays",
		'new_item_name' => "Nous pays",
		'menu_name' => "Pays",
	];

	// Créer la taxonomy est l'associer à un/des CPT ou post
	register_taxonomy('country', ['artiste', 'post'], [
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
```

## Affichez les CPT en page d'accueil