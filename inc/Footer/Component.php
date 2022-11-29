<?php

/**
 * Streamit\Utility\Editor\Component class
 *
 * @package streamit
 */

namespace Streamit\Utility\Footer;

use Streamit\Utility\Component_Interface;
use Streamit\Utility\Templating_Component_Interface;

/**
 * Class for managing sidebars.
 *
 * Exposes template tags:
 * * `streamit()->get_footer_option()`
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/
 */
class Component implements Component_Interface, Templating_Component_Interface
{

	/**
	 * Gets the unique identifier for the theme component.
	 *
	 * @return string Component slug.
	 */
	public function get_slug(): string
	{
		return 'footer';
	}

	/**
	 * Adds the action and filter hooks to integrate with WordPress.
	 */
	public function initialize()
	{
		add_action('widgets_init', array($this, 'action_register_footers'));
		add_action('after_setup_theme', array($this, 'action_register_redux_footers'));
	}

	/**
	 * Gets template tags to expose as methods on the Template_Tags class instance, accessible through `streamit()`.
	 *
	 * @return array Associative array of $method_name => $callback_info pairs. Each $callback_info must either be
	 *               a callable or an array with key 'callable'. This approach is used to reserve the possibility of
	 *               adding support for further arguments in the future.
	 */
	public function template_tags(): array
	{
		return array(
			'get_footer_option' => array($this, 'get_footer_option')
		);
	}

	/**
	 * Registers the footer.
	 */
	public function action_register_footers()
	{
		$footer_option = [
			1 => 'footer_one',
			2 => 'footer_two',
			3 => 'footer_three',
			4 => 'footer_four'
		];

		$this->register_footers($footer_option);
	}

	public function action_register_redux_footers()
	{
		if (class_exists('Redux')) {
			if (empty($theme_option['footer_five'])) {

				$footer_option = [
					5 => 'footer_five',
				];

				$this->register_footers($footer_option);
			}
		}
	}

	public function register_footers($footer_option)
	{

		global $streamit_options;

		$default = [
			'1' => esc_html__('text-left', 'streamit'),
			'2' => esc_html__('text-right', 'streamit'),
			'3' => esc_html__('text-center', 'streamit'),
		];

		foreach ($footer_option as $key => $item) {
			$footer = '';
			if (!empty($theme_option[$item])) {
				$footer = $default[$theme_option[$item]];
			}
			register_sidebar(
				array(
					'name'          => esc_html__('Footer Area ' . $key, 'streamit'),
					'class'         => 'nav-list',
					'id'            => 'footer_' . ($key) . '_sidebar',
					'before_widget' => '<div class="widget ' . esc_attr($footer) . '">',
					'after_widget'  => '</div>',
					'before_title'  => '<h4 class="footer-title">',
					'after_title'   => '</h4>',
				)
			);
		}
	}

	public function get_footer_option(): array
	{
		$data = [];
		if (
			is_active_sidebar('footer_1_sidebar') || is_active_sidebar('footer_2_sidebar') ||
			is_active_sidebar('footer_3_sidebar') || is_active_sidebar('footer_4_sidebar') ||
			is_active_sidebar('footer_5_sidebar')
		) {
			if (function_exists('get_field') && class_exists('ReduxFramework')) {

				global $streamit_options;

				$page_id = get_queried_object_id();
				$acf_footer_option = get_field('acf_key_footer', $page_id);
				if (isset($acf_footer_option) && $acf_footer_option != "default") {
					$options = !empty($acf_footer_option) ? $acf_footer_option : '';
				} else {
					$options = !empty($streamit_options['streamit_footer_width']) ? $streamit_options['streamit_footer_width'] : '';
				}
				switch ($options) {
					case 1:
						$data['value'] = ['col-12'];
						break;
					case 2:
						$data['value'] = ['col-lg-6 col-sm-6', 'col-lg-6 col-sm-6'];
						break;
					case 3:
						$data['value'] = ['col-lg-4 col-sm-6', 'col-lg-4 col-sm-6 mt-4 mt-lg-0 mt-md-0', 'col-lg-4 col-sm-6 mt-lg-0 mt-md-5 mt-4'];
						break;
					case 4:
						$data['value'] = ['col-lg-4 col-sm-6 mt-4 mt-lg-0 mt-md-0', 'col-lg-2  col-sm-6 mt-lg-0 mt-4', 'col-lg-3 col-sm-6 mt-lg-0 mt-4', 'col-lg-3 col-sm-6 mt-lg-0 mt-4'];
						break;
					case 6:
						$data['value'] = ['col-lg-7', 'col-lg-2 col-md-6 mt-4 mt-lg-0', 'col-lg-3 col-md-6 mt-4 mt-lg-0'];
						break;
					default:
						$data['value'] = ['col-lg-4 col-sm-6', 'col-lg-4 col-sm-6 mt-3 mt-lg-0', 'col-lg-4 col-sm-12 mt-3 mt-lg-0'];
				}
			} else {
				$data['value'] = ['col-lg-4 col-sm-6', 'col-lg-4 col-sm-6 mt-3 mt-lg-0', 'col-lg-4 col-sm-12 mt-3 mt-lg-0'];
			}
		}
		return $data;
	}
}
