<?php
namespace App\Traits;

trait LanguageTrait {



    public function nameLanguage() {
        $language = session('language', 'en');
        if ($language === 'ar') {
            return $this->attributes['name_ar'];
        } else {
            return $this->attributes['name_en'];
        }
    }

    public function descriptionLanguage() {
        $language = session('language', 'en');
        if ($language === 'ar') {
            return $this->attributes['description_ar'];
        } else {
            return $this->attributes['description_en'];
        }
    }


    
       public function titleLanguage() {
           $language = session('language', 'en');
           if ($language === 'ar') {
               return $this->attributes['title_ar'];
           } else {
               return $this->attributes['title_en'];
           }
       }

       public function TimesWorksLanguage() {
           $language = session('language', 'en');
           if ($language === 'ar') {
               return $this->attributes['working_hours_ar'];
           } else {
               return $this->attributes['working_hours_en'];
           }
       }




}
