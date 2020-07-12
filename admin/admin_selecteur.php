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
//-----------------------------------------------------------------------------------
include_once (_LEX_ROOT_PATH.'/class/clsHtmlDoc.php');


//----------------------------------------------------------
$vars = array(array('name' =>'op',          'default' => 'list'),
              array('name' =>'idLexique',   'default' => 0),
              array('name' =>'idSelecteur', 'default' => 0),              
              array('name' =>'id',          'default' => 0),
              array('name' =>'pinochio',    'default' => false));
              
require (_LEX_JJD_PATH."include/gp_globe.php");
//-------------------------------------------------------------


//----------------------------------------------------------

define ("_LEXSEL_PREFIX_NAME",       "name_");
define ("_LEXSEL_PREFIX_ID",         "id_");


define ("_PREFIX_LIST",    _LEXSEL_PREFIX_ID.";"
                          ._LEXSEL_PREFIX_NAME);

//---------------------------------------------------------------------


//---------------------------------------------------------------------
function listSelecteur(){
	Global $xoopsModuleConfig, $xoopsDB, $xoopsConfig, $xoopsModule;
	$myts =& MyTextSanitizer::getInstance();

	
    //echo "la***********************************<br>";
	
    $sql = "SELECT * FROM ".$xoopsDB->prefix(_LEX_TBL_SELECTEUR)." ORDER BY Name";
    $sqlquery=$xoopsDB->query($sql);

	  //xoops_cp_header();
    OpenTable();    
    echo _JJD_JSI_TOOLS._JJD_JSI_SPIN._LEX_JSI_LEXIQUE._br;
    
	  echo "<B>"._AD_LEX_ADMIN." ".$xoopsConfig['sitename']."</B><p>";
  	echo "<B>"._AD_LEX_SELECTEUR_MANAGEMENT."</B><P>";
    
    echo "<table>";
    //------------------------------------------------        
    $h = 0;
    while ($sqlfetch=$xoopsDB->fetchArray($sqlquery)) {
      $idSelecteur = $sqlfetch["idSelecteur"];
    	$name       = $sqlfetch["name"];    	
      
      $sql = "SELECT count(idSelecteur) as count FROM ".$xoopsDB->prefix(_LEX_TBL_LEXIQUE). " "
            ."WHERE idSelecteur = ".$idSelecteur;     
      $sqlqueryTermes = $xoopsDB->query($sql);      
	    list( $countId ) = $xoopsDB->fetchRow( $sqlqueryTermes ) ;      
      
      $n = _LEXSEL_PREFIX_NAME.$h;
      $$n = $name;
      $$n = $myts->makeTboxData4Save($$n);

      $txtId          = _LEXSEL_PREFIX_ID.$h;      
      $txtName        = _LEXSEL_PREFIX_NAME.$h;
  	  $link = "admin_selecteur.php?op=edit&idSelecteur=".$idSelecteur;
    //jjd_echo ("-<".$tcat[$h]."-".$$n.">-", _LEXJJD_DEBUG_VAR);
    
        echo "<TR>"._br;
        echo "<TD align='right' >".$idSelecteur." <INPUT TYPE=\"hidden\" id='".$txtId."'  NAME='".$txtId."'  size='1%'"." VALUE='".$idSelecteur."'></TD>"._br;
        
       // echo "<TD align='left'  ><INPUT TYPE=\"text\" id='".$txtName."'  NAME='".$txtName."'  size='60%'"." VALUE='".$name."'></TD>"._br;
  	   echo "<TD align='left' width = '50%' ><A href='".$link."'>".$name."</A></TD>";
        
        //-----------------------------------------------------------------------
        
        //-----------------------------------------------------------------------        
        echo "<TD align='center'>";        

  	   echo "<A href='".$link."'><img src='"._JJDICO_EDIT."' border=0 Alt='"._AD_LEX_EDIT."' title='"._AD_LEX_EDIT."' width='20' height='20' ALIGN='absmiddle'></A>";
        echo "</td>";        
        //-----------------------------------------------------------------------        
        echo "<TD align='center'>";        
      	if( $countId == 0 ) {
      	   $link = "admin_selecteur.php?op=remove&idSelecteur={$idSelecteur}&name={$name}";
      	   echo "<A href='".$link."'><img src='"._JJDICO_REMOVE."' border=0 Alt='"._AD_LEX_DELETE."' title='"._AD_LEX_DELETE."' width='20' height='20' ALIGN='absmiddle'></A>";
      	}
        echo "</td>";      	
        //-----------------------------------------------------------------------      
        //----------------------------------------------------
        echo "</TR>"._br;
        $h ++;                			
    }

     
    echo "</table>"._br;




echo "<TABLE BORDER=0 CELLPADDING=2 CELLSPACING=3>
  <tr valign='top'>
    <td align='left' ><input type='button' name='cancel' value='"._CLOSE."' onclick='".buildUrlJava("index.php",false)."'></td>
    <td align='left' width='200'></td>

    <td align='right'>
    <input type='button' name='new' value='"._AD_LEX_NEW."' onclick='".buildUrlJava("admin_selecteur.php?op=new",false)."'>    
    </td>    

    
  </tr>";

    
	CloseTable();
	//xoops_cp_footer();

      //------------------------------------------------------------------
      //$xoopsTpl->append('dic_post', $post);
    


	exit();
}
//-----------------------------------------------------------------

