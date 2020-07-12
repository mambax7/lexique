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

//-------------------------------------------------------------
$vars = array(array('name' => 'op',        'default' => 'list'),
              array('name' => 'idLexique', 'default' => 0),
              array('name' => 'id',        'default' => 0),
              array('name' => 'pinochio',  'default' => false));
              
require (_LEX_JJD_PATH."include/gp_globe.php");

//-------------------------------------------------------------

//---------------------------------------------------------------------
/**********************************************************************
 *
 **********************************************************************/

function listAccess($idLexique, $access = 255){
//$acces permet d decouper en plusiers page pour le seveur qu limitent le nombre d'objet dans le form

	Global $xoopsModuleConfig, $xoopsDB, $xoopsConfig, $xoopsModule,$info;
  if ($access == 0) $access = 255;
  //----------------------------------------------------------
  //initialisation des parametres et tableaux
  //----------------------------------------------------------  
  getLexInfo ($idLexique, $info, '');
  getCaption ($info['idCaption'], $libelle);

  $ta = getAAccessValues($idLexique);
    
  $groups = getListGroupes(1);
  //---------------------------------------------------
  $optionsGen = getListOptionsButtons(0);
  
  $buttonsTlb = getListOptionsButtons(1);  
  $buttonsItem = getListOptionsButtons(2);  
    
  $lexOptions = getListOptionsGenerales($libelle);
 
  $Property   = getListProperty($info['idProperty']);
  //------------------------------------------------------------
  //insertion des scriopt javascript  
 
	  //xoops_cp_header();
    OpenTable();  
 echo _LEX_JSI_LEXIQUE._JJD_JSI_TOOLS._JJD_JSI_SPIN;
      
//echo "<B>idLexique ------------->{$idLexique}---{$info['idCaption']}-</B><br>";    
	  echo "<B>"._AD_LEX_ADMIN." ".$xoopsConfig['sitename']."</B><br>";
  	echo "<B>"._AD_LEX_ACCESS_MANAGEMENT." : {$info['name']}</B>";
		echo "<FORM ACTION='admin_access.php?op=save&idLexique={$idLexique}&access={$access}' METHOD=POST>";
   CloseTable();
    //OpenTable();   
    //echo "<table width='80%'>"._br;     
  $h = -1;  
  //------------------------------------------------------------	
  //echo "access = <h>{$access}<hr>";
	
  $h++;
  if (isbitOk($h, $access)){
    buildDataArray(_AD_LEX_PERMISSIONS_OPTIONS,'gen', $optionsGen, $groups, $ta['buttonAccess']);    
  	buildDataArray(_AD_LEX_PERMISSIONS_TLB,'tlb', $buttonsTlb, $groups, $ta['readButtonsTlb']);
  
  }
  

  $h++;
  if (isbitOk($h, $access)){
  	buildDataArray(_AD_LEX_PERMISSIONS_BTN_LIST,'btnList', $buttonsItem, $groups, $ta['readButtonsList']); 
   	buildDataArray(_AD_LEX_PERMISSIONS_BTN_FORM,'btnForm', $buttonsItem, $groups, $ta['readButtonsForm']);  
  
  }

  $h++;
  if (isbitOk($h, $access)){
  	buildDataArray(_AD_LEX_PERMISSIONS_DEF_LIST,'lexList', $lexOptions, $groups, $ta['readAccessList']); 
   	buildDataArray(_AD_LEX_PERMISSIONS_DEF_FORM,'lexForm', $lexOptions, $groups, $ta['readAccessForm']);  
  
  }
  
	
  $h++;
	if (isbitOk($h, $access) & $info['idProperty'] <> 0 ) {
      buildDataArray(_AD_LEX_PERMISSIONS_PPT_LIST,'pptList', $Property, $groups, $ta['readPropertyList']); 
    	buildDataArray(_AD_LEX_PERMISSIONS_PPT_FORM,'pptForm', $Property, $groups, $ta['readPropertyForm']);  
  
  }
	
   
  //------------------------------------------------------------      

  OpenTable();    
echo "<TABLE BORDER=0 CELLPADDING=2 CELLSPACING=3>
  <tr valign='top'>
    <td align='left' ><input type='button' name='cancel' value='"._CLOSE."' onclick='".buildUrlJava("admin_lexique.php",false)."'></td>
    <td align='left' width='200'></td>
    <td align='right'><input type='submit' name='submit' value='"._AD_LEX_VALIDER."'></td>
  </tr>
  
  </table>";
  

  echo "</form>";
    
	CloseTable();
	//xoops_cp_footer();
  
}
/**********************************************************************
 *
 **********************************************************************/
