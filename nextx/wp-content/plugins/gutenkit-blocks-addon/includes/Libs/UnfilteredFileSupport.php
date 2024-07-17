<?php
namespace Gutenkit\Libs;

defined('ABSPATH') || exit;

use Gutenkit\Helpers\Utils;

class UnfilteredFileSupport {

	use \Gutenkit\Traits\Singleton;

	private function allowed_svg_attrs_tags() {
		$allowed_svg_tags = [
			'svg' => [
				'xmlns' => true,
				'width' => true,
				'height' => true,
				'viewBox' => true,
				'viewbox' => true,
				'fill' => true,
				'class' => true,
			],
			'g' => [
				'transform' => true,
				'style' => true,
				'id' => true,
			],
			'path' => [
				'd' => true,
				'fill' => true,
				'fill-rule' => true,
				'transform' => true,
				'style' => true,
				'opacity' => true,
				'stroke' => true,
				'stroke-width' => true,
				'stroke-miterlimit' => true,
				'stroke-linecap' => true,
				'stroke-linejoin' => true,
				'fill-opacity' => true,
			],
			'circle' => [
				'cx' => true,
				'cy' => true,
				'r' => true,
				'fill' => true,
				'stroke' => true,
				'stroke-width' => true,
			],
			'ellipse' => [
				'cx' => true,
				'cy' => true,
				'rx' => true,
				'ry' => true,
				'fill' => true,
				'stroke' => true,
				'stroke-width' => true,
			],
			'line' => [
				'x1' => true,
				'y1' => true,
				'x2' => true,
				'y2' => true,
				'stroke' => true,
				'stroke-width' => true,
			],
			'polygon' => [
				'points' => true,
				'fill' => true,
				'stroke' => true,
				'stroke-width' => true,
			],
			'polyline' => [
				'points' => true,
				'fill' => true,
				'stroke' => true,
				'stroke-width' => true,
			],
			'rect' => [
				'x' => true,
				'y' => true,
				'width' => true,
				'height' => true,
				'fill' => true,
				'stroke' => true,
				'stroke-width' => true,
			],
			'text' => [
				'x' => true,
				'y' => true,
				'dx' => true,
				'dy' => true,
				'text-anchor' => true,
				'style' => true,
			],
			'tspan' => [
				'x' => true,
				'y' => true,
				'dx' => true,
				'dy' => true,
				'text-anchor' => true,
				'style' => true,
			],
			'defs' => [],
			'lineargradient' => [
				'id' => true,
				'x1' => true,
				'y1' => true,
				'x2' => true,
				'y2' => true,
				'gradientunits' => true,
			],
			'stop' => [
				'offset' => true,
				'style' => true,
				'stop-color' => true,
				'stop-opacity' => true,
			],
			'radialgradient' => [
				'id' => true,
				'cx' => true,
				'cy' => true,
				'r' => true,
				'gradientunits' => true,
				'gradienttransform' => true,
			],
		];

		return apply_filters( 'gutenkit_allowed_svg_attrs_tags', $allowed_svg_tags );
	}

	/**
	 * Returns an array of allowed JSON attribute tags.
	 *
	 * This function defines an array of allowed JSON attribute tags and their corresponding properties.
	 * The array includes tags such as 'object', 'array', 'string', 'number', 'integer', 'boolean', 'null',
	 * 'enum', 'const', 'oneOf', 'allOf', 'anyOf', 'not', 'if', 'then', 'else', and 'format'.
	 *
	 * @return array The array of allowed JSON attribute tags.
	 */
	private function allowed_json_attrs_tags() {
		$allowed_json_tags = [
			'object' => [
				'type' => true,
				'properties' => true,
				'required' => true,
			],
			'array' => [
				'type' => true,
				'items' => true,
				'minItems' => true,
				'maxItems' => true,
			],
			'string' => [
				'type' => true,
				'minLength' => true,
				'maxLength' => true,
				'pattern' => true,
			],
			'number' => [
				'type' => true,
				'minimum' => true,
				'maximum' => true,
			],
			'integer' => [
				'type' => true,
				'minimum' => true,
				'maximum' => true,
			],
			'boolean' => [
				'type' => true,
			],
			'null' => [
				'type' => true,
			],
			'enum' => [
				'type' => true,
				'enum' => true,
			],
			'const' => [
				'type' => true,
				'const' => true,
			],
			'oneOf' => [
				'type' => true,
				'oneOf' => true,
			],
			'allOf' => [
				'type' => true,
				'allOf' => true,
			],
			'anyOf' => [
				'type' => true,
				'anyOf' => true,
			],
			'not' => [
				'type' => true,
				'not' => true,
			],
			'if' => [
				'type' => true,
				'if' => true,
			],
			'then' => [
				'type' => true,
				'then' => true,
			],
			'else' => [
				'type' => true,
				'else' => true,
			],
			'format' => [
				'type' => true,
				'format' => true,
			],
		];

		return apply_filters('gutenkit_allowed_json_attrs_tags', $allowed_json_tags);
	}


