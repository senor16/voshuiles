let user = document.getElementsByClassName('user');
let menu = document.getElementsByClassName('drop-down');

for (let menuKey in menu) {
    menuKey.hidden = true;
}

for (let i=0; i< user.length; i++) {
    user[i].addEventListener('click', function (event) {
        //Prevent default action
        event.preventDefault();
        if (menu[i].hidden) {
            menu[i].hidden = false;
            menu[i].style = "visibility:visible";
        } else {
            menu[i].hidden = true;
            menu[i].style = "visibility:hidden";
        }
    })
}


