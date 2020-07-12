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

//-----------------------------------------------------------------------------------
global $xoopsModule;

include_once (XOOPS_ROOT_PATH."/modules/".$xoopsModule->getVar('dirname')."/include/constantes.php");
//-----------------------------------------------------------------------------------
include_once (_LEX_ROOT_JJD."functions.php");


$f = XOOPS_ROOT_PATH . "/class/xoopsform/securityimage.php";

if (is_readable($f)) {
  echo "<hr>{$f}<hr>";
  include_once($f);

}


  

include_once ("include/lexique_function.php");
include_once (XOOPS_ROOT_PATH."/class/xoopsformloader.php");
$xoopsOption['template_main'] = 'lexique_question.html';
include_once(XOOPS_ROOT_PATH."/header.php");

include_once ("include/temp_function.php");
include_once ("include/letterbar_function.php");
include_once ("include/category_functions.php");
include_once ("include/lexique_function.php");

getLexInfo ($idLexique, $info, 'submit');
getCaption ($info['idCaption'], $libelle);

$myts =& MyTextSanitizer::getInstance();

//-------------------------------------------------------------
$vars = array(array('name' =>'op',        'default' => ''),
              array('name' =>'idLexique', 'default' => 0),
              array('name' =>'pinochio',  'default' => false));
              
require (_LEX_JJD_PATH."include/gp_globe.php");
//-------------------------------------------------------------
global $xoopsModuleConfig, $xoopsDB;

if (!empty($_POST['submit'])) {

  //displayArray($gepeto,'-----question--------');
  //--------------------------------------------------------------------
  //CAPCHA - sucurityimage de dugris
  //--------------------------------------------------------------------  
  if ( defined('SECURITYIMAGE_INCLUDED') 
      && !SecurityImage::CheckSecurityImage() 
      && ($xoopsModuleConfig['capcha_question'] == 1)) {
    echo "<hr>oui<hr>";
       //redirect_header( 'history.go(-1)', 2,  ) ;
       redirect_header("index.php?idLexique={$idLexique}",2, _SECURITYIMAGE_ERROR);
       exit();
  }{
    //echo "<hr>non<hr>";
  }
  //--------------------------------------------------------------------
/*

    [state] => D
    [logname] => 
    [idLexique] => 1
    [name] => ddddddddddddd
    [submit] => Envoyer la Demande
    [op] => submit
    [pinochio] => 
*/  
  //-------------------------------------------------------------------
  $name = $gepeto['name'];
	$name = $myts->makeTboxData4Save($name);

  $shortDef = $name;
  $definition1 = $name;
  $letter = getFirstLetter ($name);
  $idSeeAlso =  getNewIdTerme ($idLexique);
  $logName = $xoopsUser->getVar("uname", "E");   
  $state = _LEX_STATE_ASK;
  
  $sql = "INSERT INTO ".$xoopsDB->prefix(_LEX_TBL_TERME)
        ." (idLexique, idSeealso, letter, name, state, user)"
        ." VALUES ({$idLexique},{$idSeeAlso},'{$letter}', '{$name}', '{$state}','{$logName}')";

	$xoopsDB->query($sql);
  $id = $xoopsDB->getInsertId();
  
	lex_envoyerMail (_MD_LEX_MAIL_DEF_ASKED, $name, $id, $shortDef, $definition1); //z01
	  	
	redirect_header("index.php",1,""._MD_LEX_YOREQREG."");

} else {
	if($xoopsUser) {
		$logname = $xoopsUser->getVar("uname", "E");
	} else {
		$logname = $xoopsConfig['anonymous'];
	}

  $xoopsTpl->assign('lexiqueList',     buildLexiqueList(''));
  
  //--------------------------------------------------------------------
  //CAPCHA - sucurityimage de dugris
  //--------------------------------------------------------------------  
  $xoopsTpl->assign('capchaOk', $xoopsModuleConfig['capcha_question']);
  if (defined('SECURITYIMAGE_INCLUDED') AND ($xoopsModuleConfig['capcha_question'] == 1)) {
    
  	$security_image = new SecurityImage( _SECURITYIMAGE_GETCODE );
    $xoopsTpl->assign('capcha',    $security_image->render());
    $xoopsTpl->assign('capchaLib', _SECURITYIMAGE_GETCODE);
  }else{
    //$xoopsTpl->assign('capchaLib',    "bin non");
  }
  //--------------------------------------------------------------------




	
	include(XOOPS_ROOT_PATH."/footer.php");
}
?>
