let previous = document.querySelectorAll(".previous");
let next = document.querySelectorAll(".next");
let docs = document.querySelectorAll(".rows");
let scrollDuration = 600;

for (let i = 0; i < previous.length; i++) {
    previous[i].onclick = function (event) {
        let scollAmount = 0;
        var slidetimer = setInterval(function () {
            docs[i].scrollLeft -= 15;
            scollAmount += 15;
            if (scollAmount >= window.innerWidth) {
                window.clearInterval(slidetimer);
            }
        }, 5);
    }



}

for (let i = 0; i < next.length; i++) {
    next[i].onclick = function (event) {
        let scollAmount = 0;
        var slidetimer = setInterval(function () {
            docs[i].scrollLeft += 15;
            scollAmount += 15;
            if (scollAmount >= window.innerWidth) {
                window.clearInterval(slidetimer);
            }
        }, 5);
    }

}


/*


next.onclick = function (event){
    doc.scrollright+=20;
    alert(doc);

}

previous.onclick = function (event){
    doc.scrollright-=20;
    alert(doc);

    for (let docKey in doc) {
        alert(docKey);
    }
}

*/
