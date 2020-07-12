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
define ('_LEX_SEP_LINK1',      '<font color="#FF0000" ><b> : </b></font>');
define ('_LEX_SEP_LINK2',      '<font color="#FF0000" ><b> ~ </b></font>');




//---------------------------------------------------------------
include_once (XOOPS_ROOT_PATH."/class/xoopsformloader.php");
//require_once ("constantes.php");

//-----------------------------------------------------------------------------------
global $xoopsModule;
//include_once (XOOPS_ROOT_PATH."/modules/".$xoopsModule->getVar('dirname')."/include/constantes.php");
//include_once (XOOPS_ROOT_PATH."/modules/lexique/include/constantes.php");
include_once (dirname(__FILE__)."/constantes.php");
//-----------------------------------------------------------------------------------
include_once (_LEX_ROOT_JJD."functions.php");
include_once (_LEX_ROOT_JJD."database_functions.php");

include_once (_LEX_ROOT_JJD."strbin_function.php");

//---------------------------------------------------------------/
include_once (XOOPS_ROOT_PATH."/class/xoopsformloader.php");

//---------------------------------------------------------------/



//---------------------------------------------------------------

//require_once ("constantes.php");



//---------------------------------------------------------------/



/*********************************************************************

**********************************************************************/
function displayListeTerme ($sqlSelect = "*", $sqlWhere = "", $sqlOrderby = "", 
                      $limitStart = 0, $limitCount = 0, 
                      $increment = true,
                      &$myts, &$xoopsTpl, $tSeealsoid = false,  
                      $info){

	Global $xoopsModuleConfig, $xoopsDB, $libelle;
  getReadAccess($info['idLexique'], $buttonAccess, $readAccessList, $readPropertyList);  

    $sqlquery = selectTermes($sqlSelect, $sqlWhere,  $sqlOrderby, 
                   $limitStart, $limitCount, $increment);

    //---------------------------------------------------------------------    
    $nbEnr = $xoopsDB->getRowsNum($sqlquery);
    //echo "<hr>displayListeTerme - nb = {$nbEnr}<hr>" ;   
    
    if ($nbEnr > 1){
      $access = $info['access']['alist'];
    }else{
      $access = $info['access']['aform'];    
    }  
    //displayArray2($access,"-----------access--------------");
//    displayArray2($access['def'],"-----------définitions--------------");    
    //---------------------------------------------------------------------
   $xoopsTpl->assign("accessCategory",      $access['category']);    
   $xoopsTpl->assign("detailShowShortDef",  $access['shortdef']);    
   $xoopsTpl->assign("detailShowSeeAlso",   $access['seealso']);   
//   $xoopsTpl->assign("detailShowFollow",    $access['follow']);     
   $xoopsTpl->assign("detailShowDownload",  $access['download']);   

      
   $xoopsTpl->assign("showDefinition1",   $access['def'][1]);
   $xoopsTpl->assign("showDefinition2",   $access['def'][2]);
   $xoopsTpl->assign("showDefinition3",   $access['def'][3]);
   
   
   $xoopsTpl->assign("info", $info);   
   $xoopsTpl->assign("libelle", $libelle);
   
   
   
   //$xoopsTpl->assign('intlinkspopup',   $info['intlinkspopup']);   
    //---------------------------------------------------------------------    
    while ($sqlfetch=$xoopsDB->fetchArray($sqlquery)) {
    
      $id = $sqlfetch["idTerme"];
    	$idLexique = $sqlfetch["idLexique"]; 
      $post = array();
    	$comments = $sqlfetch["comments"];
    	
    	$post['lang_category']= $libelle[_LEX_LANG_FAMILY];       	
    	$post['id']           = $id;
    	$post['idLexique']    = $sqlfetch["idLexique"];    	
    	$post['name']         = $sqlfetch["name"];           //--->jjd-02
    	$post['shortDef']     = $sqlfetch["shortDef"];
    	$post['idSeeAlso']    = $sqlfetch["idSeeAlso"];    	
      //--------------------------------------------------------------
/*
      
		if ($info['intlinkspopup'] == 1) {
        $xoopsTpl->assign('intlinkswidth',   $info['intlinkswidth']);	
        $xoopsTpl->assign('intlinksheight',  $info['intlinksheight']);        
    }     
*/      
      
      
      //--------------------------------------------------------------      
     $xoopsTpl->assign('detailShowButtons',     $info['detailShowButtons']);      
     $xoopsTpl->assign('detailShowId', $info['access']['buttonBin'][_LEX_BYTE_SHOWOPTION]);

      //-------------------------------------------------------------------------
      //-------------------------------------------------------------------------
      for ($h = 1; $h < 4 ; $h++) {
          if ($access['def'][$h] == 1){
              $name = "definition{$h}";
              //$post[$name] = $myts->sanitizeForDisplay($sqlfetch[$name],1,0,0,0,0);
              
            
            //echo "dootions :  dohtml = {$sqlfetch['dohtml']} | dosmiley = {$sqlfetch['dosmiley']} | doxcode = {$sqlfetch['doxcode']} ";
            $i = $h-1;
            $dohtml   = isBitOk($i, $sqlfetch['dohtml']);
            $dosmiley = isBitOk($i, $sqlfetch['dosmiley']);
            $doxcode  = isBitOk($i, $sqlfetch['doxcode']);    
            $doimage  = isBitOk($i, $sqlfetch['doimage']);
            $dobr     = isBitOk($i, $sqlfetch['dobr']);            
            
            //echo "<hr>option editions : {$dohtml}-{$dosmiley}-{$doxcode}-{$doimage}-{$dobr}<hr>";            
            $post[$name] = $myts->previewTarea($sqlfetch[$name], $dohtml, $dosmiley, $doxcode, $doimage, $dobr);
            
//$myts->displayTarea($arr['post_text'],$arr['dohtml'],$arr['dosmiley'],$arr['doxcode'],1,$arr['dobr']);                
            //$post[$name] = $myts->previewTarea($sqlfetch[$name] ,$sqlfetch['dohtml'],$sqlfetch['dosmiley'],$sqlfetch['doxcode']);
            //$post[$name] = $myts->sanitizeForDisplay($sqlfetch[$name],1,0,0,0,0);              
              
              
          }
      }

     //--------------------------------------------------------
     // ajout des proprietes
     //--------------------------------------------------------   

     $xoopsTpl->assign("idProperty",  $info['idProperty']);  
     $xoopsTpl->assign("accessProperty",  $access['property']);          
     if ($info['idProperty'] <> 0){
           
         $pr = getPropertyList($info['idProperty'] ,$id , $propertyName, $info['detailShowProperty']);
         $post ['property'] =  $propertyName;         
        
          $ppt = array();         
         
         reset($pr);
         $sep = '';
          //----------------------------------------------------------------------
          while (list($key, $val) = each($pr)) {
              if ( isByteOk ($val['byteAccess'], $access['readProperty']) == 0) continue;
              $bold=false;
              switch ($val['dataType']){
              
                case 1:
                  $v = "<b>{$val['value']}</b>";
                  $bold=true;
                  break;
              
                case 2:
                  $v = "<a href='mailto:{$val['value']}'>{$val['value']}</a>";
                  break;
                
              
                case 3:
                  $v = "<a href='{$val['value']}' target=blanck>{$val['value']}</a>";
                  break;
                  
                default:
                  $v = $val['value'];                  
                  break;  
                                
              }

              //-------------------------------------------------------
              $b1 = ($bold)?'<b>':'';
              $b2 = ($bold)?'</b>':'';           
              
              $ppt[] = array('name'       => $b1.$val['name'].' : '.$b2, 
                             'value'      => "{$b1}{$v}{$b2}",
                             'rowBefore'  => $val['rowBefore']);

             
          }
         
         $post['ppt'] = $ppt;           
    }
           
      //-------------------------------------------------------------------------
      // a revoir ???
      $saMode = showSeeAlsoMode($sqlfetch["reference"], $info['detailShowSeeAlso']);
    	$post['detailShowSeeAlso'] = $saMode;     
      //ajouter une condition si c'est visible
      if ($access['seealso'] == 1){
        $post['seealso'] = parserSeeAlso($sqlfetch['idSeeAlso'], $myts->sanitizeForDisplay($sqlfetch["seeAlsoList"]), $saMode, $info);      
      }
      
      
    /***************************************************************************
     * selection des terme correspondant a la page et a la letre selectionee
     * et affichage en cochant la case si dans la liste de seeAlsoList 
     ***************************************************************************/
      if (is_array($tSeealsoid)) {
        	//$idsa = $sqlfetch["id"];
        	$idsa = $sqlfetch["idSeeAlso"];        	
          $key = array_search($idsa, $tSeealsoid); 
        
        	$post['checked']   = ($key===false)?"":"checked";
      
      }
      
      //-------------------------------------------------------------------------
      //boutons
      //-------------------------------------------------------------------------      

          	  
    	//$lButton = $info['access']['button']        ;
    	$lButton = $access['readButtons'];   
      //$lButton = 0;
       	
    	//f (!isBitOk(_LEX_BYTE_VISIBLE, $lButton)) $lButton = $lButton &  ~_LEXBTN_MENU0 ;          	
    	
      if ($comments != 0) {$lButton = $lButton | _LEXBTN_COMMENT1 ;} else {$lButton = $lButton | _LEXBTN_COMMENT2 ;}
      //$post['admin'] = getButtonBar ($lButton & _LEXBTN_TLB_MASKED, $post['id'], $info['idLexique'], $sqlfetch);
      
      $post['admin'] = getButtonBar ($lButton, $post['id'], $info['idLexique'], $sqlfetch);      
      $post['follow'] = getFollow ($lButton, $post['id'], $info['idLexique'], $sqlfetch);      
      //-------------------------------------------------------------------------
      //categories
      //-------------------------------------------------------------------------      
      if ($info['idFamily'] <> 0  AND $access['category'] == 1){      
        $listIndexCategory = binStr2Index ( $myts->sanitizeForDisplay($sqlfetch["category"]), 1);
        $post['categoryBinStr'] = _MD_LEX_CATEGORYS." = ".$listIndexCategory;
      }
      $post['categories'] = $sqlfetch["tempCategory"];  
      
      
      
      //-------------------------------------------------------------------------
      if ($info['access']['buttonBin'][_LEX_BYTE_SHOWVISIT] == 1 and $info['detailGererVisit'] == 1) {
          //$xoopsTpl->assign('detailShowVisit', 1);  
          $xoopsTpl->assign('detailShowVisit', $info['access']['buttonBin'][_LEX_BYTE_SHOWVISIT]);  
        	$post['visit'] = "("._MI_LEX_SHOW_VISIT_VU." ".$sqlfetch["visit"]." "._MI_LEX_SHOW_VISIT_FOIS.")";    
      }

     //--------------------------------------------------------
     // ajout des fihciers attachés
     //--------------------------------------------------------   
    $post['files']   = lexGetFiles($idLexique, $id, _LEX_PREFIX_UPLOAD, true);    
    $post['nbFiles'] = count($post['files']);
    $post['folderFiles'] = lexGetFolder($idLexique, $id, true);
    //displayArray($post['files'],"--------------------------------");

      //------------------------------------------------------------------
      $xoopsTpl->append('dic_post', $post);
    }
}

