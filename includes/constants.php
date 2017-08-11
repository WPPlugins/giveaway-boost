<?php

if(!defined('ABSPATH')) { exit; }

// Plugin information

if(!defined('GB__PLUGIN__VERSION')) {
	// Plugin version - used for update checks and cache bursting
	define('GB__PLUGIN__VERSION', '1.0.7');
}

if(!defined('GB__PLUGIN__AUTHOR')) {
	// Plugin author - used in update checks
	define('GB__PLUGIN__AUTHOR', 'Giveaway Boost');
}

if(!defined('GB__PLUGIN__DIRPATH')) {
	// Plugin directory path
	define('GB__PLUGIN__DIRPATH', dirname(dirname(__FILE__)));
}

if(!defined('GB__PLUGIN__FILEPATH')) {
	// Plugin file path
	define('GB__PLUGIN__FILEPATH', path_join(GB__PLUGIN__DIRPATH, 'giveaway-boost.php'));
}

if(!defined('GB__PLUGIN__PHP_VERSION_REQUIRED')) {
	// Plugin minimum PHP version required
	define('GB__PLUGIN__PHP_VERSION_REQUIRED', '5.4');
}

// Plugin configuration

if(!defined('GB__CONF__ADDRESS_KEYS')) {
	// A comma separated list of keys to search for in the $_SERVER super global that specify a visitor's IP address
	define('GB__CONF__ADDRESS_KEYS', 'REMOTE_ADDR');
}

if(!defined('GB__CONF__ADDRESS_TRACKING')) {
	// A boolean value indicating whether to enable IP address tracking (default false)
	define('GB__CONF__ADDRESS_TRACKING', false);
}

