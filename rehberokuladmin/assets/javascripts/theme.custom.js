/* Add here all your JS customizations */

$(document).on('click', '.modal-dismiss', function (e) {
        e.preventDefault();
        $.magnificPopup.close();
});

/*
Modal Confirm
*/
$(document).on('click', '.modal-confirm', function (e) {
        e.preventDefault();
        $.magnificPopup.close();


});




function set_towns(){
    var selectedOpts = $("#city").children("option:selected").val();
    $('#town').val(null).trigger('change');
    $('#town').select2({
        theme: 'bootstrap',
        ajax: {
            url: "ajaxrequest/towns",
            type: "post",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    searchTerm: params.term, // search term
                    selectedCity: selectedOpts
                };
            },
            processResults: function (data) {
                return {
                    results: data
                };
            },
            cache: false
        }
    });
    $('#servc').val(null).trigger('change');
    $('#servc').select2({
        allowclear: true,
        multiple: true,
        theme: 'bootstrap',
        ajax: {
            url: "ajaxrequest/towns",
            type: "post",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    searchTerm: params.term, // search term
                    selectedCity: selectedOpts
                };
            },
            processResults: function (data) {
                return {
                    results: data
                };
            },
            cache: true
        }
    });
}

function set_subtowns() {
    var selectedOpts = $("#town").children("option:selected").val();
    $('#subtown').val(null).trigger('change');
    $('#subtown').select2({
        theme: 'bootstrap',
        ajax: {
            url: "ajaxrequest/subtowns",
            type: "post",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    searchTerm: params.term, // search term
                    selectedTown: selectedOpts
                };
            },
            processResults: function (data) {
                return {
                    results: data
                };
            },
            cache: true
        }
    });
}

function set_user_info() {
    var selectedOpts = $("#user_id").children("option:selected").val();
    if(selectedOpts == '') {
        $("#full_name").prop('disabled',false);
        $("#email").prop('disabled',false);
        $("#phone").prop('disabled',false);
    } else {
        $("#full_name").prop('disabled',true);
        $("#email").prop('disabled',true);
        $("#phone").prop('disabled',true);
    }

    $.ajax({
        url: "ajaxrequest/get_selected_user",
        type: 'POST',
        dataType: 'json',
        data: {selected_user: selectedOpts},
        success: function(result){
            $("#full_name").val(result[0].first_name+' '+result[0].last_name);
            $("#email").val(result[0].email);
            $("#phone").val(result[0].phone);
        }});
}

function preview_answer(question_link, sss_connection) {
    var selectedOpts = $("#school").children("option:selected").val();
    if(selectedOpts != '') {
        $.ajax({
            url: "ajaxrequest/previewanswer",
            type: 'POST',
            dataType: 'json',
            data: {selected_school: selectedOpts, question: question_link, sss_connection: sss_connection},
            success: function(result){
                $(".summernote").summernote("code", result[0].answer);
            }});
    }
}

function delete_notification(notId) {

    $.ajax({
        url: "ajaxrequest/delete_notification",
        type: 'POST',
        async: false,
        dataType: 'json',
        data: {notification: notId},
        success: function(result){
            setTimeout(
                function()
                {
                    location.reload();
                }, 1);
        },
        error: function (request, status, error) {
            setTimeout(
                function()
                {
                    location.reload();
                }, 1);
        }});
}
function mark_as_read(notId) {

    $.ajax({
        url: "ajaxrequest/mark_as_read",
        type: 'POST',
        async: false,
        dataType: 'json',
        data: {notification: notId},
        success: function(result){
            setTimeout(
                function()
                {
                    location.reload();
                }, 1);
        },
        error: function (request, status, error) {
            setTimeout(
                function()
                {
                    location.reload();
                }, 1);
        }});
}

function mark_as_unread(notId) {

    $.ajax({
        url: "ajaxrequest/mark_as_unread",
        type: 'POST',
        async: false,
        dataType: 'json',
        data: {notification: notId},
        success: function(result){
            setTimeout(
                function()
                {
                    location.reload();
                }, 1);
        },
        error: function (request, status, error) {
            setTimeout(
                function()
                {
                    location.reload();
                }, 1);
        }});
}

