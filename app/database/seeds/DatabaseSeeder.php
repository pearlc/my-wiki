<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
        // fillable 혹은 guarded 로 지정된 것들 무효화
		Eloquent::unguard();

		$this->call('UserTableSeeder');
        $this->command->info('User table seeded!');

        $this->call('PageChangeTableSeeder');
        $this->command->info('Page Change table seeded!');

        $this->call('PageTableSeeder');
        $this->command->info('Page table seeded!');

        $this->call('RevisionTableSeeder');
        $this->command->info('Revision table seeded!');

    }

}
