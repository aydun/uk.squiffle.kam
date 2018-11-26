<?php
/**
 *
 * @package CRM
 * @copyright CiviCRM LLC (c) 2004-2013
 *
 */
/*
 * Settings metadata file
 */

return [
  'menubar_position' => [
    'group_name' => 'CiviCRM Preferences',
    'group' => 'core',
    'name' => 'menubar_position',
    'type' => 'String',
    'html_type' => 'select',
    'default' => 'over-cms-menu',
    'add' => '5.9',
    'title' => ts('Menubar position'),
    'is_domain' => 1,
    'is_contact' => 0,
    'description' => ts('Location of the CiviCRM main menu.'),
    'help_text' => NULL,
    'options' => [
      'over-cms-menu' => ts('Over CMS menu'),
      'below-cms-menu' => ts('Below CMS menu'),
      'above-crm-container' => ts('Above content area')
    ],
  ],
];
