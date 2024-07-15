<?php

namespace Zlots\Casinos;

class Casino
{
	private $casino_id;

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

	public function __construct( $casino_id ) {
		$this->casino_id = $casino_id;
	}

	public function get_description() {
		return wp_kses( get_post_meta( $this->casino_id, 'casino_short_desc', true ), $this->allowed_html );
	}

	public function get_pros() {
		return wp_kses( get_post_meta( $this->casino_id, 'casino_pros_desc', true ), $this->allowed_html );
	}

	public function get_cons() {
		return wp_kses( get_post_meta( $this->casino_id, 'casino_cons_desc', true ), $this->allowed_html );
	}

	public function get_external_link() {
		return esc_url( get_post_meta( $this->casino_id, 'casino_external_link', true ) );
	}

	public function get_terms_desc() {
		return wp_kses( get_post_meta( $this->casino_id, 'casino_terms_desc', true ), $this->allowed_html );
	}

	public function get_rating_trust() {
		return esc_html( get_post_meta( $this->casino_id, 'casino_rating_trust', true ) );
	}

	public function get_rating_games() {
		return esc_html( get_post_meta( $this->casino_id, 'casino_rating_games', true ) );
	}

	public function get_rating_bonus() {
		return esc_html( get_post_meta( $this->casino_id, 'casino_rating_bonus', true ) );
	}

	public function get_rating_customer() {
		return esc_html( get_post_meta( $this->casino_id, 'casino_rating_customer', true ) );
	}

	public function get_rating_overall() {
		return esc_html( get_post_meta( $this->casino_id, 'casino_overall_rating', true ) );
	}

	public function get_is_deposit() {
		return esc_html( get_post_meta( $this->casino_id, 'zlotz_rg_is_deposit', true ) );
	}

	public function get_is_wager() {
		return esc_html( get_post_meta( $this->casino_id, 'zlotz_rg_is_wager', true ) );
	}

	public function get_is_loss() {
		return esc_html( get_post_meta( $this->casino_id, 'zlotz_rg_is_loss', true ) );
	}

	public function get_is_time() {
		return esc_html( get_post_meta( $this->casino_id, 'zlotz_rg_is_time', true ) );
	}

	public function get_is_exclusion() {
		return esc_html( get_post_meta( $this->casino_id, 'zlotz_rg_is_exclusion', true ) );
	}

	public function get_is_cool() {
		return esc_html( get_post_meta( $this->casino_id, 'zlotz_rg_is_cool', true ) );
	}

	public function get_is_reality() {
		return esc_html( get_post_meta( $this->casino_id, 'zlotz_rg_is_reality', true ) );
	}

	public function get_is_assessment() {
		return esc_html( get_post_meta( $this->casino_id, 'zlotz_rg_is_assessment', true ) );
	}

	public function get_is_withdrawal() {
		return esc_html( get_post_meta( $this->casino_id, 'zlotz_rg_is_withdrawal', true ) );
	}

	public function get_is_participation() {
		return esc_html( get_post_meta( $this->casino_id, 'zlotz_rg_is_participation', true ) );
	}

	public function get_withdrawal_ewallet() {
		return esc_html( get_post_meta( $this->casino_id, 'casinos_withdrawal_time_ewallet', true ) );
	}

	public function get_withdrawal_bank_transfers() {
		return esc_html( get_post_meta( $this->casino_id, 'casinos_withdrawal_time_bank_transfers', true ) );
	}

	public function get_withdrawal_cheques() {
		return esc_html( get_post_meta( $this->casino_id, 'casinos_withdrawal_time_cheques', true ) );
	}

	public function get_withdrawal_card_payments() {
		return esc_html( get_post_meta( $this->casino_id, 'casinos_withdrawal_time_card_payments', true ) );
	}

	public function get_withdrawal_pending_time() {
		return esc_html( get_post_meta( $this->casino_id, 'casinos_withdrawal_time_pending_time', true ) );
	}

	public function get_terms( $taxonomy_name ) {
		return wp_get_object_terms( $this->casino_id, $taxonomy_name );
	}

	public function get_primary_term() {
		$primary_term_id = get_post_meta( $this->casino_id, '_yoast_wpseo_primary_casino-category', true );
		$primary_term    = get_term( $primary_term_id );

		if ( $primary_term && ! is_wp_error( $primary_term ) ) {
			return $primary_term;
		}

		return null;
	}

	public function get_related_bonus_id() {
		$query_args = [
			'post_type'      => 'bonus',
			'post_status'    => 'publish',
			'fields'         => 'ids',
			'no_found_rows'  => true,
			'posts_per_page' => 1,
			'meta_query'     => [
				[
					'key'     => 'bonus_parent_casino',
					'value'   => '"' . $this->casino_id . '"',
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

	public function get_image( $size = 'zlots-220-80' ) {
		return wp_get_attachment_image(
			get_post_thumbnail_id( $this->casino_id ),
			$size
		);
	}
}
