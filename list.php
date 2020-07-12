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

//echo "<hr>".__FILE__."<hr>";
getLexInfo ($idLexique, $info);
getCaption ($info['idCaption'], $libelle);

include_once ("include/seealso_function.php");

$xoopsOption['template_main'] = 'lexique_index.html';
include_once (XOOPS_ROOT_PATH."/header.php");

//$myts =& MyTextSanitizer::getInstance();

//Admin or not
//---------------------------------------------------------------------------
if($xoopsUser) {
	$adminview = $xoopsUser->isAdmin($xoopsModule->mid()) ;
} else {
	$adminview=0;
}
//-------------------------------------------------------------
$vars = array(array('name' =>'op',        'default' => ''),
              array('name' =>'idLexique', 'default' => getFirstIdLexique()),
              array('name' =>'id',        'default' => 0),
              array('name' =>'type',      'default' => 0),              
              array('name' =>'pinochio',  'default' => false));
              
require (_LEX_JJD_PATH."include/gp_globe.php");
//-------------------------------------------------------------

//---------------------------------------------------------------------------
$myts =& MyTextSanitizer::getInstance();


$xoopsTpl->assign('pathToolsJS', _JJD_JS_TOOLS);
$xoopsTpl->assign('pathLexToolsJS', _LEX_JS_LEXIQUE);	
//---------------------------------------------------------------------
Global $xoopsModuleConfig,$xoopsConfig,$xoopsModule,$modversion;
$versionInfo = array('name','version','description','credits','author');
for ($h = 0; $h < count($versionInfo); $h++){
  $xoopsTpl->assign($versionInfo[$h],  $modversion[$versionInfo[$h]]);
}

$moduleInfo = array('textintro');
for ($h = 0; $h < count($moduleInfo); $h++){
  if (isset($xoopsModuleConfig[$moduleInfo[$h]])) {
  $xoopsTpl->assign($moduleInfo[$h],  $xoopsModuleConfig[$moduleInfo[$h]]);
  }
}




$sql = "SELECT * FROM ".$xoopsDB->prefix(_LEX_TBL_LEXIQUE)
      ." WHERE actif = 1"
      ." ORDER BY ordre, name";

    $sqlquery=$xoopsDB->query($sql);
//echo "<hr>list.php<br>{$sql}<hr>";
    //------------------------------------------------     
    $lstLexique = array();   
    $h = 0;
    while ($sqlfetch=$xoopsDB->fetchArray($sqlquery)) {
      $idLexique = $sqlfetch["idLexique"];
      if (cb_isLexiqueOk($idLexique) == 0) continue;

      $sql = "SELECT count(idLexique) as count FROM "
            .$xoopsDB->prefix(_LEX_TBL_TERME)
            ." WHERE idLexique = ".$idLexique;     
      $sqlqueryTermes = $xoopsDB->query($sql);      
	    list( $countTermes ) = $xoopsDB->fetchRow( $sqlqueryTermes ) ;      
    	
    	$sqlfetch ['count'] = $countTermes;
      $sqlfetch['icone'] = getLexIcone ($sqlfetch['icone']);
      $sqlfetch['entry'] = ($countTermes > 1)?_MI_LEX_ENTRYS:_MI_LEX_ENTRY;      
      $sqlfetch['showNotation'] = (($sqlfetch["noteMax"]>$sqlfetch["noteMin"]) ? 1 : 0);
      //$sqlfetch['notation'] = getLexNotation($lButton = 255, $idLexique = 0) ; 
      $sqlfetch['notation'] = getLexNotation(pow(2,16)-1, $sqlfetch) ;                
      $lstLexique[]= $sqlfetch;
      

  }

  $xoopsTpl->assign('lex_post',  $lstLexique);
//displayArray($lstLexique,'-----------------------');

$xoopsTpl->assign('lexiqueList',     buildLexiqueList('index.php'));
$xoopsTpl->assign('doActionMenu',    buildActionMenu(_LEXBTN_TLB_MENU0 & $info['access']['buttons']));
$xoopsTpl->assign('doActionBtn',     getButtonBar(_LEXBTN_TLB_MENU0 & $info['access']['buttons'], 0, $idLexique ));

$xoopsTpl->assign('showMenuList',    $xoopsModuleConfig['showMenuList']);
$xoopsTpl->assign('showMenuBtn',     $xoopsModuleConfig['showMenuBtn']);

 
//---------------------------------------------------------------------
$xoopsTpl->assign('introtext', $info['introtext']);
$xoopsTpl->assign('lexIcone',  getLexIcone($info['icone']));
//---------------------------------------------------------------------------
if ($adminview) {
	$xoopsTpl->assign('lang_admin', _CPHOME);  //panneau de controle
	$xoopsTpl->assign('link_admin', true);

	list($newdef) = $xoopsDB->fetchRow($xoopsDB->query("SELECT  COUNT(*)  "
                                     ."FROM ".$xoopsDB->prefix(_LEX_TBL_TERME)
                                     ." WHERE state='"._LEX_STATE_WAIT."' "
                                     ." AND idLexique = {$idLexique}"));
	if($newdef == 0) {
  		$xoopsTpl->assign('newdeff', _MD_LEX_NODEF);
  	} else {
  		$xoopsTpl->assign('newdeff', "&nbsp;<font color='red'> $newdef </font>"._MD_LEX_PROWAIT."&nbsp;[&nbsp;<a href='admin/index.php'>"._MD_LEX_SEEIT."</a>&nbsp;]");
	}
}
//---------------------------------------------------------------------------



//---------------------------------------------------------------------------
list($numrows) = $xoopsDB->fetchRow($xoopsDB->query("SELECT COUNT(*) "
                                    ." FROM ".$xoopsDB->prefix(_LEX_TBL_TERME)
                                    ." WHERE state='"._LEX_STATE_OK."' "
                                    ." AND idLexique = {$idLexique}"));
if($numrows == 0) {
	$xoopsTpl->assign('counter', _MD_LEX_ISEMPTY);
} else {
  	$xoopsTpl->assign('counter', _MD_LEX_ACTUELL."&nbsp;<font color='red'>$numrows</font>&nbsp;"._MI_LEX_DEFINITIONS.".");
}
//---------------------------------------------------------------------------
if (!isset($letter)) {$letter="";}

$xoopsTpl->assign('nbmsgbypage', $info['nbmsgbypage']);


$xoopsTpl->assign('lang_shortdef2',     $libelle[_LEX_LANG_SHORTDEF2]);
$xoopsTpl->assign('lang_terme2',        $libelle[_LEX_LANG_TERME2]);		
$xoopsTpl->assign('lang_category',      $libelle[_LEX_LANG_CATEGORYS]);   


$xoopsTpl->assign('letterbar', letterBar("letter.php", "letter", "limite", 0, " ", "idLexique=$idLexique", $letter,'' ,'' , $idLexique ));


//JJD 008---------------------------------------------------------




$xoopsTpl->assign('detailShowButtons',     $info['detailShowButtons']);
//$xoopsTpl->assign('detailShowId',          $info['detailShowId']);
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
displayListeTerme ("*", "state='"._LEX_STATE_OK."' AND idLexique={$idLexique}", "idTerme desc", 
                      $limite,  $info['nbmsgbypage'], false,
                      $myts, $xoopsTpl, false, $info);

include(XOOPS_ROOT_PATH."/footer.php");



?>
