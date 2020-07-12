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

global $xoopsModuleConfig, $xoopsDB, $info, $idLexique;
include_once (XOOPS_ROOT_PATH."/class/xoopsformloader.php");

//-----------------------------------------------------------------------------------
global $xoopsModule;
include_once (XOOPS_ROOT_PATH."/modules/".$xoopsModule->getVar('dirname')."/include/constantes.php");
//-----------------------------------------------------------------------------------
include_once ("lexique_function.php");
include_once (_LEX_ROOT_JJD."functions.php");



//require_once ("constantes.php");


define ('_COLOR_SAMODE2', "#FF0000");


getLexInfo ($idLexique, $info, true);
//global $libelle;
getCaption ($info['idCaption'], $libelle);



//displayArray($info, 'info lexique');

//require_once ("seealso_function-".$info['synchroniseterme'].".php");
if (!isset($info['seealsomode']))  $info['seealsomode']=0;
$file = "seealso_function-".$info['seealsomode'].".php";
include_once ($file);
/*

echo "********************************************<br>";
echo "{$file}<br>";
echo "********************************************<br>";
*/


// jjd_echo ($exp, $binDebug = 15, $carLinEntete = "_", $carLineEnqueue = "_", $title = "", $lgLine=60){



define ("_SA_AD_LEX_REF_NEVER",            0);
define ("_SA_AD_LEX_REF_ALONEIFREF",       1);
define ("_SA_AD_LEX_REF_ALWAYSWITHREF",    2);
define ("_SA_AD_LEX_REF_ALWAYSWITHOUTREF", 3);
define ("_SA_AD_LEX_REF_MIXEDREF",         4);

define ("_SA_ICO_PATH", "images/arrows/");  
define ("_SA_ICO_PATH_SMALL",   _SA_ICO_PATH."small/");
define ("_SA_ICO_PATH_MEDIUM",  _SA_ICO_PATH."medium/");
define ("_SA_ICO_PATH_LARGE",   _SA_ICO_PATH."large/");
/*********************************************************************

**********************************************************************/
function setNewSeeAlso($id, $seeAlsoList, $colonne){

	global $xoopsModuleConfig, $xoopsDB;

  //-----------------------------------------------------------
  $sql = "UPDATE ".$xoopsDB->prefix(_LEX_TBL_TERME)
        ." SET ".$colonne." = '".$seeAlsoList."',"
        ." templink = '' "
        ." WHERE idTerme = ".$id;
    //echo "=>>> ".$sql."<br>";
  $xoopsDB->query($sql);

}

/************************************************************
 *
*************************************************************/
function buildLinkSeeAlso ($id, $name, $shortDef, $reference,$saMode, $info){
$colWidth1 = '20%';
GLOBAL $xoopsModuleConfig, $info;

/*

    //selon les param&egrave;tre de configuration on ajoute ou non l'icone "fleche" 
		if ($info['intlinksicon']) {
			  $ico = "&nbsp;<img src='images/info1.gif'>&nbsp;";
		} else {$ico="";}

    //------------------------------------------------------------
    //selon les parametre de configuration on construit un lien 
    //dans la meme fenetre  ou dans une fenetre popup
		if ($info['intlinkspopup']) {
			$link  = $ico."<a href=\"javascript:openWithSelfMain('popup.php?id=".$id."','',".$info['intlinkswidth'].",".$info['intlinksheight'].");\">".$name."</a>";
		} else {
			$link = $ico.'<a href="detail.php?id='.$id.'">'.$name.'</a>';
		}
*/	

    //------------------------------------------------------------
    //selon les parametre de configuration on construit un lien 
    //dans la meme fenetre  ou dans une fenetre popup
		if ($info['intlinkspopup']) {
			$link  = "<a href=\"javascript:openWithSelfMain('popup.php?mode=1&id=".$id."','',".$info['intlinkswidth'].",".$info['intlinksheight'].");\">".$name."</a>";
		} else {
			$link = '<a href="detail.php?id='.$id.'">'.$name.'</a>';
		}


		//--------------------------------------------------------------------
		if ($reference == 1){
		    $s = getDelimitor($info['detailSeeAlsoShowing']);
        $link = addDelimitor ($link,"#FF0000",$s,false);
    }
	
		//--------------------------------------------------------------------
    //selon les param&egrave;tre de configuration on ajoute ou non l'icone "fleche" 
    $ico = getIcoFullName(1, $reference, $info);
	  $link = $ico.$link;
		
		//--------------------------------------------------------------------		
		
    if ($saMode == 2){
        $col1 = '<td width="'.$colWidth1.'">';      
        $link = "<tr>".$col1.$link.'</td>'.'<td>'.$shortDef.'</td>'."</tr>";
    }
  return $link;
}

