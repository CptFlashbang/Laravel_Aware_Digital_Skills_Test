$(document).ready(function() {
    $('#fetchJokeButton').click(function(event) {
        event.preventDefault();
        var url = $(this).data('url');
        $.ajax({
            url: url,
            type: 'GET',
            success: function(response) {
                $('#message').val(response.joke);
            },
            error: function(xhr, status, error) {
                console.log('Error:', error);
            }
        });
    });
});