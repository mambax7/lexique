<?php
//  ------------------------------------------------------------------------ //
//            LEXIQUE - Module de gestion de lexiques pour XOOPS             //
//                    Copyright (c) 2006 JJ Delalandre                       //
//                       <http://kiolo.com>                                  //
//  ------------------------------------------------------------------------ //
/******************************************************************************

Module LEXIQUE version 1.6.2 pour XOOPS- Gestion multi-lexiques 
Copyright (C) 2007 Jean-Jacques DELALANDRE 
Ce programme est libre, vous pouvez le redistribuer et/ou le modifier selon les termes de la Licence Publique GTnTrale GNU publiTe par la Free Software Foundation (version 2 ou bien toute autre version ultTrieure choisie par vous). 

Ce programme est distribuT car potentiellement utile, mais SANS AUCUNE GARANTIE, ni explicite ni implicite, y compris les garanties de commercialisation ou d'adaptation dans un but spTcifique. Reportez-vous a la Licence Publique GTnTrale GNU pour plus de dTtails. 

Vous devez avoir retu une copie de la Licence Publique GTnTrale GNU en mOme temps que ce programme ; si ce n'est pas le cas, Tcrivez a la Free Software Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307, +tats-Unis. 

DerniFre modification : juin 2007 
******************************************************************************/

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

if (! $xoopsUser ) {
	redirect_header(XOOPS_URL."/",3,_AD_LEX_NOPERM);
	exit();
}

//-------------------------------------------------------------
$vars = array(array('name' =>'op',          'default' => ''),
              array('name' =>'idLexique',   'default' => 0),
              array('name' =>'name',        'default' => ''),              
              array('name' =>'definition1', 'default' => ''),              
              array('name' =>'definition2', 'default' => ''),              
              array('name' =>'definition3', 'default' => ''),              
              array('name' =>'shortDef',    'default' => ''),              
              array('name' =>'seealso',     'default' => ''),              
              array('name' =>'logname',     'default' => ''),              
              array('name' =>'list_status', 'default' => 0),   
              array('name' =>'letter',      'default' => ''),
              array('name' =>'validation',  'default' => ''),                                       
              array('name' =>'pinochio',    'default' => false));
  
  
             
require (_LEX_JJD_PATH."include/gp_globe.php");
//-------------------------------------------------------------
getLexInfo ($idLexique, $info, 'submit');
getCaption ($info['idCaption'], $libelle);

include_once ("include/seealso_function.php");

include_once (XOOPS_ROOT_PATH."/class/xoopsformloader.php");
$xoopsOption['template_main'] = 'lexique_submit.html';

include_once (XOOPS_ROOT_PATH.'/class/pagenav.php');

//---------------------------------------------------------------

$myts =& MyTextSanitizer::getInstance();


/**************************************************************************
 * Le formulaire … ‚t‚ valider selon, l'enregistrement emis … jour ou ajoutT
 **************************************************************************/
      $logName = $xoopsUser->getVar("uname", "E"); 
