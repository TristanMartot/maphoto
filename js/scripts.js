document.addEventListener("DOMContentLoaded", function () {
    const container = document.querySelector(".container");
    const modale = document.querySelector(".modale");

    document.addEventListener("click", (event) => {
        // Vérifie si le clic est en dehors de la modale
        if (modale && !modale.contains(event.target) && container && container.contains(event.target)) {
            container.classList.add("bye");
            setTimeout(() => {
                container.classList.remove("open");
                modale.classList.remove("open_modale");
                container.classList.remove("bye");
            }, 300);
        }
    });

    const button = document.querySelector(".contact a");
    if (button) {
        button.addEventListener("click", (e) => {
            e.preventDefault();
            if (container && modale) {
                container.classList.add("open");
                modale.classList.add("open_modale");
            }
        });
    }

    const contact = document.getElementById("open");
    if (contact) {
        contact.addEventListener("click", (e) => {
            e.preventDefault();
            if (container && modale) {
                container.classList.add("open");
                modale.classList.add("open_modale");
            }
        });
    }

    jQuery(document).ready(function ($) {
        // Récupérer le texte de l'élément span une fois que le DOM est prêt
        let val = document.getElementById("reference")?.textContent;
        console.log(val);
        // Assigner la valeur récupérée au champ input
        if (val) {
            document.querySelector('#ref').value = val;
        }
    });

    (function ($) {
        $(document).ready(function () {
            const ajaxurl = $('.js-load-photo').data('ajaxurl');
            const nonce = $('.js-load-photo').data('nonce');
            const postsPerPage = parseInt($('.js-load-photo').data('post-on-page'), 10);
            let currentPhoto = $('#photos-container .photo-container').length;
            let newNumber = 8

            if (postsPerPage < currentPhoto) {
                postsPerPage = currentPhoto
            }

            function loadInitialPhotos() {
                const data = {
                    action: 'capitaine_load_initial_photos',
                    nonce: nonce,
                    post: newNumber,
                };

                fetchPhotos(data);
            }

            function loadSortedPhotos() {
                const dateOrder = getSelectedRadioValue('date-order');
                const category = getSelectedRadioValue('category');
                const format = getSelectedRadioValue('format');

                const data = {
                    action: 'capitaine_load_sorted_photos',
                    nonce: nonce,
                    post: newNumber,
                    date_order: dateOrder,
                    category: category,
                    format: format,
                };

                fetchPhotos(data);
            }

            function loadMorePhotos() {
                const currentOffset = $('#photos-container .photo-container').length;
                const dateOrder = getSelectedRadioValue('date-order');
                const category = getSelectedRadioValue('category');
                const format = getSelectedRadioValue('format');
                newNumber += 8

                const data = {
                    action: 'capitaine_load_more_photos',
                    nonce: nonce,
                    post: newNumber,
                    offset: currentOffset,
                    date_order: dateOrder,
                    category: category,
                    format: format,
                };

                fetchPhotos(data, true); // Pass true to append new photos
            }

            function fetchPhotos(data, append = false) {
                fetch(ajaxurl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: new URLSearchParams(data),
                })
                    .then(response => response.json())
                    .then(body => {
                        if (!body.success) {
                            alert(body.data);
                            return;
                        }
                        if (append) {
                            $('#photos-container').append(body.data);
                        } else {
                            $('#photos-container').html(body.data);
                        }
                    })
                    .catch(error => {
                        console.error('Fetch Error:', error);
                    });
            }

            function getSelectedRadioValue(name) {
                const radio = $(`input[name="${name}"]:checked`);
                return radio.length ? radio.val() : '';
            }

            loadInitialPhotos();

            $('input[name="date-order"], input[name="category"], input[name="format"]').on('change', function () {
                loadSortedPhotos();
            });

            $('.js-load-photo').click(function (e) {
                e.preventDefault();
                loadMorePhotos();
            });
        });
    })(jQuery);

});

document.addEventListener("DOMContentLoaded", function () {
    const customSelects = document.querySelectorAll(".custom-select");

    // Function to update the selected class
    function updateSelectedClass() {
        // Remove the .selected-value class from all <li> elements
        document.querySelectorAll('.select-dropdown li').forEach(function (li) {
            li.classList.remove('selected');
        });

        // Add the .selected-value class to the parent <li> of the checked radio button
        document.querySelectorAll('.select-dropdown input[type="radio"]:checked').forEach(function (checkedRadio) {
            checkedRadio.closest('li').classList.add('selected');
        });
    }

    // Add change event listeners to all radio buttons
    document.querySelectorAll('.select-dropdown input[type="radio"]').forEach(function (radio) {
        radio.addEventListener('change', updateSelectedClass);
    });

    // Update the selected class on page load
    updateSelectedClass();



    customSelects.forEach((customSelect) => {
        const selectBtn = customSelect.querySelector(".select-button");
        const selectedValue = customSelect.querySelector(".selected-value");
        const optionsList = customSelect.querySelectorAll(".select-dropdown li");

        // add click event to select button
        selectBtn.addEventListener("click", () => {
            // add/remove active class on the container element
            customSelect.classList.toggle("active");
            // update the aria-expanded attribute based on the current state
            selectBtn.setAttribute(
                "aria-expanded",
                selectBtn.getAttribute("aria-expanded") === "true" ? "false" : "true"
            );
        });

        optionsList.forEach((option) => {
            function handler(e) {
                // Click Events
                if (e.type === "click" && e.clientX !== 0 && e.clientY !== 0) {
                    selectedValue.textContent = option.querySelector("label").textContent;
                    customSelect.classList.remove("active");
                }
            }
            option.addEventListener("click", handler);
        });

        // Ajout d'un écouteur d'événement au document pour gérer les clics en dehors du menu déroulant
        document.addEventListener('click', (e) => {
            customSelects.forEach(cs => {
                const isClickInsideCustomSelect = cs.contains(e.target);
                if (!isClickInsideCustomSelect) {
                    cs.classList.remove('active');
                }
            });
        })
    });
});