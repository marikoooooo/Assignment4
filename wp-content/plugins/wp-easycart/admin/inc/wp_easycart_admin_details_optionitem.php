<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class wp_easycart_admin_details_optionitem extends wp_easycart_admin_details {

	public $optionitem;
	public $option;
	public $item;

	public function __construct() {
		parent::__construct();
		add_action( 'wp_easycart_admin_optionitem_details_basic_fields', array( $this, 'basic_fields' ) );
		add_action( 'wp_easycart_admin_optionitem_details_advanced_fields', array( $this, 'advanced_fields' ) );
		add_action( 'wp_easycart_admin_optionitem_details_price_fields', array( $this, 'price_fields' ) );
		add_action( 'wp_easycart_admin_optionitem_details_weight_fields', array( $this, 'weight_fields' ) );
		add_filter( 'wp_easycart_admin_optionitem_details_basic_fields_list', array( $this, 'maybe_remove_icon_field' ) );
	}

	protected function init() {
		global $wpdb;
		$this->docs_link = 'http://docs.wpeasycart.com/wp-easycart-administrative-console-guide/?wpeasycartadmin=1&section=option';
		$this->id = 0;
		$this->page = 'wp-easycart-products';
		$this->subpage = 'optionitems';
		$this->action = 'admin.php?page=' . $this->page . '&subpage=' . $this->subpage;
		$this->form_action = 'add-new-optionitem';
		$this->item = $this->optionitem = (object) array(
			'optionitem_id' => '',
			'optionitem_id' => '',
			'option_id' => '',
			'optionitem_name' => '',
			'optionitem_enable_custom_price_label' => 0,
			'optionitem_custom_price_label' => '',
			'optionitem_price' => '',
			'optionitem_price_onetime' => '',
			'optionitem_price_override' => '',
			'optionitem_price_multiplier' => '',
			'optionitem_price_per_character' => '',
			'optionitem_weight' => '',
			'optionitem_weight_onetime' => '',
			'optionitem_weight_override' => '',
			'optionitem_weight_multiplier' => '',
			'optionitem_order' => '',
			'optionitem_icon' => '',
			'optionitem_initial_value' => '',
			'optionitem_model_number' => '',
			'optionitem_allow_download' => '',
			'optionitem_disallow_shipping' => '',
			'optionitem_initially_selected' => '',
			'optionitem_download_override_file' => '',
			'optionitem_download_addition_file' => '',
			'is_override_file' => false,
			'is_override_amazon' => false,
			'override_amazon_key' => '',
			'override_file_name' => '',
			'is_additional_file' => false,
			'is_additional_amazon' => false,
			'additional_amazon_key' => '',
			'additional_file_name' => '',
		);
		if ( isset( $_GET['option_id'] ) ) {
			$this->option = $wpdb->get_row( $wpdb->prepare( 'SELECT ec_option.* FROM ec_option WHERE option_id = %d', (int) $_GET['option_id'] ) );
		}
	}

	protected function init_data() {
		global $wpdb;
		$this->form_action = 'update-optionitem';
		$this->item = $this->optionitem = ( ( isset( $_GET['optionitem_id'] ) ) ? $wpdb->get_row( $wpdb->prepare( 'SELECT ec_optionitem.* FROM ec_optionitem WHERE optionitem_id = %d', (int) $_GET['optionitem_id'] ) ) : 0 );
		$this->id = $this->optionitem->optionitem_id;
		$this->option = $wpdb->get_row( $wpdb->prepare( 'SELECT ec_option.* FROM ec_option WHERE option_id = %d', $this->optionitem->option_id ) );
		$this->optionitem->is_override_file = false;
		$this->optionitem->is_override_amazon = false;
		$this->optionitem->override_amazon_key = '';
		$this->optionitem->override_file_name = '';
		$this->optionitem->is_additional_file = false;
		$this->optionitem->is_additional_amazon = false;
		$this->optionitem->additional_amazon_key = '';
		$this->optionitem->additional_file_name = '';
		if ( is_string( $this->optionitem->optionitem_download_override_file ) && '{' == substr( $this->optionitem->optionitem_download_override_file, 0, 1 ) ) {
			$override_file_json = json_decode( $this->optionitem->optionitem_download_override_file );
			$this->optionitem->is_override_file = ( isset( $override_file_json->is_override_file ) ) ? $override_file_json->is_override_file : false;
			$this->optionitem->is_override_amazon = ( isset( $override_file_json->is_override_amazon ) ) ? $override_file_json->is_override_amazon : false;
			$this->optionitem->override_amazon_key = ( isset( $override_file_json->override_amazon_key ) ) ? $override_file_json->override_amazon_key : '';
			$this->optionitem->override_file_name = ( isset( $override_file_json->override_file_name ) ) ? $override_file_json->override_file_name : '';
		} else {
			if ( is_string( $this->optionitem->optionitem_download_override_file ) && '' != trim( $this->optionitem->optionitem_download_override_file ) ) {
				$this->optionitem->is_override_file = true;
			}
		}

		if ( is_string( $this->optionitem->optionitem_download_addition_file ) && '{' == substr( $this->optionitem->optionitem_download_addition_file, 0, 1 ) ) {
			$additional_file_json = json_decode( $this->optionitem->optionitem_download_addition_file );
			$this->optionitem->is_additional_file = ( isset( $additional_file_json->is_additional_file ) ) ? $additional_file_json->is_additional_file : false;
			$this->optionitem->is_additional_amazon = ( isset( $additional_file_json->is_additional_amazon ) ) ? $additional_file_json->is_additional_amazon : false;
			$this->optionitem->additional_amazon_key = ( isset( $additional_file_json->additional_amazon_key ) ) ? $additional_file_json->additional_amazon_key : '';
			$this->optionitem->additional_file_name = ( isset( $additional_file_json->additional_file_name ) ) ? $additional_file_json->additional_file_name : '';
		} else {
			if ( is_string( $this->optionitem->optionitem_download_addition_file ) && '' != trim( $this->optionitem->optionitem_download_addition_file ) ) {
				$this->optionitem->is_additional_file = true;
			}
		}
	}

	public function output( $type = 'edit' ) {
		$this->init();
		if ( 'edit' == $type ) {
			$this->init_data();
		}
		include( EC_PLUGIN_DIRECTORY . '/admin/template/products/options/optionitem-details.php' );
	}

	public function basic_fields() {
		$swatch_image = $this->optionitem->optionitem_icon;

		if ( '' != $swatch_image && 'http://' != substr( $swatch_image, 0, 7 ) && 'https://' != substr( $swatch_image, 0, 8 ) ) {
			$swatch_image = plugins_url( '/wp-easycart-data/products/swatches/' . $swatch_image, EC_PLUGIN_DATA_DIRECTORY );
		}

		$fields = array(
			array(
				'name' => 'optionitem_id',
				'alt_name' => 'optionitem_id',
				'type' => 'hidden',
				'value' => $this->optionitem->optionitem_id,
			),
			array(
				'name' => 'optionitem_name',
				'type' => 'text',
				'label' => __( 'Option Item Name', 'wp-easycart' ),
				'required' => true,
				'message' => __( 'Please enter a unique option item name.', 'wp-easycart' ),
				'validation_type' => 'text',
				'value' => $this->optionitem->optionitem_name,
			),
			array(
				'name' => 'optionitem_order',
				'type' => 'number',
				'label' => __( 'Option Sort Order', 'wp-easycart' ),
				'decimals' => 0,
				'step' => 1,
				'required' => true,
				'message' => __( 'Please enter a unique sort order number value.', 'wp-easycart' ),
				'validation_type' => 'number',
				'value' => $this->optionitem->optionitem_order,
			),
			array(
				'name' => 'optionitem_model_number',
				'type' => 'text',
				'label' => __( 'Model Number Extension', 'wp-easycart' ),
				'required' => false,
				'message' => __( 'Please enter a unique model number extension (letters, numbers and dashes only).', 'wp-easycart' ),
				'validation_type' => 'model_number',
				'value' => $this->optionitem->optionitem_model_number,
			),
			array(
				'name' => 'optionitem_icon',
				'type' => 'image_upload',
				'label' => __( 'Image Swatch (optional)', 'wp-easycart' ),
				'required' => false,
				'message' => __( 'Please select an image for this option swatch.', 'wp-easycart' ),
				'validation_type' => 'image_upload',
				'value' => $swatch_image,
			),
			array(
				'name' => 'optionitem_enable_custom_price_label',
				'type' => 'checkbox',
				'label' => __( 'Add custom price adjustment label?', 'wp-easycart' ),
				'required' => false,
				'validation_type' => 'checkbox',
				'show' => array(
					'name' => 'optionitem_custom_price_label',
					'value' => '1',
				),
				'value' => $this->optionitem->optionitem_enable_custom_price_label,
			),
			array(
				'name' => 'optionitem_custom_price_label',
				'type' => 'text',
				'label' => __( 'Custom Label for Price Adjustments', 'wp-easycart' ),
				'required' => false,
				'message' => __( 'Please enter the custom message to be shown if a price adjustment applies.', 'wp-easycart' ),
				'validation_type' => 'text',
				'requires' => array(
					'name' => 'optionitem_enable_custom_price_label',
					'value' => 1,
				),
				'value' => $this->optionitem->optionitem_custom_price_label,
				'visible' => false,
			),
		);

		if ( 'basic-combo' == $this->option->option_type || 'basic-swatch' == $this->option->option_type ) {
			$fields[] = array(
				'name' => 'optionitem_price',
				'type' => 'currency',
				'label' => __( 'Price Adjustment (+/-)', 'wp-easycart' ),
				'required' => false,
				'validation_type' => 'price',
				'visible' => true,
				'value' => $this->optionitem->optionitem_price,
			);
		}

		if ( 'basic-combo' == $this->option->option_type || 'basic-swatch' == $this->option->option_type ) {
			$fields[] = array(
				'name' => 'optionitem_weight',
				'type' => 'number',
				'label' => __( 'Weight Adjustment (+/-)', 'wp-easycart' ),
				'required' => false,
				'validation_type' => 'number',
				'visible' => true,
				'value' => $this->optionitem->optionitem_weight,
			);
		}
		$fields = apply_filters( 'wp_easycart_admin_optionitem_details_basic_fields_list', $fields );
		$this->print_fields( $fields );
	}

	public function maybe_remove_icon_field( $fields ) {

		if ( ! $this->is_swatch() ) {
			$new_fields = array();
			$field_count = count( $fields );
			for ( $i = 0; $i < $field_count; $i++ ) {
				if ( 'optionitem_icon' != $fields[ $i ]['name'] ) {
					$new_fields[] = $fields[ $i ];
				}
			}
			return $new_fields;
		} else {
			return $fields;
		}
	}

	public function is_swatch() {
		global $wpdb;
		if ( isset( $_GET['option_id'] ) ) {
			$option_id = (int) $_GET['option_id'];
		} else {
			$option_id = $this->optionitem->option_id;
		}
		if ( 'basic-swatch' == $this->option->option_type || 'swatch' == $this->option->option_type ) {
			return true;
		} else {
			return false;
		}
	}

	public function advanced_fields() {
		$s3_files = array(
			(object) array(
				'id' => '0',
				'value' => 'Not Connected',
			),
		);
		if ( ( get_option( 'ec_option_amazon_key' ) != '' && get_option( 'ec_option_amazon_key' ) != '0' ) && 
			( get_option( 'ec_option_amazon_secret' ) != '' && get_option( 'ec_option_amazon_secret' ) != '0' ) &&
			( get_option( 'ec_option_amazon_bucket' ) != '' && get_option( 'ec_option_amazon_bucket' ) != '0' ) && 
			( phpversion() >= 5.3 ) ) {
			try {
				require_once( EC_PLUGIN_DIRECTORY . '/inc/classes/account/ec_amazons3.php' );
				$amazons3 = new ec_amazons3();
				$s3_files_from_server = $amazons3->get_aws_files();
				$s3_files = array();
				foreach ( $s3_files_from_server as $file ) {
					$s3_files[] = (object) array(
						'id' => $file,
						'value' => $file,
					);
				}
			} catch( Exception $e ) {
				// Do Nothing
			}
		}

		$fields = apply_filters(
			'wp_easycart_admin_optionitem_details_advanced_fields_list',
			array(
				array(
					'name' => 'optionitem_initially_selected',
					'type' => 'checkbox',
					'label' => __( 'Initially Selected?', 'wp-easycart' ),
					'required' => false,
					'message' => '',
					'selected' => false,
					'validation_type' => 'checkbox',
					'value' => $this->optionitem->optionitem_initially_selected,
				),
				array(
					'name' => 'optionitem_allow_download',
					'type' => 'checkbox',
					'label' => __( 'Option Allows Product Download?', 'wp-easycart' ),
					'required' => false,
					'message' => '',
					'selected' => true,
					'validation_type' => 'checkbox',
					'value' => $this->optionitem->optionitem_allow_download,
				),
				array(
					'name' => 'is_override_file',
					'type' => 'checkbox',
					'label' => __( 'Enable Download File Override', 'wp-easycart' ),
					'required' => false,
					'validation_type' => 'checkbox',
					'onclick' => 'wpeasycart_optionitem_update_override_file',
					'read-only' => false,
					'visible' => true,
					'value' => $this->optionitem->is_override_file,
				),
				array(
					'name' => 'is_override_amazon',
					'type' => 'select',
					'label' => __( 'Download Location', 'wp-easycart' ),
					'data' => array(
						(object) array(
							'id' => '1',
							'value' => __( 'Amazon S3', 'wp-easycart' ),
						),
					),
					'data_label' => __( 'My Server', 'wp-easycart' ),
					'required' => false,
					'requires' => array(
						'name' => 'is_override_file',
						'value' => 1,
						'default_show' => false,
					),
					'onchange' => 'wpeasycart_optionitem_update_override_file',
					'validation_type' => 'select',
					'visible' => false,
					'value' => $this->optionitem->is_override_amazon,
				),
				array(
					'name' => 'override_amazon_key',
					'type' => 'select',
					'label' => __( 'S3 File', 'wp-easycart' ),
					'data' => $s3_files,
					'data_label' => __( 'None Selected', 'wp-easycart' ),
					'required' => false,
					'requires' => array(
						array(
							'name' => 'is_override_amazon',
							'value' => 1,
							'default_show' => false,
						),
						array(
							'name' => 'is_override_file',
							'value' => 1,
							'default_show' => false,
						),
					),
					'validation_type' => 'select',
					'visible' => false,
					'value' => $this->optionitem->override_amazon_key,
				),
				array(
					'name' => 'override_file_name',
					'type' => 'image_upload',
					'hide_preview' => true,
					'button_label' => __( 'Upload File', 'wp-easycart' ),
					'label' => __( 'Download File', 'wp-easycart' ),
					'required' => false,
					'requires' => array(
						array(
							'name' => 'is_override_amazon',
							'value' => 0,
							'default_show' => false,
						),
						array(
							'name' => 'is_override_file',
							'value' => 1,
							'default_show' => false,
						),
					),
					'validation_type' => 'image',
					'image_action' => 'ec_admin_download_upload',
					'visible' => true,
					'delete_label' => __( 'Remove File', 'wp-easycart' ),
					'value' => $this->optionitem->override_file_name,
				),
				array(
					'name' => 'is_additional_file',
					'type' => 'checkbox',
					'label' => __( 'Enable Additional Download File', 'wp-easycart' ),
					'required' => false,
					'validation_type' => 'checkbox',
					'onclick' => 'wpeasycart_optionitem_update_additional_file',
					'read-only' => false,
					'visible' => true,
					'value' => $this->optionitem->is_additional_file,
				),
				array(
					'name' => 'is_additional_amazon',
					'type' => 'select',
					'label' => __( 'Download Location', 'wp-easycart' ),
					'data' => array(
						(object) array(
							'id' => '1',
							'value' => __( 'Amazon S3', 'wp-easycart' ),
						),
					),
					'data_label' => __( 'My Server', 'wp-easycart' ),
					'required' => false,
					'requires' => array(
						'name' => 'is_additional_file',
						'value' => 1,
						'default_show' => false,
					),
					'onchange' => 'wpeasycart_optionitem_update_additional_file',
					'validation_type' => 'select',
					'visible' => false,
					'value' => $this->optionitem->is_additional_amazon,
				),
				array(
					'name' => 'additional_amazon_key',
					'type' => 'select',
					'label' => __( 'S3 File', 'wp-easycart' ),
					'data' => $s3_files,
					'data_label' => __( 'None Selected', 'wp-easycart' ),
					'required' => false,
					'requires' => array(
						array(
							'name' => 'is_additional_amazon',
							'value' => 1,
							'default_show' => false,
						),
						array(
							'name' => 'is_additional_file',
							'value' => 1,
							'default_show' => false,
						),
					),
					'validation_type' => 'select',
					'visible' => false,
					'value' => $this->optionitem->additional_amazon_key,
				),
				array(
					'name' => 'additional_file_name',
					'type' => 'image_upload',
					'hide_preview' => true,
					'button_label' => __( 'Upload File', 'wp-easycart' ),
					'label' => __( 'Download File', 'wp-easycart' ),
					'required' => false,
					'requires' => array(
						array(
							'name' => 'is_additional_amazon',
							'value' => 0,
							'default_show' => false,
						),
						array(
							'name' => 'is_additional_file',
							'value' => 1,
							'default_show' => false,
						),
					),
					'validation_type' => 'image',
					'image_action' => 'ec_admin_download_upload',
					'visible' => true,
					'delete_label' => __( 'Remove File', 'wp-easycart' ),
					'value' => $this->optionitem->additional_file_name,
				),
				array(
					'name' => 'optionitem_disallow_shipping',
					'type' => 'checkbox',
					'label' => __( 'Option Makes NO Shipping on Product?', 'wp-easycart' ),
					'required' => false,
					'message' => '',
					'selected' => false,
					'validation_type' => 'checkbox',
					'value' => $this->optionitem->optionitem_disallow_shipping,
				),
				array(
					'name' => 'optionitem_initial_value',
					'type' => ( $this->optionitem->optionitem_name == 'Text Box Input' ) ? 'text' : 'currency',
					'label' => __( 'Initial Value', 'wp-easycart' ),
					'required' => false,
					'message' => __( 'Please enter the initial value of option.', 'wp-easycart' ),
					'validation_type' => 'text',
					'value' => $this->optionitem->optionitem_initial_value,
				),
			)
		);
		$this->print_fields( $fields );
	}

	public function price_fields() {
		$fields = apply_filters(
			'wp_easycart_admin_optionitem_details_price_fields_list',
			array(
				array(
					'name' => 'optionitem_price',
					'type' => 'currency',
					'label' => __( 'Basic Price Adjustment', 'wp-easycart' ),
					'required' => false,
					'message' => __( 'Please enter a basic price adjustment for this option', 'wp-easycart' ),
					'validation_type' => 'currency',
					'value' => $this->optionitem->optionitem_price,
				),
				array(
					'name' => 'optionitem_price_onetime',
					'type' => 'currency',
					'label' => __( 'One Time Price', 'wp-easycart' ),
					'required' => false,
					'message' => __( 'Please enter a one time price adjustment for this option', 'wp-easycart' ),
					'validation_type' => 'currency',
					'value' => $this->optionitem->optionitem_price_onetime,
				),
				array(
					'name' => 'optionitem_price_override',
					'type' => 'currency',
					'label' => __( 'Price Over-Ride', 'wp-easycart' ),
					'required' => false,
					'default' => '-1.000',
					'message' => __( 'Please enter an override price adjustment for this option', 'wp-easycart' ),
					'validation_type' => 'currency',
					'value' => $this->optionitem->optionitem_price_override,
				),
				array(
					'name' => 'optionitem_price_multiplier',
					'type' => 'currency',
					'label' => __( 'Price Multiplier', 'wp-easycart' ),
					'required' => false,
					'message' => __( 'Please enter a price multiplier adjustment for this option', 'wp-easycart' ),
					'validation_type' => 'currency',
					'value' => $this->optionitem->optionitem_price_multiplier,
				),
				array(
					'name' => 'optionitem_price_per_character',
					'type' => 'currency',
					'label' => __( 'Price Per Character', 'wp-easycart' ),
					'required' => false,
					'message' => __( 'Please enter a price per character for this option', 'wp-easycart' ),
					'validation_type' => 'currency',
					'value' => $this->optionitem->optionitem_price_per_character,
				),
			)
		);
		$this->print_fields( $fields );
	}

	public function weight_fields() {
		$fields = apply_filters(
			'wp_easycart_admin_optionitem_details_weight_fields_list',
			array(
				array(
					'name' => 'optionitem_weight',
					'type' => 'currency',
					'label' => __( 'Basic Weight Adjustment', 'wp-easycart' ),
					'required' => false,
					'message' => __( 'Please enter a basic weight adjustment for this option', 'wp-easycart' ),
					'validation_type' => 'currency',
					'value' => $this->optionitem->optionitem_weight,
				),
				array(
					'name' => 'optionitem_weight_onetime',
					'type' => 'currency',
					'label' => __( 'One Time Weight', 'wp-easycart' ),
					'required' => false,
					'message' => __( 'Please enter a one time weight adjustment for this option', 'wp-easycart' ),
					'validation_type' => 'currency',
					'value' => $this->optionitem->optionitem_weight_onetime,
				),
				array(
					'name' => 'optionitem_weight_override',
					'type' => 'currency',
					'label' => __( 'Weight Over-Ride', 'wp-easycart' ),
					'required' => false,
					'default' => '-1.000',
					'message' => __( 'Please enter an override weight adjustment for this option', 'wp-easycart' ),
					'validation_type' => 'currency',
					'value' => $this->optionitem->optionitem_weight_override,
				),
				array(
					'name' => 'optionitem_weight_multiplier',
					'type' => 'currency',
					'label' => __( 'Weight Multiplier', 'wp-easycart' ),
					'required' => false,
					'message' => __( 'Please enter a weight multiplier adjustment for this option', 'wp-easycart' ),
					'validation_type' => 'currency',
					'value' => $this->optionitem->optionitem_weight_multiplier,
				),
			)
		);
		$this->print_fields( $fields );
	}
}