function buildDataArray($titre,$prefixe,$aRowHead, $aColHead,$aDefaut){
$bv="||";
$bh="<hr>";

  OpenTable();  
  //----------------------------------
  echo "<table><tr><td><b>{$titre}</b></td></tr></table>";
  echo '<hr>';
	//CloseTable();  
  //OpenTable();	
  echo "<table border='2' bordercolor='#808080'  cellspacing='1' cellpadding='4'>";
  //---------------------------------------------------------    
    //---------------------------------------------------
    echo "<tr><td align='center' rowspan='2'><b></b></td>";  

    for ($c=0; $c<count($aColHead);$c++){
      echo '<td align = center>';
      $title = str_replace(' ', '<br>', $aColHead[$c]['name']);
      echo "{$title}";      
      echo '</td>';      
    }  
 
    $title = str_replace(' ', '<br>', _AD_LEX_FILLROW);         
    echo "<td align = center>{$title}</td>";    
    
    echo "</tr>";
    //---------------------------------------------------
    //echo "<tr><td> </td>";  
    for ($c=0; $c<count($aColHead);$c++){
      echo '<td align = center>';
      echo "{$aColHead[$c]['id']}";      
      echo '</td>';      
    }  
 
    echo '<td align = center>(*)</td>';    
    
    echo "</tr>";
    //---------------------------------------------------




  
//displayArray2($aRowHead,'-----aRowHead-----------');  
  $lastRow = count($aRowHead)-1;
  $maxGid = 0;
  for ($r=0; $r<count($aRowHead);$r++){
    echo "<tr><td>{$aRowHead[$r]['name']}</td>";  

    for ($c=0; $c< count($aColHead);$c++){
      echo '<td align = center>';      
      
      $gid = $aColHead[$c]['id'];
      if ($maxGid < $gid){$maxGid = $gid;}
      $value = 'unchecked';
      if (isset($aDefaut[$gid])){
        if (isByteOk($r, $aDefaut[$gid]) ){
            $value = 'checked';        
        }

      }

      $name = "{$prefixe}{$gid}_{$r}";      

    echo "<input type='checkbox' NAME='{$name}' size='5%' {$value}>"._br;

      
      echo '</td>';      
    }  
    //--------------------------------------------------------    
    //ajout de la coche pour cocher toute la ligne
    
    echo '<td align = center>';
    $name = "{$prefixe}checkH_{$r}";
    $oc = "checkFromTo(\"{$prefixe}\", {$r}, {$r}, 1, {$maxGid}, \"{$name}\", 1);";
    echo "<input type='checkbox' NAME='{$name}' size='5%' onclick='{$oc}'>"._br;  
    echo '</td>';        
    //--------------------------------------------------------
    echo "</tr>";
    //--------------------------------------------------------    
  }
  
  //--------------------------------------------------------
  //ajout de la coche pour cocher toute la colonne  
  echo "<tr><td>"._AD_LEX_FILLCOL."</td>";  
    //echo "<tr><td>zzzzzzz</td>";    
    for ($c=0; $c< count($aColHead);$c++){
      echo '<td align = center>'; 
      $gid = $aColHead[$c]['id'];     
      $name = "{$prefixe}checkV_{$gid}";
      $oc = "checkFromTo(\"{$prefixe}\", 0, {$lastRow}, {$gid}, {$gid}, \"{$name}\", 1);";
      echo "<input type='checkbox' NAME='{$name}' size='5%' onclick='{$oc}'>"._br;  
      echo '</td>';        
      //--------------------------------------------------------
    }
    //--------------------------------------------------------    
    //ajout de la coche pour tout cocher (en bas a droite))

    echo '<td align = center>';
    $name = "{$prefixe}checkT_0";
    $oc = "checkFromTo(\"{$prefixe}\", 0, {$lastRow}, 1, {$maxGid}, \"{$name}\", 1);";
    echo "<input type='checkbox' NAME='{$name}' size='5%' onclick='{$oc}'>"._br;  
    echo '</td>';        
    //--------------------------------------------------------
    echo "</tr>";
    //--------------------------------------------------------    
  
  
  
  //---------------------------------------------------------
  echo "</table>";  


  //echo "</td></tr>";  
	CloseTable();  
}

