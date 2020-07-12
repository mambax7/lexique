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


//***************************************************************
include_once (XOOPS_ROOT_PATH."/class/xoopsformloader.php");
//require_once ("constantes.php");
include_once (_LEX_JJD_PATH.'include/functions.php');

define ('_TEMP_DEBUG', false);

define ('_TEMP_TBLDATA', 'tbldata');
define ('_TEMP_COLDATA', 'coldata');
define ('_TEMP_COLID', 'colid');
define ('_TEMP_DATAID', 'dataid');
define ('_TEMP_DATAVALUE', 'datavalue');
define ('_TEMP_DATATYPE', 'datatype');
define ('_TEMP_LASTUPDATE', 'lastupdate');

define ('_TEMP_FORMATDATE', 'Y/m/d H:i:s');


/***************************************************************

**********************************************************************/
function saveTemp($table, $colData, $colId, $id, $killOld = false, $colAllias = ""){
global $xoopsDB;
  
  //-------------------------------------------------------
  $tColData   = explode (";", $colData);
  $tColAllias = explode (";", $colAllias);
  
  $tColExist = isTempA($table, $id);
  
  $col = str_replace(";", ",", $colData);
  $sql = "SELECT {$col} FROM ".$xoopsDB->prefix($table)
        ." WHERE ".$colId."=".$id;
  $sqlquery = $xoopsDB->query($sql);
  $tv = $xoopsDB->fetchArray($sqlquery);
 //displayArray ($tv,$col);

  for ($h = 0; $h < count($tColData); $h++){
    $colData = $tColData [$h];
    $colDest = $colData;
    if ($h < count($tColAllias)) {
      if ($tColAllias [$h] <> ""){
        $colDest = $tColAllias [$h];}
    }
    
    
    
  	if (!$killOld){
      //if (isTemp($table, $colDest, $id)){continue;}
      if ( isset($tColExist[$colDest])){continue;}      
    }
    //----------------------------------------------------
    $v = $tv [$colData];
    if (_TEMP_DEBUG) tempEcho ($sql);
    //----------------------------------------------------
    
    setTemp($table, $colDest, $v, $colId, $id);
  }
}
/*********************************************************************

**********************************************************************/
function saveTemp2($table, $colData, $colId, $id, $killOld = false, $colAllias = ""){
global $xoopsDB;
  
/*
*/
  //-------------------------------------------------------
  $tColData   = explode (";", $colData);
  $tColAllias = explode (";", $colAllias);
  

  
  for ($h = 0; $h < count($tColData); $h++){
    $colData = $tColData [$h];
    $colDest = $colData;
    if ($h < count($tColAllias)) {
      if ($tColAllias [$h] <> ""){
        $colDest = $tColAllias [$h];}
    }
    
    
    
  	if (!$killOld){
      if (isTemp($table, $colDest, $id)){continue;}
    }
    //----------------------------------------------------
    $sql = "SELECT ".$colData." FROM ".$xoopsDB->prefix($table)
          ." WHERE ".$colId."=".$id;
  	$sqlquery = $xoopsDB->query($sql);
 	  
    list( $v ) = $xoopsDB->fetchRow( $sqlquery );
    if (_TEMP_DEBUG) tempEcho ($sql);
    //----------------------------------------------------
//      echo "zzzzzzzzzzzzzzzzzzzzzzzzzz<br>";
    
    setTemp($table, $colDest, $v, $colId, $id);
  }
}

/*********************************************************************

**********************************************************************/
function restoreTemp($table, $colData, $id, $killAfter = true){

	global $xoopsDB;
  $sql = "SELECT "._TEMP_DATAVALUE.", "._TEMP_COLID." ".getClauseFromWhere ($table , $colData , $id);
        
	$sqlquery = $xoopsDB->query($sql);
	if ($xoopsDB->getRowsNum($sqlquery) == 0 ){return;}
	
 	list( $v, $cid ) = $xoopsDB->fetchRow( $sqlquery ) ;

  
    $sql  = "UPDATE ".$xoopsDB->prefix($table)
          . " SET ".$colData." = '{$v}'"
          . " WHERE {$cid}={$id}";
    $xoopsDB->query($sql);
  if (_TEMP_DEBUG) tempEcho ($sql);


  if ($killAfter){killTemp ($table, $id, $colData);}

  }
  
