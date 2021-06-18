
@if(auth()->guest())
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


    <div class="login">
      <div class="login__row">
        <div id="sideauth" class="login__col"><a class="login__logo" href="index.html"><img style="filter: drop-shadow(1px 1px 0px #1f2128); transform: scale(0.98);" alt=""></a>
           <h1 class="login__title h1" style="filter: drop-shadow(2px 2px 0px #1f2128);">Get <span>started!</span><br></h1>
          <div class="login__info h6" style="text-shadow: 1px 1px black;">Decentralized Finance Crypto for Players, Operators and Investors.</div>
          <div class="login__preview"></div>
        </div>
        <div class="login__col">
          <div class="login__form">
            <div id="auth-header" class="login__stage"><div class="h4">Sign in to  <br>your DXL Account<br></div><small><span style="color: #808191;">Setup 2FA security on your account and get a free bonus!</small></span></div>
            <div id="register-header" class="login__stage" style="display: none;"><div class="h4">Register and access <br>all DeFiXL's services<br></div><small><span style="color: #808191;">If you do not want to use our webwallet, feel free to check out our <a href="/wallets/">external desktop wallet</a>.</small></span></div>

            <div class="login__field field js-field">
              <div class="field__label">Display Name</div>
              <div class="field__wrap"><input id="login" class="field__input js-field-input" type="text"></div>
            </div>
            <div class="login__field field js-field">
              <div class="field__label">Password</div>
              <div class="field__wrap"><input class="field__input js-field-input" id="password" type="password"></div>
            </div>
            <div class="btn btn-blue btn-wide btn-block p-3">Sign in</div>
            <div class="login__links text-right"><a class="login__link" href="#"><div style="z-index: 9999999999999999; transform:scale(0.75);" class="login__verify" href="#">{!! NoCaptcha::display(['data-theme' => 'dark'], ['data-callback' => 'recaptchaCallback']) !!}</div><div class="sidebar__icon" style="margin-left: 40px;"><svg class="icon icon-link">
                  <use xlink:href="img/sprite.svg#icon-link"></use>                                                      
                </svg></div>Forgot Password?</a></div>
            </a>
            <div class="login__flex" id="auth-footer">
              <div class="login__text">Not a member?</div><a onclick="$.register()" class="login__link"><div class="sidebar__icon"><svg class="icon icon-link">
                  <use xlink:href="img/sprite.svg#icon-link"></use>
                </svg></div>Sign up now</a>
            </div>
            <div class="login__flex" id="register-footer" style="display: none;">
              <div class="login__text">Registered already?</div><a onclick="$.auth()" class="login__link"><div class="sidebar__icon"><svg class="icon icon-link">
                  <use xlink:href="img/sprite.svg#icon-link"></use>
                </svg></div>Login</a>
            </div>
          </div>
        </div>
      </div>

</div>

    <script language="text/javascript">

//When the page is fully loaded
$(document).ready(function () {
    //Change the opacity to 1
    $("pageContent").css('opacity','1');
});
</script>
@endif