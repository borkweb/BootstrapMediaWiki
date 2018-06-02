<?php
/**
 * Remove the standard user login form
 *
 * require_once($IP."/skins/bootstrap-mediawiki/NoUserLoginForm.php");
 *
 * @author Creative Commons Corporation
 * @license GPLv2+
 * @version 0.1
 */

if ( !defined( 'MEDIAWIKI' ) ) {
    die( 'This file is a MediaWiki extension and not a valid entry point' );
}

$wgExtensionCredits['other'][] = array(
    'name'        => 'NoUserCreateForm',
    'version'     => '0.1',
    'author'      => 'Creative Commons Corporation',
    'url'         => 'https://github.com/creativecommons/bootstrap-mediawiki',
    'description' => 'Removes the standard user creation form'
);

$wgHooks['UserLoginForm'][] = 'noUserLoginForm';

class NoUserLoginFormTemplate extends BaseTemplate {

	function execute() {
        // A link to log in/out would be confusing, text would require i18n
        echo '<span style="font-size:24pt">&#10004;</span>';
    }

    function getExtraInputDefinitions() {
        return [];
    }
}

function noUserLoginForm( &$template ) {
    $template = new NoUserLoginFormTemplate();
	return true ;
}
