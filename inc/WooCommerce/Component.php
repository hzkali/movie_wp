<?php

/**
 * Streamit\Utility\Woocommerce\Component class
 *
 * @package streamit
 */

namespace Streamit\Utility\Woocommerce;

use Streamit\Utility\Component_Interface;
use Streamit\Utility\Templating_Component_Interface;
use function add_action;
use function Streamit\Utility\streamit;

/**
 * Class for managing Woocommerce UI.
 *
 * Exposes template tags:
 * * `streamit()->the_comments( array $args = array() )`
 *
 * @link https://wordpress.org/plugins/amp/
 */
class Component implements Component_Interface, Templating_Component_Interface
{
	/**
	 * Gets the unique identifier for the theme component.
	 *
	 * @return string Woocommerce slug.
	 */

	public $user_is_view_grid;
	public $user_is_col_no;


	public function get_slug(): string
	{
		return 'woocommerce';
	}
	function __construct()
	{
		add_filter('woocommerce_gallery_thumbnail_size', function ($size) {
			return array(300, 300);
		});
		setcookie('done', null, -1, '/');


		add_filter('woof_sort_terms_before_out', array($this, 'streamit_woof_hide_zero_term'));
	}

	/**
	 * Adds the action and filter hooks to integrate with WordPress.
	 */

	public function initialize()
	{
		add_filter("woof_products_query", function ($query) {
			session_start();
			$_SESSION['streamit_woof_query_ajax'] = $query;
			return $query;
		});
		add_action('init', array($this, 'streamit_set_default_cookie'), -91);
		add_filter('woocommerce_show_page_title', '__return_false');
		remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);
		add_action('woocommerce_before_shop_loop_item_title', array($this, 'streamit_loop_product_thumbnail'), 10);

		remove_action('woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10);
		remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5);

		// WooCommerce Checkout Fields Hook
		add_filter('woocommerce_checkout_fields',  array($this, 'custom_wc_checkout_fields'));

