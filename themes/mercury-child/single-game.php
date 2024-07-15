<?php
get_header();
?>
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/css/page-single-game.css">
<?php

$post_id = get_the_ID();

$game_allowed_html = [
    'a' => [
        'href' => true,
        'title' => true,
        'target' => true,
        'rel' => true
    ],
    'br' => [],
    'em' => [],
    'strong' => [],
    'span' => [
        'class' => true
    ],
    'div' => [
        'class' => true
    ],
    'p' => [],
    'ul' => [],
    'ol' => [],
    'li' => [],
];

$game_rating = esc_html(get_post_meta($post_id, 'game_rating_one', true));
$game_short_desc = wp_kses(get_post_meta($post_id, 'game_short_desc', true), $game_allowed_html);
$game_date = get_the_date('d/m/Y', $post_id);
$slot_pros_desc = wp_kses(get_post_meta($post_id, 'slot_pros_desc', true), $game_allowed_html);
$slot_cons_desc = wp_kses(get_post_meta($post_id, 'slot_cons_desc', true), $game_allowed_html);

$game_link = esc_url(get_post_meta($post_id, 'zlots_slot_game_link', true));
$reels = get_post_meta($post_id, 'zlots_slot_reels', true);
$rows = get_post_meta($post_id, 'zlots_slot_rows', true);
$paylines = get_post_meta($post_id, 'zlots_slot_paylines', true);
$rtp = get_post_meta($post_id, 'zlots_slot_rtp', true);
$max_win = get_post_meta($post_id, 'zlots_slot_max_win', true);
$volatility = get_post_meta($post_id, 'zlots_slot_volatility', true);
$bet = get_post_meta($post_id, 'zlots_slot_bet', true);

$vendor = wp_get_object_terms($post_id, 'vendor');
$vendor_name = $vendor_slug = $vendor_id = $vendor_tax = null;

if (!empty($vendor[0])) {
    $vendor_name = $vendor[0]->name;
    $vendor_slug = $vendor[0]->slug;
    $vendor_id = $vendor[0]->term_id;
    $vendor_tax = $vendor[0]->taxonomy;
}

$is_mobile = wp_is_mobile();
$background_image = get_post_meta(get_the_ID(), 'background_image', true);
?>

