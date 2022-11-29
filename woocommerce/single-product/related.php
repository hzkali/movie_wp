<?php

/**
 * Related Products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/related.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce/Templates
 * @version      4.1.1
 */

namespace Streamit\Utility;

if (!defined('ABSPATH')) {
	exit;
}
if ($related_products) :
	global $streamit_options;
	if (isset($streamit_options['streamit_show_related_product']) && $streamit_options['streamit_show_related_product'] == 'no' && is_product()) {
		return false;
	}
?>

	<section class="related products container-fluid">
		<?php
		$heading = apply_filters('woocommerce_product_related_products_heading', isset($args['name']) ? $args['name'] : esc_html__('Related Products', 'streamit'));
		if ($heading) :
		?>

			<div class=" streamit-title-box streamit-title-box-1 text-animation">
				<h4 class="main-title">
					<?php
					echo esc_html($heading);
					?>
				</h4>
			</div>

		<?php endif; ?>

		<?php

		$related_count = count($related_products);
		if (class_exists('ReduxFramework') && $related_count > 4) {
			streamit()->get_single_product_dependent_script();
		?>
			<div class="swiper product-single-slider related-slider products streamit-main-product iq-rtl-direction">
				<div class="swiper-wrapper streamit-related-product streamit-product-slider product-grid-style products ">
				<?php
			} else { ?>
					<div class="columns-4 products product-grid-style streamit-main-product">
						<?php
					}

					foreach ($related_products as $related_product) :
						if (!$related_product) continue;
						$post_object = get_post($related_product->get_id());
						setup_postdata($GLOBALS['post'] = &$post_object);
						if (class_exists('ReduxFramework') && $related_count > 5) {
						?>
							<?php get_template_part('template-parts/wocommerce/entry'); ?>
						<?php
						} else {
							$args = array('is_related_product' => 'true');
							get_template_part('template-parts/wocommerce/entry', '', $args);
						}
					endforeach;

					if (class_exists('ReduxFramework') && $related_count > 5) {
						?>
					</div>
				</div>
			<?php } else { ?>
			</div>
		<?php } ?>
	</section>
<?php
endif;

wp_reset_postdata();
