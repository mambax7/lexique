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
include_once ("../admin/admin_header.php");
//include_once ("../header.php");
include_once ("temp_function.php");
include_once (_LEX_ROOT_PATH."include/seealso_function.php");
//***************************************************************

  $id = $_POST['id'];
  $from = "ISO-8859-1";
  $to = "UTF-8";

  setTemp(_LEX_TBL_TERME, "name",       mb_convert_encoding($_POST['name'],         $from, $to), "idTerme", $id, 0);  
  setTemp(_LEX_TBL_TERME, "shortDef",   mb_convert_encoding($_POST['shortDef'],     $from, $to), "idTerme", $id, 0);
  setTemp(_LEX_TBL_TERME, "definition1", mb_convert_encoding($_POST['definition1'], $from, $to), "idTerme", $id, 0);
  setTemp(_LEX_TBL_TERME, "definition2", mb_convert_encoding($_POST['definition2'], $from, $to), "idTerme", $id, 0);  
  setTemp(_LEX_TBL_TERME, "definition3", mb_convert_encoding($_POST['definition3'], $from, $to), "idTerme", $id, 0);    
  setTemp(_LEX_TBL_TERME, "category",   mb_convert_encoding($_POST['category'],     $from, $to), "idTerme", $id, 0);  


echo  "|ok - JJD ".$_POST['shortDef']."|";


?>
