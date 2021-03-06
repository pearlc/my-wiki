<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePageChangesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('page_changes', function(Blueprint $table)
		{
            // fields
            $table->increments('id');
            $table->integer('page_id')->unsigned();
            $table->integer('user_id')->unsigned()->nullable();
            $table->integer('namespace')->unsigned();
            $table->string('title');
            $table->string('comment');
            $table->tinyInteger('bot')->unsigned();
            $table->tinyInteger('type')->unsigned();
            $table->string('ip', 15);
            $table->integer('old_bytes')->unsigned();
            $table->integer('new_bytes')->unsigned();
            $table->tinyInteger('deleted')->unsigned();
            $table->timestamps();


            // indexes
            $table->index('page_id');
            $table->index('created_at');
            $table->index(array('namespace', 'title'));
            $table->index('ip');
            $table->index(array('namespace', 'created_at'));
            $table->index(array('namespace', 'user_id'));
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('page_changes');
	}

}