/************************************************************
 *
*************************************************************/
function getIcoFullName ($valide, $reference, $info){
GLOBAL $xoopsModuleConfig ;
/*
*/
		if ($info['intlinksicon']) {
		  if($valide == 1 ){
		    $numIco = ($reference == 1)?$info['icoref']:$info['icolink'];
      }
      else{
		    $numIco = $info['iconolink'];
      }
      switch ($info['icosize']){
        case 1:
          $folder = _SA_ICO_PATH_MEDIUM;
          break;
        
        case 2:
          $folder = _SA_ICO_PATH_LARGE;
          break;
          
        default:
          $folder = _SA_ICO_PATH_SMALL;
          break;
      }
      
      //echo $folder."<br>";
      //        echo "'"."img src='"._SA_ICO_PATH_SMALL."arrow".$numIco.".gif'"."'<br>"; 
	    $ico = "&nbsp;<img src='".$folder."arrow".$numIco.".gif'>&nbsp;";      
      
		}
    else{
      $ico = "";
    }

  return $ico;
}
/************************************************************
 *
*************************************************************/
function showSeeAlsoMode ($termeRef, $detailShowSeeAlso){
GLOBAL $xoopsModuleConfig,$info ;

  //switch ($info['detailShowSeeAlso']){
  switch ($detailShowSeeAlso){
    
  case _SA_AD_LEX_REF_NEVER:                   //_MI_LEX_REF_NEVER:
    $r = 0;
    break;
    
  case _SA_AD_LEX_REF_ALONEIFREF:              //_MI_LEX_REF_ALONEIFREF:
    $r = ($termeRef==1)?2:0;
    break;
    
  case _SA_AD_LEX_REF_ALWAYSWITHREF:           //_MI_LEX_REF_ALWAYSWITHREF:
    $r = 2;  
    break;
  
  case _SA_AD_LEX_REF_ALWAYSWITHOUTREF:        //_MI_LEX_REF_ALWAYSWITHOUTREF:
    $r = 1;
    break;
  
  case _SA_AD_LEX_REF_MIXEDREF:                //_MI_LEX_REF_MIXEDREF:
    $r = ($termeRef==1)?2:1;

     break; 
  
  default:
    $r = 0;
    break;  
  } 
 //$r=1;


//    echo "ref => ".$info['detailShowSeeAlso']." ===> ".$termeRef." ===> ".$r.'<br>';
		return $r;

}



/************************************************************
 *
*************************************************************/
function updateAllSeeAlsoId (){
	global $xoopsConfig,$xoopsModuleConfig , $xoopsDB,$info;
  
    $seealsomode = $info['seealsomode'];
    $oldSeealsomode = ($seealsomode==0)?1:0;
    
  	echo "<br>".$xoopsConfig['sitename'];
  	echo "<br>Traitement en cours"."------------------mode = ".$seealsomode;
    echo "<br>------------------------------------<br>";
    
    $sql = "SELECT idTerme, name, seeAlsoList from ".$xoopsDB->prefix(_LEX_TBL_TERME)
          ." WHERE seealsostatus = ".$oldSeealsomode." ORDER BY name";
    $sqlquery=$xoopsDB->query($sql);
//echo $sql."<br>";
    //test si on trouve au moins une expression
    if ($xoopsDB->getRowsNum($sqlquery)==0){return;}
    $nbEnr = $xoopsDB->getRowsNum($sqlquery); 
    //------------------------------------------------        
    while ($sqlfetch=$xoopsDB->fetchArray($sqlquery)) {
  			$idMot     = $sqlfetch['idTerme'];
  			$name      = $sqlfetch['name'];
  			$seeAlsoList = replaceSeparator($sqlfetch['seeAlsoList']);
        //-------------------------------------------------------
        if ($seeAlsoList <> "" ){
            $prefixe="";
            if ($seealsomode == 0){
              updateSeeAlsoID2Mot ($idMot, $seeAlsoList, $newseealsoid); 
              $prefixe = "-> id : ";
            }
            else {
              updateSeeAlsoMot2Id ($idMot, $seeAlsoList, $newseealsoid); 
              $prefixe = "-> mot : ";
            }
      			echo $prefixe."[".$idMot."] - [".$name."] - [".$seeAlsoList."] - [".$newseealsoid."]<br>";
        }
        /*
        */
    }
    
    echo "<br>------------------------------------<br>";
  	echo "".$nbEnr." enregistremants traitTs";
    echo "<br>------------------------------------<br>";
    return $nbEnr;
    
}


