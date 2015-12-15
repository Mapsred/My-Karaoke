<!doctype html>
<html>
<head>
<meta charset="utf-8">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<link href="style.css" rel="stylesheet" type="text/css">
<title>myKaraoke</title>
</head>

<body>
<div id="header">
<h1>Paroles en direct</h1>
</div>
<div id="section">
<h1>Démarrez la musique et les paroles suivront !</h1><br>
<audio controls ontimeupdate="myFunction(this)">
  <source src="LOR.mp3" type="audio/mp3" />
</audio>
<br>
<span id="paroles">Les paroles apparaitront ici !</span>
</div>
<div id="footer">
François Mathieu - Dev2017 - Sup'Internet - Project JavaScript <a href="myKaraokeSubject.html">myKaroke</a>
</div>


<!-------------------------------  On met les scripts ici ------------------------------->
<!-- Script de récupération du temps de la musique -->
<script>
function myFunction(event) {
    var Time = event.currentTime;
    var seconde = Math.floor(Time);
    var minute = 0;
    if (seconde >= 60) { 
      var minute = Math.floor(seconde / 60);
      seconde = seconde-(60*minute); 
    }
    if (minute < 10) {minute = '0'+minute;}
    if (seconde < 10) {seconde = '0'+seconde;}
    var Temps = minute+':'+seconde;
   recup(Temps);//On doit maintenant envoyer le temps voulu en paramètre
    
}
</script>
<!-- Script de récupération et affichage des paroles (en asynchrone) -->
<script>
function recup(TempsVoulu) {
$.ajax({
    url:'lyrics.txt',
    type:'GET',
    dataType:'text',
    success: function(data){
    var nb = 0;
    for (var s in data){nb++;}
    var lyrics = '';
    var ligneArray = new Array();
    var nbLigne = 0;
    for (var s in data){
      if ( (data[s] == '[' && s != 0)  || s == nb-1) {
        ligneArray[nbLigne] = lyrics;
        nbLigne++;
        lyrics = '';
      }
        lyrics += data[s];
    } 
    for(var nbr in ligneArray) {
      decoupe = ligneArray[nbr].substr(1, 5);
        if (decoupe == TempsVoulu) {
         ligne = ligneArray[nbr].substr(10);
         //Ici on met la ligne voulue dans lyrics
          $('#paroles').html(ligne);
        }
    }  
    },
    error : function(result, status, error){
        $('body').html(error);
    }
});
}
</script>


</body>
</html>