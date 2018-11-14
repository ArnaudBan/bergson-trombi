<?php
/*
Plugin Name: Bergson trombi
Plugin URI: https://github.com/ArnaudBan/bergson-trombi
Description: Gérer le trombinoscope des parents élu de l'école Henri Bergson à Nantes
Version: 1.0
Author: ArnaudBAn
Author URI: https://arnaudban.me
License: GNU GENERAL PUBLIC LICENSE Version 3
*/

add_action( 'init', 'btrom_register_post_type' );


function btrom_register_post_type(){

	register_post_type( 'elected_parent',
		array(
			'labels' => array(
				'name'          => 'Parents',
				'singular_name' => 'Parent',
				'add_new'       => __('Add New' ),
				'add_new_item'  => 'Ajouter un parent',
				'edit_item'     => 'Modifier un parent',
				'new_item'      => 'Nouveau parent',
				'view_item'     => 'Voir le parent',
				'view_items'    => 'Voir les parents',
				'search_items'  => 'Rechercher un parent',
				'not_found'     => 'Aucun parent trouvé',
				'not_found_in_trash'    => 'Aucun parent trouvé dans la corbeil',
				'featured_image'        => 'Portrait du parent',
				'set_featured_image'    => 'Ajouter un portrait',
				'remove_featured_image' => 'Supprimer le portrait',
			),
			'public'        => false,
			'show_ui'       => true,
			'menu_icon'     => 'dashicons-businessman',
			'supports'      => array( 'title', 'editor', 'revisions', 'thumbnail')
		));

	register_taxonomy( 'year', 'elected_parent', array(
		'labels'    => array(
			'name'          => 'Années',
			'singular_name' => 'Année',
			'search_items'  => 'Rechercher une année',
			'all_items'     => 'Toutes les années',
			'parent_item'   => 'Année parent',
			'parent_item_colon' => 'Année parent:',
			'edit_item'     => 'Modifier l‘Année',
			'view_item'     => 'Voir l‘année',
			'update_item'   => 'Mettre à jours l‘année',
			'add_new_item'  => 'Ajouter une année',
			'new_item_name' => 'Nouveau nom d‘année',
		),
		'hierarchical'  => true,
		'public'        => false,
		'show_ui'       => true,
		'show_admin_column'   => true
	));

	wp_register_script(
		'bergson-trombi-block',
		plugins_url( 'dist/index.js', __FILE__ ),
		array( 'wp-element' )
	);

	wp_register_style(
		'bergson-trombi-style',
		plugins_url( 'dist/index.css', __FILE__ ),
		array()
	);

	if( function_exists( 'register_block_type' ) ){

		register_block_type( 'bergson/trombi', array(
			'editor_script'     => 'bergson-trombi-block',
			'render_callback'   => 'bergson_trombi_render_block',
			'editor_style'      => 'bergson-trombi-style',
			'style'             => 'bergson-trombi-style',
		) );
	}
}


function bergson_trombi_render_block( $args ){

	$parents_query = new WP_Query( array(
		'post_type'         => 'elected_parent',
		'posts_per_page'    => 20,
		'no_found_rows'     => true
	));

	$response = '';
	if( $parents_query->have_posts() ){

		$response .= '<div class="elected-parent-wrapper">';
		ob_start();
		while ($parents_query->have_posts() ){
			$parents_query->the_post();

			include 'templates/trombi.php';
		}
		$response .= ob_get_clean();
		$response .= '</div>';
	}

	return $response;
}