function editSelecteur($p){
	Global $xoopsModuleConfig, $xoopsDB, $xoopsConfig, $xoopsModule;
	$myts =& MyTextSanitizer::getInstance();
	

	  //xoops_cp_header();
    OpenTable();    
    //------------------------------------------------  
    $ligneDeSeparation = "<TR><td colspan='2'><hr></td></TR>"._br;  
    //------------------------------------------------    
    
	  echo "<B>"._AD_LEX_ADMIN." ".$xoopsConfig['sitename']."</B><br>";
  	echo "<B>"._AD_LEX_SELECTEUR_MANAGEMENT."</B><P>";
    
 		echo "<FORM ACTION='admin_selecteur.php?op=save' METHOD=POST>"._br;

    echo "<table width='80%'>"._br;
    //------------------------------------------------    
    //$idSelecteur=0;
    
    //---idSelecteur
    echo "<TR>"._br;
    echo "<TD align='left' >"."zzz"."</TD>"._br;
    echo "<TD align='right' >".$p['idSelecteur']." <INPUT TYPE=\"hidden\" id='idSelecteur'  NAME='idSelecteur'  size='1%'"." VALUE='".$p['idSelecteur']."'></TD>"._br;
    echo "</TR>"._br;    
    echo $ligneDeSeparation;    
    //----------------------------------------------------------    
    //---Name
    echo "<TR>"._br;
    echo "<TD align='left' ><B>"._AD_LEX_NOM."</B></TD>"._br;    
    //echo "<br>"._AD_LEX_ALPHABET_DSC;
    echo "<TD align='left'  ><INPUT TYPE=\"text\" id='txtName'  NAME='txtName'  size='60%'"." VALUE='".$p['name']."'></TD>"._br;
    echo "</TR>"._br;
    echo $ligneDeSeparation;    
    //----------------------------------------------------------
    //---Alphabet
    echo "<TR>"._br;
    echo "<TD align='left' ><B>"._AD_LEX_ALPHABET."</B></TD>"._br;    
    echo "<TD align='left'  ><INPUT TYPE=\"text\" id='txtAlphabet'  NAME='txtAlphabet'  size='60%'"." VALUE='".$p['alphabet']."'></TD>"._br;
    echo "</TR>"._br;
    
    echo buildDescription(_AD_LEX_ALPHABET_DSC);
    echo $ligneDeSeparation;
    //----------------------------------------------------------        
    //---Other
    echo "<TR>"._br;
    echo "<TD align='left' ><B>"._AD_LEX_OTHER."</B></TD>"._br;    
    echo "<TD align='left'  ><INPUT TYPE=\"text\" id='txtOther'  NAME='txtOther'  size='60%'"." VALUE='".$p['other']."'></TD>"._br;
    echo "</TR>"._br;

    echo buildDescription(_AD_LEX_OTHER_DSC);    
    //----------------------------------------------------------    
    //---showAllLetters
    $list = array (_NO, _YES);    
    $selected = getlistSearch ('txtShowAllLetters', $list, 0, $p['showAllLetters']);
    
    echo "<TR>"._br;
    echo "<TD align='left' ><B>"._AD_LEX_SHOWALLALPHABET."</B></TD>"._br;    
    //echo "<TD align='left'  ><INPUT TYPE=\"text\" id='txtShowAllLetters'  NAME='txtShowAllLetters'  size='60%'"." VALUE='".$p['showAllLetters']."'></TD>"._br;
    echo "<TD align='left'>".$selected."</TD>"._br;    
    echo "</TR>"._br;
    echo "<TR></TR>"._br;

    echo buildDescription(_AD_LEX_SHOWALLALPHABET_DSC);    
    //----------------------------------------------------------    
    //---frameDelimitor
    
    $list = str_replace("#", _LEXCST_MODELESELECTEUR, _LEXCST_FRAMEDELIMITOR);
    $tList = explode(";", $list);
    $selected = getlistSearch ('txtFrameDelimitor', $tList, 0, $p['frameDelimitor']);
    
    
    echo "<TR>"._br;
    echo "<TD align='left' ><B>"._AD_LEX_DELIMITOR."</B></TD>"._br;    
//    echo "<TD align='left'  ><INPUT TYPE=\"text\" id='txtFrameDelimitor'  NAME='txtFrameDelimitor'  size='60%'"." VALUE='".$p['frameDelimitor']."'></TD>"._br;
    echo "<TD align='left'  >".$selected."</TD>"._br;
    echo "</TR>"._br;
    echo "<TR></TR>"._br;

    echo buildDescription(_AD_LEX_DELIMITOR_DSC);    
    //----------------------------------------------------------        
    //---letterSeparator
    echo "<TR>"._br;
    echo "<TD align='left' ><B>"._AD_LEX_SEPARATOR."</B></TD>"._br;    
    echo "<TD align='left'  ><INPUT TYPE=\"text\" id='txtlLetterSeparator'  NAME='txtLetterSeparator'  size='60%'"." VALUE='".$p['letterSeparator']."'></TD>"._br;
    echo "</TR>"._br;
    echo "<TR></TR>"._br;

    echo buildDescription(_AD_LEX_SEPARATOR_DSC);    
    //----------------------------------------------------------        
    //---rows
    $tList = array ("1", "2", "3");
    $selected = getlistSearch ('txtRows', $tList, $p['rows'], $p['showAllLetters']);
    
    echo "<TR>"._br;
    echo "<TD align='left' ><B>"._AD_LEX_NBROWS."</B</TD>>"._br;    
    //echo "<TD align='left'  ><INPUT TYPE=\"text\" id='txtRows'  NAME='txtRows'  size='60%'"." VALUE='".$p['rows']."'></TD>"._br;
    echo "<TD align='left'  >".$selected."</TD>"._br;
    echo "</TR>"._br;

    echo buildDescription(_AD_LEX_NBROWS_DSC);    
    
    //----------------------------------------------------------
    
    //Name, other, showAllLetters, frameDelimitor, letterSeparator, rows
    //------------------------------------------------        
    echo "</table>"._br;



echo "<TABLE BORDER=0 CELLPADDING=2 CELLSPACING=3>
  <tr valign='top'>
    <td align='left' ><input type='button' name='cancel' value='"._CANCEL."' onclick='".buildUrlJava("admin_selecteur.php",false)."'></td>
    <td align='left' width='200'></td>

    <td align='right'>
    <input type='submit' name='submit' value='"._AD_LEX_VALIDER."' )'>    
    </td>    
  </tr>
  </table>
  </form>";

    
	CloseTable();
	//xoops_cp_footer();

      //------------------------------------------------------------------
      //$xoopsTpl->append('dic_post', $post);
    


	exit();
}
//-----------------------------------------------------------------------------
function saveSelecteur($p){
//  displayArray ($p,'Selecteur');
  
	global $xoopsModuleConfig, $xoopsDB;
	$myts =& MyTextSanitizer::getInstance();
	

	if ($p['idSelecteur'] == 0 ){
      $sql = "INSERT INTO ".$xoopsDB->prefix(_LEX_TBL_SELECTEUR). " "
             ."(Name, alphabet, other, showAllLetters, frameDelimitor, letterSeparator, rows) "
             ."Values ("
             ."'".$p['txtName']."', "
             ."'".$p['txtAlphabet']."', "             
             ."'".$p['txtOther']."', "
             .$p['txtShowAllLetters'].", "
             .$p['txtFrameDelimitor'].", "
             ."'".$p['txtLetterSeparator']."', "
             .$p['txtRows']." )";



    	$xoopsDB->query($sql);
  
  }else{
      $sql = "UPDATE ".$xoopsDB->prefix(_LEX_TBL_SELECTEUR). " SET "
             ."Name            = '".$p['txtName']."', "
             ."alphabet        = '".$p['txtAlphabet']."', "             
             ."other           = '".$p['txtOther']."', " 
             ."showAllLetters  =  ".$p['txtShowAllLetters'].", "
             ."frameDelimitor  = '".$p['txtFrameDelimitor']."', "
             ."letterSeparator = '".$p['txtLetterSeparator']."', "
             ."rows            =  ".$p['txtRows']." "
             ."WHERE idSelecteur = ".$p['idSelecteur'];
      
//      echo $sql."<br>";
    	$xoopsDB->query($sql);
  
  }

}

