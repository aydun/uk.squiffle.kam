# KAM - Keyboard Accessible Menus

## What this module does

This module uses the SmartMenus jQuery plugin to add a responsive, accessible menu to CiviCRM.

## Installation

Install as a normal CiviCRM extension; no other configuration is required.

## Requirements

Requires CiviCRM 5.8 or later.

## Roadmap

This extension will be merged into CiviCRM core in the near future. See https://lab.civicrm.org/dev/core/issues/487

## API

*Provides a clientside api for working with the menubar (adding/removing/updating menu items, etc.)*

#### Events

| Event  | Description | Example |
| ------ | ----------- | ------- |
| `crmMenuLoad` | Triggered on the page body after menu data loads but *before* the menu is rendered in the dom.<br />This is a good time to add/remove items if you already know what they are at page load. | `$(document).on('crmMenuLoad', function() {` <br /> `  CRM.menubar.addItems(-1, 'Search', myItems);` <br /> `});` | 
| `crmLoad` | Triggered on the `#civicrm-menu` element after menu is rendered in the dom. | `$(document).on('crmLoad', '#civicrm-menu', function() {` <br /> ` // Do something now that the menu is rendered` <br /> `});` | 

#### Methods

| Method | Description | Example |
| ------ | ----------- | ------- |
| `addItems( position, targetName, items )` | `position`: can be "before" or "after" to create siblings of the target, or an integer to specify index to place as child of the target (negative numbers will start from the end). <br /> `targetName`: name of the menu item to place the new items before/after/within. If using an index for position, specify `null` for placing top-level menu items. <br /> `items`: An array of one or more menu items. | `CRM.menubar.addItems('before', 'Search', [{name: 'foo', label: 'Foo', child: [{name: 'bar', label: 'Bar'}]}]);` |
| `close( )` | Close any open menus. | `CRM.menubar.close();` |
| `destroy( )` | Remove the menubar from the dom (although the menu data is still retained in `CRM.menubar.data` for use by `initialize()`). | `CRM.menubar.destroy();` |
| `hide( [speed], [showMessage] )` | Hides the menubar.<br />`speed`: if a number is given, a slideup animation is used.<br />`showMessage`: if `true`, a restore button will be shown. | `CRM.menubar.hide(250, true);` |
| `obj getItem( itemName )` | Returns the object defining a particular menu item. Includes children. | `CRM.menubar.getItem('New Individual');` |
| `initialize( )` | Build the menu from scratch. Called internally when the page loads. | `CRM.menubar.initialize();` |
| `bool isOpen( itemName )` | Checks if a given menu tree is open (will always return false if called on items that do not have children). | `var isOpen = CRM.menubar.isOpen('Search');` |
| `open( itemName )` | Opens the menu and gives focus to the named item. | `CRM.menubar.open('New Individual');` |
| `removeItem( itemName )` | Deletes an item from the menu (and all its children).<br />`itemName`: name of item to remove. | `CRM.menubar.removeItem('New Household');` |
| `show( [speed] )` | Shows the menubar if hidden.<br />`speed`: if a number is given, a slidedown animation is used. | `CRM.menubar.show(250);` |
| `spin( [spin] )`  | Spins the icon in the home menu.<br />`spin`: pass a boolean to start or stop the spinning, or pass no arguments to toggle. | `CRM.menubar.spin(true); // start` <br /> `CRM.menubar.spin(false); // stop` |
| `updateItem( item )`  | Updates the properties of a menu item (label, url, separator, icon, etc.<br />`item`: object with at least a `name` plus properties to update. | `CRM.menubar.updateItem({name: 'Search', label: 'Find');` |

Tip: Try pasting those examples into your browser console.

## Acknowledgements

- The SmartMenus jQuery plugin was written by Vasil Dinkov - smartmenus.org
- Based on com.aghstrategies.slicknav that provides a responsive menu on mobile devices.  This module changes the menu on both mobile and desktop displays.
- Nic Wistreich - customising CSS to blend smartmenus with CiviCRM
