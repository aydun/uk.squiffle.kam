<?php

require_once 'kam.civix.php';

/**
 * Implements hook_civicrm_coreResourceList().
 * Adds js/css for the smartmenus menu
 *
 *  * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_coreResourceList()
 */
function kam_civicrm_coreResourceList(&$list, $region) {
  $config = CRM_Core_Config::singleton();

  // Don't load default navigation css and menu
  $cssWeDontWant = array_search('css/civicrmNavigation.css', $list);
  unset($list[$cssWeDontWant]);
  define('CIVICRM_DISABLE_DEFAULT_MENU', TRUE);

  //check if logged in user has access CiviCRM permission and build menu
  $buildNavigation = !CRM_Core_Config::isUpgradeMode() && CRM_Core_Permission::check('access CiviCRM');
  if (!$buildNavigation || $config->userFrameworkFrontend) {
    return;
  }

  if ($region == 'html-header') {
    $contactID = CRM_Core_Session::getLoggedInContactID();
    if ($contactID) {
      $path = 'packages/smartmenus-1.1.0/';
      CRM_Core_Resources::singleton()
        ->addScriptFile('uk.squiffle.kam', $path . 'jquery.smartmenus.js', 0, 'html-header')
        ->addScriptFile('uk.squiffle.kam', $path . 'addons/keyboard/jquery.smartmenus.keyboard.js', 1, 'html-header')
        ->addScriptFile('uk.squiffle.kam', 'js/sm-civicrm.js', 2, 'html-header')
        ->addStyleUrl(\Civi::service('asset_builder')->getUrl('sm-civicrm.css'));

      // These params force the browser to refresh the js file when switching user, domain, or language
      if (is_callable(array('CRM_Core_I18n', 'getLocale'))) {
        $tsLocale = CRM_Core_I18n::getLocale();
      }
      // 4.6 compatibility
      else {
        global $tsLocale;
      }
      $domain = CRM_Core_Config::domainID();
      $key = CRM_Core_BAO_Navigation::getCacheKey($contactID);
      $src = CRM_Utils_System::url("civicrm/ajax/kam/$contactID/$tsLocale/$domain/$key", 1, 'html-header');
      CRM_Core_Resources::singleton()->addScriptUrl($src);
    }
  }
}

/**
 * Implements hook_civicrm_buildAsset().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_buildAsset
 */
function kam_civicrm_buildAsset($asset, $params, &$mimetype, &$content) {
  if ($asset !== 'sm-civicrm.css') {
    return;
  }
  $path = 'packages/smartmenus-1.1.0/';
  $raw = '';
  foreach (array($path . 'css/sm-core-css.css', 'css/sm-civicrm.css') as $file) {
    $raw .= file_get_contents(Civi::resources()->getPath('uk.squiffle.kam', $file));
  }
  $content = str_replace('LOGO_URL', Civi::resources()->getUrl('civicrm', 'i/logo_sm.png'), $raw);
  $mimetype = 'text/css';
}

/**
 * Implements hook_civicrm_config().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_config
 */
function kam_civicrm_config(&$config) {
  if (isset(Civi::$statics[__FUNCTION__])) {
    return;
  }
  Civi::$statics[__FUNCTION__] = 1;
  Civi::dispatcher()->addListener('hook_civicrm_navigationMenu', 'kam_event_civicrm_navigationmenu', -1000);

  _kam_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_navigationMenu().
 * Called via event dispatcher so we can ensure it is called after all other navigationMenu hooks
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_navigationMenu
 *
 * Submenus need a url so they are recognised by smartmenus
 * Change all 'url' keys with null values to '#'
 * This is a bit ugly ... can't just use '#', since this trips up
 * CRM_Core_BAO_Navigation::getMenuName(), so we use 'http://#' then replace it
 * in CRM_Kam_Page_AdminMenu::run()
 */
function kam_event_civicrm_navigationmenu($event) {
  $params = $event->getHookValues();
  _kam_recurse_navigationMenu($params[0]);
}

function _kam_recurse_navigationMenu(&$menu) {
  foreach ($menu as $menuKey => $menuItem) {
    if (empty($menuItem['attributes']['url'])) {
      $menu[$menuKey]['attributes']['url'] = 'http://#';
    }
    if (isset($menuItem['child'])) {
      _kam_recurse_navigationMenu($menu[$menuKey]['child']);
    }
  }
}

/**
 * Implements hook_civicrm_xmlMenu().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_xmlMenu
 */
function kam_civicrm_xmlMenu(&$files) {
  _kam_civix_civicrm_xmlMenu($files);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_install
 */
function kam_civicrm_install() {
  _kam_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_postInstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_postInstall
 */
function kam_civicrm_postInstall() {
  _kam_civix_civicrm_postInstall();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_uninstall
 */
function kam_civicrm_uninstall() {
  _kam_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_enable
 */
function kam_civicrm_enable() {
  _kam_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_disable
 */
function kam_civicrm_disable() {
  _kam_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_upgrade
 */
function kam_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _kam_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_managed().
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_managed
 */
function kam_civicrm_managed(&$entities) {
  _kam_civix_civicrm_managed($entities);
}

/**
 * Implements hook_civicrm_caseTypes().
 *
 * Generate a list of case-types.
 *
 * Note: This hook only runs in CiviCRM 4.4+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_caseTypes
 */
function kam_civicrm_caseTypes(&$caseTypes) {
  _kam_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implements hook_civicrm_angularModules().
 *
 * Generate a list of Angular modules.
 *
 * Note: This hook only runs in CiviCRM 4.5+. It may
 * use features only available in v4.6+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_caseTypes
 */
function kam_civicrm_angularModules(&$angularModules) {
  _kam_civix_civicrm_angularModules($angularModules);
}

/**
 * Implements hook_civicrm_alterSettingsFolders().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_alterSettingsFolders
 */
function kam_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _kam_civix_civicrm_alterSettingsFolders($metaDataFolders);
}

// --- Functions below this ship commented out. Uncomment as required. ---

/**
 * Implements hook_civicrm_preProcess().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_preProcess
 *
function kam_civicrm_preProcess($formName, &$form) {

} // */

/**
 * Implements hook_civicrm_navigationMenu().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_navigationMenu
 *
function kam_civicrm_navigationMenu(&$menu) {
  _kam_civix_insert_navigation_menu($menu, NULL, array(
    'label' => ts('The Page', array('domain' => 'uk.squiffle.kam')),
    'name' => 'the_page',
    'url' => 'civicrm/the-page',
    'permission' => 'access CiviReport,access CiviContribute',
    'operator' => 'OR',
    'separator' => 0,
  ));
  _kam_civix_navigationMenu($menu);
} // */