/****************************************************************************
 *
 ****************************************************************************/

function removeSelecteur($idSelecteur){
  
	global $xoopsModuleConfig, $xoopsDB;
	
   
  $sql = "DELETE FROM ".$xoopsDB->prefix(_LEX_TBL_SELECTEUR). " "
        ."WHERE idSelecteur = ".$idSelecteur;
  
	$xoopsDB->query($sql);

}

/****************************************************************************
 *
 ****************************************************************************/
function getSelecteur ($idSelecteur){
	global $xoopsModuleConfig, $xoopsDB;

  if ($idSelecteur == 0) {
      $p = array ('idSelecteur' => '0', 
                  'name' => 'nom du selecteur',
                  'alphabet' => $xoopsModuleConfig['alphabet'],
                  'other' => '#',
                  'showAllLetters' => '1',
                  'frameDelimitor' => '[]',
                  'letterSeparator' => '#|#',
                  "rows" => '1');
  
  }
  else {
    	
    $sql = "SELECT  idSelecteur,name,alphabet,other,showAllLetters,frameDelimitor,letterSeparator,rows "
          ."FROM ".$xoopsDB->prefix(_LEX_TBL_SELECTEUR)." "
          ."WHERE idSelecteur = ".$idSelecteur;
  
    $sqlquery=$xoopsDB->query($sql);
    $sqlfetch=$xoopsDB->fetchArray($sqlquery);
    $p = array('idSelecteur'     => $sqlfetch['idSelecteur'],
               'name'            => $sqlfetch['name'],
               'alphabet'        => $sqlfetch['alphabet'],
               'other'           => $sqlfetch['other'],
               'showAllLetters'  => $sqlfetch['showAllLetters'],
               'frameDelimitor'  => $sqlfetch['frameDelimitor'],
               'letterSeparator' => $sqlfetch['letterSeparator'],
               'rows'            => $sqlfetch['rows']);    
    
    
    
    
//    displayArray ($p);    
  }
  
  return $p;
}
//---------------------------------------------------------------------
$bOk = true;
if ($bOk){admin_xoops_cp_header(_LEX_ONGLET_SELECTEUR, $xoopsModule);}   

   

