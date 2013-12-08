#Steg 1. Optimering

##1. Tagit bort sleep från php
Före 6.88 sekunder 2.4 mb 19requests
Efter 7.07 sekunder 2.4 mb 18 requests
Minskade även inloggningstiden med 2 sekunder
Teorin säger att det är dumt att låta php-koden medvetet stanna upp exekveringen av koden. Dessutom så låg denna 
funktion i en egen fil som var tvungen att förfrågas från servern, vilket skapar en extra http request.
###Reflektion
Laddningstiden blev betydligt mer användarvänlig vid inloggningen. Av alla saker man kan pausa så känns inloggningen 
väldigt konstigt att göra detta på. Angående laddningstiden så borde denna ha minskat eftersom det blivit en request 
mindre, men det tog uppenbarligen en fjärdedelssekund längre. Vad detta beror på är omöjligt att säga, men det kan 
vara servern eller något annat program som suger bandbredd.
High Performance Web Sites, Steve Sounders, O’Reilly sida 10

##2. Lagt all css i en fil och  fått bort större inline-styles
Före 7.07 sekunder 2.4 mb 18requests
Efter 5.17 sekunder 2.4 mb 16 requests


Teorin säger att det är bättre att ha css samlad i en fil för att på så sätt minska antalet http-förfrågningar, 
vilket gör att sidan kan ladda in snabbare. Dock gäller det att se upp för hur många css-filer man slår ihop till en,
 ifall css:en inte används så kommer filstorleken bli större än av den behöver vara. I denna applikation används samma 
 css i princip på alla sidor vilket gjorde att jag valde att  slå ihop den. Angående inline styles, så är detta inte 
 något att föredra då de ligger på en dynamisk html-sida som inte kan cachas av webbläsaren. Ligger däremot all css i
 en egen fil, kan denna cachas vilket gör att webbsidan blir snabbare. Dessutom så hade alla inline-styles behövt 
 implementeras i olika html-filer, vilket hade gjort att storleken på dessa varit onödigt stor.
https://developers.google.com/speed/pagespeed/service/CombineCSS
###Reflektion
Sidan laddas förhoppningsvis snabbare pga att antalet http-förfrågningar minskat, men detta är väldigt svårt att 
slå fast eftersom Binero tycks vara lite instabilt beroende på vilken tidpunkt man laddar sidan.

##3. Låtit all Javascript laddas in sist i dokumentet
Före 5.17 sekunder 2.4 mb 18requests
Efter 3.31 sekunder 2.4 mb 16 requests
Teorin säger att script-filer ska laddas in efter att DOMen skrivits ut. Detta för att script som exempelvis ligger
 i mitten av koden, ser till att stanna upp all annan nedladdning och då stoppar den även den parallella nedladdning
 av komponenter som skulle kunna ha utförts. Även för användaren uppleves sidans laddtid betydligt snabbare då man får
 upp hela sidan direkt istället för att halva sidans html skrivs ut för att sedan vänta på att ett script ska laddas 
 in och därefter få se resterande html.
High Performance Web Sites, Steve Sounders, O’Reilly sida 45
###Reflektion
Den parallella nedladdningen fungerar bättre och detta leder nog med stor sannolikhet till att sidan laddas snabbare.
 Om det är Bineros delade hosting som har lägre belastning än tidigare är svårt att säga.

##4. Gjort bildfilerna close.png, prev.png och next.png till en fil och använt css-sprites
Teorin säger att ju förre http requests när det kommer till inladdning av bilder, desto bättre. En webbsida laddas snabbare
 ju  färre http-requests en den behöver göra. Antalet bytes blir dessutom mindre eftersom varje request kräver utrymme i så fall
 http-headers som image headers. Dessutom är vissa webbläsare snabbare på att läsa in en bildfil än flera små.
https://developers.google.com/speed/pagespeed/module/filter-image-sprite
Före 3.31 sekunder 2.4mb 16 requests
Efter 3.21 sekunder 2.4mb 14 requests
###Reflektion
Css sprites verkar ha minskat förfrågningtiden lite, men det är svårt att säkerhetsställa. Eftersom antalet requests har 
minskat så borde detta ha gjort sidan snabbare. Dock kan man alltid diskutera ifall css-sprites är optimalt att använda 
ifall man har en sida där man skiftar design och ikoner. Som utvecklare kan det kanske vara värt att få någon request extra 
än att behöva göra nya sprites så fort ikoner ska ändras.
##5. Ändrat storlek på bild som skalas om med html
Före 3.21 sekunder 2.4mb 14 requests
Efter 2.45 sekunder 528kb 14 requests
Teorin säger att det är idiotiskt att skala om bilder med html eller css och inte på samma gång ändra bildfilens storlek.
 Om bildfilens fulla storlek aldrig ska visas är det inte någon god idé att inte skala om den. Den request som görs kommer
 ta betydligt längre tid än vad som egentligen behövs.
https://developers.google.com/speed/docs/best-practices/payload#ScaleImages
###Reflektion
Det är uppenbart att storleken på bilden spelar roll på laddningstiden. Att minska storleken på filen gjorde att den totala
 storleken på allt som laddades in minskade med 80%, vilket gjorde att laddningstiden minskade.
##6. Ta bort resurser som inte finns

Före 2.45 sekunder 528kb 14 requests
Efter 2.60 sekunder 528kb 12 requests