/**********************************************************************
 *renvoi 3 tableaux de valeurs
 **********************************************************************/
function getAAccessValues($idLexique){ 
	global $xoopsModuleConfig, $xoopsDB;

    $sql = "SELECT  * FROM ".$xoopsDB->prefix(_LEX_TBL_ACCESS)
          ." WHERE idLexique = {$idLexique}"
          ." ORDER BY idGroup";
    $sqlquery = $xoopsDB->queryF($sql);  



    $buttonAccess      = array();
    $readButtonsTlb    = array();
    
    $readButtonsList   = array();
    $readAccessList    = array();
    $readPropertyList  = array();
    
    $readButtonsForm   = array();
    $readAccessForm    = array();
    $readPropertyForm  = array();
    

    
    //$isDefine      = array();
               
    while ($sqlfetch = $xoopsDB->fetchArray($sqlquery)) {
      //$isDefine    [$sqlfetch ['idGroup']] = $sqlfetch ['isDefine'];   
      
      $buttonAccess   [$sqlfetch ['idGroup']] = $sqlfetch ['buttonAccess'];      
      $readButtonsTlb [$sqlfetch ['idGroup']] = $sqlfetch ['readButtonsTlb'];

      $readButtonsList  [$sqlfetch ['idGroup']] = $sqlfetch ['readButtonsList'];             
      $readAccessList   [$sqlfetch ['idGroup']] = $sqlfetch ['readAccessList'];
      $readPropertyList [$sqlfetch ['idGroup']] = $sqlfetch ['readPropertyList'];      

      $readButtonsForm  [$sqlfetch ['idGroup']] = $sqlfetch ['readButtonsForm'];
      $readAccessForm   [$sqlfetch ['idGroup']] = $sqlfetch ['readAccessForm'];
      $readPropertyForm [$sqlfetch ['idGroup']] = $sqlfetch ['readPropertyForm'];      
      

      
        
 
    }
    $ta = array('buttonAccess'     => $buttonAccess,
                'readButtonsTlb'   => $readButtonsTlb,
                'readButtonsList'  => $readButtonsList,                
                'readAccessList'   => $readAccessList,                
                'readPropertyList' => $readPropertyList,                
                'readButtonsForm'  => $readButtonsForm,
                'readAccessForm'   => $readAccessForm,               
                'readPropertyForm' => $readPropertyForm);   
    return $ta;
 }
//--------------------------------------------------------------------------- 
 
 /*

 function getAccessValues($idLexique, &$buttonAccess, &$readAccessList, &$readPropertyList){ 
	global $xoopsModuleConfig, $xoopsDB;

    $sql = "SELECT  idGroup, isDefine, buttonAccess, readAccessList, readPropertyList FROM "
          .$xoopsDB->prefix(_LEX_TBL_ACCESS)
          ." WHERE idLexique = {$idLexique}"
          ."   ORDER BY idGroup";
    $sqlquery = $xoopsDB->queryF($sql);  
//echo $sql.'<br>';
    $readAccessList    = array();
    $readPropertyList  = array();
    $buttonAccess  = array();
    //$isDefine      = array();
               
    while ($sqlfetch = $xoopsDB->fetchArray($sqlquery)) {
      //$isDefine    [$sqlfetch ['idGroup']] = $sqlfetch ['isDefine'];    
      $readAccessList  [$sqlfetch ['idGroup']] = $sqlfetch ['readAccessList'];
      $buttonAccess[$sqlfetch ['idGroup']] = $sqlfetch ['buttonAccess'];  
      $readPropertyList[$sqlfetch ['idGroup']] = $sqlfetch ['readPropertyList']; 
    }
      
 }
 */
/**********************************************************************
 *renvoi un tableau avec comme cl‚ le nom de l'options g‚n‚ral
 *comme valeur in num‚ro de byte
 **********************************************************************/