switch($op) {
  case "list":
    listSelecteur();
    break;

  case "new":
    $p = getSelecteur (0);
    editSelecteur ($p);
    //newSelecteur ();    
    break;

  case "edit":
    $p = getSelecteur ($_GET['idSelecteur']);
    editSelecteur ($p);
    break;


  case "remove":
    //xoops_cp_header();
    $msg = sprintf(_AD_LEX_CONFIRM_DEL, "<b>{$_GET['name']} (id:{$idSelecteur})</b>" , _AD_LEX_SELECTEURS);            
    xoops_confirm(array('op'          => 'removeOk', 
                        'idSelecteur' => $_GET['idSelecteur'] ,
                        'ok'          => 1),
                  "admin_selecteur.php", $msg );
    //xoops_cp_footer();
    
    break;

    
  case "removeOk":
    removeSelecteur ($_POST['idSelecteur']);
    redirect_header("admin_selecteur.php",1,_AD_LEX_ADDOK);    
    break;
    
    
  case "save":
    saveSelecteur($_POST);
    redirect_header("admin_selecteur.php",1,_AD_LEX_ADDOK);  
    break;
    
  case "cancel":

    break;
    
    
		
	default:
    //redirect_header("admin_selecteur.php",1,_AD_LEX_ADDOK);		
    break;
}

if ($bOk){admin_xoops_cp_footer();}

?>
