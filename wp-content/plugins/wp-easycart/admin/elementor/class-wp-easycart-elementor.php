<?php
/**
 * WP EasyCart Wrap Class for Elementor
 *
 * @category Class
 * @package  WP_EasyCart_Elementor
 * @author   WP EasyCart
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Core\Files\CSS\Global_CSS;
use Elementor\Core\Settings\Manager as SettingsManager;

/**
 * WP EasyCart Wrap Class for Elementor
 *
 * @category Class
 * @package  Wp_Easycart_Controls_Manager
 * @author   WP EasyCart
 */
class WP_EasyCart_Elementor {

	/**
	 * WP EasyCart Elementor Constructor
	 */
	public function __construct() {
		add_action( 'elementor/editor/before_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_action( 'elementor/controls/controls_registered', array( $this, 'register_elementor_controls' ) );
		add_action( 'elementor/widgets/widgets_registered', array( $this, 'register_elementor_widgets' ), 10, 1 );
		add_action( 'elementor/elements/categories_registered', array( $this, 'register_elementor_categories' ), 10, 1 );

		include( EC_PLUGIN_DIRECTORY . '/admin/elementor/class-wp-easycart-controls-manager.php' );
	}

	/**
	 * Create Elementor Category for WP EasyCart
	 *
	 * @param object $self reference to the elementor editor.
	 */
	public function register_elementor_categories( $self ) {

		$self->add_category(
			'wp-easycart-elements',
			array(
				'title'  => __( 'WP EasyCart', 'wp-easycart' ),
				'active' => true,
			)
		);

	}

	/**
	 * Enqueue scripts for WP EasyCart Elementor Widgets.
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( 'wpeasycart_owl_carousel_js', plugins_url( 'wp-easycart/design/theme/' . get_option( 'ec_option_latest_theme' ) . '/owl.carousel.min.js', EC_PLUGIN_DIRECTORY ), array( 'jquery' ), EC_CURRENT_VERSION, false );
		wp_register_style( 'wpeasycart_owl_carousel_css', plugins_url( 'wp-easycart/design/theme/' . get_option( 'ec_option_latest_theme' ) . '/owl.carousel.css', EC_PLUGIN_DIRECTORY ), array(), EC_CURRENT_VERSION );
		wp_enqueue_style( 'wpeasycart_owl_carousel_css' );
	}

	/**
	 * Register WP EasyCart Elementor Controls.
	 *
	 * @param object $self reference to the elementor editor.
	 */
	public function register_elementor_controls( $self ) {

		include( EC_PLUGIN_DIRECTORY . '/admin/elementor/class-wpeasycart-control-ajax-select2.php' );
		$class_name = '\WPEasyCart_Control_Ajax_Select2';
		$self->register_control( 'wpecajaxselect2', new $class_name() );

	}

	/**
	 * Register WP EasyCart Elementor Widgets.
	 *
	 * @param object $self reference to the elementor editor.
	 */
	public function register_elementor_widgets( $self ) {

		if ( ! defined( 'ELEMENTOR_VERSION' ) ) {
			return;
		}

		include( EC_PLUGIN_DIRECTORY . '/admin/elementor/class-wp-easycart-elementor-store-widget.php' );
		$class_name = 'Wp_Easycart_Elementor_Store_Widget';
		$self->register_widget_type( new $class_name( array(), array( 'widget_name' => $class_name ) ) );

		include( EC_PLUGIN_DIRECTORY . '/admin/elementor/class-wp-easycart-elementor-product-widget.php' );
		$class_name = 'Wp_Easycart_Elementor_Product_Widget';
		$self->register_widget_type( new $class_name( array(), array( 'widget_name' => $class_name ) ) );

		include( EC_PLUGIN_DIRECTORY . '/admin/elementor/class-wp-easycart-elementor-product-details-widget.php' );
		$class_name = 'Wp_Easycart_Elementor_Product_Details_Widget';
		$self->register_widget_type( new $class_name( array(), array( 'widget_name' => $class_name ) ) );

		include( EC_PLUGIN_DIRECTORY . '/admin/elementor/class-wp-easycart-elementor-product-details-breadcrumbs-widget.php' );
		$class_name = 'Wp_Easycart_Elementor_Product_Details_Breadcrumbs_Widget';
		$self->register_widget_type( new $class_name( array(), array( 'widget_name' => $class_name ) ) );

		include( EC_PLUGIN_DIRECTORY . '/admin/elementor/class-wp-easycart-elementor-product-details-title-widget.php' );
		$class_name = 'Wp_Easycart_Elementor_Product_Details_Title_Widget';
		$self->register_widget_type( new $class_name( array(), array( 'widget_name' => $class_name ) ) );

		include( EC_PLUGIN_DIRECTORY . '/admin/elementor/class-wp-easycart-elementor-product-details-tabs-widget.php' );
		$class_name = 'Wp_Easycart_Elementor_Product_Details_Tabs_Widget';
		$self->register_widget_type( new $class_name( array(), array( 'widget_name' => $class_name ) ) );

		include( EC_PLUGIN_DIRECTORY . '/admin/elementor/class-wp-easycart-elementor-product-details-description-widget.php' );
		$class_name = 'Wp_Easycart_Elementor_Product_Details_Description_Widget';
		$self->register_widget_type( new $class_name( array(), array( 'widget_name' => $class_name ) ) );

		include( EC_PLUGIN_DIRECTORY . '/admin/elementor/class-wp-easycart-elementor-product-details-specifications-widget.php' );
		$class_name = 'Wp_Easycart_Elementor_Product_Details_Specifications_Widget';
		$self->register_widget_type( new $class_name( array(), array( 'widget_name' => $class_name ) ) );

		include( EC_PLUGIN_DIRECTORY . '/admin/elementor/class-wp-easycart-elementor-product-details-customer-reviews-widget.php' );
		$class_name = 'Wp_Easycart_Elementor_Product_Details_Customer_Reviews_Widget';
		$self->register_widget_type( new $class_name( array(), array( 'widget_name' => $class_name ) ) );

		include( EC_PLUGIN_DIRECTORY . '/admin/elementor/class-wp-easycart-elementor-product-details-images-widget.php' );
		$class_name = 'Wp_Easycart_Elementor_Product_Details_Images_Widget';
		$self->register_widget_type( new $class_name( array(), array( 'widget_name' => $class_name ) ) );

		include( EC_PLUGIN_DIRECTORY . '/admin/elementor/class-wp-easycart-elementor-product-details-price-widget.php' );
		$class_name = 'Wp_Easycart_Elementor_Product_Details_Price_Widget';
		$self->register_widget_type( new $class_name( array(), array( 'widget_name' => $class_name ) ) );

		include( EC_PLUGIN_DIRECTORY . '/admin/elementor/class-wp-easycart-elementor-product-details-rating-widget.php' );
		$class_name = 'Wp_Easycart_Elementor_Product_Details_Rating_Widget';
		$self->register_widget_type( new $class_name( array(), array( 'widget_name' => $class_name ) ) );

		include( EC_PLUGIN_DIRECTORY . '/admin/elementor/class-wp-easycart-elementor-product-details-stock-widget.php' );
		$class_name = 'Wp_Easycart_Elementor_Product_Details_Stock_Widget';
		$self->register_widget_type( new $class_name( array(), array( 'widget_name' => $class_name ) ) );

		include( EC_PLUGIN_DIRECTORY . '/admin/elementor/class-wp-easycart-elementor-product-details-short-description-widget.php' );
		$class_name = 'Wp_Easycart_Elementor_Product_Details_Short_Description_Widget';
		$self->register_widget_type( new $class_name( array(), array( 'widget_name' => $class_name ) ) );

		include( EC_PLUGIN_DIRECTORY . '/admin/elementor/class-wp-easycart-elementor-product-details-sku-widget.php' );
		$class_name = 'Wp_Easycart_Elementor_Product_Details_Sku_Widget';
		$self->register_widget_type( new $class_name( array(), array( 'widget_name' => $class_name ) ) );

		include( EC_PLUGIN_DIRECTORY . '/admin/elementor/class-wp-easycart-elementor-product-details-social-widget.php' );
		$class_name = 'Wp_Easycart_Elementor_Product_Details_Social_Widget';
		$self->register_widget_type( new $class_name( array(), array( 'widget_name' => $class_name ) ) );

		include( EC_PLUGIN_DIRECTORY . '/admin/elementor/class-wp-easycart-elementor-product-details-category-widget.php' );
		$class_name = 'Wp_Easycart_Elementor_Product_Details_Category_Widget';
		$self->register_widget_type( new $class_name( array(), array( 'widget_name' => $class_name ) ) );

		include( EC_PLUGIN_DIRECTORY . '/admin/elementor/class-wp-easycart-elementor-product-details-manufacturer-widget.php' );
		$class_name = 'Wp_Easycart_Elementor_Product_Details_Manufacturer_Widget';
		$self->register_widget_type( new $class_name( array(), array( 'widget_name' => $class_name ) ) );

		include( EC_PLUGIN_DIRECTORY . '/admin/elementor/class-wp-easycart-elementor-product-details-meta-widget.php' );
		$class_name = 'Wp_Easycart_Elementor_Product_Details_Meta_Widget';
		$self->register_widget_type( new $class_name( array(), array( 'widget_name' => $class_name ) ) );

		include( EC_PLUGIN_DIRECTORY . '/admin/elementor/class-wp-easycart-elementor-product-details-featured-products-widget.php' );
		$class_name = 'Wp_Easycart_Elementor_Product_Details_Featured_Products_Widget';
		$self->register_widget_type( new $class_name( array(), array( 'widget_name' => $class_name ) ) );

		include( EC_PLUGIN_DIRECTORY . '/admin/elementor/class-wp-easycart-elementor-product-addtocart-widget.php' );
		$class_name = 'Wp_Easycart_Elementor_Product_Addtocart_Widget';
		$self->register_widget_type( new $class_name( array(), array( 'widget_name' => $class_name ) ) );

		include( EC_PLUGIN_DIRECTORY . '/admin/elementor/class-wp-easycart-elementor-search-widget.php' );
		$class_name = 'Wp_Easycart_Elementor_Search_Widget';
		$self->register_widget_type( new $class_name( array(), array( 'widget_name' => $class_name ) ) );

	}
}

new WP_EasyCart_Elementor();
