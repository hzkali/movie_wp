<?php

/**
 * Streamit\Utility\Dynamic_Style\Styles\General class
 *
 * @package streamit
 */

namespace Streamit\Utility\Dynamic_Style\Styles;

use Streamit\Utility\Dynamic_Style\Component;
use function add_action;

class General extends Component
{
	public $streamit_options;
	public function __construct()
	{

		add_action('wp_enqueue_scripts', array($this, 'streamit_create_general_style'), 20);
		add_action('wp_enqueue_scripts', array($this, 'streamit_page_404'), 20);
		add_action('wp_enqueue_scripts', array($this, 'streamit_badge_color'), 20);
		global $streamit_options;
		$this->streamit_options=$streamit_options;
	}

	public function streamit_create_general_style()
	{
		$general_var = '';

		if (isset($this->streamit_options['opt-container-width']) && !empty($this->streamit_options['opt-container-width'])) {

			$general = ((int)$this->streamit_options['opt-container-width'] / 16) . 'em';
			$general_var .= "
			body.iq-container-width .container,
			body.iq-container-width .elementor-section.elementor-section-boxed>.elementor-container {
				max-width: " . $general . ";} ";
		}
		if (isset($this->streamit_options['layout_set']) && $this->streamit_options['layout_set'] == 1) {
			if (isset($this->streamit_options['streamit_layout_color'])  && !empty($this->streamit_options['streamit_layout_color'])) {
				$general = $this->streamit_options['streamit_layout_color'];
				$general_var .= 'body { background : ' . $general . ' !important; }';
			}
		}
		if (isset($this->streamit_options['layout_set']) && $this->streamit_options['layout_set'] == 3) {
			if (isset($this->streamit_options['streamit_layout_image']['url']) && !empty($this->streamit_options['streamit_layout_image']['url'])) {
				$general = $this->streamit_options['streamit_layout_image']['url'];
				$general_var .= 'body { background-image: url(' . $general . ') !important; }';
			}
		}

		if (isset($this->streamit_options['streamit_back_to_top']) && !empty($this->streamit_options['streamit_back_to_top']) && $this->streamit_options['streamit_back_to_top'] == 'no') {
			$general_var .= '#back-to-top { display: none !important; }';
		}

		if (!empty($general_var)) {
			wp_add_inline_style('streamit-style', $general_var);
		}
	}
	public function streamit_page_404()
	{
		if (is_404()) {
			$header_footer_css = '';
			if (isset($this->streamit_options['header_on_404']) && !$this->streamit_options['header_on_404']) {
				$header_footer_css .= 'header#main-header { 
				display : none !important;
			}';
			}
			if (isset($this->streamit_options['footer_on_404']) && !$this->streamit_options['footer_on_404']) {
				$header_footer_css .= 'footer { 
				display : none !important;
			}';
			}
			if (!empty($header_footer_css)) {
				wp_add_inline_style('streamit-style', $header_footer_css);
			}
		}
	}

	// sale badge
	public function streamit_badge_color()
	{
		$bn_badge_color = "";

		if (!empty($this->streamit_options['streamit_display_sale_badge_color'])) {
			$bn_badge_color = $this->streamit_options['streamit_display_sale_badge_color'];
		}

		if (!empty($bn_badge_color)) {
			$badge_color = "
					.onsale.streamit-on-sale{
						background-color: $bn_badge_color !important;
					}";
			wp_add_inline_style('streamit-style', $badge_color);
		}

		if (!empty($this->streamit_options['streamit_display_new_badge_color'])) {
			$bn_badge_color = $this->streamit_options['streamit_display_new_badge_color'];
		}

		if (!empty($bn_badge_color)) {
			$badge_color = "
					.onsale.streamit-new{
						background-color: $bn_badge_color !important;
					}";
			wp_add_inline_style('streamit-style', $badge_color);
		}

		if (!empty($this->streamit_options['streamit_display_sold_badge_color'])) {
			$bn_badge_color = $this->streamit_options['streamit_display_sold_badge_color'];
		}

		if (!empty($bn_badge_color)) {
			$badge_color = "
				.onsale.streamit-sold-out{
						background-color: $bn_badge_color !important;
					}";
			wp_add_inline_style('streamit-style', $badge_color);
		}
	}
}
