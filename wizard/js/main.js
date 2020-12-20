$wValidator = $("#talepler-form").validate({
    highlight: function(element) {
        $(element).closest('.form-row').addClass('has-error');
    },
    success: function(element) {
        $(element).closest('.form-row').removeClass('has-error');
        $(element).remove();

    },
    errorPlacement: function( error, element ) {
        element.parent().append( error );
    }
});


$(function(){
    var cIndex;
    var nIndex;
    var res = false;
    $("#wizard").steps({
        headerTag: "h4",
        bodyTag: "section",
        transitionEffect: "fade",
        enableAllSteps: true,
        transitionEffectSpeed: 500,
        onStepChanging: function (event, currentIndex, newIndex) {
            cIndex = currentIndex;
            nIndex = newIndex;
            if(currentIndex < newIndex) {
                var validated = $('#talepler-form').valid();
                if( !validated ) {
                    $wValidator.focusInvalid();
                    res = false;
                    return false;
                }
            }
            if(newIndex - currentIndex < 2) { // 1. tabdan 3. taba atlayamasın
                if ( newIndex === 1 ) {
                    $('.steps ul').addClass('step-2');
                } else {
                    $('.steps ul').removeClass('step-2');
                }
                if ( newIndex === 2 ) {
                    $('.steps ul').addClass('step-3');
                } else {
                    $('.steps ul').removeClass('step-3');
                }

                if ( newIndex === 3 ) {
                    $('.steps ul').addClass('step-4');
                    $('.actions ul').addClass('step-last');
                } else {
                    $('.steps ul').removeClass('step-4');
                    $('.actions ul').removeClass('step-last');
                }
                res = true;
                return true;
            } else if(currentIndex > newIndex) { // En son tabdan başa gelebilsin
                if ( newIndex === 1 ) {
                    $('.steps ul').addClass('step-2');
                } else {
                    $('.steps ul').removeClass('step-2');
                }
                if ( newIndex === 2 ) {
                    $('.steps ul').addClass('step-3');
                } else {
                    $('.steps ul').removeClass('step-3');
                }

                if ( newIndex === 3 ) {
                    $('.steps ul').addClass('step-4');
                    $('.actions ul').addClass('step-last');
                } else {
                    $('.steps ul').removeClass('step-4');
                    $('.actions ul').removeClass('step-last');
                }
                res = true;
                return true;
            } else {
                res = false;
                return false;
            }

        },
        onFinishing: function (event, currentIndex)
        {
            var validated = $('#talepler-form').valid();
            if( !validated ) {
                $wValidator.focusInvalid();
                res = false;
                return false;
            } else {
                res = true;
                return true;
            }
        },
        labels: {
            finish: "Gönder",
            next: "İleri",
            previous: "Geri"
        }
    });
    // Custom Steps Jquery Steps
    $('.wizard > .steps li a').click(function(){
        if(res) {
            $(this).parent().addClass('checked');
            $(this).parent().prevAll().addClass('checked');
            $(this).parent().nextAll().removeClass('checked');
        }
    });


    $(".actions a[href='#finish']").on('click',(function() {
        if( res ) {
            $.ajax({
                url: "ajax-request/talep-kaydet.php",
                type: 'POST',
                data : $("#talepler-form").serialize(),
                success: function(result){
                    if (result.trim() == 1) {
                        swal({
                            text: "Talebiniz başarıyla oluşturuldu!",
                            icon: "success",
                            button: "Tamam",
                            buttonColor: "#fb5a4e"
                        });
                        document.getElementById("talepler-form").reset(); // Formu temizle
                        $('#talepler-form input').removeClass('valid');
                        $('#talepler-form input').removeClass('error');
                        $('#talepler-form select').removeClass('valid');
                        $('#talepler-form select').removeClass('error');
                        $('#talepler-form textarea').removeClass('valid');
                        $('#talepler-form textarea').removeClass('error');
                        $('#wizard').steps("reset"); // Wizardı başa al
                        $('.wizard > .steps li a').parent().nextAll().removeClass('checked'); // Yukarıdaki Turuncu Çizgiler gitsin diye
                        res = false;
                    } else if( result.trim() == 99) {
                        alert('Veli Değilsiniz!');
                    }
            }});
        }
    }));
})
