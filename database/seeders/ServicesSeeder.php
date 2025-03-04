<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Seeder;

class ServicesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('categories')->insert([
            [
                'title' => 'استراتيجية العمل',
                'description' => 'لكن لا بد أن أوضح لك أن كل هذه حول استنكار النشوة وتمجيد الألم نشأت بالفعل، وسأعرض لك التفاصيل لتكتشف.',
                'icon' => 'icon-9',
                'color_class' => 'color-primary',
            ],
            [
                'title' => 'إدارة مشروع',
                'description' => 'لكن لا بد أن أوضح لك أن كل هذه حول استنكار النشوة وتمجيد الألم نشأت بالفعل، وسأعرض لك التفاصيل لتكتشف.',
                'icon' => 'icon-16',
                'color_class' => 'color-secondary',
            ],
            [
                'title' => 'الموارد البشرية',
                'description' => 'لكن لا بد أن أوضح لك أن كل هذه حول استنكار النشوة وتمجيد الألم نشأت بالفعل، وسأعرض لك التفاصيل لتكتشف.',
                'icon' => 'assets/images/svg-icons/user.svg',
                'color_class' => 'color-extra08',
            ],
            [
                'title' => 'إدارة المبيعات',
                'description' => 'لكن لا بد أن أوضح لك أن كل هذه حول استنكار النشوة وتمجيد الألم نشأت بالفعل، وسأعرض لك التفاصيل لتكتشف.',
                'icon' => 'icon-14',
                'color_class' => 'color-tertiary',
            ],
            [
                'title' => 'مجال الاتصالات',
                'description' => 'لكن لا بد أن أوضح لك أن كل هذه حول استنكار النشوة وتمجيد الألم نشأت بالفعل، وسأعرض لك التفاصيل لتكتشف.',
                'icon' => 'assets/images/svg-icons/instructor.svg',
                'color_class' => 'color-extra02',
            ],
            [
                'title' => 'مستشار',
                'description' => 'لكن لا بد أن أوضح لك أن كل هذه حول استنكار النشوة وتمجيد الألم نشأت بالفعل، وسأعرض لك التفاصيل لتكتشف.',
                'icon' => 'icon-15',
                'color_class' => 'color-extra07',
            ],
        ]);
    }
}
