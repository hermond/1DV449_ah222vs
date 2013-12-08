#Steg 1. Optimering

##1. Tagit bort sleep fr�n php
F�re 6.88 sekunder 2.4 mb 19requests
Efter 7.07 sekunder 2.4 mb 18 requests
Minskade �ven inloggningstiden med 2 sekunder
Teorin s�ger att det �r dumt att l�ta php-koden medvetet stanna upp exekveringen av koden. Dessutom s� l�g denna 
funktion i en egen fil som var tvungen att f�rfr�gas fr�n servern, vilket skapar en extra http request.
###Reflektion
Laddningstiden blev betydligt mer anv�ndarv�nlig vid inloggningen. Av alla saker man kan pausa s� k�nns inloggningen 
v�ldigt konstigt att g�ra detta p�. Ang�ende laddningstiden s� borde denna ha minskat eftersom det blivit en request 
mindre, men det tog uppenbarligen en fj�rdedelssekund l�ngre. Vad detta beror p� �r om�jligt att s�ga, men det kan 
vara servern eller n�got annat program som suger bandbredd.
High Performance Web Sites, Steve Sounders, O�Reilly sida 10

##2. Lagt all css i en fil och  f�tt bort st�rre inline-styles
F�re 7.07 sekunder 2.4 mb 18requests
Efter 5.17 sekunder 2.4 mb 16 requests


Teorin s�ger att det �r b�ttre att ha css samlad i en fil f�r att p� s� s�tt minska antalet http-f�rfr�gningar, 
vilket g�r att sidan kan ladda in snabbare. Dock g�ller det att se upp f�r hur m�nga css-filer man sl�r ihop till en,
 ifall css:en inte anv�nds s� kommer filstorleken bli st�rre �n av den beh�ver vara. I denna applikation anv�nds samma 
 css i princip p� alla sidor vilket gjorde att jag valde att  sl� ihop den. Ang�ende inline styles, s� �r detta inte 
 n�got att f�redra d� de ligger p� en dynamisk html-sida som inte kan cachas av webbl�saren. Ligger d�remot all css i
 en egen fil, kan denna cachas vilket g�r att webbsidan blir snabbare. Dessutom s� hade alla inline-styles beh�vt 
 implementeras i olika html-filer, vilket hade gjort att storleken p� dessa varit on�digt stor.
https://developers.google.com/speed/pagespeed/service/CombineCSS
###Reflektion
Sidan laddas f�rhoppningsvis snabbare pga att antalet http-f�rfr�gningar minskat, men detta �r v�ldigt sv�rt att 
sl� fast eftersom Binero tycks vara lite instabilt beroende p� vilken tidpunkt man laddar sidan.

##3. L�tit all Javascript laddas in sist i dokumentet
F�re 5.17 sekunder 2.4 mb 18requests
Efter 3.31 sekunder 2.4 mb 16 requests
Teorin s�ger att script-filer ska laddas in efter att DOMen skrivits ut. Detta f�r att script som exempelvis ligger
 i mitten av koden, ser till att stanna upp all annan nedladdning och d� stoppar den �ven den parallella nedladdning
 av komponenter som skulle kunna ha utf�rts. �ven f�r anv�ndaren uppleves sidans laddtid betydligt snabbare d� man f�r
 upp hela sidan direkt ist�llet f�r att halva sidans html skrivs ut f�r att sedan v�nta p� att ett script ska laddas 
 in och d�refter f� se resterande html.
High Performance Web Sites, Steve Sounders, O�Reilly sida 45
###Reflektion
Den parallella nedladdningen fungerar b�ttre och detta leder nog med stor sannolikhet till att sidan laddas snabbare.
 Om det �r Bineros delade hosting som har l�gre belastning �n tidigare �r sv�rt att s�ga.

##4. Gjort bildfilerna close.png, prev.png och next.png till en fil och anv�nt css-sprites
Teorin s�ger att ju f�rre http requests n�r det kommer till inladdning av bilder, desto b�ttre. En webbsida laddas snabbare
 ju  f�rre http-requests en den beh�ver g�ra. Antalet bytes blir dessutom mindre eftersom varje request kr�ver utrymme i s� fall
 http-headers som image headers. Dessutom �r vissa webbl�sare snabbare p� att l�sa in en bildfil �n flera sm�.
