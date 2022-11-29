<?php

/**
 * Streamit\Utility\Dynamic_Style\Styles\HeaderSticky class
 *
 * @package streamit
 */

namespace Streamit\Utility\Dynamic_Style\Styles;

use Streamit\Utility\Dynamic_Style\Component;
use function add_action;

class HeaderSticky extends Component
{
	public function __construct()
	{
		add_action('wp_enqueue_scripts', array($this, 'streamit_header_sticky_background_style'), 20);
		add_action('wp_enqueue_scripts', array($this, 'streamit_sticky_sub_menu_color_options'), 20);
		add_action('wp_enqueue_scripts', array($this, 'streamit_sticky_menu_color_options'), 20);
	}

	public function streamit_header_sticky_background_style()
	{
		global $streamit_options;
		$inline_css = '';
		$id = get_queried_object_id();
		 if (isset($streamit_options['sticky_header_display']) && $streamit_options['sticky_header_display'] === 'yes') {
			if (isset($streamit_options['sticky_header_background_type']) && $streamit_options['sticky_header_background_type'] != 'default') {
				$type = $streamit_options['sticky_header_background_type'];
				if ($type == 'color') {
					if (!empty($streamit_options['sticky_header_background_color'])) {
						$inline_css .= '.has-sticky.header-up,.has-sticky.header-down{
							background : ' . $streamit_options['sticky_header_background_color'] . '!important;
						}';
					}
				}
				if ($type == 'image') {
					if (!empty($streamit_options['sticky_header_background_image']['url'])) {
						$inline_css .= '.has-sticky.header-up,.has-sticky.header-down{
							background : url(' . $streamit_options['sticky_header_background_image']['url'] . ') !important;
						}';
					}
				}
				if ($type == 'transparent') {
					$inline_css .= '.has-sticky.header-up,.has-sticky.header-down{
						background : transparent !important;
					}';
				}
			}
		}
		if (!empty($inline_css)) {
			wp_add_inline_style('streamit-style', $inline_css);
		}
	}

	public function streamit_sticky_menu_color_options()
	{
		global $streamit_options;
		$inline_css = '';
		if (isset($streamit_options['sticky_menu_color_type']) && $streamit_options['sticky_menu_color_type'] == 'custom') {
			if (isset($streamit_options['sticky_menu_color']) && !empty($streamit_options['sticky_menu_color'])) {
				$inline_css .= '.has-sticky.header-down .navbar-nav > li > a, .has-sticky.header-up .navbar-nav > li > a{
						color : ' . $streamit_options['sticky_menu_color'] . '!important;
					}';
			}

			if (isset($streamit_options['sticky_menu_hover_color']) && !empty($streamit_options['sticky_menu_hover_color'])) {
				$inline_css .= '.has-sticky.header-down .navbar-nav li:hover > a,.has-sticky.header-down .navbar-nav li.current-menu-ancestor > a,.has-sticky.header-down .navbar-nav  li.current-menu-item > a, .has-sticky.header-up .navbar-nav li:hover > a,.has-sticky.header-up .navbar-nav li.current-menu-ancestor > a,.has-sticky.header-up .navbar-nav  li.current-menu-item > a{
						color : ' . $streamit_options['sticky_menu_hover_color'] . '!important;
					}';
			}
		}
		if (!empty($inline_css)) {
			wp_add_inline_style('streamit-style', $inline_css);
		}
	}

	public function streamit_sticky_sub_menu_color_options()
	{
		global $streamit_options;
		$inline_css = '';

		if (isset($streamit_options['sticky_header_submenu_color_type']) && $streamit_options['sticky_header_submenu_color_type'] == 'custom') {
			if (isset($streamit_options['sticky_streamit_header_submenu_color']) && !empty($streamit_options['sticky_streamit_header_submenu_color'])) {
				$inline_css .= '.has-sticky.header-down .navbar-nav ul.sub-menu a, .has-sticky.header-up .navbar-nav ul.sub-menu a{
                color : ' . $streamit_options['sticky_streamit_header_submenu_color'] . ' !important;
            }';
			}

			if (isset($streamit_options['sticky_streamit_header_submenu_hover_color']) && !empty($streamit_options['sticky_streamit_header_submenu_hover_color'])) {
				$inline_css .= '.has-sticky.header-down .navbar-nav li.sfHover>a,.has-sticky.header-down .navbar-nav li:hover>a,.has-sticky.header-down .navbar-nav li.current-menu-ancestor>a,.has-sticky.header-down .navbar-nav li.current-menu-item>a,.has-sticky.header-down .navbar-nav ul>li.menu-item.current-menu-parent>a,.has-sticky.header-down .navbar-nav ul li.current-menu-parent>a,.has-sticky.header-down .navbar-nav ul li .sub-menu li.current-menu-item>a,
				.has-sticky.header-up .navbar-nav li.sfHover>a,.has-sticky.header-up .navbar-nav li:hover>a,.has-sticky.header-up .navbar-nav li.current-menu-ancestor>a,.has-sticky.header-up .navbar-nav li.current-menu-item>a,.has-sticky.header-up .navbar-nav ul>li.menu-item.current-menu-parent>a,.has-sticky.header-up .navbar-nav ul li.current-menu-parent>a,.has-sticky.header-up .navbar-nav ul li .sub-menu li.current-menu-item>a{
                color : ' . $streamit_options['sticky_streamit_header_submenu_hover_color'] . ' !important;
            }';
			}

			if (isset($streamit_options['sticky_streamit_header_submenu_background_color']) && !empty($streamit_options['sticky_streamit_header_submenu_background_color'])) {
				$inline_css .= '.has-sticky.header-up .navbar-nav ul.sub-menu li, .has-sticky.header-down .navbar-nav ul.sub-menu li {
                background : ' . $streamit_options['sticky_streamit_header_submenu_background_color'] . ' !important;
            }';
			}

			if (isset($streamit_options['sticky_header_submenu_background_hover_color']) && !empty($streamit_options['sticky_header_submenu_background_hover_color'])) {
				$inline_css .= '.has-sticky.header-up .navbar-nav ul.sub-menu li:hover,.has-sticky.header-up .navbar-nav ul.sub-menu li.current-menu-item ,.has-sticky.header-up .navbar-nav ul.sub-menu li:hover,.has-sticky.header-up .navbar-nav ul.sub-menu li.current-menu-item,
				.has-sticky.header-down .navbar-nav ul.sub-menu li:hover,.has-sticky.header-down .navbar-nav ul.sub-menu li.current-menu-item ,.has-sticky.header-down .navbar-nav ul.sub-menu li:hover,.has-sticky.header-down .navbar-nav ul.sub-menu li.current-menu-item{
                background : ' . $streamit_options['sticky_header_submenu_background_hover_color'] . ' !important;
            }';
			}
		}
		if (!empty($inline_css)) {
			wp_add_inline_style('streamit-style', $inline_css);
		}
	}
}
