<?php

/**
 * Template part for displaying the page content when a 404 error has occurred
 *
 * @package streamit
 */

namespace Streamit\Utility;

use  \Elementor\Plugin;

global $streamit_options;
$is_default_404 = true;
if (isset($streamit_options['four_zero_four_layout']) && $streamit_options['four_zero_four_layout'] == 'custom') {
	if (!empty($streamit_options['404_layout'])) {
		$is_default_404 = false;
		$layout_404 = $streamit_options['404_layout'];
		$has_sticky = '';
		$my_layout = get_page_by_path($layout_404, '', 'iqonic_hf_layout');
		$f04_response =  Plugin::instance()->frontend->get_builder_content_for_display($my_layout->ID);
	}
}
?>
<?php if (!$is_default_404) : ?>
	<?php echo function_exists('iqonic_return_elementor_res') ? iqonic_return_elementor_res($f04_response) : $f04_response; ?>
<?php else : ?>
	<div class="container">
		<div id="primary" class="content-area">
			<main id="main" class="site-main">
				<div class="error-404 not-found">
					<div class="page-content">
						<div class="row">
							<div class="col-sm-12 text-center">
								<?php
								if (!empty($streamit_options['streamit_404_banner_image']['url'])) { ?>
									<div class="fourzero-image mb-5">
										<img src="<?php echo esc_url($streamit_options['streamit_404_banner_image']['url']); ?>" alt="<?php esc_attr_e('404', 'streamit'); ?>" />
									</div>

								<?php } else { ?>

									<img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/redux/404.png" alt="<?php esc_attr_e('404', 'streamit'); ?>" />

								<?php } ?>
								<h4>
									<?php
									$four_title = 'Oops! This Page is Not Found.';
									if (isset($streamit_options['streamit_fourzerofour_title']) && !empty($streamit_options['streamit_fourzerofour_title'])) {
										$four_title = $streamit_options['streamit_fourzerofour_title'];
									}
									echo esc_html($four_title);
									?>
								</h4>
								<p class="mb-5">
									<?php
									$four_des = 'The requested page does not exist.';
									if (isset($streamit_options['streamit_four_description']) && !empty($streamit_options['streamit_four_description'])) {
										$four_des = $streamit_options['streamit_four_description'];
									}
									echo esc_html($four_des);
									?>
								</p>
								<div class="d-block">
									<?php
									if (!empty($streamit_options['404_backtohome_title'])) {
										$btn_text  = esc_html($streamit_options['404_backtohome_title']);
									} else {
										$btn_text  = esc_html__('Back to Home', 'streamit');
									}
									echo streamit()->streamit_get_comment_btn('a',$btn_text,true,array('href'=>home_url(), 'class'=>'btn-hover')); ?>
								</div>
							</div>
						</div>
					</div><!-- .page-content -->
				</div><!-- .error-404 -->
			</main><!-- #main -->
		</div><!-- #primary -->
	</div><!-- .container -->

<?php endif; ?>