<?php
//  ------------------------------------------------------------------------ //
//  ------------------------------------------------------------------------ //
//       LEX - Module de gestion de tableau de bord                          //
//                    Copyright (c) 2006 JJ Delalandre                       //
//                       <http://xoops.kiolo.com>                            //
//  ------------------------------------------------------------------------ //
//  ------------------------------------------------------------------------ //
/******************************************************************************

******************************************************************************/

// General settings
global $xoopsModule;
include_once ("header.php");
//-----------------------------------------------------------------------------------
global $xoopsModule;
include_once (XOOPS_ROOT_PATH."/modules/".$xoopsModule->getVar('dirname')."/include/constantes.php");
//-----------------------------------------------------------------------------------

include_once (_LEX_ROOT_JJD."functions.php");
include_once (_LEX_ROOT_JJD."editor_functions.php");
include_once (_LEX_ROOT_JJD."strbin_function.php");

$f = XOOPS_ROOT_PATH . "class/xoopsform/securityimage.php";
if (is_readable($f)) include_once($f);


include_once (XOOPS_ROOT_PATH."/header.php");
include_once ("include/temp_function.php");
include_once ("include/letterbar_function.php");
include_once ("include/category_functions.php");
include_once ("include/lexique_function.php");
include_once ("include/constantes.php");

if (! $xoopsUser ) {
	redirect_header(XOOPS_URL."/",3,_AD_LEX_NOPERM);
	exit();
}


//-------------------------------------------------------------
$vars = array(array('name' =>'op',      'default' => ''),
	    	array('name' =>'rneorpseudo',   'default' => '2'),
		    array('name' =>'rne',           'default' => $xoopsUser->getVar('uname')),
        array('name' =>'pinochio',      'default' => false));
              
require (_LEX_JJD_PATH."include/gp_globe.php");
//-------------------------------------------------------------
$xoopsOption['template_main'] = 'lexique_loadFile.html';
getLexInfo ($idLexique, $info, 'submit');
getCaption ($info['idCaption'], $libelle);

$myts =& MyTextSanitizer::getInstance();
/*

if ($op == 'popup'){
		$link  = "javascript:openWithSelfMain('popup.php?mode=2&id={$idTerme}&idLexique={$info['idLexique']}','',500,600);";		
    redirect_header($link,1,'_AD_LEX_ADDOK');
    
exit;
}
*/

   //$xoopsTpl->assign('intlinkspopup',   $info['intlinkspopup']);
global    $xoopsModuleConfig;

$xoopsTpl->assign('info',    $info);	
$xoopsTpl->assign('libelle', $libelle);
//displayArray($info,'--------------------');
/*
*/

$xoopsTpl->assign('doActionMenu',    buildActionMenu(_LEXBTN_TLB_MENU0 & $info['access']['buttons']));
$xoopsTpl->assign('doActionBtn',     getButtonBar(_LEXBTN_TLB_MENU0 & $info['access']['buttons'], 0, $idLexique ));

$xoopsTpl->assign('showMenuList',    $xoopsModuleConfig['showMenuList']);
$xoopsTpl->assign('showMenuBtn',     $xoopsModuleConfig['showMenuBtn']);



/**********************************************************************
 *
 **********************************************************************/ 
