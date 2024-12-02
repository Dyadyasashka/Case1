$(function() {
    $('.object-link').on('click', function(e) {
        e.preventDefault();

        var objectName = $(this).data('object-name');
        document.cookie = 'object_name=' + objectName;

        window.location.href = $(this).attr('href');
    });
});
