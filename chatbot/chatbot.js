// =============================================
//  CHATBOT PORTFOLIO — chatbot.js
//  Gère l'UI et envoie les messages au serveur
// =============================================

const chatWindow = document.getElementById('chat-window');
const chatInput  = document.getElementById('chat-input');
const sendBtn    = document.getElementById('send-btn');

// ── Helpers ────────────────────────────────

function getTime() {
  const d = new Date();
  return d.getHours().toString().padStart(2,'0') + ':' +
         d.getMinutes().toString().padStart(2,'0');
}

function scrollBottom() {
  chatWindow.scrollTop = chatWindow.scrollHeight;
}

// ── Afficher un message ────────────────────

function appendMsg(text, role, withQuickReplies = false) {
  const isBot = role === 'bot';

  const wrap = document.createElement('div');
  wrap.className = 'msg ' + role;

  // Avatar
  const av = document.createElement('div');
  av.className = 'msg-avatar';
  av.innerHTML = isBot
    ? '<i class="ti ti-robot" aria-hidden="true"></i>'
    : 'Vous';

  // Contenu
  const inner = document.createElement('div');

  const bubble = document.createElement('div');
  bubble.className = 'bubble';
  bubble.textContent = text;
  inner.appendChild(bubble);

  // Réponses rapides (uniquement pour le bot)
  if (isBot && withQuickReplies) {
    const qr = document.createElement('div');
    qr.className = 'quick-replies';
    ['🚀 Voir les projets', '💻 Compétences', '✉️ Contact'].forEach(label => {
      const btn = document.createElement('button');
      btn.className = 'qr-btn';
      btn.textContent = label;
      btn.addEventListener('click', () => sendQuick(label));
      qr.appendChild(btn);
    });
    inner.appendChild(qr);
  }

  wrap.appendChild(av);
  wrap.appendChild(inner);
  chatWindow.appendChild(wrap);
  scrollBottom();
}

// ── Indicateur de frappe ───────────────────

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

// ── Envoi du message au serveur PHP ───────

async function sendMessage(text) {
  if (!text.trim()) return;

  // Bloquer l'input pendant la requête
  chatInput.disabled = true;
  sendBtn.disabled   = true;

  // Afficher le message utilisateur
  appendMsg(text, 'user');
  showTyping();

  try {
    const response = await fetch('bot.php', {
      method:  'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body:    'message=' + encodeURIComponent(text)
    });

    const data = await response.json();

    removeTyping();

    if (data.reply) {
      // Petit délai pour un effet naturel
      setTimeout(() => {
        appendMsg(data.reply, 'bot', data.show_quick_replies || false);
      }, 300);
    } else {
      appendMsg("Désolé, une erreur est survenue.", 'bot');
    }

  } catch (err) {
    removeTyping();
    appendMsg("Impossible de joindre le serveur. Réessayez.", 'bot');
    console.error('Erreur fetch:', err);
  }

  chatInput.disabled = false;
  sendBtn.disabled   = false;
  chatInput.focus();
}

// ── Réponses rapides ───────────────────────

function sendQuick(label) {
  // Retirer l'emoji pour le texte envoyé
  const clean = label.replace(/^[^\w\s]+\s*/, '').trim();
  chatInput.value = clean;
  sendMessage(clean);
  chatInput.value = '';
}

// ── Événements ────────────────────────────

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
