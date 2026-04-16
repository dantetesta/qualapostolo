<?php
/**
 * API Handler — Rotas AJAX
 */
require_once SRC_PATH . '/includes/db.php';
require_once SRC_PATH . '/includes/questions.php';
require_once SRC_PATH . '/includes/scoring.php';

header('Content-Type: application/json');

// Extrair rota da URL
$requestUri = $_SERVER['REQUEST_URI'];
$basePath = '/api/';
$apiPath = str_replace($basePath, '', parse_url($requestUri, PHP_URL_PATH));
$parts = explode('/', trim($apiPath, '/'));
$resource = $parts[0] ?? null;
$action = $parts[1] ?? null;

// Rotas
if ($resource === 'quiz' && $action === 'answer' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    handleQuizAnswer();
} elseif ($resource === 'quiz' && $action === 'undo' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    handleQuizUndo();
} elseif ($resource === 'quiz' && $action === 'status' && $_SERVER['REQUEST_METHOD'] === 'GET') {
    handleQuizStatus();
} else {
    http_response_code(404);
    echo json_encode(['error' => 'Endpoint não encontrado']);
}

/**
 * POST /api/quiz/answer
 * Salvar resposta de uma questão
 */
function handleQuizAnswer() {
    $data = json_decode(file_get_contents('php://input'), true);

    if (!isset($data['question_id'], $data['answer_index'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Parâmetros inválidos']);
        return;
    }

    $questionId = (int)$data['question_id'];
    $answerIndex = is_null($data['answer_index']) ? null : (int)$data['answer_index'];

    // Validar resposta
    if ($answerIndex !== null) {
        $questions = getQuestions();
        $question = null;

        foreach ($questions as $q) {
            if ($q['id'] == $questionId) {
                $question = $q;
                break;
            }
        }

        if (!$question || !isset($question['answers'][$answerIndex])) {
            http_response_code(400);
            echo json_encode(['error' => 'Resposta inválida']);
            return;
        }
    }

    // Salvar na session
    if (!isset($_SESSION['quiz_answers'])) {
        $_SESSION['quiz_answers'] = [];
    }

    $_SESSION['quiz_answers'][$questionId] = $answerIndex;

    echo json_encode([
        'success' => true,
        'question_id' => $questionId,
        'answered_count' => count($_SESSION['quiz_answers'])
    ]);
}

/**
 * POST /api/quiz/undo
 * Desfazer última resposta
 */
function handleQuizUndo() {
    if (!isset($_SESSION['quiz_answers']) || empty($_SESSION['quiz_answers'])) {
        echo json_encode(['success' => false, 'error' => 'Nenhuma resposta para desfazer']);
        return;
    }

    // Remover última resposta
    $keys = array_keys($_SESSION['quiz_answers']);
    $lastKey = end($keys);
    unset($_SESSION['quiz_answers'][$lastKey]);

    echo json_encode([
        'success' => true,
        'answered_count' => count($_SESSION['quiz_answers'])
    ]);
}

/**
 * GET /api/quiz/status
 * Obter status do quiz
 */
function handleQuizStatus() {
    if (!isset($_SESSION['quiz_session_id'])) {
        echo json_encode(['session' => null]);
        return;
    }

    $answered = isset($_SESSION['quiz_answers']) ? count($_SESSION['quiz_answers']) : 0;
    $total = getTotalQuestions();

    echo json_encode([
        'session_id' => $_SESSION['quiz_session_id'],
        'answered_count' => $answered,
        'total_questions' => $total,
        'progress' => ($answered / $total) * 100,
        'started_at' => $_SESSION['quiz_started_at'] ?? null
    ]);
}
