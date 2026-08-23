# Click to Copy Button Elementor Widget

A lightweight Elementor widget that lets visitors copy coupon codes, referral links, API keys, wallet addresses, and other short text with a single click or tap.

Designed with **cross-browser compatibility**, including a tested workaround for **Safari and iOS**, where the Clipboard API alone is often unreliable.

---

## Features

- 📋 One-click copy to clipboard
- 📱 Reliable copying on **iPhone & Safari**
- 🎨 Full Elementor Style controls
- 🔤 Typography and Text Shadow controls
- 🎨 Background (Solid & Gradient)
- 🟦 Border Type, Width, Color & Radius
- 🌟 Box Shadow support
- 📏 Padding controls
- 🖱️ Separate **Normal** and **Hover** styling
- ✅ **Copied State** styling (text/icon color, background, border, icon size)
- 🔗 Optional Link field (copy first, then redirect)
- ⭐ Elementor Icon Library support
- 🔄 **Separate Copied Icon** — choose a different icon for the copied state
- 🔄 Adjustable icon position and spacing
- 🏷️ Dynamic Tags support
- 🌿 ACF Dynamic Tags support (Elementor Pro)
- ♿ Accessible (`aria-label`, `aria-live`, keyboard focus)
- ⚡ Lightweight (single shared CSS & JS loaded once)

---

## Requirements

| Requirement | Version |
|------------|---------|
| WordPress | 6.0+ |
| Tested up to | 6.6 |
| PHP | 7.4+ |
| Elementor | Latest Recommended |

---

## Installation

### Method 1 — Upload Plugin

1. Download the plugin ZIP.
2. Go to **WordPress Dashboard → Plugins → Add New**.
3. Click **Upload Plugin**.
4. Upload the ZIP file.
5. Activate the plugin.
6. Make sure **Elementor** is installed and activated.

### Method 2 — Manual Installation

Upload the plugin folder to:

```
wp-content/plugins/click-to-copy-button-elementor-widget
```

Then activate it from:

```
Dashboard → Plugins
```

---

## Usage

1. Edit a page with Elementor.
2. Search for:

```
Click to Copy Button
```

3. Drag the widget onto your page.
4. Enter the text visitors should copy.
5. Customize the button appearance using Elementor's Style panel.
6. (Optional) Add a destination link to redirect users after copying.

---

## Widget Settings

### Content

- Text to Copy
- Text After Copying
- Optional Link (with Open in New Window support)
- Icon (from Elementor Icon Library)
- Copied Icon (separate icon shown after copying)
- Icon Position (Before / After)
- Icon Spacing
- Button ID

### Style — Button

#### Text

- Typography
- Text & Icon Color
- Text Shadow

#### Background

- Solid
- Gradient

#### Border

- Border Type
- Border Width
- Border Color
- Border Radius

#### Shadow

- Box Shadow

#### Icon

- Icon Size

#### Layout

- Padding
- Alignment (Left / Center / Right / Justified)

#### States

- Normal (Text & Icon Color, Background, Border Color)
- Hover (Text & Icon Color, Background, Border Color, Transition Duration)

### Style — Copied State

- Text & Icon Color
- Background (Solid / Gradient)
- Border Color
- Copied Icon Size

---

## Dynamic Tags

Supports Elementor Dynamic Tags for:

- Copy Text
- Copied Message
- Optional Link

When Elementor Pro is installed, ACF Dynamic Tags are also supported.

---

## Browser Compatibility

Tested on:

- ✅ Chrome
- ✅ Edge
- ✅ Firefox
- ✅ Safari
- ✅ iOS Safari
- ✅ Android Chrome

Unlike many clipboard plugins, this widget includes an iOS-friendly fallback to improve copy reliability on Safari.

---

## Accessibility

The widget includes:

- `aria-label`
- `aria-live`
- Keyboard focus styles
- Semantic button markup

---

## Changelog

<<<<<<< HEAD
### Version 1.1.0

- **New**: Copied Icon — choose a separate icon (from Elementor Icon Library) to display during the "Copied!" state. Defaults to a checkmark (fas fa-check).
- **New**: Copied State style section — customize text/icon color, background (solid/gradient), border color, and icon size independently for the copied state.
- **New**: Icon visibility is now handled via pure CSS class toggling (`ctcew-button--copied`), making the transition instantaneous and reliable across all browsers.
- **Fix**: Copied icon now renders correctly — previous versions used innerHTML cloning which broke Font Awesome's SVG replacement.
- **Fix**: Copied icon renders even when no normal icon is set.
- **Fix**: `overflow: hidden` removed from button — was clipping icons, especially when the copied state icon size was set larger.
- **Fix**: Hover background CSS override removed — `background-color: transparent` in the stylesheet was overriding Elementor's hover background controls.
- **Fix**: Icon Position and Icon Spacing controls now remain visible when only a Copied Icon is set (no normal icon).
- **Fix**: Version number corrected to follow semantic versioning.

=======
>>>>>>> 2e3e6ccc343ed6908fc710b8acd34c6632c8d903
### Version 1.0.5

- **Fix**: Critical clipboard fallback bug resolved. The button now correctly copies text on iOS Safari and older devices using an improved legacy method.
- **Fix**: Resolved an issue where the copy script and styles wouldn't load when placed inside an Elementor Loop template with ACF dynamic tags.
- **Fix**: JS logic completely rewritten to be synchronous and optimizer-friendly, fixing silent failures on some WordPress configurations.
- **Update**: Added automatic cache clearing (Elementor, WP Rocket, LiteSpeed, etc.) upon plugin deactivation or deletion to prevent stale layout issues.
- **Update**: Improved default styling with a responsive layout, a purple gradient, and an animated icon swap (copy to checkmark) upon clicking.
- **UI**: Rearranged Elementor Style panel controls for better usability (Border Type → Border Radius → Box Shadow now uses native Elementor Group Controls).

### Version 1.0.3

- Removed hardcoded default colors.
- Button now inherits the active theme styles until customized.
- Border Type defaults to **None**.
- Increased asset version to avoid browser cache issues.

### Version 1.0.2

- Renamed internal CSS classes.
- Removed Minimum Width control.
- Switched to Elementor `add_render_attribute()` API.
- Added accessibility improvements.
- Improved Elementor live preview compatibility.

### Version 1.0.1

- Added optional Link field.
- Added Icon Library support.
- Added Button ID.
- Added Normal/Hover styling.
- Added Dynamic Tags support.

### Version 1.0.0

- Initial release.

---

## Frequently Asked Questions

### Does it work on iPhone and Safari?

Yes.

The widget includes an iOS-specific fallback instead of relying solely on the Clipboard API, making copy actions significantly more reliable on Safari.

---

### Does the Link field require Elementor Pro?

No.

The Link field works in the free version of Elementor.

Only ACF Dynamic Tags require Elementor Pro.

---

### Can I copy things other than coupon codes?

Absolutely.

Common use cases include:

- Coupon Codes
- Promo Codes
- Referral Codes
- Affiliate Codes
- Wallet Addresses
- API Keys
- License Keys
- Email Addresses
- Phone Numbers
- Short URLs
- Custom Text

---

## Why this plugin?

Many copy-to-clipboard widgets fail silently on Safari and iOS because they depend only on the modern Clipboard API.

This plugin was built specifically to solve that problem while remaining lightweight, accessible, and fully integrated with Elementor's styling system.

---

## Author

**Tanzim Ahmed**

GitHub:
https://github.com/mr-tanzim-ahmed/click-to-copy-button-elementor-widget
