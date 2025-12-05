<?php
// includes/helpers.php

function h($str) { return htmlspecialchars((string)$str, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); }

function asset_url($path) {
  $base = rtrim((getenv('BASE_URL') ?: ''), '/');
  if ($base === '') return $path;
  if (strpos($path, 'http://') === 0 || strpos($path, 'https://') === 0) return $path;
  return $base . '/' . ltrim($path, '/');
}

function csrf_token() {
  if (session_status() !== PHP_SESSION_ACTIVE) { session_start(); }
  if (empty($_SESSION['csrf'])) { $_SESSION['csrf'] = bin2hex(random_bytes(32)); }
  return $_SESSION['csrf'];
}

function csrf_field() {
  $t = csrf_token();
  echo '<input type="hidden" name="csrf_token" value="' . h($t) . '">';
}

function csrf_check() {
  if (session_status() !== PHP_SESSION_ACTIVE) { session_start(); }
  if (empty($_POST['csrf_token']) || empty($_SESSION['csrf']) || !hash_equals($_SESSION['csrf'], $_POST['csrf_token'])) {
    http_response_code(422);
    die('Invalid form token.');
  }
}
?>
