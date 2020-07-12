<?php

class cls_lex_2_15{  

/************************************************************
 * declaration des varaibles membre:
 ************************************************************/
  var $version      = '2.15';  
  var $dateVersion  = '2008-08-15 12:12:12'; //date("Y-m-d h:m:s");
  var $description  = 'Modif des table lexique et terme pour prende ecopte html,bbcode,emoticone, ... ';

/************************************************************
 * Constructucteur:
 ************************************************************/
  function  cls_lex_2_15($options){
 
  }
  
/*************************************************************************
 *
 *************************************************************************/
function getVersion()     {return $this->version;}
function getDateVersion() {return $this->dateVersion;}
function getDescription() {return $this->description;}


/*************************************************************************
 *
 *************************************************************************/

function updateModule(&$module){
    
    $this->updateLexique();    
    $this->updateTerme();     
    $this->updateAccess();    
    $this->insertCaptionSet();       
              
    return true;
} // fin updtateModule



/*************************************************************************
 *
 *************************************************************************/
function updateLexique(){
global $xoopsModuleConfig, $xoopsDB;

  //-------------------------------------------  
  $table = $xoopsDB->prefix('lex_lexique');  

  $sql = "ALTER TABLE {$table}"
        ." ADD `followPosition` tinyint DEFAULT '0' NOT NULL, "
        ." ADD `editor`    tinyint(1) default '99',"  
        ." ADD `dooptions` tinyint(1) default '0',"        
        ." ADD `dohtml`    tinyint(1) default '1',"  
        ." ADD `dosmiley`  tinyint(1) default '1',"  
        ." ADD `doxcode`   tinyint(1) default '1',"  
        ." ADD `doimage`   tinyint(1) default '1',"  
        ." ADD `dobr`      tinyint(1) default '1' ";
  
  $xoopsDB->queryF ($sql);  
  //--------------------------------------------------  
  return true;   
   
}//fin update
/*************************************************************************
 *
 *************************************************************************/
function updateTerme(){
global $xoopsModuleConfig, $xoopsDB;

  //-------------------------------------------  
  $table = $xoopsDB->prefix('lex_terme');  
  
  $sql = "ALTER TABLE {$table}"
        ." ADD `dooptions` tinyint(1) default '0',"  
        ." ADD `dohtml`    tinyint(1) default '1',"  
        ." ADD `dosmiley`  tinyint(1) default '1',"  
        ." ADD `doxcode`   tinyint(1) default '1',"  
        ." ADD `doimage`   tinyint(1) default '1',"  
        ." ADD `dobr`      tinyint(1) default '1' ";
  
  $xoopsDB->queryF ($sql);  
  //--------------------------------------------------  
  return true;   
   
}//fin update
/*************************************************************************
 *
 *************************************************************************/
function insertCaptionSet(){
global $xoopsModuleConfig, $xoopsDB;

  $table = $xoopsDB->prefix('lex_captionset');
  $sql = "INSERT INTO {$table} "
       . "(`idCaption` , `code` , `newText` , `state`)"
       . " VALUES (0, 'follow', 'Lire la suite...', 1 );";

  $xoopsDB->queryF ($sql);


}
/*************************************************************************
 *
 *************************************************************************/
function updateAccess(){
global $xoopsModuleConfig, $xoopsDB;

  //-------------------------------------------  
  $table = $xoopsDB->prefix('lex_access');  
  
  $sql = "ALTER TABLE {$table}"
        ." ADD `readButtonsTlb`  BIGINT NOT NULL DEFAULT '0',"  
        ." ADD `readButtonsList` BIGINT NOT NULL DEFAULT '0',"  
        ." ADD `readButtonsForm` BIGINT NOT NULL DEFAULT '0'";
        
  $xoopsDB->queryF ($sql);  
  //--------------------------------------------------  
  return true;   
   
}//fin update

//-----------------------------------------------------------

} // fin de la classe

?>
