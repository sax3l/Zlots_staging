<?php

use Zlots\Casinos\Bonus;

$bonus_id = $args['bonus_id'] ?? null;

if ( ! $bonus_id ) {
	return null;
}

$bonus    = new Bonus( $bonus_id );
?>
<div class="item-wrap casinos-item">
  <div class="casino-logo">


    <?php if ( is_array( $bonus->get_categories() ) && ! empty( $bonus->get_categories() ) ): ?>
    <div class="tag-item casino-tag">
      <?php foreach ( $bonus->get_categories() as $item ): ?>
      <a
        href="<?php echo esc_url( get_term_link( (int) $item->term_id, $item->taxonomy ) ); ?>"><?php echo $item->name ?></a>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <?php echo $bonus->get_image( 'zlots-220-80' ) ?>
  </div>

  <div class="casino-content">
    <?php if ( $bonus->get_amount() ): ?>
    <div class="casino-content-item">
      <span>Bonus:</span>
      <strong>&euro;<?php echo $bonus->get_amount(); ?></strong>
    </div>
    <?php endif; ?>

    <?php if ( $bonus->get_percentage() ): ?>
    <div class="casino-content-item">
      <span>Percentage:</span>
      <strong> <?php echo $bonus->get_percentage(); ?>%</strong>
    </div>
    <?php endif; ?>

    <?php if ( $bonus->get_wager() ): ?>
    <div class="casino-content-item">
      <span>Wager:</span>
      <strong><?php echo $bonus->get_wager(); ?>x</strong>
    </div>
    <?php endif; ?>

    <?php if ( $bonus->get_spins() ): ?>
    <div class="casino-content-item">
      <span>Free Spins:</span>
      <strong><?php echo $bonus->get_spins(); ?></strong>
    </div>
    <?php endif; ?>
  </div>

  <?php if ( $bonus->get_short_desc() ): ?>
  <div class="item-wrap casino-proposition">
    <?php echo $bonus->get_short_desc(); ?>
  </div>
  <?php endif; ?>

  <?php if ( $bonus->get_code() ): ?>
  <div class="code casino-code">CODE: <?php echo $bonus->get_code(); ?></div>
  <?php endif; ?>

  <div class="buttons-wrap">
    <a class="link-button dark-link-button" href="<?php echo $bonus->get_link() ?>">Review</a>

    <?php if ( $bonus->get_external_link() ): ?>
    <a class="link-button red-link-button" href="<?php echo $bonus->get_external_link(); ?>">Bonuses</a>
    <?php endif; ?>
  </div>
</div>