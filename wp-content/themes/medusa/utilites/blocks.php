<?php      
   self::register_block('heading', array(
            'title' => __('Heading'),
            'description' => __('A custom heading block.'),
            'category' => 'formatting',
            'icon' => 'heading',
            'keywords' => array('heading', 'title'),
        ));

        self::register_block('paragraph', array(
            'title' => __('Paragraph'),
            'description' => __('A custom paragraph block.'),
            'category' => 'formatting',
            'icon' => 'editor-paragraph',
            'keywords' => array('paragraph', 'text'),
        ));

        self::register_block('image', array(
            'title' => __('Image'),
            'description' => __('A custom image block.'),
            'category' => 'media',
            'icon' => 'format-image',
            'keywords' => array('image', 'photo', 'picture'),
        ));

        self::register_block('button', array(
            'title' => __('Button'),
            'description' => __('A custom button block.'),
            'category' => 'widgets',
            'icon' => 'button',
            'keywords' => array('button', 'link'),
        ));
         self::register_block('google-map', array(
            'title' => __('Google Map'),
            'description' => __('A custom Google Map block.'),
            'category' => 'formatting',
            'icon' => 'location-alt',
            'keywords' => array('google', 'map', 'location'),
            'enqueue_assets' => function() {
                wp_enqueue_script('google-maps-api', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyDfF_Q_pG8i9k9zK8DFosXzdZd5hCo20f8', null, null, true);
            },
        ));
        self::register_block('image-carousel', array(
            'title' => __('Image Carousel'),
            'description' => __('A custom image carousel block using Slick slider.'),
            'category' => 'media',
            'icon' => 'format-gallery',
            'keywords' => array('image', 'carousel', 'slider'),
            'enqueue_assets' => function() {
                // Enqueue Slick slider CSS and JS
                wp_enqueue_style('slick-css', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css');
                wp_enqueue_style('slick-theme-css', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css');
                wp_enqueue_script('slick-js', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js', array('jquery'), null, true);
                
            },
        ));
        self::register_block('slider', array(
            'title' => __('Slider'),
            'description' => __('A custom slider block using Slick slider.'),
            'category' => 'media',
            'icon' => 'images-alt2',
            'keywords' => array('slider', 'carousel', 'image'),
            'enqueue_assets' => function() {
                // Enqueue Slick slider CSS and JS
                wp_enqueue_style('slick-css', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css');
                wp_enqueue_style('slick-theme-css', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css');
                wp_enqueue_script('slick-js', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js', array('jquery'), null, true);
            },
        ));