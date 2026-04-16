<?php
/**
 * Resultado Page
 *
 * Exibe resultado do quiz com apóstolo matched e compatibilidades
 */
require_once SRC_PATH . '/includes/apostles.php';
require_once SRC_PATH . '/includes/db.php';
require_once SRC_PATH . '/includes/scoring.php';

// Pegar resultado
$resultId = $_GET['id'] ?? null;
if (!$resultId) {
    header('Location: /');
    exit;
}

$DB = Database::getInstance();
$quizRecord = $DB->fetchOne('SELECT * FROM quizzes WHERE id = ?', [$resultId]);

if (!$quizRecord) {
    header('Location: /');
    exit;
}

$result = json_decode($quizRecord['result'], true);
$mainApostle = getApostleById($result['mainApostleId']);
$compatibility = $result['compatibility'];

// Eixos para display
$axisLabels = [
    'leadership' => '⚓ Liderança',
    'action' => '⚡ Ação',
    'faith' => '✨ Fé',
    'innovation' => '🚀 Inovação',
    'community' => '🤝 Comunidade',
    'growth' => '📈 Crescimento'
];

$shareUrl = urlencode(APP_URL . '/resultado?id=' . $resultId);
$shareText = urlencode('Descobri meu apóstolo: ' . $mainApostle['name'] . ' (' . $mainApostle['emoji'] . ') - Qual é o seu?');
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo APP_NAME; ?> — Seu Resultado: <?php echo $mainApostle['name']; ?></title>
    <meta name="description" content="Você é <?php echo $mainApostle['name']; ?>! Descubra seu perfil espiritual completo.">
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

        .axis-bar {
            background: linear-gradient(90deg, #fbbf24 0%, #f59e0b 100%);
            transition: width 0.5s ease;
        }

        .compatibility-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .compatibility-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 20px -5px rgba(251, 191, 36, 0.2);
        }
    </style>
</head>
<body class="bg-slate-900 text-slate-100">

<!-- HEADER -->
<header class="sticky top-0 z-50 bg-slate-900/95 backdrop-blur border-b border-slate-800">
    <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
        <a href="/" class="text-2xl font-display font-bold gradient-text"><?php echo APP_NAME; ?></a>
        <a href="/quiz" class="px-4 py-2 text-amber-500 hover:text-amber-400 font-bold transition-colors">
            Refazer Quiz
        </a>
    </div>
</header>

<!-- HERO RESULTADO -->
<section class="hero-bg py-16 md:py-24 relative overflow-hidden">
    <div class="absolute inset-0 opacity-5">
        <div class="absolute top-20 left-10 w-96 h-96 bg-amber-500 rounded-full blur-3xl"></div>
    </div>

    <div class="relative max-w-4xl mx-auto px-4 text-center">
        <div class="text-6xl md:text-8xl mb-6 animate-bounce" style="animation-duration: 2s;">
            <?php echo $mainApostle['emoji']; ?>
        </div>

        <h1 class="text-5xl md:text-6xl font-display font-black leading-tight mb-4">
            Você é <?php echo $mainApostle['name']; ?>
        </h1>

        <h2 class="text-2xl md:text-3xl text-amber-400 font-bold mb-6">
            <?php echo $mainApostle['title']; ?>
        </h2>

        <p class="text-lg text-slate-300 max-w-2xl mx-auto mb-8">
            <?php echo $mainApostle['summary']; ?>
        </p>

        <div class="flex flex-wrap gap-3 justify-center mb-8">
            <a href="#compatibilidade" class="px-6 py-3 bg-amber-500 hover:bg-amber-600 text-slate-900 font-bold rounded-lg transition-all">
                Ver Compatibilidades →
            </a>
            <a href="#premium" class="px-6 py-3 border-2 border-amber-500 text-amber-500 hover:bg-amber-500/10 font-bold rounded-lg transition-all">
                🔓 Desbloquear Premium
            </a>
        </div>

        <p class="text-slate-400 text-sm">
            🔗 Referência: Mateus 10:1-4 | <?php echo ucfirst(str_replace('"', '', substr($mainApostle['biblical_text'], 0, 50))); ?>...
        </p>
    </div>
