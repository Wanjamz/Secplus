<?php
/**
 * Shared data helpers for the SecPlus theme.
 *
 * @package SecPlus
 */

defined( 'ABSPATH' ) || exit;

/**
 * Principal service lines. Paths match the pages created by the SecPlus Core importer.
 *
 * @return array<string, array<string,string>>
 */
function secplus_services() {
	return array(
		'company-registration' => array(
			'title' => __( 'Company Registration & Entity Setup', 'secplus' ),
			'path'  => '/services/company-registration/',
			'icon'  => 'building',
			'text'  => __( 'Guidance on choosing a suitable structure and completing the registration steps for Kenyan and international founders.', 'secplus' ),
			'cta'   => __( 'Request Registration Guidance', 'secplus' ),
		),
		'corporate-compliance' => array(
			'title' => __( 'Corporate Compliance & Statutory Filings', 'secplus' ),
			'path'  => '/services/corporate-compliance/',
			'icon'  => 'shield-check',
			'text'  => __( 'Support for annual returns, corporate records and company changes so your statutory obligations stay in view.', 'secplus' ),
			'cta'   => __( 'Request a Compliance Review', 'secplus' ),
		),
		'company-secretarial'  => array(
			'title' => __( 'Company Secretarial Services', 'secplus' ),
			'path'  => '/services/company-secretarial/',
			'icon'  => 'register',
			'text'  => __( 'Dependable corporate administration, statutory registers, resolutions and meeting support beyond registration.', 'secplus' ),
			'cta'   => __( 'Discuss Secretarial Support', 'secplus' ),
		),
		'corporate-governance' => array(
			'title' => __( 'Corporate Governance & Board Support', 'secplus' ),
			'path'  => '/services/corporate-governance/',
			'icon'  => 'landmark',
			'text'  => __( 'Board administration, governance documents and reviews that help your board govern with confidence.', 'secplus' ),
			'cta'   => __( 'Discuss Governance Support', 'secplus' ),
		),
		'corporate-advisory'   => array(
			'title' => __( 'Corporate Advisory & Restructuring', 'secplus' ),
			'path'  => '/services/corporate-advisory/',
			'icon'  => 'restructure',
			'text'  => __( 'Professional support when ownership, share capital or corporate structures need to change.', 'secplus' ),
			'cta'   => __( 'Discuss a Corporate Matter', 'secplus' ),
		),
	);
}

/**
 * Maps Insight categories to the most relevant service.
 *
 * @return array<string,string>
 */
function secplus_category_service_map() {
	return array(
		'starting-a-business'          => 'company-registration',
		'international-investment'     => 'company-registration',
		'corporate-compliance'         => 'corporate-compliance',
		'company-secretarial-practice' => 'company-secretarial',
		'governance-and-boards'        => 'corporate-governance',
	);
}

/**
 * Insight topics (post categories). The SecPlus Core importer creates these categories.
 *
 * @return array<string, array<string,string>>
 */
function secplus_topics() {
	return array(
		'starting-a-business'          => array(
			'name' => __( 'Starting a Business in Kenya', 'secplus' ),
			'icon' => 'building',
			'text' => __( 'Entity options, registration steps and what to do after incorporation.', 'secplus' ),
		),
		'international-investment'     => array(
			'name' => __( 'International Investment & Market Entry', 'secplus' ),
			'icon' => 'globe',
			'text' => __( 'Establishing a Kenyan presence from abroad, branches and subsidiaries.', 'secplus' ),
		),
		'corporate-compliance'         => array(
			'name' => __( 'Corporate Compliance', 'secplus' ),
			'icon' => 'shield-check',
			'text' => __( 'Annual returns, statutory records and company changes.', 'secplus' ),
		),
		'company-secretarial-practice' => array(
			'name' => __( 'Company Secretarial Practice', 'secplus' ),
			'icon' => 'register',
			'text' => __( 'The company secretary role, registers, resolutions and meetings.', 'secplus' ),
		),
		'governance-and-boards'        => array(
			'name' => __( 'Governance & Boards', 'secplus' ),
			'icon' => 'landmark',
			'text' => __( 'Board processes, governance documents and effective oversight.', 'secplus' ),
		),
	);
}

/**
 * Site-relative URL helper.
 *
 * @param string $path Path beginning with a slash.
 * @return string
 */
function secplus_url( $path ) {
	return home_url( $path );
}
