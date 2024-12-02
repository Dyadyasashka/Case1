$(function() {
    var meterName = getCookie('meter_name');

    $('.meter-link').on('click', function(e) {
        e.preventDefault();

        var meterNameAttribute = $(this).data('meter-name');
        setCookie('meter_name', meterNameAttribute);
        window.location.href = $(this).attr('href');
    });

    function setCookie(name, value) {
        document.cookie = name + '=' + value + '; path=/';
    }

    function getCookie(name) {
        var nameEQ = name + '=';
        var cookies = document.cookie.split(';');
        for (var i = 0; i < cookies.length; i++) {
            var cookie = cookies[i];
            while (cookie.charAt(0) === ' ') {
                cookie = cookie.substring(1, cookie.length);
            }
            if (cookie.indexOf(nameEQ) === 0) {
                return cookie.substring(nameEQ.length, cookie.length);
            }
        }
        return null;
    }
});
