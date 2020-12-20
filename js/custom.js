function go_school_type_page(type, weburl) {
    if(type == 1) {
        window.location.href = weburl+'okul-tipi/anaokulu-kres';
    } else if(type == 2) {
        window.location.href = weburl+'okul-tipi/ilk-okul';
    } else if(type == 3) {
        window.location.href = weburl+'okul-tipi/orta-okul';
    } else {
        window.location.href = weburl+'okul-tipi/lise';
    }
}
function like_dislike(type, comment) {
    $.ajax({
        url: "ajax-request/like-dislike.php",
        type: 'POST',
        dataType: 'json',
        data : {like_type: type , comment: comment},
        success: function(result){
            if(result==99) {
                swal({
                    text: "Üye Değilsiniz!",
                    icon: "error",
                    button: "Tamam",
                    buttonColor: "#fb5a4e"
                });
            } else {
                document.getElementById('likes_'+comment).innerHTML = result[0].likes;
                document.getElementById('dislikes_'+comment).innerHTML = result[0].dislikes;
            }

        }});
}

function comment_school() {
    $.ajax({
        url: "ajax-request/comment-school.php",
        type: 'POST',
        dataType: 'json',
        data : $("#comment-form").serialize(),
        success: function(result){
            if(result[0].type==1) {
                swal({
                    text: "Görüşünüz Onaylanmak Üzere Yetkililere İletildi! Puanınız Kaydedildi!",
                    icon: "success",
                    button: "Tamam",
                    buttonColor: "#fb5a4e"
                });
                document.getElementById("comment-form").reset();
                $("#star"+result[0].rating).prop("checked", true);
            }
            else if(result[0].type==2) {
                swal({
                    text: "Görüşünüz Onaylanmak Üzere Yetkililere İletildi!",
                    icon: "success",
                    button: "Tamam",
                    buttonColor: "#fb5a4e"
                });
                document.getElementById("comment-form").reset();
            }
            else if(result[0].type==3) {
                swal({
                    text: "Puanınız Kaydedildi!",
                    icon: "success",
                    button: "Tamam",
                    buttonColor: "#fb5a4e"
                });
                $("#star"+result[0].rating).prop("checked", true);
            }
            else if(result==0) {
                swal({
                    text: "Puan veya Görüş Bildiriniz!",
                    icon: "error",
                    button: "Tamam",
                    buttonColor: "#fb5a4e"
                });
            }
            else if(result==99) {
                swal({
                    text: "Üye Değilsiniz!",
                    icon: "error",
                    button: "Tamam",
                    buttonColor: "#fb5a4e"
                });
            }

        }});
}

function comment_blog() {
    $.ajax({
        url: "ajax-request/comment-blog.php",
        type: 'POST',
        data : $("#blog-form").serialize(),
        success: function(result){
            if(result.trim()==1) {
                swal({
                    text: "Yorumunuz Onaylanmak Üzere Yetkililere İletildi!",
                    icon: "success",
                    button: "Tamam",
                    buttonColor: "#fb5a4e"
                });
                document.getElementById("blog-form").reset();
            }
            else if(result.trim()==0) {
                swal({
                    text: "Yorum Yazmadınız!",
                    icon: "error",
                    button: "Tamam",
                    buttonColor: "#fb5a4e"
                });
            }
            else if(result.trim()==99) {
                swal({
                    text: "Üye Değilsiniz!",
                    icon: "error",
                    button: "Tamam",
                    buttonColor: "#fb5a4e"
                });
            }

        }});
}

$registerValidator = $("#register-form").validate({
    highlight: function(element) {
        $(element).closest('.r-form').addClass('has-error');
    },
    success: function(element) {
        $(element).closest('.r-form').removeClass('has-error');
        $(element).remove();

    },
    errorPlacement: function( error, element ) {
        element.parent().parent().append( error );
    }
});

$ownerValidator = $("#register-form-owner").validate({
    highlight: function(element) {
        $(element).closest('.r-form').addClass('has-error');
    },
    success: function(element) {
        $(element).closest('.r-form').removeClass('has-error');
        $(element).remove();

    },
    errorPlacement: function( error, element ) {
        element.parent().parent().append( error );
    }
});

