<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php
	/**
	 * Functions hooked in to extice_page action
	 *
	 * @see extice_page_header          - 10
	 * @see extice_page_content         - 20
	 *
	 */
	do_action( 'extice_page' );
	?>
</article><!-- #post-## -->
