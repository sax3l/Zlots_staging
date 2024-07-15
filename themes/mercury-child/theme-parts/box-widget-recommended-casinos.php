<?php

// Kontrollera att $casino_id är satt och är ett giltigt post-ID

if (!isset($casino_id) || !is_numeric($casino_id)) {
    return;

}

// Hämta nödvändig information från postmeta
$casino_name_full = get_the_title($casino_id); // Hämta hela titeln
$casino_name = explode(' | ', $casino_name_full)[0]; // Rensa bort allt efter " | "
$casino_name = str_replace('Casino', '', $casino_name); // Ta bort ordet "Casino"

$bonus_external_link = esc_url(get_post_meta($casino_id, 'zlots_bonus_external_link', true));
$bonus_spins = esc_html(get_post_meta($casino_id, 'zlots_bonus_spins', true)) . ' Free Spins';
$bonus_amount = '£/$/€' . esc_html(get_post_meta($casino_id, 'zlots_bonus_amount', true));
$casino_logo = wp_get_attachment_image_src(get_post_thumbnail_id($casino_id), 'full')[0];

?>

<div class="casino-box" style="display: flex; flex-direction: column; padding: 3px; border: 2px solid var(--white); border-radius: 5px; box-shadow: var(--green-shadow); width: 100%;">

    <div class="casino-box-inner" style="display: flex;justify-content: space-between;align-items: center;max-height: 70px;padding-top: 20px;">

        <div class="casino-logo-col" style="flex: 1; text-align: left; display: flex; align-items: center; background-color: transparent; margin: 4px;">
            <div class="casino-logo" style="background-color: transparent; margin-right: 0.5px;">

                <img loading="eager" decoding="async" alt="<?php echo $casino_name; ?>" class="casino-logo-img" width="50" height="50" src="<?php echo $casino_logo; ?>" style="border-radius: 5px; border: 1px solid rgb(255, 22, 84); width: 130px; height: auto; background-color: transparent;" crossorigin="anonymous" />

            </div>
        </div>
        <div class="casino-info-col" style="flex: 1; text-align: left; display: flex; flex-direction: column; align-items: flex-start; padding-top: 5px;">

            <div class="casino-name" style="font-size: 16px; font-weight: bold; color: rgb(255, 22, 84);"><?php echo $casino_name; ?></div>

            <div class="casino-bonus">
                <p class="casino-bonus-text" style="font-size: 14px; color: rgb(236, 195, 31); margin: 0.5;"><?php echo $bonus_spins ?: $bonus_amount; ?></p>
            </div>
        </div>
        <div class="casino-link-col" style="flex: 1; text-align: right; display: flex; align-items: center; margin: 0 5px;">

            <div class="casino-play-button" style="flex: 1; width: 100%;">

                <a class="play-now-btn" target="_blank" rel="nofollow noopener" href="<?php echo $bonus_external_link; ?>" tabindex="0" style="display: block; width: 100%; height: 100%; padding: 5px 10px; background-color: rgb(236, 195, 31); color: #fff; text-decoration: none; border-radius: 4px; transition: transform 0.3s; font-size: 14px; font-weight: bold; text-align: center;">Play Now</a>

            </div>

        </div>

    </div>
    <div class="casino-footer" style="padding-bottom: 20px; max-height: 20px;">

        <p class="casino-footer-text" style="font-size: 12px; color: #999; text-align: center;">18+ | Play responsibly | Terms apply</p>

    </div>
</div>

<style>
    .play-now-btn:hover {
        transform: scale(1.05);
    }
</style>

