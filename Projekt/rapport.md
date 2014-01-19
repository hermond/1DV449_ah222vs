#Rapport

##Applikation och Bakgrund
Min Mashup samlar RSS-fl�de med artiklar fr�n fyra stora s�kmotorbloggar och presenterar dessa tillsamman med data p� hur mycket de har blivit delade i sociala medier. 
Applikationen �r som en topplista, vilket inneb�r att artiklarna kommer h�gre upp p� min sajt ju fler delningar de har f�tt. Det finns �ven m�jlighet att v�lja olika 
sorteringar ifall man vill se artiklar inom ett visst tidsintervall eller endast visa de mest delade artiklarna fr�n en av bloggarna.  

Bakgrunden �r att jag sj�lv �r v�ldigt intresserad av SEO och bes�ker flera av dessa bloggar regelbundet. N�r jag s�g Ted Valentins Socialanyheter.se s� t�nkte jag 
att jag kunde g�ra n�got liknande f�r SEO och s� blev det.

##Serversidan
Serversidan �r gjord i ren php utan n�got ramverk och �r uppdelade i tv� delar. 

###Del 1
Den f�rsta delen sk�ter med anrop fr�n cronjobs  inl�sningen av XML fr�n RSS-fl�den och uppdateringen av antalet delningar i sociala medier. Med andra ord s� �r det 
denna del som h�mtar data fr�n alla datak�llorna och uppdaterar min databas med nya artiklar och  s�v�l nya som gamla artiklar med sociala-delningar. Cron jobs anropar 
detta script var 15e minut. Datan fr�n RSS och API:erna sparas/cachas allts� 15 minuter i databasen innan de uppdateras igen. 
###Del 2
Den andra delen anropas med Ajax och ansvarar endast f�r att h�mta ut data fr�n databasen och skicka ner det till klienten. Ajax skickar en get-f�rfr�gan och f�r sedan 
tillbaka artiklar som �r fr�n de senaste 24 timmar, de senaste 48 timmarna, de senaste 7 dagarna eller de senaste 30 dagarna beroende p� get-paremetern. Eftersom det bara 
sker en get-f�rfr�gan och ingen data ska direkt valideras s� finns endast felhantering f�r databasanropet. 

##Klientsidan
Klientsidan �r byggd i ren Javascript och lite jQuery.  Den �r uppbyggd genom att lyssna p� olika hash-taggar i url:en och beroende p� vilken tid som anv�ndaren vill 
se artiklar ifr�n s� skickas ett anrop med Ajax. Eftersom det finns fyra typer av tider (24 timmar, 48 timmar, 7 dagar eller 30 dagar) s� f�r klienten tillbaka fyra
 olika arrayer med json-artiklar som kan loopas ut och visas. Sorteringen p� vilken specifik k�lla/blogg man vill visa artiklar ifr�n sk�ts helt p� klienten med de 
 fyra olika json-arrayerna.  Cachningen sk�ts med hj�lp av localstorage och ett bibliotek som heter lscache. De fyra olika arrayerna cachas 15 minuter i local storage. 
 Ifall n�got g�r fel vid Ajaxanropet eller artiklar saknas s� f�r anv�ndaren meddelande om att inga artiklar hittades. 
 
##Egenreflektion
�verlag s� har projektet flutit p� bra. Jag var r�dd f�r att det skulle bli jobbigt med 6 olika datak�llor och att samla in all data, men det gick att f� ihop det till slut. 
Det har varit lite pill med att behandla de fyra olika RSS-fl�dena d� XML-strukturen �r lite olika uppbyggd, men ocks� sorteringen p� klienten av vilken specifik blogg-k�lla 
som ska visas. L�sningen f�r sorteringen p� klienten �r jag inte alls n�jd med och �r ganska ful. Hade jag haft mer tid s� hade jag f�rs�kt l�sa det snyggare och b�ttre. 

Grundid�n fick jag ihop, men jag hade g�rna haft med �nnu fler RSS-fl�den, d� det finns m�nga fler s�kmotorbloggar �n de fyra jag har valt nu. F�rhoppningsvis s� r�cker 
det med de fyra av de st�rsta bloggarna i b�rjan och ifall tj�nsten blir popul�r s� kan jag fylla p� med fler. Eftersom Google plus �r v�ldigt popul�rt bland s�kmotorfolk, 
s� borde detta definitivt ha varit med som en k�lla till sociala delningar och jag �ngrar lite att jag valde att inte implementera det. Detta tillsammans med fler RSS-fl�den 
�r n�got som jag kommer bygga vidare p�.
Kodm�ssigt s� skulle jag ha lagt mer fokus p� klientvalideringen som inte �r j�ttebra l�st. Jag borde ha satt mig mer in i hur man jobbar med AjaxErrors och l�st det 
p� ett b�ttre s�tt. P� grund av att tiden tog slut s� valde jag att g�ra en v�ldigt l�tt l�sning.

##Risker och s�kerhet
Tekniskt- Det finn v�l egentligen tre stora risker med min applikation och det �r RSS-fl�dena, api:erna och Cronjobs. Eftersom min kod �r skriven f�r att l�sa in XML 
i en viss struktur fr�n de olika RSS-fl�dena, s� skulle hela inl�sningen kunna upph�ra ifall det gjordes �ndringar i XML-strukturen. OM API:erna skulle �ndra sitt s�tt 
att ge ut data eller s�tta en betydligt l�gre gr�ns f�r antal f�rfr�gningar, hade det  f�rst�rt fl�det i min applikation. Ifall CronJobs skulle sluta att fungera, eller 
b�rja anropa mitt inl�snings-skript oregelbundet s� hade detta ocks� f�rst�rt tanken bakom applikationsfl�det. 

S�kerhetsm�ssigt s� �r det v�l framf�rallt cronjobs-anropet som jag inte vill att n�gon annan ska kunna g�ra. Detta �r l�st med att l�senordskydda cron.php-fileni  
.htaccess. Skulle n�gon b�rja anropa cron.php s� k�rs det hela tiden nya f�rf�rfr�gning till API:erna och RSS-fl�dena, vilket skulle kunna medf�ra att jag blir blockerad. 

Det finns �ven risk med att de olika SEO-bloggarna tycker att jag anv�nder deras artiklar utan tillt�telse. Dock ser jag inte detta som en stor risk eftersom de sj�lva 
delar sina RSS-fl�den och min applikation �r egentligen som en RSS-l�sare som sorterar artiklar p� flest sociala delningar.