Teorin säger att det är dåligt att säga leta efter filer som inte existerar. Man vill alltså se till att klienten inte 
behöver lägga tid på att förfråga servern efter filer som ändå inte finns. Om det exempelvis är javascript som saknas så 
kan sökandet efter denna blockera parallell nedladdning.
http://developer.yahoo.com/performance/rules.html
###Reflektion
Att ta bort dessa filer gjorde ingen större skillnad trots att det borde göra det, då det visat sig tidigare i Chrome att 
dessa fördröjt laddningen med 0,5-1 sekund. Vad det beror på är svårt att säga, men det kan (som vanligt) vara Binero som 
för tillfället är lite långsamt.

##7. Minifiering av css

Före 2.60 sekunder 528kb 12 requests
Efter 2.70 sekunder 486kb 12 requests
Enligt teorin så kan minifiering av css-kod reducera storleken på en css-fil, vilket gör att laddningstiden blir kortare. 
https://developers.google.com/speed/pagespeed/service/MinifyCSS
###Reflektion
Filstorleken blev mindre och därmed den totala storleken, men det blev ingen större skillnad på laddningstiden här heller.  
38kb är ingen jätteminskning när man sitter på dagens 100mbits bredband.
##8. Minskat databasförfrågningar

Svårt att mäta då det triggas av javascript

Enligt teorin är det dumt att hämta ut poster från databasen en för en om man vet att flera behövs på samma gång. 
Servern får skicka flera nya förfrågningar till databasen som drar ner prestandan. 

###Reflektion
När meddelande hämtades ut gjordes detta seperat, dvs en åt gången. Nu är det ändrat så att alla meddelande hämtas
 och läggs i en array som sedan kan lopas ut med javascript. Detta verkar med "ögonmått" ha gjort att meddelanden laddas snabbare.
http://stackoverflow.com/questions/2077654/in-php-mysql-should-i-open-multiple-database-connections-or-share-1


#Steg 2. Säkerhet
##1.  XSS

*Jag upptäckte att man kunde mata in script som namn eller meddelandet på en producents sida. 
* Detta kan utnyttjas till att exempelvis förstöra en webbsida genom att se till att javascripten hämtar in tunga bilder
 och annat, men även för att lägga in script som hämtar information om kakor och annat känsligt hos en användare. 
*Det kan leda till stora skador på exempelvis community sajter, där man genom javascript kommer åt en användares 
inloggningskaka och kan använda den för att skapa oreda och ta reda på information som egentligen bara den "riktiga"
 autensierade användaren ska få komma åt.

 *Jag har använt mig av phps htmlspecialchars-funktion som gör att taggar sparas i databasen och skrivs ut med 
 specialtecken och blir därmed verkningslösa.

##2. Parameterfrågor

Jag upptäckte att parametrar till i de funktioner som använder pdo och sql inte är skyddade av parameterfrågor. 
*Säkerhetshålet går att utnyttja till sk SQL injections där en hackare kan skriva in helt andra sql-frågor än vad som är tänkt.

*Detta kan göra så att en hackare exempelvis kan fråga om information från en lösenordstabell och få ut lösenord eller ta bort information från databasen.

*Jag implementerade PDOs bindparam-funktion och bestämde parametrarna.

##3. Utloggning med JavaScript

Jag upptäckte att utloggningen av sidan endast sker med en omdirigering i JavaScript.
*Detta gör att en användare tror att de har loggat ut, men i själva verket så ligger sessionen kvar.
*En hackare eller egentligen vem som helst skulle kunna bli inloggade på kontot genom att navigera till mess.php, 
trots att användaren tror sig vara utloggad för alltid. Detta skulle vara speciellt farligt på exempelvis ett 
stadsbibliotek där flera människor använder samma dator.

##4. Lättknäckta lösenord

De båda användarna user och admin har lösenord som är likadana som användarnamnet. 

*Dessa lösenord är lätta att knäcka för en hackare eller egentligen vem som helst.
*Kontot är lätta att komma åt och samla information ifrån
*Lösenorden är inte hashade, men är åtminstone lite svårare att lösa. admin har fått lösenordet: detARkAlltiKalmarNu26 
och user har fått lösenordet mou22KYkL2xxO

##5. Cross site request forgery
Jag har hittat möjligheten att lyckas göra en cross site request forgery genom formuläret.
*Detta innebär att någon kan använda en användares giltiga kaka för att posta data till en url. 
*Det som kan hända är att någon ser till att skicka data med hjälp av en autensierad användares kaka. 
Exempelvis öppnar en autensierad användare en ny flik med ett script/länk som i bakgrunden skickar data 
till ett formulär och lyckas tackvare att den satta kakan är giltig.
*Jag har åtgärdat detta med att generar en token varje gång som man ska posta data i formuläret. Tokenen 
sparas i en session och i ett dolt input fält och dessa två måste stämma överens för att datan ska få skickas.

 

#Steg 3. Ajax-implementation
För att implementera Ajax anropet och dessutom låta meddelandena bli sorterade i datumordning så ändrade jag först funktionen getMessage i 
get.php så att den hämtar ut alla meddelanden på en producent och returnerar detta som en array. Sedan tog jag bort den onödiga delen med 
Ajax där man först letar upp serialnumbers på varje producents meddelande för att sedan göra en ny förfrågan och leta upp meddelandena, till 
att endast skicka med ett producerid och få tillbaka alla meddelanden(dvs använda den nya getMessage i get.php som returnerar en array med objekt). 
Objekten loopas sedan ut med sina meddelande, skribenter och ett datum(som lagts till i databasen).   
För att få ut meddelandet direkt efter att man skickat in det så såg jag till att javascript-funktionen changeProducer anropades efter åt igen.  
 



