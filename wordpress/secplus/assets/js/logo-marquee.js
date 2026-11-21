/**
 * SecPlus client logo strip: turns `.sp-logo-marquee` rows into a seamless,
 * auto-scrolling marquee. Pauses on hover, keyboard focus or the pause button,
 * and stays static for visitors who prefer reduced motion.
 */
( function () {
	var reduce = window.matchMedia && window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;
	var PAUSE = '<svg viewBox="0 0 24 24" width="14" height="14" aria-hidden="true" focusable="false"><path fill="currentColor" d="M7 5h3.5v14H7zM13.5 5H17v14h-3.5z"/></svg>';
	var PLAY = '<svg viewBox="0 0 24 24" width="14" height="14" aria-hidden="true" focusable="false"><path fill="currentColor" d="M8 5v14l11-7z"/></svg>';

	function init( track ) {
		if ( track.getAttribute( 'data-sp-ready' ) ) {
			return;
		}
		track.setAttribute( 'data-sp-ready', '1' );
		var items = Array.prototype.slice.call( track.children );
		if ( items.length < 2 ) {
			return;
		}

		var wrap = document.createElement( 'div' );
		wrap.className = 'sp-marquee';
		track.parentNode.insertBefore( wrap, track );
		wrap.appendChild( track );

		if ( reduce ) {
			wrap.classList.add( 'is-static' );
			return;
		}

		// Second copy for a seamless loop; hidden from assistive technology.
		items.forEach( function ( el ) {
			var copy = el.cloneNode( true );
			copy.setAttribute( 'aria-hidden', 'true' );
			Array.prototype.forEach.call( copy.querySelectorAll( 'img' ), function ( img ) {
				img.alt = '';
				img.removeAttribute( 'loading' );
			} );
			Array.prototype.forEach.call( copy.querySelectorAll( 'a' ), function ( a ) {
				a.setAttribute( 'tabindex', '-1' );
			} );
			track.appendChild( copy );
		} );
		Array.prototype.forEach.call( track.querySelectorAll( 'img' ), function ( img ) {
			img.removeAttribute( 'loading' );
		} );

		var button = document.createElement( 'button' );
		button.type = 'button';
		button.className = 'sp-marquee__toggle';
		function setState( paused ) {
			wrap.classList.toggle( 'is-paused', paused );
			button.setAttribute( 'aria-pressed', paused ? 'true' : 'false' );
			button.setAttribute( 'aria-label', paused ? 'Play logo animation' : 'Pause logo animation' );
			button.innerHTML = paused ? PLAY : PAUSE;
		}
		button.addEventListener( 'click', function () {
			setState( ! wrap.classList.contains( 'is-paused' ) );
		} );
		setState( false );
		wrap.appendChild( button );

		// Constant speed (about 40px per second) whatever the number of logos.
		function setSpeed() {
			var half = track.scrollWidth / 2;
			track.style.setProperty( '--sp-marquee-duration', Math.max( 20, Math.round( half / 40 ) ) + 's' );
		}
		setSpeed();
		window.addEventListener( 'load', setSpeed );
		window.addEventListener( 'resize', setSpeed );
		wrap.classList.add( 'is-animated' );

		// Stop the loop while it is off screen.
		if ( 'IntersectionObserver' in window ) {
			new IntersectionObserver( function ( entries ) {
				entries.forEach( function ( entry ) {
					wrap.classList.toggle( 'is-offscreen', ! entry.isIntersecting );
				} );
			} ).observe( wrap );
		}
	}

	function run() {
		Array.prototype.forEach.call( document.querySelectorAll( '.sp-logo-marquee' ), init );
	}
	if ( document.readyState === 'loading' ) {
		document.addEventListener( 'DOMContentLoaded', run );
	} else {
		run();
	}
}() );
