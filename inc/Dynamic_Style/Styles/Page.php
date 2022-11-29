<?php

/**
 * Streamit\Utility\Dynamic_Style\Styles\Page class
 *
 * @package streamit
 */

namespace Streamit\Utility\Dynamic_Style\Styles;

use Streamit\Utility\Dynamic_Style\Component;
use function add_action;

class Page extends Component
{
	public function __construct()
	{
        add_action('wp_enqueue_scripts',array($this ,'streamit_big_heading_texture_button'),  20);
	}   
    public function streamit_big_heading_texture_button()
    {
        global $streamit_options;
        $big_heading_bg_type = isset($streamit_options['streamit_big_heading_title_bg_type'])? $streamit_options['streamit_big_heading_title_bg_type']:'';
        $big_heading_color = isset($streamit_options['streamit_big_heading_title_bg_color'])? $streamit_options['streamit_big_heading_title_bg_color']:'';
        $big_heading_image = isset($streamit_options['streamit_big_heading_title_banner_image']['url'])? $streamit_options['streamit_big_heading_title_banner_image']['url']:'';
        $streamit_big_heading_title = "";
    
        if ($big_heading_bg_type == '1') {
            $streamit_big_heading_title .= "
                .big-title {
                    color: $big_heading_color;
                    -webkit-text-fill-color: unset;
                    -moz-text-fill-color: unset;
                    text-fill-color: unset;
                }";
        } else {
            $streamit_big_heading_title .= "
            .big-title {
                background: url($big_heading_image);
                -webkit-background-clip: text;
                -moz-background-clip: text;
                 background-clip: text;
            }";
        }
        wp_add_inline_style('streamit-style', $streamit_big_heading_title);

    }

}