/*****************************************************************
 *
 *****************************************************************/
function lexGetFiles($idLexique, $idTerme, $prefixe, $bShortName = false){
    
    $folder = lexGetFolder($idLexique, $idTerme).$prefixe.$idTerme.'*.*';
    //**********************************************************************************    
    //echo "<hr>{$folder}<hr>";
    $t = array();
    $files = glob($folder);
    if ($files === false) return $t;
    //---------------------------------------------
    foreach (glob($folder) as $filename) {
      if ($bShortName){
        $t[] = basename($filename);      
      }else{
        $t[] = $filename;      
      }
        
      //$h++;          
    }
    //displayArray($t, "------------lexGetFiles--------------------");
  return $t;

}
/*****************************************************************
 *
 *****************************************************************/
function lexGetFolder($idLexique, $idTerme, $bUrl=false){
  
  if ($bUrl){
    $path = _LEX_URL_UPLOAD . "lex_{$idLexique}/";  
  }else{
    $path = _LEX_ROOT_UPLOAD;
    $b = isFolder($path, true);  
    $path = _LEX_ROOT_UPLOAD . "lex_{$idLexique}/";  
    $b = isFolder($path, true);    
  }


  //echo "{$idLexique}-{$idTerme}-{$path}";
  

 // $path = _LEX_ROOT_UPLOAD & "{$idLexique}_$idTerme{}/";  
  return $path;
}

/************************************************************
 *
*************************************************************/

function getLibCategories($idFamily, $binCategory, $sep = ' - '){
global $xoopsDB;
    
    $lstIdCategory = binStr2Index ($binCategory , 0, true, ',', '1','0','','');	 

  if ($lstIdCategory == ''){
      $list = '';  
  }else{
       $sql = "SELECT name FROM ".$xoopsDB->prefix(_LEX_TBL_CATEGORY)
             ." WHERE idFamily = {$idFamily} "
             ." AND idCategory in ({$lstIdCategory})"
             ." AND state = 1 and name <>'' "
             ." ORDER BY showOrder, name";
    
    
        $sqlquery = $xoopsDB->query($sql);
    
        $t = array();
        while ($sqlfetch = $xoopsDB->fetchArray($sqlquery)) {
            $t[] = $sqlfetch['name'];
        }
    
      $list = implode ($sep, $t);
  
  }  
  return $list;

}

/************************************************************
 *
*************************************************************/

function clearIntrusion(){
Global $xoopsDB;
	 
	 $sql = "DELETE FROM ".$xoopsDB->prefix(_LEX_TBL_TERME)." "
   ."WHERE letter = '#' OR Name='' or Name is null";
   
   $xoopsDB->query($sql);

}


/************************************************************************
 *
 ************************************************************************/
function getInfoSelecteur ($idLexique){
	Global $xoopsModuleConfig, $xoopsDB;
	
  buildColSql ('selecteur', 'idSelecteur,name,alphabet,other,showAllLetters,frameDelimitor,letterSeparator,rows', $tCols, $sCols);  
  echo "$sCol<br>";  
  
    $sql = "SELECT {$sCols} "
          ." FROM ".$xoopsDB->prefix(_LEX_TBL_SELECTEUR)." as SELECTEUR,".$xoopsDB->prefix(_LEX_TBL_LEXIQUE)." as LEXIQUE "
          ." WHERE SELECTEUR.idSelecteur =  LEXIQUE.idSelecteur "
          ."   AND LEXIQUE.idLexique = {$idLexique}";    

    $sqlquery = $xoopsDB->query($sql);
	  $selecteur  = $xoopsDB->fetchRow($sqlquery);
	
   return arrayCombine ($tCols, $selecteur);   
}
/************************************************************************
 *
 ************************************************************************/
function buildColSql ($sTable, $sCol, &$tCols, &$sNewCol){
  
  $tCols   = explode (',', $sCol);
  $sNewCol = "{$sTable}.".implode (",{$sTable}.", $tCols);
  return $sNewCol;
  
}

/************************************************************************
 *
 ************************************************************************/
function getInfoCategory ($idLexique){
	Global $xoopsModuleConfig, $xoopsDB;

  buildColSql ('family', 'idFamily,name as family,maxCount', $tColFamily, $sColsFamily);
  buildColSql ('category', 'idCategory,name as categoty,state,showOrder', $tColCategory, $sColsCategory);
  
  
  $tColFamily[1]   = 'family';
  $tColCategory[1] = 'category';
  $tCols = array_merge ($tColFamily, $tColCategory);  
  
    $sql = "SELECT {$sColsFamily},{$sColsCategory} "
          ." FROM ".$xoopsDB->prefix(_LEX_TBL_FAMILY)."   as family,"
                   .$xoopsDB->prefix(_LEX_TBL_CATEGORY)." as category, "
                   .$xoopsDB->prefix(_LEX_TBL_LEXIQUE)."  as lexique "
          ." WHERE family.idFamily    =  lexique.idFamily "
          ."   AND family.idFamily    =  category.idFamily "          
          ."   AND lexique.idLexique  = {$idLexique} "
          ." ORDER BY idCategory";    


    $sqlquery = $xoopsDB->query($sql);

    $categories = array();
    while ($sqlfetch = $xoopsDB->fetchArray($sqlquery)) {
        $t = arrayCombine ($tCols, $sqlfetch);        
        $categories[] = $t;
    }

    return $categories;
   
}

/************************************************************************
 *
 ************************************************************************/
function getInfoLexique ($idLexique){
	Global $xoopsModuleConfig, $xoopsDB;

  buildColSql ('lexique', 'idLexique,idFamily,idSelecteur,name as lexique,'
                         .'introtext,nbmsgbypage,showmode,actif,ordre,noteMin,noteMax,noteImg', 
                          $tColsLexique, $sColsLexique);
  
  buildColSql ('selecteur', 'name as selecteur,alphabet,other,showAllLetters,frameDelimitor,letterSeparator,rows', $tColsSelecteur, $sColsSelecteur);  
  
  $tColFamily[3]   = 'lexique';
  $tColsSelecteur[0] = 'selecteur';
  $tCols = array_merge ($tColsLexique, $tColsSelecteur);  
  //  if ($idLexique == '' ){$idLexique=9992;}
  

  
    $sColsLexique = 'lexique.*';
    $sql = "SELECT {$sColsLexique},{$sColsSelecteur} "
          ." FROM ".$xoopsDB->prefix(_LEX_TBL_LEXIQUE)."   as lexique,"
                   .$xoopsDB->prefix(_LEX_TBL_SELECTEUR)." as selecteur "
          ." WHERE lexique.idSelecteur    =  selecteur.idSelecteur "
          ."   AND lexique.idLexique  = {$idLexique} ";
    

    $sqlquery = $xoopsDB->query($sql);

    $t = array();
    $sqlfetch = $xoopsDB->fetchArray($sqlquery);  
         
    $t = arrayCombine ($tCols, $sqlfetch);


$myts =& MyTextSanitizer::getInstance();
$t ['introtext'] = $myts->makeTareaData4Show($t['introtext'], 1, 1, 1);   
    
    return $sqlfetch;   
}
/*****************************************************************************
 *
 ****************************************************************************/
