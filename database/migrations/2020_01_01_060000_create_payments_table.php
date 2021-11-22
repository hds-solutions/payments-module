<?php

use HDSSolutions\Laravel\Blueprints\BaseBlueprint as Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        // get schema builder
        $schema = DB::getSchemaBuilder();

        // replace blueprint
        $schema->blueprintResolver(fn($table, $callback) => new Blueprint($table, $callback));

        // create main table
        $schema->create('payments', function(Blueprint $table) {
            $table->id();
            $table->foreignTo('Company');
            $table->foreignTo('Currency');
            $table->morphable('partner');
            $table->string('document_number');
            $table->timestamp('transacted_at')->useCurrent();
            $table->amount('payment_amount');
        });

        // create Credit table
        $schema->create('credits', function(Blueprint $table) {
            $table->foreignTo('Payment', 'id')->primary();
            $table->unsignedDecimal('interest')->default(0);
            $table->unsignedTinyInteger('dues')->default(1);
        });

        // create Check table
        $schema->create('checks', function(Blueprint $table) {
            $table->foreignTo('Payment', 'id')->primary();
            $table->foreignTo('Bank');
            $table->string('account_holder');
            $table->timestamp('due_date')->useCurrent();
            $table->boolean('is_deposited')->default(false);
            $table->foreignTo('BankAccount')->nullable();
            $table->boolean('is_cashed')->default(false);
            $table->foreignTo('Cash')->nullable();
            $table->boolean('is_paid')->default(false);
        });

        // create CreditNote table
        $schema->create('credit_notes', function(Blueprint $table) {
            $table->foreignTo('Payment', 'id')->primary();
            $table->morphable('document')->nullable();
            $table->string('description');
            $table->amount('used_amount')->default(0);
            $table->boolean('is_used')->default(false);
            $table->boolean('is_paid')->default(false);
        });

        // create PromissoryNote table
        $schema->create('promissory_notes', function(Blueprint $table) {
            $table->foreignTo('Payment', 'id')->primary();
            $table->timestamp('due_date')->useCurrent();
            $table->boolean('is_paid')->default(false);
        });

        // create Card table
        $schema->create('cards', function(Blueprint $table) {
            $table->foreignTo('Payment', 'id')->primary();
            $table->string('card_holder')->nullable();
            $table->string('is_credit')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('promissory_notes');
        Schema::dropIfExists('credit_notes');
        Schema::dropIfExists('checks');
        Schema::dropIfExists('credits');
        Schema::dropIfExists('payments');
    }

}
