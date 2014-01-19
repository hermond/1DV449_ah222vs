/**
 * Created with JetBrains PhpStorm.
 * User: Hello World
 * Date: 2014-01-15
 * Time: 20:50
 * To change this template use File | Settings | File Templates.
 */

var App = {

timeQuery: "last24hours",

source: 5,

init: window.onload = function(){

App.initialize();

},

initialize: function()
{


    App.getArticles();

    $(window).on('hashchange', function() {
       var query = window.location.hash.replace("#","");
        if(+query){

        App.source = parseInt(query);
        App.getArticles();
        }else
        {
        App.timeQuery = query;
        App.getArticles();
        }
    });

    $(".time").click(function() {
        $(".time").removeClass("selected");
        $(this).addClass("selected");
    });

    $(".sources").click(function() {
        $(".sources").removeClass("selected");
        $(this).addClass("selected");
    });


},

getArticles: function()
{

    var query = App.timeQuery;
    if(lscache.get(query))
    {
        App.writeArticles(lscache.get(query));
    }else{
        App.getJson(query, function(data) {

            if (data == "" || data == undefined)
            {
                App.writeMessage("No articles were found :(");
            }else{
                lscache.set(query, data, 15);
                App.writeArticles(data);
            }
        });
    }

},
writeArticles: function(articles)
{

    var articleWrapper = document.getElementById("articleWrapper");
    articleWrapper.innerHTML = "";
    for (var i = 0; i < articles.length; i++)
    {

    if(articles[i].publisherID == App.source || App.source == 5)
    {
    var articleBox = document.createElement("div");
    articleBox.setAttribute("class","articleBox");
    var publisherImg = document.createElement("img");
        publisherImg.setAttribute("src", "images/"+articles[i].publisherID+".jpg");
    var titleP = document.createElement("p");
    var titleA = document.createElement("a");
    titleA.setAttribute("href", articles[i].url);
    titleA.innerHTML = articles[i].title;
    titleP.appendChild(titleA);
    var facebookShareP = document.createElement("p");
        facebookShareP.setAttribute("class","facebook");
    var twitterShareP = document.createElement("p");
        twitterShareP.setAttribute("class","twitter");
    var totalSharesP = document.createElement("p");
        totalSharesP.setAttribute("class","totalShares");
    var dateP = document.createElement("p");
        dateP.innerHTML = articles[i].date;
    facebookShareP.innerHTML = " "+articles[i].facebookShare;
    twitterShareP.innerHTML = " "+articles[i].twitterShare;
    totalSharesP.innerHTML = "Total Shares: " + (parseInt(articles[i].facebookShare) + parseInt(+articles[i].twitterShare)).toString();
        articleBox.appendChild(publisherImg);
        articleBox.appendChild(titleP);
        articleBox.appendChild(facebookShareP);
        articleBox.appendChild(twitterShareP);
        articleBox.appendChild(totalSharesP);
        articleBox.appendChild(dateP);
    articleWrapper.appendChild(articleBox);
    }

    }

    if(articleWrapper.innerHTML == "")
    {
        App.writeMessage("No articles were found:(");
    }

},

writeMessage: function(message)
{

    var articleWrapper = document.getElementById("articleWrapper");
    articleWrapper.innerHTML = "";
    var messageP = document.createElement("p");
    messageP.innerHTML = message;
    articleWrapper.appendChild(messageP);
},

getJson: function(query, callback)
{
    query = query || "last24hours";
    console.log(query);
        $.ajax({
            url: "routes.php?" +  query ,
            type: "GET"
        }).done(function(data) {
                //console.log(data[0].title);
               callback(data);
            });


}
};







