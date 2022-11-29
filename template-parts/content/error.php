<?php

/**
 * Template part for displaying the page content when an error has occurred
 *
 * @package streamit
 */

namespace Streamit\Utility;

?>
<div class="col-12">
	<section class="error text-center streamit-error">
		<?php get_template_part('template-parts/content/page_header'); ?>
		<div class="page-content">
			<?php if (is_home() && current_user_can('publish_posts')) { ?>
				<p>
					<?php
					printf(
						wp_kses(
							/* translators: 1: link to WP admin new post page. */
							__('Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'streamit'),
							array(
								'a' => array(
									'href' => array(),
								),
							)
						),
						esc_url(admin_url('post-new.php'))
					);
					?>
				</p>
			<?php } elseif (is_search()) { ?>
				<div class="row justify-content-center align-items-center">

				
				<div class="col-md-6">
					<p>
						<?php esc_html_e('Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'streamit'); ?>
					</p>
					<form method="get" class="search-form search__form errorsearchform" action="<?php echo esc_url(home_url('/')); ?>">
						<div class="form-search clearfix">
							<input type="search" class="search-field search__input error-search__input" name="s" value="<?php echo get_search_query(); ?>" placeholder=<?php esc_attr_e("Search website", "streamit") ?> />
							<button type="submit" class="search-submit"><i class="fa fa-search" aria-hidden="true"></i><span class="screen-reader-text"><?php echo esc_html_x('Search', 'submit button', 'streamit'); ?></span></button>
						</div>
					</form>
					<div class="d-block pt-4">
						<?php
						if (!empty($streamit_options['404_backtohome_title'])) {
							$btn_text  = esc_html($streamit_options['404_backtohome_title']);
						} else {
							$btn_text  = esc_html__('Back to Home', 'streamit');
						}
						?>
						<?php echo  streamit()->streamit_get_comment_btn('a',$btn_text,true,array('href'=>home_url(), 'class'=>'btn-hover')); ?>
					</div>
				</div>

				</div>
			<?php } else { ?>
				<p>
					<?php esc_html_e('It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'streamit'); ?>
				</p>
			<?php
			}
			get_search_form('');
			?>
		</div><!-- .page-content -->
	</section><!-- .error -->
</div>