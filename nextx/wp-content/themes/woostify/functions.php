<?php
/**
 * Woostify
 *
 * @package woostify
 */

// Define constants.
define( 'WOOSTIFY_VERSION', '2.3.2' );
define( 'WOOSTIFY_PRO_MIN_VERSION', '1.7.2' );
define( 'WOOSTIFY_THEME_DIR', get_template_directory() . '/' );
define( 'WOOSTIFY_THEME_URI', get_template_directory_uri() . '/' );

// Woostify svgs icon.
require_once WOOSTIFY_THEME_DIR . 'inc/class-woostify-icon.php';

// Woostify functions, hooks.
require_once WOOSTIFY_THEME_DIR . 'inc/woostify-functions.php';
require_once WOOSTIFY_THEME_DIR . 'inc/woostify-template-hooks.php';
require_once WOOSTIFY_THEME_DIR . 'inc/woostify-template-builder.php';
require_once WOOSTIFY_THEME_DIR . 'inc/woostify-template-functions.php';

// Woostify generate css.
require_once WOOSTIFY_THEME_DIR . 'inc/customizer/class-woostify-webfont-loader.php';
require_once WOOSTIFY_THEME_DIR . 'inc/customizer/class-woostify-fonts-helpers.php';
require_once WOOSTIFY_THEME_DIR . 'inc/customizer/class-woostify-get-css.php';

// Woostify customizer.
require_once WOOSTIFY_THEME_DIR . 'inc/class-woostify.php';
require_once WOOSTIFY_THEME_DIR . 'inc/customizer/class-woostify-customizer.php';

// Woostify woocommerce.
if ( woostify_is_woocommerce_activated() ) {
	require_once WOOSTIFY_THEME_DIR . 'inc/woocommerce/class-woostify-woocommerce.php';
	require_once WOOSTIFY_THEME_DIR . 'inc/woocommerce/class-woostify-adjacent-products.php';
	require_once WOOSTIFY_THEME_DIR . 'inc/woocommerce/woostify-woocommerce-template-functions.php';
	require_once WOOSTIFY_THEME_DIR . 'inc/woocommerce/woostify-woocommerce-archive-product-functions.php';
	require_once WOOSTIFY_THEME_DIR . 'inc/woocommerce/woostify-woocommerce-single-product-functions.php';
	require_once WOOSTIFY_THEME_DIR . 'inc/woocommerce/woostify-woocommerce-query-update.php';
}

// Woostify admin.
if ( is_admin() ) {
	require_once WOOSTIFY_THEME_DIR . 'inc/admin/class-woostify-admin.php';
	require_once WOOSTIFY_THEME_DIR . 'inc/admin/class-woostify-meta-boxes.php';
}

// Compatibility.
require_once WOOSTIFY_THEME_DIR . 'inc/compatibility/class-woostify-divi-builder.php';

/**
 * Note: Do not add any custom code here. Please use a custom plugin so that your customizations aren't lost during updates.
 */

add_action('template_redirect','webrpoint');

function webrpoint(){
         if(is_product_category('ted-baker'))
        {
          $url=site_url('ted-baker');
          wp_safe_redirect($url);
          exit();
   }

}

add_action('template_redirect','web');

function web(){
         if(is_product_category('marc-darcy'))
        {
          $url=site_url('marc-darcy');
          wp_safe_redirect($url);
          exit();
   }

}
add_action('template_redirect','suitsfrom149');

function suitsfrom149(){
         if(is_product_category('suits-from-149'))
        {
          $url=site_url('affordable-suits');
          wp_safe_redirect($url);
          exit();
   }

}
add_action('template_redirect','alexandreofengland');

function alexandreofengland(){
         if(is_product_category('alexandre-of-england'))
        {
          $url=site_url('alexandre-of-england');
          wp_safe_redirect($url);
          exit();
   }

}
add_action('template_redirect','antiquerogue');

function antiquerogue(){
         if(is_product_category('antique-rogue'))
        {
          $url=site_url('antique-rogue');
          wp_safe_redirect($url);
          exit();
   }

}
add_action('template_redirect','blacksuits');

function blacksuits(){
         if(is_product_category('black-suits'))
        {
          $url=site_url('black-suits');
          wp_safe_redirect($url);
          exit();
   }

}
add_action('template_redirect','farah');

function farah(){
         if(is_product_category('farah'))
        {
          $url=site_url('farah');
          wp_safe_redirect($url);
          exit();
   }

}
add_action('template_redirect','knitwear');

function knitwear(){
         if(is_product_category('knitwear'))
        {
          $url=site_url('knitwear');
          wp_safe_redirect($url);
          exit();
   }

}
add_action('template_redirect','limehaus');

function limehaus(){
         if(is_product_category('limehaus'))
        {
          $url=site_url('limehaus');
          wp_safe_redirect($url);
          exit();
   }

}
add_action('template_redirect','newarrivals');

function newarrivals(){
         if(is_product_category('new-arrivals'))
        {
          $url=site_url('new-arrivals');
          wp_safe_redirect($url);
          exit();
   }

}
add_action('template_redirect','shirts');

function shirts(){
         if(is_product_category('shirts'))
        {
          $url=site_url('shirts');
          wp_safe_redirect($url);
          exit();
   }

}
add_action('template_redirect','suits');

function suits(){
         if(is_product_category('suits'))
        {
          $url=site_url('suits');
          wp_safe_redirect($url);
          exit();
   }

}
add_action('template_redirect','tuxedos');

function tuxedos(){
         if(is_product_category('tuxedos'))
        {
          $url=site_url('tuxedos');
          wp_safe_redirect($url);
          exit();
   }

}
add_action('template_redirect','weddingsuits');

function weddingsuits(){
         if(is_product_category('wedding'))
        {
          $url=site_url('wedding-suits');
          wp_safe_redirect($url);
          exit();
   }

}

function my_account(){
  echo do_shortcode('[INSERT_ELEMENTOR id="3191"]');
}
add_action('woocommerce_account_dashboard','my_account');


