$(function() {
	$('.dropdown-toggle').dropdown();
	$('table')
		.not('#toc')
		.not('.mw-specialpages-table')
		.each(function() {
			var $el = $(this);

			if( $el.closest('form').length == 0 ) {
				$el.addClass('table')
					 .addClass('table-striped')
					 .addClass('table-bordered');
			}//end if
		});

	$('pre').addClass('prettyprint linenums');

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
		});
		$el.closest('label').addClass($el.attr('type'));
	});

	$('.tip').tooltip();
	$('.pop').popover();

	$('#toc').each(function() {
		var $toc = $(this);
		var $title = $toc.find('#toctitle');
		var $links = $title.siblings('ul');

		$('.page-header').prepend('<ul class="nav nav-pills pull-right"><li class="dropdown" id="page-contents"><a class="dropdown-toggle" href="#"><i class="icon-list"></i> Contents <b class="caret"></b></a> <ul class="dropdown-menu"></ul></li></ul>');

		$('.page-header #page-contents').find('.dropdown-menu').html( $links.html() );

		var $intent = $('#page-contents, .navbar .dropdown');

		$intent
			.on('mouseenter', function(){
				$(this).doTimeout( 'dropdown', 300, 'addClass', 'open' );
			})
			.on('mouseleave', function(){
				$(this).doTimeout( 'dropdown', 500, 'removeClass', 'open' );
			})
			.find('.dropdown-toggle')
			.on('click', function(e){ 
				e.preventDefault(); 
			});
	});

	prettyPrint();
});
