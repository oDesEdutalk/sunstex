<div class="project-item project-style-1 service-item service-style-1">
    <div class="service-content">
        <?php
        $thumb_id = get_post_thumbnail_id(get_the_ID());
        $icon_url = get_post_meta(get_the_ID(), 'services_icon_class', true);
        if (!$icon_url && $thumb_id) {
            $icon_url = wp_get_attachment_url($thumb_id);
        }
        if ($icon_url && !empty($icon_url)) {
            echo '<div class="icon-wrap"><img class="service-icon project-logo" src="' . esc_url($icon_url) . '" alt="' . esc_attr(get_the_title()) . '"></div>';
        }
        ?>
        <h4 class="service-title project-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
        <div class="description project-excerpt"><?php the_excerpt(); ?></div>
        <div class="service-button-wrap project-button-wrap">
            <a class="service-button" href="<?php the_permalink(); ?>">
                <span><?php echo esc_html__('Đọc thêm', 'extice'); ?></span>
                <i class="extice-icon-arrow-right"></i>
            </a>
        </div>
    </div>
</div>
