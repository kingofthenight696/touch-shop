<?php

use App\Models\Board;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class BoardTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //TODO add path format
        $editorId = User::adminRole()->first()->id;
        factory(Board::class, 1)->create([
            'path' => '',
            'author_id' => $editorId,
            'last_editor_id' => $editorId
        ])->each(function ($board) {
            factory(Product::class, 2)->create([
                'board_id' => $board->id,
            ]);
        });
    }
}
