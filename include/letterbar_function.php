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

//-----------------------------------------------------------------------------------
global $xoopsModule;
include_once (XOOPS_ROOT_PATH."/modules/".$xoopsModule->getVar('dirname')."/include/constantes.php");
//-----------------------------------------------------------------------------------
include_once (_LEX_JJD_PATH.'include/functions.php');
require_once ("temp_function.php");

define ('_COLOR_NORMAL',   "#000000");
define ('_COLOR_SELECTED', "#FF0000");
//define ('_DELIMITEURS', "()");
define ('_DELIMITEURS', "");

/***************************************************************************
JJD - 15/07/2006
Fonction rTTcrite completement
J'ai rempllace le tableau de l'alphabet par une constante dTfini dans 
les fichiers de langue. 
remplacement du "autres" par un param&egrave;tre de configuration par dTfaut Tgal a "#" 
lui aussi dans les fichiers langues
au passage le champ letter n'est plus que de 1 caractere histoire aussi
d'optimiser la base de donnees. D'ailleurs y a pas que ca 
les autres champs aussi ont ete retailles
Changement separateur " | " par un simple espace de facon a avoir l'aphabet sur une ligne
Optimisation de la construction par constitution d'un tableau concatene ensuite

    letterBar("submit.php", "letter", "limite", 0, " ", "id=".$id, $letter);
****************************************************************************/
function letterBarInfo($id, $mode = 0) {
	Global $xoopsDB, $xoopsModuleConfig, $info;
  
  if ($id == '')$id = $info['idlexique'];
  
  buildColSql ('selecteur', 'name as selecteur,alphabet,other,showAllLetters,frameDelimitor,letterSeparator,rows', $tColsSelecteur, $sColsSelecteur);
  
  switch ($mode){
    case 1:
      $sql = "SELECT {$sColsSelecteur} "
          ." FROM ".$xoopsDB->prefix(_LEX_TBL_SELECTEUR)." as selecteur "
          ." WHERE selecteur.idSelecteur = {$id}";
//      echo "$sql<br>";
      $sqlquery = $xoopsDB->query($sql);
      $t = $xoopsDB->fetchArray($sqlquery);  
          
      break;
    
    case 2:
      $sql = "SELECT {$sColsSelecteur} "
          ." FROM ".$xoopsDB->prefix(_LEX_TBL_LEXIQUE)."   as lexique,"
                   .$xoopsDB->prefix(_LEX_TBL_SELECTEUR)." as selecteur "
          ." WHERE lexique.idSelecteur    =  selecteur.idSelecteur "
          ."   AND lexique.idLexique  = {$id} ";
//      echo "$sql<br>";
      $sqlquery = $xoopsDB->query($sql);
      $t = $xoopsDB->fetchArray($sqlquery);  
      
      break;
    
    default:
      $t = array(
                'other' => $info['other'],
                'alphabet' => $info['alphabet'],           
                'showAllLetters' => $info['showAllLetters']                     
                ) ;
    break;
  }
  
          
	   return $t;
}
//------------------------------------------------------------------------------
function letterBar($Link, 
                   $letterParamName = "letter", 
                   $limiteParamName = "limite", 
                   $limite = 0, 
                   $sep = " ", 
                   $otherParams = "",
                   $oldLetter = "", 
                   $scriptName = "", 
                   $seealsoTemp = "", 
                   $idLexique = 1) {
                   


	Global $xoopsDB, $xoopsModuleConfig,$info; 

	//$t = letterBarInfo ($idLexique, ($idLexique==0)?0:2);	
	$t = letterBarInfo ($idLexique, 2);
    
  if ( $t['showAllLetters'] == 0){
    $alphabet =   getLetterUsed ( $t['alphabet'], $t['other']);
  }else{
    $alphabet =   $t['alphabet'];
    if ($alphabet == ''){$alphabet = $xoopsModuleConfig['alphabet'];}  
  }
 

   // return letterBarUsed  ($Link, $letterParamName, $alphabet, $other, $sep, $limiteParamName, $limite, $otherParams, $oldLetter);
    if ($scriptName == ""){
        return letterBarDefine($Link, $letterParamName, $alphabet, 
                                      $t['other'], $sep, $limiteParamName, 
                                      $limite, $otherParams, $oldLetter, $t);  
    
    }
    else {
        return letterBarDefineJS($Link, $letterParamName, $alphabet, 
                                      $t['other'], $sep, $limiteParamName, 
                                      $limite, $otherParams, $oldLetter, 
                                      $scriptName, $seealsoTemp, $t);  
    
    }

}
//---------------------------------------------------

