/**
 * SecPlus motion: scroll-triggered sequences that express the corporate
 * lifecycle (Establish -> Maintain -> Govern -> Advance), list entrances,
 * the How We Work progress rail and the header scroll state.
 *
 * Content is visible by default. The inline head script adds `sp-js` (only when
 * motion is allowed); this file marks the page ready and reveals elements as
 * they enter the viewport. Reduced-motion visitors keep the static page.
 */
( function () {
	var root = document.documentElement;
	var reduce = window.matchMedia && window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;
	var each = function ( list, fn ) {
		Array.prototype.forEach.call( list, fn );
	};

	// Header state: soft shadow once the page has scrolled (state feedback, kept for everyone).
	var header = document.querySelector( '.sp-site-header' );
	if ( header ) {
		var ticking = false;
		var update = function () {
			header.classList.toggle( 'is-scrolled', window.scrollY > 8 );
			ticking = false;
		};
		update();
		window.addEventListener( 'scroll', function () {
			if ( ! ticking ) {
				ticking = true;
				window.requestAnimationFrame( update );
			}
		}, { passive: true } );
	}

	if ( reduce || ! root.classList.contains( 'sp-js' ) || ! ( 'IntersectionObserver' in window ) ) {
		root.classList.remove( 'sp-js' );
		return;
	}

	// One-shot reveal: add `is-in` when an element is sufficiently visible.
	var once = new IntersectionObserver( function ( entries ) {
		entries.forEach( function ( entry ) {
			if ( entry.isIntersecting ) {
				entry.target.classList.add( 'is-in' );
				once.unobserve( entry.target );
			}
		} );
	}, { threshold: 0.2, rootMargin: '0px 0px -8% 0px' } );

	// Lists that appear as lists: children rise in with a capped stagger.
	var LISTS = [
		'.sp-audiences .sp-card-grid',
		'.sp-audience-hub .sp-card-grid',
		'.sp-services-grid',
		'.sp-latest .wp-block-post-template',
		'.sp-post-grid',
		'div.sp-topics'
	].join( ',' );
	each( document.querySelectorAll( LISTS ), function ( list ) {
		each( list.children, function ( el, i ) {
			el.classList.add( 'sp-rise' );
			el.style.setProperty( '--sp-i', Math.min( i, 5 ) );
		} );
		once.observe( list );
	} );

	// Lifecycle sequences: routes panel, process steps, services lifecycle.
	each( document.querySelectorAll( '.sp-routes, .sp-steps, .sp-lifecycle__grid' ), function ( seq ) {
		var items = seq.querySelectorAll( '.sp-route-card, .sp-step, .sp-stage' );
		each( items, function ( el, i ) {
			el.style.setProperty( '--sp-i', i );
		} );
		seq.classList.add( 'sp-seq' );
		once.observe( seq );
	} );

	// Single reveals.
	each( document.querySelectorAll( '.sp-about__img, .sp-page-hero .sp-hero-card' ), function ( el ) {
		once.observe( el );
	} );

	// Ambient brand marks on the CTA panel: only animate while on screen.
	var live = new IntersectionObserver( function ( entries ) {
		entries.forEach( function ( entry ) {
			entry.target.classList.toggle( 'is-live', entry.isIntersecting );
		} );
	} );
	each( document.querySelectorAll( '.sp-cta' ), function ( el ) {
		live.observe( el );
	} );

	// How We Work: a vertical rail that fills to the last stage reached.
	each( document.querySelectorAll( '.sp-timeline' ), function ( timeline ) {
		var items = Array.prototype.slice.call( timeline.querySelectorAll( '.sp-timeline__item' ) );
		if ( items.length < 2 ) {
			return;
		}
		var dotY = function ( item ) {
			return item.offsetTop + 34;
		};
		var layout = function () {
			var top = dotY( items[ 0 ] );
			timeline.style.setProperty( '--sp-rail-top', top + 'px' );
			timeline.style.setProperty( '--sp-rail-h', ( dotY( items[ items.length - 1 ] ) - top ) + 'px' );
		};
		var progress = function () {
			var reached = items.filter( function ( item ) {
				return item.classList.contains( 'is-reached' );
			} );
			if ( ! reached.length ) {
				timeline.style.setProperty( '--sp-progress', 0 );
				return;
			}
			var top = dotY( items[ 0 ] );
			var span = dotY( items[ items.length - 1 ] ) - top || 1;
			timeline.style.setProperty( '--sp-progress', ( dotY( reached[ reached.length - 1 ] ) - top ) / span );
		};
		layout();
		progress();
		timeline.classList.add( 'sp-rail' );
		var railObserver = new IntersectionObserver( function ( entries ) {
			entries.forEach( function ( entry ) {
				// Reached once its marker passes 60% of the viewport height; un-reached when scrolled back above.
				entry.target.classList.toggle( 'is-reached', entry.isIntersecting || entry.boundingClientRect.top < 0 );
			} );
			progress();
		}, { rootMargin: '0px 0px -40% 0px' } );
		items.forEach( function ( item ) {
			railObserver.observe( item );
		} );
		window.addEventListener( 'resize', function () {
			layout();
			progress();
		} );
	} );

	root.classList.add( 'sp-motion-ready' );
}() );
