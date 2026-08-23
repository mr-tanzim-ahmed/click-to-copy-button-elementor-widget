/**
 * Click to Copy Button — frontend behavior.
 */
( function () {
	if ( window.__ctcewInitialized ) {
		return;
	}
	window.__ctcewInitialized = true;

	document.addEventListener( 'click', function ( event ) {
		const button = event.target.closest( '.ctcew-button' );
		if ( ! button ) {
			return;
		}

		// Ensure we parse the code. Using Elementor dynamic tags (like ACF)
		// might inject extra line breaks or spacing.
		const textToCopy = ( button.dataset.code || '' ).trim();
		if ( ! textToCopy ) {
			return;
		}

		const copiedLabel = button.dataset.copiedText || 'Copied!';
		const textEl = button.querySelector( '.ctcew-button__text' );
		const originalLabel = textEl ? textEl.textContent : textToCopy;

		// Helper to update the UI
		const updateUI = ( label ) => {
			if ( textEl ) {
				clearTimeout( button._ctcewLabelTimer );
				textEl.textContent = label;
				
				if ( label === copiedLabel ) {
					button.classList.add( 'ctcew-button--copied' );
				} else {
					button.classList.remove( 'ctcew-button--copied' );
				}

				button._ctcewLabelTimer = setTimeout( () => {
					textEl.textContent = originalLabel;
					button.classList.remove( 'ctcew-button--copied' );
				}, 1500 );
			}

			// Open link if configured
			const href = button.dataset.href;
			if ( href ) {
				window.open( href, button.dataset.target || '_self' );
			}
		};

		// Helper for legacy copy (must be synchronous for iOS Safari / older browsers)
		const executeLegacyCopy = () => {
			const textarea = document.createElement( 'textarea' );
			textarea.value = textToCopy;
			textarea.style.position = 'fixed';
			textarea.style.opacity = '0';
			// Keep it editable so execCommand works on all OSs
			textarea.contentEditable = 'true';
			textarea.readOnly = false;

			document.body.appendChild( textarea );
			
			// textarea.select() fails on iOS Safari, we must use setSelectionRange
			textarea.focus();
			textarea.setSelectionRange( 0, textToCopy.length );
			
			try {
				document.execCommand( 'copy' );
			} catch ( err ) {}
			
			textarea.remove();
			updateUI( copiedLabel );
		};

		// Modern Clipboard API is only available in secure contexts (HTTPS).
		// If it's missing, we MUST use the legacy fallback synchronously before
		// the user gesture is lost.
		if ( navigator.clipboard && navigator.clipboard.writeText ) {
			navigator.clipboard.writeText( textToCopy )
				.then( () => updateUI( copiedLabel ) )
				.catch( () => executeLegacyCopy() ); // Fallback if permission denied
		} else {
			executeLegacyCopy();
		}
	} );
} )();
