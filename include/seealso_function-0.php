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



//***************************************************************

define ('_LEXCOL_SEE_ALSO', 'seeAlsoList');


/************************************************************
*************************************************************/
function parserSeeAlsoOnMode ($idMot, $seeAlsoList = "", $saMode = 1, $searchSeeAlsoMode, $info) {
//displayArray($info,"-------parserSeeAlsoOnMode-----------");
  //$motsSources="do/zan/za/gae/aku:zzz:xxx";
	Global $xoopsDB, $xoopsModuleConfig;
  $ref = array();  //va permettre le stockage des mot avec le lien hypertext.
  $idFind = array ();
  $sql="";
//echo "<hr>parserSeeAlsoOnMode -> $seeAlsoList = {$seeAlsoList}<hr>";  
  if ($seeAlsoList == ''){return  "<table> </table>";}
  $text = replaceSeparator($seeAlsoList);
  
  //la chaine 'voir aussi' stockTe dans la table est une suite d'expression sTparTe par des '/'
  //ex bonbon/sucrerie/gaterie/friandise
  //on commence par la transformer en tableau d'expression
  $tmot = explode("/",$text);
//  displayArray ($tmot,'tmot --->'.$seeAlsoList);
  // balayage du tableau a la recherche des expressions &eacute;quivalentes dans la table
  while (list ($key, $val) = each ($tmot)) {
    $ok = false;
 		if ($val <> ''){
        //recherche dans le dico de l'expression
        $toSearch = buildClauseLike ("name", $val, $searchSeeAlsoMode );
        $sql = "SELECT idTerme, name, shortDef, reference "
              ." from ".$xoopsDB->prefix(_LEX_TBL_TERME)
              ." WHERE {$toSearch} "
              ." AND state='"._LEX_STATE_OK."' "
              ." AND idSeealso <> {$idMot}"
              ." AND idLexique = {$info['idLexique']}" ;
//echo "<hr>parserSeeAlsoOnMode -> {$idMot}<br>{$sql}<hr>";              
    //    displaySql($sql,'parserSeeAlsoOnMode',true);
        $sqlquery=$xoopsDB->query($sql);
      //jjd_echo ($sql,15);
      //jjd_echo ("nb enr = ".$xoopsDB->getRowsNum($sqlquery),15);
        $ok = ($xoopsDB->getRowsNum($sqlquery)==0)?false:true;
     }	
      
      
    //test si on trouve au moins une expression
    //if ($xoopsDB->getRowsNum($sqlquery)==0){    
    if (!$ok){
        //bin non, alors on met l'icone rouge, sans lien hypertext
        
        $ico = getIcoFullName(0, 0, $info);        
        if ($val==""){ $ref[] ="";} else{ $ref[] =$ico.strToUpper($val);}

    }
    else{
      //yes on a trouv&eacute; une ou plusieurs expressions dans le dico
      //pour chacune on cr&eacute; un lien hypertexte avec l'icone verte
    	while ($sqlfetch=$xoopsDB->fetchArray($sqlquery)) {
    	    //le lien est construit avec le terme trouv&eacute;, et son identifiant pur pouvor point&eacute; dessus
    			$id = $sqlfetch['idTerme'];
    			if (!array_key_exists( "k-".$id, $idFind)){
    				//---------------------------------------------------------------
    				$idFind ["k-".$id] = true;
      			$name      = $sqlfetch['name'];
      			$shortDef  = $sqlfetch['shortDef'];     
       			$reference = $sqlfetch['reference'];   
            $ref[] = buildLinkSeeAlso($id, $name, $shortDef,$reference , $saMode, $info);

    				//---------------------------------------------------------------
          }
    			
        }
      }  
    }   

  //on a tout balay&eacute;, on trasforme le tableau obenu en une chaine complete
  //prette a &ecirc;tre ins&eacute;rer dans la paage HTML
  $r = join(" ", $ref);
  if ($saMode==2){$r = "<table>{$r}</table>";}  
  return ($r);
  
}


/*********************************************************************

**********************************************************************/
function synchroniseSeeAlso($id, $seeAlso = "", $name =""){

	global $xoopsModuleConfig, $xoopsDB, $info;
	//echo "synchroniseterme = {$info['synchroniseterme']} <br>";
	if ($info['synchroniseterme']==0) return;
	//------------------------------------------------------------
  if ($seeAlso == "" or $name == "") {
    $sql = "SELECT seeAlso, name FROM ".$xoopsDB->prefix(_LEX_TBL_TERME)
          ." WHERE idTerme = ".$id." ";
    
    	$result = $xoopsDB->query($sql);
	     list ($seeAlso, $name)  = $xoopsDB->fetchRow($result);

    }
    $seeAlso = str_replace ("/", ",", $seeAlso);
    synchroniseSeeAlso_add ($id, $seeAlso, $name);  
    synchroniseSeeAlso_delete ($id, $seeAlso, $name);      

  
}
 
