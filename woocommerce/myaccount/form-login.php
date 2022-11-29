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
 * @package WooCommerce/Templates
 * @version 4.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

do_action( 'woocommerce_before_customer_login_form' ); ?>

<?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) : ?>

<div class="u-columns col2-set row" id="customer_login">

    <div class="u-column1 col-lg-6">

        <?php endif; ?>
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <h5 class="streamit-wc-login-title"><?php esc_html_e( 'Login', 'streamit' ); ?></h5>

                <form class="woocommerce-form woocommerce-form-login login" method="post">

                    <?php do_action( 'woocommerce_login_form_start' ); ?>

                    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                        <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username"
                            id="username" autocomplete="username"
                            placeholder="<?php echo esc_attr('Username or email address *','streamit'); ?>"
                            value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
                    </p>
                    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                        <input class="woocommerce-Input woocommerce-Input--text input-text" type="password"
                            name="password" id="password" autocomplete="current-password"
                            placeholder="<?php echo esc_attr('Password *','streamit'); ?>" />
                    </p>

                    <?php do_action( 'woocommerce_login_form' ); ?>
                    <p class="woocommerce-form-row">
                        <div class="streamit-check">
                            <label class="woocommerce-form__label woocommerce-form__label-for-checkbox inline">
                                <input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme"
                                    type="checkbox" id="rememberme" value="forever" />
                                    <span class="checkmark"></span>
                                <span class="text-check"><?php esc_html_e( 'Remember me', 'streamit' ); ?></span>
                            </label>
                        </div>
                    </p>
                    <p class="form-row">
                        <?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
                        <!-- login button -->
                        <button type="submit" class="iq-button btn btn-hover woocommerce-Button" name="login"
                            value="<?php esc_attr_e( 'Log in', 'streamit' ); ?>">
                            <?php esc_html_e( 'Log in', 'streamit' ); ?>
                        </button>
                    </p>
                    <p class="woocommerce-LostPassword lost_password">
                        <a
                            href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'Lost your password?', 'streamit' ); ?></a>
                    </p>

                    <?php do_action( 'woocommerce_login_form_end' ); ?>

                </form>
            </div>
        </div>
        <?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) : ?>

    </div>

    <div class="u-column2 col-lg-6">

        <h5 class="streamit-wc-login-title"><?php esc_html_e( 'Register', 'streamit' ); ?></h5>

        <form method="post" class="woocommerce-form woocommerce-form-register register"
            <?php do_action( 'woocommerce_register_form_tag' ); ?>>

            <?php do_action( 'woocommerce_register_form_start' ); ?>

            <?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>

            <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username"
                    id="reg_username" autocomplete="username"
                    placeholder="<?php echo esc_attr('Username *','streamit'); ?>"
                    value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
            </p>

            <?php endif; ?>

            <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                <input type="email" class="woocommerce-Input woocommerce-Input--text input-text" name="email"
                    id="reg_email" autocomplete="email"
                    placeholder="<?php echo esc_attr('Email address *','streamit'); ?>"
                    value="<?php echo ( ! empty( $_POST['email'] ) ) ? esc_attr( wp_unslash( $_POST['email'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
            </p>

            <?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>

            <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                <input type="password" class="woocommerce-Input woocommerce-Input--text input-text" name="password"
                    id="reg_password" autocomplete="new-password"
                    placeholder="<?php echo esc_attr('Password *','streamit'); ?>" />
            </p>

            <?php endif; ?>

            <?php do_action( 'woocommerce_register_form' ); ?>

            <p class="woocommerce-FormRow form-row">
                <?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
                <!-- register button  -->
                <button type="submit" class="iq-button btn btn-hover woocommerce-Button" name="register"
                    value="<?php esc_attr_e( 'Register', 'streamit' ); ?>">
                    <?php esc_html_e( 'Register', 'streamit' ); ?>
                    <i class="fas fa-angle-right" aria-hidden="true"></i>
                </button>
            </p>

            <?php do_action( 'woocommerce_register_form_end' ); ?>

        </form>

    </div>

</div>
<?php endif; ?>

<?php do_action( 'woocommerce_after_customer_login_form' );