function get_school_type_shop() {
    var selectedOpts = $("#school_shop").children("option:selected").val();

    $.ajax({
        url: "ajaxrequest/get_school_type",
        type: 'POST',
        async: false,
        dataType: 'json',
        data: {selected_school: selectedOpts},
        success: function(result){
            document.getElementById('type_price').innerHTML = result[0].fiyat + ' TL';
            if(result[0].okul_turu == 1) {
                document.getElementById('premium_type').innerHTML = '(Anaokulu veya Kreş)';
            } else if(result[0].okul_turu == 2) {
                document.getElementById('premium_type').innerHTML = '(İlkokul)';
            } else if(result[0].okul_turu == 3) {
                document.getElementById('premium_type').innerHTML = '(Ortaokul)';
            } else if(result[0].okul_turu == 4) {
                document.getElementById('premium_type').innerHTML = '(Lise)';
            } else {
                document.getElementById('premium_type').innerHTML = '(Okul Seçilmedi)';
            }
        }});
}

function remove_from_cart(item_id) {
    var selectedOpts = $("#school_shop").children("option:selected").val();
        $.ajax({
        url: "ajaxrequest/remove_from_cart",
        type: 'POST',
        async: false,
        dataType: 'json',
        data: {selected_cart_item: item_id},
        success: function(result){
            setTimeout(
                function()
                {
                    location.reload();
                }, 1);
        },
        error: function (request, status, error) {
            setTimeout(
                function()
                {
                    location.reload();
                }, 1);
        }});
}

function add_to_cart() {
    var selectedOpts = $("#school_shop").children("option:selected").val();
    let fiyat = document.getElementById('type_price').innerHTML;
    fiyat = fiyat.split(" ");
    fiyat = fiyat[0];
    fiyat = parseFloat(fiyat.replace('.',' ').replace(' ',''));
    if(selectedOpts != '') {
        $.ajax({
            url: "ajaxrequest/add_to_cart",
            type: 'POST',
            async: false,
            dataType: 'json',
            data: {selected_school: selectedOpts, fiyat: fiyat},
            success: function(result){
                setTimeout(
                    function()
                    {
                        location.reload();
                    }, 1);
            },
            error: function (request, status, error) {
                setTimeout(
                    function()
                    {
                        location.reload();
                    }, 1);
            }});
    } else {
        alert('Okul Seçmediniz!');
    }
}

function complete_payment(user_id) {
    let price = $('#price').text();
    price =  price.split(",");
    price = parseFloat(price[0].replace('.',' ').replace(' ',''));
    let kdv = $('#kdv').text();
    kdv =  kdv.split(",");
    kdv = parseFloat(kdv[0].replace('.',' ').replace(' ',''));
    let total_price = $('#total_price').text();
    total_price =  total_price.split(",");
    total_price = parseFloat(total_price[0].replace('.',' ').replace(' ',''));
    let total_discount = $('#total_discount').text();
    total_discount =  total_discount.split(",");
    total_discount = parseFloat(total_discount[0].replace('.',' ').replace(' ',''));
    if($('input#agree').is(':checked')) {
        $.ajax({
            url: "ajaxrequest/complete_payment",
            type: 'POST',
            async: false,
            dataType: 'json',
            data: {user_id: user_id, price: price, kdv: kdv, total_price: total_price, total_discount: total_discount},
            success: function(result){
                alert(result);
                setTimeout(
                    function()
                    {
                        location.reload();
                    }, 1);
            },
            error: function (request, status, error) {
                setTimeout(
                    function()
                    {
                        location.reload();
                    }, 1);
            }});
    } else {
        alert('Okudum, onaylıyorum kutucuğunu işaretleyiniz!');
    }
}




document.addEventListener("DOMContentLoaded", function() {
    var elements = document.getElementsByTagName("input");
    for (var i = 0; i < elements.length; i++) {
        elements[i].oninvalid = function(e) {
            e.target.setCustomValidity("");
            if (!e.target.validity.valid) {
                e.target.setCustomValidity(this.title);
            }
        };
        elements[i].oninput = function(e) {
            e.target.setCustomValidity("");
        };
    }
})

