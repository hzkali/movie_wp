<?php


namespace Streamit\Utility;

global $product;
global $post;
global $streamit_options; 
$product = wc_get_product($post->ID);
if (!$product) {
	return '';
}

?>
<div <?php wc_product_class('streamit-sub-product', get_the_ID()); ?>>

	<div class="streamit-inner-box ">
		<a href="<?php the_permalink(); ?>"></a>
		<div class="row">
			<div class="col-md-4">
				<div class="streamit-product-block">
					<?php
					$newness_days = 30;
					$created = strtotime($product->get_date_created());
					if (!$product->is_in_stock()) {
					?>
						<span class="onsale streamit-sold-out"><?php echo esc_html__('Sold!', 'streamit') ?></span>
					<?php } else if ($product->is_on_sale()) { ?>
						<span class="onsale streamit-on-sale"><?php echo esc_html__('Sale!', 'streamit') ?></span>
					<?php } else if ((time() - (60 * 60 * 24 * $newness_days)) < $created) { ?>
						<span class="onsale streamit-new"><?php echo esc_html__('New!', 'streamit'); ?></span>
					<?php } ?>
					<div class="streamit-image-wrapper">
						<?php
						if ($product->get_image_id()) {
							$product->get_image('shop_catalog');
							$image = wp_get_attachment_image_src($product->get_image_id(), 'streamit-product');
						?>
							<a href="<?php echo the_permalink($product->get_id()); ?>" class="streamit-product-title-link ">
								<?php echo '<div class="streamit-product-image">' . woocommerce_get_product_thumbnail() . '</div>'; ?>
							</a><?php

							} else {
								?>
							<a href="<?php echo the_permalink($product->get_id()); ?>" class="streamit-product-title-link ">
								<?php
								echo sprintf('<div class="streamit-product-image"><img src="%s" alt="%s" class="wp-post-image" /></div>', esc_url(wc_placeholder_img_src()), esc_html__('Awaiting product image', 'streamit')); ?>
							</a><?php
							}
								?>


						<?php
						if (class_exists('ReduxFramework') && isset($streamit_options['streamit_display_product_quickview_icon'])) {
							if ($streamit_options['streamit_display_product_quickview_icon'] == "yes") { ?>
								<div class="streamit-woo-buttons-holder">
									<ul>
										<?php
										if (class_exists('WPCleverWoosq')) { ?>
											<li class="quick-view-icon"><?php echo do_shortcode('[woosq id="' . $product->get_id() . '"]') ?></li>
										<?php
										}
										?>
									</ul>
								</div>
							<?php } ?>
						<?php
						}
						?>
					</div>
				</div>
			</div>
			<div class="col-md-8">
				<div class="product-caption">
					<h4 class="woocommerce-loop-product__title th13">
						<a href="<?php echo the_permalink(); ?>" class="streamit-product-title-link ">
							<?php echo esc_html($product->get_name()); ?>
						</a>
					</h4>

					<div class="price-detail">
						<span class="price">
							<?php echo wp_kses($product->get_price_html(), 'streamit'); ?>
						</span>
					</div>

					<div class="container-rating">
						<?php
						$rating_count = $product->get_rating_count();
						if ($rating_count >= 0) {
							$average      = $product->get_average_rating();
						?>
							<div class="star-rating">
								<?php echo wc_get_rating_html($average, $rating_count); ?>
							</div>
						<?php } ?>
					</div>
					<div class="streamit-woo-buttons-holder">
						<ul>
							<li>
								<?php
								if ($product->get_id()) {
									if ($product->is_type('variable')) { ?>
										<a href="<?php echo esc_url($product->get_permalink()); ?>" class="iq-button btn streamit-add-to-cart btn btn-hover  " data-product_id="<?php echo get_the_ID(); ?>" data-product_sku="<?php echo esc_attr($product->get_sku()); ?>" data-product_name="<?php the_title(); ?>">
											<?php echo esc_html__('Select Options', 'streamit'); ?>
										</a>
									<?php } elseif ($product->is_type('grouped')) { ?>
										<a href="<?php echo esc_url($product->get_permalink()); ?>" class="iq-button btn streamit-add-to-cart btn btn-hover  " data-product_id="<?php echo get_the_ID(); ?>" data-product_sku="<?php echo esc_attr($product->get_sku()); ?>" data-product_name="<?php the_title(); ?>">
											<?php echo esc_html__('View products', 'streamit'); ?>
										</a>
									<?php } elseif ($product->is_type('external')) { ?>
										<a rel="nofollow" href="<?php echo esc_url($product->add_to_cart_url()); ?>" class="iq-button btn streamit-add-to-cart btn btn-hover  " data-quantity="<?php echo esc_attr(isset($quantity) ? $quantity : 1); ?>'" data-product_id="<?php echo get_the_ID(); ?>" data-product_sku="<?php echo esc_attr($product->get_sku()); ?>" target="_blank">
											<?php echo esc_html__('Our Product', 'streamit'); ?>
										</a>
									<?php } else {	?>
										<a href="<?php echo esc_url($product->add_to_cart_url()); ?>" class="ajax_add_to_cart add_to_cart_button iq-button btn streamit-add-to-cart btn btn-hover  " data-product_id="<?php echo get_the_ID(); ?>" data-product_sku="<?php echo esc_attr($product->get_sku()); ?>" data-product_name="<?php the_title(); ?>">
											<?php echo esc_html__('Add to Cart', 'streamit'); ?>
										</a>
									<?php }
								} else { ?>
									<a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="added_to_cart iq-button btn btn-hover wc-forward iq-button btn streamit-add-to-cart btn btn-hover  " title="View cart">
										<?php echo esc_html__('View cart', 'streamit'); ?>
										<i class="fas fa-long-arrow-alt-right ml-2"></i>
									</a>
								<?php
								}
								?>
							</li>

							<?php
							if (class_exists('YITH_WCWL')) {
							?>
								<li>
									<?php echo do_shortcode('[yith_wcwl_add_to_wishlist]'); ?>
								</li>

							<?php 	} ?>
						</ul>
					</div>
					<?php
					if (!empty(get_the_excerpt())) {
					?>
						<div class="streamit-product-description">
							<?php
							the_excerpt();
							?>
						</div>
					<?php
					}
					?>
				</div>
			</div>
		</div>
	</div>
</div>