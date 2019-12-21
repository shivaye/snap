<?php
/**
 * Custom Class
 *
 * @access public
 * @return void
*/

class WC_GST_Settings {
    /**
     * Bootstraps the class and hooks required actions & filters.
     *
     */
    public function init() {

    	add_filter( 'woocommerce_settings_tabs_array', array( $this ,'fn_add_settings_tab' ), 50 );
    	add_action( 'woocommerce_settings_tabs_settings_gst_tab', array( $this , 'fn_settings_tab') );
    	add_action( 'woocommerce_update_options_settings_gst_tab', array( $this , 'fn_update_settings') );
    	add_action( 'woocommerce_update_options_tax', array( $this , 'fn_update_tax_settings') );
    	add_action( 'init', array( $this , 'fn_gst_callback') );
    	add_action('woocommerce_product_options_general_product_data', array( $this , 'fn_add_product_custom_meta_box') );
		add_action( 'woocommerce_process_product_meta', array( $this , 'fn_save_license_field') );
        add_action( 'admin_print_scripts',  array( $this , 'fn_load_custom_wp_admin_script'), 999 );
	    add_action( 'woocommerce_email_after_order_table', array( $this , 'fn_woocommerce_gstin_invoice_fields') );
        add_action( 'admin_notices', array( $this , 'print_pro_notice') );
        add_filter( 'plugin_row_meta', array( $this, 'fn_add_extra_links' ), 10, 2 );
    }

    /**
     * print_pro_notice
     * Prints the notice of pro version
     */
    public function print_pro_notice() {
        $class = 'notice notice-success is-dismissible';
        $pro_link = GST_PRO_LINK;

        printf( '<div class="%1$s"><p>For more feature of WooCommerce GST <a href="%2$s" target="_blank">download PRO version</a>.</p></div>', $class, $pro_link );
    }
    function fn_woocommerce_gstin_invoice_fields( $order ) {
    	?>
    	<p><strong><?php _e('GSTIN Number:', 'woocommerce'); ?></strong> <?php echo get_option('woocommerce_gstin_number'); ?></p>
    	<?php
    }

    public function fn_load_custom_wp_admin_script() {

       ?>
       <script>
       	jQuery(document).ready(function($) {
       		
       		if($('#woocommerce_product_types').val() == 'multiple'){
   				hide_singe();
   			} else {
       			hide_mutiple();
   			}
       		$('#woocommerce_product_types').change(function(){
       			if($(this).val() == 'single'){
       				hide_mutiple();
       			} else {
       				hide_singe();
       			}
       		});	

       		function hide_singe(){
       			$('select[name="woocommerce_gst_single_select_slab"]').parents('tr:first').hide();
       			$('select[name="woocommerce_gst_multi_select_slab[]"]').parents('tr:first').show();
       		}

       		function hide_mutiple(){
       			$('select[name="woocommerce_gst_multi_select_slab[]"]').parents('tr:first').hide();
       			$('select[name="woocommerce_gst_single_select_slab"]').parents('tr:first').show();
       		}
       	});
       </script>
       <?php
	}

	public function fn_add_product_custom_meta_box() {
		woocommerce_wp_text_input( 
			array( 
				'id'            => 'hsn_prod_id', 
				'label'         => __('HSN Code', 'woocommerce' ), 
				'description'   => __( 'HSN Code is mandatory for GST.', 'woocommerce' ),
				'custom_attributes' => array( 'required' => 'required' ),
				'value'         => get_post_meta( get_the_ID(), 'hsn_prod_id', true )
				)
			);
	}

	public function fn_save_license_field( $post_id ) {
	    $value = ( $_POST['hsn_prod_id'] )? sanitize_text_field( $_POST['hsn_prod_id'] ) : '' ;
	    update_post_meta( $post_id, 'hsn_prod_id', $value );
	}
    
    /**
     * Add a new settings tab to the WooCommerce settings tabs array.
     *
     * @param array $settings_tabs Array of WooCommerce setting tabs & their labels, excluding the Subscription tab.
     * @return array $settings_tabs Array of WooCommerce setting tabs & their labels, including the Subscription tab.
     */
    public static function fn_add_settings_tab( $settings_tabs ) {
    	$settings_tabs['settings_gst_tab'] = __( 'GST Settings', 'woocommerce' );
    	return $settings_tabs;
    }
    /**
     * Uses the WooCommerce admin fields API to output settings via the @see woocommerce_admin_fields() function.
     *
     * @uses woocommerce_admin_fields()
     * @uses self::fn_get_settings()
     */
    public static function fn_settings_tab() {
        woocommerce_admin_fields( self::fn_get_settings() );
    }
    /**
     * Uses the WooCommerce options API to save settings via the @see woocommerce_update_options() function.
     *
     * @uses woocommerce_update_options()
     * @uses self::fn_get_settings()
     */
    public static function fn_update_settings() {
    	self::gst_insrt_tax_slab_rows();
    	woocommerce_update_options( self::fn_get_settings() );
    }

    /**
     * call to gst_callback function on tax tab save button.
     *
     */
    public static function fn_update_tax_settings() {
    	self::fn_gst_callback();
    }

