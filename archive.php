<?php

/**
 * The template for displaying archive pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package streamit
 */

namespace Streamit\Utility;
 
global $wp_query;

global $streamit_options;

$is_sidebar = streamit()->is_primary_sidebar_active();
$post_section = streamit()->post_style();
get_header();
$options_streamit_load = !empty($streamit_options) ? $streamit_options['streamit_genere_tag_category_item'] : '';
$args['post_type'] = $wp_query->query_vars['post_type'];

if ($wp_query->query_vars['post_type'] != 'person' && $wp_query->query_vars['post_type'] != 'tv_show') {
	$args = $wp_query->query;
}

$streamit_layout = '';
if (isset($streamit_options['streamit_blog'])) {
	$streamit_layout = $streamit_options['streamit_blog'];
}

$args['posts_per_page'] = isset($streamit_options['streamit_genere_tag_category_post_per_page']) && !empty($streamit_options['streamit_genere_tag_category_post_per_page']) ? $streamit_options['streamit_genere_tag_category_post_per_page'] : $wp_query->query_vars['posts_per_page'];
$is_generes_tag = !empty(wp_get_post_terms(get_the_ID(), array('movie_genre', 'movie_tag', 'video_tag', 'video_cat', 'tv_show_tag', 'tv_show_genre', 'persons')));
$wp_post = new \WP_Query($args);
?>

<div class="site-content-contain">
	<div id="content" class="site-content">
		<div id="primary" class="content-area">
			<main id="main" class="site-main <?php if($is_generes_tag) { echo  esc_attr('watchlist-contens streamit_datapass_archive');  }else{ echo esc_attr('streamit_datapass_blog');}  ?>" data-displaypost="<?php echo esc_attr($args['posts_per_page']) ?>" data-options="<?php echo esc_attr($is_generes_tag ? $options_streamit_load : $streamit_options['streamit_display_pagination']); ?>" data-pages="<?php echo esc_attr(round($wp_post->found_posts / $args['posts_per_page'])) ?>">
				<?php

				if (class_exists('MasVideos') && $is_generes_tag && !(is_date() || 	is_author()) && get_post_type()!='post')  {

					if ($wp_post->have_posts()) {
				?>
						<div class="container-fluid ">
							<div class="row iq_archive_items <?php echo esc_attr('iq-archive-' . get_post_type()) ?>">
								<?php
								while ($wp_post->have_posts()) {
									$wp_post->the_post();
									get_template_part('template-parts/content/entry_archive', get_post_type($wp_post->ID));
								}
								wp_reset_postdata();
								?>
							</div>
							<?php
							if (isset($streamit_options['streamit_genere_tag_category_item'])) {
								$options = $streamit_options['streamit_genere_tag_category_item'];
								if ($options == "load_more") {
									if ($wp_post->max_num_pages > 1)
										echo '<a class="streamit_loadmore_btn btn btn-hover iq-button" tabindex="0" data-loading-text="' . $streamit_options['streamit_genere_tag_category_loadmore_text_2'] . '"><span data-parallax="scroll">' . $streamit_options['streamit_genere_tag_category_display_loadmore_text'] . '</span></a>';
								} elseif ($options == "infinite_scroll") {

									echo '<div class="loader-wheel-container"></div>';
								} else {
									get_template_part('template-parts/content/pagination');
								}
							} else {
								get_template_part('template-parts/content/pagination');
							}
							?>

						</div>
					<?php
					}else{
						get_template_part('template-parts/content/error');
					}
				} else {


					$args = $wp_query->query_vars;

					unset($args['post_type']);
					unset($args['posts_per_page']);
					$args['post_type'] = array('post');


					?>
					<div class="container">
						<div class="row <?php echo esc_attr($post_section['row_reverse']); ?>">
							<?php
							if ($is_sidebar) {
								echo '<div class="col-xl-8 col-sm-12 streamit-blog-main-list">';
							} else if ($streamit_layout != '4' && $streamit_layout != '5') {
								echo '<div class="col-lg-12 col-sm-12 streamit-blog-main-list">';
							}

							if (have_posts()) {
								while (have_posts()) {
									the_post();
									get_template_part('template-parts/content/entry', get_post_type(), $post_section['post']);
								}
							} else {
								get_template_part('template-parts/content/error');
							}

							if ($is_sidebar || $streamit_layout != '4' && $streamit_layout != '5') {
								echo '</div>';
								get_sidebar();
							}

							?>
						</div>
						<?php
						if (!is_singular()) {
							if (isset($streamit_options['streamit_display_pagination'])) {
								$options = $streamit_options['streamit_display_pagination'];
								if ($options == "load_more") {
									
									if ($wp_query->max_num_pages > 1)
										echo '<a class="streamit_loadmore_btn_blog btn btn-hover iq-button" tabindex="0" data-loading-text="' . $streamit_options['streamit_display_blog_loadmore_text_2'] . '"><span>' . $streamit_options['streamit_display_blog_loadmore_text'] . '</span></a>';
								} elseif ($options == "infinite_scroll") {

									echo '<div class="loader-wheel-container"></div>';
								} else {
									get_template_part('template-parts/content/pagination');
								}
							} else {
								get_template_part('template-parts/content/pagination');
							}
						}

						?>
					</div>

				<?php
				}
				?>
			</main><!-- #main -->
		</div> <!-- #primary -->

	</div>

</div>
<?php
get_footer();
