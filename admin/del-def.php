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


global $info;
include_once ("admin_header.php");
global $xoopsModule;

//-------------------------------------------------------------
$vars = array(array('name' => 'op',        'default' => ''),
              array('name' => 'idLexique', 'default' => 0),
              array('name' => 'id',        'default' => 0),
              array('name' => 'pinochio',  'default' => false));
              
require (_LEX_JJD_PATH."include/gp_globe.php");
//-------------------------------------------------------------


getLexInfo ($idLexique, $info, 'submit');
getCaption ($info['idCaption'], $libelle);


/************************************************************************
 *
 ************************************************************************/
function deleteOk($id, $source) {
	global $xoopsDB;
	$sql = "SELECT terme.letter, terme.name, terme.shortDef, "
        ." terme.definition1, terme.definition2, terme.definition3, "
        ." terme.seeAlsoList, "
	      ."       lexique.idLexique, lexique.name as lexique "
        ." FROM ".$xoopsDB->prefix(_LEX_TBL_TERME)." AS terme "
        .",".$xoopsDB->prefix(_LEX_TBL_LEXIQUE)." AS lexique "
        ." WHERE terme.idLexique = lexique.idLexique " 
        ." AND idTerme = {$id}";
	$result = $xoopsDB->query($sql);
	list ($letter, $name, $shortDef, $definition1, $definition2, $definition3, $seeAlsoList, $idLexique, $lexique)  = $xoopsDB->fetchRow($result);
	//--------------------------------------------------------------------------
  $sql="DELETE FROM ".$xoopsDB->prefix(_LEX_TBL_TERME)." WHERE idTerme = ".$id."";
//	jjd_echo ("JJD-Delete = ".$sql, _LEXJJD_DEBUG_SQL) ;
	$xoopsDB->query($sql);

  lex_envoyerMail (_AD_LEX_MAIL_DEF_DELETED, $name, $id, $shortDef, $definition1);//z01
          	
	//for ($h=0; $h<2000; $h++){ jjd_echo ("JJD-Delete = ".$sql, _LEXJJD_DEBUG_SQL) ;}
	
  if ($source=='admin'){
    redirect_header("index.php",2,_AD_LEX_DELOK);  
  }else{
    redirect_header("../index.php",2,_AD_LEX_DELOK);  
  }

	//redirect_header("http://kiolo.com",1,_AD_LEX_DELOK);
	exit();
}
/****************************************************************
 *
 ****************************************************************/
function FormDelete($id, $source='') {
	global $xoopsDB, $xoopsConfig, $myts, $libelle;
	xoops_cp_header();
	echo "<B>"._AD_LEX_ADMIN." ".$xoopsConfig['sitename']."</B><p>";
	OpenTable();
	
	$sql = "SELECT terme.letter, terme.name, terme.shortDef, "
        ." terme.definition1, terme.definition2, terme.definition3, "
        ." terme.seeAlsoList, "
	      ."       lexique.idLexique, lexique.name as lexique "
        ." FROM ".$xoopsDB->prefix(_LEX_TBL_TERME)." AS terme "
        .",".$xoopsDB->prefix(_LEX_TBL_LEXIQUE)." AS lexique "
        ." WHERE terme.idLexique = lexique.idLexique " 
        ." AND idTerme = {$id}";
	$result = $xoopsDB->query($sql);
	list ($letter, $name, $shortDef, $definition1, $definition2, $definition3, $seeAlsoList, $idLexique, $lexique)  = $xoopsDB->fetchRow($result);
	$seealsoTerme = getSeeAlsoName($seeAlsoList, $id, " - "); 

	if ($letter == 'others') {
		$letter = _MD_LEX_OTHERS;
	}
	$myts =& MyTextSanitizer::getInstance();
	$name = $myts->makeTboxData4Show($name, 1);
	$definition1 = $myts->makeTareaData4Show($definition1, "1", "1", "1");
	$definition2 = $myts->makeTareaData4Show($definition2, "1", "1", "1");
	$definition3 = $myts->makeTareaData4Show($definition3, "1", "1", "1");
	echo "<P><br /><B>"._AD_LEX_DEL_DEF." <FONT COLOR=\"#FF0000\">$id</FONT> "._AD_LEX_ANDCOMLINK."</B></CENTER><P>";



	echo "<TABLE WIDTH=100% BORDER=0 CELLPADDING=3 CELLSPACING=0 CLASS=\"bg2\">
    	<TR CLASS=\"bg1\">
      	  <TD WIDTH=20%><B>".'Lexique : '." </B></TD>
      	  <TD WIDTH=80%>{$lexique} ({$idLexique})</TD><P>
    	</TR>
    	<TR CLASS=\"bg1\">
      	  <TD><B>".$libelle[_LEX_LANG_TERME2]." </B></TD>
      	  <TD>$name</TD>
    	</TR>
    	<TR CLASS=\"bg1\">
      	  <TD><B>".$libelle[_LEX_LANG_SHORTDEF2]." </B></TD>
      	  <TD>$shortDef</TD>
    	</TR>
    	<TR CLASS=\"bg1\">
      	  <TD><B>".$libelle[_LEX_LANG_SEEALSO2]." </B></TD>
      	  <TD>$seealsoTerme</TD>
    	</TR>
    	<TR CLASS=\"bg1\">
      	  <TD VALIGN=\"TOP\"><B>".$libelle[_LEX_LANG_DEFINITION1]." </B></TD>
      	  <TD>$definition1</TD>
    	</TR>
    	<TR CLASS=\"bg1\">
      	  <TD VALIGN=\"TOP\"><B>".$libelle[_LEX_LANG_DEFINITION2]." </B></TD>
      	  <TD>$definition2</TD>
    	</TR>
    	<TR CLASS=\"bg1\">
      	  <TD VALIGN=\"TOP\"><B>".$libelle[_LEX_LANG_DEFINITION3]." </B></TD>
      	  <TD>$definition3</TD>      	  
    	</TR>
	</TABLE>
	<form method=post action='del-def.php?op=deleteOk&id=$id&source={$source}'><input type=submit value=\""._AD_LEX_DEL_DEF."\"></form>";
	CloseTable();
	xoops_cp_footer();
}
/************************************************************************
 *
 ************************************************************************/
