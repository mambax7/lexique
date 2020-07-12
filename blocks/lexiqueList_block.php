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
//include_once ("header.php");
global $xoopsModule;

//-----------------------------------------------------------------------------------
global $xoopsModule;
//echo XOOPS_ROOT_PATH."/modules/".$xoopsModule->getVar('dirname')."/include/constantes.php";
//include_once (XOOPS_ROOT_PATH."/modules/lexique/include/constantes.php");
//include_once (dirname(__FILE__)."/../include/constantes.php");
//-----------------------------------------------------------------------------------
include_once (_LEX_ROOT_JJD."functions.php");


//include_once (_LEX_ROOT_INCLUDE."lexique_function.php");
include_once (XOOPS_ROOT_PATH.'/modules/lexique/include/'."lexique_function.php");

function lexiqueList_show($options) {
	global $xoopsDB;
	
	$block = array();
	$numDef = $options[0];
	
	//-----------------------------------------------------	
		$def = array();	
		$def['idLexique'] = 0;
		
		/***************************************************************
		 a remplacer par
		$copyright = getCopyright2('lexique', 'xoops.kiolo.com', 'J°J°D');
    quand jjd_tools sera mis à jour		      		
		 ****************************************************************/		
		$module = XoopsModule::getByDirname('lexique');
    $n = $module->vars['name']['value'];    
    $v = number_format($module->vars['version']['value'] / 100, 2, '.', ' ');
    $i = 'J°J°D';
    $cr = "{$n}-{$v}-{$i}";
		$copyright = $cr;
    //-------------------------------------------------------------------

		$def['name'] = "<span title='{$copyright}'><b>"._MB_LEX_LEXIQUES."</b></span>";
		//$def['icone'] = '../images/icones/view.gif';	
		$def['icone'] = getLexIcone ('livre1.gif');    	
		//--------------------------------------------
		$block['def'][] = $def;	
	//-----------------------------------------------------
	$sql = "SELECT idLexique, name, icone "
        ." FROM ".$xoopsDB->prefix(_LEX_TBL_LEXIQUE)
        ." WHERE actif = 1"
        ." ORDER BY ordre, name";
	$result = $xoopsDB->query($sql);

	while($dic_def = $xoopsDB->fetcharray($result)) {
	 if (cb_isLexiqueOk($dic_def['idLexique']) == 0) continue;
		$def = array();
		//--------------------------------------------		
		$def['idLexique'] = $dic_def['idLexique'];
		$def['name'] = $dic_def['name'];
		//$def['icone'] = "<img src='"._LEX_URL_LEXICONES.$dic_def['icone']."' border=0 Alt='' width='20' height='20' ALIGN='absmiddle'>";
		$def['icone'] = getLexIcone ($dic_def['icone']);
		//--------------------------------------------
		$block['def'][] = $def;
	}
	
	//displayArray2($block,'---Block---'.$sql);
  return $block;
}

/************************************************************************
 *
 ************************************************************************/
function lexiqueList_edit($options) {
	$form  = "<table border='0'>";
	$form .= "<tr><td>"._MB_LEX_LEXIQUES."</td><td>";
	$form .= "<input type='text' name='options[0]' size='16' value='".$options[0]."'></td></tr>";
	$form .= "</td></tr>";
	$form .= "</table>";
	return $form;
}
?>
