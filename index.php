<!DOCTYPE html >
<head>
<title>Sierre Seminar 2023 - Team </title>
  <link rel="icon" type="image/x-icon" href="https://imgtr.ee/images/2023/04/05/kmbPL.png">
  <meta name='viewport' content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no' />
  <script src='https://api.mapbox.com/mapbox-gl-js/v2.13.0/mapbox-gl.js'></script>
  <script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-compare/v0.1.0/mapbox-gl-compare.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/suncalc@1.9.0/suncalc.js"></script>
  <link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-compare/v0.1.0/mapbox-gl-compare.css" type="text/css">
  <link href='https://api.mapbox.com/mapbox-gl-js/v2.13.0/mapbox-gl.css' rel='stylesheet' />
  <script src="https://kit.fontawesome.com/015843ef38.js" crossorigin="anonymous"></script>
   <style>
  html {
      background:#191919;
  }
    body { margin: 0; padding: 0; font: 12px/20px Helvetica Neue,Arial,Helvetica,sans-serif;}
    #map { z-index:-100; position: absolute; top: 0; bottom: 0; width: 100%; }
    #info {
        font-size: 16px;
        margin-top:1px;
    }
#inffoo {
  z-index: 10;
  cursor: default;
  position: absolute;
  top: 10px;
  right: 10px;
  background-color: rgba(0, 0, 0, 0.5);
  color: #fff;
  padding: 10px;
  font-size: 18px;
  border-radius: 5px;
  box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.3);
}
#inffoo p{
    margin:3px;
}
.cen {
   text-align: center;
   margin:-5px !important;
}
.LS {
    margin-top:-15px;
    height: 0px;
    font-style: italic;
    color:dimgray;
    font-size: 10px;
    text-align: center;
}
#back-to-point {
  z-index: 10;
  cursor: pointer;
  position: absolute;
  bottom: 30px;
  right: 20px;
  background-color: #333;
  color: #fff;
  padding: 10px 20px;
  font-size: 22px;
  font-weight: 700;
  border-radius: 10px;
  box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.3);
  border: none;
  outline: none;
  transition: background-color 0.3s ease-in-out;
}

#back-to-point:hover {
  background-color: #555;
}
#refresh{
  z-index: 10;
  cursor: pointer;
  position: absolute;
  bottom: 90px;
  right: 20px;
  background-color: #333;
  color: #fff;
  padding: 10px 20px;
  font-size: 22px;
  font-weight: 700;
  border-radius: 10px;
  box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.3);
  border: none;
  outline: none;
  transition: background-color 0.3s ease-in-out;
}
#refresh:hover {
  background-color: #555;
}
.mapboxgl-ctrl.mapboxgl-ctrl-attrib {
  display: none;
}
  </style>
</head>

<html lang="en">
<body>
    
<?php
include 'load.php';
extractData();
?>

<button id="back-to-point"><i class="fa-solid fa-location-crosshairs"></i></button>
<button onclick="refreshPage()" id="refresh"><i class="fa-solid fa-arrows-rotate"></i></button>

 <div id='inffoo'> 
 <p><i class="fa-solid fa-user-group"></i> Team <?php echo json_encode($team_no, JSON_NUMERIC_CHECK); ?> </p> 
 <p class="cen">-------------</p>
 <p><i class="fa-solid fa-temperature-low"></i> <?= intval($data[0]['temperature']); ?>  &deg;C </p> 
 <p>  </p> 
 <p><i class="fa-solid fa-satellite"> </i> <?= intval($data[0]['satellites']); ?> Sat </p>
 <p><i class="fa-solid fa-gauge-simple"> </i> <?= intval($data[0]['pressure']); ?> hPa</p>
 <p><i class="fa-solid fa-mountain-sun"> </i> <?= intval($data[0]['altitude']); ?> m</p>
 </div>

<div id='map'></div>

