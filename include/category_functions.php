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

include_once (_LEX_ROOT_PATH."xoops_version.php");

//-----------------------------------------------------------------------------------
global $xoopsModule;
include_once (XOOPS_ROOT_PATH."/modules/".$xoopsModule->getVar('dirname')."/include/constantes.php");
//-----------------------------------------------------------------------------------
include_once (_LEX_ROOT_JJD."functions.php");

include_once (_LEX_ROOT_JJD."strbin_function.php");
include_once (_LEX_ROOT_PATH."include/lexique_function.php");
//***************************************************************

define("_MINCATEGORY",      2);
define("_MAXCATEGORY",     32);

define("_PREFIX_CAT",   'name');
define("_PREFIX_ORD",   'showOrder');
define("_PREFIX_STATE", 'state');
define("_PREFIX_IDCATEGORY", 'idCategory');
/***************************************************************************
JJD - 25/07/2006
renvoie la liste des categories 

Param&egrave;tres:
  $sourceId:  0 = id = idFamily
              1 = id = idLexique
****************************************************************************/
function getNbCategory($id, $sourceId = 0  ){
	global $xoopsConfig, $xoopsDB;
  
  switch ($sourceId){
  case 1:
      $sql = "SELECT {family}.maxCount FROM {family},{lexique} "
            ." WHERE {family}.idFamily = {lexique}.idFamily "
            ."   AND {lexique}.idFamily = $id";
            
      break;    
      
  default:
      
      $sql = "SELECT maxCount FROM {family} WHERE idFamily = ".$id;
      
      break;      
  }
  //---------------------------------------------------------- 
  $sql = replaceTbl ($sql);  
	$sqlquery = $xoopsDB->query($sql);
	list( $categories ) = $xoopsDB->fetchRow( $sqlquery ) ;
	
  //---------------------------------------------------------------
   return $categories;

}

/***************************************************************************
JJD - 25/07/2006
renvoie la liste des categories 

Param&egrave;tres:
  $state:  0 = categorie de base
           1 = Combinaison de categories
****************************************************************************/
function loadCategory($idFamily = 0, $order = "idCategory", $clauseWhere = ''){  
	global $xoopsConfig, $xoopsDB;
  $categories = getNbCategory($idFamily);

  //---------------------------------------------------------------
  if ($clauseWhere == ''){
    $sWhere = " WHERE idFamily = {$idFamily}";
  }else{
    $sWhere = " WHERE idFamily = {$idFamily} AND {$clauseWhere}" ; 
  }
  
  $sql = "SELECT * FROM {category} {$sWhere}"
        ." ORDER BY ".$order;
  
  $sql = replaceTbl ($sql);      
	$sqlquery = $xoopsDB->query($sql);   
  $tCat = array();
	$catMax = getValeurBornee($categories, _MINCATEGORY, _MAXCATEGORY);
	//echo "nbCatMax = ".$catMax."<br>";
	$h=0;
	$catMax = 32;
	
	while (($sqlfetch = $xoopsDB->fetchArray($sqlquery)) && ($h < $catMax)) {
  	 $tCat[] = $sqlfetch;
  	 $h++;

  }
 
 
  if (count($tCat)< $catMax AND $clauseWhere == '') {
    for ($h = count($tCat); $h < $catMax; $h++){
        $tCat [] = array ('idCategory' => $h ,
                          'idBin'      => pow(2, $h) ,
                          'name'       => '',
                          'state'      => 1,                                
                          'showOrder'  => $h * 10, 
                          'id' => 0);
    
    }


  }
//displayArray($tCat,"Famille : {$idFamily}");  
  return $tCat;


}

//---------------------------------------------------------------


