<?php
// Configurações da aplicação

define('APP_NAME', 'Qual Apóstolo?');
define('APP_URL', 'https://qualapostolo.com.br');
define('APP_ENV', getenv('APP_ENV') ?: 'production');

// Database
define('DB_PATH', __DIR__ . '/../data/quiz.db');

// Paths
define('BASE_PATH', __DIR__ . '/..');
define('PUBLIC_PATH', BASE_PATH . '/public');
define('SRC_PATH', BASE_PATH . '/src');

// API Keys
define('GROQ_API_KEY', getenv('GROQ_API_KEY') ?: '');
define('GEMINI_API_KEY', getenv('GEMINI_API_KEY') ?: '');
define('MP_ACCESS_TOKEN', getenv('MP_ACCESS_TOKEN') ?: '');
define('EVO_API_KEY', getenv('EVO_API_KEY') ?: '');

// Session
session_start();
ini_set('display_errors', APP_ENV === 'development' ? 1 : 0);
header('Content-Type: text/html; charset=utf-8');
