<?php
// Scoring Logic — Quiz para Apostle Matching

/**
 * Calculate result from quiz answers
 *
 * @param array $answers — Array onde chave=question_id, valor=answer_index
 * @return array Result object com apostle match e scores
 *
 * Exemplo:
 * $answers = [1 => 0, 2 => 1, 3 => 2, ...]; // question_id => answer_index
 * $result = calculateResult($answers);
 */
function calculateResult($answers) {
    require_once __DIR__ . '/questions.php';
    require_once __DIR__ . '/apostles.php';

    $questions = getQuestions();

    // Inicializar scores dos 6 eixos
    $axes = [
        'leadership' => 0,
        'action' => 0,
        'faith' => 0,
        'innovation' => 0,
        'community' => 0,
        'growth' => 0
    ];

    $totalAnswers = 0;

    // Somar scores de cada resposta
    foreach ($answers as $questionId => $answerIndex) {
        // Encontrar a questão
        $question = null;
        foreach ($questions as $q) {
            if ($q['id'] == $questionId) {
                $question = $q;
                break;
            }
        }

        if (!$question || !isset($question['answers'][$answerIndex])) {
            continue;
        }

        $answer = $question['answers'][$answerIndex];

        // Adicionar scores desta resposta
        foreach ($axes as $axis => $val) {
            if (isset($answer['scores'][$axis])) {
                $axes[$axis] += $answer['scores'][$axis];
            }
        }

        $totalAnswers++;
    }

    // Normalizar para 0-100 (dividir pelo total de respostas vezes 100)
    if ($totalAnswers > 0) {
        foreach ($axes as &$score) {
            $score = round($score / $totalAnswers);
            $score = min(100, max(0, $score)); // Clamp 0-100
        }
    }

    // Encontrar apóstolo mais compatível
    $allApostles = getAllApostles();
    $apostleScores = [];

    foreach ($allApostles as $apostle) {
        $distance = calculateApostleDistance($axes, $apostle);
        $apostleScores[$apostle['id']] = $distance;
    }

    // Ordenar por menor distância (melhor match)
    asort($apostleScores);

    // Top 5 apostles (melhor match + 4 compatíveis)
    $topApostles = array_slice($apostleScores, 0, 5, true);
    $mainApostleId = key($topApostles);

    // Calcular compatibilidade % (100 = distância 0, decresce com distância)
    $maxDistance = 424.26; // √(100² * 6) = distância máxima possível
    $compatibility = [];

    foreach ($topApostles as $apostleId => $distance) {
        $compatPercent = max(0, round(100 - ($distance / $maxDistance * 100)));
        $compatibility[$apostleId] = $compatPercent;
    }

    return [
        'axes' => $axes,
        'mainApostleId' => $mainApostleId,
        'compatibility' => $compatibility,  // ID => percentage
        'timestamp' => date('Y-m-d H:i:s'),
        'totalAnswers' => $totalAnswers
    ];
}

/**
 * Calculate Euclidean distance between user axes and apostle profile
 * Lower = melhor match
 */
function calculateApostleDistance($userAxes, $apostle) {
    $apostleAxes = $apostle['axes'];

    $distanceSquared = 0;
    foreach ($userAxes as $axis => $userScore) {
        $apostleScore = isset($apostleAxes[$axis]) ? $apostleAxes[$axis] : 50;
        $diff = $userScore - $apostleScore;
        $distanceSquared += $diff * $diff;
    }

    return sqrt($distanceSquared);
}

/**
 * Get apostle result data
 */
function getResultData($resultJson) {
    if (is_string($resultJson)) {
        return json_decode($resultJson, true);
    }
    return $resultJson;
}

/**
 * Format result for display
 */
function formatResultForDisplay($result) {
    require_once __DIR__ . '/apostles.php';

    $mainApostle = getApostleById($result['mainApostleId']);

    $compatible = [];
    foreach ($result['compatibility'] as $apostleId => $percent) {
        if ($apostleId !== $result['mainApostleId']) {
            $compatible[] = [
                'apostle' => getApostleById($apostleId),
                'compatibility' => $percent
            ];
        }
    }

    return [
        'mainApostle' => $mainApostle,
        'axes' => $result['axes'],
        'compatibleApostles' => $compatible,
        'compatibility' => $result['compatibility']
    ];
}

/**
 * Validate quiz answers
 */
function validateQuizAnswers($answers) {
    require_once __DIR__ . '/questions.php';

    $questions = getQuestions();
    $totalQuestions = getTotalQuestions();

    // Verificar se respondeu todas as questões
    if (count($answers) !== $totalQuestions) {
        return false;
    }

    // Verificar se cada resposta é válida
    foreach ($answers as $questionId => $answerIndex) {
        $question = null;
        foreach ($questions as $q) {
            if ($q['id'] == $questionId) {
                $question = $q;
                break;
            }
        }

        if (!$question) {
            return false;
        }

        if (!isset($question['answers'][$answerIndex])) {
            return false;
        }
    }

    return true;
}