//---------------------------------------------------------------
function loadCategory2($idFamily = 0, $order = "idCategory"){
	global $xoopsConfig, $xoopsDB;
  
  $categories = getNbCategory($idFamily);

  //---------------------------------------------------------------
  
  $sql = "SELECT * FROM {category} "
        ." WHERE idFamily = ".$idFamily
        ." ORDER BY ".$order;
        
	$sqlquery=$xoopsDB->query(replaceTbl ($sql));   
  $tcat = array();
	$nbCatMax = getValeurBornee($categories, _MINCATEGORY, _MAXCATEGORY);
	$h=0;
	
	while (($sqlfetch=$xoopsDB->fetchArray($sqlquery)) && ($h < $nbCatMax)) {
	   $enr = array();
	   $id = floor((log($sqlfetch['idCategory']) / log(2)) + 0);
  	 $tcat[$id] = $sqlfetch['name'];
     $h++;
  }
 /*
 */ 
  if (count($tcat)< $nbCatMax) {
    for ($h = count($tcat); $h < $nbCatMax; $h++){
      $tcat [$h] = "???";
    }
  }
  
  return $tcat;

}

function loadCategoryByTerme ($idTerme = 0, $order = "idCategory"){
	global $xoopsConfig, $xoopsDB;
  
  $categories = getNbCategory($idFamily);

  //---------------------------------------------------------------
  $tCat = $xoopsDB->prefix(_LEX_TBL_CATEGORY);
  $tLex = $xoopsDB->prefix(_LEX_TBL_LEXIQUE);
  $tFam = $xoopsDB->prefix(_LEX_TBL_FAMILY);
  $tTer = $xoopsDB->prefix(_LEX_TBL_TERME);
    
  $sql = "SELECT {$tCat}.* FROM {$tCat},{$tFam},{$tLex},{$tTer}"
        ." WHERE {$tTerm}.idLExique = {$tLex}.idLexique "
        ."   AND {$tFam}.idFamily = {$tLex}.idFamily "        
        ."   AND {$tCat}.idFamily ={$tFam}.idFamily "        
        ."   AND {$tTerm}.idTerme= {$idTerme}"
        ." ORDER BY ".$order;

        
	$sqlquery=$xoopsDB->query($sql);
  $tcat = array();
	$nbCatMax = getValeurBornee($categories, _MINCATEGORY, _MAXCATEGORY);
	$h=0;
	
	while (($sqlfetch=$xoopsDB->fetchArray($sqlquery)) && ($h < $nbCatMax)) {
	   $enr = array();
	   $id = floor((log($sqlfetch['idCategory']) / log(2))+0);
  	 $tcat[$id] = $sqlfetch['name'];
     $h++;
  }
 /*
 */ 
  if (count($tcat)< $nbCatMax) {
    for ($h = count($tcat); $h < $nbCatMax; $h++){
      $tcat [$h] = "???";
    }
  }
  
  return $tcat;

}
/*********************************************************************
 *
 *********************************************************************/
function loadCategoryByLexique ($idLexique, $order = "idCategory"){
	global $xoopsConfig, $xoopsDB;
  
  $categories = getNbCategory($idLexique, 1);

  //---------------------------------------------------------------
  $tCat = $xoopsDB->prefix(_LEX_TBL_CATEGORY);
  $tLex = $xoopsDB->prefix(_LEX_TBL_LEXIQUE);
  $tFam = $xoopsDB->prefix(_LEX_TBL_FAMILY);
  $tTer = $xoopsDB->prefix(_LEX_TBL_TERME);
    
  $sql = "SELECT {$tCat}.* FROM {$tCat},{$tFam},{$tLex} "
        ." WHERE {$tFam}.idFamily   = {$tLex}.idFamily "        
        ."   AND {$tCat}.idFamily   ={$tFam}.idFamily "        
        ."   AND {$tLex}.idLexique  = {$idLexique}"
        ." ORDER BY ".$order;

        
	$sqlquery=$xoopsDB->query($sql);
  $tcat = array();
	$nbCatMax = getValeurBornee($categories, _MINCATEGORY, _MAXCATEGORY);
	$h=0;
	
	while (($sqlfetch=$xoopsDB->fetchArray($sqlquery)) && ($h < $nbCatMax)) {
	   $enr = array();
	   $id = floor((log($sqlfetch['idCategory']) / log(2))+0);
  	 $tcat[$id] = $sqlfetch['name'];
     $h++;
  }
  if (count($tcat)< $nbCatMax) {
    for ($h = count($tcat); $h < $nbCatMax; $h++){
      $tcat [$h] = "???";
    }
  }
  
  return $tcat;

}

