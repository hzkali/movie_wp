<?php

/**
 * Streamit\Utility\Helper\Component class
 *
 * @package streamit
 */

namespace Streamit\Utility\Helper;

use Exception;
use Streamit\Utility\Component_Interface;
use function add_action;
use function Patchwork\Utils\args;

/**
 * Class for managing comments UI.
 *
 * Exposes template tags:
 * * `streamit()->the_comments( array $args = array() )`
 *
 * @link https://wordpress.org/plugins/amp/
 */
class Component implements Component_Interface
{
	/**
	 * Gets the unique identifier for the theme component.
	 *
	 * @return string Component slug.
	 */

	public $streamit_options;

	public function get_slug(): string
	{
		return 'helper';
	}

	/**
	 * Adds the action and filter hooks to integrate with WordPress.
	 */
	public function initialize()
	{
		// live ajax search
		add_action('wp_ajax_data_fetch', array($this, 'data_fetch'));
		add_action('wp_ajax_nopriv_data_fetch', array($this, 'data_fetch'));
		add_action('wp_footer', array($this, 'ajax_fetch'), 9999);

		add_action('pre_post_update', array($this, 'streamit_save_episode_function'), 10, 2);
		add_action('draft_to_publish', array($this, 'streamit_save_episode_function'));

		// ** search load more *//
		if (!function_exists('streamit_loadmore_ajax_handler')) {
			add_action('wp_ajax_loadmore', array($this, 'streamit_loadmore_ajax_handler'));
			add_action('wp_ajax_nopriv_loadmore', array($this, 'streamit_loadmore_ajax_handler'));
		}
		//** blog load more *//
		if (!function_exists('streamit_loadmore_blog_ajax_handler')) {
			add_action('wp_ajax_loadmore_blog', array($this, 'streamit_loadmore_blog_ajax_handler'));
			add_action('wp_ajax_nopriv_loadmore_blog', array($this, 'streamit_loadmore_blog_ajax_handler'));
		}
		//** person load more *//
		if (!function_exists('streamit_loadmore_person_ajax_handler')) {
			add_action('wp_ajax_loadmore_person', array($this, 'streamit_loadmore_person_ajax_handler'));
			add_action('wp_ajax_nopriv_loadmore_person', array($this, 'streamit_loadmore_person_ajax_handler'));
		}
		// Archive Page -> Genres ,Tag, Category
		if (!function_exists('streamit_loadmore_archive_ajax_handle')) {
			add_action('wp_ajax_loadmore_archive', array($this, 'streamit_loadmore_archive_ajax_handle'), 10, 2);
			add_action('wp_ajax_nopriv_loadmore_archive', array($this, 'streamit_loadmore_archive_ajax_handle'));
		}

		// ** Product load more *//
		if (!function_exists('streamit_loadmore_product_ajax_handler')) {
			add_action('wp_ajax_loadmore_product', array($this, 'streamit_loadmore_product_ajax_handler'));
			add_action('wp_ajax_nopriv_loadmore_product', array($this, 'streamit_loadmore_product_ajax_handler'));
		}

		add_action('wp_ajax_load_skeleton', array($this, 'streamit_load_skeleton_ajax_handler'));
		add_action('wp_ajax_nopriv_load_skeleton', array($this, 'streamit_load_skeleton_ajax_handler'));

		// Get Woof Ajax Filter Product Query 
		if (!function_exists('streamit_fetch_woof_filter_ajax_query')) {
			add_action('wp_ajax_fetch_woof_filter_ajax_query', array($this, 'streamit_fetch_woof_filter_ajax_query'));
			add_action('wp_ajax_nopriv_fetch_woof_filter_ajax_query', array($this, 'streamit_fetch_woof_filter_ajax_query'));
		}

		if (!function_exists('streamit_download_file')) {
			add_action('admin_post_streamit_download', array($this, 'streamit_download_file'));
			add_action('admin_post_nopriv_streamit_download', array($this, 'streamit_download_file'));
		}
		add_filter('pms_edit_profile_form_submit_text', function ($btn_text) {
			return esc_html__('Save Profile', 'streamit');
		});
		add_filter('pms_member_account_subscriptions_view_row', function ($subscription_row) {
			return '<div class="table-responsive">' . $subscription_row . '</div>';
		});
	}
	public function streamit_load_skeleton_ajax_handler()
	{
		$skeleton_path = get_template_directory() . '/template-parts/skeleton/';
		try {
			$data = array(
				'skeleton-grid' => file_get_contents($skeleton_path . 'skeleton-grid.php'),
				'skeleton-list' => file_get_contents($skeleton_path . 'skeleton-list.php'),
			);
			if ($data['skeleton-grid'] == false || $data['skeleton-list'] == false) {
				throw new Exception("File not Found");
			}
			wp_send_json_success($data);
		} catch (Exception $e) {
			wp_send_json_error($e->getMessage(), 404);
		}
	}
	public function streamit_download_file()
	{
		if (isset($_POST["download"]) && !empty($_POST['download'])) {
			$this->streamit_send_download_file();
		}
	}
	public function streamit_send_download_file()
	{
		$id = base64_decode($_POST["download"]);

		if (get_post_meta($id, 'download_btn', true) == 'link') {
			$remoteURL = get_post_meta($id, 'dwn_link', true);
		} elseif (get_post_meta($id, 'download_btn', true) == 'upload') {
			$remoteURL = wp_get_attachment_url(get_post_meta($id, 'upload_item', true));
		}

		if (!post_exists(get_the_title($id)) && !empty($remoteURL))
			return;

		header("Content-type: application/x-file-to-save");
		header("Content-Disposition: attachment; filename=" . basename($remoteURL));
		while (ob_get_level()) {
			ob_end_clean();
		}
		readfile($remoteURL);
		exit();
	}
	public function streamit_fetch_woof_filter_ajax_query()
	{

		session_start();
		$query = new \WP_Query($_SESSION['streamit_woof_query_ajax']);
		echo json_encode(array('query' => json_encode($_SESSION['streamit_woof_query_ajax']), 'max_page' => $query->max_num_pages));
		wp_reset_postdata();
		session_unset();
		die;
	}


