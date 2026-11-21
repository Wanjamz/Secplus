/**
 * SecPlus chat assistant (front end).
 * A WhatsApp-style FAQ chat: instant, friendly answers from the editable
 * "Chat answers", then a hand-over to an adviser on WhatsApp with the visitor's
 * question pre-filled. Nothing is stored or sent until the visitor taps
 * the WhatsApp (or enquiry) button themselves.
 */
( function () {
	var D = window.secplusChat;
	if ( ! D || ! D.entries || ! D.entries.length ) {
		return;
	}
	var reduce = window.matchMedia && window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;
	var entries = D.entries;
	var asked = {};
	var greeted = false;
	var busy = false;

	var ICON_CHAT = '<svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path fill="currentColor" d="M12 2.2a9.7 9.7 0 0 0-8.4 14.6L2.3 21.7l5-1.3A9.7 9.7 0 1 0 12 2.2Zm0 17.7a8 8 0 0 1-4.1-1.1l-.3-.2-3 .8.8-2.9-.2-.3A8 8 0 1 1 12 19.9Zm4.4-6c-.2-.1-1.4-.7-1.7-.8-.2-.1-.4-.1-.5.1l-.8 1c-.1.2-.3.2-.5.1a6.6 6.6 0 0 1-3.3-2.9c-.2-.4.2-.4.7-1.3.1-.1 0-.3 0-.4l-.8-1.8c-.2-.5-.4-.4-.5-.4h-.5a1 1 0 0 0-.7.3 2.9 2.9 0 0 0-.9 2.2 5.1 5.1 0 0 0 1 2.7 11.6 11.6 0 0 0 4.5 4c1.7.7 2.3.8 3.2.6a2.7 2.7 0 0 0 1.8-1.2 2.2 2.2 0 0 0 .1-1.3c0-.1-.2-.2-.5-.3Z"/></svg>';
	var ICON_CLOSE = '<svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M6 6l12 12M18 6 6 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" fill="none"/></svg>';
	var ICON_SEND = '<svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path fill="currentColor" d="M3.4 20.4 21 12 3.4 3.6 3.4 10l12.6 2-12.6 2z"/></svg>';
	var ICON_PLUS = '<svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M12 5v14M5 12h14" stroke="currentColor" stroke-width="3" stroke-linecap="round" fill="none"/></svg>';

	function el( tag, cls, html ) {
		var n = document.createElement( tag );
		if ( cls ) {
			n.className = cls;
		}
		if ( html ) {
			n.innerHTML = html;
		}
		return n;
	}
	function text( tag, cls, str ) {
		var n = el( tag, cls );
		n.textContent = str;
		return n;
	}
	function time() {
		var d = new Date();
		return ( '0' + d.getHours() ).slice( -2 ) + ':' + ( '0' + d.getMinutes() ).slice( -2 );
	}

	/* ---------- Build the interface ---------- */

	var launcher = el( 'button', 'spc-launcher', ICON_CHAT + '<span class="spc-launcher__label">Chat with us</span>' );
	launcher.type = 'button';
	launcher.setAttribute( 'aria-expanded', 'false' );
	launcher.setAttribute( 'aria-controls', 'spc-panel' );
	launcher.setAttribute( 'aria-label', 'Chat with ' + D.name );

	var panel = el( 'section', 'spc-panel' );
	panel.id = 'spc-panel';
	panel.setAttribute( 'role', 'dialog' );
	panel.setAttribute( 'aria-labelledby', 'spc-title' );
	panel.hidden = true;

	var head = el( 'header', 'spc-head' );
	var avatar = el( 'span', 'spc-avatar', ICON_PLUS );
	var who = el( 'div', 'spc-who' );
	var title = text( 'h2', 'spc-title', D.name );
	title.id = 'spc-title';
	who.appendChild( title );
	who.appendChild( text( 'p', 'spc-status', 'Instant answers · Advisers on WhatsApp' ) );
	var close = el( 'button', 'spc-close', ICON_CLOSE );
	close.type = 'button';
	close.setAttribute( 'aria-label', 'Close chat' );
	head.appendChild( avatar );
	head.appendChild( who );
	head.appendChild( close );

	var log = el( 'div', 'spc-log' );
	log.setAttribute( 'role', 'log' );
	log.setAttribute( 'aria-live', 'polite' );
	log.setAttribute( 'aria-label', 'Conversation' );

	var form = el( 'form', 'spc-form' );
	var input = el( 'input', 'spc-input' );
	input.type = 'text';
	input.setAttribute( 'aria-label', 'Type your question' );
	input.placeholder = 'Type your question…';
	input.maxLength = 300;
	input.autocomplete = 'off';
	var send = el( 'button', 'spc-send', ICON_SEND );
	send.type = 'submit';
	send.setAttribute( 'aria-label', 'Send' );
	form.appendChild( input );
	form.appendChild( send );

	var note = el( 'p', 'spc-note' );
	note.innerHTML = 'General guidance, not legal advice. Please don’t share confidential documents here. <a href="' + D.privacy + '">Privacy</a>';

	panel.appendChild( head );
	panel.appendChild( log );
	panel.appendChild( form );
	panel.appendChild( note );

	var wrap = el( 'div', 'spc' );
	wrap.appendChild( panel );
	wrap.appendChild( launcher );
	document.body.appendChild( wrap );

	/* ---------- Messages ---------- */

	function scrollDown() {
		log.scrollTop = log.scrollHeight;
	}

	function bubble( str, from ) {
		var b = el( 'div', 'spc-msg spc-msg--' + from );
		var lines = String( str ).split( '\n' );
		lines.forEach( function ( line, i ) {
			if ( i ) {
				b.appendChild( document.createElement( 'br' ) );
			}
			b.appendChild( document.createTextNode( line ) );
		} );
		b.appendChild( text( 'span', 'spc-time', time() ) );
		log.appendChild( b );
		scrollDown();
		return b;
	}

	function typing() {
		var t = el( 'div', 'spc-msg spc-msg--bot spc-typing', '<span></span><span></span><span></span>' );
		t.setAttribute( 'aria-label', D.name + ' is typing' );
		log.appendChild( t );
		scrollDown();
		return t;
	}

	function wait( ms ) {
		return new Promise( function ( r ) {
			setTimeout( r, reduce ? Math.min( ms, 150 ) : ms );
		} );
	}

	// Bot says several bubbles in turn, each preceded by a short "typing…".
	function say( parts ) {
		busy = true;
		var chain = Promise.resolve();
		parts.forEach( function ( p ) {
			chain = chain.then( function () {
				var t = typing();
				return wait( Math.max( 450, Math.min( 1300, p.length * 11 ) ) ).then( function () {
					t.remove();
					bubble( p, 'bot' );
				} );
			} );
		} );
		return chain.then( function () {
			busy = false;
		} );
	}

	function handoffUrl( question, entry ) {
		if ( D.whatsapp ) {
			var msg = 'Hi ' + D.name + ', I was on your website and would like help with: ' + question;
			return { href: 'https://wa.me/' + D.whatsapp + '?text=' + encodeURIComponent( msg ), label: 'Chat with an adviser on WhatsApp', wa: true };
		}
		var svc = entry && entry.service ? entry.service : 'not-sure';
		return { href: D.contact + '?service=' + encodeURIComponent( svc ) + '#enquiry', label: 'Send us your question', wa: false };
	}

	function actions( question, entry ) {
		var box = el( 'div', 'spc-actions' );
		if ( entry && entry.link && entry.linkLabel ) {
			var more = text( 'a', 'spc-link', entry.linkLabel );
			more.href = entry.link;
			box.appendChild( more );
		}
		var h = handoffUrl( question, entry );
		var cta = el( 'a', 'spc-handoff' + ( h.wa ? ' is-wa' : '' ), ( h.wa ? ICON_CHAT : '' ) + '<span></span>' );
		cta.lastChild.textContent = h.label;
		cta.href = h.href;
		if ( h.wa ) {
			cta.target = '_blank';
			cta.rel = 'noopener';
		}
		box.appendChild( cta );
		log.appendChild( box );
		scrollDown();
	}

	function chips( list, label ) {
		if ( ! list.length ) {
			return;
		}
		var box = el( 'div', 'spc-chips' );
		box.setAttribute( 'role', 'group' );
		box.setAttribute( 'aria-label', label || 'Suggested questions' );
		list.forEach( function ( e ) {
			var c = text( 'button', 'spc-chip', e.q );
			c.type = 'button';
			c.addEventListener( 'click', function () {
				if ( busy ) {
					return;
				}
				box.remove();
				ask( e.q, e );
			} );
			box.appendChild( c );
		} );
		log.appendChild( box );
		scrollDown();
	}

	function suggestions( current ) {
		var related = entries.filter( function ( e ) {
			return e !== current && ! asked[ e.id ] && current && e.service === current.service;
		} );
		var quick = entries.filter( function ( e ) {
			return e !== current && ! asked[ e.id ] && e.quick && related.indexOf( e ) === -1;
		} );
		return related.slice( 0, 2 ).concat( quick ).slice( 0, 3 );
	}

	/* ---------- Understanding questions ---------- */

	function norm( s ) {
		return ( ' ' + String( s ).toLowerCase().replace( /[’']/g, '' ).replace( /[^a-z0-9]+/g, ' ' ) + ' ' ).replace( /\s+/g, ' ' );
	}
	var STOP = ' a an the i im my me we our is are to of for and or in on do does can how what when where which who with it be about please you your have has need want would like '.split( ' ' );

	function match( q ) {
		var t = norm( q );
		var best = null;
		var bestScore = 0;
		entries.forEach( function ( e ) {
			var score = 0;
			String( e.k ).split( ',' ).forEach( function ( k ) {
				var kk = norm( k ).trim();
				if ( kk && t.indexOf( ' ' + kk + ' ' ) > -1 ) {
					score += 2 * kk.split( ' ' ).length;
				} else if ( kk.length > 5 && t.indexOf( kk ) > -1 ) {
					score += 1;
				}
			} );
			norm( e.q ).trim().split( ' ' ).forEach( function ( w ) {
				if ( w.length > 3 && STOP.indexOf( w ) === -1 && t.indexOf( ' ' + w ) > -1 ) {
					score += 1;
				}
			} );
			if ( score > bestScore ) {
				bestScore = score;
				best = e;
			}
		} );
		return bestScore >= 2 ? best : null;
	}

	// Topics SecPlus does not advise on: be honest and offer an adviser instead of a near-miss answer.
	var OUT_OF_SCOPE = /\b(trade ?marks?|patents?|copyrights?|visas?|immigration|work permits?|tax returns?|vat|paye|payroll|audits?|audited|bookkeeping|litigation|court|lawsuits?|sue|divorce|title deeds?|jobs?|vacanc(y|ies)|internships?|hiring|careers?)\b/;

	function smalltalk( q ) {
		var t = norm( q );
		if ( OUT_OF_SCOPE.test( t ) ) {
			return null;
		}
		if ( /^ (hi|hello|hey|hallo|good (morning|afternoon|evening)|habari|jambo|mambo|niaje)( [a-z]+)? $/.test( t ) ) {
			return [ 'Hello! Great to have you here.', 'What would you like to know? Pick a topic below or just type your question.' ];
		}
		if ( /\b(thanks|thank you|asante|appreciate)\b/.test( t ) ) {
			return [ 'You’re very welcome! Is there anything else I can help with?' ];
		}
		if ( /\b(bye|goodbye|kwaheri|that s all|thats all)\b/.test( t ) ) {
			return [ 'Thanks for stopping by! Whenever you’re ready, our advisers are a message away.' ];
		}
		return null;
	}

	/* ---------- Conversation ---------- */

	function ask( q, entry ) {
		bubble( q, 'user' );
		var small = ! entry && smalltalk( q );
		if ( small ) {
			say( small ).then( function () {
				chips( suggestions( null ) );
			} );
			return;
		}
		if ( ! entry && OUT_OF_SCOPE.test( norm( q ) ) ) {
			say( [
				'Thanks for asking! That’s a little outside what I can answer here.',
				'Our advisers can tell you whether it’s something SecPlus can help with, or point you towards the right specialist.'
			] ).then( function () {
				actions( q, null );
				chips( suggestions( null ) );
			} );
			return;
		}
		var e = entry || match( q );
		if ( e ) {
			asked[ e.id ] = true;
			var parts = String( e.a ).split( /\n\s*\n/ ).map( function ( s ) {
				return s.trim();
			} ).filter( Boolean );
			say( parts ).then( function () {
				actions( e.q, e );
				chips( suggestions( e ), 'More questions' );
			} );
		} else {
			say( [
				'That’s a great question, and one our advisers can answer properly for your situation.',
				D.whatsapp ? 'Tap below to continue on WhatsApp. I’ve added your question so you don’t have to type it again.' : 'Send it to us below and an adviser will get back to you.'
			] ).then( function () {
				actions( q, null );
				chips( suggestions( null ) );
			} );
		}
	}

	function greet() {
		greeted = true;
		say( [
			'Hi there! I’m the ' + D.name + ' assistant.',
			'I can help with questions about registering a company, staying compliant, company secretarial and governance support, or put you in touch with an adviser on WhatsApp.',
			'What can I help you with today?'
		] ).then( function () {
			chips( entries.filter( function ( e ) {
				return e.quick;
			} ), 'Popular topics' );
		} );
	}

	/* ---------- Open / close ---------- */

	function open() {
		panel.hidden = false;
		wrap.classList.add( 'is-open' );
		launcher.setAttribute( 'aria-expanded', 'true' );
		window.requestAnimationFrame( function () {
			panel.classList.add( 'is-visible' );
		} );
		if ( ! greeted ) {
			greet();
		}
		setTimeout( function () {
			input.focus( { preventScroll: true } );
		}, reduce ? 0 : 200 );
	}
	function shut() {
		panel.classList.remove( 'is-visible' );
		wrap.classList.remove( 'is-open' );
		launcher.setAttribute( 'aria-expanded', 'false' );
		setTimeout( function () {
			panel.hidden = true;
		}, reduce ? 0 : 160 );
		launcher.focus();
	}

	launcher.addEventListener( 'click', function () {
		if ( panel.hidden ) {
			open();
		} else {
			shut();
		}
	} );
	close.addEventListener( 'click', shut );
	panel.addEventListener( 'keydown', function ( ev ) {
		if ( ev.key === 'Escape' ) {
			shut();
		}
	} );
	form.addEventListener( 'submit', function ( ev ) {
		ev.preventDefault();
		var q = input.value.trim();
		if ( ! q || busy ) {
			return;
		}
		input.value = '';
		var stale = log.querySelector( '.spc-chips:last-child' );
		if ( stale ) {
			stale.remove();
		}
		ask( q, null );
	} );

	// Any link or button with data-secplus-chat opens the assistant.
	document.addEventListener( 'click', function ( ev ) {
		var t = ev.target.closest && ev.target.closest( '[data-secplus-chat], a[href="#chat"]' );
		if ( t ) {
			ev.preventDefault();
			open();
		}
	} );
}() );