		// Single
		remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
		add_action('woocommerce_single_product_summary',  array($this, 'woocommerce_my_single_title'), 5);
		add_action('after_setup_theme', array($this, 'streamit_add_woocommerce_support'));
		remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0);
		remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10);

		add_action('woocommerce_before_main_content', array($this, 'streamit_woocommerce_output_content_wrapper_start'));
		add_action('woocommerce_after_main_content', array($this, 'streamit_woocommerce_output_content_wrapper_end'));

		// Remove add to cart
		remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart');
		remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 20);

		// Remove product title
		remove_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10);

		// Remove product price
		remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);

		add_filter('get_the_archive_title', array($this, 'streamit_product_archive_title'));

		/* Rating Create For Product Loop */
		remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);

		add_filter('woocommerce_add_to_cart_fragments', array($this, 'streamit_refresh_mini_cart_count'));

		remove_action('woocommerce_widget_shopping_cart_buttons', 'woocommerce_widget_shopping_cart_button_view_cart', 10);
		remove_action('woocommerce_widget_shopping_cart_buttons', 'woocommerce_widget_shopping_cart_proceed_to_checkout', 20);
		add_action('woocommerce_widget_shopping_cart_buttons', array($this, 'custom_widget_cart_btn_view_cart'), 21);
		add_action('woocommerce_widget_shopping_cart_buttons', array($this, 'custom_widget_cart_checkout'), 12);

		add_filter('woocommerce_sale_flash', array($this, 'lw_hide_sale_flash'));

		/* products loop_columns */
		add_filter('loop_shop_columns', array($this, 'streamit_loop_columns'), 21);

		/* wishlist title hide */
		add_filter('yith_wcwl_wishlist_params', array($this, 'streamit_wishlist_remove_title'), 10, 3);

		/* hide terms and conditions toggle */
		add_action('wp_enqueue_scripts', array($this, 'streamit_disable_terms'), 1000);

		/* woocommerce redirection after login registration */
		add_filter('woocommerce_registration_redirect', array($this, 'streamit_after_login_registration'), 10, 1);
		add_filter('woocommerce_login_redirect', array($this, 'streamit_after_login_registration'), 10, 1);
		add_filter('wc_get_template_part', array($this, 'streamit_wc_template_part'), 10, 3);

		add_filter('loop_shop_per_page', array($this, 'streamit_product_perpage'), 99999);

		add_action('woocommerce_before_checkout_form', array($this, 'streamit_woocomerce_page_header'), -999);
		add_action('woocommerce_before_cart', array($this, 'streamit_woocomerce_page_header'));
		add_action('streamit_order_summary_before', array($this, 'streamit_woocomerce_page_header'));

		add_filter('woocommerce_get_script_data', function ($params) {
			if (isset($params['i18n_view_cart'])) {
				$params['i18n_view_cart'] = '<span>' . $params['i18n_view_cart'] . '</span>';
			}
			return $params;
		});
		add_action('woocommerce_after_main_content', array($this, 'streamit_woo_notice_massage'), 99);


		if (has_filter('woocommerce_checkout_update_order_review_expired', true)) {
			add_filter('woocommerce_update_order_review_fragments', function ($ar) {
				$ar['form.woocommerce-checkout'] = "<div clas='woocommerce-notices-wrapper'>" . $ar['form.woocommerce-checkout'] . '</div>';
				return $ar;
			});
		}
		add_action('streamit_before_footer', array($this, 'streamit_woocommerce_mini_cart'));
	}
	public function template_tags(): array
	{
		return array(
			'get_single_product_dependent_script' 	=> array($this, 'get_single_product_dependent_script'),
			'streamit_load_woocomerce_script' 	=> array($this, 'streamit_load_woocomerce_script'),
			'streamit_ajax_product_load_scripts' 	=> array($this, 'streamit_ajax_product_load_scripts'),
		);
	}
	public function streamit_load_woocomerce_script()
	{
		wp_enqueue_script("woocomerce-product-dependency", get_template_directory_uri() . '/assets/js/woocommerce.min.js',  array('jquery'), "1.0.0", true);
	}
	public function streamit_ajax_product_load_scripts()
	{
		wp_enqueue_script("woocomerce-product-loadmore", get_template_directory_uri() . '/assets/js/ajax-product-load.min.js',  array('jquery'), "1.0.0", true);
	}
	public function streamit_woo_notice_massage()
	{
?>
		<div class="iq-modal css-prefix-model-woo">
			<div class="modal fade" id="<?php echo esc_attr(''); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
					<div class="modal-content">
						<div class="modal-body">
							<p class="streamit-model-text">

							</p>
						</div>
					</div>
				</div>
			</div>
		</div>
		<script type="text/javascript">
			jQuery(function(jQuery) {
				// On "added_to_cart" live event
				jQuery(document.body).on('added_to_cart', function(a, b, c, d) {
					let prod_name = '“' + d.data('product_name') + '”  has been added to your cart'; // Get the product name
					let notice_model = new bootstrap.Modal(document.querySelector('.css-prefix-model-woo>.modal'));
					jQuery('.css-prefix-model-woo .modal .streamit-model-text').html(prod_name);
					notice_model.show();
				});
			});
		</script>
	<?php
	}
	public function streamit_set_default_cookie()
	{
		if (!wp_doing_ajax() && $_SERVER['REQUEST_METHOD'] !== 'POST') {
			self::set_cookie();
		}
	}

	public static function set_cookie()
	{
		global $streamit_options;
		$streamit_options['woocommerce_shop_grid'] = isset($streamit_options['woocommerce_shop_grid']) && $streamit_options['woocommerce_shop_grid'] > 2 ? $streamit_options['woocommerce_shop_grid'] - 1 : 3;
		$arr = array(
			'is_grid' => isset($streamit_options['woocommerce_shop']) ? $streamit_options['woocommerce_shop'] : 2,
			'col_no' => isset($streamit_options['woocommerce_shop']) && $streamit_options['woocommerce_shop'] == '2' && isset($streamit_options['woocommerce_shop_grid']) ? $streamit_options['woocommerce_shop_grid']  : 3
		);
		foreach ($arr as $key => $value) {
			setcookie('product_view[' . $key . ']', $value, time() + 62208000, '/');
			$_COOKIE['product_view'][$key] = $value;
		}
	}
	public function streamit_yith_wcwl_dequeue_font_awesome_styles()
	{
		wp_deregister_style('yith-wcwl-font-awesome');
	}



	public function get_single_product_dependent_script()
	{
		wp_enqueue_style('slick-theme', get_template_directory_uri() . '/assets/css/vendor/slick/slick-theme.css', array(), '1.0', "all");
		wp_enqueue_style('slick-animation', get_template_directory_uri() . '/assets/css/vendor/slick/slick-animation.css', array(), '1.0', "all");

		wp_enqueue_script('slick-min', get_template_directory_uri() . '/assets/js/vendor/slick/slick.min.js', array(), '1.0', true);
		wp_enqueue_script('slick-animation', get_template_directory_uri() . '/assets/js/vendor/slick/slick-animation.min.js', array(), '1.0', true);
		wp_enqueue_script('products-swiper', get_template_directory_uri() . '/assets/js/products-slider.min.js', array(), '1.0', true);
	}

	/**
	 * Gets template tags to expose as methods on the Template_Tags class instance, accessible through `streamit()`.
	 *
	 * @return array Associative array of $method_name => $callback_info pairs. Each $callback_info must either be
	 *               a callable or an array with key 'callable'. This approach is used to reserve the possibility of
	 *               adding support for further arguments in the future.
	 */

	public function lw_hide_sale_flash()
	{
		return false;
	}

	function streamit_product_archive_title($title)
	{
		if (is_post_type_archive('product')) $title = esc_html__("Shop", 'streamit');
		return $title;
	}

	function streamit_add_woocommerce_support()
	{
		add_theme_support('woocommerce');
		add_theme_support('wc-product-gallery-zoom');
		add_theme_support('wc-product-gallery-lightbox');
		add_theme_support('wc-product-gallery-slider');
		// Declare WooCommerce support.
	}

	// overwrite existing output content wrapper function
	function streamit_woocommerce_output_content_wrapper_start()
	{
		if (is_singular()) {
			echo '<div class="container">
						<div class="row" >
							<div class="col-sm-12" >';
		}
	}

	function streamit_woocommerce_output_content_wrapper_end()
	{
		if (is_singular()) {
			echo '</div><!-- Col -->
						</div><!-- Close Row -->
					</div><!-- Close Container -->
				';
		}
	}

	function woocommerce_my_single_title()
	{
	?>
		<h2 itemprop="name" class="product_title entry-title"><span>
				<h5 class="streamit-product-title">
					<a href="<?php echo the_permalink(); ?>" class="streamit-product-title-link">
						<?php echo the_title() ?>
					</a>
				</h5>
			</span></h3>
		<?php
	}

	function streamit_loop_product_thumbnail($args = array())
	{
		global $streamit_options;

		if (is_shop() && (isset($streamit_options['woocommerce_shop']) && $streamit_options['woocommerce_shop'] == '1')  ||   $this->user_is_view_grid === '0') {
			get_template_part('template-parts/wocommerce/entry', 'listing');
		} else {
			get_template_part('template-parts/wocommerce/entry');
		}
	}

	// Change the format of fields with type, label, placeholder, class, required, clear, label_class, options
	function custom_wc_checkout_fields($fields)
	{

		//BILLING
		$fields['billing']['billing_first_name']['label'] = false;
		$fields['billing']['billing_first_name']['placeholder'] = "First Name *";

		$fields['billing']['billing_last_name']['label'] = false;
		$fields['billing']['billing_last_name']['placeholder'] = "Last Name *";

		$fields['billing']['billing_company']['label'] = false;
		$fields['billing']['billing_company']['placeholder'] = "Company *";

		$fields['billing']['billing_country']['label'] = false;
		$fields['billing']['billing_country']['placeholder'] = 'Country *';
		$fields['billing']['billing_address_1']['label'] = false;
		$fields['billing']['billing_city']['label'] = false;
		$fields['billing']['billing_city']['placeholder'] = 'City *';
		$fields['billing']['billing_state']['label'] = false;
		$fields['billing']['billing_state']['placeholder'] = 'State *';
		$fields['billing']['billing_postcode']['label'] = false;
		$fields['billing']['billing_postcode']['placeholder'] = 'Postcode *';
		$fields['billing']['billing_phone']['label'] = false;
		$fields['billing']['billing_phone']['placeholder'] = "Phone Number *";
		$fields['billing']['billing_email']['label'] = false;
		$fields['billing']['billing_email']['placeholder'] = "E-mail Address *";

		return $fields;
	}

	// refresh mini cart ------------//
	function streamit_refresh_mini_cart_count($fragments)
	{
		ob_start();
		$empty = '';
		if (empty(WC()->cart->get_cart_contents_count())) {
			$empty = 'style=display:none';
		}
		?>
			<div id="mini-cart-count" <?php echo esc_attr($empty); ?> class="cart-items-count count">
				<?php echo (WC()->cart->get_cart_contents_count() > 9) ? '9+' : WC()->cart->get_cart_contents_count(); ?>
			</div>
		<?php
		$fragments['#mini-cart-count'] = ob_get_clean();
		return $fragments;
	}

	// Mini cart View Cart Buttou
	function custom_widget_cart_btn_view_cart()
	{
		echo streamit()->streamit_get_comment_btn($tag = "a",  $label = 'View Cart', $show_icon = false, $attr = array(
			'href' => wc_get_cart_url(),
			'class' => 'checkout wc-forward view_cart btn-hover sample',
		));
	}

	//Mini Cart Checkout Button
	function custom_widget_cart_checkout()
	{
		echo streamit()->streamit_get_comment_btn($tag = "a",  $label = 'Checkout', $show_icon = false, $attr = array(
			'href' => wc_get_checkout_url(),
			'class' => 'btn-hover checkout wc-forward',
		));
	}

	/* products loop_columns */
	function streamit_loop_columns()
	{
		if ($_COOKIE['product_view']['is_grid'] == '2') {
			return $_COOKIE['product_view']['col_no'];
		} elseif ($_COOKIE['product_view']['is_grid'] == '1') {
			return 1;
		}

		return 3; // 3 products per row
	}

	/* wishlist title hide */
	function streamit_wishlist_remove_title($args, $action, $action_params)
	{
		if (isset($args['wishlist_meta']) && $args['wishlist_meta']['is_default'] && !empty($args['wishlist_meta']['wishlist_name'])) {
			$args['page_title'] = $args['wishlist_meta']['wishlist_name'];
		}

		return $args;
	}

	/* hide terms and conditions toggle */
	function streamit_disable_terms()
	{
		wp_add_inline_script('wc-checkout', "jQuery( document ).ready( function() { jQuery( document.body ).off( 'click', 'a.woocommerce-terms-and-conditions-link' ); } );");
	}

	/* woocommerce redirection after login & registration */
	function streamit_after_login_registration($streamit_redirection_url)
	{
		$streamit_redirection_url = esc_url(get_permalink(get_option('woocommerce_myaccount_page_id')) . 'my-account');
		return $streamit_redirection_url;
	}

	public function streamit_wc_template_part($template, $slug, $name)
	{
		if (is_shop() || is_product_category() || is_product_tag()) {
			$template_page = $_COOKIE['product_view']['is_grid'] == '2' ? 'entry.php' : 'entry-listing.php';
			$template_url = get_stylesheet_directory() . 'template-parts/wocommerce/' . $template_page;
			if (file_exists($template_url)) {
				return trailingslashit($template_url);
			}
			return trailingslashit(get_template_directory()) . 'template-parts/wocommerce/' . $template_page;
		}
		return $template;
	}

	public function streamit_product_perpage($per_page)
	{
		global $streamit_options;
		$is_loadmore_pagination = isset($streamit_options['streamit_woocommerce_display_pagination']) && $streamit_options['streamit_woocommerce_display_pagination'] == 'pagination';

		if (isset($streamit_options['woocommerce_product_per_page'])) {
			if (isset($_REQUEST['loaded_paged'])  &&  !$is_loadmore_pagination) {
				return $_REQUEST['loaded_paged'] * (int)$streamit_options['woocommerce_product_per_page'];
			}
			return (int)$streamit_options['woocommerce_product_per_page'];
		}
		return $per_page;
	}
	public function streamit_woocomerce_page_header()
	{
		$links = array(
			array(
				'name' => esc_html__('Shopping Cart', 'streamit'),
				'class' => is_cart() ? 'active' : '',
			),
			array(
				'name' => esc_html__('Checkout', 'streamit'),
				'class' => is_checkout() && empty(is_wc_endpoint_url('order-received'))  ? 'active' : '',
			),
			array(
				'name' => esc_html__('Order Summary', 'streamit'),
				'class' => is_checkout() && !empty(is_wc_endpoint_url('order-received'))  ? 'active' : '',
			),
		);

		?>
			<div class="streamit-page-header">
				<ul class="streamit-page-items">
					<?php
					foreach ($links as $key => $link) {


					?>
						<li class="streamit-page-item <?php echo esc_attr($link['class']) ?>">
							<span class="streamit-pre-heading"> <?php echo esc_html($key + 1) ?> </span>
							<span class="css-prefix-page-link ">
								<?php
								echo esc_html($link['name']);
								?>
							</span>
						</li>
					<?php
					}
					?>
				</ul>
			</div>



			<?php
		}

		public function streamit_woof_hide_zero_term($val)
		{
			$new_term_arr = [];
			foreach ($val as $key => $value) {
				if ($value['count'] > 0) {
					$new_term_arr[$key] = $value;
				}
			}
			return $new_term_arr;
		}
		public function streamit_woocommerce_mini_cart()
		{
			if (apply_filters('streamit_is_mini_cart_showing', false)) {
			?>
				<div class=" dropdown-menu-mini-cart">
					<div class="streamit-menu-header">
						<h5 class="cart-header "><?php esc_html_e('Shopping Cart', 'streamit'); ?> (<span class="streamit-cart-count"><?php echo  WC()->cart->get_cart_contents_count()  ?></span>)</h5>
						<a href="javascript:void(0);" class="dropdown-close">
							<i class="fas fa-times"></i>
						</a>
					</div>
					<div class="widget_shopping_cart_content">
						<?php
						if (function_exists("woocommerce_mini_cart") &&  WC()->cart) {
							woocommerce_mini_cart();
						}
						?>
					</div>
				</div>
	<?php
			}
		}
	}
