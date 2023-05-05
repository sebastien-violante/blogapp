$("img").on("error", function() {
    $(this).attr("src", "/_assets/pictures/default-image.png");
})