<?php include "include/header.php"; include_once 'include/translation.php'; ?>
<div class="search_area">
    <?php
    /*
            Array (
                [btn] => search
                [search] => fhfgh
                  )
    */
    
    ?>
    <div class="form_area">
        
        
        <div class="head_area">
            <label class="title"><?php echo $Lookfor ?></label>
            <select class="look_for">
                <option value="1"><?php echo $User ?></option>
                <option value="2"><?php echo $Posts ?></option>
                <option value="3"><?php echo $Stuffs ?></option>
            </select>
        </div>
        
        
        
        <div class="forms_place">
            <div class="part user_part">
                <form method="post">
                    <table>
                    
                        <tr>
                            <td><?php echo $write ?></td>
                            <td><input type="text" name="user_name" /></td>
                        </tr>
                        
                        <tr>
                            <td><?php echo $AccountType ?></td>
                            <td>
                                <select name="type">
                                    <option value="0"><?php echo $Notselected ?></option>
                                    <option value="1"><?php echo $NormalUser ?></option>
                                    <option value="2"><?php echo $BabySitter ?></option>
                                </select>
                            </td>
                        </tr>
                        
                        <tr>
                            <td><?php echo $Gneder ?></td>
                            <td>
                                <select name="gender">
                                    <option value="0"><?php echo $Notselected ?></option>
                                    <option value="1"><?php echo $Male ?></option>
                                    <option value="2"><?php echo $Female ?></option>
                                </select>
                            </td>
                        </tr>
                        
                        <tr>
                            <td><?php echo $Country ?></td>
                            <td>
                                <select name="country">
                                    <option value=""><?php echo $Notselected ?></option>
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
                            <td><?php echo $Maritalstatus ?></td>
                            <td>
                                <select name="marital_status">
                                    <option value="0"><?php echo $Notselected ?></option>
                                    <option value="1"><?php echo $Married ?></option>
                                    <option value="2"><?php echo $Unmarried ?></option>
                                </select>
                            </td>
                        </tr>
                        
                        <tr>
                            <td><?php echo $Age ?></td>
                            <td>
                                <input type="number" max="99" min="18" name="age_from" placeholder="<?php echo $From ?>" />
                                <input type="number" max="99" min="18" name="age_to" placeholder="<?php echo $To ?>" />
                            </td>
                        </tr>
                        
                        <tr>
                            <td colspan="2"><input type="submit" name="user_search" value="<?php echo $Search ?>" /></td>
                        </tr>
                    
                    </table>                
                </form>
            </div>
            
            
            
            <div class="part post_part" style="display: none">
                <form method="post">
                    <table>
                    
                        <tr>
                            <td><?php echo $write ?></td>
                            <td><input type="text" name="post_name" /></td>
                        </tr>
                        
                        <tr>
                            <td><?php echo $choseCategory ?></td>
                            <td>
                                <select name="cat">
                    <option value="baby_food"><?php echo $BabyFood ?></option>
                    <option value="baby_health"><?php echo $BabyHealth ?></option>
                    <option value="newborn_babies"><?php echo $NewbornBabies ?></option>
                    <option value="baby_gear"><?php echo $BabyGear ?></option>
                    <option value="baby_games"><?php echo $BabyGames ?></option>                  
                                </select>
                            </td>
                        </tr>
                        
                        <tr>
                            <td colspan="2"><input type="submit" name="post_search" value="<?php echo $Search ?>" /></td>
                        </tr>
                    
                    </table>                
                </form>
            </div>
            
            
            <div class="part stuff_part" style="display: none">
                <form method="post">
                    <table>
                    
                        <tr>
                            <td><?php echo $write ?></td>
                            <td><input type="text" name="stuff_name" /></td>
                        </tr>
                        
                        <tr>
                            <td><?php echo $price ?> ($)</td>
                            <td>
                                <input type="number" max="500" min="0" name="price_from" placeholder="<?php echo $From ?>" />
                                <input type="number" max="500" min="0" name="price_to" placeholder="<?php echo $To ?>" />
                            </td>
                        </tr>
                        
                        <tr>
                            <td colspan="2"><input type="submit" name="stuff_search" value="<?php echo $Search ?>" /></td>
                        </tr>
                    
                    </table>                
                </form>
            </div>
            
            
        </div>    
        
    </div>
    <div class="search_result">
        <h1><?php echo $Searchresult?></h1>
        <div class="content">
            
            <?php
            if (isset($_POST['btn']) && !empty($_POST['search']) ){
                $users = user_search($_POST['search']);
                if ($users){
                    foreach( $users as $user ){
                        if ($user['account_type'] == 1)
                            $acc_type = "(Normal User)";
                        if ($user['account_type'] == 2)
                            $acc_type = "(BabySitter)";
                        echo "<div class='user_result'>
                                <a href='profile.php?id={$user['id']}'>
                                    <img src='{$user['img']}'>
                                    <p class='name'>{$user['f_name']} {$user['l_name']}</p>
                                    <div class='baby_center_friends'> $acc_type </div>
                                </a>
                              </div>";
                    }
                }else{
                    echo "<div class='error' style='width: 500px'>
                            $Resaultnotfound
                          </div>";
                }
            }
            
            
            
            
            if (isset($_POST['user_search'])){
                extract($_POST);
                
                
                if (
                        !empty($user_name) ||
                        !empty($age_from) ||
                        !empty($age_to) ||
                        $type != 0 ||
                        $gender != 0 ||
                        !empty($country) || 
                        $marital_status != 0
                    ){
                    $users = user_search_detail($_POST);
                    if ($users){
                        foreach( $users as $user ){
                            if ($user['account_type'] == 1)
                                $acc_type = "(Normal User)";
                            if ($user['account_type'] == 2)
                                $acc_type = "(BabySitter)";
                            echo "<div class='user_result'>
                                    <a href='profile.php?id={$user['id']}'>
                                        <img src='{$user['img']}'>
                                        <p class='name'>{$user['f_name']} {$user['l_name']}</p>
                                        <div class='baby_center_friends'> $acc_type </div>
                                    </a>
                                  </div>";
                        }
                    }else{
                        echo "<div class='error' style='width: 500px'>
                                $Resaultnotfound
                              </div>";
                    }
                }
                
                
                
            }
            
            if (isset($_POST['post_search'])){
                if (!empty($_POST['post_name']) || !empty($_POST['cat']) ){
                    $posts = post_search_detail($_POST['post_name'], $_POST['cat']);
                    if ($posts){
                        foreach ($posts as $post){
                            $user = user_get_by_id($post['u_id']);
                            if ($post['type'] != 2)
                                $post['img'] = "imgs/not_found.png";
                            $time = strftime('%d/%m/%Y %H:%M',$post['time']);;
                            echo "<div class='post_result'>
                                    <div class='img'><a href='show_post.php?id={$post['id']}'><img src='{$post['img']}' /></a></div>
                                    <a href='show_post.php?id={$post['id']}'><div class='text'>{$post['text']}</div></a>
                                    <div class='info'>
                                        &nbsp; User : <a href='profile.php?id={$post['u_id']}' class='post_user'>{$user['f_name']} {$user['l_name']}</a> , 
                                        at : <span class='time'> $time </span>
                                        
                                        <b> {$post['likes']} like </b>
                                    </div>
                                  </div>";
                        }
                    }else{
                        echo "<div class='error' style='width: 500px'>
                                $Resaultnotfound
                              </div>";
                
                    }
                   
                }
            }
            
            
            if (isset($_POST['stuff_search'])){
                extract($_POST);
                if (!empty($stuff_name) || !empty($price_from)  ||  !empty($price_to)  ){
                    $stuffs = stuff_search_detail($stuff_name, $price_from, $price_to);
                    if ($stuffs){
                        
                        foreach ($stuffs as $stuff){
                       echo "<div class='stuff_result'>
                                <a href='show_stuff.php?id={$stuff['id']}'><img src='{$stuff['img']}' /></a>
                                <div class='desc'>
                                    <p class='name'>{$stuff['name']}</p>
                                    <p class='price'>{$stuff['price']}$</p>
                                    <td>Too see it is belong to</td>  
                        <a href='profile.php?id={$stuff['u_id']}' >Click Here</a> 
                                </div>
                            </div>";
                        }
                        
                    }else{
                        echo "<div class='error' style='width: 500px'>
                                Resault not found...
                              </div>";
                    }
                }
            }
            
            
            
            ?>
            
            
            <div style="clear: both"></div>
            <br><br>
        </div>
    </div>
</div>
<?php include "include/footer.php"; ?>