https://developers.google.com/speed/pagespeed/module/filter-image-sprite
F�re 3.31 sekunder 2.4mb 16 requests
Efter 3.21 sekunder 2.4mb 14 requests
###Reflektion
Css sprites verkar ha minskat f�rfr�gningtiden lite, men det �r sv�rt att s�kerhetsst�lla. Eftersom antalet requests har 
minskat s� borde detta ha gjort sidan snabbare. Dock kan man alltid diskutera ifall css-sprites �r optimalt att anv�nda 
ifall man har en sida d�r man skiftar design och ikoner. Som utvecklare kan det kanske vara v�rt att f� n�gon request extra 
�n att beh�va g�ra nya sprites s� fort ikoner ska �ndras.
##5. �ndrat storlek p� bild som skalas om med html
F�re 3.21 sekunder 2.4mb 14 requests
Efter 2.45 sekunder 528kb 14 requests
Teorin s�ger att det �r idiotiskt att skala om bilder med html eller css och inte p� samma g�ng �ndra bildfilens storlek.
 Om bildfilens fulla storlek aldrig ska visas �r det inte n�gon god id� att inte skala om den. Den request som g�rs kommer
 ta betydligt l�ngre tid �n vad som egentligen beh�vs.
https://developers.google.com/speed/docs/best-practices/payload#ScaleImages
###Reflektion
Det �r uppenbart att storleken p� bilden spelar roll p� laddningstiden. Att minska storleken p� filen gjorde att den totala
 storleken p� allt som laddades in minskade med 80%, vilket gjorde att laddningstiden minskade.
##6. Ta bort resurser som inte finns

F�re 2.45 sekunder 528kb 14 requests
Efter 2.60 sekunder 528kb 12 requests

Teorin s�ger att det �r d�ligt att s�ga leta efter filer som inte existerar. Man vill allts� se till att klienten inte 
beh�ver l�gga tid p� att f�rfr�ga servern efter filer som �nd� inte finns. Om det exempelvis �r javascript som saknas s� 
kan s�kandet efter denna blockera parallell nedladdning.
http://developer.yahoo.com/performance/rules.html
###Reflektion
Att ta bort dessa filer gjorde ingen st�rre skillnad trots att det borde g�ra det, d� det visat sig tidigare i Chrome att 
dessa f�rdr�jt laddningen med 0,5-1 sekund. Vad det beror p� �r sv�rt att s�ga, men det kan (som vanligt) vara Binero som 
f�r tillf�llet �r lite l�ngsamt.

##7. Minifiering av css

F�re 2.60 sekunder 528kb 12 requests
Efter 2.70 sekunder 486kb 12 requests
Enligt teorin s� kan minifiering av css-kod reducera storleken p� en css-fil, vilket g�r att laddningstiden blir kortare. 
https://developers.google.com/speed/pagespeed/service/MinifyCSS
###Reflektion
Filstorleken blev mindre och d�rmed den totala storleken, men det blev ingen st�rre skillnad p� laddningstiden h�r heller.  
38kb �r ingen j�tteminskning n�r man sitter p� dagens 100mbits bredband.
##8. Minskat databasf�rfr�gningar

Sv�rt att m�ta d� det triggas av javascript

Enligt teorin �r det dumt att h�mta ut poster fr�n databasen en f�r en om man vet att flera beh�vs p� samma g�ng. 
Servern f�r skicka flera nya f�rfr�gningar till databasen som drar ner prestandan. 

###Reflektion
N�r meddelande h�mtades ut gjordes detta seperat, dvs en �t g�ngen. Nu �r det �ndrat s� att alla meddelande h�mtas
 och l�ggs i en array som sedan kan lopas ut med javascript. Detta verkar med "�gonm�tt" ha gjort att meddelanden laddas snabbare.
http://stackoverflow.com/questions/2077654/in-php-mysql-should-i-open-multiple-database-connections-or-share-1


#Steg 2. S�kerhet
##1.  XSS

