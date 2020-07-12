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


define ('_LEXCOL_SEE_ALSO', 'seeAlsoList');


/************************************************************
 * Cree la liste de lien sur les mot de SeeAlso
 * $idMot est l'identifiant a exclure pour ne pas pointT sur lui meme 
*************************************************************/
function parserSeeAlsoOnMode ($idMot, $seeAlsoList = "", $saMode = 1,$searchSeeAlsoMode, $info) {
//echo "<hr>parserSeeAlsoOnMode<br>$idMot<hr>";
  //$motsSources="do/zan/za/gae/aku:zzz:xxx";
	Global $xoopsDB, $xoopsModuleConfig;
  $ref = array();  //vapermettre le stockage des mot avec le lien hypertext.
  $idFind = array ();

  
  if ($seeAlsoList == "") return "";
  
  $list = replaceSeparator($seeAlsoList, ",");
  $clauseIn = ($list <> '')?" AND idSeeAlso in ({$list})":'';
  $sql = "SELECT idTerme, idSeeAlso, name, shortDef, reference from ".$xoopsDB->prefix(_LEX_TBL_TERME)
        ." WHERE idLexique = {$info['idLexique']}".$clauseIn  
        ." AND state = '"._LEX_STATE_OK."' "
        ." AND idSeeAlso <> {$idMot}";
//displaySql($sql,'',true);
        
  $sqlquery = $xoopsDB->query($sql);
	while ($sqlfetch=$xoopsDB->fetchArray($sqlquery)) {
	    //le lien est construit avec le terme trouvT, et son identifiant pour pouvor pointT dessus
			$id = $sqlfetch['idTerme'];
			if (!array_key_exists( "k-".$id, $idFind)){
				//---------------------------------------------------------------
				$idFind ["k-".$id] = true;
  			$name      = $sqlfetch['name'];
  			$shortDef  = $sqlfetch['shortDef'];    
  			$reference = $sqlfetch['reference'];            
        $ref[] = buildLinkSeeAlso($id, $name, $shortDef, $reference, $saMode, $info);
      } 
  }
  

  //on a tout balayT, on trasforme le tableau obenu en une chaine complete
  //prette a &Ttre insTrer dans la page HTML
  $r = join(" ", $ref);
//echo $r."<br>";  
  if ($saMode==2){$r = "<table>".$r."</table>";}
  return ($r);
  //return ($sql);
  
}

  
/*********************************************************************
ajoute l'identifiant du terme en cours dans la liste des id des termes 
de la rubrique sealso li‚
**********************************************************************/
function synchroniseSeeAlso($idTerme, $seeAlsoList = ''){

	global $xoopsModuleConfig, $xoopsDB, $info;
	
  if ($info['synchroniseterme'] == 0) return;
//	echo "synchroniseterme = {$info['synchroniseterme']} <br>"
//      ."idSeeAlso = {$idSeeAlso}<br>seeAlsoList = {$seeAlsoList}<br>";  
	//------------------------------------------------------------
	
  //if ($seeAlsoList == '') {
    $sql = "SELECT idSeeAlso, seeAlsoList FROM ".$xoopsDB->prefix(_LEX_TBL_TERME)
          ." WHERE idTerme = {$idTerme} AND idLexique = {$info['idLexique']} ";
    
    	$result = $xoopsDB->query($sql);
	    list ($idSeeAlso, $seeAlsoList)  = $xoopsDB->fetchRow($result);

    //}
//	echo "idSeeAlso = {$idSeeAlso}<br>seeAlsoList = {$seeAlsoList}<br>";  

    $seeAlsoList = replaceSeparator($seeAlsoList, ",");
    synchroniseSeeAlso_add    ($idSeeAlso, $seeAlsoList);
    
    //recupere la liste des anciens identifiants et la transforme en tableau 
    $seeAlso_old    = getTemp(_LEX_TBL_TERME, "seealsoid_old", $idTerme);
    synchroniseSeeAlso_delete ($idSeeAlso, $seeAlsoList,$seeAlso_old);
//    echo '******************************************'.$seeAlsoList.'<br>';  
}
 
/*********************************************************************
 *
**********************************************************************/
function synchroniseSeeAlso_add($idSeeAlso, $seeAlsoList){
//  echo "0-synchroniseSeeAlso_add<br>     idSeeAlso = {$idSeeAlso}<br>     seeAlsoList = {$seeAlsoList}<br>";
  if ($seeAlsoList == '') {return;}
	global $xoopsModuleConfig, $xoopsDB, $info;
  //--------------------------------------------------
  //echo $id." - ".$seeAlso."<br>";
  //--------------------------------------------------
  $clauseIn = ($seeAlsoList == '')?'':" AND idSeeAlso IN ({$seeAlsoList}) ";
  $sql = "SELECT idTerme, name, seeAlsoList FROM ".$xoopsDB->prefix(_LEX_TBL_TERME)
        ." WHERE idLexique = {$info['idLexique']} {$clauseIn} " 
        ."  AND idSeealso <> {$idSeeAlso}"
        ."  ORDER BY name";
  //echo "<hr>synchroniseSeeAlso_add - {$idSeeAlso}<br>{$sql}<hr>";
  $sqlquery = $xoopsDB->query($sql);
  
	while ($sqlfetch=$xoopsDB->fetchArray($sqlquery)) {
    $id2Synchronise = $sqlfetch["idTerme"];
    $ids = $sqlfetch[_LEXCOL_SEE_ALSO];
    
    if (!isIdInList ($idSeeAlso, $ids, "/")){
        if ($ids == ""){
          setNewSeeAlso($id2Synchronise, $idSeeAlso, _LEXCOL_SEE_ALSO);
        }
        else{
          setNewSeeAlso($id2Synchronise, "{$ids}/{$idSeeAlso}", _LEXCOL_SEE_ALSO);
        } 
        
      }
  }

}

