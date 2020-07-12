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

Vous devez avoir reçu une copie de la Licence Publique Générale GNU en même temps que ce programme ; si ce n'est pas le cas, écrivez à la Free Software Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307, +tats-Unis. 

Dernière modification : juin 2007 
******************************************************************************/


include_once ("admin_header.php");
global $xoopsModule;
include_once (XOOPS_ROOT_PATH."/modules/".$xoopsModule->getVar('dirname')."/include/constantes.php");
//-----------------------------------------------------------------------------------

define ("_PREFIX_NAME",       "name_");
define ("_PREFIX_ORDER",      "order_");
define ("_PREFIX_ACTIF",      "actif_");
define ("_PREFIX_ID",         "id_");
define ("_PREFIX_CATEGORIES", "categories_");

define ("_PREFIX_LIST",    _PREFIX_ID.";"
                          ._PREFIX_NAME.";"
                          ._PREFIX_ORDER.";"
                          ._PREFIX_ACTIF.";"
                          ._PREFIX_CATEGORIES);


//define ("_br", "<br>");
//echo "<hr>idLexique = {$idLexique}<hr>";
//-------------------------------------------------------------
$vars = array(array('name' =>'op',        'default' => 'list'),
              array('name' =>'idLexique', 'default' => 0),
              array('name' =>'idLettre',  'default' => 0),
              array('name' =>'id',        'default' => 0),
              array('name' =>'pinochio',  'default' => false));
              
require (_LEX_JJD_PATH."include/gp_globe.php");
//-------------------------------------------------------------
//echo "<hr>idLexique = {$idLexique}<hr>";
		
function listLexique () {
	Global $xoopsModuleConfig, $xoopsDB, $xoopsConfig, $xoopsModule;
	$myts =& MyTextSanitizer::getInstance();
	
    $sql = "SELECT * FROM ".$xoopsDB->prefix(_LEX_TBL_LEXIQUE)." ORDER BY Ordre, name";
    $sqlquery=$xoopsDB->query($sql);

	  //xoops_cp_header();
    OpenTable();    
    echo _JJD_JSI_TOOLS._JJD_JSI_SPIN._LEX_JSI_LEXIQUE._br;
    
	  echo "<B>"._AD_LEX_ADMIN." ".$xoopsConfig['sitename']."</B><p>";
  	echo "<B>"._AD_LEX_LEXIQUE_MANAGEMENT."</B><P>";
		echo "<FORM ACTION='admin_lexique.php?op=saveList' METHOD=POST>";
    
    echo "<table width='100%'>";
    echo "<TR>";
    echo "<TD align='right' width='5%' >Id</TD>";
    echo "<TD align='left'    width='25%'>"._AD_LEX_NAME."</TD>";
    echo "<TD align='center'  width='3%' >"._AD_LEX_ORDER."</TD>";
    echo "<TD align='center'  width='3%' >"._AD_LEX_ACTIF."</TD>";   
    echo "<TD align='center'  width='3%' >"._AD_LEX_EDIT."</TD>";  
    echo "<TD align='center'  width='3%' >"._AD_LEX_CLONE."</TD>";    
    echo "<TD align='center'  width='3%' >"._AD_LEX_PERMISSIONS."</TD>";       
    echo "<TD align='center'  width='3%' >"._AD_LEX_GOTO."</TD>";    
    echo "<TD align='center'  width='3%' >"._AD_LEX_CLEAR."</TD>";    
    echo "<TD align='center'  width='3%' >"._AD_LEX_DELETE."</TD>";    
    echo "</TR>";

    
    /*
    //test si on trouve au moins une expression
    if ($xoopsDB->getRowsNum($sqlquery)==0){return;}
    $nbEnr = $xoopsDB->getRowsNum($sqlquery); 

    */
    //------------------------------------------------        
    $h = 0;
    while ($sqlfetch=$xoopsDB->fetchArray($sqlquery)) {
      $idLexique = $sqlfetch["idLexique"];
      
    	$id         = $idLexique;      
    	$name       = $sqlfetch["name"];    	
    	$actif      = $sqlfetch["actif"];
      $order      = $sqlfetch["ordre"];
      //$categories = $sqlfetch["categories"];
      
      $sql = "SELECT count(idLexique) as count FROM ".$xoopsDB->prefix(_LEX_TBL_TERME). " "
            ."WHERE idLexique = ".$idLexique;     
      $sqlqueryTermes = $xoopsDB->query($sql);      
	    list( $countTermes ) = $xoopsDB->fetchRow( $sqlqueryTermes ) ;      
      
      
      
      $n = _PREFIX_NAME.$h;
      $$n = $name;
      $$n = $myts->makeTboxData4Save($$n);
      
      $txtName        = _PREFIX_NAME.$h;
      $txtOrder       = _PREFIX_ORDER.$h;
      $txtActif       = _PREFIX_ACTIF.$h;
      $txtId          = _PREFIX_ID.$h;

   	   $link = "admin_lexique.php?op=edit&idLexique=".$idLexique;
    
        echo "<TR>"._br;
        echo "<TD align='right' >".$idLexique." <INPUT TYPE=\"hidden\" id='".$txtId."'  NAME='".$txtId."'  size='1%'"." VALUE='".$idLexique."'></TD>"._br;
    
   	    echo "<TD align='left'><A href='{$link}'>{$name}</A></TD>";
          
                 
        echo "<TD align='right'  ><INPUT TYPE=\"text\" ID='{$txtOrder}'  NAME='{$txtOrder}' size='5%'"."  align='right' VALUE='".$order."'></TD>"._br;

        
        $c = ($actif==1)?"checked":"";
        echo "<TD align='center'  ><input type='checkbox' ID='{$txtActif}' NAME='{$txtActif}' size='5%' value='ON' ".$c."></td>"._br;
        //-----------------------------------------------------------------------
        
        echo "<TD align='center'>";        
    	  echo "<A href='".$link."'><img src='"._JJDICO_EDIT."' border=0 Alt='"._AD_LEX_EDIT."' title='"._AD_LEX_EDIT."' width='20' height='20' ALIGN='absmiddle'></A>";
        echo "</td>"; 
        
        //-----------------------------------------------------------------------
        //dupliquer
   	    $link2 = "admin_lexique.php?op=duplicate&idLexique=".$idLexique;        
        echo "<TD align='center'>";        
    	  echo "<A href='".$link2."'><img src='"._JJDICO_DUPLICATE."' border=0 Alt='"._AD_LEX_DUPLICATE."' title='"._AD_LEX_DUPLICATE."' width='20' height='20' ALIGN='absmiddle'></A>";
        echo "</td>"; 
        
           
        //-----------------------------------------------------------------------
    	  $link = "admin_access.php?op=list&idLexique={$idLexique}&access=";
        echo "<TD align='center'>";        
    	  //echo "<A href='".$link."0'><img src='"._JJDICO_URL."verrou-grey.gif' border=0 Alt='"._AD_LEX_PERMISSIONS."' title='"._AD_LEX_PERMISSIONS."' width='20' height='20' ALIGN='absmiddle'></A>";
    	  echo "<A href='".$link."1'><img src='"._JJDICO_URL."verrou-red.gif' border=0 Alt='"._AD_LEX_PERMISSIONS_TLB_MAIN."' title='"._AD_LEX_PERMISSIONS_TLB_MAIN."' width='20' height='20' ALIGN='absmiddle'></A>";
    	  echo "<A href='".$link."2'><img src='"._JJDICO_URL."verrou-blue.gif' border=0 Alt='"._AD_LEX_PERMISSIONS_TLB_TERME."' title='"._AD_LEX_PERMISSIONS_TLB_TERME."' width='20' height='20' ALIGN='absmiddle'></A>";
    	  echo "<A href='".$link."4'><img src='"._JJDICO_URL."verrou-yellow.gif' border=0 Alt='"._AD_LEX_PERMISSIONS_TERMES."' title='"._AD_LEX_PERMISSIONS_TERMES."' width='20' height='20' ALIGN='absmiddle'></A>";
    	  echo "<A href='".$link."8'><img src='"._JJDICO_URL."verrou-green.gif' border=0 Alt='"._AD_LEX_PERMISSIONS_PROPERTIES."' title='"._AD_LEX_PERMISSIONS_PROPERTIES."' width='20' height='20' ALIGN='absmiddle'></A>";                            	  
        echo "</td>"; 
        //echo "<hr>"._JJDICO_URL."verrou-grey.gif";   
        //-----------------------------------------------------------------------

    	  $link = "../index.php?idLexique=".$idLexique;    
        echo "<TD align='center'>";        
    	  echo "<A href='{$link}'><img src='"._JJDICO_PROPERTY."' border=0 Alt='"._AD_LEX_LIBELLE."' title='"._AD_LEX_LIBELLE."' width='20' height='20' ALIGN='absmiddle'></A>";
        echo "</td>";    
        
              	
        //-----------------------------------------------------------------------      
        
        echo "<TD align='center'>";        
      	if( $countTermes > 0 ANd $actif == 0) {
      	   $link = "admin_lexique.php?op=clear&id=".$id;

      	   echo "<A href='".$link."'><img src='"._JJDICO_EMPTY."' border=0 Alt='"._AD_LEX_CLEAR."' title='"._AD_LEX_CLEAR."' width='20' height='20' ALIGN='absmiddle'></A>";
            
      	}
        echo "</td>";      	
        //-----------------------------------------------------------------------      
        echo "<TD align='center'>";        
      	if( $countTermes == 0 ANd $actif == 0) {
      	   $link = "admin_lexique.php?op=remove&idLexique={$id}&name={$name}";
            
      	   echo "<A href='".$link."'><img src='"._JJDICO_REMOVE."' border=0 Alt='"."_AD_LEX_DELETE"."' title='"._AD_LEX_DELETE."' width='20' height='20' ALIGN='absmiddle'></A>";
            
            
      	}
        echo "</td>";            
        //----------------------------------------------------
        echo "</TR>"._br;
        $h ++;                			
    }

     
    echo "</table>"._br;


echo "<TABLE BORDER=0 CELLPADDING=2 CELLSPACING=3>
  <tr valign='top'>
    <td align='left' ><input type='button' name='cancel' value='"._CLOSE."' onclick='".buildUrlJava("index.php",false)."'></td>
    <td align='left' width='200'></td>

    <td align='right'>
    <input type='button' name='new' value='"._AD_LEX_NEW."' onclick='".buildUrlJava("admin_lexique.php?op=new",false)."'>    
    </td>    

    


    <td align='right'><input type='submit' name='submit' value='"._AD_LEX_VALIDER."'></td>
  </tr>
  </form>";

    
	CloseTable();
	//xoops_cp_footer();

      //------------------------------------------------------------------
      //$xoopsTpl->append('dic_post', $post);
    

	exit();
}



