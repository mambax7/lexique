<?php
//  ------------------------------------------------------------------------ //
//            LEXIQUE - Module de gestion de lexiques pour XOOPS             //
//                    Copyright (c) 2006 JJ Delalandre                       //
//                       <http://kiolo.com>                                  //
//  ------------------------------------------------------------------------ //
/******************************************************************************

Module LEXIQUE version 1.6.2 pour XOOPS- Gestion multi-lexiques 
Copyright (C) 2007 Jean-Jacques DELALANDRE 
Ce programme est libre, vous pouvez le redistribuer et/ou le modifier selon les termes de la Licence Publique GÈnÈrale GNU publiÈe par la Free Software Foundation (version 2 ou bien toute autre version ultÈrieure choisie par vous). 

Ce programme est distribuÈ car potentiellement utile, mais SANS AUCUNE GARANTIE, ni explicite ni implicite, y compris les garanties de commercialisation ou d'adaptation dans un but spÈcifique. Reportez-vous ‡ la Licence Publique GÈnÈrale GNU pour plus de dÈtails. 

Vous devez avoir reÁu une copie de la Licence Publique GÈnÈrale GNU en mÍme temps que ce programme ; si ce n'est pas le cas, Ècrivez ‡ la Free Software Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307, …tats-Unis. 

DerniËre modification : juin 2007 
******************************************************************************/


include_once ("admin_header.php");
global $xoopsModule;
//-----------------------------------------------------------------------------------

//-------------------------------------------------------------
$vars = array(array('name' =>'op',        'default' => 'list'),
              array('name' =>'idLexique', 'default' => 0),
              array('name' =>'id',        'default' => 0),
              array('name' =>'idCaption', 'default' => 0),              
              array('name' =>'pinochio',  'default' => false));
              
require (_LEX_JJD_PATH."include/gp_globe.php");
//-------------------------------------------------------------

