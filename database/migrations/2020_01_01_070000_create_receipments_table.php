<?php

use HDSSolutions\Laravel\Blueprints\BaseBlueprint as Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateReceipmentsTable extends Migration {
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

        // create table
        $schema->create('receipments', function(Blueprint $table) {
            $table->id();
            $table->foreignTo('Company');
            $table->foreignTo('Employee');
            $table->morphable('partner');
            $table->foreignTo('Currency');
            $table->timestamp('transacted_at')->useCurrent();
            $table->string('document_number');
            $table->boolean('is_purchase')->default(false);
            // use table as document
            $table->asDocument();
        });

        // paid invoices table
        $schema->create('receipment_invoice', function(Blueprint $table) {
            $table->id();
            $table->foreignTo('Receipment');
            $table->foreignTo('Invoice');
            $table->unique([ 'receipment_id', 'invoice_id' ]);
            $table->amount('imputed_amount');
        });

        // payments table
        $schema->create('receipment_payment', function(Blueprint $table) {
            $table->id();
            $table->foreignTo('Receipment');
            $table->foreignTo('Currency');
            $table->morphable('payment');
            $table->unsignedInteger('conversion_rate')->nullable();
            $table->char('payment_type', 2);
            $table->amount('payment_amount');
            $table->amount('used_amount')->default(0);
            $table->foreignTo('CreditNote')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('receipment_payments');
        Schema::dropIfExists('receipment_invoices');
        Schema::dropIfExists('receipments');
    }

}