if(!defined('GB__CONF__MENUICON')) {
	// The string defining the icon for the plugin's top-level menu item
	define('GB__CONF__MENUICON', 'data:image/svg+xml;base64,PHN2ZyBpZD0iMjE0MDNjY2YtZmFkMy00MDA3LWEyYjItNmVlZjM5YjBlNDZhIiBkYXRhLW5hbWU9IkxheWVyIDEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeD0iMHB4IiB5PSIwcHgiIHdpZHRoPSI1MDAiIGhlaWdodD0iNTAwIiB2aWV3Qm94PSIwIDAgNTAwIDUwMCIgZW5hYmxlLWJhY2tncm91bmQ9Im5ldyAwIDAgNTAwIDUwMCI+CiAgPHBhdGggZmlsbD0iIzAwMDAwMCIgc3Ryb2tlPSIjRkZGRkZGIiBzdHJva2UtbWl0ZXJsaW1pdD0iMTAiIGlkPSIzZjM1NzQwYi1iNGFjLTQ4Y2QtYTNlYy0xOGIxM2NmMjU2OTQiIGRhdGEtbmFtZT0iJmx0O0NvbXBvdW5kIFBhdGgmZ3Q7IiBkPSJNMzI2LjgsNDgzLjY2SDQ1NS4xNWExNS4xMSwxNS4xMSwwLDAsMCwxNS4xMS0xNS4xMVYyNTkuMzdoMTQuNjNBMTUuMTEsMTUuMTEsMCwwLDAsNTAwLDI0NC4yNlYxMTMuNDNhMTUuMTEsMTUuMTEsMCwwLDAtMTUuMTEtMTUuMTFINDA0LjdhNjguOCw2OC44LDAsMCwwLDEuNTYtMTEuMjVjMS4xMS0yNS0xMS44LTQ5LjE3LTMyLjktNjEuNy0yMS44Ni0xMy01MC4xOS0xMS44OC03MC40NywyLjc3LTEyLjc4LDkuMjItMjAuNzIsMjIuMjYtMjcuNzIsMzMuNzYtMi41OCw0LjIzLTUuMTQsOC40Ny04LDEyLjQ3QTk3LjU2LDk3LjU2LDAsMCwxLDI1MCw5Mi44OWE5Ny41OSw5Ny41OSwwLDAsMS0xNy4yMi0xOC41MmMtMi44MS00LTUuMzgtOC4yNC04LTEyLjQ3LTctMTEuNS0xNC45NC0yNC41NC0yNy43MS0zMy43Ni0yMC4zLTE0LjY0LTQ4LjYxLTE1Ljc1LTcwLjQ5LTIuNzctMjEuMDksMTIuNTMtMzQsMzYuNzUtMzIuODksNjEuNjlBNjguNzEsNjguNzEsMCwwLDAsOTUuMyw5OC4zMkgxNS4xMUExNS4xMSwxNS4xMSwwLDAsMCwwLDExMy40M1YyNDQuMjZhMTUuMTEsMTUuMTEsMCwwLDAsMTUuMTEsMTUuMTFIMjkuNzRWNDY4LjU1YTE1LjExLDE1LjExLDAsMCwwLDE1LjExLDE1LjExaDI4MlptMTQzLTMwMC4wNnY0NS41NUgzMTcuMjdWMTI4LjU0SDQ2OS43OFpNNDQwLDQ1My40NEgzMTcuMjdWMjU5LjM3SDQ0MFpNMjEyLjk0LDIwMi4zVjEyOC41NGg3NC4xMVYyMjkuMTVIMjEyLjk0Wm03NC4xMSw1Ny4wNlY0NTMuNDRIMjEyLjk0VjI1OS4zN1pNMTUxLjgzLDEyOC41NGgzMC44OVYyMjkuMTVIMzAuMjJWMTI4LjU0SDE1MS44M1pNNjAsMjU5LjM3SDE4Mi43M1Y0NTMuNDRINjBabTIzMi0xNjcuNjJjMy4xOS00LjU0LDYuMTItOS4zMyw5LTE0LjEzLDYtOS45NCwxMS43Ni0xOS4zMiwxOS41OS0yNSwxMC4zNS03LjQ3LDI2LTgsMzcuMzYtMS4zUzM3Ni42OCw3MiwzNzYuMDcsODUuNzJhMzkuNTMsMzkuNTMsMCwwLDEtMi44LDEyLjZIMjg2Ljc0QzI4OC41Myw5Ni4xNywyOTAuMzMsOTQsMjkxLjkzLDkxLjc1Wm0tMTY4LTZjLS42Mi0xMy43NSw2LjY3LTI3LjU2LDE4LjEyLTM0LjM2czI3LTYuMTYsMzcuMzcsMS4yOWM3LjgyLDUuNjQsMTMuNTQsMTUsMTkuNTgsMjUsMi45Miw0LjgsNS44NSw5LjYsOSwxNC4xNCwxLjYxLDIuMjksMy40MSw0LjQyLDUuMiw2LjU3SDEyNi43NEEzOS41MywzOS41MywwLDAsMSwxMjMuOTMsODUuNzJaIi8+Cjwvc3ZnPgo=');
}

if(!defined('GB__CONF__POSITION')) {
	// The position within the admin sidebar to place the top-level plugin menu item
	define('GB__CONF__POSITION', 16);
}

// Cookies

if(!defined('GB__COOKIE_NAME__TRACKING')) {
	// The name of the cookie used for storing tracking information
	define('GB__COOKIE_NAME__TRACKING', 'gb_tracking');
}

// Metadata

/// Entry

if(!defined('GB__DATA_META__ENTRY_CHANCES')) {
	// The meta data key for each entry's associated name
	define('GB__DATA_META__ENTRY_CHANCES', 'gb_entry_chances');
}

if(!defined('GB__DATA_META__ENTRY_SOURCE')) {
	// The meta data key for storing an entry's sources
	define('GB__DATA_META__ENTRY_SOURCE', 'gb_entry_source');
}

if(!defined('GB__DATA_META__ENTRY_TOKEN')) {
	// The meta data key for each entry's associated token
	define('GB__DATA_META__ENTRY_TOKEN', 'gb_entry_token');
}

if(!defined('GB__DATA_META__ENTRY_TRACKING_ADDRESS')) {
	// The meta data key for each entry's associated IP address
	define('GB__DATA_META__ENTRY_TRACKING_ADDRESS', 'gb_entry_tracking_address');
}

if(!defined('GB__DATA_META__ENTRY_TRACKING_EMAIL')) {
	// The meta data key for each entry's associated email address
	define('GB__DATA_META__ENTRY_TRACKING_EMAIL', 'gb_entry_tracking_email');
}

