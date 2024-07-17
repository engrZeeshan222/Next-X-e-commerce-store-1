<?php
/**
 * Badge Styles
 *
 * @var string $type                       The badge type.
 * @var string $image_url                  Image URL
 * @var string $txt_color                  The text color
 * @var string $txt_color_default          The text color default value
 * @var string $bg_color                   The background color
 * @var string $bg_color_default           The background color default value
 * @var string $width                      The width
 * @var string $height                     The height
 * @var string $position                   The badge vertical position
 * @var string $alignment                  The badge horizontal alignment
 * @var string $padding_top                The badge top padding.
 * @var string $padding_right              The badge right padding.
 * @var string $padding_bottom             The badge bottom padding.
 * @var string $padding_left               The badge left padding.
 * @var string $border_radius_top_left     The badge top left border radius.
 * @var string $border_radius_top_right    The badge top right border radius.
 * @var string $border_radius_bottom_right The badge bottom right border radius.
 * @var string $border_radius_bottom_left  The badge bottom left border radius.
 * @var int    $id_badge                   The badge ID
 *
 * @package YITH\BadgeManagement\Templates
 */

defined( 'YITH_WCBM' ) || exit; // Exit if accessed directly.

$position_css = yith_wcbm_get_position_css( $position, $alignment );

switch ( $type ) {
	case 'text':
	case 'custom':
		?>
		.yith-wcbm-badge-<?php echo absint( $id_badge ); ?>
		{
		color: <?php echo esc_html( $txt_color ); ?>;
		background-color: <?php echo esc_html( $bg_color ); ?>;
		width: <?php echo esc_html( $width ); ?>;
		height: <?php echo esc_html( $height ); ?>;
		<?php echo esc_html( $position_css ); ?>
		padding: <?php echo esc_html( $padding_top . ' ' . $padding_right . ' ' . $padding_bottom . ' ' . $padding_left ); ?>;
		border-radius: <?php echo esc_html( $border_radius_top_left . ' ' . $border_radius_top_right . ' ' . $border_radius_bottom_right . ' ' . $border_radius_bottom_left ); ?>
		}
		<?php
		break;

	case 'image':
		?>
		.yith-wcbm-badge-<?php echo absint( $id_badge ); ?>
		{
		<?php echo esc_html( $position_css ); ?>
		}
		<?php
		break;
}
