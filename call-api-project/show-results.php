<?php
$message ="";
$class="";
if(isset($_SESSION['success'])){
    $message = $_SESSION['success'];
    unset($_SESSION['success']);
    $class ="success";
}
elseif(isset($_SESSION['error'])){
    $message = $_SESSION['error'];
    unset($_SESSION['error']);
    $class ="danger"; 
}
if($message) {
?>
    <div class="mt-3 alert alert-<?php echo esc_attr($class)?>"> <?php echo esc_attr($message) ?></div>
<?php } ?>
