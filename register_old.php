<?php
session_start();
$countries = array("India", "Afghanistan", "Albania", "Algeria", "American Samoa", "Andorra", "Angola", "Anguilla", "Antarctica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegowina", "Botswana", "Bouvet Island", "Brazil", "British Indian Ocean Territory", "Brunei Darussalam", "Bulgaria", "Burkina Faso", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island", "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo", "Congo, the Democratic Republic of the", "Cook Islands", "Costa Rica", "Cote d'Ivoire", "Croatia (Hrvatska)", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "East Timor", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Falkland Islands (Malvinas)", "Faroe Islands", "Fiji", "Finland", "France", "France Metropolitan", "French Guiana", "French Polynesia", "French Southern Territories", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Gibraltar", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard and Mc Donald Islands", "Holy See (Vatican City State)", "Honduras", "Hong Kong", "Hungary", "Iceland", "Indonesia", "Iran (Islamic Republic of)", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Korea, Democratic People's Republic of", "Korea, Republic of", "Kuwait", "Kyrgyzstan", "Lao, People's Democratic Republic", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libyan Arab Jamahiriya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia, The Former Yugoslav Republic of", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia, Federated States of", "Moldova, Republic of", "Monaco", "Mongolia", "Montserrat", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcairn", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romania", "Russian Federation", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Seychelles", "Sierra Leone", "Singapore", "Slovakia (Slovak Republic)", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia and the South Sandwich Islands", "Spain", "Sri Lanka", "St. Helena", "St. Pierre and Miquelon", "Sudan", "Suriname", "Svalbard and Jan Mayen Islands", "Swaziland", "Sweden", "Switzerland", "Syrian Arab Republic", "Taiwan, Province of China", "Tajikistan", "Tanzania, United Republic of", "Thailand", "Togo", "Tokelau", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Turks and Caicos Islands", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "United States Minor Outlying Islands", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Virgin Islands (British)", "Virgin Islands (U.S.)", "Wallis and Futuna Islands", "Western Sahara", "Yemen", "Yugoslavia", "Zambia", "Zimbabwe");


//  Checks the Country is from the Array..
if(isset($_POST['chk_country'])){
    $country = $_POST['country'];    
    $valid_country = false;
    for($i=0;$i<count($countries);$i++){
        if($country == $countries[$i]){
            $valid_country = true;
            break;
        }
    }
    if(!$valid_country){
        echo "<script>alert('Invalid Country...')</script>";
    }else{
        // echo "<script>alert('You Selected \'$country\' Country...')</script>";
        $_SESSION['country_checked'] = $country;
    }
}

//  Checks the Adhar Number is Valid or Not..
if(isset($_POST['chk_aadhaar_no'])){
    
    if (preg_match("/^[2-9]{1}[0-9]{3}\s\s\s\s{1}[0-9]{4}\s\s\s\s{1}[0-9]{4}/",$_POST['aadhaar_no'])) {
        // echo "<script>alert('Valid Aadhaar...')</script>";
        $_SESSION['aadhaar_no'] = $_POST['aadhaar_no'];        
    }else{
        echo "<script>alert('Invalid Aadhaar...')</script>";
    }
}

?>


<?php include "navbar.php"; ?>

    <div class="container p-4 mt-4 shadow border rounded">
        <h2 class="text-primary text-center">Register here..!</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" id="chk_country" method="POST" class="form p-4">
            <select name="country" class="form-select" aria-label="Default select example">
                <?php
                for($i=0; $i<count($countries); $i++){
                    ?>
                    <option value="<?php echo $countries[$i]; ?>"><?php echo $countries[$i]; ?></option>                    
                    <?php
                }
                ?>
            </select>            
            <div class="text-center p-5">
                <button class="btn btn-primary" name="chk_country" type="submit"><i class="fa fa-arrow-right"></i></button>
            </div>
        </form>
<!--  -->
        <?php
        if(isset($_SESSION['country_checked'])){
            ?>
            <script>
                document.getElementById("chk_country").style.display = "none";
            </script>            
            <button class="btn btn-primary m-5" onclick="<?php session_destroy();  ?> location.href = '/museum/register.php'" name="restart" type="submit"><i class="fa fa-arrow-left"></i></button>        
            <?php
            if($_SESSION['country_checked'] == "India"){                
                ?>                                  
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" id="chk_aadhaar">
                    <div class="mb-3 form-floating">
                        <input type="text" maxlength="20" name="aadhaar_no" id="aadhaar_no" class="form-control" required>
                        <label for="aadhaar_no">Adhar Number</label>
                    </div>
                    <div class="text-center p-5">
                        <button class="btn btn-primary" name="chk_aadhaar_no" type="submit"><i class="fa fa-arrow-right"></i></button>
                    </div>
                </form> 

                <script>
                    var aadhaar_input = document.getElementById("aadhaar_no");
                    aadhaar_input.onkeydown = function () {
                        
                        if (aadhaar_input.value.length > 0 && aadhaar_input.value.length < 20) {

                            if (aadhaar_input.value.length % 4 == 0) {
                                aadhaar_input.value += "    ";
                            }
                        }            
                    }
                </script>

<!--  -->
                <?php
                if(isset($_SESSION['chk_aadhaar_no'])){
                ?>
                    <script>
                        document.getElementById("chk_country").style.display = "none";
                        document.getElementById("chk_aadhaar_no").style.display = "none";
                    </script>
                    <button class="btn btn-primary m-5" onclick="<?php session_destroy();  ?> location.href = '/museum/register.php'" name="restart" type="submit"><i class="fa fa-arrow-left"></i></button>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" id="chk_email_phone">
                        <div class="mb-3 form-floating">
                            <input type="email" name="email" id="email" class="form-control" required>
                            <label for="email">Email ID</label>
                        </div>
                        <div class="mb-3 form-floating">
                            <input type="number" name="phone" id="phone" class="form-control" required>
                            <label for="phone">Mobile No</label>
                        </div>
                        <div class="text-center p-5">
                            <button class="btn btn-primary" name="chk_email_phone" type="submit"><i class="fa fa-arrow-right"></i></button>
                        </div>
                    </form>
                <?php
                }
            }else{
                echo "Thanks... Enter Your Passport ID....";
            }
            ?>            
            <?php
        }
        ?>
    </div>
    <script>         
        
        function adhar_validation(){
            var regexp=/^[2-9]{1}[0-9]{3}\s\s\s\s{1}[0-9]{4}\s\s\s\s{1}[0-9]{4}$/;
            
            var x = document.getElementById("aadhaar_no").value;
            
            if(regexp.test(x)){
                    alert("Valid Aadhar Number.");
                    var reg_form = document.getElementById('chk_aadhaar');                    
                    return true;
            }
            else{
                alert("Invalid Aadhar Number");
                return false;
            }
        }
   </script>
</body>
</html>