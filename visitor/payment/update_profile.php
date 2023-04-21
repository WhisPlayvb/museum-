<?php require "visitor_navbar.php";?>


<?php
if(isset($_POST['update']) && isset($_POST['fname']) && isset($_POST['mname']) && isset($_POST['lname'])){
    $id = $_SESSION['visitor']['visitor_id'];
    $fname = $_POST['fname'];
    $mname = $_POST['mname'];
    $lname = $_POST['lname'];
    $id_proof = $_POST['id_proof'];
    $passwd = $_POST['passwd'];
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];
    $address = $_POST['address'];

    require "../connection.php";
    $update_query = '';
    if(empty($_FILES["id_proof_img"]["name"])){
        $update_query = "update visitors set visitor_fname = '$fname', visitor_mname = '$mname', visitor_lname = '$lname', visitor_id_proof = '$id_proof', visitor_gender = '$gender', visitor_passwd = '$passwd', visitor_dob = '$dob', visitor_address = '$address' where visitor_id = '$id'";
    }else{
        if(!empty($_FILES["id_proof_img"]["name"])) { 
                    
            $fileName = basename($_FILES["id_proof_img"]["name"]);
            $fileType = pathinfo($fileName, PATHINFO_EXTENSION); 
            
            // Allow certain file formats 
            $allowTypes = array('jpg', 'png', 'PNG', 'jpeg');
            if(in_array($fileType, $allowTypes)){
                $id_proof_img = $_FILES['id_proof_img']['tmp_name']; 
                $imgContent = addslashes(file_get_contents($id_proof_img));
                $update_query = "update visitors set visitor_fname = '$fname', visitor_mname = '$mname', visitor_lname = '$lname', visitor_id_proof = '$id_proof', visitor_id_proof_img = '$imgContent', visitor_gender = '$gender', visitor_passwd = '$passwd', visitor_dob = '$dob', visitor_address = '$address' where visitor_id = '$id'";
            }else{
                echo "<script>alert('Sorry, only JPG, JPEG, PNG files are allowed to upload.')</script>"; 
            }
        }else{
            echo "<script>alert('Upload ID Proof Image.')</script>"; 
        }
    }
    mysqli_query($con, $update_query);
    
    if($con->affected_rows > 0){
        echo "<script>alert('Profile Updated Successfully'); location.href = 'index.php'</script>";
    }else{
        echo "<script>alert('Somehing went wrong');</script>";
    }
}
?>

<div class="container shadow mt-5 p-5">
<h2><i class="fa fa-edit"></i> Update Profile</h2>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" class="form" enctype="multipart/form-data">
        <div class="mt-3">
            <label for="id">Visitor ID <i class="text-warning">(Don't edit this field.)</i></label>
            <input type="text" name="id" value="<?php echo $_SESSION['visitor']['visitor_id']; ?>" disable class="form-control" readonly>
        </div>
        <div class="mt-3">
            <label for="country">Country <i class="text-warning">(Don't edit this field.)</i></label>
            <input type="text" name="country" id="country" value="<?php echo $_SESSION['visitor']['visitor_country']; ?>" class="form-control" readonly>
        </div>
        <div class="mt-3">
            <label for="fname">First Name</label>
            <input type="text" name="fname" id="fname" value="<?php echo $_SESSION['visitor']['visitor_fname']; ?>" class="form-control">
        </div>
        <div class="mt-3">
            <label for="mname">Mid Name</label>
            <input type="text" name="mname" id="mname" value="<?php echo $_SESSION['visitor']['visitor_mname']; ?>" class="form-control">
        </div>
        <div class="mt-3">
            <label for="lname">Last Name</label>
            <input type="text" name="lname" id="lname" value="<?php echo $_SESSION['visitor']['visitor_lname']; ?>" class="form-control">
        </div>
        <div class="mt-3">
            <label for="id_proof">ID Proof</label>
            <input type="text" name="id_proof" id="id_proof" maxlength="20" onchange="chk_id()" value="<?php echo $_SESSION['visitor']['visitor_id_proof']; ?>" class="form-control">
        </div>
        <div class="mt-3">
            <label for="lname">Password</label>
            <input type="text" name="passwd" id="passwd" value="<?php echo $_SESSION['visitor']['visitor_passwd']; ?>" class="form-control">
        </div>
        <div class="mb-3">
            <label for="image"><b>Upload ID Proof</b> <i class="text-warning"> (Only jpg, jpeg and png) skip this if don't want to upload.</i></label>
            <input type="file" name="id_proof_img" onchange="Filevalidation()" id="image" class="form-control">
        </div>
        <div class="form-check form-check-inline">
            <p class="text-info">Choose your gender</p>
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
            <input type="date" name="dob" value="<?php echo $_SESSION['visitor']['visitor_dob']; ?>" id="dob" min="1980-01-02" class="form-control" required>
        </div>
        <hr>
        <div class="mb-3">
            <label for="address"><b>Enter Current Address</b></label>
            <input type="text" value="<?php echo $_SESSION['visitor']['visitor_address']; ?>" placeholder="eg. Road No.6, Santacruz (east), Mumbai" maxlength="150" name="address" id="address" class="form-control" required>
        </div>
        <div class="mt-5">
            <button class="btn btn-primary" name="update" type="submit">Update</button>
        </div>
    </form>
</div>
<script>

    //  Give Space after 4 digit of aadhaar card no.
    var country = document.getElementById("country").value;
    if(country == "India"){
        var id_proof = document.getElementById("id_proof");
        id_proof.onkeydown = function () {
            
            if (id_proof.value.length > 0 && id_proof.value.length < 20) {

                if (id_proof.value.length % 4 == 0) {
                    id_proof.value += "    ";
                }
            }            
        }
    }
    var goodColor = "#0C6";
    var badColor = "#fc0303";
    function chk_id(){
        if(country == "India"){
            var regexp=/^[2-9]{1}[0-9]{3}\s\s\s\s{1}[0-9]{4}\s\s\s\s{1}[0-9]{4}$/;
            
            var x = document.getElementById("id_proof");
            
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
    }
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
</script>