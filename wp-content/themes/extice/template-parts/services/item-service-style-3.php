<div class="service-content">
    <div class="service-post-thumbnail">
        <div class="service-post-thumbnail-inner">
            <?php if (has_post_thumbnail()) : ?>
                <?php the_post_thumbnail('large'); ?>
            <?php endif; ?>
        </div>
    </div><!-- .post-thumbnail -->
    <div class="service-head">
        <?php
        $icon_url = get_post_meta(get_the_ID(), 'services_icon_class', true);
        if ($icon_url && !empty($icon_url)) {
            echo '<div class="icon-wrap"><img class="service-icon" src="' . esc_url($icon_url) . '" alt="service icon"></div>';
        }
        ?>
        <h4 class="service-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
    </div>
    <div class="description"><?php the_excerpt(); ?></div>
</div>

