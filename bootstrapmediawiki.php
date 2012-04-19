<?php
/**
 * Bootstrap - A basic MediaWiki skin based on Twitter's excellent Bootstrap CSS framework
 * Loosely based off of the skin by Aaron Parecki <aaron@parecki.com>
 *
 * @Version 1.0.0
 * @Author Matthew Batchelder <borkweb@gmail.com>
 * @Copyright Matthew Batchelder 2012 - http://borkweb.com/
 * @License: GPLv2 (http://www.gnu.org/copyleft/gpl.html)
 */

if( !defined( 'MEDIAWIKI' ) ) {
	die( -1 );
}

require_once('includes/SkinTemplate.php');

/**
 * Inherit main code from SkinTemplate, set the CSS and template filter.
 * @todo document
 * @package MediaWiki
 * @subpackage Skins
 */
class SkinBootstrapMediawiki extends SkinTemplate {
    /** Using Bootstrap */
	public $skinname = 'bootstrap-mediawiki';
	public $stylename = 'bootstrap-mediawiki';
	public $template = 'BootstrapMW_Template';
	public $useHeadElement = true;

	function setupSkinUserCss( OutputPage $out ) {
		global $wgHandheldStyle, $wgSiteCSS;

		parent::setupSkinUserCss( $out );

		$out->addStyle( 'bootstrap-mediawiki/bootstrap/css/bootstrap.min.css' );
		$out->addStyle( 'bootstrap-mediawiki/bootstrap/css/bootstrap-responsive.min.css' );
		$out->addStyle( 'bootstrap-mediawiki/google-code-prettify/prettify.css' );
		$out->addStyle( 'bootstrap-mediawiki/style.css' );
		if( $wgSiteCSS ) {
			$out->addStyle( $wgSiteCSS );
		}//end if
	}
}

/**
 * @todo document
 * @package MediaWiki
 * @subpackage Skins
 */
class BootstrapMW_Template extends QuickTemplate {
	/**
	 * @var Cached skin object
	 */
	var $skin;

  /**
   * Template filter callback for Bootstrap skin.
   * Takes an associative array of data set from a SkinTemplate-based
   * class, and a wrapper for MediaWiki's localization database, and
   * outputs a formatted page.
   *
   * @access private
   */
  function execute() {
		global $wgRequest, $wgPsuBasePath, $wgUser, $wgSitename, $wgSitenameshort, $wgCopyrightLink, $wgCopyright, $wgBootstrap, $wgArticlePath, $wgGoogleAnalyticsID, $wgSiteCSS;

		$this->skin = $this->data['skin'];
		$action = $wgRequest->getText( 'action' );

    // Suppress warnings to prevent notices about missing indexes in $this->data
    wfSuppressWarnings();

		$this->html('headelement');
?>
<div class="navbar navbar-fixed-top">
	<div class="navbar-inner">
		<div class="container">
			<!-- .btn-navbar is used as the toggle for collapsed navbar content -->
			<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</a>
		<a class="brand" href="<?php echo $this->data['nav_urls']['mainpage']['href'] ?>" title="<?php echo $wgSitename ?>"><img src="<?php $this->text('stylepath') ?>/<?php $this->text('stylename') ?>/images/logo.png"/><?php echo $wgSitenameshort ?: $wgSitename; ?></a>

		<div class="nav-collapse">
			<ul class="nav">
				<li>
				<a href="<?php echo $wgPsuBasePath; ?>">Home</a>
				</li>
				<?php
					echo $this->nav( $this->get_page_links( 'Bootstrap:TitleBar' ) );
				?>
			</ul>
			
	<?php

	if($wgUser->isLoggedIn()) {
		if ( count( $this->data['personal_urls'] ) > 0 ) {
			$user_icon = '<span class="user-icon"><img src="https://secure.gravatar.com/avatar/'.md5(strtolower( $wgUser->getName()) . '@plymouth.edu').'.jpg?s=20&r=g"/></span>';
			$name = strtolower( $wgUser->getName() );
			$user_nav = $this->get_array_links( $this->data['personal_urls'], $user_icon . $name, 'user' );
		?>
		<ul<?php $this->html('userlangattributes') ?> class="nav pull-right">
			<?php echo $user_nav; ?>
		</ul>
		<?php
		}
		?>

		<?php
		if ( count( $this->data['content_actions']) > 0 ) {
			$content_nav = $this->get_array_links( $this->data['content_actions'], 'Page', 'page' );
		?>
			<ul class="nav pull-right content-actions"><?php echo $content_nav; ?></ul>
		<?php
		}
	} else {  // else if is logged in
		?>
			<ul class="pull-right">
				<li>
					<?php echo Linker::linkKnown(
						SpecialPage::getTitleFor( 'Userlogin' ),
						wfMsg( 'login' )
					) ?>
				</li>
			</ul>
		<?php
	}
	?>
			</div>
			<form class="navbar-search pull-right" action="<?php $this->text( 'wgScript' ) ?>" id="search-form">
				<input type="text" placeholder="Search" name="search" onchange="$('#search-form').submit()" />
			</form>
			
		</div>
	</div>
</div><!-- topbar -->
<?php
if( $subnav_links = $this->get_page_links('Bootstrap:Subnav') ) {
?>
<div class="subnav subnav-fixed">
	<select id="subnav-select">
	<?php echo $this->nav_select( $subnav_links ); ?>
	</select>
	<ul class="nav nav-pills">
	<?php echo $this->nav( $subnav_links ); ?>
	</ul>
</div>
<?php
}//end if
?>
<div id="wiki-outer-body">
    <div id="wiki-body" class="container">
      <?php if( $this->data['sitenotice'] ) { ?><div id="siteNotice" class="alert-message warning"><?php $this->html('sitenotice') ?></div><?php } ?>
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
    </div><!-- container -->
</div>
    <div class="bottom">
      <div class="container">
        <?php
        $this->includePage('Bootstrap:Footer');
        ?>
      
        <footer>
          <p>&copy; <?php echo date('Y'); ?> by <a href="<?php echo (isset($wgCopyrightLink) ? $wgCopyrightLink : 'http://www.plymouth.edu'); ?>"><?php echo (isset($wgCopyright) ? $wgCopyright : 'Plymouth State University'); ?></a> 
          	&bull; Powered by <a href="http://mediawiki.org">MediaWiki</a> 
          </p>
        </footer>
      </div><!-- container -->
    </div><!-- bottom -->

		<?php $js_file = dirname( $_SERVER['SCRIPT_FILENAME'] ) . '/skins/' . $this->skin->skinname . '/js/site.min.js'; ?>
  	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
  	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js"></script>
		<script type="text/javascript" src="<?php $this->text('stylepath') ?>/<?php $this->text('stylename') ?>/js/site.min.js?v=<?php echo filemtime( $js_file ); ?>"></script>
  	<script type="text/javascript" src="<?php $this->text('stylepath') ?>/<?php $this->text('stylename') ?>/google-code-prettify/prettify.js"></script>
</body>
</html>
<?php
	}
	

