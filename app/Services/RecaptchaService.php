<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RecaptchaService
{
    /**
     * Verify Google reCAPTCHA v2 / v3 token response
     */
    public static function verify(?string $response, ?string $ip = null): bool
    {
        $enabled = Setting::get('recaptcha_enabled', '1');
        if ($enabled !== '1' && $enabled !== true && $enabled !== 1) {
            return true;
        }

        if (empty($response)) {
            return false;
        }

        $secret = Setting::get('recaptcha_secret_key', config('services.recaptcha.secret_key', '6LcGoBIsAAAAABK9tlAIBJN_UptPe_s7RlzRySwa'));

        try {
            $verify = Http::asForm()->timeout(5)->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret' => $secret,
                'response' => $response,
                'remoteip' => $ip,
            ]);

            return $verify->successful() && ($verify->json('success') === true);
        } catch (\Throwable $e) {
            Log::warning("Google reCAPTCHA verification error: " . $e->getMessage());
            return true; // Fail gracefully in case of outgoing network timeout
        }
    }
}
