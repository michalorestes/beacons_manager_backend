<?php
include('templateFiles/header.php');
$usernameError = '';
$passwordError = '';
//Login script
if (isset($_POST['btnLogin'])) {
  $db = new Database();
  $user = $db->getLogin($_POST['txtLogin']);
  if ($user != null) {
    if ($user['password'] === $_POST['txtPassword']) {
      $_SESSION['login'] = $user;
    } else {
      $passwordError = '<span style="font-size: 9pt; color: red;">Incorrect password</span>';
    }
  } else {
    $usernameError = '<span style="font-size: 9pt; color: red;">Incorrect username</span>';
  }
}
//redirect to managing page if user is logged in
if (isset($_SESSION['login'])) {
  header('Location: beacons.php');
}
?>
    <div class="centerClass loginPanel">
      <form method="post" action="index.php">
        <?php echo $usernameError; ?>
        <input type="text" value="Login..." name="txtLogin" onclick="clearTextField(this);"/>
        <?php echo $passwordError; ?>
        <input type="password" value="Password..." name="txtPassword" onclick="clearTextField(this);" />
        <input class="button" type="submit" value="Login" name="btnLogin" />
      </form>
      <img src="http://www.beacon-counselling.org.uk/wp-content/themes/beaconcounselling/library/images/branding/logo-lighthouse.svg" />
    </div>

<script type="text/javascript">
 function clearTextField(element){
   if (element.value === "Login..." || element.value === "Password...") {
     element.value = "";
   }

}
</script>

<?php
  include('templateFiles/footer.php');
 ?>