//------------------------------------------------------------------

/***************************************************************************
JJD - 25/07/2006
renvoie la liste des categories 

Param&egrave;tres:
  $state:  0 = categorie de base
           1 = Combinaison de categories
****************************************************************************/
function saveCategory($list, $idFamily, $familyName, $state = 0){
	global $xoopsConfig, $xoopsDB;
	
	
	//---------------------------------------------------------------------	
	//Mise a our ou insertion de la famille
  //---------------------------------------------------------------------	
	if ($idFamily == 0) {
    $sql = "INSERT INTO ".$xoopsDB->prefix(_LEX_TBL_FAMILY)." "
         ."(name, maxCount)"." "
         ."VALUES ('".$familyName."',".(count($tcat)).")";
	  $xoopsDB->query($sql);    
    
    $sql = "SELECT idFamily FROM ".$xoopsDB->prefix(_LEX_TBL_FAMILY)." "
         ."WHERE name = '".$familyName."'";
    $sql = "SELECT idFamily FROM ".$xoopsDB->prefix(_LEX_TBL_FAMILY)." "
          ." WHERE name = '".$familyName."' "
          ." ORDER BY idFamily DESC";
    $sqlquery=$xoopsDB->query($sql);
    list ($idFamily) = $xoopsDB->fetchRow($sqlquery);
          
  }else{
    $sql = "UPDATE ".$xoopsDB->prefix(_LEX_TBL_FAMILY)." "
         ." SET name = '".$familyName."', "
         ." maxCount = ".count($list)
         ." WHERE idFamily = ".$idFamily; 
	   $xoopsDB->query($sql);         
     //----------------------------------------------------
  }
  //---------------------------------------------------------------------	
  $sql = "DELETE FROM ".$xoopsDB->prefix(_LEX_TBL_CATEGORY)
        ." WHERE idFamily = ".$idFamily;

	$xoopsDB->query($sql);
        
	
	//---------------------------------------------------------------------
	$t = array();
	for ($h = 0; $h < count($list); $h++){	
	 $tcat= $list[$h];
	 
    $i = pow (2, $h);
    if (!isset($tcat['state']))  {$tcat['state'] = 'ON';}	
    $state = ($tcat['state'] == 'on')?1:0;
    $idBin = pow (2, $tcat['idCategory']);
    $t[] = "({$tcat['idCategory']},{$idBin},{$idFamily},'{$tcat['name']}',{$state},{$tcat['showOrder']})";
  }
  $v  = implode(',', $t);	

    $sql = "INSERT INTO ".$xoopsDB->prefix(_LEX_TBL_CATEGORY)
          ." (idCategory, idBin, idFamily, name, state, showOrder) "
          ." VALUES {$v}";
  	$xoopsDB->query($sql);  
  	
  
}
//----------------------------------------------------------------------------
function saveCategory2($tcat, $idFamily, $familyName, $state = 0){
	global $xoopsConfig, $xoopsDB;
	
	
	//---------------------------------------------------------------------	
	//Mise a our ou insertion de la famille
  //---------------------------------------------------------------------	
	if ($idFamily == 0) {
    $sql = "INSERT INTO ".$xoopsDB->prefix(_LEX_TBL_FAMILY)." "
         ."(name, maxCount)"." "
         ."VALUES ('".$familyName."',".(count($tcat)).")";
	  $xoopsDB->query($sql);    
    
    $sql = "SELECT idFamily FROM ".$xoopsDB->prefix(_LEX_TBL_FAMILY)." "
         ."WHERE name = '".$familyName."'";
    $sql = "SELECT idFamily FROM ".$xoopsDB->prefix(_LEX_TBL_FAMILY)." "
          ." WHERE name = '".$familyName."' "
          ." ORDER BY idFamily DESC";
    $sqlquery=$xoopsDB->query($sql);
    list ($idFamily) = $xoopsDB->fetchRow($sqlquery);
          
  }else{
    $sql = "UPDATE ".$xoopsDB->prefix(_LEX_TBL_FAMILY)." "
         ." SET name = '".$familyName."', "
         ." maxCount = ".count($tcat)
         ." WHERE idFamily = ".$idFamily; 
	   $xoopsDB->query($sql);         
     //----------------------------------------------------
  }
  //---------------------------------------------------------------------	
      $sql = "DELETE FROM ".$xoopsDB->prefix(_LEX_TBL_CATEGORY)
            ." WHERE idFamily = ".$idFamily;

    	$xoopsDB->query($sql);
            
	
	//---------------------------------------------------------------------
	$t = array();
	for ($h = 0; $h < count($tcat); $h++){
    $i = pow (2, $h);	
    $t = "({$i},'{$tcat[$h]}',{$state},{$idFamily})";
  }
  $v  = implode(',', $t);	
  

    $sql = "INSERT INTO ".$xoopsDB->prefix(_LEX_TBL_CATEGORY)
          ." (idCategory, name, state, idFamily) "
          ." VALUES {$v}";
  	$xoopsDB->query($sql);  
  	
  	
}

