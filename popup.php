<?php
//  ------------------------------------------------------------------------ //
//            LEXIQUE - Module de gestion de lexiques pour XOOPS             //
//                    Copyright (c) 2006 JJ Delalandre                       //
//                       <http://kiolo.com>                                  //
//  ------------------------------------------------------------------------ //
/******************************************************************************

Module LEXIQUE version 1.6.2 pour XOOPS- Gestion multi-lexiques 
Copyright (C) 2007 Jean-Jacques DELALANDRE 
Ce programme est libre, vous pouvez le redistribuer et/ou le modifier selon les termes de la Licence Publique Générale GNU publiée par la Free Software Foundation (version 2 ou bien toute autre version ultérieure choisie par vous). 

Ce programme est distribué car potentiellement utile, mais SANS AUCUNE GARANTIE, ni explicite ni implicite, y compris les garanties de commercialisation ou d'adaptation dans un but spécifique. Reportez-vous à la Licence Publique Générale GNU pour plus de détails. 

Vous devez avoir reçu une copie de la Licence Publique Générale GNU en même temps que ce programme ; si ce n'est pas le cas, écrivez à la Free Software Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307, +tats-Unis. 

Dernière modification : juin 2007 
******************************************************************************/


include_once ("header.php");
include_once XOOPS_ROOT_PATH.'/class/template.php';
$xoopsTpl = new XoopsTpl();

include_once (XOOPS_ROOT_PATH."/header.php");


//-----------------------------------------------------------------------------------
global $xoopsModule;
include_once (XOOPS_ROOT_PATH."/modules/".$xoopsModule->getVar('dirname')."/include/constantes.php");
//-----------------------------------------------------------------------------------
include_once (_LEX_ROOT_JJD."functions.php");
include_once (_LEX_ROOT_PATH."include/seealso_function.php");
include_once (_LEX_ROOT_PATH."include/lexique_function.php");


Global $xoopsModule,$xoopsModuleConfig,$info,$libelle;

xoops_header(true);
//$xoopsTpl->assign("xoops_showlblock", 0);
//$xoopsTpl->assign("xoops_showrblock", 0);


$fcss =  _LEX_URL.'theme/yahoo_taste/style.css';
//$xoopsTpl->assign("xoops_themecss", _LEX_ROOT_PATH.'theme/young_leaves/style.css');


$xoopsTpl->assign("xoops_theme", "yahoo_taste");
//$xoopsTpl->assign("xoops_themecss", $fcss);
xoops_template_clear_module_cache($xoopsModule->getVar('mid'));

//-------------------------------------------------------------
$vars = array(array('name' =>'op',        'default' => ''),
              array('name' =>'idLexique', 'default' => 0),
              array('name' =>'idTerme',   'default' => 0),              
              array('name' =>'id',        'default' => 0),
              array('name' =>'mode',      'default' => 0),              
              array('name' =>'pinochio',  'default' => false));
              
require (_LEX_JJD_PATH."include/gp_globe.php");
//-------------------------------------------------------------
//mode = 0 : pour consultation
//mode = 1 : pour impression
//-------------------------------------------------------------
getLexInfo ($idLexique, $info, 'submit');
getCaption ($info['idCaption'], $libelle);

$myts =& MyTextSanitizer::getInstance();
/*

if ($op == 'popup'){
		$link  = "javascript:openWithSelfMain('popup.php?mode=2&id={$idTerme}&idLexique={$info['idLexique']}','',500,600);";		
    redirect_header($link,1,'_AD_LEX_ADDOK');
    
exit;
}
*/

   //$xoopsTpl->assign('intlinkspopup',   $info['intlinkspopup']);
global    $xoopsModuleConfig;

$limite = 0;
$xoopsTpl->assign('mode',      $mode);

$xoopsTpl->assign('info',    $info);	
$xoopsTpl->assign('libelle', $libelle);
//displayArray($info,'--------------------');

$xoopsTpl->assign('lexiqueList',     buildLexiqueList('index.php'));
$xoopsTpl->assign('doActionMenu',    buildActionMenu(_LEXBTN_TLB_MENU0 & $info['access']['buttons']));
$xoopsTpl->assign('doActionBtn',     getButtonBar(_LEXBTN_TLB_MENU0 & $info['access']['buttons'], 0, $idLexique ));

$xoopsTpl->assign('showMenuList',    $xoopsModuleConfig['showMenuList']);
$xoopsTpl->assign('showMenuBtn',     $xoopsModuleConfig['showMenuBtn']);


if ($mode ==2){
  $introModule = 	$myts->previewTarea($xoopsModuleConfig['textintro'],1,1,1,1); 
  $xoopsTpl->assign('introModule',     $introModule);  

}
//echo "<hr>xm : {$xoopsModuleConfig['showMenuList']}-{$xoopsModuleConfig['showMenuBtn']}<hr>";



	
displayListeTerme ("*", "idTerme={$id}", "idTerme desc", 
                      $limite,  $info['nbmsgbypage'], false,
                      $myts, $xoopsTpl, false, $info);


// $libelle[_LEX_LANG_]


	

//JJD 008---------------------------------------------------------


$xoopsTpl->assign('detailShowButtons',     $info['detailShowButtons']);
$xoopsTpl->assign('detailShowId',          $info['access']['buttonBin'][_LEX_BYTE_SHOWOPTION]);
$xoopsTpl->assign('idLexique',             $info['idLexique']);


//--------------------------------------------------------------------------
$xoopsTpl->display('db:lexique_detail.html');





?>
