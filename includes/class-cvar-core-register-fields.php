<?php
/**
 * CVAR Core Register Fields with REST API
 * 
 * @package    CVAR_Core
 * @subpackage CVAR_Core\Includes
 * @since      0.1.0
 * @license    GPL-2.0+
 */

/**
 * Register Fields with REST API
 *
 * This file registers fields with REST API.
 *
 * @since 0.1.0
 */
class CVAR_Rest_API_Fields {

    /**
     * Initialize all the things
     *
     * @since 0.1.0
     */
    function __construct () {
        /**
         * Filters to have fields returned in `custom_fields` instead of `acf`.
         */
        add_filter( 'acf/rest_api/post/get_fields', array( $this, 'set_custom_field_base' ) );
        add_filter( 'acf/rest_api/issue/get_fields', array( $this, 'set_custom_field_base' ) );
        add_filter( 'acf/rest_api/term/get_fields', array( $this, 'set_custom_field_base' ) );
        add_filter( 'acf/rest_api/timeline/get_fields', array( $this, 'set_custom_field_base' ) );
        add_filter( 'acf/rest_api/chart/get_fields', array( $this, 'set_custom_field_base' ) );

        /**
         * Filters to have fields returned in `custom_fields` instead of `acf`. For v1.
         */
        add_filter( 'rest_prepare_department', array( $this, 'rest_prepare_term' ), 10, 2 );

        add_filter( 'rest_prepare_issue', array( $this, 'rest_prepare_term' ), 10, 2 );

        add_filter( 'rest_prepare_location', array( $this, 'rest_prepare_term' ), 10, 2 );

        add_filter( 'rest_prepare_series', array( $this, 'rest_prepare_term' ), 10, 2 );

        add_action( 'rest_api_init', array( $this, 'register_fields' ) );

        add_action( 'init', array( $this, 'register_taxonomy' ), 25 );

    }

    /**
     * Register the custom fields
     *
     * @since 0.1.0
     */
    function register_fields () {
        if ( function_exists( 'register_api_field' ) ) {

            register_api_field( 'post',
                'subhead',
                array(
                    'get_callback'    => array( $this, 'get_field' ),
                    'update_callback' => null,
                    'schema'          => null
                )
            );

            register_api_field( 'post',
                'authors',
                array(
                    'get_callback'    => array( $this, 'get_authors' ),
                    'update_callback' => null,
                    'schema'          => null
                )
            );

            register_api_field( 'post',
                'featured_image_secondary',
                array(
                    'get_callback'    => array( $this, 'get_featured_image_secondary' ),
                    'update_callback' => null,
                    'schema'          => null,
                )
            );

            register_api_field( 'issue',
                'articles',
                array(
                    'get_callback'    => array( $this, 'get_issue_articles' ),
                    'update_callback' => null,
                    'schema'          => null,
                )
            );

        } elseif ( function_exists( 'register_rest_field' ) ) {

            register_rest_field( 'post',
                'authors',
                array(
                    'get_callback'    => array( $this, 'get_field' ),
                    'update_callback' => null,
                    'schema'          => null,
                )
            );

            register_rest_field( 'post',
                'subhead',
                array(
                    'get_callback'    => array( $this, 'get_authors' ),
                    'update_callback' => null,
                    'schema'          => null,
                )
            );

            register_rest_field( 'post',
                'featured_image_secondary',
                array(
                    'get_callback'    => array( $this, 'get_featured_image_secondary' ),
                    'update_callback' => null,
                    'schema'          => null,
                )
            );

            register_rest_field( 'issue',
                'articles',
                array(
                    'get_callback'    => array( $this, 'get_issue_articles' ),
                    'update_callback' => null,
                    'schema'          => null,
                )
            );

        }
    }

    /**
     * Register the custom taxonomy
     *
     * @since 0.1.0
     */
    function register_taxonomy () {}

    /**
     * Get post meta
     *
     * @since 0.1.0
     *
     * @param object $object
     * @param string $field_name
     * @param string $request
     * @return string meta
     *
     */
    function get_field ( $object, $field_name, $request ) {
        return get_post_meta( $object[ 'id' ], $field_name, true );
    }

    /**
     * Get secondary featured image
     *
     * @since 0.1.0
     *
     * @uses  get_post_thumbnail_id()
     * @uses  get_post()
     * @uses  get_post_meta()
     * @param object $object
     * @param string $field_name
     * @param string $request
     * @return array $authors
     *
     */
    public function get_featured_image_secondary ( $object, $field_name, $request ) {

        $post_id = $object['id'];
        $image_id = get_post_thumbnail_id( $post_id );
        $post_data = get_post( $image_id );

        if( !empty( $post_data ) ) {
            $featured_image_secondary = array(
                'id'            => $post_data->ID,
                'title'         => array(
                    'rendered'  => $post_data->post_title
                ),
                'alt_text'      => get_post_meta( $image_id  , '_wp_attachment_image_alt', true ),
                'description'   => $post_data->post_content,
                'caption'       => $post_data->post_excerpt,
                'link'          => wp_get_attachment_url( $image_id ),
                'author'        => (int) $post_data->post_author,
                'media_details' => wp_get_attachment_metadata( $image_id ),
            );
            
            return $featured_image_secondary;
        }

        return;

    }

