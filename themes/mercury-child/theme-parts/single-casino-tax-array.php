<?php
$tax_array = $args['tax_array'] ?? null;

if (is_array($tax_array)):
  $count = count($tax_array) - 1;
  foreach ($tax_array as $idx => $tax_item):
    $tax_name = esc_attr($tax_item->name);
    ?>
    <a href="<?php echo esc_url(get_term_link((int) $tax_item->term_id, $tax_item->taxonomy)); ?>"
      title="<?php echo $tax_name; ?>">
      <?php echo $tax_name; ?></a><?php echo $idx < $count ? ',' : ''; ?>
  <?php
  endforeach;
endif;