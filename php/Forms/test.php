<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>
    <form class="s12 ng-pristine ng-valid" method="post" action="register.php">
        <div>
            <div class="input-field s12">
                <input name="first_name" type="text">
                <label>Ad</label>
            </div>
        </div>
        <div>
            <div class="input-field s12">
                <input name="last_name" type="text">
                <label class="">Soyad</label>
            </div>
        </div>
        <div>
            <div class="input-field s12">
                <input name="email" type="email">
                <label class="active">E-Posta</label>
            </div>
        </div>
        <div>
            <div class="input-field s12">
                <input name="phone" type="text">
                <label>Telefon</label>
            </div>
        </div>
        <div>
            <div class="input-field s12">
                <select name="user_role" class="initialized">
                    <option value="" disabled="" selected="">Kullanıcı Tipi</option>
                    <option value="2">Kurum Sahibi</option>
                    <option value="3">Veli</option>
                </select>
            </div>
        </div>
        <div>
            <div class="input-field s12">
                <input name="password" type="password" class="validate valid">
                <label class="active">Şifre</label>
            </div>
        </div>
        <div>
            <div class="input-field s4 xxs-pt">
                <i class="waves-effect waves-light log-in-btn waves-input-wrapper" style="">
                    <input type="submit" value="Kayıt Ol" class="waves-button-input fullwidth">
                </i>
            </div>
        </div>
    </form>
</body>
</html>