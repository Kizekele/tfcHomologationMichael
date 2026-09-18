<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $now = Carbon::now();

        $faculteIds = [];
        foreach (['Polytechnique', 'Droit', 'Économie'] as $nom) {
            $faculteIds[$nom] = DB::table('faculte')->insertGetId([
                'nom_faculte' => $nom,
                'created_at' => $now,
                'updated_at' => $now,
            ], 'id_faculte');
        }

        $anneeIds = [];
        foreach (['2024-2025', '2025-2026'] as $libelle) {
            $anneeIds[$libelle] = DB::table('anneeacad')->insertGetId([
                'libelle' => $libelle,
                'created_at' => $now,
                'updated_at' => $now,
            ], 'id_anneeacad');
        }

        $promotions = [
            ['fac' => 'Polytechnique', 'nom' => 'G1 Informatique', 'count' => 160, 'years' => ['2024-2025', '2025-2026']],
            ['fac' => 'Polytechnique', 'nom' => 'G2 Informatique', 'count' => 157, 'years' => ['2024-2025', '2025-2026']],
            ['fac' => 'Polytechnique', 'nom' => 'G3 Informatique', 'count' => 133, 'years' => ['2025-2026']],
            ['fac' => 'Droit', 'nom' => 'L1 Droit', 'count' => 160, 'years' => ['2024-2025', '2025-2026']],
            ['fac' => 'Droit', 'nom' => 'L2 Droit Public', 'count' => 160, 'years' => ['2024-2025', '2025-2026']],
            ['fac' => 'Économie', 'nom' => 'L1 Comptabilité', 'count' => 240, 'years' => ['2024-2025', '2025-2026']],
            ['fac' => 'Économie', 'nom' => 'G3 Gestion', 'count' => 235, 'years' => ['2024-2025', '2025-2026']],
        ];

        $promotionIds = [];
        foreach ($promotions as $promo) {
            $id = DB::table('promotion')->insertGetId([
                'nom_promotion' => $promo['nom'],
                'cycle' => 'Licence',
                'id_faculte' => $faculteIds[$promo['fac']],
                'created_at' => $now,
                'updated_at' => $now,
            ], 'id_promotion');
            $promotionIds[$promo['nom']] = $id;

            foreach ($promo['years'] as $year) {
                DB::table('concerner')->insert([
                    'id_promotion' => $id,
                    'id_anneeacad' => $anneeIds[$year],
                ]);
            }
        }

        [$etudiants, $featured] = $this->buildEtudiants($promotions, $promotionIds, $now);
        foreach (array_chunk($etudiants, 200) as $chunk) {
            DB::table('etudiant')->insert($chunk);
        }

        $agents = [
            ['matricule_agent' => 'AG-001', 'nom_agent' => 'Michel Banza', 'email' => 'admin@esu.cd', 'password' => bcrypt('password'), 'role' => 'admin', 'fonction_agent' => 'Secrétaire Général Académique', 'telephone_agent' => '+243 810 111 222'],
            ['matricule_agent' => 'AG-002', 'nom_agent' => 'Chantal Muyumba', 'email' => 'chantal.muyumba@esu.cd', 'password' => bcrypt('password'), 'role' => 'agent', 'fonction_agent' => 'Chef de Bureau', 'telephone_agent' => '+243 810 222 333'],
            ['matricule_agent' => 'AG-003', 'nom_agent' => 'Fiston Lukusa', 'email' => 'fiston.lukusa@esu.cd', 'password' => bcrypt('password'), 'role' => 'agent', 'fonction_agent' => 'Agent de liaison', 'telephone_agent' => '+243 810 333 444'],
            ['matricule_agent' => 'AG-004', 'nom_agent' => 'Bernadette Kasongo', 'email' => 'bernadette.kasongo@esu.cd', 'password' => bcrypt('password'), 'role' => 'agent', 'fonction_agent' => 'Rapporteur', 'telephone_agent' => '+243 810 444 555'],
            ['matricule_agent' => 'AG-005', 'nom_agent' => 'Didier Mwamba', 'email' => 'didier.mwamba@esu.cd', 'password' => bcrypt('password'), 'role' => 'agent', 'fonction_agent' => 'Agent administratif', 'telephone_agent' => '+243 810 555 666'],
            ['matricule_agent' => 'AG-006', 'nom_agent' => 'Sarah Ntumba', 'email' => 'sarah.ntumba@esu.cd', 'password' => bcrypt('password'), 'role' => 'agent', 'fonction_agent' => 'Secrétaire de mission', 'telephone_agent' => '+243 810 666 777'],
        ];
        foreach ($agents as $agent) {
            DB::table('agent')->insert(array_merge($agent, ['created_at' => $now, 'updated_at' => $now]));
        }

        $inspecteurs = [];
        for ($i = 1; $i <= 9; $i++) {
            $inspecteurs[] = [
                'matricule_inspecteur' => 'INSP-'.str_pad((string) $i, 3, '0', STR_PAD_LEFT),
                'nom_inspecteur' => $this->inspecteurNames()[$i - 1],
                'fonction_inspecteur' => $i % 3 === 1 ? 'Inspecteur Principal' : 'Inspecteur',
                'telephone_inspecteur' => '+243 820 '.$i.'00 '.$i.'00',
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }
        DB::table('inspecteur')->insert($inspecteurs);

        $equipes = [
            ['moyen_transport' => 'Toyota Hilux'],
            ['moyen_transport' => 'Toyota Land Cruiser'],
            ['moyen_transport' => 'Mini Bus Coaster'],
        ];
        $equipeIds = [];
        foreach ($equipes as $eq) {
            $equipeIds[] = DB::table('equipe')->insertGetId(array_merge($eq, ['created_at' => $now, 'updated_at' => $now]), 'id_equipe');
        }

        $composer = [
            ['matricule_inspecteur' => 'INSP-001', 'id_equipe' => $equipeIds[0], 'role' => "Chef d'équipe"],
            ['matricule_inspecteur' => 'INSP-002', 'id_equipe' => $equipeIds[1], 'role' => "Chef d'équipe"],
            ['matricule_inspecteur' => 'INSP-003', 'id_equipe' => $equipeIds[2], 'role' => "Chef d'équipe"],
        ];
        DB::table('composer')->insert($composer);

        $missions = [
            ['numero_lettre' => 'MIN-ESU/2025/001', 'date_lettre' => $now->copy()->subDays(20), 'motif' => 'Contrôle de la scolarité et de l\'homologation des diplômes', 'periode_debut' => $now->copy()->subDays(8), 'periode_fin' => $now->copy()->addDays(7), 'id_equipe' => $equipeIds[0], 'id_faculte' => $faculteIds['Polytechnique']],
            ['numero_lettre' => 'MIN-ESU/2025/002', 'date_lettre' => $now->copy()->subDays(15), 'motif' => 'Mission d\'inspection académique', 'periode_debut' => $now->copy()->subDays(5), 'periode_fin' => $now->copy()->addDays(12), 'id_equipe' => $equipeIds[1], 'id_faculte' => $faculteIds['Droit']],
            ['numero_lettre' => 'MIN-ESU/2025/003', 'date_lettre' => $now->copy()->subDays(10), 'motif' => 'Vérification des dossiers des finalistes', 'periode_debut' => $now->copy()->addDays(2), 'periode_fin' => $now->copy()->addDays(18), 'id_equipe' => $equipeIds[2], 'id_faculte' => $faculteIds['Économie']],
        ];
        $missionIds = [];
        foreach ($missions as $mission) {
            $missionIds[] = DB::table('mission')->insertGetId(array_merge($mission, [
                'id_anneeacad' => $anneeIds['2025-2026'],
                'created_at' => $now,
                'updated_at' => $now,
            ]), 'id_mission');
        }

        $presenter = [
            ['matricule_agent' => 'AG-001', 'id_mission' => $missionIds[0], 'date_presentation' => $now->copy()->subDays(8)],
            ['matricule_agent' => 'AG-002', 'id_mission' => $missionIds[1], 'date_presentation' => $now->copy()->subDays(5)],
            ['matricule_agent' => 'AG-003', 'id_mission' => $missionIds[2], 'date_presentation' => $now->copy()->addDays(2)],
        ];
        DB::table('presenter')->insert($presenter);

        $vacations = [];
        for ($i = 0; $i < 15; $i++) {
            $paye = $i < 10;
            $vacations[] = [
                'montant' => 300000,
                'date_paiement' => $paye ? $now->copy()->subDays(15 - $i) : null,
                'matricule_inspecteur' => $inspecteurs[$i % 9]['matricule_inspecteur'],
                'id_mission' => $missionIds[$i % 3],
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }
        DB::table('vacation')->insert($vacations);

        $matricules = collect($etudiants)->pluck('matricule')->shuffle()->values();
        $avisRows = [];
        foreach ($matricules->take(1168) as $index => $matricule) {
            $favorable = $index < 1150;
            $avisRows[] = [
                'matricule' => $matricule,
                'id_mission' => $missionIds[$index % 3],
                'avis' => $favorable ? 'Favorable' : 'Défavorable',
                'date_avis' => $now->copy()->subDays(random_int(1, 30)),
                'observation' => $favorable ? null : 'Dossier incomplet ou pièces non conformes',
                'numero_fiche' => 'FH-2026-'.str_pad((string) ($index + 1), 4, '0', STR_PAD_LEFT),
            ];
        }
        foreach (array_chunk($avisRows, 300) as $chunk) {
            DB::table('homologuer')->insert($chunk);
        }
    }

    private function buildEtudiants(array $promotions, array $promotionIds, Carbon $now): array
    {
        $featured = [
            'G3 Informatique' => [
                ['Musaga', 'Kizekele', 'Jean', 'M'],
                ['Tshibangu', 'Nkongolo', 'Mireille', 'F'],
            ],
            'L2 Droit Public' => [
                ['Kabasele', 'Mbuyi', 'Ruth', 'F'],
            ],
            'L1 Droit' => [
                ['Ngoy', 'Kalala', 'Grâce', 'F'],
            ],
            'L1 Comptabilité' => [
                ['Ilunga', 'Mulamba', 'Patrick', 'M'],
            ],
            'G3 Gestion' => [
                ['Kabongo', 'Tshimanga', 'Jonathan', 'M'],
            ],
        ];

        $noms = ['Kabila', 'Mwamba', 'Ilunga', 'Tshibangu', 'Kabongo', 'Ngoy', 'Mutombo', 'Kasongo', 'Banza', 'Lukusa', 'Muyumba', 'Ntumba', 'Nkulu', 'Mulumba', 'Kayembe', 'Mukendi', 'Mbuyi', 'Kalala', 'Kanku', 'Badibanga', 'Tshilombo', 'Muteba', 'Kazadi', 'Beya', 'Mabika', 'Kibwe', 'Lumbala', 'Mwenze', 'Nkashama', 'Bope', 'Makanda', 'Mukuna', 'Tshimanga', 'Ntambwe', 'Kaputo', 'Mpiana', 'Lubaki', 'Kalonji', 'Mujinga', 'Batumona', 'Monga', 'Kitenge', 'Numbi', 'Kabasele', 'Musaga', 'Kizekele', 'Nkongolo', 'Mwilambwe', 'Kongolo', 'Ndaya'];
        $postnoms = ['Kizekele', 'Mbuyi', 'Mulamba', 'Nkongolo', 'Kalala', 'Tshimanga', 'Mukendi', 'Kalonji', 'Nkulu', 'Banza', 'Kayembe', 'Muteba', 'Kazadi', 'Mabika', 'Kibwe', 'Lumbala', 'Mwenze', 'Bope', 'Makanda', 'Kaputo', 'Lubaki', 'Mujinga', 'Monga', 'Kitenge', 'Numbi', 'Kabasele', 'Ndaya', 'Ilunga', 'Kasongo', 'Lukusa', 'Ntumba', 'Mwamba', 'Kabongo', 'Ngoy', 'Tshibangu', 'Mutombo', 'Muyumba', 'Badibanga', 'Tshilombo', 'Beya', 'Mpiana', 'Batumona', 'Kanku', 'Nkashama', 'Kongolo', 'Mwilambwe', 'Musaga', 'Ntambwe', 'Mukuna', 'Kabila'];
        $prenoms = ['Jean', 'Patrick', 'Mireille', 'Ruth', 'Grâce', 'Jonathan', 'Céline', 'Josué', 'Esther', 'Daniel', 'Nadine', 'Emmanuel', 'Chantal', 'Fiston', 'Bernadette', 'Didier', 'Sarah', 'Elie', 'Gloria', 'Samuel', 'Divine', 'Franck', 'Kelly', 'David', 'Naomie', 'Michel', 'Rachel', 'Serge', 'Bénédicte', 'Christian', 'Pauline', 'Alexis', 'Espérance', 'Olivier', 'Sylvie', 'Jacques', 'Merveille', 'Aimé', 'Charlotte', 'Cédric'];
        $lieux = ['Kinshasa', 'Lubumbashi', 'Mbuji-Mayi', 'Kisangani', 'Kananga', 'Goma', 'Bukavu', 'Matadi', 'Uvira', 'Kolwezi'];
        $provinces = ['Kinshasa', 'Haut-Katanga', 'Kasaï-Oriental', 'Tshopo', 'Kasaï-Central', 'Nord-Kivu', 'Sud-Kivu', 'Kongo-Central', 'Haut-Uélé', 'Lualaba'];
        $mentions = ['Distinction', 'Grande distinction', 'Satisfaction'];
        $etats = ['Célibataire', 'Célibataire', 'Marié(e)'];

        $rows = [];
        $numero = 0;
        $featuredQueue = [];

        foreach ($promotions as $promo) {
            $promoTop = $promo['nom'];
            $specials = $featured[$promoTop] ?? [];
            $specialsCount = count($specials);
            $randomCount = $promo['count'] - $specialsCount;

            for ($i = 0; $i < $randomCount; $i++) {
                $numero++;
                $sexe = random_int(0, 1) ? 'M' : 'F';
                $nom = $noms[array_rand($noms)];
                $postnom = $postnoms[array_rand($postnoms)];
                $prenom = $prenoms[array_rand($prenoms)];
                $createdAt = $now->copy()->subDays(random_int(40, 480))->subMinutes(random_int(0, 1440));

                $rows[] = [
                    'matricule' => 'ESU-2025-'.str_pad((string) $numero, 4, '0', STR_PAD_LEFT),
                    'nom' => $nom,
                    'postnom' => $postnom,
                    'prenom' => $prenom,
                    'sexe' => $sexe,
                    'lieu_naissance' => $lieux[array_rand($lieux)],
                    'date_naissance' => $now->copy()->subYears(random_int(20, 27))->subDays(random_int(0, 365)),
                    'etat_civil' => $etats[array_rand($etats)],
                    'nationalite' => 'Congolaise (RDC)',
                    'nom_pere' => $noms[array_rand($noms)].' '.$postnoms[array_rand($postnoms)],
                    'nom_mere' => $noms[array_rand($noms)].' '.$postnoms[array_rand($postnoms)],
                    'province_origine' => $provinces[array_rand($provinces)],
                    'adresse' => random_int(1, 60).' Avenue '.$noms[array_rand($noms)].', Q. '.$lieux[array_rand($lieux)],
                    'telephone' => '+243 8'.random_int(10, 99).' '.random_int(100, 999).' '.random_int(100, 999),
                    'diplome_acces' => "Diplôme d'État",
                    'pourcentage_diplome' => random_int(60, 85),
                    'section' => 'Scientifique',
                    'option_etude' => $promoTop,
                    'lieu_delivrance' => $lieux[array_rand($lieux)],
                    'date_delivrance' => $now->copy()->subDays(random_int(600, 1000)),
                    'ecole_provenance' => 'Institut '.$lieux[array_rand($lieux)],
                    'code_ecole' => 'CD-'.random_int(10000, 99999),
                    'province_ecole' => $provinces[array_rand($provinces)],
                    'mention' => $mentions[array_rand($mentions)],
                    'pourcentage_bulletin' => random_int(60, 84),
                    'id_promotion' => $promotionIds[$promoTop],
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
                ];
            }

            foreach ($specials as $k => $special) {
                $numero++;
                $createdAt = $now->copy()->subMinutes(3 + $k * 7);
                $rows[] = [
                    'matricule' => 'ESU-2025-'.str_pad((string) $numero, 4, '0', STR_PAD_LEFT),
                    'nom' => $special[0],
                    'postnom' => $special[1],
                    'prenom' => $special[2],
                    'sexe' => $special[3],
                    'lieu_naissance' => 'Kinshasa',
                    'date_naissance' => $now->copy()->subYears(random_int(21, 25)),
                    'etat_civil' => 'Célibataire',
                    'nationalite' => 'Congolaise (RDC)',
                    'nom_pere' => $special[0].' '.$special[1],
                    'nom_mere' => 'Maman '.$special[1],
                    'province_origine' => 'Kinshasa',
                    'adresse' => 'Avenue de la Paix, Kinshasa',
                    'telephone' => '+243 820 000 000',
                    'diplome_acces' => "Diplôme d'État",
                    'pourcentage_diplome' => random_int(65, 82),
                    'section' => 'Scientifique',
                    'option_etude' => $promoTop,
                    'lieu_delivrance' => 'Kinshasa',
                    'date_delivrance' => $now->copy()->subDays(random_int(700, 900)),
                    'ecole_provenance' => 'Collège Saint-Joseph',
                    'code_ecole' => 'CD-'.random_int(10000, 99999),
                    'province_ecole' => 'Kinshasa',
                    'mention' => $mentions[array_rand($mentions)],
                    'pourcentage_bulletin' => random_int(65, 83),
                    'id_promotion' => $promotionIds[$promoTop],
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
                ];
            }
        }

        return [$rows, $featuredQueue];
    }

    private function inspecteurNames(): array
    {
        return [
            'Joseph Kabila Mutombo',
            'Marie-Louise Ngoy',
            'Albert Tshibangu',
            'Francine Kabongo',
            'Étienne Mukendi',
            'Cécile Banza',
            'Patrice Kalala',
            'Joséphine Nkulu',
            'Benoît Kasongo',
        ];
    }
}