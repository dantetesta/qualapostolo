<?php
/**
 * Home Page — Landing
 */
require_once SRC_PATH . '/includes/apostles.php';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo APP_NAME; ?> — Descubra qual apóstolo você é</title>
    <meta name="description" content="Quiz personalidade para descobrir qual dos 12 apóstolos de Jesus você é mais parecido. Responda 20 questões e desbloqueie seu perfil completo.">
    <meta name="theme-color" content="#0f172a">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Lexend:wght@400;700&family=Playfair+Display:wght@700;900&display=swap');

        * {
            font-family: 'Lexend', sans-serif;
        }

        .font-display {
            font-family: 'Playfair Display', serif;
        }

        .gradient-text {
            background: linear-gradient(135deg, #fcd34d 0%, #f59e0b 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-bg {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        }

        .card-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .card-hover:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.3);
        }

        .apostle-card {
            position: relative;
            overflow: hidden;
        }

        .apostle-emoji {
            font-size: 3rem;
            line-height: 1;
        }

        @media (max-width: 640px) {
            .apostle-emoji {
                font-size: 2.5rem;
            }
        }
    </style>
</head>
<body class="bg-slate-900 text-slate-100">

<!-- HEADER -->
<header class="sticky top-0 z-50 bg-slate-900/95 backdrop-blur border-b border-slate-800">
    <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
        <div class="text-2xl font-display font-bold gradient-text"><?php echo APP_NAME; ?></div>
        <a href="#quiz" class="px-6 py-2 bg-amber-500 hover:bg-amber-600 text-slate-900 font-bold rounded-lg transition-colors">
            Começar
        </a>
    </div>
</header>

<!-- HERO SECTION -->
<section class="hero-bg pt-20 pb-16 md:pt-32 md:pb-24 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-20 left-10 w-72 h-72 bg-amber-500 rounded-full blur-3xl"></div>
        <div class="absolute bottom-20 right-10 w-72 h-72 bg-blue-500 rounded-full blur-3xl"></div>
    </div>

    <div class="relative max-w-4xl mx-auto px-4 text-center">
        <h1 class="text-5xl md:text-7xl font-display font-black leading-tight mb-6">
            Qual <span class="gradient-text">Apóstolo</span> você é?
        </h1>

        <p class="text-xl md:text-2xl text-slate-300 mb-8 max-w-2xl mx-auto">
            Descubra qual dos 12 apóstolos de Jesus você mais se parece. Responda 20 questões rápidas e receba seu perfil espiritual completo.
        </p>

        <div class="flex flex-col md:flex-row gap-4 justify-center mb-12">
            <a href="/quiz" class="px-8 py-4 bg-amber-500 hover:bg-amber-600 text-slate-900 font-bold text-lg rounded-lg transition-all shadow-lg hover:shadow-xl hover:scale-105">
                🚀 Começar Quiz (1 min)
            </a>
            <a href="#como" class="px-8 py-4 border-2 border-amber-500 text-amber-500 hover:bg-amber-500/10 font-bold text-lg rounded-lg transition-all">
                ℹ️ Como Funciona
            </a>
        </div>

        <div class="flex justify-center gap-8 text-sm text-slate-400">
            <div>✅ Gratuito</div>
            <div>✅ Sem Cadastro</div>
            <div>✅ Resultado Instant</div>
        </div>
    </div>
</section>

<!-- GRID APÓSTOLOS (Preview) -->
<section class="bg-slate-800/50 py-16 md:py-24">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-4xl md:text-5xl font-display font-bold mb-4">
                Os 12 Apóstolos
            </h2>
            <p class="text-slate-400 text-lg">Descubra qual é o seu</p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
            <?php
            $apostles = getAllApostles();
            $count = 0;
            foreach ($apostles as $apostle) {
                if ($count >= 12) break; // Mostrar apenas os 12 apóstolos principais
                $count++;
                ?>
                <div class="apostle-card bg-slate-900 border border-slate-700 rounded-xl p-6 text-center card-hover cursor-pointer hover:border-amber-500/50" onclick="showApostleModal('<?php echo $apostle['id']; ?>')">
                    <div class="apostle-emoji mb-3"><?php echo $apostle['emoji']; ?></div>
                    <h3 class="font-bold text-lg mb-1"><?php echo $apostle['name']; ?></h3>
                    <p class="text-sm text-slate-400"><?php echo $apostle['title']; ?></p>
                </div>
                <?php
            }
            ?>
        </div>

        <div class="mt-8 text-center">
            <p class="text-slate-400">Clique em um apóstolo para ver mais detalhes</p>
        </div>
    </div>
</section>

