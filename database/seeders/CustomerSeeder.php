<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        $customers = [
            ['type' => 'company', 'first_name' => null, 'last_name' => null, 'full_name' => 'AGUILA COURIER SRL', 'company_name' => 'AGUILA COURIER SRL', 'document' => '80090859-6', 'phone' => '21234305', 'email' => 'cristian.lopez.py@gmail.com', 'created_at' => $now, 'updated_at' => $now],
            ['type' => 'company', 'first_name' => null, 'last_name' => null, 'full_name' => 'B.A.G. S.A.', 'company_name' => 'B.A.G. S.A.', 'document' => '80096858-1', 'phone' => '972146641', 'email' => 'bag.caaguazu@gmail.com', 'created_at' => $now, 'updated_at' => $now],
            ['type' => 'company', 'first_name' => null, 'last_name' => null, 'full_name' => 'CALVO CENDRA SA', 'company_name' => 'CALVO CENDRA SA', 'document' => '80007890-0', 'phone' => '212381705', 'email' => 'cacesa@gmail.com', 'created_at' => $now, 'updated_at' => $now],
            ['type' => 'company', 'first_name' => null, 'last_name' => null, 'full_name' => 'CASA IMPERAL S.A.', 'company_name' => 'CASA IMPERAL S.A.', 'document' => '80002212-2', 'phone' => '556991', 'email' => 'ventasimp@casaimperial.com.py', 'created_at' => $now, 'updated_at' => $now],
            ['type' => 'company', 'first_name' => null, 'last_name' => null, 'full_name' => 'CENTRONIC S.A', 'company_name' => 'CENTRONIC S.A', 'document' => '80099441-8', 'phone' => '21612512', 'email' => 'vet12@gmail.com', 'created_at' => $now, 'updated_at' => $now],
            ['type' => 'company', 'first_name' => null, 'last_name' => null, 'full_name' => 'CHACOMER SAECA', 'company_name' => 'CHACOMER SAECA', 'document' => '80013744-2', 'phone' => '21000000', 'email' => 'chacomer@gmail.com', 'created_at' => $now, 'updated_at' => $now],
            ['type' => 'company', 'first_name' => null, 'last_name' => null, 'full_name' => 'COMPAÑIA VETERINARIA DEL PARAGUAY S.A', 'company_name' => 'COMPAÑIA VETERINARIA DEL PARAGUAY S.A', 'document' => '80031026-8', 'phone' => '21503445', 'email' => 'bmolinas123@covepa.com', 'created_at' => $now, 'updated_at' => $now],
            ['type' => 'company', 'first_name' => null, 'last_name' => null, 'full_name' => 'CONSULT PEC SRL', 'company_name' => 'CONSULT PEC SRL', 'document' => '80008670-8', 'phone' => '21520609', 'email' => 'bio234@gmail.com', 'created_at' => $now, 'updated_at' => $now],
            ['type' => 'company', 'first_name' => null, 'last_name' => null, 'full_name' => 'COOP. DE PROD. AGR. NARANJAL LTDA', 'company_name' => 'COOP. DE PROD. AGR. NARANJAL LTDA', 'document' => '976320210', 'phone' => '976320210', 'email' => 'facturacionelectronica@copronar.com.py', 'created_at' => $now, 'updated_at' => $now],
            ['type' => 'company', 'first_name' => null, 'last_name' => null, 'full_name' => 'CRISTOBAL ADOLFO MORELL', 'company_name' => 'CRISTOBAL ADOLFO MORELL', 'document' => '3516979-6', 'phone' => '975122474', 'email' => 'morell.electric@gmail.com', 'created_at' => $now, 'updated_at' => $now],
            ['type' => 'company', 'first_name' => null, 'last_name' => null, 'full_name' => "DISTRISOL - PIRO'Y S.A.", 'company_name' => "DISTRISOL - PIRO'Y S.A.", 'document' => '80000505-8', 'phone' => '212492500', 'email' => 'facturacionglt@grupoluminotecnia.com', 'created_at' => $now, 'updated_at' => $now],
            ['type' => 'company', 'first_name' => null, 'last_name' => null, 'full_name' => 'ESMART  SRL', 'company_name' => 'ESMART  SRL', 'document' => '80062091-7', 'phone' => '21527077', 'email' => 'esmart20@gmail.com', 'created_at' => $now, 'updated_at' => $now],
            ['type' => 'company', 'first_name' => null, 'last_name' => null, 'full_name' => 'FERREMAT S.R.L.', 'company_name' => 'FERREMAT S.R.L.', 'document' => '80087175-8', 'phone' => '976450737', 'email' => 'ferremat924@gmail.com', 'created_at' => $now, 'updated_at' => $now],
            ['type' => 'company', 'first_name' => null, 'last_name' => null, 'full_name' => 'HUGUITO FERRETERIA S.R.L.', 'company_name' => 'HUGUITO FERRETERIA S.R.L.', 'document' => '80046898-8', 'phone' => '981542750', 'email' => 'hf.ferreteria@hotmail.com', 'created_at' => $now, 'updated_at' => $now],
            ['type' => 'company', 'first_name' => null, 'last_name' => null, 'full_name' => 'IMPORTADORA BOGGIANI', 'company_name' => 'IMPORTADORA BOGGIANI', 'document' => '80086897', 'phone' => '21515219', 'email' => 'adbf@gmail.com', 'created_at' => $now, 'updated_at' => $now],
            ['type' => 'company', 'first_name' => null, 'last_name' => null, 'full_name' => 'KAMO S.A', 'company_name' => 'KAMO S.A', 'document' => '80050425-9', 'phone' => '21521222', 'email' => 'kamo14@gamil.com', 'created_at' => $now, 'updated_at' => $now],
            ['type' => 'company', 'first_name' => null, 'last_name' => null, 'full_name' => 'MANGOPAR SRL', 'company_name' => 'MANGOPAR SRL', 'document' => '80019441-1', 'phone' => '21520511', 'email' => 'ventascde@mangopar.com', 'created_at' => $now, 'updated_at' => $now],
            ['type' => 'company', 'first_name' => null, 'last_name' => null, 'full_name' => 'MANUFACTURA DE PILAR S.A.', 'company_name' => 'MANUFACTURA DE PILAR S.A.', 'document' => '80002014-6', 'phone' => '985518204', 'email' => 'dpto.impositivo@palmas.com.py', 'created_at' => $now, 'updated_at' => $now],
            ['type' => 'company', 'first_name' => null, 'last_name' => null, 'full_name' => 'MARMO S.A.', 'company_name' => 'MARMO S.A.', 'document' => '80011811-1', 'phone' => '976320063', 'email' => 'marmonaranjal@hotmail.com', 'created_at' => $now, 'updated_at' => $now],
            ['type' => 'company', 'first_name' => null, 'last_name' => null, 'full_name' => 'MERCOTEC S.A.E', 'company_name' => 'MERCOTEC S.A.E', 'document' => '80021576-1', 'phone' => '212376555', 'email' => 'cgaleano@mercotec.com.py', 'created_at' => $now, 'updated_at' => $now],
            ['type' => 'company', 'first_name' => null, 'last_name' => null, 'full_name' => 'OLIMPIC S.A', 'company_name' => 'OLIMPIC S.A', 'document' => '80009960-2', 'phone' => '21300221', 'email' => 'casa102@gmail.com', 'created_at' => $now, 'updated_at' => $now],
            ['type' => 'company', 'first_name' => null, 'last_name' => null, 'full_name' => 'OPERACIONES', 'company_name' => 'OPERACIONES', 'document' => '80000505-8', 'phone' => '212492500', 'email' => 'facturacionglt@grupoluminotecnia.com', 'created_at' => $now, 'updated_at' => $now],
            ['type' => 'company', 'first_name' => null, 'last_name' => null, 'full_name' => 'PEREZ RAMIREZ', 'company_name' => 'PEREZ RAMIREZ', 'document' => '80002745-0', 'phone' => '21270495', 'email' => 'perez680@gmail.com', 'created_at' => $now, 'updated_at' => $now],
            ['type' => 'company', 'first_name' => null, 'last_name' => null, 'full_name' => 'PROVINDUS S A', 'company_name' => 'PROVINDUS S A', 'document' => '80010810-8', 'phone' => '21606343', 'email' => 'provindus@provindus.com.py', 'created_at' => $now, 'updated_at' => $now],
            ['type' => 'company', 'first_name' => null, 'last_name' => null, 'full_name' => 'R G S A', 'company_name' => 'R G S A', 'document' => '80014603-4', 'phone' => '984759887', 'email' => 'contabilidad1@rgsa.com.py', 'created_at' => $now, 'updated_at' => $now],
            ['type' => 'company', 'first_name' => null, 'last_name' => null, 'full_name' => 'REAL CENTER SRL', 'company_name' => 'REAL CENTER SRL', 'document' => '80011924-0', 'phone' => '21514160', 'email' => 'azure74@gmail.com', 'created_at' => $now, 'updated_at' => $now],
            ['type' => 'company', 'first_name' => null, 'last_name' => null, 'full_name' => 'SENCON', 'company_name' => 'SENCON', 'document' => '80002280-7', 'phone' => '215306069', 'email' => 'rio123@gmail.com', 'created_at' => $now, 'updated_at' => $now],
            ['type' => 'company', 'first_name' => null, 'last_name' => null, 'full_name' => 'SOL TINTAS S.A', 'company_name' => 'SOL TINTAS S.A', 'document' => '80028903-5', 'phone' => '21654957', 'email' => 'compras@soltintas.com.py', 'created_at' => $now, 'updated_at' => $now],
            ['type' => 'company', 'first_name' => null, 'last_name' => null, 'full_name' => 'SPORT GROUP S.A', 'company_name' => 'SPORT GROUP S.A', 'document' => '80051098-4', 'phone' => '212383388', 'email' => 'info@holdingsportgroup.com', 'created_at' => $now, 'updated_at' => $now],
            ['type' => 'company', 'first_name' => null, 'last_name' => null, 'full_name' => 'DISTRISOL - ESTE', 'company_name' => 'DISTRISOL - ESTE', 'document' => '80000505-8', 'phone' => '212492500', 'email' => 'facturacionglt@grupoluminotecnia.com', 'created_at' => $now, 'updated_at' => $now],
        ];

        DB::table('customers')->insert($customers);
    }
}
