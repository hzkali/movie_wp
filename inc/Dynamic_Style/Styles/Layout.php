<?php

/**
 * Streamit\Utility\Dynamic_Style\Styles\Layout class
 *
 * @package streamit
 */

namespace Streamit\Utility\Dynamic_Style\Styles;

use Streamit\Utility\Dynamic_Style\Component;
use function add_action;
use function Streamit\Utility\streamit;

class Layout extends Component
{

    public function __construct()
    {
        $this->streamit_maintenance_mode();
    }
    public function streamit_maintenance_mode()
    {
        global $streamit_options;
        add_filter('body_class', array($this, 'streamit_add_body_classes'));
        if (isset($streamit_options['streamit_enable_sswitcher'])) {
            if ($streamit_options['streamit_enable_sswitcher']) {
                add_action('wp_enqueue_scripts', array($this, 'streamit_style_switcher_styles'), 20);
                add_action('wp_footer', array($this, 'streamit_style_switcher'));
            }
        }
    }

    function streamit_add_body_classes($classes)
    {
        global $streamit_options;

        if (!empty($streamit_options['streamit_layout_mode_options']) && $streamit_options['streamit_layout_mode_options'] == 2) {
            if (isset($_GET['preset'])) {
                if ($_GET['preset'] == '1') {
                    $classes = array_merge($classes, array('rtl'));
                }
            } else {
                $classes = array_merge($classes, array('rtl'));
            }
        } else {
            if (isset($_GET['preset'])  && $_GET['preset'] == '2') {
                $classes = array_merge($classes, array('rtl'));
            }
        }
        return $classes;
    }

    public function streamit_style_switcher_styles()
    {
        wp_enqueue_script('iq-style-switcher-js', get_template_directory_uri() . '/assets/js/vendor/layout/iq-style-switcher.js', array(), streamit()->get_version(), false);

        wp_enqueue_style('iq-style-switcher-css', get_template_directory_uri() . '/assets/css/vendor/layout/iq-style-switcher.css', array(), streamit()->get_version());
    }


    public function streamit_style_switcher()
    {
        global $streamit_options;
        $options = $streamit_options['streamit_layout_mode_options'];  ?>

        <div class="iq-theme-feature hidden-xs hidden-sm hidden-md">
            <div class="iq-switchbuttontoggler"><i class="fas fa-cog"></i></div>
            <div class="spanel">
                <form name="styleswitcher" action="<?php echo esc_url(home_url('/')); ?>" method="post">
                    <div class="presets">
                        <ul id="preset" class="preset">
                            <?php if ($options == 2) { ?>
                                <li class="active"><a class="ltr" id="ltr" href="?preset=2"><?php esc_html_e('LTR', 'streamit'); ?><input name="b" type="radio" value="LTR" hidden></a></li>
                                <li><a class="rtl" href="?preset=1" id="rtl"><?php esc_html_e('RTL', 'streamit'); ?><input name="b" type="radio" value="RTL" hidden></a></li>
                            <?php } else { ?>
                                <li class="active"><a class="ltr" id="ltr" href="?preset=1"><?php esc_html_e('LTR', 'streamit'); ?><input name="b" type="radio" value="1" hidden></a></li>
                                <li><a class="rtl" href="?preset=2" id="rtl"><?php esc_html_e('RTL', 'streamit'); ?><input name="b" type="radio" value="2" hidden></a></li>
                            <?php } ?>
                        </ul>
                    </div>
                </form>
            </div>
        </div>
<?php
    }
}
