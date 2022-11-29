<?php

/**
 * Single Product Up-Sells
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/up-sells.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.0.0
 */

use function Streamit\Utility\streamit;

if (!defined('ABSPATH')) {
	exit;
}

if ($upsells) : ?>

	<section class="up-sells upsells products">
		<?php
		$heading = apply_filters('woocommerce_product_upsells_products_heading', __('You may also like', 'streamit'));

		if ($heading) :
		?>
			<div class=" streamit-title-box streamit-title-box-1 text-animation">

				<h4 class="streamit-title streamit-heading-title">
					<?php
					$streamit_words = explode(" ", $heading);
					$streamit_split = explode(' ', $heading);
					$streamit_lastword = array_pop($streamit_split);
					array_splice($streamit_words, -1);
					$streamit_string = implode(" ", $streamit_words);
					echo esc_html($streamit_string) . ' <span class="highlighted-text-wrap wow">' . $streamit_lastword . '</span>';
					?>
				</h4>
			</div>
		<?php endif;
		$upsells_count = count($upsells);
		if (class_exists('ReduxFramework') && $upsells_count > 4) {
			streamit()->get_single_product_dependent_script();
		?>
			<div class="swiper product-single-slider upsells-slider products streamit-main-product">
				<div class="swiper-wrapper streamit-upsells-product streamit-product-slider">
				<?php } else { ?>
					<div class="columns-4 products streamit-main-product product-grid-style">
					<?php
				}
				foreach ($upsells as $upsell) : ?>

						<?php
						$post_object = get_post($upsell->get_id());

						setup_postdata($GLOBALS['post'] = &$post_object); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited, Squiz.PHP.DisallowMultipleAssignments.Found

						if (class_exists('ReduxFramework') && $upsells_count > 4) {
						?>
							<div class="swiper-slide">
								<?php wc_get_template_part('content', 'product'); ?>
							</div>
						<?php
						} else {
							wc_get_template_part('content', 'product');
						}
						?>

					<?php
				endforeach;
				if (class_exists('ReduxFramework') && $upsells_count > 4) {
					?>
					</div>
				</div>
				<div class="iqonic-navigation">
					<div class="swiper-button-prev">
						<span class="text-btn">
							<span class="text-btn-line-holder">
								<span class="text-btn-line-top"></span>
								<span class="text-btn-line"></span>
								<span class="text-btn-line-bottom"></span>
							</span>
						</span>
					</div>
					<div class="swiper-button-next">
						<span class="text-btn">
							<span class="text-btn-line-holder">
								<span class="text-btn-line-top"></span>
								<span class="text-btn-line"></span>
								<span class="text-btn-line-bottom"></span>
							</span>
						</span>
					</div>
				</div>
			<?php } else { ?>
			</div>
		<?php } ?>

	</section>

<?php
endif;

wp_reset_postdata();
