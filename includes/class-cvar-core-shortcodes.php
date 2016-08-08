<?php
/**
 * CVAR Core Register Shortcodes
 *
 * @package    CVAR_Core
 * @subpackage CVAR_Core\Includes
 * @since      0.1.0
 * @license    GPL-2.0+
 */

/**
 * Register Shortcodes
 *
 * @since 0.1.0
 *
 */
class CVAR_Register_Shortcodes {

    /**
     * Initialize all the things
     *
     * @since 0.1.0
     *
     */
    function __construct() {

        add_action( 'init', array( $this, 'detect_shortcode_ui' ) );
        add_action( 'init', array( $this, 'register_shortcodes' ) );
        add_action( 'init', array( $this, 'register_shortcode_ui' ) );

    }

    /**
     * Detect if Shortcode UI is activated
     *
     * @since 0.1.0
     *
     */
    public function detect_shortcode_ui() {
        if ( !function_exists( 'shortcode_ui_register_for_shortcode' ) ) {
            add_action( 'admin_notices', array( $this, 'shortcode_ui_notices' ) );
        }
    }

    /**
     * Show message if Shortcode UI not activated
     *
     * @since 0.1.0
     *
     */
    public function shortcode_ui_notices() {
        if ( current_user_can( 'activate_plugins' ) ) {
            ?>
            <div class="error message">
                <p><?php esc_html_e( 'Shortcode UI plugin must be active in order to take advantage of an improved shortcode user interface.', 'cvar-core' ); ?></p>
            </div>
            <?php
        }
    }

    /**
     * Register shortcodes
     *
     * @since 0.1.0
     *
     * @param string $shortcode_tag
     * @param function $shortcode_function
     *
     */
    public function register_shortcodes() {
        add_shortcode( 'image-gallery', array( $this, 'image_gallery_shortcode' ) );
    }

    /**
     * Register Shortcode with Shortcode UI
     *
     * @since 0.1.0
     *
     * @param string $shortcode_tag
     * @param function $shortcode_function
     *
     */
    public function register_shortcode_ui() {
        add_action( 'register_shortcode_ui', array( $this, 'image_gallery_shortcode_ui' ) );
    }

    /**
     * Callback for the `image-gallery` shortcode.
     *
     * It renders the shortcode based on supplied attributes.
     *
     * @example `[image-gallery media_category="farm-animals"]` where `media_category` is the image category
     *
     * @since 0.1.0
     *
     * @param string $attr
     * @param string $content
     * @param string $shortcode_tag
     */
    public function image_gallery_shortcode( $attr, $content, $shortcode_tag ) {
        $attr = shortcode_atts( array(
            'post_type'     => 'attachment',
            'tax_query' => array(
                array(
                    'taxonomy' => 'media_category',
                    'field' => 'slug',
                    'terms' => '',
               ),
            ),
        ), $attr, $shortcode_tag );

        global $wpdb;

        // Output buffering here.
        ob_start();

        include_once ( 'views/gallery.php' );

        return ob_get_clean();
    }

    /**
     * Embed Timeline Shortcode UI
     *
     * @since 0.1.0
     *
     */
    public function image_gallery_shortcode_ui() {
        $fields = array(
            array(
                'label'    => esc_html__( 'Select Category', 'cvar-core' ),
                'attr'     => 'term',
                'type'     => 'term_select',
                'taxonomy' => 'media_category',
                'multiple' => true,
    		),
        );

        /*
         * Define the Shortcode UI arguments.
         */
        $shortcode_ui_args = array(
            'label'         => esc_html__( 'Add Image Gallery', 'cvar-core' ),
            'listItemImage' => 'dashicons-format-gallery',
            'post_type'     => array( 'post', 'page' ),
            'attrs'         => $fields,
        );

        shortcode_ui_register_for_shortcode( 'image-gallery', $shortcode_ui_args );
    }

}

new CVAR_Register_Shortcodes();
