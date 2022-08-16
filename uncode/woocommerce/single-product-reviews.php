<?php
/**
 * Display single product reviews (comments)
 *
 * @package 	WooCommerce/Templates
 * @version	 4.3.0
 */
global $product, $wp_query;
$old_query = $wp_query;
$post_type = uncode_get_current_post_type();

if ( ! $product ) {
	$products_args = array(
		'post_type' => 'product',
		'post_status' => 'publish',
		'posts_per_page' => '1',
		'orderby' => 'id',
		'order' => 'asc',
	);
	$products = get_posts( $products_args );
	foreach( $products as $_product ) {
		$product_id = $_product->ID;
	}
} else {
	if ( is_object( $product ) ) {
		$product_id = $product->get_id();
	} else {
		return;
	}
}

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! comments_open() && $post_type !== 'uncodeblock' ) {
	return;
}

if ( $post_type === 'uncodeblock' ) { //It removes nonce check on Product Builder
	remove_action( 'comment_form', 'wp_comment_form_unfiltered_html_nonce' );
}

?>
<div id="reviews" class="woocommerce-Reviews">
	<div id="comments" class="woocomments">
		<?php if ( ! isset( $vc_shortcode ) ) { ?>
		<h5 class="woocomments-title woocommerce-Reviews-title"><?php
			if ( get_option( 'woocommerce_enable_review_rating' ) === 'yes' && ( $count = $product->get_review_count() ) ) {
				printf( _n( '%s review', '%s reviews', $count, 'woocommerce' ), esc_html__('Product', 'woocommerce') );
			} else {
				esc_html_e( 'Reviews', 'woocommerce' );
			}
		?></h5>
		<?php } ?>

		<?php if ( have_comments() || ( ( is_object( $product ) && $product->get_review_count() ) || $post_type == 'uncodeblock' || isset( $vc_shortcode ) ) ) : ?>

			<?php
				if ( $post_type == 'uncodeblock' || isset( $vc_shortcode ) ) {
					$commenter = wp_get_current_commenter();
					$comments_args = array(
						'post_id' => $product_id,
						'order' => 'ASC'
					);
					if ( empty( $commenter['comment_author'] ) ) {
						$comments_args['status'] = 'approve';
					}
					$comments = get_comments( $comments_args );
					$wp_query->comments = $comments;
					$cpage = get_query_var('cpage');
					if ( $cpage == '' ) {
						$cpage = get_option( 'default_comments_page' ) == 'newest' && get_option( 'comment_order' ) == 'asc' ? get_comment_pages_count() : 1;
					}
					set_query_var('cpage',$cpage);
				}
			?>
			<ul class="commentlist" data-comment-amout="<?php echo esc_attr( get_comments_number() ); ?>">
				<?php
					wp_list_comments( apply_filters( 'woocommerce_product_review_list_args', array( 'callback' => 'woocommerce_comments' ) ) );
					$wp_query = $old_query;
				?>
			</ul>

			<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
				echo '<nav class="woocommerce-pagination">';
				paginate_comments_links( apply_filters( 'woocommerce_comment_pagination_args', array(
					'prev_text' => is_rtl() ? '&rarr;' : '&larr;',
					'next_text' => is_rtl() ? '&larr;' : '&rarr;',
					'type'	  => 'list',
				) ) );
				echo '</nav>';
			endif; ?>

		<?php else : ?>

			<p class="woocommerce-noreviews"><?php esc_html_e( 'There are no reviews yet.', 'woocommerce' ); ?></p>

		<?php endif; ?>
	</div>
	<?php if ( get_option( 'woocommerce_review_rating_verification_required' ) === 'no' || wc_customer_bought_product( '', get_current_user_id(), $product->get_id() ) ) : ?>

		<div id="review_form_wrapper">
			<div id="review_form">
				<?php
					$commenter = wp_get_current_commenter();

					$comment_form = array(
						'title_reply'		  => ( have_comments() || ( ( is_object( $product ) && $product->get_review_count() ) || $post_type == 'uncodeblock' || isset( $vc_shortcode ) ) ) ? esc_html__( 'Add a review', 'woocommerce' ) : sprintf( esc_html__( 'Be the first to review &ldquo;%s&rdquo;', 'woocommerce' ), get_the_title() ),
						'title_reply_to'	   => esc_html__( 'Leave a Reply to %s', 'woocommerce' ),
						'title_reply_before'   => '<h6 id="reply-title" class="comment-reply-title">',
						'title_reply_after'	=> '</h6>',
						'comment_notes_before' => '',
						'comment_notes_after'  => '',
						'fields'			   => array(
							'author' => '<p class="comment-form-author">' . '<label for="author">' . esc_html__( 'Name', 'woocommerce' ) . ' <span class="required">*</span></label> ' .
										'<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" required /></p>',
							'email'  => '<p class="comment-form-email"><label for="email">' . esc_html__( 'Email', 'woocommerce' ) . ' <span class="required">*</span></label> ' .
										'<input id="email" name="email" type="email" value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="30" required /></p>',
						),
						'label_submit'  => esc_html__( 'Submit', 'woocommerce' ),
						'logged_in_as'  => '',
						'comment_field' => ''
					);

					if ( $account_page_url = wc_get_page_permalink( 'myaccount' ) ) {
						$comment_form['must_log_in'] = '<p class="must-log-in">' . sprintf( esc_html__( 'You must be %1$slogged in%2$s to post a review.', 'woocommerce' ), '<a href="' . esc_url( $account_page_url ) . '">', '</a>' ) . '</p>';
					}

					if ( get_option( 'woocommerce_enable_review_rating' ) === 'yes' ) {
						$comment_form['comment_field'] = '<p class="comment-form-rating"><label for="rating" class="hidden">' . esc_html__( 'Your rating', 'woocommerce' ) . ( wc_review_ratings_required() ? '&nbsp;<span class="required">*</span>' : '' ) . '</label><select name="rating" id="rating">
							<option value="">' . esc_html__( 'Rate&hellip;', 'woocommerce' ) . '</option>
							<option value="5">' . esc_html__( 'Perfect', 'woocommerce' ) . '</option>
							<option value="4">' . esc_html__( 'Good', 'woocommerce' ) . '</option>
							<option value="3">' . esc_html__( 'Average', 'woocommerce' ) . '</option>
							<option value="2">' . esc_html__( 'Not that bad', 'woocommerce' ) . '</option>
							<option value="1">' . esc_html__( 'Very Poor', 'woocommerce' ) . '</option>
						</select></p>';
					}

					$comment_form['comment_field'] .= '<p class="comment-form-comment"><label for="comment">' . esc_html__( 'Your review', 'woocommerce' ) . '</label><textarea id="comment" name="comment" cols="45" rows="8"></textarea></p>';

					comment_form( apply_filters( 'woocommerce_product_review_comment_form_args', $comment_form ) );
				?>
			</div>
		</div>

	<?php else : ?>

		<p class="woocommerce-verification-required"><?php esc_html_e( 'Only logged in customers who have purchased this product may leave a review.', 'woocommerce' ); ?></p>

	<?php endif; ?>

	<div class="clear"></div>
</div>
<?php
