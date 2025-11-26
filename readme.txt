=== ThisWriteOnly ===
Contributors: bobeec
Requires at least: 6.0
Tested up to: 6.7
Requires PHP: 8.0
Stable tag: 1.0.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A minimal WordPress blog theme focused on writing and reading.

== Description ==

ThisWriteOnly is an extremely simple WordPress blog theme that focuses on "writing and reading."

= Features =

* **Minimal Customization** - Display toggle options only, no complex settings
* **Optional Simple Editor Mode** - Enable to limit blocks to essential ones only (opt-in, disabled by default)
* **SEO Ready** - Built-in meta descriptions, Open Graph, Twitter Cards, JSON-LD, canonical URLs, and breadcrumbs with structured data
* **Responsive** - Mobile-first design for optimal reading on any device
* **Accessibility Ready** - Skip links, keyboard navigation, proper heading structure, and link underlines

= Built-in SEO Features =

* Meta description (auto-generated from excerpt)
* Open Graph tags for social sharing
* Twitter Card support
* JSON-LD structured data (Article schema)
* Canonical URL output
* Breadcrumb navigation with Schema.org markup

= Display Options =

Navigate to Appearance > Customize > ThisWriteOnly Settings to configure what to show:

* Header, Site Icon, Site Title, Navigation
* Post Date, Modified Date, Author, Reading Time
* Categories, Tags, Author Box
* Post Navigation, Comments
* Footer Archives (Yearly, Monthly, Categories)
* Breadcrumb

= Editor Options =

* Simple Editor Mode - When enabled, limits available blocks to essentials (paragraph, heading, list, quote, image, etc.)

== Installation ==

1. In your admin panel, go to Appearance > Themes and click the Add New button.
2. Click Upload Theme and Choose File, then select the theme's .zip file. Click Install Now.
3. Click Activate to use your new theme right away.

== Frequently Asked Questions ==

= Why are there so few customization options? =

By design! ThisWriteOnly focuses on content, not design decisions. The typography, spacing, and layout are optimized for the best reading experience.

= Can I limit available blocks in the editor? =

Yes! Go to Appearance > Customize > ThisWriteOnly Settings > Editor Options and enable "Simple Editor Mode". This limits available blocks to essential ones only (paragraph, heading, list, quote, image, etc.). This feature is disabled by default so all blocks are available.

= Does this theme need SEO plugins? =

No. ThisWriteOnly has built-in SEO features including meta descriptions, OGP, Twitter Cards, JSON-LD structured data, canonical URLs, and breadcrumbs. However, for sitemaps, we recommend using the XML Sitemaps plugin.

== Changelog ==

= 1.0.1 =
* Re-submission to WordPress.org

= 1.0.0 =
* Major release for WordPress.org submission
* Renamed theme from BLOGthemeWP to ThisWriteOnly (WordPress trademark compliance)
* Moved all settings to Customizer (WordPress.org recommended approach)
* Made block restriction opt-in via "Simple Editor Mode" (default: OFF)
* Removed dashboard widget
* Updated all function prefixes to thiswriteonly_
* Added Editor Options section in Customizer
* Tested with WordPress 6.7

= 0.4.2 =
* Improved keyboard focus styles for accessibility
* Updated tags (removed accessibility-ready, added custom-logo)
* Updated readme.txt with complete resource licenses

= 0.4.1 =
* Added English (en_US) translation
* Updated POT template file

= 0.4.0 =
* Added breadcrumb navigation with Schema.org structured data
* Added canonical URL output
* Added modified date display option

= 0.3.0 =
* Added footer archive display options (yearly, monthly, category)

= 0.2.3 =
* Fixed comment display error

= 0.2.2 =
* Fixed Theme Check required errors
* Added wp_link_pages support
* Added theme supports: wp-block-styles, align-wide, custom-logo
* Added required CSS classes

= 0.2.1 =
* Fixed display toggle functionality
* Simplified settings to toggle-only system

= 0.1.0 =
* Initial release

== Resources ==

= Google Fonts =
Noto Sans JP
License: SIL Open Font License, 1.1
Source: https://fonts.google.com/specimen/Noto+Sans+JP
License URL: https://scripts.sil.org/cms/scripts/page.php?site_id=nrsi&id=OFL

= Screenshot =
The screenshot image was created by the theme author and is released under GPLv2 or later.

== Copyright ==

ThisWriteOnly WordPress Theme, (C) 2024 bobeec
ThisWriteOnly is distributed under the terms of the GNU GPL v2 or later.

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
