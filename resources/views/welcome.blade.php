<!DOCTYPE html>
<html lang="fr" x-data="{ dark: false }" :class="dark ? 'dark' : ''">
<head>
    <meta charset="UTF-8">
    <title>ClinixPro - Plateforme SaaS de Gestion Médicale</title>

    @vite('resources/css/app.css')
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        .animated-gradient {
            background: linear-gradient(-45deg, #2563eb, #0ea5e9, #3b82f6, #1e40af);
            background-size: 400% 400%;
            animation: gradientMove 10s ease infinite;
        }

        @keyframes gradientMove {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .card-hover {
            transition: all 0.4s ease;
        }

        .card-hover:hover {
            transform: translateY(-10px);
            box-shadow: 0 25px 50px rgba(0,0,0,0.12);
        }
    </style>
</head>

<body class="bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-200 transition duration-500">

{{-- NAVBAR --}}
<nav class="fixed w-full bg-white/80 dark:bg-gray-900/80 backdrop-blur-md shadow-sm z-50">
    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
        <h1 class="text-2xl font-bold text-blue-600">ClinixPro</h1>

        <div class="flex items-center space-x-6">
            <a href="#solution">Solution</a>
            <a href="#features">Fonctionnalités</a>
            <a href="#pricing">Tarifs</a>
            <button @click="dark = !dark" class="px-3 py-1 border rounded-lg text-sm">
                Mode
            </button>
            <a href="/admin"
               class="bg-blue-600 text-white px-5 py-2 rounded-xl hover:bg-blue-700 transition">
                Connexion
            </a>
        </div>
    </div>
</nav>

{{-- HERO --}}
<section class="min-h-screen flex items-center pt-20 animated-gradient text-white">
    <div class="max-w-7xl mx-auto px-6 text-center">
        <h2 class="text-5xl md:text-6xl font-extrabold mb-6 leading-tight">
            Digitalisez et automatisez<br>
            la gestion complète de votre clinique
        </h2>

        <p class="text-xl max-w-3xl mx-auto mb-8 opacity-90">
            ClinixPro est une plateforme SaaS intelligente conçue pour les cliniques,
            cabinets médicaux et hôpitaux souhaitant moderniser leurs opérations,
            sécuriser leurs données et améliorer leur performance.
        </p>

        <div class="flex justify-center space-x-6">
            <a href="/register"
               class="bg-white text-blue-600 px-8 py-4 rounded-2xl font-semibold hover:scale-105 transition">
                Essai gratuit 14 jours
            </a>
            <a href="#solution"
               class="border border-white px-8 py-4 rounded-2xl hover:bg-white hover:text-blue-600 transition">
                En savoir plus
            </a>
        </div>
    </div>
</section>

{{-- PROBLÈME --}}
<section class="py-24 bg-gray-50 dark:bg-gray-800">
    <div class="max-w-6xl mx-auto px-6 text-center">
        <h3 class="text-4xl font-bold mb-8">Les défis des cliniques modernes</h3>

        <p class="max-w-3xl mx-auto text-lg text-gray-600 dark:text-gray-300">
            Beaucoup d'établissements médicaux souffrent encore de systèmes
            fragmentés, dossiers papier, erreurs administratives, manque
            de visibilité financière et perte de temps considérable.
            Ces inefficacités impactent directement la qualité des soins
            et la rentabilité.
        </p>
    </div>
</section>

{{-- SOLUTION --}}
<section id="solution" class="py-24 bg-white dark:bg-gray-900">
    <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-2 gap-12 items-center">

        <div>
            <h3 class="text-4xl font-bold mb-6">
                Une solution centralisée et intelligente
            </h3>

            <p class="text-gray-600 dark:text-gray-300 mb-6">
                ClinixPro regroupe dans une seule plateforme :
                gestion des patients, consultations, hospitalisations,
                prescriptions, facturation et statistiques avancées.
            </p>

            <ul class="space-y-4 text-gray-600 dark:text-gray-300">
                <li>✔ Centralisation des données</li>
                <li>✔ Réduction des erreurs administratives</li>
                <li>✔ Gain de temps pour le personnel</li>
                <li>✔ Amélioration de l’expérience patient</li>
            </ul>
        </div>

        <div class="bg-gray-100 dark:bg-gray-800 p-10 rounded-3xl shadow-xl">
            <h4 class="font-bold mb-4">Impact mesurable</h4>
            <p>+35% d’efficacité administrative</p>
            <p>-40% de temps de gestion manuel</p>
            <p>+20% d’optimisation des revenus</p>
        </div>
    </div>
</section>

{{-- WORKFLOW --}}
<section class="py-24 bg-gray-50 dark:bg-gray-800">
    <div class="max-w-6xl mx-auto px-6 text-center">
        <h3 class="text-4xl font-bold mb-16">Comment ça fonctionne ?</h3>

        <div class="grid md:grid-cols-3 gap-10">

            <div class="card-hover bg-white dark:bg-gray-900 p-8 rounded-2xl">
                <h4 class="font-semibold mb-4">1. Enregistrement</h4>
                <p>Créez votre clinique et configurez vos utilisateurs en quelques minutes.</p>
            </div>

            <div class="card-hover bg-white dark:bg-gray-900 p-8 rounded-2xl">
                <h4 class="font-semibold mb-4">2. Gestion quotidienne</h4>
                <p>Planifiez consultations, hospitalisations et prescriptions.</p>
            </div>

            <div class="card-hover bg-white dark:bg-gray-900 p-8 rounded-2xl">
                <h4 class="font-semibold mb-4">3. Analyse & Optimisation</h4>
                <p>Suivez vos statistiques et améliorez vos performances.</p>
            </div>

        </div>
    </div>
</section>

{{-- SÉCURITÉ --}}
<section class="py-24 bg-white dark:bg-gray-900">
    <div class="max-w-5xl mx-auto px-6 text-center">
        <h3 class="text-4xl font-bold mb-8">Sécurité & Conformité</h3>

        <p class="text-lg text-gray-600 dark:text-gray-300 mb-6">
            Nous protégeons les données médicales avec les plus hauts standards :
        </p>

        <ul class="space-y-3 text-gray-600 dark:text-gray-300">
            <li>🔐 Chiffrement des données</li>
            <li>🛡 Sauvegardes automatiques</li>
            <li>📜 Conformité RGPD</li>
            <li>👥 Gestion avancée des rôles et permissions</li>
        </ul>
    </div>
</section>

{{-- TÉMOIGNAGES --}}
<section class="py-24 bg-gray-50 dark:bg-gray-800">
    <div class="max-w-6xl mx-auto px-6 text-center">
        <h3 class="text-4xl font-bold mb-12">Ils nous font confiance</h3>

        <div class="grid md:grid-cols-2 gap-8">

            <div class="bg-white dark:bg-gray-900 p-8 rounded-2xl shadow">
                <p class="italic mb-4">
                    "ClinixPro a transformé la gestion de notre clinique.
                    Nous avons gagné en efficacité et en transparence."
                </p>
                <p class="font-semibold">Dr. Ahmed M.</p>
            </div>

            <div class="bg-white dark:bg-gray-900 p-8 rounded-2xl shadow">
                <p class="italic mb-4">
                    "Une solution complète, intuitive et puissante."
                </p>
                <p class="font-semibold">Directrice Clinique Santé+</p>
            </div>

        </div>
    </div>
</section>

{{-- FAQ --}}
<section class="py-24 bg-white dark:bg-gray-900">
    <div class="max-w-4xl mx-auto px-6">
        <h3 class="text-4xl font-bold mb-12 text-center">Questions fréquentes</h3>

        <div class="space-y-6">

            <div>
                <h4 class="font-semibold">Puis-je tester gratuitement ?</h4>
                <p class="text-gray-600 dark:text-gray-300">
                    Oui, nous proposons un essai gratuit de 14 jours.
                </p>
            </div>

            <div>
                <h4 class="font-semibold">Mes données sont-elles sécurisées ?</h4>
                <p class="text-gray-600 dark:text-gray-300">
                    Toutes les données sont chiffrées et sauvegardées automatiquement.
                </p>
            </div>

            <div>
                <h4 class="font-semibold">Puis-je gérer plusieurs cliniques ?</h4>
                <p class="text-gray-600 dark:text-gray-300">
                    Oui, via notre offre Enterprise multi-établissements.
                </p>
            </div>

        </div>
    </div>
</section>

{{-- CTA FINAL --}}
<section class="py-20 bg-blue-600 text-white text-center">
    <h3 class="text-4xl font-bold mb-6">
        Modernisez votre clinique dès aujourd’hui
    </h3>

    <p class="mb-8 text-lg">
        Rejoignez les établissements qui adoptent la transformation digitale.
    </p>

    <a href="/register"
       class="bg-white text-blue-600 px-8 py-4 rounded-2xl font-semibold hover:scale-105 transition">
        Créer mon compte
    </a>
</section>

<footer class="bg-gray-100 dark:bg-gray-800 py-12 text-center text-gray-500">
    © {{ date('Y') }} ClinixPro — Tous droits réservés
</footer>

</body>
</html>