	// live ajax search
	public function data_fetch()
	{

		$args = array('posts_per_page' => 5, 's' => esc_attr($_POST['keyword']), 'post_type' =>  apply_filters('streamit_search_filter_ajax_by_posttype', array('movie', 'tv_show', 'episode', 'video')));
		if (isset($_POST['is_include']) && $_POST['is_include'] == 'posts') {
			array_push($args['post_type'], 'post');
			array_push($args['post_status'], 'publish');
		}

		$wp_query = new \WP_Query($args); ?>
		<div class="widget streamit-ajax-custom-search mb-0 pb-0">
			<div class="list-inline iq-widget-menu">
				<ul class="iq-post">
					<?php
					$genre = '';
					if ($wp_query->have_posts()) :
						while ($wp_query->have_posts()) : $wp_query->the_post();
							if ('movie' == get_post_type() || 'tv_show' == get_post_type()) {
								$wp_object = wp_get_post_terms(get_the_ID(), 'movie_genre');
							} else if ('video' == get_post_type()) {
								$wp_object = wp_get_post_terms(get_the_ID(), 'video_cat');
							} else {
								$wp_object = wp_get_post_terms(get_the_ID(), 'category');
							}
							if (!empty($wp_object)) {
								$k = 1;
								foreach ($wp_object as $val) {

									if ($k == 1)
										$genre = $val->name;
									else
										$genre .= ', ' . $val->name;
									$k++;
								}
							}
							$img_url = wp_get_attachment_image_url(get_post_thumbnail_id(get_the_ID()), "medium");
					?>
							<li class="mr-0 mb-2 pb-0 d-block">
								<div class="post-img">
									<div class="post-img-holder">
										<a class="img-height" href="<?php echo esc_url(get_permalink()); ?>">
											<img src='<?php echo esc_url($img_url, 'streamit'); ?>' alt="image" />
										</a>
									</div>
									<div class="post-blog pt-2 pb-2 pr-2">
										<div class="blog-box">
											<a class="new-link" href="<?php echo esc_url(get_permalink()); ?>">
												<h6><?php the_title(); ?></h6>
											</a>

											<ul class="list-inline iq-category-list">
												<li class="list-inline-item"><span><?php echo esc_html(rtrim($genre, ",")); ?></span></li>
											</ul>

										</div>
									</div>
								</div>
							</li>

						<?php endwhile;
						wp_reset_postdata();
						?>

				</ul>
			<?php
					else :
						echo '<p class="no-result pb-2">' . esc_html__('No Results Found', 'streamit') . '</p>';
					endif;
			?>
			</div>
		</div>
		<?php
		$tot = $wp_query->found_posts;
		$total_pages = $wp_query->max_num_pages;
		if ($total_pages > 1) { ?>
			<button type="submit" class="hover-buttons btn w-100"><?php esc_html_e('More Results', 'streamit'); ?></button>
		<?php }
		die();
	}

