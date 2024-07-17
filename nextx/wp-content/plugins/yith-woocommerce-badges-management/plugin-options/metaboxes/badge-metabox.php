<?php
/**
 * Badge Metabox
 *
 * @author   YITH <plugins@yithemes.com>
 * @package  YITH\BadgeManagementPremium\PluginOptions
 * @since    2.0
 */

return array(
	'label'    => __( 'Badge Options', 'yith-woocommerce-badges-management' ),
	'pages'    => YITH_WCBM_Post_Types::$badge,
	'priority' => 'high',
	'class'    => yith_set_wrapper_class() . ' yith-wcbm-badge-options-metabox',
	'tabs'     => array(
		'badge-options' => array(
			'label'  => __( 'Text Badge', 'yith-woocommerce-badges-management' ),
			'fields' => array(
				'yith_wcbm_badge_security' => array(
					'type' => 'hidden',
					'std'  => wp_create_nonce( 'yith_wcbm_save_badge' ),
					'name' => 'yith_wcbm_badge_security',
				),
				'post-title'               => array(
					'label'             => __( 'Badge name', 'yith-woocommerce-badges-management' ),
					'type'              => 'text',
					'name'              => 'post_title',
					'id'                => 'yith-wcbm-title',
					'custom_attributes' => array(
						'placeholder' => __( 'Badge name', 'yith-woocommerce-badges-management' ),
						'required'    => 'true',
					),
					'desc'              => __( 'Enter a name to identify this badge', 'yith-woocommerce-badges-management' ),
				),
				'type'                     => array(
					'name'            => 'yith_wcbm_badge[_type]',
					'label'           => __( 'Badge type', 'yith-woocommerce-badges-management' ),
					'type'            => 'select',
					'class'           => 'yith-wcbm-badge-type yith-enhanced-select',
					'extra_row_class' => 'yith-wcbm-badge-type-row',
					'options'         => array(
						'text'  => __( 'Text', 'yith-woocommerce-badges-management' ),
						'image' => __( 'Image', 'yith-woocommerce-badges-management' ),
					),
					'std'             => isset( $_GET['badge-type'] ) && in_array( $_GET['badge-type'], array( 'text', 'image' ), true ) ? sanitize_text_field( wp_unslash( $_GET['badge-type'] ) ) : 'text', // phpcs:ignore WordPress.Security.NonceVerification.Recommended
					'desc'            => __( 'Choose the badge type', 'yith-woocommerce-badges-management' ),
				),
				'image'                    => array(
					'name'            => 'yith_wcbm_badge[_image]',
					'custom_label'    => esc_html__( 'Choose the badge image', 'yith-woocommerce-badges-management' ),
					'type'            => 'custom',
					'extra_row_class' => 'yith-wcbm-badge-image-row yith-wcbm-visible-if-image',
					'action'          => 'yith_wcbm_print_badge_library_field',
					'library'         => yith_wcbm_get_local_badges_list( 'image' ),
					'allow_upload'    => 'yes',
					'url'             => YITH_WCBM_ASSETS_URL . 'images/image-badges/',
					'std'             => '1.svg',
				),
				'text'                     => array(
					'name'            => 'yith_wcbm_badge[_text]',
					'label'           => __( 'Text', 'yith-woocommerce-badges-management' ),
					'desc'            => __( 'Use the editor to add the badge text.', 'yith-woocommerce-badges-management' ),
					'type'            => 'textarea',
					'extra_row_class' => 'yith-wcbm-text-editor-row yith-wcbm-visible-if-text',
					'class'           => 'yith-wcbm-text-editor',
					'std'             => 'Text',
				),
				'background_color'         => array(
					'name'            => 'yith_wcbm_badge[_background_color]',
					'label'           => __( 'Background color', 'yith-woocommerce-badges-management' ),
					'type'            => 'colorpicker',
					'extra_row_class' => 'yith-wcbm-visible-if-text',
					'alpha_enabled'   => false,
					'class'           => 'yith-plugin-fw-colorpicker yith-wcbm-background-colorpicker',
					'std'             => '#2470FF',
				),
				'size'                     => array(
					'name'            => 'yith_wcbm_badge[_size]',
					'label'           => __( 'Size (px)', 'yith-woocommerce-badges-management' ),
					'type'            => 'dimensions',
					'extra_row_class' => 'yith-wcbm-visible-if-text',
					'class'           => 'yith-wcbm-visible-if-text',
					'dimensions'      => array(
						'width'  => __( 'Width', 'yith-woocommerce-badges-management' ),
						'height' => __( 'Height', 'yith-woocommerce-badges-management' ),
					),
					'units'           => array(
						'px' => 'px',
					),
					'min'             => 0,
					'std'             => array(
						'dimensions' => array(
							'width'  => 100,
							'height' => 50,
						),
						'linked'     => 'no',
						'unit'       => 'px',
					),
				),
				'padding'                  => array(
					'name'            => 'yith_wcbm_badge[_padding]',
					'label'           => __( 'Padding', 'yith-woocommerce-badges-management' ),
					'desc'            => __( 'Set the badge content spacing', 'yith-woocommerce-badges-management' ),
					'type'            => 'dimensions',
					'extra_row_class' => 'yith-wcbm-visible-if-text',
					'dimensions'      => array(
						'top'    => __( 'Top', 'yith-woocommerce-badges-management' ),
						'right'  => __( 'Right', 'yith-woocommerce-badges-management' ),
						'bottom' => __( 'Bottom', 'yith-woocommerce-badges-management' ),
						'left'   => __( 'Left', 'yith-woocommerce-badges-management' ),
					),
					'units'           => array(
						'px'         => 'px',
						'percentage' => '%',
					),
					'min'             => 0,
				),
				'border_radius'            => array(
					'name'            => 'yith_wcbm_badge[_border_radius]',
					'label'           => __( 'Border radius', 'yith-woocommerce-badges-management' ),
					'desc'            => __( 'Set the badge border radius', 'yith-woocommerce-badges-management' ),
					'type'            => 'dimensions',
					'extra_row_class' => 'yith-wcbm-visible-if-text',
					'dimensions'      => array(
						'top-left'     => __( 'Top left', 'yith-woocommerce-badges-management' ),
						'top-right'    => __( 'Top right', 'yith-woocommerce-badges-management' ),
						'bottom-right' => __( 'Bottom right', 'yith-woocommerce-badges-management' ),
						'bottom-left'  => __( 'Bottom left', 'yith-woocommerce-badges-management' ),
					),
					'units'           => array(
						'px'         => 'px',
						'percentage' => '%',
					),
					'min'             => 0,
				),
				'position'                 => array(
					'name'            => 'yith_wcbm_badge[_position]',
					'label'           => __( 'Position', 'yith-woocommerce-badges-management' ),
					'type'            => 'radio',
					'extra_row_class' => 'yith-wcbm-visible-if-image yith-wcbm-visible-if-text yith-wcbm-visible-if-css yith-wcbm-visible-if-advanced yith-wcbm-preview-boxed-radio yith-wcbm-position-fixed-row',
					'class'           => 'yith-wcbm-position-field',
					'options'         => array(
						'top'    => '<span class="yith-wcbm-radio-preview-box yith-wcbm-position-preview"></span>' . __( 'Top', 'yith-woocommerce-badges-management' ),
						'middle' => '<span class="yith-wcbm-radio-preview-box yith-wcbm-position-preview"></span>' . __( 'Middle', 'yith-woocommerce-badges-management' ),
						'bottom' => '<span class="yith-wcbm-radio-preview-box yith-wcbm-position-preview"></span>' . __( 'Bottom', 'yith-woocommerce-badges-management' ),
					),
					'std'             => 'top',
				),
				'alignment'                => array(
					'name'            => 'yith_wcbm_badge[_alignment]',
					'label'           => __( 'Alignment', 'yith-woocommerce-badges-management' ),
					'type'            => 'radio',
					'extra_row_class' => 'yith-wcbm-visible-if-text yith-wcbm-visible-if-image yith-wcbm-visible-if-css yith-wcbm-visible-if-advanced yith-wcbm-preview-boxed-radio yith-wcbm-alignment-fixed-row',
					'class'           => 'yith-wcbm-alignment-field',
					'options'         => array(
						'left'   => '<span class="yith-wcbm-radio-preview-box yith-wcbm-alignment-preview"></span>' . __( 'Left', 'yith-woocommerce-badges-management' ),
						'center' => '<span class="yith-wcbm-radio-preview-box yith-wcbm-alignment-preview"></span>' . __( 'Center', 'yith-woocommerce-badges-management' ),
						'right'  => '<span class="yith-wcbm-radio-preview-box yith-wcbm-alignment-preview"></span>' . __( 'Right', 'yith-woocommerce-badges-management' ),
					),
					'std'             => 'left',
				),
			),
		),
		'preview'       => array(
			'label'  => '',
			'fields' => array(
				'preview' => array(
					'label'  => '',
					'type'   => 'custom',
					'action' => 'yith_wcbm_print_badge_preview',
				),
			),
		),
	),
);