<div id="post-<?php the_ID(); ?>" >
    <div class="single-page-wrap" style="max-width: 100%; margin: 0; background-color: var(--background-textbox-blue);">
    
    <!-- Title Box End -->
        <div class="space-page-wrapper single-game-content-wrap" style="max-width: 100%; margin: 0 auto; background-color: var(--background-textbox-blue);">
        <div class="space-archive-title-box-ins space-page-wrapper relative" style="max-width: 100%; margin: 0 auto; padding: 0; --background-site-blue: linear-gradient(90deg,rgb(4,28,87));">
            <div class="single-casino-top-info-wrap" style="max-width: 1500px; display: flex; justify-content: space-between; gap: 50px;">
                <div class="top-row" style="width: 50%; display: flex; flex-direction: column; gap: 20px;">
                    <div class="upper-side-wrap" style="color: var(--white);">
                        <span><a href="<?php echo home_url() ?>" style="color: var(--white);">Zlots.com</a></span> /
                        <span class="breadcrumb_last" aria-current="page" style="color: var(--white);"><?php echo get_the_title() ?></span>
                        <header class="entry-header clearfix" style="text-align: left; padding: 0;">
                            <h1 class="entry-title" style="font-size: 36px; line-height: 1.2; font-weight: 700; color: var(--white); text-align: left; margin: 10px 0; padding: 0; border: 0;"><?php echo preg_replace('/ – .*/', '', get_the_title()); ?></h1>
                            <div class="divider" style="height: 2px; background: linear-gradient(to right, rgba(255, 255, 255, 0), rgba(255, 255, 255, 0.75), rgba(255, 255, 255, 0)); margin: 0; padding: 0; border: 0; color: var(--white); text-align: center; width: calc(100% + 20px);"></div>
                            <div class="mh-subheading-top" style="text-align: left; margin: 0; padding: 0; border: 0;"></div>
                            <h2 class="mh-subheading" style="font-size: 24px; line-height: 1.2; font-weight: 400; color: var(--white); text-align: left; margin: 10px 0 20px 0; padding: 0; border: 0;">(<?php echo $vendor_name; ?>)  – Slot Demo & Review</h2>
                        </header>
                    </div>
                    <div class="logo-wrap" style="width: 100%; padding: 0px; border: 2px solid white; border-radius: 5px; background: #1b233d; overflow: hidden; box-shadow: 0 1px 8px 0 #fff; position: relative; display: flex; justify-content: center; align-items: center; gap: 50px; margin-bottom: 0;">
                        <?php
                        $post_title_attr = the_title_attribute('echo=0');
                        if (wp_get_attachment_image(get_post_thumbnail_id())) {
                            echo wp_get_attachment_image(get_post_thumbnail_id(), 'zlots-300-300', "", ['alt' => $post_title_attr, 'style' => 'width: 100%; height: 100%; object-fit: cover;']);
                        } ?>
                        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 20%; height: 20%;">
                            <button id="playNowButton" class="link-button red-link-button" data-game-link="<?php echo $game_link; ?>" style="width: 100%; height: 100%;">Play Now</button>
                        </div>
                    </div>
                </div>
                <div class="right-side-wrap" style="width: 40%; margin: 90px 0 0 0; padding: 0; border: none; position: relative;">
                <div class="tabs-wrap section-wrap" style="border: 2px solid white; border-radius: 5px; background: #1b233d; padding: 10px; overflow: hidden; box-shadow: 0 1px 8px 0 #fff; position: relative; top: 0; margin-top: auto; height: 330px;">
                        <ul class="tabs" style="display: flex; align-items: flex-start; width: 100%; overflow: visible; flex-wrap: nowrap; position: sticky; top: 0; margin: 30px 0 30px 0; font-size: calc(1rem + 0.5vw); padding: 0 25px;">
                            <li class="tab-link current" data-tab="betting" style="cursor: pointer; color: var(--white); text-align: center; font-weight: 600; flex: 1 0 auto; margin: 1px; padding: 0; white-space: normal;">Betting</li>
                            <li class="tab-link" data-tab="appearance" style="cursor: pointer; color: var(--white); text-align: center; font-weight: 600; flex: 1 0 auto; margin: 1px; padding: 0; white-space: normal;">Appearance</li>
                            <li class="tab-link" data-tab="pros-cons" style="cursor: pointer; color: var(--white); text-align: center; font-weight: 600; flex: 1 0 auto; margin: 1px; padding: 0; white-space: normal;">Pros & Cons</li>
                            <li class="tab-link" data-tab="rating" style="cursor: pointer; color: var(--white); text-align: center; font-weight: 600; flex: 1 0 auto; margin: 1px; padding: 0; white-space: normal;">Rating</li>
                            <li class="tab-link" data-tab="provider" style="cursor: pointer; color: var(--white); text-align: center; font-weight: 600; flex: 1 0 auto; margin: 1px; padding: 0; white-space: normal;">Provider</li>
                        </ul>
                        <div id="betting" class="blocks-wrap tab-content current" style="width: 100%; margin-top: 10px; font-size: calc(0.7 * (1rem + 0.5vw));">
                            <div class="tab-content-item" style="width: 100%; font-size: calc(0.7 * (1rem + 0.5vw)); display: flex; justify-content: space-between;">
                                <h5 style="color: var(--white);">RTP:</h5>
                                <div style="color: var(--text-red);"><?php echo $rtp ?? 'N/A'; ?></div>
                            </div>
                            <div class="tab-content-item" style="width: 100%; font-size: calc(0.7 * (1rem + 0.5vw)); display: flex; justify-content: space-between;">
                                <h5 style="color: var(--white);">Max Win:</h5>
                                <div style="color: var(--text-red);"><?php echo $max_win ?: 'N/A'; ?></div>
                            </div>
                            <div class="tab-content-item" style="width: 100%; font-size: calc(0.7 * (1rem + 0.5vw)); display: flex; justify-content: space-between;">
                                <h5 style="color: var(--white);">Volatility:</h5>
                                <div style="color: var(--text-red);"><?php echo $volatility ?: 'N/A'; ?></div>
                            </div>
                            <div class="tab-content-item" style="width: 100%; font-size: calc(0.7 * (1rem + 0.5vw)); display: flex; justify-content: space-between;">
                                <h5 style="color: var(--white);">Bet:</h5>
                                <div style="color: var(--text-red);"><?php echo $bet ?: 'N/A'; ?></div>
                            </div>
                        </div>
                        <div id="appearance" class="blocks-wrap tab-content" style="width: 100%; margin-top: 40px; font-size: calc(0.7 * (1rem + 0.5vw));">
                            <div class="tab-content-item" style="width: 100%; font-size: calc(0.7 * (1rem + 0.5vw)); display: flex; justify-content: space-between;">
                                <h5 style="color: var(--white);">Reels:</h5>
                                <div style="color: var(--text-red);"><?php echo $reels ?: 'N/A'; ?></div>
                            </div>
                            <div class="tab-content-item" style="width: 100%; font-size: calc(0.7 * (1rem + 0.5vw)); display: flex; justify-content: space-between;">
                                <h5 style="color: var(--white);">Rows:</h5>
                                <div style="color: var(--text-red);"><?php echo $rows ?: 'N/A'; ?></div>
                            </div>
                            <div class="tab-content-item" style="width: 100%; font-size: calc(0.7 * (1rem + 0.5vw)); display: flex; justify-content: space-between;">
                                <h5 style="color: var(--white);">Paylines:</h5>
                                <div style="color: var(--text-red);"><?php echo $paylines ?: 'N/A'; ?></div>
                            </div>
                        </div>
                        <div id="pros-cons" class="blocks-wrap tab-content" style="width: 100%; margin-top: 40px; font-size: calc(0.7 * (1rem + 0.5vw));">
                            <div class="tab-content-item" style="width: 100%; font-size: calc(0.7 * (1rem + 0.5vw)); display: flex; justify-content: space-between;">
                                <h5 style="color: var(--white);">Pros:</h5>
                                <div style="color: var(--text-red);"><?php echo $slot_pros_desc; ?></div>
                            </div>
                            <div class="tab-content-item" style="width: 100%; font-size: calc(0.7 * (1rem + 0.5vw)); display: flex; justify-content: space-between;">
                                <h5 style="color: var(--white);">Cons:</h5>
                                <div style="color: var(--text-red);"><?php echo $slot_cons_desc; ?></div>
                            </div>
                        </div>
                        <div id="rating" class="blocks-wrap tab-content" style="width: 100%; margin-top: 40px; font-size: calc(0.7 * (1rem + 0.5vw));">
                            <div class="tab-content-item" style="width: 100%; font-size: calc(0.7 * (1rem + 0.5vw)); display: flex; justify-content: space-between;">
                                <h5 style="color: var(--white);">Rating:</h5>
                                <div style="color: var(--text-red);"><?php echo $game_rating ?: 'N/A'; ?></div>
                            </div>
                        </div>
                        <div id="provider" class="blocks-wrap tab-content" style="width: 100%; margin-top: 40px; font-size: calc(0.7 * (1rem + 0.5vw));">
                            <div class="tab-content-item" style="width: 100%; font-size: calc(0.7 * (1rem + 0.5vw)); display: flex; justify-content: space-between;">
                                <h5 style="color: var(--white);">Provider:</h5>
                                <div style="color: var(--text-red);"><?php echo $vendor_name ?: 'N/A'; ?></div>
                            </div>
                        </div>
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
            </div>
        </div>
    </div>
    </div>  
        <div class="content-part-wrap" style="max-width: 100%; margin: 0 auto; background-color: white; display: flex; justify-content: center;">
            <section class="section-wrap-content-block" style="display: flex; width: 1500px;">
                <div class="left-side-wrap-content" style="width: 70%; margin-right: 35px;">
                    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                        <?php the_content(); ?>
                    <?php endwhile; endif; ?>
                </div>
                <div class="right-side-wrap-tab" style="position: sticky; top: 0; width: 30%; margin: 0; text-align: left; display: flex; flex-direction: column; align-items: flex-end;">
                    <div class="content-table-container" style="border: 2px solid white; border-radius: 5px; background: #1b233d; overflow: hidden; box-shadow: 0 1px 8px 0 #fff; position: relative; width: 100%;">
                        <p class="toc-title" style="color: var(--white); text-align: left; width: 100%;">Contents</p>
                        <div class="content-table-section" style="text-align: left;; width: 100%;">
                            <span style="color: var(--white);">Review</span>
                            <hr>
                        </div>
                        <ul class="toc-list" style="text-align: left; width: 100%;">
                            <?php
                            // Hämta innehållet och analysera rubriker
                            $content = get_the_content();
                            preg_match_all('/<h([1-6])>(.*?)<\/h\1>/', $content, $matches, PREG_SET_ORDER);
                            $toc_index = 1;
                            foreach ($matches as $match) {
                                echo '<li class="toc-link" style="text-align: left; width: 100%;"><a href="#toc-' . $toc_index . '"><span>' . $toc_index . '. </span>' . $match[2] . '</a></li>';
                                $toc_index++;
                            }
                            ?>
                        </ul>
                        </div>
                        <div style="width: 100%;">
                            <?php echo do_shortcode('[zlots-widget-recommended-casinos]'); ?>
                        </div>
                    </div>
                </div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const content = document.querySelector('.left-side-wrap-content');
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
            tocLink.textContent = heading.textContent;
            tocItem.appendChild(tocLink);
            tocList.appendChild(tocItem);

            tocIndex++;
        });
    });
