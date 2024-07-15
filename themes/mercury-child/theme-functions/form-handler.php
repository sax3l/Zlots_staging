<?php

add_action( 'wp_ajax_zlots_search_form', 'zlots_search_form' );
add_action( 'wp_ajax_nopriv_zlots_search_form', 'zlots_search_form' );
function zlots_search_form() {
	$nonce = filter_input( INPUT_POST, 'nonce', FILTER_UNSAFE_RAW );

	if ( ! wp_verify_nonce( $nonce, ZLOTS_NONCE_NAME ) ) {
		wp_send_json_error( [ 'error' => esc_html__( 'Form error', 'zlots' ) ] );
	}

	$search = filter_input( INPUT_POST, 'search', FILTER_SANITIZE_SPECIAL_CHARS );

	if ( ! $search ) {
		wp_send_json_error( [ 'error' => esc_html__( 'Search field is empty', 'zlots' ) ] );
	}

	$result = zlots_search_request( $search );

	if ( ! $result || ! is_array( $result ) ) {
		wp_send_json_error( [ 'error' => esc_html__( 'Nothing found', 'zlots' ) ] );
	}

	$html_result = zlots_get_html_for_search_result( $result );

	wp_send_json_success( [ 'result' => $html_result ] );
}

function zlots_search_request( $string ) {
	$query_args = [
		'post_type'      => [ 'casino', 'game' ],
		'post_status'    => 'publish',
		'fields'         => 'ids',
		's'              => $string,
		'no_found_rows'  => true,
		'posts_per_page' => 20,
		'orderby'        => 'date',
		'order'          => 'DESC'
	];

	$query = get_posts( $query_args );

	if ( $query && is_array( $query ) ) {
		return $query;
	}

	return null;
}

function zlots_get_html_for_search_result( $query_ids ) {
	$list = '';

	ob_start();
	foreach ( $query_ids as $id ) {
		?>
		<li><a href="<?php echo get_the_permalink( $id ) ?>"><?php echo get_the_title( $id ) ?></a></li>
		<?php
	}
	$list = ob_get_clean();

	return '<ul>' . $list . '</ul>';
}

add_action( 'wp_ajax_loadmore_casino', 'zlots_loadmore_casino' );
add_action( 'wp_ajax_nopriv_loadmore_casino', 'zlots_loadmore_casino' );

function zlots_loadmore_casino() {
	$nonce = filter_input( INPUT_POST, 'nonce', FILTER_UNSAFE_RAW );
	
	if ( ! wp_verify_nonce( $nonce, ZLOTS_NONCE_NAME ) ) {
		wp_send_json_error( [ 'error' => esc_html__( 'Form error', 'zlots' ) ] );
	}
	
	$offset = filter_input( INPUT_POST, 'offset', FILTER_VALIDATE_INT );

	if ( ! $offset ) {
		wp_send_json_error( [ 'error' => esc_html__( 'Form error', 'zlots' ) ] );
	}

	$tax = zlots_get_filter_casinos_tax();

	$casinos_list = zlots_get_casinos_archive_query_with_bonus( $offset, $tax, true );
	$casinos_html = zlots_get_casinos_archive_html( $casinos_list, false );
	
	wp_send_json( [ $casinos_html ], 200 );
}

add_action( 'wp_ajax_filter_slots', 'zlots_filter_slots' );
add_action( 'wp_ajax_nopriv_filter_slots', 'zlots_filter_slots' );

function zlots_filter_slots() {
    $nonce = filter_input(INPUT_POST, 'nonce', FILTER_UNSAFE_RAW);
    $sort_by = filter_input(INPUT_POST, 'sort_by', FILTER_SANITIZE_STRING);
    $offset = filter_input(INPUT_POST, 'offset', FILTER_SANITIZE_STRING);
    $categories = filter_input(INPUT_POST, 'game-category', FILTER_SANITIZE_STRING);
    $vendors = filter_input(INPUT_POST, 'vendor', FILTER_SANITIZE_STRING); // Added line to capture vendors

    if (!wp_verify_nonce($nonce, ZLOTS_NONCE_NAME)) {
        wp_send_json_error(['error' => esc_html__('Form error, received nonce: ' . $nonce, 'zlots')]);
    }

    $game_categories = !empty($categories) ? explode(',', $categories) : [];
    $game_vendors = !empty($vendors) ? explode(',', $vendors) : []; // Process vendors input

    $slot_list = zlots_get_slots_archive_filter_query($offset, false, $game_categories, $game_vendors); // Pass vendors to the query function
	//wp_send_json($slot_list, 200);
    $slot_html = zlots_get_slots_archive_html($slot_list, false);

    wp_send_json([$slot_html], 200);
}


add_action( 'wp_ajax_filter_casino', 'zlots_filter_casino' );
add_action( 'wp_ajax_nopriv_filter_casino', 'zlots_filter_casino' );

function zlots_filter_casino() {
    $nonce = filter_input(INPUT_POST, 'nonce', FILTER_UNSAFE_RAW);
    $sort_by = filter_input(INPUT_POST, 'sort_by', FILTER_SANITIZE_STRING); // Added line to capture sort_by criteria
	$offset = filter_input(INPUT_POST, 'offset', FILTER_SANITIZE_STRING); // Added line to capture sort_by criteria
    if (!wp_verify_nonce($nonce, ZLOTS_NONCE_NAME)) {
        wp_send_json_error(['error' => esc_html__('Form error, received nonce: ' . $nonce, 'zlots')]);
    }

    $tax = zlots_get_slider_filter_casinos_tax();
    $casinos_list = zlots_get_casinos_archive_query_with_bonus($offset, $tax, false, $sort_by); // Pass sort_by to the query function
    $casinos_html = zlots_get_casinos_archive_html($casinos_list, false);

    wp_send_json([$casinos_html], 200);
}



add_action( 'wp_ajax_filter_slider_casino', 'zlots_slider_filter_casino' );
add_action( 'wp_ajax_nopriv_slider_filter_casino', 'zlots_slider_filter_casino' );

function zlots_slider_filter_casino() {
	$nonce = filter_input( INPUT_POST, 'nonce', FILTER_UNSAFE_RAW );

	if ( ! wp_verify_nonce( $nonce, ZLOTS_NONCE_NAME ) ) {
		wp_send_json_error( [ 'error' => esc_html__( 'Form error, received nonce: ' . $nonce, 'zlots' ) ] );
	}

	$tax = zlots_get_slider_filter_casinos_tax();
	//wp_send_json( "MIN FS: ".$tax['free_spins']['min']);
	$casinos_list = zlots_get_casinos_archive_query_with_bonus( 0, $tax, false);
	$casinos_html = zlots_get_casinos_archive_html( $casinos_list, false );

	wp_send_json( [ $casinos_html ], 200 );
	//wp_send_json( [	$casinos_list ], 200 );
}
