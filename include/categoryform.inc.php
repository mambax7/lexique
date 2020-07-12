<?php
include_once (XOOPS_ROOT_PATH."/class/xoopsformloader.php");
include_once (XOOPS_ROOT_PATH._LEXCST_DIR_ROOT."include/functions.php");
include_once (XOOPS_ROOT_PATH._LEXCST_DIR_ROOT."include/category_functions.php");

$nbCatMax = getValeurBornee('nbcategorymax', _MINCATEGORY, _MAXCATEGORY);
Global $tcat, $cat_0, $cat_1, $cat_2, $cat_3, $cat_4;
Global $xoopsDB, $xoopsModuleConfig, $state;
	
echo "<TABLE BORDER=0 CELLPADDING=2 CELLSPACING=3>";

//displayArray($_GET, "Categories");



  $wz1 = '100%'; 
  $wz2 = '5'; 
  $tcat = loadCategory ($state);

  //----------------------------------------------------------------------- 
//  for ($h = 0; $h < $nbCatMax; $h++){  
  for ($h = 0; $h < count($tcat); $h++){
    $n = _PREFIX_CAT.$h;
    //echo "-".$n."-";
    $$n = $tcat[$h];
    $txtName = $n;
    
    $txtOrder = _PREFIX_ORD.$h;
    
    //$txtName = "tca[]";
    //$txtName = "name";
    if ($h > count($tcat)) {$val="";} else {$val=$tcat[$h];}
    $i = $h + 1;
    echo "<TR>";
    echo "<TD align='right'>".$i." </TD>";
    echo "<TD><INPUT TYPE=\"text\" NAME='".$txtName."' SIZE='".$wz1."' VALUE='".$$n."'></TD>";
    //echo "<TD align='right'><INPUT TYPE=\"text\" NAME='".$txtOrder."' SIZE='".$wz2."' VALUE='".$h."'></TD>";
    echo "</TR>";
  }

echo "</table>";

$linkAddCat = buildUrlJava ("category.php?op=addNewCategory",     false);
$linkAddDel = buildUrlJava ("category.php?op=removeLastCategory", false);

echo "<TABLE BORDER=0 CELLPADDING=2 CELLSPACING=3>
  <tr valign='top'>
    <td align='left' ><input type='button' name='cancel' value='"._CANCEL."' onclick='"._LEXCST_URL_ADMIN."'></td>
    <td align='left' ><input type='button' name='addNewCat' value='"._LEX_AD_CAT_ADD."' onclick='".$linkAddCat."'></td>
    <td align='left' ><input type='button' name='addDelCat' value='"._LEX_AD_CAT_REMOVE."' onclick='".$linkAddDel."'></td>
                                                        

    
    
    <td align='right'><input type='submit' name='submit' value='"._LEX_AD_FREE."'></td>
  </tr>
  </form>";





  
?>
