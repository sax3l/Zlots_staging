<?php
/*
Template Name: Providers Archive Style Zlots
*/
get_header();
$term = get_queried_object();

$term_image_id = get_term_meta( $term->term_id, 'taxonomy-image-id', true );
$established   = get_term_meta( $term->term_id, 'zlots_taxonomy_established', true );
$website       = get_term_meta( $term->term_id, 'zlots_taxonomy_website', true );
$headquarters  = get_term_meta( $term->term_id, 'zlots_taxonomy_headquarters', true );
$licenses      = get_term_meta( $term->term_id, 'zlots_taxonomy_licenses', true );

$provider_casinos_ids  = zlots_get_provider_casinos_ids( $term->term_id );
$provider_casinos_html = zlots_get_casinos_archive_html( $provider_casinos_ids );

$provider_slots_recent_ids = zlots_get_provider_recent_slots_ids( $term->term_id );
$provider_slots_all_ids    = zlots_get_provider_all_slots_ids( $term->term_id, $provider_slots_recent_ids );

$provider_slots_recent_html = zlots_get_slots_archive_html( $provider_slots_recent_ids );
$provider_slots_all_html    = zlots_get_slots_archive_html( $provider_slots_all_ids );

$slot_count = zlots_get_post_count_for_term( $term->slug );

?>

    <!-- Title Box Start -->
    <div class="space-archive-title-box box-100 relative">
        <div class="space-archive-title-box-ins space-page-wrapper relative">
            <div class="space-archive-title-box-h1 relative">
                <!-- Breadcrumbs Start -->
                <div class="space-single-aces-breadcrumbs relative">
                    <div class="breadcrumbs">
                        <ul>
                            <li><a href="<?php echo home_url() ?>">Zlots.com</a> /</li>
                            <li><p><?php single_term_title() ?></p></li>
                        </ul>
                    </div>
                </div>
                <!-- Breadcrumbs End -->

                <div class="content-block">
                    <div class="left">
	                    <?php if ( $term_image_id ): ?>
		                    <?php echo wp_get_attachment_image( $term_image_id, 'zlots-300-300' ); ?>
	                    <?php endif; ?>
                    </div>

                    <div class="right">
                        <h1><?php single_term_title() ?></h1>

		                <?php if ( $website ): ?>
                            <a target="_blank" href="<?php echo $website ?>">Visit Website</a>
		                <?php endif; ?>

                        <div>
                            <div class="div-left">
                                Quick Information
                                <ul>
                                    <li>Founded: <?php echo $established ?></li>
                                    <li>Headquarters: <?php echo $headquarters ?></li>
                                    <li>Games: <?php echo $slot_count ?></li>
                                </ul>
                            </div>

                            <div class="div-right">
	                            <?php single_term_title() ?> Licenses

                                <p><?php echo $licenses ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Slots Start -->
                <div class="vendor-slots">
                    <ul>
                        <li><a href="#recent-releases">Recent Releases</a></li>
                        <li><a href="#all-slots">All Slots by <?php single_term_title() ?></a></li>
                    </ul>

                    <div id="recent-releases">
                        <?php echo $provider_slots_recent_html ?>
                    </div>

                    <div id="all-slots">
                        <?php echo $provider_slots_all_html ?>
                    </div>
                </div>
                <!-- Slots End -->

                <!-- Casinos Start -->
                <div class="vendor-casinos">
                    <p>Casinos Offering Games by <?php single_term_title() ?></p>
		            <?php echo $provider_casinos_html; ?>
                </div>
                <!-- Casinos End -->
            </div>
        </div>
    </div>
    <!-- Title Box End -->






<?php get_footer();
