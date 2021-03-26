<?php
/**
 * BaseTemplate class for the BootstrapMediaWiki skin
 *
 * @ingroup Skins
 */
class BootstrapMediaWikiTemplate extends BaseTemplate {
	/**
	 * Outputs the entire contents of the page
	 */
	public function execute() {
		global $wgRequest;
		global $wgUser;
		global $wgCopyrightLink;
		global $wgCopyright;
		global $wgArticlePath;
		global $wgEnableUploads;
		global $wgLogo;
		global $wgTOCLocation;
		global $wgNavBarClasses;
		global $wgGroupPermissions;

		$this->skin = $this->data['skin'];
		$action = $wgRequest->getText( 'action' );
		$url_prefix = str_replace( '$1', '', $wgArticlePath );
		$subnav_links = $this->getPageLinks( 'Bootstrap:Subnav' );
		$subnav_select = $this->navSelect( $subnav_links );

		$this->html('headelement');
		?>
		<nav class="navbar sticky-top navbar-expand-lg <?php echo $wgNavBarClasses; ?>  navbar-dark bg-primary" role="navigation">
			<div class="container">
				<a class="navbar-brand" href="<?php echo $this->data['nav_urls']['mainpage']['href'] ?>" title="<?php echo $this->get( 'sitename' ); ?>">
					<?php echo isset( $wgLogo ) && $wgLogo ? "<img src='{$wgLogo}' alt='Logo'/> " : ''; echo $this->get( 'sitenameshort' ) ?: $this->get( 'sitename' ); ?>
				</a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>

				<div class="collapse navbar-collapse" id="navbarSupportedContent">
					<ul class="navbar-nav mr-auto">
						<li class="navbar-item">
							<a class="nav-link" href="<?php echo $this->data['nav_urls']['mainpage']['href'] ?>">Home</a>
						</li>
						<li class="navbar-item dropdown">
							<a href="#" class="nav-link dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Tools</a>
							<div class="dropdown-menu" aria-labelledby="navbarDropdown">
								<a class="dropdown-item recent-changes" href="<?php echo $url_prefix; ?>Special:RecentChanges"><i class="fa fa-edit"></i> Recent Changes</a>
								<a class="dropdown-item special-pages" href="<?php echo $url_prefix; ?>Special:SpecialPages"><i class="fa fa-star"></i> Special Pages</a>
								<?php if ( $wgEnableUploads ) { ?>
									<a class="dropdown-item upload-a-file" href="<?php echo $url_prefix; ?>Special:Upload"><i class="fa fa-upload"></i> Upload a File</a>
								<?php } ?>
							</div>
						</li>
						<?php echo $this->nav( $this->getPageLinks( 'Bootstrap:TitleBar' ) ); ?>
					</ul>
					<form class="form-inline my-2 my-lg-0" action="<?php $this->text( 'wgScript' ) ?>" id="searchform" role="search">
						<div>
							<input class="form-control mr-sm-2" type="search" name="search" placeholder="Search" title="Search <?php echo $this->get( 'sitename' ); ?> [ctrl-option-f]" accesskey="f" id="searchInput" autocomplete="off">
							<input type="hidden" name="title" value="Special:Search">
						</div>
					</form>
					<?php
					if ( $wgUser->isLoggedIn() ) {
						$personal_urls = $this->get( 'personal_urls' );
						if ( count( $personal_urls ) > 0 ) {
							$user_icon = '<span class="user-icon mr-1"><img src="https://secure.gravatar.com/avatar/'.md5(strtolower( $wgUser->getEmail())).'.jpg?s=20&r=g"/></span>';
							$name = strtolower( $wgUser->getName() );
							$user_nav = $this->getArrayLinks( $personal_urls, $user_icon . $name, 'user' );
							?>
							<ul<?php $this->html('userlangattributes') ?> class="nav navbar-nav navbar-right">
								<?php echo $user_nav; ?>
							</ul>
							<?php
						}//end if

						$content_actions = $this->get( 'content_actions' );
						if ( count( $content_actions ) > 0 ) {
							$content_nav = $this->getArrayLinks( $content_actions, 'Page', 'page' );
							?>
							<ul class="nav navbar-nav navbar-right content-actions"><?php echo $content_nav; ?></ul>
							<?php
						}//end if
					} else {  // else if is logged in
						?>
						<ul class="nav navbar-nav navbar-right">
							<li class="nav-item">
								<?php echo Linker::linkKnown( SpecialPage::getTitleFor( 'Userlogin' ), wfMessage( 'login' ), [ 'class' => 'nav-link' ] ); ?>
							</li>
							<?php if ( ! empty( $wgGroupPermissions['*']['createaccount'] ) ) : ?>
								<li class="nav-item ml-4">
									<?php echo Linker::linkKnown( SpecialPage::getTitleFor( 'CreateAccount' ), 'New user? Register here!', [ 'class' => 'nav-link' ] ); ?>
								</li>
							<?php endif; ?>
						</ul>
						<?php
					}
					?>
				</div>
			</div>
		</nav><!-- topbar -->
		<?php if ( $subnav_links ): ?>
			<div class="subnav subnav-fixed">
				<div class="container">
					<?php if ( trim( $subnav_select ) ) : ?>
						<select id="subnav-select">
							<?php echo $subnav_select; ?>
						</select>
					<?php endif; ?>
					<ul class="nav nav-pills">
						<?php echo $this->nav( $subnav_links ); ?>
					</ul>
				</div>
			</div>
		<?php endif; ?>
		<div id="wiki-outer-body">
			<div id="wiki-body" class="container">
				<?php if ( 'sidebar' == $wgTOCLocation ): ?>
					<div class="row">
						<section class="col-md-3 toc-sidebar"></section>
						<section class="col-md-9 wiki-body-section">
				<?php endif; ?>
				<?php if ( $this->data['sitenotice'] ): ?>
					<div id="siteNotice" class="alert-message warning">
						<?php $this->html('sitenotice') ?>
					</div>
				<?php endif; ?>
				<?php if ( $this->data['undelete'] ): ?>
					<!-- undelete -->
					<div id="contentSub2"><?php $this->html( 'undelete' ) ?></div>
					<!-- /undelete -->
				<?php endif; ?>
				<?php if($this->data['newtalk'] ): ?>
					<!-- newtalk -->
					<div class="usermessage"><?php $this->html( 'newtalk' )  ?></div>
					<!-- /newtalk -->
				<?php endif; ?>

				<div class="pagetitle page-header">
					<h1><?php $this->html( 'title' ) ?> <small><?php $this->html('subtitle') ?></small></h1>
				</div>

				<div class="body">
					<?php $this->html( 'bodytext' ) ?>
				</div>

				<?php if ( $this->data['catlinks'] ): ?>
					<div class="category-links">
						<!-- catlinks -->
						<?php $this->html( 'catlinks' ); ?>
						<!-- /catlinks -->
					</div>
				<?php endif; ?>
				<?php if ( $this->data['dataAfterContent'] ): ?>
					<div class="data-after-content">
						<!-- dataAfterContent -->
						<?php $this->html( 'dataAfterContent' ); ?>
						<!-- /dataAfterContent -->
					</div>
				<?php endif; ?>
				<?php if ( 'sidebar' == $wgTOCLocation ): ?>
						</section>
					</section>
				<?php endif; ?>
			</div><!-- container -->
		</div>
		<div class="bottom">
			<div class="container">
				<?php $this->includePage('Bootstrap:Footer'); ?>
				<footer>
					<p>&copy; <?php echo date('Y'); ?> by <a href="<?php echo (isset($wgCopyrightLink) ? $wgCopyrightLink : 'http://borkweb.com'); ?>"><?php echo (isset($wgCopyright) ? $wgCopyright : 'BorkWeb'); ?></a>
						&bull; Powered by <a href="http://mediawiki.org">MediaWiki</a>
					</p>
				</footer>
			</div><!-- container -->
		</div><!-- bottom -->

		<?php
		$this->html( 'bottomscripts' ); /* JS call to runBodyOnloadHook */
		$this->html( 'reporttime' );

		if ( $this->data['debug'] ) {
			?>
			<!-- Debug output:
			<?php $this->text( 'debug' ); ?>
			-->
			<?php
		}//end if
		?>
		</body>
		</html>
		<?php
	}