	public function ajax_fetch()
	{
		?>
		<script type="text/javascript">
			var debounce_fn = _.debounce(fetchResults, 500, false);

			function fetchResults(input) {
				let keyword = input.value;
				if (jQuery(input).parents('header').length == 0) {
					return false
				}
				if (keyword == "") {
					jQuery(input).siblings('.datafetch').html('');
				} else {
					jQuery.ajax({
						url: '<?php echo admin_url('admin-ajax.php'); ?>',
						type: 'post',
						data: {
							action: 'data_fetch',
							keyword: keyword,
							is_include: 'posts',
						},
						success: function(data) {
							jQuery(input).siblings('.datafetch').html(data);
						}
					});
				}
			}
		</script>
		<?php
	}

	// EPisode update feature checkbox
	public function streamit_save_episode_function($post_ID)
	{
		if (get_post_type($post_ID) == 'episode') {

			if (isset($_POST['_featured']) && !empty($_POST['_featured'])) {
				update_post_meta($post_ID, '__featured', 'yes');
				return;
			}

			update_post_meta($post_ID, '__featured', false);
		}
	}

	// ** search load more *//
	public function streamit_loadmore_ajax_handler()
	{
		$args = json_decode(stripslashes($_POST['query']), true);
		$args['paged'] = $_POST['page'] + 1; // we need next page to be loaded
		$args['post_status'] = 'publish';

		query_posts($args);
		if (have_posts()) :
			while (have_posts()) : the_post();
				get_template_part('template-parts/content/entry_search', get_post_type());
			endwhile;

		endif;
		die;
	}

	//** blog load more *//
	public function streamit_loadmore_blog_ajax_handler()
	{
		$args = json_decode(stripslashes($_POST['query']), true);
		$args['paged'] = $_POST['page'] + 1; // we need next page to be loaded
		$args['post_status'] = 'publish';

		query_posts($args);
		if (have_posts()) :
			while (have_posts()) : the_post();
				get_template_part('template-parts/content/entry', get_post_type());
			endwhile;

		endif;
		die;
	}

