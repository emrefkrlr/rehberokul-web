



$(function() {
    var availableTags = [] ;
    $.ajax({
        url: "ajax-request/get-landing.php",
        type: "POST",
        dataType: "json",
        async: false,
        data: {},
        success: function (result) {
            result.forEach(function(entry) {
                availableTags.push(entry);
            })
        }
    });


    var count = 0;

    if(count == 0) {
        $.ajax({
            url: "ajax-request/get-school-names.php",
            type: 'POST',
            dataType: 'json',
            async: false,
            data : {},
            success: function(result){
                result.forEach(function(entry) {
                    availableTags.push(entry);
                })
            }});

    }
    count = count + 1;

    var accentMap = {
        "İ": "I",
        "i": "ı"
    };
    var normalize = function (term) {
        var ret = "";
        for (var i = 0; i <term.length; i ++) {
            ret += accentMap [term.charAt (i)] || term.charAt (i);

        }
        return ret;
    };
    $( ".autocomplete").autocomplete ({
        minLength: 3,
        source: function (request, response) {
            var matcher = new RegExp ($ .ui.autocomplete.escapeRegex (request.term.toLocaleLowerCase('tr')), "gi");
            response ($ .grep (availableTags, function (value) {
                value = value.label || value.value || value;
                return matcher.test (value.toLocaleUpperCase('tr')) || matcher.test (value.toLocaleLowerCase('tr'))
                    || matcher.test (normalize (value.toLocaleUpperCase('tr')))
                    || matcher.test (normalize (value.toLocaleLowerCase('tr'))) || matcher.test(value);
            }).slice(0, 10));

        }
    }).autocomplete( "instance" )._renderItem = function( ul, item ) {
        return $( "<li>" )
            .append( "<div>" + item.label  +"<img class='right' src='"+item.icon +"' width='20' height='20'></div>" )
            .appendTo( ul );
    };
});