	/**
	 * Render one or more navigations elements by name, automatically reveresed
	 * when UI is in RTL mode
	 */
	private function nav( $nav ) {
		global $wgArticlePath;

		$path_replace = str_replace( '$1', '/', $wgArticlePath );

		$output = '';
		foreach ( $nav as $topItem ) {
			$pageTitle = Title::newFromText( $topItem['link'] ?? $topItem['title'] );
			if ( array_key_exists( 'sublinks', $topItem ) ) {
				$output .= '<li class="nav-item dropdown">';
				$output .= '<a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">' . $topItem['title'] . '</a>';
				$output .= '<div class="dropdown-menu" aria-labelledby="navbarDropdown">';

				foreach ( $topItem['sublinks'] as $subLink ) {
					if ( 'divider' == $subLink ) {
						$output .= "<div class='dropdown-divider'></div>\n";
					} elseif ( ! empty( $subLink['textonly'] ) ) {
						$output .= "<div class='nav-header'>{$subLink['title']}</div>\n";
					} elseif ( ! empty( $subLink['link'] ) ) {
						if ( $pageTitle = Title::newFromText( $subLink['link'] ) ) {
							$href = str_replace( $path_replace, '/', $pageTitle->getLocalURL() );
						} else {
							$href = $subLink['link'];
						}

						$href = urldecode( $href );
						$slug = strtolower( str_replace(' ', '-', preg_replace( '/[^a-zA-Z0-9 ]/', '', trim( strip_tags( $subLink['title'] ) ) ) ) );

						$output .= sprintf(
							'<a href="%1$s" class="dropdown-item %2$s %3$s" %4$s>%5$s</a>' . "\n",
							$href,
							$subLink['class'] ?? null,
							$slug,
							$subLink['attributes'] ?? null,
							$subLink['title'] ?? null
						);
					}
				}
				$output .= '</div>';
			} elseif ( $pageTitle ) {
				$active_class = $this->data['title'] == $topItem['title'] ? 'active' : '';

				$output .= sprintf(
					'<li class="nav-item %1$s"><a class="nav-link" href="%2$s">%3$s</a></li>',
					$active_class,
					! empty( $topItem['external'] ) ? $topItem['link'] : $pageTitle->getLocalURL(),
					$topItem['title'] ?? null
				);
			}
		}

		return $output;
	}