<!-- COMO FUNCIONA -->
<section id="como" class="py-16 md:py-24 bg-slate-900">
    <div class="max-w-4xl mx-auto px-4">
        <h2 class="text-4xl md:text-5xl font-display font-bold text-center mb-16">Como Funciona</h2>

        <div class="grid md:grid-cols-3 gap-8">
            <!-- Step 1 -->
            <div class="text-center">
                <div class="w-16 h-16 bg-amber-500/20 border-2 border-amber-500 rounded-full flex items-center justify-center mx-auto mb-6 text-2xl font-bold">
                    1
                </div>
                <h3 class="text-xl font-bold mb-3">Responda 20 Questões</h3>
                <p class="text-slate-400">
                    Quiz rápido (≈ 1 minuto) sobre sua personalidade, valores e forma de agir.
                </p>
            </div>

            <!-- Step 2 -->
            <div class="text-center">
                <div class="w-16 h-16 bg-amber-500/20 border-2 border-amber-500 rounded-full flex items-center justify-center mx-auto mb-6 text-2xl font-bold">
                    2
                </div>
                <h3 class="text-xl font-bold mb-3">Inteligência Artificial</h3>
                <p class="text-slate-400">
                    Nosso algoritmo analisa suas respostas e compara com os 6 eixos de personalidade dos apóstolos.
                </p>
            </div>

            <!-- Step 3 -->
            <div class="text-center">
                <div class="w-16 h-16 bg-amber-500/20 border-2 border-amber-500 rounded-full flex items-center justify-center mx-auto mb-6 text-2xl font-bold">
                    3
                </div>
                <h3 class="text-xl font-bold mb-3">Descubra Seu Apóstolo</h3>
                <p class="text-slate-400">
                    Receba seu resultado completo: apóstolo match, compatibilidades e insights espirituais.
                </p>
            </div>
        </div>

        <div class="mt-16 bg-slate-800 border border-slate-700 rounded-2xl p-8 md:p-12">
            <h3 class="text-2xl font-bold mb-6">Os 6 Eixos de Análise</h3>
            <div class="grid md:grid-cols-2 gap-6">
                <div class="flex gap-4">
                    <div class="text-2xl">⚓</div>
                    <div>
                        <h4 class="font-bold mb-1">Leadership</h4>
                        <p class="text-sm text-slate-400">Você lidera ou segue? Onde está sua autoridade?</p>
                    </div>
                </div>
                <div class="flex gap-4">
                    <div class="text-2xl">⚡</div>
                    <div>
                        <h4 class="font-bold mb-1">Action vs Reflection</h4>
                        <p class="text-sm text-slate-400">Age rápido ou pensa antes?</p>
                    </div>
                </div>
                <div class="flex gap-4">
                    <div class="text-2xl">✨</div>
                    <div>
                        <h4 class="font-bold mb-1">Faith vs Logic</h4>
                        <p class="text-sm text-slate-400">Segue intuição ou evidência?</p>
                    </div>
                </div>
                <div class="flex gap-4">
                    <div class="text-2xl">🚀</div>
                    <div>
                        <h4 class="font-bold mb-1">Innovation vs Tradition</h4>
                        <p class="text-sm text-slate-400">Abraça mudança ou prefere estabilidade?</p>
                    </div>
                </div>
                <div class="flex gap-4">
                    <div class="text-2xl">🤝</div>
                    <div>
                        <h4 class="font-bold mb-1">Community vs Solitude</h4>
                        <p class="text-sm text-slate-400">Recarrega em grupo ou sozinho?</p>
                    </div>
                </div>
                <div class="flex gap-4">
                    <div class="text-2xl">📈</div>
                    <div>
                        <h4 class="font-bold mb-1">Growth vs Stability</h4>
                        <p class="text-sm text-slate-400">Busca evoluir ou manter equilíbrio?</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA FINAL -->
<section class="py-16 md:py-24 bg-gradient-to-r from-slate-900 to-slate-800 border-t border-slate-700">
    <div class="max-w-4xl mx-auto px-4 text-center">
        <h2 class="text-4xl md:text-5xl font-display font-bold mb-6">
            Pronto para descobrir?
        </h2>
        <p class="text-xl text-slate-300 mb-8">
            Seu resultado espiritual completo em menos de 1 minuto
        </p>
        <a href="/quiz" class="inline-block px-8 py-4 bg-amber-500 hover:bg-amber-600 text-slate-900 font-bold text-lg rounded-lg transition-all shadow-lg hover:shadow-xl hover:scale-105">
            🚀 Começar Quiz
        </a>
    </div>
</section>

<!-- FOOTER -->
<footer class="bg-slate-950 border-t border-slate-800 py-8 px-4">
    <div class="max-w-7xl mx-auto text-center text-slate-500 text-sm">
        <p>© 2026 <?php echo APP_NAME; ?> | Descubra seu apóstolo interior</p>
        <p class="mt-2">Feito com ❤️ para explorar personalidade e espiritualidade</p>
    </div>
</footer>

<!-- MODAL APÓSTOLO (Placeholder) -->
<div id="apostleModal" class="hidden fixed inset-0 z-50 bg-black/70 flex items-center justify-center p-4">
    <div class="bg-slate-900 border border-slate-700 rounded-2xl max-w-md w-full max-h-[90vh] overflow-y-auto" id="modalContent">
        <!-- Preenchido por JS -->
    </div>
</div>

<script>
    function showApostleModal(apostleId) {
        // Placeholder: será implementado com dados do backend
        document.getElementById('apostleModal').classList.remove('hidden');
        document.getElementById('modalContent').innerHTML = `
            <div class="p-6">
                <button onclick="closeModal()" class="float-right text-2xl">&times;</button>
                <p>Modal para ${apostleId}</p>
            </div>
        `;
    }

    function closeModal() {
        document.getElementById('apostleModal').classList.add('hidden');
    }

    // Fechar ao clicar fora
    document.getElementById('apostleModal').addEventListener('click', function(e) {
        if (e.target === this) closeModal();
    });
</script>

</body>
</html>