function listCaption($bEmpty = false){
	Global $xoopsModuleConfig, $xoopsDB, $xoopsConfig, $xoopsModule;
	
	

	$myts =& MyTextSanitizer::getInstance();
	
    $sql = "SELECT * FROM ".$xoopsDB->prefix(_LEX_TBL_CAPTION)
          ." WHERE idCaption > 0 ORDER BY name";
    $sqlquery=$xoopsDB->query($sql);

	  //xoops_cp_header();
    OpenTable();    
    echo _JJD_JSI_TOOLS._JJD_JSI_SPIN._LEX_JSI_LEXIQUE._br;
    
	  echo "<B>"._AD_LEX_ADMIN." ".$xoopsConfig['sitename']."</B><p>";
  	echo "<B>"._AD_LEX_CAPTION_MANAGEMENT."</B><P>";
		echo "<FORM ACTION='index.php' METHOD=POST>";
    
    echo "<table >";

    echo "<TR>";
    echo "<TD align='right' > </TD>";
    echo "<TD align='left'   > </TD>";
    echo "<TD align='center'  > </TD>";    
    echo "<TD align='center'   > </TD>";    
    echo "</TR>";
    
    //------------------------------------------------        
    $h = 0;
    while ($sqlfetch=$xoopsDB->fetchArray($sqlquery)) {

     	$idCaption  = $sqlfetch['idCaption'];    	
    	$name       = $sqlfetch['name'];      
     
      $sql = "SELECT count(idCaption) as count FROM ".$xoopsDB->prefix(_LEX_TBL_LEXIQUE). " "
            ."WHERE idCaption = ".$idCaption;     
      $sqlqueryTermes = $xoopsDB->query($sql);      
	    list( $countCaption ) = $xoopsDB->fetchRow( $sqlqueryTermes ) ;      
      
        echo "<TR>"._br;
         //-----------------------------------------------------------------------        
       echo "<TD align='right' >{$idCaption} <INPUT TYPE=\"hidden\" NAME='"._LEX_PREFIX_ID."{$h}'  size='1%'"." VALUE='{$idCaption}'></TD>"._br;
         //-----------------------------------------------------------------------
  	    $link = "admin_caption.php?op=edit&idCaption=".$idCaption;            	   
        echo "<TD align='left'><A href='{$link}'>{$name}</A></TD>";
         
         //-----------------------------------------------------------------------

        echo "<TD align='center'>";        
    	  echo "<A href='".$link."'><img src='"._JJDICO_EDIT."' border=0 Alt='"._AD_LEX_EDIT."' title='"._AD_LEX_EDIT."' width='20' height='20' ALIGN='absmiddle'></A>";
        echo "</td>";    
        //-----------------------------------------------------------------------
        
        
        echo "<TD align='center'>";        
      	if( $countCaption == 0 ) {
      	   $link = "admin_caption.php?op=remove&idCaption={$idCaption}&name={$name}";
          //echo "<input type='button' name='clear' value='"._AD_LEX_CLEAR."' onclick='".buildUrlJava("$link",false)."'>";

      	   echo "<A href='{$link}'><img src='"._JJDICO_REMOVE."' border=0 Alt='"."_AD_LEX_DELETE"."' title='"._AD_LEX_DELETE."' width='20' height='20' ALIGN='absmiddle'></A>";            
      	}
        echo "</td>";      	
        
        
        //-----------------------------------------------------------------------      
//echo $name."<br>";
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
    <input type='button' name='new' value='"._AD_LEX_NEW."' onclick='".buildUrlJava("admin_caption.php?op=new",false)."'>    
    </td>    

    


    <td align='right'><input type='submit' name='submit' value='"._AD_LEX_FREE."'></td>
  </tr>
  </table>
  </form>";

    
	CloseTable();
	//xoops_cp_footer();

      //------------------------------------------------------------------
      //$xoopsTpl->append('dic_post', $post);
    

  //redirect_header("admin_family.php",1,_AD_LEX_ADDOK);
	exit();
}


//-----------------------------------------------------------------



/****************************************************************************
 *
 ****************************************************************************/
function SaveCaption ($p) {
	
	Global $xoopsModuleConfig, $xoopsDB, $xoopsConfig, $xoopsModule;
	$myts =& MyTextSanitizer::getInstance();

    //displayArray ($_POST, "POST libelle");
    //displayArray ($p, "POST libelle");    
    $tr = getArrayKeyOnPrefix ($p, _LEX_PREFIX_NAME);
    
//    displayArray ($tr, "nouveaux libelles");   
    setCaption ($p['idCaption'], $tr, $p['txtName']); 

}/***************************************************************************
 *
 ***************************************************************************/
function editCaption($p, $idCaption, $bEmpty = false){
//si $bEmpty = true, les zone ne sont pas remplie en vue de vider l'ensemble apräs validation

	Global $xoopsModuleConfig, $xoopsDB, $xoopsConfig, $xoopsModule,$info;
	$myts =& MyTextSanitizer::getInstance();
	
   //$lib = getCaption ($idCaption, $lexLib, false);	
	 //$def = getCaptionDefault ($idCaption);
	
   $lib = $p['captionLib'];	
	 $def = $p['captionDef'];

	  //xoops_cp_header();
    OpenTable();    
    






    //------------------------------------------------  
    $ligneDeSeparation = "<TR><td colspan='2'><hr></td></TR>"._br;  
    //------------------------------------------------    
    
	  echo "<B>"._AD_LEX_ADMIN." ".$xoopsConfig['sitename']."</B><br>";
  	echo "<B>"._AD_LEX_CAPTION_MANAGEMENT."</B><br>";
    
 		echo "<FORM ACTION='admin_caption.php?op=save' METHOD=POST>"._br;

    echo "<table width='80%'>"._br;
    //------------------------------------------------    
    //$idFamily=0;
    
    //---idFamily
    echo "<TR>"._br;
    echo "<TD align='left' >"."</TD>"._br;
    echo "<TD align='right' >".$p['idCaption']." <INPUT TYPE=\"hidden\" id='idCaption'  NAME='idCaption'  size='1%'"." VALUE='".$p['idCaption']."'></TD>"._br;
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
     echo "</table>"._br;    






    
    echo "<table>";
    //------------------------------------------------        
    $h = 0;
    //displayArray ($lib,'libelle');
    
    
      $myts =& MyTextSanitizer::getInstance();   
    	

    while (list($key, $value) = each ($lib)){
      if ($key == 'family' OR $key == 'idCaption' ) continue;
      
      if ($def[$key] == '' ) continue;
       $value = $myts->makeTboxData4Show($value);            
       echo "<TR>"._br;
      
  	   echo "<TD align='right'  >{$def[$key]}</TD>";        
       $txtName = _LEX_PREFIX_NAME.$key;
       if ($bEmpty) {$value = '';}
       echo "<TD align='left'  ><INPUT TYPE=\"text\" NAME='{$txtName}'  size='60%'"." VALUE='{$value}'></TD>"._br;
   }

     
    echo "</table>"._br;



$linkCancel   = buildUrlJava ("admin_caption.php?op=list",  false);
$linkClear    = buildUrlJava ("admin_caption.php?op=clear&idCaption={$idCaption}",  false);

echo "<TABLE BORDER=0 CELLPADDING=2 CELLSPACING=3>
  <tr valign='top'>
    <td align='left' ><input type='button' name='cancel'    value='"._CANCEL."' onclick='".$linkCancel."'></td>
    <td align='left' width='200'></td>

    <td align='right'>
    <input type='submit' value='"._AD_LEX_SAVE."'>    
    </td>    

    
  </tr>
  </table>
  </FORM>";
    
	CloseTable();
	//xoops_cp_footer();

      //------------------------------------------------------------------
    


	exit();
}

function editCaption2 ($p){
	Global $xoopsModuleConfig, $xoopsDB, $xoopsConfig, $xoopsModule;
	$myts =& MyTextSanitizer::getInstance();
	$idFamily = $p['idFamily'];

	  //xoops_cp_header();
    OpenTable();    
    //------------------------------------------------  
    $ligneDeSeparation = "<TR><td colspan='2'><hr></td></TR>"._br;  
    //------------------------------------------------    
    
	  echo "<B>"._AD_LEX_ADMIN." ".$xoopsConfig['sitename']."</B><br>";
  	echo "<B>"._AD_LEX_CAPTION_MANAGEMENT."</B><br>";
    
 		echo "<FORM ACTION='admin_caption.php?op=save' METHOD=POST>"._br;

    echo "<table width='80%'>"._br;
    //------------------------------------------------    
    //$idFamily=0;
    
    //---idFamily
    echo "<TR>"._br;
    echo "<TD align='left' >"."</TD>"._br;
    echo "<TD align='right' >".$p['idCaption']." <INPUT TYPE=\"hidden\" id='idCaption'  NAME='idCaption'  size='1%'"." VALUE='".$p['idCaption']."'></TD>"._br;
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
     echo "</table>"._br;    
    
	OpenTable();    
	///////////////////////////////////////////////////////////////////
echo "<TABLE BORDER=0 CELLPADDING=2 CELLSPACING=3>";
//echo "--------------------<>br";

//$lexique = $_GET['lexique'];

//echo "lexique = ".$lexique."<br>";
  $wz1 = '100%'; 
  $wz2 = '5'; 

  $list = $p['captionSet'];   //loadCategory ($idFamily);
//displayArray($list, "Categories");  
  //----------------------------------------------------------------------- 
//  for ($h = 0; $h < $nbCatMax; $h++){  
     //echo "<hr>"._br;   
  for ($h = 0; $h < count($list); $h++){
    $titem = $list [$h];
    $i = $h + 1;
    $j =$h;// $tcat['idCategory'];
    echo "<TR>"._br;
    echo "<TD align='right'>{$i}</TD>"._br;
    echo "<INPUT TYPE='hidden' NAME='"._LEX_PREFIX_ID."_{$j}' VALUE='{$titem['idCaption']}'>";

    echo "<TD><INPUT TYPE=\"text\" NAME='"._LEX_PREFIX_NAME."{$j}' SIZE='".$wz1."' VALUE='{$titem['name']}'></TD>"._br;


    
    if ($tcat['state'] == 1){$value = 'checked';} else {$value = 'unchecked';}    
    echo "<TD align='center'  ><input type='checkbox' NAME='"._PREFIX_STATE."_{$j}' size='5%' {$value}></td>"._br;
    
    
    echo "</TR>"._br;
  }

echo "</table>";   
  ///////////////////////////////////////////////////////////////////  
  CloseTable(); 
	
	
  echo "<br>";
  OpenTable();

  

//$linkAddCat = buildUrlJava ("admin_Caption.php?idCaption=".$idCaption."&op=addNewCategory",     false);
//$linkAddDel = buildUrlJava ("admin_Caption.php?idCaption=".$idCaption."&op=removeLastCategory", false);
//$linkAddZap = buildUrlJava ("admin_Caption.php?idCaption=".$idCaption."&op=removeAllCategory",  false);
$linkCancel = buildUrlJava ("admin_Caption.php?op=list",  false);

/*
    <td align='left' ><input type='button' name='addDelCat' value='"._AD_LEX_CAT_REMOVEALL."' onclick='".$linkAddZap."'></td>
    <td align='left' ><input type='button' name='addDelCat' value='"._AD_LEX_CAT_REMOVE."' onclick='".$linkAddDel."'></td>
    <td align='left' ><input type='button' name='addNewCat' value='"._AD_LEX_CAT_ADD."' onclick='".$linkAddCat."'></td> 

*/
echo "<TABLE BORDER=0 CELLPADDING=2 CELLSPACING=3
  <tr valign='top'>
    <td align='left' ><input type='button' name='cancel' value='"._CANCEL."' onclick='".$linkCancel."'></td>
    <td align='left' width='10'></td>


    <td align='right'>
    <input type='submit' name='submit' value='"._AD_LEX_VALIDER."' )'>    
    </td>    
  </tr>
  </table>";

  CloseTable();
  
echo  "</form>";    
	CloseTable();
	//xoops_cp_footer();


	exit();
}


