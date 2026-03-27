<!DOCTYPE html
     PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="no" lang="no">
<head profile="http://gmpg.org/xfn/1">
    <title>Alf Kåre Lefdal - Moduluskontroll</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="ICBM" content="59.9247, 10.7739" />
    <meta name="DC.title" content="Hjemmeside for Alf Kåre Lefdal" />
    <script type="text/javascript" src="https://www.google-analytics.com/urchin.js"></script>
    <link rel="stylesheet" type="text/css" media="screen, print" href="/styles-site.css"  />
    <link rel="stylesheet" type="text/css" media="print" href="/print.css" />
    </head>

<body id="lefdal-cc" class="nydesign">
<div id="header">
    <h1><a href="/">Alf Kåre Lefdal</a></h1>
</div>

<div id="navmenu">
    <ul>
        <li><a href="/blog/">Blogg</a></li>
        <li><a href="/links">Lenker</a></li>
        <li><a href="/info">Kontakt Alf Kåre</a></li>
    </ul>

</div>
<div id="main">
<!--[if lte IE 6]>
<style type="text/css">
    #ie6msg{border:3px solid #c33; margin:8px 0; background:#fcc; color:#000;}
    #ie6msg h4{margin:8px; padding:0;}
    #ie6msg p{margin:8px; padding:0;}
    #ie6msg p a.getie7{font-weight:bold; color:#006;}
    #ie6msg p a.ie6expl{font-weight:bold; color:#006;}
</style>
<div id="ie6msg">
<h4>Did you know that your browser is out of date?</h4>
<p>To get the best possible experience using my website I recommend that you upgrade your browser to a newer version. The current version is <a class="getie7" href="http://www.microsoft.com/windows/downloads/ie/getitnow.mspx">Internet Explorer 7</a> or <a class="getie7" href="http://www.microsoft.com/windows/Internet-explorer/beta/default.aspx">Internet Explorer 8 (Beta)</a>. The upgrade is free. If you're using a PC at work you should contact your IT-administrator. Either way, I'd personally like to encourage you to stop using IE6 and try a more secure and Web Standards-friendly browser.</p>
<p>You could also try some other popular browsers like <a class="ie6expl" href="http://mozilla.com">FireFox</a> or <a class="ie6expl" href="http://www.opera.com">Opera</a>.</p>
</div>
<![endif]-->

<script type="text/javascript">
<!--
/**
 * The length of numbers
 */
var FNR_NUMBER_LENGTH = 11;
var ACCOUNT_NUMBER_LENGTH = 11;

var mod11Array10 = new Array(3, 7, 6, 1, 8, 9, 4, 5, 2);
var mod11Array11 = new Array(5, 4, 3, 2, 7, 6, 5, 4, 3, 2);

/**
 * Returns true if the input is valid according to the mod 11 test
 * false otherwise.
 */
function fnrMod11(valueToCheck){
    var checkDigit = getCheckDigit(valueToCheck.substring(0, valueToCheck.length - 1));

    var inCheckDigit = parseInt(valueToCheck.substring(valueToCheck.length - 1));
    return (inCheckDigit == checkDigit);
}

function getCheckDigit(sValue){
    var modArray;
    if (sValue.length == 9){
        modArray = mod11Array10;
    }
    else{
        modArray = mod11Array11;
    }

    var sum = 0;
    for (var i = 0; i < modArray.length; i++){
      sum += parseInt(sValue.substring(i, i + 1)) * modArray[i];;
    }

    var checkDigit = 11 - (sum % 11);
    if (checkDigit == 11){
      checkDigit = 0;
    }

    return checkDigit;
}

function getKontrollsifferMod11(nummer) {
    const weights = [2, 3, 4, 5, 6, 7];
    let sum = 0;

    let reversed = nummer.toString().split('').reverse().join('')

    for (let index = 0; index < reversed.length; index++) {
        sum += parseInt(reversed.charAt(index), 10) * weights[index % 6];
    }

    const remainder = 11 - (sum % 11);
    if (remainder === 11)
        return 0;
    if (remainder === 10)
        return '-';
    return remainder;
  }

  function checkMod11(valueToCheck){
    var checkDigit = getKontrollsifferMod11(valueToCheck.substring(0, valueToCheck.length - 1));

    var inCheckDigit = valueToCheck.substring(valueToCheck.length - 1);
    return (inCheckDigit == (checkDigit + ''));
}


