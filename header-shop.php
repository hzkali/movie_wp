<?php

/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package streamit
 */

namespace Streamit\Utility;

use Elementor\Plugin;
?>
<!doctype html>
<html <?php language_attributes(); ?> class="no-js">

<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
  <?php global $streamit_options; ?>
  <link rel="profile" href="<?php echo is_ssl() ? 'https:' : 'http:' ?>//gmpg.org/xfn/11">
  <?php
  global $template;

  $c_url = explode('/', $template);
  $c_page = end($c_url);
  $class_hide = '';
  if (isset($streamit_options['email_and_button']) && $streamit_options['email_and_button'] == 'yes') {
    $class_hide .= "iq-header-top ";
  }
  if ($c_page === 'single-movie.php' || $c_page === 'single-episode.php' || $c_page === 'single-video.php' || $c_page === 'single-person.php') {
    $class_hide .= 'iq-hide-header ';
  }
  if (isset($streamit_options['opt-container-width']) && !empty($streamit_options['opt-container-width'])) {
    // .iq-container-width
    $class_hide .= 'iq-container-width';
  }
  if (!function_exists('has_site_icon') || !wp_site_icon()) {
    if (!empty($streamit_options['streamit_fevicon'])) {
  ?>
      <link rel="shortcut icon" href="<?php echo esc_url($streamit_options['streamit_fevicon']['url']); ?>" />
  <?php }
  }
  ?>
  <?php wp_head(); ?>
</head>

