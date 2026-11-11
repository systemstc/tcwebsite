@php
    $recaptchaSiteKey = \App\Models\Setting::get('recaptcha_site_key', config('services.recaptcha.site_key', '6LcGoBIsAAAAALZ2jeq6GOKz9RDkKhLJk38uEVP3'));
    $recaptchaEnabled = \App\Models\Setting::get('recaptcha_enabled', '1');
@endphp

@if(!empty($recaptchaSiteKey) && $recaptchaEnabled)
    <div class="my-3">
        <div class="g-recaptcha" data-sitekey="{{ $recaptchaSiteKey }}"></div>
        @error('g-recaptcha-response')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>
@endif
