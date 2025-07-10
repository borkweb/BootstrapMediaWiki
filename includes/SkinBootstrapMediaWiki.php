<?php
/**
 * SkinTemplate class for the BootstrapMediaWiki skin
 *
 * @ingroup Skins
 */
class SkinBootstrapMediaWiki extends SkinTemplate {
	/** @var string Skin name */
	public $skinname = 'bootstrap-mediawiki';
	/** @var string Stylename */
	public $stylename = 'bootstrap-mediawiki';
	/** @var string Template name */
	public $template = 'BootstrapMediaWikiTemplate';
	/** @var bool Whether to use head element */
	public $useHeadElement = true;

	/**
	 * Add CSS via ResourceLoader
	 *
	 * @param OutputPage $out OutputPage instance
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
			$styles[] = 'skins.bootstrapmediawiki.custom';
		}

		$scripts = [
			'skins.bootstrapmediawiki.js',
		];

		if ( file_exists( dirname( __DIR__ ) . '/resources/custom.js' ) ) {
			$scripts[] = 'skins.bootstrapmediawiki.custom.js';
		}

		$out->addModuleStyles( $styles );
		$out->addModules( $scripts );
	}
}
