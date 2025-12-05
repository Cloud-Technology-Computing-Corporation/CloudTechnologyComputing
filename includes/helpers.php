<?php
if (session_status() !== PHP_SESSION_ACTIVE) { session_start(); }

function h($s) {
  return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8');
}

function csrf_token() {
  if (empty($_SESSION['csrf'])) {
    $_SESSION['csrf'] = bin2hex(random_bytes(32));
  }
  return $_SESSION['csrf'];
}

function csrf_field() {
  echo '<input type="hidden" name="csrf" value="'. h(csrf_token()) .'">';
}

function csrf_check(): bool {
  $ok = isset($_POST['csrf'], $_SESSION['csrf']) && hash_equals($_SESSION['csrf'], $_POST['csrf']);
  return $ok;
}
