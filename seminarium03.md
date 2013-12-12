#Seminarium 3 - 1DV449

Tanken med min mashup är att samla in artiklar inom Internetmarknadsföring och presentera dessa i ordning kring hur många sociala signaler de har fått. 
Jag kommer således kombinera data från Facebook och Twitter för att räkna ihop likes, shares och tweets och ge artiklarna en poäng som de kan sorteras efter.
Finns det utrymme så kommer jag även koppla in Google Plus och kanske Delicius för att även få antalet delningarna/likes från dessa källor.

##Steg 1
* Facebook har flera tillgängliga API:er som gör det möjligt att få ut data från en specifik url. Ifall en webbsajt är ansluten till Open Graph så verkar detta
vara det bästa sättet, men då tanken är att samla information från flera olika sajter så kan det blir svårt att utgå från att dessa är anslutna till Open Graph.
Valet faller därför på att använda FQL som verkar vara ganska lätt att använda. API:et fungerar i princip som sql där man frågar om till exempel antalet shares, 
likes och annat på en url med en fråga som liknar detta: 

* https://api.facebook.com/method/fql.query?query=select  url,like_count, total_count, share_count, click_count from link_stat where url = “http://domain.com”

* Från Twitter är det möjligt att få ut antalet tweets för en specifik url, fast det är egentligen inget som stöds av twitter. Det man får göra för att komma åt denna 
data är att gå via deras ”tweet-knapp” som egentligen ska ligga på en url. Twitter API känns inte så svårt att jobba emot, det är väldokumenterat och det finns mer 
intressant data att komma åt som hade varit intressant att använda i min applikation, så som t.ex antalet retweets.

* Från båda dessa API:er går det att få tillbaka JSON. Med Facebooks API ska det även gå att få xml.

* API:erna är helt fria och det kostar inget att använda dem. Dock så kan det eventuellt uppstå problem med Twitters API då det egentligen inte finns stöd för att hämta 
ut antalet tweets för en url på detta sätt. Om man vill kan man även gå via deras Streaming API för att få ut denna data så jag får se vad jag väljer. 
Jag har inte bestämt ifall jag ska lagra antalet social shares/likes i en databas och ladda in dem vid någon tidpunkt med cron jobs eller låta en förfrågning ske 
varje gång sidan laddas till api:erna. Det är svårt att säga vilka risker som finns, men det skulle kunna vara att datan inte ändras eller att Twitter inte gör det 
möjligt att hämta ut antalet tweets med det sätt jag funderar på att använda.

##Steg 2

* Jag tycker personligen att Mashups där man använder Google Maps tillsammans med en eller flera datakällor ofta blir ganska häftiga. Exempelvis gjorde Ted Valentin 
annonskartan där han bland annat använde Traderas API för att leta upp annonser och placera dem på en karta. Denna tjänsten har jag själv använt lite till och från 
för att se vad folk säjer i närheten. En annan häftig google maps mashup är Trendsmap.com, där man samlar in twitterdata och presenterar de populäraste hashtagsen 
på en karta. Här kan man exempelvis se vad det twittras om i olika delar av Sverige just nu.

* Mervärdet av denna typ av applikation är att den är visuellt tilltalande och det går lätt att få en överblick över geografisk data. Istället för att först söka på 
vad det twittras om i Malmö för att sedan behöva söka på vad det twittras om i Stockholm, så kan få en överblick över båda orterna på bara en sekund med hjälp av 
Google Maps. Det samma gäller för annonskartan, istället för att behöva gå in på Tradera eller blocket för att titta på en speciell stad, kan man direkt se vad som 
sälj i Kalmar men även Nybro. 


