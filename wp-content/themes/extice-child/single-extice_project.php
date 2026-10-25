<?php
/**
 * The template for displaying all single project posts.
 * Fully compatible with Elementor builder and matches services/qua-tang-may-mac/.
 */

get_header();
?>
<div id="primary" class="content-area">
	<main id="main" class="site-main">
		<?php
		while ( have_posts() ) :
			the_post();
			the_content();
		endwhile;
		?>
	</main>
</div>
<?php
get_footer();
