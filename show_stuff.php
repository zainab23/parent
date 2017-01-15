<?php include "include/header.php";

if (!isset($_GET['id'])){
    header('location: index.php');
    exit;
}
$stuff = suff_get_by_id($_GET['id']);
if (!$stuff){
    header('location: index.php');
    exit;
}



/*
 *Array (
 *          [id] => 2
 *          [u_id] => 14
 *          [name] => bed bayby
 *          [desc] => this  baby bed is great bad and very nice look, I bay it on best case.
 *          [img] => upload/imgs/stuff.jpg
 *          [price] => 45
 *          [time] => 1455784227
 *          [who_want_it] =>
 *                      Array ( )
 *       )
 **/


?>
<div style="clear: both"></div>
<br>
<div class="show_stuff">
    <table>
        
        <tr>
            <td><?php echo $Name ?></td>
            <td><?php echo $stuff['name'] ?></td>
        </tr>
        
        <tr>
            <td><?php echo $Description ?></td>
            <td><p><?php echo $stuff['desc'] ?></p></td>
        </tr>
        
        <tr>
            <td><?php echo $price ?></td>
            <td><?php echo $stuff['price'] ?> $ </td>
        </tr>
        
        <tr>
            <td><?php echo $Time ?></td>
            <td><?php echo  strftime('%d/%m/%Y %H:%M',$stuff['time']); ?></td>
        </tr>
        
        <tr>

            <td><?php echo $Persenwantit ?></td>
            <td><?php
                    if (count($stuff['who_want_it']) == 0)
                        echo $noonewantit;
                    else{
                        foreach($stuff['who_want_it'] as $want_id){
                            $user = user_get_by_id($want_id);
                            echo "<a href='profile.php?id={$user['id']}'>{$user['f_name']} {$user['l_name']}</a> , ";
                        }
                    }
                ?></td>
        </tr>
        
        <tr>
            <td colspan="2"><img src="<?php echo $stuff['img'] ?>" /></td>
        </tr>
        <?php if (isset($_SESSION['user']) && !in_array($_SESSION['user']['id'], $stuff['who_want_it']) && $_SESSION['user']['id'] != $stuff['u_id']  ){ ?>
        <tr>
            <td colspan="2"><a href="#"
                               class="want_this"
                               action="want"
                               id="<?php echo $stuff['id'] ?>"
                               uid="<?php echo $stuff['u_id'] ?>"
                               ><?php echo $Iwantit ?></a></td>
        </tr>
        <?php }elseif(isset($_SESSION['user']) && in_array($_SESSION['user']['id'], $stuff['who_want_it']) && $_SESSION['user']['id'] != $stuff['u_id']   ){ ?>
        <tr>
            <td colspan="2"><a href="#"
                               class="want_this"
                               action="unwant"
                               id="<?php echo $stuff['id'] ?>"
                               uid="<?php echo $stuff['u_id'] ?>"
                               ><?php echo $dontwantit ?></a></td>
        </tr>
        <?php } ?>
        
    </table>
    <br>
    <div style="clear: both"></div>
</div>
<?php include "include/footer.php"; ?>