function getLexInfo (&$idLexique, &$tLexInfo, $echoList = ''){
	Global $xoopsModuleConfig, $xoopsDB, $info;
  $bShow = false;
  
  if (!isset($idLexique)){$idLexique = getFirstIdLexique();}
  if ($idLexique == 0){$idLexique = getFirstIdLexique();}
  if ($idLexique == $info['idLexique'] ){return $info;}
  
  //if ($idLexique == '' ){$idLexique=999;}
  
  //buildColSql ('selecteur', 'name as selecteur,alphabet,other,showAllLetters,frameDelimitor,letterSeparator,rows', $tColsSelecteur, $sColsSelecteur);  
  buildColSql ('selecteur', 'name as selecteur,alphabet,other,showAllLetters,'
                            .'frameDelimitor,letterSeparator,rows', 
                            $tColsSelecteur, $sColsSelecteur);  
  
                            //.'dooptions,dohtml,dosmiley,doxcode,dobr', 
  
  $tColFamily[3]   = 'lexique';
  $tColsSelecteur[0] = 'selecteur';
  //$tCols = array_merge ($tColsLexique, $tColsSelecteur);  
  
  
    
    $sColsLexique = 'lexique.*';
    
    $sql = "SELECT {$sColsLexique},{$sColsSelecteur} "
          ." FROM ".$xoopsDB->prefix(_LEX_TBL_LEXIQUE)."   as lexique,"
                   .$xoopsDB->prefix(_LEX_TBL_SELECTEUR)." as selecteur "
          ." WHERE lexique.idSelecteur    =  selecteur.idSelecteur "
          ."   AND lexique.idLexique  = {$idLexique} ";
    

//echo "<hr>$sql<hr>";
    $sqlquery = $xoopsDB->query($sql);
    $sqlfetch = $xoopsDB->fetchArray($sqlquery);  

	 $tLexInfo = $sqlfetch;

$myts =& MyTextSanitizer::getInstance();
$tLexInfo ['introtext'] = $myts->makeTareaData4Show($tLexInfo['introtext'], 1, 1, 1);   
$tLexInfo ['lexIcone'] = getLexIcone($tLexInfo['icone']);


//jjd-01
  //--------------------------------------------------------------  
  getReadAccess($idLexique, $buttonAccess, $readAccessList, $readPropertyList);
  $ta = getAReadAccess($idLexique);
  //displayArray($ta,"---------getLexInfo------------------");
  $defAccess = array(_LEX_BYTE_DEFINITION1,_LEX_BYTE_DEFINITION2,_LEX_BYTE_DEFINITION3);
  //--------------------------------------------------------------
  //--------------------------------------------------------------  
  
  $tList = array();
  $tForm = array();  
  
  for ($h = 1; $h < 4 ; $h++) {
      if ((($info['detailShowDefinition'] & pow(2,$h-1)) <> 0)){
        $tList[$h] = isBitOk($defAccess[$h-1], $ta['readAccessList']);    
        $tForm[$h] = isBitOk($defAccess[$h-1], $ta['readAccessForm']);          
      
      }else{
        $tList[$h] = 0;    
        $tForm[$h] = 0;          
      }  
  }
  
  $tLexInfo['access'] = array('alist' => array(), 'aform' => array());
  
  
  $tLexInfo['access']['lexique']  = isBitOk(_LEXBTN_VISIBLE_IN_GROUP, $ta['buttonAccess']);  
  $tLexInfo['access']['buttonAccess']   = $ta['buttonAccess'];  
  $tLexInfo['access']['buttons']        = $ta['readButtonsTlb'];  
  //--------------------------------------------------------------  
  /*

  $tLexInfo['access']['readButtonsTlb']  = $ta['readButtonsTlb'];  
  $tLexInfo['access']['readButtonsList'] = $ta['readButtonsList'];  
  $tLexInfo['access']['readButtonsForm'] = $ta['readButtonsForm'];  
  */  
  //--------------------------------------------------------------  
  //permet d'accer directement au value boolean
  //--------------------------------------------------------------
  $lstShowOption = array();
  for ($h = 0; $h < 20 ; $h++) {
    $lstShowOption[$h] = isByteOk($h, $ta['buttonAccess']);
  }
  $tLexInfo['access']['buttonBin'] = $lstShowOption;
  //--------------------------------------------------------------  
  //echo "<hr>zzzz->"._LEX_BYTE_FILES."-{$ta['readAccessList']}<hr>" ;
   
  $tLexInfo['access']['alist']['buttons']  = $ta['readButtonsList'];  
  $tLexInfo['access']['alist']['def']      = $tList;
  $tLexInfo['access']['alist']['category'] = isBitOk(_LEX_BYTE_CATEGORYS, $ta['readAccessList']) & $info['showcategory'];
  $tLexInfo['access']['alist']['shortdef'] = isBitOk(_LEX_BYTE_SHORTDEF,  $ta['readAccessList']) & $info['detailShowShortDef'];  
  $tLexInfo['access']['alist']['seealso']  = isBitOk(_LEX_BYTE_SEEALSO,   $ta['readAccessList']) & (($info['detailShowSeeAlso'])<>0)?1:0;
  //$tLexInfo['access']['alist']['follow']  = isBitOk(_LEX_BYTE_FOLLOW,     $ta['readAccessList']);
  $tLexInfo['access']['alist']['download']  = isBitOk(_LEX_BYTE_DOWNLOAD, $ta['readAccessList']);
        
  $tLexInfo['access']['alist']['property']     = ($ta['readPropertyList'] == 0)?0:1;
  $tLexInfo['access']['alist']['readProperty'] = $ta['readPropertyList'];  
  $tLexInfo['access']['alist']['readButtons']   = $ta['readButtonsList'];  
  //-------------------------------------------------------------------------
  $tLexInfo['access']['aform']['buttons']  = $ta['readButtonsForm'];  
  $tLexInfo['access']['aform']['def']      = $tForm;
  $tLexInfo['access']['aform']['category'] = isBitOk(_LEX_BYTE_CATEGORYS, $ta['readAccessForm']) & $info['showcategory'];  
  $tLexInfo['access']['aform']['shortdef'] = isBitOk(_LEX_BYTE_SHORTDEF,  $ta['readAccessForm'])  & $info['detailShowShortDef'];  
  $tLexInfo['access']['aform']['seealso']  = isBitOk(_LEX_BYTE_SEEALSO,   $ta['readAccessForm'])   & (($info['detailShowSeeAlso'])<>0)?1:0;
  //$tLexInfo['access']['aform']['follow']  = isBitOk(_LEX_BYTE_FOLLOW,     $ta['readAccessForm']);  
  $tLexInfo['access']['aform']['download'] = isBitOk(_LEX_BYTE_DOWNLOAD,  $ta['readAccessForm']);    
  
  $tLexInfo['access']['aform']['property']     = ($ta['readPropertyForm'] == 0)?0:1;  
  $tLexInfo['access']['aform']['readProperty'] = $ta['readPropertyForm'];  
  $tLexInfo['access']['aform']['readButtons']   = $ta['readButtonsForm'];  

//  $info = &$tLexInfo;
  

  //--------------------------------------------------------------

    
 //$bShow=true;
	 if ($echoList<> '' AND $bShow){
      //echo "$sql<br>";	 
      //displayArray($tLexInfo,'lexInfo: liste des valeurs appell‚ de : '.$echoList);
   }
	     
   return $tLexInfo;   
}


/************************************************************
 *
*************************************************************/
function getFirstIdLexique () {
Global $xoopsDB, $xoopsModuleConfig;
	 
Global $xoopsDB, $xoopsModuleConfig;
	
  $sql = "SELECT idLexique FROM ".$xoopsDB->prefix(_LEX_TBL_LEXIQUE)." "
        ."ORDER BY ordre LIMIT 0,1" ;	
  
	$result = $xoopsDB->query($sql);
	list ($idLexique) = $xoopsDB->fetchRow($result);
  return $idLexique;
  
}
/************************************************************
 *
*************************************************************/
function getLexiqueFromTerme ($idTerme) {
Global $xoopsDB, $xoopsModuleConfig;
	 
Global $xoopsDB, $xoopsModuleConfig;
	
  $sql = "SELECT idLexique FROM ".$xoopsDB->prefix(_LEX_TBL_TERME)." "
        ."WHERE idTerme = ".$idTerme." " ;	
  
	$result = $xoopsDB->query($sql);
	list ($idLexique) = $xoopsDB->fetchRow($result);
  return $idLexique;
  
}

/************************************************************
 *
*************************************************************/
function getNewIdTerme ($idLexique) {
  return getNewId ($idLexique, _LEX_TBL_TERME, 'idLexique', 'idTerme');
}

  

/***************************************************************************
 *                gestion des libelle (Caption)
 ***************************************************************************/
/************************************************************
 * si default = true, renvoie la valeur des constante definir dans les fichier langue
 * si default = falst renvoi une chaine vide si la constante est trouvees
 * cette derniere option est utilisee dans admin_libelle pour remplir les zones 
 * avec des chaine vide plutot quavec le nom de constantes que l'tilisateur ne connait pas.
 * par contre si les valeur sont trouvz pour le lexique et la langue elle sont r‚vup‚ree dans tous les cas   
*************************************************************/
function getCaption (&$idCaption, &$lexLib, $default = true, $forcer = false) {
Global $xoopsDB, $xoopsModuleConfig,$xoopsConfig, $info, $libelle;

  if (isset($lexLib)){
    if (isset($lexLib['idCaption'])) {
      if ($lexLib['idCaption'] == $idCaption){return;}
    }
  };
	// if (isset($info['idLexique'])){$idLexique = $info['idLexique'];} else {$idLexique = 0;}
	// $idLexique = 3;
   //---------------------------------------------------------
	$lang = 'default';
  $sql = "SELECT * FROM ".$xoopsDB->prefix(_LEX_TBL_CAPTIONSET)
        ." WHERE idCaption = 0 AND state = 1 ORDER BY code";	
  
	$sqlquery = $xoopsDB->query($sql);
	$def = array();
	        
   while ($sqlfetch=$xoopsDB->fetchArray($sqlquery)) {
      //$def [$sqlfetch['code']] = "LEX_MI_{$sqlfetch['text']}";
      $def [$sqlfetch['code']] = ($default)?$sqlfetch['newText']:'';                               
   }
   //echo $sql.'<br>';
   //displayArray($def, 'Definition par default');
   //---------------------------------------------------------  

  $sql = "SELECT * FROM ".$xoopsDB->prefix(_LEX_TBL_CAPTIONSET)
        ." WHERE idCaption = {$idCaption}"
        ." AND newText <> ''"
        ." ORDER BY code";	
  
	$sqlquery = $xoopsDB->query($sql);
	$lib = array();
	        
   while ($sqlfetch=$xoopsDB->fetchArray($sqlquery)) {
      $lib [$sqlfetch['code']] = $sqlfetch['newText'];
                               
   }
   //echo $sql.'<br>';   
   //displayArray($lib, 'Definition du lexique '.$idLexique);    
   //---------------------------------------------------------
   if (is_array($lib)){
     $r = array_merge ($def, $lib);   
   }else{
     $r = $def;   
   }
   
  $prefixe = array ('_MI_LEX_', '_MD_LEX_', '_AD_LEX_');
  $tKeys = array_keys($r);

   for ($h = 0; $h < count($tKeys); $h++){
      $k = $tKeys[$h];
      //echo "key ==> {$k} - {$r[$k]}<br>";
      
      for ($i = 0; $i < count($prefixe); $i++){
        $v = $prefixe[$i].$r[$k];        
        if (defined($v)) {
             $r[$k] = constant($v);
             break;
        }        
      }
      
    }
      
   $r['idCaption'] = $idCaption ;  

  //displayArray($r,'***************************');
  //jjd_err_02
  if (!isset($info['idFamily'])) $info['idFamily']=0;
  if ($info['idFamily'] <> 0){
      $sql = "SELECT * FROM ".$xoopsDB->prefix(_LEX_TBL_FAMILY)
            ." WHERE idFamily = {$info['idFamily']}";
     
    	$sqlquery = $xoopsDB->query($sql);
    	$sqlfetch=$xoopsDB->fetchArray($sqlquery);
       $r['family'] = $sqlfetch['name'] ;   
  
  } else{
       $r['family'] = '' ;  
  }


   $r['copyright'] = getCopyright();
   //--------------------------------------------------------
   $lexLib = $r;   
   return $r ; 
}



/************************************************************
 *
*************************************************************/
function getCaptionDefault (&$idCaption) {
Global $xoopsDB, $xoopsModuleConfig,$xoopsConfig, $info,$libelle;

	 
   //---------------------------------------------------------
	$lang = 'default';
  $sql = "SELECT * FROM ".$xoopsDB->prefix(_LEX_TBL_CAPTIONSET)
        ." WHERE idCaption = 0 AND state = 1 ORDER BY code";	
  
	$sqlquery = $xoopsDB->query($sql);
	$def = array();
	        
   while ($sqlfetch=$xoopsDB->fetchArray($sqlquery)) {
      $def [$sqlfetch['code']] = $sqlfetch['newText'];                               
   }
   //---------------------------------------------------------  
   $r = $def;   

   
  $prefixe = array ('_MI_LEX_', '_MD_LEX_', '_AD_LEX_');
  $tKeys = array_keys($r);

   for ($h = 0; $h < count($tKeys); $h++){
      $k = $tKeys[$h];
      //echo "key ==> {$k} - {$r[$k]}<br>";
      
      for ($i = 0; $i < count($prefixe); $i++){
        $v = $prefixe[$i].$r[$k];        
        if (defined($v)) {
             $r[$k] = constant($v);
             break;
        }        
      }
  }
  
   $r['copyright'] = getCopyright();  
   return $r ; 
}