function moveOk($id, $newIdLexique) {
	global $xoopsDB;
	$sql = "SELECT terme.letter, terme.name, terme.shortDef, "
        ." terme.definition1, terme.definition2, terme.definition3, "
        ." terme.seeAlsoList, "
	      ."       lexique.idLexique, lexique.name as lexique "
        ." FROM ".$xoopsDB->prefix(_LEX_TBL_TERME)." AS terme "
        .",".$xoopsDB->prefix(_LEX_TBL_LEXIQUE)." AS lexique "
        ." WHERE terme.idLexique = lexique.idLexique " 
        ." AND idTerme = {$id}";
	$result = $xoopsDB->query($sql);
	list ($letter, $name, $shortDef, $definition1, $definition2, $definition3, $seeAlsoList, $idLexique, $lexique)  = $xoopsDB->fetchRow($result);
	//--------------------------------------------------------------------------
  $idSeeAlso =  getNewIdTerme ($idLexique);	
  $sql = "UPDATE ".$xoopsDB->prefix(_LEX_TBL_TERME)
       . " SET idLexique = {$newIdLexique}, "
       . "     idSeeAlso = {$idSeeAlso} "
       . " WHERE idTerme = ".$id."";
//	jjd_echo ("JJD-Delete = ".$sql, _LEXJJD_DEBUG_SQL) ;
	$xoopsDB->query($sql);
//echo "<hr>moveOk<br>{$sql}<hr>";
  lex_envoyerMail (_AD_LEX_MAIL_DEF_MOVED, $name, $id, $shortDef, $definition1);//z01


	//exit();          	
	//for ($h=0; $h<2000; $h++){ jjd_echo ("JJD-Delete = ".$sql, _LEXJJD_DEBUG_SQL) ;}
	//redirect_header("../detail.php?id={$id}&idLexique={$newIdLexique}",2,_AD_LEX_MOVEOK);
	redirect_header("../detail.php?id={$id}",2,_AD_LEX_MOVE_OK);	
	
	//redirect_header("http://kiolo.com",1,_AD_LEX_DELOK);

}
/****************************************************************
 *
 ****************************************************************/
