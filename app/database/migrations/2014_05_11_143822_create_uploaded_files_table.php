<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUploadedFilesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('uploaded_files', function(Blueprint $table)
		{

            /**

            CREATE TABLE `uploaded_files` (
            `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `name` varchar(11) NOT NULL DEFAULT '',
            `size` int(10) unsigned NOT NULL,
            `width` int(10) unsigned NOT NULL,
            `height` int(10) unsigned NOT NULL,
            `meta` text NOT NULL,
            `bits` int(10) unsigned NOT NULL,
            `type` enum('unknown','application','audio','image','text','video','message','model','multipart') NOT NULL DEFAULT 'unknown',
            `major_mime` varchar(30) NOT NULL DEFAULT '',
            `minor_mime` varchar(30) NOT NULL DEFAULT '',
            `description` varchar(200) NOT NULL DEFAULT '',
            `user` int(10) unsigned NOT NULL,
            `sha1` varbinary(32) NOT NULL DEFAULT '',
            `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            KEY `idx_user_created_at` (`user`,`created_at`),
            KEY `idx_size` (`size`),
            KEY `idx_timestamp` (`created_at`),
            KEY `idx_type_mime` (`type`,`major_mime`,`minor_mime`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

             */

            // fields
            $table->increments('id');
            $table->string('name');
            $table->integer('size')->unsigned();
            $table->integer('width')->unsigned();
            $table->integer('height')->unsigned();
            $table->text('meta');
            $table->integer('bits')->unsigned();
            $table->enum('type', array('unknown','application','audio','image','text','video','message','model','multipart'));
            $table->string('major_mime', 30);
            $table->string('minor_mime', 30);
            $table->string('description', 200);
            $table->integer('user_id')->unsigned();
            $table->string('sha1', 32);
			$table->timestamps();

            // indexes
            $table->index('user_id', 'created_at');
            $table->index('size');
            $table->index('created_at');
            $table->index(array('type', 'major_mime', 'minor_mime'));
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('uploaded_files');
	}

}
