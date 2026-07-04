<?php
/**
 * includes/scripts.php
 * Scripts communs : Bootstrap JS · script.js · scripts modals (togglePwd, etc.)
 * Requiert : session_start() déjà appelé dans index.php
 */
?>

<!-- script.js -->
<script src="assets/js/script.js?v=<?php echo filemtime('assets/js/script.js'); ?>" defer></script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- feedback.js -->
<script src="assets/js/feedback.js?v=<?php echo filemtime('assets/js/feedback.js'); ?>" defer></script>

<!-- ================================================
     Scripts modals (togglePwd, force mot de passe,
     ouverture automatique selon erreurs session)
================================================ -->
<script>
function togglePwd(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon  = document.getElementById(iconId);
    input.type  = input.type === 'password' ? 'text' : 'password';
    icon.className = input.type === 'password' ? 'bi bi-eye' : 'bi bi-eye-slash';
}

function evalForceReg(val) {
    const bar = document.getElementById('regPwdBar');
    const lbl = document.getElementById('regPwdLabel');
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
        { w:'100%', c:'#2C6BED', t:'Fort ✓' },
    ];
    bar.style.width      = levels[score].w;
    bar.style.background = levels[score].c;
    lbl.textContent      = levels[score].t;
    lbl.style.color      = levels[score].c;
}

function checkMatchReg() {
    const pwd = document.getElementById('regPwd').value;
    const cfm = document.getElementById('regConfirm').value;
    const msg = document.getElementById('regMatchMsg');
    if (!cfm) { msg.textContent = ''; return; }
    if (pwd === cfm) {
        msg.textContent = '✓ Les mots de passe correspondent';
        msg.style.color = '#2C6BED';
    } else {
        msg.textContent = '✗ Ne correspondent pas';
        msg.style.color = '#dc3545';
    }
}

document.addEventListener('DOMContentLoaded', () => {
    <?php if (!empty($_SESSION['register_erreur'])): ?>
        new bootstrap.Modal(document.getElementById('registerModal')).show();
    <?php endif; ?>
    <?php if (!empty($_SESSION['forgot_succes']) || !empty($_SESSION['forgot_erreur']) || !empty($_SESSION['reset_lien'])): ?>
        new bootstrap.Modal(document.getElementById('forgotModal')).show();
    <?php endif; ?>
    <?php if (!empty($_SESSION['login_erreur']) || !empty($_SESSION['msg_succes'])): ?>
        new bootstrap.Modal(document.getElementById('loginModal')).show();
    <?php endif; ?>
});
</script>
