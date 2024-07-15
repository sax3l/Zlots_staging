<?php
$news_id = $args['news_id'] ?? null;

if (!$news_id) {
	return null;
}

$news_link = get_permalink($news_id);
$news_date = get_the_date('M d, Y', $news_id);
$news_img = wp_get_attachment_image(get_post_thumbnail_id($news_id), 'mercury-120-120');
$news_title = get_the_title($news_id);
$news_excerpt = get_the_excerpt($news_id);
?>

<a class="item-wrap news-item" href="<?php echo $news_link ?>">
  <div class="news-logo">
    <?php echo $news_img ?>
  </div>
  <div class="news-content-wrap">
    <span><?php echo $news_date ?></span>
    <h3><?php echo $news_title ?></h3>
    <div class="news-content ellipsis">
      <p><?php echo $news_excerpt ?></p>
    </div>
  </div>
</a>