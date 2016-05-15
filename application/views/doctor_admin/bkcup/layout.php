 <?php  $this->load->view('doctor_admin/components/head.php'); ?>

    <div id="wrapper">

        <!-- Navigation -->
        <?php  $this->load->view('doctor_admin/components/navigation.php'); ?>
        

         <?php  $this->load->view('doctor_admin/sub_view/'.$sub_view,$this->data); ?>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

<?php  $this->load->view('doctor_admin/components/footer.php'); ?>
