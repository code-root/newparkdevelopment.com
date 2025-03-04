<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Language;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $languages = [
            [
                'code' => 'ar',
                'name' => 'العربية',
                'is_active' => true,
                'is_default' => false,
                'direction' => 'rtl',
                'flag' => '🇸🇦',
                'currency' => 'SAR',
                'currency_symbol' => '﷼',
                'locale' => 'ar_SA',
                'date_format' => 'd/m/Y',
                'time_format' => 'H:i',
                'timezone' => 'Asia/Riyadh',
                'weekend' => 'Friday,Saturday',
                'status' => 'active',
            ],
            [
                'code' => 'en',
                'name' => 'English',
                'is_active' => true,
                'is_default' => true,
                'direction' => 'ltr',
                'flag' => '🇺🇸',
                'currency' => 'USD',
                'currency_symbol' => '$',
                'locale' => 'en_US',
                'date_format' => 'm/d/Y',
                'time_format' => 'h:i A',
                'timezone' => 'America/New_York',
                'weekend' => 'Saturday,Sunday',
                'status' => 'active',
            ],
            [
                'code' => 'es',
                'name' => 'Español',
                'is_active' => true,
                'is_default' => false,
                'direction' => 'ltr',
                'flag' => '🇪🇸',
                'currency' => 'EUR',
                'currency_symbol' => '€',
                'locale' => 'es_ES',
                'date_format' => 'd/m/Y',
                'time_format' => 'H:i',
                'timezone' => 'Europe/Madrid',
                'weekend' => 'Saturday,Sunday',
                'status' => 'active',
            ],
            [
                'code' => 'de',
                'name' => 'Deutsch',
                'is_active' => true,
                'is_default' => false,
                'direction' => 'ltr',
                'flag' => '🇩🇪',
                'currency' => 'EUR',
                'currency_symbol' => '€',
                'locale' => 'de_DE',
                'date_format' => 'd.m.Y',
                'time_format' => 'H:i',
                'timezone' => 'Europe/Berlin',
                'weekend' => 'Saturday,Sunday',
                'status' => 'active',
            ],
        ];

        foreach ($languages as $language) {
            Language::create($language);
        }
    }
}

