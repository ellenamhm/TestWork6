<?php
/**
 * Storefront engine room
 *
 * @package storefront
 */

/**
 * Assign the Storefront version to a var
 */
$theme              = wp_get_theme( 'storefront' );
$storefront_version = $theme['Version'];

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 980; /* pixels */
}

$storefront = (object) array(
	'version'    => $storefront_version,

	/**
	 * Initialize all the things.
	 */
	'main'       => require 'inc/class-storefront.php',
	'customizer' => require 'inc/customizer/class-storefront-customizer.php',
);

require 'inc/storefront-functions.php';
require 'inc/storefront-template-hooks.php';
require 'inc/storefront-template-functions.php';
require 'inc/wordpress-shims.php';

if ( class_exists( 'Jetpack' ) ) {
	$storefront->jetpack = require 'inc/jetpack/class-storefront-jetpack.php';
}

if ( storefront_is_woocommerce_activated() ) {
	$storefront->woocommerce            = require 'inc/woocommerce/class-storefront-woocommerce.php';
	$storefront->woocommerce_customizer = require 'inc/woocommerce/class-storefront-woocommerce-customizer.php';

	require 'inc/woocommerce/class-storefront-woocommerce-adjacent-products.php';

	require 'inc/woocommerce/storefront-woocommerce-template-hooks.php';
	require 'inc/woocommerce/storefront-woocommerce-template-functions.php';
	require 'inc/woocommerce/storefront-woocommerce-functions.php';
}

if ( is_admin() ) {
	$storefront->admin = require 'inc/admin/class-storefront-admin.php';

	require 'inc/admin/class-storefront-plugin-install.php';
}

/**
 * NUX
 * Only load if wp version is 4.7.3 or above because of this issue;
 * https://core.trac.wordpress.org/ticket/39610?cversion=1&cnum_hist=2
 */
if ( version_compare( get_bloginfo( 'version' ), '4.7.3', '>=' ) && ( is_admin() || is_customize_preview() ) ) {
	require 'inc/nux/class-storefront-nux-admin.php';
	require 'inc/nux/class-storefront-nux-guided-tour.php';
	require 'inc/nux/class-storefront-nux-starter-content.php';
}





function include_myuploadscript() {
    // wp_enqueue_script('jquery');
    if ( ! did_action( 'wp_enqueue_media' ) ) {
        wp_enqueue_media();
    }
    wp_enqueue_script( 'myuploadscript', get_stylesheet_directory_uri() . '/js/custom.js', array('jquery'), null, false );
}
 
add_action( 'admin_enqueue_scripts', 'include_myuploadscript' );


function include_myscript() {
    // wp_enqueue_script('jquery');
    if ( ! did_action( 'wp_enqueue_media' ) ) {
        wp_enqueue_media();
    }

    wp_enqueue_script('my_assets', get_stylesheet_directory_uri() . '/js/main.js', array(), '', true, false);

    wp_localize_script('my_assets', 'MyAjax', array(
        'ajaxurl' => site_url() . '/wp-admin/admin-ajax.php', // WordPress AJAX
		// 'page_shop' =>  link_page_shop(),
    ));
}
 
add_action( 'wp_enqueue_scripts', 'include_myscript' );



