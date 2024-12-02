$(function() {
    $('.network-link').on('click', function(e) {
        e.preventDefault();

        var networkId = $(this).data('network-id');
        var networkName = $(this).data('network-name');

        document.cookie = 'network_id=' + networkId;
        document.cookie = 'network_name=' + networkName;

        window.location.href = $(this).attr('href');
    });
});
