<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $categories=['RLD GENEL','Eğlence','bilişim','teknoloji','film','3d','oyun'];
      foreach($categories as $category){
        DB::table('categories')->insert([
          'name'=>$category,
          'slug'=>str_slug($category),
          'created_at'=>now(),
          'updated_at'=>now(),
        ]);
      }

    }
}