/****************************************************************************
 *
 ****************************************************************************/
function RemoveCaption ($idCaption) {
	Global $xoopsModuleConfig, $xoopsDB, $xoopsConfig, $xoopsModule;
  
  
  $sql = "DELETE FROM ".$xoopsDB->prefix(_LEX_TBL_CAPTIONSET) 
        ." WHERE idCaption = {$idCaption}";
  $xoopsDB->query($sql);
        
  $sql = "DELETE FROM ".$xoopsDB->prefix(_LEX_TBL_CAPTION) 
        ." WHERE idCaption = {$idCaption}";
  $xoopsDB->query($sql);
  
}
/****************************************************************************
 *
 ****************************************************************************/
function buildCaptionArray ($idCaption){
	global $xoopsModuleConfig, $xoopsDB;


  if ($idCaption == 0) {
      $p = array ('$idCaption' => '0', 
                  'name'       => _AD_LEX_CAPTION,
                  'captionLib' => array(),
                  'captionDef' => array());  
  }else {
    	
    $sql = "SELECT  * "
          ."FROM ".$xoopsDB->prefix(_LEX_TBL_CAPTION)." "
          ."WHERE idCaption = {$idCaption}";
  
    //echo $sql."<br>";          
    $sqlquery=$xoopsDB->query($sql);

    $sqlfetch=$xoopsDB->fetchArray($sqlquery);
    $p = array('idCaption'  => $sqlfetch['idCaption'],
               'name'       => $sqlfetch['name'],
               'captionLib' => array(),
               'captionDef' => array());                 
               
  
  }
    
  $p['captionLib']  = getCaption ($idCaption, $lexLib, false ) ;    
  $p['captionDef']  = getCaptionDefault ($idCaption ) ;   

  return $p;    

}


