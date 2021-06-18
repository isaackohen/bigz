<div
  class="tfa modal"
  id="tfa modal"
  tabindex="-1"
    style="display: block; flex: none;"
  aria-hidden="true">
  <div class="modal-dialog modal-fullscreen">
    <div class="modal-content">
      <div class="modal-header">2FA Verification
      </div>
      <div class="modal-body">
        <div class="ui-blocker" style="display: none;">
            <div class="loader"><div></div></div>
        </div>
        <div class="lockContainer">
            <i class="fas fa-lock"></i>

            <div class="lock"></div>

            <div class="bubble"></div>
            <div class="bubble"></div>
        </div>

        <div class="tfah">2FA</div>
        <div class="tfad">{{ __('general.profile.2fa_description') }}</div>

        <div class="inputs">
            <input maxlength="2">
            <input maxlength="2">
            <input maxlength="2">
            <input maxlength="2">
            <input maxlength="2">
            <input maxlength="1">
        </div>

        <div class="tfaStatus">{{ __('general.profile.2fa_digits', ['digits' => 6]) }}</div>
    </div>
</div>
</div>
</div>
