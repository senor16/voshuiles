let previous = document.querySelectorAll(".previous");
let next = document.querySelectorAll(".next");
let docs = document.querySelectorAll(".rows");
let scrollDuration = 600;

for (let i = 0; i < previous.length; i++) {
    previous[i].onclick = function (event) {
        let scollAmount = 0;
        var slidetimer = setInterval(function () {
            docs[i].scrollLeft -= 10;
            scollAmount += 10;
            if (scollAmount >= 300) {
                window.clearInterval(slidetimer);
            }
        }, 15);
    }



}

for (let i = 0; i < next.length; i++) {
    next[i].onclick = function (event) {
        let scollAmount = 0;
        var slidetimer = setInterval(function () {
            docs[i].scrollLeft += 10;
            scollAmount += 10;
            if (scollAmount >= 300) {
                window.clearInterval(slidetimer);
            }
        }, 15);
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
