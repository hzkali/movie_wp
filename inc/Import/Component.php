<?php

/**
 * Streamit\Utility\Import\Component class
 *
 * @package streamit
 */

namespace Streamit\Utility\Import;

use Streamit\Utility\Component_Interface;

use function add_action;


class Component implements Component_Interface
{
	/**
	 * Gets the unique identifier for the theme component.
	 *
	 * @return string Component slug.
	 */
	public function get_slug(): string
	{
		return 'import';
	}

	/**
	 * Adds the action and filter hooks to integrate with WordPress.
	 */
	public function initialize()
	{
		add_filter('merlin_generate_child_functions_php', array($this, 'streamit_generate_child_functions_php'), 10, 2);
		add_filter('merlin_generate_child_style_css', array($this, 'streamit_generate_child_style_css'), 10, 5);
		add_filter('merlin_import_files', array($this, 'streamit_import_files'));
		add_action('merlin_after_all_import', array($this, 'streamit_after_import_setup'));
		add_filter('merlin_generate_child_screenshot', function () {
			return trailingslashit(get_template_directory()) . 'screenshot.png';
		});
	}

	function streamit_generate_child_functions_php($output, $slug)
	{

		$slug_no_hyphens = strtolower(preg_replace('#[^a-zA-Z]#', '', $slug));

		$output = "
		<?php
		/**
		 * Theme functions and definitions.
		 */
		add_action( 'wp_enqueue_scripts', '{$slug_no_hyphens}_enqueue_styles' ,99);

		function {$slug_no_hyphens}_enqueue_styles() {
				
			wp_enqueue_style( 'parent-style', get_stylesheet_directory_uri() . '/style.css'); 
			wp_enqueue_style( 'child-style',get_stylesheet_directory_uri() . '/style.css');
		}

		/**
		 * Set up My Child Theme's textdomain.
		*
		* Declare textdomain for this child theme.
		* Translations can be added to the /languages/ directory.
		*/
		function {$slug_no_hyphens}_child_theme_setup() {
			load_child_theme_textdomain( 'streamit', get_stylesheet_directory() . '/languages' );
		}
		add_action( 'after_setup_theme', '{$slug_no_hyphens}_child_theme_setup' );
	";

		// Let's remove the tabs so that it displays nicely.
		$output = trim(preg_replace('/\t+/', '', $output));

		// Filterable return.
		return $output;
	}

	public function streamit_generate_child_style_css($output, $slug, $author, $parent, $version)
	{

		$output = "
			/**
			* Theme Name: {$parent} Child
			* Description: This is a child theme of {$parent}, generated by iQonic Design.
			* Author: {$author}
			* Template: {$slug}
			* Version: {$version}
			*/\n
		";

		// Let's remove the tabs so that it displays nicely.
		$output = trim(preg_replace('/\t+/', '', $output));

		return  $output;
	}

	function streamit_import_files()
	{
		return array(
			array(
				'import_file_name'             => esc_html__('All Content', 'streamit'),
				'local_import_redux'           => array(
					array(
						'file_path'   => trailingslashit(get_template_directory()) . 'inc/Import/Demo/streamit_redux.json',
						'option_name' => 'streamit_options',
					),
				),
				'local_import_file'            => trailingslashit(get_template_directory()) . '/inc/Import/Demo/streamit-content.xml',
				'local_import_widget_file'     => trailingslashit(get_template_directory()) . '/inc/Import/Demo/streamit-widget.wie',
				'local_import_customizer_file' => trailingslashit(get_template_directory()) . '/inc/Import/Demo/streamit-export.dat',

				'import_preview_image_url'     => get_template_directory_uri() . '/screenshot.png',
				'import_notice' => esc_html__('DEMO IMPORT REQUIREMENTS: Memory Limit of 128 MB and max execution time (php time limit) of 300 seconds. ', 'streamit') . '</br></br>' . esc_html__('Based on your INTERNET SPEED it could take 5 to 25 minutes. ', 'streamit'),
				'preview_url'                  => 'https://wordpress.iqonic.design/product/wp/streamit',
			),
		);
	}

	function streamit_after_import_setup()
	{

		global $wp_filesystem;
		$content    =   '';

		// Assign menus to their locations.
		$locations = get_theme_mod('nav_menu_locations'); // registered menu locations in theme
		$menus = wp_get_nav_menus(); // registered menus

		if ($menus) {
			foreach ($menus as $menu) { // assign menus to theme locations

				if ($menu->name == 'Main Menu') {
					$locations['top'] = $menu->term_id;
				}
			}
		}
		set_theme_mod('nav_menu_locations', $locations); // set menus to locations 

		//reading settings default static pages

		$front_page_id = get_page_by_title('Streamit');
		$blog_page_id  = get_page_by_title('Blog');


		update_option('show_on_front', 'page');
		update_option('page_on_front', $front_page_id->ID);
		update_option('page_for_posts', $blog_page_id->ID);


		//Elementor Settings

		require_once(ABSPATH . '/wp-admin/includes/file.php');
		WP_Filesystem();

		$import_file =  trailingslashit(get_template_directory()) . 'inc/Import/Demo/elementor-site-settings.json';
		$enable_edit_with_elementor = [
			"post",
			"page",
			"iqonic_hf_layout",
		];
		update_option('elementor_cpt_support', $enable_edit_with_elementor);
		if (file_exists($import_file)) {
			$content = $wp_filesystem->get_contents($import_file);
		}

		if (!empty($content)) {
			$default_post_id = get_option('elementor_active_kit');
			update_post_meta($default_post_id, '_elementor_page_settings', json_decode($content, true));
		}

		// save woof setting
		$woof_setting_file =  trailingslashit(get_template_directory()) . 'inc/Import/Demo/streamit-woof-setting.json';
		if (file_exists($woof_setting_file)) {
			$content =  $wp_filesystem->get_contents($woof_setting_file);
			if (!empty($content)) {
				$woof_options = json_decode($content, true);
				foreach ($woof_options as $option_name => $option_data) {
					if (is_serialized($option_data)) {
						$option_data = unserialize($option_data);
					}
					update_option($option_name, $option_data);
				}
			}
		}

		update_option('woosq_button_type', 'link');
		update_option('woosq_button_position', '0');

		$wp_ulike_setting = get_option('wp_ulike_settings');
		$wp_ulike_setting['posts_group']['enable_auto_display'] = '0';

		update_option('wp_ulike_settings', $wp_ulike_setting);


		// remove default post
		wp_delete_post(1, true);

		// Set All Post Tag Counter
		global $query_posts;
		$query_posts = new \WP_Query(array(
			'nopaging' => true,
			'post_type' => array('movie', 'tv_show', 'video', 'post', 'person', 'nav_menu_item')
		));
		while ($query_posts->have_posts()) :
			$query_posts->the_post();
			wp_update_post(array(
				'ID' => get_the_ID(),
				'post_content' => get_the_content(),
			));
		endwhile;
	}
}