	//** person load more *//
	public function streamit_loadmore_person_ajax_handler()
	{
		$cast_id = url_to_postid($_POST['href']);
		$post_type = $_POST['post_type'];
		$recommended_person_cast_ids = [];
		$recommended_movie_cast_ids = [];
		$recommended_tv_show_cast_ids = [];
		$recommended_movie_cast_ids = get_post_meta($cast_id, '_movie_cast', true);
		if (is_array($recommended_movie_cast_ids) && !empty($recommended_movie_cast_ids)) {
			$recommended_person_cast_ids = array_merge($recommended_person_cast_ids, $recommended_movie_cast_ids);
		}
		$recommended_tv_show_cast_ids = get_post_meta($cast_id, '_tv_show_cast', true);
		if (is_array($recommended_tv_show_cast_ids) && !empty($recommended_tv_show_cast_ids)) {
			$recommended_person_cast_ids = array_merge($recommended_person_cast_ids, $recommended_tv_show_cast_ids);
		}
		$args = array(
			'posts_per_page'     => 10,
			'paged'                => $_POST['page'] + 1,
			'post_status'       => 'publish',
			'order'             => 'ASc',
			'suppress_filters'  => 0
		);
		if ($post_type == 'all') {
			$args['post_type'] = array('movie', 'tv_show');
			$args['post__in'] = $recommended_person_cast_ids;
			$args['fields'] = 'ids';
		} else if ($post_type == 'tv_show') {
			$args['post_type'] = 'tv_show';
			$args['post__in'] = $recommended_tv_show_cast_ids;
		} else {
			$args['post_type'] = 'movie';
			$args['post__in'] = $recommended_movie_cast_ids;
		}
		$counter = $args['posts_per_page'] + 1;
		query_posts($args);
		if (have_posts()) :
			while (have_posts()) : the_post();
				$r_movie_obj = get_the_ID();
				$meta = get_post_meta($r_movie_obj);
				$movie_cast = get_post_meta($r_movie_obj, '_cast');
				$m_cast = $movie_cast[0];
				$found_key = array_search($cast_id, array_column($m_cast, 'id'));
				if ('tv_show' == get_post_type()) {
					$season_data = unserialize($meta['_seasons'][0]);
					if (!empty($season_data)) {
						$season_years = array_column($season_data, 'year');
						$start = count($season_years) ? min($season_years) : '';
						$end = count($season_years) ? max($season_years) : '';
						$season_count = count($season_data);
						if ($season_count == '1') {
							$release_year = $start;
						} else {
							if (!empty($start) && !empty($end)) {
								$release_year = $start . ' - ' . $end;
							}
						}
						if (is_array($season_data)) {
							$censor_rating = ' (' . count($season_data) . ' Seasons) ';
						}
					}
				} else {
					$release_year = get_post_meta($r_movie_obj, '_movie_release_date');
					if (isset($release_year[0])) {
						$release_year = date('Y', $release_year[0]);
					}
				}
				$attachement_url = wp_get_attachment_image_src(get_post_thumbnail_id($r_movie_obj), 'thumbnail')[0];
				if (isset($attachement_url) && !empty($attachement_url))
					$attachement_url = $attachement_url;
				else
					$attachement_url = ''; ?>
				<tr class="trending-pills">
					<td class="image"><img src="<?php echo esc_url($attachement_url); ?>" class="img-fluid" alt="<?php esc_attr_e('streamit', 'streamit'); ?>"></td>
					<td class="seperator"><?php echo esc_html($counter); ?></td>
					<td class="content">
						<a href="<?php the_permalink(); ?>">
							<?php the_title(); ?>
						</a>
						<span class="ml-2 group"> <?php esc_html_e('as', 'streamit'); ?> <span class="character">
								<?php echo esc_html($m_cast[$found_key]['character']);
								if ('tv_show' == get_post_type()) {
									echo esc_html($censor_rating);
								} ?></span></span>
					</td>
					<td class="year">
						<?php if (!empty($release_year)) {
							echo esc_html($release_year);
						} ?>
					</td>
				</tr>
				<?php $counter++;
			endwhile;
		endif;
		die;
	}