	/**
	 * Render one or more navigations elements by name, automatically reveresed
	 * when UI is in RTL mode
	 */
	private function nav( $nav ) {
		$output = '';
		foreach($nav as $topItem) {
			$pageTitle = Title::newFromText($topItem['link'] ?: $topItem['title'] );
			if(array_key_exists('sublinks', $topItem)) {
				$output .= '<li class="dropdown">';
				$output .= '<a href="#" class="dropdown-toggle" data-toggle="dropdown">' . $topItem['title'] . ' <b class="caret"></b></a>';
				$output .= '<ul class="dropdown-menu">';
				foreach($topItem['sublinks'] as $subLink) {
					if( 'divider' == $subLink ) {
						$output .= "<li class='divider'></li>\n";
					} elseif( $subLink['textonly'] ) {
						$output .= "<li class='nav-header'>{$subLink['title']}</li>\n";
					} else {
						if( $subLink['local'] && $pageTitle = Title::newFromText($subLink['link']) ) {
							$href = $pageTitle->getLocalURL();
						} else {
							$href = $subLink['link'];
						}//end else
						$slug = strtolower( str_replace(' ', '-', preg_replace('/[^a-zA-Z0-9 ]/', '', trim( strip_tags( $subLink['title'] ) ) ) ) );
						$output .= "<li {$subLink['attributes']}><a href='{$href}' class='{$subLink['class']} {$slug}'>{$subLink['title']}</a>";
					}//end else
				}
				$output .= '</ul>';
				$output .= '</li>';
			} else {
				if( $pageTitle ) {
					$output .= '<li' . ($this->data['title'] == $topItem['title'] ? ' class="active"' : '') . '><a href="' . ( $topItem['external'] ? $topItem['link'] : $pageTitle->getLocalURL() ) . '">' . $topItem['title'] . '</a></li>';
				}//end if
			}
		}

		return $output;
	}

