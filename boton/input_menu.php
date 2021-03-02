<?php 
//error_reporting(0); 
require_once("includes/header.php"); 
?>


    
   
  
<div class="container">
    
    <div class="card text-center" style="text-decoration: none; margin-top:-80px; margin-bottom:50px;">
    <div class="card-header">
        Planta: <?php echo $planta_id ?>
    </div>
        <ul class="list-group list-group-flush">
                
                <?php 
                $query = "SELECT * FROM ordenes_main WHERE planta_id = $planta_id AND estado = 1";
                $result = mysqli_query($connection, $query);
                while($row = mysqli_fetch_array($result)):
                ?>
                
                    <a style="text-decoration: none;" href="input.php?maquina=<?php echo $row['maquina'] ?>"><li class="list-group-item"><?php echo $row['maquina'] ?></li></a>
                
                <?php
                endwhile; 
                ?>

        </ul>
    </div>
</div>

   


<?php require_once("includes/footer.php"); ?>
