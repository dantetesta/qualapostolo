<?php
/**
 * Pagamento Page — Mercado Pago Integration
 */
require_once SRC_PATH . '/includes/db.php';

$error = null;
$success = false;

// Processar formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $whatsapp = $_POST['whatsapp'] ?? null;
    $resultId = $_POST['result_id'] ?? null;

    // Validar
    if (!$whatsapp || !preg_match('/^\d{10,}$/', preg_replace('/\D/', '', $whatsapp))) {
        $error = 'Número de WhatsApp inválido';
    } else {
        // Salvar pagamento pending no banco
        $DB = Database::getInstance();
        $paymentId = uniqid('pay_', true);

        $DB->insert('payments', [
            'id' => $paymentId,
            'session_id' => session_id(),
            'whatsapp' => $whatsapp,
            'amount' => 19.90,
            'status' => 'pending'
        ]);

        // TODO: Integração real com Mercado Pago
        // Por enquanto, redirecionar para sucesso simulado
        $success = true;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo APP_NAME; ?> — Pagamento Seguro</title>
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
    </style>
</head>
<body class="bg-slate-900 text-slate-100">

<!-- HEADER -->
<header class="sticky top-0 z-50 bg-slate-900/95 backdrop-blur border-b border-slate-800">
    <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
        <a href="/" class="text-2xl font-display font-bold gradient-text"><?php echo APP_NAME; ?></a>
    </div>
</header>

<!-- CONTAINER -->
<div class="min-h-[calc(100vh-64px)] flex items-center py-12">
    <div class="max-w-lg mx-auto w-full px-4">
        <!-- CARD PAGAMENTO -->
        <div class="bg-slate-800 border border-slate-700 rounded-2xl p-8 md:p-10">
            <?php if ($success): ?>
                <!-- SUCCESS -->
                <div class="text-center mb-8">
                    <div class="text-6xl mb-4">✅</div>
                    <h1 class="text-3xl font-bold mb-4">Pagamento Enviado!</h1>
                    <p class="text-slate-400 mb-6">
                        Você receberá seu relatório Premium no WhatsApp em breve.
                    </p>
                </div>

                <div class="bg-green-500/10 border border-green-500/30 rounded-lg p-6 mb-6">
                    <p class="text-green-400 font-bold mb-2">Número recebido:</p>
                    <p class="text-lg font-mono"><?php echo htmlspecialchars($_POST['whatsapp']); ?></p>
                </div>

                <div class="space-y-4">
                    <a href="/" class="block text-center px-6 py-3 bg-amber-500 hover:bg-amber-600 text-slate-900 font-bold rounded-lg transition-all">
                        ← Voltar para Home
                    </a>
                    <a href="/quiz" class="block text-center px-6 py-3 border-2 border-amber-500 text-amber-500 hover:bg-amber-500/10 font-bold rounded-lg transition-all">
                        Refazer Quiz
                    </a>
                </div>

            <?php else: ?>
                <!-- FORM -->
                <h1 class="text-3xl font-bold mb-2">Desbloquear Premium</h1>
                <p class="text-slate-400 mb-8">
                    Complete o pagamento e receba seu relatório completo no WhatsApp
                </p>

                <!-- PREÇO -->
                <div class="bg-slate-900 rounded-lg p-6 mb-8 text-center">
                    <p class="text-slate-400 text-sm mb-2">Valor</p>
                    <div class="text-5xl font-bold gradient-text">R$ 19,90</div>
                    <p class="text-slate-400 text-sm mt-2">Acesso vitalício • Sem renovação</p>
                </div>

                <!-- BENEFÍCIOS -->
                <div class="bg-slate-900/50 border border-slate-700 rounded-lg p-6 mb-8">
                    <h3 class="font-bold mb-4">O que você recebe:</h3>
                    <ul class="space-y-3 text-sm">
                        <li class="flex gap-3">
                            <span>✓</span>
                            <span>Relatório PDF completo</span>
                        </li>
                        <li class="flex gap-3">
                            <span>✓</span>
                            <span>Análise dos 6 eixos detalhada</span>
                        </li>
                        <li class="flex gap-3">
                            <span>✓</span>
                            <span>Compatibilidade integral (12 apóstolos)</span>
                        </li>
                        <li class="flex gap-3">
                            <span>✓</span>
                            <span>Recomendações personalizadas</span>
                        </li>
                    </ul>
                </div>

                <!-- FORM -->
                <form method="POST" class="space-y-4">
                    <!-- WhatsApp -->
                    <div>
                        <label class="block text-sm font-bold mb-2">
                            📱 WhatsApp
                        </label>
                        <input type="tel" name="whatsapp" placeholder="(11) 99999-9999" required
                            class="w-full px-4 py-3 bg-slate-700 border border-slate-600 rounded-lg focus:border-amber-500 focus:outline-none text-white placeholder-slate-500"
                            pattern="\d{10,}">
                        <p class="text-xs text-slate-500 mt-1">Seu relatório será enviado por aqui</p>
                    </div>

                    <!-- Erro -->
                    <?php if ($error): ?>
                        <div class="bg-red-500/10 border border-red-500/30 rounded-lg p-4 text-red-400 text-sm">
                            ⚠️ <?php echo htmlspecialchars($error); ?>
                        </div>
                    <?php endif; ?>

                    <!-- Disclaimer -->
                    <div class="text-xs text-slate-500 text-center">
                        <p>🔒 Pagamento seguro com Pix</p>
                        <p>Seus dados nunca serão compartilhados</p>
                    </div>

                    <!-- Submit -->
                    <button type="submit" class="w-full px-6 py-4 bg-amber-500 hover:bg-amber-600 text-slate-900 font-bold text-lg rounded-lg transition-all shadow-lg">
                        Pagar com Pix →
                    </button>

                    <button type="button" onclick="window.history.back()" class="w-full px-6 py-3 border-2 border-slate-600 hover:border-slate-500 text-slate-300 font-bold rounded-lg transition-all">
                        ← Voltar
                    </button>
                </form>

            <?php endif; ?>
        </div>

        <!-- FOOTER -->
        <div class="text-center mt-8 text-slate-500 text-xs">
            <p>Por questões ou suporte, entre em contato via WhatsApp</p>
            <p class="mt-2">© 2026 <?php echo APP_NAME; ?></p>
        </div>
    </div>
</div>

</body>
</html>
