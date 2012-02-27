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
    function initPage( &$out ) {
        SkinTemplate::initPage( $out );
        $this->skinname  = 'bootstrap-mediawiki';
        $this->stylename = 'bootstrap-mediawiki';
        $this->template  = 'BootstrapMW_Template';
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
		global $wgUser, $wgSitename, $wgSitenameshort, $wgCopyrightLink, $wgCopyright, $wgBootstrap, $wgArticlePath, $wgGoogleAnalyticsID, $wgSiteCSS;

		$this->skin = $this->data['skin'];

        // Suppress warnings to prevent notices about missing indexes in $this->data
        wfSuppressWarnings();
?><!DOCTYPE html>
<html xml:lang="<?php $this->text('lang') ?>" lang="<?php $this->text('lang') ?>" dir="<?php $this->text('dir') ?>">
<head>
    <meta http-equiv="Content-Type" content="<?php $this->text('mimetype') ?>; charset=<?php $this->text('charset') ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php $this->text('pagetitle') ?></title>
    <link rel="stylesheet" type="text/css" href="<?php $this->text('stylepath') ?>/<?php $this->text('stylename') ?>/bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="<?php $this->text('stylepath') ?>/<?php $this->text('stylename') ?>/bootstrap/css/bootstrap-responsive.min.css" />
    <link rel="stylesheet" type="text/css" href="<?php $this->text('stylepath') ?>/<?php $this->text('stylename') ?>/google-code-prettify/prettify.css" />
    <link rel="stylesheet" type="text/css" href="<?php $this->text('stylepath') ?>/<?php $this->text('stylename') ?>/style.css" />
    <?php if(isset($wgSiteCSS)) { ?>
    	<link rel="stylesheet" type="text/css" href="<?php $this->text('stylepath') ?>/<?php $this->text('stylename') ?>/<?php echo $wgSiteCSS ?>" />
    <?php } ?>
    <?php $this->html('headlinks') ?>
    <?php 
    
    if(isset($wgGoogleAnalyticsID)) { ?>

<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', '<?php echo $wgGoogleAnalyticsID; ?>']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
      <?php
    }
    ?>
</head>
<body class="<?php echo Sanitizer::escapeClass('page-' . $this->data['title'])?>">

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
					<a href="/webapp/devwiki/wiki/Main_Page">Home</a>
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
			<ul class="nav pull-right"><?php echo $content_nav; ?></ul>
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


    <div id="wiki-body" class="container">

      <?php if( $this->data['sitenotice'] ) { ?><div id="siteNotice" class="alert-message warning"><?php $this->html('sitenotice') ?></div><?php } ?>

        <div class="page-header">
          <h1><?php $this->html( 'title' ) ?> <small><?php $this->html('subtitle') ?></small></h1>
        </div>	

        <!-- Main hero unit for a primary marketing message or call to action -->
<!--
        <div class="hero-unit">
          <h1>Hello, world!</h1>
          <p>Vestibulum id ligula porta felis euismod semper. Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit.</p>
          <p><a class="btn primary large">Learn more &raquo;</a></p>
        </div>
-->

		<?php $this->html( 'bodytext' ) ?>

    </div><!-- container -->



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

  	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
  	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js"></script>
  	<script type="text/javascript" src="<?php $this->text('stylepath') ?>/<?php $this->text('stylename') ?>/js/site.min.js"></script>
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
			$pageTitle = Title::newFromText($topItem['title']);
			if(array_key_exists('sublinks', $topItem)) {
				$output .= '<li class="dropdown">';
				$output .= '<a href="#" class="dropdown-toggle" data-toggle="dropdown">' . $topItem['title'] . ' <b class="caret"></b></a>';
				$output .= '<ul class="dropdown-menu">';
				foreach($topItem['sublinks'] as $subLink) {
					if( $subLink['local'] && $pageTitle = Title::newFromText($subLink['link']) ) {
						$href = $pageTitle->getLocalURL();
					} else {
						$href = $subLink['link'];
					}//end else
					$output .= "<li {$subLink['attributes']}><a href='{$href}' class='{$subLink['class']}'>{$subLink['title']}</a>";
				}
				$output .= '</ul>';
				$output .= '</li>';
			} else {
				$output .= '<li' . ($this->data['title'] == $topItem['title'] ? ' class="active"' : '') . '><a href="' . $pageTitle->getLocalURL() . '">' . $topItem['title'] . '</a></li>';
			}
		}

		return $output;
	}

	private function get_page_links( $source ) {
		$titleBar = $this->getPageRawText( $source );
		$nav = array();
		foreach(explode("\n", $titleBar) as $line) {
			if(trim($line) == '') continue;
			
			if(preg_match('/^\*\s*\[\[(.+)\]\]/', $line, $match)) {
				$nav[] = array('title'=>$match[1], 'link'=>$match[1]);
			}elseif(preg_match('/\*\*\s*(.*)\[\[(.+)\]\]/', $line, $match)) {
				if( strpos( $match[2], '|' ) !== false ) {
					$item = explode( '|', $match[2] );
					$item = array(
						'title' => $match[1] . $item[1],
						'link' => $item[0],
						'local' => true,
					);
				} else {
					$item = $match[1] . $match[2];
				}//end else

				$nav[count($nav)-1]['sublinks'][] = $item;
			}elseif(preg_match('/^\*\s*(.+)/', $line, $match)) {
				$nav[] = array('title'=>$match[1]);
			}
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

