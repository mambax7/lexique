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
global $xoopsModule;
//include_once (XOOPS_ROOT_PATH."/modules/".$xoopsModule->getVar('dirname')."/include/constantes.php");
//include_once (XOOPS_ROOT_PATH."/modules/lexique/include/constantes.php");
//-----------------------------------------------------------------------------------
include_once (_LEX_ROOT_JJD."functions.php");

function lexique_show_new($options) {
	global $xoopsDB;
	$block = array();
	$numDef = $options[0];

	
	$result = $xoopsDB->query("SELECT idTerme, name "
                            ." FROM ".$xoopsDB->prefix(_LEX_TBL_TERME)."  "
                            ." WHERE state = '"._LEX_STATE_OK."' "
                            ." ORDER BY idTerme desc LIMIT 0, {$numDef}");
                            
                            

	while($dic_def = $xoopsDB->fetcharray($result)) {
		$def = array();
		$def['id'] = $dic_def['idTerme'];
		$def['name'] = $dic_def['name'];
		
		$block['def'][] = $def;
	}
        return $block;
}

/************************************************************************
 *
 ************************************************************************/
 
function numDef_edit($options) {
	$form  = "<table border='0'>";
	$form .= "<tr><td>"._MB_LEX_NUMSDEF."</td><td>";
	$form .= "<input type='text' name='options[0]' size='16' value='".$options[0]."'></td></tr>";
	$form .= "</td></tr>";
	$form .= "</table>";
	return $form;
}
?>
