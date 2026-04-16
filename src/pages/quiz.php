<?php
/**
 * Quiz Page
 *
 * Exibe questões uma por uma, gerencia progresso, salva respostas
 */
require_once SRC_PATH . '/includes/apostles.php';
require_once SRC_PATH . '/includes/questions.php';
require_once SRC_PATH . '/includes/db.php';
require_once SRC_PATH . '/includes/scoring.php';

// Inicializar session de quiz
if (!isset($_SESSION['quiz_session_id'])) {
    $_SESSION['quiz_session_id'] = uniqid('quiz_', true);
    $_SESSION['quiz_answers'] = [];
    $_SESSION['quiz_started_at'] = time();
}

$questions = getQuestions();
$totalQuestions = getTotalQuestions();
$answeredCount = count($_SESSION['quiz_answers']);
$currentProgress = $answeredCount / $totalQuestions * 100;

// Encontrar próxima questão não respondida
$nextQuestionId = null;
for ($i = 1; $i <= $totalQuestions; $i++) {
    if (!isset($_SESSION['quiz_answers'][$i])) {
        $nextQuestionId = $i;
        break;
    }
}

// Se respondeu todas, redirecionar para resultado
if ($nextQuestionId === null) {
    // Calcular resultado
    $result = calculateResult($_SESSION['quiz_answers']);

    // Salvar no banco
    $DB = Database::getInstance();
    $DB->insert('quizzes', [
        'id' => uniqid('result_', true),
        'session_id' => $_SESSION['quiz_session_id'],
        'answers' => json_encode($_SESSION['quiz_answers']),
        'result' => json_encode($result)
    ]);

    // Limpar session de quiz
    unset($_SESSION['quiz_session_id']);
    unset($_SESSION['quiz_answers']);

    // Redirecionar
    header('Location: /resultado?id=' . $DB->lastInsertId());
    exit;
}

// Pegar questão atual
$currentQuestion = null;
foreach ($questions as $q) {
    if ($q['id'] == $nextQuestionId) {
        $currentQuestion = $q;
        break;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo APP_NAME; ?> — Quiz</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Lexend:wght@400;700&family=Playfair+Display:wght@700;900&display=swap');

        * {
            font-family: 'Lexend', sans-serif;
        }

        .font-display {
            font-family: 'Playfair Display', serif;
        }

        .answer-btn {
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .answer-btn:hover {
            transform: translateX(8px);
            background-color: rgba(251, 191, 36, 0.1);
            border-color: rgb(251, 191, 36);
        }

        .answer-btn.selected {
            background-color: rgba(251, 191, 36, 0.2);
            border-color: rgb(251, 191, 36);
        }

        .progress-bar {
            height: 3px;
            background: linear-gradient(90deg, #fbbf24 0%, #f59e0b 100%);
            transition: width 0.3s ease;
        }
    </style>
</head>
<body class="bg-gradient-to-b from-slate-900 to-slate-800 min-h-screen text-slate-100">

<!-- PROGRESS BAR -->
<div class="fixed top-0 left-0 right-0 h-1 bg-slate-800 z-50">
    <div class="progress-bar" style="width: <?php echo $currentProgress; ?>%"></div>
</div>

<!-- CONTAINER -->
<div class="max-w-2xl mx-auto px-4 py-12">
    <!-- HEADER -->
    <div class="text-center mb-12 mt-6">
        <div class="text-sm text-slate-400 mb-3">
            Questão <?php echo $nextQuestionId; ?> de <?php echo $totalQuestions; ?>
        </div>
        <div class="w-full bg-slate-700 rounded-full h-2 mb-6">
            <div class="bg-gradient-to-r from-amber-400 to-amber-600 h-2 rounded-full transition-all" style="width: <?php echo $currentProgress; ?>%"></div>
        </div>
    </div>

    <!-- QUESTÃO -->
    <?php if ($currentQuestion): ?>
        <div class="mb-12">
            <h2 class="text-2xl md:text-3xl font-bold leading-relaxed mb-8">
                <?php echo $currentQuestion['question']; ?>
            </h2>

            <!-- RESPOSTAS -->
            <form id="answerForm" class="space-y-3">
                <?php foreach ($currentQuestion['answers'] as $answerIndex => $answer): ?>
                    <label class="answer-btn block p-4 md:p-5 border-2 border-slate-600 rounded-xl hover:border-amber-500 hover:bg-slate-800/50 cursor-pointer">
                        <input type="radio" name="answer" value="<?php echo $answerIndex; ?>" class="hidden">
                        <div class="flex items-start gap-4">
                            <div class="w-6 h-6 mt-1 border-2 border-slate-400 rounded-full flex-shrink-0"></div>
                            <div>
                                <p class="font-medium text-base md:text-lg"><?php echo $answer['text']; ?></p>
                            </div>
                        </div>
                    </label>
                <?php endforeach; ?>
            </form>
        </div>

        <!-- BUTTONS -->
        <div class="flex gap-4 justify-between mt-12">
            <button onclick="goBack()" class="px-6 py-3 border-2 border-slate-600 hover:border-slate-500 text-slate-300 font-bold rounded-lg transition-all">
                ← Anterior
            </button>

            <button onclick="submitAnswer()" class="px-8 py-3 bg-amber-500 hover:bg-amber-600 text-slate-900 font-bold rounded-lg transition-all shadow-lg">
                Próxima →
            </button>
        </div>

        <!-- SKIP -->
        <div class="text-center mt-6">
            <button onclick="skipQuestion()" class="text-slate-500 hover:text-slate-400 text-sm underline transition-colors">
                Pular questão
            </button>
        </div>

    <?php endif; ?>
</div>

<script>
    let currentQuestionId = <?php echo json_encode($nextQuestionId); ?>;
    let totalQuestions = <?php echo json_encode($totalQuestions); ?>;
    let answeredCount = <?php echo json_encode($answeredCount); ?>;

    // Selecionar resposta
    document.querySelectorAll('.answer-btn input').forEach(input => {
        input.addEventListener('change', function() {
            document.querySelectorAll('.answer-btn').forEach(btn => btn.classList.remove('selected'));
            this.closest('.answer-btn').classList.add('selected');
        });
    });

    function submitAnswer() {
        const selected = document.querySelector('input[name="answer"]:checked');
        if (!selected) {
            alert('Por favor, selecione uma resposta');
            return;
        }

        const answerIndex = parseInt(selected.value);

        // Salvar via AJAX
        fetch('/api/quiz/answer', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                question_id: currentQuestionId,
                answer_index: answerIndex
            })
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Erro ao salvar resposta: ' + data.error);
            }
        })
        .catch(err => console.error('Error:', err));
    }

    function skipQuestion() {
        // Deixar em branco e ir para próxima
        fetch('/api/quiz/answer', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                question_id: currentQuestionId,
                answer_index: null
            })
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        });
    }

    function goBack() {
        // Remover última resposta e voltar
        fetch('/api/quiz/undo', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            }
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        });
    }
</script>

</body>
</html>
