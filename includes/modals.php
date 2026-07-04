<?php
/**
 * includes/modals.php
 * Modals Bootstrap : Login · Inscription · Mot de passe oublié · Reset mot de passe
 */
?>

<!-- ================================================
     MODAL 1 — LOGIN
================================================ -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div style="color:#fff;text-align:center;padding:1.6rem;">
        <i class="bi bi-person-lock" style="font-size:2rem;display:block;margin-bottom:.4rem;"></i>
        <h5 style="margin:0;font-weight:700;">Connexion</h5>
        <p style="margin:.3rem 0 0;opacity:.85;font-size:.85rem;">Accédez à votre espace Portfolio</p>
      </div>
      <div class="modal-body p-4">
        <?php if (!empty($_SESSION['login_erreur'])): ?>
          <div class="alert alert-danger d-flex align-items-center gap-2 py-2">
            <i class="bi bi-exclamation-triangle-fill"></i>
            <?= htmlspecialchars($_SESSION['login_erreur']) ?>
          </div>
          <?php unset($_SESSION['login_erreur']); ?>
        <?php endif; ?>
        <?php if (!empty($_SESSION['msg_succes'])): ?>
          <div class="alert alert-success d-flex align-items-center gap-2 py-2">
            <i class="bi bi-check-circle-fill"></i>
            <?= htmlspecialchars($_SESSION['msg_succes']) ?>
          </div>
          <?php unset($_SESSION['msg_succes']); ?>
        <?php endif; ?>
        <form method="POST" action="auth2/login.php">
          <div class="mb-3">
            <label class="form-label fw-semibold">Email</label>
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-envelope"></i></span>
              <input type="email" name="email" class="form-control" placeholder="votre@email.com" required>
            </div>
          </div>
          <div class="mb-2">
            <label class="form-label fw-semibold">Mot de passe</label>
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-lock"></i></span>
              <input type="password" name="password" id="loginPwd" class="form-control" placeholder="••••••••" required>
              <button type="button" class="btn btn-outline-secondary" onclick="togglePwd('loginPwd','loginPwdIcon')">
                <i class="bi bi-eye" id="loginPwdIcon"></i>
              </button>
            </div>
          </div>
          <div class="text-end mb-4">
            <a href="#" style="font-size:.85rem;font-weight:600;text-decoration:none;"
               data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#forgotModal">
              <i class="bi bi-question-circle me-1"></i>Mot de passe oublié ?
            </a>
          </div>
          <div class="d-grid">
            <button type="submit" class="btn btn-lg" style="background:#2C6BED;color:#fff;border-color:#2C6BED;">
              <i class="bi bi-box-arrow-in-right me-2"></i>Se connecter
            </button>
          </div>
        </form>
        <hr>
        <p class="text-center mb-0 text-muted" style="font-size:.9rem;">
          Pas encore de compte ?
          <a href="#" style="font-weight:600;"
             data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#registerModal">Créer un compte</a>
        </p>
      </div>
    </div>
  </div>
</div>

<!-- ================================================
     MODAL 2 — INSCRIPTION
