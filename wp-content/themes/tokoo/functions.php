<?php
/**
 * Tokoo engine room
 *
 * @package tokoo
 */

/**
 * Assign the Tokoo version to a var
 */
$theme         = wp_get_theme( 'tokoo' );
$tokoo_version = $theme['Version'];

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
    $content_width = 780; /* pixels */
}

$tokoo = (object) array(
    'version'    => $tokoo_version,
    'main'       => require get_template_directory() . '/inc/class-tokoo.php'
);

require get_template_directory() . '/inc/tokoo-functions.php';
require get_template_directory() . '/inc/tokoo-template-hooks.php';
require get_template_directory() . '/inc/tokoo-template-functions.php';

if ( tokoo_is_redux_activated() ) {
    require get_template_directory() . '/inc/redux-framework/tokoo-options.php';
    require get_template_directory() . '/inc/redux-framework/hooks.php';
    require get_template_directory() . '/inc/redux-framework/functions.php';
}

if ( tokoo_is_woocommerce_activated() ) {
    $tokoo->woocommerce = require get_template_directory() . '/inc/woocommerce/class-tokoo-woocommerce.php';
    require get_template_directory() . '/inc/woocommerce/tokoo-woocommerce-template-hooks.php';
    require get_template_directory() . '/inc/woocommerce/tokoo-woocommerce-template-functions.php';
}

if ( tokoo_is_ocdi_activated() ) {
    require get_template_directory() . '/inc/ocdi/hooks.php';
    require get_template_directory() . '/inc/ocdi/functions.php';
}

if ( tokoo_is_jetpack_activated() ) {
    require_once get_template_directory() . '/inc/jetpack/tokoo-jetpack-functions.php';
}

if ( tokoo_is_woozone_activated() ) {
    require_once get_template_directory() . '/inc/woozone/tokoo-woozone.php';
}

if ( apply_filters( 'tokoo_load_wpml', true ) && tokoo_is_wpml_activated() ) {
    require get_template_directory() . '/inc/wpml/class-tokoo-wpml.php';
}

if ( is_admin() ) {
    require get_template_directory() . '/inc/admin/class-tokoo-admin.php';
}

/**
 * Load Dokan compatibility files.
 */
if ( tokoo_is_dokan_activated() ) {
    require get_template_directory() . '/inc/dokan/functions.php';
    require get_template_directory() . '/inc/dokan/hooks.php';
}


wp_enqueue_script( 'script', get_template_directory_uri() . '/assets/js/rohit_register.js', array ( 'jquery' ), 1.1, true);


add_filter('woocommerce_get_catalog_ordering_args', 'am_woocommerce_catalog_orderby');
function am_woocommerce_catalog_orderby( $args ) { 
    $args['orderby'] = 'rand'; 
    $args['order'] = 'ID'; 
    return $args;
}


// add the action 
function action_woocommerce_created_customer($customer_id){
        if ( isset( $_POST['billing_first_name'] ) ) {
	        update_user_meta( $customer_id, 'billing_first_name', sanitize_text_field( $_POST['billing_first_name'] ) );
	        update_user_meta( $customer_id, 'first_name', sanitize_text_field( $_POST['billing_first_name']) );
	    }
	    if ( isset( $_POST['billing_phone'] ) ) {
	        update_user_meta( $customer_id, 'billing_phone', sanitize_text_field( $_POST['billing_phone'] ) );
	        
	    }
}
add_action( 'woocommerce_created_customer', 'action_woocommerce_created_customer', 10, 3 );




//Front side show
add_action( 'woocommerce_edit_account_form', 'my_woocommerce_edit_account_form' );
add_action( 'woocommerce_save_account_details', 'my_woocommerce_save_account_details' );
 
function my_woocommerce_edit_account_form() {
 
  $user_id = get_current_user_id();
  $user = get_userdata( $user_id );
 
  if ( !$user )
    return;
 
  $sbilling_phone = get_user_meta( $user_id, 'billing_phone', true );  
 
  ?>
   
  
  	<p class="woocommerce-form-row woocommerce-form-row--wide  form-row form-row-wide">
		    <label for="reg_billing_phone"><?php _e( 'Mobile', 'tokoo' ); ?> <span class="required">*</span></label>
		    <input type="text" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" pattern="\d*" maxlength="10"  autocomplete="off" required class="woocommerce-Input woocommerce-Input--text input-text" name="billing_phone"  value="<?php echo esc_attr( $sbilling_phone ); ?>" />
	    </p> 
	    
 
  <?php
 
}
 
function my_woocommerce_save_account_details( $user_id ) {
 
  update_user_meta( $user_id, 'billing_phone', htmlentities( $_POST[ 'billing_phone' ] ) ); 
  
 
} 



//Show Custom Fields admin side
add_action( 'show_user_profile', 'crf_show_extra_profile_fields' );
add_action( 'edit_user_profile', 'crf_show_extra_profile_fields' );

function crf_show_extra_profile_fields( $user ) {
	?>
	<h3><?php esc_html_e( 'Personal Information', 'crf' ); ?></h3>

	<table class="form-table">
	 
		<tr>
			<th><label for="find_where"><?php esc_html_e( 'Mobile Number', 'crf' ); ?></label></th>
			<td><?php echo esc_html( get_the_author_meta( 'billing_phone', $user->ID ) ); ?></td>
		</tr>
	</table>
	<?php
}
 


/**
 * Note: Do not add any custom code here. Please use a custom plugin so that your customizations aren't lost during updates.
 * https://github.com/woocommerce/theme-customisations
 */
