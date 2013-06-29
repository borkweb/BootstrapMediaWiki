/**
 * Vector-specific scripts
 */
jQuery( function ( $ ) {
	// custom stuff
	var $dirs = $('.mud-dir');

	$dirs.find('.toggle').click( function( e ) {
		$(this).closest('.mud-dir').toggleClass('show-long');
	});

	if ( false && ! $dirs.find('.reverse-short').length ) {
		var opposites = {
			n: 's',
			s: 'n',
			e: 'w',
			w: 'e',
			u: 'd',
			d: 'u',
			nw: 'se',
			ne: 'sw',
			se: 'nw',
			sw: 'ne',
			in: 'out',
			out: 'in',
			climb: 'd',
			enter: 'leave',
			xmen: 'eternal'
		};

		var dirs = $dirs.find('.short').html();
		var short_dirs = [];
		var long_dirs = [];

		if ( /^From/.test( dirs ) ) {
			console.log( 'here' );
			dirs = $.trim( dirs.replace( /^From [^:]/, '' ) );
		}//end if

		dirs = dirs.split( ',' );

		for ( var i in dirs ) {
			dirs[ i ] = $.trim( dirs[ i ] );
			matches = dirs[ i ].match(/([0-9]+)?(.+)/);
			if ( typeof opposites[ matches[2] ] != 'undefined' ) {
				short_dirs.push( ( matches[1] || '' ) + matches[2] );
			} else {
				short_dirs.push( ( matches[1] || '' ) + '?' );
			}//end else

			matches = dirs[ i ].match( /^([0-9]+)(n|s|e|w|u|d|nw|ne|sw|se|out|in|climb|jump|enter|leave)$/ );

			if ( matches[1] ) {
				for ( var index = 0; index < parseInt( matches[1], 10 ); index++ ) {
					long_dirs.push( typeof opposites[ matches[2] ] != 'undefined' ? opposites[ matches[2] ] : '?' );
				}//end for
			} else {
				long_dirs.push( ( typeof opposites[ dirs[ i ] ] != 'undefined' ? opposites[ dirs[ i ] ] : '?' ) );
			}//end else
		}//end for

		$dirs.append( '<div class="reverse-short">' + short_dirs.join( ', ' ) + '</div>' );
		$dirs.append( '<div class="reverse-long">' + long_dirs.join( ', ' ) + '</div>' );
	}//end if
	else {
		$dirs.find('.reverse').hide();
	}

	$dirs.find('.reverse').click( function( e ) {
		e.stopPropagation();

		$(this).closest('.mud-dir').toggleClass('show-reverse');
	});
} );
