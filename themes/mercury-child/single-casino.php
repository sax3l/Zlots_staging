<?php
get_header();

use Zlots\Casinos\CasinoBonus;

$casino_allowed_html = [
	'a'      => [
		'href'   => true,
		'title'  => true,
		'target' => true,
		'rel'    => true
	],
	'img'    => [
		'src' => true,
		'alt' => true
	],
	'br'     => [],
	'em'     => [],
	'strong' => [],
	'span'   => [
		'class' => true
	],
	'div'    => [
		'class' => true
	],
	'p'      => [],
	'ul'     => [],
	'ol'     => [],
	'li'     => [],
];

$post_id = get_the_ID();

$casino_pros_desc = wp_kses(get_post_meta( $post_id, 'casino_pros_desc', true ), $casino_allowed_html);
$casino_cons_desc = wp_kses(get_post_meta( $post_id, 'casino_cons_desc', true ), $casino_allowed_html);

$casino_external_link   = esc_url( get_post_meta( $post_id, 'zlots_bonus_external_link', true ) );
$casino_terms_desc      = wp_kses( get_post_meta( $post_id, 'casino_terms_desc', true ), $casino_allowed_html );
$casino_rating_trust    = esc_html( get_post_meta( $post_id, 'casino_rating_trust', true ) );
$casino_rating_games    = esc_html( get_post_meta( $post_id, 'casino_rating_games', true ) );
$casino_rating_bonus    = esc_html( get_post_meta( $post_id, 'casino_rating_bonus', true ) );
$casino_rating_customer = esc_html( get_post_meta( $post_id, 'casino_rating_customer', true ) );
$casino_overall_rating  = esc_html( get_post_meta( $post_id, 'casino_overall_rating', true ) );

$casino_bonus = new CasinoBonus( $post_id );

$casino_languages  = wp_get_object_terms( $post_id, 'casino-language' );
$casino_est        = wp_get_object_terms( $post_id, 'casino-est' );
$casino_licences   = wp_get_object_terms( $post_id, 'licence' );
$casino_company    = wp_get_object_terms( $post_id, 'owner' );
$casino_categories = wp_get_object_terms( $post_id, 'casino-category' );

$casino_deposit_methods    = wp_get_object_terms( $post_id, 'deposit-method' );
$casino_currencies         = wp_get_object_terms( $post_id, 'currency' );
$casino_withdrawal_methods = wp_get_object_terms( $post_id, 'withdrawal-method' );
$casino_wt_ewallet         = esc_html( get_post_meta( $post_id, 'casinos_withdrawal_time_ewallet', true ) );
$casino_wt_bank_transfers  = esc_html( get_post_meta( $post_id, 'casinos_withdrawal_time_bank_transfers', true ) );
$casino_wt_cheques         = esc_html( get_post_meta( $post_id, 'casinos_withdrawal_time_cheques', true ) );
$casino_wt_card_payments   = esc_html( get_post_meta( $post_id, 'casinos_withdrawal_time_card_payments', true ) );
$casino_wt_pending_time    = esc_html( get_post_meta( $post_id, 'casinos_withdrawal_time_pending_time', true ) );
$casino_withdrawal_limits  = wp_get_object_terms( $post_id, 'withdrawal-limit' );

$casino_software = wp_get_object_terms( $post_id, 'vendor' );

$is_deposit       = get_post_meta( $post_id, 'zlotz_rg_is_deposit', true );
$is_wager         = get_post_meta( $post_id, 'zlotz_rg_is_wager', true );
$is_loss          = get_post_meta( $post_id, 'zlotz_rg_is_loss', true );
$is_time          = get_post_meta( $post_id, 'zlotz_rg_is_time', true );
$is_exclusion     = get_post_meta( $post_id, 'zlotz_rg_is_exclusion', true );
$is_cool          = get_post_meta( $post_id, 'zlotz_rg_is_cool', true );
$is_reality       = get_post_meta( $post_id, 'zlotz_rg_is_reality', true );
$is_assessment    = get_post_meta( $post_id, 'zlotz_rg_is_assessment', true );
$is_withdrawal    = get_post_meta( $post_id, 'zlotz_rg_is_withdrawal', true );
$is_participation = get_post_meta( $post_id, 'zlotz_rg_is_participation', true );

// Hämta bonus information
$bonus_amount = get_post_meta($post_id, 'zlots_bonus_amount', true);
$bonus_percentage = get_post_meta($post_id, 'zlots_bonus_percentage', true);
$bonus_wager = get_post_meta($post_id, 'zlots_bonus_wager', true);
$bonus_spins = get_post_meta($post_id, 'zlots_bonus_spins', true);

?>