/***************************************************************************
JJD - 25/07/2006
renvoie la liste des categories 

ParamFtres:
  $state:  0 = catTgorie de base
           1 = Combinaison de categories
****************************************************************************/
function getSelectCategory ($name, $idLexique, $defaut = -1){
	global $xoopsConfig, $xoopsDB;
  
  $sql = "SELECT {category}.* FROM {category},{lexique} "
	      ."WHERE {lexique}.idFamily =  {category}.idFamily "
	      ."  AND {category}.name <> '' "	
	      ."  AND {category}.state = 1 "	      
	      ."  AND idLexique = {$idLexique} "	
        ."ORDER BY name";
  
  $sql = replaceTbl($sql);
  $sqlquery=$xoopsDB->query($sql);


  $h = 0;
  $tselected []= "<SELECT NAME='".$name."'>";

  $id   = 0;
  $name = _MI_LEX_ALLCATEGORY;
  if (($defaut == $id) AND ($defaut >= 0)){$sdefaut = " selected";} else {$sdefaut = "";}
  $tselected [] = "<OPTION VALUE='".$id."'".$sdefaut.">".$name;
	
	$h++;
  //------------------------------------------------------------  	 
  while ($sqlfetch=$xoopsDB->fetchArray($sqlquery)) {
	   $id   = $sqlfetch['idBin'];
	   $name = $sqlfetch['name'];
  	 
  	 if (($defaut == $id) AND ($defaut >= 0)){$sdefaut = " selected";} else {$sdefaut = "";}
     $tselected [] = "<OPTION VALUE='".$id."'".$sdefaut.">".$name;
     $h++;
  }	 
  //------------------------------------------------------------  	 
  $tselected []= "</select>";
  
  $selected = implode ("", $tselected);
  return $selected;
}



/*********************************************************************
 *
 *********************************************************************/

function getSelectCategory2 ($name, $defaut = -1){
	global $xoopsConfig, $xoopsDB;
  
  $tsql[0] = "SELECT * FROM ".$xoopsDB->prefix(_LEX_TBL_CATEGORY)." ";
	$tsql[1] = "WHERE name <> ''";
	$tsql[2] = "ORDER BY name";
  $sql = implode (" ", $tsql);
  $sqlquery=$xoopsDB->query($sql);

  $h = 0;
  $tselected []= "<SELECT NAME='".$name."'>";

  //$id   = pow(2, 16)-1;
  $id   = 0;
  $name = _MI_LEX_ALLCATEGORY;
  if (($defaut == $id) AND ($defaut >= 0)){$sdefaut = " selected";} else {$sdefaut = "";}
  $tselected [] = "<OPTION VALUE='".$id."'".$sdefaut.">".$name;
	
	$h++;
  //------------------------------------------------------------  	 
  while ($sqlfetch=$xoopsDB->fetchArray($sqlquery)) {
	   $id   = $sqlfetch['idCategory'];
	   $name = $sqlfetch['name'];
  	 
  	 if (($defaut == $id) AND ($defaut >= 0)){$sdefaut = " selected";} else {$sdefaut = "";}
     $tselected [] = "<OPTION VALUE='".$id."'".$sdefaut.">".$name;
     $h++;
  }	 
  //------------------------------------------------------------  	 
  $tselected []= "</select>";
  
  $selected = implode ("", $tselected);
  return $selected;
}