/********************************************************************
 *
 ********************************************************************/

function setCaption (&$idCaption, $lexLib, $name) {
Global $xoopsDB, $xoopsModuleConfig,$xoopsConfig, $info,$libelle;


   //---------------------------------------------------------
   
    if ($idCaption == 0){
      $sql = "SELECT max(idCaption) as id FROM ".$xoopsDB->prefix(_LEX_TBL_CAPTION);
    	$sqlquery = $xoopsDB->query($sql);
     	list( $idCaption ) = $xoopsDB->fetchRow( $sqlquery ) ;
      $idCaption++;
    
      $sql = "INSERT INTO ".$xoopsDB->prefix(_LEX_TBL_CAPTION)
            ." (idCaption,name) VALUES ({$idCaption},'{$name}')";	
      $xoopsDB->query($sql);   
     	
    }else{
      $sql = "UPDATE ".$xoopsDB->prefix(_LEX_TBL_CAPTION)
            ." SET name = '{$name}' WHERE idCaption = {$idCaption}";	
      $xoopsDB->query($sql);   
   
    }
    
   //---------------------------------------------------------
  
  $sql = "DELETE FROM ".$xoopsDB->prefix(_LEX_TBL_CAPTIONSET)
        ." WHERE idCaption = {$idCaption}";	
  $xoopsDB->query($sql);
  
   //---------------------------------------------------------
   $t = array();
   $keys = array_keys($lexLib);
   for ($h = 0; $h < count($keys); $h++){
    $k = $keys [$h];

	

    $t[] = "({$idCaption},'{$k}',\"{$lexLib[$k]}\")";
    
   }  
	 $i = implode(', ', $t);
  

  $sql = "INSERT INTO ".$xoopsDB->prefix(_LEX_TBL_CAPTIONSET)
        ." (idCaption, code, newText) "
        ." VALUES {$i}";	
  $xoopsDB->query($sql);  
  
//  displaySql ($sql);
  
}


/********************************************************************
 * fonction liées aux property
 ********************************************************************/
function propertyClean(){
Global $xoopsDB, $xoopsModuleConfig,$xoopsConfig;  

  $sql = "DELETE FROM ".$xoopsDB->prefix(_LEX_TBL_PROPERTYSET)
       ." WHERE name = '' or name is null OR state = 0;";
  $xoopsDB->query($sql);       
}

/********************************************************************
 * fonction liées aux property
 ********************************************************************/
function getPropertyList($idProperty ,$idTerme , &$propertyName , $showAll = 0){
Global $xoopsDB, $xoopsModuleConfig,$xoopsConfig;  

  $sql = "SELECT name FROM ".$xoopsDB->prefix(_LEX_TBL_PROPERTY)
       ." WHERE idProperty = {$idProperty} ";
  $sqlquery = $xoopsDB->query($sql);
  list( $propertyName ) = $xoopsDB->fetchRow( $sqlquery ) ;      
  //---------------------------------------------------------------------

  $sql = "SELECT * FROM ".$xoopsDB->prefix(_LEX_TBL_PROPERTYSET)
       ." WHERE idProperty = {$idProperty} AND state = 1"
       ." ORDER BY showOrder, name";
  $sqlquery = $xoopsDB->query($sql);
	$p = array();
	 
   $hr = 0;       
   while ($sqlfetch = $xoopsDB->fetchArray($sqlquery)) {
      $k = 'k'.$sqlfetch['idPropertySet'];
      $p[$k] = array ('name'          => $sqlfetch['name'],
                      'idProperty'    => $sqlfetch['idProperty'],
                      'idPropertySet' => $sqlfetch['idPropertySet'],                                     
                      'value'         => ' ', 
                      'dataType'      => $sqlfetch['dataType'],
                      'idList'        => $sqlfetch['idList'],
                      'rowBefore'     => ((($sqlfetch['rowSeparator'] & 1) <> 0 ) OR ($hr == 1))?1:0,
                      'rowAfter'      => (($sqlfetch['rowSeparator']  & 2) <> 0 )?1:0,
                      'byteAccess'    => $sqlfetch['byteAccess'],
                      'list'          => geListForProperty($sqlfetch['idList'], "property_{$sqlfetch['idPropertySet']}", 0));
         
    $hr =  $p[$k]['rowAfter']; 
   }

   //--------------------------------------------------------   
  $sql = "SELECT pVal.value, pSet.name, pSet.idPropertySet as idPropertySet FROM "
         .$xoopsDB->prefix(_LEX_TBL_PROPERTYVAL)." as pVal,"
         .$xoopsDB->prefix(_LEX_TBL_PROPERTYSET)." as pSet "  
        ." WHERE pVal.idPropertySet = pSet.idPropertySet "
        ."   AND pVal.idTerme = {$idTerme} ";       
  $sqlquery = $xoopsDB->query($sql);
  
   while ($sqlfetch = $xoopsDB->fetchArray($sqlquery)) {
    
      $k = 'k'.$sqlfetch['idPropertySet'];
      
      if (isset($p[$k])) {
          $p[$k]['value'] =  $sqlfetch['value']; 
          //echo "<hr>".$p[$k]['name']." = {$p[$k]['value']}<br>";
          if ($p[$k]['idList'] > 0 ) {
            $name = "property_{$sqlfetch['idPropertySet']}";
            $p[$k]['list'] = geListForProperty($p[$k]['idList'], $name, $sqlfetch['value']);
          }else{
            $p[$k]['list'] = $sqlfetch['value'];
          }         
      } 
   }
   
   //si $showAll=1 supression des cles dont la valeur est une chaine nulle
   //$showAll = 1: on n'affiche que les items non vides
   //suppression des items vide et report des ligne avant sur l'item suivant quand c'est vide

   if ($showAll == 1 ){
      $hr = 0;   
      reset ($p);
      while (list ($key, $val) = each ($p)) {
        if (trim($val['value']) == ''){ 
          $hr = (($hr == 1) OR ($val['rowBefore'] == 1))?1:0;
          unset ($p[$key]);
          //echo "r->key = {$key} : name = {$val['name']} : hr = {$hr}<br>";
          //$p[$key]['value'] = "???";
        }else{
          if ($hr == 1 OR $val['rowBefore'] == 1){
            $p[$key]['rowBefore'] = 1;
            $hr = 0;
          }
        }
                 
      }
   }   
   
  return $p;


}
/********************************************************************
 * fonction liées aux property
 ********************************************************************/
function setPropertyList($p, $idProperty ,$idTerme ){
Global $xoopsDB, $xoopsModuleConfig,$xoopsConfig;  

  $sql = "DELETE FROM ".$xoopsDB->prefix(_LEX_TBL_PROPERTYVAL)
        ." WHERE idTerme = {$idTerme}";	
  $xoopsDB->query($sql);  
  
  //displayArray($p,'--------setPropertyList------------');
  $t = array ();
  while ((list($k, $v) = each($p))){
      $v=trim($v);
      $sql = "INSERT INTO ".$xoopsDB->prefix(_LEX_TBL_PROPERTYVAL)
            ." (idTerme, idPropertySet, value) "
            ." VALUES ({$idTerme},{$k},'{$v}')";
      $xoopsDB->query($sql);            
  }

}



/********************************************************************
 * fonction liées aux property
 ********************************************************************/
function geListForProperty($idList, $name, $default){
Global $xoopsDB, $xoopsModuleConfig,$xoopsConfig;  

  $sql = "SELECT items FROM ".$xoopsDB->prefix(_LEX_TBL_LIST)
       ." WHERE idList = {$idList} ";
  //echo "<hr>geListForProperty<br>{$sql}<hr>";
  $sqlquery = $xoopsDB->query($sql);
  list( $listItem ) = $xoopsDB->fetchRow( $sqlquery ) ;   
  $listItem = str_replace (chr(13).chr(10),";", $listItem);
  $listItem = str_replace ('<br />',";", $listItem);  
  $listItem = str_replace ('<br>',";", $listItem);  
  
  //echo "<hr>liste : {$listItem}<hr>";   
  //---------------------------------------------------------------------
  //$list = buildList(_AD_LEX_ACTIF, _AD_LEX_LEXIQUE_ACTIF_DSC, 
  //                 'txtActif', $listYesNo, $p['actif'], $ligneDeSeparation);

  //$selected = getlistSearch ($name, $list, 0, $default, 12);   
  $selected = buildHtmlListString ($name, $listItem, $default);  
  return $selected;


}

/********************************************************************
 * f
 ********************************************************************/
function buildListSearch($name = '', $default = ''){
global $libelle;

  $list = array( $libelle [_LEX_LANG_TERME2], 
                 $libelle [_LEX_LANG_SHORTDEF2], 
                 $libelle [_LEX_LANG_DEFINITION1], 
                 $libelle [_LEX_LANG_SEEALSO2], 
                 _MI_LEX_EVERYWHERE);


  $selected = getlistSearch ($name, $list, 0, $default);
  return $selected;
  
}

/********************************************************************
 * reconstruit le champ tempCategory de lexTerme
 ********************************************************************/
function rebuild_tempCategory ($idLexique = 0){
global $xoopsDB;
  
  $clauseWhere = ($idLexique > 0)?" WHERE idLexique = {$idLexique}":'';
  $sql = "SELECT idLexique, idFamily FROM "
         .$xoopsDB->prefix(_LEX_TBL_LEXIQUE)
         .$clauseWhere;
  $queryLex = $xoopsDB->query($sql);
  
   while ($fetchLex = $xoopsDB->fetchArray($queryLex)) {
      $idLexique = $fetchLex ['idLexique'];
      $idFamily  = $fetchLex ['idFamily'];
      
      $sql = "SELECT idTerme, category FROM "
             .$xoopsDB->prefix(_LEX_TBL_TERME)
             ." WHERE idLexique = {$idLexique}";
      $queryTerme = $xoopsDB->query($sql);   
      
      while ($fetchTerme = $xoopsDB->fetchArray($queryTerme)) {   
          $idTerme  = $fetchTerme['idTerme']; 
          $category = $fetchTerme['category'];
          $tempCategory = $tempCategory = getLibCategories($idFamily, $category);
          
          $sql = "UPDATE ".$xoopsDB->prefix(_LEX_TBL_TERME)
                ." SET tempCategory = '{$tempCategory}' "
                ." WHERE idTerme = {$idTerme}";
          $xoopsDB->queryF($sql);         
      }
   
   }


}


