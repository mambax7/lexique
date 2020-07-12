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
              array('name' =>'idList',      'default' => 0),
              array('name' =>'pinochio',    'default' => false));
              
require (_LEX_JJD_PATH."include/gp_globe.php");
//-------------------------------------------------------------


//----------------------------------------------------------

define ("_LEXLIST_PREFIX_NAME",       "name_");
define ("_LEXLIST_PREFIX_ID",         "id_");

//---------------------------------------------------------------------


//---------------------------------------------------------------------
function listList(){
	Global $xoopsModuleConfig, $xoopsDB, $xoopsConfig, $xoopsModule;
	$myts =& MyTextSanitizer::getInstance();

	
    //echo "la***********************************<br>";
	
    $sql = "SELECT * FROM "._LEX_TFN_LIST." ORDER BY Name";
    $sqlquery=$xoopsDB->query($sql);

	  //xoops_cp_header();
    OpenTable();    
    echo _JJD_JSI_TOOLS._JJD_JSI_SPIN._LEX_JSI_LEXIQUE._br;
    
	  echo "<B>"._AD_LEX_ADMIN." ".$xoopsConfig['sitename']."</B><p>";
  	echo "<B>"._AD_LEX_LIST_MANAGEMENT."</B><P>";
    
    echo "<table>";
    //------------------------------------------------        
    $h = 0;
    while ($sqlfetch=$xoopsDB->fetchArray($sqlquery)) {
      $idList = $sqlfetch["idList"];
    	$name   = $sqlfetch["name"];    	
      
      $sql = "SELECT count(idList) as count FROM "._LEX_TFN_PROPERTYSET. " "
            ."WHERE idList = ".$idList;     
      $sqlqueryCount = $xoopsDB->query($sql);      
	    list( $countId ) = $xoopsDB->fetchRow( $sqlqueryCount) ;      
      
      //$n = _LEX_SEL_PREFIX_NAME.$h;
      //$$n = $name;
      //$$n = $myts->makeTboxData4Save($$n);

      $txtId          = _LEXLIST_PREFIX_ID.$h;      
      $txtName        = _LEXLIST_PREFIX_NAME.$h;
  	  $link = "admin_list.php?op=edit&idList=".$idList;
    //jjd_echo ("-<".$tcat[$h]."-".$$n.">-", _LEXJJD_DEBUG_VAR);
    
        echo "<TR>"._br;
        echo "<TD align='right' >".$idList." <INPUT TYPE=\"hidden\" id='".$txtId."'  NAME='".$txtId."'  size='1%'"." VALUE='".$idList."'></TD>"._br;
        
       // echo "<TD align='left'  ><INPUT TYPE=\"text\" id='".$txtName."'  NAME='".$txtName."'  size='60%'"." VALUE='".$name."'></TD>"._br;
  	   echo "<TD align='left' width = '50%' ><A href='".$link."'>".$name."</A></TD>";
        
        //-----------------------------------------------------------------------
        
        //-----------------------------------------------------------------------        
        echo "<TD align='center'>";        

  	   echo "<A href='".$link."'><img src='"._JJDICO_EDIT."' border=0 Alt='"._AD_LEX_EDIT."' title='"._AD_LEX_EDIT."' width='20' height='20' ALIGN='absmiddle'></A>";
        echo "</td>";        
        //-----------------------------------------------------------------------        
        echo "<TD align='center'>";        
      	if( $countId == 0 AND $sqlfetch['killable'] == 1) {
      	   $link = "admin_list.php?op=remove&idList={$idList}&name={$name}";
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
    <input type='button' name='new' value='"._AD_LEX_NEW."' onclick='".buildUrlJava("admin_list.php?op=new",false)."'>    
    </td>    

    
  </tr>";

    
	CloseTable();
	//xoops_cp_footer();

      //------------------------------------------------------------------
      //$xoopsTpl->append('dic_post', $post);
    


	exit();
}
//-----------------------------------------------------------------

function editList($p){
	Global $xoopsModuleConfig, $xoopsDB, $xoopsConfig, $xoopsModule;
	$myts =& MyTextSanitizer::getInstance();
	//displayArray($p, "***************");

	  //xoops_cp_header();
    OpenTable();    
    echo _JJD_JSI_TOOLS._JJD_JSI_SPIN._LEX_JSI_LEXIQUE._br;
    //------------------------------------------------  
    $ligneDeSeparation = "<TR><td colspan='2'><hr></td></TR>"._br;  
    //------------------------------------------------    
    
	  echo "<B>"._AD_LEX_ADMIN." ".$xoopsConfig['sitename']."</B><p>";
  	echo "<B>"._AD_LEX_LIST_MANAGEMENT."</B><P>";
    
 		echo "<FORM ACTION='admin_list.php?op=save' METHOD=POST>"._br;

    echo "<table width='80%'>"._br;
    //------------------------------------------------    
    //$idList=0;
    
    //---idList
    echo "<TR>"._br;
    echo "<TD align='left' >".""."</TD>"._br;
    echo "<TD align='right' >".$p['idList']." <INPUT TYPE=\"hidden\" id='idList'  NAME='idList'  size='1%'"." VALUE='".$p['idList']."'></TD>"._br;
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
    //---liste des items

    $definition1 = $myts->makeTareaData4Show($p['items'], "1", "1", "1");
   	//$desc1 = getXME($definition1, 'txtItems', '','100%');
   	//$definition1 =  $p['items'];
   	$desc1 = getEditorHTML(_EDITOR_TEXTAREA, $definition1, $name = 'txtItems', '               
                       Texte', '80%', '300px', 16 , 69 );

    echo "<TR>"._br;
    echo "<TD align='left' ><B>"._AD_LEX_LISTITEMS."</B></TD>"._br;    
    echo "<TD align='left'  >";
      echo $desc1->render();
    echo "</TD>"._br;
    echo "</TR>"._br;
    	
  
    //----------------------------------------------------------    
    //---trier la liste
    //a faire : prevoir une option qui permettent d'afficher la liste triee
    //sans en changer l'ordre dans l'original - JJD
    /*

    $list = array (_NO, _YES);    
    $selected = getlistSearch ('txtSorth', $list, 0, $p['sorth']);
    
    echo "<TR>"._br;
    echo "<TD align='left' ><B>"._AD_LEX_SORTHLIST."</B></TD>"._br;    
    echo "<TD align='left'>".$selected."</TD>"._br;    
    echo "</TR>"._br;
    echo "<TR></TR>"._br;

    echo buildDescription(_AD_LEX_SORTH_LIST_DSC);    
    */    
    //----------------------------------------------------------    

    //----------------------------------------------------------
    
    //Name, other, showAllLetters, frameDelimitor, letterSeparator, rows
    //------------------------------------------------        
    echo "</table>"._br;



echo "<TABLE BORDER=0 CELLPADDING=2 CELLSPACING=3>
  <tr valign='top'>
    <td align='left' ><input type='button' name='cancel' value='"._CANCEL."' onclick='".buildUrlJava("admin_list.php",false)."'></td>
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
function saveList($p){
//  displayArray ($p,'List');
  
	global $xoopsModuleConfig, $xoopsDB;
	$myts =& MyTextSanitizer::getInstance();
	//$t['txtItems'] = string2sql($t['txtItems']);
  $items = $myts->makeTareaData4Save($p['txtItems']);
  $p['txtSorth'] = "0"; // provisoir en attendant de gerer l'ption de tri a l'affichage des listes
  
	if ($p['idList'] == 0 ){
      $sql = "INSERT INTO "._LEX_TFN_LIST
             ." (Name, items, sorth, killable) "
             ."Values ("
             ."'".$p['txtName']."', "
             ."'{$items}', "             
             .$p['txtSorth'].", "
             ."1 )";



    	$xoopsDB->query($sql);
  
  }else{
      $sql = "UPDATE "._LEX_TFN_LIST. " SET "
             ."Name            = '".$p['txtName']."', "
             ."items           = '{$items}', "             
             ."sorth           = ".$p['txtSorth'] 
             ." WHERE idList    = ".$p['idList'];
      

    	$xoopsDB->query($sql);
  
  }


      //echo "<hr>saveList<br>{$sql}<hr>";

}

/****************************************************************************
 *
 ****************************************************************************/

function removeList($idList){
  
	global $xoopsModuleConfig, $xoopsDB;
	
   
  $sql = "DELETE FROM "._LEX_TFN_LIST." WHERE idList = ".$idList;
  
	$xoopsDB->query($sql);

}

/****************************************************************************
 *
 ****************************************************************************/
function getList ($idList){
	global $xoopsModuleConfig, $xoopsDB;

  if ($idList == 0) {
      $p = array ('idList' => '0', 
                  'name' => 'nom de la liste',
                  'items' => '',
                  'sorth' => 0);
  
  }
  else {
    	
//    $sql = "SELECT  idList,name,items,sorth "
//          ." FROM "._LEX_TFN_LIST
//          ." WHERE idList = ".$idList;
    $sql = "SELECT * FROM "._LEX_TFN_LIST." WHERE idList = ".$idList;
  
    $sqlquery=$xoopsDB->query($sql);
    //$sqlfetch=$xoopsDB->fetchArray($sqlquery);
    $p = $xoopsDB->fetchArray($sqlquery);    
    //$p = array('idList'          => $sqlfetch['idList'],
    //           'name'            => $sqlfetch['name'],
    //           'items'           => $sqlfetch['items'],
    //           'sorth'           => $sqlfetch['sorth']);    
    
    
    
    
//    displayArray ($p);    
  }
  
  return $p;
}
//---------------------------------------------------------------------
$bOk = true;
if ($bOk){admin_xoops_cp_header(_LEX_ONGLET_LIST, $xoopsModule);}   

   

switch($op) {
  case "list":
    listList();
    break;

  case "new":
    $p = getList (0);
    editList ($p);
    //newList ();    
    break;

  case "edit":
    $p = getList ($_GET['idList']);
    editList ($p);
    break;


  case "remove":
    //xoops_cp_header();
    $msg = sprintf(_AD_LEX_CONFIRM_DEL, "<b>{$_GET['name']} (id:{$idList})</b>" , _AD_LEX_LIST);            
    xoops_confirm(array('op'          => 'removeOk', 
                        'idList     ' => $_GET['idList'] ,
                        'ok'          => 1),
                        "admin_list.php", $msg );
    //xoops_cp_footer();
    
    break;

    
  case "removeOk":
    removeList ($_POST['idList']);
    redirect_header("admin_list.php",1,_AD_LEX_ADDOK);    
    break;
    
    
  case "save":
    saveList($_POST);
    redirect_header("admin_list.php",1,_AD_LEX_ADDOK);  
    break;
    
  case "cancel":

    break;
    
    
		
	default:
    //redirect_header("admin_list.php",1,_AD_LEX_ADDOK);		
    break;
}

if ($bOk){admin_xoops_cp_footer();}

?>
