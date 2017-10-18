# KAM - Keyboard Accessible Menus

## What this module does

This module uses the SmartMenus jQuery plugin to add a responsive, accessible menu to CiviCRM.

## Installation

Install as normal CiviCRM extension
No other configuration is required

## Core patch
This extension triggers a bug in core resulting in notices like:

    (Notice: unserialize(): Error at offset 0 of 8 bytes in Civi\Core\SettingsBag->loadValues() (line 153 of /Applications/MAMP/htdocs/drupal/sites/all/modules/civicrm/Civi/Core/SettingsBag.php)
   
This is fixed by https://github.com/civicrm/civicrm-core/pull/11107 and has been merged so will be in a future release of CiviCRM.  You can apply this fix by manually making the changes to CRM/Core/BAO/Navigation.php

## Acknowledgements

- The SmartMenus jQuery plugin was written by Vasil Dinkov - smartmenus.org
- Based on com.aghstrategies.slicknav that provides a responsive menu on mobile devices.  This module changes the menu on both mobile and desktop displays.
- Nic Wistreich - customising CSS to blend smartmenus with CiviCRM
