$(document).ready(function () {
    $('#form-check').submit(function (e) {
        $('.btn-check').css('display', 'none');
        $('.loading').css('display', 'block');
        $('#urlInput').prop('readonly', true);
        var url = $('#urlInput').val();

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
                    $('.website-true').html(url)
                    showTrueModal();
                } else {
                    $('.loading').css('display', 'none');
                    $('.btn-check').css('display', 'block');
                    $('#urlInput').prop('readonly', false);
                    $('.website-false').html(url)
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