	/**
	 * Render one or more navigations elements by name, automatically reveresed
	 * when UI is in RTL mode
	 */
	private function navSelect( $nav ) {
		$output = '';
		foreach ( $nav as $topItem ) {
			$pageTitle = Title::newFromText( $topItem['link'] ?: $topItem['title'] );
			$output .= '<optgroup label="'.strip_tags( $topItem['title'] ).'">';
			if ( array_key_exists( 'sublinks', $topItem ) ) {
				foreach ( $topItem['sublinks'] as $subLink ) {
					if ( 'divider' == $subLink ) {
						$output .= "<option value='' disabled='disabled' class='unclickable'>----</option>\n";
					} elseif ( ! empty( $subLink['textonly'] ) ) {
						$output .= "<option value='' disabled='disabled' class='unclickable'>{$subLink['title']}</option>\n";
					} else {
						if( ! empty( $subLink['local'] ) && $pageTitle = Title::newFromText( $subLink['link'] ) ) {
							$href = $pageTitle->getLocalURL();
						} else {
							$href = $subLink['link'];
						}//end else

						$output .= "<option value='{$href}'>{$subLink['title']}</option>";
					}//end else
				}//end foreach
			} elseif ( $pageTitle ) {
				$output .= '<option value="' . $pageTitle->getLocalURL() . '">' . $topItem['title'] . '</option>';
			}//end else
			$output .= '</optgroup>';
		}//end foreach

		return $output;
	}

