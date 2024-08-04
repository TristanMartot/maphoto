document.addEventListener("DOMContentLoaded", function () {
    (function ($) {
        $(document).ready(function () {
            const ajaxurl = $(".js-load-photo").data("ajaxurl");
            const nonce = $(".js-load-photo").data("nonce");
            const postsPerPage = parseInt(
                $(".js-load-photo").data("post-on-page"),
                10
            );
            let currentPhoto = $("#photos-container .photo-container").length;
            let newNumber = 8;

            if (postsPerPage < currentPhoto) {
                postsPerPage = currentPhoto;
            }

            // Ajout initial des photos
            function loadInitialPhotos() {
                const data = {
                    action: "mota_load_initial_photos",
                    nonce: nonce,
                    post: newNumber,
                };

                fetchPhotos(data);
            }

            // Tri par sorte de photos
            function loadSortedPhotos() {
                const dateOrder = getSelectedRadioValue("date-order");
                const category = getSelectedRadioValue("category");
                const format = getSelectedRadioValue("format");

                const data = {
                    action: "mota_load_sorted_photos",
                    nonce: nonce,
                    post: newNumber,
                    date_order: dateOrder,
                    category: category,
                    format: format,
                };

                fetchPhotos(data);
            }

            // Ajouter des photos avec le bouton "Charger plus"
            function loadMorePhotos() {
                const currentOffset = $("#photos-container .photo-container").length;
                const dateOrder = getSelectedRadioValue("date-order");
                const category = getSelectedRadioValue("category");
                const format = getSelectedRadioValue("format");
                newNumber += 8;

                const data = {
                    action: "mota_load_more_photos",
                    nonce: nonce,
                    post: newNumber,
                    offset: currentOffset,
                    date_order: dateOrder,
                    category: category,
                    format: format,
                };

                fetchPhotos(data, true); // Pass true to append new photos
            }

            // Fonction qui va chercher les informations
            function fetchPhotos(data, append = false) {
                fetch(ajaxurl, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                    },
                    body: new URLSearchParams(data),
                })
                    .then((response) => response.json())
                    .then((body) => {
                        if (!body.success) {
                            alert(body.data);
                            return;
                        }
                        if (append) {
                            $("#photos-container").append(body.data);
                        } else {
                            $("#photos-container").html(body.data);
                        }
                    })
                    .catch((error) => {
                        console.error("Fetch Error:", error);
                    });
            }

            // Récupère la valeur des selects
            function getSelectedRadioValue(name) {
                const radio = $(`input[name="${name}"]:checked`);
                return radio.length ? radio.val() : "";
            }

            // Initialise le bloc photo de la page
            loadInitialPhotos();

            // Change l'ordre des photos 
            $('input[name="date-order"], input[name="category"], input[name="format"]').on("change", function () {
                loadSortedPhotos();
            });

            // Ajoute des photos
            $(".js-load-photo").click(function (e) {
                e.preventDefault();
                loadMorePhotos();
            });
        });
    })(jQuery);
})