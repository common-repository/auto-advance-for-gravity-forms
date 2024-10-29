<?php

/*
Plugin Name: Auto Advance for GravityForms
Description:  The Auto Advance plugin for Gravity Forms makes the form filling process quicker and more user friendly for visitors. The plugin gives an easy way to choose which field(s) trigger an auto advance to the next step of your form.
Version: 5.0.2
Author: Frog Eat Fly 
Tested up to: 6.6.2
Author URI: https://www.multipagepro.com/
*/
define( 'AAFG_PRO_PLAN_NAME', 'autoadvanceforgravityformspro' );
define( 'AAFG_PLUS_PLAN_NAME', 'autoadvanceforgravityformsplus' );
define( 'ZZD_AAGF_DIR', plugin_dir_path( __FILE__ ) );
define( 'ZZD_AAGF_URL', plugin_dir_url( __FILE__ ) );
define( 'AUTO_ADVANCED_ZZD', '5.0.2' );
define( 'AUTO_ADVANCED_ASSETS', '5.0.2' );
if ( !function_exists( 'aafgf_fs' ) ) {
    // Create a helper function for easy SDK access.
    function aafgf_fs() {
        global $aafgf_fs;
        if ( !isset( $aafgf_fs ) ) {
            // Include Freemius SDK.
            require_once dirname( __FILE__ ) . '/freemius/start.php';
            $aafgf_fs = fs_dynamic_init( array(
                'id'             => '6159',
                'slug'           => 'auto-advance-for-gravity-forms',
                'type'           => 'plugin',
                'public_key'     => 'pk_03c636a8e7786094d99a1bf5e2e43',
                'is_premium'     => false,
                'has_addons'     => false,
                'has_paid_plans' => true,
                'menu'           => array(
                    'first-path' => 'plugins.php',
                    'support'    => false,
                ),
                'is_live'        => true,
            ) );
        }
        return $aafgf_fs;
    }

    // Init Freemius.
    aafgf_fs();
    // Signal that SDK was initiated.
    do_action( 'aafgf_fs_loaded' );
    aafgf_fs()->add_filter( 'pricing_url', 'aafgf_upgrade_url' );
    function aafgf_upgrade_url(  $url  ) {
        $modified_url = "https://www.multipagepro.com/";
        return $modified_url;
    }

}
add_action( 'gform_loaded', array('GF_Auto_Advanced_AddOn', 'load'), 5 );
class GF_Auto_Advanced_AddOn {
    public static function load() {
        if ( !method_exists( 'GFForms', 'include_addon_framework' ) ) {
            return;
        }
        require_once ZZD_AAGF_DIR . 'php/class-gfautoadvancedaddon.php';
        GFAddOn::register( 'GFAutoAdvancedAddOn' );
    }

}

add_action( 'plugins_loaded', 'load_aagf_languages', 0 );
function load_aagf_languages() {
    load_plugin_textdomain( 'gf-autoadvanced', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}

function aafg_simple_addon() {
    return GFAutoAdvancedAddOn::get_instance();
}

function aagf_fn_validate_required_plugins() {
    if ( !method_exists( 'GFForms', 'include_payment_addon_framework' ) ) {
        return false;
    }
    return true;
}

function aagf_fn_admin_notice() {
    $show = false;
    $show = true;
    if ( isset( $_GET['show_notices'] ) ) {
        delete_transient( 'aafg-notice' );
        delete_transient( 'aafg-version-notice' );
        $show = true;
    }
    if ( !aagf_fn_validate_required_plugins() ) {
        ?>
		<div id="aafg-notice-error" class="aafg-notice-error notice notice-error">
			<div class="notice-container">
				<span> <?php 
        _e( "Auto Advanced Needs GravityForms Active", "gf-autoadvanced" );
        ?></span>
			</div>
		</div>
		<?php 
    } else {
        if ( $show && false == get_transient( 'aafg-version-notice' ) && current_user_can( 'install_plugins' ) ) {
            ?>
			<div id="aafg-version-notice" class="aafg-notice notice is-dismissible ">
				<div class="notice-container">
					<div class="notice-image big-image">
						<img src="<?php 
            echo ZZD_AAGF_URL;
            ?>/images/IMPORTANT UPDATE NOTICE.png" class="big-logo" alt="AAFG">
					</div> 
					<div class="notice-content">
						<div class="notice-heading">
							<?php 
            _e( "MPAA Basic is now limited to the following options:", "gf-autoadvanced" );
            ?>
						</div>
						<?php 
            _e( "1. Auto advance for radio buttons", "gf-autoadvanced" );
            ?>  <br>
						<?php 
            _e( "2. Auto advance for dropdown fields", "gf-autoadvanced" );
            ?>  <br>
						<?php 
            _e( "Basic no longer supports the option to hide buttons or any of the other features that were standard with the basic version.", "gf-autoadvanced" );
            ?>  <br>
						
						<div class="notice-footer">
							Don't worry, we've extended the upgrade option until 9/27/24. Use code <strong>upgrade50</strong> to get 50% off the annual or lifetime price of Multi Page Pro or Plus.<br>
							Don't wait!<br>
							For all features, pricing, and to upgrade, visit <a href="https://multipagepro.com">https://multipagepro.com</a><br>
						</div>
					</div>	

					
						
					</div>					
				</div>
			</div>
		<?php 
        } else {
            if ( $show && false == get_transient( 'aafg-notice' ) && current_user_can( 'install_plugins' ) ) {
                ?>
			<div id="aafg-notice" class="aafg-notice notice is-dismissible ">
				<div class="notice-container">
					<div class="notice-image">
						<img src="<?php 
                echo ZZD_AAGF_URL;
                ?>/images/icon.png" class="custom-logo" alt="AAFG">
					</div> 
					<div class="notice-content">
						<div class="notice-heading">
							<?php 
                _e( "Hi there, Thanks for using Multi Page Auto Advanced for Gravity Forms", "gf-autoadvanced" );
                ?>
						</div>
						<?php 
                _e( "Did you know our PRO version includes the ability to use the auto advance functionality conditionally per selection? Check it out!", "gf-autoadvanced" );
                ?>  <br>
						<div class="aafg-review-notice-container">
							<a href="https://gformsdemo.com/gravity-forms-auto-advance-demo/#multipro" class="aafg-notice-close aafg-review-notice button-primary" target="_blank">
							<?php 
                _e( "See The Demo", "gf-autoadvanced" );
                ?>
							</a>
							
						<span class="dashicons dashicons-smiley"></span>
							<a href="#" class="aafg-notice-close notice-dis aafg-review-notice">
							<?php 
                _e( "Dismiss", "gf-autoadvanced" );
                ?>
							</a>
						</div>
					</div>				
				</div>
			</div>
		<?php 
            }
        }
    }
}

add_action( 'admin_notices', 'aagf_fn_admin_notice' );
add_action( 'wp_ajax_aafg-notice-dismiss', 'aafg_ajax_fn_dismiss_notice' );
function aafg_ajax_fn_dismiss_notice() {
    $notice_id = ( isset( $_POST['notice_id'] ) ? sanitize_key( $_POST['notice_id'] ) : '' );
    $repeat_notice_after = 7 * DAY_IN_SECONDS;
    if ( $notice_id == 'aafg-version-notice' ) {
        $repeat_notice_after = 7 * DAY_IN_SECONDS;
    }
    if ( !empty( $notice_id ) ) {
        if ( !empty( $repeat_notice_after ) ) {
            set_transient( $notice_id, true, $repeat_notice_after );
            wp_send_json_success();
        }
    }
}
