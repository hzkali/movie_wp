<?php

namespace Streamit\Utility\Dynamic_Style\Styles;

use Streamit\Utility\Dynamic_Style\Component;
use function add_action;

class HeaderTop extends Component
{
    public function __construct()
    {
        add_action('wp_enqueue_scripts', array($this,'streamit_header_top_background_style'));
        add_action('wp_enqueue_scripts', array($this,'streamit_top_text_color_options'));
    }

    public function streamit_header_top_background_style()
    {
        global $streamit_options;
        $dynamic_css = array();
        if (isset($streamit_options['header_top_background_type']) && $streamit_options['header_top_background_type'] != 'default') {
            $type = $streamit_options['header_top_background_type'];
            if ($type == 'color') {
                if (!empty($streamit_options['header_top_background_color'])) {
                    $dynamic_css[] = array(
                        'elements'  =>  'header .sub-header',
                        'property'  =>  'background',
                        'value'     =>  '' . $streamit_options['header_top_background_color'] . ' !important'
                    );
                }
            }
            if ($type == 'image') {
                if (!empty($streamit_options['header_top_background_image']['url'])) {
                    $dynamic_css[] = array(
                        'elements'  =>  'header .sub-header',
                        'property'  =>  'background',
                        'value'     =>  'url(' . $streamit_options['header_top_background_image']['url'] . ') !important'
                    );
                }
            }
            if ($type == 'transparent') {

                $dynamic_css[] = array(
                    'elements'  =>  'header .sub-header',
                    'property'  =>  'background',
                    'value'     =>  'transparent !important'
                );
            }
        }
        if (count($dynamic_css) > 0) {
            wp_add_inline_style('streamit-style',$this->streamit_dynamic_style($dynamic_css));
        }
    }
    public function streamit_top_text_color_options()
    {
        global $streamit_options;

        $inline_css = '';
        if (isset($streamit_options['header_top_text_color_type']) && $streamit_options['header_top_text_color_type'] == 'custom') {
            if (isset($streamit_options['header_top_text_color']) && !empty($streamit_options['header_top_text_color'])) {

                $inline_css .= 'header.style-one .sub-header .number-info li a,header .sub-header  li a,header.style-one .sub-header .number-info li a i{
                color : ' . $streamit_options['header_top_text_color'] . '!important;
            }';
            }
            if (isset($streamit_options['header_top_text_hover_color']) && !empty($streamit_options['header_top_text_hover_color'])) {
                $inline_css .= ' header.style-one .sub-header .number-info li:hover a,header .sub-header  li:hover a,header.style-one .sub-header .number-info li:hover a i{
                color : ' . $streamit_options['header_top_text_hover_color'] . '!important;
            }';
            }
            if (isset($streamit_options['header_top_icon_color']) && !empty($streamit_options['header_top_icon_color'])) {
                $inline_css .= 'header.style-one .sub-header :is(.social-icone,.number-info) ul li i{
                color : ' . $streamit_options['header_top_icon_color'] . '!important;
            }';
            }
            if (isset($streamit_options['header_top_icon_hover_color']) && !empty($streamit_options['header_top_icon_hover_color'])) {
                $inline_css .= 'header.style-one .sub-header :is(.social-icone,.number-info) ul li:hover i{
                color : ' . $streamit_options['header_top_icon_hover_color'] . '!important;
            }';
            }
        }

        if (!empty($inline_css)) {
            wp_add_inline_style('streamit-style', $inline_css);
        }
    }
}
