<?php

/**
 * Streamit\Utility\Dynamic_Style\Styles\Banner class
 *
 * @package streamit
 */

namespace Streamit\Utility\Dynamic_Style\Styles;

use Streamit\Utility\Dynamic_Style\Component;
use function add_action;

class Banner extends Component
{

    public function __construct()
    {
        add_action('wp_enqueue_scripts', array($this, 'streamit_banner_dynamic_style'), 20);
        add_action('wp_enqueue_scripts', array($this, 'streamit_opacity_color'), 20);
        add_action('wp_enqueue_scripts', array($this, 'streamit_featured_hide'), 20);
    }

    public function streamit_banner_dynamic_style()
    {
        $page_id = get_queried_object_id();
        global $streamit_options;
        $dynamic_css = '';

        if (function_exists('get_field') && get_field('key_banner_display', $page_id) == 'no') {
            if (get_field('key_banner_display', $page_id) == 'no') {
                $dynamic_css .=
                    '.iq-breadcrumb-one { display: none !important; }
                    .content-area .site-main {padding : 0 !important; }';
                $this->streamit_banner_action();
            }
        } else if (isset($streamit_options['display_banner'])) {
            if ($streamit_options['display_banner'] == 'no') {
                $dynamic_css .=
                    '.iq-breadcrumb-one { display: none !important; }
                    .content-area .site-main {padding : 0 !important; }';
                $this->streamit_banner_action();
            } else if (isset($streamit_options['product_display_banner']) && $streamit_options['product_display_banner'] == 'no') {
                $dynamic_css .=
                    '.single-product .iq-breadcrumb-one { display: none !important; }';
                $this->streamit_banner_action();
            }
        }


        $key = (function_exists('get_field')) ? get_field('field_display_breadcrumb', $page_id) : "";
        if (isset($key['display_title']) && $key['display_title'] != 'default'  && $key['display_title'] == 'no') {
            $dynamic_css .= '.iq-breadcrumb-one .title { display: none !important; }';
        } else if (isset($streamit_options['display_title'])) {

            if ($streamit_options['display_title'] == 'no') {
                $dynamic_css .= '.iq-breadcrumb-one .title { display: none !important; }';
            }
        }

        if (isset($key['display_breadcumb']) && $key['display_breadcumb'] != 'default'  && $key['display_breadcumb'] == 'no') {
            $dynamic_css .= '.iq-breadcrumb-one .breadcrumb { display: none !important; }';
        } else if (isset($streamit_options['display_breadcumb'])) {
            if ($streamit_options['display_breadcumb'] == 'no') {
                $dynamic_css .= '.iq-breadcrumb-one .breadcrumb { display: none !important; }';
            }
        }

        if (isset($streamit_options['bg_title_color'])) {

            if (!empty($streamit_options['bg_title_color'])) {
                $dynamic = $streamit_options['bg_title_color'];
                $dynamic_css .= !empty($dynamic) ? '.iq-breadcrumb-one .title { color: ' . $dynamic . ' !important; }' : '';
            }
        }
        if (isset($streamit_options['bg_type'])) {
            $opt = $streamit_options['bg_type'];
            if ($opt == '1') {
                if (isset($streamit_options['bg_color']) && !empty($streamit_options['bg_color'])) {
                    $dynamic = $streamit_options['bg_color'];
                    $dynamic_css .= !empty($dynamic) ? '.iq-breadcrumb-one { background: ' . $dynamic . ' !important; }' : '';
                }
            }
            if ($opt == '2') {
                if (isset($streamit_options['banner_image']['url'])) {
                    $dynamic = $streamit_options['banner_image']['url'];
                    $dynamic_css .= !empty($dynamic) ? '.iq-breadcrumb-one { background-image: url(' . $dynamic . ') !important; }' : '';
                }
            }
        }
        if (!empty($dynamic_css)) {
            wp_add_inline_style('streamit-style', $dynamic_css);
        }
    }
    public function streamit_opacity_color()
    {
        //Set Background Opacity Color
        global $streamit_options;

        if (!empty($streamit_options['bg_opacity']) && $streamit_options['bg_opacity'] == "3") {
            $bg_opacity = $streamit_options['opacity_color']['rgba'];
        }

        if (!empty($streamit_options['bg_opacity']) && $streamit_options['bg_opacity'] == "3") {
            if (!empty($bg_opacity)) {
                $dynamic_css = "
                .breadcrumb-video::before,.breadcrumb-bg::before, .breadcrumb-ui::before {
                    background : $bg_opacity !important;
                }";
                wp_add_inline_style('streamit-style', $dynamic_css);
            }
        }
    }

    public function streamit_featured_hide()
    {
        global $streamit_options;
        $featured_hide = '';
        $post_format = "";

        if (isset($streamit_options['posts_select']) && !is_404() &&  isset($streamit_options['mainte_mode']) && $streamit_options['mainte_mode'] == 'no' && get_post_type() == 'post') //Condition for hide feature image for post 
        {
            $posts_format = $streamit_options['posts_select'];
            global $post;
            $post_id = $post->ID;
            $post_format = get_post_format($post_id);
            if (in_array(get_post_format(), $posts_format)) {
                $featured_hide .= '.streamit-blog-main-list .format-' . $post_format . ' .iq-blog-box .iq-blog-image img { display : none !important }';
            }
            wp_add_inline_style('streamit-style', $featured_hide);
        }
    }
    public function streamit_banner_action()
    {
        add_filter('body_class', function ($classes) {
            if ((get_post_meta(get_queried_object_id(), 'name_banner_display', true) == 'no') && (get_post_meta(get_queried_object_id(), 'name_header_display', true) == 'no')) {
                $classes[] = 'streamit-header-banner-hide';
            }else if (get_post_meta(get_queried_object_id(), 'name_banner_display', true) == 'no') {
                $classes[] = 'streamit-banner-hide';
            } 
            return $classes;
        });
    }
}
