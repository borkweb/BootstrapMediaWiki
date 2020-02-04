<?php
/**
 * SkinTemplate class for the BootstrapMediaWiki skin
 *
 * @ingroup Skins
 */
class SkinBootstrapMediaWiki extends SkinTemplate {
	public $skinname       = 'bootstrap-mediawiki';
	public $stylename      = 'bootstrap-mediawiki';
	public $template       = 'BootstrapMediaWikiTemplate';
	public $useHeadElement = true;

	/**
	 * Add CSS via ResourceLoader
	 *
	 * @param $out OutputPage
	 */
	public function initPage( OutputPage $out ) {
		$out->addMeta(
			'viewport',
			'width=device-width, initial-scale=1.0, user-scalable=yes, minimum-scale=0.25, maximum-scale=5.0'
		);

		$styles = [
				'mediawiki.skinning.interface',
				'mediawiki.skinning.content.externallinks',
				'skins.bootstrapmediawiki',
		];

		if ( file_exists( dirname( __DIR__ ) . '/resources/custom.css' ) ) {
			$styles[] = 'skins.boostrapmediawiki.custom';
		}

		$scripts = [
			'skins.bootstrapmediawiki.js',
		];

		if ( file_exists( dirname( __DIR__ ) . '/resources/custom.js' ) ) {
			$styles[] = 'skins.boostrapmediawiki.custom.js';
		}

		$out->addModuleStyles( $styles );
		$out->addModules( $scripts );
	}
}
