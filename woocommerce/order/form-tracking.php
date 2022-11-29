<?php

/**
 * Order tracking form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/order/form-tracking.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 6.5.0
 */

defined('ABSPATH') || exit;

global $post;

?>

<div class="track-form-wrapper">
    <form action="<?php echo esc_url(get_permalink($post->ID)); ?>" method="post" class="woocommerce-form woocommerce-form-track-order track_order">

        <p>
            <?php echo esc_html__('To track your order please enter your Order ID in the box below and press the "Track" button. This was given to you on your receipt and in the confirmation email you should have received.', 'streamit');?>
        </p>
        <p class="form-row form-row-first">
            <input class="input-text" type="text" name="orderid" id="orderid" value="<?php echo isset($_REQUEST['orderid']) ? esc_attr(wp_unslash($_REQUEST['orderid'])) : ''; ?>" placeholder="<?php esc_attr_e('Enter your order id.', 'streamit'); ?>" />

        </p>
        <p class="form-row form-row-last">
            <input class="input-text" type="text" name="order_email" id="order_email" value="<?php echo isset($_REQUEST['order_email']) ? esc_attr(wp_unslash($_REQUEST['order_email'])) : ''; ?>" placeholder="<?php esc_attr_e('Enter your email id.', 'streamit'); ?>" />
        </p>

        <div class="clear"></div>

        <p class="form-row track-btn mb-0">
            <button type="submit" class=" iq-button btn btn-hover" name="track" value="<?php esc_attr_e('Track', 'streamit'); ?>">
                <?php esc_html_e('Track Order', 'streamit'); ?>
            </button>
        </p>
        <?php wp_nonce_field('woocommerce-order_tracking', 'woocommerce-order-tracking-nonce'); ?>
    </form>
</div>