<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('pages', function($table)
            {
                // fields
                $table->increments('id');
                $table->integer('namespace')->unsigned();
                $table->string('title');
                $table->integer('counter')->unsigned();
                $table->tinyInteger('is_redirected')->unsigned();
                $table->tinyInteger('is_new')->unsigned();
                $table->integer('latest_revision_id')->unsigned();
                $table->integer('bytes')->unsigned();
                $table->double('random', 15, 8)->unsigned();
                $table->timestamp('touched_at');
                $table->timestamps();

                // indexes
                $table->index('created_at');
                $table->index(array('namespace', 'title'));
                $table->index('random');
                $table->index('bytes');
                $table->index(array('is_redirected', 'namespace', 'bytes'));
            });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
        Schema::drop('pages');
	}

}
