<!DOCTYPE html>
<h1>
    <?php 
        if(session_status() == PHP_SESSION_NONE) session_start();
        include_once '/var/private_request/genName.php';

        //if [name dne] or [invalid session name] 
        if(!isset($_SESSION['username']) || !name_exists($_SESSION['username'])) genSet_useablename(true);
    ?>
</h1>