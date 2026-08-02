<div class="project-item project-style-1">
    <div class="project-post-thumbnail">
        <?php if (has_post_thumbnail()) : ?>
            <?php the_post_thumbnail('full'); ?>
        <?php endif; ?>
    </div><!-- .post-thumbnail -->
    <div class="project-content">
        <h4 class="project-title delta"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
        <div class="project-bottom">
            <div class="project-excerpt"><?php echo get_the_excerpt(); ?></div>
            <div class="project-button-wrapper">
                <a class="project-button" href="<?php the_permalink() ?>">
                    <i class="extice-icon-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
</div>
