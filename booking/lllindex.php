<?php 
    function getLnt($zip){
        var_dump($zip);
    $url = "https://maps.googleapis.com/maps/api/geocode/json?address=".urlencode($zip)."&sensor=false";
    var_dump($url);
    echo '</br>';
    $result_string = file_get_contents($url);
    var_dump($result_string);
    $result = json_decode($result_string, true);
    $result1[]=$result['results'][0];
    $result2[]=$result1[0]['geometry'];
    $result3[]=$result2[0]['location'];
    return $result3[0];
    }
    function printlanlong($code){
        $val = getLnt($code);
        echo "Latitude: ".$val['lat']."<br>";
        echo "Longitude: ".$val['lng']."<br>";
    }
    printlanlong('785125');

 
    
?>
<!DOCTYPE html>
<!--<html>-->
<!--<body>-->

<!--<h1>My First Google Map</h1>-->

<!--<div id="googleMap" style="width:100%;height:400px;"></div>-->

<!--<script>-->
<!--    function myMap() {-->
<!--        var mapProp= {-->
<!--            center:new google.maps.LatLng(51.508742,-0.120850),-->
<!--            zoom:5,-->
<!--        };-->
<!--        var map=new google.maps.Map(document.getElementById("googleMap"),mapProp);-->
<!--        var marker = new google.maps.Marker({-->
<!--            position: new google.maps.LatLng(51.508742, -0.120850),-->
<!--            map: map-->
<!--        });-->
<!--    }-->
<!--</script>-->
<!--<script type="text/javascript" src="http://maps.google.com/maps/api/js?key=AIzaSyBiHrjQVDBSe7nK4dDeM5Od-LZMlwPVYwM&callback=myMap"></script>-->
<!--<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBiHrjQVDBSe7nK4dDeM5Od-LZMlwPVYwM&callback=myMap"></script>-->
<!--
To use this code on your website, get a free API key from Google.
Read more at: https://www.w3schools.com/graphics/google_maps_basic.asp
-->

<!--</body>-->
<!--</html>-->
