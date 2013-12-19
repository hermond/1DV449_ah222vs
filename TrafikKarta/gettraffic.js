/**
 * Created with JetBrains PhpStorm.
 * User: Hello World
 * Date: 2013-12-15
 * Time: 19:39
 * To change this template use File | Settings | File Templates.
 */
var Traffic = {

    map: "",

    markers: [],

    init: window.onload = function() {

        var mapOptions = {
            center: new google.maps.LatLng(60.226175, 15.029297),
            zoom: 5
        };
        Traffic.map = new google.maps.Map(document.getElementById("map-canvas"),
            mapOptions);
        Traffic.initialize();
    },



    initialize: function() {


        $.getJSON("http://api.sr.se/api/v2/traffic/messages?format=json&size=100&callback=?", function(data) {

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
            $("#all").change(function(){
                Traffic.setPositionsOnMap(messages);
            });
            $("#vag").change(function(){
                Traffic.setPositionsOnMap(vagMessages);
            });
            $("#kollektiv").change(function(){
                Traffic.setPositionsOnMap(kollektivMessages);
            });
            $("#planerad").change(function(){
                Traffic.setPositionsOnMap(planeradMessages);
            });
            $("#ovrigt").change(function(){
                Traffic.setPositionsOnMap(ovrigtMessages);
            });

            Traffic.setPositionsOnMap(messages);
        });

    },


    setPositionsOnMap: function(messages)
    {

        var map = Traffic.map;

        var messagesDiv = document.getElementById("messagesDiv");
        messagesDiv.innerHTML = "";

        Traffic.setAllMap(null);
        Traffic.markers = [];
        for (var i = 0; i < messages.length; i++ )
        {


        Traffic.markers.push(new google.maps.Marker({
            position: new google.maps.LatLng(messages[i].latitude, messages[i].longitude),
            map: map,
            draggable: false,
            clickable: true
        }));

            Traffic.markers[i].info = new google.maps.InfoWindow({
                content: "<p>" + messages[i].title + "</p><p>"+messages[i].subcategory+"</p><p>"+messages[i].description+"</p>"
            });

            (function(markers, map, i) {
                google.maps.event.addListener(markers[i], 'click', function() {
                    markers[i].info.open(map, markers[i]);
                });
            })(Traffic.markers, map, i);




        Traffic.appendtoDiv(messages[i]);

        }


    },

    appendtoDiv: function(message)
    {

        var messagesDiv = document.getElementById("messagesDiv");
        var messageDiv = document.createElement("div");
        messageDiv.setAttribute("class","message");
        var title = document.createElement("p");
        var subcategory = document.createElement("p");
        var description = document.createElement("p");
        title.innerHTML = "<span class='bold'>Var: </span>"+message.title;
        subcategory.innerHTML = "<span class='bold'>Typ: </span>"+message.subcategory;
        description.innerHTML = "<span class='bold'>Beskrivning: </span>"+message.description;
        messageDiv.appendChild(title);
        messageDiv.appendChild(subcategory);
        messageDiv.appendChild(description);
        messagesDiv.appendChild(messageDiv);

    },

    setAllMap: function(map) {
    for (var i = 0; i < Traffic.markers.length; i++) {
        Traffic.markers[i].setMap(map);
    }
}

};