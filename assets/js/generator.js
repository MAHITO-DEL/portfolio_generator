document.addEventListener('DOMContentLoaded', () => {
    const previewPanel = document.getElementById('template-preview') || document.getElementById('template-preview-panel');
    const previewName = document.getElementById('preview-template-name');
    const previewCategory = document.getElementById('preview-template-category');
    const previewFrame = document.getElementById('template-preview-iframe');
    const generatedPanel = document.getElementById('generated-output-shell');
    const generatedFrame = document.getElementById('generated-portfolio-iframe');
    const clearSelectionBtn = document.getElementById('clear-template-selection');
    const backToTemplatesBtn = document.getElementById('back-to-templates');
    const editGeneratedBtn = document.getElementById('edit-generated');
    const downloadGeneratedBtn = document.getElementById('download-generated');
    const templateCards = Array.from(document.querySelectorAll('.temp-card'));
    const templatesArea = document.getElementById('templates-container') || document.querySelector('.templates-track');
    const scrollArea = document.querySelector('.templates-scroll-area');
    const searchInput = document.getElementById('gen-search');
    const form = document.getElementById('gen-form');
    let selectedTemplatePath = null;

    console.log('Generator initialized. Templates found in DOM:', templateCards.length);

    function syncHeaderHeight() {
        const header = document.querySelector('.site-header');
        if (!header) return;
        document.documentElement.style.setProperty('--site-header-height', `${header.offsetHeight}px`);
    }

    syncHeaderHeight();
    window.addEventListener('resize', syncHeaderHeight);
    window.addEventListener('scroll', syncHeaderHeight, { passive: true });

    function setSelectedTemplate(card) {
        if (!card) return;
        const templatePath = card.dataset.path;
        const templateName = card.dataset.name || 'Template';
        const templateCategory = card.dataset.category || 'Portfolio';

        console.log('Selected template:', templateName, '|', templatePath);

        templateCards.forEach(node => node.classList.toggle('selected-template', node === card));
        selectedTemplatePath = templatePath;
    }

    function clearSelectedTemplate() {
        selectedTemplatePath = null;
        templateCards.forEach(node => node.classList.remove('selected-template'));
        if (previewPanel) {
            previewPanel.classList.remove('visible');
            previewFrame.src = 'about:blank';
        }
    }

    if (searchInput) {
        searchInput.addEventListener('input', event => {
            const query = event.target.value.trim().toLowerCase();
            templateCards.forEach(card => {
                const name = card.dataset.name || '';
                const category = card.dataset.category || '';
                const description = card.dataset.description || '';
                const isMatch = [name, category, description].some(text => text.toLowerCase().includes(query));
                card.style.display = isMatch ? 'flex' : 'none';
            });
        });
    }

    templatesArea?.addEventListener('click', event => {
        const button = event.target.closest('.btn-use-template');
        if (!button) return;
        const card = button.closest('.temp-card');
        if (card) {
            setSelectedTemplate(card);
        }
    });

    clearSelectionBtn?.addEventListener('click', clearSelectedTemplate);
    backToTemplatesBtn?.addEventListener('click', () => {
        generatedPanel?.classList.remove('visible');
        clearSelectedTemplate();
    });
    editGeneratedBtn?.addEventListener('click', () => {
        generatedPanel?.classList.remove('visible');
    });
    downloadGeneratedBtn?.addEventListener('click', () => {
        if (generatedFrame?.contentWindow?.print) {
            generatedFrame.contentWindow.print();
            return;
        }
        alert('Download PDF is only available through the browser print dialog.');
    });

    function collectDynamicItems(containerId, blueprint) {
        const container = document.getElementById(containerId);
        if (!container) {
            return [];
        }

        return Array.from(container.children).map(group => {
            if (!group.matches('.dynamic-group')) {
                return null;
            }
            const data = {};
            blueprint.forEach(field => {
                const input = group.querySelector(field.selector);
                data[field.key] = input ? input.value.trim() : '';
            });
            return data;
        }).filter(Boolean);
    }

    function readFileAsDataUrl(file) {
        return new Promise((resolve, reject) => {
            const reader = new FileReader();
            reader.onload = () => resolve(reader.result);
            reader.onerror = () => reject(reader.error);
            reader.readAsDataURL(file);
        });
    }

    function collectFormData() {
        const sections = {
            contact: document.getElementById('t-contact')?.checked ?? true,
            projects: document.getElementById('t-projects')?.checked ?? true,
            skills: document.getElementById('t-skills')?.checked ?? true,
            education: document.getElementById('t-edu')?.checked ?? false,
            experience: document.getElementById('t-exp')?.checked ?? false,
        };

        return {
            name: document.getElementById('f-name')?.value || '',
            title: document.getElementById('f-title')?.value || '',
            bio: document.getElementById('f-bio')?.value || '',
            email: document.getElementById('f-email')?.value || '',
            phone: document.getElementById('f-phone')?.value || '',
            skills: document.getElementById('f-skills')?.value || '',
            github: document.getElementById('f-github')?.value || '',
            linkedin: document.getElementById('f-linkedin')?.value || '',
            behance: document.getElementById('f-behance')?.value || '',
            dribbble: document.getElementById('f-dribbble')?.value || '',
            instagram: document.getElementById('f-instagram')?.value || '',
            theme: document.getElementById('f-theme')?.value || '',
            accent: document.querySelector('input[name="color-accent"]:checked')?.value || '',
            sections,
            education: collectDynamicItems('edu-container', [
                { key: 'degree', selector: 'input:nth-of-type(1)' },
                { key: 'school', selector: 'input:nth-of-type(2)' },
                { key: 'year', selector: 'input:nth-of-type(3)' },
            ]),
            experience: collectDynamicItems('exp-container', [
                { key: 'role', selector: 'input:nth-of-type(1)' },
                { key: 'company', selector: 'input:nth-of-type(2)' },
                { key: 'duration', selector: 'input:nth-of-type(3)' },
                { key: 'summary', selector: 'textarea' },
            ]),
            projects: collectDynamicItems('proj-container', [
                { key: 'title', selector: 'input:nth-of-type(1)' },
                { key: 'description', selector: 'textarea' },
            ]),
            profileImage: '',
        };
    }

    async function attachFormImages(formData) {
        const profileInput = document.getElementById('f-profile');
        if (profileInput?.files?.length > 0) {
            formData.profileImage = await readFileAsDataUrl(profileInput.files[0]);
        }

        const projectGroups = document.querySelectorAll('#proj-container .dynamic-group');
        for (const [index, group] of Array.from(projectGroups).entries()) {
            const fileField = group.querySelector('input[type="file"].proj-image-input');
            if (fileField?.files?.length > 0 && formData.projects[index]) {
                formData.projects[index].image = await readFileAsDataUrl(fileField.files[0]);
            }
        }
    }

    async function generatePortfolio(event) {
        event.preventDefault();
        if (!selectedTemplatePath) {
            alert('Choose a template first to generate your portfolio.');
            return;
        }

        const payload = {
            template: selectedTemplatePath,
            data: collectFormData(),
        };

        await attachFormImages(payload.data);

        try {
            const response = await fetch('api/generate.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(payload),
            });

            const result = await response.json();
            if (!result.success) {
                throw new Error(result.error || 'Generation failed.');
            }

            if (generatedPanel) {
                generatedPanel.classList.add('visible');
                generatedFrame.srcdoc = result.html;
                generatedFrame.addEventListener('load', () => {
                    generatedFrame.classList.add('loaded');
                }, { once: true });
            }
        } catch (error) {
            console.error('Generation error:', error);
            alert('Unable to generate your portfolio. Please try again.');
        }
    }

    form?.addEventListener('submit', generatePortfolio);

    // Auto-select template if one was passed via URL query param
    const initialKey = document.body.dataset.selectedTemplate;
    if (initialKey) {
        const initialCard = templateCards.find(card => card.dataset.path === initialKey);
        if (initialCard) {
            setSelectedTemplate(initialCard);
        }
    }
});
