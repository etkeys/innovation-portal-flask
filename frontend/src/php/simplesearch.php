
<?php
    session_start();
    header("Location: ../index.php?content=simple-search&query=$_GET[query]");
?>
