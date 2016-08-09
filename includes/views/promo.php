<?php
/**
 * CVAR Promo Widget View
 *
 * @package    CVAR_Core
 * @subpackage CVAR_Core\Admin\Views
 * @since      0.1.0
 * @license    GPL-2.0+
 */
?>

<?php
$image_src = esc_url( wp_get_attachment_url( $image ) );
$image_title = esc_attr( get_the_title( $image ) );
?>

<div class="promo-widget">
    <h3 class="promo-title"><?php echo esc_attr( $headline ); ?></h3>
    <h4 class="promo-subhead"><?php echo esc_attr( $subhead ); ?></h4>
    <div class="promo-image"><img src="<?php echo $image_src; ?>" title="<?php echo esc_attr( $image_title ); ?>"></div>
    <p class="promo-button"><a href="<?php echo get_permalink( $link ); ?>" class="button"><?php echo esc_attr( $text ); ?></a></p>
</div>
