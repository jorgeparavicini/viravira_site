let burger = document.getElementById("hamburgerButton");
let menuNav = document.getElementById("menuNav");
let title = document.getElementById("headerTitle");
burger.addEventListener('click', function () {
    if (burger.classList.contains("open")) {
        burger.classList.remove("open");
        menuNav.classList.remove("openMenu");
        title.classList.remove("openTitle");
    } else {
        burger.classList.add("open");
        menuNav.classList.add("openMenu");
        title.classList.add("openTitle");
    }
});