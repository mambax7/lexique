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

Vous devez avoir reçu une copie de la Licence Publique Générale GNU en même temps que ce programme ; si ce n'est pas le cas, écrivez à la Free Software Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307, États-Unis. 

Dernière modification : juin 2007 
******************************************************************************/


// a revoir

include_once ("header.php");

//-----------------------------------------------------------------------------------
global $xoopsModule;
include_once (XOOPS_ROOT_PATH."/modules/".$xoopsModule->getVar('dirname')."/include/constantes.php");
include_once (_LEX_ROOT_JJD."functions.php");
//-----------------------------------------------------------------------------------

include_once ("include/category_functions.php");
include_once ("include/lexique_function.php");

getLexInfo ($idLexique, $info);
getCaption ($info['idCaption'], $libelle);


include_once ("include/seealso_function.php");
include_once (XOOPS_ROOT_PATH.'/class/pagenav.php');
$xoopsOption['template_main'] = 'lexique_searchExp.html';
include_once (XOOPS_ROOT_PATH."/header.php");
include_once ("include/letterbar_function.php");


//-------------------------------------------------------------
$vars = array(array('name' => 'op',             'default' => ''),
              array('name' => 'idLexique',      'default' => 0),
              array('name' => 'terme',          'default' => ''),              
              array('name' => 'type',           'default' => ''),              
              array('name' => 'limite',         'default' => ''),              
              array('name' => 'category',       'default' => ''),              
              array('name' => 'list_searchby',  'default' => '1'),              
              array('name' => 'pinochio',       'default' => false));
              
require (_LEX_JJD_PATH."include/gp_globe.php");
//-------------------------------------------------------------



/***************************************************************************
 *
 **************************************************************************/
function searchEdit(){
  Global $xoopsDB, $xoopsModuleConfig, $info;
  
}

/***************************************************************************
 *
 **************************************************************************/
function searchExecute(){
  Global $xoopsDB, $xoopsModuleConfig, $info;
  
}

/***************************************************************************
 *
 **************************************************************************/

//echo $g;

$myts =& MyTextSanitizer::getInstance();
$xoopsTpl->assign('pathToolsJS',       _JJD_JS_TOOLS);
$xoopsTpl->assign('pathLexToolsJS',    _LEX_JS_LEXIQUE);
$xoopsTpl->assign('idLexique',         $idLexique);



$xoopsTpl->assign('lang_category',      $libelle[_LEX_LANG_CATEGORYS]);    

		

$xoopsTpl->assign('search',     $terme);


$xoopsTpl->assign('colWidth1', '300');
$xoopsTpl->assign('colWidth2', '2');
$xoopsTpl->assign('colWidth3', '500');

$xoopsTpl->assign('sep0', '');
$xoopsTpl->assign('sep1', ':');

//---------------------------------------------------------------------
$xoopsTpl->assign('lexiqueList',     buildLexiqueList('searchExp.php'));


//JJD 008---------------------------------------------------------
Global $xoopsModuleConfig, $info, $libelle;
//JJD 008---------------------------------------------------------


//---------------------------------------------------------
//construction de l liste 'rechercher ou ?'
$list = array(_MI_LEX_SEARCH_ENTIRELY,
              _MI_LEX_SEARCH_BEGINBY , 
              _MI_LEX_SEARCH_ENDBY , 
              _MI_LEX_SEARCH_EVERYWHERE, 
              _MI_LEX_SEARCH_ENTIRELYIN);

$selected = getlistSearch ('list_searchby', $list, 0, $list_searchby);
$xoopsTpl->assign ('list_searchby', $selected);

//------------------------------------------------------------
//construction de la liste des case à cocher pour selection dans
//quels élément rechercher (terme, voir aussi, definition1, definition2, ...)
    $lib = 'lib';
    $val = 'val';
    $id  = 'id';
    $onClick = 'onchange';
    $h=0;
    $b = ($type==0)?2:$type;

    $listLib = array(  _MI_LEX_EVERYWHERE,
                      $libelle [_LEX_LANG_TERME2], 
                      $libelle [_LEX_LANG_SHORTDEF2],
                      $libelle [_LEX_LANG_DEFINITION1],
                      $libelle [_LEX_LANG_DEFINITION2],               
                      $libelle [_LEX_LANG_DEFINITION3],               
                      $libelle [_LEX_LANG_SEEALSO2] );
    $t = array();
    for ($h; $h < count($listLib); $h++){
      $t [] = array($lib     =>  $listLib [$h],
                    $val     => isBitOk($h, $b), 
                    $onClick => "checkAll(\"lookfor\",0,{$h});", 
                    $id      => $h
                    ); 
    
    }
    
    $chkList =  buildCheckedListH ($t, '' , "lookfor", 0, 1, $lib, $val, $id, $onClick);
    $xoopsTpl->assign('lookfor',  $chkList);    

//------------------------------------------------------------
//construction del liste des categories pour affiner les recherches
$selected = getSelectCategory ('category', $idLexique, $category);
$xoopsTpl->assign('list_category', $selected);
//------------------------------------------------------------
//construction del liste des proprieté pour affiner les recherches
//$selected = getSelectCategory ('category', $idLexique, $category);
//$xoopsTpl->assign('list_category', $selected);

//------------------------------------------------------------



$linkCancel = buildUrlJava("index.php",false);
$xoopsTpl->assign('linkCancel', $linkCancel);

//------------------------------------------------------------
include(XOOPS_ROOT_PATH."/footer.php");

?>
