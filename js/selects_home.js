document.addEventListener("DOMContentLoaded", function () {
    const customSelects = document.querySelectorAll(".custom-select");

    // Fonction pour mettre a jour les selects
    function updateSelectedClass() {
        // Retire la class .selected les li
        document.querySelectorAll(".select-dropdown li").forEach((li) => {
            li.classList.remove("selected");
        });

        // Ajoute la class .selected sur le li parent du radio checked
        document.querySelectorAll('.select-dropdown input[type="radio"]:checked').forEach((checkedRadio) => {
                checkedRadio.closest("li").classList.add("selected");
            });
    }

    // Ecoute un changement dans les selects
    document.querySelectorAll('.select-dropdown input[type="radio"]').forEach((radio) => {
            radio.addEventListener("change", updateSelectedClass);
        });

    // Initialisation de la fonction
    updateSelectedClass();

    customSelects.forEach((customSelect) => {
        const selectBtn = customSelect.querySelector(".select-button");
        const selectedValue = customSelect.querySelector(".selected-value");
        const optionsList = customSelect.querySelectorAll(".select-dropdown li");

        // Ecoute le clic sur le .select-button
        selectBtn.addEventListener("click", () => {
            // Change la class .active
            customSelect.classList.toggle("active");
            // Change les attributs aria
            selectBtn.setAttribute(
                "aria-expanded",
                selectBtn.getAttribute("aria-expanded") === "true" ? "false" : "true"
            );
        });

        // Change le label du bouton au clic
        optionsList.forEach((option) => {
            function handler(e) {
                if (e.type === "click") {
                    selectedValue.textContent = option.querySelector("label").textContent;
                    customSelect.classList.remove("active");
                }
            }
            option.addEventListener("click", handler);
        });

        // Referme le menu déroulant au clic en dehors du menu déroulant
        document.addEventListener("click", (e) => {
            customSelects.forEach((cs) => {
                const isClickInsideCustomSelect = cs.contains(e.target);
                if (!isClickInsideCustomSelect) {
                    cs.classList.remove("active");
                }
            });
        });
    });
})