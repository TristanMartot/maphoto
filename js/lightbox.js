class Lightbox {
    constructor(url, ref, category) {
        this.url = url;
        this.element = this.buildDOM();
        document.body.appendChild(this.element);
        this.loadImage(url, ref, category);
        this.addKeyboardSupport();
        this.addTouchSupport();
    }

    // Création du DOM de la lightbox
    buildDOM() {
        const dom = document.createElement('div');
        dom.classList.add('lightbox');
        dom.innerHTML = `<button class="lightbox__close"></button>
                         <div class="lightbox_nav">
                         <div class="button_prev"><button class="lightbox__prev"></button></div>
                         <div class="lightbox__container">
                            <div class="lightbox__img"></div>
                            <div class="lightbox_info">
                                <div class="lightbox_ref"></div>
                                <div class="lightbox_cat"></div>
                            </div>
                         </div>
                         <div class="button_next"><button class="lightbox__next"></button></div>`;
        
        dom.querySelector('.lightbox__close').addEventListener('click', closeLightbox);
        dom.querySelector('.lightbox__next').addEventListener('click', nextImage);
        dom.querySelector('.lightbox__prev').addEventListener('click', prevImage);
        
        return dom;
    }

    // Création des informations pour la première image de la lightbox
    loadImage(url, ref, category) {
        const imageContainer = this.element.querySelector('.lightbox__img');
        const imageRef = this.element.querySelector('.lightbox_ref');
        const imageCategory = this.element.querySelector('.lightbox_cat');
        imageContainer.innerHTML = '<div class="loader"></div>'; 
        imageRef.innerHTML = ''; 
        imageCategory.innerHTML = ''; 
    
        const image = new Image();
        image.onload = () => {
            imageContainer.innerHTML = ''; 
            imageRef.innerHTML = ref;
            imageCategory.innerHTML = category;
            imageContainer.appendChild(image); // Ajoute la nouvelle image à la lightbox
        };
        image.src = url;
    }

    // Gestion de la lightbox au clavier
    addKeyboardSupport() {
        this.keydownHandler = (event) => {
            if (event.key === 'Escape') {
                closeLightbox();
            } else if (event.key === 'ArrowRight') {
                nextImage(event);
            } else if (event.key === 'ArrowLeft') {
                prevImage(event);
            }
        };
        document.addEventListener('keydown', this.keydownHandler);
    }

    // Gestion de la lightbox sur les écrans tactiles
    addTouchSupport() {
        let startX = 0;
        let startY = 0;

        this.touchStartHandler = (event) => {
            startX = event.touches[0].clientX;
            startY = event.touches[0].clientY;
        };

        this.touchMoveHandler = (event) => {
            if (!startX || !startY) {
                return;
            }

            let endX = event.touches[0].clientX;
            let endY = event.touches[0].clientY;

            let diffX = startX - endX;
            let diffY = startY - endY;

            if (Math.abs(diffX) > Math.abs(diffY)) {
                // swipe left or right
                if (diffX > 0) {
                    // swipe left
                    nextImage(event);
                } else {
                    // swipe right
                    prevImage(event);
                }
            }

            startX = 0;
            startY = 0;
        };

        this.element.addEventListener('touchstart', this.touchStartHandler);
        this.element.addEventListener('touchmove', this.touchMoveHandler);
    }

    removeEventListeners() {
        document.removeEventListener('keydown', this.keydownHandler);
        this.element.removeEventListener('touchstart', this.touchStartHandler);
        this.element.removeEventListener('touchmove', this.touchMoveHandler);
    }

    destroy() {
        this.removeEventListeners();
        this.element.remove();
    }
}

// Fonction pour fermer la lightbox
function closeLightbox() {
    const lightbox = document.querySelector('.lightbox');
    if (lightbox) {
        lightbox.LightboxInstance.destroy(); // Supprime complètement la lightbox du DOM
    }
}