<div id="post-<?php the_ID(); ?>" >
  <div class="single-page-wrap" style="max-width: 100%; padding: 0;">
    <div class="space-page-wrapper single-game-content-wrap" style="max-width: 100%; margin: 0 auto;">
        <div class="space-archive-title-box-ins space-page-wrapper relative" style="max-width: 100%; background-color: var(--background-textbox-blue);">
            <div class="single-casino-top-info-wrap" style="max-width: 1500px; display: flex; justify-content: space-between; gap: 50px;">
                <div class="top-row" style="width: 40%; display: flex; flex-direction: column; gap: 20px;">
                    <div class="upper-side-wrap" style="color: var(--white);">
                        <span><a href="<?php echo home_url() ?>" style="color: var(--white);">Zlots.com</a></span> /
                        <span class="breadcrumb_last" aria-current="page" style="color: var(--white);"><?php echo get_the_title() ?></span>
                        <header class="entry-header clearfix" style="text-align: left; padding: 0;">
                            <h1 class="entry-title" style="font-size: 36px; line-height: 1.2; font-weight: 700; color: var(--white); text-align: left; margin: 10px 0; padding: 0; border: 0;"><?php echo preg_replace('/ – .*/', '', get_the_title()); ?></h1>
                            <div class="divider" style="height: 2px; background: linear-gradient(to right, rgba(255, 255, 255, 0), rgba(255, 255, 255, 0.75), rgba(255, 255, 255, 0)); margin: 0; padding: 0; border: 0; color: var(--white); text-align: center; width: calc(100% + 20px);"></div>
                            <div class="mh-subheading-top" style="text-align: left; margin: 0; padding: 0; border: 0;"></div>
                            <h2 class="mh-subheading" style="font-size: 24px; line-height: 1.2; font-weight: 400; color: var(--white); text-align: left; margin: 10px 0 20px 0; padding: 0; border: 0;"> | Review Of Casino & Games</h2>
                        </header>
                    </div>
                    <div class="logo-wrap" style="padding: 0px; border: 2px solid white; border-radius: 5px; background: #1b233d; overflow: hidden; box-shadow: 0 1px 8px 0 #fff; position: relative; display: flex; justify-content: center; align-items: center; margin-bottom: 0; width: 100%; height: auto;">
                        <?php
                        $post_title_attr = the_title_attribute('echo=0');
                        if (wp_get_attachment_image(get_post_thumbnail_id())) {
                            echo wp_get_attachment_image(get_post_thumbnail_id(), 'zlots-300-300', "", ['alt' => $post_title_attr, 'style' => 'width: 100%; height: auto; max-width: 100%; max-height: 100%;']);
                        } ?>
                        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 20%; height: 20%;">
                        <a class="link-button red-link-button" href="<?php echo $casino_external_link ?>" target="_blank" style="display: block; text-align: center; background-color: var(--text-red); color: white; font-weight: bold; text-decoration: none; position: sticky; top: 0; z-index: 1000; margin: 0; height: 50px; gap: 25px;">Claim bonus</a>
                        </div>
                    </div>
                </div>
                <div class="right-side-wrap" style="width: 70%; margin: 90px 0 0 0; padding: 0; border: none; position: relative;">
          <div class="title-wrap">
          <a class="link-button red-link-button" href="<?php echo $casino_external_link ?>" target="_blank" style="display: block; text-align: center; background-color: var(--text-red); color: white; font-weight: bold; text-decoration: none; position: sticky; top: 0; z-index: 1000; margin: 0; height: 50px; gap: 25px;">Claim bonus</a>
          </div>

          <div class="blocks-wrap values-items-wrap">
          <div class="values-item-wrap circle">
            <div class="circle-value" data-value="<?php echo esc_html($bonus_amount); ?>" style="font-size: calc(0.7 * (1rem + 0.5vw)); color: var(--text-red);"><?php echo esc_html($bonus_amount); ?></div>
            <div class="circle-title" style="font-size: calc(0.7 * (1rem + 0.5vw)); color: var(--white);"><?php esc_html_e('Bonus Amount', 'zlots'); ?></div>
          </div>
          <div class="values-item-wrap circle">
            <div class="circle-value" data-value="<?php echo esc_html($bonus_percentage); ?>" style="font-size: calc(0.7 * (1rem + 0.5vw)); color: var(--text-red);"><?php echo esc_html($bonus_percentage); ?></div>
            <div class="circle-title" style="font-size: calc(0.7 * (1rem + 0.5vw)); color: var(--white);"><?php esc_html_e('Bonus Percentage', 'zlots'); ?></div>
          </div>
          <div class="values-item-wrap circle">
            <div class="circle-value" data-value="<?php echo esc_html($bonus_wager); ?>" style="font-size: calc(0.7 * (1rem + 0.5vw)); color: var(--text-red);"><?php echo esc_html($bonus_wager); ?></div>
            <div class="circle-title" style="font-size: calc(0.7 * (1rem + 0.5vw)); color: var(--white);"><?php esc_html_e('Bonus Wager', 'zlots'); ?></div>
          </div>
          <div class="values-item-wrap circle">
            <div class="circle-value" data-value="<?php echo esc_html($bonus_spins); ?>" style="font-size: calc(0.7 * (1rem + 0.5vw)); color: var(--text-red);"><?php echo esc_html($bonus_spins); ?></div>
            <div class="circle-title" style="font-size: calc(0.7 * (1rem + 0.5vw)); color: var(--white);"><?php esc_html_e('Bonus Spins', 'zlots'); ?></div>
          </div>
        </div>

          <div class="blocks-wrap values-items-wrap">
            <div class="values-item-wrap positive">
              <h5 style="font-size: calc(0.7 * (1rem + 0.5vw)); color: var(--white);">What we like</h5>
              <?php echo $casino_pros_desc; ?>
            </div>

            <div class="values-item-wrap negative">
              <h5 style="font-size: calc(0.7 * (1rem + 0.5vw)); color: var(--white);">What we don't like</h5>
              <?php echo $casino_cons_desc; ?>
            </div>
          </div>
        </div>
      </div>
    <div class="banner-section" style="border: 2px solid white; border-radius: 5px; background: #1b233d; overflow: hidden; box-shadow: 0 1px 8px 0 #fff; position: relative; max-width: 1500px; margin: 0 auto;">
                        <a target="_blank" rel="nofollow" href="https://zamsino.com/uk/banner/free/netbet/">
                            <noscript><img decoding="async" class="largeImg" width="1500px" height="100%" alt="large banner" src="https://wordpress-1113219-4588577.cloudwaysapps.com/wp-content/uploads/2024/06/image-3-4.png"></noscript>
                            <img decoding="async" class="largeImg lazyloaded" width="1500px%" height="100%" alt="large banner" src="https://wordpress-1113219-4588577.cloudwaysapps.com/wp-content/uploads/2024/06/image-3-4.png" data-src="https://wordpress-1113219-4588577.cloudwaysapps.com/wp-content/uploads/2024/06/image-3-4.png">
                        </a>
    </div>
    </div>
    <section class="single-casino-middle-content-section-wrap" style="max-width: 100%; background-color: white; display: flex; justify-content: center; align-items: center; text-align: center; margin: 50px auto;">
      <section class="single-casino-middle-info-wrap section-wrap" style="display: flex; width: 1500px; margin: 0 auto; padding: 0; border: 0; justify-content: center;">
        <div class="left-side-wrap-content" style="width: 100%; display: flex; flex-direction: column;">
          <div class="tabs-wrap section-wrap" style="width: 100%; border: 2px solid var(--text-red); border-radius: 5px; background: white; padding: 10px; overflow: hidden; box-shadow: 0 1px 8px 0 var(--text-red); position: relative; top: 0; margin-top: auto; height: 450px;">
              <ul class="tabs" style="display: flex; align-items: flex-start; width: 100%; overflow: visible; flex-wrap: nowrap; position: sticky; top: 0; margin: 30px 0 30px 0; font-size: calc(1rem + 0.5vw); padding: 0 25px;">
                <li class="tab-link current" data-tab="general" style="cursor: pointer; color: #1b233d; text-align: center; font-weight: 600; flex: 1 0 auto; margin: 1px; padding: 0; white-space: normal;">General</li>
                <li class="tab-link" data-tab="payments" style="cursor: pointer; color: #1b233d; text-align: center; font-weight: 600; flex: 1 0 auto; margin: 1px; padding: 0; white-space: normal;">Payments</li>
                <li class="tab-link" data-tab="games" style="cursor: pointer; color: #1b233d; text-align: center; font-weight: 600; flex: 1 0 auto; margin: 1px; padding: 0; white-space: normal;">Games</li>
                <li class="tab-link" data-tab="support" style="cursor: pointer; color: #1b233d; text-align: center; font-weight: 600; flex: 1 0 auto; margin: 1px; padding: 0; white-space: normal;">Support</li>
                <li class="tab-link" data-tab="gambling" style="cursor: pointer; color: #1b233d; text-align: center; font-weight: 600; flex: 1 0 auto; margin: 1px; padding: 0; white-space: normal;">Responsible Gambling</li>
              </ul>
              <div id="general" class="blocks-wrap tab-content current general-tab-content" style="width: 100%; margin-top: 10px; font-size: calc(0.7 * (1rem + 0.5vw));">
                <div class="tab-content-item general-tab-content-item" style="width: 100%; font-size: calc(0.7 * (1rem + 0.5vw)); display: flex; justify-content: space-between;">
                  <h5 style="color: #1b233d;"><?php esc_html_e( 'Website', 'zlots' ); ?>:</h5>
                  <div style="color: var(--text-red);"><?php echo $casino_external_link ?></div>
                </div>

                <div class="tab-content-item general-tab-content-item" style="width: 100%; font-size: calc(0.7 * (1rem + 0.5vw)); display: flex; justify-content: space-between;">
                  <h5 style="color: #1b233d;"><?php esc_html_e( 'Languages', 'zlots' ); ?>:</h5>
                  <div style="color: var(--text-red);">
                    <?php get_template_part( 'theme-parts/single-casino-tax-array', null, [ 'tax_array' => $casino_languages ] ); ?>
                  </div>
                </div>

                <div class="tab-content-item general-tab-content-item" style="width: 100%; font-size: calc(0.7 * (1rem + 0.5vw)); display: flex; justify-content: space-between;">
                  <h5 style="color: #1b233d;"><?php esc_html_e( 'Established', 'zlots' ); ?>:</h5>
                  <div style="color: var(--text-red);">
                    <?php get_template_part( 'theme-parts/single-casino-tax-array', null, [ 'tax_array' => $casino_est ] ); ?>
                  </div>
                </div>

                <div class="tab-content-item general-tab-content-item" style="width: 100%; font-size: calc(0.7 * (1rem + 0.5vw)); display: flex; justify-content: space-between;">
                  <h5 style="color: #1b233d;"><?php esc_html_e( 'Licences', 'zlots' ); ?>:</h5>
                  <div style="color: var(--text-red);">
                    <?php get_template_part( 'theme-parts/single-casino-tax-array', null, [ 'tax_array' => $casino_licences ] ); ?>
                  </div>
                </div>

                <div class="tab-content-item general-tab-content-item" style="width: 100%; font-size: calc(0.7 * (1rem + 0.5vw)); display: flex; justify-content: space-between;">
                  <h5 style="color: #1b233d;"><?php esc_html_e( 'Company', 'zlots' ); ?>:</h5>
                  <div style="color: var(--text-red);">
                    <?php get_template_part( 'theme-parts/single-casino-tax-array', null, [ 'tax_array' => $casino_company ] ); ?>
                  </div>
                </div>

                <div class="tab-content-item general-tab-content-item" style="width: 100%; font-size: calc(0.7 * (1rem + 0.5vw)); display: flex; justify-content: space-between;">
                  <h5 style="color: #1b233d;"><?php esc_html_e( 'Casino Type', 'zlots' ); ?>:</h5>
                  <div style="color: var(--text-red);">
                    <?php get_template_part( 'theme-parts/single-casino-tax-array', null, [ 'tax_array' => $casino_categories ] ); ?>
                  </div>
                </div>

              </div>
              <div id="payments" class="blocks-wrap tab-content payments-tab-content" style="width: 100%; margin-top: 10px; font-size: calc(0.7 * (1rem + 0.5vw));">
                <div class="tab-content-item payments-tab-content-item" style="width: 100%; font-size: calc(0.7 * (1rem + 0.5vw)); display: flex; justify-content: space-between;">
                  <h5 style="color: #1b233d;"><?php esc_html_e( 'Deposit Methods', 'zlots' ); ?>:</h5>
                  <div style="color: var(--text-red);">
                    <?php get_template_part( 'theme-parts/single-casino-tax-array', null, [ 'tax_array' => $casino_deposit_methods ] ); ?>
                  </div>
                </div>

                <div class="tab-content-item payments-tab-content-item" style="width: 100%; font-size: calc(0.7 * (1rem + 0.5vw)); display: flex; justify-content: space-between;">
                  <h5 style="color: #1b233d;"><?php esc_html_e( 'Currencies', 'zlots' ); ?>:</h5>
                  <div style="color: var(--text-red);">
                    <?php get_template_part( 'theme-parts/single-casino-tax-array', null, [ 'tax_array' => $casino_currencies ] ); ?>
                  </div>
                </div>

                <div class="tab-content-item payments-tab-content-item" style="width: 100%; font-size: calc(0.7 * (1rem + 0.5vw)); display: flex; justify-content: space-between;">
                  <h5 style="color: #1b233d;"><?php esc_html_e( 'Withdrawal Methods', 'zlots' ); ?>:</h5>
                  <div style="color: var(--text-red);">
                    <?php get_template_part( 'theme-parts/single-casino-tax-array', null, [ 'tax_array' => $casino_withdrawal_methods ] ); ?>
                  </div>
                </div>

                <div class="tab-content-item payments-tab-content-item" style="width: 100%; font-size: calc(0.7 * (1rem + 0.5vw)); display: flex; justify-content: space-between;">
                  <h5 style="color: #1b233d;"><?php esc_html_e( 'Withdrawal Times', 'zlots' ); ?>:</h5>
                  <div style="color: var(--text-red);">
                    <div><?php esc_html_e( 'EWallets', 'zlots' ); ?>: <?php echo $casino_wt_ewallet ?></div>
                    <div><?php esc_html_e( 'Bank Transfers', 'zlots' ); ?>: <?php echo $casino_wt_bank_transfers ?></div>
                    <div><?php esc_html_e( 'Cheques', 'zlots' ); ?>: <?php echo $casino_wt_cheques ?></div>
                    <div><?php esc_html_e( 'Card Payments', 'zlots' ); ?>: <?php echo $casino_wt_card_payments ?></div>
                    <div><?php esc_html_e( 'Pending Time', 'zlots' ); ?>: <?php echo $casino_wt_pending_time ?></div>
                  </div>
                </div>

                <div class="tab-content-item payments-tab-content-item" style="width: 100%; font-size: calc(0.7 * (1rem + 0.5vw)); display: flex; justify-content: space-between;">
                  <h5 style="color: #1b233d;"><?php esc_html_e( 'Withdrawal Limits', 'zlots' ); ?>:</h5>
                  <div style="color: var(--text-red);">
                    <?php get_template_part( 'theme-parts/single-casino-tax-array', null, [ 'tax_array' => $casino_withdrawal_limits ] ); ?>
                  </div>
                </div>
              </div>
              <div id="games" class="blocks-wrap tab-content games-tab-content" style="width: 100%; margin-top: 10px; font-size: calc(0.7 * (1rem + 0.5vw));">
                <div class="tab-content-item payments-tab-content-item" style="width: 100%; font-size: calc(0.7 * (1rem + 0.5vw)); display: flex; justify-content: space-between;">
                  <h5 style="color: #1b233d;"><?php esc_html_e( 'Software', 'zlots' ); ?>:</h5>
                  <div style="color: var(--text-red);">
                    <?php get_template_part( 'theme-parts/single-casino-tax-array', null, [ 'tax_array' => $casino_software ] ); ?>
                  </div>
                </div>
              </div>
              <div id="support" class="blocks-wrap tab-content support-tab-content" style="width: 100%; margin-top: 10px; font-size: calc(0.7 * (1rem + 0.5vw));">
                <div class="tab-content-item support-tab-content-item" style="width: 100%; font-size: calc(0.7 * (1rem + 0.5vw)); display: flex; justify-content: space-between;">
                  <h5 style="color: #1b233d;">Support:</h5>
                  <div style="color: var(--text-red);">
                    <a href="http://support@bingogodz.com" style="color: var(--text-red);">support@bingogodz.com</a>
                  </div>
                </div>
                <div class="tab-content-item support-tab-content-item" style="width: 100%; font-size: calc(0.7 * (1rem + 0.5vw)); display: flex; justify-content: space-between;">
                  <h5 style="color: #1b233d;">Live Chat (Yes / No):</h5>
                  <div style="color: var(--text-red);">Yes</div>
                </div>
              </div>
              <div id="gambling" class="blocks-wrap tab-content" style="width: 100%; margin-top: 10px; font-size: calc(0.7 * (1rem + 0.5vw));">
                <div class="gambling-tab-content" style="width: 100%; font-size: calc(0.7 * (1rem + 0.5vw));">
                  <div class="gambling-items-wrap" style="width: 100%; font-size: calc(0.7 * (1rem + 0.5vw)); display: flex; justify-content: space-between;">
                    <div class="tab-content-item payments-tab-content-item" style="width: 100%; font-size: calc(0.7 * (1rem + 0.5vw)); display: flex; justify-content: space-between;">
                      <h5 style="color: #1b233d;" <?php echo $is_deposit != 'on' ? 'class="strikethrough-text"' : '' ?>>
                        <i class="fa fa-plus"></i>
                        <?php esc_html_e( 'Deposit limit Tool', 'zlots' ); ?>
                      </h5>
                    </div>

                    <div class="tab-content-item payments-tab-content-item" style="width: 100%; font-size: calc(0.7 * (1rem + 0.5vw)); display: flex; justify-content: space-between;">
                      <h5 style="color: #1b233d;" <?php echo $is_wager != 'on' ? 'class="strikethrough-text"' : '' ?>>
                        <i class="fa fa-funnel-dollar"></i>
                        <?php esc_html_e( 'Wager Limit Tool', 'zlots' ); ?>
                      </h5>
                    </div>

                    <div class="tab-content-item payments-tab-content-item" style="width: 100%; font-size: calc(0.7 * (1rem + 0.5vw)); display: flex; justify-content: space-between;">
                      <h5 style="color: #1b233d;" <?php echo $is_loss != 'on' ? 'class="strikethrough-text"' : '' ?>>
                        <i class="fa fa-funnel-dollar"></i>
                        <?php esc_html_e( 'Loss Limit Tool', 'zlots' ); ?>
                      </h5>
                    </div>

                    <div class="tab-content-item payments-tab-content-item" style="width: 100%; font-size: calc(0.7 * (1rem + 0.5vw)); display: flex; justify-content: space-between;">
                      <h5 style="color: #1b233d;" <?php echo $is_time != 'on' ? 'class="strikethrough-text"' : '' ?>>
                        <i class="fa fa-stopwatch-20"></i>
                        <?php esc_html_e( 'Time/Session Limit Tool', 'zlots' ); ?>
                      </h5>
                    </div>

                    <div class="tab-content-item payments-tab-content-item" style="width: 100%; font-size: calc(0.7 * (1rem + 0.5vw)); display: flex; justify-content: space-between;">
                      <h5 style="color: #1b233d;" <?php echo $is_exclusion != 'on' ? 'class="strikethrough-text"' : '' ?>>
                        <i class="fa fa-user-times"></i>
                        <?php esc_html_e( 'Self-Exclusion Tool', 'zlots' ); ?>
                      </h5>
                    </div>
                  </div>

                  <div class="gambling-items-wrap" style="width: 100%; font-size: calc(0.7 * (1rem + 0.5vw)); display: flex; justify-content: space-between;">
                    <div class="tab-content-item payments-tab-content-item" style="width: 100%; font-size: calc(0.7 * (1rem + 0.5vw)); display: flex; justify-content: space-between;">
                      <h5 style="color: #1b233d;" <?php echo $is_cool != 'on' ? 'class="strikethrough-text"' : '' ?>>
                        <i class="fa fa-database"></i>
                        <?php esc_html_e( 'Cool Off/Time-Out Tool', 'zlots' ); ?>
                      </h5>
                    </div>

                    <div class="tab-content-item payments-tab-content-item" style="width: 100%; font-size: calc(0.7 * (1rem + 0.5vw)); display: flex; justify-content: space-between;">
                      <h5 style="color: #1b233d;" <?php echo $is_reality != 'on' ? 'class="strikethrough-text"' : '' ?>>
                        <i class="fa fa-exclamation-triangle"></i>
                        <?php esc_html_e( 'Reality Check Tool', 'zlots' ); ?>
                      </h5>
                    </div>

                    <div class="tab-content-item payments-tab-content-item" style="width: 100%; font-size: calc(0.7 * (1rem + 0.5vw)); display: flex; justify-content: space-between;">
                      <h5 style="color: #1b233d;" <?php echo $is_assessment != 'on' ? 'class="strikethrough-text"' : '' ?>>
                        <i class="fa fa-user-check"></i>
                        <?php esc_html_e( 'Self-Assessment Test', 'zlots' ); ?>
                      </h5>
                    </div>

                    <div class="tab-content-item payments-tab-content-item" style="width: 100%; font-size: calc(0.7 * (1rem + 0.5vw)); display: flex; justify-content: space-between;">
                      <h5 style="color: #1b233d;" <?php echo $is_withdrawal != 'on' ? 'class="strikethrough-text"' : '' ?>>
                        <i class="fa fa-lock"></i>
                        <?php esc_html_e( 'Withdrawal Lock', 'zlots' ); ?>
                      </h5>
                    </div>

                    <div class="tab-content-item payments-tab-content-item" style="width: 100%; font-size: calc(0.7 * (1rem + 0.5vw)); display: flex; justify-content: space-between;">
                      <h5 style="color: #1b233d;" <?php echo $is_participation != 'on' ? 'class="strikethrough-text"' : '' ?>>
                        <i class="fa fa-user-cog"></i>
                        <?php esc_html_e( 'Self-Exclusion Register Participation', 'zlots' ); ?>
                      </h5>
                    </div>
                  </div>
                </div>
              </div>
            </div>  
        <div class="content-block">
                <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                        <?php the_content(); ?>
                    <?php endwhile; endif; ?>
        </div>
      </div>
		  
      <div class="right-side-wrap-tab" style="width: 30%; border: 2px solid var(--text-red); border-radius: 5px; background: white; padding: 0px; overflow: hidden; box-shadow: 0 1px 8px 0 var(--text-red); position: sticky; top: 0; margin-top: 0; height: auto; text-align: left;">
    <!-- Lägg till content-table-container här -->
    <a class="link-button red-link-button" href="<?php echo $casino_external_link ?>" target="_blank" style="display: block; text-align: center; background-color: var(--text-red); color: white; font-weight: bold; text-decoration: none; position: sticky; top: 0; z-index: 1000; margin: 0; height: 50px; gap: 25px;">Claim bonus</a>
    <div class="content-table-container" style="background-color: white; border: 2px solid white; border-radius: 5px; overflow: hidden; box-shadow: 0 1px 8px 0 #fff; position: relative; width: 100%;">
        <p class="toc-title" style="color: #1b233d; text-align: left; width: 100%;">Contents</p>
        <div class="content-table-section" style="text-align: left; width: 100%;">
            <span style="color: #1b233d;">Review</span>
            <hr>
        </div>
        <ul class="toc-list" style="text-align: left; width: 100%;">
            <?php
            // Hämta innehållet från content-block och analysera rubriker
            $content_block = get_the_content();
            preg_match_all('/<h([1-6])>(.*?)<\/h\1>/', $content_block, $matches, PREG_SET_ORDER);
            $toc_index = 1;
            $excluded_titles = [
                'Website:', 'Languages:', 'Established:', 'Licences:', 'Company:', 'Casino Type:', 'Deposit Methods:', 
                'Currencies:', 'Withdrawal Methods:', 'Withdrawal Times:', 'Withdrawal Limits:', 'Software:', 'Support:', 
                'Live Chat (Yes / No):', 'Deposit limit Tool', 'Wager Limit Tool', 'Loss Limit Tool', 'Time/Session Limit Tool', 
                'Self-Exclusion Tool', 'Cool Off/Time-Out Tool', 'Reality Check Tool', 'Self-Assessment Test', 'Withdrawal Lock', 
                'Self-Exclusion Register Participation'
            ];
            foreach ($matches as $match) {
                if (!in_array($match[2], $excluded_titles)) {
                    echo '<li class="toc-link" style="text-align: left; width: 100%;"><a href="#toc-' . $toc_index . '"><span>' . $toc_index . '. </span>' . $match[2] . '</a></li>';
                    $toc_index++;
                }
            }
            ?>
        </ul>
    </div>
            <h3 style="color: #1b233d; font-family: 'Montserrat', sans-serif !important; font-weight: 700;">Rating</h3>
            <div class="rating-container" style="width: 100%; margin-top: 0px; font-size: calc(0.7 * (1rem + 0.5vw)); padding: 20px;">
              <div class="rating-content" style="width: 100%; font-size: calc(0.7 * (1rem + 0.5vw)); display: flex; flex-direction: column; justify-content: space-between;">
                <div class="rating-block" style="width: 100%; font-size: calc(0.7 * (1rem + 0.5vw)); display: flex; flex-direction: column; justify-content: space-between;">
                  <div class="rating-text" style="width: 100%; font-size: calc(0.7 * (1rem + 0.5vw)); display: flex; flex-direction: column; justify-content: space-between;">

                    <?php if ($casino_terms_desc) : ?>
                    <div class="rating-text-ins" style="width: 100%; font-size: calc(0.7 * (1rem + 0.5vw)); display: flex; flex-direction: column; justify-content: space-between;">
                      <span style="color: var(--text-red);"><?php echo wp_kses( $casino_terms_desc, $casino_allowed_html ); ?></span>
                    </div>
                    <?php endif; ?>

                  </div>
                </div>
              </div>
              <div class="rating-content" style="width: 100%; font-size: calc(0.7 * (1rem + 0.5vw)); display: flex; flex-direction: column; justify-content: space-between;">
                <div class="ratings-block" style="width: 100%; font-size: calc(0.7 * (1rem + 0.5vw)); display: flex; flex-direction: column; justify-content: space-between;">
                  <div class="ratings-all" style="width: 100%; font-size: calc(0.7 * (1rem + 0.5vw)); display: flex; flex-direction: column; justify-content: space-between;">
                    <div class="ratings-all-ins" style="width: 100%; font-size: calc(0.7 * (1rem + 0.5vw)); display: flex; flex-direction: column; justify-content: space-between;">

                      <?php if ( $casino_rating_trust ) : ?>
                      <div class="ratings-item" style="width: 100%; font-size: calc(0.7 * (1rem + 0.5vw)); display: flex; flex-direction: column; justify-content: space-between;">
                        <div class="ratings-item-ins" style="width: 100%; font-size: calc(0.7 * (1rem + 0.5vw)); display: flex; flex-direction: column; justify-content: space-between;">
                          <div class="ratings-item-value" style="width: 100%; font-size: calc(0.7 * (1rem + 0.5vw)); display: flex; flex-direction: column; justify-content: space-between;">
                            <span style="color: var(--text-red);"><?php echo esc_html( number_format( (float) $casino_rating_trust, 1, '.', ',' ) ); ?></span>
                            <i class="fas fa-star"></i>
                          </div>
                          <?php
                        $rating_1_title = get_option( 'rating_1' );
                        if ( $rating_1_title ) {
                          echo '<span style="color: var(--text-red);">' . esc_html( $rating_1_title ) . '</span>';
                        } else {
                          echo '<span style="color: var(--text-red);">' . esc_html__( 'Trust & Fairness', 'mercury' ) . '</span>';
                        } 
                      ?>
                        </div>
                      </div>
                      <?php endif; ?>

                      <?php if ( $casino_rating_games ) : ?>
                      <div class="ratings-item" style="width: 100%; font-size: calc(0.7 * (1rem + 0.5vw)); display: flex; flex-direction: column; justify-content: space-between;">
                        <div class="ratings-item-ins" style="width: 100%; font-size: calc(0.7 * (1rem + 0.5vw)); display: flex; flex-direction: column; justify-content: space-between;">
                          <div class="ratings-item-value" style="width: 100%; font-size: calc(0.7 * (1rem + 0.5vw)); display: flex; flex-direction: column; justify-content: space-between;">
                            <span style="color: var(--text-red);"><?php echo esc_html( number_format( (float) $casino_rating_games, 1, '.', ',' ) ); ?></span>
                            <i class="fas fa-star"></i>
                          </div>
                          <?php
                        $rating_2_title = get_option( 'rating_2' );
                        if ( $rating_2_title ) {
                          echo '<span style="color: var(--text-red);">' . esc_html( $rating_2_title ) . '</span>';
                        } else {
                          echo '<span style="color: var(--text-red);">' . esc_html__( 'Games & Software', 'mercury' ) . '</span>';
                        } 
                      ?>
                        </div>
                      </div>
                      <?php endif; ?>

                      <?php if ( $casino_rating_bonus ) : ?>
                      <div class="ratings-item" style="width: 100%; font-size: calc(0.7 * (1rem + 0.5vw)); display: flex; flex-direction: column; justify-content: space-between;">
                        <div class="ratings-item-ins" style="width: 100%; font-size: calc(0.7 * (1rem + 0.5vw)); display: flex; flex-direction: column; justify-content: space-between;">
                          <div class="ratings-item-value" style="width: 100%; font-size: calc(0.7 * (1rem + 0.5vw)); display: flex; flex-direction: column; justify-content: space-between;">
                            <span style="color: var(--text-red);"><?php echo esc_html( number_format( (float) $casino_rating_bonus, 1, '.', ',' ) ); ?></span>
                            <i class="fas fa-star"></i>
                          </div>
                          <?php
                        $rating_3_title = get_option( 'rating_3' );
                        if ( $rating_3_title ) {
                          echo '<span style="color: var(--text-red);">' . esc_html( $rating_3_title ) . '</span>';
                        } else {
                          echo '<span style="color: var(--text-red);">' . esc_html__( 'Bonuses & Promotions', 'mercury' ) . '</span>';
                        } 
                      ?>
                        </div>
                      </div>
                      <?php endif; ?>

                      <?php if ( $casino_rating_customer ) : ?>
                      <div class="ratings-item" style="width: 100%; font-size: calc(0.7 * (1rem + 0.5vw)); display: flex; flex-direction: column; justify-content: space-between;">
                        <div class="ratings-item-ins" style="width: 100%; font-size: calc(0.7 * (1rem + 0.5vw)); display: flex; flex-direction: column; justify-content: space-between;">
                          <div class="ratings-item-value" style="width: 100%; font-size: calc(0.7 * (1rem + 0.5vw)); display: flex; flex-direction: column; justify-content: space-between;">
                            <span style="color: var(--text-red);"><?php echo esc_html( number_format( (float) $casino_rating_customer, 1, '.', ',' ) ); ?></span>
                            <i class="fas fa-star"></i>
                          </div>
                          <?php
                        $rating_4_title = get_option( 'rating_4' );
                        if ( $rating_4_title ) {
                          echo '<span style="color: var(--text-red);">' . esc_html( $rating_4_title ) . '</span>';
                        } else {
                          echo '<span style="color: var(--text-red);">' . esc_html__( 'Customer Support', 'mercury' ) . '</span>';
                        } 
                      ?>
                        </div>
                      </div>
                      <?php endif; ?>

                    </div>
                  </div>
                </div>
              </div>
              <div class="rating-content" style="width: 100%; font-size: calc(0.7 * (1rem + 0.5vw)); display: flex; flex-direction: column; justify-content: space-between;">
                <div class="rating-overall" style="width: 100%; font-size: calc(0.7 * (1rem + 0.5vw)); display: flex; flex-direction: column; justify-content: space-between;">
                  <div class="rating-overall-ins text-center" style="width: 100%; font-size: calc(0.7 * (1rem + 0.5vw)); display: flex; flex-direction: column; justify-content: space-between;">
                    <span style="color: var(--text-red);"><?php echo esc_html( number_format( (float) $casino_overall_rating, 1, '.', ',' ) ); ?></span>
                    <span style="color: #1b233d;">
                      <?php
                    $rating_overall_title = get_option( 'rating_overall' );
                    if ( $rating_overall_title ) {
                      echo '<span style="color: var(--text-red);">' . esc_html( $rating_overall_title ) . '</span>';
                    } else {
                      echo '<span style="color: var(--text-red);">' . esc_html__( 'Overall Rating', 'mercury' ) . '</span>';
                    } 
                  ?>
                    </span>
                  </div>
                </div>
              </div>
            </div>
        <div class="right-side-wrap blocks-wrap desktop-right-side-values" style="border-radius: 5px; background: white; padding: 0px; overflow: hidden; box-shadow: 0 1px 8px 0 var(--text-red); position: relative; top: 0; margin-top: auto; height: auto; width: 100%; margin: 0;">
          <?php get_template_part('theme-parts/item-hot-bonus-desktop'); ?>
        </div>
        <div class="right-side-wrap blocks-wrap mobile-right-side-values" style="border-radius: 5px; background: white; padding: 0px; overflow: hidden; box-shadow: 0 1px 8px 0 var(--text-red); position: relative; top: 0; margin-top: auto; height: auto; width: 100%; margin: 0;">
          <?php get_template_part('theme-parts/item-hot-bonus-mobile'); ?>
        </div>
      </section>

      
    </div>

  </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
  const counters = document.querySelectorAll('.circle-value');

  counters.forEach(counter => {
    const updateCount = () => {
      const target = parseFloat(counter.getAttribute('data-value').replace(/[^0-9.]/g, ''));
      const count = parseFloat(counter.innerText.replace(/[^0-9.]/g, ''));
      const increment = target / 1000;

      if (count < target) {
        counter.innerText = (count + increment).toFixed(0) + counter.innerText.replace(/[0-9]/g, '');
        setTimeout(updateCount, 100);
      } else {
        counter.innerText = target.toFixed(0) + counter.innerText.replace(/[0-9]/g, '');
      }
    };

    updateCount();
  });
});
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const content = document.querySelector('.content-block');
        const tocContainer = document.querySelector('.content-table-container');
        const tocList = document.createElement('ul');
        tocList.classList.add('toc-list');
        tocContainer.appendChild(tocList);

        const headings = content.querySelectorAll('h1, h2, h3, h4, h5, h6');
        let tocIndex = 1;

        headings.forEach(heading => {
            const id = 'toc-' + tocIndex;
            heading.setAttribute('id', id);

            const tocItem = document.createElement('li');
            tocItem.classList.add('toc-link');
            const tocLink = document.createElement('a');
            tocLink.setAttribute('href', '#' + id);
            tocLink.textContent = tocIndex + '. ' + heading.textContent;
            tocItem.appendChild(tocLink);
            tocList.appendChild(tocItem);

            tocIndex++;
        });
    });
