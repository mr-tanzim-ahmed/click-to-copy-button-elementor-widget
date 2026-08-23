/**
 * Click to Copy Button — frontend behavior.
 *
 * Zero async/await — maximum compatibility with WordPress
 * script optimizers, concatenators, and older environments.
 * Uses event delegation for Elementor Loop support.
 */
( function () {

	/* Prevent duplicate listeners if loaded twice */
	if ( window._ctcew_v2 ) {
		return;
	}
	window._ctcew_v2 = true;

	/* =====================================================
	   FALLBACK COPY (sync — works on HTTP, iOS, etc.)
	   ===================================================== */

	function fallbackCopy( text ) {
		var textarea = document.createElement( 'textarea' );
		textarea.value = text;
		textarea.style.position = 'fixed';
		textarea.style.opacity = '0';
		document.body.appendChild( textarea );
		textarea.focus();
		textarea.select();
		textarea.setSelectionRange( 0, textarea.value.length );
		document.execCommand( 'copy' );
		textarea.remove();
	}

	/* =====================================================
	   SHOW "COPIED" STATE
	   ===================================================== */

	function showCopied( button, textEl, originalLabel, copiedLabel ) {
		button.classList.add( 'ctcew-button--copied' );
		textEl.textContent = copiedLabel;

		var normalIcon = button.querySelector( '.ctcew-button__normal-icon' );
		var copiedIcon = button.querySelector( '.ctcew-button__copied-icon' );
		
		if ( normalIcon ) {
			normalIcon.style.setProperty('display', 'none', 'important');
		}
		if ( copiedIcon ) {
			copiedIcon.style.setProperty('display', 'inline-flex', 'important');
		}

		/* Restore after 1500ms */
		clearTimeout( button._ctcewT );
		button._ctcewT = setTimeout( function () {
			button.classList.remove( 'ctcew-button--copied' );
			textEl.textContent = originalLabel;
			
			if ( normalIcon ) {
				normalIcon.style.removeProperty('display');
			}
			if ( copiedIcon ) {
				copiedIcon.style.setProperty('display', 'none', 'important');
			}
		}, 1500 );
	}

	/* =====================================================
	   CLICK HANDLER
	   ===================================================== */

	document.addEventListener( 'click', function ( event ) {

		var button = event.target.closest( '.ctcew-button' );
		if ( ! button ) {
			return;
		}

		var textEl = button.querySelector( '.ctcew-button__text' );
		if ( ! textEl ) {
			return;
		}
		
		// Safely store original text to handle rapid double-clicks
		if ( ! textEl.hasAttribute('data-orig-text') ) {
			textEl.setAttribute('data-orig-text', textEl.textContent.trim());
		}
		var originalLabel = textEl.getAttribute('data-orig-text');

		var couponCode = button.getAttribute( 'data-code' );
		if ( ! couponCode ) {
			couponCode = originalLabel;
		}
		if ( ! couponCode ) {
			return;
		}

		var copiedLabel = button.getAttribute( 'data-copied-text' ) || 'Copied!';

		/* Try modern Clipboard API with promise, fallback sync */
		if ( navigator.clipboard && navigator.clipboard.writeText && window.isSecureContext ) {
			navigator.clipboard.writeText( couponCode ).then(
				function () {
					showCopied( button, textEl, originalLabel, copiedLabel );
				},
				function () {
					/* Modern API rejected — use sync fallback */
					fallbackCopy( couponCode );
					showCopied( button, textEl, originalLabel, copiedLabel );
				}
			);
		} else {
			/* No modern API — sync fallback (HTTP sites, older browsers) */
			fallbackCopy( couponCode );
			showCopied( button, textEl, originalLabel, copiedLabel );
		}

		/* Open link if configured */
		var href = button.getAttribute( 'data-href' );
		if ( href ) {
			var target = button.getAttribute( 'data-target' ) || '_self';
			window.open( href, target );
		}

	} );

} )();