	/**
	 * SvgSupport class constructor.
	 * private for singleton
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public function __construct() {
		if ( ! Utils::get_settings('unfiltered_upload') ) {
			return;
		}

		add_filter( 'upload_mimes', [$this, 'allowed_mime_types'] );
		add_filter( 'wp_handle_upload_prefilter', [$this, 'check_files_formate'] );
		add_filter( 'wp_check_filetype_and_ext', [ $this, 'fix_mime_types' ], 90, 4 );
	}

	/**
	 * Get WP filesystem
	 *
	 * @return void
	 */
	protected function get_filesystem() {
		// Check if WP_Filesystem is available
		if ( ! function_exists( 'WP_Filesystem' ) ) {
			require_once ABSPATH . 'wp-admin/includes/file.php';
		}

		// Initialize WP_Filesystem
		WP_Filesystem();
	}

	/**
	 * Adds SVG and json mime types to the list of allowed file types for upload.
	 *
	 * @param array $mimes The list of allowed file types.
	 * @return array The updated list of allowed file types.
	 */
	public function allowed_mime_types( $mimes ) {
		if( current_user_can( 'upload_files' ) ) {
			$mimes['svg']  = 'image/svg+xml';
			$mimes['svgz'] = 'image/svg+xml';
			$mimes['json'] = 'application/json';
		}
		return $mimes;
	}

	/**
	 * Checks the SVG files before processing.
	 *
	 * @param array $file The file to be checked.
	 * @return array The checked file.
	 */
	public function check_files_formate( $file ) {
		// check file path before processing
		if ( ! isset( $file['tmp_name'] ) ) {
			return $file;
		}

		$file_name   = isset( $file['name'] ) ? $file['name'] : '';
		$wp_filetype = wp_check_filetype_and_ext( $file['tmp_name'], $file_name );
		$type        = ! empty( $wp_filetype['type'] ) ? $wp_filetype['type'] : '';

		if ( 'image/svg+xml' === $file['type'] ) {
			if( ! current_user_can( 'upload_files' ) ) {
				$file['error'] = esc_html__( 'Sorry, you are not allowed to upload SVG files.', 'gutenkit-blocks-addon' );
				return $file;
			}

			if ( ! $this->sanitize_svg( $file['tmp_name'] ) ) {
				$file['error'] = esc_html__( 'Sorry, this file could not be sanitized so for security reasons was not uploaded.', 'gutenkit-blocks-addon' );
			}
		}

		if ( 'application/json' === $file['type'] ) {
			if( ! current_user_can( 'upload_files' ) ) {
				$file['error'] = esc_html__( 'Sorry, you are not allowed to upload JSON files.', 'gutenkit-blocks-addon' );
				return $file;
			}

			if ( ! $this->sanitize_json( $file['tmp_name'] ) ) {
				$file['error'] = esc_html__( 'Sorry, this file could not be sanitized so for security reasons was not uploaded.', 'gutenkit-blocks-addon' );
			}
		}

		return $file;
	}

	/**
	 * Sanitizes an SVG file by cleaning its contents and optionally gzipping it.
	 *
	 * @param string $file The path to the SVG file.
	 * @return bool True if the SVG file was successfully sanitized, false otherwise.
	 */
	private function sanitize_svg( $file ) {

		$this->get_filesystem();
		global $wp_filesystem;

		$dirty = $wp_filesystem->get_contents( $file );

		// Is the SVG gzipped? If so we try and decode the string
		$is_zipped = $this->is_gzipped( $dirty );
		if ( $is_zipped ) {
			$dirty = gzdecode( $dirty );

			// If decoding fails, bail as we're not secure
			if ( false === $dirty ) {
				return false;
			}
		}

		// Sanitize the SVG
		$dirty = preg_replace( '/<script(.*?)>(.*?)<\/script>/is', '', $dirty ); // remove <script>....</script> tags
		$allowed_html = wp_parse_args($this->allowed_svg_attrs_tags(), wp_kses_allowed_html( 'post' ));
		$clean = wp_kses( $dirty, $allowed_html );

		// Minify the SVG
		$clean = preg_replace('/>\s+</', '><', $clean);
		$clean = preg_replace('/\s+/', ' ', $clean);

		// Check if the SVG is still valid
		if ( ! preg_match( '/<svg.*?(viewBox=".*"|width=".*"\s+height=".*"|height=".*"\s+width=".*").*<\/svg>/s', $clean ) ) {
			$clean = false;
		}

		if ( false === $clean ) {
			return false;
		}

		// If we were gzipped, we need to re-zip
		if ( $is_zipped ) {
			$clean = gzencode( $clean );
		}

		$wp_filesystem->put_contents( $file, $clean );

		return true;
	}