/****************************************************************************
 * retourne unbleau de valeur binares qi definissent les permissions
 * qui representent les autorisations d'acces de l'utilisateur
 * pour tous les groupes auquel il appartient 
 * pas concondre avec la fonction getAAReadAccess qui rnvoi un tableu par groupe
 * utilisé dans l'affetaiotn des permissions dans l'admin  
 ****************************************************************************/
 function getAReadAccess($idLexique, $test=''){
	global $xoopsModuleConfig, $xoopsDB;
	
    $groupe = getListGroupesID(_LEX_DIR_NAME);
    $sql = "SELECT * FROM ".$xoopsDB->prefix(_LEX_TBL_ACCESS)
          ." WHERE idLexique = {$idLexique}"
          ."   AND idGroup in ({$groupe}) "
          ." ORDER BY idGroup";
    $sqlquery = $xoopsDB->queryF($sql);  

    
    

    $isDefine          = 0;
    $buttonAccess      = 0; 
    $readButtonsTlb    = 0; 
 
    $readButtonsList   = 0; 
    $readAccessList    = 0;
    $readPropertyList  = 0;
 
    $readButtonsForm   = 0;
    $readAccessForm    = 0;
    $readPropertyForm  = 0;

    

    //$showOption  = 0;               
    //-------------------------------------------------------
    while ($sqlfetch = $xoopsDB->fetchArray($sqlquery)) {
      $isDefine        = $isDefine        | $sqlfetch ['isDefine'];
      $buttonAccess    = $buttonAccess    | $sqlfetch ['buttonAccess'];      
      $readButtonsTlb  = $readButtonsTlb  | $sqlfetch ['readButtonsTlb'];
            
      $readButtonsList  = $readButtonsList  | $sqlfetch ['readButtonsList'];      
      $readAccessList   = $readAccessList   | $sqlfetch ['readAccessList'];
      $readPropertyList = $readPropertyList | $sqlfetch ['readPropertyList'];
      
      $readButtonsForm  = $readButtonsForm  | $sqlfetch ['readButtonsForm'];      
      $readAccessForm   = $readAccessForm   | $sqlfetch ['readAccessForm'];
      $readPropertyForm = $readPropertyForm | $sqlfetch ['readPropertyForm'];
        
    }
    
    //si aucune autorisation on donne toutes les autorisation 
    //foncionnement par defaut adopt‚ car sera souvent le cas
    //ou aucune autorisation ne sera defini
    if ($isDefine == 0) {
      $buttonAccess     = _LEX_BYTE_DEFAULT_BUTTON;    
      $readButtonsTlb   = _LEX_BYTE_DEFAULT_BTN_TLB;
      
      $readButtonsList  = _LEX_BYTE_DEFAULT_BTN_LIST;            
      $readAccessList   = _LEX_BYTE_DEFAULT_READLIST;
      $readPropertyList = _LEX_BYTE_DEFAULT_PROPERTYLIST;    
      
      $readButtonsForm  = _LEX_BYTE_DEFAULT_BTN_FORM;
      $readAccessForm   = _LEX_BYTE_DEFAULT_READFORM;
      $readPropertyForm = _LEX_BYTE_DEFAULT_PROPERTYFORM;    
      
      //$showOption       = _LEX_BYTE_DEFAULT_SHOWOPTION;    
      $isDefine = 1 ;
    }
    
    $ta = array('buttonAccess'     => $buttonAccess,
                'readButtonsTlb'   => $readButtonsTlb,
                'readButtonsList'  => $readButtonsList,                
                'readAccessList'   => $readAccessList,                
                'readPropertyList' => $readPropertyList,                
                'readButtonsForm'  => $readButtonsForm,
                'readAccessForm'   => $readAccessForm,               
                'readPropertyForm' => $readPropertyForm);   
                
    return $ta;
      
 }
//-------------------------------------------------------------------------

/***************************************************************************
 
 ***************************************************************************/
 
 function getReadAccess($idLexique, &$buttonAccess, &$readAccessList, &$readPropertyList, $test=''){
	global $xoopsModuleConfig, $xoopsDB;
	
    $groupe = getListGroupesID(_LEX_DIR_NAME);
    $sql = "SELECT {$test} isDefine, buttonAccess, readAccessList, readPropertyList FROM "
          .$xoopsDB->prefix(_LEX_TBL_ACCESS)
          ." WHERE idLexique = {$idLexique}"
          ."   AND idGroup in ({$groupe})";
    $sqlquery = $xoopsDB->queryF($sql);  

    $readAccessList    = 0;
    $readPropertyList  = 0;
    $buttonAccess  = 0;
    $isDefine      = 0;
               
    while ($sqlfetch = $xoopsDB->fetchArray($sqlquery)) {
      $isDefine     = $isDefine     | $sqlfetch ['isDefine'];
      $buttonAccess = $buttonAccess | $sqlfetch ['buttonAccess'];      
      $readAccessList   = $readAccessList   | $sqlfetch ['readAccessList'];
      $readPropertyList = $readPropertyList | $sqlfetch ['readPropertyList'];   
//      echo "read lexique: {$idLexique} - groupes: ({$groupe})=> {$isDefine} : {$buttonAccess} : {$readAccessList} : {$readPropertyList}<br>";       
    }
    
    //si aucune autorisation on donne toutes les autorisation 
    //foncionnement par defaut adopt‚ car sera souvent le cas
    //ou aucune autorisation ne sera defini
    if ($isDefine == 0) {
      $buttonAccess     = _LEX_BYTE_DEFAULT_BUTTON;    
      $readAccessList   = _LEX_BYTE_DEFAULT_READLIST;
      $readPropertyList = _LEX_BYTE_DEFAULT_PROPERTYLIST;    
      $isDefine = 1 ;
    }
      
 }
/****************************************************************************
 *
 ****************************************************************************/
function cb_isLexiqueOk($idLexique){
  // a revoir et remonter ca dans les option avec les boutons meme si c'en est pas
  $ta = getAReadAccess($idLexique);  
  $b = isByteOk (_LEX_BYTE_VISIBLE_IN_GROUP, $ta['buttonAccess']);
  
  return $b;
}


/****************************************************************************
 *
 ****************************************************************************/
function afecterDateBidon($ob = 0){
	global $xoopsModuleConfig, $xoopsDB;
	
	 switch ($ob){
   case 1:
      $table = _LEX_TBL_TERME;
      $idName = "idTerme";
   
      break;
   default:
      $table = _LEX_TBL_LEXIQUE;
      $idName = "idLexique";
      break;
   
   }
	 
    $sql = "SELECT {$idName} FROM ".$xoopsDB->prefix($table);
    //echo "---> {$sql}<br>";
    $sqlquery = $xoopsDB->queryF($sql);  

    //-------------------------------------------------------
    while ($sqlfetch = $xoopsDB->fetchArray($sqlquery)) {
      $id = $sqlfetch[$idName];


/*
      $newDate = getdate();
      $aujourdhui = getdate();
      $mois = $aujourdhui['month'];
      $mjour = $aujourdhui['mday'];
      $annee = $aujourdhui['year'];
//  echo "$mjour/$mois/$annee";
*/

     $j=array();
      $j['year'] = rand (2005, 2007) ;
      $j['month'] = rand (1, 12);
      $j['mday']= rand (1, 30);
      $nd = implode("-", $j);

      echo "date rnd = {$nd}<br>";
      $newDateCreation = date("y-m-d", strtotime($nd));
      
      
      $j['year'] = rand (2005, 2007) ;
      $j['month'] = rand (1, 12);
      $j['mday']= rand (1, 30);
      $nd = implode("-", $j);
      
      $newDateModification = date("y-m-d", strtotime($nd));      
      
      $sql = "UPDATE ".$xoopsDB->prefix($table)
            ." SET dateCreation = '{$newDateCreation}'," 
            . "dateModification = '{$newDateModification}',"
            . "dateState = 0 "
            ." WHERE {$idName} = ".$id; 
 //date( 'd-m-Y',strtotime($date));      
    //echo "---> {$sql}<br>";     
      $xoopsDB->queryF($sql);      
   
   }
}

/***************************************************************************
JJD - 15/07/2006
Nouvelle fonction pour alimenter le champ 'letter' en remplacement 
de la liste d&eacute;roulante avec l'alaphabet
La fonction prens la premiere lettre du mot, la transforme en maluscule
et la recherche dans la constante _MD_LEX_ALPHABET. Si elle n'est pas trouv&eacute;
la fonction renvoie _MD_LEX_OTHERS &eacute;galement d&eacute;fini dans les fichiers de langue
attention maintenant _MD_LEX_ALPHABET doit avoir une longueur de 1 caract&egrave;re
normalement "#"
plut(t que lur les d&eacute;but de mot de la description.'
****************************************************************************/