//-----------------------------------------------------------------
/*****************************************************************
 *
 *****************************************************************/
function editLexique($p){
	
    Global $xoopsModuleConfig, $xoopsDB, $xoopsConfig, $xoopsModule;
	$myts =& MyTextSanitizer::getInstance();

    //------------------------------------------------  
    $ligneDeSeparation = "<TR><td colspan='2'><hr></td></TR>"._br;  

    $s0 ='';// "color: #FFFF00; background-color: #CCCCCC; line-height: 100%;border-width:1; border-style: solid; border-color: #0000FF; margin-top: 0; margin-bottom: 0; padding: 0";
    $s1 ='';// "color: #0000FF; text-align: right; margin-left: 1; margin-right: 2";
    
    $listYesNo = array(_AD_LEX_NO,_AD_LEX_YES);    
    
    $listColor = array(_AD_LEX_COUL_WHITE,       _AD_LEX_COUL_BLACK,
                       _AD_LEX_COUL_GREY,        _AD_LEX_COUL_BLUE,
                       _AD_LEX_COUL_YELLOW,      _AD_LEX_COUL_GREEN,
                       _AD_LEX_COUL_RED,         _AD_LEX_COUL_MAGENTA,
                       _AD_LEX_COUL_CYAN,        _AD_LEX_COUL_TURQUOISE,
                       _AD_LEX_COUL_BRAUWN,      _AD_LEX_COUL_VIOLET);
 
    //------------------------------------------------    
  
  //echo versionJS();
 
  echo _JJD_JSI_TOOLS._JJD_JSI_SPIN._LEX_JSI_LEXIQUE._br;

	  //xoops_cp_header();
    OpenTable();  
    //********************************************************************
	  echo "<div align='center'><B>"._AD_LEX_ADMIN." ".$xoopsConfig['sitename']."</B><br>";
  	echo "<B>"._AD_LEX_LEXIQUE_MANAGEMENT."</B></div>";
    
 		echo "<FORM ACTION='admin_lexique.php?op=save' METHOD=POST>"._br;
    
    //********************************************************************
    CloseTable();
    OpenTable();   
    echo "<table width='80%'>"._br;     
    //********************************************************************  
    echo buildTitleOption (_AD_LEX_OPTIONS_GENERALES,_AD_LEX_OPTIONS_GENERALES_DESC);    
    //********************************************************************

    //---id
    echo "<TR>"._br;
    echo "<TD align='left' >".""."</TD>"._br;
    echo "<TD align='right' >".$p['idLexique']." <INPUT TYPE=\"hidden\" id='idLexique'  NAME='idLexique'  size='1%'"." VALUE='".$p['idLexique']."'></TD>"._br;
    echo "</TR>"._br;    




	$myts =& MyTextSanitizer::getInstance();

    //---Name
    echo buildInput(_AD_LEX_NOM, '', 'txtName', $myts->makeTboxData4Show($p['name'], "1", "1", "1"), '60%');    


    $definition1 = $myts->makeTareaData4Show($p['introtext'], "1", "1", "1");
   	$desc1 = getXME($definition1, 'txtIntrotext', '','100%');
    echo "<TR>"._br;
    echo "<TD align='left' ><B>"._AD_LEX_INTROTEXT."</B></TD>"._br;    
    echo "<TD align='left'  >";
      echo $desc1->render();
    echo "</TD>"._br;
    echo "</TR>"._br;
    	
    //---Icone    
    $list = getGifFiles ($p['icone']);
    //$p['icone'] = 'livre1.gif';
    $img = "<img src='"._LEX_URL_LEXICONES."{$p['icone']}' name='imgIcone' border=0 Alt='' width='20' height='20' ALIGN='absmiddle'>";
        
    echo "<TR>"._br;
    echo "<TD align='left' ><B>"._AD_LEX_LEXICONE."</B></TD>"._br;    
    echo "<TD align='left' >{$list}   {$img}</TD>"._br;
    echo buildDescription(_AD_LEX_LEXICONE_DSC);    
    echo "</TR>"._br;

    echo $ligneDeSeparation;//------------------------------------------------
    
    $defaut = $p['idSelecteur'];
        //---Selecteur
    $selected = buildHtmlListFromTable ('txtSelecteur', 
                                 _LEX_TBL_SELECTEUR,
                                 'name', 
                                 'idSelecteur', 
                                 'name', 
                                 $defaut);
    
   
    echo buildSelecteur(_AD_LEX_SELECTEUR,_AD_LEX_SELECTEUR_DSC , $selected );



    echo $ligneDeSeparation;//------------------------------------------------

    //---category
    $defaut = $p['idFamily'];
    $selected = buildHtmlListFromTable ('txtFamily',  
                                 _LEX_TBL_FAMILY, 
                                 'name', 
                                 'idFamily', 
                                 'name', 
                                 $defaut);

    echo  buildSelecteur(_AD_LEX_FAMILY, _AD_LEX_FAMILY_DSC, $selected);   

    echo $ligneDeSeparation;//------------------------------------------------

    //---Jeu de libelle (caption))
    $defaut = $p['idCaption'];
    $selected = buildHtmlListFromTable ('txtCaption', 
                                 _LEX_TBL_CAPTION,
                                 'name', 
                                 'idCaption', 
                                 'idCaption', 
                                 $defaut);

   
    echo buildSelecteur(_AD_LEX_CAPTION,_AD_LEX_CAPTION_DSC , $selected );

    echo $ligneDeSeparation;//------------------------------------------------ 
    
        //---property
    $defaut = $p['idProperty'] ;   
    $selected = buildHtmlListFromTable ('txtProperty', 
                                 _LEX_TBL_PROPERTY,
                                 'name', 
                                 'idProperty', 
                                 'name', 
                                 $defaut);
    
   
    echo buildSelecteur(_AD_LEX_PROPERTY ,_AD_LEX_PROPERTY_DSC , $selected );
    
    
        //---Show property
    //--detailShowShortDef 
    $list = array(_AD_LEX_SHOW_PROPERTY_ALL, _AD_LEX_SHOW_PROPERTY_NOTEMPTY);
    echo buildList(_AD_LEX_SHOW_PROPERTY, _AD_LEX_SHOW_PROPERTY_DSC, 
                   'lst_detailShowProperty', $list, $p['detailShowProperty']);
               
    //------------------------------------------------   
    echo $ligneDeSeparation;
    //------------------------------------------------        
    
    //---actif
    echo buildList(_AD_LEX_ACTIF, _AD_LEX_LEXIQUE_ACTIF_DSC, 
                   'txtActif', $listYesNo, $p['actif']); //$ligneDeSeparation
    
    //---ordre
    echo buildSpin(_AD_LEX_ORDER, _AD_LEX_ORDER_DESC, 'txt_ordre', $p['ordre'], 100, 0, 1, 10);
    
    
    //------------------------------------------------
    //echo $ligneDeSeparation;
    //------------------------------------------------    
     //********************************************************************  
    echo buildTitleOption3 (_AD_LEX_NOTE_LEXIQUE);    
    //********************************************************************
   
    //---note minimum
    echo buildSpin(_AD_LEX_NOTE_MIN, '', 'txt_noteMin', $p['noteMin'], 9, 0, 1, 10);
    
    //---note maximum
    echo buildSpin(_AD_LEX_NOTE_MAX, '', 'txt_noteMax', $p['noteMax'], 9, 0, 1, 10);

    //---note liste des sets d'images
    //$f = _LEX_URL_NOTEIMG.$p['noteImg'].'/';    
    $mask = str_replace ("//", '/', XOOPS_URL."/".$p['noteImg']);
    
    $tImg = array();
    $tOc  = array();
    for ($h = 0; $h <=9; $h++){
      $f = str_replace("?", $h, $mask);
      //echo $f."<br>";
      $tImg[] = "<img src='{$f}' name='noteImg{$h}' border=0 Alt='' ALIGN='absmiddle'>";
      //$tOc[]  = "changeImgFromList(\"noteImg{$h}\", \"txt_noteImg\", \""._LEX_URL_NOTEIMG."\", \"/{$h}.gif\");";
      $tOc[]  = "changeImgFromList2(\"noteImg{$h}\", \"txt_noteImg\", \"".XOOPS_URL."\", \"{$h}\");";
    } 
    
    $img = implode('', $tImg); 
    $oc  = implode ('', $tOc);
    
    //$list =  html_buildFolderlist(_LEX_ROOT_NOTEIMG, 'txt_noteImg', $p['noteImg'], $oc);    
    $list =  getListNoteImgSet('txt_noteImg', $p['noteImg'], $oc);  
    
    
    echo "<TR>"._br;
    echo "<TD align='left' ><B>"._AD_LEX_LEXICONE."</B></TD>"._br;    
    echo "<TD align='left' >{$list}<br>{$img}</TD>"._br;
    echo buildDescription(_AD_LEX_LEXICONE_DSC);    
    echo "</TR>"._br;
  

     //********************************************************************  
    echo buildTitleOption3 (_AD_LEX_NOTE_TERME);    
    //********************************************************************
   
   //---note minimum
    echo buildSpin(_AD_LEX_NOTE_MIN, '', 'txt_termeNoteMin', $p['termeNoteMin'], 9, 0, 1, 10);
    
    //---note maximum
    echo buildSpin(_AD_LEX_NOTE_MAX, '', 'txt_termeNoteMax', $p['termeNoteMax'], 9, 0, 1, 10);

    //---note liste des sets d'images
    //$f = _LEX_URL_NOTEIMG.$p['noteImg'].'/';    
    $mask = str_replace ("//", '/', XOOPS_URL."/".$p['termeNoteImg']);
    
    $tImg = array();
    $tOc  = array();
    for ($h = 0; $h <=9; $h++){
      $f = str_replace("?", $h, $mask);
      //echo $f."<br>";
      $tImg[] = "<img src='{$f}' name='termeNoteImg{$h}' border=0 Alt='' ALIGN='absmiddle'>";
      $tOc[]  = "changeImgFromList2(\"termeNoteImg{$h}\", \"txt_termeNoteImg\", \"".XOOPS_URL."\", \"{$h}\");";
    } 
    
    $img = implode('', $tImg); 
    $oc  = implode ('', $tOc);
    
    //$list =  html_buildFolderlist(_LEX_ROOT_NOTEIMG, 'txt_noteImg', $p['noteImg'], $oc);    
    $list =  getListNoteImgSet('txt_termeNoteImg', $p['termeNoteImg'], $oc);  
    
    
    echo "<TR>"._br;
    echo "<TD align='left' ><B>"._AD_LEX_LEXICONE."</B></TD>"._br;    
    echo "<TD align='left' >{$list}<br>{$img}</TD>"._br;
    echo buildDescription(_AD_LEX_NOTE_FOLDER_DSC);    //_AD_LEX_LEXICONE_DSC
    echo "</TR>"._br;
   
    

    //------------------------------------------------
    echo $ligneDeSeparation;
    //------------------------------------------------    
    
    
    //------------------------------------------------ 
    //---nbmsgbypage    
    echo buildSpin(_AD_LEX_NBROWS, _AD_LEX_NBROWS_DESC, 'txt_nbmsgbypage', $p['nbmsgbypage'], 
                   100, 1, 1, 10, $ligneDeSeparation);
    
    //-- intautosubmit
    echo buildList(_AD_LEX_AUTOSUBMIT, _AD_LEX_AUTOSUBMIT_DESC, 'lst_intautosubmit', $listYesNo, $p['intautosubmit']);

    //-- sendmail2webmaster
    echo buildList(_AD_LEX_SENDMAIL2WEBMASTER,_AD_LEX_SENDMAIL2WEBMASTERDESC , 
                   'lst_sendmail2webmaster', $listYesNo, $p['sendmail2webmaster']);


    //---_mail4webmaster
    echo buildInput(_AD_LEX_MAIL4WEBMASTER, _AD_LEX_MAIL4WEBMASTERDESC, 'txt_mail4webmaster', $p['mail4webmaster'], '60%');


    //---optins pour xoops search
    //---actif
    $lib = 'lib';
    $val = 'val';
    $id  = 'id';
    $h=0;
    $b = $p['xoopsSearch'];

    $t = array(array($lib => _AD_LEX_SEARCH_IN_NAME,         $val => isBitOk($h, $b), $id => $h++), 
               array($lib => _AD_LEX_SEARCH_IN_SHORTDEF,     $val => isBitOk($h, $b), $id => $h++),
               array($lib => _AD_LEX_SEARCH_IN_DEFINITION1,  $val => isBitOk($h, $b), $id => $h++),               
               array($lib => _AD_LEX_SEARCH_IN_DEFINITION2,  $val => isBitOk($h, $b), $id => $h++),
               array($lib => _AD_LEX_SEARCH_IN_DEFINITION3,  $val => isBitOk($h, $b), $id => $h++),               
               array($lib => _AD_LEX_SEARCH_IN_CATEGORY,     $val => isBitOk($h, $b), $id => $h++));  

    echo "<tr><td><b>"._AD_LEX_XOOOPS_SEARCH."</b></td><td>"._br;
    echo buildCheckedListH ($t, '' , "xoopsSearch", 0, 1, $lib, $val, $id);
    echo "</td></tr>"._br;
    echo buildDescription(_AD_LEX_XOOPS_SEARCH_DSC);




    //********************************************************************  
    echo "</table>";      
    CloseTable();
    OpenTable();    
    echo "<table width='80%'>"._br;    
    //********************************************************************    

    
    
    
    /********************************************************************
    * options de structure du lexique - influe notament sur le formulaire d'dition
    *********************************************************************/
    
    
    echo buildTitleOption (_AD_LEX_OPTIONS_STRUCT,_AD_LEX_OPTIONS_STRUCT_DESC);
    //********************************************************************
  
    //--detailShowShortDef 
    echo buildList(_AD_LEX_SHOW_SHORTDEF, _AD_LEX_SHOW_SHORTDEF_DSC, 
                   'lst_detailShowShortDef', $listYesNo, $p['detailShowShortDef']);


 //*********
    //--detailShowDefinition 

    $lib = 'lib';
    $val = 'val';
    $id  = 'id';
    $h=0;
    
    echo "<tr><td><b>"._AD_LEX_SHOW_DEFINITONS."</b></td><td><table border='1' align='center'><tr>";  
    
    $libOptions    = array(_AD_LEX_DEFINITIONS,_AD_LEX_DO_OPTIONS,_AD_LEX_DO_HTML,_AD_LEX_DO_SMILEY,_AD_LEX_DO_XCODE,_AD_LEX_DO_IMAGE,_AD_LEX_DO_BR);
    for ($i = 0; $i < count($libOptions); $i++){    
        echo "<td align='center'>{$libOptions[$i]}</td>";    
    }
    echo "</tr><tr>";          
    //------------------------------------------------------------------    
    $b = $p['detailShowDefinition'];

    $t = array(array($lib => '1',  $val => isBitOk($h, $b), $id => $h++), 
               array($lib => '2',  $val => isBitOk($h, $b), $id => $h++),
               array($lib => '3',  $val => isBitOk($h, $b), $id => $h++));  

    echo "<td align='center'>";
    echo buildCheckedListH ($t, '' , "definitions", 0, 1, $lib, $val, $id);
    echo "</td>";    
    //------------------------------------------------------------------
    $editorOptions = array('dooptions','dosmiley','dohtml','doxcode','doimage','dobr');
    //$libOptions    = array(_AD_LEX_DO_OPTIONS,_AD_LEX_DO_HTML,_AD_LEX_DO_SMILEY,_AD_LEX_DO_XCODE,_AD_LEX_DO_BR);    
    $libOptions    = array('Options','HTML','Emoticones','xCcodes','Image','Line break');
        
    for ($i = 0; $i < count($editorOptions); $i++){
        $h = 0;
        $b = $p[$editorOptions[$i]];
        //echo "<hr>{$editorOptions[$i]} = {$b}<hr>";
        
        $t = array();
        $t[] = array($lib => $libOptions[$i],  $val => isBitOk($h, $b), $id => $h); $h++;
        $t[] = array($lib => $libOptions[$i],  $val => isBitOk($h, $b), $id => $h); $h++;
        $t[] = array($lib => $libOptions[$i],  $val => isBitOk($h, $b), $id => $h); $h++;
        
        
        echo "<td align='center'><p align='center'>";
        echo buildCheckedListH ($t, '' , $editorOptions[$i], 0, 1, $lib, $val, $id);
        echo "</td>";    
            
    }
    //------------------------------------------------------------------    
    echo "</tr></td></table></td></tr>"._br;
    echo buildDescription(_AD_LEX_SHOW_DEFINITONS_DSC);
    //------------------------------------------------------------------
    
    $listEditor = getEditorList2(); 
    echo "<tr><td align='center'>";
    //echo buildCheckedListH ($listEditor, 'rrrrrrrrrrrr' , "editor", 0, 1, $lib, $val, $id);
    
    
    echo buildList(_AD_LEX_EDITOR, _AD_LEX_EDITOR_DSC, 
                   'editor', $listEditor, $p['editor']);


    echo "</td></tr>";    
    
    
    //displayArray($list,'-----------getEditorList--------------');


 //*********
    //--etitor optionss
    
     

//*********

    //-- showcategory
    echo buildList(_AD_LEX_SHOW_CATEGORY, _AD_LEX_SHOW_CATEGORY_DSC, 
                   'lst_showcategory', $listYesNo, $p['showcategory']);

    //********************************************************************  
    echo "</table>";      
    CloseTable();
    OpenTable();    
    echo "<table width='80%'>"._br;    
    //********************************************************************

    
    /********************************************************************
    * 
    *********************************************************************/
    
    
    echo buildTitleOption (_AD_LEX_OPTIONS_SHOWING,_AD_LEX_OPTIONS_SHOWING_DESC);
    //********************************************************************

    //-- detailShowInterligne
    echo buildList(_AD_LEX_SHOW_INTERLIGNE, _AD_LEX_SHOW_INTERLIGNE_DSC, 
                   'lst_detailShowInterligne', $listYesNo, $p['detailShowInterligne']);


    //---position des bouttons
    $list = array(_AD_LEX_BTN_POSITION0,
                  _AD_LEX_BTN_POSITION1,
                  _AD_LEX_BTN_POSITION2,
                  _AD_LEX_BTN_POSITION3,
                  _AD_LEX_BTN_POSITION4,
                  _AD_LEX_BTN_POSITION5,
                  _AD_LEX_BTN_POSITION6);
    echo buildList(_AD_LEX_BTN_POSITION, _AD_LEX_BTN_POSITION_DSC, 'lst_buttonPosition', $list, $p['buttonPosition']);
    
    echo buildList(_AD_LEX_FOLLOW_POSITION, _AD_LEX_FOLLOW_POSITION_DSC, 'lst_followPosition', $list, $p['followPosition']);
    
    //----------------------------------------------------------       
    echo $ligneDeSeparation; //------------------------------------------------        
    //----------------------------------------------------------    

    //-- intlinkspopup
    echo buildList(_AD_LEX_INTLINKSPOPUP, _AD_LEX_INTLINKSPOPUPDESC, 
                   'lst_intlinkspopup', $listYesNo, $p['intlinkspopup']);


    //-- intlinksheight    
    echo buildSpin(_AD_LEX_INTLINKSHEIGHT, _AD_LEX_INTLINKSHEIGHTDESC, 'txt_intlinksheight', $p['intlinksheight'], 
                   500, 100, 1, 10);

    //--intlinkswidth
    echo buildSpin(_AD_LEX_INTLINKSWIDTH, _AD_LEX_INTLINKSWIDTHDESC, 'txt_intlinkswidth', $p['intlinkswidth'], 
                   800, 0, 1, 10);

    //----------------------------------------------------------       
    echo $ligneDeSeparation; //------------------------------------------------        
    //----------------------------------------------------------    


    //-- detailGererVisit
    echo buildList(_AD_LEX_GERER_VISIT, _AD_LEX_GERER_VISIT_DSC, 
                   'lst_detailGererVisit', $listYesNo, $p['detailGererVisit']);




    //********************************************************************  
    echo "</table>";      
    CloseTable();
    OpenTable();    
    echo "<table width='80%'>"._br;    
    //********************************************************************

    /*************************************************************************
     *gestion de la rubrique voir aussi    
     *************************************************************************/    
    echo buildTitleOption (_AD_LEX_OPTIONS_SEEALSO,_AD_LEX_OPTIONS_SEEALSO_DESC);

    //-- seealsomode
    $list = array (_AD_LEX_SA_BYEXPRESSION,
                   _AD_LEX_SA_BYID);
    echo buildList(_AD_LEX_SA_MANAGEMENT_MODE, _AD_LEX_SA_MANAGEMENT_MODE_DSC, 
                   'lst_seealsomode', $list, $p['seealsomode']);

    //-- synchroniseterme
    echo buildList(_AD_LEX_SYNCHRONISE_TERME, _AD_LEX_SYNCHRONISE_TERME_DSC, 
                   'lst_synchroniseterme', $listYesNo, $p['synchroniseterme']);

    //-- detailShowSeeAlso
    $list = array (_AD_LEX_REF_NEVER,
                   _AD_LEX_REF_ALONEIFREF,
                   _AD_LEX_REF_ALWAYSWITHREF,
                   _AD_LEX_REF_ALWAYSWITHOUTREF,
                   _AD_LEX_REF_MIXEDREF);

    echo buildList(_AD_LEX_SHOW_SEEALSO, _AD_LEX_SHOW_SEEALSO_DSC, 
                   'lst_detailShowSeeAlso', $list, $p['detailShowSeeAlso']);


    //********************************************************************


    //-- detailSeeAlsoCache
    $list = array (_AD_LEX_SA_LIB_NOCACHE,
                   _AD_LEX_SA_LIB_CACHEON,
                   _AD_LEX_SA_LIB_CACHEMARK);

    echo buildList(_AD_LEX_SA_CACHE, _AD_LEX_SA_CACHE_DSC, 
                   'lst_detailSeeAlsoCache', $list, $p['detailSeeAlsoCache']);


    //----------------------------------------------------------
    echo $ligneDeSeparation;    
    //----------------------------------------------------------    


    //-- detailSeeAlsoShowing
    $r = _AD_LEX_SAMODESHOWING_MOD;    
    $list = array (    $r  ,"({$r})","[{$r}]","{{$r}}","|{$r}|","<{$r}>");    
    echo buildList(_AD_LEX_SAMODESHOWING, _AD_LEX_SAMODESHOWING_DSC, 
                   'lst_detailSeeAlsoShowing', $list, $p['detailSeeAlsoShowing']);

    //-- intlinksicon
    echo buildList(_AD_LEX_INTLINKSICON, _AD_LEX_INTLINKSICONDESC, 
                   'lst_intlinksicon', $listYesNo, $p['intlinksicon']);


    //----------------------------------------------------------
    echo $ligneDeSeparation;    
    //----------------------------------------------------------    

///////////////////////////////////////////////////////////////////////

    //-- iconolink
    echo buildList(_AD_LEX_COULICO_NOLINK, _AD_LEX_COULICO_NOLINK_DSC, 
                   'lst_iconolink', $listColor, $p['iconolink']);

    //-- icolink    
    echo buildList(_AD_LEX_COULICO_LINK, _AD_LEX_COULICO_LINK_DSC, 
                   'lst_icolink', $listColor, $p['icolink']);

    //-- icoref
    echo buildList(_AD_LEX_COULICO_REFLINK, _AD_LEX_COULICO_REFLINK_DSC, 
                   'lst_icoref', $listColor, $p['icoref']);

    //-- icosize
    $listSize = array(_AD_LEX_ARROW_SMALL,_AD_LEX_ARROW_MEDIUM,_AD_LEX_ARROW_LARGE);
    echo buildList(_AD_LEX_ARROW_SIZE, _AD_LEX_ARROW_SIZE_DSC, 
                   'lst_icosize', $listSize, $p['icosize']);
                   
    //----------------------------------------------------------    
    echo $ligneDeSeparation;    
    //----------------------------------------------------------

    //---mode de recherche pour la rubrique seeAlso   
    $list = array (_AD_LEX_SEARCH_ENTIRELY,_AD_LEX_SEARCH_BEGINBY,_AD_LEX_SEARCH_ENDBY,_AD_LEX_SEARCH_EVERYWHERE,_AD_LEX_SEARCH_ENTIRELYIN);    
    echo buildList(_AD_LEX_SEARCHSEEALSOMODE, _AD_LEX_SEARCHSEEALSOMODE_DSC, 
                   'lst_searchSeeAlsoMode', $list, $p['searchSeeAlsoMode']);
    

    //********************************************************************  
    echo "</table>";      
    CloseTable();
    OpenTable();    
    echo "<table width='80%'>"._br;    
    //********************************************************************

    echo buildTitleOption (_AD_LEX_OPTIONS_EDITION,_AD_LEX_OPTIONS_EDITION_DESC);
    
    //-- nbtermebypage    
    echo buildSpin(_AD_LEX_NBTERMEBYPAGE, _AD_LEX_NBTERMEBYPAGE_DSC, 'txt_nbtermebypage', $p['nbtermebypage'], 
                   25, 5, 5, 10);

    //********************************************************************


    //********************************************************************  
    echo "</table>";      
    CloseTable();
    OpenTable();    
    echo "<table width='80%'>"._br;    
    //********************************************************************



    echo "<TABLE BORDER=0 CELLPADDING=2 CELLSPACING=3>
      <tr valign='top'>
        <td align='left' ><input type='button' name='cancel' value='"._CANCEL."' onclick='".buildUrlJava("admin_lexique.php",false)."'></td>
        <td align='left' width='200'></td>
    
        <td align='right'>
        <input type='submit' name='submit' value='"._AD_LEX_VALIDER."' )'>    
        </td>    
      </tr>
      </table>
      </form>";
    
        
    	CloseTable();
    	//xoops_cp_footer();

      //------------------------------------------------------------------
      //$xoopsTpl->append('dic_post', $post);
    


	exit();
}