function getListOptionsGenerales($libelle){ 

  $sep = '->';

	$titles = array(_AD_LEX_DEFINITION1.$sep.$libelle[_LEX_LANG_DEFINITION1],
                  _AD_LEX_DEFINITION2.$sep.$libelle[_LEX_LANG_DEFINITION2],
                  _AD_LEX_DEFINITION3.$sep.$libelle[_LEX_LANG_DEFINITION3],
                  _AD_LEX_SHORTDEF2.$sep.$libelle[_LEX_LANG_SHORTDEF2],
                  _AD_LEX_CATEGORYS.$sep.$libelle[_LEX_LANG_CATEGORYS],	
                  _AD_LEX_SEEALSO2.$sep.$libelle[_LEX_LANG_SEEALSO2],
                  _AD_LEX_DOWNLOAD.$sep.$libelle[_LEX_LANG_DOWNLOAD]);	


//_AD_LEX_FOLLOW
//_AD_LEX_BUTTONS
  return getListOptions($titles);	
}
/**********************************************************************
 *renvoi un tableau avec comme cl‚ le nom de l'options g‚n‚ral
 *comme valeur in num‚ro de byte
 **********************************************************************/

function getListOptions($titles){
	Global $xoopsModuleConfig, $xoopsDB, $xoopsConfig, $xoopsModule;	
 
    //------------------------------------------------        
    $t = array();
    for ($h = 0; $h < count($titles); $h++){
      //$t[$titles[$h]] = $h;   
      $t[] = array ('name' => $titles[$h] , 'id' => $h);       
    }
    return $t;    
}

/**********************************************************************
 *renvoi un tableau avec comme cl‚ le nom de l'options g‚n‚ral
 *comme valeur in num‚ro de byte
 *$mode = 0 option générales dont la visibilité du lexique selon le groupe
 *$mode = 1 boutons dans la barre principale en haut à droite
 *$mode = 2 bouton dans les listes   
 **********************************************************************/

function getListOptionsButtons($mode){
  $t = array();
  
  switch ($mode){
  case 0:
    $t[] = array ('name' =>  _AD_LEX_VISIBLE_IN_GROUP,    'id' => _LEXBTN_VISIBLE_IN_GROUP);  
    
    break;
    
  case 1:
  case 2:
    $t[] = array ('name' =>  _AD_LEX_TLB_HOME_BIBLIO,     'id' => _LEXBTN_HOME_BIBLIO);                  	
    $t[] = array ('name' =>  _AD_LEX_TLB_HOME_LEXIQUE,    'id' => _LEXBTN_HOME_LEXIQUE);
    $t[] = array ('name' =>  _AD_LEX_TLB_SEARCH,          'id' => _LEXBTN_SEARCH);  
    $t[] = array ('name' =>  _AD_LEX_TLB_ADD,             'id' => _LEXBTN_NEW);                  	
    $t[] = array ('name' =>  _AD_LEX_TLB_ASK_DEF,         'id' => _LEXBTN_ASKDEF); 
    $t[] = array ('name' =>  _AD_LEX_TLB_FRIENDSEND_LEX,  'id' => _LEXBTN_SENDMAIL_LEX); 
    $t[] = array ('name' =>  _AD_LEX_NOTE_LEX,            'id' => _LEXBTN_NOTE_LEX);    
    $t[] = array ('name' =>  _AD_LEX_TLB_ADMIN,           'id' => _LEXBTN_ADMIN);
    if ($mode == 1) break;
    
    $t[] = array ('name' =>  _AD_LEX_VIEW,            'id' => _LEXBTN_VIEW);
    $t[] = array ('name' =>  _EDIT,                   'id' => _LEXBTN_EDIT);
    $t[] = array ('name' =>  _DELETE,                 'id' => _LEXBTN_DELETE);
    $t[] = array ('name' =>  _AD_LEX_MOVE_DEF,        'id' => _LEXBTN_MOVE_DEF);  
    $t[] = array ('name' =>  _AD_LEX_PRINT,           'id' => _LEXBTN_PRINT);
    $t[] = array ('name' =>  _AD_LEX_FRIENDSEND,      'id' => _LEXBTN_SENDMAIL);
    $t[] = array ('name' =>  _COMMENTS,               'id' => _LEXBTN_COMMENT);
    $t[] = array ('name' =>  _AD_LEX_FOLLOW,          'id' => _LEXBTN_FOLLOW);
    
    $t[] = array ('name' =>  _AD_LEX_SHOW_VISIT,      'id' => _LEXBTN_SHOWVISIT);  
    $t[] = array ('name' =>  _AD_LEX_SHOW_ID,         'id' => _LEXBTN_SHOWOPTION);
    $t[] = array ('name' =>  _AD_LEX_NOTE_TERME,      'id' => _LEXBTN_NOTE_TERME);    
    $t[] = array ('name' =>  _AD_LEX_ATTACH_FILES,    'id' => _LEXBTN_FILES);  
    break;    
  }
  
  

  




  return $t;

}


