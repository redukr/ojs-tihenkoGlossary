<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Builder;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Capsule\Manager as Capsule;

class TihenkoSchemaMigration extends Migration {
    /**
     * Run migrations to create glossary table.
     * @return void
     */
    public function up() {
        Capsule::schema()->create('glossary', function (Blueprint $table) {
            $table->bigInteger('id')->autoIncrement();
            $table->string('lang', 10)->default('');
            $table->string('word', 150)->default('');
            $table->string('wordtrans', 150)->default('');
            $table->string('meaning', 2000)->default('');
            $table->bigInteger('synonymid');
            $table->datetime('datetimeupdate');
			$table->index(['id'], 'index_id');
			$table->unique(['lang', 'word'], 'pkey');
        });
    }
}
