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

define ('_bo',  '<');  
define ('_bof', '</');
define ('_bf',  '>');
define ('_cr',  chr(13));





class clsHtmldoc{  
var $lines;
var $pile;

/************************************************************
 * declaration des varaibles membre:
 * - le tableau de lignes
 * - la pile de balise a fermer  
 ************************************************************/

  function clsHtmldoc (){
    $this->lines = array();
    $this->pile  = array();
    //$this.clear();
  }

/************************************************************
 * initialise les vaiables membres
 ************************************************************/
  function clear (){
    
    $this->lines = array();
    $this->pile  = array();
    
  }




/************************************************************
 * ajoute une balise les attributs et la variable
 * si bClose =true empile la balise fermante 
 ************************************************************/
function addBaliseA ($balise, $attribut = '', $value='', $bClose = false, $paragraphe = false){
    
    $b = explode(';', $balise);

    
    for ($h = 0; $h < count($b); $h++){
      $l = '';      
      if ($h == 0 ){
        $l .=  _bo.$b[$h]." ".$attribut._bf;        
      }
      else{
        $l .=  _bo.$b[$h]._bf;        
      }
    
      $this->lines[] = $l._br;  
      $this->pile[] = _bof.$b[$h]._bf._br;      
    }
    
    $l =  _bo.$balise." ".$attribut._bf;
    if ($value <> ''){$this->lines[] = $value;}    
    
    if ($bClose){$this->depile(count($b));} 

    if ($paragraphe){$this->lines[] = '<p>';}   
} //---fin function
  

/************************************************************
 * ajoute une balise les attributs et la variable
 * si bClose =true empile la balise fermante 
 ************************************************************/
function addBalise ($balise, $attribut = '', $value='', $bClose = false){
    
    $l =  _bo.$balise." ".$attribut._bf;
    if ($value <> ''){$l .= $value;}    
    
    if ($bClose){$l .= _bof.$balise._bf;} 
    else{$this->pile[] = _bof.$balise._bf._br;}
  
    $this->lines[] = $l._br;
      
} //---fin function
  

/************************************************************
 * ajoute une balise les attributs et la variable
 * si bClose =true empile la balise fermante 
 ************************************************************/
function addSingleBalises ($balises){
    
   $b = explode(';', $balise);

    
    for ($h = 0; $h < count($b); $h++){
      $this->lines[] = _bo.$b[$h]._bf;
      $this->pile[]  = _bof.$b[$h]._bf._br;          
    }
    
      
} //---fin function
  
/************************************************************
 *
 ************************************************************/
function add ($text, $br=true, $frameBalise = '',$nbBalise2close = 0){
    addSingleBalises ($frameBalise);
    $this->lines[] = $text.(($br)?"<br>":"")._br;
    if ($nbBalise2close > 0){$this->depile($nbBalise2close);}   
    
    //$this->displayLines ();
    
} //---fin function

/************************************************************
 *
 ************************************************************/
function addInput ($text, $attribut = '', $br=true, $nbBalise2close = 0){
    
    $this->lines[] = _bo.'input '.$attribut._bf
                    .(($br)?"<br>":"")._br;
    if ($nbBalise2close > 0){$this->depile($nbBalise2close);}   
    
    //$this->displayLines ();
    
} //---fin function




/************************************************************
 *
 ************************************************************/
  function depile($nbToDepile = 0){
    
    for ($h = 0; $h < $nbToDepile AND count($this->pile) > 0; $h++){      
        $this->lines[] = array_pop ($this->pile);
    } 
    
  }//---fin function 
  
/************************************************************
 *
 ************************************************************/
  function close($ob2Close = 0){
    
    if (is_numeric($ob2Close)){
        
        if ($ob2Close == 0){$ob2Close = count($this->pile);}
        //echo   "pile--->".count($this->pile)."  --->2close = ".$ob2Close."<br>";        
        for ($h = 0; $h < $ob2Close AND count($this->pile) > 0; $h++){      
            $this->lines[] = array_pop ($this->pile);
            //echo   "--->".$this->lines[count($this->lines)]."<br>";
        } 
    
    }else{
        while ( array_pop ($this->pile) <> $ob2Close  AND count($this->pile) > 0){    
    } 
    
    }
    
    
  }//---fin function 
  
  
/************************************************************
 *
 ************************************************************/
  function toString($bEcho = true){
    $t = array();
    //t[] = 'eee'
    
    for ($h = 0; $h<= count($this->lines)-1; $h++){
      echo "line = ".$this->lines[$h]."<br>";
      $t[] = $this->lines[$h];
    } 


    for ($h = count($this->pile)-1; $h >= 0; $h--){
      //echo '==>'.$this->pile[$h].'<br>';
      $t[] = $this->pile[$h];
    } 
    /*    
    */    
    //---------------------------------------------------------
    $r = implode ('\n', $t);
    if ($bEcho){echo $r;}
    return $r;
    
  } //---fin function
  
/************************************************************
 *
 ************************************************************/
  function echoString($bClear = true){
    
    for ($h = 0; $h<= count($this->lines)-1; $h++){
      //echo "line = ".$this->lines[$h]."<br>";
      echo $this->lines[$h];
    } 


    for ($h = count($this->pile)-1; $h >= 0; $h--){
      echo $this->pile[$h];
    } 
    
    if ($bClear){$this->clear();}
    
  } //---fin function

/************************************************************
 *
 ************************************************************/
  function displayLines (){
    
    echo "......................................<br>";    
    reset($this->lines);
    while (list($key, $val) = each($this->lines)) {
        echo "$key => $val\n";
    }
    echo "......................................<br>";    

  } //---fin function
  
}  //fin de clsHtmldoc
?>