//----------------------------------------------------------------------



/**********************************************************************
 *renvoi un tableau avec comme cl‚ le nom de la propri‚t‚
 *comme valeur in num‚ro de byte correspondant au byteAccess de la table
 **********************************************************************/
function getListProperty($idProperty){
	Global $xoopsModuleConfig, $xoopsDB, $xoopsConfig, $xoopsModule;
  
    $sql = "SELECT * FROM ".$xoopsDB->prefix(_LEX_TBL_PROPERTYSET)
          ." WHERE idProperty = {$idProperty}"
          ." ORDER BY showOrder";
    $sqlquery=$xoopsDB->query($sql);  
  
    $t = array();
    while ($sqlfetch=$xoopsDB->fetchArray($sqlquery)) {
      $t[] = array ('name' =>  $sqlfetch['name'], 'id' => $sqlfetch['byteAccess']);      
    }  
  
    return $t;    
}

/**********************************************************************
 *
 **********************************************************************/

function saveAccess ($t, $access) {
	Global $xoopsModuleConfig, $xoopsDB, $xoopsConfig, $xoopsModule;
  
  $groups = getListGroupes (1);
  $idLexique = $t['idLexique'];
  //-----------------------------------------------------------
 
  //-----------------------------------------------------------
  for ($h = 0; $h < count($groups); $h++){
    $idg = $groups[$h]['id'];
    $bitAccess = -1;
    //-----------------------------------------------------------  
    $filter = " WHERE idLexique = {$idLexique} "
             ."   AND idGroup = {$idg}"; 
            
    $sql0 = "SELECT * FROM ".$xoopsDB->prefix(_LEX_TBL_ACCESS)
           .$filter;
    
    $sqlquery = $xoopsDB->query($sql0);
    $nbEnr = $xoopsDB->getRowsNum($sqlquery);
    if ($nbEnr == 0){
      $sql2 = "INSERT INTO ".$xoopsDB->prefix(_LEX_TBL_ACCESS)
            ."(idLexique,idGroup,isDefine)"
            ."VALUES ({$idLexique},{$idg},1)";          
      $sqlquery = $xoopsDB->queryF($sql2);    
    }    
    //-----------------------------------------------------------
    $bitAccess++;
    if (isbitOk($bitAccess, $access)){
      $gen     = checkBoxToBin($t, "gen{$idg}", $def2);    
      $tlb     = checkBoxToBin($t, "tlb{$idg}", $def2);

      $sql2 = "UPDATE ".$xoopsDB->prefix(_LEX_TBL_ACCESS)." SET "
             ."isDefine = 1,"
             ."buttonAccess = {$gen},"
             ."readButtonsTlb = {$tlb}"
             .$filter;
      $sqlquery = $xoopsDB->queryF($sql2);    
    }
    
    $bitAccess++;
    if (isbitOk($bitAccess, $access)){
      $btnList = checkBoxToBin($t, "btnList{$idg}", $def1);
      $btnForm = checkBoxToBin($t, "btnForm{$idg}", $def1);

      $sql2 = "UPDATE ".$xoopsDB->prefix(_LEX_TBL_ACCESS)." SET "
             ."isDefine = 1,"
             ."readButtonsList = {$btnList},"
             ."readButtonsForm = {$btnForm}"
             .$filter;
      $sqlquery = $xoopsDB->queryF($sql2);    
    
    }
    
    $bitAccess++;
    if (isbitOk($bitAccess, $access)){
      $lexList = checkBoxToBin($t, "lexList{$idg}", $def1);
      $lexForm = checkBoxToBin($t, "lexForm{$idg}", $def1);

      $sql2 = "UPDATE ".$xoopsDB->prefix(_LEX_TBL_ACCESS)." SET "
             ."isDefine = 1,"
             ."readAccessList = {$lexList},"
             ."readAccessForm = {$lexForm}"
             .$filter;
      $sqlquery = $xoopsDB->queryF($sql2);    
    
    }
    
    $bitAccess++;
    if (isbitOk($bitAccess, $access)){
      $pptList = checkBoxToBin($t, "pptList{$idg}", $def3);  
      $pptForm = checkBoxToBin($t, "pptForm{$idg}", $def3);    

      $sql2 = "UPDATE ".$xoopsDB->prefix(_LEX_TBL_ACCESS)." SET "
             ."isDefine = 1,"
             ."readPropertyList = {$pptList},"
             ."readPropertyForm = {$pptForm}"
             .$filter;
      $sqlquery = $xoopsDB->queryF($sql2);    
    
    }
    
    
    
    
    
//echo "<hr>access = {$h}-{$access}<br>{$sql2}<hr>";    


  }
  waitAndSee('admin_lexique.php');
}

