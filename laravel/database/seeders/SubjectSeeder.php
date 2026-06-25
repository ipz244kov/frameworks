<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    public function run(): void
    {
        Subject::create(['name' => 'PHP', 'description' => 'Основи мови PHP', 'credits' => 4]);
        Subject::create(['name' => 'Laravel', 'description' => 'Вивчення фреймворку Laravel', 'credits' => 5]);
        Subject::create(['name' => 'Databases', 'description' => 'Робота з SQLite та MySQL', 'credits' => 3]);
    }
}