function register(type) {
    if(type == 1) {
        var f = document.getElementById('register-form');
        var valid = $('#register-form').valid();
        if( !valid ) {
            $registerValidator.focusInvalid();
            return false;
        }
    } else {
        var f = document.getElementById('register-form-owner');
        var valid = $('#register-form-owner').valid();
        if( !valid ) {
            $ownerValidator.focusInvalid();
            return false;
        }
    }

    if(!f.kvkk_control.checked) {
        alert("Kişisel Verilerin İşlenmesine Dair Bilgilendirme Kullanımı Kutucuğunu İşaretleyiniz!");
        return false;
    }
    $.ajax({
        url: "php/Forms/register.php",
        type: 'POST',
        data : type == 1 ? $("#register-form").serialize() :  $("#register-form-owner").serialize(),
        success: function(result){
            if(result.trim()==99) {
                alert('Şifreler Uyuşmuyor!');
            }
            else if(result.trim()==1) {
                swal({
                    text: "Kayıt İşlemi Tamamlandı. Lütfen Mailinizi Gönderilen Doğrulama Kodu İle Doğrulayın!",
                    icon: "success",
                    button: "Tamam",
                    buttonColor: "#fb5a4e"
                });
                type == 1 ? document.getElementById("register-form").reset() : document.getElementById("register-form-owner").reset();
                $('.pop-close').click();
            }
            else if(result.trim()==0 && valid) {
                swal({
                    text: "Bütün Alanları Doldurunuz!",
                    icon: "error",
                    button: "Tamam",
                    buttonColor: "#fb5a4e"
                });
            }
            else if(result.trim()==-1 && valid) {
                swal({
                    text: "Kullanıcı Mevcut Olabilir!",
                    icon: "error",
                    button: "Tamam",
                    buttonColor: "#fb5a4e"
                });
            }

        }});
}

function forgotPassword() {
    $.ajax({
        url: "php/Forms/forgot-password.php",
        type: 'POST',
        data : $("#forgotPassword").serialize(),
        success: function(result){
            if(result.trim()==1) {
                swal({
                    text: "Yeni şifreniz e-posta adresinize gönderildi. Lütfen e-posta adresinizi kontrol edin.",
                    icon: "success",
                    button: "Tamam",
                    buttonColor: "#fb5a4e"
                });
                document.getElementById("forgotPassword").reset();
                $('.pop-close').click();
            } else if(result.trim()==0) {
                swal({
                    text: "Girdiğiniz e-posta adresine ait bir üyelik bulunamadı!",
                    icon: "error",
                    button: "Tamam",
                    buttonColor: "#fb5a4e"
                });
            }

        }});
}

function send_call_us() {
    $.ajax({
        url: "php/Forms/call-us.php",
        type: 'POST',
        data : $("#call-us-form").serialize(),
        success: function(result){
            if(result.trim()==1) {
                swal({
                    text: "Talebiniz Yetkililere Başarıyla İletildi!",
                    icon: "success",
                    button: "Tamam",
                    buttonColor: "#fb5a4e"
                });
                document.getElementById("call-us-form").reset();
            }
            else if(result.trim()==0) {
                swal({
                    text: "Bütün Alanları Doldurunuz!!",
                    icon: "error",
                    button: "Tamam",
                    buttonColor: "#fb5a4e"
                });
            }

        }});
}


function okula_ozel_talep_gonder() {
    $.ajax({
        url: "ajax-request/okula-ozel-talep.php",
        type: 'POST',
        data : $("#school-spesific-demand-form").serialize(),
        success: function(result){
                if(result.trim()==99) {
                    alert('Veli Değilsiniz!');
                }
                else if(result.trim()==1) {
                    swal({
                        text: "Talebiniz Okula Başarıyla İletildi!",
                        icon: "success",
                        button: "Tamam",
                        buttonColor: "#fb5a4e"
                    });
                    document.getElementById("ta-w3mission").value='';
                }
                else if(result.trim()==0) {
                    swal({
                        text: "Bütün Alanları Doldurunuz!!",
                        icon: "error",
                        button: "Tamam",
                        buttonColor: "#fb5a4e"
                    });
                }

        }});
}


