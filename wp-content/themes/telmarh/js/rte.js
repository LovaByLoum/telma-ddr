jQuery(function($) {
    $('img').each(function(){
        var _this = $(this);
        _this.parents('p').addClass('clearfix');
        if (_this.hasClass('alignleft')) {
            _this.parent('a').addClass('alignleft');
        }
        if (_this.hasClass('alignright')) {
            _this.parent('a').addClass('alignright');
            _this.parents('p').addClass('clearfix');
        }
    });
});