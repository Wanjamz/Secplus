<?php
/**
 * Plugin Name:       SecPlus Core
 * Description:       Site functionality for SecPlus Consulting: consultation enquiry form and enquiry inbox, WhatsApp-style FAQ chat, contact settings, launch checklist (Pending Client Confirmation items), SEO metadata and the website content importer. Designed for the SecPlus block theme.
 * Version:           1.2.0
 * Requires at least: 6.6
 * Requires PHP:      7.4
 * Author:            SecPlus Consulting
 * License:           GPL-2.0-or-later
 * Text Domain:       secplus-core
 *
 * @package SecPlusCore
 */

defined( 'ABSPATH' ) || exit;

define( 'SECPLUS_CORE_VERSION', '1.2.0' );
define( 'SECPLUS_CORE_FILE', __FILE__ );
define( 'SECPLUS_CORE_DIR', plugin_dir_path( __FILE__ ) );
define( 'SECPLUS_CORE_URL', plugin_dir_url( __FILE__ ) );

require_once SECPLUS_CORE_DIR . 'includes/settings.php';
require_once SECPLUS_CORE_DIR . 'includes/enquiries.php';
require_once SECPLUS_CORE_DIR . 'includes/blocks.php';
require_once SECPLUS_CORE_DIR . 'includes/seo.php';
require_once SECPLUS_CORE_DIR . 'includes/checklist.php';
require_once SECPLUS_CORE_DIR . 'includes/importer.php';
require_once SECPLUS_CORE_DIR . 'includes/site.php';
require_once SECPLUS_CORE_DIR . 'includes/chat.php';

/**
 * Top-level admin menu. Sub-pages are added by the include files.
 */
function secplus_core_admin_menu() {
	add_menu_page(
		__( 'SecPlus', 'secplus-core' ),
		__( 'SecPlus', 'secplus-core' ),
		'edit_pages',
		'secplus',
		'secplus_core_render_checklist_page',
		'dashicons-building',
		3
	);
	add_submenu_page( 'secplus', __( 'Launch checklist', 'secplus-core' ), __( 'Launch checklist', 'secplus-core' ), 'edit_pages', 'secplus', 'secplus_core_render_checklist_page' );
}
add_action( 'admin_menu', 'secplus_core_admin_menu', 9 );

/**
 * Flush rewrite rules after the enquiry post type is registered on activation.
 */
function secplus_core_activate() {
	secplus_core_register_enquiry_type();
	flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'secplus_core_activate' );
