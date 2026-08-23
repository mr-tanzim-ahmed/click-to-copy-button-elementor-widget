/**
 * Click to Copy Button — frontend behavior.
 */
( function () {
	if ( window.__ctcewInitialized ) {
		return;
	}
	window.__ctcewInitialized = true;

	document.addEventListener( 'click', async function ( event ) {
		const button = event.target.closest( '.ctcew-button' );
		if ( ! button ) {
			return;
		}

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

		try {
			// Modern approach
			await navigator.clipboard.writeText( textToCopy );
			updateUI( copiedLabel );
		} catch ( error ) {
			// Fallback for browsers where Clipboard API is unavailable
			const textarea = document.createElement( 'textarea' );
			textarea.value = textToCopy;
			textarea.style.position = 'fixed';
			textarea.style.opacity = '0';

			document.body.appendChild( textarea );
			textarea.select();
			document.execCommand( 'copy' );
			textarea.remove();

			updateUI( copiedLabel );
		}
	} );
} )();
