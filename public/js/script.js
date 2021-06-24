// alert('Welkom in je MVC');
const hidden_springsport = document.getElementById("hidden_springsport");
const radio_springsport_ja = document.getElementById("springsport_ja");
const radio_springsport_nee = document.getElementById("springsport_nee");
const totale_kosten = document.getElementById("totale_kosten");
const default_kosten = document.getElementById("default_kosten");
const max_schoofhoogte_pony = 147.5;
const kosten_uur = 55;

default_kosten.innerHTML = "De duur van een rit is altijd precies 60 minuten en kost €"+kosten_uur+",-";

function updateInput(value) {
    // Displaying the value
    console.log(value);
    if (value < max_schoofhoogte_pony) {
        radio_springsport_ja.checked = false;
        radio_springsport_nee.checked = true;

        radio_springsport_ja.disabled = true;
        radio_springsport_nee.disabled = true;
    } else {
        radio_springsport_ja.disabled = false;
        radio_springsport_nee.disabled = false;
    }
    if (radio_springsport_ja.checked) {
        hidden_springsport.value = radio_springsport_ja.value;
    } else if (radio_springsport_nee.checked) {
        hidden_springsport.value = radio_springsport_nee.value;
    }
}

function kost_berekening(aantal_uren) {
	aantal_uren = parseInt(aantal_uren);	
    var kosten = kosten_uur * aantal_uren;

    if (aantal_uren > 0 && aantal_uren === parseInt(aantal_uren)) {
        totale_kosten.innerHTML = "De totale kosten zijn nu: €"+kosten+",-";
    } else {
        totale_kosten.innerHTML = "De totale kosten zijn nu: €0,-";
    }
}
