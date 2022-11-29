<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js no-svg">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <?php 
  global $streamit_options; 

  if (!function_exists('has_site_icon') || !wp_site_icon()) {
    if (!empty($streamit_options['streamit_fevicon'])) { ?>
      <link rel="shortcut icon" href="<?php echo esc_url($streamit_options['streamit_fevicon']['url']); ?>" />
  <?php
    }
  }

  ?>
 
  <?php wp_head(); ?>
  <?php
    wp_enqueue_script('maintance-countTo', get_template_directory_uri() . '/assets/js/vendor/maintance/js/jquery.countTo.js', array('jquery'), '1.0', true);
  
    wp_enqueue_script('maintance-countdown', get_template_directory_uri() . '/assets/js/vendor/maintance/js/jquery.countdown.min.js', array('jquery'), '1.0', true);
  
    wp_enqueue_script('maintance-custom', get_template_directory_uri() . '/assets/js/vendor/maintance/js/maintance-custom.js', array(), '1.0', true);
  
  
    /* Custom CSS */
  
    wp_enqueue_style('maintance-style', get_template_directory_uri() . '/assets/css/vendor/maintance/main-style.css', array(), '1.0', 'all');
  
    wp_enqueue_style('maintance-responsive', get_template_directory_uri() . '/assets/css/vendor/maintance/main-responsive.css', array(), '1.0', 'all');
  
    wp_enqueue_style('maintance-countdown', get_template_directory_uri() . '/assets/css/vendor/maintance/jquery.countdown.css', array(), '1.0', 'all');

    
  ?>
</head>

<body data-spy="scroll" data-offset="80">

  <div id="page" class="site">
    <a class="skip-link screen-reader-text" href="#content"><?php esc_html__('Skip to content', 'streamit'); ?></a>

    <div class="site-content-contain">
      <div id="content" class="site-content">