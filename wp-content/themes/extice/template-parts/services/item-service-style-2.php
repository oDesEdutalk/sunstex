<div class="service-content">
    <div class="service-head">
        <h4 class="service-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
        <?php
        $icon_url = get_post_meta(get_the_ID(), 'services_icon_class', true);
        if ($icon_url && !empty($icon_url)) {
            echo '<div class="icon-wrap"><img class="service-icon" src="' . esc_url($icon_url) . '" alt="service icon"></div>';
        }
        ?>
    </div>
    <div class="description"><?php the_excerpt(); ?></div>
    <div class="service-post-thumbnail">
        <?php if (has_post_thumbnail()) : ?>
            <?php the_post_thumbnail('large'); ?>
        <?php endif; ?>
    </div><!-- .post-thumbnail -->
</div>