*Jag uppt�ckte att man kunde mata in script som namn eller meddelandet p� en producents sida. 
* Detta kan utnyttjas till att exempelvis f�rst�ra en webbsida genom att se till att javascripten h�mtar in tunga bilder
 och annat, men �ven f�r att l�gga in script som h�mtar information om kakor och annat k�nsligt hos en anv�ndare. 
*Det kan leda till stora skador p� exempelvis community sajter, d�r man genom javascript kommer �t en anv�ndares 
inloggningskaka och kan anv�nda den f�r att skapa oreda och ta reda p� information som egentligen bara den "riktiga"
 autensierade anv�ndaren ska f� komma �t.

 *Jag har anv�nt mig av phps htmlspecialchars-funktion som g�r att taggar sparas i databasen och skrivs ut med 
 specialtecken och blir d�rmed verkningsl�sa.

##2. Parameterfr�gor

Jag uppt�ckte att parametrar till i de funktioner som anv�nder pdo och sql inte �r skyddade av parameterfr�gor. 
*S�kerhetsh�let g�r att utnyttja till sk SQL injections d�r en hackare kan skriva in helt andra sql-fr�gor �n vad som �r t�nkt.

*Detta kan g�ra s� att en hackare exempelvis kan fr�ga om information fr�n en l�senordstabell och f� ut l�senord eller ta bort information fr�n databasen.

*Jag implementerade PDOs bindparam-funktion och best�mde parametrarna.

##3. Utloggning med JavaScript

Jag uppt�ckte att utloggningen av sidan endast sker med en omdirigering i JavaScript.
*Detta g�r att en anv�ndare tror att de har loggat ut, men i sj�lva verket s� ligger sessionen kvar.
*En hackare eller egentligen vem som helst skulle kunna bli inloggade p� kontot genom att navigera till mess.php, 
trots att anv�ndaren tror sig vara utloggad f�r alltid. Detta skulle vara speciellt farligt p� exempelvis ett 
stadsbibliotek d�r flera m�nniskor anv�nder samma dator.

##4. L�ttkn�ckta l�senord

De b�da anv�ndarna user och admin har l�senord som �r likadana som anv�ndarnamnet. 

*Dessa l�senord �r l�tta att kn�cka f�r en hackare eller egentligen vem som helst.
*Kontot �r l�tta att komma �t och samla information ifr�n
*L�senorden �r inte hashade, men �r �tminstone lite sv�rare att l�sa. admin har f�tt l�senordet: detARkAlltiKalmarNu26 
och user har f�tt l�senordet mou22KYkL2xxO

##5. Cross site request forgery
Jag har hittat m�jligheten att lyckas g�ra en cross site request forgery genom formul�ret.
*Detta inneb�r att n�gon kan anv�nda en anv�ndares giltiga kaka f�r att posta data till en url. 
*Det som kan h�nda �r att n�gon ser till att skicka data med hj�lp av en autensierad anv�ndares kaka. 
Exempelvis �ppnar en autensierad anv�ndare en ny flik med ett script/l�nk som i bakgrunden skickar data 
till ett formul�r och lyckas tackvare att den satta kakan �r giltig.
*Jag har �tg�rdat detta med att generar en token varje g�ng som man ska posta data i formul�ret. Tokenen 
sparas i en session och i ett dolt input f�lt och dessa tv� m�ste st�mma �verens f�r att datan ska f� skickas.

 

#Steg 3. Ajax-implementation
F�r att implementera Ajax anropet och dessutom l�ta meddelandena bli sorterade i datumordning s� �ndrade jag f�rst funktionen getMessage i 
get.php s� att den h�mtar ut alla meddelanden p� en producent och returnerar detta som en array. Sedan tog jag bort den on�diga delen med 
Ajax d�r man f�rst letar upp serialnumbers p� varje producents meddelande f�r att sedan g�ra en ny f�rfr�gan och leta upp meddelandena, till 
att endast skicka med ett producerid och f� tillbaka alla meddelanden(dvs anv�nda den nya getMessage i get.php som returnerar en array med objekt). 
Objekten loopas sedan ut med sina meddelande, skribenter och ett datum(som lagts till i databasen).   
F�r att f� ut meddelandet direkt efter att man skickat in det s� s�g jag till att javascript-funktionen changeProducer anropades efter �t igen.  
 