// Fonction pour charger l'image suivante dans la lightbox
function nextImage(e) {
    e.preventDefault();
    const lightbox = document.querySelector('.lightbox');
    const imageUrl = lightbox.querySelector('.lightbox__img img').src;

    let allImages = Array.from(document.querySelectorAll('a[href$=".jpg"], a[href$=".png"], a[href$=".jpeg"], a[href$=".webp"]'));
    let images = allImages.filter(function(elem, index, self) {
        // Utilisation de findIndex pour comparer les href
        return index === self.findIndex(o => o.href === elem.href);
    });
    let currentIndex = images.findIndex(link => link.href === imageUrl);
    
    if (currentIndex === -1) {
        console.error('Current image not found in the list.');
        return;
    }

    let nextIndex = (currentIndex + 1) % images.length;
    const nextLink = images[nextIndex];
    const refElement = nextLink.closest('.block_info').querySelector('.info_reference');
    const categoryElement = nextLink.closest('.block_info').querySelector('.info_category');
    
    const ref = refElement ? refElement.textContent.trim() : '';
    const category = categoryElement ? categoryElement.textContent.trim() : '';

    loadImage(nextLink.href, ref, category);
}

// Fonction pour charger l'image précédente dans la lightbox
function prevImage(e) {
    e.preventDefault();
    const lightbox = document.querySelector('.lightbox');
    const imageUrl = lightbox.querySelector('.lightbox__img img').src;

    let allImages = Array.from(document.querySelectorAll('a[href$=".jpg"], a[href$=".png"], a[href$=".jpeg"], a[href$=".webp"]'));
    let images = allImages.filter(function(elem, index, self) {
        // Utilisation de findIndex pour comparer les href
        return index === self.findIndex(o => o.href === elem.href);
    });
    let currentIndex = images.findIndex(link => link.href === imageUrl);

    if (currentIndex === -1) {
        console.error('Current image not found in the list.');
        return;
    }

    let prevIndex = (currentIndex - 1 + images.length) % images.length;
    const prevLink = images[prevIndex];
    const refElement = prevLink.closest('.block_info').querySelector('.info_reference');
    const categoryElement = prevLink.closest('.block_info').querySelector('.info_category');

    const ref = refElement ? refElement.textContent.trim() : '';
    const category = categoryElement ? categoryElement.textContent.trim() : '';

    loadImage(prevLink.href, ref, category);
}

// Fonction pour charger une nouvelle image dans la lightbox
function loadImage(url, ref, category) {
    const lightbox = document.querySelector('.lightbox');
    const imageContainer = lightbox.querySelector('.lightbox__img');
    const imageRef = lightbox.querySelector('.lightbox_ref');
    const imageCategory = lightbox.querySelector('.lightbox_cat');
    imageContainer.innerHTML = `<div class="loader"></div>`;
    imageRef.innerHTML = "";
    imageCategory.innerHTML = "";
    
    const image = new Image();
    image.onload = () => {
        imageContainer.innerHTML = '';
        imageContainer.appendChild(image);
        imageRef.textContent = ref;
        imageCategory.textContent = category;
    };
    image.src = url;
}

// Fonction pour ouvrir la lightbox au clic sur un lien d'image
function checkLinks() {
    document.querySelectorAll('a[href$=".jpg"], a[href$=".png"], a[href$=".jpeg"], a[href$=".webp"]').forEach(link => {
        link.addEventListener('click', (event) => {
            event.preventDefault();
            const lightbox = document.querySelector('.lightbox');
            const refElement = link.closest('.block_info').querySelector('.info_reference');
            const categoryElement = link.closest('.block_info').querySelector('.info_category');
            
            const ref = refElement ? refElement.textContent.trim() : '';
            const category = categoryElement ? categoryElement.textContent.trim() : '';
            
            if (!lightbox) {
                const lightboxInstance = new Lightbox(link.href, ref, category);
                lightboxInstance.element.LightboxInstance = lightboxInstance;
            } else {
                lightbox.LightboxInstance.destroy();
                const lightboxInstance = new Lightbox(link.href, ref, category);
                lightboxInstance.element.LightboxInstance = lightboxInstance;
            }
        });
    });
}

// Vérifie les liens existants lors du chargement initial
checkLinks();

// Observe les mutations pour détecter les nouveaux liens ajoutés dynamiquement
let observer = new MutationObserver((mutations) => {
    mutations.forEach((mutation) => {
        if (mutation.addedNodes && mutation.addedNodes.length > 0) {
            checkLinks();
        }
    });
});

// Configure l'observation pour surveiller les modifications du DOM
observer.observe(document.body, { subtree: true, childList: true });
