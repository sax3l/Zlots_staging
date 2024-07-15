<?php

namespace Zlots\Casinos;

class Bonus
{
	private $bonus_id;

	private $allowed_html = [
		'a'      => [
			'href'   => true,
			'title'  => true,
			'target' => true,
			'rel'    => true
		],
		'img'    => [
			'src' => true,
			'alt' => true
		],
		'br'     => [],
		'em'     => [],
		'strong' => [],
		'span'   => [
			'class' => true
		],
		'div'    => [
			'class' => true
		],
		'p'      => [],
		'ul'     => [],
		'ol'     => [],
		'li'     => [],
	];

	public function __construct( $bonus_id ) {
		$this->bonus_id = $bonus_id;
	}

	public function get_categories() {
		return wp_get_object_terms( $this->bonus_id, 'bonus-category' );
	}

	public function get_link() {
		return get_permalink( $this->bonus_id );
	}

	public function get_allowed_html(){
		return $this->allowed_html;
	}

	public function get_code() {
		return esc_html( get_post_meta( $this->bonus_id, 'bonus_code', true ) );
	}

	public function get_amount() {
		return esc_html( get_post_meta( $this->bonus_id, 'zlots_bonus_amount', true ) );
	}

	public function get_percentage() {
		return esc_html( get_post_meta( $this->bonus_id, 'zlots_bonus_percentage', true ) );
	}

	public function get_wager() {
		return esc_html( get_post_meta( $this->bonus_id, 'zlots_bonus_wager', true ) );
	}

	public function get_spins() {
		return esc_html( get_post_meta( $this->bonus_id, 'zlots_bonus_spins', true ) );
	}

	public function get_external_link() {
		return esc_url( get_post_meta( $this->bonus_id, 'bonus_external_link', true ) );
	}

	public function get_short_desc() {
		return wp_kses( get_post_meta( $this->bonus_id, 'bonus_short_desc', true ), $this->allowed_html );
	}

	public function get_valid_date() {
		return esc_html( get_post_meta( $this->bonus_id, 'bonus_valid_date', true ) );
	}

	public function get_image( $size = 'zlots-220-80' ) {
		return wp_get_attachment_image(
			get_post_thumbnail_id( $this->bonus_id ),
			$size,
			'',
			[ 'alt' => $this->get_title() ]
		);
	}

	public function get_casinos() {
		return get_post_meta( $this->bonus_id, 'bonus_parent_casino', true );
	}

	public function get_excerpt() {
		return get_the_excerpt( $this->bonus_id );
	}

	public function get_title() {
		return get_the_title( $this->bonus_id );
	}
}
