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


include_once ("admin_header.php");
global $xoopsModule;

define ('_LEX_ADMIN_SEPZONE', '');   

//-------------------------------------------------------------
$vars = array(array('name' =>'op',        'default' => ''),
              array('name' =>'idLexique', 'default' => 0),
              array('name' =>'doc',       'default' => ''),              
              array('name' =>'pinochio',  'default' => false));
              
require (_LEX_JJD_PATH."include/gp_globe.php");
//-------------------------------------------------------------

/*****************************************************************************
 *
 *****************************************************************************/
function showAdmin(){
global $xoopsModuleConfig;  

    
  showAdmin_Begin ();      echo _LEX_ADMIN_SEPZONE;
  showAdmin_Options ();    echo _LEX_ADMIN_SEPZONE;
  //showAdmin_Quick ();      echo _LEX_ADMIN_SEPZONE;
  showAdmin_Versions();      echo _LEX_ADMIN_SEPZONE;
  showAdmin_Tools ();      echo _LEX_ADMIN_SEPZONE;
  
  //----------------------------------------------------------  
  //outils et traitements perso, ne pas activer en prod  
  /*

  if ($xoopsModuleConfig['traitementJJD'] == 314116){
      showAdmin_JJD ();echo _LEX_ADMIN_SEPZONE;  
  }
  */ 
  //----------------------------------------------------------
  
  showAdmin_WaitingDef (); echo _LEX_ADMIN_SEPZONE;
  showAdmin_End ();  
}

/*****************************************************************************
 *
 *****************************************************************************/
function showAdmin_Begin(){
global $xoopsModule, $xoopsDB;

    //OpenTable();

}
/*****************************************************************************
 *
 *****************************************************************************/
function showAdmin_End(){
global $xoopsModule, $xoopsDB;

  //CloseTable();
 // xoops_cp_footer();

}


/*****************************************************************************
 *
 *****************************************************************************/
function showAdmin_Options(){
global $xoopsModule, $xoopsDB;
 
    
    
    OpenTable();
    
    
    echo "<p><A HREF=\"".XOOPS_URL."/modules/system/admin.php?fct=preferences&op=showmod&mod=".$xoopsModule->getVar('mid')."\">- "._AD_LEX_CONFDIC."</a><br></p>";

    //**********************************************************************************
    CloseTable();

}

/*****************************************************************************
 *
 *****************************************************************************/
function showAdmin_Quick(){
global $xoopsModule, $xoopsDB;

    OpenTable();
    //**********************************************************************************
    $link = BuildLink ('lex_lexique', 'idLexique', 'name',
                       _LEX_URL."index.php?idLexique=%0%", 'name');   
    echo "<p><A HREF='..'>- "._AD_LEX_NAME."</A> : {$link}</p><br>";
    
    
    echo "<p>- "._AD_LEX_DOCUMENTATIONS." : ".BuildLinkOnFolderDoc()."</p><br>";                  
    //JJD-Import a revoir

    //echo "<p>-&nbsp;<A HREF='lex_zaptemp.php'>"._AD_LEX_ZAPTEMP."</A></p>";
    
    //**********************************************************************************
    CloseTable();


}

/*****************************************************************************
 *
 *****************************************************************************/



function showAdmin_Tools(){
global $xoopsModule, $xoopsDB;

    OpenTable();
    //**********************************************************************************
    
    echo "<p><A HREF='lex_action.php?op=killTemp'>- "._AD_LEX_ZAPTEMP."</A></p><br>";
    echo "<p><A HREF='lex_action.php?op=clearTempLink'>- "._AD_LEX_SA_VIDAGEDUCACHE."</A></p><br>";
    
    echo "<p><A HREF='lex_update_seealso.php?op=valider' target='blanck'>- "._AD_LEX_UPDATE_SEEALSO."</A></p><br>";
    echo "&nbsp;"._AD_LEX_UPDATE_SEEALSO_DSC2."</p><br>";
    
    //**********************************************************************************    
    CloseTable();

}

/*****************************************************************************
 *
 *****************************************************************************/
