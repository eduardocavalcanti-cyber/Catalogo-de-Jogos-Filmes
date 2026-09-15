<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
function csrf_token(): string
{
    if (empty($_SESSION['csrf'])) $_SESSION['csrf'] = bin2hex(random_bytes(32));
    return $_SESSION['csrf'];
}
function csrf_validar(?string $t): bool
{
    return isset($_SESSION['csrf']) && hash_equals($_SESSION['csrf'], $t ?? '');
}
function e(?string $v): string
{
    return htmlspecialchars($v ?? '', ENT_QUOTES, 'UTF-8');
}
function base_url(string $p = ''): string
{
    $base = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
    if ($base === '\\' || $base === '.') $base = '';
    return $base . '/' . ltrim($p, '/');
}
function redirecionar(string $url): void
{
    header("Location: $url");
    exit;
}
function usuario_logado(): ?array
{
    return $_SESSION['usuario'] ?? null;
}
function exigir_login(): void
{
    if (!usuario_logado()) {
        $_SESSION['flash_erro'] = 'Faça login para continuar.';
        redirecionar('index.php?p=login');
    }
}