document.addEventListener("DOMContentLoaded", function() {
    var elements = document.getElementsByTagName("select");
    for (var i = 0; i < elements.length; i++) {
        elements[i].oninvalid = function(e) {
            e.target.setCustomValidity("");
            if (!e.target.validity.valid) {
                e.target.setCustomValidity(this.title);
            }
        };
        elements[i].oninput = function(e) {
            e.target.setCustomValidity("");
        };
    }
})

function visible_schools() {
    var selectedOpts = $("#roles_select").children("option:selected").val();
    if(selectedOpts == 4) {
        $("#schools_select_div").css("display", "block");
        $("#schools_select").prop('required',true);
    } else {
        $("#schools_select_div").css("display", "none");
        $("#schools_select").prop('required',false);
    }
}

function visible_notification() {
    var selectedOpts = $("#send_type").children("option:selected").val();
    if(selectedOpts == 1) {
        $("#send_to_multi_div").css("display", "block");
        $("#send_to_multi").prop('required',true);
        $("#send_to_single_div").css("display", "none");
        $("#send_to_single").prop('required',false);
    } else {
        $("#send_to_multi_div").css("display", "none");
        $("#send_to_multi").prop('required',false);
        $("#send_to_single_div").css("display", "block");
        $("#send_to_single").prop('required',true);
    }
}

function set_classes() {
    var selectedOpts = $("#school_type").children("option:selected").val();
    if (selectedOpts == 4) {
        $("#classroom_div_lise").css("display", "block");
        $("#classroom_div_ortaokul").css("display", "none");
        $("#classroom_div_ilkokul").css("display", "none");
        $("#classroom_lise").prop('required',true);
        $("#classroom_ortaokul").prop('required',false);
        $("#classroom_ilkokul").prop('required',false);
    } else if(selectedOpts == 3) {
        $("#classroom_div_lise").css("display", "none");
        $("#classroom_div_ortaokul").css("display", "block");
        $("#classroom_div_ilkokul").css("display", "none");
        $("#classroom_lise").prop('required',false);
        $("#classroom_ortaokul").prop('required',true);
        $("#classroom_ilkokul").prop('required',false);
    } else if(selectedOpts == 2) {
        $("#classroom_div_lise").css("display", "none");
        $("#classroom_div_ortaokul").css("display", "none");
        $("#classroom_div_ilkokul").css("display", "block");
        $("#classroom_lise").prop('required',false);
        $("#classroom_ortaokul").prop('required',false);
        $("#classroom_ilkokul").prop('required',true);
    } else {
        $("#classroom_div_lise").css("display", "none");
        $("#classroom_div_ortaokul").css("display", "none");
        $("#classroom_div_ilkokul").css("display", "none");
        $("#classroom_lise").prop('required',false);
        $("#classroom_ortaokul").prop('required',false);
        $("#classroom_ilkokul").prop('required',false);
    }
}

function visible_check_folder() {
    var selectedOpts = $("#isdir").children("option:selected").val();
    if(selectedOpts == 0) {
        $("#folder").css("display", "block");
        $("#folder_name").prop('required',true);
        $("#select_folder_div").css("display", "none");
        $("#select_folder").prop('required',false);
        $("#upload_div").css("display", "none");
        $("#upload").prop('required',false);
        $("#photo_name_div").css("display", "none");
        $("#photo_name").prop('required', false);
    } else {
        $("#folder").css("display", "none");
        $("#folder_name").prop('required', false);
        $("#select_folder_div").css("display", "block");
        $("#select_folder").prop('required', true);
        $("#upload_div").css("display", "block");
        $("#upload").prop('required', true);
        $("#photo_name_div").css("display", "block");
        $("#photo_name").prop('required', true);
    }
}

function check_service() {
    var selectedOpts = $("#service").children("option:selected").val();
    if(selectedOpts == 1) {
        $("#servc_div").css("display", "block");
        $("#servc").prop('required', true);
    } else {
        $("#servc_div").css("display", "none");
        $("#servc").prop('required', false);
    }
}