/****************************************************************************
 *
 ****************************************************************************/

//---------------------------------------------------------------------
$bOk = true;
if ($bOk){admin_xoops_cp_header(_LEX_ONGLET_CAPTION, $xoopsModule);}   

switch($op) {

  case "list":
    listCaption();
    break;


  case "new":
    $p=buildCaptionArray($idCaption);
    editCaption ($p);
    break;
    
  case "edit":
    $p = buildCaptionArray($idCaption);  
    editCaption ($p,$idCaption);
    break;
    
  case "clear":
    //listCaption(true);
    break;

  case "save":
    saveCaption ($_POST);
    redirect_header("admin_caption.php",1,_AD_LEX_ADDOK);    
    break;

  case "delete":
  case "remove":
    //xoops_cp_header();
    $msg = sprintf(_AD_LEX_CONFIRM_DEL, "<b>{$_GET['name']} (id:{$idCaption})</b>" , _AD_LEX_CAPTIONS);            
    xoops_confirm(array('op'         => 'removeOk', 
                        'idCaption'  => $_GET['idCaption'] ,
                        'ok'         => 1),
                  "admin_caption.php", $msg );
    //xoops_cp_footer();
    
    break;
    


    
  case "removeOk":
    removeCaption ($_POST['idCaption']);
    redirect_header("admin_caption.php",1,_AD_LEX_ADDOK);    
    break;


}


if ($bOk){admin_xoops_cp_footer();}   


?>
