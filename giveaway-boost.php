<?php
/*
Plugin Name: Giveaway Boost
Plugin URI:  http://giveawayboost.com/
Description: Easily run giveaways on your WordPress site.
Version:     1.0.7
Author:      Giveaway Boost
Author URI:  http://giveawayboost.com/
*/

// Constant definitions for the plugin
require_once(path_join(dirname(__FILE__), 'includes/constants.php'));

if(version_compare(phpversion(), GB__PLUGIN__PHP_VERSION_REQUIRED, '>=')) {
	// Utility functions
	require_once(path_join(dirname(__FILE__), 'includes/cookies.functions.php'));
	require_once(path_join(dirname(__FILE__), 'includes/datetime.functions.php'));
	require_once(path_join(dirname(__FILE__), 'includes/export.functions.php'));
	require_once(path_join(dirname(__FILE__), 'includes/utility.functions.php'));

	// Vendors

	// Resources (Scripts and Styles)
	require_once(path_join(dirname(__FILE__), 'components/resources/resources.php'));

	// Data

	/// Post types
	require_once(path_join(dirname(__FILE__), 'components/data/types/giveaway/giveaway.php'));
	require_once(path_join(dirname(__FILE__), 'components/data/types/entry/entry.php'));

	/// Metadata

	//// Entry
	require_once(path_join(dirname(__FILE__), 'components/data/metadata/entry/chances/chances.php'));
	require_once(path_join(dirname(__FILE__), 'components/data/metadata/entry/sources/sources.php'));
	require_once(path_join(dirname(__FILE__), 'components/data/metadata/entry/token/token.php'));
	require_once(path_join(dirname(__FILE__), 'components/data/metadata/entry/tracking-address/tracking-address.php'));
	require_once(path_join(dirname(__FILE__), 'components/data/metadata/entry/tracking-email/tracking-email.php'));
	require_once(path_join(dirname(__FILE__), 'components/data/metadata/entry/tracking-name/tracking-name.php'));
	require_once(path_join(dirname(__FILE__), 'components/data/metadata/entry/tracking-referrer/tracking-referrer.php'));
	require_once(path_join(dirname(__FILE__), 'components/data/metadata/entry/winner/winner.php'));

	//// Giveaway
	require_once(path_join(dirname(__FILE__), 'components/data/metadata/giveaway/finished/finished.php'));
	require_once(path_join(dirname(__FILE__), 'components/data/metadata/giveaway/settings/settings.php'));

	/// Options
	require_once(path_join(dirname(__FILE__), 'components/data/options/settings/settings.php'));

	// Views admin

	/// Types

	//// Giveaway
	require_once(path_join(dirname(__FILE__), 'components/views-admin/types/giveaway/edit/edit.php'));
	require_once(path_join(dirname(__FILE__), 'components/views-admin/types/giveaway/manage/manage.php'));

	/// Settings
	require_once(path_join(dirname(__FILE__), 'components/views-admin/settings/settings.php'));

	/// Settings sections
	require_once(path_join(dirname(__FILE__), 'components/views-admin/settings-sections/content/content.php'));
	require_once(path_join(dirname(__FILE__), 'components/views-admin/settings-sections/defaults/defaults.php'));
	require_once(path_join(dirname(__FILE__), 'components/views-admin/settings-sections/recaptcha/recaptcha.php'));
	require_once(path_join(dirname(__FILE__), 'components/views-admin/settings-sections/rewrites/rewrites.php'));

	// Views public

	/// Types

	//// Giveaways
	require_once(path_join(dirname(__FILE__), 'components/views-public/types/giveaway/giveaway.php'));

	// Views public additions

	/// Types

	//// Giveaways
	require_once(path_join(dirname(__FILE__), 'components/views-public-additions/types/giveaway/entry-methods/facebook/facebook.php'));
	require_once(path_join(dirname(__FILE__), 'components/views-public-additions/types/giveaway/entry-methods/referral/referral.php'));
	require_once(path_join(dirname(__FILE__), 'components/views-public-additions/types/giveaway/verification/verification.php'));

	// Actions

	/// Admin
	require_once(path_join(dirname(__FILE__), 'components/actions/admin/entries-export/entries-export.php'));
	require_once(path_join(dirname(__FILE__), 'components/actions/admin/entries-winners/entries-winners.php'));

	/// AJAX
	require_once(path_join(dirname(__FILE__), 'components/actions/ajax/template-controls/template-controls.php'));

	/// Data

	//// Types
	require_once(path_join(dirname(__FILE__), 'components/actions/data/types/giveaway/save/save.php'));
} else {
	add_action('admin_notices', function() {
		printf('<div class="updated error"><p>%s</p></div>', sprintf(__('The <em>Giveaway Boost</em> plugin has been disabled. The minimum PHP version required is <strong>%s</strong>, which is greater than your current version of <strong>%s</strong>.'), GB__PLUGIN__PHP_VERSION_REQUIRED, phpversion()));
	});
}

// On activation, flush the rewrite rules after ensuring that the giveaway has its permalinks registered
register_activation_hook(  __FILE__, function() { \GB\Components\Data\Types\Giveaway::register_type(); flush_rewrite_rules(); });

// On activation, ensure that the template data is reloaded
register_activation_hook(  __FILE__, function() { if(function_exists('gb_get_giveaway_templates')) { gb_get_giveaway_templates(true); } });

// On deactivation, remove the rewrite rules for the giveaways
register_deactivation_hook(__FILE__, function() { flush_rewrite_rules(); });
