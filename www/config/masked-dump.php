<?php
/*
    Laravel Masked DB Dump Schema Definition
    see:    https://beyondco.de/docs/laravel-masked-db-dump/
            https://github.com/beyondcode/laravel-masked-db-dump

    1. Installa il package
        composer require beyondcode/laravel-masked-db-dump

    2. Pubblica la configurazione del package, così da poter configurare il tuo schema dump
        php artisan vendor:publish --provider=BeyondCode\\LaravelMaskedDumper\\LaravelMaskedDumpServiceProvider

    3. Questo creerà il file “config/masked-dump.php” contenente la definizione “predefinita” (default) del dump
        'default' => DumpSchema::define()
            ->allTables()
            ->table('users', function (TableDefinition $table) {
                $table->replace('name', function (Faker $faker) {
                    return $faker->name;
                });
                $table->replace('email', function (Faker $faker) {
                    return $faker->safeEmail;
                });
                $table->mask('password');
            })
            ->schemaOnly('failed_jobs')
            ->schemaOnly('password_resets')

    4. Esegui php artisan db:masked-dump output.sql per eseguire il dump delle tabelle specificate nella configurazione di default


    Per creare una nuova configurazione
    Chiamata, ad esempio, ‘tracking’

    1. Modifica la configurazione
        'tracking' => DumpSchema::define()
            ->table('tracking_sessions', function (TableDefinition $table) {})
            ->table('tracking_data', function (TableDefinition $table) {})

    2. Esegui il dump lanciando
        php artisan db:masked-dump output.sql --definition=tracking

    3. Per comprimere il dump, usa
        php artisan db:masked-dump output.sql --definition=tracking --gzip
*/
use BeyondCode\LaravelMaskedDumper\DumpSchema;
use BeyondCode\LaravelMaskedDumper\TableDefinitions\TableDefinition;
use Faker\Generator as Faker;

return [
    /**
     * Use this dump schema definition to remove, replace or mask certain parts of your database tables.
     */
    'tracking' => DumpSchema::define()
        ->table('tracking_sessions_export', function (TableDefinition $table) {})
        ->table('tracking_data_export', function (TableDefinition $table) {})
];
