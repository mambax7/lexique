//-----------------------------------------------------------------------------

function gotoLexique(sHref) {
    
    //alert (sHref);
    ob = document.getElementsByName("idLexique");
    //alert (ob[0].value);
    //window.navigate (sHref + "?idLexique=" + ob[0].value);
    window.location = sHref + "?idLexique=" + ob[0].value;
    
}
//-----------------------------------------------------------------------------
function searchOnLexique(){
  obLexique = document.getElementsByName('idLexique');  
  link = "searchExp.php?idLexique=" + obLexique[0].value;  
  //window.navigate (link);   
  window.location = link;
}
//-----------------------------------------------------------------------------
function doAction(menuAction){
  ob = document.getElementsByName(menuAction);
  obLexique = document.getElementsByName('idLexique');
  
  action = '???';
  a = ob[0].value
  //ob[0].value = 0;  
/*
*/  
  switch (a){
    case '1':
      action = 'Chercher';
      link = "searchExp.php?idLexique=" + obLexique[0].value;
      //window.navigate (link);
      window.location = link;
      break;
      
    case '2':
      action = 'Demander une d‚finition';
      link = "question.php?idLexique=" + obLexique[0].value;
       //window.navigate (link);
       window.location = link;
      break;
      
    case '3':
      action = 'Ajouter une d‚finition'; 
      link = "submit.php?idLexique=" + obLexique[0].value;
       //window.navigate (link);
       window.location = link;
      break;
      
    default:
      action = 'ras';    
      break;
      
  }
 
  
  ob[0].value = 0;
  //ob[0] = 'selected';  
  ob[0].item[0] = 'selected';
  //alert('action = ' + a +  ' => ' + action);
  
  
}

