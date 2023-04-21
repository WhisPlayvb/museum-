<?php
session_start();
$countries = array("India", "Afghanistan", "Albania", "Algeria", "American Samoa", "Andorra", "Angola", "Anguilla", "Antarctica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegowina", "Botswana", "Bouvet Island", "Brazil", "British Indian Ocean Territory", "Brunei Darussalam", "Bulgaria", "Burkina Faso", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island", "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo", "Congo, the Democratic Republic of the", "Cook Islands", "Costa Rica", "Cote d'Ivoire", "Croatia (Hrvatska)", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "East Timor", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Falkland Islands (Malvinas)", "Faroe Islands", "Fiji", "Finland", "France", "France Metropolitan", "French Guiana", "French Polynesia", "French Southern Territories", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Gibraltar", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard and Mc Donald Islands", "Holy See (Vatican City State)", "Honduras", "Hong Kong", "Hungary", "Iceland", "Indonesia", "Iran (Islamic Republic of)", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Korea, Democratic People's Republic of", "Korea, Republic of", "Kuwait", "Kyrgyzstan", "Lao, People's Democratic Republic", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libyan Arab Jamahiriya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia, The Former Yugoslav Republic of", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia, Federated States of", "Moldova, Republic of", "Monaco", "Mongolia", "Montserrat", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcairn", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romania", "Russian Federation", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Seychelles", "Sierra Leone", "Singapore", "Slovakia (Slovak Republic)", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia and the South Sandwich Islands", "Spain", "Sri Lanka", "St. Helena", "St. Pierre and Miquelon", "Sudan", "Suriname", "Svalbard and Jan Mayen Islands", "Swaziland", "Sweden", "Switzerland", "Syrian Arab Republic", "Taiwan, Province of China", "Tajikistan", "Tanzania, United Republic of", "Thailand", "Togo", "Tokelau", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Turks and Caicos Islands", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "United States Minor Outlying Islands", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Virgin Islands (British)", "Virgin Islands (U.S.)", "Wallis and Futuna Islands", "Western Sahara", "Yemen", "Yugoslavia", "Zambia", "Zimbabwe");

//  CSRF Token
$csrf_token = rand(10000,90000);
$_SESSION['csrf_token'] = $csrf_token;

?>


<?php include "navbar.php"; ?>

    <div class="container p-4 mt-4 mb-5 shadow border rounded">
        <h2 class="text-primary text-center">Register here..!</h2>
        <?php  if(isset($_SESSION['msg'])){  ?>
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <strong>
                <?php echo $_SESSION['msg'];    
                    $_SESSION['msg'] = null; 
                ?>
                </strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php }?>      
        <form onsubmit="return validate();" id="reg_form" method="POST" class="form p-4" enctype="multipart/form-data">
            <div id="part-1">
                <select name="country" id="countries" class="form-select" aria-label="Default select example">
                    <?php
                    for($i=0; $i<count($countries); $i++){
                        ?>
                        <option value="<?php echo $countries[$i]; ?>"><?php echo $countries[$i]; ?></option>                    
                        <?php
                    }
                    ?>
                </select>
                <div class="text-center p-5">
                    <button class="btn btn-primary" onclick="return chk_countries();"><i class="fa fa-arrow-right"></i></button>
                </div>
            </div>
            <div id="part-2">
                <!-- <div class="mb-3 mt-2">
                    <label for="aadhaar_no" id="aadhaar_no_label"><b>Enter Adhar Card Number</b></label>
                    <input type="text" placeholder="eg. 9876    6775    6546" maxlength="20" onchange="aadhaar_validation()" name="id_proof" id="aadhaar_no" class="form-control" required>
                </div>
                <div class="mb-3 mt-2">
                    <label for="passport_id" id="passport_id_label"><b>Enter Passport ID</b></label>    
                    <input type="text" name="id_proof" id="passport_id" class="form-control" required>
                </div> -->
                <!-- <hr>
                <div class="mb-3">
                    <label for="image"><b>Upload ID Proof</b> <i class="text-warning"> (Only jpg, jpeg and png)</i></label>
                    <input type="file" name="id_proof_img" onchange="Filevalidation()" id="image" class="form-control" required>
                </div> -->
                <hr>
                <div class="mb-3">
                    <label for="email"><b>Enter Email ID</b> <i class="text-warning">(We'll send verification email)</i></label>
                    <input type="email" placeholder="eg. john@gmail.com" name="email" id="email" class="form-control" required>
                </div>
                <hr>
                <div class="mb-3">
                    <label for="phone"><b>Enter Mobile Number</b> <i class="text-info">(with country code)</i> <i class="text-warning">(We'll send verification link)</i></label>
                    <input type="number" placeholder="eg. +91 9067404012" name="phone" id="phone" class="form-control" required onchange="chk_phone()"><span id="message"></span>
                </div>
                <hr>
                <div class="mb-3">
                    <label for="fname"><b>Enter First Name</b></label>
                    <input type="text" placeholder="eg. Pankaj" name="fname" id="fname" class="form-control" required>
                </div>
                <hr>
                <div class="mb-3">
                    <label for="mname"><b>Enter Middle Name</b></label>
                    <input type="text" placeholder="eg. Smith" name="mname" id="mname" class="form-control" required>
                </div>
                <hr>
                <div class="mb-3">
                    <label for="lname"><b>Enter Last Name</b></label>
                    <input type="text" placeholder="eg. Saxena" name="lname" id="lname" class="form-control" required>
                </div>
                <hr>
                <input type="hidden" name="csrf_token" value = "<?php echo $csrf_token; ?>">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="gender" id="male" value="male" checked>
                    <label class="form-check-label" for="male"><b>Male</b></label>
                    </div>
                    <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="gender" id="female" value="male">
                    <label class="form-check-label" for="female"><b>Female</b></label>
                </div>
                <hr>
                <div class="mb-3 mt-2">
                    <label for="lname"><b>Date Of Birth</b></label>
                    <input type="date" name="dob" id="dob" min="1980-01-02" class="form-control" required>
                </div>
                <hr>
                <div class="mb-3">
                    <label for="address"><b>Enter Current Address</b></label>
                    <input type="text" placeholder="eg. Road No.6, Santacruz (east), Mumbai" maxlength="150" name="address" id="address" class="form-control" required>
                </div>
                <hr>
                <div class="text-center p-5">
                    <button class="btn btn-primary" name="register" value="true"><b>Register </b><i class="fa fa-arrow-right"></i></button>
                </div>
            </div>
        </form>
<!--  -->
       
    </div>
    <script>
        var part_1 = document.getElementById("part-1");
        var part_2 = document.getElementById("part-2");
        part_2.style.display = "none";
        document.getElementById("passport_id").style.display = "none";
        
        function chk_countries(){
            var aadhaar_no = document.getElementById("aadhaar_no");
            var aadhaar_no_label = document.getElementById("aadhaar_no_label");
            
            var passport_id = document.getElementById("passport_id");
            var passport_id_label = document.getElementById("passport_id_label");
            
            part_2.style.display = "block";
            part_1.style.display = "none";
            var country = document.getElementById("countries").value;
            if(country != "India"){
                aadhaar_no.style.display = "none";
                aadhaar_no_label.style.display = "none";
                passport_id.style.display = "block";
                aadhaar_no.remove();
            }else{
                passport_id.style.display = "none";
                passport_id_label.style.display = "none";
                aadhaar_no.style.display = "block";
                passport_id.remove();
            }
            return false;
        }

        var goodColor = "#0C6";
        var badColor = "#fc0303";

        
        //  Validates if  proof image is less than 4 mb
        Filevalidation = () => {
            const fi = document.getElementById('image');
            // Check if any file is selected.
            if (fi.files.length > 0) {
                for (var i = 0; i <= fi.files.length - 1; i++) {
    
                    const fsize = fi.files.item(i).size;
                    const file = Math.round((fsize / 1024));
                    // The size of the file.
                    if (file >= 4096) {
                        alert("File too Big, please select a file less than 4mb");
                        fi.style.color = badColor;
                        return false;
                    } else {
                        // document.getElementById('size').innerHTML = "<b>"+ file + "</b> KB";
                        alert("File Uploded Successfully")
                        fi.style.color = goodColor;
                        return true;
                    }
                }
            }
        }


        //  Give Space after 4 digit of aadhaar card no.
        var aadhaar_input = document.getElementById("aadhaar_no");
        aadhaar_input.onkeydown = function () {
            
            if (aadhaar_input.value.length > 0 && aadhaar_input.value.length < 20) {

                if (aadhaar_input.value.length % 4 == 0) {
                    aadhaar_input.value += "    ";
                }
            }            
        }


        //  Validates Aadhaar number
        function aadhaar_validation(){
            var regexp=/^[2-9]{1}[0-9]{3}\s\s\s\s{1}[0-9]{4}\s\s\s\s{1}[0-9]{4}$/;
            
            var x = document.getElementById("aadhaar_no");
            
            if(regexp.test(x.value)){
                    x.style.color = goodColor;
                    return true;
            }
            else{
                alert("Invalid Aadhar Number");
                x.style.color = badColor;
                return false;
            }
        }


        //  Checks Indian Number is 10 Digit or not

        function chk_phone(){

            var country = document.getElementById('countries').value;
            if(country == "India"){
                var mobile = document.getElementById('phone');

                var message = document.getElementById('message');
                
                if(mobile.value.length != 12){
                    mobile.style.backgroundColor = badColor;
                    message.style.color = badColor;
                    message.innerHTML = "required 10 digits, match requested format!"
                    return false;
                }else{
                    if(/^[\+]?(91)[7-9][0-9]{9}$/im.test(mobile.value)){
                        mobile.style.backgroundColor = goodColor;
                        message.style.color = goodColor;
                        message.innerHTML = "Valid Phone Number"
                        return true;
                    }else{
                        mobile.style.backgroundColor = badColor;
                        message.style.color = badColor;
                        message.innerHTML = "Please enter correct phone number"
                    }
                }
            }else{
                return true;
            }
        }

        //  Form Validations
        function validate(){
            var email = document.getElementById("email");
            var phone = document.getElementById("phone");
            var fname = document.getElementById("fname");
            var mname = document.getElementById("mname");
            var lname = document.getElementById("lname");

            var reg_form = document.getElementById("reg_form");
            var mailformat = /^w+([.-]?w+)*@w+([.-]?w+)*(.w{2,3})+$/;

            if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email.value)){                                
                    
                if(/^[A-Za-z]+$/.test(fname.value) && /^[A-Za-z]+$/.test(mname.value) && /^[A-Za-z]+$/.test(lname.value)){
                    var country = document.getElementById("countries").value;
                    if(country == "India"){
                        if(aadhaar_validation()){
                            if(chk_phone()){
                                reg_form.action = "reg_controller.php";
                                reg_form.submit();
                                return true;
                            }
                        }
                    }else{
                        reg_form.action = "reg_controller.php";
                        reg_form.submit();
                        return true;
                    }
                }else{
                    alert("Enter only alphabets while entering your name.")                    
                    return false;
                }
            }else{
                alert("Invalid Email ID")
                email.style.color = badColor;
                return false;
            }
            return false;
        }
   </script>   
</body>
</html>