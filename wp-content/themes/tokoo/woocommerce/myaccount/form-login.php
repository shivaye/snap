<?php
/**
 * Login Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$is_registration_enabled = false;
if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) {
	$is_registration_enabled = true;
}
?>
<style>
   
.btn-success{    background: #30a022;padding: 6px;}
.btn-primary{    background: #f00;padding: 4px;}
.card-link{text-decoration:none;color: #fff !important;}
</style>
 
<div class="customer-login-register">
	<div class="login-register-benefits">
		<?php
		$benefits = apply_filters( 'tokoo_register_benefits', array(
			esc_html__( 'Speed your way through the checkout ', 'tokoo' ),
			esc_html__( 'Track your orders easily', 'tokoo' ),
			esc_html__( 'Keep a record of all your purchases', 'tokoo' ),
			esc_html__( 'Collect your Tokoo points', 'tokoo' )
		) );

		$register_benefits_title = apply_filters( 'tokoo_register_benefits_title', esc_html__( 'Shoping in Tokoo with Confidence!' , 'tokoo' ) );
		$register_benefits_text = apply_filters( 'tokoo_register_benefits_text', esc_html__( 'Tokoo Buyer Protection has you covered from click to delivery. Sign up or sign in and you will be able to:' , 'tokoo' ) );

		if ( ! empty( $benefits ) ) : ?>
			<div class="register-benefits">
				<?php if ( ! empty( $register_benefits_title ) ): ?><h3><?php echo esc_html( $register_benefits_title ); ?></h3><?php endif; ?>
				<?php if ( ! empty( $register_benefits_text ) ): ?><p><?php echo esc_html( $register_benefits_text ); ?></p><?php endif; ?>
				<ul>
					<?php foreach ( $benefits as $benefit ) : ?>
					<li><?php echo esc_html( $benefit ); ?></li>
					<?php endforeach; ?>
				</ul>
			</div>
		<?php endif; ?>

		<?php
			$register_banner_icon = apply_filters( 'tokoo_register_banner_icon', esc_html__( 'fa flaticon-megaphone' , 'tokoo' ) );
			$register_banner_title = apply_filters( 'tokoo_register_banner_title', esc_html__( 'Get your free $50.00!' , 'tokoo' ) );
			$register_banner_text = apply_filters( 'tokoo_register_banner_text', esc_html__('Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard' , 'tokoo' ) );
		?>
		
		<div class="register-benefits-banner" style="display: none;">
			<div class="register-benefits-banner-inner">
				<?php if ( ! empty( $register_banner_icon ) ): ?>
					<div class="banner-icon">
						<i class="<?php echo esc_html( $register_banner_icon ); ?> icon"></i>
					</div>
				<?php endif; ?>

				<div class="banner-content">
					<?php if ( ! empty( $register_banner_title ) ): ?>
						<h3><?php echo esc_html( $register_banner_title ); ?></h3>
					<?php endif; ?>

					<?php if ( ! empty( $register_banner_text) ): ?>
						<p><?php echo esc_html( $register_banner_text ); ?></p>
					<?php endif; ?>
				</div>
			</div>

		</div>
	</div>

	<div class="login-register-forms">
		<div class="login-register-forms-outer">
			<ul class="nav login-register-tabs">
				<li><a href="#customer-login-form" class="login-register-tab active" data-toggle="tab"><?php echo esc_html__( 'Login', 'tokoo' ); ?></a></li>
				<?php if ( $is_registration_enabled ) : ?>
				<li><a href="#customer-register-form" class="login-register-tab" data-toggle="tab"><?php echo esc_html__( 'Register', 'tokoo' ); ?></a></li>
				<?php endif; ?>
			</ul>
			<div class="login-register-forms-inner">
				
				<?php wc_print_notices(); ?>

				<?php do_action( 'woocommerce_before_customer_login_form' ); ?>

				<?php if ( $is_registration_enabled ) : ?>

				<div class="tab-content u-columns col2-set" id="customer_login">

					<div class="u-column1 col-1 tab-pane fade show active" id="customer-login-form">

				<?php endif; ?>

						<form class="woocommerce-form woocommerce-form-login login" method="post">

							<?php do_action( 'woocommerce_login_form_start' ); ?>

							<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
								<label for="username"><?php esc_html_e( 'Username or email address', 'tokoo' ); ?> <span class="required">*</span></label>
								<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" autocomplete="username" id="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
							</p>
							
								
							
							
							<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
								<span class="password-label">
									<label for="password"><?php esc_html_e( 'Password', 'tokoo' ); ?> <span class="required">*</span></label>
									<a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'Lost your password?', 'tokoo' ); ?></a>
								</span>
								<input class="woocommerce-Input woocommerce-Input--text input-text" type="password" name="password" id="password" autocomplete="current-password" />
							</p>


							<?php do_action( 'woocommerce_login_form' ); ?>

							<p class="form-row">
								<label class="woocommerce-form__label woocommerce-form__label-for-checkbox inline">
									<input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" /> <span><?php esc_html_e( 'Keep me logged in', 'tokoo' ); ?></span>
								</label>
							</p>

							<p class="form-row">
								<?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
								<button type="submit" class="woocommerce-Button button" name="login" value="<?php esc_attr_e( 'Login', 'tokoo' ); ?>"><?php esc_html_e( 'Login', 'tokoo' ); ?></button>
							</p>

							<?php do_action( 'woocommerce_login_form_end' ); ?>

						</form>

				<?php if ( $is_registration_enabled ) : ?>

					</div>

					<div class="u-column2 col-2 tab-pane fade" id="customer-register-form">

						<form method="post" class="register submit_register_form_rohit">

							<?php do_action( 'woocommerce_register_form_start' ); ?>
 
								<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-first">
		    <label for="reg_billing_first_name"><?php _e( 'Name', 'tokoo' ); ?> <span class="required">*</span></label>
		    <input type="text" required class="woocommerce-Input woocommerce-Input--text input-text" name="billing_first_name" id="reg_billing_first_name" value="<?php if ( ! empty( $_POST['billing_first_name'] ) ) esc_attr_e( $_POST['billing_first_name'] ); ?>" />
		     <input type="hidden" class="get_site_url" value="<?php echo get_site_url(); ?>" name="get_site_url">
		     <input type="hidden" class="get_otp"/>
             <input type="hidden" class="submit_status" value="1"/>
	    </p> 

							<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
								<label for="reg_email"><?php esc_html_e( 'Email address', 'tokoo' ); ?> <span class="required">*</span></label>
								<input type="email" required class="woocommerce-Input woocommerce-Input--text input-text" name="email" id="reg_email" value="<?php echo ( ! empty( $_POST['email'] ) ) ? esc_attr( wp_unslash( $_POST['email'] ) ) : ''; ?>" /> 
							</p>
                             
                             
                             	<p class="woocommerce-form-row woocommerce-form-row--wide  form-row form-row-wide">
		    <label for="reg_billing_phone"><?php _e( 'Mobile', 'tokoo' ); ?> <span class="required">*</span></label>
		    <input type="text" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" pattern="\d*" maxlength="10"  autocomplete="off" required class="woocommerce-Input woocommerce-Input--text input-text reg_billing_phone" name="billing_phone" id="reg_billing_phone" value="<?php if ( ! empty( $_POST['billing_phone'] ) ) esc_attr_e( $_POST['billing_phone'] ); ?>" />
	    </p> 
	    
	    
							 
								<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
									<label for="reg_password"><?php esc_html_e( 'Password', 'tokoo' ); ?> <span class="required">*</span></label>
									<input type="password" required class="woocommerce-Input woocommerce-Input--text input-text" name="password" value="<?php echo ( ! empty( $_POST['password'] ) ) ? esc_attr(  $_POST['password'] ) : ''; ?>" id="reg_password" autocomplete="new-password" />
								</p>
								
        <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide all_log_bg" style="display:none">
								<label for="username"><?php esc_html_e( 'Enter OTP Number', 'tokoo' ); ?> <span class="required">*</span></label>
								<input type="text" class="woocommerce-Input woocommerce-Input--text input-text fill_otp" pattern="\d*" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" maxlength="4" placeholder="Enter OTP Number" /> 
								<a href="javascript:;" class="btn-success card-link submit_otp">Submit OTP</a>
                            <a href="javascript:;" class="pull-right btn-primary card-link resend_otp">Resend OTP</a>
							</p>

							<?php do_action( 'woocommerce_register_form' ); ?>

							<p class="woocommerce-FormRow form-row">
								<?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
								<button type="submit" class="woocommerce-Button button apply_online_submit" name="register" value="<?php esc_attr_e( 'Register', 'tokoo' ); ?>"><?php esc_html_e( 'Register', 'tokoo' ); ?></button>
							</p>

							<?php do_action( 'woocommerce_register_form_end' ); ?>

						</form>

					</div>

				</div>
				<?php endif; ?>

				<?php do_action( 'woocommerce_after_customer_login_form' ); ?>
			</div>
		</div>
	</div>
</div>