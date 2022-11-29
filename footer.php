<?php

/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package streamit
 */

namespace Streamit\Utility;

use Elementor\Plugin;

$footer_class = '';

global $streamit_options;
$is_default = true;

if (isset($streamit_options['display_footer'])) {
	$options = $streamit_options['display_footer'];
	if ($options == "yes") {
		if (isset($streamit_options['footer_image']['url'])) {
			$bgurl = $streamit_options['footer_image']['url'];
		}
	}
}

$is_default = true;
if (function_exists('get_field') && class_exists('ReduxFramework') && class_exists('\\Iqonic_Layouts\\Classes\\Iqonic_Layouts_Extension')) {
	$id = (get_queried_object_id()) ? get_queried_object_id() : '';
	$footer_display = !empty($id) ? get_post_meta($id, 'name_footer_display', true) : '';
	$footer_layout = !empty($id) ? get_post_meta($id, 'footer_layout_type', true) : '';
	$footer_name = !empty($id) ? get_post_meta($id, 'footer_layout_name', true) : '';

	if ($footer_display === 'yes' && $footer_layout !== 'default' && !empty($footer_name)) {
		$is_default = false;
		$footer = $footer_name;
		$my_layout = get_page_by_path($footer, '', 'iqonic_hf_layout');
		$footer_response =  Plugin::instance()->frontend->get_builder_content_for_display($my_layout->ID);
		wp_reset_postdata();
	} else if ($footer_layout == 'default' && $footer_display != 'default') {
		$is_default = true;
	} else if (isset($streamit_options['footer_layout']) && $streamit_options['footer_layout'] == 'custom') {
		$is_default = false;
		$footer = $streamit_options['footer_style'];
		$my_layout = get_page_by_path($footer, '', 'iqonic_hf_layout');
		$footer_response =  Plugin::instance()->frontend->get_builder_content_for_display($my_layout->ID);
		wp_reset_postdata();
	}
}

do_action('streamit_before_footer');

if ($is_default) {
?>
	<footer id="colophon" class="footer streamit-uniq footer-one iq-bg-dark" <?php if (!empty($bgurl)) { ?> style="background-image: url(<?php echo esc_url($bgurl); ?> ) !important;" <?php } ?>>
		<?php
		get_template_part('template-parts/footer/widget');
		get_template_part('template-parts/footer/info');
		?>
	</footer><!-- #colophon -->
<?php
} else {
?>
	<footer class="footer" id="colophon">
		<?php echo function_exists('iqonic_return_elementor_res') ? iqonic_return_elementor_res($footer_response) : $footer_response; ?>
	</footer>
<?php
}
?>
</div><!-- .site-content-contain -->
</div><!-- #page -->

<!-- === back-to-top === -->
<div id="back-to-top">
	<a class="top" id="top" href="#top">
		<i class="ion-ios-arrow-up"></i>
	</a>
</div>
<!-- === back-to-top End === -->
</div><!-- #page -->
<?php wp_footer(); ?>
</body>

</html>