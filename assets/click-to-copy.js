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

	function showCopied( button, textEl, originalText, copiedLabel ) {
		button.classList.add( 'ctcew-button--copied' );
		textEl.textContent = copiedLabel;

		/* Swap icon to checkmark */
		var iconEl = button.querySelector( '.ctcew-button__icon' );
		var savedIcon = '';
		var savedClass = '';

		if ( iconEl ) {
			if ( iconEl.tagName === 'svg' || iconEl.tagName === 'SVG' ) {
				savedIcon = iconEl.innerHTML;
				iconEl.innerHTML = '<path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>';
			} else {
				savedClass = iconEl.className;
				iconEl.className = 'ctcew-button__icon fas fa-check';
			}
		}

		/* Restore after 1500ms */
		clearTimeout( button._ctcewT );
		button._ctcewT = setTimeout( function () {
			button.classList.remove( 'ctcew-button--copied' );
			textEl.textContent = originalText;

			if ( iconEl ) {
				if ( savedIcon ) {
					iconEl.innerHTML = savedIcon;
				} else if ( savedClass ) {
					iconEl.className = savedClass;
				}
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

		var couponCode = textEl.textContent.trim();
		if ( ! couponCode ) {
			return;
		}

		var copiedLabel = button.getAttribute( 'data-copied-text' ) || 'Copied!';

		/* Try modern Clipboard API with promise, fallback sync */
		if ( navigator.clipboard && navigator.clipboard.writeText && window.isSecureContext ) {
			navigator.clipboard.writeText( couponCode ).then(
				function () {
					showCopied( button, textEl, couponCode, copiedLabel );
				},
				function () {
					/* Modern API rejected — use sync fallback */
					fallbackCopy( couponCode );
					showCopied( button, textEl, couponCode, copiedLabel );
				}
			);
		} else {
			/* No modern API — sync fallback (HTTP sites, older browsers) */
			fallbackCopy( couponCode );
			showCopied( button, textEl, couponCode, copiedLabel );
		}

		/* Open link if configured */
		var href = button.getAttribute( 'data-href' );
		if ( href ) {
			var target = button.getAttribute( 'data-target' ) || '_self';
			window.open( href, target );
		}

	} );

} )();
