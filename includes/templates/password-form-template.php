<?php
/**
 * Redeem gift card template.
 *
 * This template can be overriden by copying this file to your-theme/puredevs-wp-locker/password-form-template.php
 *
 * @author 		puredevs
 * @package 	PureDevs WP Locker Plugin Templates/Templates
 * @version     1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Don't allow direct access

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	
	<meta name="robots" content="noindex">
	
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<!-- pd-login-wrapper start -->
	<div class="pd-login-wrapper">
	
		<div class="pd-login-shape-left">
			<svg width="165" height="260" viewBox="0 0 165 260" fill="none" xmlns="http://www.w3.org/2000/svg">
			<circle cx="35" cy="130" r="130" fill="#F1F0FF"/>
			</svg>            
		</div>
		
		<div class='pdwl-from-container pd-login'>
			<?php
			$frm_heading = get_option( 'puredevs-wp-locker_frm_heading' );
			$frm_heading = $frm_heading ? $frm_heading : 'Protected Site';
			$sub_btn_text = get_option( 'puredevs-wp-locker_sub_btn_text' );
			$sub_btn_text = $sub_btn_text ? $sub_btn_text : 'Continue';
			?>
			<?php if( isset($_GET['valid']) && $_GET['valid'] == 'false' ):?><p class="error-msg"><span class="dashicons dashicons-warning"></span> <?php esc_html_e( 'Incorrect password. Please try again', 'puredevs-wp-locker' ); ?></p><?php endif; ?>
			<?php if( isset($_GET['n_valid']) && $_GET['n_valid'] == 'false' ):?><p class="error-msg"><span class="dashicons dashicons-warning"></span> <?php esc_html_e( 'Sorry, your nonce did not verify.', 'puredevs-wp-locker' ); ?></p><?php endif; ?>
			<h2 class="pd-login__heading"><?php echo esc_html( $frm_heading ) ?></h2>
			<form id="pdwl-loginfrm" class="pd-login__form" action="" method="post">
				<label for="password" class="pd-login__form-label"><?php esc_html_e( 'Enter Your Password and Continue', 'puredevs-wp-locker' ); ?></label>
				<input type="password" class="pd-login__form-control" id="password" placeholder="<?php esc_attr_e( 'Enter Password', 'puredevs-wp-locker' ); ?>" name="psw" required>
				<?php wp_nonce_field( 'pdwl_loginfrm_action', 'pdwl_loginfrm_nonce_field' ); ?>
				<button type="submit" class="pd-login__btn"><?php echo esc_html( $sub_btn_text ) ?></button>
			</form>

		</div>
		
		<div class="pd-login-shape-right">
			<svg width="393" height="587" viewBox="0 0 793 687" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path fill-rule="evenodd" clip-rule="evenodd" d="M639 522C783.146 522 900 405.146 900 261C900 116.854 783.146 0 639 0C494.854 0 378 116.854 378 261C378 315.082 394.449 365.323 422.618 406.991C403.223 417.204 390 437.558 390 461C390 494.689 417.311 522 451 522C475.779 522 497.107 507.226 506.656 486.006C545.459 508.879 590.697 522 639 522ZM506.656 486.006C510.089 478.375 512 469.911 512 461C512 427.311 484.689 400 451 400C440.753 400 431.096 402.527 422.618 406.991C444.369 439.167 473.107 466.231 506.656 486.006Z" fill="#F1F0FF"/>
				<circle cx="191" cy="461" r="61" fill="#F1F0FF"/>
				<circle cx="61" cy="461" r="61" fill="#F1F0FF"/>
				<circle cx="321" cy="461" r="61" fill="#F1F0FF"/>
				<circle cx="61" cy="591" r="61" fill="#F1F0FF"/>
				<circle cx="61" cy="327" r="61" fill="#F1F0FF"/>
				<circle cx="61" cy="721" r="61" fill="#F1F0FF"/>
            </svg>
		</div>

	</div>
	<!-- pd-login-wrapper end -->
<?php wp_footer(); ?>

</body>

</html>

<?php exit();?>