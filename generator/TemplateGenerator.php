<?php

require_once __DIR__ . '/TemplateLoader.php';

class TemplateGenerator {
    public static function generateFromTemplate(string $templatePath, array $data): string {
        $baseTemplates = realpath(__DIR__ . '/../portfolio_templates');
        $absolutePath = realpath(__DIR__ . '/../' . $templatePath);

        if (!$absolutePath || strpos($absolutePath, $baseTemplates) !== 0 || !is_file($absolutePath)) {
            throw new RuntimeException('Invalid template path.');
        }

        $html = file_get_contents($absolutePath);
        if ($html === false) {
            throw new RuntimeException('Unable to load selected template.');
        }

        $data = self::normalizeData($data);
        $webBase = dirname(str_replace('\\', '/', $templatePath));
        $html = self::ensureBaseHref($html, $webBase);
        $html = self::replacePlaceholders($html, $data);
        $html = self::applyFallbackInjection($html, $data);

        return $html;
    }

    private static function normalizeData(array $data): array {
        return [
            'name' => trim($data['name'] ?? '') ?: 'Your Name',
            'title' => trim($data['title'] ?? '') ?: 'Portfolio Creator',
            'bio' => trim($data['bio'] ?? '') ?: 'A passionate creator with a story to share.',
            'email' => trim($data['email'] ?? ''),
            'phone' => trim($data['phone'] ?? ''),
            'skills' => self::formatSkills($data['skills'] ?? ''),
            'projects' => self::formatProjects($data['projects'] ?? []),
            'education' => self::formatEducation($data['education'] ?? []),
            'experience' => self::formatExperience($data['experience'] ?? []),
            'social' => [
                'github' => trim($data['github'] ?? ''),
                'linkedin' => trim($data['linkedin'] ?? ''),
                'behance' => trim($data['behance'] ?? ''),
                'dribbble' => trim($data['dribbble'] ?? ''),
                'instagram' => trim($data['instagram'] ?? ''),
            ],
            'profileImage' => trim($data['profileImage'] ?? ''),
            'theme' => trim($data['theme'] ?? ''),
            'accent' => trim($data['accent'] ?? ''),
            'sections' => [
                'contact' => isset($data['sections']['contact']) ? boolval($data['sections']['contact']) : true,
                'projects' => isset($data['sections']['projects']) ? boolval($data['sections']['projects']) : true,
                'skills' => isset($data['sections']['skills']) ? boolval($data['sections']['skills']) : true,
                'education' => isset($data['sections']['education']) ? boolval($data['sections']['education']) : false,
                'experience' => isset($data['sections']['experience']) ? boolval($data['sections']['experience']) : false,
            ],
        ];
    }

    private static function formatSkills(string $skills): array {
        $parts = array_filter(array_map('trim', preg_split('/[,;\n]+/', $skills)));
        return array_values($parts);
    }

    private static function formatProjects(array $projects): array {
        $result = [];
        foreach ($projects as $project) {
            if (empty($project['title']) && empty($project['description'])) {
                continue;
            }
            $result[] = [
                'title' => trim($project['title'] ?? ''),
                'description' => trim($project['description'] ?? ''),
                'image' => trim($project['image'] ?? ''),
            ];
        }
        return $result;
    }

    private static function formatEducation(array $education): array {
        return array_values(array_filter(array_map(function ($item) {
            if (empty(trim($item['degree'] ?? '')) && empty(trim($item['school'] ?? ''))) {
                return null;
            }
            return [
                'degree' => trim($item['degree'] ?? ''),
                'school' => trim($item['school'] ?? ''),
                'year' => trim($item['year'] ?? ''),
            ];
        }, $education)));
    }

    private static function formatExperience(array $experience): array {
        return array_values(array_filter(array_map(function ($item) {
            if (empty(trim($item['role'] ?? '')) && empty(trim($item['company'] ?? '')) ) {
                return null;
            }
            return [
                'role' => trim($item['role'] ?? ''),
                'company' => trim($item['company'] ?? ''),
                'duration' => trim($item['duration'] ?? ''),
                'summary' => trim($item['summary'] ?? ''),
            ];
        }, $experience)));
    }

