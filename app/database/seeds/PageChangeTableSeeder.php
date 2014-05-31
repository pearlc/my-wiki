<?php
/**
 * User: rchung
 * Date: 2014. 5. 31.
 * Time: 오후 6:31
 */

class PageChangeTableSeeder extends Seeder {

    public function run()
    {
        DB::table('page_changes')->delete();
    }
} 
