<?php
/**
 * Bootstrap - A basic MediaWiki skin based on Twitter's excellent Bootstrap CSS framework
 *
 * @Author Sergi Tur Badenas <sergiturbadenas@gmail.com>
 *
 * Based On:
 * @Version 1.0.0
 * @Author Matthew Batchelder <borkweb@gmail.com>
 * @Copyright Matthew Batchelder 2012 - http://borkweb.com/
 * @License: GPLv2 (http://www.gnu.org/copyleft/gpl.html)
 */

if ( ! defined( 'MEDIAWIKI' ) ) {
	die( -1 );
}//end if

//File removed on new mediawiki versions (1.24.1 at least).
//require_once('includes/SkinTemplate.php');

if(file_exists('includes/SkinTemplate.php')){
    require_once('includes/SkinTemplate.php');
}

/**
 * Inherit main code from SkinTemplate, set the CSS and template filter.
 * @package MediaWiki
 * @subpackage Skins
 */
class SkinBootstrapMediaWiki extends SkinTemplate {
	/** Using Bootstrap */
	public $skinname = 'bootstrap-mediawiki';
	public $stylename = 'bootstrap-mediawiki';
	public $template = 'BootstrapMediaWikiTemplate';
	public $useHeadElement = true;

	/**
	 * initialize the page
	 */
	public function initPage( OutputPage $out ) {
		global $wgSiteJS;
		parent::initPage( $out );
		$out->addModuleScripts( 'skins.bootstrapmediawiki' );
		$out->addMeta( 'viewport', 'width=device-width, initial-scale=1, maximum-scale=1' );
		$out->addStyle('http://fonts.googleapis.com/css?family=Raleway%7COswald%3A400&#038;ver=4.0.1', 'all');
	}//end initPage

	/**
	 * prepares the skin's CSS
	 */
	public function setupSkinUserCss( OutputPage $out ) {
		global $wgSiteCSS;

		parent::setupSkinUserCss( $out );

		$out->addModuleStyles( 'skins.bootstrapmediawiki' );

		// we need to include this here so the file pathing is right
		$out->addStyle( 'bootstrap-mediawiki/font-awesome/css/font-awesome.min.css' );
	}//end setupSkinUserCss
}

/**
 * @package MediaWiki
 * @subpackage Skins
 */
class BootstrapMediaWikiTemplate extends QuickTemplate {
	/**
	 * @var Cached skin object
	 */
	public $skin;

