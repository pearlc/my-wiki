<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePageLinksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('page_links', function(Blueprint $table)
		{
            // fields
            $table->integer('from')->unsigned();
            $table->integer('to')->unsigned();

            // indexes
            $table->unique(array('from', 'to'));
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('page_links');
	}

}