/***********************************************************************
 *
 ***********************************************************************/

//---------------------------------------------------------------------
function saveListLexique ($t) {
	Global $xoopsModuleConfig, $xoopsDB, $xoopsConfig, $xoopsModule;
	$myts =& MyTextSanitizer::getInstance();
	
	
    //displayArray ($t, "POST");
    //displayArray ($_POST, "POST");
    $tr = getArrayOnPrefix2 ($t, _PREFIX_LIST);
    
//    displayArray ($tr, "Resultat");    
	 for ($h = 0; $h < count($tr); $h++){   
	 
      $idLexique  = $tr[$h][_PREFIX_ID];	 
      //$name       = $tr[$h][_PREFIX_NAME.$h];
      //$categories = $tr[$h][_PREFIX_CATEGORIES];      
      $order      = $tr[$h][_PREFIX_ORDER];
      $actif      = ($tr[$h][_PREFIX_ACTIF]=='ON')?1:0;

      
      $sql = "UPDATE ".$xoopsDB->prefix(_LEX_TBL_LEXIQUE)." SET "
            ."Ordre =  ".$order.", "
            ."Actif =  ".$actif." "
            ."WHERE idLexique = ".$idLexique;
//	     echo $sql."<br>";
       $xoopsDB->query($sql);
      
   } 

}

