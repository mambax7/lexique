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


include_once ("admin_header.php");
global $xoopsModule;
//-----------------------------------------------------------------------------------
include_once (XOOPS_ROOT_PATH."/class/xoopsformloader.php");
include_once (XOOPS_ROOT_PATH."/class/wysiwyg/formwysiwygtextarea.php");


//-------------------------------------------------------------
$vars = array(array('name' =>'op',        'default' => ''),
              array('name' =>'idLexique', 'default' => 0),
              array('name' =>'pinochio',  'default' => false));
              
require (_LEX_JJD_PATH."include/gp_globe.php");
//-------------------------------------------------------------

function ModOk($id, $letter, $name, $shortDef, 
               $definition1, $definition2, $definition3, 
               $seeAlsoList) {
	global $xoopsDB, $myts;
	if ($id == "")  {
		xoops_cp_header();
		OpenTable();
       		echo "&nbsp;";
	   	echo "<p><center>[ <a href=\"javascript:history.go(-1)\">"._BACK."</a> ]</center>";
		CloseTable();
		xoops_cp_footer();
	} else {
		$myts =& MyTextSanitizer::getInstance();
		$name = $myts->makeTboxData4Save($name);
		$shortDef = $myts->makeTboxData4Save($shortDef);
		$definition1 = $myts->makeTareaData4Save($definition1);
		$definition2 = $myts->makeTareaData4Save($definition2);		
		$definition3 = $myts->makeTareaData4Save($definition3);		
		$seeAlsoList = $myts->makeTboxData4Save($seeAlsoList);
	    //******************************************************************
	    //JJD - 04-07-2006- Automatisation du calcul de la premiere lettre
		$letter = getFirstLetter($name);  
		//******************************************************************
      $idSeeAlso =  getNewIdTerme ($idLexique);
	    $sql = "UPDATE ".$xoopsDB->prefix(_LEX_TBL_TERME)
             ." SET letter = '".strtoupper($name{0})."', "
             ."name = '".$name."' , "
             ."shortDef = '".$shortDef."' , "
             ."definition1 = '".$definition1."', "
             ."definition2 = '".$definition2."', "             
             ."definition3 = '".$definition3."', "             
             ."seeAlsoList = '".$seeAlsoList."', "
             ."state = '"._LEX_STATE_OK."' "
             ."templink = '' "             
             ."WHERE idTerme=".$id."";
             
	    //echo "ModOk - sql = ".$sql;
  	    $xoopsDB->query($sql);
		redirect_header("index.php", 1, _AD_LEX_UPDATED);
		exit();
  	}
}
/*********************************************************************
 *
 *********************************************************************/
function FormMod($id) {
	global $myts, $xoopsDB, $xoopsConfig;
	xoops_cp_header();
	echo "<B>"._AD_LEX_ADMIN." ".$xoopsConfig['sitename']."</B><p>";
	OpenTable();
	
  $sql = "SELECT idTerme, letter, name, shortDef, definition1, definition2, definition3, seeAlsoList, state "
        ."FROM ".$xoopsDB->prefix(_LEX_TBL_TERME)
        ." WHERE idTerme = '$id'";
  $TableRep = $xoopsDB->query($sql);
	$noDef = $xoopsDB->getRowsNum($TableRep);
	if($noDef == 0)  {
  		echo "<P><br />"._AD_LEX_NOEXISTDEF." $id";
	} else {
		list($id, $letter, $name, $shortDef, $definition1, $definition2, $definition3, $seeAlsoList, $state) = $xoopsDB->fetchRow($TableRep);
		$myts =& MyTextSanitizer::getInstance();
		if ($letter == 'others') {
			$letter = _MD_LEX_OTHERS;
		}
		$name = $myts->makeTboxData4Edit($name);
		$shortDef = $myts->makeTboxData4Edit($shortDef);
		$definition1 = $myts->makeTareaData4Edit($definition1);
		$definition2 = $myts->makeTareaData4Edit($definition2);		
		$definition3 = $myts->makeTareaData4Edit($definition3);		
		$seeAlsoList = $myts->makeTboxData4Edit($seeAlsoList);
		
		echo "<BR><B>"._AD_LEX_MOVALDEF."</B><P>";
		echo "<FORM enctype='multipart/form-data' ACTION='mod-def.php?op=mod&id=$id'METHOD=POST>
		<INPUT TYPE=\"hidden\" NAME=\"state\" VALUE=\"O\">
		<INPUT TYPE=\"hidden\" NAME=\"id\" VALUE=\"$id\">";
		
		echo "<TABLE BORDER=0 CELLPADDING=2 CELLSPACING=3>";

  $wz = '100%'; //".$wz."


    	echo "<TR>
      		  <TD>"._AD_LEX_TERME2." </TD>
      		  <TD><INPUT TYPE=\"text\" NAME=\"name\" SIZE=".$wz." VALUE=\"$name\"></TD>
    		</TR>
    		<TR>
      		  <TD>".$libelle[_LEX_LANG_SHORTDEF2]." </TD>
      		  <TD><INPUT TYPE=\"text\" NAME=\"shortDef\" SIZE=".$wz." VALUE=\"$shortDef\"></TD>
    		</TR>
    		<TR>
      		  <TD>".$libelle[_LEX_LANG_SEEALSO2])." </TD>
      		  <TD><INPUT TYPE=\"text\" NAME=\"seealso\" SIZE=".$wz." VALUE=\"$seeAlsoList\"></TD>
    		</TR>
    		<TR>
      		  <TD>".$libelle[_LEX_LANG_DEF3]." </TD>";

		$desc1 = getXME($definition1, 'definition1', '', $wz);
		$desc2 = getXME($definition2, 'definition2', '', $wz);
		$desc3 = getXME($definition3, 'definition3', '', $wz);    
    		
		echo "<td>";
        echo $desc->render();
		echo "</td>";
		echo "</tr></table>";

		echo "<TABLE BORDER=0 CELLPADDING=2 CELLSPACING=3>";
		echo "<tr valign=\"top\">";

		echo "  <td><FORM ACTION='mod-def.php?op=mod&id=".$id."&toto=ooo' METHOD=POST><INPUT TYPE=\"submit\" name=\"submit\" value=\""._AD_LEX_FREE."\"></FORM></td>";
		echo "  <td><FORM ACTION='del-def.php?op=delete&id=".$id."&toto=yyy' METHOD=POST><INPUT TYPE=\"submit\" VALUE=\""._DELETE."\"></FORM></TD>";
    	echo "  ";
    	echo "	</TR>";
		echo "</TABLE>";
	echo "";
	}
	CloseTable();
	xoops_cp_footer();
}

//*************************************************************************
switch($op){
//switch($post['op']){

	case "mod":
		ModOk($id, $letter, $name, $shortDef, $definition1, $definition2, $definition3, $seeAlsoList);
		break;
	default:
		FormMod($_GET["id"]);
		break;
}

?>
