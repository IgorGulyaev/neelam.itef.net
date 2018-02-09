document.observe("dom:loaded", function () {
    new BannerTraffic({
        bannerLinkId: '.mageplaza-banner-link'
    });
})
var BannerTraffic = Class.create();
BannerTraffic.prototype = {
    initialize: function (config) {
        this.bannerLinkId = config.bannerLinkId;
        this.processTraffic();
    },
    processTraffic: function () {
        var me = this;
        $$(this.bannerLinkId).each(function(element){
            element.observe('click', function(){
                var url = element.getAttribute('storeurl');
                me._ajaxProcess(url, 'click');

            });
        });
    },
    _ajaxProcess: function (url, type) {
        url += 'type/' + type;
        new Ajax.Request(url, {
            method: 'post',
            onComplete: function (transport) {
                var response = transport.responseText;
            }
        })
    }
}