function set_visible_sss_place() {
    var selectedOpts = $("#sss_place").children("option:selected").val();
    if(selectedOpts == 'okul-detay') {
        $('#sss_answer_type').val(null).trigger('change');
        $('#sss_connection').val(null).trigger('change');
        $("#sss-connection-div").css("display", "block");
        $("#sss_connection").prop('required',true);
        $("#sss-answer-type-div").css("display", "block");
        $("#sss_answer_type").prop('required',true);
    } else {
        $("#sss-connection-div").css("display", "none");
        $("#sss_connection").prop('required',false);
        $("#sss-answer-type-div").css("display", "none");
        $("#sss_answer_type").prop('required',false);
        $("#sss-style-div").css("display", "none");
        $("#sss_style").prop('required',false);
    }
}

function set_answer_type() {
    var selectedOpts = $("#sss_answer_type").children("option:selected").val();
    if(selectedOpts == 'otomatik') {
        $("#sss-style-div").css("display", "block");
        $("#sss_style").prop('required',true);
    } else {
        $("#sss-style-div").css("display", "none");
        $("#sss_style").prop('required',false);
    }
}


$(document).ready(function() {
    $('#datatable-tabletools-kindergarten thead th').each( function (i) {
        if(i != 0 && i != 5 && i != 8) {
            var title = $(this).text();
            $(this).html('<div class="form-group form-group-sm is-empty"><div>' + title + '</div><input type="search" style="width: 100%;" class="form-control" placeholder=" ' + title + '" aria-controls="datatables"></div>');
        }
    } );
} );

$(document).ready(function() {
    $('#datatable-tabletools-kindergarten-ks thead th').each( function (i) {
        if(i != 0 && i != 7) {
            var title = $(this).text();
            $(this).html('<div class="form-group form-group-sm is-empty"><div>' + title + '</div><input type="search" style="width: 100%;" class="form-control" placeholder=" ' + title + '" aria-controls="datatables"></div>');
        }
    } );
} );

$(document).ready(function() {
    $('#datatable-tabletools-demand thead th').each( function (i) {
        if(i != 0 && i != 7) {
            var title = $(this).text();
            $(this).html('<div class="form-group form-group-sm is-empty"><div>' + title + '</div><input type="search" style="width: 100%;" class="form-control" placeholder=" ' + title + '" aria-controls="datatables"></div>');
        }
    } );
} );

$(document).ready(function() {
    $('#datatable-tabletools-demand-spesific thead th').each( function (i) {
        if(i != 0 && i != 5) {
            var title = $(this).text();
            $(this).html('<div class="form-group form-group-sm is-empty"><div>' + title + '</div><input type="search" style="width: 100%;" class="form-control" placeholder=" ' + title + '" aria-controls="datatables"></div>');
        }
    } );
} );

$(document).ready(function() {
    $('#datatable-tabletools-demands thead th').each( function (i) {
        if(i != 0 && i != 7) {
            if(i == 6) {
                var title = $(this).text();
                $(this).html('<div class="form-group form-group-sm is-empty"><div>' + title + '</div><input type="search" style="width: 100%;" class="form-control" placeholder=" ' + title + '" aria-controls="datatables"></div>');

            } else {
                var title = $(this).text();
                $(this).html('<div class="form-group form-group-sm is-empty"><div>' + title + '</div><input type="search" style="width: 100%;" class="form-control" placeholder=" ' + title + '" aria-controls="datatables"></div>');

            }
        }
    } );
} );

$(document).ready(function() {
    $('#datatable-tabletools-announcement thead th').each( function (i) {
        if(i != 0 && i != 5) {
            var title = $(this).text();
            $(this).html('<div class="form-group form-group-sm is-empty"><div>' + title + '</div><input type="search" style="width: 100%;" class="form-control" placeholder=" ' + title + '" aria-controls="datatables"></div>');
        }
    } );
} );

