// <script> Generated {$smarty.now|date_format:'%d %b %Y %H:%M:%S'}
{literal}
CRM.$(function($) {
  if ($('.smartmenu_menu', '#civicrm-menu').length < 1) {
    var navMarkup = {/literal}{$navigation|@json_encode}{literal};
    $('<ul>' + navMarkup + '</ul>').smartmenus({
      subMenusSubOffsetX: 1,
      subMenusSubOffsetY: -8
    });
  }
});
{/literal}