/* 
 
function showAdmin_JJD(){
global $xoopsModule, $xoopsDB;

    OpenTable();
    echo "<p>-&nbsp;Fonctions particulieres utilisees pour pendant le dev</p>";  
    echo "<p>-&nbsp;mettre la variable jjdebug a false en prod</p>";
    echo "<p>-&nbsp;Ces options ne sont absolument pas garanties dans leur comportement</p>";
    echo '<HR>';   
    //------------------------------------------------------------------------
    echo "<p>-&nbsp;<A HREF='lex_action.php?op=clearIntrusion'>"._AD_LEX_CLEARINTRUSION."</A></p>";
    
    echo "<p>-&nbsp;<A HREF='lex_action.php?op=getInfoSelecteur'>"."getInfoSelecteur"."</A></p>";
    echo "<p>-&nbsp;<A HREF='lex_action.php?op=getInfoCategory'>"."getInfoCategory"."</A></p>";
    
    echo "<p>-&nbsp;<A HREF='lex_action.php?op=getInfoLexique'>"."getInfoLexique"."</A></p>";
    
    echo "<p>-&nbsp;<A HREF='lex_action.php?op=changeIdSeeAlso'>"."changeIdSeeAlso"."</A></p>";
    
    echo "<p>-&nbsp;<A HREF='lex_action.php?op=displayVar'>"."liste des variables"."</A></p>";
    echo "<p>-&nbsp;<A HREF='lex_action.php?op=libelle'>"."liste des libelles"."</A></p>";
    
    echo "<p>-&nbsp;<A HREF='lex_action.php?op=rebuild_tempCategory'>"."reconstruire le champ tempCategory de lex_terme"."</A></p>";
    
    
    
    echo "<p>-&nbsp;<A HREF='lex_action.php?op=afecterDateBidon2Lexiques'>"."Affecter des dates bidons aux lexiques"."</A></p>";    
    echo "<p>-&nbsp;<A HREF='lex_action.php?op=afecterDateBidon2Termes'>"."Affecter des dates bidons aux termes"."</A></p>";        
    CloseTable();

}
*/

/*****************************************************************************
 *
 *****************************************************************************/
//function showVersions($moduleName, $moduleVersion, $moduleDate){
function showAdmin_Versions(){
global $xoopsModule, $xoopsDB, $xoopsModuleConfig, $xoopsConfig;
    
    OpenTable();
    echo getInfoVersions($xoopsModule,$xoopsModuleConfig);
    CloseTable();

}

/*****************************************************************************
 *
 *****************************************************************************/
