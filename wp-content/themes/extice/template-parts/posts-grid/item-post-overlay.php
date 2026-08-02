<div class="post-inner blog-overlay <?php echo has_post_thumbnail() ? '' : esc_attr('no-thumbnail'); ?>">
    <?php extice_post_thumbnail('extice-post-grid', true); ?>
    <div class="post-content">
        <div class="post-content-inner">
        <div class="entry-meta">
            <?php extice_post_meta(['show_author' => true, 'show_cat' => false, 'show_date' => true, 'show_comment' => false]); ?>
        </div>
        <?php
        the_title('<h3 class="delta entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h3>');
        ?>

        </div>
    </div>
</div>