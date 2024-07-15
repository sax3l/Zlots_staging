<?php
  $wager = $args['wager'] ?? 0;
  $spins = $args['spins'] ?? 0;
  $amount = $args['amount'] ?? 0;
  $percentage = $args['percentage'] ?? 0;
?>


<div class="indicator-items-wrap">
  <div class="indicator-item-wrap">
    <div class="indicator-item-circle"><?php echo $amount; ?>€</div>
    <div class="indicator-item-info">
      <h5><?php esc_html_e( 'Amount', 'zlots' ); ?></h5>
    </div>
  </div>
  <div class="indicator-item-wrap">
    <div class="indicator-item-circle"><?php echo $percentage; ?>%</div>
    <div class="indicator-item-info">
      <h5><?php esc_html_e( 'Percentage', 'zlots' ); ?></h5>
    </div>
  </div>
  <div class="indicator-item-wrap">
    <div class="indicator-item-circle"><?php echo $wager; ?>x</div>
    <div class="indicator-item-info">
      <h5><?php esc_html_e( 'Wager', 'zlots' ); ?></h5>
    </div>
  </div>
  <div class="indicator-item-wrap">
    <div class="indicator-item-circle"><?php echo $spins; ?></div>
    <div class="indicator-item-info">
      <h5><?php esc_html_e( 'Free Spins', 'zlots' ); ?></h5>
    </div>
  </div>
</div>