<body <?php body_class($class_hide); ?>>
  <?php wp_body_open(); ?>

  <!-- loading -->
  <?php
  $bgurl = '';
  $site_classes = '';
  $has_sticky = '';
  $default_header_container = '';
  if (class_exists('ReduxFramework')) {
    //theme site class
    $site_classes .= 'streamit';
    //loader
    if (isset($streamit_options['streamit_display_loader']) && $streamit_options['streamit_display_loader'] === 'yes') {
      if (!empty($streamit_options['streamit_loader_gif']['url'])) {
        $bgurl = $streamit_options['streamit_loader_gif']['url'];
      }
    }
    //sticky header
    if (isset($streamit_options['sticky_header_display']) && $streamit_options['sticky_header_display'] == 'yes') {
      $has_sticky = ' has-sticky';
    }
    // container
    if (isset($streamit_options['header_container'])) {
      $default_header_container = ($streamit_options['header_container'] == 'container') ? 'container' : 'container-fluid';
    }
  } else {
    //default
    $bgurl = get_template_directory_uri() . '/assets/images/redux/loader.gif';
    $has_sticky = ' has-sticky';
    $default_header_container = 'container-fluid';
  }
  ?>
  <?php if (!empty($bgurl)) { ?>
    <div id="loading">
      <div id="loading-center">
        <img src="<?php echo esc_url($bgurl); ?>" alt="<?php esc_attr_e('loader', 'streamit'); ?>">
      </div>
    </div>
  <?php } ?>
  <!-- loading End -->
  <?php

  $is_default_header = true;
  $header_response = '';
  if (class_exists('ReduxFramework') && class_exists('\\Iqonic_Layouts\\Classes\\Iqonic_Layouts_Extension')) {
    if (isset($streamit_options['woo_header_layout']) && $streamit_options['woo_header_layout'] == 'custom') {

      if (!empty($streamit_options['woo_menu_style'])) {
        $is_default_header = false;
        $header = $streamit_options['woo_menu_style'];
        $has_sticky = '';
        $my_layout = get_page_by_path($header, '', 'iqonic_hf_layout');
        if ($my_layout) {
          $header_response =  Plugin::instance()->frontend->get_builder_content_for_display($my_layout->ID);
        }
      }
    }

    // ---------------header end

    if (isset($streamit_options['woo_header_layout_position']) && $streamit_options['woo_header_layout_position'] == 'vertical') {
      $site_classes .= ' vertical-header';
    }

    if (!strpos($site_classes, 'vertical-header')) {
      if (isset($streamit_options['woo_header_postion']) && $streamit_options['woo_header_postion'] == 'over') {
        $site_classes .= ' header-over';
      }
    } else {
      add_filter('content_container_class', function ($container) {
        $container = 'container-fluid';
        return $container;
      });
    }
  }
  ?>

  <div id="page" class="site <?php echo esc_attr(trim($site_classes)); ?>">
    <a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e('Skip to content', 'streamit'); ?></a>
    <?php
    if (!$is_default_header && !empty($header_response)) {
    ?>
      <header class="header-default iq-layout-header " id="default-header">
        <?php echo function_exists('iqonic_return_elementor_res') ? iqonic_return_elementor_res($header_response) : $header_response; ?>
      </header>
    <?php

    } else {

    ?>
      <header class="iq-ltr-direction style-one<?php echo esc_attr($has_sticky); ?>" id="main-header">
        <?php
        if (isset($streamit_options['email_and_button'])) {
          $options = $streamit_options['email_and_button'];
          if ($options == "yes") {
        ?>
            <div class="<?php echo esc_attr($default_header_container); ?> sub-header">
              <div class="row align-items-center">
                <div class="col-auto">
                  <?php
                  if (!empty($streamit_options['header_display_contact'])) {
                    $options = $streamit_options['header_display_contact'];
                    if ($options == "yes") {
                  ?>
                      <div class="number-info">
                        <ul class="list-inline">
                          <?php
                          if (!empty($streamit_options['header_email'])) {
                          ?>
                            <li class="list-inline-item"><a href="mailto:<?php echo esc_html($streamit_options['header_email']); ?>">
                                <i class="fas fa-envelope"></i><?php echo esc_html($streamit_options['header_email']); ?></a></li>
                          <?php } ?>
                          <?php if (!empty($streamit_options['header_phone'])) {
                          ?>
                            <li class="list-inline-item"><a href="tel:<?php echo str_replace(str_split('(),-" '), '', $streamit_options['header_phone']); ?>">
                                <i class="fas fa-phone"></i><?php echo esc_html($streamit_options['header_phone']); ?></a></li>
                          <?php } ?>
                        </ul>
                      </div>

                  <?php
                    }
                  }
                  ?>
                </div>
                <div class="col-auto col-auto ml-auto sub-main">
                  <?php

                  global $streamit_options;

                  if (isset($streamit_options['streamit_header_social_media'])) {
                    $options = $streamit_options['streamit_header_social_media'];
                    if ($options == "yes") { ?>
                      <div class="social-icone">
                        <?php $data = $streamit_options['social-media-iq']; ?>

                        <ul class="list-inline">
                          <?php
                          foreach ($data as $key => $options) {
                            if ($options) {
                              echo '<li class="d-inline"><a href="' . $options . '"><i class="fab fa-' . $key . '"></i></a></li>';
                            }
                          } ?>
                        </ul>
                      </div>
                  <?php
                    }
                  }
                  ?>
                </div>
              </div>
            </div>
        <?php
          }
        }
        ?>
        <div class="<?php echo esc_attr($default_header_container); ?>">
          <div class="row align-items-center">
            <div class="col-md-12">
              <?php
              get_template_part('template-parts/header/navigation');
              ?>
            </div>
          </div>
        </div>
      </header><!-- #masthead -->
    <?php
    }
    wp_reset_postdata();

    ?>
    <?php if ($is_default_header) : ?>
      <div class="streamit-mobile-menu menu-style-one default-menu">
        <?php get_template_part('template-parts/header/navigation', 'mobile'); ?>
      </div>
    <?php endif; ?>
    <div class="site-content-contain">
      <div id="content" class="site-content">
        <?php
        get_template_part('template-parts/breadcrumb/breadcrumb'); ?>