<?php
/**
 * 404 Page
 */
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página não encontrada</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&display=swap');
        .font-display { font-family: 'Playfair Display', serif; }
        .gradient-text {
            background: linear-gradient(135deg, #fcd34d 0%, #f59e0b 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
    </style>
</head>
<body class="bg-slate-900 text-slate-100">

<div class="min-h-screen flex flex-col items-center justify-center px-4">
    <div class="text-8xl mb-6">😕</div>
    <h1 class="text-6xl font-display font-bold mb-4 text-center">
        <span class="gradient-text">404</span>
    </h1>
    <p class="text-2xl mb-8">Página não encontrada</p>
    <p class="text-slate-400 text-lg text-center mb-12 max-w-md">
        Desculpe, a página que você está procurando não existe ou foi removida.
    </p>
    <a href="/" class="px-8 py-4 bg-amber-500 hover:bg-amber-600 text-slate-900 font-bold rounded-lg transition-all">
        ← Voltar para Home
    </a>
</div>

</body>
</html>
