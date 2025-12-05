<?php
// widgets/page_views.php
// Usage: require 'includes/db.php'; require 'widgets/page_views.php'; $count = track_page_view($mysqli, 'unique_page_identifier');

function track_page_view(mysqli $db, string $page_name): int {
  $sql = "SELECT views FROM page_views WHERE page_name = ?";
  $stmt = $db->prepare($sql);
  if (!$stmt) return 0;
  $stmt->bind_param('s', $page_name);
  $stmt->execute();
  $stmt->bind_result($views);
  if ($stmt->fetch()) {
    $stmt->close();
    $views++;
    $stmt2 = $db->prepare("UPDATE page_views SET views = ? WHERE page_name = ?");
    $stmt2->bind_param('is', $views, $page_name);
    $stmt2->execute();
    $stmt2->close();
    return $views;
  } else {
    $stmt->close();
    $views = 1;
    $stmt2 = $db->prepare("INSERT INTO page_views (page_name, views) VALUES (?, ?)");
    $stmt2->bind_param('si', $page_name, $views);
    $stmt2->execute();
    $stmt2->close();
    return $views;
  }
}
?>