/***********************************************************************
 *
 ***********************************************************************/

function saveListLexique2 ($t) {
	Global $xoopsModuleConfig, $xoopsDB, $xoopsConfig, $xoopsModule;
	$myts =& MyTextSanitizer::getInstance();

    $tr = getArrayOnPrefix2 ($t, _PREFIX_LIST);
    
	 for ($h = 0; $h < count($tr); $h++){   
	 
      $idLexique  = $tr[$h][_PREFIX_ID];	 
      $name       = $tr[$h][_PREFIX_NAME];
      $order      = $tr[$h][_PREFIX_ORDER];
      $actif      = ($tr[$h][_PREFIX_ACTIF]=='ON')?1:0;

      
      $sql = "UPDATE ".$xoopsDB->prefix(_LEX_TBL_LEXIQUE)." SET "
            ."name  =  '".$name."', "
            ."Ordre =  ".$order.", "
            ."Actif =  ".$actif." "
            ."WHERE idLexique = ".$idLexique;
       $xoopsDB->query($sql);
      
   } 

}

/*******************************************************************
 *
 *******************************************************************/
function saveLexique ($t) {
	Global $xoopsModuleConfig, $xoopsDB, $xoopsConfig, $xoopsModule;
  
  $idLexique = $t['idLexique'];
  //-----------------------------------------------------------
  $bDef         = checkBoxToBin($t, 'definitions',  $def);  
  $bdooptions   = checkBoxToBin($t, 'dooptions',    $def);  
  $bdohtml      = checkBoxToBin($t, 'dohtml',       $def);  
  $bdosmiley    = checkBoxToBin($t, 'dosmiley',     $def);  
  $bdoxcode     = checkBoxToBin($t, 'doxcode',      $def);  
  $bdoimage     = checkBoxToBin($t, 'doimage',      $def);  
  $bdobr        = checkBoxToBin($t, 'dobr',        $def);  
  
  $bSearch = checkBoxToBin($t, 'xoopsSearch', $def);  
  //-----------------------------------------------------------
   $t['txtName']      = string2sql($t['txtName']);
   $t['txtIntrotext'] = string2sql($t['txtIntrotext']);
   
   
  if ($idLexique == 0){
    
      $sql = "INSERT INTO ".$xoopsDB->prefix(_LEX_TBL_LEXIQUE)." "._br
              ."(name,icone,introtext,Actif,Ordre,"
              ."idFamily,idSelecteur,idCaption,idProperty,"
              ."nbmsgbypage,xoopsSearch,"
              ."searchSeeAlsoMode,detailShowShortDef,detailShowDefinition,"
              ."detailShowInterligne,buttonPosition,followPosition,"
              ."detailShowSeeAlso,detailSeeAlsoShowing,detailShowProperty,"
              ."iconolink,icolink,icoref,icosize,"
              ."intlinkspopup,intlinksheight,intlinkswidth,detailGererVisit,"
              ."intlinksicon,nbtermebypage,detailSeeAlsoCache,seealsomode,synchroniseterme,"
              ."intautosubmit,sendmail2webmaster,mail4webmaster,"
              ."showcategory, noteMin, noteMax, noteImg , termeNoteMin, termeNoteMax, termeNoteImg,"
              ."editor,dooptions,dosmiley,dohtml,doxcode,doimage,dobr) \n"
            ."VALUES (" 
            ."'{$t['txtName']}',"  
            ."'{$t['lstIcones']}',"            
            ."'{$t['txtIntrotext']}',"                      
            .$t['txtActif'].","
            .$t['txt_ordre'].","
            .$t['txtFamily'].","          
            .$t['txtSelecteur'].","
            .$t['txtCaption'].","    
            .$t['txtProperty'].","                    
            .$t['txt_nbmsgbypage'].","
            .$bSearch.","            
            .$t['lst_searchSeeAlsoMode'].","   
            .$t['lst_detailShowShortDef'].","    
            ."{$bDef},"     
            .$t['lst_detailShowInterligne'].","            
            .$t['lst_buttonPosition'].","     
            .$t['lst_followPosition'].","                   
            .$t['lst_detailShowSeeAlso'].","     
            .$t['lst_detailSeeAlsoShowing']."," 
            .$t['lst_detailShowProperty']."," 
            .$t['lst_iconolink'].","
            .$t['lst_icolink'].","            
            .$t['lst_icoref'].","                           
            .$t['lst_icosize'].","     
            .$t['lst_intlinkspopup'].","            
            .$t['txt_intlinksheight'].","           
            .$t['txt_intlinkswidth'].","    
            .$t['lst_detailGererVisit'].","    
            .$t['lst_intlinksicon'].","            
            .$t['txt_nbtermebypage'].","  
            .$t['lst_detailSeeAlsoCache'].","            
            .$t['lst_seealsomode'].","  
            .$t['lst_synchroniseterme'].","            
            .$t['lst_intautosubmit'].","
            .$t['lst_sendmail2webmaster']."," 
            ."'{$t['txt_mail4webmaster']}',"
            .$t['lst_showcategory'].","
            .$t['txt_noteMin'].","   
            .$t['txt_noteMax'].","  
            ."'{$t['txt_noteImg']}', "        
            .$t['txt_termeNoteMin'].","   
            .$t['txt_termeNoteMax'].","  
            ."'{$t['txt_termeNoteImg']}', "  
            ."{$t['editor']}, "            
            ."{$bdooptions}, "            
            ."{$bdosmiley}, "            
            ."{$bdohtml}, "            
            ."{$bdoxcode}, "   
            ."{$bdoimage}, "            
            ."{$bdobr}"                     
            .")";
          
      $xoopsDB->query($sql);
    
  }else{
      $sql = "UPDATE ".$xoopsDB->prefix(_LEX_TBL_LEXIQUE)." SET "
           ."name        = '{$t['txtName']}',"
           ."icone       = '{$t['lstIcones']}',"           
           ."introtext   = '{$t['txtIntrotext']}',"           
           ."Actif       = {$t['txtActif']}, "
           ."ordre       = {$t['txt_ordre']},"
           ."idFamily    = {$t['txtFamily']}, "
           ."idSelecteur = {$t['txtSelecteur']}, "
           ."idCaption   = {$t['txtCaption']}, "    
           ."idProperty  = {$t['txtProperty']}, "                  
           ."nbmsgbypage = {$t['txt_nbmsgbypage']}, "
           ."xoopsSearch = {$bSearch}, "           
           ."searchSeeAlsoMode    = {$t['lst_searchSeeAlsoMode']}, "      
           ."detailShowShortDef   = {$t['lst_detailShowShortDef']}, "    
           ."detailShowDefinition = {$bDef}, "       
           ."detailShowInterligne = {$t['lst_detailShowInterligne']}, "           
           ."buttonPosition       = {$t['lst_buttonPosition']}, "
           ."followPosition       = {$t['lst_followPosition']}, "           
           ."detailShowSeeAlso    = {$t['lst_detailShowSeeAlso']}, "     
           ."detailSeeAlsoShowing = {$t['lst_detailSeeAlsoShowing']}, "   
           ."detailShowProperty   = {$t['lst_detailShowProperty']}, "             
           ."iconolink   = {$t['lst_iconolink']}, "           
           ."icolink     = {$t['lst_icolink']}, "           
           ."icoref      = {$t['lst_icoref']}, "           
           ."icosize     = {$t['lst_icosize']}, "          
           ."intlinkspopup     = {$t['lst_intlinkspopup']}, "           
           ."intlinksheight    = {$t['txt_intlinksheight']}, "           
           ."intlinkswidth     = {$t['txt_intlinkswidth']}, "      
           ."detailGererVisit    = {$t['lst_detailGererVisit']}, "           
           ."intlinksicon        = {$t['lst_intlinksicon']}, "     
           ."nbtermebypage       = {$t['txt_nbtermebypage']}, "           
           ."detailSeeAlsoCache  = {$t['lst_detailSeeAlsoCache']}, "           
           ."seealsomode         = {$t['lst_seealsomode']}, "           
           ."synchroniseterme    = {$t['lst_synchroniseterme']}, "           
           ."intautosubmit       = {$t['lst_intautosubmit']}, "           
           ."sendmail2webmaster  = {$t['lst_sendmail2webmaster']}, "           
           ."mail4webmaster      = '{$t['txt_mail4webmaster']}', "    
           ."showcategory        = {$t['lst_showcategory']}, "     
           ."noteMin             = {$t['txt_noteMin']}, "
           ."noteMax             = {$t['txt_noteMax']}, "           
           ."noteImg             = '{$t['txt_noteImg']}',"     
           ."termeNoteMin        = {$t['txt_termeNoteMin']}, "
           ."termeNoteMax        = {$t['txt_termeNoteMax']}, "           
           ."termeNoteImg        = '{$t['txt_termeNoteImg']}',"    
           ."editor              = {$t['editor']},"            
           ."dooptions           = {$bdooptions}, "       
           ."dosmiley            = {$bdosmiley}, " 
           ."dohtml              = {$bdohtml}, "       
           ."doxcode             = {$bdoxcode}, " 
           ."doimage             = {$bdoimage}, "           
           ."dobr                = {$bdobr} "           
           ."WHERE idLexique = ".$idLexique;
           
      $xoopsDB->query($sql);         
      //echo "<hr>{$sql}<hr>"; exit ;   
            
  }
           

}
/****************************************************************
 *
 ****************************************************************/