================================================ -->
<div class="modal fade" id="registerModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div style="color:#fff;text-align:center;padding:1.6rem;">
        <i class="bi bi-person-plus-fill" style="font-size:2rem;display:block;margin-bottom:.4rem;"></i>
        <h5 style="margin:0;font-weight:700;">Créer un compte</h5>
        <p style="margin:.3rem 0 0;opacity:.85;font-size:.85rem;">Rejoignez Portfolio Pro</p>
      </div>
      <div class="modal-body p-4">
        <?php if (!empty($_SESSION['register_erreur'])): ?>
          <div class="alert alert-danger d-flex align-items-center gap-2 py-2">
            <i class="bi bi-exclamation-triangle-fill"></i>
            <?= htmlspecialchars($_SESSION['register_erreur']) ?>
          </div>
          <?php unset($_SESSION['register_erreur']); ?>
        <?php endif; ?>
        <form method="POST" action="auth2/register.php">
          <div class="mb-3">
            <label class="form-label fw-semibold">Nom complet</label>
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-person"></i></span>
              <input type="text" name="nom" class="form-control" placeholder="Nom Complet" required>
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label fw-semibold">Email</label>
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-envelope"></i></span>
              <input type="email" name="email" class="form-control" placeholder="votre@email.com" required>
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label fw-semibold">Mot de passe</label>
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-lock"></i></span>
              <input type="password" name="password" id="regPwd" class="form-control"
                     placeholder="Min. 8 car." required oninput="evalForceReg(this.value)">
              <button type="button" class="btn btn-outline-secondary" onclick="togglePwd('regPwd','regPwdIcon')">
                <i class="bi bi-eye" id="regPwdIcon"></i>
              </button>
            </div>
            <div class="bg-light rounded mt-1" style="height:5px;">
              <div id="regPwdBar" style="width:0%;height:100%;border-radius:3px;transition:width .3s,background .3s;"></div>
            </div>
            <small id="regPwdLabel" class="text-muted"></small>
          </div>
          <div class="mb-4">
            <label class="form-label fw-semibold">Confirmer le mot de passe</label>
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
              <input type="password" name="confirm" id="regConfirm" class="form-control"
                     placeholder="Répétez le mot de passe" required oninput="checkMatchReg()">
              <button type="button" class="btn btn-outline-secondary" onclick="togglePwd('regConfirm','regConfirmIcon')">
                <i class="bi bi-eye" id="regConfirmIcon"></i>
              </button>
            </div>
            <small id="regMatchMsg"></small>
          </div>
          <div class="d-grid">
            <button type="submit" class="btn btn-lg" style="background:#2C6BED;color:#fff;border-color:#2C6BED;">
              <i class="bi bi-person-check me-2"></i>Créer mon compte
            </button>
          </div>
        </form>
        <hr>
        <p class="text-center mb-0 text-muted" style="font-size:.9rem;">
          Déjà un compte ?
          <a href="#" style="font-weight:600;"
             data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#loginModal">Se connecter</a>
        </p>
      </div>
    </div>
  </div>
</div>

<!-- ================================================
     MODAL 3 — MOT DE PASSE OUBLIÉ
================================================ -->
<div class="modal fade" id="forgotModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div style="color:#fff;text-align:center;padding:1.6rem;">
        <i class="bi bi-key-fill" style="font-size:2rem;display:block;margin-bottom:.4rem;"></i>
        <h5 style="margin:0;font-weight:700;">Mot de passe oublié ?</h5>
        <p style="margin:.3rem 0 0;opacity:.85;font-size:.85rem;">Un lien de réinitialisation vous sera envoyé</p>
      </div>
      <div class="modal-body p-4">
        <?php if (!empty($_SESSION['forgot_succes'])): ?>
          <div class="alert alert-success d-flex align-items-center gap-2 py-2">
            <i class="bi bi-check-circle-fill"></i>
            <?= htmlspecialchars($_SESSION['forgot_succes']) ?>
          </div>
          <?php unset($_SESSION['forgot_succes']); ?>
        <?php endif; ?>
        <?php if (!empty($_SESSION['forgot_erreur'])): ?>
          <div class="alert alert-danger d-flex align-items-center gap-2 py-2">
            <i class="bi bi-exclamation-triangle-fill"></i>
            <?= htmlspecialchars($_SESSION['forgot_erreur']) ?>
          </div>
          <?php unset($_SESSION['forgot_erreur']); ?>
        <?php endif; ?>
        <?php if (!empty($_SESSION['reset_lien'])): ?>
          <div style="background:rgba(255,255,255,0.05);border:1px dashed rgba(255,255,255,0.2);border-radius:8px;padding:12px;margin-bottom:12px;font-size:.8rem;word-break:break-all;">
            <strong style="color:#f59e0b;"><i class="bi bi-code-slash me-1"></i>Mode dev — lien reset :</strong><br>
            <a href="<?= htmlspecialchars($_SESSION['reset_lien']) ?>" style="color:#60a5fa;">
              <?= htmlspecialchars($_SESSION['reset_lien']) ?>
            </a>
          </div>
          <?php unset($_SESSION['reset_lien']); ?>
        <?php endif; ?>
        <form method="POST" action="auth2/forgot_password.php">
          <div class="mb-4">
            <label class="form-label fw-semibold">Adresse email</label>
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-envelope"></i></span>
              <input type="email" name="email" class="form-control" placeholder="votre@email.com" required>
            </div>
            <div class="form-text">Lien valable <strong>1 heure</strong>.</div>
          </div>
          <div class="d-grid">
            <button type="submit" class="btn btn-lg" style="background:#2C6BED;color:#fff;border-color:#2C6BED;">
              <i class="bi bi-send me-2"></i>Envoyer le lien
            </button>
          </div>
        </form>
        <hr>
        <p class="text-center mb-0 text-muted" style="font-size:.9rem;">
          <a href="#" style="font-weight:600;"
             data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#loginModal">
            <i class="bi bi-arrow-left me-1"></i>Retour à la connexion
          </a>
        </p>
      </div>
    </div>
  </div>
