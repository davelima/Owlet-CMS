<?php
$breadcrumbs = array(
    "Home" => "/admin/",
    "Sitemap" => "/admin/sitemaps/dashboard/",
    "Atualizar sitemap" => $_SERVER['REQUEST_URI']
);
require_once ("inc/breadcrumbs.php");
?>

<h2 class="page-header">Sitemap</h2>

<?php
try {
    $baseUrl = $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'];
    \Extensions\Sitemaps::Generate($baseUrl);
    \Extensions\Sitemaps::Save();
    $type = "success";
    $message = "Sitemap atualizado com sucesso!<br><a href=\"{$baseUrl}/sitemap.xml\" target=\"_blank\">Acessar <i class='fa fa-external-link'></i></a>";
} catch (Exception $e) {
    $type = "danger";
    $message = $e->getMessage();
}

echo Extensions\Messages::Message($type, $message);
?>

<a href="sitemaps/dashboard/" class="btn btn-info">Voltar</a>