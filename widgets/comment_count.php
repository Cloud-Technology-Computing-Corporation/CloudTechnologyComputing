<?php
// widgets/comment_count.php
// Usage: $count = comment_count($mysqli, $post_id);

function comment_count(mysqli $db, int $post_id): int {
  $stmt = $db->prepare("SELECT COUNT(*) FROM comments WHERE post_id = ?");
  $stmt->bind_param('i', $post_id);
  $stmt->execute();
  $stmt->bind_result($count);
  $stmt->fetch();
  $stmt->close();
  return (int)$count;
}
?>
