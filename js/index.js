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
            url: 'fetch.php?url=' + url,
            type: 'get',
            dateType: 'text',
            data: {},
            success: function (result) {
                // find all couple tag: <script></script> that include string "client"
                var myRegex = /<script+.+src="+.+\/client+.*><\/script>/gi;
                var match = result.match(myRegex);
                if (match && match.length) {
                    for (let i = 0; i < match.length; i++) {
                        // find the path has key: "client"
                        if (match[i].includes("client")) {
                            let mayBeUrl = match[i]
                            let secondRegex = /".*"/g;
                            let subMatch = mayBeUrl.match(secondRegex)
                            if (subMatch && subMatch.length) {
                                for (let j = 0; j < subMatch.length; j++) {
                                    let itemUrl = subMatch[j].replace(/"/gi, "")
                                    if (itemUrl.indexOf('/') === 0) {
                                        itemUrl = itemUrl.substring(1)
                                    }
                                    if (itemUrl.includes('script')) {
                                        // a number of adjacent script tags
                                        continueAnalysis(match, url);
                                    } else {
                                        $.ajax({
                                            url: 'fetch.php?url=' + url + itemUrl,
                                            type: 'get',
                                            dateType: 'text',
                                            data: {},
                                            success: function (result) {
                                                if (result.includes('browserpersistence') || result.includes('M2_VENIA_BROWSER_PERSISTENCE') || result.includes('venia')) {
                                                    $('.loading').css('display', 'none');
                                                    $('.btn-check').css('display', 'block');
                                                    $('#urlInput').prop('readonly', false);
                                                    $('.website-true').html(url.substring(0, url.length - 1))
                                                    showTrueModal();
                                                }
                                            },
                                            error: function (jqXHR, textStatus, errorThrown) {
                                                // When AJAX call has failed
                                                console.log('AJAX call failed.');
                                                console.log(textStatus + ': ' + errorThrown);
                                            },
                                        });
                                    }
                                }
                            }
                        }
                    }
                } else {
                    $('.loading').css('display', 'none');
                    $('.btn-check').css('display', 'block');
                    $('#urlInput').prop('readonly', false);
                    $('.website-false').html(url.substring(0, url.length - 1))
                    showFalseModal()
                }
            }
        });
        e.preventDefault();
    })

    // case: a number of adjacent script tags -> continue filter
    function continueAnalysis(match, url) {
        if (match && match.length) {
            for (let i = 0; i < match.length; i++) {
                let subRegex = /src="+\/client+.+js">/gi;
                let match2 = match[i].match(subRegex)
                if (match2 && match2.length) {
                    // only 1 file
                    for (let k = 0; k < match2.length; k++) {
                        let itemUrl = match2[k].replace(/src="/, "").replace(/">/, "")
                        if (itemUrl[0] === '/') {
                            itemUrl = itemUrl.substring(1);
                        }
                        $.ajax({
                            url: 'fetch.php?url=' + url + itemUrl,
                            type: 'get',
                            dateType: 'text',
                            data: {},
                            success: function (result) {
                                if (result.includes('browserpersistence') || result.includes('M2_VENIA_BROWSER_PERSISTENCE') || result.includes('venia')) {
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
                    }
                }
            }
        }
    }


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