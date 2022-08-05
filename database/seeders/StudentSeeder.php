<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Seeder;


class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    protected $model = Student::class;

    public function run()
    {
        Student::factory()->count(150)->create();
    }
}
