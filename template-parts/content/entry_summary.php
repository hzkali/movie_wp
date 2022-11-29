<?php

/**
 * Template part for displaying a post's summary
 *
 * @package streamit
 */

namespace Streamit\Utility;
?>

<div class="blog-content">
<?php
	if (!empty(get_the_excerpt()) && ord(get_the_excerpt()) !== 38) {
		the_excerpt();
	}
	?>
</div><!-- .entry-summary -->