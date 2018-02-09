function loadData(url, value) {
    new Ajax.Request(url, {
        method: 'post',
        parameters: {
            select_value: value
        },
        onSuccess: function (transport) {
            var response = transport.responseText.evalJSON() || {};
            resetBannerText();
            mappingData(response);
            resetEditor(response);
        }
    });
}
function mappingData(response) {
    var responses = response.evalJSON();
    $('name').value = responses.name ? responses.name : '';
    $('js_text').value = responses.js_text ? responses.js_text : '';
    $('css_text').value = responses.css_text ? responses.css_text : '';
    $('prefix').value = responses.prefix ? responses.prefix : '';
    $('suffix').value = responses.suffix ? responses.suffix : '';
    $('html_text').value = responses.html_text ? responses.html_text : '';


}
function resetBannerText() {
    for (index in editorQueue) {
        $(index).value = '';
        $(index).up('td').down('.CodeMirror').remove();
    }
    editorQueue = {};
    cntQueue = 0;
    $$('.banner-text').each(function (el) {
        el.up('tr').remove();
        skyAdvSlider.bannerCount--;
    });
    $$('.remove-banner-text').each(function (el) {
        el.up('tr').remove();
    })

}

function resetEditor(response) {
    var response = response.evalJSON();
    var banner = response.banner_html;
    var prefix = $('prefix');
    var suffix = $('suffix');
    var htmlText = $('html_text');
    var parsed = JSON.parse(banner);
    addEditor(prefix);
    addEditor(suffix);
    addEditor(htmlText);
    for (var x in parsed) {
        skyAdvSlider.addMoreBannerText(true);
        var bannerText = $("banner_html_" + x);
        bannerText.innerHTML = parsed[x];
        addEditor(bannerText);
    }
}