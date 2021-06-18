	{!! NoCaptcha::renderJs() !!}
<div
  class="auth modal show"
  id="auth modal"
  tabindex="-1"
    style="display: block; padding-right: 15px;"
  aria-labelledby="auth modal"
  aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
                        <div class="tabs">
                    <div class="tab" onclick="$.auth()" data-toggle-auth-tab="login">
                        Login
                    </div>
                    <div class="tab" onclick="$.register()" data-toggle-auth-tab="register">
                        Register
                    </div>
                    <div class="tab" data-toggle-auth-tab="forgot">
                        Forgot
                    </div>
                </div>
        <button
          type="button"
          data-mdb-dismiss="auth modal"
                class="btn-white btn-close"
                ></button>
      </div>
      <div class="modal-body">
        <div class="ui-blocker" style="display: none;">
            <div class="loader"><div></div></div>
        </div>
                    <div class="authTabContent active" data-auth-tab="login">
<div class="form-outline mt-3 mb-3">
  <i style="font-size: 12px; margin-left: 5px;" class="fad fa-users-crown"></i> <small>Usertag</small>
  <input type="text" id="login" class="form-control" />
  <label class="form-label" for="typeText"></label>
</div>

<div class="form-outline mt-3 mb-3">
  <i style="font-size: 12px; margin-left: 5px;" class="fad fa-key"></i> <small>Password</small>
  <input type="password" id="password" class="form-control" />
  <label class="form-label" for="typeText"></label>
</div>
<div style="margin-bottom: 20px;">
                                       {!! NoCaptcha::display(['data-theme' => 'dark'], ['data-callback' => 'recaptchaCallback']) !!}
                                    </div>
        <button class="btn btn-primary btn-block p-1">{{ __('general.auth.login') }}</button>


      </div>


                    <div class="authTabs" data-auth-tab="register" style="display: none;">

        <div class="divider">
            <div class="line"></div>
            {{ __('general.auth.through_login') }}
            <div class="line"></div>
        </div>

<div class="form-outline mt-3 mb-3">
  <input type="text" id="login" class="form-control" />
  <label class="form-label" for="typeText">Username</label>
</div>

<div class="form-outline mt-3 mb-3">
  <input type="password" id="password" class="form-control" />
  <label class="form-label" for="typeText">Password</label>
</div>
<div style="height: 58px; margin-bottom: 20px;">
                                       {!! NoCaptcha::display(['data-theme' => 'dark'], ['data-callback' => 'recaptchaCallback']) !!}
                                    </div>
        <button class="btn btn-primary btn-block p-1" onclick="$.register()">{{ __('general.auth.register') }}</button>


      </div>


    </div>
  </div>
</div>

