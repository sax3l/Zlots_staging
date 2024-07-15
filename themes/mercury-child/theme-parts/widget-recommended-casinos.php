<?php
use Zlots\Casinos\Casino;

$recommended_casinos_ids = $args['casinos_ids'] ?? null;
?>
<section class="recommended-casinos-widget" style="border: 2px solid white; border-radius: 5px; background: #1b233d; padding: 10px; overflow: hidden; box-shadow: 0 1px 8px 0 #fff;">
    <div class="recommended-casinos-container-widget">
        <?php if (is_array($recommended_casinos_ids)): ?>
            <?php foreach ($recommended_casinos_ids as $casino_id): ?>
                <?php
                // Inkludera box-widget-recommended-casinos för varje rekommenderat casino
                include locate_template('theme-parts/box-widget-recommended-casinos.php');
                ?>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    <div class="view-all-casinos-button" style="display: flex; flex-direction: column; padding: 3px; border: 2px solid var(--white); border-radius: 5px; box-shadow: var(--green-shadow); max-height: 100px; background-color: rgb(255, 22, 84); text-align: center; margin-top: 10px; transition: transform 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);">
        <a href="/all-casinos" style="color: #fff; text-decoration: none; font-size: 18px; font-weight: bold; padding: 10px;">View all casinos</a>
    </div>
</section>
