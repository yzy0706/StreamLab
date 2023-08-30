<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create 'followers' table
        Schema::create('followers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('is_read')->default(false);
            $table->timestamps();
        });

        // Create 'subscribers' table
        Schema::create('subscribers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('subscription_tier');
            $table->boolean('is_read')->default(false);
            $table->timestamps();
        });

        // Create 'donations' table
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->decimal('amount', 10, 2);
            $table->string('currency');
            $table->text('donation_message')->nullable();
            $table->boolean('is_read')->default(false);
            $table->timestamps();
        });

        // Create 'merch_sales' table
        Schema::create('merch_sales', function (Blueprint $table) {
            $table->id();
            $table->string('item_name');
            $table->integer('amount');
            $table->decimal('price', 10, 2);
            $table->boolean('is_read')->default(false);
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
        // Drop tables
        Schema::dropIfExists('followers');
        Schema::dropIfExists('subscribers');
        Schema::dropIfExists('donations');
        Schema::dropIfExists('merch_sales');
    }
}
    