</script>
</div>
</div>
</div>

<div id="gameModal" class="modal" style="display:none;">
    <div class="modal-content">
        <span id="closeModal" class="close-button">&times;</span>
        <iframe id="gameIframe" class="fancybox__iframe" allow="autoplay; fullscreen" scrolling="auto" style="width: 100%; height: 80vh;"></iframe>
    </div>
</div>

<style>
.modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0,0,0,0.5);
}

.modal-content {
    background-color: var(--white);
    margin: 10% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
}

.close-button {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close-button:hover,
.close-button:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}

/* CSS för left-side-wrap och right-side-wrap */
.section-wrap.content-block {
    display: flex;
    justify-content: space-between;
}

.left-side-wrap {
    width: 63%;
}

    .right-side-wrap-tab {
        width: 35%;
        position: relative;
}

@media (max-width: 768px) {
    .right-side-wrap {
        display: none;
    }
}


/* Anpassa bakgrundsfärg upp till .content-block */
.single-page-wrap {
    max-width: 100%;
    margin: 0;
}
<img alt="<?php echo $post_title_attr; ?>" style="
    margin-bottom: 0px;
    margin-left: 0px;
    margin-right: 0px;
    margin-top: 0px;
    max-height: 100%;
    max-width: 100%;
    object-fit: cover;
    width: relative;
    height: relative;
    aspect-ratio: auto 902 / 500;
    backface-visibility: hidden;
