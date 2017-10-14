<?php

require_once 'CRM/Core/Page.php';

class CRM_Smartmenu_Page_ResponsiveMenu extends CRM_Core_Page {

  public function run() {
    if (CRM_Core_Session::singleton()->get('userID')) {
      CRM_Core_Page_AJAX::setJsHeaders();
      $smarty = CRM_Core_Smarty::singleton();
      $nav = CRM_Core_BAO_Navigation::createNavigation(NULL);  // param is not used...
      // see comment for smartmenu_civicrm_navigationMenu()
      $nav = str_replace('http://#', '#', $nav);
      // Home logo is special...
      $nav = str_replace('<span class="crm-logo-sm" ></span>', '<a href="#"><span class="crm-logo-sm" ></span></a>', $nav);
      print $smarty->fetchWith('CRM/Smartmenu/Page/navigation.js.tpl', array(
        'navigation' => $nav,
      ));
    }
    CRM_Utils_System::civiExit();
  }

}
