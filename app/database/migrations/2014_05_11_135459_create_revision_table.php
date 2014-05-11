<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRevisionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('revisions', function(Blueprint $table)
		{
            // fields
            $table->increments('id');
            $table->integer('page')->unsigned();
            $table->text('text');
            $table->string('comment');
            $table->integer('user')->unsigned();
            $table->string('ip', 15);
            $table->tinyInteger('deleted')->unsigned();
            $table->integer('len')->unsigned();
            $table->integer('parent_revision')->unsigned();
            $table->string('sha1', 32);
            $table->timestamps();

            // indexes
            $table->index('created_at');
            $table->index(array('page', 'created_at'));
            $table->index(array('user', 'created_at'));
            $table->index(array('page', 'user', 'created_at'));
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('revisions');
	}

}
