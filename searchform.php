<?php

/**
 * The template for displaying all pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package streamit
 */

namespace Streamit\Utility;

$unique_id = esc_html(uniqid('search-form-')); ?>
<form method="get" class="search-form search__form" action="<?php echo esc_url(home_url('/')); ?>" autocomplete="off">
	<label for="<?php echo esc_attr($unique_id); ?>">
		<span class="screen-reader-text"><?php echo esc_html_x('Search for:', 'label', 'streamit'); ?></span>
	</label>
	<input type="search" id="searchInput" class="search-field search__input" onkeyup="debounce_fn(this)" placeholder="<?php echo esc_attr_x('Search', 'placeholder', 'streamit'); ?>" value="<?php echo get_search_query(); ?>" name="s" />
	<?php if (isset($args['is_header_ajax']) && $args['is_header_ajax']) { ?>
		<input type="hidden" name="ajax_search" value="true">
	<?php } else { ?>
		<input type="hidden" name="post_type" value="post" />
	<?php } ?>
	<button type="submit" class="search-submit"><i class="ion-ios-search"></i><span class="screen-reader-text"><?php echo esc_html_x('Search', 'submit button', 'streamit'); ?></span></button>
	<div id="datafetch" class="datafetch"></div>

</form>