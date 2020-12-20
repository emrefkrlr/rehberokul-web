function interfaceLogin() {
    $.ajax({
        url: "https://www.rehberokul.com/rehberokuladmin/",
        type: 'POST',
        data : $("#login-form").serialize(),
        success: function(result){
            if (result.trim() == "login-error") {
                document.getElementById('message-box').innerHTML = "Giriş Başarısız!";
                document.getElementById('message-box').classList.add("message-box-error");
            } else if (result.trim() == "login-success") {
                document.getElementById('message-box').innerHTML = "Hoşgeldiniz!";
                document.getElementById('message-box').classList.remove("message-box-error");
                document.getElementById('message-box').classList.add("message-box-success");
                setTimeout(function(){
                    location.reload();
                }, 2000);
            }
        }});
}
function interfaceKurumLogin() {
    $.ajax({
        url: "https://www.rehberokul.com/rehberokuladmin/",
        type: 'POST',
        data : $("#kurum-login-form").serialize(),
        success: function(result){
            if (result.trim() == "login-error") {
                document.getElementById('kurum-message-box').innerHTML = "Giriş Başarısız!";
                document.getElementById('kurum-message-box').classList.add("message-box-error");
            } else if (result.trim() == "login-kurum-error") {
                document.getElementById('kurum-message-box').innerHTML = "Kurum Sahibi Değilsiniz!";
                document.getElementById('kurum-message-box').classList.add("message-box-error");
            } else {
                document.getElementById('kurum-message-box').innerHTML = "Hoşgeldiniz!";
                document.getElementById('kurum-message-box').classList.remove("message-box-error");
                document.getElementById('kurum-message-box').classList.add("message-box-success");
                setTimeout(function(){
                    window.location.href = result.trim();
                }, 2000);
            }
        }});
}