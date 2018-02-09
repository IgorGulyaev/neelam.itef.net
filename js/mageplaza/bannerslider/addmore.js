var SkyBannerSliderAdvanced = Class.create();
SkyBannerSliderAdvanced.prototype = {
    initialize: function (config) {
        this.bannerLable = config.bannerLable;
        this.removeLable = config.removeLable;
        this.errorMsg = config.errorMsg;
        this.bannerCount = config.bannerCount;
        this.addMoreEl = $(config.addMoreEl);
        this.removeEls = $$(config.removeClass);
        this.initEditor();
        this.initObservers();
    },
    initEditor: function () {
        for (var i = 1; i <= this.bannerCount; i++) {
            var bannerText = $("banner_html_" + i);
            addEditor(bannerText);
        }
    },
    initObservers: function () {
        if (this.addMoreEl) {
            this.addMoreEl.observe('click', function () {
                this.addMoreBannerText(false);
            }.bind(this));
        }
    },
    addMoreBannerText: function (ajax) {
        var target = this.addMoreEl;
        this.bannerCount++;
        var template = '<tr>' +
            '<td class="label"><label for="banner_html_' + this.bannerCount + '">' + this.bannerLable + ' ' + this.bannerCount + ' <span ></span></label></td>' +
            '<td class="value">' +
            '<textarea id="banner_html_' + this.bannerCount + '" name="banner_html[' + this.bannerCount + ']" title="Text" style="width:500px; height:100px;" class="banner-text required-entry textarea" rows="2" cols="15"></textarea>' +
            '</td></tr>' +
            '<tr>' +
            '<td class="label"><label for="banner_html_1">&nbsp;</label></td>' +
            '<td class="value"><button class="delete remove-banner-text" onclick="skyAdvSlider.removeBannerText(this)" id="remove_banner_text_' + this.bannerCount + '" type="button"><span>' + this.removeLable + '</span></button><br> <br> <hr> <br></td>' +
            '</tr>';
        target.up('tr').insert({'before': template});
        if (!ajax) {
            var bannerText = $("banner_html_" + this.bannerCount);
            this.addEditor(bannerText);
        }
    },
    addEditor: function (bannerText) {
        addEditor(bannerText);
    },
    removeBannerText: function (el) {
        if (this.bannerCount == 1) {
            alert(this.errorMsg);
            return;
        }
        var bannerId = el.id.replace('remove_banner_text_', 'banner_html_');
        $(bannerId).up('tr').remove();
        el.up('tr').remove();
        this.bannerCount--;
    }

}
