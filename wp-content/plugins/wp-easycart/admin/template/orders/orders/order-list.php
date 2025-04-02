<?php
$table = new wp_easycart_admin_table();
$table->set_table( 'ec_order', 'order_id' );
$table->set_table_id( 'ec_admin_order_list' );
$table->set_default_sort( 'order_id', 'DESC' );
$table->set_icon( 'tag' );
$table->set_add_new(false, '', '' );
$table->set_docs_link( 'orders','order-management' );
$table->set_join( 'LEFT JOIN ec_orderstatus ON (ec_orderstatus.status_id = ec_order.orderstatus_id)' );
$table->enable_mobile_column();
$columns = array();
$columns[] = array(
	'name' => 'order_viewed', 
	'label' => '',
	'is_mobile' => false,
	'format' => 'order_viewed',
);
$columns[] = array(
	'name' => 'order_id', 
	'label' => __( 'Order ID', 'wp-easycart' ),
	'format' => 'int',
	'linked' => true,
	'is_mobile' => true,
	'subactions' => array(
		array(
			'click' => 'return false',
			'name' => __( 'Quick Edit', 'wp-easycart' ),
			'action_type' => 'quick-edit',
			'action' => 'quick-edit-order',
			'type' => 'order',
		),
		array(
			'click' => 'return false',
			'name' => __( 'Delete', 'wp-easycart' ),
			'action_type' => 'delete',
			'action' => 'delete-order',
		),
	),
	'mobile_extra' => array(
		array(
			'select' => 'ec_orderstatus.order_status',
			'name' => 'order_status',
			'label' => __( 'Order Status', 'wp-easycart' ),
			'is_mobile' => true,
			'format' => 'order_status',
		),
	),
);
$columns[] = array(
	'select' => "ec_order.order_date AS order_date",
	'name' => 'order_date', 
	'label' => __( 'Order Date', 'wp-easycart' ),
	'is_mobile' => true,
	'format' => 'datetime',
	'localize_timestamp' => true,
);
if ( get_option( 'ec_option_admin_orders_list_enable_pickup_date' ) ) {
	$columns[] = array(
		'select' => "ec_order.pickup_date",
		'name' => 'pickup_date', 
		'label' => __( 'Pick Up Date', 'wp-easycart' ),
		'tablet_hide' => true,
		'is_mobile' => true,
		'format' => 'datetime',
		'requires' => 'includes_preorder_items',
	);
	$columns[] = array(
		'select' => 'ec_order.includes_preorder_items',
		'name' => 'includes_preorder_items',
		'label' => __( 'Includes Preorder Items', 'wp-easycart' ),
		'is_mobile' => false,
		'format' => 'hidden',
	);
}
if ( get_option( 'ec_option_admin_orders_list_enable_pickup_time' ) ) {
	$columns[] = array(
		'select' => "ec_order.pickup_time",
		'name' => 'pickup_time', 
		'label' => __( 'Restaurant Time', 'wp-easycart' ),
		'tablet_hide' => false,
		'is_mobile' => true,
		'format' => 'datetime',
		'requires' => 'includes_restaurant_type',
	);
	$columns[] = array(
		'select' => 'ec_order.includes_restaurant_type',
		'name' => 'includes_restaurant_type',
		'label' => __( 'Includes Restaurant Type', 'wp-easycart' ),
		'is_mobile' => false,
		'format' => 'hidden',
	);
}
$columns[] = array(
	'name' => 'grand_total',
	'label' => __( 'Order Total', 'wp-easycart' ),
	'is_mobile' => true,
	'format' => 'currency',
);
$columns[] = array(
	'name' => 'billing_first_name',
	'label' => __( 'First Name', 'wp-easycart' ),
	'laptop_hide' => ( get_option( 'ec_option_admin_orders_list_enable_pickup_date' ) || get_option( 'ec_option_admin_orders_list_enable_pickup_time' ) ) ? true : false,
	'tablet_hide' => true,
	'is_mobile' => true,
	'format' => 'string',
);
$columns[] = array(
	'name' => 'billing_last_name',
	'label' => __( 'Last Name', 'wp-easycart' ),
	'laptop_hide' => ( get_option( 'ec_option_admin_orders_list_enable_pickup_date' ) || get_option( 'ec_option_admin_orders_list_enable_pickup_time' ) ) ? true : false,
	'tablet_hide' => ( get_option( 'ec_option_admin_orders_list_enable_pickup_date' ) || get_option( 'ec_option_admin_orders_list_enable_pickup_time' ) ) ? true : false,
	'is_mobile' => true,
	'format' => 'string',
);
$columns[] = array(
	'select' => 'ec_orderstatus.is_approved, ec_order.orderstatus_id',
	'name' => 'orderstatus_id',
	'label' => __( 'Payment Status', 'wp-easycart' ),
	'tablet_hide' => true,
	'is_mobile' => true,
	'format' => 'payment_status',
);
$columns[] = array(
	'select' => 'ec_orderstatus.order_status',
	'name' => 'order_status',
	'label' => __( 'Order Status', 'wp-easycart' ),
	'is_mobile' => false,
	'format' => 'order_status',
);
$columns[] = array(
	'select' => 'ec_orderstatus.color_code',
	'name' => 'color_code',
	'label' => __( 'Color Code', 'wp-easycart' ),
	'is_mobile' => false,
	'format' => 'hidden',
);
$table->set_list_columns( $columns );

