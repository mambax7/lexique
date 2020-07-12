
var xhr_object = null;   
function testgetCategory(v){
  alert (getCategory ());
}
/***********************************************************************
 *
************************************************************************/
function getCategory(){
  h=0;
  bStop = false;
  sBin = "";
  
  while (h<50 && bStop == false){
      ob = document.getElementsByName("chk_" + h);
      //alert (ob.length);
      /*
       */
      if (ob.length==0) {
        bStop =  true;        
      }
      else {
        //alert (ob[0].name);  
        sBin += (ob[0].checked)?"1":"0";
      }


  //alert (v);
       // alert (ob[0].name);    
        h ++;
  }
  return sBin;
  }

/***********************************************************************
 *
************************************************************************/
function doRequest(obName, idTochange, sHref) {
//obName: checkBox composer d'un prefixe et d'un idenfiant (idSeealso) ex: chk_999
//isToChange: idTerme de 'expression representee par la checkBox
//sHref: adresse de la page … r‚aficher

//var sHref = "<{$refSeeAlsoo}>";
   //alert("RequOte en cours !");   
   
  //----------------------------------------------------------  
  //recupe de l'objet request 
  xhr_object = get_xhr();
  if (xhr_object == null) return;
  //------------------------------------------------------------------
  ob = document.getElementById("frmLexique");
  //construction des parametres a passer avec l'url en mode get   
  sHref = sHref + "&idTochange=" + idTochange 
                + "&value="      + ob.elements[obName].checked 
                + "&list="       + ob.seeAlsoList.value;
 
 xhr_object.open("GET", sHref , false);   
 xhr_object.send(null);   
 
 //analyse du r‚sultat de la requete
 //c'est un chaine de valeur separe par des pipe (|)
 if(xhr_object.readyState == 4) {
      var resultat = xhr_object.responseText;
      
      var h = resultat.indexOf("|", 0);
      var i = resultat.indexOf("|", h+1);
      var j = resultat.indexOf("|", i+1);
      
      //recupe de la iste d'identifiant
      ob.seeAlsoList.value = resultat.substr(h+1, i-h-1);
      
      //recupe de la liste des terme et transforamtion des caracteres accentues
      sList = resultat.substr(i+1, j-i-1);
      sList = transformEntites (sList);
      
      ob.seealso.value   = sList;  
          
      }  

   //alert("RequOte en cours !");

}

/***********************************************************************
 *
************************************************************************/
function gotoLetter(sHref, sLinkPHP) {

  xhr_object = get_xhr();
  if (xhr_object == null) return;


  xhr_object.open("POST", sLinkPHP, true);   
//alert (sLinkPHP);  
//alert (sHref);      
    xhr_object.onreadystatechange = function() {   
       if(xhr_object.readyState == 4)   {
          var retour = xhr_object.responseText;       
          var h = retour.indexOf("|", 0);
          var i = retour.indexOf("|", h+1);
          var j = retour.indexOf("|", i+1);

          resultat = retour.substr(h+1, i-h-1);
          //alert (resultat);
          //eval(xhr_object.responseText);   

        obLex = document.getElementById("frmLexique");   
        window.location = sHref + "&idLexique=" + obLex.idLexique.value+"&resultat="+resultat+"&jjd=54";       
       }
    
  }   

  //        alert ("gotoLetter-"+sHref);
    xhr_object.setRequestHeader("Content-type", "application/x-www-form-urlencoded");   

 ob = document.getElementById("frmLexique");    
    
    var data = "id="            + ob.id.value 
             + "&name="         + ob.name.value
             + "&shortDef="     + ob.shortDef.value
             + "&idLexique="    + ob.idLexique.value             
             + "&category="     + getCategory();   


//alert ("data = " + data );             
             
//alert ("JJD");                         
     
  //alert (data);        
    xhr_object.send(data);   
 




  
  //alert ("v = " + sLinkPHP);    
    
}