function validateFnr(fnr){
    if (fnr.length != FNR_NUMBER_LENGTH){
        return false;
    }

    // Sjekk første kontrollsiffer
    if (!fnrMod11(fnr.substring(0, FNR_NUMBER_LENGTH - 1))){
        return false;
    }

    // Sjekk andre kontrollsiffer
    return fnrMod11(fnr);
}

function validateAccount(account){
    if (account.length != ACCOUNT_NUMBER_LENGTH){
        return false;
    }

    // Sjekk kontrollsiffer
    return checkMod11(account);
}

function sjekk(){
    var fnr_field = document.getElementById("fnr");
    var fnr = fnr_field.value;
    var svar = validateFnr(fnr);
    if (svar){
        document.getElementById("svar_fnr_sjekk").innerHTML = fnr + " er et godkjent fødselsnummer";
    }
    else {
        document.getElementById("svar_fnr_sjekk").innerHTML = fnr + " er IKKE et godkjent fødselsnummer";
    }
    return;
}

function sjekk_konto(){
    var konto = document.getElementById("konto").value;
    var svar = validateAccount(konto);
    if (svar){
        document.getElementById("svar_sjekk_konto").innerHTML = konto + " er et gyldig kontonr";
    }
    else {
        document.getElementById("svar_sjekk_konto").innerHTML = konto + " er IKKE et gyldig kontonr";
    }
    return;
}

function sjekk_mod11(){
    var nummer = document.getElementById("kid").value;
    var svar = checkMod11(nummer);
    if (svar){
        document.getElementById("svar_sjekk_mod11").innerHTML = nummer + " er gyldig (MOD11)";
    }
    else {
        document.getElementById("svar_sjekk_mod11").innerHTML = nummer + " er IKKE gyldig (MOD11)";
    }
    return;
}

function mod11_lag_kontrollsiffer(){
    var grunnlagstall = document.getElementById("grunnlagstall").value;

    var kontrollsiffer = getKontrollsifferMod11(grunnlagstall) + '';

    document.getElementById("svar_mod11_kontrollsiffer").innerHTML = "Med kontrollsiffer: " + grunnlagstall + kontrollsiffer;
    return;
}

function generer_kontrollsiffer(){
    var fnr9 = document.getElementById("fnr9").value;
    if (fnr9.length != FNR_NUMBER_LENGTH - 2){
        document.getElementById("svar_fullt_fnr").innerHTML = "Må være 9 siffer";
        return;
    }

    var kontrollsiffer = getCheckDigit(fnr9) + '';
    if (isNaN(kontrollsiffer)){
        document.getElementById("svar_fullt_fnr").innerHTML = "Må være numerisk";
        return;
    }
    if (kontrollsiffer == '10'){
        document.getElementById("svar_fullt_fnr").innerHTML = "Vil aldri bli tildelt som fødselsnummer";
        return;
    }

    var fnr10 = fnr9 + kontrollsiffer;
    kontrollsiffer = getCheckDigit(fnr10) + '';
    if (isNaN(kontrollsiffer)){
        document.getElementById("svar_fullt_fnr").innerHTML = "Må være numerisk";
        return;
    }
    if (kontrollsiffer == '10'){
        document.getElementById("svar_fullt_fnr").innerHTML = "Vil aldri bli tildelt som fødselsnummer";
        return;
    }

    document.getElementById("svar_fullt_fnr").innerHTML = "Fullt fødselsnummer: " + fnr10 + kontrollsiffer;
    return;
}

function Mod10(kid)
{
    var isOne = false;
    var controlNumber = 0;
    var length = kid.length;

    for (var i = 0; i < length; i++){
        var sifferIndex = length - i - 1
        var siffer = kid.substring(sifferIndex, sifferIndex + 1)
        var intNumber = parseInt(siffer);
        var sum = isOne ? intNumber : 2 * intNumber;
        if (sum > 9)
        {
            sum = (sum%10) + 1;
        }
        isOne = !isOne;
        controlNumber += sum;
    }
    return (10 - (controlNumber % 10))  % 10 == 0
        ? 0
        : 10 - (controlNumber % 10) ;
}

function mod10_lag_kontrollsiffer(){
    var tegn = document.getElementById("kid_mod10").value;
    var kontrollsiffer = Mod10(tegn) + '';

    document.getElementById("svar_mod10_kontrollsiffer").innerHTML = "Med kontrollsiffer: " + tegn + kontrollsiffer;
    return;
}

function mod10Validering(valueToCheck){
    var checkDigit = Mod10(valueToCheck.substring(0, valueToCheck.length - 1));

    var inCheckDigit = parseInt(valueToCheck.substring(valueToCheck.length - 1));
    return (inCheckDigit == checkDigit);
}

