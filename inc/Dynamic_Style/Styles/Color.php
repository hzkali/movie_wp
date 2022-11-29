<?php

/**
 * Streamit\Utility\Dynamic_Style\Styles\Banner class
 *
 * @package streamit
 */

namespace Streamit\Utility\Dynamic_Style\Styles;

use Streamit\Utility\Dynamic_Style\Component;
use function add_action;

class Color extends Component
{

	public function __construct()
	{
		add_action('wp_enqueue_scripts', array($this, 'streamit_color_options'), 20);
		add_action('wp_enqueue_scripts', array($this, 'streamit_banner_title_color'), 20);
		add_action('wp_enqueue_scripts', array($this, 'streamit_layout_color'), 20);
		add_action('wp_enqueue_scripts', array($this, 'streamit_loader_color'), 20);
		add_action('wp_enqueue_scripts', array($this, 'streamit_bg_color'), 20);
		add_action('wp_enqueue_scripts', array($this, 'streamit_opacity_color'), 20);
		add_action('wp_enqueue_scripts', array($this, 'streamit_header_radio'), 20);
	}

	public function streamit_color_options()
	{

		global $streamit_options;
		$color_var = "";
		if (class_exists('ReduxFramework')) {
			
			if (isset($streamit_options['primary_color']) && !empty($streamit_options['primary_color'])) {
				$color = $streamit_options['primary_color'];
				$color_var .= '--iq-primary: ' . $color . ' !important;';
			}

			if (isset($streamit_options['primary_color_hover']) && !empty($streamit_options['primary_color_hover'])) {
				$color = $streamit_options['primary_color_hover'];
				$color_var .= '--iq-primary-hover: ' . $color . ' !important;';
			}
			if (isset($streamit_options['secondary_color']) && !empty($streamit_options['secondary_color'])) {
				$color = $streamit_options['secondary_color'];
				$color_var .= '--iq-secondary: ' . $color . ' !important;';
			}


			if (isset($streamit_options['text_color']) && !empty($streamit_options['text_color'])) {
				$color = $streamit_options['text_color'];
				$color_var .= '--iq-body-text: ' . $color . ' !important;';
			}


			if (isset($streamit_options['title_color']) && !empty($streamit_options['title_color'])) {
				$color = $streamit_options['title_color'];
				$color_var .= ' --iq-white-color: ' . $color . ' !important;';
			}
			if (isset($streamit_options['opt_color_gradient']['from']) && !empty($streamit_options['opt_color_gradient']['from'])) {
				$color = $streamit_options['opt_color_gradient']['from'];
				$from_rgb = implode(',', $this->hex2rgb($streamit_options['opt_color_gradient']['from']));
				$color_var .= ' --iq-form-gradient-color: rgba(' . $from_rgb . ',0) !important;';
			}
			if (isset($streamit_options['opt_color_gradient']['to']) && !empty($streamit_options['opt_color_gradient']['to'])) {
				$color = $streamit_options['opt_color_gradient']['to'];
				$to_rgb = implode(',', $this->hex2rgb($streamit_options['opt_color_gradient']['to']));
				$color_var .= ' --iq-to-gradient-color: rgba(' . $to_rgb . ',0.3) !important;';
			}
			if (!empty($color_var)) {
				$color_attrs = ':root { ' . $color_var . '}';
				wp_add_inline_style('streamit-style', $color_attrs);
			}
		}
	}

	public function streamit_banner_title_color()
	{
		//Set Body Color
		global $streamit_options;
		$bn_title_color = "";


		if (!empty($streamit_options['bg_title_color'])) {
			$bn_title_color = $streamit_options['bg_title_color'];
		}

		if (!empty($bn_title_color)) {
			$title_color = "
					.streamit-breadcrumb-one .title{
						color: $bn_title_color !important;
					}";
			wp_add_inline_style('streamit-style', $title_color);
		}
	}