	/**
	 * Template filter callback for Bootstrap skin.
	 * Takes an associative array of data set from a SkinTemplate-based
	 * class, and a wrapper for MediaWiki's localization database, and
	 * outputs a formatted page.
	 *
	 * @access private
	 */
	public function execute() {
		global $wgRequest, $wgUser, $wgSitename, $wgSitenameshort, $wgCopyrightLink, $wgCopyright, $wgBootstrap, $wgArticlePath, $wgGoogleAnalyticsID, $wgSiteCSS;
		global $wgEnableUploads;
		global $wgLogo;
		global $wgTOCLocation;
		global $wgNavBarClasses;
		global $wgSubnavBarClasses;
		global $wgDisableCounters;

		$this->skin = $this->data['skin'];
		$action = $wgRequest->getText( 'action' );
		$url_prefix = str_replace( '$1', '', $wgArticlePath );

		// Suppress warnings to prevent notices about missing indexes in $this->data
		wfSuppressWarnings();

		$this->html('headelement');
		?>
		<div id="extruderTop" class="{title:'Contingut'}"></div>
		<div class="navbar navbar-default navbar-fixed-top <?php echo $wgNavBarClasses; ?>" role="navigation">
				<div class="container-fluid">
					<!-- .btn-navbar is used as the toggle for collapsed navbar content -->
					<div class="navbar-header">
						<button class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<a class="navbar-brand" href="<?php echo $this->data['nav_urls']['mainpage']['href'] ?>" title="<?php echo $wgSitename ?>"><?php echo isset( $wgLogo ) && $wgLogo ? "<img src='{$wgLogo}' alt='Logo'/> " : ''; echo $wgSitenameshort ?: $wgSitename; ?></a>
					</div>

					<div class="collapse navbar-collapse">
						<ul class="nav navbar-nav">
							<!--<li>
							<a href="<?php echo $this->data['nav_urls']['mainpage']['href'] ?>">Home</a>
							</li>
							-->
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo wfMessage( 'toolbox')->text();?> <span class="caret"></span></a>
								<ul class="dropdown-menu">
									<li><a href="<?php echo $url_prefix; ?>Special:RecentChanges" class="recent-changes"><i class="fa fa-edit"></i> <?php echo wfMessage('recentchanges')->text();?></a></li>
									<li><a href="<?php echo $url_prefix; ?>Special:SpecialPages" class="special-pages"><i class="fa fa-star-o"></i> <?php echo wfMessage('specialpages')->text();?></a></li>
									<?php if ( $wgEnableUploads ) { ?>
									<li><a href="<?php echo $url_prefix; ?>Special:Upload" class="upload-a-file"><i class="fa fa-upload"></i> <?php echo wfMessage('uploadbtn')->text();?></a></li>
									<?php } ?>
								</ul>
							</li>
							<?php //var_export ($this->data['content_actions']);?>
							
							 <?php  if ( $wgUser->isLoggedIn() ) : ?>
								<li><a href="<?php echo $this->data['content_actions']['nstab-main']['href'];?>"><i class="fa fa-file"></i> <?php echo wfMessage('mypage')->text();?></a></li>
	                                                        <li><a href="<?php echo $this->data['content_actions']['edit']['href'];?>"><i class="fa fa-pencil"></i> <?php echo wfMessage( 'edit')->text();?></a></li>							 							 
							 <?php endif; ?>
							<?php echo $this->nav( $this->get_page_links( 'Bootstrap:TitleBar' ) ); ?>
						</ul>
					<?php
					if ( $wgUser->isLoggedIn() ) {
						if ( count( $this->data['personal_urls'] ) > 0 ) {
							$user_icon = '<span class="user-icon"><img src="https://secure.gravatar.com/avatar/'.md5(strtolower( $wgUser->getEmail())).'.jpg?s=20&r=g"/></span>';
							$name = strtolower( $wgUser->getName() );
							$user_nav = $this->get_array_links( $this->data['personal_urls'], $user_icon . $name, 'user' );
							?>
							<ul<?php $this->html('userlangattributes') ?> class="nav navbar-nav navbar-right">
								<?php echo $user_nav; ?>
							</ul>
							<?php
						}//end if

						if ( count( $this->data['content_actions']) > 0 ) {
							//var_export( $this->data['content_actions']);
							$content_nav = $this->get_array_links( $this->data['content_actions'], wfMessage('nstab-main')->text() , 'page' );
							?>
							<ul class="nav navbar-nav navbar-right content-actions"><?php echo $content_nav; ?></ul>
							<?php
						}//end if
					} else {  // else if is logged in
						?>
						<ul class="nav navbar-nav navbar-right">
							<li>
							<?php echo Linker::linkKnown( SpecialPage::getTitleFor( 'Userlogin' ), wfMsg( 'login' ) ); ?>
							</li>
						</ul>
						<?php
					}
					?>
					<form class="navbar-search navbar-form navbar-right" action="<?php $this->text( 'wgScript' ) ?>" id="searchform" role="search">
						<div>
							<input class="form-control" type="search" name="search" placeholder="<?php echo $this->msg( 'search' );?>" title="Search <?php echo $wgSitename; ?> [ctrl-option-f]" accesskey="f" id="searchInput" autocomplete="off">
							<input type="hidden" name="title" value="Special:Search">
						</div>
					</form>
					</div>
				</div>
		</div><!-- topbar -->
		<?php
		if( $subnav_links = $this->get_page_links('Bootstrap:Subnav') ) {
			?>
			<div class="subnav subnav-fixed">
				<div class="container-fluid">
					<?php

					$subnav_select = $this->nav_select( $subnav_links );

					if ( trim( $subnav_select ) ) {

						?>
						<select id="subnav-select">
						<?php echo $subnav_select; ?>
						</select>
						<?php
					}//end if
					?>
					<ul class="nav nav-pills">
					<?php echo $this->nav( $subnav_links ); ?>
					</ul>
				</div>
			</div>
			<?php
		}//end if
		?>
		<div id="wiki-outer-body">
			<div id="wiki-body" class="container-fluid">
				<?php
					if ( 'sidebar' == $wgTOCLocation ) {
						?>
						<script type="text/javascript">
							var toc_sidebar_title = "<?php echo wfMessage('toc')->text(); ?>";
							var toc_sidebar_hide = "<?php echo wfMessage('hidetoc')->text();?>";
							var toc_sidebar_show = "<?php echo wfMessage('showtoc')->text();?>";
						</script>
						<div class="row">
							<section class="col-md-3 toc-sidebar"></section>
							<section class="col-md-9 wiki-body-section">
						<?php
					}//end if
				?>
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
				<?php
					if ( 'sidebar' == $wgTOCLocation ) {
						?>
						</section></section>
						<?php
					}//end if
				?>
			</div><!-- container -->
		</div>
		<div class="bottom">
			<div class="container-fluid" style="padding-left: 0px;padding-right:0px;">
				<!--<?php //$this->includePage('Bootstrap:Footer'); ?>-->

<footer class="dark-div main-color-2-bg fixed-effect">
                                                                                        
        	<div class="footer-inner fixed-effect-inner">
        	<section id="bottom">
            	<div class="section-inner">
                	<div class="container">
                    	<div class="row normal-sidebar">
			<div id="text-2" class="   col-md-3 widget widget_text">
			<div class=" widget-inner"><h2 class="widget-title maincolor1">Sobre nosaltres</h2>			<div class="textwidget"><img src="/resources/assets/poweredby_mediawiki_88x31.png" alt="logo">
<br><br>
<p style="font-family: Raleway,sans-serif;">Acacha Wiki és un lloc web col·laboratiu d' informàtica i telecomunicacions creat per experts en administració de sistemes, xarxes, desenvolupament multiplataforma, disseny web i altres àrees de coneixement.</p>
<a class="btn btn-default footerbutton" style="margin-top:4px;" href="/mediawiki/index.php/Acacha_Wiki._Informàtica_i_telecomunicacions:Quant_a">Quant a</a>
<a class="btn btn-default footerbutton" style="margin-top:5px;" href="/mediawiki/index.php/Acacha_Wiki._Informàtica_i_telecomunicacions:Política de privadesa">Política de privadesa</a>
<a class="btn btn-default footerbutton" style="margin-top:5px;" href="/mediawiki/index.php/Acacha_Wiki._Informàtica_i_telecomunicacions:Avís general">Avís general</a></div>

		</div></div><div id="app-recent-posts-2" class="   col-md-3 widget app_recent_posts"><div class=" widget-inner"><div class="app-lastest"><h2 class="widget-title maincolor1">Blog</h2><div class="item"><div class="thumb item-thumbnail">
							<a href="#" title="Android Apps on Applay">
								<div class="item-thumbnail"><img width="80" height="80" src="/resources/assets/IMG_3212-1300x866-80x80.jpg" class="attachment-thumb_80x80 wp-post-image" alt="TODO" />
									<div class="thumbnail-hoverlay main-color-5-bg"></div>
									<div class="thumbnail-hoverlay-icon"><i class="fa fa-search"></i></div>
								</div>
							</a>
						</div><div class="app-details item-content">
						<h5><a href="#" title="Android Apps on Applay" class="main-color-5-hover">Entrada blog 1</a></h5>
						<span>October 9, 2014</span>
					</div>
					<div class="clearfix"></div></div>
					
					<div class="item"><div class="thumb item-thumbnail">
							<a href="#" title="Apps For Work‎">
								<div class="item-thumbnail"><img width="80" height="80" src="/resources/assets/IMG_5956-1300x866-80x80.jpg" class="attachment-thumb_80x80 wp-post-image" alt="pendent" />
									<div class="thumbnail-hoverlay main-color-5-bg"></div>
									<div class="thumbnail-hoverlay-icon"><i class="fa fa-search"></i></div>
								</div>
							</a>
						</div><div class="app-details item-content">
						<h5><a href="#" title="Apps For Work‎" class="main-color-1-hover">Entrada blog 2</a></h5>
						<span>October 9, 2014</span>
					</div>
					<div class="clearfix"></div></div>
					
					</div></div></div>
<div id="tag_cloud-5" class="   col-md-3 widget widget_tag_cloud"><div class=" widget-inner"><h2 class="widget-title maincolor1">Pàgines populars</h2>

<div>
 <a href='/mediawiki/index.php/Creació_de_paquets_Debian' class='btn btn-default footerbutton' style="margin-top:4px;">Creació Paquets Debian</a>
 <a href='/mediawiki/index.php/Apache' class='btn btn-default footerbutton' style="margin-top:4px;">Apache</a>
 <a href='/mediawiki/index.php/APT_i_DPKG' class='btn btn-default footerbutton' style="margin-top:4px;">APT i DPKG</a>
 <a href='/mediawiki/index.php/DNS' class='btn btn-default footerbutton' style="margin-top:4px;">DNS</a>    
 <a href='/mediawiki/index.php/Ldap' class='btn btn-default footerbutton' style="margin-top:4px;">Ldap</a>  
 <a href='/mediawiki/index.php/Android UI development' class='btn btn-default footerbutton' style="margin-top:4px;">Android UI development</a>    
 <a href='/mediawiki/index.php/DHCP' class='btn btn-default footerbutton' style="margin-top:4px;">DHCP</a>    
 <a href='/mediawiki/index.php/SQL' class='btn btn-default footerbutton' style="margin-top:4px;">SQL</a>   
 <a href='/mediawiki/index.php/Especial:Pàgines_populars' class='btn btn-default footerbutton' style="margin-top:4px;">Llista completa</a>
 <a href='/mediawiki/index.php/AirOS' class='btn btn-default footerbutton' style="margin-top:4px;">AirOS</a>
    
  
</div></div></div>
<div id="zflickr-2" class="col-md-3 widget widget_flickr"><div class=" widget-inner"><h2 class="widget-title maincolor1">Segueix-nos</h2>
 <div class='flickr-badge-wrapper zframe-flickr-wrap-ltr'>
  <a class="twitter-follow-button" href="https://twitter.com/acachawiki"
    data-show-count="false"
      data-lang="en">
      Follow @acachawiki
      </a>
      <script type="text/javascript">
       window.twttr = (function (d, s, id) {
       var t, js, fjs = d.getElementsByTagName(s)[0];
       if (d.getElementById(id)) return;
       js = d.createElement(s); js.id = id;
       js.src= "https://platform.twitter.com/widgets.js";
       fjs.parentNode.insertBefore(js, fjs);
       return window.twttr || (t = { _e: [], ready: function (f) { t._e.push(f) } });
       }(document, "script", "twitter-wjs"));
      </script>
 </div>
 <div id="fb-root"></div>
 <div class="fb-like" data-href="http://acacha.org" data-layout="button_count" data-action="like" data-show-faces="true" data-share="true"></div>
 <script>(function(d, s, id) {
   var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) return;
       js = d.createElement(s); js.id = id;
         js.src = "//connect.facebook.net/ca_ES/sdk.js#xfbml=1&appId=779450832121140&version=v2.0";
           fjs.parentNode.insertBefore(js, fjs);
           }(document, 'script', 'facebook-jssdk'));
 </script>
 <br/><br/>
 