function mod10_sjekk_kontrollsiffer(){
    var nummer = document.getElementById("kid2").value;
    var svar = mod10Validering(nummer);
    if (svar){
        document.getElementById("svar_sjekk_mod10").innerHTML = nummer + " er gyldig (MOD10)";
    }
    else {
        document.getElementById("svar_sjekk_mod10").innerHTML = nummer + " er IKKE gyldig (MOD10)";
    }
    return;
}

// -->
</script>

<h1>Moduluskontroll</h1>
<p>Modulus-kontroll er verifisering og generering av kontrollsiffer på viktige nummer, som fx. fødselsnummer, kontonummer og KID. Kalles også CDV: Check Digit Verification. </p>

<h2>Modulus 11 (Mod11)</h2>

<p>Modulus 11 er i bruk i flere sammenhenger: Fødselsnummer, kontonummer, KID, m.fl. Mod11 kan gi kontrollsiffer 0-9,
    samt '-' i tilfelle kontrollsifferet beregnes til 10.</p>

<h3>Fødselsnummer</h3>

<p>Fødselsnummer består av seks siffer som representerer fødselsnummer, deretter tre siffer som
    er et løpenummer, og til slutt to kontrontrollsiffer. Første kontrollsiffer bruker Mod11-algoritmen,
    med med et helt spesielt sett med multiplikasjonsfaktorer, mens siste kontrollsiffer er helt
    standard Mod11. Dersom noen av kontrollsifferne beregnes til '-', så forkastes fødselsnummeret -
    det vil da ikke bli utstedt.
</p>

<form action="javascript:sjekk();" id="skjema">
<p>Skriv inn fødselsnr: <input type="text" id="fnr" />
<input type="submit" id="submit_fnr" value="Sjekk fødselsnr" /> </p>
<p><em id="svar_fnr_sjekk">&nbsp;</em></p>
</form>
<p><em>Forbehold:</em> Det er kun kontrollsifferne (2 siste siffer) som sjekkes i forhold til resten av fødselsnummeret.
Det foretas ingen sjekk av om datoen er en gyldig dato, eller om individnummeret (7.-9. siffer) er mulig for den angitte
datoen.</p>
<p>Les mer om fødselsnummer på
<a href="https://www.skatteetaten.no/person/folkeregister/fodsel-og-navnevalg/barn-fodt-i-norge/fodselsnummer/">Skatteetaten</a> sine sider.</p>

<h4>Generer kontrollsiffer til fødselsnummer</h4>

<form action="javascript:generer_kontrollsiffer();" id="skjema_kontrollsiffer">
<p>Skriv inn 9 første siffer av fødselsnr: <input type="text" id="fnr9" />
<input type="submit" id="submit_fnr_lag_kontrollsiffer" value="Finn kontrollsiffer" /> </p>
<p><em id="svar_fullt_fnr">&nbsp;</em></p>
</form>

<h3>Kontonummer</h3>
<p>Kontonummer bruker helt standard Mod11, i tillegg er det krav om de fire første sifferne representerer
    riktig bank og at kontonummeret er på 11 tegn. Dersom kontrollsifferet blir '-', så forkastes kontonummeret
    og brukes ikke.
</p>
<form action="javascript:sjekk_konto();" id="skjema_kontonr">
<p>Skriv inn kontonr: <input type="text" id="konto" />
<input type="submit" id="submit_sjekk_konto" value="Sjekk kontonr" /> </p>
<p><em id="svar_sjekk_konto">&nbsp;</em></p>
</form>
<p><em>Forbehold:</em> Det er kun kontrollsifferet (siste siffer) som sjekkes i forhold til resten av kontonummeret.
Det foretas ingen sjekk av om bankregisternummeret (4 første siffer) er gyldig. I tillegg til sjekk av
kontrollsiffer, så verifiseres det at kontonummeret er 11 tegn langt.</p>

<h3>Sjekk av Orgnr, KID, ISBN, strekkoder etc. (MOD11)</h3>
<form action="javascript:sjekk_mod11();" id="skjema_kid">
<p>Skriv inn nummeret: <input type="text" id="kid" />
<input type="submit" id="submit_sjekk_modd11" value="Sjekk kontrollsiffer" /> </p>
<p><em id="svar_sjekk_mod11">&nbsp;</em></p>
</form>

