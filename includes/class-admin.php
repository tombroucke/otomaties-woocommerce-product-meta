<?php
namespace Otomaties\WooCommerce_Product_meta;

class Admin {
	public function __construct() {
		add_action( 'woocommerce_product_options_general_product_data', array( $this, 'custom_meta_field' ) );
		add_action( 'woocommerce_process_product_meta', array( $this, 'save_custom_meta_field' ) );
		add_filter( 'woocommerce_get_item_data', array( $this, 'display_custom_meta_field' ) , 25, 2 );
		add_action( 'woocommerce_checkout_create_order_line_item', array( $this, 'save_cart_item_custom_meta_field' ), 10, 4 );
		add_action( 'woocommerce_order_item_meta_end', array( $this, 'display_cart_item_custom_meta_field' ), 10, 3 );
	}

	public function custom_meta_field() {
		woocommerce_wp_text_input(
			array(
				'id'          => '_custom_meta_field',
				'label'       => __( 'Custom meta field', 'wc-product-meta' ),
				'placeholder' => __( 'Custom meta field', 'wc-product-meta' )
			)
		);
	}

	public function save_custom_meta_field( $post_id ) {
		$custom_meta_field = filter_input( INPUT_POST, '_custom_meta_field', FILTER_SANITIZE_STRING );
		if( $custom_meta_field && $custom_meta_field != '' ) {
			update_post_meta( $post_id, '_custom_meta_field', $custom_meta_field );
		}
		else {
			delete_post_meta( $post_id, '_custom_meta_field' );
		}
	}

	public function display_custom_meta_field( $cart_data, $cart_item ) {
		$product = $cart_item['data'];
		$custom_meta_field = get_post_meta( $product->get_ID(), '_custom_meta_field', true );
		if( $custom_meta_field ) {
			$cart_data[] = array(
				'key'     => 'custom_meta_field',
				'name'    => __('Information', 'wc-product-meta'),
				'display' => $custom_meta_field
			);
		}
		return $cart_data;
	}

	public function save_cart_item_custom_meta_field( $cart_item, $cart_item_key, $values, $order ) {

		$product = $cart_item->get_product();
		$custom_meta_field = get_post_meta( $product->get_ID(), '_custom_meta_field', true );
		if( $custom_meta_field ) {
			$cart_item->update_meta_data( '_custom_meta_field', $custom_meta_field );
		}
	}

	public function display_cart_item_custom_meta_field( $item_id, $item, $order ) {
		$meta_field = wc_get_order_item_meta( $item_id, '_custom_meta_field', true );
		if( $meta_field ) {
			?>
			<div class="custom_meta_field">
				<ul class="wc-item-meta">
					<li><?php echo $meta_field; ?></li>
				</ul>
			</div>
			<?php
		}
	}
}