 <!-- Inserta esta etiqueta en la sección "head" o justo antes de la etiqueta "body" de cierre. -->
 <script src="https://apis.google.com/js/platform.js" async defer>
   {lang: 'ca'}
   </script>
   
   <!-- Inserta esta etiqueta donde quieras que aparezca Botón +1. -->
   <div class="g-plusone" data-annotation="inline" data-width="300"></div>
 <br/>
 <h2 class="widget-title maincolor1">Pàgines Germanes</h2>
 <p><a href="http://acacha.org/mediawiki/index.php/Ebre-escool">Ebre-escool</a></p>
</div>
</div>                		
</div>
                    </div>
                </div>
            </section>
            <div id="bottom-nav">
                <div class="container">
                    <div class="text-center back-to-top-wrap">
                        <a class="back-to-top main-color-10-bg" href="#top" title="Pujar" style="text-decoration:none;"><i class="fa fa-angle-double-up"></i></a>
                    </div>
                    <div class="row footer" style="padding-bottom: 0px;padding-top: 10px;">
                     <div class="col-md-12" style="font-family: Raleway,sans-serif;text-align:center;padding-bottom: 0px;padding-top: 0px;font-size:10px;">
                         <?php 
                         
                         $title = RequestContext::getMain()->getTitle();
                         $skin = RequestContext::getMain()->getSkin();
                         if ( RequestContext::getMain()->getOutput()->isArticle() && $title->exists() ) {
                         	if ( $skin->isRevisionCurrent() ) {
                         		if ( !$wgDisableCounters ) {
						 $viewcount = RequestContext::getMain()->getWikiPage()->getCount();
						if ( $viewcount ) {
							echo wfMessage( 'viewcount', $viewcount)->parse();						
						}
					}
				}
			 }	
			 
