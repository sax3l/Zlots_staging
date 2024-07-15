<!-- Footer Start -->

<div class="space-footer box-100 relative">
	<div class="space-footer-copy box-100 relative">
		<div class="space-footer-ins relative">
			<div class="space-footer-copy-left box-50 left relative">
				<?php if(get_theme_mod('footer_copyright') == '') { ?>
					<?php esc_html_e( '&copy; Copyright', 'mercury' ); ?> <?php echo esc_html( date( 'Y' ) ) ?> | <?php esc_attr_e( 'Zlots.com', 'mercury' ); ?>
				<?php } else { ?>
					<?php 
						$allowed_html = array(
							'a' => array(
								'href' => true,
								'title' => true,
								'target' => true,
							),
							'br' => array(),
							'em' => array(),
							'strong' => array(),
							'span' => array(),
							'p' => array()
						);
						echo wp_kses( get_theme_mod( 'footer_copyright' ), $allowed_html );
					?>
				<?php } ?>
			</div>
			<div class="space-footer-copy-menu box-50 left relative">
				<?php
					if (has_nav_menu('footer-menu')) {
						wp_nav_menu( array( 'container' => 'ul', 'menu_class' => 'space-footer-menu', 'theme_location' => 'footer-menu', 'depth' => 1, 'fallback_cb' => '__return_empty_string' ) );
					}
				?>
			</div>
		</div>
	</div>
</div>

<!-- Footer End -->

</div>

<!-- Mobile Menu Start -->

<?php get_template_part( '/theme-parts/mobile-menu' ); ?>

<!-- Mobile Menu End -->

<!-- Back to Top Start -->

<div class="space-to-top">
	<a href="#" id="scrolltop" title="<?php esc_attr_e( 'Back to Top', 'mercury' ); ?>"><i class="far fa-arrow-alt-circle-up"></i></a>
</div>

<!-- Back to Top End -->

<!-- Back to Top End -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    function addCrossOrigin() {
        document.querySelectorAll('img').forEach(function(img) {
            if (!img.hasAttribute('crossorigin')) {
                img.setAttribute('crossorigin', 'anonymous');
            }
        });
    }
    addCrossOrigin();
    var observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            mutation.addedNodes.forEach(function(node) {
                if (node.tagName === 'IMG' && !node.hasAttribute('crossorigin')) {
                    node.setAttribute('crossorigin', 'anonymous');
                }
            });
        });
    });
    observer.observe(document.body, {
        childList: true,
        subtree: true
    });
});
</script>




<?php wp_footer(); ?>

</body>
</html>