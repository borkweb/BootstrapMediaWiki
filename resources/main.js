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
			var $title = $toc.find('.toctitle');
			var $links = $title.siblings('ul').find( 'a' );

			$.each( $links.find( '.tocnumber' ), function() {
				var $el = $( this );
				var numDots = ( $el.text().match( /\./g ) || [] ).length;
				var prefix = '';
				for ( var i = 0; i < numDots; i++ ) {
					prefix += '&nbsp;&nbsp;';
				}

				$el.prepend( prefix );
			} );

			$links.addClass( 'dropdown-item' );

			var toc_html = [
				'<ul class="nav nav-pills float-right bootstrap-toc mt-3">',
					'<li class="nav-item dropdown" id="page-contents">',
						'<a class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">',
							'<i class="icon-list"></i> Contents <span class="caret"></span>',
						'</a>',
						'<ul class="dropdown-menu" aria-labelledby="contentsDropdownButton" style="min-width: ' + $toc.width() + 'px"></ul>',
					'</li>',
				'</ul>'
			];

			$('.page-header').prepend( toc_html.join( ' ' ) );

			$('.page-header #page-contents').find('.dropdown-menu').html( $links );
		});

		if( $('.page-header .nav').length === 0 ) {
			$('.page-header').prepend('<ul class="nav nav-pills float-right"></li></ul>');
		}//end if

		var $header = $('.page-header');
		var $hero = $('.jumbotron');
		var $edit = $('.navbar .content-actions .edit');
		if( $edit.length > 0 ) {
			var $editListItem = $( '<li class="nav-item"/>' );
			$edit.clone().removeClass( 'dropdown-item' ).addClass( 'nav-link' ).prependTo( $editListItem );

			if( $hero.length ) {
				if( ! $hero.find('.nav-pills').length ) {
					$hero.prepend('<ul class="nav nav-pills float-right"></ul>');
				}//end if

				$editListItem.prependTo( $hero.find('.nav-pills') );
			} else {
				$editListItem.prependTo( $header.find('.nav-pills') );
			}//end else
		}//end if
	}//end if

	$('#wiki-body .body a[title="Special:UserLogin"]').click();
	$('.dropdown-toggle').dropdown();
});
