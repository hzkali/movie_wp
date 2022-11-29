<?php

/**
 * Streamit\Utility\Redux_Framework\Options\User class
 *
 * @package streamit
 */

namespace Streamit\Utility\Redux_Framework\Options;

use Redux;
use Streamit\Utility\Redux_Framework\Component;

class Woocommerce extends Component
{

	public function __construct()
	{
		$this->set_widget_option();
	}

	protected function set_widget_option()
	{
		Redux::set_section($this->opt_name, array(
			'title' => esc_html__('WooCommerce ', 'streamit'),
			'icon'  => 'el el-shopping-cart',
			'customizer_width' => '500px',
		));


		Redux::set_section($this->opt_name, array(
			'title' => esc_html__('Shop Page', 'streamit'),
			'id'    => 'Woocommerce',
			'subsection' => true,
			'fields' => array(
				array(
					'id'        => 'woocommerce_shop',
					'type'      => 'image_select',
					'title'     => esc_html__('Shop page Setting', 'streamit'),
					'subtitle'  => wp_kses(__('Choose among these structures (Product Listing, Product Grid) for your shop section.<br />To filling these column sections you should go to appearance > widget.<br />And put every widget that you want in these sections.', 'streamit'), array('br' => array())),
					'options'   => array(
						'1' => array('title' => esc_html__('Product Listing', 'streamit'), 'img' => get_template_directory_uri() . '/assets/images/redux//single-column.jpg'),
						'2' => array('title' => esc_html__('Product Grid ', 'streamit'), 'img' => get_template_directory_uri() . '/assets/images/redux//three-column.jpg'),
					),
					'default'   => '2',
				),
				array(
					'id'        => 'woocommerce_shop_grid',
					'type'      => 'image_select',
					'title'     => esc_html__('Shop Grid page Setting', 'streamit'),
					'options'   => array(
						'1' => array('title' => esc_html__('Left Sidebar', 'streamit'), 'img' => get_template_directory_uri() . '/assets/images/redux//left-side.jpg'),
						'2' => array('title' => esc_html__('Right Sidebar', 'streamit'), 'img' => get_template_directory_uri() . '/assets/images/redux//right-side.jpg'),
						'3' => array('title' => esc_html__('Two Columns', 'streamit'), 'img' => get_template_directory_uri() . '/assets/images/redux//two-column.jpg'),
						'4' => array('title' => esc_html__('Three Columns', 'streamit'), 'img' => get_template_directory_uri() . '/assets/images/redux//three-column.jpg'),
						'5' => array('title' => esc_html__('Four Columns', 'streamit'), 'img' => get_template_directory_uri() . '/assets/images/redux//four-column.jpg'),
					),
					'default'   => '1',
					'required'  => array('woocommerce_shop', '=', '2'),
				),
				array(
					'id'        => 'woocommerce_shop_list',
					'type'      => 'image_select',
					'title'     => esc_html__('Shop List page Setting', 'streamit'),
					'options'   => array(
						'1' => array('title' => esc_html__('Left Sidebar', 'streamit'), 'img' => get_template_directory_uri() . '/assets/images/redux//left-side.jpg'),
						'2' => array('title' => esc_html__('Right Sidebar', 'streamit'), 'img' => get_template_directory_uri() . '/assets/images/redux//right-side.jpg'),
					),
					'default'   => '1',
					'required'  => array('woocommerce_shop', '=', '1'),
				),

				array(
					'id' => 'woocommerce_product_per_page',
					'type' => 'slider',
					'title' => esc_html__('Set Product Per Page', 'streamit'),
					'desc' => esc_html__('Here This option provide set post per paged item', 'streamit'),
					'min' => 1,
					'step' => 1,
					'max' => 99,
					'default' => 10
				),

				array(
					'id'        => 'streamit_woocommerce_display_pagination',
					'type'      => 'button_set',
					'title'     => esc_html__('Woocommerce Product Load Type', 'streamit'),
					'subtitle' => esc_html__('This Option Product The Shop page Product Load Type', 'streamit'),
					'options'   => array(
						'pagination' => esc_html__('Pagination', 'streamit'),
						'load_more' => esc_html__('Load More', 'streamit'),
						'infinite_scroll' => esc_html__('Infinite Scroll', 'streamit')
					),
					'default'   => 'pagination'
				),
				array(
					'id'        => 'streamit_show_cart_at_all',
					'type'      => 'button_set',
					'title'     => esc_html__('Show Cart', 'streamit'),
					'subtitle' => esc_html__('Turn on to Show Cart At All Page or Show Only In Woocommerce Pages', 'streamit'),
					'options'   => array(
						'yes' => esc_html__('On', 'streamit'),
						'no' => esc_html__('Off', 'streamit')
					),
					'required' 	=> array('display_header_cart_button', '=', 'yes'),
					'default'   => esc_html__('yes', 'streamit')
				),
				array(
					'id'        => 'streamit_woocommerce_payment_gateway_title',
					'type'      => 'text',
					'title'     => esc_html__('Woocommerce Payment Gateway Title', 'streamit'),
					'subtitle' => esc_html__('Add Text To Show Your Custom Woocommerce Payment Gateway Title', 'streamit'),
					'default'   => esc_html__('Woocommerce Payment Gateway', 'streamit'),
				),
			)
		));
		Redux::set_section($this->opt_name, array(
			'title' => esc_html__('Product Page', 'streamit'),
			'id'    => 'product_page',
			'subsection' => true,
			'fields' => array(

				array(
					'id' => 'product_display_banner',
					'type' => 'button_set',
					'title' => esc_html__('Display Banner on Product Page', 'streamit'),
					'subtitle' => esc_html__('This Option Display The Banner Of The Product', 'streamit'),
					'options' => array(
						'yes' => esc_html__('Yes', 'streamit'),
						'no' => esc_html__('No', 'streamit')
					),
					'default' => esc_html__('no', 'streamit')
				),
				array(
					'id' => 'streamit_show_related_product',
					'type' => 'button_set',
					'title' => esc_html__('Display Related Product On Single Page', 'streamit'),
					'subtitle' => esc_html__('This Option Display RElated Product On Single Page', 'streamit'),
					'options' => array(
						'yes' => esc_html__('Yes', 'streamit'),
						'no' => esc_html__('No', 'streamit')
					),
					'default' => esc_html__('yes', 'streamit')
				),

			)
		));
		Redux::set_section($this->opt_name, array(
			'title' => esc_html__('Products Setting', 'streamit'),
			'id'    => 'single_page',
			'subsection' => true,
			'fields' => array(


				array(
					'id'        => 'streamit_display_product_name',
					'type'      => 'button_set',
					'title'     => esc_html__('Display Name', 'streamit'),
					'subtitle' => esc_html__('Here This option provide Name Of The Product', 'streamit'),
					'options'   => array(
						'yes' => esc_html__('Yes', 'streamit'),
						'no' => esc_html__('No', 'streamit')
					),
					'default'   => 'yes'
				),

				array(
					'id'        => 'streamit_display_price',
					'type'      => 'button_set',
					'title'     => esc_html__('Display Price', 'streamit'),
					'subtitle' => esc_html__('Here This option Display The Price', 'streamit'),
					'options'   => array(
						'yes' => esc_html__('Yes', 'streamit'),
						'no' => esc_html__('No', 'streamit')
					),
					'default'   => 'yes'
				),

				array(
					'id'        => 'streamit_display_product_rating',
					'type'      => 'button_set',
					'title'     => esc_html__('Display Rating', 'streamit'),
					'subtitle' => esc_html__('Display The Ratings', 'streamit'),
					'options'   => array(
						'yes' => esc_html__('Yes', 'streamit'),
						'no' => esc_html__('No', 'streamit')
					),
					'default'   => 'no'
				),


				array(
					'id'        => 'streamit_display_product_addtocart_icon',
					'type'      => 'button_set',
					'title'     => esc_html__('Display AddToCart Icon', 'streamit'),
					'subtitle' => esc_html__('Display AddToCart Icon', 'streamit'),
					'options'   => array(
						'yes' => esc_html__('Yes', 'streamit'),
						'no' => esc_html__('No', 'streamit')
					),
					'default'   => 'yes'
				),

				array(
					'id'        => 'streamit_display_product_wishlist_icon',
					'type'      => 'button_set',
					'title'     => esc_html__('Display Wishlist Icon', 'streamit'),
					'subtitle' => esc_html__('Display The Wishlist Icon', 'streamit'),
					'options'   => array(
						'yes' => esc_html__('Yes', 'streamit'),
						'no' => esc_html__('No', 'streamit')
					),
					'default'   => 'yes'
				),


				array(
					'id'        => 'streamit_display_product_quickview_icon',
					'type'      => 'button_set',
					'title'     => esc_html__('Display QuickView Icon', 'streamit'),
					'subtitle' => esc_html__('Display QuickView Icon', 'streamit'),
					'options'   => array(
						'yes' => esc_html__('Yes', 'streamit'),
						'no' => esc_html__('No', 'streamit')
					),
					'default'   => 'yes'
				),
			

				array(
					'id'            => 'streamit_display_sale_badge_color',
					'type'          => 'color',
					'title'         => esc_html__(' Sale Badge Color', 'streamit'),
					'subtitle'		=> esc_html__('Color Of The Sale Badge', 'streamit'),
					'mode'          => 'background',
					'transparent'   => false,
				),

				array(
					'id'            => 'streamit_display_new_badge_color',
					'type'          => 'color',
					'title'         => esc_html__(' New Badge Color', 'streamit'),
					'subtitle' 		=> esc_html__('Color Of The New Badge', 'streamit'),
					'mode'          => 'background',
					'transparent'   => false,
				),


				array(
					'id'            => 'streamit_display_sold_badge_color',
					'type'          => 'color',
					'title'         => esc_html__(' Sold Badge Color', 'streamit'),
					'subtitle'      => esc_html__('Color Of The Sold BAdge', 'streamit'),
					'mode'          => 'background',
					'transparent'   => false,
				),
				'default' => 'yes'
			),

		));
		Redux::set_section($this->opt_name, array(
			'title' => esc_html__('Header', 'streamit'),
			'id'    => 'woo_header',
			'subsection' => true,
			'fields' => array(
				array(
					'id' => 'woo_header_layout',
					'type' => 'button_set',
					'title' => esc_html__('Header Layout', 'streamit'),
					'subtitle' => esc_html__('Select the variation for header ', 'streamit'),
					'options' => array(
						'default' => esc_html__('Default', 'streamit'),
						'custom' => esc_html__('Custom', 'streamit'),
					),
					'default' => esc_html__('default', 'streamit')
				),
				array(
					'id'        	=> 'woo_menu_style',
					'type'      	=> 'select',
					'title' 		=> esc_html__('Header Layout', 'streamit'),
					'subtitle' 		=> esc_html__('Select the layout variation that you want to use for header layout.', 'streamit'),
					'options'		=> (function_exists('iqonic_addons_get_list_layouts')) ? iqonic_addons_get_list_layouts(false, 'header') : '',
					'description'	=> (function_exists('iqonic_addons_get_list_layouts')) ? esc_html__("Create", 'streamit') . " <a target='_blank' href='" . admin_url('edit.php?post_type=iqonic_hf_layout') . "'>" . esc_html__("New Layout", 'streamit') . "</a>" : "",
					'required' 		=> array('woo_header_layout', '=', 'custom'),
				),
				array(
					'id' => 'woo_header_layout_position',
					'type' => 'button_set',
					'title' => esc_html__('Header Layout Position', 'streamit'),
					'options' => array(
						'horizontal' 	=> esc_html__('Horizontal', 'streamit'),
						'vertical' 		=> esc_html__('Vertical', 'streamit'),
					),
					'default' => 'horizontal',
					'required' 	=> array('header_layout', '=', 'custom'),
				),

				array(
					'id'        =>  'woo_vertical_header_width',
					'type'      =>  'dimensions',
					'units'     =>  array('em', 'px', '%'),
					'height'    =>  false,
					'width'     =>  true,
					'title'     =>  __('Vertical header width', 'streamit'),
					'default'   =>  array(
						'width'   => '300px',
					),
					'required' 	=> array('woo_header_layout_position', '=', 'vertical'),
				),
				array(
					'id'        	=> 'streamit_woo_header_variation',
					'type'      	=> 'image_select',
					'title' 		=> esc_html__('Header Layout', 'streamit'),
					'subtitle' 		=> esc_html__('Select the layout variation that you want to use for header layout.', 'streamit'),
					'options' => array(
						'1'      => array(
							'alt' => 'Style1',
							'img' => get_template_directory_uri() . '/assets/images/redux/header.png',
						),
					),
					'required' 	=> array('woo_header_layout', '=', 'default'),
					'default' => '1'
				),

				array(
					'id' => 'woo_header_postion',
					'type' => 'button_set',
					'title' => esc_html__('Header Position', 'streamit'),
					'options' => array(
						'default' => esc_html__('Default', 'streamit'),
						'under' => esc_html__('Under', 'streamit'),
						'over' => esc_html__('Over', 'streamit'),
					),
					'default' => 'over',
				),

				array(
					'id' => 'woo_header_layout_position',
					'type' => 'button_set',
					'title' => esc_html__('Header Layout Position', 'streamit'),
					'options' => array(
						'horizontal' 	=> esc_html__('Horizontal', 'streamit'),
						'vertical' 		=> esc_html__('Vertical', 'streamit'),
					),
					'default' => 'horizontal',
					'required' 	=> array('woo_header_layout', '=', 'custom'),
				),

				array(
					'id'        =>  'woo_vertical_header_width',
					'type'      =>  'dimensions',
					'units'     =>  array('em', 'px', '%'),
					'height'    =>  false,
					'width'     =>  true,
					'title'     =>  esc_html__('Vertical header width', 'streamit'),
					'default'   =>  array(
						'width'   => '300px',
					),
					'required' 	=> array('woo_header_layout_position', '=', 'vertical'),
				),


			)
		));

		Redux::set_section($this->opt_name, array(
			'title' => esc_html__('Footer', 'streamit'),
			'id'    => 'woo_footer',
			'subsection' => true,
			'fields' => array(
				array(
					'id' => 'woo_footer_layout',
					'type' => 'button_set',
					'title' => esc_html__('Footer Layout', 'streamit'),
					'options' => array(
						'default' => esc_html__('Default', 'streamit'),
						'custom' => esc_html__('Custom', 'streamit'),
					),
					'default' => 'default'
				),
				array(
					'id'        => 'woo_footer_style',
					'type'      => 'select',
					'title' 	=> esc_html__('Footer Layout', 'streamit'),
					'subtitle' 	=> esc_html__('Select the layout variation that you want to use for Footer.', 'streamit'),
					'options'	=> (function_exists('iqonic_addons_get_list_layouts')) ? iqonic_addons_get_list_layouts(false, 'footer') : '',
					'description'	=> (function_exists('iqonic_addons_get_list_layouts')) ? esc_html__("Create", 'streamit') . " <a target='_blank' href='" . admin_url('edit.php?post_type=iqonic_hf_layout') . "'>" . esc_html__("New Layout", 'streamit') . "</a>" : "",
					'required' 	=> array('woo_footer_layout', '=', 'custom'),
				),
			)
		));
	}
}