	/**
	 * Generates the logo and (optionally) site title
	 * @param string $id
	 * @param bool $imageOnly Whether or not to generate the logo with only the image,
	 * or with a text link as well
	 *
	 * @return string html
	 */
	protected function getLogo( $id = 'p-logo', $imageOnly = false ) {
		$html = Html::openElement(
			'div',
			[
				'id' => $id,
				'class' => 'mw-portlet',
				'role' => 'banner'
			]
		);
		$html .= Html::element(
			'a',
			[
				'href' => $this->data['nav_urls']['mainpage']['href'],
				'class' => 'mw-wiki-logo',
			] + Linker::tooltipAndAccesskeyAttribs( 'p-logo' )
		);
		if ( !$imageOnly ) {
			$language = $this->getSkin()->getLanguage();
			$siteTitle = $language->convert( $this->getMsg( 'sitetitle' )->escaped() );

			$html .= Html::rawElement(
				'a',
				[
					'id' => 'p-banner',
					'class' => 'mw-wiki-title',
					'href' => $this->data['nav_urls']['mainpage']['href']
				] + Linker::tooltipAndAccesskeyAttribs( 'p-logo' ),
				$siteTitle
			);
		}
		$html .= Html::closeElement( 'div' );

		return $html;
	}

	/**
	 * Generates the search form
	 * @return string html
	 */
	protected function getSearch() {
		$html = Html::openElement(
			'form',
			[
				'action' => $this->get( 'wgScript' ),
				'role' => 'search',
				'class' => 'mw-portlet',
				'id' => 'p-search'
			]
		);
		$html .= Html::hidden( 'title', $this->get( 'searchtitle' ) );
		$html .= Html::rawElement(
			'h3',
			[],
			Html::label( $this->getMsg( 'search' )->text(), 'searchInput' )
		);
		$html .= $this->makeSearchInput( [ 'id' => 'searchInput' ] );
		$html .= $this->makeSearchButton( 'go', [ 'id' => 'searchGoButton', 'class' => 'searchButton' ] );
		$html .= Html::closeElement( 'form' );

		return $html;
	}

	/**
	 * Generates the sidebar
	 * Set the elements to true to allow them to be part of the sidebar
	 * Or get rid of this entirely, and take the specific bits to use wherever you actually want them
	 *  * Toolbox is the page/site tools that appears under the sidebar in vector
	 *  * Languages is the interlanguage links on the page via en:... es:... etc
	 *  * Default is each user-specified box as defined on MediaWiki:Sidebar; you will still need a foreach loop
	 *    to parse these.
	 * @return string html
	 */
	protected function getSiteNavigation() {
		$html = '';

		$sidebar = $this->getSidebar();
		$sidebar['SEARCH'] = false;
		$sidebar['TOOLBOX'] = true;
		$sidebar['LANGUAGES'] = true;

		foreach ( $sidebar as $name => $content ) {
			if ( $content === false ) {
				continue;
			}
			// Numeric strings gets an integer when set as key, cast back - T73639
			$name = (string)$name;

			switch ( $name ) {
				case 'SEARCH':
					$html .= $this->getSearch();
					break;
				case 'TOOLBOX':
					$html .= $this->getPortlet( 'tb', $this->getToolbox(), 'toolbox' );
					break;
				case 'LANGUAGES':
					$html .= $this->getLanguageLinks();
					break;
				default:
					$html .= $this->getPortlet( $name, $content['content'] );
					break;
			}
		}
		return $html;
	}

	/**
	 * In other languages list
	 *
	 * @return string html
	 */
	protected function getLanguageLinks() {
		$html = '';
		if ( $this->data['language_urls'] !== false ) {
			$html .= $this->getPortlet( 'lang', $this->data['language_urls'], 'otherlanguages' );
		}

		return $html;
	}

	/**
	 * Language variants. Displays list for converting between different scripts in the same language,
	 * if using a language where this is applicable (such as latin vs cyric display for serbian).
	 *
	 * @return string html
	 */
	protected function getVariants() {
		$html = '';
		if ( count( $this->data['content_navigation']['variants'] ) > 0 ) {
			$html .= $this->getPortlet(
				'variants',
				$this->data['content_navigation']['variants']
			);
		}

		return $html;
	}

