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

	prettyPrint();
});
