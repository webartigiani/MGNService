<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GiustificativiTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('giustificativi')->truncate();


        DB::table('giustificativi')->insert([
            'code' => 'A1',
            'description' => 'Assegno Ordinario (AOR)',
            'item' => '',
            'ref_code' => 'A1',
            'inclusion' => 'Si'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'A2',
            'description' => 'Assegno solid./ord.CDS (ASR)',
            'item' => '',
            'ref_code' => 'A2',
            'inclusion' => 'Si'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'A3',
            'description' => 'Cig in deroga',
            'item' => '',
            'ref_code' => 'A3',
            'inclusion' => 'Si'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'A4',
            'description' => 'Quarantena sorv.attiva COVID19',
            'item' => '',
            'ref_code' => 'MA',
            'inclusion' => 'Si'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'A5',
            'description' => 'Assenza aut. sanitarie COVID19',
            'item' => '',
            'ref_code' => 'MA',
            'inclusion' => 'Si'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'A6',
            'description' => 'CIGO pagamento diretto',
            'item' => '',
            'ref_code' => 'A3',
            'inclusion' => 'Si'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'A7',
            'description' => 'Cong.genit.figli disab.COVID19',
            'item' => '',
            'ref_code' => 'A7',
            'inclusion' => 'Si'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'A8',
            'description' => 'Congedo genitor.retrib.COVID19',
            'item' => '',
            'ref_code' => 'A8',
            'inclusion' => 'Si'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'A9',
            'description' => 'Congedo genit.non retr.COVID19',
            'item' => '',
            'ref_code' => 'A9',
            'inclusion' => 'Si'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'AH',
            'description' => 'Assenza assunti/dimessi',
            'item' => '',
            'ref_code' => 'AH',
            'inclusion' => 'Si'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'AI',
            'description' => 'Assenza ingiustificata',
            'item' => '',
            'ref_code' => 'AI',
            'inclusion' => 'Si'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'AL',
            'description' => 'Allattamento',
            'item' => '',
            'ref_code' => 'AL',
            'inclusion' => 'Si'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'AO',
            'description' => 'Assenza Operazione Societaria',
            'item' => '',
            'ref_code' => 'AI',
            'inclusion' => 'Si'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'AP',
            'description' => 'Aspettativa non retribuita',
            'item' => '',
            'ref_code' => 'AP',
            'inclusion' => 'Si'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'AR',
            'description' => 'Aspettativa Retribuita',
            'item' => '',
            'ref_code' => 'AR',
            'inclusion' => 'Si'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'AS',
            'description' => 'Assemblea sindacale',
            'item' => '',
            'ref_code' => 'AS',
            'inclusion' => 'Si'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'B1',
            'description' => 'BANCA ORE MATURATA',
            'item' => '',
            'ref_code' => '',
            'inclusion' => 'No'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'BO',
            'description' => 'Permessi banca ore goduti',
            'item' => '',
            'ref_code' => 'BO',
            'inclusion' => 'Si'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'C1',
            'description' => 'Solidarietà antic.DLgs.148/15',
            'item' => '',
            'ref_code' => 'C1',
            'inclusion' => 'Si'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'C2',
            'description' => 'Solidarietà autor.DLgs.148/15',
            'item' => '',
            'ref_code' => 'C2',
            'inclusion' => 'Si'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'C3',
            'description' => 'Cig autorizz.post D.Lgs.148/15',
            'item' => '',
            'ref_code' => 'C3',
            'inclusion' => 'Si'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'C4',
            'description' => 'CIG EDILI/LAPID.x maltempo ant',
            'item' => '',
            'ref_code' => 'C4',
            'inclusion' => 'Si'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'C5',
            'description' => 'CIG EDILI/LAPID.x maltempo aut',
            'item' => '',
            'ref_code' => 'C5',
            'inclusion' => 'Si'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'C6',
            'description' => 'Solidarietà anticipata',
            'item' => '',
            'ref_code' => 'C6',
            'inclusion' => 'Si'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'C7',
            'description' => 'Solidarietà autorizzata',
            'item' => '',
            'ref_code' => 'C7',
            'inclusion' => 'Si'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'C8',
            'description' => 'CIG ant. per maltempo (edili)',
            'item' => '',
            'ref_code' => 'C4',
            'inclusion' => 'Si'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'C9',
            'description' => 'CIG aut. per maltempo (edili)',
            'item' => '',
            'ref_code' => 'C5',
            'inclusion' => 'Si'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'CA',
            'description' => 'CIG anticipata',
            'item' => '',
            'ref_code' => 'CA',
            'inclusion' => 'Si'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'CB',
            'description' => 'CIG autorizzata (si ctr.add.)',
            'item' => '',
            'ref_code' => 'CB',
            'inclusion' => 'Si'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'CC',
            'description' => 'CIG autorizzata (no ctr.add.)',
            'item' => '',
            'ref_code' => 'CC',
            'inclusion' => 'Si'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'CD',
            'description' => 'Congedi straordinari disabili',
            'item' => '',
            'ref_code' => 'CD',
            'inclusion' => 'Si'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'CF',
            'description' => 'Congedo facoltativo padre',
            'item' => '',
            'ref_code' => 'CF',
            'inclusion' => 'Si'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'CI',
            'description' => 'CIG non retribuita',
            'item' => '',
            'ref_code' => 'CI',
            'inclusion' => 'Si'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'CM',
            'description' => 'Congedo matrimoniale',
            'item' => '',
            'ref_code' => 'CM',
            'inclusion' => 'Si'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'CO',
            'description' => 'CIG IN DEROGA CARICO INPS',
            'item' => '',
            'ref_code' => 'CO',
            'inclusion' => 'Si'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'CP',
            'description' => 'Congedo obbligatorio del padre',
            'item' => '',
            'ref_code' => 'CP',
            'inclusion' => 'Si'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'CV',
            'description' => 'Perm. non retrib. Ctr virtuale',
            'item' => '',
            'ref_code' => 'CV',
            'inclusion' => 'Si'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'CY',
            'description' => 'Morbo Cooley',
            'item' => '',
            'ref_code' => 'MA',
            'inclusion' => 'Si'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'D1',
            'description' => 'Donazione Sangue Inidoneità',
            'item' => '',
            'ref_code' => 'D1',
            'inclusion' => 'Si'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'D2',
            'description' => 'Permessi disabili gg COVID19',
            'item' => '',
            'ref_code' => 'D2',
            'inclusion' => 'Si'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'D3',
            'description' => 'Per.disabili fruiti hh-COVID19',
            'item' => '',
            'ref_code' => 'D3',
            'inclusion' => 'Si'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'DM',
            'description' => 'Donazione midollo osseo',
            'item' => '',
            'ref_code' => 'DM',
            'inclusion' => 'Si'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'DS',
            'description' => 'Donazione sangue',
            'item' => '',
            'ref_code' => 'DS',
            'inclusion' => 'Si'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'E1',
            'description' => 'ORE EBER ANTICIP. 10%',
            'item' => '',
            'ref_code' => 'E1',
            'inclusion' => 'Si'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'E5',
            'description' => 'ORE EBER ANTICIP.50%',
            'item' => '',
            'ref_code' => 'E5',
            'inclusion' => 'Si'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'E6',
            'description' => 'ORE EBER ANTICIP. 60%',
            'item' => '',
            'ref_code' => 'E6',
            'inclusion' => 'Si'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'EM',
            'description' => 'Emodialisi',
            'item' => '',
            'ref_code' => 'MA',
            'inclusion' => 'Si'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'F1',
            'description' => 'Flessibilità Tipo 1',
            'item' => '',
            'ref_code' => '',
            'inclusion' => 'No'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'F2',
            'description' => 'Flessibilità Tipo 2',
            'item' => '',
            'ref_code' => '',
            'inclusion' => 'No'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'F3',
            'description' => 'Flessibilità Tipo 3',
            'item' => '',
            'ref_code' => '',
            'inclusion' => 'No'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'F4',
            'description' => 'Flessibilità senza maggioraz.',
            'item' => '',
            'ref_code' => '',
            'inclusion' => 'No'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'F6',
            'description' => 'Ferie solidarietà anticipata',
            'item' => '',
            'ref_code' => 'F6',
            'inclusion' => 'Si'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'F7',
            'description' => 'Ferie solidarietà autorizzata',
            'item' => '',
            'ref_code' => 'F7',
            'inclusion' => 'Si'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'FE',
            'description' => 'Ferie',
            'item' => '',
            'ref_code' => 'FE',
            'inclusion' => 'Si'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'FG',
            'description' => 'Flessibilità godute',
            'item' => '',
            'ref_code' => 'FG',
            'inclusion' => 'Si'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'FO',
            'description' => 'Corso Formazione Apprendisti',
            'item' => '',
            'ref_code' => 'FO',
            'inclusion' => 'Si'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'FR',
            'description' => 'Matern.facolt.retribuita (MB2)',
            'item' => '',
            'ref_code' => 'FR',
            'inclusion' => 'Si'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'FS',
            'description' => 'Lavoro Festivo',
            'item' => '000452',
            'ref_code' => '',
            'inclusion' => 'No'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'GO',
            'description' => 'Giornata ad orario ridotto-GOR',
            'item' => '',
            'ref_code' => 'GO',
            'inclusion' => 'Si'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'IN',
            'description' => 'Infortunio',
            'item' => '',
            'ref_code' => 'IN',
            'inclusion' => 'Si'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'LA',
            'description' => 'Lav.Domenicale 40% Alim.Artig.',
            'item' => '000199',
            'ref_code' => '',
            'inclusion' => 'No'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'LD',
            'description' => 'Lavoro Domenicale Pubblici',
            'item' => '000277',
            'ref_code' => '',
            'inclusion' => 'No'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'LF',
            'description' => 'Lavoro straordinario festivo',
            'item' => '000450',
            'ref_code' => '',
            'inclusion' => 'No'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'LN',
            'description' => 'Lavoro Notturno',
            'item' => '000070',
            'ref_code' => '',
            'inclusion' => 'No'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'LS',
            'description' => 'Supplementare diurno',
            'item' => '',
            'ref_code' => '',
            'inclusion' => 'No'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'LT',
            'description' => 'Lavoro Domenicale Terz.',
            'item' => 'ZP9986',
            'ref_code' => '',
            'inclusion' => 'No'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'LZ',
            'description' => 'Maggiorazione Fest.60%',
            'item' => '000008',
            'ref_code' => '',
            'inclusion' => 'No'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'M1',
            'description' => 'Perm.retr. per MA bimbo < 3a',
            'item' => '',
            'ref_code' => 'M1',
            'inclusion' => 'Si'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'M3',
            'description' => 'Mal. bambino < 3 anni (MA3)',
            'item' => '',
            'ref_code' => 'MB',
            'inclusion' => 'Si'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'M4',
            'description' => 'Prolung. MF fino 3a/Hand (MA4)',
            'item' => '',
            'ref_code' => 'M4',
            'inclusion' => 'Si'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'M5',
            'description' => 'Maternità facolt. a ore (MA0)',
            'item' => '',
            'ref_code' => 'M5',
            'inclusion' => 'Si'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'M6',
            'description' => 'Mat. fac. a ore non retr.(MB0)',
            'item' => '',
            'ref_code' => 'M6',
            'inclusion' => 'Si'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'MA',
            'description' => 'Malattia',
            'item' => '',
            'ref_code' => 'MA',
            'inclusion' => 'Si'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'MB',
            'description' => 'Mal. bambino > 3 anni (MB4)',
            'item' => '',
            'ref_code' => 'MB',
            'inclusion' => 'Si'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'MC',
            'description' => 'Mancata certificaz. malattia',
            'item' => '',
            'ref_code' => 'MC',
            'inclusion' => 'Si'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'MF',
            'description' => 'Maternità facoltativa (MA2)',
            'item' => '',
            'ref_code' => 'MF',
            'inclusion' => 'Si'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'MI',
            'description' => 'Militare',
            'item' => '',
            'ref_code' => 'MI',
            'inclusion' => 'Si'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'MM',
            'description' => 'Malattia non conta per malus',
            'item' => '',
            'ref_code' => 'MA',
            'inclusion' => 'Si'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'MN',
            'description' => 'Mat. fac. non retribuita (MB2)',
            'item' => '',
            'ref_code' => 'MN',
            'inclusion' => 'Si'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'MO',
            'description' => 'Malattia ospedaliera',
            'item' => '',
            'ref_code' => 'MA',
            'inclusion' => 'Si'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'MP',
            'description' => 'Malattia breve',
            'item' => '',
            'ref_code' => 'MP',
            'inclusion' => 'Si'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'MR',
            'description' => 'Mancata certific.ricaduta mal.',
            'item' => '',
            'ref_code' => 'MC',
            'inclusion' => 'Si'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'MT',
            'description' => 'Maternità obbligatoria',
            'item' => '',
            'ref_code' => 'MT',
            'inclusion' => 'Si'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'MX',
            'description' => 'Malattia no trattam. speciale',
            'item' => '',
            'ref_code' => 'MA',
            'inclusion' => 'Si'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'NF',
            'description' => 'e',
            'item' => '',
            'ref_code' => '',
            'inclusion' => 'Si'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'NO',
            'description' => 'Magg.notturna 25%',
            'item' => '000279',
            'ref_code' => '',
            'inclusion' => 'No'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'P1',
            'description' => 'Permessi studio',
            'item' => '',
            'ref_code' => 'P1',
            'inclusion' => 'Si'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'P2',
            'description' => 'Permessi per esami',
            'item' => '',
            'ref_code' => 'P2',
            'inclusion' => 'Si'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'P3',
            'description' => 'Permessi corsi di formazione',
            'item' => '',
            'ref_code' => 'P3',
            'inclusion' => 'Si'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'P6',
            'description' => 'PF solidarietà anticipata',
            'item' => '',
            'ref_code' => 'P6',
            'inclusion' => 'Si'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'P7',
            'description' => 'PF solidarietà autorizzata',
            'item' => '',
            'ref_code' => 'P7',
            'inclusion' => 'Si'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'PC',
            'description' => 'Permessi L.104/92 COVID-19',
            'item' => '',
            'ref_code' => 'PC',
            'inclusion' => 'Si'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'PD',
            'description' => 'Permessi disabili edili',
            'item' => '',
            'ref_code' => 'PD',
            'inclusion' => 'Si'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'PE',
            'description' => 'Permesso elettorale',
            'item' => '',
            'ref_code' => 'PE',
            'inclusion' => 'Si'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'PF',
            'description' => 'Permessi ex festività',
            'item' => '',
            'ref_code' => 'PF',
            'inclusion' => 'Si'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'PG',
            'description' => 'Permessi disabili a giorni',
            'item' => '',
            'ref_code' => 'PG',
            'inclusion' => 'Si'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'PH',
            'description' => 'Permessi disabili a ore',
            'item' => '',
            'ref_code' => 'PH',
            'inclusion' => 'Si'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'PL',
            'description' => 'Permessi lutto',
            'item' => '',
            'ref_code' => 'PL',
            'inclusion' => 'Si'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'PN',
            'description' => 'Permessi non retribuiti',
            'item' => '',
            'ref_code' => 'PN',
            'inclusion' => 'Si'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'PR',
            'description' => 'Permessi retribuiti',
            'item' => '',
            'ref_code' => 'PR',
            'inclusion' => 'Si'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'PS',
            'description' => 'Permesso sindacale',
            'item' => '',
            'ref_code' => 'PS',
            'inclusion' => 'Si'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'R6',
            'description' => 'ROL solidarietà anticipata',
            'item' => '',
            'ref_code' => 'R6',
            'inclusion' => 'Si'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'R7',
            'description' => 'ROL solidarietà autorizzata',
            'item' => '',
            'ref_code' => 'R7',
            'inclusion' => 'Si'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'RA',
            'description' => 'Riposo Compensativo',
            'item' => '',
            'ref_code' => 'RA',
            'inclusion' => 'Si'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'RC',
            'description' => 'Rid.orario di lavoro di cong.',
            'item' => '',
            'ref_code' => 'RC',
            'inclusion' => 'Si'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'RI',
            'description' => 'Ricaduta infortunio',
            'item' => '',
            'ref_code' => 'IN',
            'inclusion' => 'Si'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'RL',
            'description' => 'Riduzione orario di lavoro',
            'item' => '',
            'ref_code' => 'RL',
            'inclusion' => 'Si'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'RM',
            'description' => 'Ricaduta malattia',
            'item' => '',
            'ref_code' => 'MA',
            'inclusion' => 'Si'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'RO',
            'description' => 'Ricaduta malattia ospedale',
            'item' => '',
            'ref_code' => 'MA',
            'inclusion' => 'Si'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'S1',
            'description' => 'Straordinario 20%',
            'item' => 'Z40020',
            'ref_code' => '',
            'inclusion' => 'No'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'S2',
            'description' => 'Straord. porte aperte feriale',
            'item' => 'Z40050',
            'ref_code' => '',
            'inclusion' => 'No'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'S3',
            'description' => 'Straord. porte chiuse feriale',
            'item' => '',
            'ref_code' => '',
            'inclusion' => 'No'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'S4',
            'description' => 'Straord. porte aperte festivo',
            'item' => 'Z40075',
            'ref_code' => '',
            'inclusion' => 'No'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'S5',
            'description' => 'Straord. porte chiuse festivo',
            'item' => 'Z40055',
            'ref_code' => '',
            'inclusion' => 'No'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'SC',
            'description' => 'Sciopero',
            'item' => '',
            'ref_code' => 'SC',
            'inclusion' => 'Si'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'SD',
            'description' => 'Sospensione disciplinare',
            'item' => '',
            'ref_code' => 'SD',
            'inclusion' => 'Si'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'SF',
            'description' => 'SemiFestività',
            'item' => '',
            'ref_code' => 'SF',
            'inclusion' => 'Si'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'SN',
            'description' => 'Straordinario notturno',
            'item' => '',
            'ref_code' => '',
            'inclusion' => 'No'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'SO',
            'description' => 'Sospensione',
            'item' => '',
            'ref_code' => 'SO',
            'inclusion' => 'Si'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'ST',
            'description' => 'Straordinario diurno',
            'item' => '',
            'ref_code' => '',
            'inclusion' => 'No'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'SW',
            'description' => 'Smart working',
            'item' => '',
            'ref_code' => '',
            'inclusion' => 'Si'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'TB',
            'description' => 'Malattia TBC',
            'item' => '',
            'ref_code' => 'MA',
            'inclusion' => 'Si'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'V1',
            'description' => 'Volontariato Protezione Civile',
            'item' => '',
            'ref_code' => 'V1',
            'inclusion' => 'Si'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'V6',
            'description' => 'Assegno ordinar. pagam.diretto',
            'item' => '',
            'ref_code' => 'A3',
            'inclusion' => 'Si'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'V9',
            'description' => 'Congedo quarant.figli DL111/20',
            'item' => '',
            'ref_code' => 'V9',
            'inclusion' => 'Si'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'VM',
            'description' => 'Permessi per visita medica',
            'item' => '',
            'ref_code' => 'VM',
            'inclusion' => 'Si'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'VO',
            'description' => 'Cong. vittime viol.a ore (DVO)',
            'item' => '',
            'ref_code' => 'VO',
            'inclusion' => 'Si'
        ]);
        DB::table('giustificativi')->insert([
            'code' => 'VV',
            'description' => 'Cong. vittime violenza (DVV)',
            'item' => '',
            'ref_code' => 'VV',
            'inclusion' => 'Si'
          ]);
    }
}
