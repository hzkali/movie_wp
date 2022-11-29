<?php

/**
 * Template part for displaying the Cast 
 *
 * @package streamit
 */

namespace Streamit\Utility;


if (!defined('ABSPATH')) {
    exit;
}
extract($args);
if (empty($tabs) || !is_array($tabs)) {
    return;
}

$default_active_tab = empty($default_active_tab) ? 0 : $default_active_tab;
$tab_uniqid = 'tab-' . uniqid();
$class = empty($class) ? 'streamit_cast_crew' : 'streamit_cast_crew ' . $class;

uasort($tabs, function ($a, $b) {
    if (!isset($a['priority'], $b['priority']) || $a['priority'] === $b['priority']) {
        return 0;
    }
    return ($a['priority'] < $b['priority']) ? -1 : 1;
});

?>
<div class="<?php echo esc_attr($class); ?>">
    <ul class="trending-pills d-flex nav nav-pills align-items-center text-center mb-4 ml-0">
        <?php foreach ($tabs as $key => $tab) :
            if (!is_numeric($key) && !$default_active_tab) {
                $default_active_tab = $key;
            }
            $tab_id = $tab_uniqid . $key; ?>
            <li class="nav-item">
                <a href="#<?php echo esc_attr($tab_id); ?>" data-toggle="tab" class="nav-link ml-0 <?php if ($key == $default_active_tab) echo esc_attr(' active show'); ?>">
                    <?php echo wp_kses_post($tab['title']); ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
    <div class="tab-content">
        <?php foreach ($tabs as $key => $tab) :
            $tab_id = $tab_uniqid . $key; ?>
            <div id="<?php echo esc_attr($tab_id); ?>" class="tab-pane animated fadeInUp <?php if ($key == $default_active_tab) echo esc_attr(' active show'); ?>">
                <?php
                if (isset($tab['callback'])) {
                    call_user_func($tab['callback'], $key, $tab);
                } elseif (!empty($tab['content'])) {
                    echo wp_kses_post($tab['content']);
                }
                ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>