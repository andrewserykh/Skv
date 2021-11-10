<?
include_once("../administrator/engine/initdb.php");
include ('../settings.php');
error_reporting( E_ERROR );
$root_path = "../";
?>
<div class="login">

    <!-- Login -->
    <form role="form" enctype="multipart/form-data" name="form1" method="post" action="login_auth.php"  autocomplete="off">
    <div class="login__block active" id="l-login">
        <div class="login__block__header">
            <i class="zwicon-user-circle"></i>
            Пожалуйста выполните вход.

            <div class="actions actions--inverse login__block__actions">
                <div class="dropdown">
                    <i data-toggle="dropdown" class="zwicon-more-h actions__item"></i>

                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" data-sa-action="login-switch" data-sa-target="#l-forget-password" href="">Забыли пароль?</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="login__block__body">
            <div class="form-group">
                <input type="text" name="username" class="form-control text-center" placeholder="Пользователь">
            </div>

            <div class="form-group">
                <input type="password" name="password" class="form-control text-center" placeholder="Пароль">
            </div>

            <button type="submit"  class="btn btn-theme btn--icon"><i class="zwicon-checkmark"></i></button>
        </div>
    </div>
    </form>


    <!-- Forgot Password -->
    <form role="form" enctype="multipart/form-data" name="form1" method="post" action="index.php"  autocomplete="off">

    <div class="login__block" id="l-forget-password">
        <div class="login__block__header">
            <i class="zwicon-user-circle"></i>
            Забыли пароль?

            <div class="actions actions--inverse login__block__actions">
                <div class="dropdown">
                    <i data-toggle="dropdown" class="zwicon-more-h actions__item"></i>

                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" data-sa-action="login-switch" data-sa-target="#l-login" href="">Перейти к авторизации</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="login__block__body">
            <p class="mb-5">Укажите адрес электронной почты Вашего аккаунта и мы вышлем пароль.</p>

            <div class="form-group">
                <input type="text" class="form-control text-center" placeholder="Email адрес">
            </div>

            <button type="submit"  class="btn btn-theme btn--icon"><i class="zwicon-checkmark"></i></button>
        </div>
    </div>
    </form>
</div>

<!-- Older IE warning message -->
<!--[if IE]>
<div class="ie-warning">
    <h1>Warning!!</h1>
    <p>You are using an outdated version of Internet Explorer, please upgrade to any of the following web browsers to access this website.</p>

    <div class="ie-warning__downloads">
        <a href="http://www.google.com/chrome">
            <img src="img/browsers/chrome.png" alt="">
        </a>

        <a href="https://www.mozilla.org/en-US/firefox/new">
            <img src="img/browsers/firefox.png" alt="">
        </a>

        <a href="http://www.opera.com">
            <img src="img/browsers/opera.png" alt="">
        </a>

        <a href="https://support.apple.com/downloads/safari">
            <img src="img/browsers/safari.png" alt="">
        </a>

        <a href="https://www.microsoft.com/en-us/windows/microsoft-edge">
            <img src="img/browsers/edge.png" alt="">
        </a>

        <a href="http://windows.microsoft.com/en-us/internet-explorer/download-ie">
            <img src="img/browsers/ie.png" alt="">
        </a>
    </div>
    <p>Sorry for the inconvenience!</p>
</div>
<![endif]-->

<!-- Javascript -->
<!-- Vendors -->
<script src="resources/vendors/jquery/jquery.min.js"></script>
<script src="resources/vendors/popper.js/popper.min.js"></script>
<script src="resources/vendors/bootstrap/js/bootstrap.min.js"></script>

<!-- App functions and actions -->
<script src="resources/js/app.min.js"></script>

<?
exit();
?>