">

.top-row{
    position: relative;
    width: auto;
    display: flex;
    flex-direction: row;
    }


.single-game-top-info-wrap,
.single-game-middle-info-wrap {
    background-color: transparent;
}

@media (max-width: 767px) {
    .single-game-container {
        display: flex;
        flex-direction: column;
    }
    .title-wrap {
        order: 1;
    }
    .game-iframe-wrap {
        order: 2;
    }
    .date-rating-wrap.vertical-centered {
        order: 3;
    }
    .tabs-wrap.section-wrap {
        order: 4;
        display: flex;
        flex-direction: row;
    }
    .banner-section {
        order: 5;
    }
    .recommended-casinos-wrap {
        order: 6;
        display: block;
    }
    .logo-wrap {
        display: block;
    }
    .single-game-middle-info-wrap.section-wrap .game-wrap {
        width: 100%;
        height: auto;
        background-size: cover;
        background-position: center;
    }
}

/* Anpassa iframe-knappen */
#iframeGameDesktop {
    display: none;
}
#iframeGameDesktop.active {
    display: block;
    width: 100%;
    height: 100%;
    position: fixed;
    top: 0;
    left: 0;
}
.iframe-bwb__button {
    color: var(--white);
    padding: 10px 20px;
    border: none;
    cursor: pointer;
}
.iframe-bwb__button:focus,
.iframe-bwb__button:hover {
    background-color: var(--button-green-hover);
}

