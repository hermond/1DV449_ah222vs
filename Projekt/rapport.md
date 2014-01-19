#Rapport

##Applikation och Bakgrund
Min Mashup samlar RSS-flöde med artiklar från fyra stora sökmotorbloggar och presenterar dessa tillsamman med data på hur mycket de har blivit delade i sociala medier. 
Applikationen är som en topplista, vilket innebär att artiklarna kommer högre upp på min sajt ju fler delningar de har fått. Det finns även möjlighet att välja olika 
sorteringar ifall man vill se artiklar inom ett visst tidsintervall eller endast visa de mest delade artiklarna från en av bloggarna.  

Bakgrunden är att jag själv är väldigt intresserad av SEO och besöker flera av dessa bloggar regelbundet. När jag såg Ted Valentins Socialanyheter.se så tänkte jag 
att jag kunde göra något liknande för SEO och så blev det.

##Serversidan
Serversidan är gjord i ren php utan något ramverk och är uppdelade i två delar. 

###Del 1
Den första delen sköter med anrop från cronjobs  inläsningen av XML från RSS-flöden och uppdateringen av antalet delningar i sociala medier. Med andra ord så är det 
denna del som hämtar data från alla datakällorna och uppdaterar min databas med nya artiklar och  såväl nya som gamla artiklar med sociala-delningar. Cron jobs anropar 
detta script var 15e minut. Datan från RSS och API:erna sparas/cachas alltså 15 minuter i databasen innan de uppdateras igen. 
###Del 2
Den andra delen anropas med Ajax och ansvarar endast för att hämta ut data från databasen och skicka ner det till klienten. Ajax skickar en get-förfrågan och får sedan 
tillbaka artiklar som är från de senaste 24 timmar, de senaste 48 timmarna, de senaste 7 dagarna eller de senaste 30 dagarna beroende på get-paremetern. Eftersom det bara 
sker en get-förfrågan och ingen data ska direkt valideras så finns endast felhantering för databasanropet. 

##Klientsidan
Klientsidan är byggd i ren Javascript och lite jQuery.  Den är uppbyggd genom att lyssna på olika hash-taggar i url:en och beroende på vilken tid som användaren vill 
se artiklar ifrån så skickas ett anrop med Ajax. Eftersom det finns fyra typer av tider (24 timmar, 48 timmar, 7 dagar eller 30 dagar) så får klienten tillbaka fyra
 olika arrayer med json-artiklar som kan loopas ut och visas. Sorteringen på vilken specifik källa/blogg man vill visa artiklar ifrån sköts helt på klienten med de 
 fyra olika json-arrayerna.  Cachningen sköts med hjälp av localstorage och ett bibliotek som heter lscache. De fyra olika arrayerna cachas 15 minuter i local storage. 
 Ifall något går fel vid Ajaxanropet eller artiklar saknas så får användaren meddelande om att inga artiklar hittades. 
 
##Egenreflektion
Överlag så har projektet flutit på bra. Jag var rädd för att det skulle bli jobbigt med 6 olika datakällor och att samla in all data, men det gick att få ihop det till slut. 
Det har varit lite pill med att behandla de fyra olika RSS-flödena då XML-strukturen är lite olika uppbyggd, men också sorteringen på klienten av vilken specifik blogg-källa 
som ska visas. Lösningen för sorteringen på klienten är jag inte alls nöjd med och är ganska ful. Hade jag haft mer tid så hade jag försökt lösa det snyggare och bättre. 

Grundidén fick jag ihop, men jag hade gärna haft med ännu fler RSS-flöden, då det finns många fler sökmotorbloggar än de fyra jag har valt nu. Förhoppningsvis så räcker 
det med de fyra av de största bloggarna i början och ifall tjänsten blir populär så kan jag fylla på med fler. Eftersom Google plus är väldigt populärt bland sökmotorfolk, 
så borde detta definitivt ha varit med som en källa till sociala delningar och jag ångrar lite att jag valde att inte implementera det. Detta tillsammans med fler RSS-flöden 
är något som jag kommer bygga vidare på.
Kodmässigt så skulle jag ha lagt mer fokus på klientvalideringen som inte är jättebra löst. Jag borde ha satt mig mer in i hur man jobbar med AjaxErrors och löst det 
på ett bättre sätt. På grund av att tiden tog slut så valde jag att göra en väldigt lätt lösning.

##Risker och säkerhet
Tekniskt- Det finn väl egentligen tre stora risker med min applikation och det är RSS-flödena, api:erna och Cronjobs. Eftersom min kod är skriven för att läsa in XML 
i en viss struktur från de olika RSS-flödena, så skulle hela inläsningen kunna upphöra ifall det gjordes ändringar i XML-strukturen. OM API:erna skulle ändra sitt sätt 
att ge ut data eller sätta en betydligt lägre gräns för antal förfrågningar, hade det  förstört flödet i min applikation. Ifall CronJobs skulle sluta att fungera, eller 
börja anropa mitt inläsnings-skript oregelbundet så hade detta också förstört tanken bakom applikationsflödet. 

Säkerhetsmässigt så är det väl framförallt cronjobs-anropet som jag inte vill att någon annan ska kunna göra. Detta är löst med att lösenordskydda cron.php-fileni  
.htaccess. Skulle någon börja anropa cron.php så körs det hela tiden nya förförfrågning till API:erna och RSS-flödena, vilket skulle kunna medföra att jag blir blockerad. 

Det finns även risk med att de olika SEO-bloggarna tycker att jag använder deras artiklar utan tilltåtelse. Dock ser jag inte detta som en stor risk eftersom de själva 
delar sina RSS-flöden och min applikation är egentligen som en RSS-läsare som sorterar artiklar på flest sociala delningar.








