<?php include "include/header.php"; ?>
<?php include "include/col_left.php"; ?>        
            
            <div class="col_right">
              
              <?php if (isset($_SESSION['user']) && $_SESSION['user']['account_status'] !== 0){ ?>
              <?php
                if (isset($_POST['post'])){
                  extract($_POST);
                  if (empty($text)){
                    echo "<div class='error' style='width: 500px'>
                         $EMwritesomthing
                        </div>";
                  }else{
                    
                    
                    if (isset($_FILES['file']) && $_FILES['file']['error'] == 0 ){
                        $file_type = explode("/", $_FILES['file']['type'])[0];
                        $ext = explode(".", $_FILES['file']['name']);
                        $ext = $ext[count($ext) - 1];
                        $ext = "abc".time().".".$ext;
                        
                        if ($file_type == "image"){
                          $type = 2;
                          $src = "upload/imgs/".$ext;
                          move_uploaded_file($_FILES['file']['tmp_name'], $src);
                          $img = $src;
                          $video = null;
                        }elseif ($file_type == "video"){
                          $type = 3;
                          $src = "upload/videos/".$ext;
                          $r = move_uploaded_file($_FILES['file']['tmp_name'], $src);
                          $video = $src;
                          $img = null;
                        }
                        
                    }else{
                      $type = 1;
                      $img = null;
                      $video = null;
                    }
                    
                    
                    
                    
                    
                    $result = post_add_new($text, $img, $video, $type, $cat);
                    if ($result){
                      header('location: index.php');
                      exit;
                    }else{
                      echo "<div class='error' style='width: 500px'>
                       $EMtryagaint
                      </div>";
                    }
                    
                  }
                }
              ?>
              <div class="new_post">
                <form method="post" enctype="multipart/form-data">
                  <textarea name="text" placeholder=" <?php echo $Whatmind ;?>"></textarea>
                  <input name="file" type="file" />
                  <button name="post" type="submit"><?php echo $Public ?></button>
                  <label><?php echo $choseCategory ?></label>
                  <select name="cat">
                    <option value="baby_food"><?php echo $BabyFood ?></option>
                    <option value="baby_health"><?php echo $BabyHealth ?></option>
                    <option value="newborn_babies"><?php echo $NewbornBabies ?></option>
                    <option value="baby_gear"><?php echo $BabyGear ?></option>
                    <option value="baby_games"><?php echo $BabyGames ?></option>
                  </select>
                </form>
                <div style="clear: both"></div>
              </div>
              <?php } ?>
              
              
              
              
              <?php
                if (!isset($_SESSION['user'])){
                  if (!isset($_GET['cat']))
                    include 'show_posts_random.php';
                  else
                    include 'show_posts_random_by_cat.php';
                }else{
                  if (!isset($_GET['cat']))
                    include 'show_posts.php';
                  else
                    include 'show_posts_by_cat.php';
                }
              ?>
              
              
                
              
              
              
              
              
                
                
            </div>
            <div style="clear: both"></div>
        </div>
        
        
        <?php include "include/footer.php"; ?>
