<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    
        for($i = 1; $i <= 5; $i++) {
					// Generating random hex color
					$color_hex = '#';
					$hex = array_merge(range('a', 'f'), range(0, 9));
					for($hci = 0; $hci < 6; $hci++) {
						$color_hex .= $hex[rand(0, count($hex)-1)];
					}
        
	        DB::table('categories')->insert([
						'name' => 'cat_' . str_random(5),
						'color' => $color_hex
	        ]);
	        DB::table('tasks')->insert([
						'category_id' => rand(0, 5), // Generating also tasks without category (category_id = 0)
						'title' => 'task_' . str_random(5),
						'description' => 'Some task description here with random text' . str_random(32),
						'completed' => rand(0, 1)
	        ]);
        }
    }
}