<h3>Beregning av kontrollsiffer - MOD11</h3>
<form action="javascript:mod11_lag_kontrollsiffer();" id="skjema_mod10_kontrollsiffer">
<p>Skriv inn grunnlagstallet: <input type="text" id="grunnlagstall" />
<input type="submit" id="submit_lag_mod11_kontrollsiffer" value="Lag kontrollsiffer" /> </p>
<p><em id="svar_mod11_kontrollsiffer">&nbsp;</em></p>
</form>


<h2>Modulus10 (Mod10)</h2>
<p>Modulus10 kalles Luhn's algoritme, og er en annen algoritme enn Modulus11, og brukes fx.
    til validering av KID-nr på bankgiroer. Les mer på <a href="https://no.wikipedia.org/wiki/MOD10">Wikipedia</a>.
    Jeg har laget <a href="https://gist.github.com/aklefdal/1367a06bba1728399f232e3e7340ff9d">VBA</a>-kode for dette,
    og den er implementer i et <a href="https://www.dropbox.com/s/83xiakj850esdgh/MOD10.xlsm?dl=0">Excel</a>-dokument også.</p>

<h3>Sjekk av KID etc. (MOD10)</h3>
<form action="javascript:mod10_sjekk_kontrollsiffer();" id="skjema_mod10_sjekk">
<p>Skriv inn KID (eller annet tall som skal valideres): <input type="text" id="kid2" />
<input type="submit" id="submit_sjekk_mod10_kontrollsiffer" value="Sjekk kontrollsiffer" /> </p>
<p><em id="svar_sjekk_mod10">&nbsp;</em></p>
</form>

<h3>Beregning av kontrollsiffer - MOD10</h3>
<form action="javascript:mod10_lag_kontrollsiffer();" id="skjema_mod10_kontrollsiffer">
<p>Skriv inn grunnlagstallet: <input type="text" id="kid_mod10" />
<input type="submit" id="submit_lag_mod10_kontrollsiffer" value="Lag kontrollsiffer" /> </p>
<p><em id="svar_mod10_kontrollsiffer">&nbsp;</em></p>
</form>


<h2>Eksempel med fødselsnummer</h2>

<p>I eksemplet her bruker jeg som et eksempel fødselsnummeret 26059765131.</p>
<h3>Beregning av 1. kontrollsiffer</h3>
<p>
Man tar utgangspunkt i de 9
første sifferne (her 260597651).  Først multipliserer man siffer for siffer med følgende tallrekke: 3, 7, 6, 1, 8, 9, 4, 5 og 2.
Deretter summerer man resultatene.  Så finner første kontrollsiffer ved å trekke "resten" man får når man deler dette
på 11 (herav navnet modulus11-kontroll), og trekker denne "resten" fra 11.  Hvis kontrollsifferet blir 11, så settes det til 0,
og hvis det blir 10, så er det ikke gyldig (da må det genereres et nytt individnummer).</p>
<p>Eksempel: Fødselnummeret er 26059765131.  De første 9 sifferne, som danner utgangspunktet for å beregne kontrollsifferet,
er 260597651.  Nedenfor vises regnestykket:</p>
<table class="validering">
    <tr>
        <th>Siffer nr.</th><th>Siffer</th><th>Multiplikator</th><th>Multiplum</th>
    </tr><tr>
        <td>1</td><td>2</td><td>3</td><td>6</td>
    </tr><tr>
        <td>2</td><td>6</td><td>7</td><td>42</td>
    </tr><tr>
        <td>3</td><td>0</td><td>6</td><td>0</td>
    </tr><tr>
        <td>4</td><td>5</td><td>1</td><td>5</td>
    </tr><tr>
        <td>5</td><td>9</td><td>8</td><td>72</td>
    </tr><tr>
        <td>6</td><td>7</td><td>9</td><td>63</td>
    </tr><tr>
        <td>7</td><td>6</td><td>4</td><td>24</td>
    </tr><tr>
        <td>8</td><td>5</td><td>5</td><td>25</td>
    </tr><tr>
        <td>9</td><td>1</td><td>2</td><td>2</td>
    </tr><tr>
        <td colspan="3">Sum:</td><td>239</td>
    </tr>
</table>
<p>Denne summen deler man på 11, og får da en "rest" på 8 (11x21=231, 239-231=8).  Dette trekker vi fra 11, og får da 3 (11-8=3).</p>
<p>Første kontrollsiffer skal være 3, og det stemmer i vårt tilfelle.</p>

