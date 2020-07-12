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

//-----------------------------------------------------------------------------------
global $xoopsModule;
include_once (XOOPS_ROOT_PATH."/modules/".$xoopsModule->getVar('dirname')."/include/constantes.php");
//-----------------------------------------------------------------------------------
include_once (_LEX_ROOT_JJD."functions.php");
include_once ("include/letterbar_function.php");
include_once ("include/category_functions.php");
include_once ("include/lexique_function.php");

//-------------------------------------------------------------
$vars = array(array('name' =>'op',        'default' => ''),
              array('name' =>'idLexique', 'default' => 0),
              array('name' =>'type',      'default' => 0),
              array('name' =>'pinochio',  'default' => false));

require (_LEX_JJD_PATH."include/gp_globe.php");
//-------------------------------------------------------------


getLexInfo ($idLexique, $info);
getCaption ($info['idCaption'], $libelle);


include_once ("include/seealso_function.php");

$xoopsOption['template_main'] = 'lexique_lexique.html';
include_once (XOOPS_ROOT_PATH."/header.php");

//Admin or not
//---------------------------------------------------------------------------
if($xoopsUser) {
	$adminview = $xoopsUser->isAdmin($xoopsModule->mid()) ;
} else {
	$adminview=0;
}
//echo "<hr>".__FILE__."<hr>";
if (!isset($idLexique)){$idLexique = getFirstIdLexique();}

//---------------------------------------------------------------------------
$myts =& MyTextSanitizer::getInstance();

$xoopsTpl->assign('pathToolsJS', _JJD_JS_TOOLS);
$xoopsTpl->assign('pathLexToolsJS', _LEX_JS_LEXIQUE);	
//---------------------------------------------------------------------
Global $xoopsModuleConfig;

$xoopsTpl->assign('info',   $info);
$xoopsTpl->assign('libelle',   $libelle);
$xoopsTpl->assign('showLexiqueList',   1);

$xoopsTpl->assign('lexiqueList',     buildLexiqueList('index.php'));
$xoopsTpl->assign('doActionMenu',    buildActionMenu(_LEXBTN_TLB_MENU0 & $info['access']['buttons']));
$xoopsTpl->assign('doActionBtn',     getButtonBar(_LEXBTN_TLB_MENU0 & $info['access']['buttons'], 0, $idLexique ));

$xoopsTpl->assign('showMenuList',    $xoopsModuleConfig['showMenuList']);
$xoopsTpl->assign('showMenuBtn',     $xoopsModuleConfig['showMenuBtn']);

//---------------------------------------------------------------------
if ($adminview) {
	$xoopsTpl->assign('link_admin', true);

	list($newdef) = $xoopsDB->fetchRow($xoopsDB->query("SELECT  COUNT(*)  "
                                     ."FROM ".$xoopsDB->prefix(_LEX_TBL_TERME)
                                     ." WHERE state='"._LEX_STATE_WAIT."' "
                                     ." AND idLexique = {$idLexique}"));
	if($newdef == 0) {
  		$xoopsTpl->assign('newdeff', _MD_LEX_NODEF);
  	} else {
  		$xoopsTpl->assign('newdeff', "&nbsp;<font color='red'> $newdef </font>"
                                  ._MD_LEX_PROWAIT
                                  ."&nbsp;[&nbsp;<a href='admin/index.php'>"
                                  ._MD_LEX_SEEIT."</a>&nbsp;]");
	}
}
//---------------------------------------------------------------------------
$sql = "SELECT COUNT(*) FROM ".$xoopsDB->prefix(_LEX_TBL_TERME)
     . " WHERE state='"._LEX_STATE_OK."' "
     ." AND idLexique = {$idLexique}";
list($numrows) = $xoopsDB->fetchRow($sql);

if($numrows == 0) {
	$xoopsTpl->assign('counter', _MD_LEX_ISEMPTY);
} else {
  	$xoopsTpl->assign('counter', _MD_LEX_ACTUELL."&nbsp;<font color='red'>$numrows</font>&nbsp;"._MI_LEX_DEFINITIONS.".");
}
//---------------------------------------------------------------------------
if (!isset($letter)) {$letter="";}


// $libelle[_LEX_LANG_]
$xoopsTpl->assign('lang_shortdef2',     $libelle[_LEX_LANG_SHORTDEF2]);
$xoopsTpl->assign('lang_terme2',        $libelle[_LEX_LANG_TERME2]);		
$xoopsTpl->assign('lang_category',      $libelle[_LEX_LANG_CATEGORYS]);    


$xoopsTpl->assign('letterbar', letterBar("letter.php", "letter", "limite", 0, " ", "idLexique=$idLexique", $letter,'' ,'' , $idLexique ));


//JJD 008---------------------------------------------------------

$xoopsTpl->assign('detailShowButtons',     $info['detailShowButtons']);
$xoopsTpl->assign('detailShowId', $info['access']['buttonBin'][_LEX_BYTE_SHOWOPTION]);

//JJD 008---------------------------------------------------------

//JJD---------------------------------------------------------
$list = array(_MI_LEX_SEARCH_ENTIRELY,_MI_LEX_SEARCH_BEGINBY , _MI_LEX_SEARCH_ENDBY , _MI_LEX_SEARCH_EVERYWHERE, _MI_LEX_SEARCH_ENTIRELYIN);
$selected = getlistSearch ('list_searchby', $list, 0, 1);
$xoopsTpl->assign('list_searchby', $selected);
//------------------------------------------------------------

$xoopsTpl->assign('selected',  buildListSearch('type' , $type));
//------------------------------------------------------------
if (!isset($category)) {$category = 0;}
$selected = getSelectCategory ('category', $idLexique, $category);
$xoopsTpl->assign('list_category', $selected);
//------------------------------------------------------------
$xoopsTpl->assign('frm_submit', _LEX_URL."submit.php?idLexique={$idLexique}");

$xoopsTpl->assign('idLexique', $idLexique);
$limite=0;

$xoopsTpl->assign('info',    $info);	
$xoopsTpl->assign('libelle', $libelle);	
displayListeTerme ("*", "state='"._LEX_STATE_OK."' AND idLexique={$idLexique}", 
                      "idTerme desc", 
                      $limite,  $info['nbmsgbypage'], false,
                      $myts, $xoopsTpl, false, $info);

include(XOOPS_ROOT_PATH."/footer.php");



?>
