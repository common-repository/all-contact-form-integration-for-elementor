<?php
 
 global $current_user;
 wp_get_current_user();
  $userId =  $current_user->ID;
  $formDatas = DB_Elementor_Form_Admin::getAllDBFromData();

  if (isset($_GET['id'])) {
      DB_Elementor_Form_Admin::deleteData($_GET['id']);
       echo '<script> window.location="'. admin_url('admin.php?page=db_element_form') .'" </script>';
  }
  
  $pages = DB_Element_Form_Helper::void_page_url_set();
  $singlePage = $pages['show-element-form'];
  $admin_url = 'admin.php?page=db_element_form';
  //$pdf_url = 'admin.php?page=db_element_form&&download_csv=1';
  $singlePage_url = 'admin.php?page='.$singlePage;
  
?>
<div class="wrap">
  <h3>Form Submissions List</h3> <h4> <a href="https://theinnovs.com/downloads/elementorsms/?discount=elesms60" style="color: red" target="_blank">|>> Grab Elementor SMS addon</a> at 60% discount for first 1000 customers! Don't miss any lead from now on! Get notified via SMS on every form submission. Coupon: 'elesms60'</h4>
    
    <a href="<?php echo admin_url(); ?>?page=download_report" class="btn btn-success dbef-csv-btn">Export as CSV</a>
    
    <table id="dbForm" class="display" style="width:100%">
        <thead>
             <tr>
                <th>#</th>
                <th>View</th> 
                <th>Form ID</th>
                <th>Email</th>
                <th>Read/Unread</th>
                <th>Read By</th>
                <th>Submission On</th>
                <th>Submitted Date</th>
                <th>Action</th>
              </tr>
        </thead>
        <tbody>
        <?php $i = 1; 
        if(!empty($formDatas)){ 
          foreach ($formDatas as $key => $value) {
            
            $user = get_user_by( 'id', $value->submitedBy );
          
          ?>           
              <tr>
                <td> <?php echo $i++; ?> </td>
                <td> <a href="<?php echo esc_url($singlePage_url.'&id='. $value->id); ?>"><?php echo 'View Submission'; ?></a></td> 
                <td><?php echo $value->formID; ?></td>
                <td><?php echo $value->email; ?></td>
                <td><?php echo $value->status; ?></td> 
                <td><?php echo isset($user->user_login) ? $user->user_login : ''; ?></td>
                <td><?php echo $value->submitedOn; ?></td>
                <td><?php echo $value->cdate; ?></td> 
                <td>
                  <a class="estimateDelete btn btn-danger" data-nonce="<?php echo wp_create_nonce( 'estimateDelete' ); ?>" data-id="<?php echo $value->id; ?>" href="<?php echo esc_url($admin_url.'&id='. $value->id); ?>">Delete</a>
                </td>
              </tr>
              <?php   } 
             } ?>
        </tbody>
        <tfoot>
              <tr>
                <th>#</th>
                <th><?php printf( __('View','db-for-elementor-form')); ?></th> 
                <th><?php printf( __('Form ID','db-for-elementor-form')); ?></th>
                <th><?php printf( __('Email','db-for-elementor-form')); ?></th>
                <th><?php printf( __('Read/Unread','db-for-elementor-form')); ?></th>
                <th><?php printf( __('Read By','db-for-elementor-form')); ?></th>
                <th><?php printf( __('Submission On','db-for-elementor-form')); ?></th>
                <th><?php printf( __('Submitted Date','db-for-elementor-form')); ?></th>
                <th><?php printf( __('Action','db-for-elementor-form')); ?></th>
              </tr>
             
        </tfoot>
    </table> 

</div>