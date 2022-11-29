<?php

/**
 * Template part for displaying the header navigation menu
 *
 * @package streamit
 */

namespace Streamit\Utility;

global $streamit_options;
?>

<nav id="site-navigation" class="navbar navbar-expand-lg navbar-light p-0" aria-label="<?php esc_attr_e('Main menu', 'streamit'); ?>" <?php
																																	if (streamit()->is_amp()) {
																																	?> [class]=" siteNavigationMenu.expanded ? 'main-navigation nav--toggle-sub nav--toggle-small nav--toggled-on' : 'main-navigation nav--toggle-sub nav--toggle-small' " <?php
																																																																														}
																																																																															?>>

	<a class="navbar-brand" href="<?php echo esc_url(home_url('/')); ?>">
		<?php
		if (function_exists('get_field') || class_exists('ReduxFramework')) {
			$is_yes = function_exists('get_field')?get_field('acf_key_header_switch'):false  ;
			$acf_logo = function_exists('get_field')?get_field('header_logo'):''  ;

			if ($is_yes === 'yes' && !empty($acf_logo['url'])) {
				$options = $acf_logo['url'];
			} else if (isset($streamit_options['header_radio'])) {
				if ($streamit_options['header_radio'] == 1) {
					$logo_text = $streamit_options['header_text'];
					echo '<h1 class="logo-text">' . esc_html($logo_text) . '</h1>';
				}
				if ($streamit_options['header_radio'] == 2) {
					$options = $streamit_options['streamit_logo']['url'];
				}
			}

			if (isset($options) && !empty($options)) {
				echo streamit()->streamit_get_svg($options, "img-fluid logo");
			}
		} elseif (has_header_image()) {
			$image = wp_get_attachment_image_src(get_theme_mod('custom_logo'), 'full');
			if (has_custom_logo()) {
				echo streamit()->streamit_get_svg($image, "img-fluid logo");
			} else {
				bloginfo('name');
			}
		} else {
			$logo_url = get_template_directory_uri() . '/assets/images/logo.png';
			echo streamit()->streamit_get_svg($logo_url, "img-fluid logo");
		} ?>
	</a>

	<div id="navbarSupportedContent" class="collapse navbar-collapse new-collapse">
			<?php
			if (streamit()->is_primary_nav_menu_active()) {
				streamit()->display_primary_nav_menu(array(
					'theme_location' => 'top',
					'menu_class'     => 'navbar-nav ml-auto',
					'menu_id'        => 'top-menu',
					'container'       => 'div',
					'container_id'   => 'iq-menu-container',
				));
			}
			?>
	</div>
	<div class="sub-main">
		<nav aria-label="breadcrumb">
			<?php get_template_part('template-parts/header/header', 'user'); ?>
		</nav>
	</div>
	<button class="navbar-toggler custom-toggler ham-toggle streamit-menu-box" type="button" data-toggle="collapse" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon">
			<span class="menu-btn d-inline-block" id="menu-btn">
			<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none"><rect width="4" height="4" fill="white"></rect><rect x="6" width="4" height="4" fill="white"></rect><rect x="12" width="4" height="4" fill="white"></rect><rect y="6" width="4" height="4" fill="white"></rect><rect x="6" y="6" width="4" height="4" fill="white"></rect><rect x="12" y="6" width="4" height="4" fill="white"></rect><rect y="12" width="4" height="4" fill="white"></rect><rect x="6" y="12" width="4" height="4" fill="white"></rect><rect x="12" y="12" width="4" height="4" fill="white"></rect></svg>
			</span>
		</span>
	</button>
</nav><!-- #site-navigation -->
<div class="nav-overlay"></div>