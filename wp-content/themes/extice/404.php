<?php
get_header(); ?>

    <div id="primary" class="content">
        <main id="main" class="site-main">
            <div class="error-404 not-found">
                <div class="content-404">
                    <div class="page-content">
                        <img src="<?php echo get_theme_file_uri('assets/images/404/404-img.png'); ?>"
                             alt="<?php echo esc_attr__('404 Page', 'extice'); ?>">
                        <h2 class="error-header"><?php esc_html_e('Oops! This Page is Not Found.', 'extice') ?></h2>
                        <span class="error-text"><?php echo esc_html__('We searched everywhere but couldn\'t find what you\'re looking for.', 'extice') . '<br>' . esc_html__('Let\'s find a better place for you to go.', 'extice'); ?></span>
                        <div class="error-button button-icon-rotate-yes">
                            <a href="javascript: history.go(-1)" class="elementor-button">
                                <span class="elementor-button-content-wrapper">
                                    <span class="elementor-button-text">back to home</span>
                                        <span class="elementor-button-icon">
				                            <i aria-hidden="true" class="extice-icon-arrow-right"></i>
                                        </span>
                                </span>
                            </a>
                        </div>
                    </div>
                </div><!-- .page-content -->
            </div><!-- .error-404 -->
        </main><!-- #main -->
    </div><!-- #primary -->
<?php

get_footer();