if (!empty($_POST['submit'])){

  //--------------------------------------------------------------------
  //CAPCHA - sucurityimage de dugris
  //--------------------------------------------------------------------  
  if ( defined('SECURITYIMAGE_INCLUDED') 
      && !SecurityImage::CheckSecurityImage() 
      && ($xoopsModuleConfig['capcha_terme'] == 1)) {
       //redirect_header( 'history.go(-1)', 2,  ) ;
       redirect_header("index.php?idLexique={$idLexique}",2, _SECURITYIMAGE_ERROR);
       exit();
  }{
    //echo "<hr>non<hr>";
  }
  //--------------------------------------------------------------------

	$name = $myts->makeTboxData4Save($name);
	
	//isBitOk($i, $info['dooptions']))
	$definition1 = $myts->addSlashes($definition1);
	$definition2 = $myts->addSlashes($definition2);	
	$definition3 = $myts->addSlashes($definition3);	
    

    $dooptions   = checkBoxToBin($gepeto, 'dooptions',    $def, '1');  
    $dohtml      = checkBoxToBin($gepeto, 'dohtml',       $def, '1');    
    $dosmiley    = checkBoxToBin($gepeto, 'dosmiley',     $def, '1');  
    $doxcode     = checkBoxToBin($gepeto, 'doxcode',      $def, '1');  
    $doimage     = checkBoxToBin($gepeto, 'doimage',      $def, '1');    
    $dobr        = checkBoxToBin($gepeto, 'dobr',         $def, '1');  
      
//displayArray ($gepeto, "----------update--bdooptions={$dooptions}-----------");
    //$dooptions   = 7;	
	/*

	$definition1 = $myts->makeTareaData4Save($definition1);
	$definition2 = $myts->makeTareaData4Save($definition2);	
	$definition3 = $myts->makeTareaData4Save($definition3);	
    */	
    
	$shortDef = $myts->makeTareaData4Save($shortDef);  
  $statenum    =  $list_status; //$_POST ['list_status']; 
  $state = substr(_LEX_STATE_LIST, $statenum, 1);      
  //******************************************************************
  $letter = getFirstLetter ($name);
  $tcat = getArrayOnPrefix ($_POST, 'chk_');
  $category = array2BinStr ($tcat);
  $tempCategory = getLibCategories($info['idFamily'], $category);  
  
  $id = $_GET ['id'];
  $newDate = date("y-m-d"); 
  
  //---------------------------------------------------------------------
  // Hack permettant l'utilisation avec le module Xoops Tag
  //---------------------------------------------------------------------  
     $f = _LEX_ROOT."modules/tag/include/formtag.php";
     //echo "<hr>{$f}<hr>";     
     if (is_readable($f)){
      $tag_handler = xoops_getmodulehandler('tag', 'tag');
      $tag_handler->updateByItem($_POST["item_tag"], $id, $xoopsModule->getVar("dirname"), $idLexique);
     
     }


   
    
    //---------------------------------------------------------------------    
    
    if ($id > 0) {
          
      if ($info['seealsomode']==0) {
        $seeAlsoList = $seealso;      
      }
      else {
          $seeAlsoList = getTemp (_LEX_TBL_TERME, "seeAlsoList", $id, false);      
      }   
      
      if (!isset($chkReferentiel)){$chkReferentiel = '';}       
      $ref = ($chkReferentiel == 'on')?'1':'0';      

      $sql = "UPDATE ".$xoopsDB->prefix(_LEX_TBL_TERME)." SET "
           ."letter = '".strtoupper($name{0})."' , "
           ."name = '{$name}' , "
           ."shortDef = '{$shortDef}' , "
           ."definition1 = '{$definition1}', "
           ."definition2 = '{$definition2}', "           
           ."definition3 = '{$definition3}', "           
           ."seeAlsoList = '{$seeAlsoList}', "
           ."state       = '{$state}', "
           ."category    = '{$category}', "
           ."tempCategory   = '{$tempCategory}', "           
           ."reference      = ".$ref.', '
           ."templink       = '', "
           ."dateModification = '{$newDate}', "      
           ."dateState  = 0,"   
           ."user       = '{$logName}', " 
           ."dooptions  = {$dooptions}, "           
           ."dohtml     = {$dohtml}, "           
           ."dosmiley   = {$dosmiley}, "           
           ."doxcode    = {$doxcode}, "    
           ."doimage    = {$doimage}, "             
           ."dobr       = {$dobr} "                
           ."  WHERE idTerme   = {$id} "
           ."    AND idLexique = {$idLexique}";
           
       $pp = getArrayKeyOnPrefix ($_POST, 'property_');
       setPropertyList($pp , $info['idProperty'] ,$id );   
     
      
          	    
          $xoopsDB->query($sql);

          $seeAlsoList = '';
          synchroniseSeeAlso($id, $seeAlsoList );
          killTemp (_LEX_TBL_TERME, $id);
          
          lex_envoyerMail (_MD_LEX_MAIL_DEF_UPDATED, $name, $id, $shortDef, $definition1);//z01
    } 
    else {
      if ($id < 0) {
          $idSeeAlso =  getNewIdTerme ($idLexique);
          $seeAlsoList = getTemp (_LEX_TBL_TERME, "seeAlsoList", $id);
          killTemp (_LEX_TBL_TERME, $id, "");
      }else{
        $idSeeAlso =  getNewIdTerme ($idLexique);   
      }
     $state = 'O';      
      //-----------------------------------------------------
      $tSql [] = "INSERT INTO ".$xoopsDB->prefix(_LEX_TBL_TERME);
      $tSql [] = "(idLexique, idSeeAlso, letter, name, shortDef, "
                ."definition1, definition2, definition3, seeAlsoList, state, "
                ."category, tempCategory, user, "
                ."dateCreation, dateModification, dateState,"
                ."dooptions,dohtml,dosmiley,doxcode,doimage,dobr)";
      $tSql [] = " VALUES ($idLexique, $idSeeAlso, '$letter', '$name', '$shortDef', "
              ."'$definition1', '$definition2', '$definition3', '$seeAlsoList', '$state', "
              ."'$category', '$tempCategory', '$logName', "
              ."'$newDate', '$newDate', 0, "
              ."$dooptions,$dohtml,$dosmiley,$doxcode,$doimage,$dobr)";
      $sql = implode(" ", $tSql);
    	$xoopsDB->query($sql);
      
       $idTerme = $xoopsDB->getInsertId() ;
       $pp = getArrayKeyOnPrefix ($_POST, 'property_');
       setPropertyList($pp , $info['idProperty'] , $idTerme);      
       lex_envoyerMail (_MD_LEX_MAIL_DEF_NEW, $name, $id, $shortDef, $definition1);//z01
    }

  	//-----------------------------------------------------
    clearIntrusion();

  	//-----------------------------------------------------
  	if ($validation == 'ok'){
    	redirect_header("admin/index.php",1,""._MD_LEX_YOSUBREG."");    
    }else{
    	redirect_header("index.php?idLexique=$idLexique",1,""._MD_LEX_YOSUBREG."");    
    }

} 
/**************************************************************************
 * Le formulaire a TtT annulT destruction des data temporaires
 **************************************************************************/
