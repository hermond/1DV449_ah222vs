/**
 * Created with JetBrains PhpStorm.
 * User: Hello World
 * Date: 2013-12-15
 * Time: 19:39
 * To change this template use File | Settings | File Templates.
 */

window.onload = function() {



    initialize();


}
function initialize() {

    $.getJSON("http://api.sr.se/api/v2/traffic/messages?format=json&size=100&callback=?", function(data) {
        console.log(data); // use data as a generic object
        var messages = data.messages;


        var vagMessages = [];
        var kollektivMessages = [];
        var planeradMessages = [];
        var ovrigtMessages = [];

        for (var i = 0; i < messages.length; i++ )
        {
        console.log(messages[i].category);
            switch(messages[i].category)
            {
                case 0:
                    vagMessages.push(messages[i]);
                    console.log(vagMessages);
                    break;
                case 1:
                    kollektivMessages.push(messages[i]);
                    break;
                case 2:
                    planeradMessages.push(messages[i]);
                    break;
                case 3:
                    ovrigtMessages.push(messages[i]);
                    break;

            }
        }
        $("#vag").change(function(){
            console.log(vagMessages);
            setPositionsOnMap(vagMessages);
        });
        $("#kollektiv").change(function(){
            setPositionsOnMap(kollektivMessages);
        });
        $("#planerad").change(function(){
            setPositionsOnMap(planeradMessages);
        });
        $("#ovrigt").change(function(){
            setPositionsOnMap(ovrigtMessages);
        });

        setPositionsOnMap(messages);
    });

}


function setPositionsOnMap(messages)
{

    var mapOptions = {
        center: new google.maps.LatLng(60.226175, 15.029297),
        zoom: 5
    };
    var map = new google.maps.Map(document.getElementById("map-canvas"),
        mapOptions);
    google.maps.event.addDomListener(window, 'load', initialize);



    for (var i = 0; i < messages.length; i++ )
    {
    var marker = new google.maps.Marker({
        position: new google.maps.LatLng(messages[i].latitude, messages[i].longitude),
        map: map,
        draggable: false,
        clickable: true
    });

        marker.info = new google.maps.InfoWindow({
            content: "<p>"+messages[i].description+"</p>"
        });

        (function(marker, map) {
            google.maps.event.addListener(marker, 'click', function() {
                marker.info.open(map, marker);
            });
        })(marker, map)

       // returnMarker(marker, map);


    }

    function returnMarker(marker, map) {
        google.maps.event.addListener(marker, 'click', function() {
            marker.info.open(map, marker);
        });
    }

}