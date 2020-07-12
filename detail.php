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


include("header.php");

//-----------------------------------------------------------------------------------
global $xoopsModule;
include_once (XOOPS_ROOT_PATH."/modules/".$xoopsModule->getVar('dirname')."/include/constantes.php");
//-----------------------------------------------------------------------------------
include_once (_LEX_ROOT_JJD."functions.php");
include_once ("include/lexique_function.php");
include_once ("include/letterbar_function.php");
//include_once (_LEX_ROOT_PATH."xoops_version.php");



//-------------------------------------------------------------
$vars = array(array('name' =>'op',        'default' => ''),
              array('name' =>'idLexique', 'default' => 0),
              array('name' =>'id',        'default' => 0),
              array('name' =>'limite',    'default' => 0), 
              array('name' =>'letter',    'default' => ''),                                         
              array('name' =>'pinochio',  'default' => false));
              
require (_LEX_JJD_PATH."include/gp_globe.php");
//-------------------------------------------------------------
//$info = getInfoLexique ($idLexique);
//if ($idLexique==0){$idLexique = getLexiqueFromTerme($id);}     




include_once ("include/seealso_function.php");
$xoopsOption['template_main'] = 'lexique_detail.html';
include_once (XOOPS_ROOT_PATH."/header.php");

global $info;
getLexInfo ($idLexique, $info);
getCaption ($info['idCaption'], $libelle);

$xoopsTpl->assign('lexiqueList',     buildLexiqueList('index.php'));
$xoopsTpl->assign('doActionMenu',    buildActionMenu(_LEXBTN_TLB_MENU0 & $info['access']['buttons']));
$xoopsTpl->assign('doActionBtn',     getButtonBar(_LEXBTN_TLB_MENU0 & $info['access']['buttons'], 0, $idLexique ));

$xoopsTpl->assign('showMenuList',    $xoopsModuleConfig['showMenuList']);
$xoopsTpl->assign('showMenuBtn',     $xoopsModuleConfig['showMenuBtn']);
//setListFormAccess(1);
//displayArray2($info,"----------setListFormAccess---------------");

//$id = $_GET["id"];
//Admin or not
if($xoopsUser) {
	$adminview=$xoopsUser->isAdmin($xoopsModule->mid()) ;
	$xoopsTpl->assign('link_admin', true);
} else {
	$adminview=0;
}


$myts =& MyTextSanitizer::getInstance();

/*

$xoopsTpl->assign("xoops_showlblock", 0);
$xoopsTpl->assign("xoops_showrblock", 0);
*/
Global $xoopsModuleConfig;
$xoopsTpl->assign('pathToolsJS',    _JJD_JS_TOOLS);	
$xoopsTpl->assign('pathLexToolsJS', _LEX_JS_LEXIQUE);

$xoopsTpl->assign('info',    $info);	
$xoopsTpl->assign('libelle', $libelle);	
displayListeTerme ("*", "idTerme={$id}", "name", 
                      $limite,  $info['nbmsgbypage'], true,
                      $myts, $xoopsTpl, false, $info);

//--------------------------------------------------------------------------
// $libelle[_LEX_LANG_]

//if (!isset($letter)) $letter='';
$xoopsTpl->assign('letterbar', letterBar("letter.php", "letter", "limite", 0, " ", "idLexique=$idLexique", $letter,'' ,'' , $idLexique ) );
//JJD 008---------------------------------------------------------

$xoopsTpl->assign('detailShowButtons',     $info['detailShowButtons']);
$xoopsTpl->assign('detailShowId',          $info['access']['buttonBin'][_LEX_BYTE_SHOWOPTION]);
$xoopsTpl->assign('idLexique',             $info['idLexique']);
//JJD 008---------------------------------------------------------


//--------------------------------------------------------------------------
include XOOPS_ROOT_PATH.'/include/comment_view.php';
include(XOOPS_ROOT_PATH."/footer.php");
?>