@media (min-width: 1025px) {
    .single-game-top-info-wrap {
        display: flex;
        gap: 2rem;
        flex-wrap: wrap;
    }

    .single-game-top-info-wrap .logo-wrap {
        width: 100%;
        flex: auto;
        height: auto;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .single-game-top-info-wrap {
        width: 100%;
        flex: auto;
        display: flex;
        flex-direction: column;
        position: relative;
    }
    .right-side-wrap {
        width: 100%;
        flex: auto;
        display: flex;
        flex-direction: row;
        position: relative;
    }

    .title-wrap {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .date-rating-wrap {
        display: flex;
        align-items: center;

    }

    .tabs-wrap ul.tabs {
        position: relative;
    width: auto;
    display: flex;
    flex-direction: row;
}

@media (max-width: 1024px) {
    .single-game-top-info-wrap {
        flex-direction: column;
        gap: 1rem;
    }


    }

    .tabs-wrap ul.tabs li {
        position: relative;
    width: auto;
    display: flex;
    flex-direction: row;
    margin: 2px;
    padding: 0;
    white-space: nowrap;
    }

    .game-iframe-wrap {
        width: 100%;
    }

    .game-iframe-wrap iframe {
        width: 100%;
        height: 100vh;
    }
}

@media (max-width: 768px) {
    .single-game-top-info-wrap .right-side-wrap {
        order: 1;
    }

    .single-game-top-info-wrap .left-side-wrap {
        order: 2;
    }

    .game-wrap {
        height: auto;
        padding-top: 56.25%;
        position: relative;
    }

    .game-iframe-wrap {
        width: 100%;
        height: 100vh;
    }

    .game-iframe-wrap iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100vh;
    }

    .tabs-wrap {
        order: 3;
    }
}

@media (max-width: 480px) {
    .single-game-top-info-wrap .logo-wrap {
        margin-bottom: 0;
    }
    .single-game-top-info-wrap .right-side-wrap {
        padding-top: 0;
        padding-bottom: 0;
        padding-right: 0;
        padding-left: 0;
    }
    .title-wrap {
        padding-left: 0;
        padding-right: 0;
    }
    .single-game-top-info-wrap .right-side-wrap {
        padding-left: 1rem;
        padding-right: 1rem;
    }

    .game-iframe-wrap {
        height: 100vh;
    }

    .game-iframe-wrap iframe {
        height: 100vh;
    }
}

/* Stilar för att anpassa utseendet på smartphones och mindre skärmar */
@media (max-width: 768px) {
    .single-game-middle-info-wrap .game-wrap {
        width: 100%;
        height: auto;
        background-size: cover;
        background-position: center;
    }

    .single-game-middle-info-wrap {
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    .left-side-wrap-content {
        display: flex;
        flex-direction: rown;
        align-items: left;
    }

    .title-wrap, 
    .game-iframe-wrap, 
    .date-rating-wrap, 
    .tabs-wrap, 
    .banner-section {
        width: 100%;
    }

    .tabs-wrap.section-wrap {
    position: relative;
    width: auto;
    display: flex;
    flex-direction: row;
    }
}

/* Fancybox container */
.fancybox__container {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 10000;
    background: rgba(0, 0, 0, 0.8);
    display: flex;
    align-items: center;
    justify-content: center;
}

.fancybox__backdrop {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.8);
}

.fancybox__content {
    position: relative;
    width: 80%;
    max-width: 1280px;
    height: 80%;
    max-height: 720px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.fancybox__iframe {
    width: 100%;
    height: 100%;
    border: none;
}

.f-button.is-close-btn {
    position: absolute;
    top: 10px;
    right: 10px;
    background: none;
    border: none;
    cursor: pointer;
}

f-button.is-close-btn svg {
    width: 24px;
    height: 24px;
}

#gameModal {
    display: none;
}

#gameModal.show {
    display: flex;
}

