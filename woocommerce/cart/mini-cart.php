<?php
/**
 * Mini-cart
 *
 * Contains the markup for the mini-cart, used by the cart widget.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/mini-cart.php.
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
 * @version 3.7.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

?>

<?php do_action( 'woocommerce_before_mini_cart' ); ?>

<?php if ( ! WC()->cart->is_empty() ) : ?>

    <ul class="woocommerce-mini-cart cart_list product_list_widget <?php echo esc_attr( $args['list_class'] ); ?>">

    <?php do_action( 'woocommerce_before_mini_cart_contents' ); ?>

    <?php
    foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
        $_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
        $product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

        if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
            if ( version_compare( WC_VERSION, '2.7', '>' ) ) {
                $product_name      = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key );
            } else {
                $product_name      = apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key );
            }
            $thumbnail         = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
            $product_price     = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
            $product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
            ?>
            <li class="<?php echo esc_attr( apply_filters( 'woocommerce_mini_cart_item_class', 'mini_cart_item', $cart_item, $cart_item_key ) ); ?>">
                <div class="cart-remove-icon">
                    <?php
                    echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                        'woocommerce_cart_item_remove_link', sprintf(
                        '<a href="%s" class="remove remove_from_cart_button" aria-label="%s" data-product_id="%s" data-cart_item_key="%s" data-product_sku="%s">&times;</a>',
                        esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
                        esc_attr__( 'Remove this item', 'dokani' ),
                        esc_attr( $product_id ),
                        esc_attr( $cart_item_key ),
                        esc_attr( $_product->get_sku() )
                    ), $cart_item_key );

                    ?>
                </div>
                <div class="mini-cart-content">
                    <?php $mini_cart_html = str_replace( array( 'http:', 'https:' ), '', $thumbnail ) . $product_name . '&nbsp;'; ?>
                    <?php if ( ! $_product->is_visible() ) : ?>
                        <?php echo wp_kses_post( $mini_cart_html ) ?>
                    <?php else : ?>
                        <a href="<?php echo esc_url( $product_permalink ); ?>">
                            <?php echo wp_kses_post( $mini_cart_html ); ?>
                        </a>
                    <?php endif; ?>
                    <?php echo wp_kses_post( wc_get_formatted_cart_item_data( $cart_item ) ); ?>

                    <?php echo wp_kses_post( apply_filters( 'woocommerce_widget_cart_item_quantity', '<span class="quantity">' . sprintf( '%s &times; %s', $cart_item['quantity'], $product_price ) . '</span>', $cart_item, $cart_item_key ) ); ?>
                </div>
            </li>
            <?php
        }
    }
    ?>

    <?php do_action( 'woocommerce_mini_cart_contents' ); ?>

<?php else : ?>

    <li class="empty"><?php esc_html_e( 'No products in the cart.', 'dokani' ); ?></li>

<?php endif; ?>

    </ul><!-- end product list -->

<?php if ( ! WC()->cart->is_empty() ) : ?>

    <p class="total"><strong><?php esc_html_e( 'Subtotal', 'dokani' ); ?>:</strong> <?php echo wp_kses_post( WC()->cart->get_cart_subtotal() ); ?></p>

    <?php do_action( 'woocommerce_widget_shopping_cart_before_buttons' ); ?>


    <p class="buttons clearfix">
        <?php if ( version_compare( WC_VERSION, '2.7', '>' ) ) : ?>
            <?php do_action( 'woocommerce_widget_shopping_cart_buttons' ); ?>
        <?php else: ?>
            <a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="button wc-forward"><?php esc_html_e( 'View Cart', 'dokani' ); ?></a>
            <a href="<?php echo esc_url( wc_get_checkout_url() ); ?>" class="button checkout wc-forward"><?php esc_html_e( 'Checkout', 'dokani' ); ?></a>
        <?php endif; ?>
    </p>

<?php endif; ?>

<?php do_action( 'woocommerce_after_mini_cart' ); ?>
