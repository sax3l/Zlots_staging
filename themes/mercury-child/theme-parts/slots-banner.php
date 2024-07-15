<?php
$slot_id = $args['slot_id'] ?? null;
$slot_btn_name = get_post_meta( $slot_id, 'zlots_slots_btn_name', true );
?>
<section class="section-wrap slots-banner-wrap" style="margin-bottom:0;">
  <?php echo wp_get_attachment_image(get_post_thumbnail_id($slot_id), 'zlots-1980-200'); ?>
  <a class="link-button red-link-button" href="<?php echo get_permalink($slot_id) ?>"><?php echo $slot_btn_name ?: 'View Game' ?></a>
</section>