	/**
	 * Generates page-related tools/links
	 * You will probably want to split this up and move all of these to somewhere that makes sense for your skin.
	 * @return string html
	 */
	protected function getPageLinks( $source ) {
		$title    = null;
		$titleBar = $this->getPageRawText( $source );
		$nav      = [];
		foreach ( explode( "\n", $titleBar ) as $line ) {
			if ( trim( $line ) == '' ) {
				continue;
			}

			if ( preg_match('/^\*\*\s*divider/', $line ) ) {
				$nav[ count( $nav ) - 1 ]['sublinks'][] = 'divider';
				continue;
			}

			$sub = false;
			$link = false;
			$external = false;

			$non_sub_prefix = '\*\s*';
			$sub_prefix     = '\*\*\s*';

			$page_link = '\[\[:?(.+)\]\]';

			if ( preg_match( "/^{$non_sub_prefix}([^\*]*){$page_link}/", $line, $match ) ) {
				$sub = false;
				$link = true;
			} elseif ( preg_match( "/^{$non_sub_prefix}([^\*\[]*)\[([^\[ ]+) (.+)\]/", $line, $match ) ) {
				$sub = false;
				$link = true;
				$external = true;
			} elseif ( preg_match( "/^{$sub_prefix}([^\*\[]*)\[([^\[ ]+) (.+)\]/", $line, $match ) ) {
				$sub = true;
				$link = true;
				$external = true;
			} elseif ( preg_match( "/{$sub_prefix}([^\*]*){$page_link}/", $line, $match ) ) {
				$sub = true;
				$link = true;
			} elseif ( preg_match( "/{$sub_prefix}([^\* ]*)(.+)/", $line, $match ) ) {
				$sub = true;
				$link = false;
			} elseif ( preg_match( "/^{$non_sub_prefix}(.+)/", $line, $match ) ) {
				$sub = false;
				$link = false;
			}

			if( isset( $match[2] ) && strpos( $match[2], '|' ) !== false ) {
				$item = explode( '|', $match[2] );
				$item = array(
					'title' => $match[1] . $item[1],
					'link' => $item[0],
					'local' => true,
				);
			} else {
				if( $external ) {
					$item = $match[2];
					$title = $match[1] . $match[3];
				} elseif ( isset( $match[1] ) ) {
					$item = $match[1];

					if ( ! empty( $match[2] ) ) {
						$item .= $match[2];
					}

					$title = $item;
				} else {
					continue;
				}

				if( $link ) {
					$item = array('title'=> $title, 'link' => $item, 'local' => ! $external , 'external' => $external );
				} else {
					$item = array('title'=> $title, 'link' => $item, 'textonly' => true, 'external' => $external );
				}//end else
			}//end else

			if( $sub ) {
				$nav[count( $nav ) - 1]['sublinks'][] = $item;
			} else {
				$nav[] = $item;
			}//end else
		}

		return $nav;
	}

	public function getPageRawText($title) {
		$pageTitle = Title::newFromText($title);
		if(!$pageTitle->exists()) {
			return 'Create the page [[Bootstrap:TitleBar]]';
		} else {
			$page = WikiPage::factory( $pageTitle );
			$revision = $page->getRevision();
			$content  = $revision->getContent( Revision::RAW );
			return ContentHandler::getContentText( $content );
		}
	}

	/**
	 * Generates user tools menu
	 * @return string html
	 */
	protected function getUserLinks() {
		// Basic list output
		return $this->getPortlet(
			'personal',
			$this->getPersonalTools(),
			'personaltools'
		);
	}

	/**
	 * Generates siteNotice, if any
	 * @return string html
	 */
	protected function getSiteNotice() {
		return $this->getIfExists( 'sitenotice', [
			'wrapper' => 'div',
			'parameters' => [ 'id' => 'siteNotice' ]
		] );
	}

