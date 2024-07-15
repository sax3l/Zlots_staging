<?php
use Zlots\Casinos\Casino;

$casino_id = $args['casino_id'] ?? null;
$casino = new Casino($casino_id);
$casino_link = get_permalink($casino_id);
$casino_overall_rating = esc_html(get_post_meta($casino_id, 'casino_overall_rating', true));
$casino_img = wp_get_attachment_image(get_post_thumbnail_id($casino_id), 'zlots-220-80');

// Retrieve casino bonus meta fields
$bonus_amount = esc_html(get_post_meta($casino_id, 'zlots_bonus_amount', true));
$bonus_percentage = esc_html(get_post_meta($casino_id, 'zlots_bonus_percentage', true));
$bonus_wager = esc_html(get_post_meta($casino_id, 'zlots_bonus_wager', true));
$bonus_spins = esc_html(get_post_meta($casino_id, 'zlots_bonus_spins', true));
$bonus_external_link = esc_url(get_post_meta($casino_id, 'zlots_bonus_external_link', true));
?>

<div class="card">
    <div class="top-section">
        <div class="border"></div>
        <div class="icons">
            <div class="logo">
                <?php if ($casino->get_primary_term()): ?>
                    <?php $casino_terms = $casino->get_primary_term(); ?>
                    <div class="card-cas-tag">
                        <a href="<?php echo esc_url(get_term_link((int)$casino_terms->term_id, $casino_terms->taxonomy)); ?>">
                            <?php echo $casino_terms->name ?>
                        </a>
                    </div>
                <?php else: ?>
                    <span class="card-cas-category">
                        <?php if (is_array($casino->get_terms('casino-category')) && !empty($casino->get_terms('casino-category'))): ?>
                            <?php $casino_terms = $casino->get_terms('casino-category')[0]; ?>
                            <div class="card-cas-tag">
                                <a href="<?php echo esc_url(get_term_link((int)$casino_terms->term_id, $casino_terms->taxonomy)); ?>">
                                    <?php echo $casino_terms->name ?>
                                </a>
                            </div>
                        <?php endif; ?>
                    </span>
                <?php endif; ?>
            </div>
            <div class="social-media">
                <div class="rating casino-rating">
                    <i class="fas fa-star" aria-hidden="true"></i>
                    <strong><?php echo esc_html(number_format((float)$casino_overall_rating, 1, '.', ',')); ?></strong>
                </div>
            </div>
        </div>
        <div class="recommended-casino-logo">
            <?php echo $casino_img ?>
        </div>
    </div>
    <div class="bottom-section">
        <div class="row row1">
            <div class="item">
                <span class="big-text"><?php echo $bonus_amount ?: 'N/A'; ?></span>
                <span class="regular-text">Amount</span>
            </div>
            <div class="item">
                <span class="big-text"><?php echo $bonus_percentage ?: 'N/A'; ?></span>
                <span class="regular-text">Percentage</span>
            </div>
        </div>
        <div class="row row2">
            <div class="item">
                <span class="big-text"><?php echo $bonus_spins ?: 'N/A'; ?></span>
                <span class="regular-text">Free Spins</span>
            </div>
            <div class="item">
                <span class="big-text"><?php echo $bonus_wager ?: 'N/A'; ?></span>
                <span class="regular-text">Wager</span>
            </div>
        </div>
        <div class="row row1">
            <div class="item">
                <?php if ($casino_link): ?>
                    <a class="link-button dark-link-button" href="<?php echo $casino_link ?>"><?php esc_html_e('Review', 'zlots'); ?></a>
                <?php else: ?>
                    <a class="link-button dark-link-button" href="#">Claim Bonus</a>
                <?php endif; ?>
            </div>
        </div>
        <div class="row row1">
            <div class="item">
                <?php if ($bonus_external_link): ?>
                    <a class="link-button red-link-button" href="<?php echo $bonus_external_link; ?>">Claim Bonus</a>
                <?php else: ?>
                    <a class="link-button red-link-button" href="#">Claim Bonus</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
