<?php
 
  global $current_user;
  wp_get_current_user();
  $userId =  $current_user->ID;
  $formDatas = DB_Elementor_Form_Admin::getAllDBFromData();

  $pages = DB_Element_Form_Helper::void_page_url_set();
  $view_submission = $pages['view_submission'];
  $submissions = $pages['submissions'];

    if (isset($_GET['id'])) {
        DB_Elementor_Form_Admin::deleteData($_GET['id']);
        echo '<script> window.location="'. $submissions .'" </script>';
    }
  
 
  
?>
<div class="wrap">
  <h3>Form Submissions List</h3> <h4> <a href="https://theinnovs.com/downloads/elementorsms/?discount=elesms60" style="color: red" target="_blank">|>> Grab Elementor SMS addon</a> at 60% discount for first 1000 customers! Don't miss any lead from now on! Get notified via SMS on every form submission. Coupon: 'elesms60'</h4>
    
    <a href="<?php echo esc_url(admin_url() .'?page=export_submission_data_csv'); ?>" class="btn btn-success dbef-csv-btn">Export as CSV</a>
    
    <table id="dbForm" data-order='[[ 0, "desc" ]]' class="display" style="width:100%">
        <thead>
             <tr>
                <th>#</th>
                <th><?php printf( __('View','db-for-elementor-form')) ?> </th> 
                <th><?php printf( __('Form ID','db-for-elementor-form')) ?></th>
                <th><?php printf( __('Email','db-for-elementor-form')) ?></th>
                <th><?php printf( __('Read/Unread','db-for-elementor-form')) ?></th>
                <th><?php printf( __('Read By','db-for-elementor-form')) ?></th>
                <th><?php printf( __('Submission On','db-for-elementor-form')) ?></th>
                <th><?php printf( __('Submitted Date','db-for-elementor-form')) ?></th>
                <th><?php printf( __('Action','db-for-elementor-form')) ?></th>
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
                <td><a href="<?php echo esc_url( $view_submission . '&id=' . esc_attr( $value->id ) ); ?>"><?php printf( esc_html__( 'View Submission', 'db-for-elementor-form' ) ); ?></a></td>
                <td><?php echo esc_html( $value->formID ); ?></td>
                <td><?php echo esc_html( $value->email ); ?></td>
                <td><?php echo esc_html( $value->status ); ?></td>
                <td><?php echo isset( $user->user_login ) ? esc_html( $user->user_login ) : ''; ?></td>
                <td><?php echo esc_html( $value->submitedOn ); ?></td>
                <td><?php echo esc_html( $value->cdate ); ?></td>
                <td>
                    <a class="submissionDelete btn btn-danger" data-nonce="<?php echo esc_attr( wp_create_nonce( 'submission_delete' ) ); ?>" data-id="<?php echo esc_attr( $value->id ); ?>" href="<?php echo esc_url( $submissions . '&id=' . esc_attr( $value->id ) ); ?>">Delete</a>
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