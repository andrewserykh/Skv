<main class="main">

<div class="page-loader">
    <div class="page-loader__spinner">
        <svg viewBox="25 25 50 50">
            <circle cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
        </svg>
    </div>
</div>


<?
    include ("_content_toolbar.php");
    include ("_content_menu.php");
    if (file_exists ( "page_" . $pg . ".php" )){
        include("page_" . $pg . ".php");
    } else {
        include("page_404.php");
    }
?>

</main>