	/**
	 * Generates new talk message banner, if any
	 * @return string html
	 */
	protected function getNewTalk() {
		return $this->getIfExists( 'newtalk', [
			'wrapper' => 'div',
			'parameters' => [ 'class' => 'usermessage' ]
		] );
	}

	/**
	 * Generates subtitle stuff, if any
	 * @return string html
	 */
	protected function getPageSubtitle() {
		return $this->getIfExists( 'subtitle', [ 'wrapper' => 'p' ] );
	}

	/**
	 * Generates category links, if any
	 * @return string html
	 */
	protected function getCategoryLinks() {
		return $this->getIfExists( 'catlinks' );
	}

	/**
	 * Generates data after content stuff, if any
	 * @return string html
	 */
	protected function getDataAfterContent() {
		return $this->getIfExists( 'dataAfterContent' );
	}

	/**
	 * Simple wrapper for random if-statement-wrapped $this->data things
	 *
	 * @param string $object name of thing
	 * @param array $setOptions
	 *
	 * @return string html
	 */
	protected function getIfExists( $object, $setOptions = [] ) {
		$options = $setOptions + [
			'wrapper' => 'none',
			'parameters' => []
		];

		$html = '';

		if ( $this->data[$object] ) {
			if ( $options['wrapper'] == 'none' ) {
				$html .= $this->get( $object );
			} else {
				$html .= Html::rawElement(
					$options['wrapper'],
					$options['parameters'],
					$this->get( $object )
				);
			}
		}

		return $html;
	}

	/**
	 * Generates a block of navigation links with a header
	 *
	 * @param string $name
	 * @param array|string $content array of links for use with makeListItem, or a block of text
	 * @param null|string|array $msg
	 * @param array $setOptions random crap to rename/do/whatever
	 *
	 * @return string html
	 */
	protected function getPortlet( $name, $content, $msg = null, $setOptions = [] ) {
		// random stuff to override with any provided options
		$options = $setOptions + [
			// extra classes/ids
			'id' => 'p-' . $name,
			'class' => 'mw-portlet',
			'extra-classes' => '',
			// what to wrap the body list in, if anything
			'body-wrapper' => 'div',
			'body-id' => null,
			'body-class' => 'mw-portlet-body',
			// makeListItem options
			'list-item' => [ 'text-wrapper' => [ 'tag' => 'span' ] ],
			// option to stick arbitrary stuff at the beginning of the ul
			'list-prepend' => '',
			// old toolbox hook support (use: [ 'SkinTemplateToolboxEnd' => [ &$skin, true ] ])
			'hooks' => ''
		];

		// Handle the different $msg possibilities
		if ( $msg === null ) {
			$msg = $name;
		} elseif ( is_array( $msg ) ) {
			$msgString = array_shift( $msg );
			$msgParams = $msg;
			$msg = $msgString;
		}
		$msgObj = $this->getMsg( $msg );
		if ( $msgObj->exists() ) {
			if ( isset( $msgParams ) && !empty( $msgParams ) ) {
				$msgString = $this->getMsg( $msg, $msgParams )->parse();
			} else {
				$msgString = $msgObj->parse();
			}
		} else {
			$msgString = htmlspecialchars( $msg );
		}

		$labelId = Sanitizer::escapeIdForAttribute( "p-$name-label" );

		if ( is_array( $content ) ) {
			$contentText = Html::openElement( 'ul',
				[ 'lang' => $this->get( 'userlang' ), 'dir' => $this->get( 'dir' ) ]
			);
			$contentText .= $options['list-prepend'];
			foreach ( $content as $key => $item ) {
				$contentText .= $this->makeListItem( $key, $item, $options['list-item'] );
			}
			// Compatibility with extensions still using SkinTemplateToolboxEnd or similar
			if ( is_array( $options['hooks'] ) ) {
				foreach ( $options['hooks'] as $hook ) {
					if ( is_string( $hook ) ) {
						$hookOptions = [];
					} else {
						// it should only be an array otherwise
						$hookOptions = array_values( $hook )[0];
						$hook = array_keys( $hook )[0];
					}
					$contentText .= $this->deprecatedHookHack( $hook, $hookOptions );
				}
			}

			$contentText .= Html::closeElement( 'ul' );
		} else {
			$contentText = $content;
		}

		// Special handling for role=search and other weird things
		$divOptions = [
			'role' => 'navigation',
			'id' => Sanitizer::escapeIdForAttribute( $options['id'] ),
			'title' => Linker::titleAttrib( $options['id'] ),
			'aria-labelledby' => $labelId
		];
		if ( !is_array( $options['class'] ) ) {
			$class = [ $options['class'] ];
		}
		if ( !is_array( $options['extra-classes'] ) ) {
			$extraClasses = [ $options['extra-classes'] ];
		}
		$divOptions['class'] = array_merge( $class, $extraClasses );

		$labelOptions = [
			'id' => $labelId,
			'lang' => $this->get( 'userlang' ),
			'dir' => $this->get( 'dir' )
		];

		if ( $options['body-wrapper'] !== 'none' ) {
			$bodyDivOptions = [ 'class' => $options['body-class'] ];
			if ( is_string( $options['body-id'] ) ) {
				$bodyDivOptions['id'] = $options['body-id'];
			}
			$body = Html::rawElement( $options['body-wrapper'], $bodyDivOptions,
				$contentText .
				$this->getAfterPortlet( $name )
			);
		} else {
			$body = $contentText . $this->getAfterPortlet( $name );
		}

		$html = Html::rawElement( 'div', $divOptions,
			Html::rawElement( 'h3', $labelOptions, $msgString ) .
			$body
		);

		return $html;
	}

