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
        add_shortcode( 'category-gallery', array( $this, 'image_gallery_shortcode' ) );
        add_shortcode( 'promo-widget', array( $this, 'promo_widget_shortcode' ) );
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
        add_action( 'register_shortcode_ui', array( $this, 'promo_widget_shortcode_ui' ) );
    }

    /**
     * Callback for the `category-gallery` shortcode.
     *
     * It renders the shortcode based on supplied attributes.
     *
     * @example `[category-gallery terms="farm-animals" columns="3" size="medium"]` where `terms` is the ID(s) the `media_category` term(s)
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
            'tax_query'     => array(
                array(
                    'taxonomy'  => 'media_category',
                    'field'     => 'term_id',
                    'terms'     => $attr['ids'],
               ),
            ),
            'columns'       => $attr['columns'],
            'size'          => $attr['size']
        ), $attr, $shortcode_tag );

        $terms = ( isset( $attr['tax_query'][0]['terms'] ) && !empty( $attr['tax_query'][0]['terms'] ) ) ? $attr['tax_query'][0]['terms'] : null;

        $image_ids = cvar_get_image_ids_by_terms( $terms );

        $columns = ( isset( $attr['columns'] ) && !empty( $attr['columns'] ) ) ? $attr['columns'] : false;

        $size = ( isset( $attr['size'] ) && !empty( $attr['size'] ) ) ? $attr['size'] : false;

        global $wpdb;

        // Output buffering here.
        ob_start();

        include( 'views/gallery.php' );

        return ob_get_clean();
    }

    /**
     * Callback for the `promo-widget` shortcode.
     *
     * It renders the shortcode based on supplied attributes.
     *
     * @example `[promo-widget headline="Donate" image="27" button-text="Click Here" link=""]`
     *
     * @since 0.1.0
     *
     * @param string $attr
     * @param string $content
     * @param string $shortcode_tag
     */
    public function promo_widget_shortcode( $attr, $content, $shortcode_tag ) {
        $attr = shortcode_atts( array(
            'headline'  => $attr['headline'],
            'subhead'   => $attr['subhead'],
            'image'     => $attr['image'],
            'link'      => $attr['link'],
            'text'      => $attr['text'],
        ), $attr, $shortcode_tag );

        extract( $attr, EXTR_SKIP );

        // Output buffering here.
        ob_start();

        include( 'views/promo.php' );

        return ob_get_clean();
    }

    /**
     * Image Gallery Shortcode UI
     *
     * @since 0.1.0
     *
     */
    public function image_gallery_shortcode_ui() {
        $fields = array(
            array(
                'label'     => esc_html__( 'Select Category', 'cvar-core' ),
                'attr'      => 'ids',
                'type'      => 'term_select',
                'taxonomy'  => 'media_category',
                'multiple'  => true,
    		),
            array(
                'label'     => esc_html__( 'Number of Columns', 'cvar-core' ),
                'attr'      => 'columns',
                'type'      => 'select',
                'options'   => array_combine( range( 1, 5 ), range( 1, 5 ) ),
                'multiple'  => false,
            ),
            array(
                'label'     => esc_html__( 'Image Size', 'cvar-core' ),
                'attr'      => 'size',
                'type'      => 'select',
                'default'   => 'thumbnail',
                'options'   => array(
                    'thumbnail'     => __( 'Thumbnail', 'cvar-core' ),
                    'medium'        => __( 'Medium', 'cvar-core' ),
                    'large'         => __( 'Large', 'cvar-core' ),
                    'full'          => __( 'Full Size', 'cvar-core' ),
                ),
                'multiple'  => false,
            ),

        );

        /*
         * Define the Shortcode UI arguments.
         */
        $shortcode_ui_args = array(
            'label'         => esc_html__( 'Add Gallery', 'cvar-core' ),
            'listItemImage' => 'dashicons-format-gallery',
            'post_type'     => array( 'post', 'page' ),
            'attrs'         => $fields,
        );

        shortcode_ui_register_for_shortcode( 'category-gallery', $shortcode_ui_args );
    }

    /**
     * Promo Widget Shortcode UI
     *
     * @since 0.1.0
     *
     */
    public function promo_widget_shortcode_ui() {
        $fields = array(
            array(
                'label'  => esc_html__( 'Headline', 'cvar-core' ),
                'attr'   => 'headline',
                'type'   => 'text',
                'encode' => false,
                'meta'   => array(
                    'placeholder' => esc_html__( 'e.g. Volunteers Needed', 'cvar-core' ),
                    'data-test'   => 1,
                ),
            ),
            array(
                'label'  => esc_html__( 'Subhead', 'cvar-core' ),
                'attr'   => 'subhead',
                'type'   => 'text',
                'encode' => false,
                'meta'   => array(
                    'placeholder' => esc_html__( 'e.g. Support our efforts to care for animals in need.', 'cvar-core' ),
                    'data-test'   => 1,
                ),
            ),
            array(
                'label'         => esc_html__( 'Select Image', 'cvar-core' ),
                'attr'          => 'image',
                'type'          => 'attachment',
                'libraryType'   => array( 'image' ),
                'addButton'     => esc_html__( 'Select Image', 'cvar-core' ),
                'frameTitle'    => esc_html__( 'Select Image', 'cvar-core' ),
            ),
            array(
                'label'     => esc_html__( 'Select Link', 'cvar-core' ),
                'attr'      => 'link',
                'type'      => 'post_select',
                'query'     => array(
                    'post_type' => array( 'page', 'post', 'form' ),
                ),
                'multiple'  => false,
            ),
            array(
                'label'  => esc_html__( 'Button Text', 'cvar-core' ),
                'attr'   => 'text',
                'type'   => 'text',
                'encode' => false,
                'meta'   => array(
                    'placeholder' => esc_html__( 'e.g. Learn More', 'cvar-core' ),
                    'data-test'   => 1,
                ),
            ),
        );

        /*
         * Define the Shortcode UI arguments.
         */
        $shortcode_ui_args = array(
            'label'         => esc_html__( 'Add Promo Widget', 'cvar-core' ),
            'listItemImage' => 'dashicons-format-gallery',
            'post_type'     => array( 'post', 'page' ),
            'attrs'         => $fields,
        );

        shortcode_ui_register_for_shortcode( 'promo-widget', $shortcode_ui_args );
    }

}

new CVAR_Register_Shortcodes();
