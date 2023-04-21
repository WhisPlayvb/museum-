<?php
session_start();

//  Checks the button is clicked and the CSRF token is valid.
if(isset($_POST['register']) && $_POST['csrf_token'] == $_SESSION['csrf_token']){
    require "connection.php";
    
    $id_proof = $_POST['id_proof'];

    //  Checks the Visitor Age is above 16
    if( strtotime($_POST['dob']) > strtotime('now -16 year') ){
        echo "<script>alert('Age Should be Greater than 16.'); location.href = '/museum/register.php'</script>";

    }else{
        //  Check ID Proof
        mysqli_query($con, "select visitor_id from visitors where visitor_id_proof = '$id_proof' limit 1");        
        if($con->affected_rows > 0){
            echo "<script>alert('ID Proof Already Exist.'); location.href = '/museum/register.php'</script>";
        }else{
            $email = $_POST['email'];
            $phone = $_POST['phone'];

            
            //  Checks Mobile No or Email ID Exist or Not
            mysqli_query($con, "select visitor_id from visitors where visitor_email = '$email' or visitor_mob_no = '$phone' limit 1");
            if($con->affected_rows > 0){        
                echo "<script>alert('Email Or Phone Number Already Exist.');</script>";
            }else{
                
                //  auto-generating Visitor ID
                $visitor_id = rand(10000,90000)."@NM";
                $country = $_POST['country'];        
                $fname = $_POST['fname'];
                $mname = $_POST['mname'];
                $lname = $_POST['lname'];
                $gender = $_POST['gender'];
                $dob = $_POST['dob'];
                $address = $_POST['address'];
                
                if(!empty($_FILES["id_proof_img"]["name"])) { 
                    
                    $fileName = basename($_FILES["id_proof_img"]["name"]);
                    $fileType = pathinfo($fileName, PATHINFO_EXTENSION); 
                    
                    // Allow certain file formats 
                    $allowTypes = array('jpg', 'png', 'PNG', 'jpeg');
                    if(in_array($fileType, $allowTypes)){
                        $id_proof_img = $_FILES['id_proof_img']['tmp_name']; 
                        $imgContent = addslashes(file_get_contents($id_proof_img));
                        
                        date_default_timezone_set('Asia/Kolkata');
                        $dt=date("Y-m-d H:i:s");
                        

                        //  Generating Random Password
                        $comb = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
                        $pass = array(); 
                        $combLen = strlen($comb) - 1; 
                        for ($i = 0; $i < 8; $i++) {
                            $n = rand(0, $combLen);
                            $pass[] = $comb[$n];
                        }                        
                        $passwd = implode($pass);

                        //  Inserting Information to Visitors Table
                        $insert_query = "insert into visitors (visitor_id, visitor_country, visitor_id_proof, visitor_id_proof_img, visitor_email, visitor_passwd, visitor_mob_no, visitor_fname, visitor_mname, visitor_lname, visitor_gender, visitor_dob, visitor_address, evs, mvs, reg_time) values
                                        ('$visitor_id', '$country', '$id_proof', '$imgContent', '$email', '$passwd', '$phone', '$fname', '$mname', '$lname', '$gender', '$dob', '$address', 'Inactive', 'Inactive', '$dt')";
                        $insert = mysqli_query($con, $insert_query);
                        if($insert){

                            $role = "evs";
                            ob_start();
                            include 'verifyemailcontent.php';
                            $subject = "National Museum [Email Verification]";
                            $body = ob_get_clean();
                            include 'sendEmail.php';
                            $_SESSION['msg'] = "You are registered sucessfully..! \nEmail Verification sent to Email.";                            

                        }else{
                            echo "<script>alert('Something went wrong, please try again.')</script>";
                        }
                    }else{
                        echo "<script>alert('Sorry, only JPG, JPEG, PNG files are allowed to upload.')</script>"; 
                    }
                }else{
                    echo "<script>alert('Upload ID Proof Image.')</script>"; 
                }
            }
        }
        echo "<script>location.href = '/museum/register.php'</script>"; 
    }
}else{
    header("Location: /museum");
}

?>