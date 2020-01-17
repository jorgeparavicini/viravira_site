let burger = document.getElementById("hamburgerButton");
burger.addEventListener('click', function () {
    if (burger.classList.contains("open")) {
        burger.classList.remove("open");
    } else {
        burger.classList.add("open");
    }
});