/******************************************************************************
 
******************************************************************************/
function getCheckedCategoryBinStr ($name, $idTerme, $idLexique, $idFamily, $prefixe = "chk_", $cols = 2, $sens = 1){
	global $xoopsConfig, $xoopsDB;
  
  $tLex = $xoopsDB->prefix(_LEX_TBL_LEXIQUE);  
  if ($idTerme > 0) {

    $tTer = $xoopsDB->prefix(_LEX_TBL_TERME);

    $sql = "SELECT {$tLex}.idFamily, {$tTer}.category FROM {$tTer},{$tLex} "
  	      ." WHERE {$tTer}.idLexique  = {$tLex}.idLexique "
  	      ."   AND {$tTer}.idTerme = $idTerme";
    
    $sqlquery = $xoopsDB->query($sql);
  	list ($idFamily, $category)  = $xoopsDB->fetchRow($sqlquery);
    
  }
  else{
  
  	$category = str_pad("", "0", 32);
  	
  }
  
    $tcat = loadCategory ($idFamily,'name,idCategory', "name <> '' AND state = 1" ) ;  

  $tValStr = binStr2Array ($category);
  $tVal = arrayStr2Bin($tValStr);
  
  if ($sens == 0 ) {
    return getCheckedV ($name, $tcat, $tVal, $prefixe, $cols );
  }
  else {
    return getCheckedH ($name, $tcat, $tVal, $prefixe, $cols, 'idCategory' );
  }
  
}



/******************************************************************************
 
******************************************************************************/

function getChecked ($idLexique, $name, $category, $prefixe = "chk_", $cols = 2, $sens = 1){
  $tcat = loadCategoryByLexique ($idLexique) ;
  $tValStr = binStr2Array ($category);
  $tVal = arrayStr2Bin($tValStr);
  
  if ($sens == 0 ) {
    return getCheckedH ($name, $tcat, $tVal, $prefixe, $cols );
  }
  else {
    return getCheckedV ($name, $tcat, $tVal, $prefixe, $cols );
  }
}