			 ?>
                         <br/>
                         <?php

			 $timestamp = RequestContext::getMain()->getOutput()->getRevisionTimestamp();
                         # No cached timestamp, load it from the database
                         if ( $timestamp === null ) {
	                    $timestamp = Revision::getTimestampFromId( $title, $skin->getRevisionId() );
                         }
                         $d ="";
                         $t="";
                         if ( $timestamp ) {
			    $d = RequestContext::getMain()->getLanguage()->userDate( $timestamp, RequestContext::getMain()->getUser() );				
			    $t = RequestContext::getMain()->getLanguage()->userTime( $timestamp, RequestContext::getMain()->getUser() );
			    $s = ' ' . wfMessage( 'lastmodifiedat', $d,$t)->text();
			 }
			 echo $s;?></div>    
                    </div>                                                                                    
                    <div class="row footer-content" style="padding-top: 0px;">
                        <div class="copyright col-md-7" style="font-family: Raleway,sans-serif;">
							&copy; <?php echo date('Y'); ?> by <a href="<?php echo (isset($wgCopyrightLink) ? $wgCopyrightLink : 'http://acacha.org'); ?>" style="text-decoration:none;font-family: Raleway,sans-serif;"><?php echo (isset($wgCopyright) ? $wgCopyright : 'Sergi Tur Badenas i altres contribuïdors'); ?></a>
							&bull; Powered by <a href="http://mediawiki.org" style="text-decoration:none;">MediaWiki</a> 
							& <a href="http://getbootstrap.com" style="text-decoration:none;">Bootstrap</a> 
							                        </div>
                        <nav class="col-md-5 footer-social">
                        	                            <ul class="list-inline pull-right social-list">
                            	                                            <li><a href="https://www.facebook.com/pages/Acacha-Wiki/121532428620" target="_blank"  class="btn btn-default social-icon"><i class="fa fa-facebook"></i></a></li>
				                                            <li><a href="https://twitter.com/acachawiki"  class="btn btn-default social-icon" target="_blank"><i class="fa fa-twitter"></i></a></li>
				                                            <li><a href="https://www.linkedin.com/company/acacha-wiki?trk=company_logo"  class="btn btn-default social-icon" target="_blank"><i class="fa fa-linkedin"></i></a></li>
				                                            <li><a href="https://plus.google.com/b/116791959261119875735/"  class="btn btn-default social-icon" target="_blank"><i class="fa fa-google-plus"></i></a></li>
				                            </ul>
                        </nav>
                    </div><!--/row-->
                                                                                                      
