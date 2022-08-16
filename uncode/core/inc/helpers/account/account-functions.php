<?php
/**
 * Account related functions.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Get account URL
 */
function uncode_get_login_url() {
	if ( class_exists( 'WooCommerce' ) ) {
		$account_url = wc_get_page_permalink( 'myaccount' );
	} else {
		$account_url = admin_url();
	}

	return $account_url;
}

/**
 * Add account icon to menu
 */
function uncode_add_account_in_menu( $login_account_icon, $login_account_class ) {
	global $menutype;

	$horizontal_menu = ( strpos($menutype ,'hmenu' ) !== false ) ? true : false;
	$vertical = ( strpos($menutype, 'vmenu' ) !== false || $menutype === 'menu-overlay' || $menutype === 'menu-overlay-center' ) ? true : false;

	$account_url  = uncode_get_login_url();
	$account_text = is_user_logged_in() ? __( 'My Account', 'uncode' ) : __( 'Login / Register', 'uncode' );

	ob_start();
	?>

	<li class="<?php echo esc_attr( $login_account_class ); ?> uncode-account menu-item-link menu-item">
		<a href="<?php echo esc_url( $account_url ); ?>" data-type="title" title="account">
			<span class="account-icon-container">
				<?php if ( $horizontal_menu ) : ?>
					<i class="<?php echo esc_attr( $login_account_icon ); ?>"></i><span class="desktop-hidden"><?php echo esc_html( $account_text ); ?></span>
				<?php else : ?>
					<i class="<?php echo esc_attr( $login_account_icon ); ?>"></i><span><?php echo esc_html( $account_text ); ?></span>
				<?php endif; ?>
			</span>
		</a>
	</li>

	<?php
	$icon = ob_get_clean();

    return $icon;
}
