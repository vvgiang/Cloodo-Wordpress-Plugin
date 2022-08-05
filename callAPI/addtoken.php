<?php 
require_once ('showresults.php');
?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css">
<h1>ADD TOKEN</h1>
<form method="post" action="">
    <table>
        <tr>
            <td>Id Token</td>
            <td>
                <input type="text" name="token" value="<?= $token ?? ""; ?>"/>
            </td>
        </tr>
        <tr>
            <td>
                <input type="submit" name="savetoken" value="add token"/>
            </td>
        </tr>
     
    </table>
</form>