                </div><!--/container-->
            </div>
            </div>
            
        </footer><!--/footer-inner-->


			</div><!-- container -->
		</div><!-- bottom -->
		

		<?php
		$this->html('bottomscripts'); /* JS call to runBodyOnloadHook */
		$this->html('reporttime');

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
	}//end execute

	/**
	 * Render one or more navigations elements by name, automatically reveresed
	 * when UI is in RTL mode
	 */
	private function nav( $nav ) {
		$output = '';
		foreach ( $nav as $topItem ) {
			$pageTitle = Title::newFromText( $topItem['link'] ?: $topItem['title'] );
			if ( array_key_exists( 'sublinks', $topItem ) ) {
				$output .= '<li class="dropdown">';
				$output .= '<a href="#" class="dropdown-toggle" data-toggle="dropdown">' . $topItem['title'] . ' <b class="caret"></b></a>';
				$output .= '<ul class="dropdown-menu">';

				foreach ( $topItem['sublinks'] as $subLink ) {
					if ( 'divider' == $subLink ) {
						$output .= "<li class='divider'></li>\n";
					} elseif ( $subLink['textonly'] ) {
						$output .= "<li class='nav-header'>{$subLink['title']}</li>\n";
					} else {
						if( $subLink['local'] && $pageTitle = Title::newFromText( $subLink['link'] ) ) {
							$href = $pageTitle->getLocalURL();
						} else {
							$href = $subLink['link'];
						}//end else

						$slug = strtolower( str_replace(' ', '-', preg_replace( '/[^a-zA-Z0-9 ]/', '', trim( strip_tags( $subLink['title'] ) ) ) ) );
						$output .= "<li {$subLink['attributes']}><a href='{$href}' class='{$subLink['class']} {$slug}'>{$subLink['title']}</a>";
					}//end else
				}
				$output .= '</ul>';
				$output .= '</li>';
			} else {
				if( $pageTitle ) {
					$output .= '<li' . ($this->data['title'] == $topItem['title'] ? ' class="active"' : '') . '><a href="' . ( $topItem['external'] ? $topItem['link'] : $pageTitle->getLocalURL() ) . '">' . $topItem['title'] . '</a></li>';
				}//end if
			}//end else
		}//end foreach
		return $output;
	}//end nav

	/**
	 * Render one or more navigations elements by name, automatically reveresed
	 * when UI is in RTL mode
	 */
	private function nav_select( $nav ) {
		$output = '';
		foreach ( $nav as $topItem ) {
			$pageTitle = Title::newFromText( $topItem['link'] ?: $topItem['title'] );
			$output .= '<optgroup label="'.strip_tags( $topItem['title'] ).'">';
			if ( array_key_exists( 'sublinks', $topItem ) ) {
				foreach ( $topItem['sublinks'] as $subLink ) {
					if ( 'divider' == $subLink ) {
						$output .= "<option value='' disabled='disabled' class='unclickable'>----</option>\n";
					} elseif ( $subLink['textonly'] ) {
						$output .= "<option value='' disabled='disabled' class='unclickable'>{$subLink['title']}</option>\n";
					} else {
						if( $subLink['local'] && $pageTitle = Title::newFromText( $subLink['link'] ) ) {
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
	}//end nav_select

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
			}elseif(preg_match('/^\*\s*([^\*\[]*)\[([^\[ ]+) (.+)\]/', $line, $match)) {
				$sub = false;
				$link = true;
				$external = true;
			}elseif(preg_match('/^\*\*\s*([^\*\[]*)\[([^\[ ]+) (.+)\]/', $line, $match)) {
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
			
			//DEBUG
			//echo $key . " | " . $link['title'] . " # ";

			if( 'page' == $which ) {
				switch( $key ) {
				case 'nstab-main': $icon = 'file'; break;
				case 'talk': $icon = 'comment'; break;
				case 'edit': $icon = 'pencil'; break;
				case 'history': $icon = 'clock-o'; break;
				case 'delete': $icon = 'remove'; break;
				case 'move': $icon = 'arrows'; break;
				case 'protect': $icon = 'lock'; break;
				case 'unprotect': $icon = 'unlock'; break;
				case 'watch': $icon = 'eye-open'; break;
				case 'unwatch': $icon = 'eye-slash'; break;
				}//end switch

				$link['title'] = '<i class="fa fa-' . $icon . '"></i> ' . $link['title'];
			} elseif( 'user' == $which ) {
				switch( $key ) {
				case 'mytalk': $icon = 'comment'; break;
				case 'preferences': $icon = 'cog'; break;
				case 'watchlist': $icon = 'eye-slash'; break;
				case 'mycontris': $icon = 'list-alt'; break;
				case 'logout': $icon = 'power-off'; break;
				default: $icon = 'user'; break;
				}//end switch

				$link['title'] = '<i class="fa fa-' . $icon . '"></i> ' . $link['title'];
			}//end elseif

			$nav[0]['sublinks'][] = $link;
		}//end foreach

		return $this->nav( $nav );
	}//end get_array_links

	function getPageRawText($title) {
		global $wgParser, $wgUser;
		$pageTitle = Title::newFromText($title);
		if(!$pageTitle->exists()) {
			return 'Create the page [[Bootstrap:TitleBar]]';
		} else {
			$article = new Article($pageTitle);
			$wgParserOptions = new ParserOptions($wgUser);
			// get the text as static wiki text, but with already expanded templates,
			// which also e.g. to use {{#dpl}} (DPL third party extension) for dynamic menus.
			$parserOutput = $wgParser->preprocess($article->getRawText(), $pageTitle, $wgParserOptions );
			return $parserOutput;
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

