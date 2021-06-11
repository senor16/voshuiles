<?php
$title = "404 - Page not found";
ob_start();
?>

<h2 class="error">Error code 404 - Page not found</h2>
<p>
    The requested page was not found
</p>

<?php
$content = ob_get_clean();
