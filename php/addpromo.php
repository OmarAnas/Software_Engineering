<html>
    <?php
    include('navbar.php');
    echo '<link rel="stylesheet"href="../css/style5.css">';
    echo '<link href="../css/temp.css" rel="stylesheet" type="text/css">';
    echo '<link href="../css/BG.css" rel="stylesheet" type="text/css">';
    ?>
    <body>
    <form name="fpromo" action="promo_model.php" method = "post">
        <label>Code</label>
        <input type="text" name="code" >
        <br>
        <label>percent</label>
        <input type="number" step="any" name="value" max=100 min=1  >
        <br>
        <label>End Date</label>
        <?php
        $date = date("Y-m-d");
        echo '<input type="date" min="' . $date . '" name="Edate" >';
        echo '<input type = "submit" name = "submit" value = "Confirm">';
        ?>
    </form>
</body>
    <?php
// 
?>
</html>
