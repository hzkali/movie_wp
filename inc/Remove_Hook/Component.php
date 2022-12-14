<?php

/**
 * Streamit\Utility\Remove_Hook\Component class
 *
 * @package streamit
 */

namespace Streamit\Utility\Remove_Hook;

use Streamit\Utility\Component_Interface;

/**
 * Class for improving remove_Hook among various core features.
 */
class Component implements Component_Interface
{

	/**
	 * Gets the unique identifier for the theme component.
	 *
	 * @return string Component slug.
	 */
	public function get_slug(): string
	{
		return 'remove_hook';
	}

	/**
	 * Adds the action and filter hooks to integrate with WordPress.
	 */
	public function initialize()
	{

		add_filter('body_class', 'masvideos_body_class');

		remove_action('masvideos_before_main_content', 'masvideos_template_loop_content_area_open', 10);
		remove_action('masvideos_before_movies_loop', 'masvideos_movies_control_bar', 10);
		remove_action('masvideos_after_movies_loop', 'masvideos_movies_page_control_bar', 10);
		remove_action('masvideos_before_tv_shows_loop', 'masvideos_tv_shows_control_bar', 10);
		remove_action('masvideos_after_tv_shows_loop', 'masvideos_tv_shows_page_control_bar', 10);
		remove_action('masvideos_before_persons_loop', 'masvideos_persons_control_bar', 10);
		remove_action('masvideos_after_persons_loop', 'masvideos_persons_page_control_bar', 10);
		remove_action('masvideos_before_videos_loop', 'masvideos_videos_control_bar', 10);
		remove_action('masvideos_after_videos_loop', 'masvideos_videos_control_bar', 10);
		remove_action('masvideos_after_main_content', 'masvideos_template_loop_content_area_close', 999);


		/**
		 * Breadcrumbs.
		 *
		 * @see masvideos_breadcrumb()
		 */
		remove_action('masvideos_before_main_content', 'masvideos_breadcrumb', 20, 0);

		/**
		 * Notices.
		 */
		remove_action('masvideos_before_user_register_login_form', 'masvideos_output_all_notices', 10);
		remove_action('masvideos_before_edit_video_form', 'masvideos_output_all_notices', 10);

		/**
		 * My Account.
		 */
		remove_action('masvideos_account_navigation', 'masvideos_account_navigation');
		remove_action('masvideos_account_content', 'masvideos_account_content');
		remove_action('masvideos_account_videos_endpoint', 'masvideos_account_videos');
		remove_action('masvideos_account_movie-playlists_endpoint', 'masvideos_account_movie_playlists');
		remove_action('masvideos_account_video-playlists_endpoint', 'masvideos_account_video_playlists');
		remove_action('masvideos_account_tv-show-playlists_endpoint', 'masvideos_account_tv_show_playlists');
		remove_action('masvideos_account_edit-account_endpoint', 'masvideos_account_edit_account');

		remove_action('masvideos_before_edit_account_form', 'masvideos_print_notices');

		/**
		 * Persons Loop.
		 */
		remove_action('masvideos_no_persons_found', 'masvideos_no_persons_found', 10);
		remove_action('masvideos_persons_loop', 'masvideos_persons_loop_content', 20);
		remove_action('masvideos_before_persons_loop', 'masvideos_display_person_page_title', 5);
		remove_action('masvideos_before_persons_loop_item', 'masvideos_template_loop_person_poster_open', 30);
		remove_action('masvideos_before_persons_loop_item', 'masvideos_template_loop_person_link_open', 40);
		remove_action('masvideos_before_persons_loop_item', 'masvideos_template_loop_person_poster', 50);
		remove_action('masvideos_before_persons_loop_item', 'masvideos_template_loop_person_link_close', 60);
		remove_action('masvideos_before_persons_loop_item', 'masvideos_template_loop_person_poster_close', 70);
		remove_action('masvideos_before_persons_loop_item_title', 'masvideos_template_loop_person_body_open', 80);
		remove_action('masvideos_before_persons_loop_item_title', 'masvideos_template_loop_person_link_open', 90);
		remove_action('masvideos_persons_loop_item_title', 'masvideos_template_loop_person_title', 10);
		remove_action('masvideos_after_persons_loop_item_title', 'masvideos_template_loop_person_link_close', 10);
		remove_action('masvideos_after_persons_loop_item_title', 'masvideos_template_loop_person_body_close', 20);

		/**
		 * Person Single.
		 */
		remove_action('masvideos_single_person_summary', 'masvideos_template_single_person_content_sidebar_open', 10);
		remove_action('masvideos_single_person_summary', 'masvideos_template_single_person_content_sidebar', 20);
		remove_action('masvideos_single_person_summary', 'masvideos_template_single_person_content_sidebar_close', 30);
		remove_action('masvideos_single_person_summary', 'masvideos_template_single_person_content_body_open', 40);
		remove_action('masvideos_single_person_summary', 'masvideos_template_single_person_title', 50);
		remove_action('masvideos_single_person_summary', 'masvideos_template_single_person_short_desc', 60);
		remove_action('masvideos_single_person_summary', 'masvideos_template_single_person_credits_tabs', 70);
		remove_action('masvideos_single_person_summary', 'masvideos_template_single_person_tabs', 80);
		remove_action('masvideos_single_person_summary', 'masvideos_template_single_person_content_body_close', 200);

		remove_action('masvideos_template_single_person_content_sidebar', 'masvideos_template_single_person_poster', 10);

		/**
		 * Episodes Loop.
		 */
		remove_action('masvideos_no_episodes_found', 'masvideos_no_episodes_found', 10);
		remove_action('masvideos_episodes_loop', 'masvideos_episodes_loop_content', 20);
		remove_action('masvideos_before_episodes_loop_item', 'masvideos_template_loop_episode_poster_open', 30);
		remove_action('masvideos_before_episodes_loop_item', 'masvideos_template_loop_episode_link_open', 40);
		remove_action('masvideos_before_episodes_loop_item', 'masvideos_template_loop_episode_poster', 50);
		remove_action('masvideos_before_episodes_loop_item', 'masvideos_template_loop_episode_link_close', 60);
		remove_action('masvideos_before_episodes_loop_item', 'masvideos_template_loop_episode_poster_close', 70);
		remove_action('masvideos_before_episodes_loop_item_title', 'masvideos_template_loop_episode_body_open', 80);
		remove_action('masvideos_before_episodes_loop_item_title', 'masvideos_template_loop_episode_link_open', 90);
		remove_action('masvideos_episodes_loop_item_title', 'masvideos_template_loop_episode_title', 10);
		remove_action('masvideos_after_episodes_loop_item_title', 'masvideos_template_loop_episode_link_close', 10);
		remove_action('masvideos_after_episodes_loop_item_title', 'masvideos_template_loop_episode_body_close', 20);

		/**
		 * Episode Single.
		 */
		remove_action('masvideos_before_single_episode_summary', 'masvideos_template_single_episode_prev_navigation', 20);
		remove_action('masvideos_before_single_episode_summary', 'masvideos_template_single_episode_next_navigation', 60);
		remove_action('masvideos_before_single_episode_summary', 'masvideos_template_single_episode_head_wrap_close', 70);
		remove_action('masvideos_single_episode_summary', 'masvideos_template_single_episode_title', 5);
		remove_action('masvideos_single_episode_summary', 'masvideos_template_single_episode_info_head_open', 11);
		remove_action('masvideos_single_episode_summary', 'masvideos_template_single_episode_meta', 20);
		remove_action('masvideos_single_episode_summary', 'masvideos_template_single_episode_rating_with_sharing_open', 30);
		remove_action('masvideos_single_episode_summary', 'masvideos_template_single_episode_avg_rating', 40);
		remove_action('masvideos_single_episode_summary', 'masvideos_template_single_sharing', 50);
		remove_action('masvideos_single_episode_summary', 'masvideos_template_single_episode_rating_with_sharing_close', 60);
		remove_action('masvideos_single_episode_summary', 'masvideos_template_single_episode_info_head_close', 70);
		remove_action('masvideos_single_episode_summary', 'masvideos_template_single_episode_info_body_open', 80);
		remove_action('masvideos_single_episode_summary', 'masvideos_template_single_episode_description', 90);
		remove_action('masvideos_single_episode_summary', 'masvideos_template_single_episode_tags', 100);
		remove_action('masvideos_single_episode_summary', 'masvideos_template_single_episode_info_body_close', 110);
		remove_action('masvideos_after_single_episode_summary', 'masvideos_template_single_episode_seasons_tabs', 10);
		remove_action('masvideos_after_single_episode_summary', 'masvideos_template_single_episode_related_tv_shows', 20);
		remove_action('masvideos_after_single_episode_summary', 'masvideos_template_single_episode_tabs', 30);

		remove_action('masvideos_single_episode_meta', 'masvideos_template_single_episode_duration', 10);
		remove_action('masvideos_single_episode_meta', 'masvideos_template_single_episode_release_date', 20);

		/**
		 * Episode Reviews
		 *
		 * @see masvideos_episode_review_display_gravatar()
		 * @see masvideos_episode_review_display_rating()
		 * @see masvideos_episode_review_display_meta()
		 * @see masvideos_episode_review_display_comment_text()
		 */
		// remove_action('masvideos_episode_review_before', 'masvideos_episode_review_display_gravatar', 10);
		remove_action('masvideos_episode_review_before_comment_meta', 'masvideos_episode_review_display_rating', 10);
		add_action('masvideos_episode_review_meta', 'masvideos_episode_review_display_rating', 10);
		// remove_action('masvideos_episode_review_meta', 'masvideos_episode_review_display_meta', 10);
		// remove_action('masvideos_episode_review_comment_text', 'masvideos_episode_review_display_comment_text', 10);

		/**
		 * TV Shows Loop.
		 */
		remove_action('masvideos_no_tv_shows_found', 'masvideos_no_tv_shows_found', 10);
		remove_action('masvideos_tv_shows_loop', 'masvideos_tv_shows_loop_content', 20);
		remove_action('masvideos_before_tv_shows_loop', 'masvideos_display_tv_show_page_title', 5);
		remove_action('masvideos_before_tv_shows_loop_item', 'masvideos_template_loop_tv_show_feature_badge', 10);
		remove_action('masvideos_before_tv_shows_loop_item', 'masvideos_template_loop_tv_show_poster_open', 30);
		remove_action('masvideos_before_tv_shows_loop_item', 'masvideos_template_loop_tv_show_link_open', 40);
		remove_action('masvideos_before_tv_shows_loop_item', 'masvideos_template_loop_tv_show_poster', 50);
		remove_action('masvideos_before_tv_shows_loop_item', 'masvideos_template_loop_tv_show_link_close', 60);
		remove_action('masvideos_before_tv_shows_loop_item', 'masvideos_template_loop_tv_show_poster_close', 70);
		remove_action('masvideos_before_tv_shows_loop_item_title', 'masvideos_template_loop_tv_show_body_open', 10);
		remove_action('masvideos_before_tv_shows_loop_item_title', 'masvideos_template_loop_tv_show_info_open', 20);

		remove_action('masvideos_tv_shows_loop_item_title', 'masvideos_template_loop_tv_show_info_head_open', 10);
		remove_action('masvideos_tv_shows_loop_item_title', 'masvideos_template_single_tv_show_meta', 20);
		remove_action('masvideos_tv_shows_loop_item_title', 'masvideos_template_loop_tv_show_link_open', 30);
		remove_action('masvideos_tv_shows_loop_item_title', 'masvideos_template_loop_tv_show_title', 40);
		remove_action('masvideos_tv_shows_loop_item_title', 'masvideos_template_loop_tv_show_link_close', 50);
		remove_action('masvideos_tv_shows_loop_item_title', 'masvideos_template_loop_tv_show_new_episode', 60);
		remove_action('masvideos_tv_shows_loop_item_title', 'masvideos_template_loop_tv_show_info_head_close', 70);

		remove_action('masvideos_after_tv_shows_loop_item_title', 'masvideos_template_loop_tv_show_short_desc', 10);
		remove_action('masvideos_after_tv_shows_loop_item_title', 'masvideos_template_loop_tv_show_actions', 20);
		remove_action('masvideos_after_tv_shows_loop_item_title', 'masvideos_template_loop_tv_show_info_close', 30);
		remove_action('masvideos_after_tv_shows_loop_item', 'masvideos_template_loop_tv_show_review_info_open', 10);
		remove_action('masvideos_after_tv_shows_loop_item', 'masvideos_template_single_tv_show_avg_rating', 20);
		remove_action('masvideos_after_tv_shows_loop_item', 'masvideos_template_loop_tv_show_viewers_count', 30);
		remove_action('masvideos_after_tv_shows_loop_item', 'masvideos_template_loop_tv_show_review_info_close', 40);
		remove_action('masvideos_after_tv_shows_loop_item', 'masvideos_template_loop_tv_show_body_close', 50);

		remove_action('masvideos_after_tv_shows_loop_item', 'masvideos_template_loop_tv_show_hover_area_open', 60);
		remove_action('masvideos_after_tv_shows_loop_item', 'masvideos_template_loop_tv_show_hover_area_poster_info_open', 70);
		remove_action('masvideos_after_tv_shows_loop_item', 'masvideos_template_loop_tv_show_poster_open', 75);
		remove_action('masvideos_after_tv_shows_loop_item', 'masvideos_template_loop_tv_show_link_open', 80);
		remove_action('masvideos_after_tv_shows_loop_item', 'masvideos_template_loop_tv_show_poster', 90);
		remove_action('masvideos_after_tv_shows_loop_item', 'masvideos_template_loop_tv_show_link_close', 100);
		remove_action('masvideos_after_tv_shows_loop_item', 'masvideos_template_loop_tv_show_poster_close', 110);

		remove_action('masvideos_after_tv_shows_loop_item', 'masvideos_template_loop_tv_show_info_head_open', 120);
		remove_action('masvideos_after_tv_shows_loop_item', 'masvideos_template_single_tv_show_meta', 130);
		remove_action('masvideos_after_tv_shows_loop_item', 'masvideos_template_loop_tv_show_link_open', 140);
		remove_action('masvideos_after_tv_shows_loop_item', 'masvideos_template_loop_tv_show_title', 150);
		remove_action('masvideos_after_tv_shows_loop_item', 'masvideos_template_loop_tv_show_link_close', 160);
		remove_action('masvideos_after_tv_shows_loop_item', 'masvideos_template_loop_tv_show_info_head_close', 170);
		remove_action('masvideos_after_tv_shows_loop_item', 'masvideos_template_loop_tv_show_hover_area_poster_info_close', 180);

		remove_action('masvideos_after_tv_shows_loop_item', 'masvideos_template_loop_tv_show_hover_area_body_info_open', 190);
		remove_action('masvideos_after_tv_shows_loop_item', 'masvideos_template_loop_tv_show_seasons_episode_wrap_open', 200);
		remove_action('masvideos_after_tv_shows_loop_item', 'masvideos_template_loop_tv_show_seasons', 205);
		remove_action('masvideos_after_tv_shows_loop_item', 'masvideos_template_loop_tv_show_new_episode', 210);
		remove_action('masvideos_after_tv_shows_loop_item', 'masvideos_template_loop_tv_show_seasons_episode_wrap_close', 220);

		remove_action('masvideos_after_tv_shows_loop_item', 'masvideos_template_loop_tv_show_review_info_open', 230);
		remove_action('masvideos_after_tv_shows_loop_item', 'masvideos_template_single_tv_show_avg_rating', 240);
		remove_action('masvideos_after_tv_shows_loop_item', 'masvideos_template_loop_tv_show_viewers_count', 250);
		remove_action('masvideos_after_tv_shows_loop_item', 'masvideos_template_loop_tv_show_review_info_close', 260);
		remove_action('masvideos_after_tv_shows_loop_item', 'masvideos_template_loop_tv_show_actions', 270);

		remove_action('masvideos_after_tv_shows_loop_item', 'masvideos_template_loop_tv_show_hover_area_body_info_close', 280);
		remove_action('masvideos_after_tv_shows_loop_item', 'masvideos_template_loop_tv_show_hover_area_info_close', 290);

		/**
		 * TV Show Single.
		 */
		remove_action('masvideos_before_single_tv_show_summary', 'masvideos_template_single_tv_show_head_wrap_open', 10);
		remove_action('masvideos_before_single_tv_show_summary', 'masvideos_template_single_tv_show_poster', 20);
		remove_action('masvideos_before_single_tv_show_summary', 'masvideos_template_single_tv_show_head_wrap_close', 50);
		remove_action('masvideos_single_tv_show_summary', 'masvideos_template_single_tv_show_title', 5);
		remove_action('masvideos_single_tv_show_summary', 'masvideos_template_single_tv_show_info_head_open', 11);
		remove_action('masvideos_single_tv_show_summary', 'masvideos_template_single_tv_show_meta', 20);
		remove_action('masvideos_single_tv_show_summary', 'masvideos_template_single_tv_show_meta_right_open', 30);
		remove_action('masvideos_single_tv_show_summary', 'masvideos_template_single_tv_show_rating_with_playlist_open', 35);
		remove_action('masvideos_single_tv_show_summary', 'masvideos_template_single_tv_show_avg_rating', 40);
		remove_action('masvideos_single_tv_show_summary', 'masvideos_template_button_tv_show_playlist', 45);
		remove_action('masvideos_single_tv_show_summary', 'masvideos_template_single_tv_show_rating_with_playlist_close', 50);
		remove_action('masvideos_single_tv_show_summary', 'masvideos_template_single_sharing', 60);
		remove_action('masvideos_single_tv_show_summary', 'masvideos_template_single_tv_show_meta_right_close', 70);
		remove_action('masvideos_single_tv_show_summary', 'masvideos_template_single_tv_show_info_head_close', 80);
		remove_action('masvideos_single_tv_show_summary', 'masvideos_template_single_tv_show_info_body_open', 90);
		remove_action('masvideos_single_tv_show_summary', 'masvideos_template_single_tv_show_short_desc', 100);
		remove_action('masvideos_single_tv_show_summary', 'masvideos_template_single_tv_show_tags', 110);
		remove_action('masvideos_single_tv_show_summary', 'masvideos_template_single_tv_show_info_body_close', 120);
		remove_action('masvideos_after_single_tv_show_summary', 'masvideos_template_single_tv_show_seasons_tabs', 10);
		remove_action('masvideos_after_single_tv_show_summary', 'masvideos_related_tv_shows', 20);
		remove_action('masvideos_after_single_tv_show_summary', 'masvideos_template_single_tv_show_tabs', 30);

		remove_action('masvideos_single_tv_show_meta', 'masvideos_template_single_tv_show_genres', 10);
		remove_action('masvideos_single_tv_show_meta', 'masvideos_template_single_tv_show_release_year', 20);

		// Set current user's watched history to playlist.
		remove_action('masvideos_after_single_tv_show', 'masvideos_set_watched_tv_show_history_to_playlist', 999);

		/**
		 * TV Show Reviews
		 *
		 * @see masvideos_tv_show_review_display_gravatar()
		 * @see masvideos_tv_show_review_display_rating()
		 * @see masvideos_tv_show_review_display_meta()
		 * @see masvideos_tv_show_review_display_comment_text()
		 */
		// remove_action('masvideos_tv_show_review_before', 'masvideos_tv_show_review_display_gravatar', 10);
		remove_action('masvideos_tv_show_review_before_comment_meta', 'masvideos_tv_show_review_display_rating', 10);
		add_action('masvideos_tv_show_review_meta', 'masvideos_tv_show_review_display_rating', 10);
		// remove_action('masvideos_tv_show_review_meta', 'masvideos_tv_show_review_display_meta', 10);
		// remove_action('masvideos_tv_show_review_comment_text', 'masvideos_tv_show_review_display_comment_text', 10);

		/**
		 * Videos Loop.
		 */
		remove_action('masvideos_no_videos_found', 'masvideos_no_videos_found', 10);
		remove_action('masvideos_videos_loop', 'masvideos_videos_loop_content', 20);
		remove_action('masvideos_before_videos_loop', 'masvideos_display_video_page_title', 5);
		remove_action('masvideos_before_videos_loop_item', 'masvideos_template_loop_video_feature_badge', 10);
		remove_action('masvideos_before_videos_loop_item', 'masvideos_template_loop_video_container_open', 20);
		remove_action('masvideos_before_videos_loop_item', 'masvideos_template_loop_video_poster_open', 30);
		remove_action('masvideos_before_videos_loop_item', 'masvideos_template_loop_video_link_open', 40);
		remove_action('masvideos_before_videos_loop_item', 'masvideos_template_loop_video_poster', 50);
		remove_action('masvideos_before_videos_loop_item', 'masvideos_template_loop_video_link_close', 60);
		remove_action('masvideos_before_videos_loop_item', 'masvideos_template_loop_video_poster_close', 70);
		remove_action('masvideos_before_videos_loop_item', 'masvideos_template_loop_video_container_close', 80);
		remove_action('masvideos_before_videos_loop_item_title', 'masvideos_template_loop_video_body_open', 10);
		remove_action('masvideos_before_videos_loop_item_title', 'masvideos_template_loop_video_info_open', 20);
		remove_action('masvideos_videos_loop_item_title', 'masvideos_template_loop_video_info_head_open', 10);
		remove_action('masvideos_videos_loop_item_title', 'masvideos_template_loop_video_link_open', 20);
		remove_action('masvideos_videos_loop_item_title', 'masvideos_template_loop_video_title', 30);
		remove_action('masvideos_videos_loop_item_title', 'masvideos_template_loop_video_link_close', 40);
		remove_action('masvideos_videos_loop_item_title', 'masvideos_template_loop_video_meta', 50);
		remove_action('masvideos_videos_loop_item_title', 'masvideos_template_loop_video_info_head_close', 60);
		remove_action('masvideos_after_videos_loop_item_title', 'masvideos_template_loop_video_short_desc', 10);
		remove_action('masvideos_after_videos_loop_item_title', 'masvideos_template_loop_video_actions', 20);
		remove_action('masvideos_after_videos_loop_item_title', 'masvideos_template_loop_video_info_close', 30);
		remove_action('masvideos_after_videos_loop_item', 'masvideos_template_loop_video_review_info_open', 10);
		remove_action('masvideos_after_videos_loop_item', 'masvideos_template_loop_video_viewers_count', 30);
		remove_action('masvideos_after_videos_loop_item', 'masvideos_template_loop_video_review_info_close', 40);
		remove_action('masvideos_after_videos_loop_item', 'masvideos_template_loop_video_body_close', 50);
		remove_action('masvideos_after_videos_loop', 'masvideos_videos_pagination',    20);

		/**
		 * Video Single.
		 */

		remove_action('masvideos_single_video_summary', 'masvideos_template_single_video_title', 5);
		remove_action('masvideos_single_video_summary', 'masvideos_template_single_video_meta', 10);
		remove_action('masvideos_single_video_summary', 'masvideos_template_single_video_actions_bar', 15);
		remove_action('masvideos_single_video_summary', 'masvideos_template_single_video_short_desc', 20);
		remove_action('masvideos_after_single_video_summary', 'masvideos_template_single_video_tabs', 30);
		remove_action('masvideos_after_single_video_summary', 'masvideos_template_single_video_gallery', 40);
		remove_action('masvideos_after_single_video_summary', 'masvideos_related_videos', 50);
		remove_action('masvideos_after_single_video_summary', 'masvideos_template_single_video_related_playlist_videos', 55);
		remove_action('masvideos_after_single_video_summary', 'comments_template', 60);

		// Set current user's watched history to playlist.
		remove_action('masvideos_after_single_video', 'masvideos_set_watched_video_history_to_playlist', 999);

		remove_action('masvideos_single_video_description_tab', 'masvideos_template_single_video_description', 30);
		remove_action('masvideos_single_video_description_tab', 'masvideos_display_video_attributes', 50);
		remove_action('masvideos_single_video_description_tab', 'masvideos_template_single_video_tags', 80);

		/**
		 * Video Reviews
		 *
		 * @see masvideos_video_review_display_gravatar()
		 * @see masvideos_video_review_display_rating()
		 * @see masvideos_video_review_display_meta()
		 * @see masvideos_video_review_display_comment_text()
		 */
		// remove_action('masvideos_video_review_before', 'masvideos_video_review_display_gravatar', 10);
		remove_action('masvideos_video_review_before_comment_meta', 'masvideos_video_review_display_rating', 10);
		add_action('masvideos_video_review_meta', 'masvideos_video_review_display_rating', 10);
		// remove_action('masvideos_video_review_meta', 'masvideos_video_review_display_meta', 10);
		// remove_action('masvideos_video_review_comment_text', 'masvideos_video_review_display_comment_text', 10);

		/**
		 * Movies Loop.
		 */
		remove_action('masvideos_no_movies_found', 'masvideos_no_movies_found', 10);
		remove_action('masvideos_movies_loop', 'masvideos_movies_loop_content', 20);
		remove_action('masvideos_before_movies_loop', 'masvideos_display_movie_page_title', 5);
		remove_action('masvideos_before_movies_loop', 'masvideos_movies_control_bar', 10);
		remove_action('masvideos_before_movies_loop_item', 'masvideos_template_loop_movie_feature_badge', 5);
		remove_action('masvideos_before_movies_loop_item', 'masvideos_template_loop_movie_poster_open', 10);
		remove_action('masvideos_before_movies_loop_item', 'masvideos_template_loop_movie_link_open', 20);
		remove_action('masvideos_before_movies_loop_item', 'masvideos_template_loop_movie_poster', 30);
		remove_action('masvideos_before_movies_loop_item', 'masvideos_template_loop_movie_link_close', 40);
		remove_action('masvideos_before_movies_loop_item', 'masvideos_template_loop_movie_poster_close', 50);
		remove_action('masvideos_before_movies_loop_item_title', 'masvideos_template_loop_movie_body_open', 10);
		remove_action('masvideos_before_movies_loop_item_title', 'masvideos_template_loop_movie_info_open', 20);
		remove_action('masvideos_movies_loop_item_title', 'masvideos_template_loop_movie_info_head_open', 10);
		remove_action('masvideos_movies_loop_item_title', 'masvideos_template_single_movie_meta', 20);
		remove_action('masvideos_movies_loop_item_title', 'masvideos_template_loop_movie_link_open', 30);
		remove_action('masvideos_movies_loop_item_title', 'masvideos_template_loop_movie_title', 40);
		remove_action('masvideos_movies_loop_item_title', 'masvideos_template_loop_movie_link_close', 50);
		remove_action('masvideos_movies_loop_item_title', 'masvideos_template_loop_movie_info_head_close', 60);
		remove_action('masvideos_after_movies_loop_item_title', 'masvideos_template_loop_movie_short_desc', 10);
		remove_action('masvideos_after_movies_loop_item_title', 'masvideos_template_loop_movie_actions', 20);
		remove_action('masvideos_after_movies_loop_item_title', 'masvideos_template_loop_movie_info_close', 30);
		remove_action('masvideos_after_movies_loop_item', 'masvideos_template_loop_movie_review_info_open', 10);
		remove_action('masvideos_after_movies_loop_item', 'masvideos_template_single_movie_avg_rating', 20);
		remove_action('masvideos_after_movies_loop_item', 'masvideos_template_loop_movie_viewers_count', 30);
		remove_action('masvideos_after_movies_loop_item', 'masvideos_template_loop_movie_review_info_close', 40);
		remove_action('masvideos_after_movies_loop_item', 'masvideos_template_loop_movie_body_close', 50);

		/**
		 * Movie Single.
		 */
		remove_action('masvideos_before_single_movie_summary', 'masvideos_template_single_movie_summary_open', 100);
		remove_action('masvideos_single_movie_summary', 'masvideos_template_single_movie_title', 5);
		remove_action('masvideos_single_movie_summary', 'masvideos_template_single_movie_meta', 20);
		remove_action('masvideos_single_movie_summary', 'masvideos_template_single_movie_short_desc', 25);
		remove_action('masvideos_single_movie_summary', 'masvideos_template_single_movie_rating_with_playlist_wrap_open', 30);
		remove_action('masvideos_single_movie_summary', 'masvideos_template_single_movie_avg_rating', 40);
		remove_action('masvideos_single_movie_summary', 'masvideos_template_button_movie_playlist', 45);
		remove_action('masvideos_single_movie_summary', 'masvideos_template_single_movie_rating_with_playlist_wrap_close', 50);
		remove_action('masvideos_after_single_movie_summary', 'masvideos_template_single_movie_summary_close', 10);
		remove_action('masvideos_after_single_movie_summary', 'masvideos_related_movies', 20);
		remove_action('masvideos_after_single_movie_summary', 'masvideos_template_single_movie_tabs', 30);
		remove_action('masvideos_after_single_movie_summary', 'masvideos_template_single_movie_cast_crew_tabs', 30);
		remove_action('masvideos_after_single_movie_summary', 'masvideos_template_single_movie_gallery', 30);

		remove_action('masvideos_after_single_movie_summary', 'masvideos_recommended_movies', 30);
		remove_action('masvideos_after_single_movie_summary', 'masvideos_movie_related_videos', 30);

		remove_action('masvideos_single_movie_meta', 'masvideos_template_single_movie_release_year', 10);
		remove_action('masvideos_single_movie_meta', 'masvideos_template_single_movie_genres', 20);

		remove_action('masvideos_single_movie_description_tab', 'masvideos_template_single_movie_description', 130);
		remove_action('masvideos_single_movie_description_tab', 'masvideos_display_movie_attributes', 180);
		remove_action('masvideos_single_movie_description_tab', 'masvideos_template_single_movie_tags', 190);

		// Set current user's watched history to playlist.
		remove_action('masvideos_after_single_movie', 'masvideos_set_watched_movie_history_to_playlist', 999);
		/**
		 * Movie Reviews
		 *
		 * @see masvideos_movie_review_display_gravatar()
		 * @see masvideos_movie_review_display_rating()
		 * @see masvideos_movie_review_display_meta()
		 * @see masvideos_movie_review_display_comment_text()
		 */
		// remove_action('masvideos_movie_review_before', 'masvideos_movie_review_display_gravatar', 10);
		remove_action('masvideos_movie_review_before_comment_meta', 'masvideos_movie_review_display_rating', 10);
		add_action('masvideos_movie_review_meta', 'masvideos_movie_review_display_rating', 10);

		// remove_action('masvideos_movie_review_meta', 'masvideos_movie_review_display_meta', 10);
		// remove_action('masvideos_movie_review_comment_text', 'masvideos_movie_review_display_comment_text', 10);

		/**
		 * Movie Playlists Loop.
		 */
		remove_action('masvideos_before_movie_playlists_loop_item', 'masvideos_template_loop_movie_playlist_link_open', 10);
		remove_action('masvideos_movie_playlists_loop_item_title', 'masvideos_template_loop_movie_playlist_title', 10);
		remove_action('masvideos_after_movie_playlists_loop_item_title', 'masvideos_template_loop_movie_playlist_poster_open', 10);
		remove_action('masvideos_after_movie_playlists_loop_item_title', 'masvideos_template_loop_movie_playlist_poster', 20);
		remove_action('masvideos_after_movie_playlists_loop_item_title', 'masvideos_template_loop_movie_playlist_poster_close', 30);
		remove_action('masvideos_after_movie_playlists_loop_item_title', 'masvideos_template_loop_movie_playlist_info_open', 40);
		remove_action('masvideos_after_movie_playlists_loop_item_title', 'masvideos_template_loop_movie_playlist_author', 50);
		remove_action('masvideos_after_movie_playlists_loop_item_title', 'masvideos_template_loop_movie_playlist_meta', 60);
		remove_action('masvideos_after_movie_playlists_loop_item_title', 'masvideos_template_loop_movie_playlist_info_close', 70);
		remove_action('masvideos_after_movie_playlists_loop_item', 'masvideos_template_loop_movie_playlist_link_close', 10);

		remove_action('masvideos_template_loop_movie_playlist_meta', 'masvideos_template_loop_movie_playlist_movies_count', 10);

		/**
		 * Videos Playlists Loop.
		 */
		remove_action('masvideos_before_video_playlists_loop_item', 'masvideos_template_loop_video_playlist_link_open', 10);
		remove_action('masvideos_video_playlists_loop_item_title', 'masvideos_template_loop_video_playlist_title', 10);
		remove_action('masvideos_after_video_playlists_loop_item_title', 'masvideos_template_loop_video_playlist_poster_open', 10);
		remove_action('masvideos_after_video_playlists_loop_item_title', 'masvideos_template_loop_video_playlist_poster', 20);
		remove_action('masvideos_after_video_playlists_loop_item_title', 'masvideos_template_loop_video_playlist_poster_close', 30);
		remove_action('masvideos_after_video_playlists_loop_item_title', 'masvideos_template_loop_video_playlist_info_open', 40);
		remove_action('masvideos_after_video_playlists_loop_item_title', 'masvideos_template_loop_video_playlist_author', 50);
		remove_action('masvideos_after_video_playlists_loop_item_title', 'masvideos_template_loop_video_playlist_meta', 60);
		remove_action('masvideos_after_video_playlists_loop_item_title', 'masvideos_template_loop_video_playlist_info_close', 70);
		remove_action('masvideos_after_video_playlists_loop_item', 'masvideos_template_loop_video_playlist_link_close', 10);

		remove_action('masvideos_template_loop_video_playlist_meta', 'masvideos_template_loop_video_playlist_videos_count', 10);

		/**
		 * TV Show Playlists Loop.
		 */
		remove_action('masvideos_before_tv_show_playlists_loop_item', 'masvideos_template_loop_tv_show_playlist_link_open', 10);
		remove_action('masvideos_tv_show_playlists_loop_item_title', 'masvideos_template_loop_tv_show_playlist_title', 10);
		remove_action('masvideos_after_tv_show_playlists_loop_item_title', 'masvideos_template_loop_tv_show_playlist_poster_open', 10);
		remove_action('masvideos_after_tv_show_playlists_loop_item_title', 'masvideos_template_loop_tv_show_playlist_poster', 20);
		remove_action('masvideos_after_tv_show_playlists_loop_item_title', 'masvideos_template_loop_tv_show_playlist_poster_close', 30);
		remove_action('masvideos_after_tv_show_playlists_loop_item_title', 'masvideos_template_loop_tv_show_playlist_info_open', 40);
		remove_action('masvideos_after_tv_show_playlists_loop_item_title', 'masvideos_template_loop_tv_show_playlist_author', 50);
		remove_action('masvideos_after_tv_show_playlists_loop_item_title', 'masvideos_template_loop_tv_show_playlist_meta', 60);
		remove_action('masvideos_after_tv_show_playlists_loop_item_title', 'masvideos_template_loop_tv_show_playlist_info_close', 70);
		remove_action('masvideos_after_tv_show_playlists_loop_item', 'masvideos_template_loop_tv_show_playlist_link_close', 10);

		remove_action('masvideos_template_loop_tv_show_playlist_meta', 'masvideos_template_loop_tv_show_playlist_tv_shows_count', 10);

		/**
		 * TV Show Playlists Single.
		 */
		remove_action('masvideos_single_tv_show_playlist_summary', 'masvideos_template_single_tv_show_playlist_title', 10);
		remove_action('masvideos_single_tv_show_playlist_summary', 'masvideos_template_single_tv_show_playlist_tv_shows', 20);

		/**
		 * Video Playlists Single.
		 */
		remove_action('masvideos_single_video_playlist_summary', 'masvideos_template_single_video_playlist_title', 10);
		remove_action('masvideos_single_video_playlist_summary', 'masvideos_template_single_video_playlist_videos', 20);


		/**
		 * Movie Playlists Single.
		 */
		remove_action('masvideos_single_movie_playlist_summary', 'masvideos_template_single_movie_playlist_title', 10);
		remove_action('masvideos_single_movie_playlist_summary', 'masvideos_template_single_movie_playlist_movies', 20);


		/** 
		 * Remove attribute options 
		 * */
		add_filter('masvideos_movie_data_tabs', function ($tabs) {
			unset($tabs['attribute']);
			return $tabs;
		});
		add_filter('masvideos_episode_data_tabs', function ($tabs) {
			unset($tabs['attribute']);
			return $tabs;
		});
		add_filter('masvideos_person_data_tabs', function ($tabs) {
			unset($tabs['attribute']);
			return $tabs;
		});
		add_filter('masvideos_tv_show_data_tabs', function ($tabs) {
			unset($tabs['attribute']);
			return $tabs;
		});
		add_filter('masvideos_video_data_tabs', function ($tabs) {
			unset($tabs['attribute']);
			return $tabs;
		});

		/**
		 * Footer.
		 *
		 * @see  masvideos_print_js()
		 */
		add_action('wp_footer', 'masvideos_print_js', 25);

		// Remove Genres And Tag Tamplate
		add_action('template_redirect', function () {
			if (get_post_type(get_the_ID()) != "tv_show" || !is_singular()) {
				remove_action('template_include', array('MasVideos_Template_Loader', 'template_loader'));
			}
		});
	}
}
