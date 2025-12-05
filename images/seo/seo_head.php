<?php
// seo/seo_head.php
// Reusable SEO head tags. Set these before include:
/*
$siteName        = "Cloud Technology Computing";
$baseUrl         = "https://www.cloudtechnologycomputing.com";
$slug            = "blog/the-future-of-cloud-technology-2025";
$title           = "Cloud Technology Computing: Transforming the Future";
$metaDescription = "Learn how multi-cloud, AI, edge, and security drive growth in 2025.";
$heroImage       = asset_url("assets/img/og-default.png");
$heroAlt         = "Cloud Technology Computing hero image";
$publishedAt     = "2025-08-19T09:00:00-05:00";
$modifiedAt      = $publishedAt;
$canonical       = rtrim($baseUrl, '/') . '/' . ltrim($slug, '/');
*/
?>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo h($title) . ' | ' . h($siteName); ?></title>
<meta name="description" content="<?php echo h($metaDescription); ?>">
<link rel="canonical" href="<?php echo h($canonical); ?>">
<meta name="robots" content="index,follow,max-snippet:-1,max-image-preview:large,max-video-preview:-1">

<meta property="og:type" content="article">
<meta property="og:site_name" content="<?php echo h($siteName); ?>">
<meta property="og:title" content="<?php echo h($title); ?>">
<meta property="og:description" content="<?php echo h($metaDescription); ?>">
<meta property="og:url" content="<?php echo h($canonical); ?>">
<meta property="og:image" content="<?php echo h($heroImage); ?>">
<meta property="og:image:alt" content="<?php echo h($heroAlt); ?>">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta property="article:published_time" content="<?php echo h($publishedAt); ?>">
<meta property="article:modified_time" content="<?php echo h($modifiedAt); ?>">

<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?php echo h($title); ?>">
<meta name="twitter:description" content="<?php echo h($metaDescription); ?>">
<meta name="twitter:image" content="<?php echo h($heroImage); ?>">

<script type="application/ld+json">
<?php echo json_encode([
  "@context" => "https://schema.org",
  "@type" => "BlogPosting",
  "headline" => $title,
  "description" => $metaDescription,
  "image" => [$heroImage],
  "author" => ["@type" => "Person", "name" => "Jhon A Arzu-Gil"],
  "publisher" => ["@type" => "Organization", "name" => $siteName],
  "datePublished" => $publishedAt,
  "dateModified" => $modifiedAt,
  "mainEntityOfPage" => $canonical
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT); ?>
</script>
