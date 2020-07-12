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

define ('_LEXFAM_PREFIX_ID'    , 'id_');
define ('_LEXFAM_PREFIX_NAME'  , 'name_');

//-------------------------------------------------------------
$vars = array(array('name' =>'op',        'default' => 'list'),
              array('name' =>'idLexique', 'default' => 0),
              array('name' =>'idFamily',  'default' => 0),              
              array('name' =>'id',        'default' => 0),
              array('name' =>'pinochio',  'default' => false));
              
require (_LEX_JJD_PATH."include/gp_globe.php");
//-------------------------------------------------------------

//---------------------------------------------------------------------

function listFamily(){
	Global $xoopsModuleConfig, $xoopsDB, $xoopsConfig, $xoopsModule;
	$myts =& MyTextSanitizer::getInstance();

	
	
    $sql = "SELECT * FROM ".$xoopsDB->prefix(_LEX_TBL_FAMILY)." ORDER BY Name";
    $sqlquery=$xoopsDB->query($sql);

	  //xoops_cp_header();
    OpenTable();    
    echo _JJD_JSI_TOOLS._JJD_JSI_SPIN._LEX_JSI_LEXIQUE._br;
    
	  echo "<B>"._AD_LEX_ADMIN." ".$xoopsConfig['sitename']."</B><br>";
  	echo "<B>"._AD_LEX_CAT_MANAGEMENT."</B><P>";
    
    echo "<table>";
    //------------------------------------------------        
    $h = 0;
    while ($sqlfetch=$xoopsDB->fetchArray($sqlquery)) {
      $idFamily  = $sqlfetch["idFamily"];
    	$name      = $sqlfetch["name"];    	
    	$maxCount  = $sqlfetch["maxCount"];
            
      $sql = "SELECT count(idFamily) as count FROM ".$xoopsDB->prefix(_LEX_TBL_LEXIQUE). " "
            ."WHERE idFamily = {$idFamily} ";     
      $sqlqueryTermes = $xoopsDB->query($sql);      
	    list( $countId ) = $xoopsDB->fetchRow( $sqlqueryTermes ) ;      
      
      $n = _LEXFAM_PREFIX_NAME.$h;
      $$n = $name;
      $$n = $myts->makeTboxData4Save($$n);

      $txtId          = _LEXFAM_PREFIX_ID.$h;      
      $txtName        = _LEXFAM_PREFIX_NAME.$h;
  	   $link = "admin_family.php?op=edit&id=".$idFamily;
    //jjd_echo ("-<".$tcat[$h]."-".$$n.">-", _LEXJJD_DEBUG_VAR);
    
        echo "<TR>"._br;
        echo "<TD align='right' >(".$idFamily.") <INPUT TYPE=\"hidden\" id='".$txtId."'  NAME='".$txtId."'  size='1%'"." VALUE='".$idFamily."'></TD>"._br;
   	    echo "<TD align='left'  ><A href='".$link."'>".$name."</A></TD>";        
        
        echo "<TD align='right'  >({$countId} "._AD_LEX_LEXIQUES.")</TD>"._br;        
        //-----------------------------------------------------------------------
        
        //-----------------------------------------------------------------------        
        echo "<TD align='center'>";        

  	   echo "<A href='".$link."'><img src='"._JJDICO_EDIT."' border=0 Alt='"._AD_LEX_EDIT."' title='"._AD_LEX_EDIT."' width='20' height='20' ALIGN='absmiddle'></A>";
        echo "</td>";        
        //-----------------------------------------------------------------------        
        echo "<TD align='center'>";        
      	if( $countId == 0 ) {
      	   $link = "admin_family.php?op=remove&idFamily={$idFamily}&name={$name}";
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
    <td align='left' ><input type='button' name='cancel' value='"._CLOSE."' onclick='".buildUrlJava(XOOPS_URL._LEXCST_DIR_ROOT."admin/index.php",false)."'></td>
    <td align='left' width='200'></td>

    <td align='right'>
    <input type='button' name='new' value='"._AD_LEX_NEW."' onclick='".buildUrlJava("admin_family.php?op=new",false)."'>    
    </td>    

    
  </tr>";

    
	CloseTable();
	//xoops_cp_footer();

      //------------------------------------------------------------------
      //$xoopsTpl->append('dic_post', $post);
    


	exit();
}
//-----------------------------------------------------------------

//-----------------------------------------------------------------

function editCategory($p){
	Global $xoopsModuleConfig, $xoopsDB, $xoopsConfig, $xoopsModule;
	$myts =& MyTextSanitizer::getInstance();
	$idFamily = $p['idFamily'];

	  //xoops_cp_header();
    OpenTable();    
    //------------------------------------------------  
    $ligneDeSeparation = "<TR><td colspan='2'><hr></td></TR>"._br;  
    //------------------------------------------------    
    
	  echo "<B>"._AD_LEX_ADMIN." ".$xoopsConfig['sitename']."</B><br>";
  	echo "<B>"._AD_LEX_CAT_MANAGEMENT."</B><br>";
    
 		echo "<FORM ACTION='admin_family.php?op=save' METHOD=POST>"._br;

    echo "<table width='80%'>"._br;
    //------------------------------------------------    
    //$idFamily=0;
    
    //---idFamily
    echo "<TR>"._br;
    echo "<TD align='left' >"."</TD>"._br;
    echo "<TD align='right' >".$p['idFamily']." <INPUT TYPE=\"hidden\" id='idFamily'  NAME='idFamily'  size='1%'"." VALUE='".$p['idFamily']."'></TD>"._br;
    echo "</TR>"._br;    
    echo $ligneDeSeparation;    
    //----------------------------------------------------------    
    //---Name
    echo "<TR>"._br;
    echo "<TD align='left' ><B>"._AD_LEX_NOM." (".$idFamily.")"."</B></TD>"._br;    
    //echo "<br>"._AD_LEX_ALPHABET_DSC;
    echo "<TD align='left'  ><INPUT TYPE=\"text\" id='txtName'  NAME='txtName'  size='60%'"." VALUE='".$p['name']."'></TD>"._br;
    echo "</TR>"._br;
    echo $ligneDeSeparation;    
    //----------------------------------------------------------
     echo "</table>"._br;    
    
	OpenTable();    

  	include_once("admin_category.php");	
  
  CloseTable(); 
	
	
  echo "<br>";
  OpenTable();

  

$linkAddCat = buildUrlJava ("admin_family.php?idFamily=".$idFamily."&op=addNewCategory",     false);
$linkAddDel = buildUrlJava ("admin_family.php?idFamily=".$idFamily."&op=removeLastCategory", false);
$linkAddZap = buildUrlJava ("admin_family.php?idFamily=".$idFamily."&op=removeAllCategory",  false);
$linkCancel = buildUrlJava ("admin_family.php?op=list",  false);

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

      //------------------------------------------------------------------
      //$xoopsTpl->append('dic_post', $post);
    


	exit();
}



//---------------------------------------------------------------------
function removeFamily ($idFamily) {
	Global $xoopsModuleConfig, $xoopsDB, $xoopsConfig, $xoopsModule;
	
  //verifier que la famille n'est pas utiliser par un lexique
  $sql = "SELECT count(idFamily) as nbFamily FROM ".$xoopsDB->prefix(_LEX_TBL_LEXIQUE)
        ." WHERE idFamily = ".$idFamily;
	$sqlquery = $xoopsDB->query($sql);
  list( $nbFamily ) = $xoopsDB->fetchRow( $sqlquery ) ;
  
  if ($nbFamily == 0){
    $sql = "DELETE FROM ".$xoopsDB->prefix(_LEX_TBL_CATEGORY)." "
          ."WHERE idFamily = ".$idFamily;
     $xoopsDB->query($sql);
     //echo $sql."<br>";
      
    $sql = "DELETE FROM ".$xoopsDB->prefix(_LEX_TBL_FAMILY)." "
         ."WHERE idFamily = ".$idFamily;
     $xoopsDB->query($sql);
     //echo $sql."<br>";


  }else{
  
  }



}



//---------------------------------------------------------------------
//function SaveCatDefinition ($tcat, $idFamily, $name, $state) {
function SaveCatDefinition ($p) {
	global $xoopsConfig, $xoopsDB;
	//$nbCatMax = getValeurBornee('nbcategorymax', _MINCATEGORY, _MAXCATEGORY);
	$myts =& MyTextSanitizer::getInstance();
	
	$tcat = htmlArrayOnPrefix ($p, array(_PREFIX_IDCATEGORY,
                                       _PREFIX_CAT,
                                       _PREFIX_ORD,
                                       _PREFIX_STATE));
  
	saveCategory($tcat, $p['idFamily'], $p['txtName']);
}
//-------------------------------------------------------------------

//---------------------------------------------------------------------
function SaveCatDefinition2 ($tcat, $idFamily, $name, $state) {
	global $xoopsConfig, $xoopsDB;

	$myts =& MyTextSanitizer::getInstance();

	for ($h = 0; $h < count($tcat); $h++){
    $n = _PREFIX_CAT.$h;
    $$n = $tcat[$h];
    $$n = $myts->makeTboxData4Save($$n);
    //jjd_echo ("-<".$tcat[$h]."-".$$n.">-", _LEXJJD_DEBUG_VAR);
  }
  
/*
*/	
	saveCategory($tcat, $idFamily, $name);


}
//---------------------------------------------------------------------
function NewCatDefinition($idLexique, $state) {
	global $xoopsConfig, $xoopsModule;
	//xoops_cp_header();
	
  //insertion des scriopt javascript  
  echo _LEX_JSI_LEXIQUE._JJD_JSI_TOOLS._JJD_JSI_SPIN;

	echo "<B>"._AD_LEX_ADMIN." ".$xoopsConfig['sitename']."</B><p>";
	
  OpenTable();
  	echo "<B>"._AD_LEX_CAT_MANAGEMENT."</B><P>";
		echo "<FORM ACTION='admin_family.php?op=add&lexique=".$idLexique."' METHOD=POST>";

//---------------------------------------------------------------------

$link = _LEX_URL_ADMIN."admin_family.php";
$list = buildHtmlListFromTable ("lexique", _LEX_TBL_LEXIQUE, 
                                 "name", "IdLexique", "ordre", $idLexique,
                                 "gotoLexique(\"".$link."\");",
                                 'actif = 1', $width = "100");

echo $list;
//---------------------------------------------------------------------



  	echo "<INPUT TYPE=\"hidden\" NAME=\"state\" VALUE=\"O\">";

  	include_once("admin_category.php");  	
	CloseTable();
	//xoops_cp_footer();
		
		
}

//---------------------------------------------------------------------
function incrementCategory($idFamily, $Increment) {
	global $xoopsConfig, $xoopsModule, $xoopsDB;
  
  //si l'increment est egal a 0 on vide le tout
  if ($Increment == 0){
      $sql = "DELETE ".$xoopsDB->prefix(_LEX_TBL_CATEGORY)." "
            ."WHERE idFamily = ".$idFamily;
//	     displaySql ($sql);
       
       $xoopsDB->query($sql);
       //----------------------------------------------------------------
       $newMaxCount = 0;
          $sql = "UPDATE ".$xoopsDB->prefix(_LEX_TBL_FAMILY)." SET "
                ."maxCount = ".$newMaxCount." "            
                ."WHERE idFamily = ".$idFamily;
    
           $xoopsDB->query($sql);
  
  }else{
      $sql = "SELECT maxCount FROM ".$xoopsDB->prefix(_LEX_TBL_FAMILY)." "
            ."WHERE idFamily = ".$idFamily;
    	$sqlquery = $xoopsDB->query($sql);        
      list( $maxCount ) = $xoopsDB->fetchRow( $sqlquery ) ;
      
    
      $newMaxCount = getValeurBornee($maxCount + $Increment, _MINCATEGORY, _MAXCATEGORY);
      //echo "catgories = ".$categories." --- new categories = ".$newCategories."<br>";
      
      if ( $newMaxCount <> $maxCount){
          $sql = "UPDATE ".$xoopsDB->prefix(_LEX_TBL_FAMILY)." SET "
                ."maxCount = ".$newMaxCount." "            
                ."WHERE idFamily = ".$idFamily;
    
           $xoopsDB->query($sql);
  
      }
  }     
}

/****************************************************************************
 *
 ****************************************************************************/
function getCategory ($idFamily){
	global $xoopsModuleConfig, $xoopsDB;
$catMax = $xoopsModuleConfig ['categoriesMax'];

  if ($idFamily == 0) {
      $p = array ('idFamily'   => '0', 
                  'name'       => 'nom de la famille',
                  'maxCount'   => $catMax,
                  'categories' => array());
  

        
 
  }
  else {
    	
    $sql = "SELECT  * "
          ."FROM ".$xoopsDB->prefix(_LEX_TBL_FAMILY)." "
          ."WHERE idFamily = ".$idFamily;
  
    //echo $sql."<br>";          
    $sqlquery=$xoopsDB->query($sql);
    $sqlfetch=$xoopsDB->fetchArray($sqlquery);
    $p = array('idFamily'   => $sqlfetch['idFamily'],
               'name'       => $sqlfetch['name'],
               'maxCount'   => $sqlfetch['maxCount'],
               'categories' => array() );
               
               
    $sql = "SELECT  * "
          ." FROM ".$xoopsDB->prefix(_LEX_TBL_CATEGORY)
          ." WHERE idFamily = ".$idFamily
          ." ORDER BY showOrder, name, idCategory";
    $sqlquery=$xoopsDB->query($sql);               

    
  }
    
     $p ['categories']  = loadCategory ($idFamily ) ;    
   
    //displayArray ($p);    
  return $p;    

}



function getCategory2 ($idFamily){
	global $xoopsModuleConfig, $xoopsDB;
$catMax = $xoopsModuleConfig ['categoriesMax'];

  if ($idFamily == 0) {
      $p = array ('idFamily'   => '0', 
                  'name'       => 'nom de la famille',
                  'maxCount'   => $catMax,
                  'categories' => array());
  
    $categories = array();
        
 
    for ($h = 0; $h < $catMax; $h++){
        $categories [] = array ('idCategory' => 2 ^ $h ,
                                'name'       => '',
                                'state'      => 1,                                
                                'showOrder'  => $h * 10);
    
    }
     $p ['categories']  = $categories ;    
  }
  else {
    	
    $sql = "SELECT  * "
          ."FROM ".$xoopsDB->prefix(_LEX_TBL_FAMILY)." "
          ."WHERE idFamily = ".$idFamily;
  
    //echo $sql."<br>";          
    $sqlquery=$xoopsDB->query($sql);
    //$p =  $xoopsDB->fetchRow($sqlquery);
    $sqlfetch=$xoopsDB->fetchArray($sqlquery);
    $p = array('idFamily'   => $sqlfetch['idFamily'],
               'name'       => $sqlfetch['name'],
               'state'       => $sqlfetch['state'],               
               'maxCount'   => $sqlfetch['maxCount']);
               
               
    $sql = "SELECT  * "
          ." FROM ".$xoopsDB->prefix(_LEX_TBL_CATEGORY)
          ." WHERE idFamily = ".$idFamily
          ." ORDER BY showOrder, name, idCategory";
    $sqlquery=$xoopsDB->query($sql);               
    $categories = array();
        
	   while ($sqlfetch=$xoopsDB->fetchArray($sqlquery)) {
        $categories [] = array ('idCategory' => $sqlfetch['idCategory'],
                                'name'       => $sqlfetch['name'],
                                'state'       => $sqlfetch['state'],                                
                                'showOrder'  => $sqlfetch['showOrder']);
                                 
     }
     $p ['categories']  = $categories ; 
     
  }
    
    
    
    //displayArray ($p);    
  return $p;    

}

//---------------------------------------------------------------------
   

$bOk = true;
if ($bOk){admin_xoops_cp_header(_LEX_ONGLET_FAMILY, $xoopsModule);}   


switch($op) {

  case "list":
    listFamily();
    break;

  case "new":
    $p = getCategory (0);
    editCategory ($p);
    //newSelecteur ();    
    break;


  case "edit":
    $p = getCategory ($_GET['id']);
    editCategory ($p);
    break;
    

  case "addNewCategory":
		incrementCategory($idFamily, 1);
	  redirect_header("admin_family.php?op=edit&id=".$idFamily, 1,_AD_LEX_ADDOK);		
		break;


  case "removeLastCategory":
		incrementCategory($idFamily, -1);
	  redirect_header("admin_family.php?op=edit&id=".$idFamily, 1,_AD_LEX_ADDOK);		
		break;
		
  case "removeAllCategory":
		incrementCategory($idFamily, 0);
	  redirect_header("admin_family.php?op=edit&id=".$idFamily, 1,_AD_LEX_ADDOK);		
		break;
		
		
  case "save":
    $tcat = getArrayOnPrefix ($_POST, _PREFIX_CAT);
		//SaveCatDefinition($tcat, $_POST['idFamily'], $_POST['txtName']);
		SaveCatDefinition ($_POST);    
    
    
    //saveCategory($_POST);
    redirect_header("admin_family.php",1,_AD_LEX_ADDOK);  
    break;



  case "remove":
    //xoops_cp_header();
    $msg = sprintf(_AD_LEX_CONFIRM_DEL, "<b>{$_GET['name']} (id:{$idFamily})</b>" , _AD_LEX_CATEGORYS);            
    xoops_confirm(array('op'         => 'removeOk', 
                        'idFamily' => $_GET['idFamily'] ,
                        'ok'         => 1),
                  "admin_family.php", $msg );
    //xoops_cp_footer();
    
    break;
    
  case "removeOk":
    removeFamily ($_POST['idFamily']);
    redirect_header("admin_family.php",1,_AD_LEX_ADDOK);    
    break;


}


if ($bOk){admin_xoops_cp_footer();}   

?>