    private static function ensureBaseHref(string $html, string $base): string {
        $base = rtrim($base, '/') . '/';
        $baseTag = '<base href="' . htmlspecialchars($base, ENT_QUOTES, 'UTF-8') . '">';
        if (stripos($html, '<base') !== false) {
            return preg_replace('/<base[^>]*>/i', $baseTag, $html, 1);
        }
        if (preg_match('/<head[^>]*>/i', $html)) {
            return preg_replace('/(<head[^>]*>)/i', '$1' . $baseTag, $html, 1);
        }
        return $baseTag . $html;
    }

    private static function replacePlaceholders(string $html, array $data): string {
        $tokens = [
            'name' => $data['name'],
            'title' => $data['title'],
            'bio' => $data['bio'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'skills' => implode(', ', $data['skills']),
            'projects' => self::renderProjectList($data['projects']),
            'education' => self::renderEducationList($data['education']),
            'experience' => self::renderExperienceList($data['experience']),
            'github' => $data['social']['github'],
            'linkedin' => $data['social']['linkedin'],
            'behance' => $data['social']['behance'],
            'dribbble' => $data['social']['dribbble'],
            'instagram' => $data['social']['instagram'],
            'profileImage' => $data['profileImage'],
            'theme' => $data['theme'],
            'accent' => $data['accent'],
            
            // Premium layout HTML sections
            'social_links' => self::renderSocialLinksList($data['social'], $data['email']),
            'skills_section' => self::renderSkillsSection($data['skills'], $data['sections']['skills']),
            'projects_section' => self::renderProjectsSection($data['projects'], $data['sections']['projects']),
            'education_section' => self::renderEducationSection($data['education'], $data['sections']['education']),
            'experience_section' => self::renderExperienceSection($data['experience'], $data['sections']['experience']),
            'contact_section' => self::renderContactSection($data['email'], $data['phone'], $data['sections']['contact']),
        ];

        foreach ($tokens as $key => $value) {
            // Note: HTML sections are pre-escaped in their respective render methods, so we replace them directly.
            if (in_array($key, ['skills_section', 'projects_section', 'education_section', 'experience_section', 'contact_section', 'social_links'], true)) {
                $html = str_replace('{{' . $key . '}}', $value, $html);
            } else {
                $html = str_replace('{{' . $key . '}}', htmlspecialchars($value, ENT_QUOTES, 'UTF-8'), $html);
            }
        }

        return $html;
    }

    private static function applyFallbackInjection(string $html, array $data): string {
        // Detect if this template already uses {{placeholder}} replacements (e.g. L'Extérieur).
        // For placeholder-based templates, skip regex injections that would corrupt already-rendered HTML.
        $isPlaceholderTemplate = stripos($html, 'sections-container') !== false
            || stripos($html, 'generated-section') !== false;

        $html = self::replaceFirstTag($html, 'title', htmlspecialchars($data['name'] . ' | ' . $data['title'], ENT_QUOTES, 'UTF-8'));
        $html = self::replaceFirstTag($html, 'h1', $data['name']);

        // Only replace h2 if this is NOT a placeholder-based template.
        // Placeholder templates render their own section headings (Skills, Projects, etc.)
        // so replacing the first h2 would corrupt a section heading.
        if (!$isPlaceholderTemplate) {
            $html = self::replaceFirstTag($html, 'h2', $data['title']);
            $html = self::replaceParagraphAfterHeading($html, 'h1', $data['bio']);
            $html = self::replaceSocialLinks($html, $data['social']);
            $html = self::replaceContactElements($html, $data);
        }

        // Only inject sections if they are missing (for standard templates with no placeholders).
        $html = self::injectSectionIfMissing($html, 'skills', self::renderSkillsSection($data['skills'], $data['sections']['skills']));
        $html = self::injectSectionIfMissing($html, 'projects', self::renderProjectsSection($data['projects'], $data['sections']['projects']));
        $html = self::injectSectionIfMissing($html, 'education', self::renderEducationSection($data['education'], $data['sections']['education']));
        $html = self::injectSectionIfMissing($html, 'experience', self::renderExperienceSection($data['experience'], $data['sections']['experience']));
        $html = self::injectSectionIfMissing($html, 'contact', self::renderContactSection($data['email'], $data['phone'], $data['sections']['contact']));

        if (!$isPlaceholderTemplate) {
            $html = self::injectProfileImage($html, $data['profileImage']);
        }

        // Inject global responsive styles for fallback sections in standard templates
        return self::injectGlobalStyles($html);
    }

    private static function replaceFirstTag(string $html, string $tag, string $content): string {
        if (trim($content) === '') {
            return $html;
        }

        return preg_replace('/<' . $tag . '[^>]*>.*?<\/' . $tag . '>/is', '<' . $tag . '>' . $content . '</' . $tag . '>', $html, 1) ?: $html;
    }

    private static function replaceParagraphAfterHeading(string $html, string $heading, string $content): string {
        if (trim($content) === '') {
            return $html;
        }

        return preg_replace_callback(
            '/(<'.$heading.'[^>]*>.*?<\/'.$heading.'>)(.*?)(<p[^>]*>).*?(<\/p>)/is',
            static function ($matches) use ($content) {
                return $matches[1] . $matches[2] . $matches[3] . $content . $matches[4];
            },
            $html,
            1
        ) ?: $html;
    }

    private static function replaceSocialLinks(string $html, array $social): string {
        foreach ($social as $network => $url) {
            if (trim($url) === '') {
                continue;
            }
            $escapedUrl = htmlspecialchars($url, ENT_QUOTES, 'UTF-8');
            // Use a non-greedy, line-bounded match to avoid catastrophic backtracking.
            // Only replaces anchor hrefs that already contain the network name — does not
            // try to replace anchors whose content may span many lines (which blows up).
            $html = preg_replace(
                "/(<a[^>]*href=[\"'])(?:https?:\/\/)?[^\"']*" . preg_quote($network, '/') . "[^\"']*([\"'][^>]*>)([^<]*)<\/a>/i",
                '$1' . $escapedUrl . '$2$3</a>',
                $html
            );
        }
        return $html;
    }

    private static function replaceContactElements(string $html, array $data): string {
        if ($data['email'] !== '') {
            $escapedEmail = htmlspecialchars($data['email'], ENT_QUOTES, 'UTF-8');
            $html = preg_replace(
                "/<a([^>]*href=[\"']mailto:)[^\"']*([\"'][^>]*>).*?<\/a>/i",
                '<a$1' . $escapedEmail . '$2' . $escapedEmail . '</a>',
                $html
            );
        }
        if ($data['phone'] !== '') {
            $escapedPhone = htmlspecialchars($data['phone'], ENT_QUOTES, 'UTF-8');
            $html = preg_replace(
                "/<a([^>]*href=[\"']tel:)[^\"']*([\"'][^>]*>).*?<\/a>/i",
                '<a$1' . $escapedPhone . '$2' . $escapedPhone . '</a>',
                $html
            );
        }
        return $html;
    }

    private static function injectSectionIfMissing(string $html, string $sectionId, string $sectionHtml): string {
        if ($sectionHtml === '') {
            return $html;
        }

        $needle = sprintf('id="%s"', $sectionId);
        if (stripos($html, $needle) !== false || stripos($html, 'class="' . $sectionId . '"') !== false) {
            return $html;
        }

        if (preg_match('/<header[^>]*>.*?<\/header>/is', $html, $matches)) {
            return str_replace($matches[0], $matches[0] . "\n" . $sectionHtml, $html);
        }

        return preg_replace('/(<body[^>]*>)/i', '$1' . "\n" . $sectionHtml, $html, 1) ?: $html;
    }

    private static function injectProfileImage(string $html, string $imageUrl): string {
        if ($imageUrl === '') {
            return $html;
        }

        $regex1 = "/<img([^>]*class=[\"'][^\"\\r\\n]*avatar[^\"\\r\\n]*[\"'][^>]*)>/i";
        if (preg_match($regex1, $html, $matches)) {
            return preg_replace($regex1, '<img$1 src="' . htmlspecialchars($imageUrl, ENT_QUOTES, 'UTF-8') . '">', $html, 1);
        }

        $regex2 = "/<img([^>]*class=[\"'][^\"\\r\\n]*(headshot|profile|picture)[^\"\\r\\n]*[\"'][^>]*)>/i";
        if (preg_match($regex2, $html, $matches)) {
            return preg_replace($regex2, '<img$1 src="' . htmlspecialchars($imageUrl, ENT_QUOTES, 'UTF-8') . '">', $html, 1);
        }

        return $html;
    }

    private static function renderSkillsSection(array $skills, bool $include): string {
        if (!$include || empty($skills)) {
            return '';
        }
        $items = '';
        foreach ($skills as $skill) {
            $items .= '<li>' . htmlspecialchars($skill, ENT_QUOTES, 'UTF-8') . '</li>';
        }
        return '<section id="skills" class="generated-section generated-skills"><div class="generated-inner"><h2>Skills</h2><ul>' . $items . '</ul></div></section>';
    }

    private static function renderProjectsSection(array $projects, bool $include): string {
        if (!$include || empty($projects)) {
            return '';
        }
        $items = '';
        foreach ($projects as $project) {
            $items .= '<article class="generated-project"><h3>' . htmlspecialchars($project['title'] ?: 'Project', ENT_QUOTES, 'UTF-8') . '</h3><p>' . htmlspecialchars($project['description'] ?: 'Project overview...', ENT_QUOTES, 'UTF-8') . '</p>' . ($project['image'] ? '<img src="' . htmlspecialchars($project['image'], ENT_QUOTES, 'UTF-8') . '" alt="'.htmlspecialchars($project['title'], ENT_QUOTES,'UTF-8').'">' : '') . '</article>';
        }
        return '<section id="projects" class="generated-section generated-projects"><div class="generated-inner"><h2>Featured Projects</h2>' . $items . '</div></section>';
    }

    private static function renderEducationSection(array $education, bool $include): string {
        if (!$include || empty($education)) {
            return '';
        }
        $items = '';
        foreach ($education as $item) {
            $items .= '<div class="generated-education-item"><strong>' . htmlspecialchars($item['degree'], ENT_QUOTES, 'UTF-8') . '</strong><span>' . htmlspecialchars($item['school'], ENT_QUOTES, 'UTF-8') . '</span><em>' . htmlspecialchars($item['year'], ENT_QUOTES, 'UTF-8') . '</em></div>';
        }
        return '<section id="education" class="generated-section generated-education"><div class="generated-inner"><h2>Education</h2>' . $items . '</div></section>';
    }

    private static function renderExperienceSection(array $experience, bool $include): string {
        if (!$include || empty($experience)) {
            return '';
        }
        $items = '';
        foreach ($experience as $item) {
            $items .= '<div class="generated-experience-item"><strong>' . htmlspecialchars($item['role'], ENT_QUOTES, 'UTF-8') . '</strong><span>' . htmlspecialchars($item['company'], ENT_QUOTES, 'UTF-8') . '</span><em>' . htmlspecialchars($item['duration'], ENT_QUOTES, 'UTF-8') . '</em><p>' . htmlspecialchars($item['summary'], ENT_QUOTES, 'UTF-8') . '</p></div>';
        }
        return '<section id="experience" class="generated-section generated-experience"><div class="generated-inner"><h2>Experience</h2>' . $items . '</div></section>';
    }

    private static function renderProjectList(array $projects): string {
        return implode(', ', array_map(static fn($project) => trim(($project['title'] ?? '') . ' - ' . ($project['description'] ?? '')), $projects));
    }

    private static function renderEducationList(array $education): string {
        return implode(', ', array_map(static fn($item) => trim(($item['degree'] ?? '') . ' at ' . ($item['school'] ?? '')), $education));
    }

    private static function renderExperienceList(array $experience): string {
        return implode(', ', array_map(static fn($item) => trim(($item['role'] ?? '') . ' at ' . ($item['company'] ?? '')), $experience));
    }

    private static function renderSocialLinksList(array $social, string $email): string {
        $html = '';
        $icons = [
            'github' => 'icon brands fa-github',
            'linkedin' => 'icon brands fa-linkedin-in',
            'behance' => 'icon brands fa-behance',
            'dribbble' => 'icon brands fa-dribbble',
            'instagram' => 'icon brands fa-instagram',
        ];
        
        $delayIndex = 1;
        foreach ($social as $network => $url) {
            if ($url !== '') {
                $escapedUrl = htmlspecialchars($url, ENT_QUOTES, 'UTF-8');
                $class = $icons[$network] ?? 'icon solid fa-link';
                // Preserving HTML5 UP Aerial animation delay class/attribute style
                $html .= '<li style="animation-delay: ' . (2.25 + $delayIndex * 0.25) . 's;"><a href="' . $escapedUrl . '" target="_blank" class="' . $class . '"><span class="label">' . ucfirst($network) . '</span></a></li>';
                $delayIndex++;
            }
        }
        
        if ($email !== '') {
            $escapedEmail = htmlspecialchars($email, ENT_QUOTES, 'UTF-8');
            $html .= '<li style="animation-delay: ' . (2.25 + $delayIndex * 0.25) . 's;"><a href="mailto:' . $escapedEmail . '" class="icon solid fa-envelope"><span class="label">Email</span></a></li>';
        }
        
        return $html;
    }

    private static function renderContactSection(string $email, string $phone, bool $include): string {
        if (!$include || ($email === '' && $phone === '')) {
            return '';
        }
        $items = '';
        if ($email !== '') {
            $escapedEmail = htmlspecialchars($email, ENT_QUOTES, 'UTF-8');
            $items .= '<div class="contact-item"><i class="icon solid fa-envelope"></i><strong>Email</strong><a href="mailto:' . $escapedEmail . '">' . $escapedEmail . '</a></div>';
        }
        if ($phone !== '') {
            $escapedPhone = htmlspecialchars($phone, ENT_QUOTES, 'UTF-8');
            $items .= '<div class="contact-item"><i class="icon solid fa-phone"></i><strong>Phone</strong><a href="tel:' . $escapedPhone . '">' . $escapedPhone . '</a></div>';
        }
        return '<section id="contact" class="generated-section generated-contact"><div class="generated-inner"><h2>Contact Me</h2><div class="contact-grid">' . $items . '</div></div></section>';
    }

    private static function injectGlobalStyles(string $html): string {
        $styleBlock = '
		<!-- Injected Global Styles for Dynamic Fallback Sections -->
		<style>
			.generated-section {
				padding: 3rem 2rem;
				background: rgba(15, 15, 15, 0.95);
				border-top: 1px solid rgba(255, 255, 255, 0.08);
				color: #e5e7eb;
				font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
				text-align: left;
				box-sizing: border-box;
			}
			.generated-inner {
				max-width: 900px;
				margin: 0 auto;
			}
			.generated-section h2 {
				font-size: 1.85rem;
				font-weight: 800;
				margin-top: 0;
				margin-bottom: 2rem;
				border-bottom: 3px solid var(--accent-color, #ef4444);
				display: inline-block;
				padding-bottom: 0.5rem;
				color: #fff;
			}
			.generated-skills ul {
				display: flex;
				flex-wrap: wrap;
				gap: 0.75rem;
				padding: 0;
				margin: 0;
				list-style: none;
			}
			.generated-skills li {
				background: rgba(255, 255, 255, 0.08);
				border: 1px solid rgba(255, 255, 255, 0.15);
				padding: 0.5rem 1.2rem;
				border-radius: 50px;
				font-weight: 500;
				font-size: 0.95rem;
				transition: all 0.3s ease;
			}
			.generated-skills li:hover {
				background: var(--accent-color, #ef4444);
				border-color: var(--accent-color, #ef4444);
				color: white;
				transform: translateY(-2px);
				box-shadow: 0 4px 12px var(--accent-glow, rgba(239, 68, 68, 0.3));
			}
			.generated-projects {
				display: grid;
				gap: 2.5rem;
			}
			.generated-project {
				background: rgba(255, 255, 255, 0.03);
				border: 1px solid rgba(255, 255, 255, 0.08);
				border-radius: 16px;
				padding: 2rem;
				box-sizing: border-box;
				transition: all 0.3s ease;
			}
			.generated-project:hover {
				background: rgba(255, 255, 255, 0.05);
				border-color: var(--accent-color, #ef4444);
				transform: translateY(-4px);
			}
			.generated-project h3 {
				font-size: 1.45rem;
				font-weight: 700;
				margin-top: 0;
				margin-bottom: 0.75rem;
				color: #fff;
			}
			.generated-project p {
				font-size: 1rem;
				color: #9ca3af;
				line-height: 1.6;
				margin-bottom: 1.5rem;
			}
			.generated-project img {
				width: 100%;
				max-height: 380px;
				object-fit: cover;
				border-radius: 8px;
			}
			.generated-experience-item, .generated-education-item {
				position: relative;
				padding-left: 2rem;
				border-left: 2px solid rgba(255, 255, 255, 0.1);
				margin-bottom: 2.5rem;
			}
			.generated-experience-item:last-child, .generated-education-item:last-child {
				margin-bottom: 0;
			}
			.generated-experience-item::before, .generated-education-item::before {
				content: "";
				position: absolute;
				left: -6px;
				top: 6px;
				width: 10px;
				height: 10px;
				border-radius: 50%;
				background: var(--accent-color, #ef4444);
				box-shadow: 0 0 8px var(--accent-glow, rgba(239, 68, 68, 0.5));
			}
			.generated-experience-item strong, .generated-education-item strong {
				display: block;
				font-size: 1.25rem;
				color: #fff;
				font-weight: 700;
			}
			.generated-experience-item span, .generated-education-item span {
				display: inline-block;
				font-size: 0.95rem;
				color: var(--accent-color, #ef4444);
				font-weight: 600;
				margin-right: 1rem;
			}
			.generated-experience-item em, .generated-education-item em {
				font-size: 0.85rem;
				color: #9ca3af;
				font-style: normal;
			}
			.generated-experience-item p {
				margin-top: 0.75rem;
				color: #9ca3af;
				line-height: 1.6;
				margin-bottom: 0;
			}
			.contact-grid {
				display: grid;
				grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
				gap: 1.5rem;
			}
			.contact-item {
				background: rgba(255, 255, 255, 0.04);
				border: 1px solid rgba(255, 255, 255, 0.08);
				padding: 1.5rem;
				border-radius: 12px;
				display: flex;
				flex-direction: column;
				gap: 0.5rem;
				box-sizing: border-box;
				align-items: flex-start;
			}
			.contact-item i {
				font-size: 1.5rem;
				color: var(--accent-color, #ef4444);
				margin-bottom: 0.2rem;
			}
			.contact-item strong {
				font-size: 0.8rem;
				text-transform: uppercase;
				color: rgba(255, 255, 255, 0.5);
				letter-spacing: 0.1em;
			}
			.contact-item a {
				color: #fff;
				text-decoration: none;
				border-bottom: dotted 1px rgba(255, 255, 255, 0.3);
			}
			.contact-item a:hover {
				color: var(--accent-color, #ef4444);
				border-bottom-color: var(--accent-color, #ef4444);
			}
		</style>';
         
         if (preg_match('/<\/head>/i', $html)) {
             return preg_replace('/(<\/head>)/i', $styleBlock . "\n" . '$1', $html, 1);
         }
         return $html . $styleBlock;
    }
}
