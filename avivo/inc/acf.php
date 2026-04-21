<?php

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Populates an ACF select field with a list of registered WordPress navigation menus.
 *
 * This function is used to dynamically populate the choices of a select field in ACF with the names of
 * all registered WordPress menus. The field will display these menus as selectable options.
 *
 * Steps:
 * 1. Resets any existing choices in the select field.
 * 2. Retrieves all registered WordPress navigation menus.
 * 3. Adds each menu's slug and name to the select field's choices array.
 * 4. Returns the updated field object.
 *
 * eg. Hooked to the 'acf/load_field/name=main_menu' filter to ensure it populates the 'main_menu' field when
 * it is being loaded in the ACF admin interface.
 *
 * @param array $field The ACF field object being modified.
 * @return array The updated ACF field object with populated choices.
 */
function cd_populate_menu_field($field) {
	// Reset choices
	$field['choices'] = array();

	// Get the registered menus
	$menus = wp_get_nav_menus();

	// Check if there are any menus
	if (!empty($menus)) {
		// Loop through each menu and add it to the choices array
		foreach ($menus as $menu) {
			$field['choices'][$menu->slug] = $menu->name;
		}
	}

	return $field;
}
add_filter('acf/load_field/name=main_menu', 'cd_populate_menu_field');			// main_menu
add_filter('acf/load_field/name=secondary_menu', 'cd_populate_menu_field');		// secondary_menu
add_filter('acf/load_field/name=mobile_menu', 'cd_populate_menu_field');		// mobile_menu


/**
 * Populate the 'mega_menu_item' field with top-level menu items based on the selected 'main_menu'.
 *
 * This function is hooked into the ACF 'load_field' filter for the 'mega_menu_item' field.
 * It retrieves the selected menu from the 'main_menu' ACF field (set on an options page),
 * then fetches the menu items from that menu. Only top-level menu items (items with no parent)
 * are added to the choices of the 'mega_menu_item' field, allowing users to select from these items
 * in the ACF field.
 *
 * @param array $field The field object that is being modified.
 * @return array The modified field object with updated choices.
 */
function cd_populate_megamenu_field($field) {
	// Get the selected main menu ID
	$selected_menu = get_field('main_menu', 'option'); // 'option' refers to the options page

	// Reset choices
	$field['choices'] = array();

	if ($selected_menu) {
		// Get the menu items for the selected menu
		$menu_items = wp_get_nav_menu_items($selected_menu);

		// Check if there are any menu items
		if (!empty($menu_items)) {
			// Loop through each menu item and add only top-level items to the choices array
			foreach ($menu_items as $menu_item) {
				// Only add items that have no parent (top-level items)
				if ($menu_item->menu_item_parent == 0) {
					$field['choices'][$menu_item->ID] = $menu_item->title;
				}
			}
		}
	}

	return $field;
}
add_filter('acf/load_field/name=mega_menu_item', 'cd_populate_megamenu_field');
