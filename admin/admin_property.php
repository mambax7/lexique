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

//-------------------------------------------------------------
$vars = array(array('name' =>'op',         'default' => 'list'),
              array('name' =>'idProperty', 'default' => 0),
              array('name' =>'idProperty', 'default' => 0),
              array('name' =>'id',         'default' => 0),
              array('name' =>'pinochio',   'default' => false));
              
require (_LEX_JJD_PATH."include/gp_globe.php");
//-------------------------------------------------------------

define ('LEX_PROPERTY_MAX',   50);
define ('LEX_PROPERTY_FIRST', 0);


function listProperty($bEmpty = false){
	Global $xoopsModuleConfig, $xoopsDB, $xoopsConfig, $xoopsModule;
	
    

	$myts =& MyTextSanitizer::getInstance();
	
    $sql = "SELECT * FROM ".$xoopsDB->prefix(_LEX_TBL_PROPERTY)
          ." WHERE idProperty > 0 ORDER BY name";
    $sqlquery=$xoopsDB->query($sql);

	  //xoops_cp_header();
    OpenTable();    
	  echo _JJD_JSI_TOOLS._JJD_JSI_SPIN._LEX_JSI_LEXIQUE._br;    
	  
    echo "<B>"._AD_LEX_ADMIN." ".$xoopsConfig['sitename']."</B><p>";
  	echo "<B>"._AD_LEX_PROPERTY_MANAGEMENT."</B><P>";
		echo "<FORM ACTION='index.php' METHOD=POST>";
    
    echo "<table >";

    echo "<TR>";
    echo "<TD align='right' > </TD>";
    echo "<TD align='left'   > </TD>";
    echo "<TD align='center'  > </TD>";    
    echo "<TD align='center'   > </TD>";    
    echo "</TR>";
    
    /*
    //test si on trouve au moins une expression
    if ($xoopsDB->getRowsNum($sqlquery)==0){return;}
    $nbEnr = $xoopsDB->getRowsNum($sqlquery); 

    */
    //------------------------------------------------        
    $h = 0;
    while ($sqlfetch=$xoopsDB->fetchArray($sqlquery)) {

     	$idProperty  = $sqlfetch['idProperty'];    	
    	$name       = $sqlfetch['name'];      
     
      //$categories = $sqlfetch["categories"];
      
      /*
      */
      $sql = "SELECT count(idProperty) as count FROM ".$xoopsDB->prefix(_LEX_TBL_LEXIQUE). " "
            ."WHERE idProperty = ".$idProperty;     
      $sqlqueryTermes = $xoopsDB->query($sql);      
	    list( $countTermes ) = $xoopsDB->fetchRow( $sqlqueryTermes ) ;      
      
      
      
     
        echo "<TR>"._br;
         //-----------------------------------------------------------------------        
       echo "<TD align='right' >{$idProperty} <INPUT TYPE=\"hidden\" NAME='"._LEX_PREFIX_ID."{$h}'  size='1%'"." VALUE='{$idProperty}'></TD>"._br;
         //-----------------------------------------------------------------------
  	    $link = "admin_property.php?op=edit&idProperty=".$idProperty;            	   
        echo "<TD align='left'><A href='{$link}'>{$name}</A></TD>";
         
         //-----------------------------------------------------------------------

        echo "<TD align='center'>";        
    	  echo "<A href='".$link."'><img src='"._JJDICO_EDIT."' border=0 Alt='"._AD_LEX_EDIT."' title='"._AD_LEX_EDIT."' width='20' height='20' ALIGN='absmiddle'></A>";
        echo "</td>";    
        //-----------------------------------------------------------------------
        
        
        echo "<TD align='center'>";        
      	if( $countTermes == 0 ) {
      	   $link = "admin_property.php?op=delete&idProperty={$idProperty}&name={$name}";
          //echo "<input type='button' name='clear' value='"._AD_LEX_CLEAR."' onclick='".buildUrlJava("{$link}",false)."'>";

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
    <input type='button' name='new' value='"._AD_LEX_NEW."' onclick='".buildUrlJava("admin_property.php?op=new",false)."'>    
    </td>    

    


    <td align='right'><input type='submit' name='submit' value='"._AD_LEX_FREE."'></td>
  </tr>
  </table>
  </form>";

    
	CloseTable();
	//xoops_cp_footer();

  //------------------------------------------------------------------
	exit();
}


//-----------------------------------------------------------------



/****************************************************************************
 *
 ****************************************************************************/
function SaveProperty ($p) {
	
	Global $xoopsModuleConfig, $xoopsDB, $xoopsConfig, $xoopsModule;
	$myts =& MyTextSanitizer::getInstance();

    $sType = 'nsbnnn';
    $table = $xoopsDB->prefix(_LEX_TBL_PROPERTYSET);
    
    //si le jeu de propreite existe deja on le met a jour
    //sinon on cre le jeu de propriete
    //il s'agit de l'obejet parent
    $idProperty = $p['idProperty'];
    if ($idProperty == 0){
        $sql = "INSERT INTO ".$xoopsDB->prefix(_LEX_TBL_PROPERTY)
               ." (name) VALUES (\"{$p['txtName']}\")";
         $xoopsDB->query($sql);
         $idProperty = $xoopsDB->getInsertId() ;
    }else{
        $sql = "UPDATE ".$xoopsDB->prefix(_LEX_TBL_PROPERTY)
               ." SET name = '{$p['txtName']}'"
               ." WHERE idProperty = {$idProperty}";
         $xoopsDB->query($sql);
        
    }
    //-----------------------------------------------------------------

    $sType = 'nsbnnnn';
    $lstPrefix = 'idPropertySet;name;state;dataType;idList;rowSeparator;showOrder';
    $tSql =  sqlArrayOnPrefix ($p, $lstPrefix, $sType, $table,    
                               'idProperty', $idProperty) ;        
    
    for ($h=0; $h < count($tSql); $h++){
      //echo "<hr>SaveProperty<br>{$tSql[$h]}<hr>";
      $xoopsDB->query($tSql[$h]);    
    }
    propertyClean ();
  
  setByteAccess($idProperty);
}

/***************************************************************************
 *
 ***************************************************************************/
function editProperty($p, $idProperty, $bEmpty = false){
//si $bEmpty = true, les zone ne sont pas remplie en vue de vider l'ensemble aprŠs validation

	Global $xoopsModuleConfig, $xoopsDB, $xoopsConfig, $xoopsModule,$info;
	$myts =& MyTextSanitizer::getInstance();
	
   $list = $p['lstProperty'];	
	  //xoops_cp_header();
    OpenTable();    
  echo _JJD_JSI_TOOLS._JJD_JSI_SPIN._LEX_JSI_LEXIQUE._br;    






    //------------------------------------------------  
    $ligneDeSeparation = "<TR><td colspan='2'><hr></td></TR>"._br;  
    //------------------------------------------------    
    
	  echo "<B>"._AD_LEX_ADMIN." ".$xoopsConfig['sitename']."</B><br>";
  	echo "<B>"._AD_LEX_PROPERTY_MANAGEMENT."</B><br>";
    
 		echo "<FORM ACTION='admin_property.php?op=save' METHOD=POST>"._br;

    echo "<table width='80%'>"._br;
    //------------------------------------------------    
    //$idFamily=0;
    
    //---idProperty
    echo "<TR>"._br;
    echo "<TD align='left' >"."</TD>"._br;
    echo "<TD align='right' >".$p['idProperty']." <INPUT TYPE=\"hidden\" id='idProperty'  NAME='idProperty'  size='1%'"." VALUE='".$p['idProperty']."'></TD>"._br;
    echo "</TR>"._br;    
    echo $ligneDeSeparation;    
    //----------------------------------------------------------    
    //---Name
    echo "<TR>"._br;
    echo "<TD align='left' ><B>"._AD_LEX_NOM."</B></TD>"._br;    

    echo "<TD align='left'  ><INPUT TYPE=\"text\" id='txtName'  NAME='txtName'  size='60%'"." VALUE='".$p['name']."'></TD>"._br;
    echo "</TR>"._br;
    echo $ligneDeSeparation;    
    //----------------------------------------------------------
     echo "</table>"._br;    

    
    echo "<table>";
    echo "<TR>";
    echo "<TD align='center'>#</TD>";
    echo "<TD align='left'  > "._AD_LEX_PROPERTY."</TD>";
    echo "<TD align='center'>"._AD_LEX_TYPE."</TD>";   
    echo "<TD align='center'>"._AD_LEX_LIST."</TD>";     
    echo "<TD align='center'>"._AD_LEX_ROW."</TD>";    
    echo "<TD align='center'>"._AD_LEX_ORDER."</TD>";    
    echo "<TD align='center'>"._AD_LEX_ACTIF."</TD>";    
    echo "</TR>";
    
    //------------------------------------------------        
    $h = 0;
    //displayArray ($list,'********************');
    
    
      $myts =& MyTextSanitizer::getInstance();   
    $listDataType = array(_AD_LEX_DATATYPE_STANDARD,
                          _AD_LEX_DATATYPE_TITLE,
                          _AD_LEX_DATATYPE_EMAIL,
                          _AD_LEX_DATATYPE_URL);
    
    $listRowSeparator = array('aucune', 'avant','après','les deux');
    
    
    for ($h = 0; $h < count($list); $h++){
      $item =  $list[$h];
      //displayArray($item,"----- item ({$h})-----");
      /*

    $hr = false; //flage popur inserer une ligne selon rowBefore ou roxAfter, pour ne pas ne mettre deux      //---------------------------------------------------------------------
      // ajout d'un ligne d separation selon le parametrage de la propriete
      if ($item['rowBefore'] == 1 AND !$hr){
       echo "<TR colspan='5'><HR></td>";
      }
      //---------------------------------------------------------------------        
      */      
      echo "<tr>"._br;
      $showId = (_LEX_SHOWID)?"({$item ['idPropertySet']}/{$item ['byteAccess']})":'';
       echo "<TD align='left'  >
       	   <INPUT TYPE=\"hidden\" NAME=\"idPropertySet_{$h}\" VALUE=\"{$item ['idPropertySet']}\">
       	   <INPUT TYPE=\"hidden\" NAME=\"idProperty_{$h}\" VALUE=\"{$item ['idProperty']}\">
       	   {$showId}</TD>"._br;    

       $item ['name'] = $myts->makeTboxData4Show($item ['name']);           
       echo "<TD align='left'  >
           <INPUT TYPE='text' NAME='name_{$h}'  size='60%' VALUE='{$item ['name']}'>
           </TD>"._br;    


    //-- dataType
       echo "<TD>";    
       echo     getlistSearch ("dataType_{$h}", $listDataType, 0, $item['dataType']);
       echo  "</TD>"._br;


    //-- Liste

   //---Chapitre
    $lstList = buildHtmlListFromTable ("idList_{$h}", 
                                 _LEX_TBL_LIST,
                                 'name', 
                                 'idList', 
                                 'name', 
                                 $item['idList'],
                                 "",
                                 '',
                                 "150",
                                 '',
                                 true);                  
                                 
                                 
       echo "<TD>";    
       echo     $lstList;
       echo  "</TD>"._br;
                                 
    //echo buildSelecteur(_AD_TBA_CHAPITRE, _AD_TBA_CHAPITRE_DSC , $lstType );
   
      




    //-- rowSeparator
       echo "<TD>";    
       echo     getlistSearch ("rowSeparator_{$h}", $listRowSeparator, 0, $item['rowSeparator']);
       echo  "</TD>"._br;
           
       echo "<TD align='left'  >"
           ."<INPUT TYPE=\"text\" NAME='showOrder_{$h}'  size='10%' VALUE=\"{$item['showOrder']}\">"
           ."</TD>"._br;    
       
     
        $c = ($item['state']==1)?"checked":"";
        echo "<TD align='center'  ><input type='checkbox' NAME='state_{$h}' size='5%' value='ON' {$c}></td>"._br;
 
      echo "</tr>"._br;   
      
      
    }

     
    echo "</table>"._br;



$linkCancel   = buildUrlJava ("admin_property.php?op=list",  false);
$linkClear    = buildUrlJava ("admin_property.php?op=clear&idProperty={$idProperty}",  false);
$linkAdd    = buildUrlJava ("admin_property.php?op=Save&idProperty={$idProperty}",  false);

echo "<TABLE BORDER=0 CELLPADDING=2 CELLSPACING=3>
  <tr valign='top'>
    <td align='left' ><input type='button' name='cancel'    value='"._CANCEL."' onclick='{$linkCancel}'></td>
    <td align='left' width='200'></td>

    <td align='right'>
    <input type='submit' name='add' value='"._AD_LEX_ADDPROPERTY."'>    
    </td>    
    <td align='right'>
    <input type='submit'name='save'  value='"._AD_LEX_SAVE."'>    
    </td>    

    
  </tr>
  </table>
  </FORM>";
    
	CloseTable();
	//xoops_cp_footer();

      //------------------------------------------------------------------

	exit();
}


/****************************************************************************
 *
 ****************************************************************************/
function removeProperty ($idProperty) {
	Global $xoopsModuleConfig, $xoopsDB, $xoopsConfig, $xoopsModule;
  
  
  $sql = "DELETE FROM ".$xoopsDB->prefix(_LEX_TBL_PROPERTYSET) 
        ." WHERE idProperty = {$idProperty}";
  $xoopsDB->queryF($sql);
        
  $sql = "DELETE FROM ".$xoopsDB->prefix(_LEX_TBL_PROPERTY) 
        ." WHERE idProperty = {$idProperty}";
  $xoopsDB->queryF($sql);
  
}

function removeProperty2 ($idProperty) {
	Global $xoopsModuleConfig, $xoopsDB, $xoopsConfig, $xoopsModule;
  
  
  $sql = "DELETE FROM ".$xoopsDB->prefix(_LEX_TBL_PROPERTYSET) 
        ." WHERE idProperty = {$idProperty}";
  $xoopsDB->queryF($sql);
        
  $sql = "DELETE FROM ".$xoopsDB->prefix(_LEX_TBL_PROPERTY) 
        ." WHERE idProperty = {$idProperty}";
  $xoopsDB->queryF($sql);
  
}

/****************************************************************************
 *
 ****************************************************************************/
function buildPropertyArray ($idProperty){
	global $xoopsModuleConfig, $xoopsDB;


  if ($idProperty == 0) {
    //bin non je ferais rien      
      
  }else {
    	
    $sql = "SELECT  *  FROM ".$xoopsDB->prefix(_LEX_TBL_PROPERTY)." "
          ."WHERE idProperty = {$idProperty}";
  
    //echo $sql."<br>";          
    $sqlquery = $xoopsDB->query($sql);
    $p = $xoopsDB->fetchArray($sqlquery);
   //displayArray($p, $sql)   ;   

                              
    $sql = "SELECT  * FROM ".$xoopsDB->prefix(_LEX_TBL_PROPERTYSET)
          ." WHERE idProperty = {$idProperty}"
          ." ORDER BY showOrder,name";
    $sqlquery=$xoopsDB->query($sql);  
    $list = array(); 
    $i=0;            
    while ($sqlfetch = $xoopsDB->fetchArray($sqlquery)) {
      $list[] = $sqlfetch;
      if ($i<= $sqlfetch['showOrder']){$i = $sqlfetch['showOrder']+10;}
    }
  
  
  }
  
      for ($h = 0; $h < 8; $h++) {
        $list[] = array('idPropertySet' => 0,
                        'idProperty'    => $idProperty,
                        'name'          => '',
                        'dataType'      => 0,
                        'idList'        => 0,
                        'rowSeparator'  => 0,
                        'showOrder'     => $i + ($h * 10),
                        'state'         => 1,
                        'byteAccess'    => 0);
      }
    $p ['lstProperty']=  $list;  

  //displayArray($list, $sql)   ;
  return $p;    

}
/****************************************************************************
 * affecte a chaque propriete pour un numéo de byte pour les autorisaton d'acès
 * chaque jeu de propriété a sa propre numérotation
 * il est possible d'aller jusque 60 bytes avec un bigInteger(22)  
 ****************************************************************************/
 function setByteAccess($idProperty){
	global $xoopsModuleConfig, $xoopsDB;

                              
    $sql = "SELECT  idPropertySet, byteAccess FROM "
          .$xoopsDB->prefix(_LEX_TBL_PROPERTYSET)
          ." WHERE idProperty = {$idProperty}"
          ." ORDER BY byteAccess,showOrder,name";
    $sqlquery = $xoopsDB->query($sql);  
    $list = array(); 
    $i=0;  
    
    //$t = array_pad(array(), LEX_PROPERTY_MAX, 0); 
    $t = array();
    $vide = array();
             
    while ($sqlfetch = $xoopsDB->fetchArray($sqlquery)) {
      $id = $sqlfetch ['idPropertySet'];
      $byteAccess = $sqlfetch ['byteAccess'];
      if ($byteAccess >= LEX_PROPERTY_FIRST AND !isset($t[$byteAccess])){
        //echo "$byteAccess ok -> {$id}-{$byteAccess}<br>";
        $t[$byteAccess] = $id;   
        //$vide [] = $id;           
      }else{
        //echo "$byteAccess pas ok -> {$id}-{$byteAccess}<br>";      
        $vide [] = $id; 
      }

    }
    
  //displayArray($t,"------------{$sql}----------------------");
  //displayArray2($vide,"..................................");  
  
  
  $i = LEX_PROPERTY_FIRST;
  for($h = 0; $h < count($vide); $h++){
      while ($t[$i] > 0) {$i++;}
      $sql = "UPDATE ".$xoopsDB->prefix(_LEX_TBL_PROPERTYSET)
            ." SET byteAccess = {$i} "
            ." WHERE idPropertySet = {$vide[$h]}";
        //echo $sql.'<br>';
        $xoopsDB->queryF($sql);      
      $i++;
  }
  
      
 }

/****************************************************************************
 * fonction a metre dans le module functions
 * permet de connaitre le nom du bouton sbmit qui a été presse 
 ****************************************************************************/

function getSubmitName($p, $nameList){
  
  $t = explode (';', $nameList);
  
  for ($h = 0; $h < count($t); $h++){
    if (isset($p[$t[$h]])  ) {return $t[$h];}
  }
  
  return '';
}
function getSubmitNum($p, $nameList){
  
  $t = explode (';', $nameList);
  
  for ($h = 0; $h < count($t); $h++){
    if (isset($p[$t[$h]])  ) {return $h;}
  }
  
  return -1;
}


/****************************************************************************
 *
 ****************************************************************************/

//---------------------------------------------------------------------
$bOk = true;
if ($bOk){admin_xoops_cp_header(_LEX_ONGLET_PROPERTY, $xoopsModule);}   


switch($op) {

  case "list":
    listProperty();
    break;


  case "new":
    $p=buildPropertyArray($idProperty);
    editProperty ($p);
    break;
    
  case "edit":
    $p = buildPropertyArray($idProperty);  
    editProperty ($p,$idProperty);
    break;
    
  case "clear":
    //listCaption(true);
    break;

  case "save":

     switch(getSubmitName($_POST, 'save;add')) { 
        case 'save':
          saveProperty ($_POST);
          redirect_header("admin_property.php",1,_AD_LEX_ADDOK);    
          break;
          
          break;
        case 'add':
          saveProperty ($_POST);
          $p = buildPropertyArray($idProperty);
          editProperty ($p,$idProperty);
          //redirect_header("admin_property.php",1,_AD_LEX_ADDOK);    
          break;
          
          break;
     
     }  
    


  case "delete":    
  case "remove":
    //xoops_cp_header();
    $msg = sprintf(_AD_LEX_CONFIRM_DEL, "<b>{$_GET['name']} (id:{$idProperty})</b>" , _AD_LEX_PROPERTYS);            
    xoops_confirm(array('op'         => 'removeOk', 
                        'idProperty' => $_GET['idProperty'] ,
                        'ok'         => 1),
                  "admin_property.php", $msg );
    //xoops_cp_footer();
    
    break;

  case "removeOk":
    removeProperty ($_POST['idProperty']);
    redirect_header("admin_property.php",1,_AD_LEX_ADDOK);    
    break;

}


if ($bOk){admin_xoops_cp_footer();}   

?>
