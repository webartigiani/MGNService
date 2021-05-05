<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WorkersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('workers')->truncate();

        DB::table('workers')->insert([
            'codice_azienda' => 228,
            'denominazione_azienda' => 'MGN SOCIETA\' COOPERATIVA',
            'cognome' => 'BRANCHINI',
            'nome' => 'GIOVANNI MARIA',
            'codice_fiscale' => 'BRNGNN93D29Z222L',
            'data_assunzione' => '2019-01-02'
        ]);

        DB::table('workers')->insert([
            'codice_azienda' => 228,
            'denominazione_azienda' => 'MGN SOCIETA\' COOPERATIVA',
            'cognome' => 'ALBERTI',
            'nome' => 'LIDIA',
            'codice_fiscale' => 'LBRLDI66T50G643I',
            'data_assunzione' => '2019-02-01'
        ]);
        DB::table('workers')->insert([
            'codice_azienda' => 228,
            'denominazione_azienda' => 'MGN SOCIETA\' COOPERATIVA',
            'cognome' => 'BICOCCHI',
            'nome' => 'STEFANIA',
            'codice_fiscale' => 'BCCSFN65M43I191N',
            'data_assunzione' => '2021-02-04'
        ]);
        DB::table('workers')->insert([
            'codice_azienda' => 228,
            'denominazione_azienda' => 'MGN SOCIETA\' COOPERATIVA',
            'cognome' => 'BLAJ',
            'nome' => 'IRINA',
            'codice_fiscale' => 'BLJRNI87C42Z129J',
            'data_assunzione' => '2019-01-02'
        ]);
        DB::table('workers')->insert([
            'codice_azienda' => 228,
            'denominazione_azienda' => 'MGN SOCIETA\' COOPERATIVA',
            'cognome' => 'BONASONI',
            'nome' => 'SARA',
            'codice_fiscale' => 'BNSSRA81A42G467P',
            'data_assunzione' => '2019-01-02'
        ]);
        DB::table('workers')->insert([
            'codice_azienda' => 228,
            'denominazione_azienda' => 'MGN SOCIETA\' COOPERATIVA',
            'cognome' => 'BRANCHINI',
            'nome' => 'NEHA',
            'codice_fiscale' => 'BRNNHE92T48Z222M',
            'data_assunzione' => '2019-01-02'
        ]);
        DB::table('workers')->insert([
            'codice_azienda' => 228,
            'denominazione_azienda' => 'MGN SOCIETA\' COOPERATIVA',
            'cognome' => 'COLLARI',
            'nome' => 'ROBERTA',
            'codice_fiscale' => 'CLLRRT57C42C469G',
            'data_assunzione' => '2019-01-07'
        ]);
        DB::table('workers')->insert([
            'codice_azienda' => 228,
            'denominazione_azienda' => 'MGN SOCIETA\' COOPERATIVA',
            'cognome' => 'E. NACCAH',
            'nome' => 'ANNA',
            'codice_fiscale' => 'NCCNNA64T64I072Z',
            'data_assunzione' => '2019-01-02'
        ]);
        DB::table('workers')->insert([
            'codice_azienda' => 228,
            'denominazione_azienda' => 'MGN SOCIETA\' COOPERATIVA',
            'cognome' => 'GUERRA',
            'nome' => 'LORENZA',
            'codice_fiscale' => 'GRRLNZ74H68G467P',
            'data_assunzione' => '2019-01-02'
        ]);
        DB::table('workers')->insert([
            'codice_azienda' => 228,
            'denominazione_azienda' => 'MGN SOCIETA\' COOPERATIVA',
            'cognome' => 'LALOMIA',
            'nome' => 'LUCIANA',
            'codice_fiscale' => 'LLMLCN61M43A944L',
            'data_assunzione' => '2019-01-02'
        ]);
        DB::table('workers')->insert([
            'codice_azienda' => 228,
            'denominazione_azienda' => 'MGN SOCIETA\' COOPERATIVA',
            'cognome' => 'LUCCHETTI',
            'nome' => 'VALERIA',
            'codice_fiscale' => 'LCCVLR85A57D969V',
            'data_assunzione' => '2020-06-22'
        ]);
        DB::table('workers')->insert([
            'codice_azienda' => 228,
            'denominazione_azienda' => 'MGN SOCIETA\' COOPERATIVA',
            'cognome' => 'MUTO',
            'nome' => 'ROSA',
            'codice_fiscale' => 'MTURSO71S45E990W',
            'data_assunzione' => '2019-01-02',
            'data_cessazione' => '2021-01-22'
        ]);
        DB::table('workers')->insert([
            'codice_azienda' => 228,
            'denominazione_azienda' => 'MGN SOCIETA\' COOPERATIVA',
            'cognome' => 'MELLONI',
            'nome' => 'MONICA',
            'codice_fiscale' => 'MLLMNC71M52C469V',
            'data_assunzione' => '2020-03-01'
        ]);
        DB::table('workers')->insert([
            'codice_azienda' => 228,
            'denominazione_azienda' => 'MGN SOCIETA\' COOPERATIVA',
            'cognome' => 'MONTI',
            'nome' => 'CLAUDIA',
            'codice_fiscale' => 'MNTCLD67A64G467A',
            'data_assunzione' => '2019-01-02'
        ]);
        DB::table('workers')->insert([
            'codice_azienda' => 228,
            'denominazione_azienda' => 'MGN SOCIETA\' COOPERATIVA',
            'cognome' => 'PONCE GUARDARRAMOS',
            'nome' => 'DAYSY',
            'codice_fiscale' => 'PNCDSY68P68Z504C',
            'data_assunzione' => '2020-01-23',
            'data_cessazione' => '2021-01-31'
        ]);
        DB::table('workers')->insert([
            'codice_azienda' => 228,
            'denominazione_azienda' => 'MGN SOCIETA\' COOPERATIVA',
            'cognome' => 'ROSSI',
            'nome' => 'DORELLA',
            'codice_fiscale' => 'RSSDLL64H48G916C',
            'data_assunzione' => '2021-01-16'
        ]);
        DB::table('workers')->insert([
            'codice_azienda' => 228,
            'denominazione_azienda' => 'MGN SOCIETA\' COOPERATIVA',
            'cognome' => 'MUSOLINO',
            'nome' => 'GIUSEPPINA MARIA',
            'codice_fiscale' => 'MSLGPP67D62A676L',
            'data_assunzione' => '2020-11-19'
        ]);
        DB::table('workers')->insert([
            'codice_azienda' => 228,
            'denominazione_azienda' => 'MGN SOCIETA\' COOPERATIVA',
            'cognome' => 'POLIMARU',
            'nome' => 'MARIA',
            'codice_fiscale' => 'PLMMRA57S44Z140X',
            'data_assunzione' => '2019-01-02'
        ]);
        DB::table('workers')->insert([
            'codice_azienda' => 228,
            'denominazione_azienda' => 'MGN SOCIETA\' COOPERATIVA',
            'cognome' => 'SARTOR',
            'nome' => 'DANIELA',
            'codice_fiscale' => 'SRTDNL66E59G467P',
            'data_assunzione' => '2019-01-02'
        ]);
        DB::table('workers')->insert([
            'codice_azienda' => 228,
            'denominazione_azienda' => 'MGN SOCIETA\' COOPERATIVA',
            'cognome' => 'SOFFIETTO',
            'nome' => 'VITA',
            'codice_fiscale' => 'SFFVTI68T67G348N',
            'data_assunzione' => '2019-01-02'
        ]);
        DB::table('workers')->insert([
            'codice_azienda' => 228,
            'denominazione_azienda' => 'MGN SOCIETA\' COOPERATIVA',
            'cognome' => 'ZACCANTI',
            'nome' => 'SANDRA',
            'codice_fiscale' => 'ZCCSDR66B43G467M',
            'data_assunzione' => '2019-07-01'
        ]);
        DB::table('workers')->insert([
            'codice_azienda' => 228,
            'denominazione_azienda' => 'MGN SOCIETA\' COOPERATIVA',
            'cognome' => 'BALBONI',
            'nome' => 'TAMARA',
            'codice_fiscale' => 'BLBTMR72R52C469K',
            'data_assunzione' => '2021-03-09',
            'data_cessazione' => '2021-03-25'
        ]);
        DB::table('workers')->insert([
            'codice_azienda' => 228,
            'denominazione_azienda' => 'MGN SOCIETA\' COOPERATIVA',
            'cognome' => 'MARCHETTI',
            'nome' => 'SABRINA',
            'codice_fiscale' => 'MRCSRN69E59F257O',
            'data_assunzione' => '2019-11-13'
        ]);
        DB::table('workers')->insert([
            'codice_azienda' => 228,
            'denominazione_azienda' => 'MGN SOCIETA\' COOPERATIVA',
            'cognome' => 'BORGHI',
            'nome' => 'FABIOLA',
            'codice_fiscale' => 'BRGFBL64R59C469J',
            'data_assunzione' => '2021-04-06'
        ]);
        DB::table('workers')->insert([
            'codice_azienda' => 228,
            'denominazione_azienda' => 'MGN SOCIETA\' COOPERATIVA',
            'cognome' => 'ERRICO',
            'nome' => 'ANNA',
            'codice_fiscale' => 'RRCNNA62H48C561L',
            'data_assunzione' => '2021-04-21'
        ]);
    }
}