if( wp_doing_ajax() ){
	add_action('wp_ajax_addprod', 'addprod');
	add_action('wp_ajax_nopriv_addprod', 'addprod');
}
function addprod(){
	$userAdmin = current_user_can('administrator');
    if ( is_user_logged_in() ||  $userAdmin) {  
		$product = new WC_Product_Simple();

		if (isset($_POST['title_product']) && !empty(isset($_POST['title_product']))) {
			$product->set_name($_POST['title_product']);
		}
		if (isset($_POST['price_product']) && !empty(isset($_POST['price_product']))) {
			$product->set_regular_price($_POST['price_product']);
		}
		if (isset($_POST['uploader_custom']) && !empty(isset($_POST['uploader_custom']))) {
			$product->set_image_id($_POST['uploader_custom']);
		}
		$product->save();
		$product_id    = $product->get_id();
		if (isset($_POST['date_product']) && !empty(isset($_POST['date_product']))) {
			update_post_meta( $product_id, 'custom_date', $_POST['date_product']);
		}
		if (isset($_POST['select_product']) && !empty(isset($_POST['select_product']))) {
			update_post_meta( $product_id, 'custom_select', $_POST['select_product']);
		}
		wp_send_json_success( $product_id );
		die();
	}
}





	add_action( 'add_meta_boxes', 'my_custom_meta' );
	
	function my_custom_meta() {
		add_meta_box( 'imagesdiv', 'Image', 'my_custom_print', 'product', 'side', 'default' );
	}


	function my_custom_print( $post ) {
		if( function_exists( 'my_custom_uploader_field' ) ) {
			my_custom_uploader_field( array(
				'name' => 'uploader_custom',
				'value_img' => get_post_meta( $post->ID, 'uploader_custom', true ),
				'value_date' => get_post_meta( $post->ID, 'custom_date', true ),
				'value_select' => get_post_meta( $post->ID, 'custom_select', true ),
			) );
		}
	}




	add_action('save_post', 'my_custom_save');

	function my_custom_save( $post_id ) {
		global $post;
		// if ( ! current_user_can( $post_type->cap->edit_post, $post_id ) ) {
		// 	return $post_id;
		// }

		if( 'product' !== $post->post_type ) {
			return $post_id;
		}

		if( isset( $_POST[ 'uploader_custom' ] ) ) {
			update_post_meta( $post_id, 'uploader_custom', absint( $_POST[ 'uploader_custom' ] ) );
		} else {
			delete_post_meta( $post_id, 'uploader_custom' );
		}
		if( isset( $_POST[ 'custom_date' ] ) ) {
			update_post_meta( $post_id, 'custom_date', $_POST[ 'custom_date' ] );
		} else {
			delete_post_meta( $post_id, 'custom_date' );
		}
		if( isset( $_POST[ 'custom_select' ] ) ) {
			update_post_meta( $post_id, 'custom_select', $_POST[ 'custom_select' ] );
		} else {
			delete_post_meta( $post_id, 'custom_select' );
		}
		return $post_id;
	}

	function my_custom_uploader_field( $args ) {
		global $post;
		$value = $args[ 'value_img' ];
		$default = get_site_url() . '/wp-content/uploads/woocommerce-placeholder.png';
	 
		if( $value && ( $image_attributes = wp_get_attachment_image_src( $value, array( 150, 110 ) ) ) ) {
			$src = $image_attributes[0];
		} else {
			$src = $default;
		}
		echo '
		<div id="up_img_custom">
			<img src="' . $src . '" width="150" />
			<div>
				<input type="hidden" data-src="' . $default  . '" name="uploader_custom" id="uploader_custom" value="' . $value . '" />
				<button type="submit" class="upload_image_button button">Загрузить</button>
				<button type="submit" class="remove_image_button button">×</button>
			</div>
		</div>
		';


        $date_today = date("Y-m-d");
		woocommerce_wp_text_input(
			array(
				'id'        => 'custom_date',
				'label' => '',
				'name'        => 'custom_date',
				'value'     =>   $args[ 'value_date' ] ? $args[ 'value_date' ]  :  $date_today ,
				'type' => 'date',
			)
		);
		print_r($args[ 'value_select' ]);

		woocommerce_wp_select( array(
			'id'      => 'custom_select',
			'label' => '',
			'name'    => 'custom_select',
			'value' =>  $args[ 'value_select' ] ? $args[ 'value_select' ]  :  ' '  ,
			'options' => array(
				'' => 'Выберите...',
				'ra' => 'rare',
				'fr' => 'frequent',
				'un' => 'unusua'
			)
		) );

		echo '
		<div><button id="remove_custom"  class="remove_fields_button button">Очистить поля</button></div>';

		echo '
		<div><button class="button button-primary button-large" id="update_custom" >Обновить</button></div>';

	}

    add_action( 'admin_bar_menu', 'add_admin_bar_link', 110 );
 
    function add_admin_bar_link( $wp_admin_bar ) {
	 if (!is_admin()) {
		    $args = array(
		     'id' => 'mytestmenu',
		     'title' => 'добавить товар форма',
		     'href' => site_url( 'create-form' )
		    );
		    $wp_admin_bar->add_node( $args );
	    }
	}

add_filter( 'wp_list_pages_excludes', 'list_pages_excludes_filter' );

function list_pages_excludes_filter( $exclude_array ){
	$userAdmin = current_user_can('administrator');
	    if ( !is_user_logged_in() ||  !$userAdmin) {  

	    $exclude_array[] = 169;
	}

	return $exclude_array;
}