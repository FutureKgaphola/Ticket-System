

<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Personal Details with Issue encoutered</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="Actions/LogTicket.php" method="post">
            <input required name="cuemail" style="margin: 3px;" class="form-control" type="email" placeholder="email" aria-label="default input example">
            <input required name="cfname" style="margin: 3px;" class="form-control" type="text" placeholder="first name" aria-label="default input example">
            <input required name="clname" style="margin: 3px;" class="form-control" type="text" placeholder="last name" aria-label="default input example">
            <select name="department" style="margin: 3px;" class="form-select" aria-label="Default select example">
                <option selected>Select Department/Categories</option>
                <option value="Sales">Sales</option>
                <option value="Accounts">Accounts</option>
                <option value="IT">IT</option>
            </select>
            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">Desription</label>
                <textarea name="cdesc" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
            </div>
            <p id="cordinates">Cordinated to be defined</p>
            <input type="text" id="clat" name="cordinatesLat" value="" hidden>
            <input type="text" id="clon" name="cordinatesLon" value="" hidden>

            <div class="modal-footer">
            <img id="loadimg" src="img/gfload.gif" style="width: 35px; height: 35px; display: block; margin-left: auto; margin-right: auto;"/>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" name="btnCreateTicket" id="logbtn" class="btn btn-primary">Log</button>
          </div>
        </form>
      </div>
      
    </div>
  </div>
</div>



<!--add admin account modal-->

<div class="modal fade" id="static_Backdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Add account for administrator</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form class="user" action="Actions/creatAdmin.php" method="post">
            <div class="form-group row">
                <div class="col-sm-6 mb-3 mb-sm-0">
                    <input required name="fname" type="text" class="form-control form-control-user" id="exampleFirstName"
                        placeholder="First Name">
                </div>
                <div class="col-sm-6">
                    <input required name="lname" type="text" class="form-control form-control-user" id="exampleLastName"
                        placeholder="Last Name">
                </div>
            </div>
            <div class="form-group">
                <input required name="uemail" type="email" class="form-control form-control-user" id="exampleInputEmail"
                    placeholder="Email Address">
            </div>
            
            <button type="submit" name="btnCreate" class="btn btn-primary btn-user btn-block">
                Register Account
            </button>
            
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        
      </div>
    </div>
  </div>
</div>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <form action="Actions/logout.php" method="post">
                        <button name="btnlogout" class="btn btn-primary" href="index.php">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!--add update admin account modal-->
    <?php
try{
    $authUid=$_SESSION['auth_user']['uid'];
    $authemail=$_SESSION['auth_user']['email'];
    $authrole=$_SESSION['auth_user']['role'];
    $dbconn=new DBconnect();
    $stmt=$dbconn->getconnection()->prepare("SELECT Names FROM admins
     WHERE id=? AND username =?");
    $stmt->execute([$authUid,$authemail]);
    $data=$stmt->fetchAll(); ?>

<?php }catch(PDOException $er){
echo $er->getMessage();
} ?>
<div class="modal fade" id="static_updateAdmin" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Update administrator</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form class="user" action="Actions/updatedAdmin.php" method="post">
        <?php
          foreach($data as $user)
          {
            $tot=$user['Names'];
            $ar=array();
            $ar=explode(" ",$tot,2);
            ?>
          
            <div class="form-group row">
                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <input required name="Admin_Name" type="text" class="form-control form-control-user" id="exampleFirstName"
                            placeholder="First Name" value='<?= $ar[0]; ?>'>
                    </div>
                    <div class="col-sm-6">
                        <input required name="Admin_lastname" type="text" class="form-control form-control-user" id="exampleLastName"
                            placeholder="Last Name" value='<?=$ar[1]; ?>'>
                    </div>
                </div>
            
          <?php                 
              }
              ?>

            <button name="btnAdminUpdate" type="submit" class="btn btn-primary btn-user btn-block">
                Update Account
            </button>
            
        </form>
      </div>
      <div class="modal-footer">
        
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        
      </div>
    </div>
  </div>
</div>