function taleple_ilgilen(demandId, demandUserId ,talepIndex, isPremium, hasQuota) {
    if(isPremium == 1 && hasQuota == 1) { // Premiumsa ve Kota var ise
        $.ajax({
            url: "ajax-request/taleple-ilgilen.php",
            type: 'POST',
            data : {demandUserId : demandUserId,
                demandId: demandId},
            success: function(result){
                if(result.trim()==99) {
                    alert('Taleple İlgilenemezsiniz!');
                }
        }});
        var demand_url = document.getElementById('demand_url').value;
        var element = $('<a href="'+demand_url+'" style="font-size: 14px;font-weight: 400;border-radius: 4px;max-width: 200px;cursor:pointer;" class="waves-effect waves-light btn-large full-btn list-red-btn float-right">Talebe Git</a>');
        $('.veliye-iletildi-'+talepIndex).removeClass('hide');
        element.insertBefore($('#taleple-ilgilen-'+talepIndex));
        $('#taleple-ilgilen-'+talepIndex).remove();


    } else if(isPremium == 0) {
        $('.premium-degilsiniz-'+talepIndex).removeClass('hide');
        $('#taleple-ilgilen-'+talepIndex).prop("onclick", null).off("click");
        $('#taleple-ilgilen-'+talepIndex).attr("disabled", true);
    }
}

function reset_talep_form() {
    document.getElementById("frm-talep-filtre").reset();
    $("input:checkbox").prop("checked", false);
    $('#select-iller').val(null).trigger('change');
    $('#select-ilceler').val(null).trigger('change');
}

function reset_talep_form_mobile() {
    document.getElementById("frm-talep-filtre-mobile").reset();
    $("input:checkbox").prop("checked", false);
    $('#select-iller-mobile').val(null).trigger('change');
    $('#select-ilceler-mobile').val(null).trigger('change');
}

function set_multiple_towns(select2_obj) {
    var items= $("#select-iller").val();
    $('#select-ilceler').find('option').remove().end();
    $.ajax({
        url: "ajax-request/set-towns.php",
        type: 'POST',
        dataType: 'json',
        data : {selected_cities : items},
        success: function(result){
            for(var j = 0; j < result.length; j++ ) {
                var sel = document.getElementById('select-ilceler');
                var opt = document.createElement('option');
                opt.appendChild( document.createTextNode(result[j].text) );
                opt.value = result[j].id;
                sel.appendChild(opt);
            }
        }});
    set_select2_multiple_icerik(select2_obj);
}

function set_multiple_towns_mobile(select2_obj) {
    var items= $("#select-iller-mobile").val();
    $('#select-ilceler-mobile').find('option').remove().end();
    $.ajax({
        url: "ajax-request/set-towns.php",
        type: 'POST',
        dataType: 'json',
        data : {selected_cities : items},
        success: function(result){
            for(var j = 0; j < result.length; j++ ) {
                var sel = document.getElementById('select-ilceler-mobile');
                var opt = document.createElement('option');
                opt.appendChild( document.createTextNode(result[j].text) );
                opt.value = result[j].id;
                sel.appendChild(opt);
            }
        }});
    set_select2_multiple_icerik_mobile(select2_obj);
}

function set_towns(element) {
    var selectedOpts = $("#select-city-talep").children("option:selected").val();
    $('#select-town-talep').val(null).trigger('change');
    $('#select-town-talep').find('option').remove().end().append('<option value="">Seçiniz</option>');
    $.ajax({
        url: "ajax-request/set-towns.php",
        type: 'POST',
        dataType: 'json',
        data : {selected_city : selectedOpts},
        success: function(result){
            for(var j = 0; j < result.length; j++ ) {
                var sel = document.getElementById('select-town-talep');
                var opt = document.createElement('option');
                opt.appendChild( document.createTextNode(result[j].text) );
                opt.value = result[j].id;
                sel.appendChild(opt);
            }
        }});

    click_closest_label(element);
}

function set_subtowns(element) {
    var selectedOpts = $("#select-town-talep").children("option:selected").val();
    $('#select-subtown-talep').val(null).trigger('change');
    $('#select-subtown-talep').find('option').remove().end().append('<option value="">Seçiniz</option>');
    $.ajax({
        url: "ajax-request/set-towns.php",
        type: 'POST',
        dataType: 'json',
        data : {selected_town : selectedOpts},
        success: function(result){
            for(var j = 0; j < result.length; j++ ) {
                var sel = document.getElementById('select-subtown-talep');
                var opt = document.createElement('option');
                opt.appendChild( document.createTextNode(result[j].text) );
                opt.value = result[j].id;
                sel.appendChild(opt);
            }
        }});

    click_closest_label(element);
}