	/**
	 * Render one or more navigations elements by name, automatically reveresed
	 * when UI is in RTL mode
	 */
	private function nav_select( $nav ) {
		$output = '';
		foreach($nav as $topItem) {
			$pageTitle = Title::newFromText($topItem['link'] ?: $topItem['title'] );
			$output .= '<optgroup label="'.strip_tags($topItem['title']).'">';
			if(array_key_exists('sublinks', $topItem)) {
				foreach($topItem['sublinks'] as $subLink) {
					if( 'divider' == $subLink ) {
						$output .= "<option value='' disabled='disabled' class='unclickable'>----</option>\n";
					} elseif( $subLink['textonly'] ) {
						$output .= "<option value='' disabled='disabled' class='unclickable'>{$subLink['title']}</option>\n";
					} else {
						if( $subLink['local'] && $pageTitle = Title::newFromText($subLink['link']) ) {
							$href = $pageTitle->getLocalURL();
						} else {
							$href = $subLink['link'];
						}//end else
						$output .= "<option value='{$href}'>{$subLink['title']}</option>";
					}//end else
				}
			} else {
				if( $pageTitle ) {
					$output .= '<option value="' . $pageTitle->getLocalURL() . '">' . $topItem['title'] . '</option>';
				}//end if
			}
			$output .= '</optgroup>';
		}

		return $output;
	}

	private function get_page_links( $source ) {
		$titleBar = $this->getPageRawText( $source );
		$nav = array();
		foreach(explode("\n", $titleBar) as $line) {
			if(trim($line) == '') continue;
			if( preg_match('/^\*\*\s*divider/', $line ) ) {
				$nav[ count( $nav ) - 1]['sublinks'][] = 'divider';
				continue;
			}//end if

			$sub = false;
			$link = false;
			$external = false;
			
			if(preg_match('/^\*\s*([^\*]*)\[\[:?(.+)\]\]/', $line, $match)) {
				$sub = false;
				$link = true;
			}elseif(preg_match('/^\*\s*([^\*]*)\[([^ ]+) (.+)\]/', $line, $match)) {
				$sub = false;
				$link = true;
				$external = true;
			}elseif(preg_match('/^\*\*\s*([^\*]*)\[([^ ]+) (.+)\]/', $line, $match)) {
				$sub = true;
				$link = true;
				$external = true;
			}elseif(preg_match('/\*\*\s*([^\*]*)\[\[:?(.+)\]\]/', $line, $match)) {
				$sub = true;
				$link = true;
			}elseif(preg_match('/\*\*\s*([^\* ]*)(.+)/', $line, $match)) {
				$sub = true;
				$link = false;
			}elseif(preg_match('/^\*\s*(.+)/', $line, $match)) {
				$sub = false;
				$link = false;
			}

			if( strpos( $match[2], '|' ) !== false ) {
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
				} else {
					$item = $match[1] . $match[2];
					$title = $item;
				}//end else

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
	}//end get_page_links

	private function get_array_links( $array, $title, $which ) {
		$nav = array();
		$nav[] = array('title' => $title );
		foreach( $array as $key => $item ) {
			$link = array(
				'id' => Sanitizer::escapeId( $key ),
				'attributes' => $item['attributes'],
				'link' => htmlspecialchars( $item['href'] ),
				'key' => $item['key'],
				'class' => htmlspecialchars( $item['class'] ),
				'title' => htmlspecialchars( $item['text'] ),
			);

			if( 'page' == $which ) {
				switch( $link['title'] ) {
					case 'Page': $icon = 'file'; break;
					case 'Discussion': $icon = 'comment'; break;
					case 'Edit': $icon = 'pencil'; break;
					case 'History': $icon = 'time'; break;
					case 'Delete': $icon = 'remove'; break;
					case 'Move': $icon = 'move'; break;
					case 'Protect': $icon = 'lock'; break;
					case 'Watch': $icon = 'eye-open'; break;
				}//end switch

				$link['title'] = '<i class="icon-' . $icon . '"></i> ' . $link['title'];
			} elseif( 'user' == $which ) {
				switch( $link['title'] ) {
					case 'My talk': $icon = 'comment'; break;
					case 'My preferences': $icon = 'cog'; break;
					case 'My watchlist': $icon = 'eye-close'; break;
					case 'My contributions': $icon = 'list-alt'; break;
					case 'Log out': $icon = 'off'; break;
					default: $icon = 'user'; break;
				}//end switch

				$link['title'] = '<i class="icon-' . $icon . '"></i> ' . $link['title'];
			}//end elseif

			$nav[0]['sublinks'][] = $link;
		}//end foreach

		return $this->nav( $nav );
	}//end get_array_links
	
	function getPageRawText($title) {
    $pageTitle = Title::newFromText($title);
    if(!$pageTitle->exists()) {
      return 'Create the page [[Bootstrap:TitleBar]]';
    } else {
      $article = new Article($pageTitle);
      return $article->getRawText();
    }
	}
	
	function includePage($title) {
    global $wgParser, $wgUser;
    $pageTitle = Title::newFromText($title);
    if(!$pageTitle->exists()) {
      echo 'The page [[' . $title . ']] was not found.';
    } else {
      $article = new Article($pageTitle);
      $wgParserOptions = new ParserOptions($wgUser);
      $parserOutput = $wgParser->parse($article->getRawText(), $pageTitle, $wgParserOptions);
      echo $parserOutput->getText();
    }
	}

	public static function link() { }
}

