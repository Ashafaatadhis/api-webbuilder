<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $users = [
            [
                "role" => "store_owner",
                "username" => "AnnyMul",
                "password" => Hash::make("GDFGHGC4#"),
                "email" => "mulya_anny@yahoo.com"
            ],
            [
                "role" => "store_owner",
                "username" => "AriantiMega",
                "password" => Hash::make("IJDJDNBD#"),
                "email" => "megasariarianti@gmail.com"
            ],
            [
                "role" => "store_owner",
                "username" => "CheTa",
                "password" => Hash::make("CHRIS412!"),
                "email" => "chanieyrini@gmail.com"
            ],
            [
                "role" => "store_owner",
                "username" => "DewiAndriani",
                "password" => Hash::make("HBDJENOE#"),
                "email" => "hazelsfood45@gmail.com"
            ],
            [
                "role" => "store_owner",
                "username" => "dewita",
                "password" => Hash::make("dewita123#"),
                "email" => "dewita.rachmajani@gmail.com"
            ],
            [
                "role" => "store_owner",
                "username" => "DiniWindu",
                "password" => Hash::make("Mbreb331#"),
                "email" => "mbrebesmilifood@gmail.com"
            ],
            [
                "role" => "store_owner",
                "username" => "DjokoMul",
                "password" => Hash::make("HBBCN$20#"),
                "email" => "djokimul@gmail.com"
            ],
            [
                "role" => "store_owner",
                "username" => "EkaEty",
                "password" => Hash::make("JBCKJ$#30"),
                "email" => "etyeka74@gmail.com"
            ],
            [
                "role" => "store_owner",
                "username" => "elizakitchen",
                "password" => Hash::make("Elizk507!"),
                "email" => "eliza.rizal24@gmail.com"
            ],
            [
                "role" => "store_owner",
                "username" => "ElsiRosa",
                "password" => Hash::make("HGVBGCKB#"),
                "email" => "bunda.elsi@gmail.com"
            ],
            [
                "role" => "store_owner",
                "username" => "encum",
                "password" => Hash::make("Sumar211!"),
                "email" => "Encumbunda4@gmail.com"
            ],
            [
                "role" => "store_owner",
                "username" => "EndenNell",
                "password" => Hash::make("Dapur323#"),
                "email" => "enden.nelly.anggraeni@gmail.com"
            ],
            [
                "role" => "store_owner",
                "username" => "EstiArimbhi",
                "password" => Hash::make("GYBVGBJK#"),
                "email" => "earimbhi@gmail.com"
            ],
            [
                "role" => "store_owner",
                "username" => "Febriyanti",
                "password" => Hash::make("Renda321#"),
                "email" => "febriyanti1967@gmail.com"
            ],
            [
                "role" => "store_owner",
                "username" => "FitriaMartha",
                "password" => Hash::make("Caesa431#"),
                "email" => "fitriamartha1980@gmail.com"
            ],
            [
                "role" => "store_owner",
                "username" => "Hafizh",
                "password" => Hash::make("Ngatm823!"),
                "email" => "Ngatmini1602@gmail.com"
            ],
            [
                "role" => "store_owner",
                "username" => "IcutNad",
                "password" => Hash::make("momicut123#"),
                "email" => "Momicutproduk@gmail.com"
            ],
            [
                "role" => "store_owner",
                "username" => "IdaZubaed",
                "password" => Hash::make("Iwaku134#"),
                "email" => "ida.iwakula@gmail.com"
            ],
            [
                "role" => "store_owner",
                "username" => "IlmaPagia",
                "password" => Hash::make("Olaha424#"),
                "email" => "olahansehathawa17@gmail.com"
            ],
            [
                "role" => "store_owner",
                "username" => "Itanur",
                "password" => Hash::make("Ellarasah123#"),
                "email" => "ellasarah24@gmail.com"
            ],
            [
                "role" => "store_owner",
                "username" => "JundaHerlita",
                "password" => Hash::make("Arbas243#"),
                "email" => "Arbaacookies@gmail.com"
            ],
            [
                "role" => "store_owner",
                "username" => "kartilawati",
                "password" => Hash::make("kartila123#"),
                "email" => "tkartila@gmail.com"
            ],
            [
                "role" => "store_owner",
                "username" => "Kerupu",
                "password" => Hash::make("Roza751!"),
                "email" => "Zufarullahdesember86@gmail.com"
            ],
            [
                "role" => "store_owner",
                "username" => "KusdaHerdi",
                "password" => Hash::make("YGVS342Q#"),
                "email" => "kusdayanti.herdiyani@gmail.com"
            ],
            [
                "role" => "store_owner",
                "username" => "LCUP",
                "password" => Hash::make("Luthf416!"),
                "email" => "Luthfiaziadati.husna@gmail.com"
            ],
            [
                "role" => "store_owner",
                "username" => "leniMarya",
                "password" => Hash::make("kelapa23!"),
                "email" => "lenimaryat1221@gmail.com"
            ],
            [
                "role" => "store_owner",
                "username" => "linamarliana",
                "password" => Hash::make("marliana123#"),
                "email" => "Lina.marliana25@gmail.com"
            ],
            [
                "role" => "store_owner",
                "username" => "LindaYuni",
                "password" => Hash::make("JSJBHIMD#"),
                "email" => "lindayy.lyy@gmail.com"
            ],
            [
                "role" => "store_owner",
                "username" => "MilaKarmila",
                "password" => Hash::make("HBDI$28#J"),
                "email" => "mielz_prima@yahoo.com"
            ],
            [
                "role" => "store_owner",
                "username" => "NinaHanda",
                "password" => Hash::make("YCYGKYFV#"),
                "email" => "ninarajacakecokies@gmail.com"
            ],
            [
                "role" => "store_owner",
                "username" => "NuraNovi",
                "password" => Hash::make("HDNDN455#"),
                "email" => "mimibakoel@gmail.com"
            ],
            [
                "role" => "store_owner",
                "username" => "NurAsiah",
                "password" => Hash::make("JKBJHNH3#"),
                "email" => "aat.130776@gmail.com"
            ],
            [
                "role" => "store_owner",
                "username" => "Nurhas",
                "password" => Hash::make("hasanah123#"),
                "email" => "nurhasanahsyatirih@gmail.com"
            ],
            [
                "role" => "store_owner",
                "username" => "NurHasanah",
                "password" => Hash::make("JJNDBJDJ#"),
                "email" => "nur3477278@gmail.com"
            ],
            [
                "role" => "store_owner",
                "username" => "PrasetyatiniKunti",
                "password" => Hash::make("Dodol412#"),
                "email" => "pkunti1972@gmail.com"
            ],
            [
                "role" => "store_owner",
                "username" => "PujiAstuti",
                "password" => Hash::make("JHUIWEFH#"),
                "email" => "bdujiran@gmail.com"
            ],
            [
                "role" => "store_owner",
                "username" => "RianitaHis",
                "password" => Hash::make("Momca231#"),
                "email" => "momcaofficial@gmail.com"
            ],
            [
                "role" => "store_owner",
                "username" => "RumaniHastuti",
                "password" => Hash::make("DJNKDN3U#"),
                "email" => "hastuti8rumani@gmail.com"
            ],
            [
                "role" => "store_owner",
                "username" => "Rusdianah",
                "password" => Hash::make("IJDNDOKS#"),
                "email" => "rumahlapislegitbunda@gmail.com"
            ],
            [
                "role" => "store_owner",
                "username" => "Sainah",
                "password" => Hash::make("VBGVV46V#"),
                "email" => "Sainahefendi977@mail.com"
            ],
            [
                "role" => "store_owner",
                "username" => "Sansan",
                "password" => Hash::make("Sanid350!"),
                "email" => "koreasansan99@gmail.com"
            ],
            [
                "role" => "store_owner",
                "username" => "Sarwati",
                "password" => Hash::make("UHDBIO23#"),
                "email" => "wati09020@gmail.com"
            ],
            [
                "role" => "store_owner",
                "username" => "SelviaMaryanti",
                "password" => Hash::make("HBCDNCNE#"),
                "email" => "ic.hakasecorp@gmail.com"
            ],
            [
                "role" => "store_owner",
                "username" => "Sugasa",
                "password" => Hash::make("Nurha412!"),
                "email" => "healthyturath@gmail.com"
            ],
            [
                "role" => "store_owner",
                "username" => "suparmi",
                "password" => Hash::make("dapurmia23!"),
                "email" => "amisuparmi05@gmail.com"
            ],
            [
                "role" => "store_owner",
                "username" => "SushiB",
                "password" => Hash::make("Indri343!"),
                "email" => "indri.hapsari85@gmail.com"
            ],
            [
                "role" => "store_owner",
                "username" => "Syofni",
                "password" => Hash::make("JBFVIHBR#"),
                "email" => "syofnisyahrial23@gmail.com"
            ],
            [
                "role" => "store_owner",
                "username" => "TitiIsnani",
                "password" => Hash::make("AYAMK424#"),
                "email" => "titi.isnani@gmail.com"
            ],
            [
                "role" => "store_owner",
                "username" => "ZentikaMaodi",
                "password" => Hash::make("tahub312#"),
                "email" => "zentikamaodi@yahoo.co.id"
            ]
        ];
        foreach ($users as $user) {
            User::create($user);
        }
        // User::create([
        //     'username' => 'jidan',
        //     'email' => 'jidan@gmail.com',
        //     "password" => Hash::make(Hash::make()"jidan123"),
        // ]);
        // User::create([
        //     'username' => 'admin',
        //     'email' => 'admin@gmail.com',
        //     "password" => Hash::make(Hash::make()"admin123"),
        //     "role" => "administrator"
        // ]);
    }
}
