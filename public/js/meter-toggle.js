$(document).ready(function() {
    $(".toggle-button").click(function() {
        var hiddenInfo = $(this).siblings(".hidden-info");
        hiddenInfo.toggle();
        if (hiddenInfo.is(":visible")) {
            $(this).text("Скрыть");
        } else {
            $(this).text("Подробнее");
        }
    });
});
