<?php
/*
Template Name: Slots Archive Style Zlots
*/

$terms_categories = get_terms( [ 'taxonomy' => 'game-category' ] );
$terms_vendor     = get_terms( [ 'taxonomy' => 'vendor' ] );
?>

<div class="slots-filters">
	<div class="loading-overlay">
    <div class="spinner"></div>
	</div>
  <div class="blocks-wrap filters-mobile-wrap mobile-menu">
    <div class="blocks-wrap filters-wrap main-menu">
      <h5>Filters</h5>
      <form id="slots-archive-filters" method="post">
        <div class="accordion-wrap">
          <?php if (is_array($terms_categories) && !empty($terms_categories)): ?>
    <div class="set">
        <p>Categories<i class="fa fa-angle-down"></i></p>
        <ul class="content">
            <?php foreach ($terms_categories as $term): ?>
            <li>
                <label for="<?php echo $term->name; ?>"><?php echo $term->name; ?></label>
                <input id="<?php echo $term->name; ?>" type="checkbox" value="<?php echo $term->slug ?>" name="game-category">
            </li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<?php if (is_array($terms_vendor) && !empty($terms_vendor)): ?>
    <div class="set">
        <p>Vendors<i class="fa fa-angle-down"></i></p>
        <ul class="content">
            <?php foreach ($terms_vendor as $term): ?>
            <li>
                <label for="<?php echo $term->name; ?>"><?php echo $term->name; ?></label>
                <input id="<?php echo $term->name; ?>" type="checkbox" value="<?php echo $term->slug ?>" name="vendor">
            </li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>
        </div>
		  <!--
        <div class="slider-filters">
          <div class="range-slider-wrap">
            <div class="slider-wrap">
              <p class="range-slider-title">Slots Amount</p>
              <div class="slider" data-min="0" data-max="1000" data-name="slots_amount" data-symbol=""></div>
            </div>
            <div class="slider-values">
              0 - 1000
            </div>
          </div>
        </div>
-->
      </form>
    </div>
  </div>
</div>