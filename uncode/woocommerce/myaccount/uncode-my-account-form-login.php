<?php
/**
 * Login Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/uncode-my-account-form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

do_action( 'woocommerce_before_customer_login_form' );

$form_title_classes  = implode( ' ', $form_classes[ 'title' ] );
$form_button_classes = implode( ' ', $form_classes[ 'button' ] );
?>

<h2 class="<?php echo esc_attr( $form_title_classes ); ?>"><?php esc_html_e( 'Login', 'woocommerce' ); ?></h2>

<form class="woocommerce-form woocommerce-form-login login" method="post">

	<?php do_action( 'woocommerce_login_form_start' ); ?>

	<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
		<label for="username"><?php esc_html_e( 'Username or email address', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
		<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" placeholder="<?php echo esc_attr( uncode_woocommerce_get_form_field_placeholder( 'username-email' ) ); ?>" /><?php // @codingStandardsIgnoreLine ?>
	</p>
	<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
		<label for="password"><?php esc_html_e( 'Password', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
		<input class="woocommerce-Input woocommerce-Input--text input-text" type="password" name="password" id="password" autocomplete="current-password" placeholder="<?php echo esc_attr( uncode_woocommerce_get_form_field_placeholder( 'password' ) ); ?>" />
	</p>

	<?php do_action( 'woocommerce_login_form' ); ?>

	<p class="form-row">
		<label class="woocommerce-form__label woocommerce-form__label-for-checkbox woocommerce-form-login__rememberme">
			<input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" /> <span><?php esc_html_e( 'Remember me', 'woocommerce' ); ?></span>
		</label>
		<?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
		<button type="submit" class="woocommerce-button button woocommerce-form-login__submit btn <?php echo esc_attr( $form_button_classes ); ?>" name="login" value="<?php esc_attr_e( 'Log in', 'woocommerce' ); ?>" style="<?php echo esc_attr( $button_adjust_value ? 'margin-top:' . $button_adjust_value . 'px' : '' ); ?>"><?php esc_html_e( 'Log in', 'woocommerce' ); ?></button>
	</p>
	<p class="woocommerce-LostPassword lost_password">
		<a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'Lost your password?', 'woocommerce' ); ?></a>
	</p>

	<?php do_action( 'woocommerce_login_form_end' ); ?>

</form>

<?php do_action( 'woocommerce_after_customer_login_form' ); ?>