/*********************************************************************

**********************************************************************/
function synchroniseSeeAlso_delete($idSeeAlso, $seeAlsoList,$seeAlso_old){

  //if ($seeAlsoList == '') {return;}
	global $xoopsModuleConfig, $xoopsDB, $info;
  //--------------------------------------------------

  $tSeeAlsoId_old =  explode ("/", $seeAlso_old); 
  
  
  if ($seeAlso_old == ''){return;}  
  //fait la diff‚rence entre la nuvelle et l'ancienne liste, et extrait la list des id a supprimer
  $tSeeAlsoId = explode (",", $seeAlsoList); 
  
  $tSeeAlso2del = array_diff ($tSeeAlsoId_old, $tSeeAlsoId);
  $seeAlsoList = implode (",", $tSeeAlso2del);
  if ($seeAlsoList == ''){return;}  
  
  //----------------------------------------------------
  $clauseIn = ($seeAlsoList == '')?'':" AND idSeeAlso IN ({$seeAlsoList}) ";
  $sql = "SELECT idTerme, idSeeAlso, name, seeAlsoList FROM ".$xoopsDB->prefix(_LEX_TBL_TERME)
        ." WHERE idLexique = {$info['idLexique']} {$clauseIn}" 
        ." AND idSeeAlso <> {$idSeeAlso} "
        ." ORDER BY name,idTerme";

  $sqlquery = $xoopsDB->query($sql);
  
	while ($sqlfetch=$xoopsDB->fetchArray($sqlquery)) {
    $id2Synchronise = $sqlfetch["idTerme"];
    $ids = $sqlfetch["seeAlsoList"];
    
    $tIds = explode ("/", $ids);
    $tId    = array();
    $tId [] = $idSeeAlso;
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
 * plus les id as supprimer si la case a ete decoch‚e  
 *****************************************************************************/  
function SeeAlsoDefinition($post, 
                           &$newListId, 
                           &$newListName, 
                           $sepId = "/", 
                           $sepName = " - ") {
                           
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
  //selection de tous les identifiants y compris selui a supprimer
  $clauseIn = ($list == '')?'':" AND idSeeAlso IN ({$list}) ";
  $sql = "SELECT idTerme, idSeeAlso, name FROM ".$xoopsDB->prefix(_LEX_TBL_TERME)
        ." WHERE idLexique = {$info['idLexique']} {$clauseIn}";
  
  //que l'on exclu par l'ajout de cette clause le cas ‚ch‚ant      
  if ($value == 'false') {$sql .= " AND idSeeAlso <> ".$idTochange;}
  $sql .= " ORDER BY name";
  $tId   = array();
  $tName = array();
  
	$sqlquery=$xoopsDB->query($sql);
	while ($sqlfetch=$xoopsDB->fetchArray($sqlquery)) {
    //$tId   []= $sqlfetch["idTerme"];
    $tId   []= $sqlfetch["idSeeAlso"];    
    $tName []= $sqlfetch["name"];
	
  }
 		
  $newListId   = implode ($sepId, $tId);
  $newListName = implode ($sepName, $tName);  
  
  //transformation des caractere accentue avans renvoi des valeur
  $newListName = htmlentities($newListName, ENT_QUOTES);
  
}

/******************************************************************
 * 
 ******************************************************************/
 function getSeeAlsoName($ListId, $idToExclude, $sep = "/") {
	global $xoopsModuleConfig, $xoopsDB, $info;
	
  if ($ListId == "" ){return "";}
  $ListId = str_replace ("/", ",", $ListId);
  //---------------------------------------------------------------
  //---------------------------------------------------------------
  $clauseIn = ($ListId == '')?'':" AND idSeeAlso IN ({$ListId}) ";
  $sql = "SELECT idTerme, idSeeAlso, name FROM ".$xoopsDB->prefix(_LEX_TBL_TERME)
        ." WHERE idLexique = {$info['idLexique']} {$clauseIn}";
//displaySql($sql, 'getSeeAlsoName.........');   
     
  if ($idToExclude <> 0) {$sql .= " AND idSeeAlso <> ".$idToExclude;}
  $sql .= " ORDER BY name";
  $tName = array();
  
	$sqlquery=$xoopsDB->query($sql);
	while ($sqlfetch=$xoopsDB->fetchArray($sqlquery)) {
    $tName []= $sqlfetch["name"];
  }
  //--------------------------------------------------------------- 	
  $ListName = implode ($sep, $tName);  
  $myts =& MyTextSanitizer::getInstance();  
  $ListName = $myts->makeTareaData4Show($ListName, "1", "1", "1"); 
  //---------------------------------------------------------------
  	

  return $ListName;
}

function wlogsa ($text){

  $f = _LEX_ROOT_PATH."log/log.txt";
  $f =str_replace("\/", "\\", $f);

    $handle = fopen ($f, "a");

    
    fwrite ($handle, $text.chr(13).chr(10));    
    
    fclose ($handle);



}
?>
