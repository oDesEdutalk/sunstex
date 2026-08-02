<article id="post-<?php the_ID(); ?>" <?php post_class('article-default'); ?>>
    <div class="post-inner">
        <?php extice_post_thumbnail('post-thumbnail'); ?>
        <div class="post-content">
            <?php
            /**
             * Functions hooked in to extice_loop_post action.
             *
             * @see extice_post_header          - 15
             * @see extice_post_content         - 30
             */
            do_action('extice_loop_post');
            ?>
        </div>
    </div>
</article><!-- #post-## -->