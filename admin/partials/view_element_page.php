<?php 

$data = DB_Elementor_Form_Admin::getSingleData($_GET['id']) ;
$dataRead = DB_Elementor_Form_Admin::redData($_GET['id']) ;
$user = get_user_by( 'id', $data->submitedBy );

if(isset($_POST['submitForm'])){
    $formID = $_POST['formID'];
    $dataRead = DB_Elementor_Form_Admin::UpdatedViewData($_GET['id'],$formID) ;
}

$ID = $_GET['id'];
if(isset($_POST['delete'])) {
    DB_Elementor_Form_Admin::deleteViewSubData($ID);
}

if(isset($_POST['back'])){
    echo '<script> window.location="'. admin_url('admin.php?page=db_element_form') .'" </script>';
}

?>



 <div class="wrap">

    <form action="" method="POST">

        <div class="row"> 

            <div class="col-md-7 left-form">
                <h3><?php printf( __('First read by TheInnovs at  %s','db-for-elementor-form'), isset($data->cdate) ? $data->cdate : '' ) ?></h3>
                <input type="text" name="formID" style=" min-width: 300px;" value="<?php echo $data->formID; ?>" class="from-control">

                <div class="mt-5">
                    <table class="dbef-data-view-table table">
                        <tr>
                            <th> <?php printf( __('Label','db-for-elementor-form')); ?></th>
                            <th> <?php printf( __('Value','db-for-elementor-form')); ?></th>
                        </tr>

                        <?php $arrayData = unserialize($data->formData);  foreach ($arrayData as $key => $value) { ?> 
                            <tr>
                                <td> <?php printf( __($value['label'],'db-for-elementor-form')) ?> </td>
                                <td><?php echo $value['value']; ?></td>
                            </tr>
                        <?php } ?> 
                    </table>
                </div>
            </div>
            
        
            <div class="col-md-5 right-form">
                <div class="mt-5">
                    <h5><?php printf( __('Extra Information','db-for-elementor-form')); ?></h5>
                    <table class="table">
                        <tr>
                            <th><?php printf( __('Submitted On','db-for-elementor-form')); ?></th>
                            <td><?php echo  isset($data->submitedOn) ? $data->submitedOn : ''; ?></td>
                        </tr>
                        <tr>
                            <th><?php printf( __('First Read By','db-for-elementor-form')); ?></th>
                            <td><?php echo isset($user->user_login) ? $user->user_login : ''; ?></td>
                        </tr>  
                    </table>
                </div>
            </div>

            <div class="bottom-from">
                <a href="javascript:void(0)" onclick="exportTableToCSV('form-data.csv')" class="btn btn-success">Export CSV</a>
                <input type="submit" name="back" value="Back" class="btn btn-info">
                <input type="submit" name="delete" value="Delete" class="btn btn-danger">
                <!-- <input type="button" value="Send Email" class="btn btn-primary"> -->
            </div>

        </div>

    </form>

 </div>


<script>
function downloadCSV(csv, filename) {
   var csvFile;
   var downloadLink;

   // CSV file
   csvFile = new Blob([csv], {type: "text/csv"});

   // Download link
   downloadLink = document.createElement("a");

   // File name
   downloadLink.download = filename;

   // Create a link to the file
   downloadLink.href = window.URL.createObjectURL(csvFile);

   // Hide download link
   downloadLink.style.display = "none";

   // Add the link to DOM
   document.body.appendChild(downloadLink);

   // Click download link
   downloadLink.click();
}

function exportTableToCSV(filename) {
   var csv = [];
   var rows = document.querySelectorAll("table.dbef-data-view-table tr");
   
   for (var i = 0; i < rows.length; i++) {
	   var row = [], cols = rows[i].querySelectorAll("td, th");
	   
	   for (var j = 0; j < cols.length; j++) 
		   row.push(cols[j].innerText);
	   
	   csv.push(row.join(",")); 
   }

   // Download CSV file
   downloadCSV(csv.join("\n"), filename);
}
</script>