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

?>



 <div class="wrap">

    <form action="" method="POST">

        <div class="row">

            <div class="col-md-7 left-form">
                <h3><?php printf( esc_html__( 'First read by TheInnovs at %s', 'db-for-elementor-form' ), isset( $data->cdate ) ? esc_html( $data->cdate ) : '' ); ?></h3>
                <input type="text" name="formID" style="min-width: 300px;" value="<?php echo esc_attr( $data->formID ); ?>" class="from-control">

                <div class="mt-5">
                    <table class="dbef-data-view-table table">
                        <tr>
                            <th><?php printf( esc_html__( 'Label', 'db-for-elementor-form' ) ); ?></th>
                            <th><?php printf( esc_html__( 'Value', 'db-for-elementor-form' ) ); ?></th>
                        </tr>

                        <?php $arrayData = unserialize( $data->formData ); foreach ( $arrayData as $key => $value ) { ?>
                            <tr>
                                <td><?php printf( esc_html__( $value['label'], 'db-for-elementor-form' ) ); ?></td>
                                <td><?php printf( esc_html__( $value['value'], 'db-for-elementor-form' ) ); ?></td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
            </div>


            <div class="col-md-5 right-form">
                <div class="mt-5">
                    <h5><?php printf( esc_html__( 'Extra Information', 'db-for-elementor-form' ) ); ?></h5>
                    <table class="table">
                        <tr>
                            <th><?php printf( esc_html__( 'Submitted On', 'db-for-elementor-form' ) ); ?></th>
                            <td><?php echo isset( $data->submitedOn ) ? esc_html( $data->submitedOn ) : ''; ?></td>
                        </tr>
                        <tr>
                            <th><?php printf( esc_html__( 'First Read By', 'db-for-elementor-form' ) ); ?></th>
                            <td><?php echo isset( $user->user_login ) ? esc_html( $user->user_login ) : ''; ?></td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="bottom-from">
                <a href="javascript:void(0)" onclick="exportTableToCSV('form-data.csv')" class="btn btn-success">Export CSV</a>
                <a href="<?php echo esc_url(admin_url('admin.php?page=submissions')); ?>" class="btn btn-info">Back</a>
                <input type="submit" name="delete" value="Delete" class="btn btn-danger">
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