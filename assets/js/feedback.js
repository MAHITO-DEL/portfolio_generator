document.addEventListener('DOMContentLoaded', () => {
    const feedbackModalEl = document.getElementById('feedbackModal');
    const feedbackForm = document.getElementById('feedback-form');
    const openFeedbackBtn = document.getElementById('open-feedback-modal');
    const ratingStars = document.getElementById('rating-stars');
    const emailInput = document.getElementById('fb-email');
    const messageInput = document.getElementById('fb-message');
    const feedbackStatus = document.getElementById('feedback-status');
    const testimonialsTrack = document.getElementById('testimonials-track');
    const storageKey = 'portfolioGenFeedbackEmail';

    if (!feedbackModalEl || !feedbackForm || !openFeedbackBtn || !testimonialsTrack) {
        return;
    }

    const feedbackModal = new bootstrap.Modal(feedbackModalEl, {
        backdrop: 'static',
        keyboard: true,
    });

    let selectedRating = 0;
    let currentUserEmail = localStorage.getItem(storageKey) || '';

    function createStarButtons() {
        ratingStars.innerHTML = '';
        for (let value = 1; value <= 5; value++) {
            const button = document.createElement('button');
            button.type = 'button';
            button.className = 'feedback-star';
            button.dataset.value = String(value);
            button.title = `${value} star${value > 1 ? 's' : ''}`;
            button.textContent = '★';
            button.addEventListener('click', () => {
                selectedRating = value;
                updateStarUI();
                clearStatus();
            });
            ratingStars.appendChild(button);
        }
    }

    function updateStarUI() {
        Array.from(ratingStars.children).forEach(star => {
            const value = Number(star.dataset.value);
            star.classList.toggle('active', value <= selectedRating);
        });
    }

    function showStatus(message, type) {
        feedbackStatus.innerHTML = `<div class="alert alert-${type} py-2 mb-0">${message}</div>`;
    }

    function clearStatus() {
        feedbackStatus.innerHTML = '';
    }

    function isGmail(value) {
        return /^[^\s@]+@gmail\.com$/i.test(value.trim());
    }

    function createFeedbackCard(entry) {
        const isUserComment = Boolean(entry.isUserComment || (currentUserEmail && entry.email.toLowerCase() === currentUserEmail.toLowerCase()));
        const card = document.createElement('div');
        card.className = 'testimonial-card';
        if (isUserComment) {
            card.classList.add('your-comment');
        }

        const rating = document.createElement('div');
        rating.className = 'testimonial-rating';
        for (let i = 1; i <= 5; i++) {
            const star = document.createElement('span');
            star.textContent = i <= entry.rating ? '★' : '☆';
            rating.appendChild(star);
        }

        const message = document.createElement('p');
        message.className = 'testimonial-text';
        message.textContent = entry.message;

        const user = document.createElement('div');
        user.className = 'testimonial-user';

        const initials = document.createElement('div');
        initials.className = 'user-avatar';
        const letters = entry.email.match(/\b([A-Za-z])/g) || [entry.email.charAt(0)];
        initials.textContent = letters.slice(0, 2).join('').toUpperCase();

        const info = document.createElement('div');
        info.className = 'user-info';

        const name = document.createElement('span');
        name.className = 'user-name';
        name.textContent = entry.email;

        const role = document.createElement('span');
        role.className = 'user-role';
        role.textContent = entry.created_at;

        if (isUserComment) {
            const badge = document.createElement('span');
            badge.className = 'feedback-badge';
            badge.textContent = 'your comment';
            info.appendChild(badge);
        }

        info.appendChild(name);
        info.appendChild(role);
        user.appendChild(initials);
        user.appendChild(info);

        card.appendChild(rating);
        card.appendChild(message);
        card.appendChild(user);
        return card;
    }

    function appendFeedbackCard(entry) {
        const card = createFeedbackCard(entry);
        testimonialsTrack.appendChild(card);
        const clone = card.cloneNode(true);
        testimonialsTrack.appendChild(clone);
        if (typeof gsap !== 'undefined') {
            gsap.fromTo(card, { opacity: 0, y: 20 }, { opacity: 1, y: 0, duration: 0.5, ease: 'power3.out' });
        }
    }

    async function loadFeedback() {
        try {
            const response = await fetch('api/feedback.php');
            const result = await response.json();
            if (result.success && Array.isArray(result.feedback)) {
                result.feedback.forEach(entry => {
                    if (entry && entry.email && entry.message) {
                        appendFeedbackCard(entry);
                    }
                });
            }
        } catch (error) {
            console.error('Feedback load failed', error);
        }
    }

    async function submitFeedback(data) {
        const response = await fetch('api/feedback.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data),
        });
        return response.json();
    }

    feedbackModalEl.addEventListener('hidden.bs.modal', () => {
        document.body.classList.remove('feedback-open');
        clearStatus();
        feedbackForm.reset();
        selectedRating = 0;
        updateStarUI();
    });

    feedbackModalEl.addEventListener('shown.bs.modal', () => {
        emailInput.focus();
    });

    openFeedbackBtn.addEventListener('click', () => {
        selectedRating = 0;
        updateStarUI();
        clearStatus();
        feedbackModal.show();
        document.body.classList.add('feedback-open');
    });

    feedbackForm.addEventListener('submit', async event => {
        event.preventDefault();
        clearStatus();

        const email = emailInput.value.trim();
        const message = messageInput.value.trim();

        if (!email) {
            showStatus('Email is required.', 'danger');
            emailInput.focus();
            return;
        }
        if (!isGmail(email)) {
            showStatus('Please use a valid Gmail address ending in @gmail.com.', 'danger');
            emailInput.focus();
            return;
        }
        if (!selectedRating || selectedRating < 1 || selectedRating > 5) {
            showStatus('Please select a rating from 1 to 5 stars.', 'danger');
            return;
        }
        if (!message) {
            showStatus('Feedback message is required.', 'danger');
            messageInput.focus();
            return;
        }

        const payload = { email, rating: selectedRating, message };

        try {
            const result = await submitFeedback(payload);
            if (!result.success) {
                throw new Error(result.error || 'Unable to save feedback.');
            }

            currentUserEmail = email;
            localStorage.setItem(storageKey, email);
            showStatus('Thanks! Your feedback is submitted.', 'success');

            if (result.entry) {
                result.entry.isUserComment = true;
                appendFeedbackCard(result.entry);
            }

            feedbackForm.reset();
            selectedRating = 0;
            updateStarUI();

            setTimeout(() => {
                feedbackModal.hide();
            }, 1200);
        } catch (error) {
            console.error(error);
            showStatus('Unable to submit feedback right now. Please try again.', 'danger');
        }
    });

    createStarButtons();
    updateStarUI();
    loadFeedback();
});