</div>

<!-- ================================================
     MODAL 4 — RÉINITIALISATION MOT DE PASSE
     Ouvert automatiquement quand ?reset_token=xxx
     est présent dans l'URL (redirigé depuis reset_password.php)
================================================ -->
<div class="modal fade" id="resetModal" tabindex="-1" aria-hidden="true"
     data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <!-- En-tête -->
      <div style="background:linear-gradient(135deg,#E0143C,#2255D4);color:#fff;text-align:center;padding:1.6rem;border-radius:var(--bs-modal-inner-border-radius) var(--bs-modal-inner-border-radius) 0 0;">
        <i class="bi bi-shield-lock-fill" style="font-size:2rem;display:block;margin-bottom:.4rem;"></i>
        <h5 style="margin:0;font-weight:700;">Nouveau mot de passe</h5>
        <p style="margin:.3rem 0 0;opacity:.85;font-size:.85rem;">Choisissez un nouveau mot de passe sécurisé</p>
      </div>

      <div class="modal-body p-4">

        <!-- Alerte erreur PHP -->
        <?php if (!empty($_SESSION['reset_erreur'])): ?>
          <div class="alert alert-danger d-flex align-items-center gap-2 py-2">
            <i class="bi bi-exclamation-triangle-fill"></i>
            <?= htmlspecialchars($_SESSION['reset_erreur']) ?>
          </div>
          <?php unset($_SESSION['reset_erreur']); ?>
        <?php endif; ?>

        <!-- Alerte succès PHP -->
        <?php if (!empty($_SESSION['reset_succes'])): ?>
          <div class="alert alert-success d-flex align-items-center gap-2 py-2">
            <i class="bi bi-check-circle-fill"></i>
            <?= htmlspecialchars($_SESSION['reset_succes']) ?>
          </div>
          <?php unset($_SESSION['reset_succes']); ?>
          <div class="d-grid mt-3">
            <a href="#" class="btn btn-lg btn-primary"
               data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#loginModal">
              <i class="bi bi-box-arrow-in-right me-2"></i>Se connecter
            </a>
          </div>
          <hr>
          <p class="text-center mb-0 text-muted" style="font-size:.9rem;">
            <a href="#" data-bs-dismiss="modal" style="font-weight:600;">
              <i class="bi bi-arrow-left me-1"></i>Retour
            </a>
          </p>

        <?php else: ?>

          <!-- Token invalide / expiré -->
          <div id="reset-token-error" style="display:none;">
            <div class="alert alert-danger d-flex align-items-center gap-2 py-2">
              <i class="bi bi-exclamation-triangle-fill"></i>
              <span>Ce lien est invalide ou a expiré.</span>
            </div>
            <div class="d-grid mb-3">
              <button class="btn btn-warning btn-lg"
                      data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#forgotModal">
                <i class="bi bi-arrow-repeat me-2"></i>Refaire une demande
              </button>
            </div>
          </div>

          <!-- Formulaire reset -->
          <form id="resetForm" method="POST" action="auth2/reset_password.php" onsubmit="return validateReset()">
            <input type="hidden" name="token" id="resetTokenInput" value="">

            <div class="mb-3">
              <label class="form-label fw-semibold">Nouveau mot de passe</label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                <input type="password" id="resetPwd" name="password" class="form-control"
                       placeholder="Min. 8 car., 1 majuscule, 1 chiffre"
                       required oninput="evalForceReset(this.value)">
                <button type="button" class="btn btn-outline-secondary"
                        onclick="togglePwd('resetPwd','resetPwdIcon')">
                  <i class="bi bi-eye" id="resetPwdIcon"></i>
                </button>
              </div>
              <!-- Barre de force -->
              <div class="rounded mt-1" style="height:5px;background:#e9ecef;">
                <div id="resetPwdBar" style="width:0%;height:100%;border-radius:3px;transition:width .3s,background .3s;"></div>
              </div>
              <small id="resetPwdLabel" class="text-muted"></small>
            </div>

            <div class="mb-4">
              <label class="form-label fw-semibold">Confirmer le mot de passe</label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                <input type="password" id="resetConfirm" name="confirm" class="form-control"
                       placeholder="Répétez le mot de passe"
                       required oninput="checkMatchReset()">
                <button type="button" class="btn btn-outline-secondary"
                        onclick="togglePwd('resetConfirm','resetConfirmIcon')">
                  <i class="bi bi-eye" id="resetConfirmIcon"></i>
                </button>
              </div>
              <small id="resetMatchMsg"></small>
            </div>

            <div id="reset-client-error" class="alert alert-danger d-flex align-items-center gap-2 py-2" style="display:none!important;"></div>

            <div class="d-grid">
              <button type="submit" class="btn btn-lg"
                      style="background:linear-gradient(135deg,#E0143C,#2255D4);color:#fff;border:none;">
                <i class="bi bi-check-lg me-2"></i>Réinitialiser le mot de passe
              </button>
            </div>
          </form>

          <hr>
          <p class="text-center mb-0 text-muted" style="font-size:.9rem;">
            <a href="#" style="font-weight:600;"
               data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#loginModal">
              <i class="bi bi-arrow-left me-1"></i>Retour à la connexion
            </a>
          </p>

        <?php endif; ?>

      </div>
    </div>
  </div>