function getFirstLetter($name)
{
	Global $xoopsDB, $xoopsModuleConfig, $info;

  $alphabet = strtoupper ( $info['alphabet'] );
  $other    = $info['other'];

  $ret="";

  if (''.$name == '') {$ret = $other;}
  
  $fl = strtoupper(substr($name, 0, 1)) ;
  
  if (strpos($alphabet, $fl)=== false AND $alphabet <> '') 
    {$ret = $other;} 
  else 
    {$ret = $fl;}
  //-------------------------------------
  return $ret;    
}
/***************************************************************************

****************************************************************************/
function getLexNotation($lButton = 255, $lexInfo){

	global $xoopsConfig, $xoopsDB, $xoopsModule, $xoopsUser, $info;
  //-----------------------------------------------------------------------	
  //echo "<hr>getLexNotation : {$lButton}-"._LEXBTN_NOTE_LEX."<hr>"  ;
  
  $r = '';
  $t= array();
  if ((($lButton &  _LEXBTN_NOTE_LEX)  <> 0 ) AND ($lexInfo['noteMax'] > $lexInfo['noteMin'] )){

    $mask = XOOPS_URL.$lexInfo['noteImg'];
    $tImg = array();
$req = $_SERVER['QUERY_STRING'];
    for ($h = $lexInfo['noteMin']; $h <= $lexInfo['noteMax']; $h++){
        $img = str_replace("?", $h, $mask);
        $tImg[] = "<A HREF='admin/lex_action.php?op=addNote2lexique&idLexique={$lexInfo['idLexique']}&note={$h}&{$req}'>"
                 ."<img src='{$img}' border=0 Alt='"
                 .$h."' ALIGN='absmiddle'></A>" ; 
    }
    $a = round($lexInfo['noteAverage'],1);
    $r = " - "._MD_LEX_NOTE_NUMBER. ": {$lexInfo['noteCount']} - "._MD_LEX_NOTE_AVERAGE.": {$a} / {$lexInfo['noteMax']} ";
    $r = ' '._MD_LEX_NOTE_THIS_LEXIQUE.' '.implode('', $tImg).$r;        
  }
  
  return $r;

  
}
/***************************************************************************
 *
****************************************************************************/
function getFollow($lButton = 255, $idTerme = 0, $idLexique = 0, $terme = ''){
	global $xoopsConfig, $xoopsDB, $xoopsModule, $xoopsUser, $info, $libelle;
  
  if (($lButton &  _LEXBTN_FOLLOW) <> 0 ){	
			if ($info['intlinkspopup'] == 1) {
				$r  = "<a HREF=\"javascript:openWithSelfMain('popup.php?mode=1&id={$idTerme}&idLexique={$info['idLexique']}','',{$info['intlinkswidth']},{$info['intlinksheight']});\">"
                  ."<img src='"._JJDICO_VIEW."' border=0 Alt='"._MD_LEX_VIEW."' title='"._MD_LEX_VIEW."' width='20' height='20' ALIGN='absmiddle'>"
                  .$libelle['follow']
                  ."</a>";
				
			} else {
          $r = "<A HREF='detail.php?id=".$idTerme."&idLexique={$idLexique}'>"
                   ."<img src='"._JJDICO_VIEW."' border=0 Alt='"._MD_LEX_VIEW."' title='"._MD_LEX_VIEW."' width='20' height='20' ALIGN='absmiddle'>"
                  .$libelle['follow']                   
                   ."</A>" ;
      }			

  }else{
    $r = '';
  }
  //-----------------------------------------
  return $r;
}
/***************************************************************************
JJD - 25/07/2006
Nouvelle fonction pour construire la barre de bouton utiliser dans les listes 

Param&egrave;tres:
  $lButton:  addition de valeur Binaire des constantes de d&eacute;finition des boutons
             voir les d&eacute;finition en tete de ce module
  $id: Identifiant du mot pour les options qui le n&eacute;cessite comme le bouton 'edit' ou 'delete''"

exemple: 
  $post['admin'] = getButtonBar (BTN_EDIT | _LEXBTN_NEW | _LEXBTN_DELETE | _LEXBTN_PRINT | _LEXBTN_SENDMAIL, $post['id']);
****************************************************************************/
function getButtonBar($lButton = 255, $idTerme = 0, $idLexique = 0, $terme = ''){
  //echo "<hr>getButtonBar-byte : {$lButton}-"._LEXBTN_NOTE_LEX."-"._LEXBTN_NOTE_TERME."<hr>" ;
	global $xoopsConfig, $xoopsDB, $xoopsModule, $xoopsUser, $info;
  //-----------------------------------------------------------------------	
  $tBtn= array();
  
  //masque les boutons de la barre d'outil dans les listes si pas visible
  //if (!isBitOk(_LEX_BYTE_VISIBLE, $lButton)) $lButton = $lButton &  _LEXBTN_TLB_MASKED ;
  //if (!isBitOk(_LEX_BYTE_VISIBLE, $lButton)) $lButton = $lButton &  ~_LEXBTN_MENU0 ;  
  
/*//------------------------------------------------------
*/
  //affichage des numero pour la notation
  //echo "<hr>boutons : {$lButton}<br>min : {$info['noteMin']}<br>max : {$info['noteMax']}<hr>";  
  if (($lButton &  _LEXBTN_TLB_MENU0)  <> 0 ){
    $tBtn[] = getLexNotation($lButton , $info); 
  
  }
 
  //affichage des numero pour la notation
  //echo "<hr>boutons : {$lButton}<br>min : {$info['noteMin']}<br>max : {$info['noteMax']}<hr>";  
/*
*/
  if ((($lButton &  _LEXBTN_NOTE_TERME)  <> 0 ) AND ($info['termeNoteMax'] > $info['termeNoteMin'] )){

    $mask = XOOPS_URL.$info['termeNoteImg'];
    $tImg = array();
    $req = $_SERVER['QUERY_STRING'];
    for ($h = $info['termeNoteMin']; $h <= $info['termeNoteMax']; $h++){
        $img = str_replace("?", $h, $mask);
        $tImg[] = "<A HREF='admin/lex_action.php?op=addNote2item&idTerme={$idTerme}&note={$h}&{$req}'>"
                 ."<img src='{$img}' border=0 Alt='"
                 .$h."' ALIGN='absmiddle'></A>" ; 
    }
    $a = round($terme['noteAverage'],1);
    $r = " - "._MD_LEX_NOTE_NUMBER. ": {$terme['noteCount']} - "._MD_LEX_NOTE_AVERAGE.": {$a} / {$info['termeNoteMax']} ";
    $tBtn[] = ' '._MD_LEX_NOTE_THIS_TERME.' '.implode('', $tImg).$r;        
  
  }

//----------------------------------------------------------------------






  if (($lButton &  _LEXBTN_VIEW) <> 0 ){
			if ($info['intlinkspopup'] == 1) {
				$tBtn[]  = "<a HREF=\"javascript:openWithSelfMain('popup.php?mode=1&id={$idTerme}&idLexique={$info['idLexique']}','',{$info['intlinkswidth']},{$info['intlinksheight']});\">"
                  ."<img src='"._JJDICO_VIEW."' border=0 Alt='"._MD_LEX_VIEW."' title='"._MD_LEX_VIEW."' width='20' height='20' ALIGN='absmiddle'>"
                  ."</a>";
				
			} else {
          $tBtn[] = "<A HREF='detail.php?id=".$idTerme."&idLexique={$idLexique}'><img src='"._JJDICO_VIEW."' border=0 Alt='"._MD_LEX_VIEW."' title='"._MD_LEX_VIEW."' width='20' height='20' ALIGN='absmiddle'></A>" ;
      }			
	}
//---------------------------------------
  if (($lButton & _LEXBTN_HOME_BIBLIO) <> 0 ){
    $tBtn[] = "<A HREF='index.php'><img src='"._JJDICO_URL."lexiques.gif' border=0 Alt='"._MD_LEX_HOME_BIBLIO."' title='"._MD_LEX_HOME_BIBLIO."' width='20' height='20' ALIGN='absmiddle'></A>" ;}

  if (($lButton &  _LEXBTN_HOME_LEXIQUE) <> 0 ){
    $tBtn[] = "<A HREF='lexique.php?&idLexique={$idLexique}'><img src='"._JJDICO_URL."lexique.gif' border=0 Alt='"._MD_LEX_HOME_LEXIQUE."' title='"._MD_LEX_HOME_LEXIQUE."' width='20' height='20' ALIGN='absmiddle'></A>" ;}

//---------------------------------------
  if (($lButton &  _LEXBTN_SEARCH) <> 0 ){
    $tBtn[] = "<A HREF='searchExp.php?&idLexique={$idLexique}'><img src='"._JJDICO_SEARCH."' border=0 Alt='"._SEARCH."' title='"._SEARCH."' width='20' height='20' ALIGN='absmiddle'></A>" ;}

  if (($lButton &  _LEXBTN_ASKDEF) <> 0 ){
    $tBtn[] = "<A HREF='question.php?&idLexique={$idLexique}'><img src='"._JJDICO_ASKDEF."' border=0 Alt='"._MD_LEX_ASK_DEF."' title='"._MD_LEX_ASK_DEF."' width='20' height='20' ALIGN='absmiddle'></A>" ;}
  
  if (($lButton &  _LEXBTN_EDIT) <> 0 ){
    $tBtn[] = "<A HREF='submit.php?id=".$idTerme."&idLexique=".$idLexique."'><img src='"._JJDICO_EDIT."' border=0 Alt='"._EDIT."' title='"._EDIT."' width='20' height='20' ALIGN='absmiddle'></A>" ;}
 
  if (($lButton &  _LEXBTN_NEW) <> 0 ){
    $tBtn[] = "<A HREF='submit.php?idLexique=".$idLexique."'><img src='"._JJDICO_NEW."' border=0 Alt='"._ADD."' title='"._ADD."' width='20' height='20' ALIGN='absmiddle'></A>" ; }
 
  if (($lButton &  _LEXBTN_DELETE) <> 0 ){
    $tBtn[] = "<A HREF='admin/del-def.php?op=delete&id=".$idTerme."&idLexique=".$idLexique."'><img src='"._JJDICO_DELETE."' border=0 Alt='"._DELETE."' title='"._DELETE."' width='20' height='20' ALIGN='absmiddle'></A>" ; }
 //
  if (($lButton &  _LEXBTN_MOVE_DEF) <> 0 ){
    $tBtn[] = "<A HREF='admin/del-def.php?op=move&id=".$idTerme."&idLexique=".$idLexique."'><img src='"._JJDICO_MOVE."' border=0 Alt='"._MD_LEX_MOVE_DEF_TO_LEX."' title='"._MD_LEX_MOVE_DEF_TO_LEX."' width='20' height='20' ALIGN='absmiddle'></A>" ; }
 
 
 
  if (($lButton &  _LEXBTN_PRINT) <> 0 ){
    //$tBtn[] = "<a href='print.php?id=".$idTerme."&idLexique=".$idLexique."' target='_blank'><img src='images/icones/print.gif' border=0 Alt='"._MD_LEX_PRINT."' width='20' height='20' ALIGN='absmiddle'></a>" ; 
		$tBtn[]  = "<a HREF=\"javascript:openWithSelfMain('popup.php?mode=2&id={$idTerme}&idLexique={$info['idLexique']}','',{$info['intlinkswidth']},{$info['intlinksheight']});\">"
            ."<img src='"._JJDICO_PRINT."' border=0 Alt='"._MD_LEX_PRINT."' title='"._MD_LEX_PRINT."' width='20' height='20' ALIGN='absmiddle'>"
            ."</a>";

  }

  if (($lButton &  _LEXBTN_FILES) <> 0 ){
    $tBtn[] = "<A HREF='loadFile.php?op=&id=".$idTerme."&idLexique=".$idLexique."'><img src='"._JJDICO_URL."trombonne.gif' border=0 Alt='"._MD_LEX_MOVE_DEF_TO_LEX."' title='"._MD_LEX_MOVE_DEF_TO_LEX."' width='20' height='20' ALIGN='absmiddle'></A>" ; }

  //------------------------------------------------------------------------
  //la c'est sp&eacute;cial car si le commentaire existe l'icone utilis&eacute; n'est pas le m&ecirc;me
  //le flag test&eacute; est _LEXBTN_COMMENT, mais les flag utilis&eacute; sont _LEXBTN_COMMENT1 & _LEXBTN_COMMENT2
  if (($lButton &  _LEXBTN_COMMENT) <> 0 ){
    if (($lButton &  _LEXBTN_COMMENT1) <> 0 ){
      $tBtn[] = "<a href='detail.php?id=".$idTerme."&idLexique=".$idLexique."'><img src='"._JJDICO_COMMENT1."' border=0 Alt='"._COMMENTS."' title='"._COMMENTS."' width='20' height='20' ALIGN='absmiddle'></a>" ; }
  
    if (($lButton &  _LEXBTN_COMMENT2) <> 0 ){
      $tBtn[] = "<a href='detail.php?id=".$idTerme."&idLexique=".$idLexique."'><img src='"._JJDICO_COMMENT2."' border=0 Alt='"._COMMENTS."' title='"._COMMENTS."' width='20' height='20' ALIGN='absmiddle'></a>" ; }
  }
  //------------------------------------------------------------------------
  
  if (($lButton &   _LEXBTN_SENDMAIL) <> 0 ){
    $body = sprintf(_MD_LEX_INTDEFINITIONFOUND, $xoopsConfig['sitename'])
             .":  ".XOOPS_URL.""._LEXCST_DIR_ROOT."detail.php?id=".$idTerme."&idLexique=".$idLexique;
             
    $tBtn[] = "<a target='_top' href='mailto:?subject="
             .sprintf(_MD_LEX_INTDEFINITION,$xoopsConfig['sitename'])
             ."&amp;body=".$body."'>"
             ."<img src='"._JJDICO_SEND."' border='0' alt='"._MD_LEX_FRIENDSEND
             ."' title='"._MD_LEX_FRIENDSEND."' width='20' height='20' ALIGN='absmiddle'></a>" ; }
 
  if (($lButton &  _LEXBTN_ADMIN) <> 0 ){
    $tBtn[] = "<A HREF='"._LEX_URL_ADMIN."admin_lexique.php?op=edit&idLexique={$idLexique}'><img src='"._JJDICO_TOOLS."' border=0 Alt='"._MD_LEX_ADMINISTRATION."' title='"._MD_LEX_ADMINISTRATION."' width='20' height='20' ALIGN='absmiddle'></A>" ; }

  //------------------------------------------------------------------------
  $sep = "&nbsp;";
  $r = implode ( $sep, $tBtn);
//echo "<hr>getButtonBar<br>$r<hr>";  
 return $r;
 
 
}