    /**
     * Uses the WooCommerce options API to save settings via the @see woocommerce_update_options() function.
     *
     * @uses woocommerce_set_gst_tax_slabs()
     * @uses self::gst_callback()
     */
    public static function fn_gst_callback() {
    	$a_currunt_tax_slabs = array();
		$a_gst_tax_slabs = array();
		$s_woocommerce_product_types = get_option( 'woocommerce_product_types' );

		if( isset( $s_woocommerce_product_types ) && $s_woocommerce_product_types == 'multiple' ){
			$s_product_types = get_option( 'woocommerce_gst_multi_select_slab' );
			$a_gst_tax_slabs = array_merge( $a_gst_tax_slabs, $s_product_types );
		} elseif( isset( $s_woocommerce_product_types ) && $s_woocommerce_product_types == 'single' ) {
			$s_product_types = get_option( 'woocommerce_gst_single_select_slab' );
			array_push( $a_gst_tax_slabs, $s_product_types );
		}

		$s_woocommerce_tax_classes = get_option('woocommerce_tax_classes');
		if( isset( $s_woocommerce_tax_classes ) ){
			$a_currunt_tax_slabs = explode( PHP_EOL, $s_woocommerce_tax_classes );
			$i_old_count = count( $a_currunt_tax_slabs );
			foreach ( $a_gst_tax_slabs as $gst_tax_value ) {
				if ( !in_array( $gst_tax_value, $a_currunt_tax_slabs ) ) 
					array_push( $a_currunt_tax_slabs, $gst_tax_value );
			}
			$i_new_count = count( $a_currunt_tax_slabs );
			if( $i_new_count == $i_old_count ){
				return;
			}
		}
		$a_currunt_tax_slabs = ( !$a_currunt_tax_slabs ) ? $a_gst_tax_slabs : $a_currunt_tax_slabs ;
		$a_currunt_tax_slabs = implode( PHP_EOL, $a_currunt_tax_slabs );
		update_option( 'woocommerce_tax_classes', $a_currunt_tax_slabs );
    }

    /**
     * Uses this function to insert tax slab rows.
     *
     */
    public static function gst_insrt_tax_slab_rows() {
    	global $wpdb;


    	$a_multiple_slabs = array();
    	if( isset( $_POST['woocommerce_product_types'] ) && $_POST['woocommerce_product_types'] == 'multiple' ){
            $multi_select_slab = $_POST['woocommerce_gst_multi_select_slab'];
            if( ! empty( $multi_select_slab ) )
                $a_multiple_slabs = array_merge( $a_multiple_slabs, $multi_select_slab );
    	} elseif ( isset( $_POST['woocommerce_product_types'] ) ){
            $single_select_slab = $_POST['woocommerce_gst_single_select_slab'];
			array_push( $a_multiple_slabs, $single_select_slab );		
    	}

    	$table_prefix = $wpdb->prefix . "woocommerce_tax_rates";

        $s_woocommerce_tax_classes = get_option('woocommerce_tax_classes');
        $a_currunt_tax_slabs = array();


        if( !empty( $s_woocommerce_tax_classes ) )
            $a_currunt_tax_slabs = explode( PHP_EOL, $s_woocommerce_tax_classes );


    	
    	foreach ( $a_multiple_slabs as $a_multiple_slab ) {
    		if( $a_multiple_slab != '0%' && ! in_array( $a_multiple_slab, $a_currunt_tax_slabs ) ){
	    		$slab_name = preg_replace('/%/', '', $a_multiple_slab);
	    		$state_tax ='';
	    		switch ($slab_name) {
	    			case '5':
	    				$state_tax = '2.5';
	    				break;
	    			case '12':
	    				$state_tax = '6';
	    				break;
	    			case '18':
	    				$state_tax = '9';
	    				break;
	    			case '28':
	    				$state_tax = '14';
	    				break;

	    			default:
	    				$state_tax ='';
	    				break;
	    		}

                $state = get_option( 'woocommerce_store_state' );
                if( isset( $state ) ) :
    	    		$wpdb->insert($table_prefix,array( 'tax_rate_country' => 'IN', 'tax_rate_state' => $state,'tax_rate' => $state_tax,'tax_rate_name' => $state_tax."% CGST",'tax_rate_priority' => 1,'tax_rate_compound' => 0,'tax_rate_shipping' => 0,'tax_rate_order' => 0,'tax_rate_class' =>$slab_name),array( '%s','%s','%s','%s','%d','%d','%d','%d','%s'));

    	    		$wpdb->insert($table_prefix,array( 'tax_rate_country' => 'IN', 'tax_rate_state' => $state,'tax_rate' => $state_tax,'tax_rate_name' => $state_tax."% SGST",'tax_rate_priority' => 2,'tax_rate_compound' => 0,'tax_rate_shipping' => 0,'tax_rate_order' => 0,'tax_rate_class' =>$slab_name),array( '%s','%s','%s','%s','%d','%d','%d','%d','%s'));

    	    		$wpdb->insert($table_prefix,array( 'tax_rate_country' => 'IN', 'tax_rate_state' => '','tax_rate' => $slab_name,'tax_rate_name' => $slab_name."% IGST",'tax_rate_priority' => 1,'tax_rate_compound' => 0,'tax_rate_shipping' => 0,'tax_rate_order' => 0,'tax_rate_class' =>$slab_name),array( '%s','%s','%s','%s','%d','%d','%d','%d','%s'));
                endif;
    		}
    	}
        
    }