	/**
	 * Checks the JSON files before processing.
	 *
	 * @param array $file The file to be checked.
	 * @return array The checked file.
	 */
	private function sanitize_json( $file ) {
		$this->get_filesystem();
		global $wp_filesystem;

		$dirty = $wp_filesystem->get_contents( $file );

		// Is the JSON gzipped? If so we try and decode the string
		$is_zipped = $this->is_gzipped( $dirty );
		if ( $is_zipped ) {
			$dirty = gzdecode( $dirty );

			// If decoding fails, bail as we're not secure
			if ( false === $dirty ) {
				return false;
			}
		}

		// Decode JSON
		$data = json_decode( $dirty, true );
		if ( json_last_error() !== JSON_ERROR_NONE ) {
			return false;
		}

		// Sanitize JSON
		$data = $this->sanitize_json_data( $data );

		// Encode JSON
		$clean = json_encode( $data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );

		// Minify JSON by removing spaces and newlines
		$clean = preg_replace('/\s+/', ' ', $clean);

		// If we were gzipped, we need to re-zip
		if ( $is_zipped ) {
			$clean = gzencode( $clean );
		}

		$wp_filesystem->put_contents( $file, $clean );

		return true;
	}

	/**
	 * Sanitizes JSON data by filtering its contents based on allowed JSON tags.
	 *
	 * This function uses a recursive approach to traverse through the JSON data. If the data is an array,
	 * it iterates over each element. If an element is an array, the function calls itself recursively to filter the data.
	 * If an element is not an array, it checks if the key of the element is in the list of allowed JSON tags.
	 * If the key is not in the list, it removes the element from the data.
	 *
	 * @param mixed $data The JSON data to sanitize. This can be an array or an object.
	 * @return mixed The sanitized JSON data.
	 */
	private function sanitize_json_data( $data ) {
		$allowed_json_tags = $this->allowed_json_attrs_tags();
		// Recursive function to filter JSON data
		$filter_data = function( $data ) use ( &$filter_data, $allowed_json_tags ) {
			if ( is_array( $data ) ) {
				foreach ( $data as $key => $value ) {

					if ( is_array( $value ) ) {
						$data[ $key ] = $filter_data( $value );
					} else {
						if ( ! isset( $allowed_json_tags[ $key ] ) ) {
							unset( $data[ $key ] );
						}
					}
				}
			}
			return $data;
		};

		return $filter_data( $data );
	}
	/**
	 * Check if the contents are gzipped
	 *
	 * @see http://www.gzip.org/zlib/rfc-gzip.html#member-format
	 *
	 * @param string $contents Content to check.
	 *
	 * @return bool
	 */
	protected function is_gzipped( $contents ) {
		// phpcs:disable Generic.Strings.UnnecessaryStringConcat.Found
		if ( function_exists( 'mb_strpos' ) ) {
			return 0 === mb_strpos( $contents, "\x1f" . "\x8b" . "\x08" );
		} else {
			return 0 === strpos( $contents, "\x1f" . "\x8b" . "\x08" );
		}
		// phpcs:enable
	}

	/**
	 * Fixes the mime types for a given file.
	 *
	 * @param array|null $data The data array containing the file information.
	 * @param string|null $file The file path.
	 * @param string|null $filename The file name.
	 * @param array|null $mimes The array of allowed mime types.
	 * @return array|null The updated data array with fixed mime types.
	 */
	public function fix_mime_types( $data = null, $file = null, $filename = null, $mimes = null ) {
		$ext = isset( $data['ext'] ) ? $data['ext'] : '';
		if ( strlen( $ext ) < 1 ) {
			$exploded = explode( '.', $filename );
			$ext      = strtolower( end( $exploded ) );
		}

		if ( 'svg' === $ext ) {
			$data['type'] = 'image/svg+xml';
			$data['ext']  = 'svg';
		} elseif ( 'svgz' === $ext ) {
			$data['type'] = 'image/svg+xml';
			$data['ext']  = 'svgz';
		} elseif ( 'json' === $ext ) {
			$data['type'] = 'application/json';
			$data['ext']  = 'json';
		}

		return $data;
	}

}

