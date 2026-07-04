# Chatbot Portfolio — Guide d'installation

## Structure des fichiers

```
chatbot/
├── index.html   ← Page principale (structure HTML)
├── style.css    ← Styles (mise en page, couleurs, animations)
├── chatbot.js   ← Logique frontend (envoi/affichage messages)
└── bot.php      ← Backend PHP (traitement et réponses)
```

## Installation

1. Copiez les 4 fichiers dans le dossier de votre serveur PHP
   (ex: `htdocs/`, `www/`, ou un sous-dossier de votre hébergement).

2. Ouvrez `index.html` via votre serveur local (XAMPP, WAMP, Laragon...)
   ou en ligne sur votre hébergement.

> ⚠️ Le fichier `bot.php` nécessite un serveur PHP actif.
>    Ouvrir `index.html` directement avec un navigateur (file://) ne fonctionnera pas.

## Personnalisation

### Changer le nom et le statut
Dans `index.html`, modifiez :
```html
<h2>Alex — Portfolio Assistant</h2>
<p>En ligne · répond en quelques secondes</p>
```

### Ajouter/modifier des réponses
Dans `bot.php`, chaque entrée du tableau `$knowledge` suit ce modèle :
```php
'ma_categorie' => [
    'keywords' => ['mot1', 'mot2', 'mot3'],
    'replies'  => [
        "Première réponse possible.",
        "Deuxième réponse possible (choisie aléatoirement).",
    ],
    'show_quick' => false, // true = afficher les boutons de réponse rapide
],
```

### Changer les couleurs
Dans `style.css`, modifiez les variables CSS :
```css
:root {
  --purple-main: #534AB7;  /* couleur principale */
  --teal-main:   #1D9E75;  /* couleur accent */
}
```

## Dépendances (CDN — aucune installation)
- Google Fonts : Syne + DM Mono
- Tabler Icons Webfont
