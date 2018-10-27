<div class="content-wrapper"> 
 <h3 class="page-heading mb-4">Change Password</h3>
 <?php 
  if ($this->session->flashdata('msg') != '') {
    echo $this->session->flashdata('msg');
  }
?>
<div class="row mb-2">
   <div class="col-lg-12">
     <div class="card">
       <div class="card-body">
        <div class="col-md-4">
         <form method="post" action="<?php echo base_url('dash/change_password');?>">
          <div class="form-group">
            <label for="exampleInputEmail1">Old Password</label>
            <input type="password" class="form-control p-input" name="opass" placeholder="Enter Old Password">
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">New Password</label>
            <input type="password" class="form-control p-input" name="newpass" placeholder="Enter New Password">
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Verif New Password</label>
            <input type="password" class="form-control p-input" name="vpass" placeholder="Enter Verif New Password">
          </div>
          <div class="form-group">
            <button type="submit" name="save" class="btn btn-primary">Change</button> <button type="reset"  class="btn btn-default">Reset</button>
          </div>
         </form>
         </div>
       </div>
     </div>
   </div>
 </div>
</div>