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

//-----------------------------------------------------------------------------------
include_once ("admin_header.php");
global $xoopsModule;

//-----------------------------------------------------------------------------------

include XOOPS_ROOT_PATH."/class/xoopsformloader.php";


$nbCatMax = getValeurBornee('nbcategorymax', _MINCATEGORY, _MAXCATEGORY);
Global $tcat, $cat_0, $cat_1, $cat_2, $cat_3, $cat_4;
Global $xoopsDB, $xoopsModuleConfig, $state;
	
echo "<TABLE BORDER=0 CELLPADDING=2 CELLSPACING=3>";
//echo "--------------------<>br";

//echo "lexique = ".$lexique."<br>";
  $wz1 = '100%'; 
  $wz2 = '5'; 

  $list = $p['categories'];   //loadCategory ($idFamily);
//displayArray($list, "Categories");  
  //----------------------------------------------------------------------- 
  for ($h = 0; $h < count($list); $h++){
    $tcat = $list [$h];
    $i = $h + 1;
    $j =$h;// $tcat['idCategory'];
    echo "<TR>"._br;
    echo "<TD align='right'>{$i}</TD>"._br;
    echo "<INPUT TYPE='hidden' NAME='"._PREFIX_IDCATEGORY."_{$j}' VALUE='{$tcat['idCategory']}'>";

    echo "<TD><INPUT TYPE=\"text\" NAME='"._PREFIX_CAT."_{$j}' SIZE='".$wz1."' VALUE='{$tcat['name']}'></TD>"._br;
    echo "<TD align='right'><INPUT TYPE=\"text\" NAME='"._PREFIX_ORD."_{$j}' SIZE='".$wz2."' VALUE='{$tcat['showOrder']}' style='text-align: right'></TD>"._br;

    
    if ($tcat['state'] == 1){$value = 'checked';} else {$value = 'unchecked';}    
    echo "<TD align='center'  ><input type='checkbox' NAME='"._PREFIX_STATE."_{$j}' size='5%' {$value}></td>"._br;
   //     $line =  "<input type='checkbox' name='".$prefixe.$h."' ".$value.">&nbsp;".$tList[$h]."</input>";

    
    
    echo "</TR>"._br;
  }

echo "</table>";


  
?>
