<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteAnalytic extends Model
{
    use HasFactory;

    protected $table = 'site_analytics';

    protected $fillable = [
        'session_id',
        'ip_address',
        'url',
        'path',
        'page_title',
        'locale',
        'bhashini_lang',
        'is_bhashini',
        'device_type',
        'browser',
        'platform',
        'referer',
        'view_date',
    ];

    protected $casts = [
        'is_bhashini' => 'boolean',
        'view_date' => 'date',
    ];

    /**
     * Get rich metadata for language code.
     */
    public static function getLanguageMeta($code)
    {
        $map = [
            'en' => ['name' => 'English', 'native' => 'English', 'label' => 'English'],
            'hi' => ['name' => 'Hindi', 'native' => 'हिन्दी', 'label' => 'Hindi (हिन्दी)'],
            'mr' => ['name' => 'Marathi', 'native' => 'मराठी', 'label' => 'Marathi (मराठी)'],
            'ta' => ['name' => 'Tamil', 'native' => 'தமிழ்', 'label' => 'Tamil (தமிழ்)'],
            'te' => ['name' => 'Telugu', 'native' => 'తెలుగు', 'label' => 'Telugu (తెలుగు)'],
            'gu' => ['name' => 'Gujarati', 'native' => 'ગુજરાતી', 'label' => 'Gujarati (ગુજરાતી)'],
            'bn' => ['name' => 'Bengali', 'native' => 'বাংলা', 'label' => 'Bengali (বাংলা)'],
            'kn' => ['name' => 'Kannada', 'native' => 'ಕನ್ನಡ', 'label' => 'Kannada (ಕನ್ನಡ)'],
            'ml' => ['name' => 'Malayalam', 'native' => 'മലയാളം', 'label' => 'Malayalam (മലയാളം)'],
            'pa' => ['name' => 'Punjabi', 'native' => 'ਪੰਜਾਬੀ', 'label' => 'Punjabi (ਪੰਜਾਬੀ)'],
            'or' => ['name' => 'Odia', 'native' => 'ଓଡ଼ିଆ', 'label' => 'Odia (ଓଡ଼ିଆ)'],
            'as' => ['name' => 'Assamese', 'native' => 'অসমীয়া', 'label' => 'Assamese (অসমীয়া)'],
            'ur' => ['name' => 'Urdu', 'native' => 'اردو', 'label' => 'Urdu (اردو)'],
        ];

        $c = strtolower(trim((string)$code));
        return $map[$c] ?? ['name' => strtoupper($c ?: 'EN'), 'native' => strtoupper($c ?: 'EN'), 'label' => strtoupper($c ?: 'EN')];
    }

    /**
     * Map language code to human-readable label.
     */
    public static function getLanguageName($code)
    {
        return self::getLanguageMeta($code)['label'];
    }
}
