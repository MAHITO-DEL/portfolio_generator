<?php

class TemplateLoader {
    public static function getTemplates(string $root = 'portfolio_templates'): array {
        $templates = [];
        $baseDir = realpath($root);
        if (!$baseDir || !is_dir($baseDir)) {
            return $templates;
        }

        $directoryIterator = new RecursiveDirectoryIterator($baseDir, FilesystemIterator::SKIP_DOTS);
        $iterator = new RecursiveIteratorIterator($directoryIterator, RecursiveIteratorIterator::SELF_FIRST);
        $iterator->setMaxDepth(3);

        $found = [];
        foreach ($iterator as $file) {
            if (!$file->isFile()) {
                continue;
            }

            $filename = strtolower($file->getFilename());
            if (!in_array($filename, ['index.html', 'index.php'], true)) {
                continue;
            }

            $templateDir = $file->getPath();
            if (isset($found[$templateDir])) {
                continue;
            }
            $found[$templateDir] = true;

            $name = self::readTemplateTitle($templateDir) ?: self::humanizeName(basename($templateDir));
            $description = self::readTemplateDescription($templateDir);
            $preview = self::findPreviewImage($templateDir) ?: self::buildPlaceholderImage();
            $category = self::readTemplateCategory($root, $templateDir);

            $templates[] = [
                'key' => base64_encode($templateDir),
                'name' => $name,
                'description' => $description,
                'category' => $category,
                'path' => self::normalizeWebPath($file->getPathname()),
                'preview' => $preview,
            ];
        }

        usort($templates, static fn($a, $b) => strcasecmp($a['name'], $b['name']));
        return $templates;
    }

    private static function readTemplateTitle(string $templateDir): string {
        foreach (['README.txt', 'README.md'] as $readme) {
            $path = $templateDir . DIRECTORY_SEPARATOR . $readme;
            if (!is_file($path)) {
                continue;
            }

            $content = trim(file_get_contents($path));
            if (!$content) {
                continue;
            }

            $lines = preg_split('/\r?\n/', $content);
            if ($lines && trim($lines[0]) !== '') {
                return trim($lines[0]);
            }
        }

        return '';
    }

    private static function readTemplateDescription(string $templateDir): string {
        foreach (['README.txt', 'README.md'] as $readme) {
            $path = $templateDir . DIRECTORY_SEPARATOR . $readme;
            if (!is_file($path)) {
                continue;
            }

            $content = trim(preg_replace('/\r\n?/', "\n", file_get_contents($path)));
            $paragraphs = preg_split('/\n{2,}/', $content);
            foreach ($paragraphs as $paragraph) {
                $paragraph = trim(strip_tags($paragraph));
                if ($paragraph !== '' && strlen($paragraph) > 20) {
                    return preg_replace('/\s+/', ' ', $paragraph);
                }
            }
        }

        return 'A polished responsive portfolio layout with professional structure.';
    }

    private static function readTemplateCategory(string $root, string $templateDir): string {
        $relative = str_replace(['\\', '/'], DIRECTORY_SEPARATOR, ltrim(str_replace(realpath($root), '', realpath($templateDir)), DIRECTORY_SEPARATOR));
        $parts = array_filter(explode(DIRECTORY_SEPARATOR, $relative));
        return $parts[0] ?? 'Portfolio';
    }

    private static function findPreviewImage(string $templateDir): ?string {
        $candidates = [];
        $preferred = ['preview', 'screenshot', 'banner', 'thumb', 'cover', 'hero'];
        $allowed = ['png', 'jpg', 'jpeg', 'webp', 'gif'];

        $directoryIterator = new RecursiveDirectoryIterator($templateDir, FilesystemIterator::SKIP_DOTS);
        $iterator = new RecursiveIteratorIterator($directoryIterator, RecursiveIteratorIterator::SELF_FIRST);
        $iterator->setMaxDepth(3);

        foreach ($iterator as $file) {
            if (!$file->isFile()) {
                continue;
            }
            $extension = strtolower(pathinfo($file->getFilename(), PATHINFO_EXTENSION));
            if (!in_array($extension, $allowed, true)) {
                continue;
            }

            $filename = strtolower($file->getBasename('.' . $extension));
            $score = 999;
            foreach ($preferred as $index => $prefix) {
                if (strpos($filename, $prefix) !== false) {
                    $score = $index;
                    break;
                }
            }
            $candidates[] = ['path' => $file->getPathname(), 'score' => $score];
        }

        usort($candidates, static fn($a, $b) => $a['score'] <=> $b['score']);
        if (count($candidates) > 0) {
            return self::normalizeWebPath($candidates[0]['path']);
        }

        return null;
    }

    private static function buildPlaceholderImage(): string {
        $svg = '<svg xmlns="http://www.w3.org/2000/svg" width="1200" height="900" viewBox="0 0 1200 900"><defs><linearGradient id="g" x1="0" y1="0" x2="1" y2="1"><stop offset="0%" stop-color="#161616"/><stop offset="100%" stop-color="#030303"/></linearGradient></defs><rect width="1200" height="900" fill="url(%23g)"/><text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle" font-family="Inter, sans-serif" fill="#9ca3af" font-size="48">Portfolio template preview</text></svg>';
        return 'data:image/svg+xml;charset=UTF-8,' . rawurlencode($svg);
    }

    private static function normalizeWebPath(string $path): string {
        $path = str_replace('\\', '/', $path);
        $root = str_replace('\\', '/', realpath('.') . '/');
        if (strpos($path, $root) === 0) {
            $path = substr($path, strlen($root));
        }
        return ltrim($path, '/');
    }
}
