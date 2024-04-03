<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>ISS Tracker | 3D</title>
    <link rel="stylesheet" href="./css/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <script src="http://code.jquery.com/jquery-3.1.1.js"></script>
  </head>
  <body>
    <div class="background fadeouttt" id="suppr"></div>
    <div class="Logo animate__animated animate__fadeIn animate__slower"  id="suppr">
      <div class="fadeouttt"  id="suppr">
        <img class="LogoImg " src="./img/nasa.png" alt="daylight" width="512" height="512">
      </div>

    </div>


    <div class="container">
      <div class="item item1">
        <div class="Texte">Local Time</div>
        <div class="BoxTime">
          <div id="time"><p>00:00:00</p></div>
          <script type="text/javascript">
            function getTime(dateObj) {
              var time = [dateObj.getUTCHours(),
              dateObj.getUTCMinutes(),
              dateObj.getUTCSeconds()];

              var i = 0;
              for (i; i < time.length; i++) {
                if(time[i] < 10) {
                  time[i] = "0" + time[i];
                }
              }
              var timeFormat = time[0] + ":" + time[1] + ":" + time[2] + "<sup> UTC</sup>";
              return timeFormat;
            }
            var pElem = document.getElementById('time').firstElementChild;
            setInterval(function(){var currentDate = new Date;pElem.innerHTML = getTime(currentDate);}, 1000);
          </script>

        </div>
      </div>
      <div class="item item2">
        <div class="Texte">Astronauts in ISS</div>
        <div class="BoxISS">
          <div id="Global">
            <?php
              $lectureAstro = file_get_contents('http://api.open-notify.org/astros');
              $lectureAstro = json_decode($lectureAstro, true);
              echo "<div id='gauche'>";
              for ($i=0; $i < 5; $i++) {
                if ($lectureAstro["people"][$i]["craft"] == 'ISS') {
                  print($lectureAstro["people"][$i]['name']);
                  echo "<br>";
                }
              }
              echo "</div>";
              echo "<div id='droite'>";
              for ($i=5; $i < $lectureAstro["number"]; $i++) {
                if ($lectureAstro["people"][$i]["craft"] == 'ISS') {
                  print($lectureAstro["people"][$i]['name']);
                  echo "<br>";
                }
              }
              echo "</div>";
            ?>
          </div>
        </div>
      </div>
      <div class="item item3">
        <div class="Texte">Velocity</div>
        <div class="BoxVEL">
          <div id="velo"></div>

        </div>
      </div>
      <div class="item item4" onclick="location.href='#';" style="cursor: pointer;">
        <div class="Texte">Units</div>
        <div class="BoxKMILE">KILOMETERS</div>
      </div>
      <div class="item item5">
        <div class="Texte">Lat.</div>
        <div class="BoxLLA">
          <div id="lat"></div>

        </div>
      </div>
      <div class="item item7">
        <div class="Texte">Long.</div>
        <div class="BoxLLA">
          <div id="long"></div>

        </div>
      </div>
      <div class="item item8">
        <div class="Texte">Alt.</div>
        <div class="BoxLLA">
          <div id="alt"></div>

        </div>
      </div>
      <div class="item item9">
        <div class="Texte">Time in orbit</div>
        <div class="BoxDate">
          <?php
            $date1 = date_create("1998-11-20");
            $date2 = date_create(date("Y-m-d"));
            $diff =  date_diff($date1 , $date2);
            echo $diff->format("%y Years %m Months %d Days");
          ?>
        </div>
      </div>
      <div class="item item10">
        <div class="Texte">visibility</div>
        <div class="BoxVi">
          <div id="daymoon"></div>
        </div>
      </div>
      <script type="text/javascript">

      setInterval(function(){
        $.getJSON( "https://api.wheretheiss.at/v1/satellites/25544", function( json ) {
          console.log(json.latitude);
          if (json.latitude.toFixed(2) < 0) {
            document.getElementById('lat').innerHTML = json.latitude.toFixed(2) + "<sup>°</sup>" + " S";
          } else {
            document.getElementById('lat').innerHTML = json.latitude.toFixed(2) + "<sup>°</sup>" + " N";
          }
          document.getElementById('velo').innerHTML = Math.round(json.velocity) + "<sup> KM/H</sup>";

          if (json.latitude.toFixed(2) < 0) {
            document.getElementById('long').innerHTML = json.longitude.toFixed(2) + "<sup>°</sup>" + " W";
          } else {
            document.getElementById('long').innerHTML = json.longitude.toFixed(2) + "<sup>°</sup>" + " E";
          }
          document.getElementById('alt').innerHTML = json.altitude.toFixed(2) + "<sup> KM</sup>";

          if (json.visibility == "daylight") {
            document.getElementById('daymoon').innerHTML = '<img src="./img/sun.png" alt="daylight" width="128" height="128">';
          } else {
            document.getElementById('daymoon').innerHTML = '<img src="./img/moon.png" alt="moon" width="128" height="128">';
          }
        });
      }, 5000);

      setTimeout(function(){
        $.getJSON( "https://api.wheretheiss.at/v1/satellites/25544", function( json ) {
          $.getJSON( "https://api.wheretheiss.at/v1/coordinates/" + json.latitude +"," + json.longitude), function( json1 ) {
            console.log(json1.country_code);
          }
        }, 7500);
      }, 5000);

      setTimeout(function(){
        var myobj1 = document.getElementById("suppr");
        myobj1.remove();
      }, 7500);
      </script>

    </div>
  </body>
</html>