/******************************************************************
 * incremente le nombre de visite des termes dont la selection rTpond
 * aux criteres passe en parametre 
 * GŠre aussi les pages (les lilites) 
 ******************************************************************/
function incrementVisit ($selection = 0, $v=1, $limitStart = 0, $limitCount = 0){
	global $xoopsModuleConfig, $xoopsDB;
	
	if ($limitCount > 0) {
      $sqlLimit = "LIMIT ".intval($limitStart).",".intval($limitCount);
  } else {
      $sqlLimit = "";
  }
  //----------------------------------------------------------------
	if (is_string($selection)){
  	 if ($selection <> ""){
  	   $clauseWhereId = addClause ("WHERE", $selection);
  	}
     else {
  	   $clauseWhereId = " ";
      }
  }
  else {
	 $clauseWhereId = "WHERE idTerme =".$id;  
   $sqlLimit = ""; 
  }
  
  //il semble que le clause 'LIMIT' ne fonctionne pas avec la clause UPDATE
  //faudra probablement adopter une autre solution plus gourmande !!!
  //pour le moment je la d‚sactive
   $sqlLimit = "";	
   
  //----------------------------------------------------------------------
  if ($v == 0){
    $sql = "UPDATE ".$xoopsDB->prefix(_LEX_TBL_TERME)." SET visit = ".$v." ".$clauseWhereId." ".$sqlLimit;  }
  else {
    $sql = "UPDATE ".$xoopsDB->prefix(_LEX_TBL_TERME)." SET visit = visit+".$v." ".$clauseWhereId." ".$sqlLimit;
  }
  //----------------------------------------------------------------------

  //echo $sql."<br>";
  $xoopsDB->queryF($sql);

}

/******************************************************************
 * 
 ******************************************************************/
function setVisit ($selection=0, $v=0){
	global $xoopsModuleConfig, $xoopsDB;
	
	if (is_string($selection)){
  	 if ($clauseWhereId <> ""){
  	   $clauseWhereId = addClause ("WHERE", $selection);
  	 }
     else {
  	   $clauseWhereId = " ";
      }
  }
  else {
	 $clauseWhereId = " WHERE idTerme=".$id;  
  }
	
  //----------------------------------------------------------------------
  $sql = "UPDATE ".$xoopsDB->prefix(_LEX_TBL_TERME)." SET visit = ".$v.$clauseWhereId;	
  //-------------------------------------------------------
  $xoopsDB->query($sql);

}

/******************************************************************
 * Renvoi la s‚lection de termed r‚pondant au critŠres pass‚s en paramŠtre
 * Incr‚mente le nombre de visite le cas ‚ch‚ants 
 ******************************************************************/
function selectTermes($sqlSelect = "*", $sqlWhere = "", $sqlOrderby = "", 
                      $limitStart = 0, $limitCount = 0, 
                      $increment=true){
	global $xoopsModuleConfig, $xoopsDB, $info;
  
  $sqlWhere   = addClause ("WHERE", $sqlWhere);
  $sqlOrderby = addClause ("ORDER BY", $sqlOrderby);
  $sqlSelect  = addClause ("SELECT", $sqlSelect);
  
  //if ($limitStart <> $limiCount) {
  if ($limitCount > 0) {
      $sqlLimit = "LIMIT ".intval($limitStart).",".intval($limitCount);
  } else {
      $sqlLimit = "";
  }


  $sql ="{$sqlSelect} FROM ".$xoopsDB->prefix(_LEX_TBL_TERME)
       ." {$sqlWhere} {$sqlOrderby} {$sqlLimit}";

  //echo "<hr>{$sql}<hr>";
  //displaySql ($sql,'selectTermes+++++++++++',true);     
   
//   echo "Select  = ".$sqlSelect."<br>";
//   echo "Where   = ".$sqlWhere."<br>";
//   echo "Orderby = ".$sqlOrderby."<br>";  

  
  if ($increment and $info['detailGererVisit'] == 1) {
      incrementVisit ($sqlWhere, 1, $limitStart, $limitCount);
  }  
  $sqlquery = $xoopsDB->query($sql);

  return $sqlquery;
}
/******************************************************************
 *
 ******************************************************************/
 function lex_envoyerMail ($message, $terme, $id = 0, $shortDef = '', 
          $definition1 = '', $definition2 = '', $definition3 = ''){
 
	global $xoopsConfig, $xoopsModuleConfig, $xoopsDB, $xoopsUser, $info; 
/*
 
displayArray($info,'-------------lex_envoyerMail----------------');
	echo "+++++++++++++++++++++++++++++++++++++++++++++<br>";
	echo "{$info['mail4webmaster']}<br>";
	echo "+++++++++++++++++++++++++++++++++++++++++++++<br>";	
*/	
	


   	if ($xoopsUser) {
      $logName = $xoopsUser->getVar("uname", "E");   	
      $sql = "SELECT email FROM ".$xoopsDB->prefix("users")." where uname='{$logName}'";
  		$result = $xoopsDB->query($sql);
  		list($adrs) = $xoopsDB->fetchRow($result);

  	} else {
      $logName = 'unknow';  	
  		$adrs = $info['mail4webmaster'];
    }  
    //--------------------------------------------------
   	if (! $info['sendmail2webmaster']) return false;    
		if ($info['mail4webmaster'] != '') {
			$setToEmails = $info['mail4webmaster'];
		} else {
			$setToEmails = $xoopsConfig['adminmail'];
		}
   	if ($setToEmails == $adrs) return false;
    //--------------------------------------------------
   	
   	//if ($info['sendmail2webmaster']) {
   	
		$subject = $xoopsConfig['sitename']." - "._MD_LEX_LEXIQUE;
		$xoopsMailer =& getMailer();
		$xoopsMailer->useMail();
		$xoopsMailer->setToEmails($setToEmails);		
		$xoopsMailer->setFromEmail($adrs);
		$xoopsMailer->setFromName($xoopsConfig['sitename']);
		$xoopsMailer->setSubject($subject);
		
  $mode = 0;
  $tBody = array();  
	$myts =& MyTextSanitizer::getInstance();

    //$definition1 = $myts->makeTareaData4Show($p['introtext'], "1", "1", "1");
   	//$desc1 = getXME($definition1, 'txtIntrotext', '','100%');

  switch ($mode){
  //---------------------------------------------------------  
  case 1: //texte

    $tBody[] = findConstante('HELLO', 'LEX') . ', '. $message ;
    $tBody[] = _LEX_URL."/detail.php?id={$id}<br>";
    $tBody[] = _MI_LEX_SEND_BY." : {$logName} : {$adrs}";
    $tBody[] = _MI_LEX_TERME.": $terme ({$id})";
    $tBody[] = _MI_LEX_SHORTDEF2.": ${shortDef}";
    
    break;
  //---------------------------------------------------------    
  case 2: //pdf
    break;
    
  //---------------------------------------------------------    
  default:
    $xoopsMailer->multimailer->isHTML(true);  
    
    $tBody = array();
    $tBody[] = "<html>";
    $tBody[] = "  <head>";
    //$tBody[] = "    <meta http-equiv=\"Content-Type\" content=\"text/html; charset=windows-1252\">";
    $tBody[] = "    <title>J°J°D</title>";
    $tBody[] = "  </head>";
    $tBody[] = "  <body>";
    $tBody[] = "    <b>". findConstante('HELLO', 'LEX') . ', '. $message . "</b><hr>";
    
    $tBody[] = "    <A href='"._LEX_URL."/detail.php?id={$id}'>".$terme."</A><br>";
    $tBody[] = "    <A href='"._LEX_URL."index.php?idLexique={$info['idLexique']}'>{$info['name']}</A><br>";    
    $tBody[] = "    <A href='"._LEX_URL."'>"._LEX_NAME."</A><br>";    
    $tBody[] = "    <A href='".XOOPS_URL."'>{$xoopsConfig['sitename']}</A><br>";   
     
    $tBody[] = "    "._MI_LEX_SEND_BY." : {$logName} : {$adrs}<br>";
    $tBody[] = "    "._MI_LEX_TERME.": $terme ({$id})<br>";
    $tBody[] = "    "._MI_LEX_SHORTDEF2.": ${shortDef}<hr>";
    
    
    for ($h = 1; $h <= 3; $h++){
      $name = "definition".$h;
      $def = $$name;
      if ($def <> ''){
        $def = $myts->sanitizeForDisplay($def,1,0,0,0,0);	
        //$def = str_replace ("http:/","http://",$def);
        $def = str_replace ('\\',"", $def);    
        $tBody[] = "    <b>".constant("_MI_LEX_DEFINITION{$h}")." : </b>{$def}<hr>";

      }
    }
    
    $tBody[] = "  </body>";
    $tBody[] = "</html>";    
    
  }	
  //---------------------------------------------------------           
            
    $body = implode("\n", $tBody);        
    //$body = strip_tags($body);
       
		$xoopsMailer->setBody($body);
		$xoopsMailer->send();
		echo "<hr>Mail envoyé<hr>";
	//}

 }
 
 /****************************************************************************
 * 
 ****************************************************************************/
