<form class="main-search-wrap" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="POST">
  <input type="text" name="search" placeholder="Search for casinos, bonuses, slots and reviews!">

  <input type="hidden" name="nonce" value="<?php echo ZLOTS_NONCE_KEY ?>">
  <input type="hidden" name="action" value="zlots_search_form">

  <button class="search-button" type="submit"></button>
</form>