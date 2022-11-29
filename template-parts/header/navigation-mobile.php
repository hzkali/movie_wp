<?php

/**
 * Template part for displaying the header navigation menu
 *
 * @package streamit
 */

namespace Streamit\Utility;

global $streamit_options;
$is_img =true;
?>

<nav class="streamit-menu-wrapper mobile-menu">
    <div class="navbar">
        <a class="navbar-brand " href="<?php echo esc_url(home_url('/')); ?>">
            <?php
            if (function_exists('get_field') || class_exists('ReduxFramework')) {
                $is_yes = function_exists('get_field') ? get_field('acf_key_header_switch') : '';
                $acf_logo = function_exists('get_field') ? get_field('header_logo') : '';

                if ($is_yes === 'yes' && !empty($acf_logo['url'])) {
                    $options = $acf_logo['url'];
                } else if (isset($streamit_options['header_radio'])) {
                    if ($streamit_options['header_radio'] == 1) {
                        $logo_text = $streamit_options['header_text'];
                        $is_img=false;
                        echo esc_html($logo_text);
                        
                    }
                    if ($streamit_options['header_radio'] == 2) {
                        $options = $streamit_options['streamit_mobile_logo']['url'];
                    }
                }
            }
                if (isset($options) && !empty($options)) {
                    echo '<img class="img-fluid logo" src="' . esc_url($options) . '" alt="streamit">';
                }
             elseif (has_header_image()) {
                $image = wp_get_attachment_image_src(get_theme_mod('custom_logo'), 'full');
                if (has_custom_logo()) {
                    echo '<img class="img-fluid logo" src="' . esc_url($image) . '" alt="streamit">';
                } else {
                    bloginfo('name');
                }
            } else {
                if($is_img)
                {
                    $logo_url = get_template_directory_uri() . '/assets/images/logo.png';
                    echo '<img class="img-fluid logo" src="' . esc_url($logo_url) . '" alt="streamit">';
                }
            } ?>
        </a>
        <?php if (streamit()->is_primary_nav_menu_active()) : ?>
            <button class="navbar-toggler custom-toggler ham-toggle streamit-menu-box" type="button">
                <span class="menu-btn d-inline-block">
                    <span class="line one"></span>
                    <span class="line two"></span>
                    <span class="line three"></span>
                </span>
            </button>
        <?php endif; ?>
    </div>

    <?php if (streamit()->is_primary_nav_menu_active()) : ?>
        <div class="c-collapse">
            <div class="menu-new-wrapper row align-items-center">
                <div class="menu-scrollbar verticle-mn yScroller col-lg-12">
                    <div id="streamit-menu-main" class="streamit-full-menu">
                        <?php
                        streamit()->display_primary_nav_menu(array('menu_id' => 'top-menu', 'menu_class' => 'navbar-nav',));
                        ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</nav><!-- #site-navigation -->