function showAdmin_WaitingDef (){
global $xoopsModule, $xoopsDB;

    OpenTable();
      echo "<P><br><B>"._AD_LEX_STAT_LIBELLE."</B><br>";    

    //**********************************************************************************   
    for ($h = 1; $h < strlen(_LEX_STATE_LIST); $h++) {
      echo "<hr>";    
    
      $state = substr(_LEX_STATE_LIST, $h, 1);

      switch ($state){
      case 'B': $lib1 = '_AD_LEX_STAT_BLOCKED';      break;
      case 'N': $lib1 = '_AD_LEX_STAT_INWAITING';    break;
      case 'A': $lib1 = '_AD_LEX_STAT_ASK';          break;
      case 'O': $lib1 = '_AD_LEX_STAT_OK';           break;
      }
      
      //--------------------------------------------------------------------------
    
      $sql = "SELECT idTerme, terme.name as name, shortDef, lexique.name as lexique, terme.idLexique as idLexique"
            ." FROM ".$xoopsDB->prefix(_LEX_TBL_TERME)." as terme, "
            ."      ".$xoopsDB->prefix(_LEX_TBL_LEXIQUE)." as lexique "            
            ." WHERE state='{$state}' "
            ."   AND terme.idLexique = lexique.idLexique "
            ." ORDER BY terme.idLexique, terme.name";
      $submitdef = $xoopsDB->query($sql);      

      $submit = $xoopsDB->getRowsNum($submitdef);
      
      if($submit == 0) {
        $lib = constant($lib1);
        echo "<B><FONT COLOR=\"#FF0000\">"._AD_LEX_NONE."  {$lib}</FONT></B><br>";      
      	//echo  " "._AD_LEX_NODEFWAIT."<P>";
      } else {
        $lib2 = $lib1.(($submit > 1 )?'S':'');
        $lib = constant($lib2);
          echo "<B><FONT COLOR=\"#FF0000\">{$submit} {$lib}</FONT></B><br>";
        	//echo "<FONT COLOR=\"#FF0000\">$submit</FONT> "._AD_LEX_WAITDEF."<p>";
        	echo "<TABLE BORDER=0 CELLPADDING=2 CELLSPACING=1 class=\"even\">
          	<TR>
            	  <TD WIDTH=20><CENTER><B>"._AD_LEX_NUM."</B></CENTER></TD>
            	  <TD WIDTH=150><B>"._AD_LEX_TERME4."</B></TD>       
            	  <TD WIDTH=150><B>"._AD_LEX_SHORTDEF2."</B></TD>  
            	  <TD WIDTH=150><B>"._AD_LEX_LEXIQUE."</B></TD>                                   	  
            	  <TD><CENTER><B>"._AD_LEX_OPTION."</B></CENTER></TD>
          	</TR>";
      	while ( list($idTerme, $name,$shortDef, $lexique, $idLexique) = $xoopsDB->fetchRow($submitdef) ) {
      		$myts =& MyTextSanitizer::getInstance();
      		$name = $myts->makeTboxData4Show($name);
      		$shortDef = $myts->makeTboxData4Show($shortDef);   
      		$lexique = $myts->makeTboxData4Show($lexique);             		
         	$linkDel = "del-def.php?op=delete&id={$idTerme}&idLexique={$idLexique}&source=admin";
      		$linkEdit = _LEX_URL."submit.php?id={$idTerme}&idLexique={$idLexique}&validation=ok";		

      		echo "<tr class=\"odd\">
                  <td><CENTER>$idTerme</CENTER></td>
                  <td>{$name}</td>
                  <td>{$shortDef}</td>     
                  <td>{$lexique}</td>                               
                  <td>[ <A HREF=\"{$linkEdit}\">"._EDIT."</A> | <A HREF=\"{$linkDel}\">"._DELETE."</A> ]&nbsp;&nbsp;</td>
                </tr>";      		
        	
          }
       	echo    "</TABLE><P><br />";
      }
      
    }

    //***************************************************************************
    CloseTable();

}


/****************************************************************************
 *
 ****************************************************************************/
function readDoc($doc, $redirect = 'index.php'){

	Global $xoopsModuleConfig, $xoopsDB, $xoopsConfig, $xoopsModule;
	
    $f = _LEX_ROOT_PATH."language/{$xoopsConfig['language']}/doc/{$doc}";	
    
    if (!file_exists($f)){
      redirect_header($redirect,1,_AD_LEX_ADDOK);
      return;
    }    

    //------------------------------------------------  
    //$ligneDeSeparation = "<TR><td colspan='2'><hr></td></TR>"._br;  
    $ligneDeSeparation = "<hr>"._br;

	  //xoops_cp_header();
    OpenTable();    
    //------------------------------------------------   
	  echo "<B>"._AD_LEX_ADMIN." ".$xoopsConfig['sitename']."</B><br>";
  	echo "<B>"._AD_LEX_DOCUMENTATIONS." : </B>".BuildLinkOnFolderDoc();
    
    echo $ligneDeSeparation;     
    getButtonReadFile();    
    //------------------------------------------------    

    
 		echo "<FORM ACTION='{$redirect}' METHOD=POST>"._br;
    readfile ($f);
  
    //------------------------------------------------
  
     
  echo $ligneDeSeparation;	
  
  echo "<B>"._AD_LEX_DOCUMENTATIONS." : </B>".BuildLinkOnFolderDoc();
  getButtonReadFile();

  CloseTable();
  
echo  "</form>";    
	CloseTable();
	//xoops_cp_footer();



}
/****************************************************************************
 *
 ****************************************************************************/
function getButtonReadFile(){
  $linkCancel = buildUrlJava ("index.php",  false);  
echo "<TABLE BORDER=0 CELLPADDING=2 CELLSPACING=3
  <tr valign='top'>
    <td align='left' >

    </td>
    <td align='left' width='10'></td>


    <td align='right'>
    <input type='button' name='cancel' value='"._CLOSE."' onclick='".$linkCancel."'>    
    </td>    
  </tr>
  </table>";


}

//-------------------------------------------------------------



/*****************************************************************************
 *  controleur
*****************************************************************************/
$bOk = true;
//displayArray($gepeto, "***** $gepeto *****");

  if (!isset($op)){$op='';}
  if ($bOk){admin_xoops_cp_header(_LEX_ONGLET_GESTION, $xoopsModule);} 
  
  switch ($op){
    
  case 'read': 
  
    readDoc ($doc);   
    break;    
  
  default:
   
    showAdmin ();    
    break;
  }

/*
  
  if ($op == 'read'){
    readDoc ($doc);  
  }else{
    showAdmin ();  
  }
*/

if ($bOk){admin_xoops_cp_footer();}

?>
