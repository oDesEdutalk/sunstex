<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="single-content">
        <?php
        /**
         * Functions hooked in to extice_single_post_top action
         *
         *
         * @see extice_post_header         - 5
         * @see extice_post_thumbnail        - 10
         */
        do_action('extice_single_post_top');

        /**
         * Functions hooked in to extice_single_post action
         * @see extice_post_content        - 30
         */
        do_action('extice_single_post');

        /**
         * Functions hooked in to extice_single_post_bottom action
         *
         *
         * @see extice_post_taxonomy      - 5
         * @see extice_post_nav            - 15
         *  @see extice_single_author      - 16
         * @see  extice_display_comments    - 20
         */
        do_action('extice_single_post_bottom');
        ?>

    </div>

</article><!-- #post-## -->
