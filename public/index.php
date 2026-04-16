<?php
/**
 * Qual Apóstolo? — Main Router
 *
 * Todas as requisições passam por este arquivo.
 * Carrega config, faz dispatch para as páginas corretas.
 */

// Configurações
define('BASE_PATH', __DIR__ . '/..');
define('SRC_PATH', BASE_PATH . '/src');
define('PUBLIC_PATH', __DIR__);
define('DB_PATH', BASE_PATH . '/data/quiz.db');

// Carregar configuração
require_once SRC_PATH . '/config.php';

// Extrair rota da URL
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$basePath = parse_url(APP_URL, PHP_PATH_PATH) ?: '';
$route = str_replace($basePath, '', $requestUri);
$route = trim($route, '/');

// Parse route e parâmetros
$parts = explode('/', $route);
$page = $parts[0] ?: 'home';
$action = $parts[1] ?? null;
$param = $parts[2] ?? null;

// Sanitizar
$page = preg_replace('/[^a-z0-9-]/', '', strtolower($page));
$action = $action ? preg_replace('/[^a-z0-9-]/', '', strtolower($action)) : null;

// Router
switch ($page) {
    case 'home':
    case '':
        require_once SRC_PATH . '/pages/home.php';
        break;

    case 'quiz':
        require_once SRC_PATH . '/pages/quiz.php';
        break;

    case 'resultado':
        require_once SRC_PATH . '/pages/resultado.php';
        break;

    case 'pagamento':
        require_once SRC_PATH . '/pages/pagamento.php';
        break;

    case 'api':
        // API endpoints
        header('Content-Type: application/json');
        require_once SRC_PATH . '/api/handler.php';
        break;

    case 'admin':
        require_once SRC_PATH . '/pages/admin.php';
        break;

    default:
        // 404
        http_response_code(404);
        require_once SRC_PATH . '/pages/404.php';
        break;
}
