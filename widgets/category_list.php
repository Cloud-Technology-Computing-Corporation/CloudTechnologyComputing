<?php
// widgets/category_list.php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/db.php';

$sql = "SELECT c.id, c.name, COUNT(p.id) as post_count
        FROM categories c
        LEFT JOIN posts p ON c.id = p.category_id
        GROUP BY c.id, c.name ORDER BY c.name ASC";
$res = $mysqli->query($sql);

if ($res && $res->num_rows > 0) {
  echo '<ul class="wp-block-categoris-cloud">';
  while ($row = $res->fetch_assoc()) {
    echo '<li><a href="blog.php?category=' . h($row['id']) . '"><span>' . h($row['name']) . '</span> <span class="number-of-categoris">(' . (int)$row['post_count'] . ')</span></a></li>';
  }
  echo '</ul>';
} else {
  echo "<p>No categories found.</p>";
}
?>
