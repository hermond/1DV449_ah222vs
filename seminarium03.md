#Seminarium 3 - 1DV449

Tanken med min mashup �r att samla in artiklar inom Internetmarknadsf�ring och presentera dessa i ordning kring hur m�nga sociala signaler de har f�tt. 
Jag kommer s�ledes kombinera data fr�n Facebook och Twitter f�r att r�kna ihop likes, shares och tweets och ge artiklarna en po�ng som de kan sorteras efter.
Finns det utrymme s� kommer jag �ven koppla in Google Plus och kanske Delicius f�r att �ven f� antalet delningarna/likes fr�n dessa k�llor.

##Steg 1
* Facebook har flera tillg�ngliga API:er som g�r det m�jligt att f� ut data fr�n en specifik url. Ifall en webbsajt �r ansluten till Open Graph s� verkar detta
vara det b�sta s�ttet, men d� tanken �r att samla information fr�n flera olika sajter s� kan det blir sv�rt att utg� fr�n att dessa �r anslutna till Open Graph.
Valet faller d�rf�r p� att anv�nda FQL som verkar vara ganska l�tt att anv�nda. API:et fungerar i princip som sql d�r man fr�gar om till exempel antalet shares, 
likes och annat p� en url med en fr�ga som liknar detta: 

* https://api.facebook.com/method/fql.query?query=select  url,like_count, total_count, share_count, click_count from link_stat where url = �http://domain.com�

* Fr�n Twitter �r det m�jligt att f� ut antalet tweets f�r en specifik url, fast det �r egentligen inget som st�ds av twitter. Det man f�r g�ra f�r att komma �t denna 
data �r att g� via deras �tweet-knapp� som egentligen ska ligga p� en url. Twitter API k�nns inte s� sv�rt att jobba emot, det �r v�ldokumenterat och det finns mer 
intressant data att komma �t som hade varit intressant att anv�nda i min applikation, s� som t.ex antalet retweets.

* Fr�n b�da dessa API:er g�r det att f� tillbaka JSON. Med Facebooks API ska det �ven g� att f� xml.

* API:erna �r helt fria och det kostar inget att anv�nda dem. Dock s� kan det eventuellt uppst� problem med Twitters API d� det egentligen inte finns st�d f�r att h�mta 
ut antalet tweets f�r en url p� detta s�tt. Om man vill kan man �ven g� via deras Streaming API f�r att f� ut denna data s� jag f�r se vad jag v�ljer. 
Jag har inte best�mt ifall jag ska lagra antalet social shares/likes i en databas och ladda in dem vid n�gon tidpunkt med cron jobs eller l�ta en f�rfr�gning ske 
varje g�ng sidan laddas till api:erna. Det �r sv�rt att s�ga vilka risker som finns, men det skulle kunna vara att datan inte �ndras eller att Twitter inte g�r det 
m�jligt att h�mta ut antalet tweets med det s�tt jag funderar p� att anv�nda.

##Steg 2

* Jag tycker personligen att Mashups d�r man anv�nder Google Maps tillsammans med en eller flera datak�llor ofta blir ganska h�ftiga. Exempelvis gjorde Ted Valentin 
annonskartan d�r han bland annat anv�nde Traderas API f�r att leta upp annonser och placera dem p� en karta. Denna tj�nsten har jag sj�lv anv�nt lite till och fr�n 
f�r att se vad folk s�jer i n�rheten. En annan h�ftig google maps mashup �r Trendsmap.com, d�r man samlar in twitterdata och presenterar de popul�raste hashtagsen 
p� en karta. H�r kan man exempelvis se vad det twittras om i olika delar av Sverige just nu.

* Merv�rdet av denna typ av applikation �r att den �r visuellt tilltalande och det g�r l�tt att f� en �verblick �ver geografisk data. Ist�llet f�r att f�rst s�ka p� 
vad det twittras om i Malm� f�r att sedan beh�va s�ka p� vad det twittras om i Stockholm, s� kan f� en �verblick �ver b�da orterna p� bara en sekund med hj�lp av 
Google Maps. Det samma g�ller f�r annonskartan, ist�llet f�r att beh�va g� in p� Tradera eller blocket f�r att titta p� en speciell stad, kan man direkt se vad som 
s�lj i Kalmar men �ven Nybro. 


