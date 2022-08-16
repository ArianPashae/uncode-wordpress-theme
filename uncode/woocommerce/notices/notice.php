<?php
/**
 * Show messages
 *
 * @package 	WooCommerce/Templates
 * @version     3.9.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! $messages ) {
	return;
}

?>

<?php foreach ( $messages as $message ) : ?>
	<?php if ( is_product() ) : ?>
	<div class="row-container row-message">
		<div class="row-parent limit-width double-top-padding no-bottom-padding">
	<?php endif; ?>

			<div class="woocommerce-info wc-notice"<?php echo function_exists( 'wc_get_notice_data_attr' ) ? wc_get_notice_data_attr( $message ) : ''; ?>>
				<?php
					echo wc_kses_notice( $message );
				?>
			</div>

	<?php if ( is_product() ) : ?>
		</div>
	</div>
	<?php endif; ?>
<?php endforeach; ?>