/************************************************************
 *
*************************************************************/
function updateSeeAlsoId2Mot ($idMot, &$OldSeealso, &$newSeealso ){
  global $xoopsConfig, $xoopsDB;
  
  echo "$OldSeealso = ".$OldSeealso."<br>";
  $tItems = explode ("/", $OldSeealso);
  $tFind = array ();
  //-----------------------------------------------------------
  for ($h = 0; $h < count($tItems); $h++){

    $item = trim ($tItems[$h]);
    $sql = "SELECT idTerme, name from ".$xoopsDB->prefix(_LEX_TBL_TERME)
          ." WHERE idTerme = ".$item."";
    $sqlquery = $xoopsDB->query($sql);

    //test si on trouve au moins une expression
    if (!$xoopsDB->getRowsNum($sqlquery)==0){
      while ($sqlfetch=$xoopsDB->fetchArray($sqlquery)) {
          $name = $sqlfetch['name'];
          $id = $sqlfetch['idTerme'];
          if ($id <> $idMot){
            if (!array_key_exists($name, $tFind)){
        			$tFind [$name] = $name;
              //echo $id."<br>";
            }
          }
          //-------------------------------------------------------
      }
    }
  }  
  
  //-----------------------------------------------------------------
          //echo "nb id = ".count($tId)."<br>";
  if (count($tFind) == 0){
    $newSeealso = "";
  }
  else {
    $newSeealso = implode ("/", $tFind);
  }
  
  echo $newSeealso;
  $sql = "UPDATE ".$xoopsDB->prefix(_LEX_TBL_TERME)
        ." SET seeAlsoList = '".$newSeealso."' ,  seealsostatus = 0, templink = '' "
        ." WHERE idTerme = ".$idMot."";
  $xoopsDB->query($sql);
  
  return count($tFind);


}

/************************************************************
 *
*************************************************************/
function updateSeeAlsoMot2ID ($idMot, &$OldSeealso ,  &$newSeealso ){
  global $xoopsConfig, $xoopsDB;
  
  $tMots = explode ("/", $OldSeealso);
  $tId = array ();
  //-----------------------------------------------------------
  for ($h = 0; $h < count($tMots); $h++){

    $mot = trim ($tMots[$h]);
    $sql = "SELECT idTerme, name from ".$xoopsDB->prefix(_LEX_TBL_TERME)
          ." WHERE name = '".$mot."'";
    $sqlquery = $xoopsDB->query($sql);

    //test si on trouve au moins une expression
    if (!$xoopsDB->getRowsNum($sqlquery)==0){
      while ($sqlfetch=$xoopsDB->fetchArray($sqlquery)) {
          $id = $sqlfetch['idTerme'];
          if ($id <> $idMot){
            if (!array_key_exists("k-".$id, $tId)){
        			$tId ["k-".$id] = $id;
              //echo $id."<br>";
            }
          }
          //-------------------------------------------------------
      }
    }
  }  
  
  //-----------------------------------------------------------------
          //echo "nb id = ".count($tId)."<br>";
  if (count($tId) == 0){
    $newSeealso = "";
  }
  else {
    $newSeealso = implode ("/", $tId);
  }
  
  echo $newSeealso;
  $sql = "UPDATE ".$xoopsDB->prefix(_LEX_TBL_TERME).' '
        ." SET seeAlsoList = '".$newSeealso."' ,  seealsostatus = 1, templink = '' "
        ." WHERE idTerme = ".$idMot."";
  $xoopsDB->query($sql);
  
  return count($tId);

}


