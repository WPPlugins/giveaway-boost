<?php

use GB\Components\Resources;

if(!defined('ABSPATH')) { exit; }

function gb_get_media_picker($image_id, $field_id, $field_name, $text_button = 'Select Image', $text_title = 'Select Image') {
	return apply_filters('gb_get_media_picker', Resources::get_media_picker($image_id, $field_id, $field_name, $text_button, $text_title), $image_id, $field_id, $field_name, $text_button, $text_title);
}