function FormMove($id) {
	global $xoopsDB, $xoopsConfig, $myts;
	xoops_cp_header();
	echo "<B>"._AD_LEX_ADMIN." ".$xoopsConfig['sitename']."</B><p>";
	OpenTable();
	
	$sql = "SELECT terme.letter, terme.name, terme.shortDef, "
        ." terme.definition1, terme.definition2, terme.definition3, "
        ." terme.seeAlsoList, "
	      ."       lexique.idLexique, lexique.name as lexique "
        ." FROM ".$xoopsDB->prefix(_LEX_TBL_TERME)." AS terme "
        .",".$xoopsDB->prefix(_LEX_TBL_LEXIQUE)." AS lexique "
        ." WHERE terme.idLexique = lexique.idLexique " 
        ." AND idTerme = {$id}";
	$result = $xoopsDB->query($sql);
	list ($letter, $name, $shortDef, $definition1, $definition2, $definition3, $seeAlsoList, $idLexique, $lexique)  = $xoopsDB->fetchRow($result);
	$seealsoTerme = getSeeAlsoName($seeAlsoList, $id, " - "); 

	if ($letter == 'others') {
		$letter = _MD_LEX_OTHERS;
	}
	$myts =& MyTextSanitizer::getInstance();
	$name = $myts->makeTboxData4Show($name, 1);
	$definition1 = $myts->makeTareaData4Show($definition1, "1", "1", "1");
	$definition2 = $myts->makeTareaData4Show($definition2, "1", "1", "1");
	$definition3 = $myts->makeTareaData4Show($definition3, "1", "1", "1");

  $txtIdLexique = buildLexiqueList('', $idLexique);

	
	echo "<P><br /><B>"._AD_LEX_MOVE_DEF." <FONT COLOR=\"#FF0000\">$id</FONT> "._AD_LEX_ANDCOMLINK."</B></CENTER><P>";

	

	echo "<form method=post action=del-def.php?op=moveOk&id=$id>
      <TABLE WIDTH=100% BORDER=0 CELLPADDING=3 CELLSPACING=0 CLASS=\"bg2\">
    	<TR CLASS=\"bg1\">
      	  <TD WIDTH=20%><B>".'Lexique : '." </B></TD>
      	  <TD WIDTH=80%>{$lexique} ({$idLexique})</TD><P>
    	</TR>
    	<TR CLASS=\"bg1\">
      	  <TD><B>".$libelle[_LEX_LANG_TERME2]." </B></TD>
      	  <TD>$name</TD>
    	</TR>
    	<TR CLASS=\"bg1\">
      	  <TD><B>".$libelle[_LEX_LANG_SHORTDEF2]." </B></TD>
      	  <TD>$shortDef</TD>
    	</TR>
    	<TR CLASS=\"bg1\">
      	  <TD><B>".$libelle[_LEX_LANG_SEEALSO2]." </B></TD>
      	  <TD>$seealsoTerme</TD>
    	</TR>
    	<TR CLASS=\"bg1\">
      	  <TD VALIGN=\"TOP\"><B>".$libelle[_LEX_LANG_DEF1]." </B></TD>
      	  <TD>$definition1</TD>
    	</TR>
    	<TR CLASS=\"bg1\">
      	  <TD VALIGN=\"TOP\"><B>".$libelle[_LEX_LANG_DEF2]." </B></TD>
      	  <TD>$definition2</TD>
    	</TR>
    	<TR CLASS=\"bg1\">
      	  <TD VALIGN=\"TOP\"><B>".$libelle[_LEX_LANG_DEF3]." </B></TD>
      	  <TD>$definition3</TD>      	  
    	</TR>
    	
    	
    	<TR CLASS=\"bg1\">
      	  <TD VALIGN=\"TOP\"><B>"._AD_LEX_MOVE_DEF_TO." </B></TD>
      	  <TD>$txtIdLexique</TD>      	  
    	</TR>
    	
    	
	</TABLE>
	
  <TABLE><tr><td align='center'>	
	<form method=post action=del-def.php?op=moveOk&id=$id>
    <input type='reset' name='reset' value='"._CANCEL."'>  
    <input type='submit' value=\""._AD_LEX_MOVE_DEF."\">
  
	</td></tr></TABLE>
  </form>";	
	
  CloseTable();
	xoops_cp_footer();
}

//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
switch($op){
	case "deleteOk":
	   if (!isset($_GET["source"])) $_GET["source"] = '';	
		deleteOk($id, $_GET["source"]);
		break;
		
	case "delete":
	   if (!isset($_GET["source"])) $_GET["source"] = '';
		FormDelete($_GET["id"], $_GET["source"]);
		break;
		
  //--------------------------------------------------------
  
	case "moveOk":
		moveOk($id, $idLexique);
		break;
		
	case "move":
		FormMove($_GET["id"]);
		break;
		
  //--------------------------------------------------------
  
  		
	default:
	  redirect_header("../index.php?idLexique=$idLexique",0,"");
		break;
}
?>
