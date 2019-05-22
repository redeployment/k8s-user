<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use App\Models\User;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('guid',32)->unique()->nullable();

            $table->smallInteger('type', false, true)->default(User::TYPE_INIT)->comment('用户类型');
            $table->smallInteger('status', false, true)->default(User::STATUS_INIT)->comment('用户状态');

            $table->string('name');
            $table->string('true_name')->nullable();
            $table->string('mobile')->nullable()->comment('手机号码');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
