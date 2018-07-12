<!DOCTYPE html>
<html lang="en">

<head>
<title>NotTooBed | Registration</title>

<?php require 'indexHeader.php'; ?>
<body>

<section class="navbar">
    <button class="regBtn">Register</button>
    <button class="logBtn">Login</button>
</section>

<section class="wrapper">
    <div class="inner">
        <div class="formHeader">
            <ls class="reg" style="cursor: pointer">Register</ls>
            <ls class="log" style="cursor: pointer">Login</ls>
        </div>
        <div class="formBody">
            <div class="closeContainer">
                <div class="close" style="cursor: pointer">&times</div>
            </div>
            <form id="regForm" autocomplete="off">
                <label for="regUsr">Username </label><span id="regUsr_err"></span>
                <input type="text" id="regUsr" name="regUsr">
                <label for="regEml">E-mail </label><span id="regEml_err"></span>
                <input type="text" id="regEml" name="regEml">
                <label for="regPwd">Password </label><span id="regPwd_err"></span>
                <input type="password" id="regPwd" name="regPwd">
                <label for="pwdC">Conferma Password </label><span id="pwdC_err"></span>
                <input type="password" id="pwdC" name="pwdC">
                <input type="button" id="regSubmit" value="Crea Account">
            </form>
            <form id="logForm" autocomplete="off" > 
                <label for="logUsr">Username </label><span id="logUsr_err"></span>
                <input type="text" id="logUsr" name="logUsr">
                <label for="logPwd">Password </label><span id="logPwd_err"></span>
                <input type="password" id="logPwd" name="logPwd">
                <input type="button" id="logSubmit" value="Login">
                <span id="logErr"></span>
            </form>
        </div>
    </div>
</section>

<?php require 'indexFooter.php'; ?>

</body>

</html>
