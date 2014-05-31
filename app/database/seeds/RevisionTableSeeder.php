<?php
/**
 * User: rchung
 * Date: 2014. 5. 31.
 * Time: 오후 6:30
 */

class RevisionTableSeeder extends Seeder {

    public function run()
    {
        DB::table('revisions')->delete();
    }
}
