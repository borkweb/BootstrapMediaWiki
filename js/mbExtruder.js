/*
 * ******************************************************************************
 *  jquery.mb.components
 *  file: mbExtruder.js
 *
 *  Copyright (c) 2001-2014. Matteo Bicocchi (Pupunzi);
 *  Open lab srl, Firenze - Italy
 *  email: matteo@open-lab.com
 *  site: 	http://pupunzi.com
 *  blog:	http://pupunzi.open-lab.com
 * 	http://open-lab.com
 *
 *  Licences: MIT, GPL
 *  http://www.opensource.org/licenses/mit-license.php
 *  http://www.gnu.org/licenses/gpl.html
 *
 *  last modified: 08/05/14 20.00
 *  *****************************************************************************
 */

/*Browser detection patch*/
var nAgt = navigator.userAgent;
if (!jQuery.browser) {
	jQuery.browser = {};
	jQuery.browser.mozilla = !1;
	jQuery.browser.webkit = !1;
	jQuery.browser.opera = !1;
	jQuery.browser.safari = !1;
	jQuery.browser.chrome = !1;
	jQuery.browser.msie = !1;
	jQuery.browser.ua = nAgt;
	jQuery.browser.name = navigator.appName;
	jQuery.browser.fullVersion = "" + parseFloat(navigator.appVersion);
	jQuery.browser.majorVersion = parseInt(navigator.appVersion, 10);
	var nameOffset, verOffset, ix;
	if (-1 != (verOffset = nAgt.indexOf("Opera")))jQuery.browser.opera = !0, jQuery.browser.name = "Opera", jQuery.browser.fullVersion = nAgt.substring(verOffset + 6), -1 != (verOffset = nAgt.indexOf("Version")) && (jQuery.browser.fullVersion = nAgt.substring(verOffset + 8)); else if (-1 != (verOffset = nAgt.indexOf("OPR")))jQuery.browser.opera = !0, jQuery.browser.name = "Opera", jQuery.browser.fullVersion = nAgt.substring(verOffset + 4); else if (-1 != (verOffset = nAgt.indexOf("MSIE")))jQuery.browser.msie = !0, jQuery.browser.name = "Microsoft Internet Explorer", jQuery.browser.fullVersion = nAgt.substring(verOffset + 5); else if (-1 != nAgt.indexOf("Trident")) {
		jQuery.browser.msie = !0;
		jQuery.browser.name = "Microsoft Internet Explorer";
		var start = nAgt.indexOf("rv:") + 3, end = start + 4;
		jQuery.browser.fullVersion = nAgt.substring(start, end)
	} else-1 != (verOffset = nAgt.indexOf("Chrome")) ? (jQuery.browser.webkit = !0, jQuery.browser.chrome = !0, jQuery.browser.name = "Chrome", jQuery.browser.fullVersion = nAgt.substring(verOffset + 7)) : -1 != (verOffset = nAgt.indexOf("Safari")) ? (jQuery.browser.webkit = !0, jQuery.browser.safari = !0, jQuery.browser.name = "Safari", jQuery.browser.fullVersion = nAgt.substring(verOffset + 7), -1 != (verOffset = nAgt.indexOf("Version")) && (jQuery.browser.fullVersion = nAgt.substring(verOffset + 8))) : -1 != (verOffset = nAgt.indexOf("AppleWebkit")) ? (jQuery.browser.webkit = !0, jQuery.browser.name = "Safari", jQuery.browser.fullVersion = nAgt.substring(verOffset + 7), -1 != (verOffset = nAgt.indexOf("Version")) && (jQuery.browser.fullVersion = nAgt.substring(verOffset + 8))) : -1 != (verOffset = nAgt.indexOf("Firefox")) ? (jQuery.browser.mozilla = !0, jQuery.browser.name = "Firefox", jQuery.browser.fullVersion = nAgt.substring(verOffset + 8)) : (nameOffset = nAgt.lastIndexOf(" ") + 1) < (verOffset = nAgt.lastIndexOf("/")) && (jQuery.browser.name = nAgt.substring(nameOffset, verOffset), jQuery.browser.fullVersion = nAgt.substring(verOffset + 1), jQuery.browser.name.toLowerCase() == jQuery.browser.name.toUpperCase() && (jQuery.browser.name = navigator.appName));
	-1 != (ix = jQuery.browser.fullVersion.indexOf(";")) && (jQuery.browser.fullVersion = jQuery.browser.fullVersion.substring(0, ix));
	-1 != (ix = jQuery.browser.fullVersion.indexOf(" ")) && (jQuery.browser.fullVersion = jQuery.browser.fullVersion.substring(0, ix));
	jQuery.browser.majorVersion = parseInt("" + jQuery.browser.fullVersion, 10);
	isNaN(jQuery.browser.majorVersion) && (jQuery.browser.fullVersion = "" + parseFloat(navigator.appVersion), jQuery.browser.majorVersion = parseInt(navigator.appVersion, 10));
	jQuery.browser.version = jQuery.browser.majorVersion
}
jQuery.browser.android = /Android/i.test(nAgt);
jQuery.browser.blackberry = /BlackBerry/i.test(nAgt);
jQuery.browser.ios = /iPhone|iPad|iPod/i.test(nAgt);
jQuery.browser.operaMobile = /Opera Mini/i.test(nAgt);
jQuery.browser.windowsMobile = /IEMobile/i.test(nAgt);
jQuery.browser.mobile = jQuery.browser.android || jQuery.browser.blackberry || jQuery.browser.ios || jQuery.browser.windowsMobile || jQuery.browser.operaMobile;