function okul_tipi_changed(element) {
    var selectedOpts = $("#select-okul-tipi").children("option:selected").val();
    if(selectedOpts == 1) {
        $(".div-anaokulu").removeClass("form-group");
        $(".div-sinif").css("display", "none");
        $("#select-class-talep").prop('required',false);
        $('#select-age-talep').find('option').remove().end().append('<option value="">Seçiniz</option>'); // Temizle optionları
        for(var j = 1; j <= 6; j++ ) {
            var sel = document.getElementById('select-age-talep');
            var opt = document.createElement('option');
            opt.appendChild( document.createTextNode(j) );
            opt.value = j;
            sel.appendChild(opt);
        }

    } else {
        $(".div-anaokulu").addClass("form-group");
        $(".div-sinif").css("display", "block");
        $("#select-class-talep").prop('required',true);
        $('#select-age-talep').find('option').remove().end().append('<option value="">Seçiniz</option>'); // Temizle optionları
        $('#select-class-talep').find('option').remove().end().append('<option value="">Seçiniz</option>'); // Temizle optionları
        if(selectedOpts == 2) { // İlkokulsa 1 ile 4 arası sınıfı set et
            for(var j = 1; j <= 4; j++ ) {
                var sel = document.getElementById('select-class-talep');
                var opt = document.createElement('option');
                opt.appendChild( document.createTextNode(j) );
                opt.value = j;
                sel.appendChild(opt);
            }

            for(var j = 6; j <= 10; j++ ) {
                var sel = document.getElementById('select-age-talep');
                var opt = document.createElement('option');
                opt.appendChild( document.createTextNode(j) );
                opt.value = j;
                sel.appendChild(opt);
            }
        } else if(selectedOpts == 3) { // Ortaokulsa 5 - 8 arası sınıf
            for(var j = 5; j <= 8; j++ ) {
                var sel = document.getElementById('select-class-talep');
                var opt = document.createElement('option');
                opt.appendChild( document.createTextNode(j) );
                opt.value = j;
                sel.appendChild(opt);
            }
            for(var j = 10; j <= 13; j++ ) {
                var sel = document.getElementById('select-age-talep');
                var opt = document.createElement('option');
                opt.appendChild( document.createTextNode(j) );
                opt.value = j;
                sel.appendChild(opt);
            }
        } else if(selectedOpts == 4) { // Lise ise 9- 12 arası sınıf
            for(var j = 9; j <= 12; j++ ) {
                var sel = document.getElementById('select-class-talep');
                var opt = document.createElement('option');
                opt.appendChild( document.createTextNode(j) );
                opt.value = j;
                sel.appendChild(opt);
            }
            for(var j = 13; j <= 18; j++ ) {
                var sel = document.getElementById('select-age-talep');
                var opt = document.createElement('option');
                opt.appendChild( document.createTextNode(j) );
                opt.value = j;
                sel.appendChild(opt);
            }
        }
    }

    click_closest_label(element);
}
// Wizarda bir sıkıntı var required oldukta sonra mesela seçiyorum hala uyarılar kalıyor ama bir yere tıklayınca
// geçiyordu bende otomatik tıklasın diye error olanlara bunu yaptım
function click_closest_label(element) {
    if($(element)[0].labels[1]) { // if error label exists
        $(element)[0].labels[1].click();// Click error label
    }
}

