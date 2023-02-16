const role = document.getElementById('registration_personne_role');
const livreur = document.getElementById('livreur');
role.addEventListener("change",()=>{
    console.log(livreur.value);
    if (role.value == "Livreur") {
        livreur.style.visibility = "visible"
    }else{
        livreur.style.visibility = "hidden"
    }
})