/**********************************************************************
 *
 **********************************************************************/

function saveAccess2 ($t) {
	Global $xoopsModuleConfig, $xoopsDB, $xoopsConfig, $xoopsModule;
  
  $groups = getListGroupes (1);
  $idLexique = $t['idLexique'];
  //-----------------------------------------------------------
 
  //-----------------------------------------------------------
  for ($h = 0; $h < count($groups); $h++){
    $idg = $groups[$h]['id'];
    
    $gen     = checkBoxToBin($t, "gen{$idg}", $def2);    
    $tlb     = checkBoxToBin($t, "tlb{$idg}", $def2);
    
    $btnList = checkBoxToBin($t, "btnList{$idg}", $def1);
    $btnForm = checkBoxToBin($t, "btnForm{$idg}", $def1);
    
    $lexList = checkBoxToBin($t, "lexList{$idg}", $def1);
    $lexForm = checkBoxToBin($t, "lexForm{$idg}", $def1);
    
    $pptList = checkBoxToBin($t, "pptList{$idg}", $def3);  
    $pptForm = checkBoxToBin($t, "pptForm{$idg}", $def3);    
echo "{lexList}-{lexForm}-{$pptList}-{$pptForm}<hr>";    
    $sql1 = "DELETE FROM ".$xoopsDB->prefix(_LEX_TBL_ACCESS)
           ." WHERE idLexique = {$idLexique} "
           ."   AND idGroup = {$idg}";
    $sql2 = "INSERT INTO ".$xoopsDB->prefix(_LEX_TBL_ACCESS)
          ."(idLexique,idGroup,isDefine,"
          ."buttonAccess, readButtonsTlb,"
          ."readButtonsList,readAccessList,readPropertyList,"
          ."readButtonsForm,readAccessForm,readPropertyForm)"
          ."VALUES ("
          ."{$idLexique},{$idg},1,"
          ."{$gen},{$tlb},"          
          ."{$btnList},{$lexList},{$pptList},"          
          ."{$btnForm},{$lexForm},{$pptForm})";          


    $xoopsDB->query($sql1);       
    $xoopsDB->query($sql2);         
  }
  waitAndSee('admin_lexique.php');
}

/**********************************************************************
 *
 **********************************************************************/
function waitAndSee($url2Redirect){

    Global $xoopsModuleConfig, $xoopsDB, $xoopsConfig, $xoopsModule;
    
    echo "<FORM ACTION='{$url2Redirect}' METHOD=POST>";
    echo "<input type='submit' name='submit' value='"._AD_LEX_VALIDER."'>";
    echo "</form>";  
  
}


//---------------------------------------------------------------------
$bOk = true;
if ($bOk){admin_xoops_cp_header(_LEX_ONGLET_LEXIQUE, $xoopsModule);}   

switch($op) {

  case "list":
    listAccess($idLexique, $gepeto['access']);
    break;
    
  case "save":
    saveAccess($gepeto, $gepeto['access']);
    redirect_header("admin_lexique.php",1,_AD_LEX_ADDOK);    
    break;

}


if ($bOk){admin_xoops_cp_footer();}   


?>
