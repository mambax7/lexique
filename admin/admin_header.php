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


include_once ('../../../include/cp_header.php');
include_once (XOOPS_ROOT_PATH."/include/xoopscodes.php");
include_once ("../include/constantes.php");

if ( $xoopsUser ) {
	$xoopsModule = XoopsModule::getByDirname(_LEX_DIR_NAME);
	if ( !$xoopsUser->isAdmin($xoopsModule->mid()) ) {
		redirect_header(XOOPS_URL."/",3,_AD_LEX_NOPERM);
    exit();
	}
} else {
	redirect_header(XOOPS_URL."/",3,_AD_LEX_NOPERM);
	exit();
}


//---------------------------------------------------------------------

include_once (_LEX_JJD_PATH.'include/version.php');
include_once (_LEX_JJD_PATH.'include/functions.php');
include_once (_LEX_JJD_PATH.'include/constantes.php');
include_once (_LEX_JJD_PATH.'include/html_functions.php');
include_once (_LEX_JJD_PATH.'include/editor_functions.php');
include_once (_LEX_JJD_PATH.'include/strbin_function.php');

include_once (_LEX_JJD_PATH.'include/adminOnglet/adminOnglet.php');
include_once (_LEX_JJD_PATH.'include/spin/spin.php');
//----------------------------------------------------------------
include_once (_LEX_ROOT_PATH."include/lexique_function.php");
include_once (_LEX_ROOT_PATH."include/category_functions.php");
include_once (_LEX_ROOT_PATH."include/seealso_function.php");
include_once (_LEX_ROOT_PATH."include/seealso_function.php");






?> 
