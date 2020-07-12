<?php
//  ------------------------------------------------------------------------ //
//       lexique - Module de gestion de lettre de diffusion pour XOOPS        //
//                    Copyright (c) 2006 JJ Delalandre                       //
//                       <http://xoops.kiolo.com>                                  //
//  ------------------------------------------------------------------------ //
/******************************************************************************

******************************************************************************/

// General settings
//include_once ("header.php");
global $xoopsModule;
//$f = XOOPS_ROOT_PATH.((substr(XOOPS_ROOT_PATH, -1) == '/') ? '' : '/')
//                               ."modules/".$xoopsModule->getVar('dirname')."/include/hermes_constantes.php";
// echo "<hr>$f<hr>";

//$hPath = XOOPS_ROOT_PATH.((substr(XOOPS_ROOT_PATH, -1) == '/') ? '' : '/')
//                               ."modules/".$xoopsModule->getVar('dirname');
$hPath = XOOPS_ROOT_PATH.((substr(XOOPS_ROOT_PATH, -1) == '/') ? '' : '/')
                               ."modules/".'lexique';

//echo "<hr>{$hPath}<hr>";
//include_once ($hPath."/include/lexique_constantes.php");
//include_once ($hPath."/include/lexique_data.php");

/*

include_once (XOOPS_ROOT_PATH.((substr(XOOPS_ROOT_PATH, -1) == '/') ? '' : '/')
                               ."modules/".$xoopsModule->getVar('dirname')."/include/hermes_constantes.php");
*/

$root = XOOPS_ROOT_PATH.((substr(XOOPS_ROOT_PATH, -1) == '/') ? '' : '/').
                          "modules/jjd_tools/";
include_once ($root."include/jjd_constantes.php");
include_once ($root."_common/include/version_functions.php");


//-------------------------------------------------------------
$vars = array(array('name' =>'op',        'default' => ''),
              array('name' =>'pinochio',  'default' => false));
              
require (_LEX_JJD_PATH."include/gp_globe.php");
//-------------------------------------------------------------



/**********************************************************************
 *
 **********************************************************************/ 
//function xoops_module_install_xoopshack(&$module) {
function xoops_module_install_lexique(&$module) {
global $xoopsModuleConfig, $xoopsDB;

  return true;
}


/**********************************************************************
 *
 **********************************************************************/ 
//function xoops_module_update_xoopshack(&$module) {
function xoops_module_update_lexique(&$module) {
global $xoopsModuleConfig, $xoopsDB;
  
  return update_module($module);
  return true;  

}

/**********************************************************************
 *
 **********************************************************************/ 
//function xoops_module_uninstall_xoopshack(&$module) {
function xoops_module_uninstall_lexique(&$module) {
global $xoopsModuleConfig, $xoopsDB;

  kill_Module($module);
  return true;
}
 
 

?>

