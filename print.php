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



include_once ("header.php");
include_once (XOOPS_ROOT_PATH."/header.php");
include_once (XOOPS_ROOT_PATH."/class/xoopsformloader.php");

//-----------------------------------------------------------------------------------
global $xoopsModule;
include_once (XOOPS_ROOT_PATH."/modules/".$xoopsModule->getVar('dirname')."/include/constantes.php");
//-----------------------------------------------------------------------------------
include_once (_LEX_ROOT_JJD."functions.php");
include_once (_LEX_ROOT_PATH."include/category_functions.php");
include_once (_LEX_ROOT_PATH."include/seealso_function.php");


//$id = $_GET["id"];
//-------------------------------------------------------------
$vars = array(array('name' =>'op',        'default' => ''),
              array('name' =>'idLexique', 'default' => 0),
              array('name' =>'id',        'default' => 0),
              array('name' =>'pinochio',  'default' => false));
              
require (_LEX_JJD_PATH."include/gp_globe.php");
//-------------------------------------------------------------
global $libelle;
getLexInfo ($idLexique, $info, 'submit');
getCaption ($info['idCaption'], $libelle);

$currenttheme = getTheme();
/*
$sql = "SELECT name, shortDef, definition1, definition2, definition3, seeAlsoList "
      ." FROM ".$xoopsDB->prefix(_LEX_TBL_TERME)
      ." where idTerme=".$id;
$result = $xoopsDB->query($sql);
list($name, $shortDef, $definition1, $definition2, $definition3,$seeAlsoList) = $xoopsDB->fetchRow($result);

$seealsoTerme = getSeeAlsoName($seeAlsoList, $id, " - "); 






$myts =& MyTextSanitizer::getInstance();    
$name = $myts->makeTboxData4Show($name, 1);

$definition1 = $myts->makeTareaData4Show($definition1, "1", "1", "1");
$definition2 = $myts->makeTareaData4Show($definition2, "1", "1", "1");
$definition3 = $myts->makeTareaData4Show($definition3, "1", "1", "1");

$shortDef = $myts->makeTareaData4Show($shortDef, "1", "1", "1");
*/

displayListeTerme ("*", "idTerme={$id}", "idTerme desc", 
                      $limite,  $info['nbmsgbypage'], false,
                      $myts, $xoopsTpl, false, $info);

echo "
<html>
<head><title>".$xoopsConfig['sitename']."</title>
<LINK REL=\"StyleSheet\" HREF=\"../../themes/".$currenttheme."/style/style.css\" TYPE=\"text/css\">
</head>";

echo "
<body bgcolor=\"#FFFFFF\" text=\"#000000\" onload="javascript:window.print()">
<table border=0><tr><td>
<table border=0 width=640 cellpadding=0 cellspacing=1 bgcolor=\"#000000\"><tr><td>
<table border=0 width=640 cellpadding=20 cellspacing=1 bgcolor=\"#FFFFFF\"><tr><td>
<center><img src=\""._LEX_URL."logovd.gif\" border=0 alt=\"\"></center><P><br />
<font size=2><b>".$libelle[_LEX_LANG_TERME2].": </b> $name : </b> $shortDef<P>
<font size=2><b>".$libelle[_LEX_LANG_DEFINITION1].": </b> $definition1<P><P>
<font size=2><b>".$libelle[_LEX_LANG_DEFINITION2].": </b> $definition2<P><P>
<font size=2><b>".$libelle[_LEX_LANG_DEFINITION3].": </b> $definition3<P><P>
<font size=2><b>".$libelle[_LEX_LANG_FAMILY].": </b> $definition3<P><P>
<font size=2><b>"._MI_LEX_SEEALSO2.": </b> $seealsoTerme<P><P>

"
;


//----------------------------------------------------------------------------
echo "
<br /><br />
</td></tr></table></td></tr></table>
<br /><br /><center>"._MD_LEX_EXTRDIC." ".$xoopsConfig['sitename']." :<br />
<a href=\"".XOOPS_URL.""._LEXCST_DIR_ROOT."\">".$xoopsConfig['xoops_url'].""._LEXCST_DIR_ROOT."</a>
</td></tr></table>
</body>
</html>
";
?>