/***************************************************************************
 appelle par 'letterBar'. selon le parametre de configuration construit
 la barre de selection de l'alphabet a partir de la chaine configuree
 cela permet d'ajouter ou d'enlever des caracteres specifiques a 
 certaines langues
****************************************************************************/
function letterBarDefine($link, 
                         $letterParamName, 
                         $alphabet, $other, $sep = " ", 
                         $limiteParamName="limite", $limite=0,
                         $otherParams = "" ,
                         $oldLetter = "", 
                         $tInfo ) {
  
  $ta= array();
    $debLink = "<b><a href='".$link."?";
    if ($otherParams<>""){ $debLink .= $otherParams."&";};

  buildDelimitors($tInfo, $separateur, $prefixe, $suffixe, $between);

	
  for ($i = 0; $i < strLen($alphabet) ; $i++) {
    $ltr = substr($alphabet, $i, 1);
    //if ($ltr == $oldLetter){ $ltrlib = "<font color='#FF0000'>".$ltr."</font>" ;}
    if ($ltr == '_'){
       $ta[$i] = $between;
       
    }else{
        if ($ltr == $oldLetter){
            $ltrlib = FormaterSelection ($ltr, _COLOR_SELECTED, _DELIMITEURS) ;
        }else { 
            $ltrlib = $ltr ; 
        }
        
        $ta[$i]= $debLink.$letterParamName."=$ltr&".$limiteParamName."=$limite'>".$ltrlib."</a></b>";
    
    } 
    
  }
  //----------------------------------------------------------------------
  //   wlog(letterBarBuildString($ta, $tInfo)));

  return   letterBarBuildString($ta, $tInfo);
}

/***************************************************************************
 *
****************************************************************************/

function letterBarDefineJS($link, 
                         $letterParamName, 
                         $alphabet, 
                         $other, 
                         $sep = " ", 
                         $limiteParamName="limite", 
                         $limite=0,
                         $otherParams = "" ,
                         $oldLetter = "", 
                         $scriptName = "", 
                         $seealsoTemp = "",
                         $tInfo ) {
  
  $ta= array();
//    wlog($alphabet);

  $r = "<b><a href='#' onclick='%0%(\"%1%\",\"%3%\");'>%2%</a></B>";
  $r= str_replace("%0%", $scriptName, $r);

  $debLink = $link."?";    
  if ($otherParams<>""){ $debLink .= $otherParams."&";};
  
  buildDelimitors($tInfo, $separateur, $prefixe, $suffixe, $between);
    
    //if ($otherParams<>""){ $alphabet .= $otherParams;}
  //-----------------------------------------------------------------	
  for ($i = 0; $i < strLen($alphabet) ; $i++) {
    $ltr = substr($alphabet, $i, 1);

    if ($ltr == '_'){
      $ta[$i] = $between;
    } 
    else{
        if ($ltr == $oldLetter){    
          $ltrlib = FormaterSelection ($ltr, _COLOR_SELECTED, _DELIMITEURS) ;
        }
        else {
          $ltrlib = $ltr ; 
        }
        //---------------------------------------------------------------------
        $newLink = $debLink.$letterParamName."=$ltr&".$limiteParamName."=".$limite;
        //$newLink = $debLink.$letterParamName."={$ltr}&toto=titi&{$limiteParamName}={$limite}";    
        
        $r2 = str_replace ("%1%", $newLink, $r);
        $r2 = str_replace ("%2%", $ltr, $r2);    
        $r2 = str_replace ("%3%", $seealsoTemp, $r2);    
        
        $ta[$i]= $r2;
    
    }
  }
  //----------------------------------------------------------------------
//    wlog(letterBarBuildString($ta,$tInfo));
//    wlog($alphabet);

  return   letterBarBuildString($ta, $tInfo);
}

//-----------------------------------------------------------------------

