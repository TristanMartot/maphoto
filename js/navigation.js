const menuNavContainer = document.querySelector('.nav_mob_container')
const toggle = document.querySelector('.toggle')
const cross = document.querySelector('.cross')

toggle.addEventListener('click', (e) => {
    e.preventDefault();
    menuNavContainer.classList.remove('hidden');
    menuNavContainer.classList.add('visible');
})

cross.addEventListener('click', (e) => {
    e.preventDefault();
    menuNavContainer.classList.add('hidden');
    menuNavContainer.classList.remove('visible');
})