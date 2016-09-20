<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpstreamList extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
		Schema::create('upstream_lists', function (Blueprint $table) {
			$table->increments('id');
			$table->string('name')->unique();
			$table->boolean('is_enable');
			$table->string('ip1');
			$table->boolean('is_backup_ip1');
			$table->string('ip2')->nullable();
			$table->boolean('is_backup_ip2')->nullable();
			$table->string('ip3')->nullable();
			$table->boolean('is_backup_ip3')->nullable();
			$table->string('ip4')->nullable();
			$table->boolean('is_backup_ip4')->nullable();
			$table->timestamps();
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
		Schema::drop('upstream_lists');
    }
}