/*
 * Metadata - jQuery plugin for parsing metadata from elements
 * Copyright (c) 2006 John Resig, Yehuda Katz, Jörn Zaefferer, Paul McLanahan
 * Dual licensed under the MIT and GPL licenses:
 *   http://www.opensource.org/licenses/mit-license.php
 *   http://www.gnu.org/licenses/gpl.html
 */

(function(c){c.extend({metadata:{defaults:{type:"class",name:"metadata",cre:/({.*})/,single:"metadata"},setType:function(b,c){this.defaults.type=b;this.defaults.name=c},get:function(b,f){var d=c.extend({},this.defaults,f);d.single.length||(d.single="metadata");var a=c.data(b,d.single);if(a)return a;a="{}";if("class"==d.type){var e=d.cre.exec(b.className);e&&(a=e[1])}else if("elem"==d.type){if(!b.getElementsByTagName)return;e=b.getElementsByTagName(d.name);e.length&&(a=c.trim(e[0].innerHTML))}else void 0!= b.getAttribute&&(e=b.getAttribute(d.name))&&(a=e);0>a.indexOf("{")&&(a="{"+a+"}");a=eval("("+a+")");c.data(b,d.single,a);return a}}});c.fn.metadata=function(b){return c.metadata.get(this[0],b)}})(jQuery);

/***************************************************************************************/


