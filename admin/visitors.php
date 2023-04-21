<?php
require "admin_navbar.php";
require "../connection.php";



if(isset($_POST['remove_id'])){
    $id = $_POST['remove_id'];
    $remove_query = "delete from visitors where visitor_id = '$id'";
    mysqli_query($con, $remove_query);
    if($con->affected_rows > 0){
        echo "<script>alert('Visitor Removed Successfully..!')</script>";
    }else{
        echo "<script>alert('Visitor Not Exist..!')</script>";
    }
}


// Get all visitors profile whose email and phone is verified (Non Indian dont require phone verification)
$get_visitor_query = "select *from visitors where (visitor_country = 'India' and evs = 'Active' and mvs = 'Active') or (evs = 'Active') order by reg_time";
$visitors = mysqli_query($con, $get_visitor_query);


// Get Genders and ages

$filter_visitors_query = "select visitor_gender, visitor_dob from visitors";
$filtered_visitors = mysqli_query($con, $filter_visitors_query);

$male = $female = 0;
$age[] = 0;
$i = 0;
while($visitor = $filtered_visitors->fetch_assoc()){

    if($visitor['visitor_gender'] == "male")
        $male = $male + 1;
    if($visitor['visitor_gender'] == "female")
        $female = $female + 1;
    
    $age[$i] = date_diff(date_create($visitor['visitor_dob']), date_create(date('Y-m-d', strtotime($dt))));
    $i++;
}

$gender = array( 
    array("label"=>"male", "y"=>$male/($male + $female) * 100),
    array("label"=>"Female", "y"=>$female/($male + $female) * 100),
);

$under_18 = $under_50 = $under_100 = 0;
for($i=0; $i<sizeof($age); $i++){

    if($age[$i]->format("%y")+1 >= 6 && $age[$i]->format("%y")+1 <= 18)
        $under_18++;
    if($age[$i]->format("%y")+1 > 18 && $age[$i]->format("%y")+1 <= 50)
        $under_50++;
    if($age[$i]->format("%y")+1 > 50 && $age[$i]->format("%y")+1 <= 100)
        $under_100++;
}

$age_filter = array(    
    array("label"=>"06 - 18", "y"=>$under_18/sizeof($age) * 100),
    array("label"=>"19 - 50", "y"=>$under_50/sizeof($age) * 100),
    array("label"=>"51 - 100", "y"=>$under_100/sizeof($age) * 100),
);

?>

    <script>
        window.onload = function() {

            var chart = new CanvasJS.Chart("genderPieChart", {
                theme: "light2",
                animationEnabled: true,
                title: {
                    text: "Gender Of Visitors"
                },
                data: [{
                    type: "pie",
                    indexLabel: "{y}",
                    yValueFormatString: "#,##0.00\"%\"",
                    indexLabelPlacement: "inside",
                    indexLabelFontColor: "#36454F",
                    indexLabelFontSize: 18,
                    indexLabelFontWeight: "bolder",
                    showInLegend: true,
                    legendText: "{label}",
                    dataPoints: <?php echo json_encode($gender, JSON_NUMERIC_CHECK); ?>
                }]
            });

            chart.render();
            var chart1 = new CanvasJS.Chart("agePieChart", {
                theme: "light2",
                animationEnabled: true,
                title: {
                    text: "Age Of Visitors"
                },
                data: [{
                    type: "pie",
                    indexLabel: "{y}",
                    yValueFormatString: "#,##0.00\"%\"",
                    indexLabelPlacement: "inside",
                    indexLabelFontColor: "#36454F",
                    indexLabelFontSize: 18,
                    indexLabelFontWeight: "bolder",
                    showInLegend: true,
                    legendText: "{label}",
                    dataPoints: <?php echo json_encode($age_filter, JSON_NUMERIC_CHECK); ?>
                }]
            });
            chart1.render();        
        }
    </script>

    <div class="container mt-5 row g-3">
        <div id="genderPieChart" style="height: 370px; width: 100%;" class="col"></div>
        <div id="agePieChart" style="height: 370px; width: 100%;" class="col"></div>
    </div>

