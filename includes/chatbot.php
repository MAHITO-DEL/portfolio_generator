<?php
/**
 * includes/chatbot.php
 * Chatbot flottant — visible uniquement si l'utilisateur est connecté
 * Requiert : session_start() déjà appelé dans index.php
 */
if (!isset($_SESSION['id_user'])) return;
?>

<!-- Fonts + Icons chatbot -->
<link href="https://fonts.googleapis.com/css2?family=DM+Mono:wght@400;500&family=Syne:wght@400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">

<!-- Bouton flottant -->
<button class="chatbot-fab" id="chatbot-fab" onclick="toggleChatbot()"
        title="Assistant Portfolio" aria-label="Ouvrir le chatbot">
    <i class="ti ti-message-chatbot"></i>
</button>

<!-- Fenêtre chatbot -->
<div class="chatbot-window" id="chatbot-window">
    <div class="chat-header">
        <div class="avatar"><i class="ti ti-robot"></i></div>
        <div class="header-info">
            <h2>Portfolio Assistant</h2>
            <p>En ligne · répond en quelques secondes</p>
        </div>
        <button class="chatbot-close" onclick="toggleChatbot()" title="Fermer" aria-label="Fermer">
            <i class="ti ti-x"></i>
        </button>
    </div>

    <div class="chat-window" id="chat-window">
        <div class="msg bot">
            <div class="msg-avatar"><i class="ti ti-robot"></i></div>
            <div>
                <div class="bubble">
                    Bonjour <?= htmlspecialchars($_SESSION['nom']) ?> ! 👋 Je suis l'assistant de ce portfolio.
                    Je peux vous parler des projets, des compétences ou vous aider à prendre contact.
                </div>
                <div class="quick-replies">
                    <button class="qr-btn" onclick="sendQuick('Voir les projets')">🚀 Voir les projets</button>
                    <button class="qr-btn" onclick="sendQuick('Compétences techniques')">💻 Compétences</button>
                    <button class="qr-btn" onclick="sendQuick('Me contacter')">✉️ Contact</button>
                </div>
            </div>
        </div>
    </div>

    <div class="chat-input-area">
        <button class="action-btn" title="Emoji" aria-label="Emoji"><i class="ti ti-mood-smile"></i></button>
        <input type="text" id="chat-input" placeholder="Écrivez un message..." autocomplete="off"/>
        <button class="send-btn" id="send-btn" aria-label="Envoyer"><i class="ti ti-send"></i></button>
    </div>
</div>

<script>
function toggleChatbot() {
    const win = document.getElementById('chatbot-window');
    const fab = document.getElementById('chatbot-fab');
    const isOpen = win.classList.contains('open');
    win.classList.toggle('open');
    fab.classList.toggle('open');
    fab.innerHTML = isOpen ? '<i class="ti ti-message-chatbot"></i>' : '<i class="ti ti-x"></i>';
    if (!isOpen) setTimeout(() => document.getElementById('chat-input').focus(), 300);
}
</script>
<script>const _originalFetch = window.fetch;</script>
<script src="chatbot/chatbot.js"></script>
<script>
window.fetch = function(url, options) {
    if (url === 'bot.php') url = 'chatbot/bot.php';
    return _originalFetch(url, options);
};
</script>
