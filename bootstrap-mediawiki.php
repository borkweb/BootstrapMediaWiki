<?php
/**
 * Bootstrap MediaWiki
 *
 * @bootstrap-mediawiki.php
 * @ingroup Skins
 * @author Matthew Batchelder (http://borkweb.com)
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

if ( ! defined( 'MEDIAWIKI' ) ) die( "This is an extension to the MediaWiki package and cannot be run standalone." );

$wgExtensionCredits['skin'][] = array(
	'path'        => __FILE__,
	'name'        => 'Bootstrap Mediawiki',
	'url'         => 'http://borkweb.com',
	'author'      => '[http://borkweb.com Matthew Batchelder]',
	'description' => 'MediaWiki skin using Bootstrap 3',
);

$wgValidSkinNames['bootstrapmediawiki'] = 'BootstrapMediaWiki';
$wgAutoloadClasses['SkinBootstrapMediaWiki'] = __DIR__ . '/BootstrapMediaWiki.skin.php';

$wgResourceModules['skins.bootstrapmediawiki'] = array(
	'styles' => array(
		'bootstrap-mediawiki/bootstrap/css/bootstrap.min.css'            => array( 'media' => 'screen' ),
		'bootstrap-mediawiki/bootstrap/css/bootstrap-responsive.min.css' => array( 'media' => 'screen' ),
		'bootstrap-mediawiki/google-code-prettify/prettify.css'          => array( 'media' => 'screen' ),
		'bootstrap-mediawiki/style.css'                                  => array( 'media' => 'screen' ),
	),
	'scripts' => array(
		'bootstrap-mediawiki/bootstrap/js/bootstrap.min.js',
		'bootstrap-mediawiki/google-code-prettify/prettify.js',
		'bootstrap-mediawiki/js/behavior.js',
	),
	'dependencies' => array(
		'jquery',
		'jquery.mwExtension',
		'jquery.client',
		'jquery.cookie',
	),
	'remoteBasePath' => &$GLOBALS['wgStylePath'],
	'localBasePath'  => &$GLOBALS['wgStyleDirectory'],
);
