const container = document.querySelector(".container");
const modale = document.querySelector(".modale");

document.addEventListener("click", (event) => {
    // Vérifie si le clic est en dehors de la modale
    if (!modale.contains(event.target) && container.contains(event.target)) {
        container.classList.add("bye")
        setTimeout(() => {
            container.classList.remove("open")
            modale.classList.remove("open_modale")      
            container.classList.remove("bye")
              }, 300)
    }
});

const button = document.querySelector(".contact a");

button.addEventListener("click", (e) => {
  e.preventDefault()
  container.classList.add("open")
  modale.classList.add("open_modale")
})

const contact = document.getElementById("open");

contact.addEventListener("click", (e) => {
  e.preventDefault()
  container.classList.add("open")
  modale.classList.add("open_modale")
})

jQuery(document).ready(function($) {
    // Récupérer le texte de l'élément span une fois que le DOM est prêt
    let val = document.getElementById("reference").textContent
    console.log(val)
    // Assigner la valeur récupérée au champ input
    $("#ref").val(val);
  });