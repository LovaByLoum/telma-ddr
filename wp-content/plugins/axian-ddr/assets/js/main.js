jQuery(function() {
    $('.chosen-select').chosen();
    $(".datepicker" ).datepicker();
    $('.daterangepicker-input').daterangepicker({
        "showDropdowns": true,
        "autoUpdateInput": false,
        "locale": {
            "format": "DD/MM/YYYY",
            "separator": ":",
            "applyLabel": "Appliquer",
            "cancelLabel": "Réinitialiser",
            "fromLabel": "De",
            "toLabel": "A",
            "customRangeLabel": "Personnalisé",
            "weekLabel": "S",
            "daysOfWeek": [
                "Di",
                "Lu",
                "Ma",
                "Me",
                "Je",
                "Ve",
                "Sa"
            ],
            "monthNames": [
                "Jan",
                "Fév",
                "Mar",
                "Avr",
                "Mai",
                "Juin",
                "Juil",
                "Aou",
                "Sep",
                "Oct",
                "Nov",
                "Dec"
            ],
            "firstDay": 1
        }
    }).on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('DD/MM/YYYY') + ':' + picker.endDate.format('DD/MM/YYYY'));
    }).on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
    });

    $( ".ddr-autocompletion[data-source]").each(function(){
        var _this = $(this);
        var _source = _this.data('source');
        var _hidden = $(this).next();
        var _current_val = _hidden.val();
        _this.autocomplete({
            source: ddr_settings.autocompletion_url + '?source=' + _source,
            minLength: 2,
            select: function( event, ui ) {
                _hidden.val(ui.item.id);
                _this.val(ui.item.label);
            }
        }).blur(function(){
            if ( _this.val() == '' ){
                _hidden.val('');
            }
        });
        //preload current value
        if ( _current_val != '' ){
            $.ajax( {
                url: ddr_settings.autocompletion_url + '?source=' + _source + '&id=' + _current_val,
                success: function( value ) {
                    _this.val(value);
                }
            } );
        }
    })


});