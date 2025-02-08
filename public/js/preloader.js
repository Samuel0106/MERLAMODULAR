var loader = document.getElementById("preloader");

$(function () {
    $("form").submit(function () {
        loader.style.display = "block";
    });
});