/******************************************************************************
 
******************************************************************************/
function getCheckedH ($name, $tList, $tVal, $prefixe = "chk_", $cols = 2, $colId = ''){
  
	$tselected = array ();
  if ($name <> ""){$tselected []= $name."<br>";} 
  
  $tselected []= addBaliseBV ("TABLE", "", 1, 0, true);
  $i = 0; //pour compter les colonnes
  
  for ($h = 0; $h < count($tList); $h++){

      $tCat = $tList[$h];
      $index =  (isset($tCat[$colId]))?$tCat[$colId]:$h;  
      $showIndex = (false)?("({$index})"):''; 
         
        if ($tVal[$index] == 1){$value = 'checked';} else {$value = 'unchecked';}
        $line =  "<input type='checkbox' name='".$prefixe.$index."' ".$value.">&nbsp;".$tCat['name']."{$showIndex}</input>";
        /*
        */
        if ($cols > 1){
          addBalise ("TD", $line, 1, 1, true);
          if ($i == 0) { 
              addBalise ("TR", $line, 1, 0, true);
              $j=1;
          }
          $i++;
          if ($i >= $cols) { 
            $i = 0;
            $j = 0;
            addBalise ("TR", $line, 0, 1, true);
          }
          //$tselected []= $line;
          
        }
        else {
          //$tselected []= $line;
        }
        
          $tselected []= $line;

  }
  
  $line = "";
  if ($i > 0) {$tselected [] = addBaliseBV ("TR", "", 0, 1);}
  $tselected [] = addBaliseBV ("TABLE", "", 0, 1);
   //------------------------------------------------------------  	 
  $obHtml = implode ("", $tselected);
  //$obHtml = balise2Str($obHtml);
  return $obHtml;
 

}
/********************************************************************
 *a revoir selon modif de hor audessus
*********************************************************************/
function getCheckedV ($name, $tList, $tVal, $prefixe = "chk_", $cols = 2){
  
	$tselected = array ();
  if ($name <> ""){$tselected []= $name."<br>";} 
//    displayArray($tList,'getCheckedV----------------------');  
  $tselected []= addBaliseBV ("TABLE", "", 1, 0, true);
  $i = 0; //pour compter les colonnes

  $nbRows  = floor (count($tList) / $cols) ;
  $tselected []= addBaliseBV ("TR", "", 1, 0, true);
  
  
  for ($h = 0; $h < count($tList); $h++){
       $tCat = $tList[$h];
        //echo $tVal[$h]."<BR>";
        if ($tVal[$h] == 1){$value = 'checked';} else {$value = 'unchecked';}
        $line =  "<input type='checkbox' name='".$prefixe.$h."' ".$value.">&nbsp;".$tCat['name']."</input>";
        /*
        */
        if ($cols > 1){
          if ($i == 0) { 
              addBalise ("TD", $line, 1, 0, true);
          }
          $i++;
          if ($i >= $nbRows) { 
            $i = 0;
            addBalise ("TD", $line, 0, 1, true);
          }
          else {
              $line .= "<br>";
              //addBalise ("BR", $line, 0, 1, true);
           
          }
        }
        else {
          //$tselected []= $line;
        }
        
          $tselected []= $line;

  }
  
  $line = "";
  if ($i > 0) {$tselected [] = addBaliseBV ("TD", "", 0, 1);}
  $tselected [] = addBaliseBV ("TABLE", "", 0, 1);
   //------------------------------------------------------------  	 
  $obHtml = implode ("", $tselected);
  //$obHtml = balise2Str($obHtml);
  return $obHtml;
 

}

/******************************************************************
 *
 ******************************************************************/
function tblAdCol ($line, $baliseOpen = 1 , $baliseClose = 1){
  return addBalise ("TD", $line, $baliseOpen, $baliseClose);
}

function tblAdRow (&$line, $baliseOpen = 1 , $baliseClose = 1){
  return addBalise ("TR", $line, $baliseOpen, $baliseClose);
}



/********************************************************************
construction de la ckause WHERE pour les recheeches
********************************************************************/
function getSqlWhereForSearch ($p , $g) {

$p = array_merge ($g, $p);

$terme         = (isset($p['terme']))?$p['terme']:'';  
$type          = (isset($p['type']))?$p['type']:'';
$limite        = (isset($p['limite']))?$p['limite']:'';
$category      = (isset($p['category']))?$p['category']:'';
$list_searchby = (isset($p['list_searchby']))?$p['list_searchby']:'';
$idLexique     = (isset($p['idLexique']))?$p['idLexique']:'0';


if ($idLexique==''){$idLexique=999;}

  $query = stripslashes($terme);
  
  $tSql = array();
  
  if ($query <> "" ) {
    //------------------------------------------------------------------------
   //-----------------------------------------------------------  
  $b = checkBoxToBin($p, 'lookfor', $def);

  $ok = false;
  //$tout = ($def[0]['lookfor'] == 'on');
  $tout = ($def[0]['lookfor'] == 'on');
  
  /*

  displayArray($def,"-----------checkBoxToBin-------------");
  $r = ($tout) ? 'Vrai' : 'Faux';
  echo "<hr>tout = {$r}<hr>";
  */  
  
  $tFields = array("","name","shortDef","definition1","definition2","definition3","seeAlsoList");  
  $tSqlType = array();
  for ($h = 1; $h < count($tFields)-1; $h++){
    if ( (($b and pow(2,$h)) <> 0 ) OR $tout){
       $tSqlType [] = buildClauseLike ($tFields [$h] , $query, $list_searchby); 
       $ok = true;     
     }
             
  }
  //---------------------------------------------------
  if ($ok) {
    $tSql [] = " (".implode(" OR ",$tSqlType).") ";  
  }
  
  //-----------------------------------------------------------

  }else
  {$sqlType = '';}
  //-----------------------------------------------------------------
  if ($category <> 0) {
     $categoryStr = bin2Str ($category);
      $categoryStr = str_replace ("0", "_", $categoryStr);
      
      $sqlWhereCategory = "((category LIKE '".$categoryStr."') OR (category =  ''))";

    $tSql [] = $sqlWhereCategory;  
  }
  
  $tSql [] = "state='"._LEX_STATE_OK."'";  
  $tSql [] = "idLexique = {$idLexique}";   
   
  $sqlWhere = " WHERE ".implode(' AND ', $tSql);    
  //-----------------------------------------------------------------
  return $sqlWhere;
}

