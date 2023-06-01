<!DOCTYPE html>
<h1>
    <?php 
        session_start();
        
        include_once '/var/private_request/genName.php';
        if(!isset($_SESSION['username'])) setNewUseableName(true);
    ?>
</h1>