/***************************************************************************
 *construit la liste des caracteres utilise dans le lexique.
 *Cette liste est construite a partir du premier caractere de chaque mot
 *si $other = 0 prend tous les caractFres trouves
 *si $other = 1 prend que les caracteres trouve qi se trouve dans $alphabet 
 *              et met les autres sous autres: "#"     
****************************************************************************/
function getLetterUsed($alphabet, $other){

	Global $xoopsDB, $xoopsModuleConfig,$info;
    $ta= array();
    
    if ($alphabet == ''){
        $sql = "SELECT DISTINCT  left(name,1) as letter "
              ."FROM ".$xoopsDB->prefix(_LEX_TBL_TERME)
              ." WHERE idLexique= {$info['idLexique']} "
              ." AND state = 'O'"
              ." ORDER BY letter" ;    
    }else if ($other == _LEXCST_OTHER_NONE){
        $sql = "SELECT DISTINCT  left(name,1) as letter "
              ."FROM ".$xoopsDB->prefix(_LEX_TBL_TERME)
              ." WHERE idLexique= {$info['idLexique']}"
              ." AND instr('{$alphabet}',left(name,1))> 0 "
              . "AND  state = 'O'"
              ."ORDER BY letter" ;
    }else {
         $sql = "SELECT DISTINCT letter "
               ."FROM ".$xoopsDB->prefix(_LEX_TBL_TERME)
               ." WHERE idLexique= {$info['idLexique']}"
               ." AND instr('".$alphabet."',letter)>0 "
               ." AND letter <> '{$other}' AND state = 'O' "
               ." ORDER BY letter" ;
    }
    
    $sqlquery=$xoopsDB->query($sql);
    
    //jjd_echo (  $sql."<br>nb enr = ".$xoopsDB->getRowsNum($sqlquery)." -");

   	while ($sqlfetch=$xoopsDB->fetchArray($sqlquery)) {
    		$ta[] = strtoupper( $sqlfetch['letter']);
    }  
    
    return implode('', $ta);
}
//-----------------------------------------------------------------------
function letterBarBuildString($ta, $tInfoSelecteur, $color = _COLOR_NORMAL){
	Global $xoopsDB, $xoopsModuleConfig, $info;
  
    $other      = $tInfoSelecteur['other'] ;
    $nbrows     = $tInfoSelecteur['rows'] ;
    $limite=0;
    buildDelimitors($tInfoSelecteur, $separateur, $prefixe, $suffixe, $between);    
    //--------------------------------------------
 	  if ( $other <> _LEXCST_OTHER_NONE){
      //if ($nbrows < 0){$p = $between;} else {$p = '';}
   	  //$ta[] = $p."<b><a href='letter.php?letter=".$other."&limite=$limite'>"._MI_LEX_OTHER_LIB."</a></b>";
     }
     
    $nbrows = abs($nbrows);
    if ($nbrows > 1){
      $lg = intval (count($ta) / $nbrows);
      for ($i = 1; $i < $nbrows; $i++){
        $ta[$i * $lg] .= $between;
      }
    }
  
  //********************************************************************
  $letter = "<font color='".$color."'>"."<CENTER>"
            .$prefixe.implode($separateur, $ta).$suffixe
            ."</CENTER>\n"."</font>";
  $letter = str_replace($prefixe.$separateur, $prefixe, $letter);
  $letter = str_replace($separateur.$suffixe, $suffixe, $letter);
  return $letter;
 
}
/******************************************************************************
 *
 *****************************************************************************/
function buildDelimitors($tInfoSelecteur, &$separateur, &$prefixe, &$suffixe, &$between){
  $separateur =  str_replace ("#", " ", $tInfoSelecteur['letterSeparator']);
  
  $td = explode(";", _LEXCST_FRAMEDELIMITOR);
  $delimiteur = str_replace ( '#' , ' ', $td [ $tInfoSelecteur['frameDelimitor'] ]);

    $lg = intval( (strlen($delimiteur)+1) / 2 );
    
    $prefixe = substr($delimiteur, 0, $lg);
    $suffixe = substr($delimiteur, -$lg);
    $between = $suffixe."<br>".$prefixe; 
    //--------------------------------------------

}
/******************************************************************************
 *
 *****************************************************************************/
function FormaterSelection ($ltr, $color = _COLOR_SELECTED, $delimiteurs = _DELIMITEURS){
  if (substr ($color,0,1)<>"#") {$color = "#".$color;}
  
  switch (strlen($delimiteurs)){
  case 0:
    $delimiteurOuvrant = "";
    $delimiteurFermant = "";
    break;
    
  case 1:
    $delimiteurOuvrant = $delimiteurs;
    $delimiteurFermant = $delimiteurs;
    break;
    
  default:
    $delimiteurOuvrant = substr($delimiteurs, 0, 1);
    $delimiteurFermant = substr($delimiteurs, 1, 1);
    break;
  }
  
  
  $ltrlib = "<font color='".$color."'>".$delimiteurOuvrant.$ltr.$delimiteurFermant."</font>" ;
  return $ltrlib;
}
?>