	public function streamit_layout_color()
	{
		//Set Body Color
		global $streamit_options;
		$body_accent_color = "";

		if (!empty($streamit_options['streamit_layout_color'])) {
			$streamit_layout_color = $streamit_options['streamit_layout_color'];
		}

		if (function_exists('get_field')) {
			$page_id_body_col = get_queried_object_id();
			$key_body_bg_col = get_field('key_body', $page_id_body_col);
			if (isset($key_body_bg_col['body_variation']) && $key_body_bg_col['body_variation'] == 'has_body_color') {
				if (isset($key_body_bg_col['acf_body_color']) && !empty($key_body_bg_col['acf_body_color'])) {
					$body_back_color = $key_body_bg_col['acf_body_color'];
				}
			}
		}

		if (isset($body_back_color) && !empty($body_back_color)) {
			$body_accent_color .= "body {
									background-color: $body_back_color !important;
								}";
		} else if (!empty($streamit_options['layout_set']) && $streamit_options['layout_set'] == "1" ) {
			if (!empty($streamit_layout_color) && $streamit_layout_color != '#ffffff') {
				$body_accent_color .= "
            body {
                background-color: $streamit_layout_color !important;
            }";
			}
		} else {
			$body_accent_color = "";
		}
		if (!empty($body_accent_color)) {
			wp_add_inline_style('streamit-style', $body_accent_color);
		}
	}

	public function streamit_loader_color()
	{
		//Set Loader Background Color
		global $streamit_options;

		if (!empty($streamit_options['loader_color'])) {
			$loader_color = $streamit_options['loader_color'];
		}

		if (!empty($loader_color) && $loader_color != '#ffffff') {
			$ld_color = "#loading {
							background : $loader_color !important;
						}";
			wp_add_inline_style('streamit-style', $ld_color);
		}
	}

	public function streamit_bg_color()
	{
		//Set Background Color
		global $streamit_options;

		if (!empty($streamit_options['bg_color'])) {
			$bg_color = $streamit_options['bg_color'];
		}

		if (!empty($streamit_options['bg_type']) && $streamit_options['bg_type'] == "1") {
			if (!empty($bg_color)) {
				$background_color = "
					.streamit-bg-over {
						background : $bg_color !important;
					}";
				wp_add_inline_style('streamit-style', $background_color);
			}
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
			if (!empty($bg_opacity) && $bg_opacity != '#ffffff') {
				$op_color = "
				.breadcrumb-video::before,.breadcrumb-bg::before, .breadcrumb-ui::before {
					background : $bg_opacity !important;
				}";
				wp_add_inline_style('streamit-style', $op_color);
			}
		}
	}

	public function streamit_header_radio()
	{
		//Set Text Logo Color
		global $streamit_options;

		if (!empty($streamit_options['header_color'])) {
			$logo = $streamit_options['header_color'];
		}

		if (!empty($streamit_options['header_radio']) && $streamit_options['header_radio'] == "1") {
			if (!empty($logo) && $logo != '#ffffff') {
				$logo_color = "
					.logo-text {
						color : $logo !important;
					}";
				wp_add_inline_style('streamit-style', $logo_color);
			}
		}
	}
	//  Gredient Color
	public function hex2RGB($hexStr, $returnAsString = false, $seperator = ',')
	{
		$hexStr = preg_replace("/[^0-9A-Fa-f]/", '', $hexStr); // Gets a proper hex string
		$rgbArray = array();
		if (strlen($hexStr) == 6) { //If a proper hex code, convert using bitwise operation. No overhead... faster
			$colorVal = hexdec($hexStr);
			$rgbArray['red'] = 0xFF & ($colorVal >> 0x10);
			$rgbArray['green'] = 0xFF & ($colorVal >> 0x8);
			$rgbArray['blue'] = 0xFF & $colorVal;
		} elseif (strlen($hexStr) == 3) { //if shorthand notation, need some string manipulations
			$rgbArray['red'] = hexdec(str_repeat(substr($hexStr, 0, 1), 2));
			$rgbArray['green'] = hexdec(str_repeat(substr($hexStr, 1, 1), 2));
			$rgbArray['blue'] = hexdec(str_repeat(substr($hexStr, 2, 1), 2));
		} else {
			return false; //Invalid hex color code
		}
		return $returnAsString ? implode($seperator, $rgbArray) : $rgbArray; // returns the rgb string or the associative array
	}
}
