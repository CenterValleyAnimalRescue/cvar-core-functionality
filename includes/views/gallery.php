<?php
/**
 * CVAR Gallery View
 *
 * @package    CVAR_Core
 * @subpackage CVAR_Core\Admin\Views
 * @since      0.1.0
 * @license    GPL-2.0+
 */
?>

<?php
$ids = implode( ',', $image_ids );
$options = 'ids="' . $ids . '"';
$options .= ( $columns ) ? ' columns="' . $columns .  '"' : '';
$options .= ( $size ) ? ' size="' . $size .  '"' : '';
?>

<?php echo do_shortcode( '[gallery ' . $options . ']' ) ?>