/* Justeringar för fancybox-carousel och dess underordnade element */
.fancybox__carousel {
    width: 100% !important;
    height: 100% !important;
}

.fancybox__viewport {
    height: 100% !important;
}

.fancybox__track {
    height: 100% !important;
}

.fancybox__slide {
    height: 100% !important;
    width: 100% !important;
}

.fancybox__content {
    height: 100% !important;
    width: 100% !important;
}
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

.right-side-wrap-tab {
    position: -webkit-sticky;
    position: sticky;
    top: 10px;
    right: 0;
    width: 35%; /* Justera bredden efter behov */
    margin-left: auto;
}

/* För mindre skärmar och smartphones */
@media (max-width: 768px) {
    .right-side-wrap-tab {
        position: relative;
        top: auto;
        width: 100%;
        margin-left: 0;
        margin-top: 20px;
    }
}
#playNowButton {
    position: absolute;
    justify-content: center;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 10;
}

.space-archive-title-box-ins.space-page-wrapper.relative {
    padding: 0;
    --background-site-blue: linear-gradient(90deg,rgb(4,28,87));
}

/* Add this CSS to ensure h2, h3, and paragraphs are displayed as rows */
.content-row {
    display: flex;
    flex-direction: column;
}

/* Ny CSS för att hantera hover-effekten på tabbar */
.tabs .tab-link:hover {
    color: var(--text-red);
    border-bottom: 2px solid var(--text-red);
    display: flex;
    justify-content: center;
}

.tabs .tab-link.current {
    color: var(--text-red);
    border-bottom: 2px solid var(--text-red);
    display: flex;
    justify-content: center;
}

/* Ny CSS för att hantera hover-effekten på tabbar */
.tabs .tab-link.hovered {
    color: var(--text-red);
    border-bottom: 2px solid var(--text-red);
    display: flex;
    justify-content: center;
}
</style>

<!-- JavaScript-kod direkt i single-game.php -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const playNowButton = document.getElementById('playNowButton');
        const gameModal = document.getElementById('gameModal');
        const gameIframe = document.getElementById('gameIframe');
        const closeModal = document.getElementById('closeModal');

        playNowButton.addEventListener('click', function () {
            const gameLink = playNowButton.getAttribute('data-game-link');
            gameIframe.src = gameLink;
            gameModal.style.display = 'block';
        });

        closeModal.addEventListener('click', function () {
            gameModal.style.display = 'none';
            gameIframe.src = '';  // Stoppar spelet när modalen stängs
        });

        window.addEventListener('click', function (event) {
            if (event.target == gameModal) {
                gameModal.style.display = 'none';
                gameIframe.src = '';  // Stoppar spelet när man klickar utanför modalen
            }
        });

        // Ny JavaScript-kod för att hantera hover-effekten på tabbar
        const tabs = document.querySelectorAll('.tabs .tab-link');
        let currentTab = document.querySelector('.tabs .tab-link.current');

        tabs.forEach(tab => {
            tab.addEventListener('mouseover', function () {
                tabs.forEach(t => t.classList.remove('hovered'));
                tab.classList.add('hovered');
            });

            tab.addEventListener('mouseout', function () {
                tabs.forEach(t => t.classList.remove('hovered'));
                currentTab.classList.add('hovered');
            });

            tab.addEventListener('click', function () {
                tabs.forEach(t => t.classList.remove('current'));
                tab.classList.add('current');
                currentTab = tab;
            });
        });

        // Initial hover-effekt på current tab
        currentTab.classList.add('hovered');
    });
</script>

<?php get_footer(); ?>