function newLexique () {
	Global $xoopsModuleConfig, $xoopsDB, $xoopsConfig, $xoopsModule;
	
	$sql = "INSERT INTO ".$xoopsDB->prefix(_LEX_TBL_LEXIQUE)." "
	      ."(name,Ordre,Actif) "
	      ."VALUES ('???',0,0)";
	
       $xoopsDB->query($sql);	

  
}

/****************************************************************
 *
 ****************************************************************/

function deleteLexique ($id) {
	Global $xoopsModuleConfig, $xoopsDB, $xoopsConfig, $xoopsModule;
	
	$sql = "DELETE FROM ".$xoopsDB->prefix(_LEX_TBL_LEXIQUE)." "
	      ."WHERE idLexique = ".$id;
	
       $xoopsDB->query($sql);	

	
  //redirect_header("admin_lexique.php?op=edit",1,_AD_LEX_ADDOK);	
  
}


/****************************************************************
 *
 ****************************************************************/

function clearLexique ($id) {
	Global $xoopsModuleConfig, $xoopsDB, $xoopsConfig, $xoopsModule;
	
	$sql = "DELETE FROM ".$xoopsDB->prefix(_LEX_TBL_TERME)." "
	      ."WHERE idLexique = ".$id;
	
       $xoopsDB->query($sql);	

  
}

