let momo = document.getElementById("mm");
let om = document.getElementById("om");
let visa = document.getElementById("visa");

let div_om_momo = document.getElementById("div-mm-om");
let div_visa = document.getElementById("div-visa");

om.onclick = function (event){
    div_visa.style="display:none;";
    div_om_momo.style="display:initial;";

}

momo.onclick = function (event){
    div_visa.style="display:none;";
    div_om_momo.style="display:initial;";
}



visa.onclick = function (event){
    div_visa.style="display:initial;";
    div_om_momo.style="display:none;";
}