<h3>Beregning av 2. kontrollsiffer</h3>
<p>
Framgangsmåten er tilsvarende som for 1. kontrollsiffer, men man tar utgangspunkt i de 10
første sifferne (her 2605976513), og tallrekken er annerledes: 5, 4, 3, 2, 7, 6, 5, 4, 3 og 2. Egentlig er
tallrekken 2 til 7 bakenifra, og man begynner på 2 igjen på det syvende sifferet bakenifra.</p>
<p>Dette er også måten å finne kontrollsifferet til kontonummer på, da de har kun et kontrollsiffer.</p>
<p>Eksempel: Fødselsnummeret (eller like gjerne kontonummeret) er 26059765131.  De første 10 sifferne, som danner utgangspunktet for å beregne kontrollsifferet,
er 2605976513.  Nedenfor vises regnestykket:</p>
<table class="validering">
    <tr>
        <th>Siffer nr.</th><th>Siffer</th><th>Multiplikator</th><th>Multiplum</th>
    </tr><tr>
        <td>1</td><td>2</td><td>5</td><td>10</td>
    </tr><tr>
        <td>2</td><td>6</td><td>4</td><td>24</td>
    </tr><tr>
        <td>3</td><td>0</td><td>3</td><td>0</td>
    </tr><tr>
        <td>4</td><td>5</td><td>2</td><td>10</td>
    </tr><tr>
        <td>5</td><td>9</td><td>7</td><td>63</td>
    </tr><tr>
        <td>6</td><td>7</td><td>6</td><td>42</td>
    </tr><tr>
        <td>7</td><td>6</td><td>5</td><td>30</td>
    </tr><tr>
        <td>8</td><td>5</td><td>4</td><td>20</td>
    </tr><tr>
        <td>9</td><td>1</td><td>3</td><td>3</td>
    </tr><tr>
        <td>10</td><td>3</td><td>2</td><td>6</td>
    </tr><tr>
        <td colspan="3">Sum:</td><td>208</td>
    </tr>
</table>
<p>Denne summen deler man på 11, og får da en "rest" på 10 (11x18=198, 208-198=10).  Dette trekker vi fra 11, og får da 1 (11-10=1).</p>
<p>Andre kontrollsiffer skal være 1, og det stemmer i vårt tilfelle.</p>

<h2>Eksempel med KID og Mod10</h2>

<p>Man starter med utgangspunktet, som kan være et tall med hvilket som helst lengde, innenfor rimelighetens grenser...
    og tallrekken er annerledes: 1 og 2 om hverandre, og man starter med 2 bakfra. Dersom multiplikasjonen
    gir et resultat som er større enn eller lik 10, så trekkes ifra 9.</p>
<p>Eksempel: KID er 3000924872.  De første 9 (i dette tilfellet) sifferne, som danner utgangspunktet for å beregne kontrollsifferet,
er 300092487.  Nedenfor vises regnestykket:</p>
<table class="validering">
    <tr>
        <th>Siffer nr.</th><th>Siffer</th><th>Multiplikator</th><th>Multiplum</th><th>Multiplum justert</th>
    </tr><tr>
        <td>1</td><td>3</td><td>2</td><td>6</td><td>6</td>
    </tr><tr>
        <td>2</td><td>0</td><td>1</td><td>0</td><td>0</td>
    </tr><tr>
        <td>3</td><td>0</td><td>2</td><td>0</td><td>0</td>
    </tr><tr>
        <td>4</td><td>0</td><td>1</td><td>0</td><td>0</td>
    </tr><tr>
        <td>5</td><td>9</td><td>2</td><td>18</td><td>9 (18-9)</td>
    </tr><tr>
        <td>6</td><td>2</td><td>1</td><td>2</td><td>2</td>
    </tr><tr>
        <td>7</td><td>4</td><td>2</td><td>8</td><td>8</td>
    </tr><tr>
        <td>8</td><td>8</td><td>1</td><td>8</td><td>8</td>
    </tr><tr>
        <td>9</td><td>7</td><td>2</td><td>14</td><td>5 (14-9)</td>
    </tr><tr>
        <td colspan="4">Sum:</td><td>38</td>
    </tr>
</table>
<p>Denne summen (38) deler man på 10, og får da en "rest" på 8.  Dette trekker vi fra 10, og får da 2.</p>
<p>Kontrollsifferet skal være 2, og det stemmer i vårt tilfelle.</p>

<p>Copyright &copy; Alf Kåre Lefdal.</p>

</div><!-- main-->

<div id="sidebar">

</div><!-- sidebar-->

<div id="footer">
    <p id="urldisplay">Adresse til denne siden: <strong>https://www.lefdal.cc/div/moduluskontroll.php</strong></p>
</div>
</body>
</html>
