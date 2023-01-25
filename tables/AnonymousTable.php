<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 style="margin: 10px;" class="h3 mb-0 text-gray-800">Anonymous view dashboard</h1>
</div>

<br>
<!-- Button trigger modal -->


<div style="margin: 10px;" class="card shadow mb-4">

<?php
try{
    $clientUsername=$_GET['em'];
    $ticketNum=$_GET['tk'];
    $dbconn=new DBconnect();
    $stmt=$dbconn->getconnection()->prepare("SELECT clientName,id,ticketNum,description,department,status,loggedby FROM tickets
     WHERE clientUsername=? AND ticketNum=?");
    $stmt->execute([$clientUsername,$ticketNum]);
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

                    </tr>
                    <?php                 
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