/*********************************************************************

**********************************************************************/
function getTemp($table, $colData, $id, $killAfter = false){

	global $xoopsDB;
  $sql = "SELECT datavalue ".getClauseFromWhere ($table, $colData, $id);
        
        
	$sqlquery = $xoopsDB->query($sql);
	if ($xoopsDB->getRowsNum($sqlquery) == 0 ){return '';}
	
 	list( $v ) = $xoopsDB->fetchRow( $sqlquery ) ;

  if ($killAfter){killTemp ($table, $id, $colData);}
  return $v;
 
}
/*********************************************************************

**********************************************************************/
function setTemp($table, $colData, $newValue, $colId, $id, $dataType = 0){
	global $xoopsDB;
  
	//$id=999;
  //$sqlWhere = " WHERE "._TEMP_TBLDATA."='".$table."' "._TEMP_COLDATA." = '". $colData,."' AND "._TEMP_DATAID." = ".$id;
  $sqlWhere = getClauseFromWhere ($table ,$colData , $id, "", true);
  if (_TEMP_DEBUG) tempEcho ("id = ".$id);
  $sql = "SELECT count("._TEMP_DATAID.") as count".$sqlWhere;
        
	$sqlquery = $xoopsDB->query($sql);
 	list( $count ) = $xoopsDB->fetchRow( $sqlquery ) ;
	$lastUpdate = date (_TEMP_FORMATDATE);
	
	
  $dataType=1;
  $newValue = str_replace("'", "''", $newValue);
  if( $count == 0 ) {
	  $sql  = "INSERT INTO ".$xoopsDB->prefix(_LEX_TBL_TEMP)." ";
    
    $sql .= "("._TEMP_TBLDATA.", "._TEMP_COLDATA.", "._TEMP_COLID.", "._TEMP_DATAID.", "
           ._TEMP_DATAVALUE.", "._TEMP_DATATYPE.", "._TEMP_LASTUPDATE.") ";
    
    $sql .= "VALUES ('".$table."', '". $colData."', '".$colId."', ".$id
           .", '".$newValue."', ".$dataType.", '".$lastUpdate."')";
    
    if (_TEMP_DEBUG) tempEcho ($sql);
    $xoopsDB->queryF($sql);
    //--------------------------------------------------------
	} 
  ELSE{
    $sqlWhere = getClauseFromWhere ($table ,$colData , $id, "", false);
    $sql  = "UPDATE ".$xoopsDB->prefix(_LEX_TBL_TEMP)." ";
    $sql .= "SET "
           ._TEMP_DATAVALUE." = '".$newValue."', "
           ._TEMP_LASTUPDATE." = '".$lastUpdate."' ".$sqlWhere;
    
    if (_TEMP_DEBUG) tempEcho ("<br>".$sql);
    $xoopsDB->queryF($sql);
  }
}
/*********************************************************************
**********************************************************************/
function getClauseFromWhere ($table ="" , $colData = "" , $id = 0, $clause2add = "", $addClauseFrom = true){

	global $xoopsDB;
	
	$tClauseWhere = array();
	if ($table <> "" )       {$tClauseWhere[] = _TEMP_TBLDATA." = '".$table."'";}
	if ($colData <> "" )     {$tClauseWhere[] = _TEMP_COLDATA." = '".$colData."'";}
	if ($id <> 0 )           {$tClauseWhere[] = _TEMP_DATAID."  =  ".$id."";}
	if ($clause2add <> "" )  {$tClauseWhere[] = $clause2add;}
	
	if (count($tClauseWhere) > 0) {
    $ClauseWhere = " WHERE ".implode (" AND ", $tClauseWhere);
  }
  else {
    $ClauseWhere = " ";
  }
  //------------------------------------------------------------------------
  if ($addClauseFrom){
    $clauseFrom = " FROM ".$xoopsDB->prefix(_LEX_TBL_TEMP);}
  else {
    $clauseFrom = "";
  }

  if (_TEMP_DEBUG) tempEcho ($clauseFrom.$ClauseWhere);
  return $clauseFrom.$ClauseWhere; 
}

/*********************************************************************
 *
**********************************************************************/
function isTemp($table, $colData, $id){

	global $xoopsDB;
  
  $sql = "SELECT count(dataid) as count".getClauseFromWhere($table, $colData, $id);
	$sqlquery = $xoopsDB->query($sql);
 	list( $count ) = $xoopsDB->fetchRow( $sqlquery ) ;
	
	return ( $count > 0 ) ;
 
}

/*********************************************************************
 *
**********************************************************************/
function isTempA($table, $id){

	global $xoopsDB;
  
  $sql = "SELECT "._TEMP_COLDATA." ".getClauseFromWhere($table, '', $id);
	$sqlquery = $xoopsDB->query($sql);
  $t = array ();
  
    while ($sqlfetch = $xoopsDB->fetchArray($sqlquery)) {
      $t[$sqlfetch [_TEMP_COLDATA]]= true ;
    }	

	//echo $sql."<br>";
	//displayArray ($t, '****************************');
	return $t ;
 
}
  
  
/*********************************************************************

**********************************************************************/
function killTemp ($table = "", $id = 0 , $colData = ""){
  
	global $xoopsDB;
	
	$ClauseWhere = getClauseFromWhere($table,$colData,$id);
	
  $sql = "DELETE ".$ClauseWhere;
  if (_TEMP_DEBUG) tempEcho ($sql);
  $xoopsDB->queryF($sql);
}

/*********************************************************************

**********************************************************************/
function getNewIdTemp ($table, $colData, $colId = "", $value = ""){
	global $xoopsDB;
  
  $sql = "SELECT min(dataid) as newid".getClauseFromWhere($table, $colData, 0, ""._TEMP_DATAID." < 0");
  if (_TEMP_DEBUG) tempEcho ($sql);
  
	$sqlquery = $xoopsDB->query($sql);
	if ($xoopsDB->getRowsNum($sqlquery) == 0 ){
    $newId = 0;
  }
  else{
 	  list ($id) = $xoopsDB->fetchRow($sqlquery) ;
  }
  
  $id -= 1;
  setTemp ($table, $colData, $value, $colId, $id);
  return $id;

}

  
/*********************************************************************

**********************************************************************/
function tempEcho($line, $addBR = true){
  echo $line;
  if ($addBR) {
  echo "<br>";
  echo "---------------------------------------------------<br>";
  }
} 


/*********************************************************************

**********************************************************************/

function wlog ($text){

  $f = _LEX_ROOT_PATH."log/log.txt";
  $f =str_replace("\/", "\\", $f);

    $handle = fopen ($f, "a");

    
    fwrite ($handle, $text.chr(13).chr(10));    
    
    fclose ($handle);

}


?>
