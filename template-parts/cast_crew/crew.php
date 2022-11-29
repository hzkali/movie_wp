<?php

/**
 * Template part for displaying the Cast 
 *
 * @package streamit
 */

namespace Streamit\Utility;

$person = masvideos_get_person($args['cast']['id']);
if (!($person && is_a($person, 'MasVideos_Person'))) return;

$term = get_term($args['cast']['category']);
?>


<div class="cast-images position-relative">
    <div class="col-sm-4 col-12 img-box p-0">
        <?php echo masvideos_get_person_thumbnail('thumbnail', $person); ?>
    </div>
    <div class="col-sm-8 col-12 block-description">
        <h6 class="iq-title">
            <a href="<?php the_permalink($person->get_ID()); ?>">
                <?php echo esc_html($person->get_name()); ?>
            </a>
        </h6>
        <?php
        if (!empty($args['cast']['job'])) : ?>
            <div class="movie-time d-flex align-items-center my-2">
                <span class="text-white">
                    <?php echo esc_html_e(!is_wp_error($term) ? $term->name : __('Unknown', 'streamit')); ?>
                </span>
            </div>
        <?php endif; ?>

    </div>
</div>