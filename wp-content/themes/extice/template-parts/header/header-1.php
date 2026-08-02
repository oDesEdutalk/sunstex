<header id="masthead" class="site-header header-1" role="banner">
    <div class="header-container">
        <div class="header-main">
            <div class="header-left">
                <?php
                extice_site_branding();
                if (extice_is_woocommerce_activated()) {
                    ?>
                    <div class="site-header-cart header-cart-mobile">
                        <?php extice_cart_link(); ?>
                    </div>
                    <?php
                }
                ?>
                <?php extice_mobile_nav_button(); ?>
            </div>
            <div class="header-center">
                <?php extice_primary_navigation(); ?>
            </div>
            <div class="header-right desktop-hide-down">
                <div class="header-group-action">
                    <?php
                    extice_header_account();
                    if (extice_is_woocommerce_activated()) {
                        extice_header_cart();
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</header><!-- #masthead -->