// Input elementi invalid bir durum olduğunda mesela required olduğunda ama
// yazmadığın zaman bişey title'da ne yazıyorsa onu uyarı versin diye
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
// Select elementi invalid bir durum olduğunda mesela required olduğunda ama
// seçmediğin zaman bişey title'da ne yazıyorsa onu uyarı versin diye
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
// Textarea elementi invalid bir durum olduğunda mesela required olduğunda ama
// yazmadığın zaman bişey title'da ne yazıyorsa onu uyarı versin diye
document.addEventListener("DOMContentLoaded", function() {
    var elements = document.getElementsByTagName("textarea");
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

$(document).ready(function() {
    /*$(".waves-input-wrapper").click(function() {
      document.getElementById('search-btn').click();
    });*/
    $('.waves-button-input').addClass('fullwidth'); // Büyük anasayfadaki hemen bul butonuna full width'i js
    // ile ekliyorum çünkü html de style width 100% verdiğinde yemiyor js ile eklemek lazım
    $('.tiny-search > .waves-button-input').addClass('tiny-search-fullwidth'); // Bu da scroll yaptığında beliren
    // yukardaki küçük arama butonu için aynısı
    $('.il-select2').select2({
        closeOnSelect : false, // seçerken kapanmasın diye
        placeholder : "İl", // Placeholder yazısı
        allowHtml: true, // Bunun şuan bi önemi yok ama ilerde select2'ye özel tasarım yaparsan callback methodları var oraya html tasarım yapılıyor onun için
        allowClear: true // Çarpı işareti çıkıyor hepsini siliyor
    });
    $('.ilce-select2').select2({
        closeOnSelect : false, // seçerken kapanmasın diye
        placeholder : "İlçe", // Placeholder yazısı
        allowHtml: true, // Bunun şuan bi önemi yok ama ilerde select2'ye özel tasarım yaparsan callback methodları var oraya html tasarım yapılıyor onun için
        allowClear: true // Çarpı işareti çıkıyor hepsini siliyor
    });
    $('.fiziksel-imkanlar-select2').select2({
        closeOnSelect : false, // seçerken kapanmasın diye
        placeholder : "Fiziksel İmkanlar", // Placeholder yazısı
        allowHtml: true, // Bunun şuan bi önemi yok ama ilerde select2'ye özel tasarım yaparsan callback methodları var oraya html tasarım yapılıyor onun için
        allowClear: true // Çarpı işareti çıkıyor hepsini siliyor
    });
    $('.servisler-select2').select2({
        closeOnSelect : false, // seçerken kapanmasın diye
        placeholder : "Servisler", // Placeholder yazısı
        allowHtml: true, // Bunun şuan bi önemi yok ama ilerde select2'ye özel tasarım yaparsan callback methodları var oraya html tasarım yapılıyor onun için
        allowClear: true // Çarpı işareti çıkıyor hepsini siliyor
    });
    $('.aktiviteler-select2').select2({
        closeOnSelect : false, // seçerken kapanmasın diye
        placeholder : "Aktiviteler", // Placeholder yazısı
        allowHtml: true, // Bunun şuan bi önemi yok ama ilerde select2'ye özel tasarım yaparsan callback methodları var oraya html tasarım yapılıyor onun için
        allowClear: true // Çarpı işareti çıkıyor hepsini siliyor
    });
    $('.yabanci-diller-select2').select2({
        closeOnSelect : false, // seçerken kapanmasın diye
        placeholder : "Yabancı Diller", // Placeholder yazısı
        allowHtml: true, // Bunun şuan bi önemi yok ama ilerde select2'ye özel tasarım yaparsan callback methodları var oraya html tasarım yapılıyor onun için
        allowClear: true // Çarpı işareti çıkıyor hepsini siliyor
    });
}); // iller select2 si

$(document).ready(function() {
    $('.okul-turu-select').select2();
}); // diller select2 si

// Şu kadar öğe seçildi diye yazdıran kod
function set_select2_multiple_icerik_fiziksel(select2_obj) {
    var uldivResult = $('#fiziksel-imkanlar-select2').parent().next('span.select2').find('ul');
    var uldiv = $('.'+select2_obj).next('span.select2').first('ul');
    var count = uldiv.find('li.select2-selection__choice').length;
    if(count > 2) { // 2'den fazla seçim varsa 3 tane seçildi gibi gözükecek, 2 seçim ve az varsa seçilenler gözükecek
        uldivResult.html("<li>"+count+" Öğe Seçildi.</li>");
    }
}

// Şu kadar öğe seçildi diye yazdıran kod
function set_select2_multiple_icerik_fiziksel_mobile(select2_obj) {
    var uldiv = $('#fiziksel-imkanlar-select2-mobile').parent().next('span.select2').find('ul');
    var count = uldiv.find('li.select2-selection__choice').length;
    if(count > 2) { // 2'den fazla seçim varsa 3 tane seçildi gibi gözükecek, 2 seçim ve az varsa seçilenler gözükecek
        uldiv.html("<li>"+count+" Öğe Seçildi.</li>");
    }
}

// Şu kadar öğe seçildi diye yazdıran kod
function set_select2_multiple_icerik_servisler(select2_obj) {
    var uldivResult = $('#servisler-select2').parent().next('span.select2').find('ul');
    var uldiv = $('.'+select2_obj).next('span.select2').first('ul');
    var count = uldiv.find('li.select2-selection__choice').length;
    if(count > 2) { // 2'den fazla seçim varsa 3 tane seçildi gibi gözükecek, 2 seçim ve az varsa seçilenler gözükecek
        uldivResult.html("<li>"+count+" Öğe Seçildi.</li>");
    }
}

// Şu kadar öğe seçildi diye yazdıran kod
function set_select2_multiple_icerik_servisler_mobile(select2_obj) {
    var uldiv = $('#servisler-select2-mobile').parent().next('span.select2').find('ul');
    var count = uldiv.find('li.select2-selection__choice').length;
    if(count > 2) { // 2'den fazla seçim varsa 3 tane seçildi gibi gözükecek, 2 seçim ve az varsa seçilenler gözükecek
        uldiv.html("<li>"+count+" Öğe Seçildi.</li>");
    }
}

// Şu kadar öğe seçildi diye yazdıran kod
function set_select2_multiple_icerik_aktiviteler(select2_obj) {
    var uldivResult = $('#aktiviteler-select2').parent().next('span.select2').find('ul');
    var uldiv = $('.'+select2_obj).next('span.select2').first('ul');
    var count = uldiv.find('li.select2-selection__choice').length;
    if(count > 2) { // 2'den fazla seçim varsa 3 tane seçildi gibi gözükecek, 2 seçim ve az varsa seçilenler gözükecek
        uldivResult.html("<li>"+count+" Öğe Seçildi.</li>");
    }
}

// Şu kadar öğe seçildi diye yazdıran kod
function set_select2_multiple_icerik_aktiviteler_mobile(select2_obj) {
    var uldiv = $('#aktiviteler-select2-mobile').parent().next('span.select2').find('ul');
    var count = uldiv.find('li.select2-selection__choice').length;
    if(count > 2) { // 2'den fazla seçim varsa 3 tane seçildi gibi gözükecek, 2 seçim ve az varsa seçilenler gözükecek
        uldiv.html("<li>"+count+" Öğe Seçildi.</li>");
    }
}

// Şu kadar öğe seçildi diye yazdıran kod
function set_select2_multiple_icerik_diller(select2_obj) {
    var uldivResult = $('#yabanci-diller-select2').parent().next('span.select2').find('ul');
    var uldiv = $('.'+select2_obj).next('span.select2').first('ul');
    var count = uldiv.find('li.select2-selection__choice').length;
    if(count > 2) { // 2'den fazla seçim varsa 3 tane seçildi gibi gözükecek, 2 seçim ve az varsa seçilenler gözükecek
        uldivResult.html("<li>"+count+" Öğe Seçildi.</li>");
    }
}

// Şu kadar öğe seçildi diye yazdıran kod
function set_select2_multiple_icerik_diller_mobile(select2_obj) {
    var uldiv = $('#yabanci-diller-select2-mobile').parent().next('span.select2').find('ul');
    var count = uldiv.find('li.select2-selection__choice').length;
    if(count > 2) { // 2'den fazla seçim varsa 3 tane seçildi gibi gözükecek, 2 seçim ve az varsa seçilenler gözükecek
        uldiv.html("<li>"+count+" Öğe Seçildi.</li>");
    }
}


// Şu kadar öğe seçildi diye yazdıran kod
function set_select2_multiple_icerik(select2_obj) {
    var uldivResult = $('#select-iller').parent().next('span.select2').find('ul');
    var uldiv = $('.'+select2_obj).next('span.select2').first('ul');
    var count = uldiv.find('li.select2-selection__choice').length;
    if(count > 2) { // 2'den fazla seçim varsa 3 tane seçildi gibi gözükecek, 2 seçim ve az varsa seçilenler gözükecek
        uldivResult.html("<li>"+count+" Öğe Seçildi.</li>");
    }
}

// Şu kadar öğe seçildi diye yazdıran kod
function set_select2_multiple_icerik_mobile(select2_obj) {
    var uldivResult = $('#select-iller-mobile').parent().next('span.select2').find('ul');
    var uldiv = $('#'+select2_obj).parent().next('span.select2').first('ul');
    var count = uldiv.find('li.select2-selection__choice').length;
    if(count > 2) { // 2'den fazla seçim varsa 3 tane seçildi gibi gözükecek, 2 seçim ve az varsa seçilenler gözükecek
        uldivResult.html("<li>"+count+" Öğe Seçildi.</li>");
    }
}

// Şu kadar öğe seçildi diye yazdıran kod
function set_select2_multiple_icerik_ilce(select2_obj) {
    var uldivResult = $('#select-ilceler').parent().next('span.select2').find('ul');
    var uldiv = $('.'+select2_obj).next('span.select2').first('ul');
    var count = uldiv.find('li.select2-selection__choice').length;
    if(count > 2) { // 2'den fazla seçim varsa 3 tane seçildi gibi gözükecek, 2 seçim ve az varsa seçilenler gözükecek
        uldivResult.html("<li>"+count+" Öğe Seçildi.</li>");
    }
}

// Şu kadar öğe seçildi diye yazdıran kod
function set_select2_multiple_icerik_ilce_mobile(select2_obj) {
    var uldiv = $('#select-ilceler-mobile').parent().next('span.select2').find('ul');
    var count = uldiv.find('li.select2-selection__choice').length;
    if(count > 2) { // 2'den fazla seçim varsa 3 tane seçildi gibi gözükecek, 2 seçim ve az varsa seçilenler gözükecek
        uldiv.html("<li>"+count+" Öğe Seçildi.</li>");
    }
}

$(document).ready(function() {
    "use strict";
	
	//COPYRIGHR YEAR UPDATE
	$("#cryear").text("2019");
	
    //LEFT MOBILE MENU OPEN
    $(".ts-menu-5").on('click', function() {
        $(".mob-right-nav").css('right', '0px');
    });

    //LEFT MOBILE MENU OPEN
    $(".mob-right-nav-close").on('click', function() {
        $(".mob-right-nav").css('right', '-270px');
    });

    //LEFT MOBILE MENU CLOSE
    $(".mob-close").on('click', function() {
        $(".mob-close").hide("fast");
        $(".menu").css('left', '-92px');
        $(".mob-menu").show("slow");
    });

    //mega menu
    $(".t-bb").hover(function() {
        $(".cat-menu").fadeIn(50);
    });
    $(".ts-menu").mouseleave(function() {
        $(".cat-menu").fadeOut(50);
    });

    //mega menu
    $(".sea-drop").on('click', function() {
        $(".sea-drop-1").fadeIn(100);
    });
    $(".sea-drop-1").mouseleave(function() {
        $(".sea-drop-1").fadeOut(50);
    });
    $(".dir-ho-t-sp").mouseleave(function() {
        $(".sea-drop-1").fadeOut(50);
    });

    //mega menu top menu
    $(".sea-drop-top").on('click', function() {
        $(".sea-drop-2").fadeIn(100);
    });
    $(".sea-drop-1").mouseleave(function() {
        $(".sea-drop-2").fadeOut(50);
    });
    $(".top-search").mouseleave(function() {
        $(".sea-drop-2").fadeOut(50);
    });

    //ADMIN LEFT MOBILE MENU OPEN
    $(".atab-menu").on('click', function() {
        $(".sb2-1").css("left", "0");
        $(".btn-close-menu").css("display", "inline-block");
    });

    //ADMIN LEFT MOBILE MENU CLOSE
    $(".btn-close-menu").on('click', function() {
        $(".sb2-1").css("left", "-350px");
        $(".btn-close-menu").css("display", "none");
    });

    //mega menu
    $(".t-bb").hover(function() {
        $(".cat-menu").fadeIn(50);
    });
    $(".ts-menu").mouseleave(function() {
        $(".cat-menu").fadeOut(50);
    });
	
    //review replay
    $(".edit-replay").on('click', function() {
        $(".hide-box").show();
    });
	
	//What you looking for checkbox
	$('.req-pop-sec-1 input:checkbox').on('change', function(){
		if($(this).is(":checked")) {
			$(".req-nxt-1").addClass("nxt-act");
		}
		var check = $('.req-pop-sec-1').find('input[type=checkbox]:checked').length;
		if(check <= 0){
			$(".req-nxt-1").removeClass("nxt-act");
		}
	});
	//What you looking for - Next button
    $(".req-nxt-1").on('click', function() {
		$(".req-nxt-1").hide();
        $(".req-pop-sec-1").hide();
		$(".req-pop-sec-2").show();
    });
	
	//SET TIME FOR SHOWING "What you looking for" POPUP
	setTimeout(function(){
      $(".req-pop").fadeIn();
	},5000);
	
	//POPUP CLOSED EVENT
    $(".req-pop-clo").on('click', function() {
		$(".req-pop").fadeOut();
    });
	
	//POPUP SUBMIT BUTTON EVENT
    $(".rer-sub-btn").on('click', function() {
		$(".req-pop-sec-1, .req-pop-sec-2").hide();
		$(".req-pop-sec-3").show();
    });
	
	

    //PRE LOADING
    $('#status').fadeOut();
    $('#preloader').delay(350).fadeOut('slow');
    $('body').delay(350).css({
        'overflow': 'visible'
    });

    $('.dropdown-button').dropdown({
        inDuration: 300,
        outDuration: 225,
        constrainWidth: 400, // Does not change width of dropdown to that of the activator
        hover: true, // Activate on hover
        gutter: 0, // Spacing from edge
        belowOrigin: false, // Displays dropdown below the button
        alignment: 'left', // Displays dropdown with edge aligned to the left of button
        stopPropagation: false // Stops event propagation
    });
    $('.dropdown-button2').dropdown({
        inDuration: 300,
        outDuration: 225,
        constrain_width: false, // Does not change width of dropdown to that of the activator
        hover: true, // Activate on hover
        gutter: ($('.dropdown-content').width() * 3) / 2.5 + 5, // Spacing from edge
        belowOrigin: false, // Displays dropdown below the button
        alignment: 'left' // Displays dropdown with edge aligned to the left of button
    });

    //Collapsible
    $('.collapsible').collapsible();

    //material select
    $('select').material_select();
	
    //AUTO COMPLETE CATEGORY SELECT
    $('#select-category.autocomplete, #select-category1.autocomplete').autocomplete({
        data: {
            "All Category": null,
            "Entertainment": null,
            "Food & Drink": null,
            "Hotel & Hostel": null,
			"OutDoor": null,
			"Parking": null,
			"Shop & Store": null,
			"Events": null,
			"Beauty arlour": null,
            "Jersey City": null
        },
        limit: 8, // The max amount of results that can be shown at once. Default: Infinity.
        onAutocomplete: function(val) {
            // Callback function when value is autcompleted.
        },
        minLength: 1, // The minimum length of the input for the autocomplete to start. Default: 1.
    });
	
//AUTO COMPLETE CITY SELECT
    $('#select-city.autocomplete, #top-select-city.autocomplete').autocomplete({
        data: {
            "New York": null,
            "California": null,
            "Illinois": null,
            "Texas": null,
            "Pennsylvania": null,
            "San Diego": null,
            "Los Angeles": null,
            "Dallas": null,
            "Austin": null,
            "Columbus": null,
            "Charlotte": null,
            "El Paso": null,
            "Portland": null,
            "Las Vegas": null,
            "Oklahoma City": null,
            "Milwaukee": null,
            "Tucson": null,
            "Sacramento": null,
            "Long Beach": null,
            "Oakland": null,
            "Arlington": null,
            "Tampa": null,
            "Corpus Christi": null,
            "Greensboro": null,
            "Jersey City": null
        },
        limit: 8, // The max amount of results that can be shown at once. Default: Infinity.
        onAutocomplete: function(val) {
            // Callback function when value is autcompleted.
        },
        minLength: 1, // The minimum length of the input for the autocomplete to start. Default: 1.
    });

    //HOME PAGE FIXED MENU
    $(window).scroll(function() {

        if ($(this).scrollTop() > 450) {
            $('.hom-top-menu').fadeIn();
            $('.cat-menu').hide();
        } else {
            $('.hom-top-menu').fadeOut();
        }
    });
	
    //HOME PAGE FIXED MENU
    $(window).scroll(function() {

        if ($(this).scrollTop() > 450) {
            $('.hom3-top-menu').addClass("top-menu-down");
        } else {
            $('.hom3-top-menu').removeClass("top-menu-down");
        }
    });	
});

function scrollNav() {
    $('.v3-list-ql-inn a').click(function() {
        //Toggle Class
        $(".active-list").removeClass("active-list");
        $(this).closest('li').addClass("active-list");
        var theClass = $(this).attr("class");
        $('.' + theClass).parent('li').addClass('active-list');
        //Animate
        $('html, body').stop().animate({
            scrollTop: $($(this).attr('href')).offset().top - 130
        }, 400);
        return false;
    });
    $('.scrollTop a').scrollTop();
}
scrollNav();
