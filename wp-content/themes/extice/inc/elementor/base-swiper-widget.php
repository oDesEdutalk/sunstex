<?php
use Elementor\Widget_Base;


if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

abstract class Extice_Base_Widgets_Swiper extends Widget_Base
{
    use Extice_Swiper_Functions_Trait;
}