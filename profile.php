
<?php include "include/header.php"; include_once 'include/translation.php';
 ?>
<?php
if (!isset($_SESSION['user']) && !isset($_GET['id'])){
    header('location: index.php');
    exit;
}

if (isset($_GET['id'])){
    if (isset($_SESSION['user']['id']) && $_SESSION['user']['id'] == $_GET['id']){
        $profile_user = $_SESSION['user'];
    }else{
        $profile_user = user_get_by_id($_GET['id']);
        if (!$profile_user){
            header('location: index.php');
            exit;
        }
    }
}elseif (isset($_SESSION['user'])){
    $profile_user = $_SESSION['user'];
}  
?>
<div class="col_left">

<div class="top">
    <a href="<?php echo "profile.php?id={$profile_user['id']}"; ?>">
        <img src="<?php echo $profile_user['img']; ?>" class="" alt="profile pictur" />
        <p><?php
                echo $profile_user['f_name'];
                if (isset($profile_user['l_name']))
                echo " ".$profile_user['l_name'];
                
            ?></p>
    </a>
   
    <?php if (isset($_SESSION['user']) && $profile_user['id'] != $_SESSION['user']['id'] && $_SESSION['user']['account_status'] !== 0 ){?>
    
        <?php if (!in_array($profile_user['id'], $_SESSION['user']['frineds'])  &&
                  !in_array($profile_user['id'], $_SESSION['user']['req_in'])  &&
                  !in_array($profile_user['id'], $_SESSION['user']['req_out'])){ ?>
                  
            <button class="add" action="add" uid="<?php echo $profile_user['id']; ?>"><?php echo $AddFriend ?></button>
        <?php } ?>
        
        <?php if (!in_array($profile_user['id'], $_SESSION['user']['frineds'])  &&
                   in_array($profile_user['id'], $_SESSION['user']['req_in'])  &&
                  !in_array($profile_user['id'], $_SESSION['user']['req_out'])){ ?>
                  
            <button class="add" action="accept" uid="<?php echo $profile_user['id']; ?>"><?php echo $Accept ?></button>
        <?php } ?>
        
        <?php if (!in_array($profile_user['id'], $_SESSION['user']['frineds'])  &&
                  !in_array($profile_user['id'], $_SESSION['user']['req_in'])  &&
                   in_array($profile_user['id'], $_SESSION['user']['req_out'])){ ?>
                  
            <button class="add" action="cencel" uid="<?php echo $profile_user['id']; ?>"><?php echo $Cencel ?></button>
        <?php } ?>
        
        <?php if ( in_array($profile_user['id'], $_SESSION['user']['frineds'])  &&
                  !in_array($profile_user['id'], $_SESSION['user']['req_in'])  &&
                  !in_array($profile_user['id'], $_SESSION['user']['req_out'])){ ?>
                  
            <button class="add" action="unfriend" uid="<?php echo $profile_user['id']; ?>"><?php echo $Unfriend ?></button>
        <?php } ?>
        
        <?php if (in_array($profile_user['id'], $_SESSION['user']['frineds']) ) {?>
            <a href="msg.php?id=<?php echo $profile_user['id']; ?>" class="msg" uid="<?php echo $profile_user['id']; ?>"><?php echo $Messages ?></a>
        <?php } ?>
        
        
        <button class="show_post" uid="<?php echo $profile_user['id']; ?>"><?php echo $Posts ?></button>
        
    <?php } ?>
    <div style="clear: both"></div>
</div>


<div class="bottom">
    <h3><?php echo $Category ?></h3>
    <ul>
        <li><a href="index.php?cat=baby_food"><?php echo $BabyFood ?></a></li>
        <li><a href="index.php?cat=baby_health"><?php echo $BabyHealth ?></a></li>
        <li><a href="index.php?cat=newborn_babies"><?php echo $NewbornBabies ?></a></li>
        <li><a href="index.php?cat=baby_gear"><?php echo $BabyGear ?></a></li>
        <li><a href="index.php?cat=baby_games"><?php echo $BabyGames ?></a></li>
    </ul>
