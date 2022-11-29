<?php

/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package streamit
 */

namespace Streamit\Utility;

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if (post_password_required()) {
	return;
}


?>
<div id="comments" class="comments-area">
	<?php
	// You can start editing here -- including this comment!
	if (have_comments()) {
	?>
		<h3 class="comments-title">
			<?php
			echo esc_html(comments_number());
			?>
		</h3>
		<?php the_comments_navigation(); ?>

		<?php streamit()->the_comments(); ?>

		<?php
		if (!comments_open()) {
		?>
			<p class="no-comments"><?php esc_html_e('Comments are closed.', 'streamit'); ?></p>
	<?php
		}
	}
	$comment_btn = streamit()->streamit_get_comment_btn($tag="button", $label = 'Post Comment', $show_icon = true,$attr=array('class'=> 'btn-hover'));
	$args = array(
		'label_submit' => esc_html__('Post Comment', 'streamit'),
		'comment_notes_before' => esc_html__('Your email address will not be published. Required fields are marked *', 'streamit') . '',
		'comment_field' => '<div class="comment-form-comment">
								<textarea id="comment" name="comment" placeholder="' . esc_attr__('Comment', 'streamit') . '" required="required"></textarea>
							</div>',
		'format'            => 'xhtml',
		'fields' => array(
			'author' => '<div class="row">
							<div class="col-lg-4">
								<div class="comment-form-author">
									<input id="author" name="author" required="required" placeholder="' . esc_attr__('Name *', 'streamit') . '" />
								</div>
							</div>',
			'email' => '<div class="col-lg-4">
							<div class="comment-form-email">
								<input id="email" name="email" required="required" placeholder="' . esc_attr__('Email *', 'streamit') . '" />
							</div>
						</div>',
			'url' => 	'<div class="col-lg-4">
							<div class="comment-form-url">
								<input id="url" name="url"  placeholder="' . esc_attr__('Website', 'streamit') . '" />
							</div>
						</div>
					</div>',
			'cookies' => 	'<div class="streamit-check">
								<label>
							<input type="checkbox" required="required" /> <span class="checkmark"></span><span class="text-check">' . esc_html__("Save my name, email, and website in this browser for the next time I comment.", "streamit") . '</span>
					</label>
				</div>',
		),
		'submit_button'	=> $comment_btn,
	);
	comment_form($args);
	?>
</div><!-- #comments -->