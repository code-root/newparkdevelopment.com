<?php

namespace App\Helpers;

use App\Models\Translation;

class TranslationHelper
{
    public static function storeText($data)
    {
        $languageId = $data['language_id']; 
        $token = $data['token'];
        $keys = array_keys($data); 
        $values = array_values($data); 
        $excludedKeys = ['language_id', 'token'];        

        for ($i = 0; $i < count($keys); $i++) {
            if ($keys[$i] != 'language_id' && $keys[$i] != 'token') {
                Translation::updateOrCreate(
                    ['token' => $token, 'language_id' => $languageId, 'key' => $keys[$i]], // استخدام المفتاح
                    [
                        'value' => $values[$i] ?? '',
                        'status' => 1,
                    ]
                );
            }
        }

        return ['message' => 'Text saved successfully'];
    }

    public static function getText($languageId, $token)
    {
        $empty = 100;
        $translations = Translation::where('token', $token)
            ->where('language_id', $languageId)
            ->get();

        $result = [];
        foreach ($translations as $translation) {
            $empty = 200;
            $result[$translation->key] = $translation->value; 
        }

        return ['translations' => $result, 'empty' => $empty];
    }

    


}