function lexLoadFile ($p) {
global $xoopsModule, $xoopsDB,$xoopsTpl, $libelle;
    //********************************************************************************** 
    
    $idLexique = $p['idLexique'];
    $idTerme   = $p['id'];
    //**********************************************************************************
    //chargement des info du termes
    //echo "<hr>lexLoadFile-{$idLexique}-{$idTerme}<hr>";
    $sqlquery = selectTermes('*', "idTerme = {$idTerme}",  '', 0, 0, 0);
    $nbEnr = $xoopsDB->getRowsNum($sqlquery);
    //echo "<hr>nbenr = $nbEnr<hr>";
    $post = $xoopsDB->fetchArray($sqlquery);  
    $xoopsTpl->assign('post',  $post);      
    //displayArray($post,"---------$nbEnr----------");
    //---------------------------------------------------------------------    

    	
    //**********************************************************************************   
  //echo _JJD_JSI_TOOLS;
  //echo _JJD_JSI_SPIN;  
    
    //**********************************************************************************
    //$xoopsTpl->assign('title',     _MD_LEX_UPLOAD_FILE);
    $xoopsTpl->assign('idLexique', $idLexique);    
    $xoopsTpl->assign('id',   $idTerme);   
    
    $folder = lexGetFolder($idLexique, $idTerme);
    //$extention = _LEX_PREFIX_UPLOAD . '*.*';
    //echo "<hr>{$folder}<hr>";
    //$tFiles = getFileListH($folder, $extention = "", $level = 1);
    $tFiles = lexGetFiles($idLexique,$idTerme, _LEX_PREFIX_UPLOAD);    
    
    $nbFiles = count($tFiles);
    
    $xoopsTpl->assign('nbFiles',$nbFiles );    
    if ($nbFiles > 0){
      $nblines = ($nbFiles > 16)?16:$nbFiles;
        $t = array();
        $t[] = "<select size='{$nblines}' name='D1[]' multiple>";
        $lg = strlen($folder);
        for ($h = 0; $h < count($tFiles); $h++){
          $f = substr($tFiles[$h], $lg);
          $t[] = "<option value='{$f}'>{$f}</option>";    
        }
        $list[] = "</select>";
      
        $lstFiles =  implode("\n",$t)."\n";
      $xoopsTpl->assign('lstFiles',$lstFiles );        
        
    }
    



}



//-----------------------------------------------------------------
/*****************************************************************
 *
 *****************************************************************/
function lexTransfertFile($p, $fileUp){
  //displayArray($p,"---------- transfertFile ----------");
    //copy($p['fileup'], HER_ROOT_PATH."/pieces/{$p['fileup_name']}");

    $idLexique = $p['idLexique'];
    $idTerme   = $p['id'];
    $folder = lexGetFolder($idLexique, $idTerme);
    //**********************************************************************************    

    
    //$to = _HER_ROOT_PATH."pieces/{$p['name']}";
    $to = $folder._LEX_PREFIX_UPLOAD."{$idTerme}-{$fileUp['name']}";    
    //echo "<hr>to : {$to}<hr>";
    move_uploaded_file($fileUp['tmp_name'], $to);   
     
  $path = _LEX_ROOT_UPLOAD . "lex_{$idLexique}_{$idTerme}/";    
}

/*****************************************************************
 *
 *****************************************************************/
function lexDeleteFiles($p){
  //displayArray($p,"---------- deleteFiles ----------");

    $idLexique = $p['idLexique'];
    $idTerme   = $p['id'];
    $folder = lexGetFolder($idLexique, $idTerme);
    //**********************************************************************************    
    $tFiles = $p['D1'];  
  
    if (!is_array($tFiles)) return;
    if (count($tFiles) == 0) return;
    
    for ($h = 0; $h < count($tFiles); $h++)  {
    
      unlink ($folder.$tFiles[$h]);
    } 
    
}


//---------------------------------------------------------------------
//if (isset($gepeto['reloadStructure']))    {$op = "reloadStructure";} 
//if (isset($gepeto['saveEditBeforeSend'])) {$op = "saveEditBeforeSend";} 
if (isset($gepeto['ok']))     {$op = "ok";}
//--------------------------------------------------------------------   
//$bOk = ($op <> 'previewLetter');   
$bOk = true;
//if ($bOk){admin_xoops_cp_header(_HER_ONGLET_FILES, $xoopsModule);}   
$bolOk=false;
//displayArray($gepeto, '-------------------------');

switch($op) {
		
  case "delete":
    lexDeleteFiles($gepeto);
		lexLoadFile ($gepeto); 
  	$bolOk=true;       
   	break;
   	
   	
  case "ok":
    lexTransfertFile($gepeto, $_FILES['fileup']);
		
  case "listFiles":
	default:  

  	lexLoadFile($gepeto); 
  	$bolOk=true;
  	break;

}


//-------------------------------------------------------------  
if($bolOk){include_once (XOOPS_ROOT_PATH."/footer.php");}
//-------------------------------------------------------------





?>

