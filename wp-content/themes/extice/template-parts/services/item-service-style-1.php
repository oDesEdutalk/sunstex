<div class="service-content">
    <?php
    $icon_url = get_post_meta(get_the_ID(), 'services_icon_class', true);
    if ($icon_url && !empty($icon_url)) {
        echo '<div class="icon-wrap"><img class="service-icon" src="' . esc_url($icon_url) . '" alt="service icon"></div>';
    }
    ?>
    <h4 class="service-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
    <div class="description"><?php the_excerpt(); ?></div>
    <div class="service-button-wrap">
        <a class="service-button" href="<?php the_permalink() ?>">
            <span><?php echo esc_html__('Read More', 'extice'); ?></span>
            <i class="extice-icon-arrow-right"></i>
        </a>
    </div>
</div>

