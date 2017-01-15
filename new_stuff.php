<?php
include "include/header.php";
if ($_SESSION['user']['account_status'] === 0)
    exit;
if (!isset($_SESSION['user'])){
    header('location: index.php');
    exit;
}


?>

<div class="new_stuff">
    <br><br><br>
    <?php
        if (isset($_POST['save'])){
            extract($_POST);
            if (empty($name) || empty($desc) || empty($price)){
                echo "<div class='error' style='width: 500px'>
                         $EMfillallfields
                      </div>";
                     // print_r($_FILES);
            }elseif( $_FILES['image']['size'] == 0 || explode("/", $_FILES['image']['type'])[0] != "image"){
                echo "<div class='error' style='width: 500px'>
                        You must chose an image for you stuff
                      </div>";
            }else{
                $ext = explode(".", $_FILES['image']['name']);
                $ext = $ext[count($ext) - 1];
                $ext = "abc_".time().".".$ext;
                $src = "upload/imgs/".$ext;
                move_uploaded_file($_FILES['image']['tmp_name'], $src);
                $image = $src;
                $res = stuff_add_new($name, $desc, $price, $image);
                if ($res){
                    echo "<div class='succes' style='width: 500px'>
                        $addsuces
                      </div>";
                }else{
                    echo "<div class='error' style='width: 500px'>
                       $addwrongs 
                      </div>";
                }
                
                
                
            }           
            
        }
            
    ?>
    <form method="post" enctype="multipart/form-data">
        <table>
            <tr>
                <td><?php echo $Name ?></td>
                <td><input type="text" name="name" /></td>
            </tr>
            
            <tr>
                <td><?php echo $Description ?></td>
                <td><textarea name="desc"></textarea></td>
            </tr>
            
            <tr>
                <td><?php echo $price ?>($)</td>
                <td><input type="number" min="1" max="600" name="price" /></td>
            </tr>
            
            <tr>
                <td><?php echo $Imge ?></td>
                <td><input type="file" name="image" /></td>
            </tr>
            
            <tr>
                <td colspan="2"><input type="submit" name="save" value="<?php echo $Save ?>" /></td>
            </tr>
        </table>
    </form>
</div>





<?php include "include/footer.php"; ?>