<?php

add_action('init', 'zlots_register_cpt_news', 0 );

function zlots_register_cpt_news() {
	$news_slug = 'news';

	$args = array(
		'labels'             => array(
			'name'         => esc_html__( 'News', 'aces' ),
			'add_new'      => esc_html__( 'Add New', 'aces' ),
			'edit_item'    => esc_html__( 'Edit Item', 'aces' ),
			'add_new_item' => esc_html__( 'Add New', 'aces' ),
			'view_item'    => esc_html__( 'View Item', 'aces' ),
		),
		'singular_label'     => __( 'news' ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_rest'       => true,
		'capability_type'    => 'post',
		'hierarchical'       => false,
		'supports'           => array(
			'title',
			'editor',
			'author',
			'comments',
			'thumbnail',
			'excerpt',
			'revisions'
		),
		'has_archive'        => false
	);

	register_post_type( 'news', $args );
}



add_action('init', 'zx_aces_casinos', 0 );

function zx_aces_casinos(){

	$games_vendor_title = esc_html__('Vendors', 'aces');
	if ( get_option( 'games_vendor_title') ) {
		$games_vendor_title = get_option( 'games_vendor_title', 'Vendors' );
	}

	$labels = array(
		'name' => $games_vendor_title,
		'singular_name' => $games_vendor_title,
		'search_items' => esc_html__('Find Taxonomy', 'aces'),
		'all_items' => esc_html__('All ', 'aces') . $games_vendor_title,
		'parent_item' => esc_html__('Parent Taxonomy', 'aces'),
		'parent_item_colon' => esc_html__('Parent Taxonomy:', 'aces'),
		'edit_item' => esc_html__('Edit Taxonomy', 'aces'),
		'view_item' => esc_html__('View Taxonomy', 'aces'),
		'update_item' => esc_html__('Update Taxonomy', 'aces'),
		'add_new_item' => esc_html__('Add New Taxonomy', 'aces'),
		'new_item_name' => esc_html__('Taxonomy', 'aces'),
		'menu_name' => $games_vendor_title
	);

	$args = array(
		'labels' => $labels,
		'public' => true,
		'show_in_nav_menus' => true,
		'show_ui' => true,
		'show_in_rest' => true,
		'show_tagcloud' => true,
		'show_admin_column' => true,
		'hierarchical' => true,
		'update_count_callback' => '',
		'rewrite' => true,
		'query_var' => '',
		'capabilities' => array(),
		'_builtin' => false
	);

	register_taxonomy('vendor', ['game', 'casino'], $args);
}