/****************************************************************************
 *
 ****************************************************************************/
function getGifFiles($defaut = ''){

  $folder = _LEX_ROOT_PATH.'images/lexIcones/';
  //$onChange = "changeImgFromList(\"imgIcone\", \"lstIcones\", \""._LEX_URL_LEXICONES."\");";
  $onChange = "changeImgFromList(\"imgIcone\", \"lstIcones\", \""._LEX_URL_LEXICONES."\", \"\");"; 
  return  htmlFilesList ($defaut, $folder, 'gif', $onChange);

}
 
/****************************************************************************
 *
 ****************************************************************************/
function getLexique ($idLexique){
	global $xoopsModuleConfig, $xoopsDB;

  if ($idLexique == 0) {
      $p = array ('idLexique'   => 0, 
                  'idFamily'    => 0,
                  'idSelecteur' => 0,
                  'idCaption'   => 0,  
                  'idProperty'  => 0,                                  
                  'name'        => 'nom du lexique',
                  'icone'       => '',                  
                  'introtext'   => '',                  
                  'actif'       =>  0,
                  'ordre'       => 99,
                  'nbmsgbypage' => 10, 
                  'xoopsSearch' =>  3,                  
                  'searchSeeAlsoMode'    => 1,
                  'detailShowShortDef'   => 1,
                  'detailShowDefinition' => 1,
                  'detailShowInterligne' => 0,
                  'buttonPosition'       => 2,
                  'followPosition'       => 0,                  
                  'detailShowSeeAlso'    => 1,
                  'detailSeeAlsoShowing' => '[]',
                  'detailShowProperty'   => 0,                  
                  'iconolink'  => 6,
                  'icolink'    => 5,
                  'icoref'     => 3,
                  'icosize'    => 0,
                  'intlinkspopup'      => 1,
                  'intlinksheight'     => 420,
                  'intlinkswidth'      => 500,
                  'detailGererVisit'   => 1,
                  'intlinksicon'       => 0,
                  'nbtermebypage'      => 10,          
                  'detailSeeAlsoCache' => 1,      
                  'seealsomode'        => 0,             
                  'synchroniseterme'   => 0,        
                  'intautosubmit'      => 01,           
                  'sendmail2webmaster' => 1,        
                  'mail4webmaster'     => 'jjd@kiolo.com',
                  'showcategory'       => 1,
                  'noteMin'            => 0,
                  'noteMax'            => 0,
                  'noteImg'            => '',
                  'termeNoteMin'       => 0,
                  'termeNoteMax'       => 0,
                  'termeNoteImg'       => '',
                  'editor'             => 99,                  
                  'dooptions'          => 0,
                  'dohtml'             => 7,
                  'dosmiley'           => 7,                  
                  'doxcode'            => 7,
                  'doimage'            => 7,                  
                  'dobr'               => 7                                
                  );

  }
  else {
    	
    $sql = "SELECT  * FROM ".$xoopsDB->prefix(_LEX_TBL_LEXIQUE)." "
          ."WHERE idLexique = ".$idLexique;
  
    //echo "<hr>{$sql}<hr>";          
    $sqlquery=$xoopsDB->query($sql);
    //$p =  $xoopsDB->fetchRow($sqlquery);
    $sqlfetch=$xoopsDB->fetchArray($sqlquery);
    
    $p = $sqlfetch;

   $p['name']      = sql2string ($p['name']);
   $p['introtext'] = sql2string ($p['introtext']);



    
  }
  
  //displayArray ($p, "edition de lexique");  
  //exit;
  return $p;
}

