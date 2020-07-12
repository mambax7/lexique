<?php

class cls_lex_2_16{  

/************************************************************
 * declaration des varaibles membre:
 ************************************************************/
  var $version      = '2.16';  
  var $dateVersion  = '2008-08-18 12:12:12'; //date("Y-m-d h:m:s");
  var $description  = 'Gestion des fichiers attachés';

/************************************************************
 * Constructucteur:
 ************************************************************/
  function  cls_lex_2_16($options){
 
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
    
    $this->insertCaptionSet();       
              
    return true;
} // fin updtateModule



/*************************************************************************
 *
 *************************************************************************/
function insertCaptionSet(){
global $xoopsModuleConfig, $xoopsDB;

  $table = $xoopsDB->prefix('lex_captionset');
  $sql = "INSERT INTO {$table} "
       . "(`idCaption` , `code` , `newText` , `state`)"
       . " VALUES (0, 'download', 'Fichiers à télécharger', 1 );";

  $xoopsDB->queryF ($sql);


}

//-----------------------------------------------------------

} // fin de la classe

?>
