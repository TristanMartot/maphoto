document.addEventListener("DOMContentLoaded", function () {
    const container = document.querySelector(".container");
    const modale = document.querySelector(".modale");

    // Vérifie si le clic est en dehors de la modale
    document.addEventListener("click", (event) => {
        if (!modale.contains(event.target) && container.contains(event.target)) {
            container.classList.add("bye");
            setTimeout(() => {
                container.classList.remove("open");
                modale.classList.remove("open_modale");
                container.classList.remove("bye");
            }, 300);
        }
    });

    // Ouvre la modale
    const buttons = document.querySelectorAll(".contact a");
    buttons.forEach((button) => {
        button.addEventListener("click", (e) => {
            e.preventDefault();
            container.classList.add("open");
            modale.classList.add("open_modale");
        });
    });

    // Ouvre la modale
    const contact = document.getElementById("open");
    if (contact) {
        contact.addEventListener("click", (e) => {
            e.preventDefault();
            container.classList.add("open");
            modale.classList.add("open_modale");
        });
    }

    // Ajoute la référence dans l'input du formulaire de contact de la modale
    jQuery(document).ready(function ($) {
        // Récupére le texte de l'élément span une fois que le DOM est prêt
        let val = document.getElementById("reference")?.textContent;
        // Assigne la valeur récupérée au champ input
        if (val) {
            document.querySelector("#ref").value = val;
        }
    });
})