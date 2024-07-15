<?php
add_shortcode( 'zlots-slots-tab', 'zlots_slots_tab_shortcode_function' );
function zlots_slots_tab_shortcode_function(){
	$slots_new_query = zlots_get_slots_for_tab('new');
	$slots_upcoming_query = zlots_get_slots_for_tab('upcoming');
	$slots_month_query = zlots_get_slots_for_tab('month');

	ob_start();
	get_template_part( 'theme-parts/slots-tab', null, [
		'new'      => $slots_new_query,
		'upcoming' => $slots_upcoming_query,
		'month'    => $slots_month_query
	] );

	return ob_get_clean();
}



add_shortcode( 'zlots-search-form', 'zlots_search_shortcode_function' );
function zlots_search_shortcode_function() {
	ob_start();
	get_template_part( 'theme-parts/form-search-main' );

	return ob_get_clean();
}

add_shortcode( 'zlots-slots-banner', 'zlots_slots_banner_function' );
function zlots_slots_banner_function( $attr ) {
	$slot_id = $attr['slot-id'] ?? null;

	if ( ! $slot_id ) {
		return null;
	}

	ob_start();
	get_template_part( 'theme-parts/slots-banner', null, [ 'slot_id' => $slot_id ] );

	return ob_get_clean();
}

add_shortcode( 'zlots-recommended-casinos-block', 'zlots_casinos_recommended_shortcode_function' );
function zlots_casinos_recommended_shortcode_function( $attr ) {

	$recommended_casinos = zlots_get_recommended_casinos();

	if ( ! $recommended_casinos ) {
		return null;
	}

	ob_start();
	get_template_part( 'theme-parts/block-recommended-casinos', null, ['casinos_ids' => $recommended_casinos] );

	return ob_get_clean();
}



add_shortcode( 'zlots-top-rated-casinos', 'zlots_top_rated_casinos_shortcode_function' );
function zlots_top_rated_casinos_shortcode_function( $attr ){
	$title = $attr['title'] ?? 'Top Rated Casinos';
	$casinos_ids = zlots_get_top_rated_casinos();

	ob_start();
	get_template_part( 'theme-parts/block-top-rated-casinos', null, ['title' => $title, 'casinos' => $casinos_ids] );

	return ob_get_clean();
}

add_shortcode( 'zlots-show-news', 'zlots_show_front_news_shortcode_function' );
function zlots_show_front_news_shortcode_function( $attr ){
	$title = $attr['title'] ?? 'News';
	$news_ids = zlots_get_news_for_front_page();

	ob_start();
	get_template_part( 'theme-parts/block-news', null, ['title' => $title, 'news' => $news_ids] );

	return ob_get_clean();
}

add_shortcode( 'zlots-slots-block', 'zlots_show_slots_shortcode_function' );
function zlots_show_slots_shortcode_function( $attr ) {
	$title     = $attr['title'] ?? 'More Slots';
	$slots_ids = zlots_get_slots_for_front_page();

	ob_start();
	get_template_part( 'theme-parts/block-slots', null, [ 'title' => $title, 'slots' => $slots_ids ] );

	return ob_get_clean();
}

add_shortcode( 'zlots-top-providers-block', 'zlots_show_top_providers_shortcode_function' );
function zlots_show_top_providers_shortcode_function( $attr ) {
	$title     = $attr['title'] ?? 'Top Providers';
	$providers_ids = zlots_get_top_providers();

	ob_start();
	get_template_part( 'theme-parts/block-top-providers', null, [ 'title' => $title, 'providers' => $providers_ids ] );

	return ob_get_clean();
}
// Lägg till Shortcode
add_shortcode('zlots-widget-recommended-casinos', 'zlots_widget_recommended_casinos_shortcode_function');

function zlots_widget_recommended_casinos_shortcode_function($attr) {
    // Hämta de rekommenderade casinona från någon funktion eller alternativ
    $recommended_casinos = zlots_get_recommended_casinos(); // Uppdatera denna funktion för att hämta de rekommenderade casinona

    if (!$recommended_casinos) {
        return null;
    }

    ob_start();
    get_template_part('theme-parts/widget-recommended-casinos', null, ['casinos_ids' => $recommended_casinos]);
    return ob_get_clean();
}
