<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    <a href="printing.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
        class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
</div>

<br>
<!-- Button trigger modal -->


<div class="card shadow mb-4">

<button type="button" id="btnLogT" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
   Log a support ticket
</button>

<?php
try{
    
    $dbconn=new DBconnect();
    $stmt=$dbconn->getconnection()->prepare("SELECT clientName,id,ticketNum,description,department,status,loggedby FROM tickets");
    $stmt->execute();
    $data=$stmt->fetchAll(); ?>

<?php }catch(PDOException $er){

} ?>

    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Tickets Table</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Full Name</th>
                        <th>Ticket ID</th>
                        <th>Ticket Number</th>
                        <th>Description</th>
                        <th>Department</th>
                        <th>status</th>
                        <th>Logged By</th>
                        <th>....</th>
                        <th>....</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>....</th>
                        <th>....</th>
                        <th>....</th>
                        <th>....</th>
                        <th>....</th>
                        <th>....</th>
                        <th>....</th>
                        <th>....</th>
                        <th>....</th>
                    </tr>
                </tfoot>
                <tbody>
                <?php
                    foreach($data as $user)
                    {?>
                    
                    <tr>
                        <td><?= $user['clientName']; ?></td>
                        <td><?= $user['id']; ?></td>
                        <td><?= $user['ticketNum']; ?></td>
                        <td><?= $user['description']; ?></td>
                        <td><?= $user['department']; ?></td>
                        <td><?= $user['status']; ?></td>
                        <td><?= $user['loggedby']; ?></td>
                        <td>

                        <form action="Actions/updateTicket.php" method="post">
                            <select name="chStatus" style="margin: 3px;" class="form-select" aria-label="Default select example">
                                <option selected>Redifine Status</option>
                                <option value="newly logged">newly logged</option>
                                <option value="in progress">in progress</option>
                                <option value="resolved">resolved</option>
                            </select>
                            
                                <input type="text" name="edtId" id="" hidden value="<?= $user['id']; ?>">
                                <button type="submit" name="btnUpdate" id="" style="margin-top: 3px;"
                                 class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#UpdateStoryModal">Update</button>
                                
                        </form>
                        </td>

                        <td>
                            <form action="Actions/deleteTicket.php" method="post">
                                <input type="text" name="edtId" id="" hidden value="<?= $user['id']; ?>"> 
                                <button name="deletebtn" type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php                 
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