if(!defined('GB__DATA_META__ENTRY_TRACKING_NAME')) {
	// The meta data key for each entry's associated name
	define('GB__DATA_META__ENTRY_TRACKING_NAME', 'gb_entry_tracking_name');
}

if(!defined('GB__DATA_META__ENTRY_TRACKING_REFERRER')) {
	// The meta data key for each entry's associated referrer
	define('GB__DATA_META__ENTRY_TRACKING_REFERRER', 'gb_entry_tracking_referrer');
}

if(!defined('GB__DATA_META__ENTRY_WINNER')) {
	// The meta data key for each entry's associated token
	define('GB__DATA_META__ENTRY_WINNER', 'gb_entry_winner');
}

/// Giveaway

if(!defined('GB__DATA_META__GIVEAWAY_FINISHED')) {
	// The meta data key for each giveaway's settings
	define('GB__DATA_META__GIVEAWAY_FINISHED', 'gb_giveaway_finished');
}

if(!defined('GB__DATA_META__GIVEAWAY_SETTINGS')) {
	// The meta data key for each giveaway's settings
	define('GB__DATA_META__GIVEAWAY_SETTINGS', 'gb_giveaway_settings');
}

// Options

if(!defined('GB__DATA_OPTS__SETTINGS')) {
	// The options key for the plugin's settings (defaults, license key, etc)
	define('GB__DATA_OPTS__SETTINGS', 'gb_settings');
}

// Transients

if(!defined('GB__DATA_TRANS__TEMPLATES')) {
	// The transient key for the plugin's templates
	define('GB__DATA_TRANS__TEMPLATES', sprintf('gb_templates_%s', GB__PLUGIN__VERSION));
}

// Types

if(!defined('GB__DATA_TYPE__GIVEAWAY')) {
	// The post type slug for the Giveaway post type
	define('GB__DATA_TYPE__GIVEAWAY', 'gb_giveaway');
}

if(!defined('GB__DATA_TYPE__ENTRY')) {
	// The post type slug for the Entry post type
	define('GB__DATA_TYPE__ENTRY', 'gb_entry');
}

// Page slugs

if(!defined('GB__PAGE_SLUG__SETTINGS')) {
	// The page slug for the "Giveaways > Settings" page
	define('GB__PAGE_SLUG__SETTINGS', 'gb_settings');
}

// Section slugs

if(!defined('GB__PAGE_SECT__CONTENT')) {
	// The page section slug for the "Giveaways > Settings > Giveaway Content" section
	define('GB__PAGE_SECT__CONTENT', 'gb_settings_content');
}

if(!defined('GB__PAGE_SECT__DEFAULTS')) {
	// The page section slug for the "Giveaways > Settings > Google reCAPTCHA" section
	define('GB__PAGE_SECT__DEFAULTS', 'gb_settings_defaults');
}

if(!defined('GB__PAGE_SECT__RECAPTCHA')) {
	// The page section slug for the "Giveaways > Settings > Google reCAPTCHA" section
	define('GB__PAGE_SECT__RECAPTCHA', 'gb_settings_recaptcha');
}

if(!defined('GB__PAGE_SECT__REWRITES')) {
	// The page section slug for the "Giveaways > Settings > Giveaway URLs" section
	define('GB__PAGE_SECT__REWRITES', 'gb_settings_rewrites');
}

// Actions

/// Admin

if(!defined('GB__ACTION_NAME__ENTRIES_EXPORT')) {
	// The action name key for exporting entries from a giveaway
	define('GB__ACTION_NAME__ENTRIES_EXPORT', 'gb_giveaway_entries_export');
}

if(!defined('GB__ACTION_NAME__ENTRIES_WINNERS')) {
	// The action name key for choosing winners from entries for a giveaway
	define('GB__ACTION_NAME__ENTRIES_WINNERS', 'gb_giveaway_entries_winners');
}

/// AJAX

if(!defined('GB__AJAX_NAME__TEMPLATE_CONTROLS')) {
	// The key for the AJAX action that returns HTML for a specific template's controls
	define('GB__AJAX_NAME__TEMPLATE_CONTROLS', 'gb_template_controls');
}

// User caps

if(!defined('GB__USER_CAPS__SETTINGS')) {
	// The capability required to access the "Giveaways > Settings" page
	define('GB__USER_CAPS__SETTINGS', 'manage_options');
}
