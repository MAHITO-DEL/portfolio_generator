<?php
/*
 * vip_payment_modal.php
 * Inclure JUSTE AVANT </body> dans templates.php
 * Usage : <?php require 'includes/vip_payment_modal.php'; ?>
 *
 * Ce fichier :
 *   1. Injecte le CSS du modal
 *   2. Injecte le HTML du modal
 *   3. Injecte le JS qui intercepte les clics VIP + gère le formulaire
 */
?>

<!-- Inter font -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<!-- ========================================================
     VIP PAYMENT MODAL — styles
     ======================================================== -->
<style>
/* ---- Variables couleurs bleu+rouge ---- */
:root {
    /* --vip-red:      #710319;
    --vip-red-soft: #7c071e; */
    --vip-blue:     #082673;
    --vip-blue-soft:#1a44b0;
    --vip-purple:   #1f0147;
    --vip-grad:     linear-gradient(135deg, #060756 0%, #460562 50%, #061a4f 100%);
    --vip-grad-btn: linear-gradient(135deg, #1e1077 0%, #03184f 100%);
    --vip-glow-r:   rgba(224,20,60,.28);
    --vip-glow-b:   rgba(34,85,212,.28);
    --vip-bg:       #08080f;
    --vip-bg2:      #0e0e1a;
    --vip-border:   rgba(255,255,255,.07);
    --vip-text:     #eeeef8;
    --vip-muted:    #7a7a9a;
    --vip-font:     'Inter', system-ui, sans-serif;
}

/* ---- Overlay ---- */
.vip-overlay {
    display: none;
    position: fixed;
    inset: 0;
    z-index: 9999;
    background: rgba(4, 4, 12, 0.78);
    backdrop-filter: blur(22px) saturate(160%);
    -webkit-backdrop-filter: blur(22px) saturate(160%);
    align-items: center;
    justify-content: center;
    padding: 20px;
}
.vip-overlay.open {
    display: flex;
    animation: vipFadeIn .22s ease both;
}
@keyframes vipFadeIn { from{opacity:0} to{opacity:1} }

/* ---- Boîte modale ---- */
.vip-box {
    width: 100%;
    max-width: 500px;
    background: var(--vip-bg2);
    border: 1px solid rgba(224,20,60,.2);
    border-radius: 22px;
    overflow: hidden;
    box-shadow:
        0 0 0 1px rgba(34,85,212,.15),
        0 40px 90px rgba(0,0,0,.8),
        inset 0 1px 0 rgba(255,255,255,.04);
    animation: vipSlideUp .32s cubic-bezier(.22,1,.36,1) both;
    max-height: 92vh;
    overflow-y: auto;
    scrollbar-width: thin;
    scrollbar-color: rgba(224,20,60,.3) transparent;
}
@keyframes vipSlideUp {
    from{opacity:0;transform:translateY(24px) scale(.97)}
    to  {opacity:1;transform:translateY(0)   scale(1)  }
}

/* ---- En-tête ---- */
.vip-head {
    padding: 24px 28px 18px;
    background: linear-gradient(135deg,
        rgba(224,20,60,.1) 0%,
        rgba(106,31,209,.06) 50%,
        rgba(34,85,212,.08) 100%);
    border-bottom: 1px solid rgba(255,255,255,.06);
    position: relative;
}
/* Ligne déco colorée en haut du header */
.vip-head::before {
    content: '';
    position: absolute; top: 0; left: 0; right: 0; height: 3px;
    background: var(--vip-grad);
}
.vip-badge {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 3px 11px;
    background: var(--vip-grad);
    color: #fff; border-radius: 100px;
    font-size: 10px; font-weight: 800; letter-spacing: 1.2px;
    text-transform: uppercase; margin-bottom: 10px;
    box-shadow: 0 2px 12px var(--vip-glow-r);
}
.vip-head-title {
    font-family: var(--vip-font);
    font-size: 19px; font-weight: 800; color: var(--vip-text);
    letter-spacing: -.3px; margin: 0 0 3px;
}
.vip-head-sub { font-size: 12px; color: var(--vip-muted); margin: 0; }
.vip-head-sub .tname { color: #7ba8ff; font-weight: 700; }
.vip-close {
    position: absolute; top: 16px; right: 16px;
    width: 30px; height: 30px; border-radius: 50%;
    background: rgba(255,255,255,.05); border: 1px solid rgba(255,255,255,.08);
    color: var(--vip-muted); font-size: 15px; cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    transition: all .18s; line-height: 1;
}
.vip-close:hover {
    background: rgba(224,20,60,.15);
    border-color: rgba(224,20,60,.35);
    color: var(--vip-red);
}

/* ---- Prix ---- */
.vip-price-bar {
    display: flex; align-items: center; gap: 14px;
    padding: 14px 28px;
    background: rgba(34,85,212,.05);
    border-bottom: 1px solid rgba(255,255,255,.05);
}
.vip-amount {
    font-family: 'Space Mono', monospace;
    font-size: 26px; font-weight: 700;
    background: var(--vip-grad);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    letter-spacing: -1px;
}
.vip-amount small {
    font-size: 14px;
    -webkit-text-fill-color: rgba(170,170,200,.5);
}
.vip-perks {
    margin-left: auto; display: flex; flex-direction: column; gap: 2px; text-align: right;
}
.vip-perk { font-size: 11px; color: #7ba8ff; display: flex; align-items: center; gap: 4px; justify-content: flex-end; }

/* ---- Corps ---- */
.vip-body { padding: 22px 28px 26px; }

/* Indicateurs d'étapes */
.vip-steps {
    display: flex; gap: 0; margin-bottom: 22px; position: relative;
}
.vip-steps::before {
    content: ''; position: absolute; top: 13px; left: 14px; right: 14px;
    height: 2px;
    background: linear-gradient(90deg, rgba(224,20,60,.2), rgba(34,85,212,.2));
    z-index: 0;
}
.vip-step { flex: 1; display: flex; flex-direction: column; align-items: center; gap: 5px; z-index: 1; }
.vip-step-dot {
    width: 26px; height: 26px; border-radius: 50%;
    background: rgba(255,255,255,.05); border: 2px solid rgba(255,255,255,.09);
    color: var(--vip-muted); font-size: 11px; font-weight: 700;
    display: flex; align-items: center; justify-content: center;
    font-family: 'Space Mono', monospace; transition: all .3s;
}
.vip-step.is-active .vip-step-dot {
    background: var(--vip-grad-btn);
    border-color: var(--vip-red);
    color: #fff;
    box-shadow: 0 0 14px var(--vip-glow-r), 0 0 28px var(--vip-glow-b);
}
.vip-step.is-done .vip-step-dot {
    background: rgba(34,85,212,.18);
    border-color: rgba(34,85,212,.5);
    color: #7ba8ff;
}
.vip-step-lbl { font-size: 10px; font-weight: 700; letter-spacing: .6px; text-transform: uppercase; color: #5a5a70; }
.vip-step.is-active .vip-step-lbl { color: #ff6b87; }
.vip-step.is-done  .vip-step-lbl  { color: #7ba8ff; }

/* Panneaux */
.vip-panel { display: none; }
.vip-panel.is-active { display: block; }

/* Champs */
.vip-field { margin-bottom: 16px; }
.vip-lbl {
    display: block; font-size: 10px; font-weight: 700;
    letter-spacing: .9px; text-transform: uppercase;
    color: var(--vip-muted); margin-bottom: 7px;
}
.vip-inp {
    width: 100%; background: rgba(255,255,255,.04);
    border: 1px solid rgba(255,255,255,.08); border-radius: 10px;
    padding: 11px 14px 11px 40px; color: var(--vip-text);
    font-family: var(--vip-font); font-size: 13px;
    outline: none; transition: border-color .2s, box-shadow .2s;
    -webkit-appearance: none;
}
.vip-inp.no-icon { padding-left: 14px; }
.vip-inp::placeholder { color: rgba(255,255,255,.15); }
.vip-inp:focus {
    border-color: rgba(34,85,212,.55);
    box-shadow: 0 0 0 3px rgba(34,85,212,.12);
}
.vip-inp.has-err {
    border-color: rgba(224,20,60,.5);
    box-shadow: 0 0 0 3px rgba(224,20,60,.08);
}
.vip-inp-wrap { position: relative; }
.vip-inp-wrap .vip-ico {
    position: absolute; left: 13px; top: 50%; transform: translateY(-50%);
    color: rgba(255,255,255,.2); font-size: 15px; pointer-events: none;
    transition: color .2s;
}
.vip-inp-wrap:focus-within .vip-ico { color: #7ba8ff; }
.vip-grid2 { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
.vip-err { display: none; font-size: 11px; color: #ff6b87; margin-top: 4px; padding-left: 2px; }
.vip-err.show { display: block; }

/* SELECT */
.vip-sel {
    appearance: none; -webkit-appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='11' height='11' viewBox='0 0 24 24' fill='none' stroke='%237a7a9a' stroke-width='2'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
    background-repeat: no-repeat; background-position: right 12px center;
    cursor: pointer;
}
.vip-sel option { background: #10101e; color: var(--vip-text); }

/* Sécurité */
.vip-sec-bar {
    display: flex; align-items: center; gap: 12px; flex-wrap: wrap;
    padding: 11px 14px; border-radius: 9px;
    background: linear-gradient(135deg, rgba(224,20,60,.06), rgba(34,85,212,.06));
    border: 1px solid rgba(34,85,212,.18);
    margin-bottom: 16px;
}
.vip-sec-item { display: flex; align-items: center; gap: 5px; font-size: 11px; color: #7ba8ff; font-weight: 600; }

/* Carte visuelle */
.vip-card-vis {
    height: 72px; border-radius: 12px;
    background: linear-gradient(135deg, #1a0820 0%, #0a1230 60%, #0e0820 100%);
    border: 1px solid rgba(34,85,212,.2);
    padding: 14px 18px; display: flex; align-items: center; gap: 12px;
    margin-bottom: 18px; position: relative; overflow: hidden;
}
.vip-card-vis::before {
    content:''; position:absolute; top:-20px; right:-20px;
    width:80px; height:80px; border-radius:50%;
    background: radial-gradient(circle, rgba(224,20,60,.15), transparent 70%);
}
.vip-card-vis::after {
    content:''; position:absolute; bottom:-20px; left:20px;
    width:60px; height:60px; border-radius:50%;
    background: radial-gradient(circle, rgba(34,85,212,.15), transparent 70%);
}
.vip-chip {
    width: 28px; height: 21px; border-radius: 4px;
    background: linear-gradient(135deg, var(--vip-blue), var(--vip-red));
    flex-shrink: 0;
}
.vip-num-prev {
    flex: 1; font-family: 'Space Mono', monospace;
    font-size: 12px; color: rgba(255,255,255,.35); letter-spacing: 3px;
}
.vip-circles { display: flex; }
.vip-circle { width: 20px; height: 20px; border-radius: 50%; opacity: .85; }
.vip-circle:first-child { background: var(--vip-red);  margin-right:-6px; z-index:1; }
.vip-circle:last-child  { background: var(--vip-blue); }

/* Boutons */
.vip-btn-main {
    width: 100%; background: var(--vip-grad-btn);
    color: #fff; border: none; border-radius: 10px;
    padding: 13px 22px; font-family: var(--vip-font);
    font-size: 14px; font-weight: 800; cursor: pointer;
    display: flex; align-items: center; justify-content: center; gap: 8px;
    transition: opacity .2s, transform .15s, box-shadow .2s; margin-top: 4px;
    letter-spacing: .2px;
    box-shadow: 0 4px 20px var(--vip-glow-r);
}
.vip-btn-main:hover {
    opacity: .92; transform: translateY(-1px);
    box-shadow: 0 6px 28px var(--vip-glow-r), 0 6px 28px var(--vip-glow-b);
}
.vip-btn-main:disabled { opacity: .5; cursor: not-allowed; transform: none; box-shadow: none; }
.vip-btn-back {
    background: transparent; color: var(--vip-muted);
    border: 1px solid rgba(255,255,255,.08); border-radius: 9px;
    padding: 10px 18px; font-family: var(--vip-font);
    font-size: 12px; font-weight: 600; cursor: pointer;
    display: inline-flex; align-items: center; gap: 6px;
    transition: all .18s;
}
.vip-btn-back:hover { border-color: rgba(34,85,212,.4); color: #7ba8ff; }
.vip-btn-row { display: flex; gap: 10px; margin-top: 18px; }
.vip-btn-row .vip-btn-main { flex: 1; margin-top: 0; }

/* Spinner */
.vip-spin {
    width: 16px; height: 16px; border-radius: 50%;
    border: 2px solid rgba(255,255,255,.25); border-top-color: #fff;
    animation: vspin .7s linear infinite; flex-shrink: 0;
}
@keyframes vspin { to{transform:rotate(360deg)} }

/* Succès */
.vip-ok { text-align: center; padding: 10px 0 4px; }
.vip-ok-icon {
    width: 64px; height: 64px; border-radius: 50%;
    background: linear-gradient(135deg, rgba(224,20,60,.12), rgba(34,85,212,.16));
    border: 2px solid rgba(34,85,212,.35);
    color: #7ba8ff; font-size: 26px;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 16px;
    box-shadow: 0 0 24px var(--vip-glow-b);
    animation: vokpop .45s cubic-bezier(.22,1,.36,1) both .1s;
}
@keyframes vokpop { from{transform:scale(.5);opacity:0} to{transform:scale(1);opacity:1} }
.vip-ok-title {
    font-family:var(--vip-font); font-size:20px; font-weight:800;
    color: var(--vip-text); margin-bottom:8px;
}
.vip-ok-sub { font-size:13px; color:var(--vip-muted); margin-bottom:20px; line-height:1.6; }
.vip-ok-sub strong {
    background: var(--vip-grad);
    -webkit-background-clip: text; -webkit-text-fill-color: transparent;
    background-clip: text;
}

/* Note légale */
.vip-legal { text-align:center; font-size:11px; color:#5a5a70; margin-top:14px; line-height:1.6; }
.vip-legal a {
    background: var(--vip-grad);
    -webkit-background-clip: text; -webkit-text-fill-color: transparent;
    background-clip: text; text-decoration: none;
}

/* Responsive */
@media(max-width:520px){
    .vip-box { border-radius:16px; }
    .vip-head,.vip-body { padding-left:18px; padding-right:18px; }
    .vip-price-bar { padding-left:18px; padding-right:18px; }
    .vip-grid2 { grid-template-columns:1fr; }
}
</style>

<!-- ========================================================
     VIP PAYMENT MODAL — HTML
     ======================================================== -->
<div class="vip-overlay" id="vipOverlay">
<div class="vip-box" role="dialog" aria-modal="true" aria-labelledby="vipTitle">

    <!-- EN-TÊTE -->
    <div class="vip-head">
        <div class="vip-badge">★ Accès VIP</div>
        <h2 class="vip-head-title" id="vipTitle">Débloquer le template</h2>
        <p class="vip-head-sub">Template : <span class="tname" id="vipTname">—</span> · Accès permanent</p>
        <button class="vip-close" id="vipCloseBtn" aria-label="Fermer">✕</button>
    </div>

    <!-- PRIX -->
    <div class="vip-price-bar">
        <div>
            <div class="vip-amount">€29<small>.99</small></div>
            <div style="font-size:11px;color:#5a5a70;margin-top:1px;">Paiement unique · Sans abonnement</div>
        </div>
        <div class="vip-perks">
            <div class="vip-perk"><i class="bi bi-check-circle-fill"></i> Accès permanent</div>
            <div class="vip-perk"><i class="bi bi-check-circle-fill"></i> Mises à jour incluses</div>
            <div class="vip-perk"><i class="bi bi-check-circle-fill"></i> Support prioritaire</div>
        </div>
    </div>

    <!-- CORPS -->
    <div class="vip-body">

        <!-- Indicateurs étapes -->
        <div class="vip-steps">
            <div class="vip-step is-active" id="vstep-1">
                <div class="vip-step-dot">1</div>
                <div class="vip-step-lbl">Infos</div>
            </div>
            <div class="vip-step" id="vstep-2">
                <div class="vip-step-dot">2</div>
                <div class="vip-step-lbl">Paiement</div>
            </div>
            <div class="vip-step" id="vstep-3">
                <div class="vip-step-dot">3</div>
                <div class="vip-step-lbl">Confirmation</div>
            </div>
        </div>

        <!-- ───── ÉTAPE 1 : Informations personnelles ───── -->
        <div class="vip-panel is-active" id="vpanel-1">

            <div class="vip-field">
                <label class="vip-lbl">Nom complet</label>
                <div class="vip-inp-wrap">
                    <i class="bi bi-person vip-ico"></i>
                    <input type="text" id="vi-name" class="vip-inp" placeholder="Nom Complet" autocomplete="name">
                </div>
                <div class="vip-err" id="ve-name">Veuillez entrer votre nom complet.</div>
            </div>

            <div class="vip-field">
                <label class="vip-lbl">Adresse e-mail</label>
                <div class="vip-inp-wrap">
                    <i class="bi bi-envelope vip-ico"></i>
                    <input type="email" id="vi-email" class="vip-inp" placeholder="gmail@exemple.com" autocomplete="email">
                </div>
                <div class="vip-err" id="ve-email">Adresse e-mail invalide.</div>
            </div>

            <div class="vip-grid2">
                <div class="vip-field">
                    <label class="vip-lbl">Pays</label>
                    <select id="vi-country" class="vip-inp vip-sel no-icon" style="padding-left:14px;">
                        <option value="">— Choisir —</option>
                        <option value="FR">🇫🇷 France</option>
                        <option value="MA">🇲🇦 Maroc</option>
                        <option value="BE">🇧🇪 Belgique</option>
                        <option value="CH">🇨🇭 Suisse</option>
                        <option value="CA">🇨🇦 Canada</option>
                        <option value="TN">🇹🇳 Tunisie</option>
                        <option value="DZ">🇩🇿 Algérie</option>
                        <option value="SN">🇸🇳 Sénégal</option>
                        <option value="OTHER">Autre</option>
                    </select>
                    <div class="vip-err" id="ve-country">Pays requis.</div>
                </div>
                <div class="vip-field">
                    <label class="vip-lbl">Code postal</label>
                    <input type="text" id="vi-zip" class="vip-inp no-icon" placeholder="75001" maxlength="10" autocomplete="postal-code">
                    <div class="vip-err" id="ve-zip">Code postal requis.</div>
                </div>
            </div>

            <button class="vip-btn-main" onclick="vipGo(2)">
                <i class="bi bi-arrow-right"></i> Continuer vers le paiement
            </button>
        </div>

        <!-- ───── ÉTAPE 2 : Paiement ───── -->
        <div class="vip-panel" id="vpanel-2">

            <!-- Badges sécurité -->
            <div class="vip-sec-bar">
                <div class="vip-sec-item"><i class="bi bi-shield-lock-fill"></i> Sécurisé</div>
                <div class="vip-sec-item"><i class="bi bi-lock-fill"></i> SSL 256-bit</div>
                <div class="vip-sec-item" style="margin-left:auto;"><i class="bi bi-patch-check-fill"></i> PCI-DSS</div>
            </div>

            <!-- Carte visuelle -->
            <div class="vip-card-vis">
                <div class="vip-chip"></div>
                <div class="vip-num-prev" id="vcardPrev">•••• •••• •••• ••••</div>
                <div class="vip-circles">
                    <div class="vip-circle"></div>
                    <div class="vip-circle"></div>
                </div>
            </div>

            <!-- Numéro -->
            <div class="vip-field">
                <label class="vip-lbl">Numéro de carte</label>
                <div class="vip-inp-wrap">
                    <i class="bi bi-credit-card vip-ico"></i>
                    <input type="text" id="vi-cnum" class="vip-inp" placeholder="1234 5678 9012 3456"
                           maxlength="19" inputmode="numeric"
                           oninput="vipFmtCard(this)" autocomplete="cc-number">
                </div>
                <div class="vip-err" id="ve-cnum">Numéro invalide (16 chiffres requis).</div>
            </div>

            <!-- Titulaire -->
            <div class="vip-field">
                <label class="vip-lbl">Titulaire de la carte</label>
                <div class="vip-inp-wrap">
                    <i class="bi bi-person-badge vip-ico"></i>
                    <input type="text" id="vi-holder" class="vip-inp" placeholder="JEAN DUPONT"
                           autocomplete="cc-name" oninput="this.value=this.value.toUpperCase()">
                </div>
                <div class="vip-err" id="ve-holder">Nom du titulaire requis.</div>
            </div>

            <!-- Expiry + CVV -->
            <div class="vip-grid2">
                <div class="vip-field">
                    <label class="vip-lbl">Expiration</label>
                    <input type="text" id="vi-exp" class="vip-inp no-icon" placeholder="MM/AA"
                           maxlength="5" inputmode="numeric"
                           oninput="vipFmtExp(this)" autocomplete="cc-exp">
                    <div class="vip-err" id="ve-exp">Date invalide ou expirée.</div>
                </div>
                <div class="vip-field">
                    <label class="vip-lbl">
                        CVV
                        <span title="3 chiffres au dos (4 pour Amex)" style="cursor:help;color:#D4AF37;font-size:10px;"> ?</span>
                    </label>
                    <div class="vip-inp-wrap">
                        <i class="bi bi-shield-shaded vip-ico"></i>
                        <input type="password" id="vi-cvv" class="vip-inp" placeholder="•••"
                               maxlength="4" inputmode="numeric" autocomplete="cc-csc">
                    </div>
                    <div class="vip-err" id="ve-cvv">CVV invalide.</div>
                </div>
            </div>

            <div class="vip-btn-row">
                <button class="vip-btn-back" onclick="vipGo(1)">
                    <i class="bi bi-arrow-left"></i> Retour
                </button>
                <button class="vip-btn-main" id="vipPayBtn" onclick="vipPay()">
                    <i class="bi bi-lock-fill"></i> Payer €29.99
                </button>
            </div>

            <div class="vip-legal">
                En cliquant sur Payer, vous acceptez nos
                <a href="#">Conditions d'utilisation</a> et notre
                <a href="#">Politique de confidentialité</a>.
            </div>
        </div>

        <!-- ───── ÉTAPE 3 : Succès ───── -->
        <div class="vip-panel" id="vpanel-3">
            <div class="vip-ok">
                <div class="vip-ok-icon"><i class="bi bi-check-lg"></i></div>
                <div class="vip-ok-title">Paiement confirmé !</div>
                <p class="vip-ok-sub">
                    Le template <strong id="vOkTname">—</strong> est débloqué.<br>
                    Un reçu a été envoyé à <strong id="vOkEmail">—</strong>.
                </p>
                <button class="vip-btn-main" style="max-width:300px;margin:0 auto;" onclick="vipRedirect()">
                    <i class="bi bi-rocket-takeoff"></i> Utiliser le template
                </button>
                <button class="vip-btn-back" style="margin:12px auto 0;display:flex;" onclick="vipClose()">
                    Retour aux templates
                </button>
            </div>
        </div>

    </div><!-- /.vip-body -->
</div><!-- /.vip-box -->
</div><!-- /.vip-overlay -->


<!-- ========================================================
     VIP PAYMENT MODAL — JavaScript
     ======================================================== -->
<script>
(function () {
    /* ── État ── */
    var _tname = '';
    var _step  = 1;

    /* ── Ouvrir ── */
    function open(templateName) {
        _tname = templateName;
        _step  = 1;
        document.getElementById('vipTname').textContent  = templateName;
        document.getElementById('vOkTname').textContent  = templateName;
        resetForm();
        setStep(1);
        document.getElementById('vipOverlay').classList.add('open');
        document.body.style.overflow = 'hidden';
    }
    window.openVipModal = open;

    /* ── Fermer ── */
    function close() {
        document.getElementById('vipOverlay').classList.remove('open');
        document.body.style.overflow = '';
    }
    window.vipClose = close;

    document.getElementById('vipCloseBtn').addEventListener('click', close);

    document.getElementById('vipOverlay').addEventListener('click', function (e) {
        if (e.target === this) close();
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') close();
    });

    /* ── Navigation entre étapes ── */
    function setStep(n) {
        /* Indicateurs */
        for (var i = 1; i <= 3; i++) {
            var ind = document.getElementById('vstep-' + i);
            ind.classList.remove('is-active', 'is-done');
            if (i < n)       ind.classList.add('is-done');
            else if (i === n) ind.classList.add('is-active');
        }
        /* Panneaux */
        for (var j = 1; j <= 3; j++) {
            document.getElementById('vpanel-' + j).classList.toggle('is-active', j === n);
        }
        _step = n;
    }

    window.vipGo = function (n) {
        if (n === 2 && !validateStep1()) return;
        setStep(n);
    };

    /* ── Réinitialisation ── */
    function resetForm() {
        var ids = ['vi-name','vi-email','vi-zip','vi-cnum','vi-holder','vi-exp','vi-cvv'];
        ids.forEach(function (id) {
            var el = document.getElementById(id);
            if (el) { el.value = ''; el.classList.remove('has-err'); }
        });
        var sel = document.getElementById('vi-country');
        if (sel) { sel.value = ''; sel.classList.remove('has-err'); }
        document.querySelectorAll('.vip-err').forEach(function (e) { e.classList.remove('show'); });
        document.getElementById('vcardPrev').textContent = '•••• •••• •••• ••••';
        var payBtn = document.getElementById('vipPayBtn');
        payBtn.disabled = false;
        payBtn.innerHTML = '<i class="bi bi-lock-fill"></i> Payer €29.99';
    }

    /* ── Validation étape 1 ── */
    function validateStep1() {
        var ok = true;

        var name = document.getElementById('vi-name').value.trim();
        setErr('vi-name', 've-name', name.length < 2);
        if (name.length < 2) ok = false;

        var email = document.getElementById('vi-email').value.trim();
        var emailOk = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
        setErr('vi-email', 've-email', !emailOk);
        if (!emailOk) ok = false;

        var country = document.getElementById('vi-country').value;
        setErr('vi-country', 've-country', !country);
        if (!country) ok = false;

        var zip = document.getElementById('vi-zip').value.trim();
        setErr('vi-zip', 've-zip', zip.length < 2);
        if (zip.length < 2) ok = false;

        return ok;
    }

    /* ── Validation étape 2 ── */
    function validateStep2() {
        var ok = true;

        var cnum = document.getElementById('vi-cnum').value.replace(/\s/g, '');
        setErr('vi-cnum', 've-cnum', cnum.length !== 16 || isNaN(cnum));
        if (cnum.length !== 16 || isNaN(cnum)) ok = false;

        var holder = document.getElementById('vi-holder').value.trim();
        setErr('vi-holder', 've-holder', holder.length < 2);
        if (holder.length < 2) ok = false;

        var exp = document.getElementById('vi-exp').value;
        var expOk = checkExpiry(exp);
        setErr('vi-exp', 've-exp', !expOk);
        if (!expOk) ok = false;

        var cvv = document.getElementById('vi-cvv').value;
        setErr('vi-cvv', 've-cvv', !/^\d{3,4}$/.test(cvv));
        if (!/^\d{3,4}$/.test(cvv)) ok = false;

        return ok;
    }

    function checkExpiry(val) {
        if (!/^\d{2}\/\d{2}$/.test(val)) return false;
        var parts = val.split('/');
        var mm = parseInt(parts[0], 10);
        var yy = parseInt(parts[1], 10);
        if (mm < 1 || mm > 12) return false;
        var now = new Date();
        var exp = new Date(2000 + yy, mm - 1, 1);
        return exp >= new Date(now.getFullYear(), now.getMonth(), 1);
    }

    function setErr(inpId, errId, hasErr) {
        document.getElementById(inpId).classList.toggle('has-err', hasErr);
        document.getElementById(errId).classList.toggle('show', hasErr);
    }

    /* ── Formatage numéro carte ── */
    window.vipFmtCard = function (inp) {
        var raw = inp.value.replace(/\D/g, '').slice(0, 16);
        inp.value = raw.replace(/(.{4})/g, '$1 ').trim();
        var prev = raw.padEnd(16, '•').replace(/(.{4})/g, '$1 ').trim();
        document.getElementById('vcardPrev').textContent = prev;
    };

    /* ── Formatage date expiration ── */
    window.vipFmtExp = function (inp) {
        var raw = inp.value.replace(/\D/g, '').slice(0, 4);
        inp.value = raw.length > 2 ? raw.slice(0, 2) + '/' + raw.slice(2) : raw;
    };

    /* ── Paiement ── */
    window.vipPay = function () {
        if (!validateStep2()) return;

        var btn = document.getElementById('vipPayBtn');
        btn.disabled = true;
        btn.innerHTML = '<div class="vip-spin"></div> Traitement...';

        /* Simuler appel API — remplacer par fetch('/api/payment', ...) */
        setTimeout(function () {
            var email = document.getElementById('vi-email').value.trim();
            document.getElementById('vOkEmail').textContent = email;

            /* Marquer étape 2 done manuellement avant setStep(3) */
            document.getElementById('vstep-2').classList.remove('is-active');
            document.getElementById('vstep-2').classList.add('is-done');
            setStep(3);
        }, 2000);
    };

    /* ── Redirection après succès ── */
    window.vipRedirect = function () {
        window.location.href = 'generator.php?template=' + encodeURIComponent(_tname) + '&vip=1';
    };

    /* ── Intercepter les boutons "Use Template" VIP ── */
    /*
     * On détecte qu'un template est VIP grâce au badge .template-badge.vip
     * dans la même .tm-card.
     * Si présent → on ouvre le modal au lieu de suivre le lien.
     */
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.tm-use-btn').forEach(function (btn) {
            var card = btn.closest('.tm-card');
            if (!card) return;
            var isVip = card.querySelector('.template-badge.vip');
            if (!isVip) return;

            /* C'est un template VIP : bloquer le lien et ouvrir le modal */
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                var tname = card.querySelector('.tm-card-title');
                open(tname ? tname.textContent.trim() : 'VIP Template');
            });
        });
    });

})();
</script>