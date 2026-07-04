<?php
// =========================================================================
//  CHATBOT PORTFOLIO ENRICHI — bot.php (Généré selon vos spécifications)
//  Inclus : Vos exemples, remerciements, et suggestions intelligentes
// =========================================================================

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');

// ── 1. RÉCUPÉRATION ET NETTOYAGE DU MESSAGE ──────────────────────────────

$message = isset($_POST['message']) ? trim($_POST['message']) : '';

if (empty($message)) {
    echo json_encode([
        'reply' => 'Veuillez écrire un message compréhensible. ⌨️', 
        'show_quick_replies' => false
    ]);
    exit;
}

// Nettoyage de base
$msgCleaned = mb_strtolower($message, 'UTF-8');
$msgCleaned = str_replace(['?', '!', '.', ',', ';', ':', '*', '(', ')', '[', ']'], ' ', $msgCleaned);
$userWords = array_filter(explode(' ', $msgCleaned));

// ── 2. BASE DE CONNAISSANCES CONFIGURÉE SELON VOS EXEMPLES + AJOUTS ──────

$knowledge = [
    'bonjour' => [
        'regex' => '/\b(salut|bonjour|hello|hey|coucou)\b/',
        'exact_keywords' => ['salut', 'bonjour', 'hello', 'hey'],
        'weight' => 3,
        'replies' => [
            "Bonjour ! 👋 Ravi de vous rencontrer. Comment puis-je vous aider aujourd'hui ?"
        ],
        'show_quick' => true,
    ],

    'ca_va' => [
        'regex' => '/\b(ca va|ça va|tu vas bien|comment ca va)\b/',
        'exact_keywords' => ['ca va', 'ça va'],
        'weight' => 4,
        'replies' => [
            "Ça va super bien, merci ! 😊 Et vous, comment se passe votre journée ?"
        ],
        'show_quick' => true,
    ],

    'qui_es_tu' => [
        'regex' => '/\b(qui es tu|qui es-tu|tu es qui|ton nom|vrai chatbot)\b/',
        'exact_keywords' => ['qui es-tu', 'qui es tu', 'vrai chatbot'],
        'weight' => 5,
        'replies' => [
            "Je suis l'assistant virtuel intelligent de ce portfolio ! Un vrai chatbot conçu pour vous guider automatiquement. 🤖"
        ],
        'show_quick' => true,
    ],

    'que_peux_tu_faire' => [
        'regex' => '/\b(que peux tu faire|que peux-tu faire|tu fais quoi|aide moi|aide-moi|fonctions)\b/',
        'exact_keywords' => ['que peux-tu faire', 'que peux tu faire', 'aide-moi', 'aide moi'],
        'weight' => 5,
        'replies' => [
            "Je peux vous présenter ce portfolio, vous montrer nos différents templates disponibles, vous expliquer comment générer le vôtre et estimer le temps de création ! 🚀"
        ],
        'show_quick' => true,
    ],

    'montre_templates' => [
        'regex' => '/\b(portfolio|template|templates|montre|voir|visiter|exemples)\b/',
        'exact_keywords' => ['portfolio', 'templates', 'template', 'montre-moi tes templates'],
        'weight' => 5,
        'replies' => [
            "Visitez les templates et vous trouverez différents templates magnifiques prêts à l'emploi ! 📂✨"
        ],
        'show_quick' => true,
    ],

    'meilleur_template' => [
        'regex' => '/\b(meilleur|meilleurs|top|choisir|categorie|categories|architecture|creative|developper|minimal|professional)\b/',
        'exact_keywords' => ['meilleur template', 'meilleurs templates', 'quel est ton meilleur template'],
        'weight' => 5,
        'replies' => [
            "Selon votre spécialité, on a plusieurs catégories ! Voici ce que nous proposons :\n• 🏛️ Architecture\n• 🎨 Creative\n• 💻 Developper\n• 🌿 Minimal\n• 👔 Professional"
        ],
        'show_quick' => false,
    ],

    'temps_creation' => [
        'regex' => '/\b(combien de temps|temps|duree|creer ce portfolio|longtemps|jours|heures)\b/',
        'exact_keywords' => ['combien de temps', 'temps pour creer', 'duree creation'],
        'weight' => 5,
        'replies' => [
            "Le temps nécessaire pour créer ce portfolio dépend entièrement de votre besoin ! ⏱️"
        ],
        'show_quick' => false,
    ],

    'design_createur' => [
        'regex' => '/\b(design|toi-meme|toi meme|cree le design|automatique|predefini|choisir|saisir|generer)\b/',
        'exact_keywords' => ['tu as cree le design', 'design toi-meme', 'templates predefinis'],
        'weight' => 5,
        'replies' => [
            "Il y a des templates prédéfinis ! Vous choisissez le template qui vous plaît, vous saisissez vos informations personnelles et le portfolio se génère automatiquement ! 🪄🤖"
        ],
        'show_quick' => false,
    ],

    // ── NOUVELLE CATÉGORIE : MERCI BIEN (DEMANDÉE) ───────────────────────
    'merci' => [
        'regex' => '/\b(merci|thanks|thx|parfait|nickel|cool|parfait|genial|bien merci)\b/',
        'exact_keywords' => ['merci', 'merci bien', 'bien merci', 'merci beaucoup', 'super merci'],
        'weight' => 4,
        'replies' => [
            "Je vous en prie ! C'est un plaisir de vous aider. 😊 N'hésitez pas si vous avez d'autres questions !",
            "De rien ! Bonne exploration de nos templates. 👍"
        ],
        'show_quick' => false,
    ],

    // ── NOUVELLE CATÉGORIE DE VOTRE CHOIX : TARIF / PRIX ─────────────────
    'prix' => [
        'regex' => '/\b(payant|gratuit|prix|combien ca coute|argent|tarif|tarifs|achat|acheter)\b/',
        'exact_keywords' => ['prix', 'tarif', 'gratuit', 'combien ca coute'],
        'weight' => 5,
        'replies' => [
            "La génération de base est totalement gratuite ! Vous pouvez choisir un template et remplir vos informations sans dépenser un centime. 💳❌"
        ],
        'show_quick' => false,
    ],

    // ── NOUVELLE CATÉGORIE DE VOTRE CHOIX : MODIFICATION APRÈS GÉNÉRATION ─
    'modifier' => [
        'regex' => '/\b(modifier|changement|changer|editer|trompe|modifier mes infos|mise a jour)\b/',
        'exact_keywords' => ['modifier', 'changer', 'editer', 'mise a jour'],
        'weight' => 5,
        'replies' => [
            "Pas d'inquiétude ! Une fois votre portfolio généré, vous recevez un accès pour modifier vos textes, vos photos et vos projets à tout moment. ✏️"
        ],
        'show_quick' => false,
    ],

    // ── NOUVELLE CATÉGORIE DE VOTRE CHOIX : AFFICHAGE MOBILE (RESPONSIVE) ─
    'mobile' => [
        'regex' => '/\b(mobile|telephone|smartphone|tablette|responsive|ecran)\b/',
        'exact_keywords' => ['mobile', 'telephone', 'responsive', 'tablette'],
        'weight' => 4,
        'replies' => [
            "Oui, absolument ! Tous nos templates sont 100% 'Responsive', ce qui signifie qu'ils s'adaptent parfaitement sur les smartphones, les tablettes et les ordinateurs. 📱💻"
        ],
        'show_quick' => false,
    ],

    // ── NOUVELLE CATÉGORIE DE VOTRE CHOIX : SUPPORT / PROBLÈME ───────────
    'support' => [
        'regex' => '/\b(bug|probleme|marche pas|bloque|erreur|contact-support|aidez-moi)\b/',
        'exact_keywords' => ['bug', 'probleme', 'erreur', 'bloque'],
        'weight' => 5,
        'replies' => [
            "Si vous rencontrez un problème technique ou un bug lors de la génération, vous pouvez contacter notre équipe via la rubrique Support pour recevoir de l'aide rapidement ! 🛠️"
        ],
        'show_quick' => false,
    ],
];

