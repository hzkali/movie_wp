<?php

/**
 * Streamit\Utility\Dynamic_Style\Styles\Logo class
 *
 * @package streamit
 */

namespace Streamit\Utility\Dynamic_Style\Styles;

use Streamit\Utility\Dynamic_Style\Component;
use function add_action;

class Logo extends Component
{

    public function __construct()
    {
        add_action('wp_enqueue_scripts', array($this, 'streamit_logo_options'), 20);
    }

    public function streamit_logo_options()
    {
        global $streamit_options;
        $logo_var = "";
        
        if (isset($streamit_options['header_radio']) && $streamit_options['header_radio'] == 1) {
            if (!empty($streamit_options['header_color'])) {
                $logo = $streamit_options['header_color'];
                $logo_var = ".navbar-light .navbar-brand {
                    color : $logo !important;
                }";
            }
        }

        if (!empty($streamit_options["logo-dimensions"]["width"]) && $streamit_options["logo-dimensions"]["width"] != "px") {
            $logo_width = $streamit_options["logo-dimensions"]["width"];
            $logo_var .= 'header a.navbar-brand img, .vertical-navbar-brand img { width: ' . $logo_width . ' !important; }';
        }

        if (!empty($streamit_options["logo-dimensions"]["height"]) && $streamit_options["logo-dimensions"]["height"] != "px") {
            $logo_height = $streamit_options["logo-dimensions"]["height"];
            $logo_var .= 'header a.navbar-brand img, .vertical-navbar-brand img { height: ' . $logo_height . ' !important; }';
        }


        if (!empty($streamit_options["mobile-logo-dimensions"]["width"]) && $streamit_options["mobile-logo-dimensions"]["width"] != "px") {
            $logo_width = $streamit_options["mobile-logo-dimensions"]["width"];
            $logo_var .= '.streamit-mobile-menu .navbar-brand  .logo { width: ' . $logo_width . ' !important; }';
        }

        if (!empty($streamit_options["mobile-logo-dimensions"]["height"]) && $streamit_options["mobile-logo-dimensions"]["height"] != "px") {
            $logo_height = $streamit_options["mobile-logo-dimensions"]["height"];
            $logo_var .= '.streamit-mobile-menu .navbar-brand  .logo { height: ' . $logo_height . ' !important; }';
        }



        if (!empty($logo_var)) {
            wp_add_inline_style('streamit-style', $logo_var);
        }
    }
}
