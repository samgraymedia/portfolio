<?php
use Timber\Timber;

if ( ! class_exists( 'Timber_Acf_Wp_Blocks' ) ) {
    class Timber_Acf_Wp_Blocks {
        public function __construct() {
            if ( is_callable( 'add_action' )
                && is_callable( 'acf_register_block_type' )
                && class_exists( 'Timber' )
                ) {
                add_action( 'acf/init', array( __CLASS__, 'timber_block_init' ), 10, 0 );
            } elseif ( is_callable( 'add_action' ) ) {
                add_action(
                    'admin_notices',
                    function() {
                        echo '<div class="error"><p>Timber ACF WP Blocks requires Timber and ACF.';
                        echo 'Check if the plugins or libraries are installed and activated.</p></div>';
                    }
                );
            }
        }

        public static function timber_block_init() {
            // Register the blocks
              require_once( 'blocks.php');
       
            $directories = self::timber_block_directory_getter();
            foreach ( $directories as $dir ) {
                if ( ! file_exists( \locate_template( $dir ) ) ) {
                    return;
                }
                $template_directory = new DirectoryIterator( \locate_template( $dir ) );
                foreach ( $template_directory as $template ) {
                    if ( $template->isDot() || $template->isDir() ) {
                        continue;
                    }
                    $file_parts = pathinfo( $template->getFilename() );
                    if ( 'twig' !== $file_parts['extension'] ) {
                        continue;
                    }
                    $slug = $file_parts['filename'];
                    $file_path    = locate_template( $dir . "/${slug}.twig" );
                    $file_headers = get_file_data(
                        $file_path,
                        array(
                            'title'                      => 'Title',
                            'description'                => 'Description',
                            'category'                   => 'Category',
                            'icon'                       => 'Icon',
                            'keywords'                   => 'Keywords',
                            'mode'                       => 'Mode',
                            'align'                      => 'Align',
                            'post_types'                 => 'PostTypes',
                            'supports_align'             => 'SupportsAlign',
                            'supports_align_content'     => 'SupportsAlignContent',
                            'supports_mode'              => 'SupportsMode',
                            'supports_multiple'          => 'SupportsMultiple',
                            'supports_anchor'            => 'SupportsAnchor',
                            'enqueue_style'              => 'EnqueueStyle',
                            'enqueue_script'             => 'EnqueueScript',
                            'enqueue_assets'             => 'EnqueueAssets',
                            'supports_custom_class_name' => 'SupportsCustomClassName',
                            'supports_reusable'          => 'SupportsReusable',
                            'supports_full_height'       => 'SupportsFullHeight',
                            'example'                    => 'Example',
                            'supports_jsx'               => 'SupportsJSX',
                            'parent'                     => 'Parent',
                            'default_data'               => 'DefaultData',
                        )
                    );

                    if ( empty( $file_headers['title'] ) || empty( $file_headers['category'] ) ) {
                        continue;
                    }

                    $keywords = str_getcsv( $file_headers['keywords'], ' ', '"' );
                    $data = array(
                        'name'            => $slug,
                        'title'           => $file_headers['title'],
                        'description'     => $file_headers['description'],
                        'category'        => $file_headers['category'],
                        'icon'            => $file_headers['icon'],
                        'keywords'        => $keywords,
                        'mode'            => $file_headers['mode'],
                        'align'           => $file_headers['align'],
                        'render_callback' => array( __CLASS__, 'timber_blocks_callback' ),
                        'enqueue_assets'  => $file_headers['enqueue_assets'],
                        'default_data'    => $file_headers['default_data'],
                    );

                    $data = array_filter( $data );

                    if ( ! empty( $file_headers['post_types'] ) ) {
                        $data['post_types'] = explode( ' ', $file_headers['post_types'] );
                    }

                    if ( ! empty( $file_headers['supports_align'] ) ) {
                        $data['supports']['align'] =
                            in_array( $file_headers['supports_align'], array( 'true', 'false' ), true ) ?
                            filter_var( $file_headers['supports_align'], FILTER_VALIDATE_BOOLEAN ) :
                            explode( ' ', $file_headers['supports_align'] );
                    }

                    if ( ! empty( $file_headers['supports_align_content'] ) ) {
                        $data['supports']['alignContent'] = ('true' === $file_headers['supports_align_content']) ?
                            true : (('matrix' === $file_headers['supports_align_content']) ? "matrix" : false);
                    }

                    if ( ! empty( $file_headers['supports_mode'] ) ) {
                        $data['supports']['mode'] =
                            ( 'true' === $file_headers['supports_mode'] ) ? true : false;
                    }

                    if ( ! empty( $file_headers['supports_multiple'] ) ) {
                        $data['supports']['multiple'] =
                            ( 'true' === $file_headers['supports_multiple'] ) ? true : false;
                    }

                    if ( ! empty( $file_headers['supports_anchor'] ) ) {
                        $data['supports']['anchor'] =
                            ( 'true' === $file_headers['supports_anchor'] ) ? true : false;
                    }

                    if ( ! empty( $file_headers['supports_custom_class_name'] ) ) {
                        $data['supports']['customClassName'] =
                            ( 'true' === $file_headers['supports_custom_class_name'] ) ? true : false;
                    }

                    if ( ! empty( $file_headers['supports_reusable'] ) ) {
                        $data['supports']['reusable'] =
                            ( 'true' === $file_headers['supports_reusable'] ) ? true : false;
                    }

                    if ( ! empty( $file_headers['supports_full_height'] ) ) {
                        $data['supports']['full_height'] =
                            ( 'true' === $file_headers['supports_full_height'] ) ? true : false;
                    }

                    if ( ! empty( $file_headers['enqueue_style'] ) ) {
                        if ( ! filter_var( $file_headers['enqueue_style'], FILTER_VALIDATE_URL ) ) {
                            $data['enqueue_style'] =
                                get_template_directory_uri() . '/' . $file_headers['enqueue_style'];
                        } else {
                            $data['enqueue_style'] = $file_headers['enqueue_style'];
                        }
                    }

                    if ( ! empty( $file_headers['enqueue_script'] ) ) {
                        if ( ! filter_var( $file_headers['enqueue_script'], FILTER_VALIDATE_URL ) ) {
                            $data['enqueue_script'] =
                                get_template_directory_uri() . '/' . $file_headers['enqueue_script'];
                        } else {
                            $data['enqueue_script'] = $file_headers['enqueue_script'];
                        }
                    }

                    if ( ! empty( $file_headers['supports_jsx'] ) ) {
                        $data['supports']['__experimental_jsx'] =
                            ( 'true' === $file_headers['supports_jsx'] ) ? true : false;
                        $data['supports']['jsx']                =
                            ( 'true' === $file_headers['supports_jsx'] ) ? true : false;
                    }

                    if ( ! empty( $file_headers['example'] ) ) {
                        $json                       = json_decode( $file_headers['example'], true );
                        $example_data               = ( null !== $json ) ? $json : array();
                        $example_data['is_example'] = true;
                        $data['example']            = array(
                            'attributes' => array(
                                'mode' => 'preview',
                                'data' => $example_data,
                            ),
                        );
                    }

                    if ( ! empty( $file_headers['parent'] ) ) {
                        $data['parent'] = str_getcsv( $file_headers['parent'], ' ', '"' );
                    }

                    $data = self::timber_block_default_data( $data );

                    acf_register_block_type( $data );
                }
            }
        }

        public static function register_block($name, $settings) {
            $settings['render_callback'] = array(__CLASS__, 'timber_blocks_callback');
            acf_register_block_type(array_merge(array(
                'name' => $name,
            ), $settings));
        }

        public static function timber_blocks_callback($block, $content = '', $is_preview = false, $post_id = 0) {
            if (method_exists('Timber', 'context')) {
                $context = Timber::context();
            } else {
                $context = Timber::get_context();
            }

            $slug = str_replace('acf/', '', $block['name']);
            $context['block'] = $block;
            $context['post_id'] = $post_id;
            $context['slug'] = $slug;
            $context['is_preview'] = $is_preview;
            $context['fields'] = get_fields();
            $classes = array_merge(
                array($slug),
                isset($block['className']) ? array($block['className']) : array(),
                $is_preview ? array('is-preview') : array(),
                array('align' . $context['block']['align'])
            );

            $context['classes'] = implode(' ', $classes);

            $is_example = false;

            if (!empty($block['data']['is_example'])) {
                $is_example = true;
                $context['fields'] = $block['data'];
            }

            $context = apply_filters('timber/acf-gutenberg-blocks-data', $context);
            $context = apply_filters('timber/acf-gutenberg-blocks-data/' . $slug, $context);
            $context = apply_filters('timber/acf-gutenberg-blocks-data/' . $block['id'], $context);

            $paths = self::timber_acf_path_render($slug, $is_preview, $is_example);

            Timber::render($paths, $context);
        }

        public static function timber_acf_path_render($slug, $is_preview, $is_example) {
            $directories = self::timber_block_directory_getter();

            $ret = array();

            $example_identifier = apply_filters('timber/acf-gutenberg-blocks-example-identifier', '-example');

            $preview_identifier = apply_filters('timber/acf-gutenberg-blocks-preview-identifier', '-preview');

            foreach ($directories as $directory) {
                if ($is_example) {
                    $ret[] = $directory . "/{$slug}{$example_identifier}.twig";
                }
                if ($is_preview) {
                    $ret[] = $directory . "/{$slug}{$preview_identifier}.twig";
                }
                $ret[] = $directory . "/{$slug}.twig";
            }

            return $ret;
        }

        public static function timber_blocks_subdirectories($directories) {
            $ret = array();

            foreach ($directories as $base_directory) {
                if (!file_exists(\locate_template($base_directory))) {
                    continue;
                }

                $template_directory = new RecursiveDirectoryIterator(
                    \locate_template($base_directory),
                    FilesystemIterator::KEY_AS_PATHNAME | FilesystemIterator::CURRENT_AS_SELF
                );

                if ($template_directory) {
                    foreach ($template_directory as $directory) {
                        if ($directory->isDir() && !$directory->isDot()) {
                            $ret[] = $base_directory . '/' . $directory->getFilename();
                        }
                    }
                }
            }

            return $ret;
        }

        public static function timber_block_directory_getter() {
            $directories = apply_filters('timber/acf-gutenberg-blocks-templates', array('templates/blocks'));

            $subdirectories = self::timber_blocks_subdirectories($directories);

            if (!empty($subdirectories)) {
                $directories = array_merge($directories, $subdirectories);
            }

            return $directories;
        }

        public static function timber_block_default_data($data) {
            $default_data = apply_filters('timber/acf-gutenberg-blocks-default-data', array());
            $data_array = array();

            if (!empty($data['default_data'])) {
                $default_data_key = $data['default_data'];
            }

            if (isset($default_data_key) && !empty($default_data[$default_data_key])) {
                $data_array = $default_data[$default_data_key];
            } elseif (!empty($default_data['default'])) {
                $data_array = $default_data['default'];
            }

            if (is_array($data_array)) {
                $data = array_merge($data_array, $data);
            }

            return $data;
        }
    }
}

if (is_callable('add_action')) {
    add_action('after_setup_theme', function() {
        new Timber_Acf_Wp_Blocks();
    });
}
