<?php
// =============================================
//  CHATBOT PORTFOLIO — bot.php
//  Reçoit un message POST et retourne une
//  réponse JSON { reply, show_quick_replies }
// =============================================

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');

// ── Récupération et nettoyage du message ───

$message = isset($_POST['message']) ? trim($_POST['message']) : '';

if (empty($message)) {
    echo json_encode(['reply' => 'Veuillez écrire un message.', 'show_quick_replies' => false]);
    exit;
}

$msg = mb_strtolower($message, 'UTF-8');

// ── Base de connaissances ──────────────────
//  Chaque entrée : [ mots-clés[], réponses[], show_quick_replies ]

$knowledge = [

    'projets' => [
        'keywords' => ['projet', 'projects', 'travail', 'réalisation', 'portfolio', 'voir', 'app'],
        'replies'  => [
            "J'ai réalisé plusieurs projets :\n• 🛒 Une marketplace en React + Node.js\n• 📊 Un dashboard analytique (Vue.js + Chart.js)\n• 🔗 Une API REST sécurisée (Laravel)\n\nLequel vous intéresse le plus ?",
            "Mes projets phares incluent une PWA e-commerce, un SaaS B2B et un portfolio interactif. Je peux vous en dire plus sur l'un d'eux !",
        ],
        'show_quick' => true,
    ],

    'competences' => [
        'keywords' => ['comp', 'skill', 'tech', 'stack', 'langag', 'savoir', 'maîtrise', 'utilise', 'framework'],
        'replies'  => [
            "Voici mon stack technique :\n• Frontend : React, Vue.js, TypeScript, Tailwind CSS\n• Backend : Node.js, PHP/Laravel, Python\n• BDD : PostgreSQL, MySQL, MongoDB\n• Outils : Git, Docker, Figma, Vercel",
            "Je suis développeur full-stack avec 4 ans d'expérience. Spécialisé React côté front et Laravel/Node côté back. Toujours en apprentissage ! 🚀",
        ],
        'show_quick' => false,
    ],

    'contact' => [
        'keywords' => ['contact', 'email', 'joindre', 'disponib', 'recrut', 'embauche', 'freelance', 'mission', 'collabor'],
        'replies'  => [
            "Vous pouvez me joindre via :\n• 📧 hello@portfolio.dev\n• 💼 linkedin.com/in/monprofil\n• 🐙 github.com/monprofil\n\nJe réponds généralement sous 24h !",
            "Je suis actuellement disponible pour des missions freelance ou un poste full-stack. N'hésitez pas à m'écrire à hello@portfolio.dev !",
        ],
        'show_quick' => false,
    ],

    'experience' => [
        'keywords' => ['expérience', 'experi', 'année', 'parcours', 'carrière', 'cursus', 'formation', 'diplôme', 'étude'],
        'replies'  => [
            "Mon parcours :\n• 🎓 Master Informatique — Université Paris Saclay (2020)\n• 💼 Développeur senior chez TechCorp (2 ans)\n• 💻 Freelance full-stack depuis 2022\n\nTotal : ~5 ans d'expérience professionnelle.",
        ],
        'show_quick' => false,
    ],

    'bonjour' => [
        'keywords' => ['bonjour', 'salut', 'hello', 'bonsoir', 'hey', 'coucou', 'hi'],
        'replies'  => [
            "Bonjour ! 👋 Ravi de vous rencontrer. Comment puis-je vous aider aujourd'hui ?",
            "Salut ! Je suis Alex, l'assistant de ce portfolio. Posez-moi vos questions !",
        ],
        'show_quick' => true,
    ],

    'merci' => [
        'keywords' => ['merci', 'thanks', 'thank', 'super', 'parfait', 'nickel', 'cool'],
        'replies'  => [
            "Avec plaisir ! 😊 N'hésitez pas si vous avez d'autres questions.",
            "De rien ! Je suis là si vous avez besoin d'autre chose.",
        ],
        'show_quick' => false,
    ],

    'tarif' => [
        'keywords' => ['tarif', 'prix', 'coût', 'devis', 'budget', 'facturation', 'taux journalier', 'tjm'],
        'replies'  => [
            "Mon TJM varie selon le type de mission (250–450 €/j). Pour un devis précis, contactez-moi directement à hello@portfolio.dev avec votre cahier des charges.",
        ],
        'show_quick' => false,
    ],

];

// ── Moteur de correspondance ───────────────

$matched_reply      = null;
$show_quick_replies = false;
$best_score         = 0;

foreach ($knowledge as $category => $data) {
    $score = 0;
    foreach ($data['keywords'] as $keyword) {
        if (mb_strpos($msg, $keyword, 0, 'UTF-8') !== false) {
            $score++;
        }
    }
    if ($score > $best_score) {
        $best_score         = $score;
        $matched_reply      = $data['replies'][array_rand($data['replies'])];
        $show_quick_replies = $data['show_quick'];
    }
}

// ── Réponse par défaut ─────────────────────

if ($best_score === 0 || $matched_reply === null) {
    $defaults = [
        "Je ne suis pas sûr de comprendre. Voulez-vous que je vous parle des projets, des compétences ou des infos de contact ?",
        "Hmm, je n'ai pas la réponse précise à cela. Essayez de me demander les projets, le stack technique ou comment me contacter !",
        "Bonne question ! Pour les détails, n'hésitez pas à me contacter directement. 😊",
    ];
    $matched_reply      = $defaults[array_rand($defaults)];
    $show_quick_replies = true;
}

// ── Simulation d'un délai naturel ─────────
//  (optionnel — à retirer en production)
// usleep(500000); // 0.5 seconde

// ── Réponse JSON ──────────────────────────

echo json_encode([
    'reply'              => $matched_reply,
    'show_quick_replies' => $show_quick_replies,
], JSON_UNESCAPED_UNICODE);
?>
