<?php
$title = $args['title'] ?? null;
$casinos_ids = $args['casinos'] ?? null;

$link_all_casinos = get_home_url('casinos');
?>

<section class="section-wrap top-rated-casinos-wrap">
  <div class="view-all-title top-rated-casinos-title">
    <h3><?php echo $title ?></h3>
    <a href="<?php echo home_url('casinos') ?>">
      View All Casinos <i class="fas fa-arrow-right"></i>
    </a>
  </div>

  <?php if (is_array($casinos_ids)): ?>
  <div class="recommended-casinos-container">
    <?php foreach ($casinos_ids as $casino_id): ?>
    <?php get_template_part('theme-parts/item-archive-casino', null, ['casino_id' => $casino_id]); ?>
    <?php endforeach; ?>
  </div>
  <?php endif; ?>
</section>