//-----------------------------------------------------------

/********************************************************************
construction de la ckause WHERE pour les recherches
********************************************************************/
function getSqlWhereForSearch2 ($p , $g) {

$p = array_merge ($g, $p);
//displayArray($p, 'getSqlWhereForSearch');


$terme         = (isset($p['terme']))?$p['terme']:'';  
$type          = (isset($p['type']))?$p['type']:'';
$limite        = (isset($p['limite']))?$p['limite']:'';
$category      = (isset($p['category']))?$p['category']:'';
$list_searchby = (isset($p['list_searchby']))?$p['list_searchby']:'';
$idLexique     = (isset($p['idLexique']))?$p['idLexique']:'0';


if ($idLexique==''){$idLexique=999;}

  $query = stripslashes($terme);
  
  $tSql = array();
  
  if ($query <> "") {
    //------------------------------------------------------------------------
    switch ($type ) {
  
    case 1 :                         //recherche dans la definition courte
      $sqlType = buildClauseLike ("shortDef", $query, $list_searchby);
  		break;
  		
    case 2 :                         //recherche dans la d&eacute;finition longue
      $sqlType = buildClauseLike ("definition1", $query, $list_searchby);
  		break;
  
    case 3 :                         //recherche dans le voir aussi
      $sqlType = buildClauseLike ("seeAlsoList", $query, $list_searchby);
  		break;
  		
    case 4 :                         //recherche dans le terme et les d&eacute;finitions
      $sqlType  = "  (".buildClauseLike ("name", $query, $list_searchby);
      $sqlType .= " OR ".buildClauseLike ("shortDef", $query, $list_searchby);
      $sqlType .= " OR ".buildClauseLike ("definition1", $query, $list_searchby);
    	$sqlType .= ")";
  		break;
  		
    case 5 :                         //recherche dans les d&eacute;finitions
      $sqlType  = "   (".buildClauseLike ("shortDef", $query, $list_searchby);
      $sqlType .= " OR ".buildClauseLike ("definition1", $query, $list_searchby);
    	$sqlType .= ")";
  		break;
  		
    case 6 :                         //recherche partout
      $sqlType  = "  (".buildClauseLike ("name", $query, $list_searchby);
      $sqlType .= " OR ".buildClauseLike ("shortDef", $query, $list_searchby);
      $sqlType .= " OR ".buildClauseLike ("definition1", $query, $list_searchby);
      $sqlType .= " OR ".buildClauseLike ("seeAlsoList", $query, $list_searchby);
    	$sqlType .= ")";
  		break;
  		
    case 0 :                         //recherche dans le terme
    default :
      $sqlType = buildClauseLike ("name", $query, $list_searchby);
  		break;
    }
    $tSql [] = $sqlType;
  }else
  {$sqlType = '';}
  //-----------------------------------------------------------------
  if ($category <> 0) {
     $categoryStr = bin2Str ($category);
      $categoryStr = str_replace ("0", "_", $categoryStr);
      
      $sqlWhereCategory = "((category LIKE '".$categoryStr."') OR (category =  ''))";

    $tSql [] = $sqlWhereCategory;  
  }
  
  $tSql [] = "state='"._LEX_STATE_OK."'";  
  $tSql [] = "idLexique = {$idLexique}";   
   
  $sqlWhere = " WHERE ".implode(' AND ', $tSql);    
  //-----------------------------------------------------------------
  return $sqlWhere;
}

//-----------------------------------------------------------

?>