    /**
     * Get all the settings for this plugin for @see woocommerce_admin_fields() function.
     *
     * @return array Array of settings for @see woocommerce_admin_fields() function.
     */
    public static function fn_get_settings() {

        $location = wc_get_base_location();
        $state = esc_attr( $location['state'] );

    	$settings = array(
    		'section_title' => array(
    			'name'     => __( 'Select Product Type', 'woocommerce' ),
    			'type'     => 'title',
    			'desc'     => '',
    			'id'       => 'wc_settings_gst_tab_section_title'
    		),
    		'GSTIN_number' => array(

            	'name'    => __( 'GSTIN Number', 'woocommerce' ),

            	'desc'    => __( 'This GSTIN number display on your invoice.', 'woocommerce' ),

            	'id'      => 'woocommerce_gstin_number',

            	'css'     => 'min-width:150px;',

			    'std'     => 'left', // WooCommerce < 2.0

			    'default' => '', // WooCommerce >= 2.0

                'custom_attributes' => array( 'required' => 'required' ),

			    'type'    => 'text',

			),
            'store_state' => array(

                'name'    => __( 'Store location state', 'woocommerce' ),

                'desc'    => __( 'Please insert state code of store location.', 'woocommerce' ),

                'id'      => 'woocommerce_store_state',

                'css'     => 'min-width:150px;',

                'std'     => 'left', // WooCommerce < 2.0

                'default' => $state, // WooCommerce >= 2.0

                'custom_attributes' => array( 'required' => 'required' ),
                
                'type'    => 'text',

            ),
            'prod_types' => array(

            	'name'    => __( 'Select Product Types', 'woocommerce' ),

            	'desc'    => __( 'Select single or multiple tax slab.', 'woocommerce' ),

            	'id'      => 'woocommerce_product_types',

            	'css'     => 'min-width:150px;height:auto;',

				    'std'     => 'left', // WooCommerce < 2.0

				    'default' => 'left', // WooCommerce >= 2.0

				    'type'    => 'select',

				    'options' => array(

				    	'single'        => __( 'Single', 'woocommerce' ),

				    	'multiple'       => __( 'Multiple', 'woocommerce' ),

				    ),

				    'desc_tip' =>  true,

				),
            'woocommerce_gst_multi_select_slab' => array(

            	'name'    => __( 'Select Multiple Tax Slabs ', 'woocommerce' ),

            	'desc'    => __( 'Multiple tax slabs.', 'woocommerce' ),

            	'id'      => 'woocommerce_gst_multi_select_slab',

            	'css'     => 'min-width:150px;',

			    'std'     => 'left', // WooCommerce < 2.0

			    'default' => 'left', // WooCommerce >= 2.0

			    'type'    => 'multi_select_countries',

			    'options' => array(

			    	'0%'  => __( '0%', 'woocommerce' ),

			    	'5%'  => __( '5%', 'woocommerce' ),

			    	'12%' => __( '12%', 'woocommerce' ),

			    	'18%' => __( '18%', 'woocommerce' ),

			    	'28%' => __( '28%', 'woocommerce' ),

			    ),

			    'desc_tip' =>  true,

			),

            'woocommerce_gst_single_select_slab' => array(

            	'name'    => __( 'Select Tax Slab', 'woocommerce' ),

            	'desc'    => __( 'Tax slab.', 'woocommerce' ),

            	'id'      => 'woocommerce_gst_single_select_slab',

            	'css'     => 'min-width:150px;height:auto;',

			    'std'     => 'left', // WooCommerce < 2.0

			    'default' => 'left', // WooCommerce >= 2.0

			    'type'    => 'select',

			    'options' => array(

			    	'0%'  => __( '0%', 'woocommerce' ),

			    	'5%'  => __( '5%', 'woocommerce' ),

			    	'12%' => __( '12%', 'woocommerce' ),

			    	'18%' => __( '18%', 'woocommerce' ),

			    	'28%' => __( '28%', 'woocommerce' ),

			    ),

			    'desc_tip' =>  true,

			),



            'section_end' => array(
            	'type' => 'sectionend',
            	'id' => 'wc_settings_gst_tab_section_end'
            )
        );
    	return apply_filters( 'wc_settings_gst_tab_settings', $settings );
    }


    function fn_add_extra_links($links, $file) {

        if( $file == gst_BASENAME ) {

            $row_meta = array(
                'pro'    => '<a href="'.GST_PRO_LINK.'" target="_blank" title="' . __( 'PRO Plugin', 'woocommerce' ) . '">' . __( 'PRO Plugin', 'woocommerce' ) . '</a>',
            );

            return array_merge( $links, $row_meta );

        }

        return (array) $links;
    }

}