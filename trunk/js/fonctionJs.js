//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
//Fonction permettant d'instancier l'objet XMLHttpRequest
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function getRequeteHttp()
{
var requeteHttp;
if (window.XMLHttpRequest) //Mozilla
      {
      requeteHttp=new XMLHttpRequest();
      if (requeteHttp.overrideMimeType) //Firefox
              {
              requeteHttp.overrideMimeType('text/xml');
              }
      }
      else
      {
      if (window.ActiveXObject) //IE < 7
              {
              try
                      {
                      requeteHttp=new ActiveXObject("Msxml2.XMLHTTP");
                      }
              catch(e)
                      {
                      try
                              {
                              requeteHttp=new ActiveXObject("Microsoft.XMLHTTP");
                              }
                      catch(e)
                              {
                              requeteHttp=null;
                              alert ("Navigateur incompatible");
                              }
                      }
              }
      }
return requeteHttp;
}


//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
//Fonction permettant de faire un appel Ajax
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function inscriptionUser(){

	var requeteHttp=getRequeteHttp();
  if (requeteHttp!=null)
          {
          requeteHttp.open("POST","./inscriptionUser.php",true);
          requeteHttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
          requeteHttp.onreadystatechange = function () {recevoirReponseRequeteAjax(requeteHttp)};
          requeteHttp.send("nom="+document.getElementById("user_nom").value+"&prenom="+document.getElementById("user_prenom").value+"&num_rue="+document.getElementById("user_num_rue").value+"&libelle_rue="+document.getElementById("user_lib_rue").value+"&code_postal="+document.getElementById("user_cp").value+"&ville="+document.getElementById("user_ville").value+"&telephone="+document.getElementById("user_tel").value+"&mail="+document.getElementById("user_email").value+"&mot_de_passe="+document.getElementById("user_mdp").value);
          }
  }

//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
//Fonction permettant de recevoir et de traiter la reponse de la requete Ajax
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function recevoirReponseRequeteAjax(requeteHttp){
if (requeteHttp.readyState==4)
{
  if (requeteHttp.status==200)
  {
           if(requeteHttp.responseText){
        	   dojo.byId("response").innerHTML = requeteHttp.responseText ;
           }
  }
  else
          alert("Erreur requete");
}
}


function affichageGestion(val){
	if(val == 0){
		document.getElementById('gestion_groupe').style.display = 'block' ;
		document.getElementById('ajout_film').style.display = 'none' ;
		document.getElementById('gestion_compte').style.display = 'none' ;
	}else if(val == 1){
		document.getElementById('gestion_groupe').style.display = 'none' ;
		document.getElementById('ajout_film').style.display = 'block' ;
		document.getElementById('gestion_compte').style.display = 'none' ;
	}else if(val == 2){
		document.getElementById('gestion_groupe').style.display = 'none' ;
		document.getElementById('ajout_film').style.display = 'none' ;
		document.getElementById('gestion_compte').style.display = 'block' ;
	}
}