</div>

<!-- ================================================
     SCRIPTS MODALS
================================================ -->
<script>
/* ── Afficher/masquer mot de passe ── */
function togglePwd(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon  = document.getElementById(iconId);
    if (!input) return;
    input.type = input.type === 'password' ? 'text' : 'password';
    if (icon) icon.className = input.type === 'password' ? 'bi bi-eye' : 'bi bi-eye-slash';
}

/* ── Force mdp inscription ── */
function evalForceReg(val) {
    _evalPwdBar(val, 'regPwdBar', 'regPwdLabel');
}

/* ── Match mdp inscription ── */
function checkMatchReg() {
    _checkPwdMatch('regPwd', 'regConfirm', 'regMatchMsg');
}

/* ── Force mdp reset ── */
function evalForceReset(val) {
    _evalPwdBar(val, 'resetPwdBar', 'resetPwdLabel');
}

/* ── Match mdp reset ── */
function checkMatchReset() {
    _checkPwdMatch('resetPwd', 'resetConfirm', 'resetMatchMsg');
}

/* ── Valider le formulaire reset avant soumission ── */
function validateReset() {
    const pwd = document.getElementById('resetPwd').value;
    const cfm = document.getElementById('resetConfirm').value;
    const err = document.getElementById('reset-client-error');

    if (pwd.length < 8) {
        _showResetError('Le mot de passe doit contenir au moins 8 caractères.');
        return false;
    }
    if (!/[A-Z]/.test(pwd)) {
        _showResetError('Le mot de passe doit contenir au moins une majuscule.');
        return false;
    }
    if (!/[0-9]/.test(pwd)) {
        _showResetError('Le mot de passe doit contenir au moins un chiffre.');
        return false;
    }
    if (pwd !== cfm) {
        _showResetError('Les mots de passe ne correspondent pas.');
        return false;
    }
    return true;
}