(function($) {
	document.extruder=new Object();
	document.extruder.left = 0;
	document.extruder.top = 0;
	document.extruder.bottom = 0;
	document.extruder.right = 0;
	document.extruder.idx=0;
	var isIE=$.browser.msie;

	$.mbExtruder= {
		author:"Matteo Bicocchi",
		version:"2.5.5",
		defaults:{
			width:350,
			positionFixed:true,
			sensibility:800,
			position:"top",
			accordionPanels:true,
			top:"auto",
			extruderOpacity:1,
			flapMargin:35,
			textOrientation:"bt", // or "tb" (top-bottom or bottom-top)
			onExtOpen:function(){},
			onExtContentLoad:function(){},
			onExtClose:function(){},
			hidePanelsOnClose:true,
			closeOnClick:true,
			closeOnExternalClick:true,
			autoCloseTime:0,
			autoOpenTime:0,
			slideTimer:300
		},

		buildMbExtruder: function(options){
			return this.each (function (){
				this.options = {};
				$.extend (this.options, $.mbExtruder.defaults);
				$.extend (this.options, options);

				this.idx=document.extruder.idx;
				document.extruder.idx++;
				var extruder,extruderContent,wrapper,extruderStyle,wrapperStyle,txt,closeTimer,openTimer;
				extruder= $(this);
				extruderContent=extruder.html();

				extruder.css("zIndex",100);
				var isVertical = this.options.position=="left" || this.options.position=="right";
				var extW= isVertical?1: this.options.width;
				var c= $("<div/>").addClass("extruder-content").css({overflow:"hidden", width:extW});
				c.append(extruderContent);
				extruder.html(c);

				var position=this.options.positionFixed?"fixed":"absolute";
				extruder.addClass("extruder");
				extruder.addClass(this.options.position);
				var isHorizontal = this.options.position=="top" || this.options.position=="bottom";
				extruderStyle =
								this.options.position=="top" ?
				{position:position,top:0,left:"50%",marginLeft:-this.options.width/2,width:this.options.width}:
								this.options.position=="bottom" ?
				{position:position,bottom:0,left:"50%",marginLeft:-this.options.width/2,width:this.options.width}:
								this.options.position=="left" ?
				{position:position,top:0,left:0,width:1}:
				{position:position,top:0,right:0,width:1};
				extruder.css(extruderStyle);
				if(!isIE) extruder.css({opacity:this.options.extruderOpacity});
				extruder.wrapInner("<div class='ext_wrapper'></div>");
				wrapper= extruder.find(".ext_wrapper");

				wrapperStyle={position:"absolute", width:isVertical?1:this.options.width};
				wrapper.css(wrapperStyle);


				if (isHorizontal){
					this.options.position=="top"? document.extruder.top++ : document.extruder.bottom++;
					if (document.extruder.top >1 || document.extruder.bottom>1){
						alert("more than 1 mb.extruder on top or bottom is not supported jet... hope soon!");
						return;
					}
				}

				if ($.metadata){
					$.metadata.setType("class");
					if (extruder.metadata().title) extruder.attr("extTitle",extruder.metadata().title);
					if (extruder.metadata().url) extruder.attr("extUrl",extruder.metadata().url);
					if (extruder.metadata().data) extruder.attr("extData",extruder.metadata().data);
				}

				var flapFooter=$("<div class='footer'/>");
				var flap=$("<div class='flap'><span class='flapLabel'/></div>");
				if (document.extruder.bottom){
					wrapper.prepend(flapFooter);
					wrapper.prepend(flap);
				}else{
					wrapper.append(flapFooter);
					wrapper.append(flap);
				}

				txt=extruder.attr("extTitle")?extruder.attr("extTitle"): "";
				var flapLabel = extruder.find(".flapLabel");
				flapLabel.text(txt);
				if(isVertical){
					flapLabel.html(txt).css({whiteSpace:"noWrap"});
					var orientation= this.options.textOrientation == "tb";
					var labelH=extruder.find('.flapLabel').getFlipTextDim()[1];
					extruder.find('.flapLabel').mbFlipText(orientation);
				}else{
					flapLabel.html(txt).css({whiteSpace:"noWrap"});
				}

				if (extruder.attr("extUrl")){
					extruder.setMbExtruderContent({
						url:extruder.attr("extUrl"),
						data:extruder.attr("extData"),
						callback: function(){
							if (extruder.get(0).options.onExtContentLoad) extruder.get(0).options.onExtContentLoad();
						}
					})
				}else{
					var container=$("<div>").addClass("text").css({width:extruder.get(0).options.width-20, overflowY:"auto"});
					c.wrapInner(container);
					extruder.setExtruderVoicesAction();
				}

				flap.on("click",function(){
					if (!extruder.attr("isOpened")){
						extruder.openMbExtruder();
					}else{
						extruder.closeMbExtruder();
						extruder.removeAttr("isOpened");
					}
				}).on("mouseenter",function(){
					if(extruder.get(0).options.autoOpenTime>0){
						openTimer=setTimeout(function(){
							extruder.openMbExtruder();
							$(document).one("click.extruder"+extruder.get(0).idx,function(){extruder.closeMbExtruder();});
						},extruder.get(0).options.autoOpenTime);
					}
				}).on("mouseleave",function(){
					clearTimeout(openTimer);
				});

				c.on("mouseleave", function(e){
					if(extruder.get(0).options.closeOnExternalClick){

						//Chrome bug: FORMELEMENT fire mouseleave event.
						if(!$(e.target).parents().is(".text"))
							$(document).one("click.extruder"+extruder.get(0).idx,function(){extruder.closeMbExtruder();});
					}
					closeTimer=setTimeout(function(){

						if(extruder.get(0).options.autoCloseTime > 0){
							extruder.closeMbExtruder();
						}
					},extruder.get(0).options.autoCloseTime);
				}).on("mouseenter", function(){
					clearTimeout(closeTimer);
					$(document).off("click.extruder"+extruder.get(0).idx);
				});

				if (isVertical){
					c.css({ height:"100%"});
					if(this.options.top=="auto") {
						flap.css({top:100+(this.options.position=="left"?document.extruder.left:document.extruder.right)});
						this.options.position=="left"?document.extruder.left+=labelH+this.options.flapMargin:document.extruder.right+= labelH+this.options.flapMargin;
					}else{
						flap.css({top:this.options.top});
					}
					var clicDiv=$("<div/>").css({position:"absolute",top:0,left:0,width:"100%",height:"100%",background:"transparent"});
					flap.append(clicDiv);
				}

				this.originalWidth = this.options.width;

				$(window).on("resize",function(){
					extruder.adjustSize();
				})
			});
		},

		adjustSize:function(){

			var $extruder = this;
			var extruder = $extruder.get(0);

			var isHorizontal = extruder.options.position=="top" || extruder.options.position=="bottom";

			if(isHorizontal){

				if( $(window).width() < extruder.options.width){
					$extruder.css({width:$(window).width(), marginLeft:0, left:0});
					$extruder.find(".ext_wrapper, .extruder-content, .extruder-container").css({width:"100%"});
				}else{
					$extruder.css({width:extruder.options.width, left:"50%",marginLeft:-extruder.options.width/2});
					$extruder.find(".ext_wrapper, .extruder-content, .extruder-container").css({width:"100%"});
				}

			} else{

				if( ($(window).width()-80) < extruder.originalWidth){
					extruder.options.width = $(window).width()-80;
				}else{
					extruder.options.width = extruder.originalWidth;
				}

				if($extruder.attr("isOpened")){
					$extruder.find('.extruder-content').css({width: extruder.options.width});
					$extruder.find(".ext_wrapper, .extruder-content, .extruder-container").css({width:extruder.options.width});
				}
			}

		},

		setMbExtruderContent: function(options){
			this.options = {
				url:false,
				data:"",
				callback:function(){}
			};
			$.extend (this.options, options);
			if (!this.options.url || this.options.url.length==0){
				alert("internal error: no URL to call");
				return;
			}
			var url=this.options.url;
			var data=this.options.data;
			var where=$(this), voice;
			var cb= this.options.callback;
			var container=$("<div>").addClass("extruder-container");
			if (!($.browser.msie && $.browser.version<=7))
				container.css({width:$(this).get(0).options.width});
			where.find(".extruder-content").wrapInner(container);
			$.ajax({
				type: "GET",
				url: url,
				data: data,
				async:true,
				dataType:"html",
				success: function(html){
					where.find(".extruder-container").append(html);
					voice=where.find(".voice");
					voice.hover(function(){$(this).addClass("hover");},function(){$(this).removeClass("hover");});
					where.setExtruderVoicesAction();
					if (cb) {
						setTimeout(function(){cb();},100);
					}
				}
			});
		},

		openMbExtruder:function(c){
			var extruder= $(this);
			extruder.adjustSize();

			extruder.attr("isOpened",true);
			$(document).off("click.extruder"+extruder.get(0).idx);
			var opt= extruder.get(0).options;
			extruder.addClass("isOpened");
			if(!isIE) extruder.css("opacity",1);
			var position = opt.position;
			extruder.mb_bringToFront();
			if (position=="top" || position=="bottom"){
				extruder.find('.extruder-content').slideDown( opt.slideTimer);
				if(opt.onExtOpen) opt.onExtOpen();
			}else{
				if(!isIE) $(this).css("opacity",1);
				extruder.find('.ext_wrapper').css({width:""});
				extruder.find('.extruder-content').css({overflowX:"hidden", display:"block"});
				extruder.find('.extruder-content').animate({ width: opt.width}, opt.slideTimer,function(){
					extruder.find(".extruder-container").css({width: opt.width});
				});
				if(opt.onExtOpen) opt.onExtOpen();
			}

			if (c) {
				setTimeout(function(){
					$(document).one("click.extruder"+extruder.get(0).idx,function(){extruder.closeMbExtruder();});
				},100);
			}

		},

		closeMbExtruder:function(){
			var extruder= $(this);
			extruder.removeAttr("isOpened");
			var opt= extruder.get(0).options;
			extruder.removeClass("isOpened");
			$(document).off("click.extruder"+extruder.get(0).idx);
			if(!isIE) extruder.css("opacity",opt.extruderOpacity);
			if(opt.hidePanelsOnClose) extruder.hidePanelsOnClose();
			if (opt.position=="top" || opt.position=="bottom"){
				extruder.find('.extruder-content').slideUp(opt.slideTimer);
				if(opt.onExtClose) opt.onExtClose();
			}else if (opt.position=="left" || opt.position=="right"){
				extruder.find('.extruder-content').css({overflow:"hidden"});
				extruder.find('.extruder-content').animate({ width: 1 }, opt.slideTimer,function(){
					extruder.find('.ext_wrapper').css({width:1});
					extruder.find('.extruder-content').css({overflow:"hidden",display:"none"});
					if(opt.onExtClose) opt.onExtClose();
				});
			}
		}
	};

	jQuery.fn.mb_bringToFront= function(){
		var zi=10;
		$('*').each(function() {
			if($(this).css("position")=="absolute" ||$(this).css("position")=="fixed"){
				var cur = parseInt($(this).css('zIndex'));
				zi = cur > zi ? parseInt($(this).css('zIndex')) : zi;
			}
		});
		$(this).css('zIndex',zi+=1);
		return zi;
	};

	/*
	 * EXTRUDER CONTENT
	 */

	$.fn.setExtruderVoicesAction=function(){
		var extruder=$(this);
		var opt=extruder.get(0).options;
		var voices= $(this).find(".voice");
		voices.each(function(){
			var voice=$(this);
			if ($.metadata){
				$.metadata.setType("class");
				if (voice.metadata().panel) voice.attr("panel",voice.metadata().panel);
				if (voice.metadata().data) voice.attr("data",voice.metadata().data);
				if (voice.metadata().disabled) voice.attr("setDisabled", voice.metadata().disabled);
			}

			if (voice.attr("setDisabled"))
				voice.disableExtruderVoice();

			if (voice.attr("panel") && voice.attr("panel")!="false"){
				voice.append("<span class='settingsBtn'/>");
				voice.find(".settingsBtn").css({opacity:.5});
				voice.find(".settingsBtn").hover(
						function(){
							$(this).css({opacity:1});
						},
						function(){
							$(this).not(".sel").css({opacity:.5});
						}).click(function(){
							if ($(this).parents().hasClass("sel")){
								if(opt.accordionPanels)
									extruder.hidePanelsOnClose();
								else
									$(this).closePanel();
								return;
							}

							if(opt.accordionPanels){
								extruder.find(".optionsPanel").slideUp(400,function(){$(this).remove();});
								voices.removeClass("sel");
								voices.find(".settingsBtn").removeClass("sel").css({opacity:.5});
							}
							var content=$("<div class='optionsPanel'></div>");
							voice.after(content);
							$.ajax({
								type: "GET",
								url: voice.attr("panel"),
								data: voice.attr("data"),
								async:true,
								dataType:"html",
								success: function(html){
									var c= $(html);
									content.html(c);
									content.children().not(".text")
											.addClass("panelVoice")
											.click(function(){
												if(opt.closeOnClick)
													extruder.closeMbExtruder();
											});
									content.slideDown(400);
								}
							});
							voice.addClass("sel");
							voice.find(".settingsBtn").addClass("sel").css({opacity:1});
						});
			}

			if (voice.find("a").length==0 && voice.attr("panel")){
				voice.find(".label").not(".disabled").css("cursor","pointer").click(function(){
					voice.find(".settingsBtn").click();
				});
			}

			if ((!voice.attr("panel") || voice.attr("panel")=="false" ) && (!voice.attr("setDisabled") || voice.attr("setDisabled")!="true")){
				voice.find(".label").click(function(){
					extruder.hidePanelsOnClose();
					if(opt.closeOnClick)
						extruder.closeMbExtruder();
				});
			}
		});
	};

	$.fn.disableExtruderVoice=function(){
		var voice=$(this);
		var label = voice.find(".label");
		voice.removeClass("sel");
		voice.next(".optionsPanel").slideUp(400,function(){$(this).remove();});
		voice.attr("setDisabled",true);
		label.css("opacity",.4);
		voice.hover(function(){$(this).removeClass("hover");},function(){$(this).removeClass("hover");});
		label.addClass("disabled").css("cursor","default");
		voice.find(".settingsBtn").hide();
		voice.on("click",function(event){
			event.stopPropagation();
			return false;
		});
	};

	$.fn.enableExtruderVoice=function(){
		var voice=$(this);
		voice.attr("setDisabled",false);
		voice.find(".label").css("opacity",1);
		voice.find(".label").removeClass("disabled").css("cursor","pointer");
		voice.off("click");
		voice.find(".settingsBtn").show();
	};

	$.fn.hidePanelsOnClose=function(){
		var voices= $(this).find(".voice");
		$(this).find(".optionsPanel").slideUp(400,function(){$(this).remove();});
		voices.removeClass("sel");
		voices.find(".settingsBtn").removeClass("sel").css("opacity",.5);
	};

	$.fn.openPanel=function(){
		var voice=$(this).hasClass("voice") ? $(this) : $(this).find(".voice");
		voice.each(function(){
			if($(this).hasClass("sel")) return;
			$(this).find(".settingsBtn").click();
		})
	};

	$.fn.closePanel=function(){
		var voice=$(this).hasClass("voice") ? $(this) : $(this).parent(".voice");
		voice.next(".optionsPanel").slideUp(400,function(){$(this).remove();});
		voice.removeClass("sel");
		$(this).removeClass("sel").css("opacity",.5);
	};

	$.fn.buildMbExtruder=$.mbExtruder.buildMbExtruder;
	$.fn.setMbExtruderContent=$.mbExtruder.setMbExtruderContent;
	$.fn.closeMbExtruder=$.mbExtruder.closeMbExtruder;
	$.fn.openMbExtruder=$.mbExtruder.openMbExtruder;
	$.fn.adjustSize=$.mbExtruder.adjustSize;

})(jQuery);