function getHeaderLex ($mode){
//mode = 0 pas d'entete
//mode = 1: format html
//mode = 2 format text
      
      if ($mode == 0 ) return '';
      //------------------------------------------------------
      $d = date("d-m-Y h:m:h" , time());
      
      $header = array();
      $header[] = "From: webmaster@{$_SERVER['SERVER_NAME']}";
      $header[] = "Reply-To: webmaster@{$_SERVER['SERVER_NAME']}";
      $header[] = "X-Mailer: PHP/" . phpversion();
      
      if ($mode == 2){
        //bin rien a prori
      }else{
        $header[] = "MIME-Version: 1.0";       
        $header[] = "Content-type: text/html; charset=iso-8859-1";
      
      }
      $header[] = "";
      
      //$sHeader = implode("\r\n", $header);
      $sHeader = implode("\r\n", $header);

  return $sHeader;



}

/************************************************************************
 *Remplace dans une reque SQL le nom court ou le nom prefixes 
 * des tables entre accolade, par le nom complet des tables
 * le nom court doit ˆtre en accolage et sans le signe '$' 
 ************************************************************************/

function replaceTbl ($sql){
	global $xoopsDB;
	
	$prefixe = '{';
	$suffixe = '}';	
  //$l = strlen(_LEX_TAB_PREFIXE);	
  //$l = _LEX_TFN_LGPREFIXE;
  
  $tbl0 = array( _LEX_TAB_LEXIQUE,  _LEX_TAB_TERME,
                 _LEX_TAB_TEMP,     _LEX_TAB_FAMILY,
                 _LEX_TAB_CATEGORY, _LEX_TAB_SELECTEUR);

  
  $tbl = array ( _LEX_TFN_LEXIQUE,  _LEX_TFN_TERME,
                 _LEX_TFN_TEMP,     _LEX_TFN_FAMILY,
                 _LEX_TFN_CATEGORY, _LEX_TFN_SELECTEUR);
  

//echo 'lg = '.$xoopsDB->prefix('x').'<br>';
//echo 'lg = '._LEX_TFN_LGPREFIXE.'<br>';  

//echo "$sql<br>";                
  for ($h = 0; $h < count($tbl0); $h++){
    $r = $prefixe.$tbl0[$h].$suffixe;
    $sql = str_replace ($r, $tbl[$h], $sql);
    
    //$r = $prefixe.substr($tbl[$h],_LEX_TFN_LGPREFIXE0).$suffixe;
    $r = $prefixe._LEX_TAB_PREFIXE.$tbl0[$h].$suffixe;        
    $sql = str_replace ($r, $tbl[$h], $sql);
    
    //echo $tbl[$h].'<br>';
    //echo "$sql<br>";
  }
  //--------------------------------------------------------------
  $tbl0 = array ( _LEX_TAB_USERS,    _LEX_TAB_GLOSSAIRE);
  $tbl1 = array ( _LEX_TFN_USERS,    _LEX_TFN_GLOSSAIRE);
  
  for ($h = 0; $h < count($tbl0); $h++){
    $r = $prefixe.$tbl0[$h].$suffixe;
    $sql = str_replace ($r, $tbl1[$h], $sql);
    
    //echo $tbl[$h].'<br>';
    //echo "$sql<br>";
  }

  //--------------------------------------------------------------     
  return $sql;
} 

/********************************************************************
 * Retourne le lien sur l'icone du lexique s'il est défini
 ********************************************************************/
function getLexIcone($icone){
		
		$imgLink = "<img src='"._LEX_URL_LEXICONES."{$icone}' border=0 Alt='' width='20' height='20' ALIGN='absmiddle'>";
    return $imgLink ;
    
}


/***************************************************************************
 *
 ***************************************************************************/
function buildLexiqueList($url = '', $idLexiqueToExclude = '', $sep = ","){

	global $xoopsConfig, $xoopsModuleConfig, $xoopsDB, $xoopsUser, $info;
	
	//-----------------------------------------------------------------
  if 	($idLexiqueToExclude == ''){
    $sqlExclude = '';  
  }else{
    $sqlExclude = " AND idLexique NOT IN ({$idLexiqueToExclude})";  
  }
	
	//-----------------------------------------------------------------
	
	if ($url == ''){
      $link1 = '';
  }else{
      $link0 = XOOPS_URL._LEXCST_DIR_ROOT.$url;
      $link1 ="gotoLexique(\"{$link0}\");";
       
  }
//echo "<hr>buildLexiqueList<br>$sqlExclude<hr>";  
  $list = buildHtmlListFromTable ("idLexique", 
                                  _LEX_TBL_LEXIQUE, 
                                   "name", 
                                   "IdLexique",  
                                   "ordre,name", 
                                   $info['idLexique'],
                                   $link1,
                                   "actif = 1 {$sqlExclude}", 
                                   $width = "100",
                                   'cb_isLexiqueOk');
  return $list;

}
//<link href="http://acf.passetemps.net/favicon.ico" rel="SHORTCUT ICON" />
/***************************************************************************
 *
 ***************************************************************************/
//D:/www/xoos-02/modules/jjd_tools/images/chiffres/chiffres_*
//D:\www\xoos-02\modules\jjd_tools\_common\images\chiffres


function getListNoteImgSet($name, $default, $oc = ''){
	global $xoopsConfig, $xoopsModuleConfig, $xoopsDB, $xoopsUser, $info;
	
  //echo "<hr>getListNoteImgSet<hr>";
	
	$list = str_replace(chr(10), '', $xoopsModuleConfig['imgCounterFolder']);
  $tRoot = explode(chr(13),	$list);
  array_unshift ($tRoot , "/modules/jjd_tools/_common/images/chiffres/chiffres_*/chiffre_?.gif");	
  array_unshift ($tRoot , "/modules/lexique/images/note/*/?.gif");	
  
  //displayArray($tRoot,"***** => getListNoteImgSet *****");
  
  $tSet = array();
	$lg = strlen(XOOPS_ROOT_PATH); 	
	for ($h = 0; $h < count($tRoot); $h++){
	  if ($tRoot[$h] == '' ) continue;	
	  $fullName = str_replace ('//','/', trim(XOOPS_ROOT_PATH.'/'.$tRoot[$h]));	  
	  $folder = dirname($fullName);
    $fMask = basename ($fullName); 

    $tf = glob($folder, GLOB_ONLYDIR);    
    //displayArray($tf,"--- |{$folder}| ---"); 
    
    for ($i = 0; $i < count($tf); $i++){
      $sf = $tf [$i].'/'.$fMask;
      $tsf = glob($sf);
      //echo "<hr>{$sf}<br>";
      //print_r ($tsf);
      
      if (count($tsf) > 0){
        $tSet[] = substr($tf [$i], $lg).'/'.$fMask;     
      }   
    } 	

    	

  }
	
	
  array_unshift ( $tSet, '');    
  //displayArray($tSet,"***** getListNoteImgSet *****");    

    return buildHtmlListString ($name, $tSet, $default, $oc);
    //$tselected [] = "<SELECT NAME='{$name}' NAME='{$name}' {$size} {$oc} >";

	
}

/***************************************************************************
 *
 ***************************************************************************/

function clearAllNote($idLexique){

}

/***************************************************************************
 *
 ***************************************************************************/

function clearNote($idTerme){

}
/***************************************************************************
 *

function addNote2lexique($idLexique, $note){
Global $xoopsModuleConfig, $xoopsDB, $xoopsConfig, $xoopsModule;  


  $sql = "UPDATE ".$xoopsDB->prefix(_LEX_TBL_TERME)." SET "
        ."noteSum = noteSum + {$note}, "
        ."noteCount = noteCount + 1,"
        ."noteAverage = noteSum / noteCount"
        ." WHERE idTerme = {$idTerme}";


	//$myts =& MyTextSanitizer::getInstance();
	
	
  $xoopsDB->queryF($sql);
  //echo "<hr>addNote<br>{$sql}<hr>";
}
 ***************************************************************************/

/***************************************************************************
 *_LEX_TBL_TERME idTerme
 ***************************************************************************/
function addNote($table, $id, $colNameId, $note){
Global $xoopsModuleConfig, $xoopsDB, $xoopsConfig, $xoopsModule;  


  $sql = "UPDATE ".$xoopsDB->prefix($table)." SET "
        ."noteSum = noteSum + {$note}, "
        ."noteCount = noteCount + 1,"
        ."noteAverage = noteSum / noteCount"
        ." WHERE {$colNameId} = {$id}";


	//$myts =& MyTextSanitizer::getInstance();
	
	
  $xoopsDB->queryF($sql);
  //echo "<hr>addNote<br>{$sql}<hr>";exit;
  
}
/***************************************************************************
 *
 * 
 ***************************************************************************/
 
  function getUserFolder(){
    return _LEX_ROOT_PATH."/upload";
  }
 
 
 
 
 
 
 /***************************************************************************
 *

function addNote2terme($idTerme, $note){
Global $xoopsModuleConfig, $xoopsDB, $xoopsConfig, $xoopsModule;  


  $sql = "UPDATE ".$xoopsDB->prefix(_LEX_TBL_TERME)." SET "
        ."noteSum = noteSum + {$note}, "
        ."noteCount = noteCount + 1,"
        ."noteAverage = noteSum / noteCount"
        ." WHERE idTerme = {$idTerme}";


	//$myts =& MyTextSanitizer::getInstance();
	
	
  $xoopsDB->queryF($sql);
  //echo "<hr>addNote<br>{$sql}<hr>";
}
 ***************************************************************************/


?>
