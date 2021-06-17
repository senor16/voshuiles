window.onload = ()=>{
    //Handle delete links
    let links = document.querySelectorAll("[data-delete]");
    for(link of links){
        link.addEventListener('click', function (event){
            //Prevent default action
            event.preventDefault();

            //Get user confirmation before deleting
            if(confirm("Voulez-vous supprimer ce produit ?")){

                window.location.href=this.getAttribute('href');


            }
        })
    }

}