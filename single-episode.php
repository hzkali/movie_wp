<?php

/**
 * The Template for displaying all single tv shows
 *
 * This template can be overridden by copying it to yourtheme/masvideos/single-tv-show.php.
 *
 * HOWEVER, on occasion MasVideos will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @package MasVideos/Templates
 * @version 1.0.0
 */

namespace Streamit\Utility;

use  Streamit\Utility\Common\Component as CommonClass;

defined('ABSPATH') || exit;

get_header();

if (function_exists('set_post_view')) {
   set_post_view();
}
$meta = get_post_meta(get_the_ID());
global $streamit_options;
$ep_imdb_rating = $meta['name_custom_imdb_rating'];
$trailer_link = function_exists('get_field') ? get_field('name_trailer_link', get_the_ID()) : '';
$imdb_rating = 0;
$is_restricted = (function_exists('pms_is_post_restricted') && pms_is_post_restricted(get_the_ID())) || !class_exists('Paid_Member_Subscriptions');

if (isset($ep_imdb_rating[0])) {
   $imdb_rating = $ep_imdb_rating[0];
   if ($streamit_options['streamit_imdb_display_rating'] === 'yes') {
      if ($streamit_options['streamit_display_single_star'] === 'no') {
         $imdb_rating = $imdb_rating;
      }
   } else {
      $imdb_rating = floatval($imdb_rating) / 2;
   }
}