	/**
	 * Wrapper to catch output of old hooks expecting to write directly to page
	 * We no longer do things that way.
	 *
	 * @param string $hook event
	 * @param array $hookOptions args
	 *
	 * @return string html
	 */
	protected function deprecatedHookHack( $hook, $hookOptions = [] ) {
		$hookContents = '';
		ob_start();
		Hooks::run( $hook, $hookOptions );
		$hookContents = ob_get_contents();
		ob_end_clean();
		if ( !trim( $hookContents ) ) {
			$hookContents = '';
		}

		return $hookContents;
	}

	/**
	 * Better renderer for getFooterIcons and getFooterLinks, based on Vector
	 *
	 * @param array $setOptions Miscellaneous other options
	 * * 'id' for footer id
	 * * 'order' to determine whether icons or links appear first: 'iconsfirst' or links, though in
	 *   practice we currently only check if it is or isn't 'iconsfirst'
	 * * 'link-prefix' to set the prefix for all link and block ids; most skins use 'f' or 'footer',
	 *   as in id='f-whatever' vs id='footer-whatever'
	 * * 'icon-style' to pass to getFooterIcons: "icononly", "nocopyright"
	 * * 'link-style' to pass to getFooterLinks: "flat" to disable categorisation of links in a
	 *   nested array
	 *
	 * @return string html
	 */
	protected function getFooterBlock( $setOptions = [] ) {
		// Set options and fill in defaults
		$options = $setOptions + [
			'id' => 'footer',
			'order' => 'iconsfirst',
			'link-prefix' => 'footer',
			'icon-style' => 'icononly',
			'link-style' => null
		];

		$validFooterIcons = $this->getFooterIcons( $options['icon-style'] );
		$validFooterLinks = $this->getFooterLinks( $options['link-style'] );

		$html = '';

		$html .= Html::openElement( 'div', [
			'id' => $options['id'],
			'role' => 'contentinfo',
			'lang' => $this->get( 'userlang' ),
			'dir' => $this->get( 'dir' )
		] );

		$iconsHTML = '';
		if ( count( $validFooterIcons ) > 0 ) {
			$iconsHTML .= Html::openElement( 'ul', [ 'id' => "{$options['link-prefix']}-icons" ] );
			foreach ( $validFooterIcons as $blockName => $footerIcons ) {
				$iconsHTML .= Html::openElement( 'li', [
					'id' => Sanitizer::escapeIdForAttribute(
						"{$options['link-prefix']}-{$blockName}ico"
					),
					'class' => 'footer-icons'
				] );
				foreach ( $footerIcons as $icon ) {
					$iconsHTML .= $this->getSkin()->makeFooterIcon( $icon );
				}
				$iconsHTML .= Html::closeElement( 'li' );
			}
			$iconsHTML .= Html::closeElement( 'ul' );
		}

		$linksHTML = '';
		if ( count( $validFooterLinks ) > 0 ) {
			if ( $options['link-style'] == 'flat' ) {
				$linksHTML .= Html::openElement( 'ul', [
					'id' => "{$options['link-prefix']}-list",
					'class' => 'footer-places'
				] );
				foreach ( $validFooterLinks as $link ) {
					$linksHTML .= Html::rawElement(
						'li',
						[ 'id' => Sanitizer::escapeIdForAttribute( $link ) ],
						$this->get( $link )
					);
				}
				$linksHTML .= Html::closeElement( 'ul' );
			} else {
				$linksHTML .= Html::openElement( 'div', [ 'id' => "{$options['link-prefix']}-list" ] );
				foreach ( $validFooterLinks as $category => $links ) {
					$linksHTML .= Html::openElement( 'ul',
						[ 'id' => Sanitizer::escapeIdForAttribute(
							"{$options['link-prefix']}-{$category}"
						) ]
					);
					foreach ( $links as $link ) {
						$linksHTML .= Html::rawElement(
							'li',
							[ 'id' => Sanitizer::escapeIdForAttribute(
								"{$options['link-prefix']}-{$category}-{$link}"
							) ],
							$this->get( $link )
						);
					}
					$linksHTML .= Html::closeElement( 'ul' );
				}
				$linksHTML .= Html::closeElement( 'div' );
			}
		}

		if ( $options['order'] == 'iconsfirst' ) {
			$html .= $iconsHTML . $linksHTML;
		} else {
			$html .= $linksHTML . $iconsHTML;
		}

		$html .= $this->getClear() . Html::closeElement( 'div' );

		return $html;
	}