</section>

<!-- PROFUNDIDADE: Strengths & Blind Spots -->
<section class="bg-slate-800/50 py-16 md:py-24">
    <div class="max-w-4xl mx-auto px-4">
        <h2 class="text-4xl font-display font-bold text-center mb-12">Seu Perfil Detalhado</h2>

        <div class="grid md:grid-cols-2 gap-8">
            <!-- STRENGTHS -->
            <div class="bg-slate-900 border border-slate-700 rounded-2xl p-8">
                <h3 class="text-2xl font-bold mb-6 text-green-400">💪 Seus Poderes</h3>
                <ul class="space-y-4">
                    <?php foreach ($mainApostle['strengths'] as $strength): ?>
                        <li>
                            <h4 class="font-bold mb-1"><?php echo $strength['name']; ?></h4>
                            <p class="text-slate-400 text-sm"><?php echo $strength['description']; ?></p>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <!-- BLIND SPOTS -->
            <div class="bg-slate-900 border border-slate-700 rounded-2xl p-8">
                <h3 class="text-2xl font-bold mb-6 text-orange-400">⚠️ Seus Desafios</h3>
                <ul class="space-y-4">
                    <?php foreach ($mainApostle['blind_spots'] as $spot): ?>
                        <li>
                            <h4 class="font-bold mb-1"><?php echo $spot['name']; ?></h4>
                            <p class="text-slate-400 text-sm"><?php echo $spot['description']; ?></p>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>

        <!-- CRESCIMENTO -->
        <div class="mt-8 bg-gradient-to-r from-slate-900 to-slate-800 border border-slate-700 rounded-2xl p-8">
            <h3 class="text-2xl font-bold mb-4 text-blue-400">🌱 Seu Caminho de Crescimento</h3>
            <p class="text-slate-300 leading-relaxed">
                <?php echo $mainApostle['growth_advice']; ?>
            </p>
        </div>
    </div>
</section>

<!-- EIXOS -->
<section class="py-16 md:py-24 bg-slate-900">
    <div class="max-w-4xl mx-auto px-4">
        <h2 class="text-4xl font-display font-bold text-center mb-12">Seus 6 Eixos de Personalidade</h2>

        <div class="space-y-6">
            <?php foreach ($result['axes'] as $axis => $value): ?>
                <div>
                    <div class="flex justify-between mb-2">
                        <span class="font-bold"><?php echo $axisLabels[$axis]; ?></span>
                        <span class="text-amber-400 font-bold"><?php echo $value; ?>/100</span>
                    </div>
                    <div class="w-full h-3 bg-slate-700 rounded-full overflow-hidden">
                        <div class="axis-bar h-full" style="width: <?php echo $value; ?>%"></div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- COMPATIBILIDADE -->
<section id="compatibilidade" class="py-16 md:py-24 bg-slate-800/50">
    <div class="max-w-4xl mx-auto px-4">
        <h2 class="text-4xl font-display font-bold text-center mb-12">Compatibilidade com Outros Apóstolos</h2>

        <div class="grid md:grid-cols-2 gap-6">
            <?php
            $allApostles = getAllApostles();
            $count = 0;
            foreach ($compatibility as $apostleId => $percent) {
                if ($apostleId === $result['mainApostleId']) continue;

                $apostle = getApostleById($apostleId);
                if (!$apostle) continue;
                $count++;
                if ($count > 4) break;
                ?>

                <div class="compatibility-card bg-slate-900 border border-slate-700 rounded-xl p-6">
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <div class="text-4xl mb-2"><?php echo $apostle['emoji']; ?></div>
                            <h3 class="font-bold text-lg"><?php echo $apostle['name']; ?></h3>
                            <p class="text-sm text-slate-400"><?php echo $apostle['title']; ?></p>
                        </div>
                        <div class="text-3xl font-bold text-amber-400"><?php echo $percent; ?>%</div>
                    </div>
                    <div class="w-full h-2 bg-slate-700 rounded-full overflow-hidden">
                        <div class="axis-bar" style="width: <?php echo $percent; ?>%"></div>
                    </div>
                </div>

                <?php
            }
            ?>
        </div>
    </div>