//---------------------------------------------------------------------
//include_once (XOOPS_ROOT_PATH.'/include/jjd/adminOnglet/adminOnglet.php');
$bOk = true;
if ($bOk){admin_xoops_cp_header(_LEX_ONGLET_LEXIQUE, $xoopsModule);}   
    

switch($op) {
  case "list":
		listLexique ();
		break;
		
  case "saveList":
		saveListLexique ($_POST);
    redirect_header("admin_lexique.php?op=list",1,_AD_LEX_ADDOK);		
		break;

  case "new":
		//saveLexique ($_POST);
    $p = getLexique (0);
    
    editLexique ($p);
    //redirect_header("admin_lexique.php?op=edit",1,_AD_LEX_ADDOK);    
		break;

  case "edit":
		//saveLexique ($_POST);
		//echo "<hr>idLexique = {$idLexique}<hr>";
		$p = getLexique ($idLexique);
    editLexique ($p);
    //redirect_header("admin_lexique.php?op=edit",1,_AD_LEX_ADDOK);    
		break;

  case "save":
		saveLexique ($_POST);
    redirect_header("admin_lexique.php?op=list",1,_AD_LEX_ADDOK);		
		break;



  case "remove":
    //xoops_cp_header();
    $msg = sprintf(_AD_LEX_CONFIRM_DEL, "<b>{$_GET['name']} (id:{$idLexique})</b>" , _AD_LEX_LEXIQUES);            
    xoops_confirm(array('op'         => 'removeOk', 
                        'idLexique' => $_GET['idLexique'] ,
                        'ok'         => 1),
                  "admin_lexique.php", $msg );
    //xoops_cp_footer();
    
    break;


  case "removeOk":
		//saveLexique ($_POST);
    //deleteLexique ($id);
    deleteLexique ($_POST['idLexique']);    
    redirect_header("admin_lexique.php?op=list",1,_AD_LEX_ADDOK);    
		break;

  case "clear":
		//saveLexique ($_POST);
    clearLexique ($id);
    redirect_header("admin_lexique.php?op=edit",1,_AD_LEX_ADDOK);    
		break;

  case "duplicate":
		//saveLexique ($_POST);
    $newIdLexique = newClone($idLexique, _LEX_TFN_LEXIQUE, 'idLexique', 'name');
    newCloneChild($idLexique, $newIdLexique, _LEX_TFN_ACCESS, '', 'idLexique');



    
		$p = getLexique ($newIdLexique);
    editLexique ($p);
    
		break;

		
	default:
	 $state = _LEX_STATE_WAIT;
    redirect_header("admin_lexique.php?op=list",1,_AD_LEX_ADDOK);
    break;
}

if ($bOk){admin_xoops_cp_footer();}
?>
