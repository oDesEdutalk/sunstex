<?php

$current_id = get_queried_object_id();
$current_class = $current_id == get_the_ID() ? 'current_post service-content' : 'service-content';
?>
<div <?php post_class($current_class); ?>>
    <h6 class="service-title">
        <a href="<?php the_permalink(); ?>"><span><?php the_title(); ?></span><i class="extice-icon-angle-right"></i></a>
    </h6>
</div>