</div>
</div>



<div class="col_right">
    <?php if ($profile_user['account_type'] == 2){
                echo "<div class='bc_header'> $BabySitterProfile</div>";
          }
    ?>
    <form method="post" class="profile_form" enctype="multipart/form-data">
        <?php
        if (isset($_SESSION['user']) && $profile_user['id'] == $_SESSION['user']['id']){
        /*
        array (
            [image] => Array (
                [name] => avatar-couple-default-profile-picture-collection-male-female-36011095.jpg
                [type] => image/jpeg
                [tmp_name] => /tmp/phpIUlnZ2
                [error] => 0
                [size] => 52128
                            )
              )
        */
        if (isset($_POST['update'])){
            extract($_POST);
           
            if ($marital == 'none')
                $marital = null;
            
            if ($country == 'none')
                $country = null;
           
            
            if ($children == 'none' || $marital == 2)
                $children = null;
                
            if ($children_age == 'none' || $marital == 2 || $children == null)
                $children_age = null;
                
                    
            if (empty($name) || empty($last_name) || empty($email)){
                echo "<div class='error' style='width: 500px'>
                        $EM3required
                      </div>";
            }elseif( $marital == 2 && ( $children != 0 || $children_age != 0 ) ){
                echo "<div class='error' style='width: 500px'>
                    $EMchangemarial
                      </div>";
            }else{
                if (isset($_FILES['image']) && $_FILES['image']['error'] == 0 && explode("/", $_FILES['image']['type'])[0] == 'image' ){
                    $ext = explode(".", $_FILES['image']['name']);
                    $ext = $ext[count($ext) - 1];
                    $ext = "abc".time().".".$ext;
                    $src = "upload/imgs/".$ext;
                    move_uploaded_file($_FILES['image']['tmp_name'], $src);
                    $img = $src;
                }else{
                     if ($gender == 2)
                 $img = 'imgs/female.png';
            if ($gender == 1)
                  $img = 'imgs/male.png';
                }
                
               if (user_email_exist($email)&& !$email==$_SESSION['user']['id'] ){
                echo "<div class='error'>
                       $EMEmailexist 
                     </div>";  
                
            }else{
                 
                list($userName, $mailDomain) = split("@", $email);
              if (checkdnsrr($mailDomain, "MX")) {   
                    
              
                $result = user_update($name, $last_name, $email, $age, $img, $gender, $marital, $country, $children, $children_age, $type);
                if ($result){
                    echo "<div class='succes' style='width: 500px'>
                        $EMsuccessfelyprofile
                          </div>";
                    $user = user_get_by_id($_SESSION['user']['id']);
                    $_SESSION['user'] = $user;
                }else{
                    echo "<div class='error' style='width: 500px'>
                           $EMtryagaint
                          </div>";
                }
              } else{
                   echo "<div class='error'>
                         $EMinvalidEmail 
                     </div>"; 
                } 
                
                
            }
              }
        }
        /* [name] => tarek
         * [last_name] =>
         * [email] => tarek@t.t
         * [age] => 18
         * [image] =>
         * [gender] => 1
         * [marital] => 1
         * [country] => none
         * [children] => none
         * [children_age] => none
         * [type] => 1
         * [update] => Update )
        */
        ?>
        <table>
            <tr>
                <td><?php echo $FirstName ?></td>
                <td><input type="text" name="name" value="<?php
                                                            echo $_SESSION['user']['f_name'];
                                                        ?>" /></td>
            </tr>
            
            <tr>
                <td><?php echo $LastName ?></td>
                <td><input type="text" name="last_name" value="<?php
                                                        if (isset($_SESSION['user']['l_name']))
                                                            echo $_SESSION['user']['l_name'];
                                                        ?>" /></td>
            </tr>
            
            <tr>
                <td><?php echo $Email ?></td>
                <td><input type="email" name="email" value="<?php
                                                            echo $_SESSION['user']['email'];
                                                        ?>" /></td>
            </tr>
            
            <tr>
                <td><?php echo $ProfilePicture ?></td>
                <td><input type="file" name="image" /></td>
            </tr>
            
            <tr>
                <td><?php echo $Gneder ?></td>
                <td><select name="gender">
                    <option value="1" <?php if ($_SESSION['user']['gender'] == 1) echo "selected" ?> ><?php echo $Male ?></option>
                    <option value="2" <?php if ($_SESSION['user']['gender'] == 2) echo "selected" ?> ><?php echo $Female ?></option>
                </select></td>
            </tr>
            
            <tr>
                <td><?php echo $Maritalstatus ?></td>
                <td><select name="marital">
                    <option value="none" <?php if ($_SESSION['user']['marital_status'] == null) echo "selected" ?> >------</option>
                    <option value="1" <?php if ($_SESSION['user']['marital_status'] == 1) echo "selected" ?> ><?php echo $Married ?></option>
                    <option value="2" <?php if ($_SESSION['user']['marital_status'] == 2) echo "selected" ?> ><?php echo $Unmarried ?></option>
                </select></td>
            </tr>
            
            <tr>
                <td><?php echo $Country ?></td>
                <td>
                    <select name="country">
                        <option selected <?php if ($_SESSION['user']['contry'] != null) echo "value='{$_SESSION['user']['contry']}'" ?> >
                                                        <?php
                                                        if (isset($_SESSION['user']['contry']) != null)
                                                            echo " - ".$_SESSION['user']['contry']." - ";
                                                        ?></option>
                        <option value="Afghanistan">Afghanistan</option>
                        <option value="Aland Islands">Aland Islands</option>
                        <option value="Albania">Albania</option>
                        <option value="Algeria">Algeria</option>
                        <option value="American Samoa">American Samoa</option>
                        <option value="Andorra">Andorra</option>
                        <option value="Angola">Angola</option>
                        <option value="Anguilla">Anguilla</option>
                        <option value="Antarctica">Antarctica</option>
                        <option value="Antigua and Barbuda">Antigua and Barbuda</option>
                        <option value="Argentina">Argentina</option>
                        <option value="Armenia">Armenia</option>
                        <option value="Aruba">Aruba</option>
                        <option value="Australia">Australia</option>
                        <option value="Austria">Austria</option>
                        <option value="Azerbaijan">Azerbaijan</option>
                        <option value="Bahamas">Bahamas</option>
                        <option value="Bahrain">Bahrain</option>
                        <option value="Bangladesh">Bangladesh</option>
                        <option value="Barbados">Barbados</option>
                        <option value="Belarus">Belarus</option>
                        <option value="Belgium">Belgium</option>
                        <option value="Belize">Belize</option>
                        <option value="Benin">Benin</option>
                        <option value="Bermuda">Bermuda</option>
                        <option value="Bhutan">Bhutan</option>
                        <option value="Bolivia">Bolivia</option>
                        <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
                        <option value="Botswana">Botswana</option>
                        <option value="Bouvet Island">Bouvet Island</option>
                        <option value="Brazil">Brazil</option>
                        <option value="British Indian">British Indian</option>
                        <option value="Brunei Darussalam">Brunei Darussalam</option>
                        <option value="Bulgaria">Bulgaria</option>
                        <option value="Burkina Faso">Burkina Faso</option>
                        <option value="Burundi">Burundi</option>
                        <option value="Cambodia">Cambodia</option>
                        <option value="Cameroon">Cameroon</option>
                        <option value="Canada">Canada</option>
                        <option value="Cape Verde">Cape Verde</option>
                        <option value="Cayman Islands">Cayman Islands</option>
                        <option value="Central African">Central African</option>
                        <option value="Chad">Chad</option>
                        <option value="Chile">Chile</option>
                        <option value="China">China</option>
                        <option value="Christmas Island">Christmas Island</option>
                        <option value="Cocos Islands">Cocos Islands</option>
                        <option value="Colombia">Colombia</option>
                        <option value="Comoros">Comoros</option>
                        <option value="Congo">Congo</option>
                        <option value="Cook Islands">Cook Islands</option>
                        <option value="Costa Rica">Costa Rica</option>
                        <option value="Cote D'ivoire">Cote D'ivoire</option>
                        <option value="Croatia">Croatia</option>
                        <option value="Cuba">Cuba</option>
                        <option value="Cyprus">Cyprus</option>
                        <option value="Czech Republic">Czech Republic</option>
                        <option value="Denmark">Denmark</option>
                        <option value="Djibouti">Djibouti</option>
                        <option value="Dominica">Dominica</option>
                        <option value="Dominican Republic">Dominican Republic</option>
                        <option value="Ecuador">Ecuador</option>
                        <option value="Egypt">Egypt</option>
                        <option value="El Salvador">El Salvador</option>
                        <option value="Equatorial Guinea">Equatorial Guinea</option>
                        <option value="Eritrea">Eritrea</option>
                        <option value="Estonia">Estonia</option>
                        <option value="Ethiopia">Ethiopia</option>
                        <option value="Falkland Islands">Falkland Islands</option>
                        <option value="Faroe Islands">Faroe Islands</option>
                        <option value="Fiji">Fiji</option>
                        <option value="Finland">Finland</option>
                        <option value="France">France</option>
                        <option value="French Guiana">French Guiana</option>
                        <option value="French Polynesia">French Polynesia</option>
                        <option value="Gabon">Gabon</option>
                        <option value="Gambia">Gambia</option>
                        <option value="Georgia">Georgia</option>
                        <option value="Germany">Germany</option>
                        <option value="Ghana">Ghana</option>
                        <option value="Gibraltar">Gibraltar</option>
                        <option value="Greece">Greece</option>
                        <option value="Greenland">Greenland</option>
                        <option value="Grenada">Grenada</option>
                        <option value="Guadeloupe">Guadeloupe</option>
                        <option value="Guam">Guam</option>
                        <option value="Guatemala">Guatemala</option>
                        <option value="Guernsey">Guernsey</option>
                        <option value="Guinea">Guinea</option>
                        <option value="Guinea-bissau">Guinea-bissau</option>
                        <option value="Guyana">Guyana</option>
                        <option value="Haiti">Haiti</option>
                        <option value="Honduras">Honduras</option>
                        <option value="Hong Kong">Hong Kong</option>
                        <option value="Hungary">Hungary</option>
                        <option value="Iceland">Iceland</option>
                        <option value="India">India</option>
                        <option value="Indonesia">Indonesia</option>
                        <option value="Iran">Iran</option>
                        <option value="Iraq">Iraq</option>
                        <option value="Ireland">Ireland</option>
                        <option value="Isle of Man">Isle of Man</option>
                        <option value="Italy">Italy</option>
                        <option value="Jamaica">Jamaica</option>
                        <option value="Japan">Japan</option>
                        <option value="Jersey">Jersey</option>
                        <option value="Jordan">Jordan</option>
                        <option value="Kazakhstan">Kazakhstan</option>
                        <option value="Kenya">Kenya</option>
                        <option value="Kiribati">Kiribati</option>
                        <option value="Korea">Korea</option>
                        <option value="Kuwait">Kuwait</option>
                        <option value="Kyrgyzstan">Kyrgyzstan</option>
                        <option value="Latvia">Latvia</option>
                        <option value="Lebanon">Lebanon</option>
                        <option value="Lesotho">Lesotho</option>
                        <option value="Liberia">Liberia</option>
                        <option value="Libyan">Libyan</option>
                        <option value="Liechtenstein">Liechtenstein</option>
                        <option value="Lithuania">Lithuania</option>
                        <option value="Luxembourg">Luxembourg</option>
                        <option value="Macao">Macao</option>
                        <option value="Macedonia">Macedonia</option>
                        <option value="Madagascar">Madagascar</option>
                        <option value="Malawi">Malawi</option>
                        <option value="Malaysia">Malaysia</option>
                        <option value="Maldives">Maldives</option>
                        <option value="Mali">Mali</option>
                        <option value="Malta">Malta</option>
                        <option value="Marshall Islands">Marshall Islands</option>
                        <option value="Martinique">Martinique</option>
                        <option value="Mauritania">Mauritania</option>
                        <option value="Mauritius">Mauritius</option>
                        <option value="Mayotte">Mayotte</option>
                        <option value="Mexico">Mexico</option>
                        <option value="Moldova">Moldova</option>
                        <option value="Monaco">Monaco</option>
                        <option value="Mongolia">Mongolia</option>
                        <option value="Montenegro">Montenegro</option>
                        <option value="Montserrat">Montserrat</option>
                        <option value="Morocco">Morocco</option>
                        <option value="Mozambique">Mozambique</option>
                        <option value="Myanmar">Myanmar</option>
                        <option value="Namibia">Namibia</option>
                        <option value="Nauru">Nauru</option>
                        <option value="Nepal">Nepal</option>
                        <option value="Netherlands">Netherlands</option>
                        <option value="Netherlands Antilles">Netherlands Antilles</option>
                        <option value="New Caledonia">New Caledonia</option>
                        <option value="New Zealand">New Zealand</option>
                        <option value="Nicaragua">Nicaragua</option>
                        <option value="Niger">Niger</option>
                        <option value="Nigeria">Nigeria</option>
                        <option value="Niue">Niue</option>
                        <option value="Norfolk Island">Norfolk Island</option>
                        <option value="Northern Mariana Islands">Northern Mariana Islands</option>
                        <option value="Norway">Norway</option>
                        <option value="Oman">Oman</option>
                        <option value="Pakistan">Pakistan</option>
                        <option value="Palau">Palau</option>
                        <option value="Palestinian">Palestinian</option>
                        <option value="Panama">Panama</option>
                        <option value="Papua New Guinea">Papua New Guinea</option>
                        <option value="Paraguay">Paraguay</option>
                        <option value="Peru">Peru</option>
                        <option value="Philippines">Philippines</option>
                        <option value="Pitcairn">Pitcairn</option>
                        <option value="Poland">Poland</option>
                        <option value="Portugal">Portugal</option>
                        <option value="Puerto Rico">Puerto Rico</option>
                        <option value="Qatar">Qatar</option>
                        <option value="Reunion">Reunion</option>
                        <option value="Romania">Romania</option>
                        <option value="Russian Federation">Russian Federation</option>
                        <option value="Rwanda">Rwanda</option>
                        <option value="Saint Helena">Saint Helena</option>
                        <option value="Saint Lucia">Saint Lucia</option>
                        <option value="Samoa">Samoa</option>
                        <option value="San Marino">San Marino</option>
                        <option value="Sao Tome and Principe">Sao Tome and Principe</option>
                        <option value="Saudi Arabia">Saudi Arabia</option>
                        <option value="Senegal">Senegal</option>
                        <option value="Serbia">Serbia</option>
                        <option value="Seychelles">Seychelles</option>
                        <option value="Sierra Leone">Sierra Leone</option>
                        <option value="Singapore">Singapore</option>
                        <option value="Slovakia">Slovakia</option>
                        <option value="Slovenia">Slovenia</option>
                        <option value="Solomon Islands">Solomon Islands</option>
                        <option value="Somalia">Somalia</option>
                        <option value="South Africa">South Africa</option>
                        <option value="South Georgia">South Georgia</option>
                        <option value="Spain">Spain</option>
                        <option value="Sri Lanka">Sri Lanka</option>
                        <option value="Sudan">Sudan</option>
                        <option value="Suriname">Suriname</option>
                        <option value="Swaziland">Swaziland</option>
                        <option value="Sweden">Sweden</option>
                        <option value="Switzerland">Switzerland</option>
                        <option value="Syrian">Syrian</option>
                        <option value="Taiwan">Taiwan</option>
                        <option value="Tajikistan">Tajikistan</option>
                        <option value="Tanzania">Tanzania</option>
                        <option value="Thailand">Thailand</option>
                        <option value="Timor-leste">Timor-leste</option>
                        <option value="Togo">Togo</option>
                        <option value="Tokelau">Tokelau</option>
                        <option value="Tonga">Tonga</option>
                        <option value="Trinidad and Tobago">Trinidad and Tobago</option>
                        <option value="Tunisia">Tunisia</option>
                        <option value="Turkey">Turkey</option>
                        <option value="Turkmenistan">Turkmenistan</option>
                        <option value="Tuvalu">Tuvalu</option>
                        <option value="Uganda">Uganda</option>
                        <option value="Ukraine">Ukraine</option>
                        <option value="United Emirates">United Emirates</option>
                        <option value="United Kingdom">United Kingdom</option>
                        <option value="United States">United States</option>
                        <option value="Uruguay">Uruguay</option>
                        <option value="Uzbekistan">Uzbekistan</option>
                        <option value="Vanuatu">Vanuatu</option>
                        <option value="Venezuela">Venezuela</option>
                        <option value="Viet Nam">Viet Nam</option>
                        <option value="Wallis and Futuna">Wallis and Futuna</option>
                        <option value="Western Sahara">Western Sahara</option>
                        <option value="Yemen">Yemen</option>
                        <option value="Zambia">Zambia</option>
                        <option value="Zimbabwe">Zimbabwe</option>
                    </select>
                </td>
            </tr>
            
            <tr>
                <td><?php echo $Children ?></td>
                <td>
                    <select name="children">
                        <option value="none" <?php if ($_SESSION['user']['children'] == null) echo "selected" ?> ></option>
                        <?php
                            for ($i = 1; $i< 15; $i++){
                                if ($_SESSION['user']['children'] == $i)
                                    echo "<option value='$i' selected >$i</option>";
                                else
                                    echo "<option value='$i'>$i</option>";
                            }
                        ?>
                    </select>
                </td>
            </tr>
            
            <tr>
                <td><?php echo $ChildrenAge ?></td>
                <td>
                    <select name="children_age">
                        <option value="none" <?php if ($_SESSION['user']['children'] == null) echo "selected" ?> ></option>
                        <?php
                            for ($i = 1; $i< 15; $i++){
                                if ($_SESSION['user']['children_age'] == $i)
                                    echo "<option value='$i' selected >$i</option>";
                                else
                                    echo "<option value='$i'>$i</option>";
                            }
                        ?>
                    </select>
                </td>
            </tr>
             <tr>
                <td><?php echo $YourAge ?></td>
                <td>
                    <select name="age">
                        
                        <?php
                            for ($i = 18 ; $i < 100 ; $i++){
                                if ($i == $_SESSION['user']['age'])
                                    echo "<option value='$i' selected >$i</option>";
                                else
                                    echo "<option value='$i'>$i</option>";
                                
                            }
                        ?>
                        
                    </select>
                </td>
            </tr>
            
            <tr>
                <td><?php echo $AccountType ?></td>
                <td><select name="type">
                    <option value="1" <?php if ($_SESSION['user']['account_type'] == 1) echo "selected" ?> ><?php echo $NormalUser ?></option>
                    <option value="2" <?php if ($_SESSION['user']['account_type'] == 2) echo "selected" ?> ><?php echo $BabySitter ?></option>
                </select></td>
            </tr>
            
            <tr>
                <td colspan="2"><input type="submit" name="update" value="<?php echo $Update ?>" /></td>
            </tr>
        </table>
        
        <?php }else{
            $f_name = $profile_user['f_name'];
            $l_name = $profile_user['l_name'];
            $email  = $profile_user['email'];
            $age    = $profile_user['age'];
            $date   = strftime('%d/%m/%Y %H:%M',$profile_user['date']);
            $f_number = count($profile_user['frineds']);
            $p_number = count($profile_user['post']);
            $l_number = count($profile_user['like_post']);
            $c_number = count($profile_user['comment_post']);
            $country  = $profile_user['contry'];
            $child_number = $profile_user['children'];
            $child_age = $profile_user['children_age'];
             
            
            
            
            if ($profile_user['account_type'] == 1)
                $account_type = $NormalUser ;
            
            if ($profile_user['account_type'] == 2)
                $account_type = $BabySitter ;
                
                
                
                
            if ($profile_user['gender'] == 1)
                $gender = $Male;
            
            if ($profile_user['gender'] == 2)
                $gender = $Female ;
            
            
            if ($profile_user['marital_status'] == 1)
                $mr_status = $Married ;
            
            if ($profile_user['marital_status'] == 2)
                $mr_status =  $Unmarried ;
            
            if ($profile_user['marital_status'] == null)
                $mr_status = $Notselected ;
                
             if ($country == null)
                $country = $Notselected ;
                
            if ($child_number == null)
                $child_number = $Notselected ;
                
            if ($child_age == null)
                $child_age =  $Notselected ;
                
            if ($l_name == null)
                $l_name = $Notselected ;
                
              if (isset($_SESSION['admin'])){  
           if ($profile_user['account_status']===1){?> 
         <a href="<?php echo "admin.php?id={$profile_user['id']}"; ?>"><strong>BLOCK</strong></a>
           <?php   }else{?> 
           <a href="<?php echo "admin.php?id={$profile_user['id']}"; ?>"><strong>UnBLOCK</strong></a>
              <?php } }?>  
        

       <?php
                echo "<br><h1 class='title_info'> $ProfileInformation </h1>
                <table class='table_info'>
                
                      
                    <tr>
                        <td>$FirstName </td>
                        <td>$f_name</td>
                    </tr>
                    
                    <tr>
                        <td>  $LastName </td>
                        <td>$l_name</td>
                    </tr>
                    
                    <tr>
                        <td>$Email </td>
                        <td>$email</td>
                    </tr>
                    
                    <tr>
                        <td> $Age </td>
                        <td>$age</td>
                    </tr>
                    
                    <tr>
                        <td>$SubscribeDate </td>
                        <td>$date</td>
                    </tr>
                    
                    <tr>
                        <td> $FriendsNumber </td>
                        <td>$f_number</td>
                    </tr>
                    
                    <tr>
                        <td>$PostNumber</td>
                        <td>$p_number</td>
                    </tr>
                    
                    <tr>
                        <td> $LikeNumber </td>
                        <td>$l_number</td>
                    </tr>
                    
                    <tr>
                        <td>$CommentNumber </td>
                        <td>$c_number</td>
                    </tr>
                    
                    <tr>
                        <td>$Gneder </td>
                        <td>$gender</td>
                    </tr>
                    
                    <tr>
                        <td>$Maritalstatus </td>
                        <td>$mr_status</td>
                    </tr>
                    
                    <tr>
                        <td>$Country </td>
                        <td>$country</td>
                    </tr>
                    
                    <tr>
                        <td>$Children </td>
                        <td>$child_number</td>
                    </tr>
                    
                    <tr>
                        <td>$ChildrenAge </td>
                        <td>$child_age</td>
                    </tr>
                    
                    <tr>
                        <td>$TypeMumbership </td>
                        <td>$account_type</td>
                    </tr>
                </table>
                    ";
              }
        ?>
    </form>
    
    <div class="profile_conten">
        <div class="unwented_stuff">
            <h1><?php echo $UnwentedStuff ?></h1>
            <?php if (isset($_SESSION['user']) && $_SESSION['user']['id'] == $profile_user['id'] && $_SESSION['user']['account_status'] !== 0 ){ ?>
            <a href="new_stuff.php" class="add_stuff"><?php echo $AddNewStuff ?></a>
            <br><br>
            <?php } ?>
            <div class="stuff_container">
                
                
                
                <?php
                $stuff = suff_get_by_u_id($profile_user['id']);
                if ($stuff){
                    stuff_print($stuff);                    
                }elseif(isset($_SESSION['user']) && $_SESSION['user']['id'] == $profile_user['id']){
                    echo "<br><br><br><br><br><br><br><br><br>
                          <div class='error' style='width: 500px'>
                          $EMnostuff
                          </div>";
                }else{
                    echo "<br><br><br><br><br><br><br><br><br>
                          <div class='error' style='width: 500px'>
                            $EMnostuffu
                          </div>";
                }
                
                ?>
                
                
                
                
            </div>
            
            
            
        <div style="clear: both"></div>    
        </div><!--unwented_stuff-->
        
        
        <div class="friend_list">
            <h1><?php echo $FriendsList ?></h1>
            <div class="stuff_container friend_container">
                <?php
                
                    if (count($profile_user['frineds']) == 0){
                        echo "<br><br><br><br><br><br><br><br><br>
                              <div class='error' style='width: 500px'>
                                 $EMnofriend
                              </div>";
                    }else{
                        foreach ($profile_user['frineds'] as $f_id){
                            $f_user = user_get_by_id($f_id);
                            if ($f_user['account_type'] == 2)
                                $bc =  $BabySitter ;
                            else
                                $bc = $NormalUser ;
                            echo "<div class='friend'>
                                    <a href='profile.php?id={$f_user['id']}'>
                                        <img src='{$f_user['img']}' />
                                        <p class='name'>{$f_user['f_name']} {$f_user['l_name']}</p>
                                        <div class='baby_center_friends'> ($bc)</div>
                                    </a>
                                  </div>";
                        }
                    }
                    
                
                ?>
                
                
            </div>    
        <div style="clear: both"></div>     
        </div><!-- friend_list -->
        
        <?php if ($_SESSION['user']['id'] == $profile_user['id']){ ?>
        <div class="friend_list">
            <h1><?php echo $RequestIn ?></h1>
            <div class="stuff_container friend_container">
                <?php
                
                    if (count($_SESSION['user']['req_in']) == 0){
                        echo "<br><br><br><br><br><br><br><br><br>
                              <div class='error' style='width: 500px'>
                                  $EMnorequestin
                              </div>";
                    }else{
                        foreach ($_SESSION['user']['req_in'] as $f_id){
                            $f_user = user_get_by_id($f_id);
                            if ($f_user['account_type'] == 2)
                                $bc =  $BabySitter;
                            else
                                $bc = $NormalUser ;
                            echo "<div class='friend'>
                                    <a href='profile.php?id={$f_user['id']}'>
                                        <img src='{$f_user['img']}' />
                                        <p class='name'>{$f_user['f_name']} {$f_user['l_name']}</p>
                                        <div class='baby_center_friends'> ($bc)</div>
                                    </a>
                                  </div>";
                        }
                    }
                    
                
                ?>
                
                
            </div>    
        <div style="clear: both"></div>     
        </div><!-- friend_list -->
        
        
        
        <div class="friend_list">
            <h1><?php echo $RequestOut ?></h1>
            <div class="stuff_container friend_container">
                <?php
                
                    if (count($_SESSION['user']['req_out']) == 0){
                        echo "<br><br><br><br><br><br><br><br><br>
                              <div class='error' style='width: 500px'>
                                  $EMnorequestout
                              </div>";
                    }else{
                        foreach ($_SESSION['user']['req_out'] as $f_id){
                            $f_user = user_get_by_id($f_id);
                            if ($f_user['account_type'] == 2)
                                $bc =  $BabySitter ;
                            else
                                $bc = $NormalUser ;
                            echo "<div class='friend'>
                                    <a href='profile.php?id={$f_user['id']}'>
                                        <img src='{$f_user['img']}' />
                                        <p class='name'>{$f_user['f_name']} {$f_user['l_name']}</p>
                                        <div class='baby_center_friends'> ($bc) </div>
                                    </a>
                                  </div>";
                        }
                    }
                    
                  
                
                ?>
                
                
            </div>    
        <div style="clear: both"></div>     
        </div><!-- friend_list -->
        <?php } ?>
        
        
    </div>
    
</div>
<?php include "include/footer.php"; ?>