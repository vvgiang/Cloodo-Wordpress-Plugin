<?php 
require_once ('showresults.php');
?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css">
<h1>GET TOKEN</h1>
<form method="post" action="">
    <table>
        <tr>
            <td>Email</td>
            <td>
            <!-- [shortcodeTs tttv='100'] -->
                <input type="text" name="email" value="<?= $email ?? ""; ?>"/>
            </td>
        </tr>
        <tr>
            <td>Password</td>
            <td>
                <input type="pasword" name="password" value="<?= $password ?? ""; ?>"/>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>
                <input type="submit" name="save" value="Lay token"/>
            </td>
        </tr>
     
    </table>
</form>



