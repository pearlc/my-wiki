<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExternalLinksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('external_links', function(Blueprint $table)
		{
            // fields
			$table->integer('page_id')->unsigned();
            $table->string('url');

            // indexes
            $table->unique(array('page_id', 'url'));
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('external_links');
	}

}