$(document).ready(function() {
    $('#datatable-tabletools-gallery thead th').each( function (i) {
        if(i != 0 && i != 4) {
            var title = $(this).text();
            $(this).html('<div class="form-group form-group-sm is-empty"><div>' + title + '</div><input type="search" style="width: 100%;" class="form-control" placeholder=" ' + title + '" aria-controls="datatables"></div>');
        }
    } );
} );

$(document).ready(function() {
    $('#datatable-tabletools thead th').each( function (i) {
        if(i != 0 && i != 6 && i != 4) {
            var title = $(this).text();
            $(this).html('<div class="form-group form-group-sm is-empty"><div>' + title + '</div><input type="search" style="width: 100%;" class="form-control" placeholder=" ' + title + '" aria-controls="datatables"></div>');
        } else if(i==4) {
            var title = $(this).text();
            $(this).html('<div class="form-group form-group-sm is-empty"><div>' + title + '</div>' +
                '<div class="input-daterange input-group datepicker-orient-top" data-plugin-datepicker>' +
                '<input type="text" data-date-format="yyyy-mm-dd" placeholder="Başlangıç" class="form-control" name="start" id="start">' +
                '<br>' +
                '<input type="text" data-date-format="yyyy-mm-dd" placeholder="Bitiş" class="form-control" name="end" id="end">' +
                '</div>');
        }
    } );
} );

$(document).ready(function() {
    $('#datatable-tabletools-blogpost thead th').each( function (i) {
        if(i != 0 && i != 4) {
            var title = $(this).text();
            $(this).html('<div class="form-group form-group-sm is-empty"><div>' + title + '</div><input type="search" style="width: 100%;" class="form-control" placeholder=" ' + title + '" aria-controls="datatables"></div>');
        }
    } );
} );

$(document).ready(function() {
    $('#datatable-tabletools-comment thead th').each( function (i) {
        if(i != 0 && i != 6) {
            var title = $(this).text();
            $(this).html('<div class="form-group form-group-sm is-empty"><div>' + title + '</div><input type="search" style="width: 100%;" class="form-control" placeholder=" ' + title + '" aria-controls="datatables"></div>');
        }
    } );
} );

$(document).ready(function() {
    $('#datatable-tabletools-payment thead th').each( function (i) {
        if(i != 0 && i != 8) {
            var title = $(this).text();
            $(this).html('<div class="form-group form-group-sm is-empty"><div>' + title + '</div><input type="search" style="width: 100%;" class="form-control" placeholder=" ' + title + '" aria-controls="datatables"></div>');
        }
    } );
} );

$(document).ready(function() {
    $('#datatable-tabletools-cat thead th').each( function (i) {
        if(i != 0 && i != 2) {
            var title = $(this).text();
            $(this).html('<div class="form-group form-group-sm is-empty"><div>' + title + '</div><input type="search" style="width: 100%;" class="form-control" placeholder=" ' + title + '" aria-controls="datatables"></div>');
        }
    } );
} );

$(document).ready(function() {
    $('#datatable-tabletools-notification thead th').each( function (i) {
        if(i != 0 && i != 3) {
            var title = $(this).text();
            $(this).html('<div class="form-group form-group-sm is-empty"><div>' + title + '</div><input type="search" style="width: 100%;" class="form-control" placeholder=" ' + title + '" aria-controls="datatables"></div>');
        }
    } );
} );

$(document).ready(function() {
    $('#datatable-tabletools-sss thead th').each( function (i) {
        if(i != 0 && i != 5) {
            var title = $(this).text();
            $(this).html('<div class="form-group form-group-sm is-empty"><div>' + title + '</div><input type="search" style="width: 100%;" class="form-control" placeholder=" ' + title + '" aria-controls="datatables"></div>');
        }
    } );
} );

$(function() {
    $( "#start" ).datepicker({
        dateFormat: 'yy-mm-dd',
        changeMonth: true,
        changeYear: true,
        orientation: 'auto bottom',
        language: 'tr'
    });

    $( "#end" ).datepicker({
        dateFormat: 'yy-mm-dd',
        changeMonth: true,
        changeYear: true,
        orientation: 'auto bottom',
        language: 'tr'
    });
} );







