$(document).ready(function () {
    $('#form-check').submit(function (e) {
        $('.btn-check').css('display', 'none');
        $('.loading').css('display', 'block');
        $('#urlInput').prop('readonly', true);
        var url = $('#urlInput').val();
        if (url.substring(url.length - 1) !== '/') {
            url += '/';
        }

        // Make url has template: https://example.com/  OR http://example.com/
        if (url.includes('https://')) {
            let subUrl = url.substring(8);
            let positionLastSlashes = subUrl.indexOf('/');
            let compactUrl = subUrl.substring(0, positionLastSlashes + 1);
            url = "https://" + compactUrl;
        } else if (url.includes('http://')) {
            let subUrl = url.substring(7);
            let positionLastSlashes = subUrl.indexOf('/');
            let compactUrl = subUrl.substring(0, positionLastSlashes + 1);
            url = 'http://' + compactUrl;
        }

        $.ajax({
            url: 'analysis.php?url=' + url,
            type: 'get',
            dateType: 'text',
            data: {},
            success: function (result) {
                if (result === 'true') {
                    $('.loading').css('display', 'none');
                    $('.btn-check').css('display', 'block');
                    $('#urlInput').prop('readonly', false);
                    $('.website-true').html(url.substring(0, url.length - 1))
                    showTrueModal();
                } else {
                    $('.loading').css('display', 'none');
                    $('.btn-check').css('display', 'block');
                    $('#urlInput').prop('readonly', false);
                    $('.website-false').html(url.substring(0, url.length - 1))
                    showFalseModal()
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                // When AJAX call has failed
                console.log('AJAX call failed.');
                console.log(textStatus + ': ' + errorThrown);
            },
        });

        e.preventDefault();
    })

    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
})


function showTrueModal() {
    $("#trueModal").modal()
}

function showFalseModal() {
    $("#falseModal").modal()
}