<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta name="google-site-verification" content="mIKMgEO1SEs3bEKy2q3HyUOO7mU77nqwVpazmsUDabc" />
    <meta charset="<?php bloginfo('charset'); ?>" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" id="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, minimum-scale=1.0, user-scalable=yes" />
    <?php wp_head(); ?>
    <script type="text/javascript">
        var helper = {
            ajaxurl: '<?php echo admin_url('admin-ajax.php'); ?>',
            nonce: '<?php echo wp_create_nonce('zlots-nonce'); ?>'
        };
    </script>
</head>
<body ontouchstart <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div class="space-box relative<?php if (get_theme_mod('mercury_boxed_layout')) { ?> enabled<?php } ?>">

<!-- Header Start -->
<?php
    $header_style = get_theme_mod('mercury_header_style');
    if ($header_style == 2) {
        get_template_part('/theme-parts/header/style-2');
    } else {
        get_template_part('/theme-parts/header/style-1');
    }
?>
<!-- Header End -->
