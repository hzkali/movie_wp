<?php

/**
 * Streamit\Utility\Redux_Framework\Options\FourZeroFour class
 *
 * @package streamit
 */

namespace Streamit\Utility\Redux_Framework\Options;

use Redux;
use Streamit\Utility\Redux_Framework\Component;

class FourZeroFour extends Component
{

	public function __construct()
	{
		$this->set_widget_option();
	}

	protected function set_widget_option()
	{
		Redux::set_section($this->opt_name, array(
			'title' => esc_html__('404', 'streamit'),
			'id'    => 'fourzerofour-section',
			'icon'  => 'el-icon-error',
			'desc'  => esc_html__('This section contains options for 404.', 'streamit'),
			'fields' => array(
				
				array(
					'id' 		=> 'four_zero_four_layout',
					'type' 		=> 'button_set',
					'title' 	=> esc_html__('Page Layout', 'streamit'),
					'options' 	=> array(
						'default' 	=> esc_html__('Default', 'streamit'),
						'custom' 	=> esc_html__('Custom', 'streamit'),
					),
					'default'	=> 'default'
				),

				array(
					'id'        => '404_layout',
					'type'      => 'select',
					'title' 	=> esc_html__('404 Layout', 'streamit'),
					'subtitle' 	=> esc_html__('Select the layout variation that you want to use for 404 page.', 'streamit'),
					'options'	=> (function_exists('iqonic_addons_get_list_layouts')) ? iqonic_addons_get_list_layouts(false, 'four_zero_four') : '',
					'description'	=> (function_exists('iqonic_addons_get_list_layouts')) ? esc_html__("Create", 'streamit') . " <a target='_blank' href='" . admin_url('edit.php?post_type=iqonic_hf_layout') . "'>" . esc_html__("New Layout", 'streamit') . "</a>" : "",
					'required' 	=> array('four_zero_four_layout', '=', 'custom'),
				),


				array(
					'id'       	=> 'streamit_404_banner_image',
					'type'     	=> 'media',
					'url'      	=> true,
					'title'    	=> esc_html__('404 Page Default Banner Image', 'streamit'),
					'read-only' => false,
					'default'  	=> array('url' => get_template_directory_uri() . '/assets/images/redux/404.png'),
					'subtitle' 	=> esc_html__('Upload banner image for your Website. Otherwise blank field will be displayed in place of this section.', 'streamit'),
					'required' 	=> array('four_zero_four_layout', '=', 'default'),
				),

				array(
					'id'        => 'streamit_fourzerofour_title',
					'type'      => 'text',
					'title'     => esc_html__('404 Page Title', 'streamit'),
					'default'   => esc_html__('Oops! This Page is Not Found.', 'streamit'),
					'required' 	=> array('four_zero_four_layout', '=', 'default'),
				),

				array(
					'id'        => 'streamit_four_description',
					'type'      => 'textarea',
					'title'     => esc_html__('404 Page Description', 'streamit'),
					'default'   => esc_html__('The requested page does not exist.', 'streamit'),
					'required' 	=> array('four_zero_four_layout', '=', 'default'),
				),

				array(
					'id'        => '404_backtohome_title',
					'type'      => 'text',
					'title'     => esc_html__('404 Page Button', 'streamit'),
					'default'   => esc_html__('Back to Home', 'streamit'),
					'required' 	=> array('four_zero_four_layout', '=', 'default'),
				),
				array(
					'id'       	=> 'header_on_404',
					'type'     	=> 'switch',
					'on'		=> esc_html__('Enable', 'streamit'),
					'off'		=> esc_html__('Disable', 'streamit'),
					'title'    	=> esc_html__('Header', 'streamit'),
					'subtitle' 	=> esc_html__('Enable / disable header on 404 page', 'streamit'),
					'default'  	=> true,
				),

				array(
					'id'       	=> 'footer_on_404',
					'type'     	=> 'switch',
					'on'		=> esc_html__('Enable', 'streamit'),
					'off'		=> esc_html__('Disable', 'streamit'),
					'title'    	=> esc_html__('Footer', 'streamit'),
					'subtitle' 	=> esc_html__('Enable / disable footer on 404 page', 'streamit'),
					'default'  	=> false,
				)
			)
		));
	}
}