/*********************************************************************

**********************************************************************/
function synchroniseSeeAlso_add($id, $seeAlso, $name){


	global $xoopsModuleConfig, $xoopsDB;
  //--------------------------------------------------
  //echo $id." - ".$seeAlso."<br>";
  //--------------------------------------------------
 if ($seeAlso == ''){
    $clauseIn = '';  
  }else{
    $sqlSeeAlso = addQuoteInList ($seeAlso);  
    $clauseIn = "name IN ({$sqlSeeAlso}) ";
  }
  
  
  $sql = "SELECT idTerme, name, seealso FROM ".$xoopsDB->prefix(_LEX_TBL_TERME)
        ." WHERE idTerme <> {$id} {$clauseIn}"
        ." ORDER BY name";
 
  //echo "<hr>synchroniseSeeAlso_add - {$idSeeAlso}<br>{$sql}<hr>";       
  //echo $id." - ".$sql."<br>";
  $sqlquery = $xoopsDB->query($sql);
  
	while ($sqlfetch=$xoopsDB->fetchArray($sqlquery)) {
    $id2Synchronise = $sqlfetch["idTerme"];
    $ids = $sqlfetch[_LEXCOL_SEE_ALSO];
    
    if (!isIdInList ($name, $ids, "/")){
        if ($ids == ""){
          setNewSeeAlso($id2Synchronise, $name, _LEXCOL_SEE_ALSO);
        }
        else{
          setNewSeeAlso($id2Synchronise, $ids."/".$name, _LEXCOL_SEE_ALSO);
        } 
        
      }
  }


}  

/*********************************************************************

**********************************************************************/
function synchroniseSeeAlso_delete($id, $seeAlso, $name){

//return;
	global $xoopsModuleConfig, $xoopsDB;
  //--------------------------------------------------
  //echo $id." - ".$seeAlso."<br>";
  //--------------------------------------------------
  $seeAlso_old    = getTemp(_LEX_TBL_TERME, "seealsoid_old", $id);
  $tSeeAlsoId_old =  explode ("/", $seeAlso_old); 
 // echo "synchroniseSeeAlsoById_delete ->".$seeAlso_old."-count=".count($tSeeAlsoId_old)."<br>";
  
  $tSeeAlsoId = explode (",", $seeAlso); 
  //echo "synchroniseSeeAlsoById_delete ->".$seeAlso."-count=".count($tSeeAlsoId)."<br>";
  
  $tSeeAlso2del = array_diff ($tSeeAlsoId_old, $tSeeAlsoId);
  $seeAlso = implode (",", $tSeeAlso2del);
  //----------------------------------------------------
  if ($seeAlso == ''){
    $clauseIn = '';  
  }else{
    $sqlSeeAlso = addQuoteInList ($seeAlso);  
    $clauseIn = "name IN ({$sqlSeeAlso}) ";
  }
  
  
  $sql = "SELECT idTerme, name, seealso FROM ".$xoopsDB->prefix(_LEX_TBL_TERME)
        ." WHERE idTerme <> {$id} {$clauseIn}"
        ." ORDER BY name";
  //echo $id." - ".$sql."<br>";
  $sqlquery = $xoopsDB->query($sql);
  
	while ($sqlfetch=$xoopsDB->fetchArray($sqlquery)) {
    $id2Synchronise = $sqlfetch["idTerme"];
    $ids = $sqlfetch[_LEXCOL_SEE_ALSO];
    
    $tIds = explode ("/", $ids);
    $tId    = array();
    $tId [] = $name;
    $tId = array_diff ($tIds, $tId);
    $ids = implode ("/", $tId);
  //echo "setNewSeeAlso -> ".$id2Synchronise."-".$ids."<br>";
    setNewSeeAlso($id2Synchronise, $ids, _LEXCOL_SEE_ALSO);
 
  }


}  

/******************************************************************************
 * renvoi la liste des termes et d'identifiant correspondant au parametres
 * de la requetet POST.
 * Utilis‚ dans le formumaire d"edition pour metre … jour la liste 
 * recoit dans post la lise actuelle des id plus le nouvel id si on a cocher la case
 * plus leid as supprimer si la case a ete decoch‚e  
 *****************************************************************************/  
function SeeAlsoDefinition($post, &$newListId, &$newListName, $sepId = "/", $sepName = " - ") {
	global $xoopsModuleConfig, $xoopsDB, $info;
	
  $id         = $post['id'];
  $idTochange = $post['idTochange']; 
  $value      = $post['value']; 
  $list       = $post['list']; 


  if ($list=="" ){
    $list = $idTochange;
  }
  else{
    $list = str_replace ("/", ",", $list);
    $list .= ",".$idTochange;
  }
  //echo "<br>"."list = ".$list."<br>";
  //---------------------------------------------------------------
  $clauseIn = ($list == '')?'':" AND idSeeAlso IN ({$list}) ";
  $sql = "SELECT idTerme, idSeeAlso, name "
        ."FROM ".$xoopsDB->prefix(_LEX_TBL_TERME)
        ." WHERE idLexique = {$info['idLexique']} {$clauseIn} ";
  if ($value == 'false') {$sql .= " AND idTerme <> ".$idTochange;}
  $sql .= " ORDER BY name";
  $tId   = array();
  $tName = array();
  
	$sqlquery=$xoopsDB->query($sql);
	while ($sqlfetch=$xoopsDB->fetchArray($sqlquery)) {
    $tId   []= $sqlfetch["idTerme"];
    $tName []= $sqlfetch["name"];
	
  }
 		
  $newListId   = implode ($sepId, $tId);
  $newListName = implode ($sepName, $tName);

  $myts =& MyTextSanitizer::getInstance();  
  $newListName = $myts->makeTareaData4Show($newListName, "1", "1", "1"); 

  
}

/******************************************************************
 * 
 ******************************************************************/
 function getSeeAlsoName($ListId, $idToExclude,$sep = "/") {
	global $xoopsModuleConfig, $xoopsDB;
	
  if ($ListId == "" ){return "";}
  $ListName = str_replace ("/", $sep, $ListId);
  //---------------------------------------------------------------
  $myts =& MyTextSanitizer::getInstance();  
  $ListName = $myts->makeTareaData4Show($ListName, "1", "1", "1"); 
  //---------------------------------------------------------------
  
   return $ListName;
}


?>
