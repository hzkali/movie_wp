<?php

/**
 * Streamit\Utility\Dynamic_Style\Styles\Header class
 *
 * @package streamit
 */

namespace Streamit\Utility\Dynamic_Style\Styles;

use Streamit\Utility;
use Streamit\Utility\Dynamic_Style\Component;
use function add_action;


class Header extends Component
{

    public function __construct()
    {
        add_action('wp_enqueue_scripts', array($this, 'streamit_header_dynamic_style'), 20);
        add_action('wp_enqueue_scripts', array($this, 'streamit_header_background_style'), 20);
        add_action('wp_enqueue_scripts', array($this, 'streamit_menu_color_options'), 20);
        add_action('wp_enqueue_scripts', array($this, 'streamit_sub_menu_color_options'), 20);
        add_action('wp_enqueue_scripts', array($this, 'streamit_responsive_menu_color_options'), 20);
        add_filter('body_class', array($this, 'streamit_add_body_classes'));
    }

    public function streamit_header_dynamic_style()
    {
        $page_id = get_queried_object_id();
        $header_css = '';
        if (function_exists('get_field') && get_field('name_header_display', $page_id) == 'no') {
            $header_css = 'header { 
					display : none !important;
				}';
        } else if (function_exists('get_field') && get_field('name_header_display', $page_id) == 'yes') {
            $header_css = '.iq-register .elementor-shortcode { 
					padding-top : 75px !important;
				}';
        }
        if (!empty($header_css)) {
            wp_add_inline_style('streamit-style', $header_css);
        }
    }

    public function streamit_header_background_style()
    {
        global $streamit_options;
        $dynamic_css = '';

        if (isset($streamit_options['streamit_header_background_type']) && $streamit_options['streamit_header_background_type'] != 'default') {
            $type = $streamit_options['streamit_header_background_type'];
            if ($type == 'color') {
                if (!empty($streamit_options['streamit_header_background_color'])) {
                    $dynamic_css = 'header#main-header{
							background : ' . $streamit_options['streamit_header_background_color'] . '!important;
						}';
                }
            }
            if ($type == 'image') {
                if (!empty($streamit_options['streamit_header_background_image']['url'])) {
                    $dynamic_css = 'header#main-header{
							background : url(' . $streamit_options['streamit_header_background_image']['url'] . ') !important;
						}';
                }
            }
            if ($type == 'transparent') {
                $dynamic_css = 'header#main-header{
						background : transparent !important;
					}';
            }
        }
        if (!empty($dynamic_css)) {
            wp_add_inline_style('streamit-style', $dynamic_css);
        }
    }

    function streamit_menu_color_options()
    {
        global $streamit_options;
        $inline_css = '';

        if (isset($streamit_options['streamit_header_variation'])  && $streamit_options['streamit_header_variation'] != '3') {
            if (isset($streamit_options['header_menu_color_type']) && $streamit_options['header_menu_color_type'] == 'custom') {

                if (isset($streamit_options['streamit_header_menu_color']) && !empty($streamit_options['streamit_header_menu_color'])) {
                    $inline_css .= 'header .navbar ul li a,header .navbar ul li i{
                    color : ' . $streamit_options['streamit_header_menu_color'] . '!important;
                }';
                }

                if (isset($streamit_options['streamit_header_menu_active_color']) && !empty($streamit_options['streamit_header_menu_active_color'])) {
                    $inline_css .= ' header .navbar ul li.current-menu-item a, header .navbar ul li.current-menu-parent > a, header .navbar ul li.current-menu-parent i, header .navbar ul li.current-menu-item i, header .navbar ul li.current-menu-ancestor> a, header .navbar ul li.current-menu-ancestor> i{
                    color : ' . $streamit_options['streamit_header_menu_active_color'] . ' !important;
                }';
                }

                if (isset($streamit_options['streamit_header_menu_hover_color']) && !empty($streamit_options['streamit_header_menu_hover_color'])) {
                    $inline_css .= 'header .navbar ul li:hover > a,header .navbar ul li:hover > i{
                    color : ' . $streamit_options['streamit_header_menu_hover_color'] . ' !important;
                }';
                }
            }
        }
        if (!empty($inline_css)) {
            wp_add_inline_style('streamit-style', $inline_css);
        }
    }
    function streamit_sub_menu_color_options()
    {
        global $streamit_options;
        $inline_css = '';

        if (isset($streamit_options['streamit_header_variation'])  && $streamit_options['streamit_header_variation'] != '3') {
            if (isset($streamit_options['header_submenu_color_type']) && $streamit_options['header_submenu_color_type'] == 'custom') {
                if (isset($streamit_options['streamit_header_submenu_color']) && !empty($streamit_options['streamit_header_submenu_color'])) {
                    $inline_css .= 'header .navbar ul li .sub-menu li a,header .navbar ul li .sub-menu li.current-menu-parent .sub-menu  li a, header .navbar ul li .sub-menu li:hover .sub-menu li a,header .navbar ul li .sub-menu li i,header .navbar ul li .sub-menu li.current-menu-parent .sub-menu  li i, header .navbar ul li .sub-menu li:hover .sub-menu li i,header .navbar ul li .sub-menu li:hover .sub-menu li a,header .navbar ul li .sub-menu li:hover .sub-menu li i{
                   color : ' . $streamit_options['streamit_header_submenu_color'] . ' !important;
               }';
                }

                if (isset($streamit_options['streamit_header_submenu_active_color']) && !empty($streamit_options['streamit_header_submenu_active_color'])) {
                    $inline_css .= 'header .navbar ul li .sub-menu li.current-menu-item a,header .navbar ul li .sub-menu li.current-menu-item i,header .navbar ul li .sub-menu li.current-menu-ancestor a,header .navbar ul li .sub-menu li.current-menu-ancestor i,header .navbar ul li .sub-menu li.current-menu-parent .sub-menu li.current-menu-item  a,header .navbar ul li .sub-menu li.current-menu-parent .sub-menu li.current-menu-item  i
                   {
                       color : ' . $streamit_options['streamit_header_submenu_active_color'] . ' !important;
                   }';
                }

                if (isset($streamit_options['streamit_header_submenu_hover_color']) && !empty($streamit_options['streamit_header_submenu_hover_color'])) {
                    $inline_css .= 'header .navbar ul li .sub-menu li:hover a,header .navbar ul li .sub-menu li:hover i,header .navbar ul li .sub-menu li.current-menu-parent:hover a, header .navbar ul li .sub-menu li.current-menu-parent .sub-menu li:hover a, header .navbar ul li .sub-menu li.current-menu-parent:hover .sub-menu li:hover a,header .navbar ul li .sub-menu li.current-menu-parent:hover i, header .navbar ul li .sub-menu li.current-menu-parent .sub-menu li:hover i, header .navbar ul li .sub-menu li.current-menu-parent:hover .sub-menu li:hover i,header .navbar ul li .sub-menu li:hover .sub-menu li:hover a,header .navbar ul li .sub-menu li:hover .sub-menu li:hover i{
                   color : ' . $streamit_options['streamit_header_submenu_hover_color'] . ' !important;
               }';
                }

                if (isset($streamit_options['streamit_header_submenu_background_color']) && !empty($streamit_options['streamit_header_submenu_background_color'])) {
                    $inline_css .= 'header .navbar ul li .sub-menu li a,header .navbar ul li .sub-menu li.current-menu-parent li a,header .navbar ul li .sub-menu li.current-menu-parent:hover .sub-menu li a,header .navbar ul li .sub-menu li:hover .sub-menu li a,header .navbar ul li .sub-menu li:hover .sub-menu li a {
                   background : ' . $streamit_options['streamit_header_submenu_background_color'] . ' !important;
               }';
                }

                if (isset($streamit_options['header_submenu_background_hover_color']) && !empty($streamit_options['header_submenu_background_hover_color'])) {
                    $inline_css .= 'header .navbar ul li .sub-menu li:hover a,header .navbar ul li .sub-menu li.current-menu-parent:hover a,header .navbar ul li .sub-menu li.current-menu-parent .sub-menu li:hover a,header .navbar ul li .sub-menu li.current-menu-parent:hover .sub-menu li:hover a,header .navbar ul li .sub-menu li:hover .sub-menu li:hover a{
                   background : ' . $streamit_options['header_submenu_background_hover_color'] . ' !important;
               }';
                }

                if (isset($streamit_options['header_submenu_background_active_color']) && !empty($streamit_options['header_submenu_background_active_color'])) {
                    $inline_css .= 'header .navbar ul li .sub-menu li.current-menu-item a,header .navbar ul li .sub-menu li.current-menu-parent a,header .navbar ul li .sub-menu li.current-menu-parent .sub-menu li.current-menu-item  a {
                   background : ' . $streamit_options['header_submenu_background_active_color'] . ' !important;
               }';
                }
            }
        }
        if (!empty($inline_css)) {
            wp_add_inline_style('streamit-style', $inline_css);
        }
    }

    function streamit_responsive_menu_color_options()
    {
        global $streamit_options;
        $inline_css = '';

        if (isset($streamit_options['responsive_menu_button_type']) && $streamit_options['responsive_menu_button_type'] == 'custom') {
            if (isset($streamit_options['responsive_menu_button_color']) && !empty($streamit_options['responsive_menu_button_color'])) {
                $inline_css .= 'header .navbar-light .navbar-toggler{
                color : ' . $streamit_options['responsive_menu_button_color'] . ' !important;
            }';
                $inline_css .= 'header .menu-btn .line{
                background-color : ' . $streamit_options['responsive_menu_button_color'] . ' !important;
            }';
            }

            if (isset($streamit_options['responsive_menu_button_background_color']) && !empty($streamit_options['responsive_menu_button_background_color'])) {
                $inline_css .= 'header .navbar-light .navbar-toggler{
                background : ' . $streamit_options['responsive_menu_button_background_color'] . ' !important;
                border-color : ' . $streamit_options['responsive_menu_button_background_color'] . ' !important;
            }';
            }
            if (isset($streamit_options['responsive_menu_color']) && !empty($streamit_options['responsive_menu_color'])) {
                $inline_css .= '@media (max-width: 992px){
                header .navbar ul li a{
                    color : ' . $streamit_options['responsive_menu_color'] . ' !important;
                }
            }';
            }
            if (isset($streamit_options['responsive_menu_color']) && !empty($streamit_options['responsive_menu_color'])) {
                $inline_css .= '@media (max-width: 992px){
                header .navbar ul li a, header .navbar ul li i{
                    color : ' . $streamit_options['responsive_menu_color'] . ' !important;
                }
            }';
            }

            if (isset($streamit_options['responsive_menu_hover_color']) && !empty($streamit_options['responsive_menu_hover_color'])) {
                $inline_css .= '@media (max-width: 992px){
                header .navbar ul li:hover a,header .navbar ul li:hover i{
                    color : ' . $streamit_options['responsive_menu_hover_color'] . ' !important;
                }
            }';
            }
            if (isset($streamit_options['responsive_menu_hover_color']) && !empty($streamit_options['responsive_menu_hover_color'])) {
                $inline_css .= '@media (max-width: 992px){
                header .navbar ul li:hover a,header .navbar ul li:hover i,header .navbar ul li.current-menu-item a, header .navbar ul li.current-menu-parent a, header .navbar ul li.current-menu-parent i, header .navbar ul li.current-menu-item i,header .navbar ul li.current-menu-ancestor a,header .navbar ul li.current-menu-ancestor i{
                    color : ' . $streamit_options['responsive_menu_hover_color'] . ' !important;
                }
            }';
            }

            if (isset($streamit_options['responsive_menu_background_color']) && !empty($streamit_options['responsive_menu_background_color'])) {
                $inline_css .= '@media (max-width: 992px){
                header .navbar ul li a{
                    background : ' . $streamit_options['responsive_menu_background_color'] . ' !important;
                }
            }';
            }
            if (isset($streamit_options['responsive_menu_active_background_color']) && !empty($streamit_options['responsive_menu_active_background_color'])) {
                $inline_css .= '@media (max-width: 992px){
                header .navbar ul li.current-menu-item a, header .navbar ul li a:hover,
                header .navbar ul li:hover a,header .navbar ul li.current-menu-item a, header .navbar ul li.current-menu-parent a,   header .navbar ul li.current-menu-ancestor a{
                    background : ' . $streamit_options['responsive_menu_active_background_color'] . ' !important;
                }
            }';
            }
        }
        if (!empty($inline_css)) {
            wp_add_inline_style('streamit-style', $inline_css);
        }
    }
    public function streamit_add_body_classes($classes)
    {
        global $streamit_options;

        if (function_exists('get_field') && get_field('name_header_display') == 'yes') {

            switch (get_field('header_position')) {
                case 'over':
                    $classes = array_merge($classes, array('iqonic-header-over'));
                    break;

                case 'under':
                    $classes = array_merge($classes, array('iqonic-header-under'));
                    break;
                default:
                    if (isset($streamit_options['header_postion'])) {
                        switch ($streamit_options['header_postion']) {
                            case 'over':
                                $classes = array_merge($classes, array('iqonic-header-over'));
                                break;

                            case 'under':
                                $classes = array_merge($classes, array('iqonic-header-under'));
                                break;
                        }
                    }
                    break;
            }
        } else {
            if (isset($streamit_options['header_postion'])) {

                switch ($streamit_options['header_postion']) {
                    case 'over':
                        $classes = array_merge($classes, array('iqonic-header-over'));
                        break;

                    case 'under':
                        $classes = array_merge($classes, array('iqonic-header-under'));
                        break;
                }
            }
        }

        return $classes;
    }
}
