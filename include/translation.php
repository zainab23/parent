 <?php 

  if (!isset($_GET['lang'])){
           include 'include/english.php';

  }
     if (isset($_GET['lang']) ){
     $_SESSION['lang']= $_GET['lang'];}
     
     
     if(isset($_SESSION['lang'])&& $_SESSION['lang'] ==="arabic")
     { include 'include/arabic.php';}
             
                
        if(isset($_SESSION['lang'])&& $_SESSION['lang'] ==="english")
     { include 'include/english.php';}
                       
                  
     ?>