	public function  streamit_loadmore_archive_ajax_handle()
	{

		$args = json_decode(stripslashes($_POST['query']), true);
		$args['posts_per_page'] = $_POST['availablepost'];
		$args['paged'] = $_POST['page'] + 1;


		query_posts($args);
		if (have_posts()) {
			if ($args['post_type'] != 'person') {
				while (have_posts()) {
					the_post();

				?>
					<article id="post-<?php the_ID(); ?>" class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6 wl-child archive-media">
						<div class="block-images position-relative watchlist-img">
							<?php
							global $streamit_options;

							if (isset($streamit_options['streamit_display_image'])) {
								$options = $streamit_options['streamit_display_image'];
								if ($options == "yes") {
									if (has_post_thumbnail()) {
										$full_image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), "medium_large");
							?>
										<div class="img-box">
											<style>
												@media (min-width: 1920px) {
													<?php
													$full_image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), "full");
													?>
												}
											</style>
											<img src="<?php echo esc_url($full_image[0]) ?>" class="img-fluid" alt="image">
										</div>
							<?php }
								}
							} ?>
							<div class="block-description">
								<h6 class="iq-title">
									<a href="<?php echo esc_url(get_the_permalink()); ?>">
										<?php the_title(); ?>
									</a>
								</h6>
								<div class="movie-time d-flex align-items-center my-2">
									<span class="text-white"><?php echo get_the_date(); ?></span>
								</div>
								<div class="hover-buttons">
									<a href="<?php echo esc_url(get_the_permalink()); ?>" class="btn btn-hover iq-button">
										<i class="fas fa-play mr-1" aria-hidden="true"></i>
										<?php _e('Play Now', 'streamit') ?>
									</a>
								</div>
							</div>
							<div class="block-social-info">
								<ul class="list-inline p-0 m-0 music-play-lists">
									<?php if (isset($streamit_options['streamit_display_social_icons'])) {
										if ($streamit_options['streamit_display_social_icons'] == 'yes') {
									?>
											<li class="share">
												<span><i class="ri-share-fill"></i></span>
												<div class="share-box">
													<svg width="15" height="40" viewBox="0 0 15 40" fill="none" xmlns="http://www.w3.org/2000/svg">
														<path fill-rule="evenodd" clip-rule="evenodd" d="M14.8842 40C6.82983 37.2868 1 29.3582 1 20C1 10.6418 6.82983 2.71323 14.8842 0H0V40H14.8842Z" fill="#191919" />
													</svg>
													<div class="d-flex align-items-center">
														<a href="https://www.facebook.com/sharer?u=<?php the_permalink(); ?>" target="_blank" rel="noopener noreferrer" class="share-ico"><i class="ri-facebook-fill"></i></a>
														<a href="http://twitter.com/intent/tweet?text=<?php the_title(); ?>&url=<?php echo get_the_permalink(); ?>" target="_blank" rel="noopener noreferrer" class="share-ico"><i class="ri-twitter-fill"></i></a>
														<a href="#" data-link='<?php get_permalink(get_the_ID()); ?>' class="share-ico iq-copy-link"><i class="ri-links-fill"></i></a>
													</div>
												</div>
											</li>
									<?php }
									} ?>
									<?php if (isset($streamit_options['streamit_display_like'])) {
										if ($streamit_options['streamit_display_like'] == 'yes') {
									?>
											<li>
												<div class="iq-like-btn"><?php echo do_shortcode('[wp_ulike for="movie" id="' . get_the_ID() . '" style="wpulike-heart"]'); ?></div>
											</li>
										<?php }
									}
									if (isset($streamit_options['streamit_display_watchlist']) && $streamit_options['streamit_display_watchlist'] == 'yes') { ?>
										<li>
											<?php
											if (!is_user_logged_in()) {
												if (isset($streamit_options['streamit_signin_link'])) {
													$streamit_signin_link = get_page_link($streamit_options['streamit_signin_link']);

											?>
													<a class="watch-list-not" href="<?php echo esc_url($streamit_signin_link) ?>">
														<span><i class="ri-add-line"></i></span>
													</a>
												<?php }
											} else {
												?>
												<a class="watch-list" rel="<?php echo esc_attr(get_the_ID(), 'streamit'); ?>">
													<?php
													if (function_exists('add_to_watchlist')) {
														echo add_to_watchlist(get_the_ID());
													}
													?>
												</a>
											<?php } ?>
										</li>
									<?php } ?>
								</ul>
							</div>
						</div>
					</article>

		<?php
				}
			} else {
				while (have_posts()) {
					the_post();
					get_template_part('template-parts/content/entry_archive', 'person');
				}
			}
		}
		wp_die();
	}

	public function streamit_loadmore_product_ajax_handler()
	{
		$args = json_decode(stripslashes($_POST['query']), true);
		$args['paged'] = $_POST['page'] + 1; // we need next page to be loaded
		$args['post_status'] = 'publish';
		$is_grid = $_POST['is_grid'] != 'true' ? 'listing' : 'grid';
		$is_switch = isset($_POST['is_switch']) && $_POST['is_switch'] == 'true' ? true : false;



		if ($is_switch) {
			for ($args['paged'] = 1; $args['paged'] <= $_POST['page']; $args['paged']++) {

				query_posts($args);
				if (have_posts()) :
					while (have_posts()) : the_post();

						get_template_part('template-parts/wocommerce/entry', $is_grid);

					endwhile;

				endif;
			}
		} else {

			query_posts($args);
			if (have_posts()) :
				while (have_posts()) : the_post();

					get_template_part('template-parts/wocommerce/entry', $is_grid);

				endwhile;

			endif;
		}

		die;
	}
	
}
