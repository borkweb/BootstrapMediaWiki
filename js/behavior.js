$(function() {
	$('html').removeClass('client-nojs');

	$('#page-contents a').click(function(e){
		e.preventDefault();
		var $target = $(this).attr('href');
		$(document).scrollTop( $($target).offset().top-100 );                                                                                                                                                                                                     
	});

	$( document ).on('change', '#subnav-select', function() {
		window.location = $(this).val();
	});

	$('table')
		.not('#toc')
		.not('.mw-specialpages-table')
		.each(function() {
			var $el = $(this);

			if( $el.closest('form').length == 0 ) {
				if ( $el.hasClass('info-box') ) {
					$el.addClass('table')
						 .addClass('table-bordered');
				} else {
					$el.addClass('table')
						 .addClass('table-striped')
						 .addClass('table-bordered');
				}//end else
			}//end if
		});

	$('pre:not([data-raw="true"])').addClass('prettyprint linenums');
	$('.jumbotron pre').removeClass('prettyprint linenums');

	$('.editButtons').addClass('well');
	$('input[type=submit],input[type=button],input[type=reset]').addClass('btn');
	$('input[type=submit]').addClass('btn-primary');

	$('input[type=checkbox],input[type=radio]').each(function() {
		var $el = $(this);

		var id = $el.attr('id');
		$( 'label[for=' + id + ']' ).each(function() {
			var $label = $(this);
			if( $.trim( $label.text() ) != '' ) {
				$el.prependTo( $label );
			}//end if

			$label.wrap( '<div class="checkbox"/>' );
		});

		$el.closest('label').addClass($el.attr('type'));
	});

	$('.tip').tooltip();
	$('[data-toggle="popover"]').popover();

	if ( $('.toc-sidebar').length > 0 ) {
		if ( 0 === $('#toc').length ) {
			$('.toc-sidebar').remove();
			$('.wiki-body-section').removeClass('col-md-9').addClass('col-md-12');
		} else {
			$('.toc-sidebar').append('<h3>Contents</h3>');
			$('#toc').each(function() {
				$(this).find('ul:first').appendTo( '.toc-sidebar' );
				$(this).remove();
			});

			$('.toc-sidebar').attr('id', 'toc');
		}//end else
	} else {
		$('#toc').each(function() {
			var $toc = $(this);
			var $title = $toc.find('#toctitle');
			var $links = $title.siblings('ul');

			$('.page-header').prepend('<ul class="nav nav-pills pull-right"><li class="dropdown" id="page-contents"><a class="dropdown-toggle" data-toggle="dropdown"><i class="icon-list"></i> Contents <span class="caret"></span></a> <ul class="dropdown-menu"></ul></li></ul>');

			$('.page-header #page-contents').find('.dropdown-menu').html( $links.html() );
		});

		if( $('.page-header .nav').length === 0 ) {
			$('.page-header').prepend('<ul class="nav nav-pills pull-right"></li></ul>');
		}//end if

		var $header = $('.page-header');
		var $hero = $('.hero-unit');
		var $edit = $('.navbar .content-actions .edit');
		if( $edit.length > 0 ) {
			if( $hero.length ) {
				if( ! $hero.find('.nav-pills').length ) {
					$hero.prepend('<ul class="nav nav-pills pull-right"></ul>');
				}//end if

				$edit.closest('li').clone().prependTo( $hero.find('.nav-pills') );
			} else {
				$edit.closest('li').clone().prependTo( $header.find('.nav-pills') );
			}//end else
		}//end if
	}//end if

	prettyPrint();

	$('#wiki-body .body a[title="Special:UserLogin"]').click();
	$('.dropdown-toggle').dropdown();
});