elseif (!empty($_POST['reset'])){
    $id = $_GET['id'];
    killTemp (_LEX_TBL_TERME, $id, "");

  	
  	if ($validation == 'ok'){
    	redirect_header("admin/index.php");    
    }else{
  	  redirect_header("index.php?idLexique=$idLexique");    	
    }
  	
}

/**************************************************************************
 * Le formuaire est editer en modif ou en ajout
 **************************************************************************/
else {

  //--------------------------------------------------------------------
  //CAPCHA - sucurityimage de dugris
  //--------------------------------------------------------------------  
  $xoopsTpl->assign('capchaOk', $xoopsModuleConfig['capcha_question']);
  if (defined('SECURITYIMAGE_INCLUDED') AND ($xoopsModuleConfig['capcha_terme'] == 1)) {
    
  	$security_image = new SecurityImage( _SECURITYIMAGE_GETCODE );
    $xoopsTpl->assign('capcha',    $security_image->render());
    $xoopsTpl->assign('capchaLib', _SECURITYIMAGE_GETCODE);
  }else{
    //$xoopsTpl->assign('capchaLib',    "bin non");
  }
  //--------------------------------------------------------------------
  // a revoir ya peut etre une faille de sTcutitT 
  //qui permet en tapant la ligne dans l'adresse d'acceder quand meme en modif ou en ajout
	if( true){
		if($xoopsUser) {
			$logname = $xoopsUser->getVar("uname", "E");
		} else {
			$logname = $xoopsConfig['anonymous'];
		}
	
   //-------------------------------------------------------------------	 
   //permet de revenir au panneau de configuration pour valider les expressions soumises	 
	 if (!isset($validation)){$validation=_NO;}
	 $xoopsTpl->assign('validation', $validation);	
   //-------------------------------------------------------------------
    	
    $xoopsTpl->assign('pathToolsJS',       _JJD_JS_TOOLS);
    $xoopsTpl->assign('pathLexToolsJS',    _LEX_JS_LEXIQUE);    	
    $xoopsTpl->assign('pathCateRequestJS', _LEX_JS_CATEGORY);    	

		$definition1 = '';		
		$definition2 = '';
		$definition3 = '';

        $dooptions  = $info['dooptions'] ;
        $dohtml     = $info['dohtml'] ;        
        $dosmiley   = $info['dosmiley'] ;      
        $doxcode    = $info['doxcode'] ;  
        $doimage    = $info['doimage'] ;
        $dobr       = $info['dobr'] ;
                
		
       
       
$id = ((isset($_GET['id'])) ? $_GET['id'] : 0 );
//displayArray($info,"--info--id = {$id}--dooptions = {$dooptions}-------");


$letter = array_key_exists("letter",$_GET)?$_GET["letter"]:'';
$limite = array_key_exists("limite",$_GET)?$_GET["limite"]:0;
		
    //------------------------------------------------------
    if ($id > 0) {
      $sql= "SELECT * FROM ".$xoopsDB->prefix(_LEX_TBL_TERME)." WHERE idTerme = ".$id;
		//$xoopsTpl->assign('name', $id);
		  $sqlquery = $xoopsDB->query($sql);
      //jjd_echo ( $sql."submit = ".$xoopsDB->getRowsNum($sqlquery));
		  //$id = $sqlfetch["id"];
		  $sqlfetch=$xoopsDB->fetchArray($sqlquery);
//displayArray($sqlfetch, '----------submit------------');		  
		  //----------------------------------------------------
      $xoopsTpl->assign('name', $sqlfetch['name']);
      $xoopsTpl->assign('shortDef', $sqlfetch['shortDef']);
      $xoopsTpl->assign('idSeeAlso', $sqlfetch['idSeeAlso']);  
      
      //----------------------------------------------------------      
      $list =  array(_MI_LEX_STAT_OK,
                     _MI_LEX_STAT_BLOCKED,
                     _MI_LEX_STAT_INWAITING,
                     _MI_LEX_STAT_ASK);  
                                
      //$i = stripos(_LEX_STATE_LIST, $sqlfetch['state']);   
      $i = strpos(_LEX_STATE_LIST, $sqlfetch['state']);                             
      $listBox = buildHtmlList('list_status', $list, $i);
                         
      $xoopsTpl->assign('list_status', $listBox);
      //----------------------------------------------------------         
	  	$xoopsTpl->assign('category', getCheckedCategoryBinStr ('category', $id, $idLexique, $info['idFamily']));
    
     $xoopsTpl->assign('refchecked',( $sqlfetch['reference']==1)?'checked':'unchecked');
	  	
      $definition1 = $sqlfetch['definition1'];
      $definition2 = $sqlfetch['definition2'];
      $definition3 = $sqlfetch['definition3'];    
      
      //$dooptions   = $sqlfetch['dooptions'];
      $dooptions  = $info['dooptions'] ;      
      //echo "<hr>{$dooptions}<hr>";
      $dohtml      = $sqlfetch['dohtml'];      
      $dosmiley    = $sqlfetch['dosmiley'];      
      $doxcode     = $sqlfetch['doxcode'];  
      $doimage     = $sqlfetch['doimage'];      
      $dobr        = $sqlfetch['dobr'];
                  
      $libelle['add'] = _SUBMIT;

      //----------------------------------------------------------------------
      
      saveTemp    (_LEX_TBL_TERME, "seeAlsoList;name;definition1;definition2;definition3;shortDef;reference;dooptions;dohtml;dosmiley;doxcode;doimage;dobr", "idTerme",  $id);
      saveTemp    (_LEX_TBL_TERME, "seeAlsoList", "idTerme",  $id, false, "seealsoid_old");
      saveTemp    (_LEX_TBL_TERME, "category", "idTerme",  $id, false);      
      $seeAlsoList = replaceSeparator(getTemp(_LEX_TBL_TERME, "seeAlsoList", $id), ",");
      
      //force $dooptions a la valeur du lexique 
      //setTemp(_LEX_TBL_TERME, 'dooptions', $dooptions, idTerme, $id);       
//----------------------------------------------------------------------
    }
    elseif ($id < 0)  {

      $seeAlsoList = replaceSeparator(getTemp(_LEX_TBL_TERME, "seeAlsoList", $id), ",");
      $xoopsTpl->assign('category', getCheckedCategoryBinStr ('category', -1, $idLexique, $info['idFamily']));
      $libelle['add'] = _ADD;
    }
    else  {
      $id = getNewIdTemp (_LEX_TBL_TERME, "");

      setTemp(_LEX_TBL_TERME, 'dooptions', $dooptions, 'idTerme', $id);
      setTemp(_LEX_TBL_TERME, 'dohtml',    $dohtml,    'idTerme', $id);      
      setTemp(_LEX_TBL_TERME, 'dosmiley',  $dosmiley,  'idTerme', $id);      
      setTemp(_LEX_TBL_TERME, 'doxcode',   $doxcode,   'idTerme', $id);      
      setTemp(_LEX_TBL_TERME, 'doimage',   $doimage,   'idTerme', $id);      
      setTemp(_LEX_TBL_TERME, 'dobr',      $dobr,      'idTerme', $id);
            
      $seeAlsoList = "";
      $xoopsTpl->assign('category', getCheckedCategoryBinStr ('category', -1, $idLexique, $info['idFamily']));
      $libelle['add'] = _ADD;
    }
    //------------------------------------------------------
    
    /*****************************************************************
     * construction de 2 requetes
     * une pour compter le nombre d'enregistrement pour la lettre sTlTctionnTe
     * l'autre pour selectioner une page de la lettre sTlTctionnTe  
     *****************************************************************/
    $table = $xoopsDB->prefix(_LEX_TBL_TERME);
    $clauseOrder = " ORDER BY name ";
    $clauseLimit = " LIMIT ".intval($limite).",".$info['nbtermebypage']; 
    

    if ($seeAlsoList=="") $seeAlsoList='';     //'0'
    
    $clauseWhere = " WHERE idLexique = {$idLexique} ";
    //------------------------------------------------------
    if ($letter==''){
      $clauseIn = ($seeAlsoList == '')?'':" AND idSeeAlso IN ({$seeAlsoList}) ";
      $clauseWhere .= " AND state='"._LEX_STATE_OK."' {$clauseIn} AND idTerme <> {$id}";
    
      $sql = "SELECT * from ".$table.$clauseWhere.$clauseOrder." limit ".intval($limite).",{$info['nbtermebypage']}"; 
      $sqlCount = "SELECT count(*) as nbmsg from ".$table.$clauseWhere;
    }
    else{
      $clauseWhere .= " AND state='"._LEX_STATE_OK."' AND name like '{$letter}%' AND idTerme <>".$id;
      
      $sql = "SELECT * from ".$table.$clauseWhere.$clauseOrder." limit ".intval($limite).",".$info['nbtermebypage'];
      $sqlCount = "SELECT count(*) as nbmsg from ".$table.$clauseWhere;

    }


    /*------------------------------------------------------------------
    -------------------------------------------------------------------*/
    $sqlqueryCount=$xoopsDB->query($sqlCount);
    $sqlfetchCount=$xoopsDB->fetchArray($sqlqueryCount);
    $nbmessage=$sqlfetchCount["nbmsg"];
    $pagenav = new XoopsPageNav($nbmessage, $info['nbtermebypage'], $limite, "limite", "letter=$letter&id=$id"."&idLexique=$idLexique");
    $xoopsTpl->assign('dic_page_nav', $pagenav->renderNav());
    $xoopsTpl->assign('seelist', "<A href='submit.php?id={$id}&idLexique={$idLexique}&letter=&limit=0'>"._MI_LEX_LIST_SELECTED_TERMES."</A>");
    $xoopsTpl->assign('refSeeAlsoo', _LEX_URL."include/lex_seealso.php?id=".$id);
    $xoopsTpl->assign('refSeeAlsoo', _LEX_URL_INCLUDE."lex_seealso.php?id=".$id);

    $xoopsTpl->assign('name',       getTemp (_LEX_TBL_TERME, 'name', $id));
    $xoopsTpl->assign('shortDef',   getTemp (_LEX_TBL_TERME, 'shortDef', $id));
    $xoopsTpl->assign('reference',  getTemp (_LEX_TBL_TERME, 'reference', $id));

    
    
    $definition1 = getTemp (_LEX_TBL_TERME, 'definition1', $id);    
    $definition2 = getTemp (_LEX_TBL_TERME, 'definition2', $id);    
    $definition3 = getTemp (_LEX_TBL_TERME, 'definition3', $id);    

    $dooptions  = getTemp (_LEX_TBL_TERME, 'dooptions', $id);
    $dosmiley   = getTemp (_LEX_TBL_TERME, 'dosmiley', $id);      
    $dohtml     = getTemp (_LEX_TBL_TERME, 'dohtml', $id);      
    $doxcode    = getTemp (_LEX_TBL_TERME, 'doxcode', $id); 
    $doimage    = getTemp (_LEX_TBL_TERME, 'doimage', $id);     
    $dobr       = getTemp (_LEX_TBL_TERME, 'dobr', $id);    
    //-----------------------------------------------------------------
//echo "<hr>id = {$id}--dooptions = {$dooptions}<hr>";
    /***************************************************************************
     * selection des terme correspondant … la page et … la letre selection‚e
     * et affichage en cochant la case si dans la liste de seeAlsoList 
     ***************************************************************************/
      $tSeealsoid = explode (",", $seeAlsoList);

    displayListeTerme ("*", $clauseWhere, $clauseOrder, 
                       $limite,  $info['nbtermebypage'], false,
                       $myts, $xoopsTpl, $tSeealsoid, $info);


    // fin de la construction de see-also
    //--------------------------------------------------------------------------
    
    $xoopsTpl->assign('id', $id);
    $xoopsTpl->assign('detailShowButtons',     $info['detailShowButtons']);
    //$xoopsTpl->assign('detailShowId', $info['detailShowId']);
    $xoopsTpl->assign('detailShowId', $info['access']['buttonBin'][_LEX_BYTE_SHOWOPTION]);




    $xoopsTpl->assign('letterbar', letterBar("submit.php", "letter", "limite", 
                      0, " ", "id=".$id, $letter, 
                      "gotoLetter", 
                      _LEX_URL_INCLUDE."lex_seealso_temp.php", $idLexique));
    $xoopsTpl->assign('seeAlsoList', $seeAlsoList);
    $seealso  = getSeeAlsoName($seeAlsoList, $id, " - ");
    $xoopsTpl->assign('seealso', $seealso);
    $xoopsTpl->assign('type_seealsoid',($info['access']['buttonBin'][_LEX_BYTE_SHOWOPTION] ==1)?"text":"hidden");    
    
    
     //--------------------------------------------------------   
     $tDef = array();
     $editor = (($info['editor'] == 99) ? $xoopsModuleConfig['editor'] : $info['editor']) ;     
     
      for ($h = 1; $h < 4 ; $h++) {
          $def = array();       
          $def['index'] = $h;      
          $detailShowDefinition = ($info['detailShowDefinition'] & pow(2,$h-1));   
          $def['detailShowDefinition'] = $detailShowDefinition;
          
          if ($detailShowDefinition <> 0 ){
              $def['libelle']  = $libelle['definition'.$h];
              $name = "definition{$h}";
              //$text = $myts->previewTarea($$name,)   
              $text = $myts->htmlSpecialChars($$name);                        
              $desc1 = getEditorHTML($editor, $text, $name, 'Texte', '80%', '200px', 8, 69 );
 		      $def['desc'] = $desc1->render();       
               
		      $i = $h-1;  
              $def['doindex']    = $i;                           
              //$def['dooptions']  = isBitOk($i, $dooptions);
              $def['dooptions']  = isBitOk($i, $info['dooptions']);               
              $def['dohtml']     = isBitOk($i, $dohtml); 
              $def['dosmiley']   = isBitOk($i, $dosmiley); 
              $def['doxcode']    = isBitOk($i, $doxcode); 
              $def['doimage']    = isBitOk($i, $doimage); 
              $def['dobr']       = isBitOk($i, $dobr); 
                    
          }
          //$tDef[$h] = $t;   
          $tDef[] = $def;                 
      } 
      
     //--------------------------------------------------------
     // Hack permettant l'utilisation avec le module Xoops Tag  
     //--------------------------------------------------------   
     $f = _LEX_ROOT."modules/tag/include/formtag.php";
     //echo "<hr>{$f}<hr>";     
     if (is_readable($f)){
       include_once _LEX_ROOT."modules/tag/include/formtag.php";
       $xoopsTpl->assign('tag_ok', 1); 
       $xoopsTpl->assign('tag_lib', "Tag");      
       $z = new XoopsFormTag("item_tag", 90, 255, $id, $idLexique);
       $xoopsTpl->assign('tag_list', $z->render() );        
     }else{
       $xoopsTpl->assign('tag_ok', 0);     
     }
       
     //--------------------------------------------------------
     // ajout des proprietes
     //--------------------------------------------------------   
         if ($info['idProperty'] > 0){
             $pr = getPropertyList($info['idProperty'] ,$id , $propertyName);
             $xoopsTpl->assign('dic_postp', $pr);    
        
        }
        //--------------------------------------------------------      
    
     //--------------------------------------------------------
     // ajout des fichier attachTs
     //--------------------------------------------------------   
     $fff = new XoopsFormFile("zzzzzzzzzzzzzz","dddddddddddd",30000);
     $fff->setExtra("size='20'");
	$xoopsTpl->assign('formFile',   $fff->render() );     
    		
	} 
	/*****************************************************************
	 * l'utilisteur n'a pas les droits, il est redirigT	
	 *****************************************************************/	
  else {
		redirect_header("../../register.php",1,""._MD_LEX_MEMBERONLY."");
	}
	
	
	//-------------------------------------------------------------
	//envoie des tableaux dans le templates
	//-------------------------------------------------------------
	$xoopsTpl->assign('info',    $info);	
	$xoopsTpl->assign('libelle', $libelle);	
	$xoopsTpl->assign('tDef',    $tDef);	
	
	
$xoopsTpl->assign('doActionMenu',    buildActionMenu(_LEXBTN_MENU0 & $info['access']['buttons']));
$xoopsTpl->assign('doActionBtn',     getButtonBar(_LEXBTN_TLB_MENU0 & $info['access']['buttons'], 0, $idLexique ));

//$xoopsTpl->assign('showMenuList',    $xoopsModuleConfig['showMenuList']);
$xoopsTpl->assign('showMenuList',    0);
$xoopsTpl->assign('showMenuBtn',     $xoopsModuleConfig['showMenuBtn']);
	
	//displayArray($tDef, '-----tDef-----------------');
	
    include(XOOPS_ROOT_PATH."/footer.php");
}


?>