</section>

<!-- PREMIUM CTA -->
<section id="premium" class="py-16 md:py-24 bg-gradient-to-r from-slate-900 via-slate-800 to-slate-900 border-t border-slate-700">
    <div class="max-w-3xl mx-auto px-4 text-center">
        <h2 class="text-4xl font-display font-bold mb-6">
            🔓 Desbloquear Perfil Premium
        </h2>

        <p class="text-xl text-slate-300 mb-8">
            Acesse análises profundas, recomendações personalizadas e um relatório PDF completo com seus insights espirituais.
        </p>

        <div class="bg-slate-900 border-2 border-amber-500 rounded-2xl p-8 mb-8">
            <div class="text-5xl font-bold text-amber-400 mb-3">R$ 19,90</div>
            <p class="text-slate-400 mb-6">Por uma única vez • Acesso vitalício</p>
            <a href="/pagamento" class="inline-block px-10 py-4 bg-amber-500 hover:bg-amber-600 text-slate-900 font-bold text-lg rounded-xl transition-all shadow-lg hover:shadow-xl hover:scale-105">
                Pagar com Pix 🔐
            </a>
        </div>

        <div class="grid md:grid-cols-3 gap-6">
            <div>
                <div class="text-3xl mb-2">📋</div>
                <h3 class="font-bold mb-2">Relatório Completo</h3>
                <p class="text-sm text-slate-400">PDF com análise profunda da sua personalidade</p>
            </div>
            <div>
                <div class="text-3xl mb-2">💭</div>
                <h3 class="font-bold mb-2">Recomendações</h3>
                <p class="text-sm text-slate-400">Dicas personalizadas baseadas no seu perfil</p>
            </div>
            <div>
                <div class="text-3xl mb-2">🔗</div>
                <h3 class="font-bold mb-2">Compatibilidade Integral</h3>
                <p class="text-sm text-slate-400">Análise com todos os 12 apóstolos</p>
            </div>
        </div>
    </div>
</section>

<!-- SHARE -->
<section class="py-8 bg-slate-900 border-t border-slate-800">
    <div class="max-w-3xl mx-auto px-4 text-center">
        <p class="text-slate-400 mb-4">Compartilhe seu resultado</p>
        <div class="flex gap-3 justify-center flex-wrap">
            <a href="https://www.whatsapp.com/send?text=<?php echo $shareText; ?>%20<?php echo $shareUrl; ?>" target="_blank" class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-bold rounded-lg transition-all">
                💬 WhatsApp
            </a>
            <a href="https://twitter.com/intent/tweet?text=<?php echo $shareText; ?>%20<?php echo $shareUrl; ?>" target="_blank" class="px-6 py-3 bg-blue-500 hover:bg-blue-600 text-white font-bold rounded-lg transition-all">
                𝕏 Twitter
            </a>
            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $shareUrl; ?>" target="_blank" class="px-6 py-3 bg-blue-700 hover:bg-blue-800 text-white font-bold rounded-lg transition-all">
                f Facebook
            </a>
            <button onclick="copyLink()" class="px-6 py-3 bg-slate-700 hover:bg-slate-600 text-white font-bold rounded-lg transition-all">
                🔗 Copiar Link
            </button>
        </div>
    </div>
</section>

<!-- FOOTER -->
<footer class="bg-slate-950 border-t border-slate-800 py-8 px-4">
    <div class="max-w-7xl mx-auto text-center text-slate-500 text-sm">
        <p>© 2026 <?php echo APP_NAME; ?> | Resultado ID: <?php echo htmlspecialchars($resultId); ?></p>
    </div>
</footer>

<script>
    function copyLink() {
        const url = '<?php echo APP_URL; ?>/resultado?id=<?php echo $resultId; ?>';
        navigator.clipboard.writeText(url).then(() => {
            alert('Link copiado para a área de transferência!');
        });
    }
</script>

</body>
</html>
