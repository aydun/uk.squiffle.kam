<?php

require_once 'CRM/Core/Page.php';

class CRM_Smartmenu_Page_ResponsiveMenu extends CRM_Core_Page {

  public function run() {
    if (CRM_Core_Session::singleton()->get('userID')) {
      CRM_Core_Page_AJAX::setJsHeaders();
      $smarty = CRM_Core_Smarty::singleton();
      ddl(CRM_Core_BAO_Navigation::buildNavigation());
      print $smarty->fetchWith('CRM/Smartmenu/Page/navigation.js.tpl', array(
        'navigation' => CRM_Core_BAO_Navigation::buildNavigation(),
      ));
    }
    CRM_Utils_System::civiExit();
  }

}
