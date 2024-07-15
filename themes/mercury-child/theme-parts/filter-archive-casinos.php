<?php
/*
Template Name: Casinos Archive Style Zlots
*/

$terms_categories = get_terms(['taxonomy' => 'casino-category']);
$terms_providers = zlots_get_terms_by_post_type('vendor', 'casino');
$terms_deposit_method = get_terms(['taxonomy' => 'deposit-method']);
$terms_withdrawal_method = get_terms(['taxonomy' => 'withdrawal-method']);
$terms_withdrawal_limit = get_terms(['taxonomy' => 'withdrawal-limit']);
$terms_restricted_country = get_terms(['taxonomy' => 'restricted-country']);
$terms_licence = get_terms(['taxonomy' => 'licence']);
$terms_casino_language = get_terms(['taxonomy' => 'casino-language']);
$terms_currency = get_terms(['taxonomy' => 'currency']);
$terms_device = get_terms(['taxonomy' => 'device']);
$terms_owner = get_terms(['taxonomy' => 'owner']);
$terms_casino_est = get_terms(['taxonomy' => 'casino-est']);


?>

<div class="available-casinos-filters">
	<div class="loading-overlay">
    <div class="spinner"></div>
</div>
  <div class="blocks-wrap filters-mobile-wrap mobile-menu">
    <div class="blocks-wrap filters-wrap main-menu">
      <h5>Filters</h5>
      <form id="available-casinos-filters" method="post">
        <div class="slider-filters">
          <div class="range-slider-wrap">
            <div class="slider-wrap">
              <p class="range-slider-title">Amount</p>
              <div class="slider" data-min="0" data-max="100000" data-name="amount" data-symbol="€"></div>
            </div>
            <div class="slider-values">
              0€ - 100000€
            </div>
          </div>
          <div class="range-slider-wrap">
            <div class="slider-wrap">
              <p class="range-slider-title">Wager</p>
              <div class="slider" data-min="0" data-max="120" data-name="wager" data-symbol="x"></div>
            </div>
            <div class="slider-values">
              0x - 120x
            </div>
          </div>
          <div class="range-slider-wrap">
            <div class="slider-wrap">
              <p class="range-slider-title">Percentage</p>
              <div class="slider" data-min="0" data-max="1000" data-name="percentage" data-symbol="%"></div>
            </div>
            <div class="slider-values">
              0% - 1000%
            </div>
          </div>
          <div class="range-slider-wrap">
            <div class="slider-wrap">
              <p class="range-slider-title">Free Spins</p>
              <div class="slider" data-min="0" data-max="1000" data-name="free_spins" data-symbol=""></div>
            </div>
            <div class="slider-values">
              0 - 1000
            </div>
          </div>
        </div>

        <div class="accordion-wrap">
          <?php if (is_array($terms_categories) && !empty($terms_categories)): ?>
          <div class="set">
            <p>Categories<i class="fa fa-angle-down"></i></p>
            <ul class="content">
              <?php foreach ($terms_categories as $term): ?>
              <li>
                <label for="<?php echo $term->name; ?>"><?php echo $term->name; ?></label>
                <input id="<?php echo $term->name; ?>" type="radio" value="<?php echo $term->slug ?>"
                  name="casino-category">
              </li>
              <?php endforeach; ?>
            </ul>
          </div>
          <?php endif; ?>

          <?php if (is_array($terms_providers) && !empty($terms_providers)): ?>
          <div class="set">
            <p>Providers<i class="fa fa-angle-down"></i></p>
            <ul class="content">
              <?php foreach ($terms_providers as $term): ?>
              <li>
                <label for="<?php echo $term->name; ?>"><?php echo $term->name; ?></label>
                <input id="<?php echo $term->name; ?>" type="radio" value="<?php echo $term->slug ?>" name="vendor">
              </li>
              <?php endforeach; ?>
            </ul>
          </div>
          <?php endif; ?>

          <?php if (is_array($terms_deposit_method) && !empty($terms_deposit_method)): ?>
          <div class="set">
            <p>Deposit Methods<i class="fa fa-angle-down"></i></p>
            <ul class="content">
              <?php foreach ($terms_deposit_method as $term): ?>
              <li>
                <label for="<?php echo $term->name; ?>"><?php echo $term->name; ?></label>
                <input id="<?php echo $term->name; ?>" type="radio" value="<?php echo $term->slug ?>"
                  name="deposit-method">
              </li>
              <?php endforeach; ?>
            </ul>
          </div>
          <?php endif; ?>

          <?php if (is_array($terms_withdrawal_method) && !empty($terms_withdrawal_method)): ?>
          <div class="set">
            <p>Withdrawal Methods<i class="fa fa-angle-down"></i></p>
            <ul class="content">
              <?php foreach ($terms_withdrawal_method as $term): ?>
              <li>
                <label for="<?php echo $term->name; ?>"><?php echo $term->name; ?></label>
                <input id="<?php echo $term->name; ?>" type="radio" value="<?php echo $term->slug ?>"
                  name="withdrawal-method">
              </li>
              <?php endforeach; ?>
            </ul>
          </div>
          <?php endif; ?>

          <?php if (is_array($terms_withdrawal_limit) && !empty($terms_withdrawal_limit)): ?>
          <div class="set">
            <p>Withdrawal Limits<i class="fa fa-angle-down"></i></p>
            <ul class="content">
              <?php foreach ($terms_withdrawal_limit as $term): ?>
              <li>
                <label for="<?php echo $term->name; ?>"><?php echo $term->name; ?></label>
                <input id="<?php echo $term->name; ?>" type="radio" value="<?php echo $term->slug ?>"
                  name="withdrawal-limit">
              </li>
              <?php endforeach; ?>
            </ul>
          </div>
          <?php endif; ?>

          <?php if (is_array($terms_restricted_country) && !empty($terms_restricted_country)): ?>
          <div class="set">
            <p>Restricted Countries<i class="fa fa-angle-down"></i></p>
            <ul class="content">
              <?php foreach ($terms_restricted_country as $term): ?>
              <li>
                <label for="<?php echo $term->name; ?>"><?php echo $term->name; ?></label>
                <input id="<?php echo $term->name; ?>" type="radio" value="<?php echo $term->slug ?>"
                  name="restricted-country">
              </li>
              <?php endforeach; ?>
            </ul>
          </div>
          <?php endif; ?>

          <?php if (is_array($terms_licence) && !empty($terms_licence)): ?>
          <div class="set">
            <p>Licences<i class="fa fa-angle-down"></i></p>
            <ul class="content">
              <?php foreach ($terms_licence as $term): ?>
              <li>
                <label for="<?php echo $term->name; ?>"><?php echo $term->name; ?></label>
                <input id="<?php echo $term->name; ?>" type="radio" value="<?php echo $term->slug ?>" name="licence">
              </li>
              <?php endforeach; ?>
            </ul>
          </div>
          <?php endif; ?>

          <?php if (is_array($terms_casino_language) && !empty($terms_casino_language)): ?>
          <div class="set">
            <p>Languages<i class="fa fa-angle-down"></i></p>
            <ul class="content">
              <?php foreach ($terms_casino_language as $term): ?>
              <li>
                <label for="<?php echo $term->name; ?>"><?php echo $term->name; ?></label>
                <input id="<?php echo $term->name; ?>" type="radio" value="<?php echo $term->slug ?>"
                  name="casino-language">
              </li>
              <?php endforeach; ?>
            </ul>
          </div>
          <?php endif; ?>

          <?php if (is_array($terms_currency) && !empty($terms_currency)): ?>
          <div class="set">
            <p>Currencies<i class="fa fa-angle-down"></i></p>
            <ul class="content">
              <?php foreach ($terms_currency as $term): ?>
              <li>
                <label for="<?php echo $term->name; ?>"><?php echo $term->name; ?></label>
                <input id="<?php echo $term->name; ?>" type="radio" value="<?php echo $term->slug ?>" name="currency">
              </li>
              <?php endforeach; ?>
            </ul>
          </div>
          <?php endif; ?>

          <?php if (is_array($terms_device) && !empty($terms_device)): ?>
          <div class="set">
            <p>Devices<i class="fa fa-angle-down"></i></p>
            <ul class="content">
              <?php foreach ($terms_device as $term): ?>
              <li>
                <label for="<?php echo $term->name; ?>"><?php echo $term->name; ?></label>
                <input id="<?php echo $term->name; ?>" type="radio" value="<?php echo $term->slug ?>" name="device">
              </li>
              <?php endforeach; ?>
            </ul>
          </div>
          <?php endif; ?>

          <?php if (is_array($terms_owner) && !empty($terms_owner)): ?>
          <div class="set">
            <p>Owner<i class="fa fa-angle-down"></i></p>
            <ul class="content">
              <?php foreach ($terms_owner as $term): ?>
              <li>
                <label for="<?php echo $term->name; ?>"><?php echo $term->name; ?></label>
                <input id="<?php echo $term->name; ?>" type="radio" value="<?php echo $term->slug ?>" name="owner">
              </li>
              <?php endforeach; ?>
            </ul>
          </div>
          <?php endif; ?>

          <?php if (is_array($terms_casino_est) && !empty($terms_casino_est)): ?>
          <div class="set">
            <p>Established<i class="fa fa-angle-down"></i></p>
            <ul class="content">
              <?php foreach ($terms_casino_est as $term): ?>
              <li>
                <label for="<?php echo $term->name; ?>"><?php echo $term->name; ?></label>
                <input id="<?php echo $term->name; ?>" type="radio" value="<?php echo $term->slug ?>" name="casino-est">
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