<script defer type="text/javascript">
   function refreshPage() {
    location.reload();
}
    document.title = "Sierre Seminar 2023 - Team " + <?php echo json_encode($team_no, JSON_NUMERIC_CHECK); ?>;
    const data = <?php echo json_encode($data); ?>;
    const teamNo = <?php echo json_encode($team_no); ?>;
    const temperature = <?php echo json_encode(intval($data[0]['temperature'])); ?>;
    const pressure = <?php echo json_encode(intval($data[0]['pressure'])); ?>;  
    const altitude = <?php echo json_encode(intval($data[0]['altitude'])); ?>;
    const date=new Date();
    mapboxgl.accessToken='pk.eyJ1IjoiZGl6ZHVkZSIsImEiOiJjbGY3aXgyangwMThoM3JwYXl4Zm0xbHVtIn0.Ur6xxsAEae271nED4B8JOA';
    const latitude=<?php echo number_format(floatval($data[0]['latitude']),6); ?>,
    longitude=<?php echo number_format(floatval($data[0]['longitude']),6); ?>,
    sunPosition=SunCalc.getPosition(date,latitude,longitude),
    isDaytime=sunPosition.altitude>0;
    const map=new mapboxgl.Map({container:"map",pitch:45,style:"mapbox://styles/mapbox/navigation-night-v1",center:[longitude,latitude],zoom:17,antialias:!0,projection:"globe"});
    map.on("style.load",()=>{map.setFog(isDaytime?{"range":[0.8,8],"color":"#dc9f9f","horizon-blend":0.5,"high-color":"#245bde","space-color":"#000000","star-intensity":0.15}:{"range":[1,10],"color":"#262c4d","horizon-blend":0.5,"high-color":"#5d5d5d","space-color":"#000000","star-intensity":0.25});
    map.addSource("mapbox-dem",{type:"raster-dem",url:"mapbox://mapbox.mapbox-terrain-dem-v1",tileSize:512,maxzoom:14}),
    map.setTerrain({source:"mapbox-dem",exaggeration:1.5}),
    map.addSource("satellite",{type:"raster",url:"mapbox://mapbox.satellite",tileSize:512,maxzoom:22}),
    map.addLayer({id:"satellite-layer",type:"raster",source:"satellite",layout:{visibility:"visible"},paint:{"raster-opacity":.2}});
    const e=map.getStyle().layers.find(e=>"symbol"===e.type&&e.layout["text-field"]).id;
    map.addLayer({id:"add-3d-buildings",source:"composite","source-layer":"building",filter:["==","extrude","true"],type:"fill-extrusion",minzoom:15,paint:{"fill-extrusion-color":"#aaa","fill-extrusion-height":["interpolate",["linear"],["zoom"],15,0,15.05,["get","height"]],"fill-extrusion-base":["interpolate",["linear"],["zoom"],15,0,15.05,["get","min_height"]],"fill-extrusion-opacity":.6}},e);
    });
     data.forEach(coordination => {
    const marker = new mapboxgl.Marker()
        .setLngLat([coordination.longitude, coordination.latitude])
        .addTo(map);

    const popup = new mapboxgl.Popup({ closeButton: false, closeOnClick: false });
    marker.getElement().addEventListener("mouseenter", () => {
        popup.setLngLat(marker.getLngLat()).setHTML(`
            <p id="info">
                Team: ${coordination.team_no}<br>
                Latitude: ${coordination.latitude}<br>
                Longitude: ${coordination.longitude}<br>
                <p class="LS"> Last seen: ${coordination.date} ${coordination.time} 

            </p></p>`).addTo(map);
    });
    marker.getElement().addEventListener("mouseleave", () => {
        popup.remove();
    });
});
    const backButton=document.getElementById("back-to-point");
    backButton.addEventListener("click",()=>{map.flyTo({center:[longitude,latitude],zoom:17.5,pitch:60})});
</script>
</body>
</html>