function _showResetError(msg) {
    const el = document.getElementById('reset-client-error');
    if (!el) return;
    el.textContent = msg;
    el.style.display = 'flex';
    setTimeout(() => { el.style.display = 'none'; }, 5000);
}

/* ── Helpers partagés ── */
function _evalPwdBar(val, barId, lblId) {
    let score = 0;
    if (val.length >= 8)            score++;
    if (/[A-Z]/.test(val))         score++;
    if (/[0-9]/.test(val))         score++;
    if (/[^A-Za-z0-9]/.test(val)) score++;
    const levels = [
        { w:'0%',   c:'#dee2e6', t:'' },
        { w:'25%',  c:'#dc3545', t:'Faible' },
        { w:'50%',  c:'#fd7e14', t:'Moyen' },
        { w:'75%',  c:'#ffc107', t:'Bon' },
        { w:'100%', c:'#198754', t:'Fort ✓' },
    ];
    const bar = document.getElementById(barId);
    const lbl = document.getElementById(lblId);
    if (bar) { bar.style.width = levels[score].w; bar.style.background = levels[score].c; }
    if (lbl) { lbl.textContent = levels[score].t; lbl.style.color = levels[score].c; }
}

function _checkPwdMatch(p1Id, p2Id, msgId) {
    const pwd = document.getElementById(p1Id)?.value;
    const cfm = document.getElementById(p2Id)?.value;
    const msg = document.getElementById(msgId);
    if (!msg || !cfm) return;
    if (pwd === cfm) {
        msg.textContent = '✓ Les mots de passe correspondent';
        msg.style.color = '#198754';
    } else {
        msg.textContent = '✗ Ne correspondent pas';
        msg.style.color = '#dc3545';
    }
}

/* ── Ouvrir le modal reset si ?reset_token= dans l'URL ── */
document.addEventListener('DOMContentLoaded', function () {
    const params = new URLSearchParams(window.location.search);
    const token  = params.get('reset_token');

    if (!token) return;

    /* Injecter le token dans le champ caché */
    const tokenInput = document.getElementById('resetTokenInput');
    if (tokenInput) tokenInput.value = token;

    /* Vérifier la validité du token via AJAX avant d'ouvrir le modal */
    fetch('auth2/check_reset_token.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ token: token })
    })
    .then(r => r.json())
    .then(data => {
        const modal = new bootstrap.Modal(document.getElementById('resetModal'));
        modal.show();

        if (!data.valid) {
            /* Token invalide → afficher message d'erreur dans le modal */
            document.getElementById('resetForm').style.display = 'none';
            document.getElementById('reset-token-error').style.display = 'block';
        }
    })
    .catch(() => {
        /* Erreur réseau → ouvrir quand même, l'API PHP validera à la soumission */
        const modal = new bootstrap.Modal(document.getElementById('resetModal'));
        modal.show();
    });

    /* Nettoyer l'URL (supprimer ?reset_token= de la barre d'adresse) */
    const cleanUrl = window.location.pathname;
    window.history.replaceState({}, document.title, cleanUrl);
});
</script>