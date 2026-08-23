# Click to Copy Button Elementor Widget

Make it effortlessly easy for your website visitors to copy coupon codes, wallet addresses, API keys, or referral links with a single click. The **Click to Copy Button Elementor Widget** is a lightweight, beautifully stylable WordPress plugin designed specifically for modern Elementor websites.

## 🚀 Why Choose This Copy Button?

Have you ever used a "copy to clipboard" button that just... didn't work on your phone? 

Most copy-to-clipboard plugins rely entirely on modern browser APIs. While great in theory, they frequently fail silently on restrictive devices or older browsers, leaving your users frustrated. 

**We fixed that.** This widget is engineered with a robust fallback mechanism. If the modern clipboard API isn't available or gets blocked, the widget seamlessly falls back to a battle-tested legacy method. The result? **100% reliable copying across all browsers and devices**, ensuring you never lose a sale or lead due to a broken coupon code.

## ✨ Key Features

- **Reliable 1-Click Copy:** Bulletproof cross-browser compatibility (no more silent copy failures).
- **Elementor Dynamic Tags Support:** Pull copy text dynamically from ACF fields, WooCommerce products, post titles, or user data.
- **Custom "Copied" State:** Give instant, satisfying visual feedback! Change the button's background, border, text color, and icon the moment a user clicks.
- **Dual Icon Support:** Choose a normal icon (like a clipboard) and a distinct "Copied" icon (like a checkmark) from the Elementor Icon Library.
- **Full Design Freedom:** Style typography, gradients, borders, box shadows, and padding directly inside the Elementor editor.
- **SEO & Accessibility Friendly:** Clean HTML output, screen-reader polite announcements (`aria-live`), and fully keyboard accessible.
- **Lightweight & Fast:** Zero bloat. The tiny CSS and JS files only load when the widget is actually used on the page.

---

## 🛠️ How to Use It

1. Open any page in the **Elementor Editor**.
2. Search for **"Click to Copy Button"** in your widgets panel.
3. Drag and drop the widget onto your canvas.
4. **Content Tab:** Enter the text you want users to copy (e.g., `SAVE20`) and set your icons.
5. **Style Tab:** Customize the colors and typography for both the Normal state and the "Copied!" state to perfectly match your brand.

*Pro Tip: Add an optional redirect link in the Content tab if you want to send users to a checkout or affiliate page immediately after they copy the code!*

---

## 📦 Installation

**From the WordPress Dashboard:**
1. Download the plugin `.zip` file.
2. Go to **Plugins → Add New → Upload Plugin**.
3. Upload the `.zip` file and click **Install Now**.
4. Click **Activate**.

**Manual Installation:**
1. Unzip the downloaded file.
2. Upload the `click-to-copy-button-elementor-widget` folder to your `/wp-content/plugins/` directory.
3. Activate the plugin through the **Plugins** menu in WordPress.

---

## 📝 Changelog

### Version 1.1.0 (Latest)
- **New Feature:** Added a dedicated "Copied Icon" picker. You can now seamlessly swap icons (e.g., from a Copy icon to a Checkmark) upon clicking.
- **New Feature:** Introduced a "Copied State" styling section! You can now independently style the button's background, text color, border color, and icon size when it is in the copied state.
- **Optimization:** Completely rebuilt the icon rendering engine. Icons now toggle via pure CSS, eliminating JavaScript layout thrashing and guaranteeing flawless compatibility with Elementor's Inline Font Awesome SVG feature.
- **Optimization:** Added strict cache-busting to ensure visitors always get the latest scripts and styles after you update the plugin.
- **Fix:** Removed hardcoded hover overrides that previously interfered with custom Elementor styles.
- **Fix:** Improved icon spacing and positioning controls so they work flawlessly even if you only use a copied icon.

### Version 1.0.5
- **Fix:** Resolved a critical clipboard fallback bug to ensure reliable copying on iOS Safari.
- **Fix:** Fixed an issue preventing scripts from running properly inside Elementor Loop Grids.
- **Update:** Added automatic asset cache clearing when the plugin is deactivated or deleted.

### Version 1.0.3
- Removed hardcoded default colors, allowing the button to inherit your active theme styles immediately.
- Minor UI improvements in the Elementor control panel.

### Version 1.0.1 - 1.0.2
- Added optional Link redirect field.
- Added Dynamic Tags support.
- Accessibility and markup improvements.

### Version 1.0.0
- Initial release. 

---

## ⚖️ License & Credits

This project is licensed under the **GNU General Public License v2.0** (or later). 

Created and maintained by **Tanzim Ahmed**.  
[View on GitHub](https://github.com/mr-tanzim-ahmed/click-to-copy-button-elementor-widget)
