<?php
if ((bool)get_the_author_meta('description')) :
    ?>
    <div class="author-wrapper">
        <div class="author-avatar">
            <img src="<?php echo esc_url(get_avatar_url(get_the_author_meta('ID'))); ?>"/>
        </div>
        <div class="author-caption">
            <?php
            printf('<h6 class="author-name"><a class="author-link" href="%s" rel="author">%s</a></h6>', esc_url(get_author_posts_url(get_the_author_meta('ID'))), get_the_author())
            ?>
            <div class="author-description">
                <?php the_author_meta('description'); ?>
            </div>
        </div>
    </div>
<?php endif; ?>