// ── 3. MOTEUR ANALYTIQUE AVEC SUPPRESSION DES ACCENTS ───────────────────

function removeAccents($str) {
    $utf8 = [
        '/[áàâãäå]/u' => 'a', '/[ÁÀÂÃÄÅ]/u' => 'A',
        '/[éèêë]/u'   => 'e', '/[ÉÈÊË]/u'   => 'E',
        '/[íìîï]/u'   => 'i', '/[ÍÌÎÏ]/u'   => 'I',
        '/[óòôõöø]/u' => 'o', '/[ÓÒÔÕÖØ]/u' => 'O',
        '/[úùûü]/u'   => 'u', '/[ÚÙÛÜ]/u'   => 'U',
        '/[ç]/u'      => 'c', '/[Ç]/u'      => 'C',
        '/[ñ]/u'      => 'n', '/[Ñ]/u'      => 'N',
    ];
    return preg_replace(array_keys($utf8), array_values($utf8), $str);
}

$bestCategory = null;
$highestScore = 0;

$msgNoAccents = removeAccents($msgCleaned);

foreach ($knowledge as $category => $data) {
    $score = 0;

    // Étape A : Match par Expressions Régulières (Regex)
    $regexMatches = preg_match_all($data['regex'], $msgNoAccents);
    if ($regexMatches > 0) {
        $score += $regexMatches * $data['weight'];
    }

    // Étape B : Tolérance mot à mot (Algorithme Levenshtein)
    foreach ($userWords as $userWord) {
        $userWordClean = removeAccents($userWord);

        foreach ($data['exact_keywords'] as $keyword) {
            $keywordClean = removeAccents(mb_strtolower($keyword, 'UTF-8'));

            $distance = levenshtein($userWordClean, $keywordClean);
            
            if ($distance === 0) {
                $score += 4; // Correspondance exacte
            } elseif ($distance === 1 && strlen($userWordClean) > 3) {
                $score += 2; // Faute de frappe légère
            }
        }
    }

    if ($score > $highestScore) {
        $highestScore = $score;
        $bestCategory = $category;
    }
}

// ── 4. SÉLECTION DE LA RÉPONSE FINALE ───────────────────────────────────

if ($bestCategory !== null && $highestScore >= 2) {
    $categoryData = $knowledge[$bestCategory];
    $finalReply = $categoryData['replies'][array_rand($categoryData['replies'])];
    $showQuick = $categoryData['show_quick'];
} else {
    // Message d'aide par défaut basé sur vos rubriques
    $finalReply = "Je ne suis pas sûr de bien comprendre. 🧐 N'hésitez pas à me demander de vous montrer les templates, nos différentes catégories (Architecture, Creative...), ou si la création est gratuite !";
    $showQuick = true;
}

// ── 5. EXPORT JSON ──────────────────────────────────────────────────────

echo json_encode([
    'reply'              => $finalReply,
    'show_quick_replies' => $showQuick,
], JSON_UNESCAPED_UNICODE);
?>