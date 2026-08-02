<div class="post-inner blog-grid">
    <?php extice_post_thumbnail('large',$show_cat = true); ?>
    <div class="post-content">
        <div class="entry-meta">
            <?php extice_post_meta(['show_author' => true, 'show_cat' => false, 'show_date' => true, 'show_comment' => false]); ?>
        </div>
        <?php
        the_title('<h3 class="delta entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h3>');
        ?>
        <div class="more-link-wrap">
            <?php echo '<a class="more-link" href="' . get_permalink() . '"> <span>' . esc_html__('Read More', 'extice') . '</span><i class="extice-icon-arrow-right"></i></a>'; ?>
        </div>
    </div>
</div>