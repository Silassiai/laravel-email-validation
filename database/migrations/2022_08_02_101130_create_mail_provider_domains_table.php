<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Silassiai\LaravelEmailValidation\Models\MailProviderDomain;

class CreateMailProviderDomainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mail_provider_domains', function (Blueprint $table) {
            $table->id();
            $table->string(MailProviderDomain::DOMAIN_NAME)->index()->unique();
            $table->jsonb(MailProviderDomain::TLD)->index()->nullable();
            $table->boolean(MailProviderDomain::POPULAR);
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
        Schema::dropIfExists('mail_provider_domains');
    }
}
