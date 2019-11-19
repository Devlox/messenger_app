<?php if(!isset($_SESSION['user_id'])): ?>
    <?php 
        $obj = new base_class();
        $obj->Create_Session("security", "Sorry you need to login first");
    ?>

    <?php header("location:login.php"); ?>
<?php endif; ?>