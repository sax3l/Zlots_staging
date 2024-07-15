<?php

namespace Zlots\Casinos;

class CasinoBonus
{
	private $bonus_id;

	public function __construct( $casino_id ) {
		$this->bonus_id = $this->get_related_bonus_id_by_casino_id( $casino_id );
	}

	private function get_related_bonus_id_by_casino_id( $casino_id ) {
		$post_id_related = '"' . $casino_id . '"';
		$query_args      = [
			'post_type'      => 'bonus',
			'post_status'    => 'publish',
			'fields'         => 'ids',
			'no_found_rows'  => true,
			'posts_per_page' => 1,
			'meta_query'     => [
				[
					'key'     => 'bonus_parent_casino',
					'value'   => $post_id_related,
					'compare' => 'LIKE'
				],
			],
		];

		$query = get_posts( $query_args );

		if ( $query && is_array( $query ) ) {
			return $query[0];
		}

		return null;
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

}