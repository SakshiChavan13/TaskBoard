<?php

namespace Database\Seeders;

use App\Models\Card;
use App\Models\Board;
use App\Models\BoardList;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BoardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $userId = 1; 
       
        for ($b = 1; $b <= 3; $b++) {
            $board = Board::create([
                'user_id' => $userId,
                'name' => "Sample Board $b",
                'description' => "This is board number $b"
            ]);

           
            for ($l = 1; $l <= 3; $l++) {
                $list = BoardList::create([
                    'board_id' => $board->id,
                    'name' => "List $l",
                    'position' => $l,
                ]);

               
                for ($c = 1; $c <= 3; $c++) {
                    Card::create([
                        'board_list_id' => $list->id,
                        'title' => "Card $c in List $l",
                        'description' => "Description for card $c",
                        'position' => $c,
                    ]);
                }
            }
        }
    }
}
