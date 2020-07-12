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

//bool setcookie ( string name [, string value [, int expire [, string path [, string domain [, int secure]]]]])
/*

if (!isset($_COOKIE['countLexique'])){
  $countLexique = 0;
}else{
  $countLexique++;
}
*/

include_once ("admin_header.php");
global $xoopsModule;
//-----------------------------------------------------------------------------------
include_once ("../include/temp_function.php");
include_once ("../include/letterbar_function.php");

//include(XOOPS_ROOT_PATH."/header.php");

//-------------------------------------------------------------
$vars = array(array('name' =>'op',        'default' => ''),
              array('name' =>'pinochio',  'default' => false));
              
require (_LEX_JJD_PATH."include/gp_globe.php");
//-------------------------------------------------------------

  $redirect = "index.php";
  $msg = _AD_LEX_ADDOK;
  
  //echo $op.'<br>';
  //---------------------------------------------------------
  switch ($op){
  
  case "clearTempLink":
      clearCacheLink (0);
      break;
      
  case "killTemp":
      killTemp ();  
    break;
    
  case "clearIntrusion":
      clearIntrusion ();  
      break;
    
  case "getInfoSelecteur":
      $ts = getInfoSelecteur(1);
//      displayArray ($ts, 'Selecteur');  
    break;
    
  case "getInfoCategory":
      $ts = getInfoCategory(1);
//      displayArray ($ts, 'liste des catTgories');  
      break;
    
  case "getInfoLexique":
      $idLexique = 1;
      $ts = getInfoLexique($idLexique);
      //displayArray($ts,'info lexique');  
      break;
      
  case "changeIdSeeAlso":
      $idLexique = 1;
      changeIdSeeAlso ($idLexique, 'lex_Import');
      //displayArray($ts,'info lexique');  
      break;
      
  case "displayVar":
  
      $a = get_defined_vars ();
      displayArray($a, 'liste des variables');
      //displayArray($HTTP_COOKIE_VARS, 'liste des variables ==> HTTP_COOKIE_VARS');  
  
      displayAll ();

      //echo 'langue = '._LANGCODE.'<br>';
      //echo 'langue = '.$xoopsConfig['language'].'<br>';
      break;

  case "libelle":
  
      $lib = getCaption ();
      displayArray($lib, 'liste des libelles');
      break;
      
  case "rebuild_tempCategory":
      rebuild_tempCategory();
      break;
      
  case "afecterDateBidon2Lexiques":
      afecterDateBidon(0);
      break;

  case "afecterDateBidon2Termes":
      afecterDateBidon(1);
      break;

  case "addNote2item":
    $n = "terme_{$gepeto['idTerme']}";
          
    if (!isset($_COOKIE[$n])){
        addNote(_LEX_TBL_TERME, $gepeto['idTerme'], 'idTerme', $gepeto['note']);  
        setcookie ( $n ,  $gepeto['note']);    		
        $msg = "<b><font color='#FF0000' size='5'>"._AD_LEX_NOTE_THANK." {$countLexique}</font></b>";    
    }else{
        $msg = "<b><font color='#FF0000' size='5'>"._AD_LEX_NOTE_TERMENOTHANK." ("._AD_LEX_NOTE." = {$_COOKIE[$n]})</font></b>";
    }
    $redirect = $_SERVER['HTTP_REFERER'];    
		break;  
		
  case "addNote2lexique":
    $n = "lexique_{$gepeto['idLexique']}";
          
    if (!isset($_COOKIE[$n])){
        addNote(_LEX_TBL_LEXIQUE, $gepeto['idLexique'], 'idLexique', $gepeto['note']);  
        setcookie ( $n ,  $gepeto['note']);    		
        $msg = "<b><font color='#FF0000' size='5'>"._AD_LEX_NOTE_THANK." {$countLexique}</font></b>";    
    }else{
        $msg = "<b><font color='#FF0000' size='5'>"._AD_LEX_NOTE_LEXIQUENOTHANK." ("._AD_LEX_NOTE." = {$_COOKIE[$n]})</font></b>";
    }

    /*
    $t = explode("&", $_SERVER['QUERY_STRING']);
    array_shift($t);
    array_shift($t); 
    echo "<hr>QUERY_STRING => {$_SERVER['QUERY_STRING']}<hr>";    
    echo "<hr>HTTP_REFERER => {$_SERVER['HTTP_REFERER']}<hr>";   
        
    $redirect = $_SERVER['HTTP_REFERER']."?".implode("&", $t);
    
    */ 
    if  ($_SERVER['HTTP_REFERER'] == ''){
      $redirect = _LEX_URL;    
    }else{
      $redirect = $_SERVER['HTTP_REFERER'];    
    }
    
  
  
     //    echo "<hr>======>{$_SERVER['HTTP_REFERER']}<hr>" ;    
    //exit;
    

		break;
  
  }

  //------------------------------------------------------
  redirect_header($redirect,1,$msg);


?>