</script>
<style>
.circle-value {
  position: relative;
  display: inline-block;
  font-size: calc(0.7 * (1rem + 0.5vw));
  color: var(--text-red);
  transition: all 0.3s ease-in-out;
}

.circle-value::after {
  content: attr(data-value);
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  color: var(--text-red);
  opacity: 0;
  transition: opacity 0.3s ease-in-out;
}

.circle-value:hover::after {
  opacity: 1;
}
</style>
<style>
.content-table-container {
    border: 2px solid white;
    border-radius: 5px;
    background: #1b233d;
    padding: 10px;
    overflow: hidden;
    box-shadow: 0 1px 8px 0 #fff;
    position: relative;
}

.toc-title {
    font-size: 1.25rem;
    font-weight: bold;
    margin-bottom: 10px;
    color: var(--white);
}

.content-table-section {
    margin-bottom: 10px;
}

.toc-list {
    list-style: none;
    padding: 0;
}

.toc-link {
    margin-bottom: 5px;
}

.toc-link a {
    text-decoration: none;
    color: var(--text-red);
}

.toc-link a:hover {
    text-decoration: underline;
}

.toc-link span {
    color: var(--white);
}
</style>
<style>
  .link-button.red-link-button {
    display: block;
    text-align: center;
    background-color: var(--text-red);
    color: white;
    font-weight: bold;
    text-decoration: none;
    position: sticky;
    top: 0;
    z-index: 1000;
  }
</style>
// ... existing code ...
<?php get_footer(); ?>
