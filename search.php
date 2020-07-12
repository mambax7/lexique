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
include_once (_LEX_ROOT_JJD."functions.php");
//-----------------------------------------------------------------------------------
global $xoopsModule;
include_once (XOOPS_ROOT_PATH."/modules/".$xoopsModule->getVar('dirname')."/include/constantes.php");
//-----------------------------------------------------------------------------------

include_once ("include/category_functions.php");
include_once ("include/lexique_function.php");

getLexInfo ($idLexique, $info);
getCaption ($info['idCaption'], $libelle);


include_once ("include/seealso_function.php");
include_once (XOOPS_ROOT_PATH.'/class/pagenav.php');
$xoopsOption['template_main'] = 'lexique_search.html';
include_once (XOOPS_ROOT_PATH."/header.php");
include_once ("include/letterbar_function.php");

//Admin or not
if($xoopsUser) {
	$adminview = $xoopsUser->isAdmin($xoopsModule->mid()) ;
	$xoopsTpl->assign('link_admin', true);
}

//-------------------------------------------------------------
$vars = array(array('name' =>'op',              'default' => ''),
              array('name' =>'idLexique',       'default' => 0),
              array('name' =>'terme',           'default' => ''),
              array('name' =>'type',            'default' => 1),
              array('name' =>'limite',          'default' => 0),
              array('name' =>'category',        'default' => ''),
              array('name' =>'list_searchby',   'default' => 0),
              array('name' =>'letter',          'default' => ''),
              array('name' =>'id',              'default' => 0),
              array('name' =>'pinochio',        'default' => false));
              
require (_LEX_JJD_PATH."include/gp_globe.php");
//-------------------------------------------------------------


//-----------------------------------------------------------
$sqlWhere = getSqlWhereForSearch ($_POST, $_GET);
//echo "<hr>{$sqlWhere}<hr>";
//-----------------------------------------------------------

//count number of messages
$sql = "SELECT count(*) as nbmsg from ".$xoopsDB->prefix(_LEX_TBL_TERME).$sqlWhere;
echo "<hr>{$sql}<hr>";

$sqlquery=$xoopsDB->query($sql);
$sqlfetch=$xoopsDB->fetchArray($sqlquery);
$nbmessage=$sqlfetch["nbmsg"];

$g = "terme={$terme}&type={$type}&category={$category}&list_searchby={$list_searchby}&idLexique={$idLexique}";
$pagenav = new XoopsPageNav($nbmessage, $info['nbmsgbypage'], 
                            $limite, "limite", $g);

$myts =& MyTextSanitizer::getInstance();
$xoopsTpl->assign('pathToolsJS',       _JJD_JS_TOOLS);	
$xoopsTpl->assign('pathLexToolsJS',       _LEX_JS_LEXIQUE);

$xoopsTpl->assign('idLexique',         $idLexique);
if($nbmessage == 0) {
	$xoopsTpl->assign('counter', _MI_LEX_NORESPOND);
} else {
  	$xoopsTpl->assign('counter', "<font color='red'>".$nbmessage."</font>&nbsp;"._MD_LEX_DEF_FOR."&nbsp;<b>$terme</b>&nbsp;"._MD_LEX_FOUND.".");
}


$xoopsTpl->assign('letterbar', letterBar("letter.php", "letter", "limite", 0, " ", "idLexique=$idLexique", $letter,'' ,'' , $idLexique ) );
$xoopsTpl->assign('search', $terme);

$xoopsTpl->assign('lang_shortdef2',     $libelle[_LEX_LANG_SHORTDEF2]);
$xoopsTpl->assign('lang_terme2',        $libelle[_LEX_LANG_TERME2]);		
$xoopsTpl->assign('lang_category',      $libelle[_LEX_LANG_CATEGORY]);    


//$xoopsTpl->assign('frm_submit', _LEXCST_DIR_ROOT."submit.php");
//---------------------------------------------------------------------
Global $xoopsModuleConfig;
$xoopsTpl->assign('lexiqueList',     buildLexiqueList('index.php'));
$xoopsTpl->assign('doActionMenu',    buildActionMenu(_LEXBTN_TLB_MENU0 & $info['access']['buttons']));
$xoopsTpl->assign('doActionBtn',     getButtonBar(_LEXBTN_TLB_MENU0 & $info['access']['buttons'], 0, $idLexique ));

$xoopsTpl->assign('showMenuList',    $xoopsModuleConfig['showMenuList']);
$xoopsTpl->assign('showMenuBtn',     $xoopsModuleConfig['showMenuBtn']);


//JJD 008---------------------------------------------------------

$xoopsTpl->assign('detailShowButtons',     $info['detailShowButtons']);
$xoopsTpl->assign('detailShowId', $info['access']['buttonBin'][_LEX_BYTE_SHOWOPTION]);

//JJD---------------------------------------------------------

$list = array(_MI_LEX_SEARCH_ENTIRELY,_MI_LEX_SEARCH_BEGINBY , _MI_LEX_SEARCH_ENDBY , _MI_LEX_SEARCH_EVERYWHERE, _MI_LEX_SEARCH_ENTIRELYIN);
$selected = getlistSearch ('list_searchby', $list, 0, $list_searchby);
$xoopsTpl->assign ('list_searchby', $selected);
//------------------------------------------------------------
$xoopsTpl->assign('selected',  buildListSearch('type' , $type));
//------------------------------------------------------------
$selected = getSelectCategory ('category', $idLexique, $category);
$xoopsTpl->assign('list_category', $selected);
//------------------------------------------------------------
$xoopsTpl->assign('frm_submit', _LEX_URL."submit.php?idLexique={$idLexique}");

$xoopsTpl->assign('lang_comments' , _COMMENTS);

$xoopsTpl->assign('info',    $info);	
$xoopsTpl->assign('libelle', $libelle);	
displayListeTerme ("*", $sqlWhere, "name", 
                   $limite,  $info['nbtermebypage'], true,
                   $myts, $xoopsTpl, false, $info);



$xoopsTpl->assign('dic_page_nav', $pagenav->renderNav());
include(XOOPS_ROOT_PATH."/footer.php");
?>
