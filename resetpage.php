<?php require_once('session_begin/session.php');
?>
<!DOCTYPE html>
<html>
<head>
<title>Ticket System-Password Recovery</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/solid.css">
<link rel="stylesheet" type="text/css" href="loginStyle/style.css">
</head>
<body>
<?php

$currentdate=date('U');
$selector=$_GET['selector'];
$validator=$_GET['validator'];
if(isset($_GET['ns']))
{?>
    <div class="alert alert-danger" role="alert">
    <?= $_GET['ns']; ?>
    </div>

<?php }

if(empty($selector)|| empty($validator))
{?>
    <div class="alert alert-danger" role="alert">
    could not validate your request. Try clicking the link in your email again.
    </div>

<?php }elseif(ctype_xdigit($selector)==true && ctype_xdigit($validator)==true)
{?>
<div class="card" style="margin-bottom:18%;padding: 6px ;margin-left:18%;margin-right:18%;margin-top:5%; z-index: 5px;">
    <form action="Actions/resetUser.php" method="POST">
        <input type="text" name="selector" class="form-control" 
        placeholder="" id="" value="<?=$selector; ?>" hidden required>
        <input type="text" name="validator" class="form-control" 
        placeholder="" id="" value="<?=$validator; ?>" hidden required>
        <div class="mb-3">
        <label for="" class="form-label">Password</label>
        <input type="password" name="pwd" class="form-control" placeholder="Enter a new password." required>
        </div>
        <div class="mb-3">
        <label for="" class="form-label">Password</label>
        <input type="password" name="pwdR" class="form-control" placeholder="Re-type your new password." required>
        </div>
        <button type="submit" name="btnReset" class="btn btn-primary">Reset</button>
    </form>
</div>
<?php
if(isset($_GET['ns']))
{?>
    <div class="alert alert-danger" role="alert">
    <?= $_GET['ns']; ?>
    </div>

<?php }
}

?>
</body>
<script type="text/javascript">
if(window.history.replaceState)
{
window.history.replaceState(null,null,window.location.href);
}
</script>

</html>