global $wpdb;
$order_status = $wpdb->get_results( "SELECT ec_orderstatus.status_id AS value, ec_orderstatus.order_status AS label FROM ec_orderstatus ORDER BY status_id ASC" );
$products = $wpdb->get_results( "SELECT product_id AS value, title AS label FROM ec_product ORDER BY title ASC LIMIT 500" );
$users = $wpdb->get_results( "SELECT user_id AS value, CONCAT(last_name, ', ', first_name) AS label FROM ec_user ORDER BY last_name, first_name ASC LIMIT 500" );

$table->set_filters(
	array(
		array(
			'data'		=> $order_status,
			'label'		=> __( 'Order Status', 'wp-easycart' ),
			'where'		=> 'ec_order.orderstatus_id = %s'
		),
		array(
			'data'		=> $products,
			'label'		=> __( 'Purchased Product', 'wp-easycart' ),
			'where'		=> 'ec_orderdetail.product_id = %s',
			'where2'	=> 'ec_orderdetail.model_number = %s',
			'join'		=> 'LEFT JOIN ec_orderdetail ON ec_orderdetail.order_id = ec_order.order_id',
		),
		array(
			'data'		=> $users,
			'label'		=> __( 'By Customer', 'wp-easycart' ),
			'where'		=> 'ec_order.user_id = %d'
		)

	)
);

$table->set_search_columns(
	array( 'ec_order.order_id', 'ec_order.user_email', 'ec_order.billing_first_name', 'ec_order.billing_last_name', 'ec_order.shipping_first_name', 'ec_order.shipping_last_name', 'ec_orderstatus.order_status', 'ec_order.billing_company_name', 'ec_order.shipping_company_name' )
);
$table->set_bulk_actions(
	apply_filters( 'wp_easycart_admin_bulk_order_options', array(
		array(
			'name'	=> 'delete-order',
			'label'	=> __( 'Delete', 'wp-easycart' )
		),
		array(
			'name'	=> 'resend-email',
			'label'	=> __( 'Resend Email Receipt', 'wp-easycart' )
		),
		array(
			'name'	=> 'print-receipt',
			'label'	=> __( 'Print Receipt', 'wp-easycart' )
		),
		array(
			'name'	=> 'print-packing-slip',
			'label'	=> __( 'Print Packing Slip', 'wp-easycart' )
		),
		array(
			'name'	=> 'send-shipped-email',
			'label'	=> __( 'Send Order Shipped Email', 'wp-easycart' )
		),
		array(
			'name'	=> 'change-order-status',
			'label'	=> __( 'Change Order Status', 'wp-easycart' ),
			'alt'	=> array(
				'id'	 	=> 'bulk_order_status',
				'options'	=> $order_status
			)
		),
		array(
			'name'	=> 'export-orders-csv',
			'label'	=> __( 'Export Selected CSV', 'wp-easycart' )
		),
		array(
			'name'	=> 'export-orders-csv-all',
			'label'	=> __( 'Export All CSV', 'wp-easycart' )
		),
		array(
			'name'	=> 'mark-orders-viewed',
			'label'	=> __( 'Mark Selected Viewed', 'wp-easycart' )
		),
		array(
			'name'	=> 'mark-orders-not-viewed',
			'label'	=> __( 'Mark Selected Not Viewed', 'wp-easycart' )
		),
		array(
			'name'	=> 'mark-all-orders-viewed',
			'label'	=> __( 'Mark All Viewed', 'wp-easycart' )
		),
		array(
			'name'	=> 'mark-all-orders-not-viewed',
			'label'	=> __( 'Mark All Not Viewed', 'wp-easycart' )
		)
	) )
);
$table->set_actions(
	array(
		array(
			'name'	=> 'quick-edit',
			'label'	=> __( 'Quick Edit', 'wp-easycart' ),
			'icon' 	=> 'feedback',
			'type'	=> 'order'
		),
		array(
			'name'	=> 'edit',
			'label'	=> __( 'Edit', 'wp-easycart' ),
			'icon' 	=> 'edit'
		),
		array(
			'name'	=> 'delete-order',
			'label'	=> __( 'Delete', 'wp-easycart' ),
			'icon'  => 'trash'
		)
	)
);

$table->set_label( __( 'Order', 'wp-easycart' ), __( 'Orders', 'wp-easycart' ) );
if( !get_option( 'ec_option_review_complete' ) ){
?>
<div class="wp-easycart-admin-review-us-box">
	<?php esc_attr_e( 'Do you like WP EasyCart? If you do, please take a moment to', 'wp-easycart' ); ?> <a href="https://wordpress.org/support/plugin/wp-easycart/reviews/" target="_blank"><?php esc_attr_e( 'submit a review', 'wp-easycart' ); ?></a>, <?php esc_attr_e( 'it really helps us!', 'wp-easycart' ); ?>
	<div class="wp-easycart-admin-review-us-close" onclick="wp_easycart_admin_close_review( '<?php echo esc_attr( wp_create_nonce( 'wp-easycart-review-us' ) ); ?>' );"><div class="dashicons dashicons-no"></div></div>
</div>
<?php
}
$table->print_table( );
wp_easycart_admin( )->load_new_slideout( 'order' );
?>
<script>
jQuery( document.getElementById( 'ec_form_action' ) ).on( 'change', function( ){
	if( jQuery( this ).val( ) == 'change-order-status' ){
		jQuery( document.getElementById( 'bulk_order_status' ) ).show( );
	}else{
		jQuery( document.getElementById( 'bulk_order_status' ) ).hide( );
	}
} );
</script>