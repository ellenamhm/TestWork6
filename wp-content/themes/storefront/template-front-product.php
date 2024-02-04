<?php
/**

 * Template name: StoreFront

 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
	
		<?php
		    the_content();

			  // if(!function_exists('wc_get_products')) {
			  //   return;
			  // }

			  // $paged                   = (get_query_var('paged')) ? absint(get_query_var('paged')) : 1;
			  // $ordering                = WC()->query->get_catalog_ordering_args();
			  // $tmp = explode(' ', $ordering['orderby']);

			  // $ordering['orderby']     = array_shift($tmp);
			  // $ordering['orderby']     = stristr($ordering['orderby'], 'price') ? 'meta_value_num' : $ordering['orderby'];
			  // $products_per_page       = apply_filters('loop_shop_per_page', wc_get_default_products_per_row() * wc_get_default_product_rows_per_page());

			  // $all_products       = wc_get_products(array(
			  //   'meta_key'             => '_price',
			  //   'status'               => 'publish',			
			  //   'limit'                => $products_per_page,
			  //   'page'                 => $paged,
			  //   'paginate'             => true,
			  //   'return'               => 'ids',
			  //   'orderby'              => $ordering['orderby'],
			  //   'order'                => $ordering['order'],
			  // ));



			  // wc_set_loop_prop('current_page', $paged);
			  // wc_set_loop_prop('is_paginated', wc_string_to_bool(true));
			  // wc_set_loop_prop('page_template', get_page_template_slug());
			  // wc_set_loop_prop('per_page', $products_per_page);
			  // wc_set_loop_prop('total', $all_products->total);
			  // wc_set_loop_prop('total_pages', $all_products->max_num_pages);
			  // wc_set_loop_prop('base', esc_url_raw( add_query_arg( 'product-page', '%#%', false ) ));
			  // wc_set_loop_prop('format','?product-page=%#%');


			  // if($all_products) {
			  //   do_action('woocommerce_before_shop_loop');
			  //   woocommerce_product_loop_start();
			  //     foreach($all_products->products as $elem_product) {
			  //       $post_object = get_post($elem_product);
			  //       setup_postdata($GLOBALS['post'] =& $post_object);
			  //       wc_get_template_part('content', 'product');
			  //     }
			  //     wp_reset_postdata();
			  //   woocommerce_product_loop_end();
			  //   do_action('woocommerce_after_shop_loop');
			  // } else {
			  //   do_action('woocommerce_no_products_found');
			  // }

		 ?>

		</main><!-- #main -->
	</div><!-- #primary -->
<?php
get_footer();