/************************************************************
 * Cree la liste de lien sur les mot de SeeAlso
 * $idMot est l'identifiant a exclure pour ne pas point+ sur lui meme 
*************************************************************/
function parserSeeAlso ($idMot, $seeAlsoList = "", $saMode = 1, $info) {
Global $xoopsDB, $xoopsModuleConfig,$info;  


  $cache = $info['detailSeeAlsoCache'];

  $link = getCacheLink ($idMot);
  //$link = "";
  if ($link == "" OR $cache == _LEXCST_SA_NOCACHE){
      $link = parserSeeAlsoOnMode ($idMot, $seeAlsoList, $saMode, $info['searchSeeAlsoMode'], $info);
      //setCacheLink ($idMot, "");  
      if ($cache > _LEXCST_SA_NOCACHE){
        setCacheLink ($idMot, $link);
      }
  }
  elseif ($cache == _LEXCST_SA_CACHEMARK) {
    $link .= ' (JÝJÝD)';     //utilisT pour le debugage. indicateur que c'est bien le cache
  }  

  return $link;
}

/************************************************************
 *
*************************************************************/
function getCacheLink ($id) {
Global $xoopsDB, $xoopsModuleConfig;
	
  $sql = "SELECT templink FROM ".$xoopsDB->prefix(_LEX_TBL_TERME)." "
        ."WHERE idTerme = ".$id." " ;	
  
	$result = $xoopsDB->query($sql);
	list ($link) = $xoopsDB->fetchRow($result);
  if ($link == null){$link = '';}
  
  return $link;
  
  
}

/************************************************************
 *
*************************************************************/
function setCacheLink ($id, $link) {
Global $xoopsDB, $xoopsModuleConfig;
	 
	 
	 //$link = "bbbbbb";		
   $myts =& MyTextSanitizer::getInstance();
		$link = $myts->makeTareaData4Save($link);
  $link = str_replace("'", "''", $link);
  //$link = str_replace("[", "x", $link);
  //$link = str_replace("[", "x", $link);
  //$link = str_replace("<", "x", $link);
  //$link = str_replace(">", "x", $link);
  
  
  
  
	 $sql = "UPDATE ".$xoopsDB->prefix(_LEX_TBL_TERME)." "
          . " SET templink = '{$link}'"
          . " WHERE idTerme = {$id}"; 
   
   $xoopsDB->queryF($sql);
   //echo $sql."<br>";
  return true;

}

/************************************************************
 *
*************************************************************/
function clearCacheLink ($id = 0) {
Global $xoopsDB;
	 
	 $sql = "UPDATE ".$xoopsDB->prefix(_LEX_TBL_TERME)." SET templink = '' ";
   if ($id > 0){$sql .= "WHERE idTerme = ".$id;} 
   $xoopsDB->queryF($sql);
}


/************************************************************
 *modifi les identifiant seealso pour faire un test 
 * avec des idSeeAlso <> idterme
*************************************************************/
function changeIdSeeAlso($idLexique = 0, $table = _LEX_TBL_TERME){
	Global $xoopsModuleConfig, $xoopsDB, $xoopsConfig, $xoopsModule;
	
	  $clauseLexique = ($idLexique <> 0)?" WHERE idLexique = {$idLexique}":'';
    $sql = "SELECT * FROM ".$xoopsDB->prefix($table)
         .$clauseLexique." ORDER BY Name";
    $sqlquery=$xoopsDB->query($sql);
//    displaySql($sql, 'changeIdSeeAlso - Select',false,true);
    
    
    while ($sqlfetch=$xoopsDB->fetchArray($sqlquery)) {
      $idSeeAlso =  $sqlfetch['idTerme'] * 10 + 8;
      
      //$seeAlsoList = $sqlfetch["seeAlsoList"];
      $seeAlsoList = $sqlfetch["seealso"];    
        
      if ($seeAlsoList == ''){
          $sql = "UPDATE ".$xoopsDB->prefix($table)
                ." SET idSeeAlso   = {$idSeeAlso} "
                ." WHERE idTerme = {$sqlfetch['idTerme']}";  
          $xoopsDB->query($sql);      
      
      }else
      
      {
          $t = explode("/", $seeAlsoList);
          
          for ($h = 0; $h < count($t); $h++){
            $t[$h] = $t[$h] * 10 + 8;
          }
          $seeAlsoList = implode("/", $t);
          
          $sql = "UPDATE ".$xoopsDB->prefix($table)
                ." SET idSeeAlso   = {$idSeeAlso}, "
                ."     seeAlsoList = '{$seeAlsoList}' "
                ." WHERE idTerme = {$sqlfetch['idTerme']}";  
          $xoopsDB->query($sql);      
      
      }
//      displaySql($sql, 'changeIdSeeAlso',false,true);      
      
    }

}

?>
