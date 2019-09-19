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
        $editorId = User::adminRole()->first()->id;

        $images = ['shelf.jpg', 'shelf-low.jpg'];

        foreach($images as $image){
            Board::create(
                [
                'path' => 'shelf.jpg',
                    'author_id' => $editorId,
                    'last_editor_id' => $editorId
                ]
            )->each(function($board) {
                factory(Product::class)->create(['board_id' => $board->id]);
            });
        }
    }
}
