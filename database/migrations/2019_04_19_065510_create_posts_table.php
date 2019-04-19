<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('slug')->nullable();
            $table->text('content');
            $table->string('description');
            $table->string('image')->nullable();
            $table->timestamps();
        });
        DB::table('posts')->insert( array(
            [
                'id' => 1,
                'title' => 'Văn học Việt Nam',
                'content' => "sdfsdf dfsdgf  sdfds ",
                'description' => "sfdfsdfdf sdfds df",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'id' => 2,
                'title' => 'Văn học nước ngoài',
                'description' => "sfdfsdfdf sdfds df",
                'content' => "sdfsdf dfsdgf  sdfds ",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'id' => 3,
                'title' => 'Truyện',
                'content' => "sdfsdf dfsdgf  sdfds ",
                'description' => "sfdfsdfdf sdfds df",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
        ));
        \DB::statement('ALTER TABLE posts AUTO_INCREMENT = 4;');

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
