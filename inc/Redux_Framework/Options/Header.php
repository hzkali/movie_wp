<?php

/**
 * Streamit\Utility\Redux_Framework\Options\General class
 *
 * @package streamit
 */

namespace Streamit\Utility\Redux_Framework\Options;

use Redux;
use Streamit\Utility\Redux_Framework\Component;

class Header extends Component
{

	public function __construct()
	{
		$this->set_widget_option();
	}

	protected function set_widget_option()
	{
		Redux::set_section($this->opt_name, array(
			'title' => esc_html__('Header', 'streamit'),
			'id' => 'header-editor',
			'icon' => 'el el-arrow-up',
			'customizer_width' => '500px',
		));

		Redux::set_section($this->opt_name, array(
			'title' => esc_html__('Header Layout', 'streamit'),
			'id' => 'header_variation',
			'subsection' => true,
			'desc' => esc_html__('This section contains options for Menu .', 'streamit'),
			'fields' => array(

				array(
					'id' => 'header_layout',
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
					'id'        	=> 'menu_style',
					'type'      	=> 'select',
					'title' 		=> esc_html__('Header Layout', 'streamit'),
					'subtitle' 		=> esc_html__('Select the layout variation that you want to use for header layout.', 'streamit'),
					'options'		=> (function_exists('iqonic_addons_get_list_layouts')) ? iqonic_addons_get_list_layouts(false, 'header') : '',
					'description'	=> (function_exists('iqonic_addons_get_list_layouts')) ? esc_html__("Create", 'streamit') . " <a target='_blank' href='" . admin_url('edit.php?post_type=iqonic_hf_layout') . "'>" . esc_html__("New Layout", 'streamit') . "</a>" : "",
					'required' 		=> array('header_layout', '=', 'custom'),
				),
				array(
					'id' => 'header_layout_position',
					'type' => 'button_set',
					'title' => esc_html__('Header Layout Position', 'streamit'),
					'options' => array(
						'horizontal' 	=> __('Horizontal', 'streamit'),
						'vertical' 		=> __('Vertical', 'streamit'),
					),
					'default' => 'horizontal',
					'required' 	=> array('header_layout', '=', 'custom'),
				),

				array(
					'id'        =>  'vertical_header_width',
					'type'      =>  'dimensions',
					'units'     =>  array('em', 'px', '%'),
					'height'    =>  false,
					'width'     =>  true,
					'title'     =>  __('Vertical header width', 'streamit'),
					'default'   =>  array(
						'width'   => '300px',
					),
					'required' 	=> array('header_layout_position', '=', 'vertical'),
				),

				array(
					'id'        	=> 'streamit_header_variation',
					'type'      	=> 'image_select',
					'title' 		=> esc_html__('Header Layout', 'streamit'),
					'subtitle' 		=> esc_html__('Select the layout variation that you want to use for header layout.', 'streamit'),
					'options' => array(
						'1'      => array(
							'alt' => 'Style1',
							'img' => get_template_directory_uri() . '/assets/images/redux/header.png',
						),
					),
					'required' 	=> array('header_layout', '=', 'default'),
					'default' => '1'
				),

				array(
					'id' => 'header_container',
					'type' => 'button_set',
					'title' => esc_html__('Header container', 'streamit'),
					'options' => array(
						'container-fluid' 	=> esc_html__('Full width', 'streamit'),
						'container' 		=> esc_html__('Container', 'streamit'),
					),
					'default' => 'container-fluid',
					'required' 	=> array('header_layout', '=', 'default'),
				),
				array(
					'id' => 'header_postion',
					'type' => 'button_set',
					'title' => esc_html__('Header Position', 'streamit'),
					'options' => array(
						'default' => esc_html__('Default', 'streamit'),
						'under' => esc_html__('Under', 'streamit'),
						'over' => esc_html__('Over', 'streamit'),
					),
					'default' => 'default',
				),

				// --------main header background options start----------//

				array(
					'id'	 	=> 'streamit_header_background_type',
					'type' 		=> 'button_set',
					'title' 	=> esc_html__('Background', 'streamit'),
					'subtitle' 	=> esc_html__('Select the variation for header background', 'streamit'),
					'options' 	=> array(
						'default' 		=> esc_html__('Default', 'streamit'),
						'color' 		=> esc_html__('Color', 'streamit'),
						'image' 		=> esc_html__('Image', 'streamit'),
						'transparent' 	=> esc_html__('Transparent', 'streamit')
					),
					'default' 	=> esc_html__('default', 'streamit'),
					'required' 	=> array('header_layout', '=', 'default'),
				),

				array(
					'id' 		=> 'streamit_header_background_color',
					'type' 		=> 'color',
					'desc' 		=> esc_html__('Set Background Color', 'streamit'),
					'required' 	=> array(array('streamit_header_background_type', '=', 'color'), array('header_layout', '=', 'default')),
					'mode' 		=> 'background',
					'transparent' => false
				),

				array(
					'id' 		=> 'streamit_header_background_image',
					'type' 		=> 'media',
					'url' 		=> false,
					'desc' 		=> esc_html__('Upload Image', 'streamit'),
					'required' 	=> array('streamit_header_background_type', '=', 'image'),
					'read-only' => false,
					'subtitle' 	=> esc_html__('Upload background image for header.', 'streamit'),
				),

				// --------main header Background options end----------//

				// --------main header Menu options start----------//
				array(
					'id'        => 'header_menu_color_type',
					'type'      => 'button_set',
					'title'     => esc_html__('Menu Color Options', 'streamit'),
					'subtitle' => esc_html__('Select Menu color .', 'streamit'),
					'options'   => array(
						'default' => esc_html__('Default', 'streamit'),
						'custom' => esc_html__('Custom', 'streamit'),
					),
					'required' 	=> array(array('header_layout', '=', 'default'), array('header_layout', '=', 'default')),
					'default'   => esc_html__('default', 'streamit')
				),
				array(
					'id'            => 'streamit_header_menu_color',
					'type'          => 'color',
					'required'  => array('header_menu_color_type', '=', 'custom'),
					'desc'     => esc_html__('Menu Color', 'streamit'),
					'mode'          => 'background',
					'transparent'   => false
				),

				array(
					'id'            => 'streamit_header_menu_active_color',
					'type'          => 'color',
					'required'  => array('header_menu_color_type', '=', 'custom'),
					'desc'     => esc_html__('Active Menu Color', 'streamit'),
					'mode'          => 'background',
					'transparent'   => false
				),

				array(
					'id'            => 'streamit_header_menu_hover_color',
					'type'          => 'color',
					'required'  => array('header_menu_color_type', '=', 'custom'),
					'desc'     => esc_html__('Menu Hover Color', 'streamit'),
					'mode'          => 'background',
					'transparent'   => false
				),


				//----sub menu options start---//
				array(
					'id'        => 'header_submenu_color_type',
					'type'      => 'button_set',
					'title'     => esc_html__('Submenu Color Options', 'streamit'),
					'subtitle' => esc_html__('Select submenu color.', 'streamit'),
					'options'   => array(
						'default' => esc_html__('Default', 'streamit'),
						'custom' => esc_html__('Custom', 'streamit'),
					),
					'required' 	=> array('header_layout', '=', 'default'),
					'default'   => esc_html__('default', 'streamit')
				),

				array(
					'id'            => 'streamit_header_submenu_color',
					'type'          => 'color',
					'desc'     => esc_html__('Submenu Color', 'streamit'),
					'required'  => array('header_submenu_color_type', '=', 'custom'),
					'mode'          => 'background',
					'transparent'   => false
				),

				array(
					'id'            => 'streamit_header_submenu_active_color',
					'type'          => 'color',
					'desc'     => esc_html__('Active Submenu Color', 'streamit'),
					'required'  => array('header_submenu_color_type', '=', 'custom'),
					'mode'          => 'background',
					'transparent'   => false
				),

				array(
					'id'            => 'streamit_header_submenu_hover_color',
					'type'          => 'color',
					'desc'     => esc_html__('Submenu Hover Color', 'streamit'),
					'required'  => array('header_submenu_color_type', '=', 'custom'),
					'mode'          => 'background',
					'transparent'   => false
				),

				array(
					'id'            => 'streamit_header_submenu_background_color',
					'type'          => 'color',
					'desc'     => esc_html__('Submenu Background Color', 'streamit'),
					'required'  => array(
						array('header_submenu_color_type', '=', 'custom'),
					),
					'mode'          => 'background',
					'transparent'   => false
				),

				array(
					'id'            => 'header_submenu_background_active_color',
					'type'          => 'color',
					'desc'     => esc_html__('Submenu Background Active Color', 'streamit'),
					'required'  => array(
						array('header_submenu_color_type', '=', 'custom'),
					),
					'mode'          => 'background',
					'transparent'   => false
				),

				array(
					'id'            => 'header_submenu_background_hover_color',
					'type'          => 'color',
					'desc'     => esc_html__('Submenu Background Hover Color', 'streamit'),
					'required'  => array(
						array('header_submenu_color_type', '=', 'custom'),
					),
					'mode'          => 'background',
					'transparent'   => false
				),
				//----sub menu options end----//



				// --------main header Menu options end----------//

				// --------main header responsive Menu Button Options start----------//
				array(
					'id'        => 'responsive_menu_button_type',
					'type'      => 'button_set',
					'title'     => esc_html__('Responsive Menu Color', 'streamit'),
					'subtitle' => esc_html__('Select menu color for responsive mode.', 'streamit'),
					'options'   => array(
						'default' => esc_html__('Default', 'streamit'),
						'custom' => esc_html__('Custom', 'streamit')
					),
					'required' 	=> array('header_layout', '=', 'default'),
					'default'   => esc_html__('default', 'streamit')
				),

				array(
					'id'            => 'responsive_menu_button_color',
					'type'          => 'color',
					'desc'     => esc_html__('Toggle button color', 'streamit'),
					'required'  => array('responsive_menu_button_type', '=', 'custom'),
					'mode'          => 'background',
					'transparent'   => false
				),

				array(
					'id'            => 'responsive_menu_button_background_color',
					'type'          => 'color',
					'desc'     => esc_html__('Toggle button background color', 'streamit'),
					'required'  => array('responsive_menu_button_type', '=', 'custom'),
					'mode'          => 'background',
					'transparent'   => false
				),

				array(
					'id'            => 'responsive_menu_color',
					'type'          => 'color',
					'desc'     => esc_html__('Responsive menu color', 'streamit'),
					'required'  => array('responsive_menu_button_type', '=', 'custom'),
					'mode'          => 'background',
					'transparent'   => false
				),

				array(
					'id'            => 'responsive_menu_hover_color',
					'type'          => 'color',
					'desc'     => esc_html__('Responsive menu hover color', 'streamit'),
					'required'  => array('responsive_menu_button_type', '=', 'custom'),
					'mode'          => 'background',
					'transparent'   => false
				),

				array(
					'id'            => 'responsive_menu_background_color',
					'type'          => 'color',
					'desc'     => esc_html__('Responsive menu background color', 'streamit'),
					'required'  => array('responsive_menu_button_type', '=', 'custom'),
					'mode'          => 'background',
					'transparent'   => false
				),

				array(
					'id'            => 'responsive_menu_active_background_color',
					'type'          => 'color',
					'desc'     => esc_html__('Responsive menu active background color', 'streamit'),
					'required'  => array('responsive_menu_button_type', '=', 'custom'),
					'mode'          => 'background',
					'transparent'   => false
				),
				// --------main header responsive Menu Button Options end----------//
				// --------main header Search Options start----------//
				array(
					'id' 		=> 'display_search_icon_header',
					'type' 		=> 'button_set',
					'title' 	=> esc_html__('Display Search Icon', 'streamit'),
					'desc' 		=> esc_html__('Turn on to display the Search in header.', 'streamit'),
					'options' 	=> array(
						'yes' 		=> esc_html__('On', 'streamit'),
						'no' 		=> esc_html__('Off', 'streamit')
					),
					'required' 	=> array('header_layout', '=', 'default'),
					'default'	=> esc_html__('yes', 'streamit')
				),
				// --------main header Search Options end----------//
				// --------main header user Icon Options start----------//
				array(
					'id'        => 'display_user_icon_header',
					'type'      => 'button_set',
					'title'     => esc_html__('Display User Icon', 'streamit'),
					'options'   => array(
						'yes' => esc_html__('Yes', 'streamit'),
						'no' => esc_html__('No', 'streamit')
					),
					'required' 	=> array('header_layout', '=', 'default'),
					'default'   => esc_html__('yes', 'streamit')
				),

					// --------main header cart Options----------//
					array(
						'id'        => 'display_header_cart_button',
						'type'      => 'button_set',
						'title'     => esc_html__('Display Cart Icon', 'streamit'),
						'subtitle' => esc_html__('Turn on to Show Cart On Default Header', 'streamit'),
						'options'   => array(
							'yes' => esc_html__('Yes', 'streamit'),
							'no' => esc_html__('No', 'streamit')
						),
						'required' 	=> array('header_layout', '=', 'default'),
						'default'   => esc_html__('no', 'streamit')
					),
				
	
			)
		));

		Redux::set_section($this->opt_name, array(
			'title' => esc_html__('Header Top', 'streamit'),
			'id'    => 'Header_Contact',
			'subsection' => true,
			'fields'  => array(
				array(
					'id'    => 'info_custom_header_top',
					'type'  => 'info',
					'required' 	=> array('header_layout', '=', 'custom'),
					'title' => __('Note:', 'streamit'),
					'style' => 'warning',
					'desc'  => __('This options only works with Default Header Layout', 'streamit')
				),

				array(
					'id'        => 'email_and_button',
					'type'      => 'button_set',
					'title'     => esc_html__('Display Header Top', 'streamit'),
					'subtitle' => esc_html__('Turn on to display top header Email, Phone, Social Media.', 'streamit'),
					'options'   => array(
						'yes' => esc_html__('On', 'streamit'),
						'no' => esc_html__('Off', 'streamit')
					),
					'required' 	=> array('header_layout', '=', 'default'),
					'default'   => esc_html__('no', 'streamit')
				),
				// --------header top background options start----------//
				array(
					'id'        => 'header_top_background_type',
					'type'      => 'button_set',
					'title'     => esc_html__('Background', 'streamit'),
					'required'  => array('email_and_button', '=', 'yes'),
					'options'   => array(
						'default' => esc_html__('Default', 'streamit'),
						'color' => esc_html__('Color', 'streamit'),
						'image' => esc_html__('Image', 'streamit'),
						'transparent' => esc_html__('Transparent', 'streamit')
					),
					'default'   => esc_html__('default', 'streamit')
				),

				array(
					'id'            => 'header_top_background_color',
					'type'          => 'color',
					'desc'     => esc_html__('Set Background Color', 'streamit'),
					'required'  => array('header_top_background_type', '=', 'color'),
					'mode'          => 'background',
					'transparent'   => false
				),

				array(
					'id'       => 'header_top_background_image',
					'type'     => 'media',
					'url'      => false,
					'desc'     => esc_html__('Upload Image', 'streamit'),
					'required'  => array('header_top_background_type', '=', 'image'),
					'read-only' => false,
					//'default'  => array( 'url' => get_template_directory_uri() .'/assets/images/logo.png' ),
					'subtitle' => esc_html__('Upload background image for top header.', 'streamit'),
				),

				// --------header top background options end----------//
				// --------header top Text color options start----------//
				array(
					'id'        => 'header_top_text_color_type',
					'type'      => 'button_set',
					'required'  => array('email_and_button', '=', 'yes'),
					'title'     => esc_html__('Text / Icon color options', 'streamit'),
					'subtitle' => esc_html__('Select text / icon color for normal and hover .', 'streamit'),
					'options'   => array(
						'default' => esc_html__('Default', 'streamit'),
						'custom' => esc_html__('Custom', 'streamit'),
					),
					'default'   => esc_html__('default', 'streamit')
				),
				array(
					'id'            => 'header_top_text_color',
					'type'          => 'color',
					'desc'      => esc_html__('Choose text color for top header.', 'streamit'),
					'required'  => array('header_top_text_color_type', '=', 'custom'),
					'mode'          => 'background',
					'transparent'   => false
				),

				array(
					'id'            => 'header_top_text_hover_color',
					'type'          => 'color',
					'desc'      => esc_html__('Choose text hover color for top header.', 'streamit'),
					'required'  => array('header_top_text_color_type', '=', 'custom'),
					'mode'          => 'background',
					'transparent'   => false
				),

				array(
					'id'            => 'header_top_icon_color',
					'type'          => 'color',
					'desc'      => esc_html__('Choose Icon color for top header.', 'streamit'),
					'required'  => array('header_top_text_color_type', '=', 'custom'),
					'mode'          => 'background',
					'transparent'   => false
				),

				array(
					'id'            => 'header_top_icon_hover_color',
					'type'          => 'color',
					'desc'      => esc_html__('Choose Icon hover color for top header.', 'streamit'),
					'required'  => array('header_top_text_color_type', '=', 'custom'),
					'mode'          => 'background',
					'transparent'   => false
				),
				// --------header top Text color options end----------//
				array(
					'id'       => 'header_phone',
					'type'     => 'text',
					'title'    => esc_html__('Phone', 'streamit'),
					'required'  => array('email_and_button', '=', 'yes'),
					'preg' => array(
						'pattern' => '/[^0-9_ -+()]/s',
						'replacement' => ''
					),
					'default'  => esc_html__('+0123456789', 'streamit'),
				),

				array(
					'id'       => 'header_email',
					'type'     => 'text',
					'title'    => esc_html__('Email', 'streamit'),
					'required'  => array('email_and_button', '=', 'yes'),
					'validate' => 'email',
					'msg'      => esc_html__('custom error message', 'streamit'),
					'default'  => esc_html__('support@example.com', 'streamit'),
				),

				array(
					'id'        => 'header_display_contact',
					'type'      => 'button_set',
					'title'     => esc_html__('Email/Phone on Header', 'streamit'),
					'required'  => array('email_and_button', '=', 'yes'),
					'subtitle' => esc_html__('Turn on to display the Email and Phone number in header menu.', 'streamit'),
					'options'   => array(
						'yes' => esc_html__('On', 'streamit'),
						'no' => esc_html__('Off', 'streamit')
					),
					'default'   => esc_html__('yes', 'streamit')
				),

				array(
					'id'        => 'streamit_header_social_media',
					'type'      => 'button_set',
					'title'     => esc_html__('Social Media', 'streamit'),
					'subtitle' => esc_html__('Turn on to display Social Media in top header.', 'streamit'),
					'required'  => array('email_and_button', '=', 'yes'),
					'options'   => array(
						'yes' => esc_html__('Yes', 'streamit'),
						'no' => esc_html__('No', 'streamit')
					),
					'default'   => esc_html__('yes', 'streamit')
				),


			)

		));

		//-----Sticky Header Options Start---//
		Redux::set_section($this->opt_name, array(
			'title' => esc_html__('Sticky Header', 'streamit'),
			'id' => 'sticky-header-variation',
			'subsection' => true,
			'desc' => esc_html__('This section contains options for sticky header menu and background color.', 'streamit'),
			'fields' => array(
				array(
					'id'    => 'info_custom_header_top_2s',
					'type'  => 'info',
					'required' 	=> array('header_layout', '=', 'custom'),
					'title' => __('Note:', 'streamit'),
					'style' => 'warning',
					'desc'  => __('This options only works with Default Header Layout', 'streamit')
				),
				array(
					'id' => 'sticky_header_display',
					'type' => 'button_set',
					'title' => esc_html__('Sticky Header', 'streamit'),
					'subtitle' => esc_html__('Enable to make header sticky.', 'streamit'),
					'required' 	=> array('header_layout', '=', 'default'),
					'options' => array(
						'yes' => esc_html__('Enable', 'streamit'),
						'no' => esc_html__('Disable', 'streamit')
					),
					'default' => esc_html__('yes', 'streamit')
				),
				// --------sticky header background options start----------//
				array(
					'id' => 'sticky_header_background_type',
					'type' => 'button_set',
					'title' => esc_html__('Background', 'streamit'),
					'subtitle' => esc_html__('Select the variation for sticky header background', 'streamit'),
					'options' => array(
						'default' => esc_html__('Default', 'streamit'),
						'color' => esc_html__('Color', 'streamit'),
						'image' => esc_html__('Image', 'streamit'),
						'transparent' => esc_html__('Transparent', 'streamit')
					),
					'default' => esc_html__('default', 'streamit'),
					'required' 	=> array( array('header_layout', '=', 'default'),array('sticky_header_display', '=', 'yes')),
				),

				array(
					'id' => 'sticky_header_background_color',
					'type' => 'color',
					'desc' => esc_html__('Set Background Color', 'streamit'),
					'required' => array('sticky_header_background_type', '=', 'color'),
					'mode' => 'background',
					'transparent' => false
				),

				array(
					'id' => 'sticky_header_background_image',
					'type' => 'media',
					'url' => false,
					'desc' => esc_html__('Upload Image', 'streamit'),
					'required' => array('sticky_header_background_type', '=', 'image'),
					'read-only' => false,
					'subtitle' => esc_html__('Upload background image for sticky header.', 'streamit'),
				),
				// --------sticky header Background options end----------//
				// --------sticky header Menu options start----------//

				array(
					'id'        => 'sticky_menu_color_type',
					'type'      => 'button_set',
					'required'  => array('sticky_header_display', '=', 'yes'),
					'title'     => esc_html__('Menu Color Options', 'streamit'),
					'subtitle' => esc_html__('Select Menu color for sticky.', 'streamit'),
					'options'   => array(
						'default' => esc_html__('Default', 'streamit'),
						'custom' => esc_html__('Custom', 'streamit'),
					),
					'default'   => esc_html__('default', 'streamit')
				),
				array(
					'id'            => 'sticky_menu_color',
					'type'          => 'color',
					'required'  => array('sticky_menu_color_type', '=', 'custom'),
					'desc'     => esc_html__('Menu color', 'streamit'),
					'mode'          => 'background',
					'transparent'   => false
				),

				array(
					'id'            => 'sticky_menu_active_color',
					'type'          => 'color',
					'required'  => array('sticky_menu_color_type', '=', 'custom'),
					'desc'     => esc_html__('Sticky header active menu color', 'streamit'),
					'mode'          => 'background',
					'transparent'   => false
				),

				array(
					'id'            => 'sticky_menu_hover_color',
					'type'          => 'color',
					'required'  => array('sticky_menu_color_type', '=', 'custom'),
					'desc'     => esc_html__('Menu hover color', 'streamit'),
					'mode'          => 'background',
					'transparent'   => false
				),

				//----sticky sub menu options start---//
				array(
					'id'        => 'sticky_header_submenu_color_type',
					'type'      => 'button_set',
					'title'     => esc_html__('Submenu Color Options', 'streamit'),
					'subtitle' => esc_html__('Select submenu color for sticky.', 'streamit'),
					'required'  => array('sticky_header_display', '=', 'yes'),
					'options'   => array(
						'default' => esc_html__('Default', 'streamit'),
						'custom' => esc_html__('Custom', 'streamit'),
					),
					'default'   => esc_html__('default', 'streamit')
				),

				array(
					'id'            => 'sticky_streamit_header_submenu_color',
					'type'          => 'color',
					'desc'     => esc_html__('Submenu Color', 'streamit'),
					'required'  => array('sticky_header_submenu_color_type', '=', 'custom'),
					'mode'          => 'background',
					'transparent'   => false
				),

				array(
					'id'            => 'sticky_streamit_header_submenu_active_color',
					'type'          => 'color',
					'desc'     => esc_html__('Active Submenu Color', 'streamit'),
					'required'  => array('sticky_header_submenu_color_type', '=', 'custom'),
					'mode'          => 'background',
					'transparent'   => false
				),

				array(
					'id'            => 'sticky_streamit_header_submenu_hover_color',
					'type'          => 'color',
					'desc'     => esc_html__('Submenu Hover Color', 'streamit'),
					'required'  => array('sticky_header_submenu_color_type', '=', 'custom'),
					'mode'          => 'background',
					'transparent'   => false
				),

				array(
					'id'            => 'sticky_streamit_header_submenu_background_color',
					'type'          => 'color',
					'desc'     => esc_html__('Submenu Background Color', 'streamit'),
					'required'  => array('sticky_header_submenu_color_type', '=', 'custom'),
					'mode'          => 'background',
					'transparent'   => false
				),
				array(
					'id'            => 'sticky_header_submenu_background_active_color',
					'type'          => 'color',
					'desc'     => esc_html__('Submenu Background Active Color', 'streamit'),
					'required'  => array('sticky_header_submenu_color_type', '=', 'custom'),
					'mode'          => 'background',
					'transparent'   => false
				),
				array(
					'id'            => 'sticky_header_submenu_background_hover_color',
					'type'          => 'color',
					'desc'     => esc_html__('Submenu Background Hover Color', 'streamit'),
					'required'  => array('sticky_header_submenu_color_type', '=', 'custom'),
					'mode'          => 'background',
					'transparent'   => false
				),
			
				// --------sticky header Menu options start----------//
			)
		));
	}
}
