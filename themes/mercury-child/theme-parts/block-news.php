<?php
$title = $args['title'] ?? null;
$news_ids = $args['news'] ?? null;

$link_all_news = get_home_url('news');
?>

<section class="section-wrap news-items-wrap">
  <div class="view-all-title top-rated-casinos-title">
    <h3><?php echo $title ?></h3>
    <a href="<?php echo home_url('casinos') ?>">
      View All News <i class="fas fa-arrow-right"></i>
    </a>
  </div>
  <?php if (is_array($news_ids)): ?>
  <div class="list-items-wrap news-items">
    <?php foreach ($news_ids as $news_id): ?>
    <?php get_template_part('theme-parts/item-front-news', null, ['news_id' => $news_id]); ?>
    <?php endforeach; ?>
  </div>
  <?php endif; ?>
</section>