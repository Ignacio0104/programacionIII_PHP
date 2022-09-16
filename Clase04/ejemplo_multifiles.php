<!doctype html>
<?php
session_start();
?>
<html>
<style>
    .alert {
        padding: 20px;
        background-color: #f44336;
        color: white;
        margin-bottom: 15px;
    }

    .closebtn {
        margin-left: 15px;
        color: white;
        font-weight: bold;
        float: right;
        font-size: 22px;
        line-height: 20px;
        cursor: pointer;
        transition: 0.3s;
    }

    .closebtn:hover {
        color: black;
    }
</style>

<head>
    <title>Subir Archivos Multiples</title>
</head>
<section>
    <div class="alert">
        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
        <?php
        if (isset($_SESSION['RESPUESTA'])) {

            echo $_SESSION['RESPUESTA'];
        }
        ?>
    </div>

</section>

<body>
<h3>Subir Archivos Multiples</h3>
    <form action="upload_multiple.php" method="post" enctype="multipart/form-data">
        <input type="file" name="archivo[]" multiple />
        <input type="submit" value="Subir" />
    </form>
</body>

</html>