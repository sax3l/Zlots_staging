<?php
/*
Template Name: Slots Archive Style Zlots
*/

$terms_categories = get_terms( [ 'taxonomy' => 'bonus-category' ] );
?>

<div class="bonuses-filters">
  <div class="blocks-wrap filters-mobile-wrap mobile-menu">
    <div class="blocks-wrap filters-wrap main-menu">
      <h5>Filters</h5>
      <form id="bonuses-archive-filters" method="post">
        <div class="accordion-wrap">
          <?php if (is_array($terms_categories) && !empty($terms_categories)): ?>
          <div class="set">
            <p>Categories<i class="fa fa-angle-down"></i></p>
            <ul class="content">
              <?php foreach ($terms_categories as $term): ?>
              <li>
                <label for="<?php echo $term->name; ?>"><?php echo $term->name; ?></label>
                <input id="<?php echo $term->name; ?>" type="radio" value="<?php echo $term->slug ?>"
                  name="casino-category"">
              </li>
              <?php endforeach; ?>
            </ul>
          </div>
          <?php endif; ?>
        </div>
      </form>
    </div>
  </div>
</div>