    /**
     * Get issue articles
     *
     * @since 0.1.0
     *
     * @uses  get_post_thumbnail_id()
     * @uses  get_post()
     * @uses  get_post_meta()
     * @param object $object
     * @param string $field_name
     * @param string $request
     * @return array $authors
     *
     */
    public function get_issue_articles ( $object, $field_name, $request ) {
        $meta = get_post_meta( $object['id'], 'article_issue_relationship', true );
        $articles = [];
        $count = 0;

        $args = array(
            'post__in' => $meta
        );

        $posts = get_posts( $args );

        if( !empty( $posts ) ) {
            foreach( $posts as $post ) {
                $articles[$count]['id'] = (int) $post->ID;
                $articles[$count]['title']['rendered'] = $post->post_title;
                $articles[$count]['slug'] = $post->post_name;
                $articles[$count]['content'] = $post->post_content;
                $articles[$count]['excerpt']['rendered'] = jacobin_the_excerpt( $post->ID );
                
                if ( function_exists( 'get_coauthors' ) ) {
                    $coauthors = get_coauthors ( $post->ID );

                    $count_authors = 0;

                    foreach( $coauthors as $coauthor ) {

                        $user_id = $coauthor->data->ID;
                        $user_meta = get_userdata( $user_id );

                        $articles[$count]['authors'][$count_authors]['id'] = (int) $user_id;
                        $articles[$count]['authors'][$count_authors]['first_name'] = $user_meta->first_name;
                        $articles[$count]['authors'][$count_authors]['last_name'] = $user_meta->last_name ;
                        $articles[$count]['authors'][$count_authors]['name'] = $user_meta->display_name;
                        $articles[$count]['authors'][$count_authors]['description'] = $user_meta->description;
                        $articles[$count]['authors'][$count_authors]['link'] = get_author_posts_url( $user_id );

                        $count_authors++;

                    }

                }

                $count++;
            } 
        }

        return $articles;
        
    }

    /**
     * Get coauthors
     *
     * @since 0.1.0
     *
     * @param object $object
     * @param string $field_name
     * @param string $request
     * @return array $authors
     *
     */
    public function get_authors ( $object, $field_name, $request ) {

        return $this->get_authors_array ( $object['id'] );
    }

    /**
     * Create array of authors
     *
     * @since 0.1.0
     *
     * @param object $object->ID
     * @return array $authors
     *
     */
    public function get_authors_array ( $object_id ) {

        if ( function_exists( 'get_coauthors' ) ) {
            $coauthors = get_coauthors ( $object_id );
            $authors = [];
            $count = 0;

            foreach( $coauthors as $coauthor ) {

                $user_id = $coauthor->data->ID;
                $user_meta = get_userdata( $user_id );

                $authors[$count]['id'] = (int) $user_id;
                $authors[$count]['first_name'] = $user_meta->first_name;
                $authors[$count]['last_name'] = $user_meta->last_name ;
                $authors[$count]['name'] = $user_meta->display_name;
                $authors[$count]['description'] = $user_meta->description;
                $authors[$count]['link'] = get_author_posts_url( $user_id );

                $count++;

            }

            return $authors;
        }

    }

    /**
     * Change Base Label of Custom Fields
     *
     * Advanced Custom Fields fields are displayed within `acf`.
     *
     * @link https://github.com/airesvsg/acf-to-rest-api/issues/41#issuecomment-222460783
     *
     * @param array $data
     * @return modified array $data
     *
     * @since 0.1.0
     */
    public function set_custom_field_base ( $data ) {
        if ( method_exists( $data, 'get_data' ) ) {
            $data = $data->get_data();
        } else {
            $data = (array) $data;
        }

        if ( isset( $data['acf'] ) ) {
            $data['custom_fields'] = $data['acf'];
            unset( $data['acf'] );
        }
        return $data;
    }

    /**
     * Change Base Label of Custom Fields
     *
     * Advanced Custom Fields fields are displayed within `acf` for v1.
     *
     * @link https://github.com/airesvsg/acf-to-wp-rest-api/issues/11#issuecomment-230176396
     *
     * @param array $data
     * @return modified array $data
     *
     * @since 0.1.0
     */
    public function set_custom_field_base_v1 ( $data ) {
        if ( isset( $data['acf'] ) ) {
          $data['custom_fields'] = $data['acf'];
          unset( $data['acf'] );
        }

        return $data;
    }

    /**
     * Change response field to `custom_fields`.
     *
     * @since 0.1.0
     *
     * @param $response
     * @param $object
     * @return modified $response
     *
     * @link http://v2.wp-api.org/extending/custom-content-types/
     */
    public function rest_prepare_term ( $response, $object ) {
        if ( $object instanceof WP_Term ) {
            if ( isset( $data['acf'] ) ) {
                $data['custom_fields'] = $data['acf'];
                unset( $data['acf'] );
            }
            $response->data['custom_fields'] = get_fields( $object->taxonomy . '_' . $object->term_id );
        }

        return $response;
    }
    
}

new CVAR_Rest_API_Fields();