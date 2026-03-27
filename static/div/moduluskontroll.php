<!DOCTYPE html>
<html lang="no">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Moduluskontroll</title>
    <style>
        body { font-family: sans-serif; max-width: 800px; margin: 2rem auto; padding: 0 1rem; line-height: 1.6; }
        table { border-collapse: collapse; margin: 1rem 0; }
        th, td { border: 1px solid #ccc; padding: 0.4rem 0.8rem; text-align: left; }
        th { background: #f5f5f5; }
        input[type=text] { padding: 0.3rem; font-size: 1rem; width: 14rem; }
        input[type=submit] { padding: 0.3rem 0.8rem; font-size: 1rem; cursor: pointer; }
        em { color: #333; }
    </style>
</head>
<body>

<h1>Moduluskontroll</h1>
<p>Modulus-kontroll er verifisering og generering av kontrollsiffer på viktige nummer, som fx. fødselsnummer, kontonummer og KID. Kalles også CDV: Check Digit Verification.</p>

<h2>Modulus 11 (Mod11)</h2>
<p>Modulus 11 er i bruk i flere sammenhenger: Fødselsnummer, kontonummer, KID, m.fl. Mod11 kan gi kontrollsiffer 0-9, samt '-' i tilfelle kontrollsifferet beregnes til 10.</p>

<h3>Fødselsnummer</h3>
<p>Fødselsnummer består av seks siffer som representerer fødselsnummer, deretter tre siffer som er et løpenummer, og til slutt to kontrollsiffer. Første kontrollsiffer bruker Mod11-algoritmen med et helt spesielt sett med multiplikasjonsfaktorer, mens siste kontrollsiffer er helt standard Mod11. Dersom noen av kontrollsifferne beregnes til '-', så forkastes fødselsnummeret - det vil da ikke bli utstedt.</p>

<form action="javascript:sjekk();">
<p>Skriv inn fødselsnr: <input type="text" id="fnr" />
<input type="submit" value="Sjekk fødselsnr" /></p>
<p><em id="svar_fnr_sjekk">&nbsp;</em></p>
</form>
<p><em>Forbehold:</em> Det er kun kontrollsifferne (2 siste siffer) som sjekkes i forhold til resten av fødselsnummeret. Det foretas ingen sjekk av om datoen er en gyldig dato, eller om individnummeret (7.-9. siffer) er mulig for den angitte datoen.</p>
<p>Les mer om fødselsnummer på <a href="https://www.skatteetaten.no/person/folkeregister/fodsel-og-navnevalg/barn-fodt-i-norge/fodselsnummer/">Skatteetaten</a> sine sider.</p>

<h4>Generer kontrollsiffer til fødselsnummer</h4>
<form action="javascript:generer_kontrollsiffer();">
<p>Skriv inn 9 første siffer av fødselsnr: <input type="text" id="fnr9" />
<input type="submit" value="Finn kontrollsiffer" /></p>
<p><em id="svar_fullt_fnr">&nbsp;</em></p>
</form>

<h3>Kontonummer</h3>
<p>Kontonummer bruker helt standard Mod11, i tillegg er det krav om de fire første sifferne representerer riktig bank og at kontonummeret er på 11 tegn. Dersom kontrollsifferet blir '-', så forkastes kontonummeret og brukes ikke.</p>
<form action="javascript:sjekk_konto();">
<p>Skriv inn kontonr: <input type="text" id="konto" />
<input type="submit" value="Sjekk kontonr" /></p>
<p><em id="svar_sjekk_konto">&nbsp;</em></p>
</form>
<p><em>Forbehold:</em> Det er kun kontrollsifferet (siste siffer) som sjekkes i forhold til resten av kontonummeret. Det foretas ingen sjekk av om bankregisternummeret (4 første siffer) er gyldig. I tillegg til sjekk av kontrollsiffer, så verifiseres det at kontonummeret er 11 tegn langt.</p>

<h3>Sjekk av Orgnr, KID, ISBN, strekkoder etc. (MOD11)</h3>
<form action="javascript:sjekk_mod11();">
<p>Skriv inn nummeret: <input type="text" id="kid" />
<input type="submit" value="Sjekk kontrollsiffer" /></p>
<p><em id="svar_sjekk_mod11">&nbsp;</em></p>
</form>

<h3>Beregning av kontrollsiffer - MOD11</h3>
<form action="javascript:mod11_lag_kontrollsiffer();">
<p>Skriv inn grunnlagstallet: <input type="text" id="grunnlagstall" />
<input type="submit" value="Lag kontrollsiffer" /></p>
<p><em id="svar_mod11_kontrollsiffer">&nbsp;</em></p>
</form>

<h2>Modulus10 (Mod10)</h2>
<p>Modulus10 kalles Luhn's algoritme, og er en annen algoritme enn Modulus11, og brukes fx. til validering av KID-nr på bankgiroer. Les mer på <a href="https://no.wikipedia.org/wiki/MOD10">Wikipedia</a>. Jeg har laget <a href="https://gist.github.com/aklefdal/1367a06bba1728399f232e3e7340ff9d">VBA</a>-kode for dette, og den er implementert i et <a href="https://www.dropbox.com/s/83xiakj850esdgh/MOD10.xlsm?dl=0">Excel</a>-dokument også.</p>

<h3>Sjekk av KID etc. (MOD10)</h3>
<form action="javascript:mod10_sjekk_kontrollsiffer();">
<p>Skriv inn KID (eller annet tall som skal valideres): <input type="text" id="kid2" />
<input type="submit" value="Sjekk kontrollsiffer" /></p>
<p><em id="svar_sjekk_mod10">&nbsp;</em></p>
</form>

<h3>Beregning av kontrollsiffer - MOD10</h3>
<form action="javascript:mod10_lag_kontrollsiffer();">
<p>Skriv inn grunnlagstallet: <input type="text" id="kid_mod10" />
<input type="submit" value="Lag kontrollsiffer" /></p>
<p><em id="svar_mod10_kontrollsiffer">&nbsp;</em></p>
</form>

<h2>Eksempel med fødselsnummer</h2>
<p>I eksemplet her bruker jeg som et eksempel fødselsnummeret 26059765131.</p>

<h3>Beregning av 1. kontrollsiffer</h3>
<p>Man tar utgangspunkt i de 9 første sifferne (her 260597651). Først multipliserer man siffer for siffer med følgende tallrekke: 3, 7, 6, 1, 8, 9, 4, 5 og 2. Deretter summerer man resultatene. Så finner første kontrollsiffer ved å trekke "resten" man får når man deler dette på 11 (herav navnet modulus11-kontroll), og trekker denne "resten" fra 11. Hvis kontrollsifferet blir 11, så settes det til 0, og hvis det blir 10, så er det ikke gyldig (da må det genereres et nytt individnummer).</p>
<p>Eksempel: Fødselsnummeret er 26059765131. De første 9 sifferne er 260597651. Nedenfor vises regnestykket:</p>
<table>
    <tr><th>Siffer nr.</th><th>Siffer</th><th>Multiplikator</th><th>Multiplum</th></tr>
    <tr><td>1</td><td>2</td><td>3</td><td>6</td></tr>
    <tr><td>2</td><td>6</td><td>7</td><td>42</td></tr>
    <tr><td>3</td><td>0</td><td>6</td><td>0</td></tr>
    <tr><td>4</td><td>5</td><td>1</td><td>5</td></tr>
    <tr><td>5</td><td>9</td><td>8</td><td>72</td></tr>
    <tr><td>6</td><td>7</td><td>9</td><td>63</td></tr>
    <tr><td>7</td><td>6</td><td>4</td><td>24</td></tr>
    <tr><td>8</td><td>5</td><td>5</td><td>25</td></tr>
    <tr><td>9</td><td>1</td><td>2</td><td>2</td></tr>
    <tr><td colspan="3">Sum:</td><td>239</td></tr>
</table>
<p>Denne summen deler man på 11, og får da en "rest" på 8 (11×21=231, 239-231=8). Dette trekker vi fra 11, og får da 3 (11-8=3).</p>
<p>Første kontrollsiffer skal være 3, og det stemmer i vårt tilfelle.</p>

<h3>Beregning av 2. kontrollsiffer</h3>
<p>Framgangsmåten er tilsvarende som for 1. kontrollsiffer, men man tar utgangspunkt i de 10 første sifferne (her 2605976513), og tallrekken er annerledes: 5, 4, 3, 2, 7, 6, 5, 4, 3 og 2.</p>
<table>
    <tr><th>Siffer nr.</th><th>Siffer</th><th>Multiplikator</th><th>Multiplum</th></tr>
    <tr><td>1</td><td>2</td><td>5</td><td>10</td></tr>
    <tr><td>2</td><td>6</td><td>4</td><td>24</td></tr>
    <tr><td>3</td><td>0</td><td>3</td><td>0</td></tr>
    <tr><td>4</td><td>5</td><td>2</td><td>10</td></tr>
    <tr><td>5</td><td>9</td><td>7</td><td>63</td></tr>
    <tr><td>6</td><td>7</td><td>6</td><td>42</td></tr>
    <tr><td>7</td><td>6</td><td>5</td><td>30</td></tr>
    <tr><td>8</td><td>5</td><td>4</td><td>20</td></tr>
    <tr><td>9</td><td>1</td><td>3</td><td>3</td></tr>
    <tr><td>10</td><td>3</td><td>2</td><td>6</td></tr>
    <tr><td colspan="3">Sum:</td><td>208</td></tr>
</table>
<p>Denne summen deler man på 11, og får da en "rest" på 10 (11×18=198, 208-198=10). Dette trekker vi fra 11, og får da 1 (11-10=1).</p>
<p>Andre kontrollsiffer skal være 1, og det stemmer i vårt tilfelle.</p>

<h2>Eksempel med KID og Mod10</h2>
<p>Man starter med utgangspunktet, som kan være et tall med hvilket som helst lengde, og tallrekken er 1 og 2 om hverandre, og man starter med 2 bakfra. Dersom multiplikasjonen gir et resultat som er større enn eller lik 10, så trekkes ifra 9.</p>
<table>
    <tr><th>Siffer nr.</th><th>Siffer</th><th>Multiplikator</th><th>Multiplum</th><th>Multiplum justert</th></tr>
    <tr><td>1</td><td>3</td><td>2</td><td>6</td><td>6</td></tr>
    <tr><td>2</td><td>0</td><td>1</td><td>0</td><td>0</td></tr>
    <tr><td>3</td><td>0</td><td>2</td><td>0</td><td>0</td></tr>
    <tr><td>4</td><td>0</td><td>1</td><td>0</td><td>0</td></tr>
    <tr><td>5</td><td>9</td><td>2</td><td>18</td><td>9 (18-9)</td></tr>
    <tr><td>6</td><td>2</td><td>1</td><td>2</td><td>2</td></tr>
    <tr><td>7</td><td>4</td><td>2</td><td>8</td><td>8</td></tr>
    <tr><td>8</td><td>8</td><td>1</td><td>8</td><td>8</td></tr>
    <tr><td>9</td><td>7</td><td>2</td><td>14</td><td>5 (14-9)</td></tr>
    <tr><td colspan="4">Sum:</td><td>38</td></tr>
</table>
<p>Denne summen (38) deler man på 10, og får da en "rest" på 8. Dette trekker vi fra 10, og får da 2.</p>
<p>Kontrollsifferet skal være 2, og det stemmer i vårt tilfelle.</p>

<p><small>Copyright &copy; Alf Kåre Lefdal.</small></p>

<script>
var FNR_NUMBER_LENGTH = 11;
var ACCOUNT_NUMBER_LENGTH = 11;
var mod11Array10 = [3, 7, 6, 1, 8, 9, 4, 5, 2];
var mod11Array11 = [5, 4, 3, 2, 7, 6, 5, 4, 3, 2];

function fnrMod11(v) {
    var c = getCheckDigit(v.substring(0, v.length - 1));
    return parseInt(v.substring(v.length - 1)) == c;
}
function getCheckDigit(s) {
    var a = s.length == 9 ? mod11Array10 : mod11Array11;
    var sum = 0;
    for (var i = 0; i < a.length; i++) sum += parseInt(s[i]) * a[i];
    var c = 11 - (sum % 11);
    return c == 11 ? 0 : c;
}
function getKontrollsifferMod11(n) {
    var w = [2,3,4,5,6,7], sum = 0;
    var r = n.toString().split('').reverse().join('');
    for (var i = 0; i < r.length; i++) sum += parseInt(r[i]) * w[i % 6];
    var rem = 11 - (sum % 11);
    if (rem === 11) return 0;
    if (rem === 10) return '-';
    return rem;
}
function checkMod11(v) {
    var c = getKontrollsifferMod11(v.substring(0, v.length - 1));
    return v.substring(v.length - 1) == (c + '');
}
function validateFnr(fnr) {
    if (fnr.length != FNR_NUMBER_LENGTH) return false;
    if (!fnrMod11(fnr.substring(0, FNR_NUMBER_LENGTH - 1))) return false;
    return fnrMod11(fnr);
}
function validateAccount(a) {
    return a.length == ACCOUNT_NUMBER_LENGTH && checkMod11(a);
}
function sjekk() {
    var fnr = document.getElementById("fnr").value;
    document.getElementById("svar_fnr_sjekk").innerHTML = fnr + (validateFnr(fnr) ? " er et godkjent fødselsnummer" : " er IKKE et godkjent fødselsnummer");
}
function sjekk_konto() {
    var k = document.getElementById("konto").value;
    document.getElementById("svar_sjekk_konto").innerHTML = k + (validateAccount(k) ? " er et gyldig kontonr" : " er IKKE et gyldig kontonr");
}
function sjekk_mod11() {
    var n = document.getElementById("kid").value;
    document.getElementById("svar_sjekk_mod11").innerHTML = n + (checkMod11(n) ? " er gyldig (MOD11)" : " er IKKE gyldig (MOD11)");
}
function mod11_lag_kontrollsiffer() {
    var g = document.getElementById("grunnlagstall").value;
    document.getElementById("svar_mod11_kontrollsiffer").innerHTML = "Med kontrollsiffer: " + g + getKontrollsifferMod11(g);
}
function generer_kontrollsiffer() {
    var f = document.getElementById("fnr9").value;
    if (f.length != FNR_NUMBER_LENGTH - 2) { document.getElementById("svar_fullt_fnr").innerHTML = "Må være 9 siffer"; return; }
    var c1 = getCheckDigit(f) + '';
    if (isNaN(c1) || c1 == '10') { document.getElementById("svar_fullt_fnr").innerHTML = "Vil aldri bli tildelt som fødselsnummer"; return; }
    var f10 = f + c1;
    var c2 = getCheckDigit(f10) + '';
    if (isNaN(c2) || c2 == '10') { document.getElementById("svar_fullt_fnr").innerHTML = "Vil aldri bli tildelt som fødselsnummer"; return; }
    document.getElementById("svar_fullt_fnr").innerHTML = "Fullt fødselsnummer: " + f10 + c2;
}
function Mod10(kid) {
    var isOne = false, ctrl = 0;
    for (var i = 0; i < kid.length; i++) {
        var idx = kid.length - i - 1;
        var n = parseInt(kid[idx]);
        var s = isOne ? n : 2 * n;
        if (s > 9) s = (s % 10) + 1;
        isOne = !isOne;
        ctrl += s;
    }
    return (10 - (ctrl % 10)) % 10 == 0 ? 0 : 10 - (ctrl % 10);
}
function mod10_lag_kontrollsiffer() {
    var t = document.getElementById("kid_mod10").value;
    document.getElementById("svar_mod10_kontrollsiffer").innerHTML = "Med kontrollsiffer: " + t + Mod10(t);
}
function mod10_sjekk_kontrollsiffer() {
    var n = document.getElementById("kid2").value;
    var c = Mod10(n.substring(0, n.length - 1));
    var ok = parseInt(n.substring(n.length - 1)) == c;
    document.getElementById("svar_sjekk_mod10").innerHTML = n + (ok ? " er gyldig (MOD10)" : " er IKKE gyldig (MOD10)");
}
</script>
</body>
</html>
