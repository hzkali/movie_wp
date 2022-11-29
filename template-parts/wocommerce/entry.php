<?php

global $product;
global $post;
global $streamit_options; 


$product = isset($args['id']) ? wc_get_product($args['id']) :  wc_get_product($post->ID); // condition fro Load Template from Plugin 
if (!$product) {
	return '';
}
$is_quickview = isset($streamit_options['streamit_display_product_quickview_icon']) && $streamit_options['streamit_display_product_quickview_icon'] == "yes";
$is_wishlist = isset($streamit_options['streamit_display_product_wishlist_icon']) && $streamit_options['streamit_display_product_wishlist_icon'] == "yes";
$is_addtocart = isset($streamit_options['streamit_display_product_addtocart_icon']) && $streamit_options['streamit_display_product_addtocart_icon'] == "yes";
?>
<div <?php wc_product_class('streamit-sub-product', $product->get_id()); ?>>
	<div class="streamit-inner-box ">
		<a href="<?php the_permalink(); ?>"></a>
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
					$image = wp_get_attachment_image_src($product->get_image_id(), 'streamit-product'); ?>
					<a href="<?php echo the_permalink($product->get_id()); ?>" class="streamit-product-title-link ">
						<?php echo '<div class="streamit-product-image">' . woocommerce_get_product_thumbnail() . '</div>'; ?>
					</a><?php
					} else { ?>
					<a href="<?php echo the_permalink($product->get_id()); ?>" class="streamit-product-title-link ">
						<?php
						echo sprintf('<div class="streamit-product-image"><img src="%s" alt="%s" class="wp-post-image" /></div>', esc_url(wc_placeholder_img_src()), esc_html__('Awaiting product image', 'streamit')); ?>
					</a><?php
					}
						?>
				<?php
				if ($is_quickview || $is_wishlist || $is_addtocart) {
				?>
					<div class="streamit-woo-buttons-holder">
						<ul>
							<?php
							if ($is_quickview) {  ?>
								<?php if (class_exists('WPCleverWoosq')) { ?>
									<li><?php echo do_shortcode('[woosq id="' . $product->get_id() . '"]') ?></li>
								<?php
								}
							}
							if ($is_wishlist) {
								if (class_exists('YITH_WCWL')) {
								?>
									<li>
										<?php echo do_shortcode('[yith_wcwl_add_to_wishlist]'); ?>
									</li>
								<?php }
							}

							if ($is_addtocart) { ?>
								<li>
									<?php if ($product->get_id() && !$product->is_type('grouped')) { ?>
										<a href="<?php echo esc_url($product->add_to_cart_url()); ?>" class=" ajax_add_to_cart add_to_cart_button d-flex align-items-center button streamit-box-shadow streamit-morden-btn" data-product_id="<?php echo esc_attr($product->get_id()); ?>" data-product_sku="<?php echo esc_attr($product->get_sku()); ?>" data-product_name="<?php the_title(); ?>">
											<svg width="20" height="18" viewBox="0 0 20 18" fill="none" xmlns="http://www.w3.org/2000/svg">
												<path d="M5 7.00009L10 1.00009L15 7.00009" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
												<path d="M19 7.00009L17 15.0001C16.9065 15.5733 16.6552 16.0873 16.2897 16.4528C15.9243 16.8182 15.4679 17.0119 15 17.0001H5C4.53211 17.0119 4.07572 16.8182 3.71028 16.4528C3.34485 16.0873 3.0935 15.5733 3 15.0001L1 7.00009H19Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
											</svg>
										</a>
									<?php } else { ?>
										<a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="added_to_cart d-flex align-items-center button iq-product-cart-button" title="<?php echo esc_attr__('View cart', 'streamit'); ?>">
											<i class="fas fa-check"></i>
										</a>
									<?php } ?>
								</li>
							<?php } ?>
						</ul>
					</div>
				<?php
				}
				?>
			</div>
		</div>
		<div class="product-caption">
			<?php if (isset($streamit_options['streamit_display_product_name']) && $streamit_options['streamit_display_product_name'] == "yes") {?>
				<h5 class="woocommerce-loop-product__title th13">
					<a href="<?php echo the_permalink($product->get_id()); ?>" class="streamit-product-title-link ">
						<?php echo esc_html($product->get_name()); ?>
					</a>
				</h5>
			<?php
			} ?>
			<?php if (isset($streamit_options['streamit_display_price']) && $streamit_options['streamit_display_price'] == "yes") {
			?>
				<div class="price-detail">
					<span class="price">
						<?php echo wp_kses($product->get_price_html(), 'streamit'); ?>
					</span>
				</div>
			<?php } ?>

			<?php if (isset($streamit_options['streamit_display_product_rating']) && $streamit_options['streamit_display_product_rating'] == "yes") {
			?>
				<div class="container-rating">
					<?php
					$rating_count = $product->get_rating_count();
					if ($rating_count >= 0) {
						$average      = $product->get_average_rating();
					?>
						<div class="star-rating">
							<?php echo wc_get_rating_html($average, $rating_count); ?>
						</div>
					<?php }
					?>
				</div>
			<?php } ?>
		</div>
	</div>
</div>