	private function getArrayLinks( $array, $title, $which ) {
		$nav = [];
		$nav[] = [ 'title' => $title ];
		foreach ( $array as $key => $item ) {
			$link = [
				'id'         => Sanitizer::escapeIdForAttribute( $key ),
				'attributes' => $item['attributes'] ?? null,
				'link'       => $item['href'] ?? null,
				'key'        => $item['key'] ?? null,
				'class'      => htmlspecialchars( $item['class'] ?? null ),
				'title'      => htmlspecialchars( $item['text'] ?? null ),
			];

			$icon = null;

			if( 'page' == $which ) {
				switch( $link['title'] ) {
					case 'Page': $icon = 'file'; break;
					case 'Discussion': $icon = 'comment'; break;
					case 'Edit': $icon = 'edit'; break;
					case 'History': $icon = 'history'; break;
					case 'Delete': $icon = 'trash-alt'; break;
					case 'Move': $icon = 'arrows-alt'; break;
					case 'Protect': $icon = 'lock'; break;
					case 'Watch': $icon = 'eye'; break;
					case 'Unwatch': $icon = 'eye-slash'; break;
				}

				$link['title'] = '<i class="fa fa-' . $icon . '"></i> ' . $link['title'];
			} elseif( 'user' == $which ) {
				switch( $link['title'] ) {
					case 'My talk': $icon = 'comment'; break;
					case 'My preferences': $icon = 'cog'; break;
					case 'My watchlist': $icon = 'eye-close'; break;
					case 'My contributions': $icon = 'list-alt'; break;
					case 'Log out': $icon = 'unlock'; break;
					default: $icon = 'user'; break;
				}

				$link['title'] = '<i class="fa fa-' . $icon . '"></i> ' . $link['title'];
			}

			$nav[0]['sublinks'][] = $link;
		}

		return $this->nav( $nav );
	}

	public function includePage( $title ) {
		$pageTitle = Title::newFromText( $title );
		if ( ! $pageTitle->exists() ) {
			echo 'The page [[' . $title . ']] was not found.';
		} else {
			$article = new Article( $pageTitle );
			echo $article->getParserOutput()->getText();
		}
	}
}
