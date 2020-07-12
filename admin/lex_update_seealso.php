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

//-------------------------------------------------------------
$vars = array(array('name' =>'op',        'default' => ''),
              array('name' =>'idLexique', 'default' => 0),
              array('name' =>'pinochio',  'default' => false));
              
require (_LEX_JJD_PATH."include/gp_globe.php");
//-------------------------------------------------------------

//------------------------------------------------------------------------

function validerTraitement(){

	global $xoopsConfig, $xoopsModuleConfig, $xoopsDB, $info;
	xoops_cp_header();
	echo "<B>"._AD_LEX_ADMIN." ".$xoopsConfig['sitename']."</B><p>";
	
	OpenTable();
	echo "<B>"._AD_LEX_UPDATE_SEEALSO."</B><P>";
	
	if ($info['seealsomode'] == 0){
	 echo _AD_LEX_UPDATE_SEEALSO_DSC0."<p>";
  }
  else {
	 echo _AD_LEX_UPDATE_SEEALSO_DSC1."<p>";
  }
	
	echo _AD_LEX_UPDATE_SEEALSO_DSC2."<br>";
	
	echo "<FORM ACTION='lex_update_seealso.php?op=executer' METHOD=POST>
	<TABLE BORDER=0 CELLPADDING=2 CELLSPACING=3>
	<TR>
  	  <TD width='100%'>"._AD_LEX_UPDATE_SEEALSO." </TD>
	</TR>
	  <td width='100%' colspan='2' align='center'><input type='submit' name='button' id='executer' value='"._AD_LEX_EXECUTER."'>&nbsp;<input type='button' name='cancel' value='"._CANCEL."' onclick='javascript:history.go(-1);'></td>
	<tr> 
	</TABLE>";
	echo "</FORM>";
	CloseTable();
	xoops_cp_footer();


  
  //redirect_header ("index.php",1,"traitement termine");
}
//------------------------------------------------------------------------

function executerTraitement(){

  updateAllSeeAlsoId ();
  redirect_header ("index.php",1,"traitement termine");
}
//------------------------------------------------------------------------
function annulerTraitement(){
  redirect_header ("index.php",1,"traitement annule");
}
//------------------------------------------------------------------------
  
  
  echo "Operation = ".$op."<br>";
  
  switch ($op){
  case "valider":
    validerTraitement ();
    break;
    
  case "executer":
    executerTraitement ();
    break;
    
  case "annuler":
    annulerTraitement ();
    break;
  
  default :
    redirect_header ("index.php",0,"???");
    break;
  }
  
?>
