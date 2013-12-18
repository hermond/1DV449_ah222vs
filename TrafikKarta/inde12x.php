<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Hello World
 * Date: 2013-12-15
 * Time: 19:21
 * To change this template use File | Settings | File Templates.
 */

echo "
<html>
<head>
<title>Trafikvarningar i Sverige</title>
    <style type='text/css'>
      html { height: 100% }
      body { height: 100%; margin: 0; padding: 0 }
      #map-canvas { height: 50%; width: 50% }
    </style>
</head>
<body>

<div id='map-canvas'/>
</div>

<input type="radio" name="group1" value="Milk"> Milk<br>
<input type="radio" name="group1" value="Butter" checked> Butter<br>
<input type="radio" name="group1" value="Cheese"> Cheese
<hr>
<input type="radio" name="group2" value="Water"> Water<br>
<input type="radio" name="group2" value="Beer"> Beer<br>
<input type="radio" name="group2" value="Wine" checked>


<script src='gettraffic.js'></script>
 <script type='text/javascript'
      src='https://maps.googleapis.com/maps/api/js?key=AIzaSyCAQVduEkMwOpv5PCHrSnw92S4-5MaPyTA&sensor=true'>
    </script>
<script src='//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js'></script>
</body>


</hmtl>



";