<?php

namespace Gutenkit\Config;
use Gutenkit\Helpers\Utils;

defined( 'ABSPATH' ) || exit;

/**
 * Register blocks class
 *
 * @since 0.1.0
 * @return void
 */

class Blocks {

	use \Gutenkit\Traits\Singleton;

	// class initilizer method
	public function __construct() {
		add_action( 'init', array( $this, 'register_blocks' ) );
		add_action( 'block_categories_all', array( $this, 'register_block_categories' ), 10, 2 );
		add_filter( 'render_block', array( $this, 'save_element' ), 10, 3 );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );
	}

	// register blocks
	public function register_blocks() {
		global $pagenow;
		
		$is_editor = $pagenow === 'post.php' || $pagenow === 'post-new.php' || $pagenow === 'site-editor.php' || $pagenow === 'widgets.php';
		$args = array(
			'handle' => 'gutenkit-blocks-editor-global',
			'src'    => GUTENKIT_PLUGIN_URL . 'build/gutenkit/global.css',
			'deps'   => array(),
			'ver'    => GUTENKIT_PLUGIN_VERSION,
			'media'  => 'all',
		);

		$blocks_list = \Gutenkit\Config\BlockList::instance()->get_list( 'active' );

		if ( ! empty( $blocks_list ) ) {
			foreach ( $blocks_list as $key => $block ) {
				$package = isset($block['package']) ? $block['package'] : '';
				$blocks_dir = '';
				$plugin_dir = '';
				$plugin_slug = '';

				if ( !empty( $package ) &&  $package === 'free') {
					$blocks_dir = GUTENKIT_BLOCKS_DIR . $key;
					$plugin_dir = GUTENKIT_PLUGIN_DIR;
					$plugin_slug = 'gutenkit';
				}

				if ( !empty( $package ) &&  $package === 'pro' && defined( 'GUTENKIT_PRO_BLOCKS_DIR' ) ) {
					$blocks_dir = GUTENKIT_PRO_BLOCKS_DIR . $key;
					$plugin_dir = GUTENKIT_PRO_PLUGIN_DIR;
					$plugin_slug = 'gutenkit-pro';
				}
				
				if ( ! file_exists( $blocks_dir ) ) {
					continue;
				}

				register_block_type( $blocks_dir );

				wp_set_script_translations( "{$plugin_slug}-{$key}-editor-script", 'gutenkit-blocks-addon', $plugin_dir . 'languages' );

				if ( $is_editor ) {
					wp_enqueue_block_style( "{$plugin_slug}/{$key}", $args );
				}
			}
		}
	}

	// register block categories
	public function register_block_categories( $categories, $post ) {
		return array_merge(
			array(
				array(
					'slug'  => 'gutenkit',
					'title' => __( 'GutenKit', 'gutenkit-blocks-addon' ),
					'icon'  => 'wordpress',
				),
			),
			$categories
		);
	}

	// admin scripts
	public function admin_scripts( $screen ) {
		$editor_template_library = include_once GUTENKIT_PLUGIN_DIR . 'build/gutenkit/editor-template-library.asset.php';

		if ( $screen === 'post.php' || $screen === 'post-new.php' || $screen === 'site-editor.php' ) {
			wp_enqueue_script(
				'gutenkit-editor-template-library',
				GUTENKIT_PLUGIN_URL . 'build/gutenkit/editor-template-library.js',
				$editor_template_library['dependencies'],
				$editor_template_library['version'],
				true
			);

			wp_enqueue_style(
				'gutenkit-editor-template-library',
				GUTENKIT_PLUGIN_URL . 'build/gutenkit/editor-template-library.css',
				array(),
				$editor_template_library['version']
			);
			// Google Roboto Font
			wp_enqueue_style(
				'gutenkit-google-fonts', 
				'https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,500;0,700;1,400;1,500;1,700&display=swap'
			);
		}
	}

	public function save_element( $block_content, $parsed_block, $instance ) {
		if ( Utils::is_gkit_block($block_content, $parsed_block, 'blockClass') ) {
			$block_content = new \WP_HTML_Tag_Processor($block_content);
			$block_content->next_tag();
			$block_content->set_attribute('id', "block-" . $parsed_block['attrs']['blockID']);
			$block_content->add_class($parsed_block['attrs']['blockClass']);
			$block_content->add_class('gutenkit-block');
			!empty($parsed_block['attrs']['commonBlockHideDesktop']) && $block_content->add_class('gkit-hide-desktop');
			!empty($parsed_block['attrs']['commonBlockHideTablet']) && $block_content->add_class('gkit-hide-tablet');
			!empty($parsed_block['attrs']['commonBlockHideMobile']) && $block_content->add_class('gkit-hide-mobile');

			$before_markup = apply_filters( 'gutenkit/save_element_markup_before', "", $parsed_block );
			$after_markup = apply_filters( 'gutenkit/save_element_markup_after', "", $parsed_block );
			$block_content = apply_filters('gutenkit_save_element_markup', $block_content, $parsed_block, $instance);

			if ( method_exists( $block_content, 'get_updated_html' ) ) {
				$block_content = $block_content->get_updated_html();
			}

			return sprintf('%1$s %2$s %3$s', $before_markup, $block_content, $after_markup);
		}

		return $block_content;
	}
}
