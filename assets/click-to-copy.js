/**
 * Click to Copy Button — frontend behavior.
 *
 * One listener handles every button on the page via event delegation,
 * so it works no matter how many times the widget is placed, and it
 * only ever runs once even if this file somehow gets enqueued twice.
 */
( function () {
	if ( window.__ctcewInitialized ) {
		return;
	}
	window.__ctcewInitialized = true;

	/**
	 * Copies text using a hidden, temporarily-editable textarea.
	 *
	 * Modern browsers offer navigator.clipboard.writeText(), but it's async,
	 * and on iOS Safari/WebKit an `await` before this fallback runs makes
	 * the browser stop trusting the click as a genuine user gesture — so
	 * the fallback silently fails too. Running this synchronously first,
	 * with no `await` in front of it, is what actually makes copying work
	 * reliably across Chrome, desktop Safari, and iOS.
	 *
	 * WebKit also has a separate quirk: it can reject execCommand('copy')
	 * on a `readonly` textarea's selection even though nothing throws.
	 * Briefly toggling contentEditable works around that.
	 */
	function copyText( value ) {
		var textarea = document.createElement( 'textarea' );
		textarea.value = value;
		textarea.style.position = 'fixed';
		textarea.style.top = '0';
		textarea.style.left = '-9999px';
		textarea.style.fontSize = '16px'; // Prevents an unwanted zoom-in on iOS.
		document.body.appendChild( textarea );

		var wasEditable = textarea.contentEditable;
		var wasReadOnly = textarea.readOnly;
		textarea.contentEditable = true;
		textarea.readOnly = false;

		var range = document.createRange();
		range.selectNodeContents( textarea );
		var selection = window.getSelection();
		selection.removeAllRanges();
		selection.addRange( range );
		textarea.setSelectionRange( 0, 999999 );

		textarea.contentEditable = wasEditable;
		textarea.readOnly = wasReadOnly;

		var succeeded = false;
		try {
			succeeded = document.execCommand( 'copy' );
		} catch ( error ) {
			succeeded = false;
		}

		selection.removeAllRanges();
		document.body.removeChild( textarea );
		return succeeded;
	}

	/**
	 * Temporarily swaps the button's label (e.g. to "Copied!"), then
	 * restores the original text after a short delay.
	 */
	function showTemporaryLabel( button, label, originalLabel, duration ) {
		var textEl = button.querySelector( '.ctcew-button__text' );
		if ( ! textEl ) {
			return;
		}
		clearTimeout( button._ctcewLabelTimer );
		textEl.textContent = label;
		button._ctcewLabelTimer = setTimeout( function () {
			textEl.textContent = originalLabel;
			button.classList.remove( 'ctcew-button--copied' );
		}, duration || 2000 );
	}

	/**
	 * Opens the button's configured link, if one was set in the
	 * Elementor "Link" field.
	 */
	function openLinkIfPresent( button ) {
		var href = button.dataset.href;
		if ( ! href ) {
			return;
		}
		window.open( href, button.dataset.target || '_self' );
	}

	document.addEventListener( 'click', function ( event ) {
		var button = event.target.closest( '.ctcew-button' );
		if ( ! button ) {
			return;
		}

		var textToCopy = ( button.dataset.code || '' ).trim();
		if ( ! textToCopy ) {
			return;
		}

		var copiedLabel = button.dataset.copiedText || 'Copied!';
		var textEl = button.querySelector( '.ctcew-button__text' );
		var originalLabel = textEl ? textEl.textContent : textToCopy;

		var copied = copyText( textToCopy );

		if ( copied ) {
			button.classList.add( 'ctcew-button--copied' );
			showTemporaryLabel( button, copiedLabel, originalLabel );
			openLinkIfPresent( button );
			return;
		}

		// Fall back to the async Clipboard API only if the sync method failed.
		if ( navigator.clipboard && window.isSecureContext ) {
			navigator.clipboard
				.writeText( textToCopy )
				.then( function () {
					button.classList.add( 'ctcew-button--copied' );
					showTemporaryLabel( button, copiedLabel, originalLabel );
					openLinkIfPresent( button );
				} )
				.catch( function () {
					showTemporaryLabel( button, 'Tap and hold to copy', originalLabel );
					openLinkIfPresent( button );
				} );
		} else {
			showTemporaryLabel( button, 'Tap and hold to copy', originalLabel );
			openLinkIfPresent( button );
		}
	} );
} )();