<p class="text-info m-4 fs-5"><b>India : Verified Email and Phone <br>Other Countries : Verified Email</b></p>
<div class="table-responsive">
    <table class="table table-hover">
    <tr class="bg-primary">
            <th>Visitor ID</th>
            <th>Action</th>
            <th>Country</th>
            <th>Name</th>
            <th>ID Proof</th>
            <th>Image</th>
            <th>Gender</th>
            <th>DOB</th>
            <th>Address</th>
            <th>Email</th>
            <th>Password</th>
            <th>Phone</th>
            <th>Time</th>
        </tr>
        <?php
            while($visitor = $visitors->fetch_assoc()){
                ?>
                <tr>
                    <td><?php echo $visitor['visitor_id'] ?></td>
                    <td>
                        <button class="btn btn-outline-danger" data-bs-visitor_id="<?php echo $visitor['visitor_id']; ?>" data-bs-toggle="modal" data-bs-target="#removeVisitor_Modal"><i class="fa fa-trash"></i></button>
                    </td>
                    <td><?php echo $visitor['visitor_country']; ?></td>
                    <td><?php echo $visitor['visitor_fname']." ".$visitor['visitor_mname']. " ". $visitor['visitor_lname']; ?></td>
                    <td><?php echo $visitor['visitor_id_proof']; ?></td>
                    <td  data-bs-img="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($visitor['visitor_id_proof_img']); ?>" data-bs-toggle="modal" data-bs-target="#id_proof_img_Modal"><p class="text-info" style="cursor:pointer;">Show <i class="fa fa-eye"></i></p></td>                    
                    <td><?php echo $visitor['visitor_gender']; ?></td>
                    <td><?php echo $visitor['visitor_dob']; ?></td>
                    <td><?php echo $visitor['visitor_address']; ?></td>
                    <td><?php echo $visitor['visitor_email']; ?></td>
                    
                    <td><?php echo $visitor['visitor_passwd']; ?></td>
                    <td><?php echo $visitor['visitor_mob_no']; ?></td>                    
                    <td><?php echo date("d-M-y H:i", strtotime($visitor['reg_time'])); ?></td>
                </tr>
                <?php
            }
        ?>        
    </table>
    <div class="modal fade" id="removeVisitor_Modal" tabindex="-1" aria-labelledby="removeVisitor_ModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-danger" id="removeVisitor_ModalLabel">Remove Visitor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="text-info" id="warning"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                    <button type="submit" name="remove_id" id="removeBtn" class="btn btn-outline-danger">Remove</button>
                </form>
            </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="id_proof_img_Modal" tabindex="-1" aria-labelledby="id_proof_img_ModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="id_proof_img_ModalLabel"></h5>
                    <button typed="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <img class="rounded mx-auto w-100" src="" alt="ID Proof Image">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" data-bs-dismiss="modal" class="btn btn-primary">OK</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var removeVisitor_Modal = document.getElementById('removeVisitor_Modal')
    removeVisitor_Modal.addEventListener('show.bs.modal', function (event) {
    // Button that triggered the modal
    var button = event.relatedTarget
    // Extract info from data-bs-* attributes
    var id = button.getAttribute('data-bs-visitor_id')
    // If necessary, you could initiate an AJAX request here
    // and then do the updating in a callback.
    //
    // Update the modal's content.
    var modalTitle = removeVisitor_Modal.querySelector('.modal-title')
    var warning = document.getElementById("warning");
    warning.innerHTML = "Do you really want to remove "+id+" ?"
    modalTitle.textContent = "Remove "+id
    document.getElementById("removeBtn").value = id
    })


    //  Enlarge Image

    var id_proof_img_Modal = document.getElementById('id_proof_img_Modal')
        id_proof_img_Modal.addEventListener('show.bs.modal', function (event) {
        // Button that triggered the modal
        var button = event.relatedTarget
        // Extract info from data-bs-* attributes
        var id_proof_img = button.getAttribute('data-bs-img')
        // If necessary, you could initiate an AJAX request here
        // and then do the updating in a callback.
        //
        // Update the modal's content.
        var modalTitle = id_proof_img_Modal.querySelector('.modal-title')
        var modalBodyImg = id_proof_img_Modal.querySelector('.modal-body img')

        modalTitle.textContent = "ID Proof Image"
        modalBodyImg.src = id_proof_img
        })
</script>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>