$episod_data = get_post_meta(get_the_ID(), '_tv_show_id');
user_post_view_count($episod_data);
$season_id =  $meta['_tv_show_season_id'][0];
$season_data = get_post_meta($episod_data[0], '_seasons');
$season_data = !empty($season_data[0][$season_id]) ? $season_data[0][$season_id] : 0;
?>
<div id="primary" class="content-area">
   <main id="main" class="site-main">
      <?php if (!is_page_template('streamit-full-width.php')) { ?>
         <div class="container-fluid">
         <?php } ?>
         <div class="w-100">
            <div class="video-container iq-main-slider">
               <?php while (have_posts()) : the_post();
                  masvideos_get_template_part('content', 'single-episode');
               endwhile; // End of the loop.
               wp_reset_postdata();
               ?>
            </div>
         </div>

         <!-- Banner End -->
         <!-- MainContent -->
         <div class="main-content pt-5">
            <section class="p-0">
               <div class="row">
                  <div class="col-lg-12">
                     <div class="trending-info season-info pt-0 pb-4 mt-0">
                        <?php while (have_posts()) : the_post(); ?>
                           <div class="row">
                              <div class="col-md-9 col-12 mb-auto">
                                 <div class="d-md-flex single-details">

                                    <h3 class="trending-text big-title text-uppercase mt-0"><?php echo get_the_title(); ?></h3>

                                    <?php if (isset($ep_imdb_rating[0]) && !empty($ep_imdb_rating[0])) { ?>
                                       <div class="slider-ratting d-flex align-items-center ml-md-3 ml-0" data-animation-in="fadeInLeft">
                                          <ul class="ratting-start p-0 m-0 list-inline text-primary d-flex align-items-center justify-content-left">
                                             <?php
                                             if (isset($streamit_options['streamit_imdb_display_rating']) && $streamit_options['streamit_imdb_display_rating'] == 'yes' && $streamit_options['streamit_display_single_star'] == 'yes') {
                                             ?>
                                                <li>
                                                   <i class="fas fa-star" aria-hidden="true"></i>
                                                </li>
                                                <?php
                                             } else {
                                                for ($i = 1; $i <= ceil($imdb_rating); $i++) {
                                                   if (($imdb_rating - floor($imdb_rating)) > 0 && $i == ceil($imdb_rating)) {
                                                ?>
                                                      <li>
                                                         <i class="fas fa-star-half" aria-hidden="true"></i>
                                                      </li>
                                                   <?php
                                                      continue;
                                                   }
                                                   ?>
                                                   <li>
                                                      <i class="fas fa-star" aria-hidden="true"></i>
                                                   </li>
                                             <?php
                                                }
                                             }
                                             ?>
                                          </ul>
                                          <span class="text-white ml-2"><?php echo esc_html(round($imdb_rating, 1) . __('(Imdb)', 'streamit')); ?></span>
                                       </div>
                                    <?php } ?>
                                 </div>
                                 <div class="d-flex flex-wrap align-items-center text-white text-detail episode-name mb-4 mt-3 flex-wrap">
                                    <span><?php echo esc_html($meta['_episode_number'][0]); ?></span>
                                    <span class="trending-year"><?php the_title(); ?></span>


                                    <?php
                                    if (isset($streamit_options['streamit_show_viewcounter']) && $streamit_options['streamit_show_viewcounter'] == 'yes') {
                                    ?>
                                       <span class="trending-year single-view-count">
                                          <?php
                                          if (function_exists('set_post_view')) {
                                          ?>
                                             <i class="fas fa-eye"></i>
                                          <?php if (get_post_view() == 0) {
                                                echo esc_html__('0 views', 'streamit');
                                             } else {
                                                echo get_post_view();
                                             };
                                          }
                                          ?>
                                       </span>

                                    <?php
                                    }
                                    ?>
                                 </div>

                                 <ul class="list-inline p-0 m-0 share-icons music-play-lists single-share-icon">
                                    <?php if (isset($streamit_options['streamit_display_social_icons'])) {
                                       if ($streamit_options['streamit_display_social_icons'] == 'yes') {
                                    ?>
                                          <li class="share">
                                             <span><i class="ri-share-fill"></i></span>
                                             <div class="share-wrapper">
                                                <div class="share-box">
                                                   <svg width="15" height="40" viewBox="0 0 15 40" class="share-shape" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                      <path fill-rule="evenodd" clip-rule="evenodd" d="M14.8842 40C6.82983 37.2868 1 29.3582 1 20C1 10.6418 6.82983 2.71323 14.8842 0H0V40H14.8842Z" fill="#191919" />
                                                   </svg>
                                                   <div class="d-flex align-items-center justify-content-center">
                                                      <a href="https://www.facebook.com/sharer?u=<?php the_permalink(); ?>" target="_blank" rel="noopener noreferrer" class="share-ico"><i class="ri-facebook-fill"></i></a>
                                                      <a href="http://twitter.com/intent/tweet?text=<?php the_title(); ?>&url=<?php echo get_the_permalink(); ?>" target="_blank" rel="noopener noreferrer" class="share-ico"><i class="ri-twitter-fill"></i></a>
                                                      <a href="#" data-link='<?php the_permalink(); ?>' class="share-ico iq-copy-link"><i class="ri-links-fill"></i></a>
                                                   </div>
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
                                             <a class="watch-list" rel="<?php echo get_the_ID(); ?>">
                                                <?php
                                                echo add_to_watchlist(get_the_ID());
                                                ?>
                                             </a>
                                          <?php } ?>
                                       </li>
                                    <?php }
                                    $id = get_queried_object_id();
                                    $show_download_btn = (get_post_meta($id, 'download_btn', true) == 'link' && !empty(get_post_meta($id, 'dwn_link', true))) ||  (get_post_meta($id, 'download_btn', true) == 'upload' && !empty(get_post_meta($id, 'upload_item', true)));
                                    if (isset($streamit_options) && $streamit_options['streamit_display_download'] == 'yes' && in_array(get_post_type(), $streamit_options['streamit_display_download_on_item']) && $show_download_btn) {
                                    ?>
                                       <li class="download-icon">
                                          <?php
                                          if ($is_restricted) {
                                          ?>
                                             <div class="restrict-box">
                                                <p>
                                                   <?php

                                                   CommonClass::streamit_get_restricted_content(get_the_ID());
                                                   ?>

                                                </p>

                                             </div>
                                          <?php
                                          }
                                          if ($is_restricted) {
                                          ?>
                                             <button type="submit" class="iq-like-btn">
                                                <i class="fas fa-download"></i>
                                             </button>
                                          <?php

                                          } else {
                                          ?>
                                             <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')) ?>">
                                                <input type="hidden" name="action" value="streamit_download">
                                                <input type="hidden" name="download" value="<?php echo base64_encode(get_the_ID()) ?>">
                                                <button type="submit" class="iq-like-btn">
                                                   <i class="fas fa-download"></i>
                                                </button>
                                             </form>
                                          <?php
                                          }
                                          ?>

                                       </li>
                                    <?php
                                    }

                                    ?>
                                 </ul>
                              </div>
                              <?php if (isset($streamit_options['streamit_display_trailer_link'])) {
                                 if ($streamit_options['streamit_display_trailer_link'] == 'yes') {
                                    if (in_array('episode', $streamit_options['streamit_opt_multi_select'])) {
                                       if ($streamit_options['streamit_display_trailer_link_btn'] == 'no') {
                                          $trailer_img = function_exists('get_field') ? get_field('name_trailer_img', get_the_ID()) : '';
                                          if (empty($trailer_img) && !has_post_thumbnail()) {
                                             $align = ' mt-0 trailer-play-btn ';
                                          } else {
                                             $align =  ' mt-4 ';
                                          }
                                       } else {
                                          $align =  ' mt-0 trailer-play-btn ';
                                       } ?>
                                       <div class="trailor-video col-md-3 col-12 mt-md-0 <?php echo esc_attr($align); ?> mb-md-0 mb-1 text-right">
                                          <?php
                                          streamit()->streamit_video_playbtn($streamit_options, $trailer_link, $trailer_img);
                                          ?>
                                       </div>
                              <?php }
                                 }
                              } ?>
                           </div>
                        <?php
                        endwhile; // End of the loop.
                        wp_reset_postdata();
                        ?>
                     </div>
                     <?php


                     ?>
                     <div class="streamit-content-details trending-info g-border">
                        <?php
                        $tab_uniqid = 'tab-' . uniqid();
                        global $episode;
                        ?>
                        <ul class="trending-pills-header d-flex nav nav-pills align-items-center text-center s-margin mb-5 justify-content-center" role="tablist">
                           <?php if (!empty(get_the_content())) { ?>
                              <li class="nav-item">
                                 <a class="nav-link active show" data-toggle="pill" href="#<?php echo esc_attr($tab_uniqid); ?>description" role="tab" aria-selected="true"><?php echo esc_html__('Description', 'streamit'); ?></a>
                              </li>
                           <?php } ?>

                           <?php if (isset($streamit_options['streamit_episode_display_rating'])) {
                              if ($streamit_options['streamit_episode_display_rating'] == 'yes') {
                           ?>
                                 <li class="nav-item">
                                    <a class="nav-link" data-toggle="pill" href="#<?php echo esc_attr($tab_uniqid); ?>review" role="tab" aria-selected="false"><?php echo esc_html__('Rate & Review', 'streamit'); ?></a>
                                 </li>

                           <?php }
                           } ?>

                           <?php
                           if (!$episode || $episode->get_sources() &&  !$is_restricted) { ?>
                              <li class="nav-item">
                                 <a class="nav-link" data-toggle="pill" href="#<?php echo esc_attr($tab_uniqid); ?>sources" role="tab" aria-selected="false"><?php echo esc_html__('Sources', 'streamit'); ?></a>
                              </li>
                           <?php } ?>
                        </ul>
                        <div class="tab-content">
                           <?php if (!empty(get_the_content())) {
                           ?>
                              <div id="<?php echo esc_attr($tab_uniqid); ?>description" class="tab-pane animated fadeInUp active show" role="tabpanel">
                                 <div class="description-content hideContent">
                                    <?php
                                    echo  get_the_content();
                                    ?>
                                 </div>
                                 <div class="show-more">
                                    <a href="javascript:void(0);" data-showmore="<?php echo esc_attr__('More...', 'streamit'); ?>" data-showless="<?php echo esc_attr__('Less...', 'streamit'); ?>"><?php echo esc_html__('More...', 'streamit'); ?></a>
                                 </div>
                              </div>
                           <?php } ?>
                           <div id="<?php echo esc_attr($tab_uniqid); ?>review" class="tab-pane animated fadeInUp" role="tabpanel">
                              <?php
                              if (comments_open() || get_comments_number()) :
                                 comments_template();
                              endif;
                              ?>
                           </div>
                           <?php
                           if (!$episode || $episode->get_sources() && !$is_restricted) { ?>
                              <div id="<?php echo esc_attr($tab_uniqid); ?>sources" class="tab-pane fade" role="tabpanel">
                                 <?php
                                 masvideos_get_template_part('single-episode-sources'); ?>
                              </div>
                           <?php } ?>
                        </div>
                     </div>

                  </div>
               </div>
            </section>
            <?php
            if (isset($streamit_options['streamit_display_latest_episode'])) {
               if ($streamit_options['streamit_display_latest_episode'] == 'yes') {
                  if (!empty($season_data['episodes'])) { ?>
                     <section id="iq-favorites">
                        <div class="block-space single-episode-space">
                           <div class="row">
                              <div class="col-sm-12 overflow-hidden">
                                 <div class="iq-main-header d-flex align-items-center justify-content-between">
                                    <h4 class="main-title">
                                       <?php if (!empty($streamit_options['streamit_latest_episodes_title'])) {
                                          echo esc_attr($streamit_options['streamit_latest_episodes_title'], 'streamit');
                                       } else {
                                          echo esc_html__('Latest Episodes', 'streamit');
                                       } ?>
                                    </h4>
                                 </div>
                              </div>
                           </div>
                           <div class="row">
                              <?php
                              foreach ($season_data['episodes'] as $epdata) {
                                 $ep_obj = get_post($epdata);
                                 $episode_number = '';
                                 $episode_run_time = '';
                                 $episode_release_date = '';

                                 $url = '';
                                 $_episode_number = get_post_meta($epdata, '_episode_number');
                                 $_episode_run_time = get_post_meta($epdata, '_episode_run_time');
                                 $_thumbnail_id = get_post_meta($epdata, '_thumbnail_id');
                                 $_featured = get_post_meta($epdata, '__featured');
                                 $_episode_release_date = get_post_meta($epdata, '_episode_release_date');



                                 if (isset($_thumbnail_id[0])) {
                                    $url = wp_get_attachment_url($_thumbnail_id[0]);
                                 }

                                 if (isset($_episode_number[0])) {
                                    $episode_number = $_episode_number[0];
                                 }
                                 if (isset($_episode_run_time[0])) {
                                    $episode_run_time = $_episode_run_time[0];
                                 }

                                 if (isset($_episode_release_date[0])) {
                                    $episode_release_date = date_i18n(get_option('date_format'), $_episode_release_date[0]);
                                 }
                              ?>
                                 <div class="col-lg-3 col-md-6 col-sm-6 iq-mb-30">
                                    <div class="epi-box">
                                       <div class="epi-img position-relative">
                                          <img src="<?php echo esc_url($url); ?>" class="img-fluid img-zoom" alt="<?php esc_attr_e('streamit', 'streamit'); ?>">
                                          <div class="episode-number"><?php echo esc_html($episode_number, 'streamit'); ?></div>
                                          <div class="episode-play-info">
                                             <div class="episode-play">
                                                <a href="<?php echo get_the_permalink($ep_obj->ID); ?>">
                                                   <i class="ri-play-fill"></i>
                                                </a>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="epi-desc p-3">
                                          <div class="d-flex align-items-center justify-content-between mb-3">
                                             <span class="text-white rel-date"><?php echo esc_html($episode_release_date, 'streamit'); ?></span>
                                             <span class="text-primary run-time"><?php echo esc_html($episode_run_time, 'streamit'); ?></span>
                                          </div>
                                          <a href="<?php echo get_the_permalink($ep_obj->ID); ?>">
                                             <h6 class="epi-name text-white mb-0">
                                                <?php echo esc_html($ep_obj->post_title, 'streamit'); ?>
                                             </h6>
                                          </a>
                                       </div>
                                    </div>
                                 </div>
                              <?php } ?>
                           </div>
                        </div>
                     </section>
            <?php }
               }
            }

            streamit()->streamit_related_prodcuct(
               get_queried_object_id(),
               $streamit_options['streamit_display_related_product'],
               $streamit_options['streamit_display_related_product_title'],
               $streamit_options['streamit_show_related']
            ); // Function Call To Get Select Related Product
            ?>
         </div>
         <?php if (!is_page_template('streamit-full-width.php')) { ?>
         </div>
      <?php } ?>
   </main>
</div>
<?php
streamit()->streamit_more_content_js();
get_footer();
