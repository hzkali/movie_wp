<?php

/**
 * Template part for displaying a post's page
 *
 * @package streamit
 */

namespace Streamit\Utility;

$persons = masvideos_get_person(get_the_ID());
$terms = get_the_terms(get_the_ID(), 'person_cat');
if(wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID() ))==false){
    return false;
}
?>
<article id="post-<?php the_ID(); ?>" class="col-xl-2 col-lg-3 col-md-3 col-sm-4 col-6 iq-persons px-2 ">
    <div class=" position-relative">
        <div class="cast-images position-relative d-flex">
            <?php $full_image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), "medium_large"); ?>
            <img src="<?php echo esc_url($full_image[0]) ?>" class="img-fluid" alt="image">
        </div>
        <div class="iq-cast-body">
            <div class="iq-person-heading">
                <h6 class="iq-title">
                    <a href="<?php the_permalink(get_the_ID()); ?>">
                        <?php echo esc_html(the_title(), 'streamit'); ?>
                    </a>
                </h6>
                <div class="iq-person-cats">
                    <?php
                    for ($i = 0; $i < 2 && isset($terms[$i]); $i++) {

                        echo "<span class='iq-person-cat-item'>";
                        echo esc_html($terms[$i]->name);
                        echo "</span>";
                    }
                    ?>
                </div>

            </div>
        </div>

    </div>
</article>