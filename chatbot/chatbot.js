// =========================================================================
//  CHATBOT PORTFOLIO — chatbot.js (Version Corrigée & Sécurisée)
// =========================================================================

const chatWindow = document.getElementById('chat-window');
const chatInput  = document.getElementById('chat-input');
const sendBtn    = document.getElementById('send-btn');

function scrollBottom() {
  chatWindow.scrollTop = chatWindow.scrollHeight;
}

// ── AFFICHAGE DES MESSAGES AVEC GESTION DES RETOURS À LA LIGNE ───────────

function appendMsg(text, role, withQuickReplies = false) {
  const isBot = role === 'bot';

  const wrap = document.createElement('div');
  wrap.className = 'msg ' + role;

  // Création de l'avatar
  const av = document.createElement('div');
  av.className = 'msg-avatar';
  av.innerHTML = isBot ? '<i class="ti ti-robot" aria-hidden="true"></i>' : 'Vous';

  // Zone de contenu interne
  const inner = document.createElement('div');

  const bubble = document.createElement('div');
  bubble.className = 'bubble';

  // Traitement et injection sécurisée des textes et des sauts de ligne (\n -> <br>)
  if (isBot) {
    bubble.innerHTML = text.replace(/\n/g, '<br>');
  } else {
    // Évite l'injection de scripts malveillants par l'utilisateur
    const tempDiv = document.createElement('div');
    tempDiv.textContent = text;
    bubble.innerHTML = tempDiv.innerHTML.replace(/\n/g, '<br>');
  }
  
  inner.appendChild(bubble);

  // Injection des boutons de réponses rapides si demandées
  if (isBot && withQuickReplies) {
    const qr = document.createElement('div');
    qr.className = 'quick-replies';
    
    const buttons = [
      { label: '🚀 Voir les projets', query: 'Voir les projets' },
      { label: '💻 Compétences', query: 'Compétences' },
      { label: '✉️ Contact', query: 'Contact' }
    ];

    buttons.forEach(btnData => {
      const btn = document.createElement('button');
      btn.className = 'qr-btn';
      btn.textContent = btnData.label;
      btn.addEventListener('click', () => sendQuick(btnData.query));
      qr.appendChild(btn);
    });
    inner.appendChild(qr);
  }

  wrap.appendChild(av);
  wrap.appendChild(inner);
  chatWindow.appendChild(wrap);
  scrollBottom();
}

// ── INDICATEUR D'ÉCRITURE VISUEL (TYPING) ───────────────────────────────

function showTyping() {
  const wrap = document.createElement('div');
  wrap.className = 'msg bot';
  wrap.id = 'typing-indicator';

  const av = document.createElement('div');
  av.className = 'msg-avatar';
  av.innerHTML = '<i class="ti ti-robot" aria-hidden="true"></i>';

  const t = document.createElement('div');
  t.className = 'typing-indicator';
  t.innerHTML = '<span></span><span></span><span></span>';

  wrap.appendChild(av);
  wrap.appendChild(t);
  chatWindow.appendChild(wrap);
  scrollBottom();
}

function removeTyping() {
  const el = document.getElementById('typing-indicator');
  if (el) el.remove();
}

// ── ENVOI DES DONNÉES AU SERVEUR (FETCH AJAX) ───────────────────────────

async function sendMessage(text) {
  if (!text.trim()) return;

  // Verrouillage temporaire des contrôles
  chatInput.disabled = true;
  sendBtn.disabled   = true;

  appendMsg(text, 'user');
  showTyping();

  try {
    const response = await fetch('bot.php', {
      method:  'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body:    'message=' + encodeURIComponent(text)
    });

    if (!response.ok) throw new Error("Erreur serveur HTTP");

    const data = await response.json();
    removeTyping();

    if (data.reply) {
      setTimeout(() => {
        appendMsg(data.reply, 'bot', data.show_quick_replies);
      }, 300);
    } else {
      appendMsg("Désolé, je rencontre des difficultés à formuler une réponse.", 'bot', true);
    }

  } catch (err) {
    removeTyping();
    appendMsg("Impossible de joindre le serveur. Veuillez vérifier votre connexion.", 'bot', true);
    console.error('Erreur Chatbot:', err);
  }

  // Déverrouillage des entrées
  chatInput.disabled = false;
  sendBtn.disabled   = false;
  chatInput.focus();
}

// ── ACTION DES RÉPONSES RAPIDES ─────────────────────────────────────────

function sendQuick(queryText) {
  sendMessage(queryText);
}

// ── ÉCOUTEURS D'ÉVÉNEMENTS (LISTENERS) ──────────────────────────────────

sendBtn.addEventListener('click', () => {
  const text = chatInput.value.trim();
  chatInput.value = '';
  sendMessage(text);
});

chatInput.addEventListener('keydown', (e) => {
  if (e.key === 'Enter' && !e.shiftKey) {
    e.preventDefault();
    const text = chatInput.value.trim();
    chatInput.value = '';
    sendMessage(text);
  }
});