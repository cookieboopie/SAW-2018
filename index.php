<!DOCTYPE html>
<html lang="en">

<header>
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
            <form id="regForm">
                <label for="regUsr">Username </label>
                <input type="text" id="regUsr" name="regUsr">
                <label for="regMail">E-mail </label>
                <input type="text" id="regMail" name="regMail">
                <label for="regPwd">Password </label>
                <input type="password" id="regPwd" name="regPwd">
                <label for="pwdC">Conferma Password </label>
                <input type="password" id="pwdC" name="pwdC">
                <input type="submit" id="regSubmit" value="Crea Account">
                <span id="inputError"></span>
            </form>
            <form id="logForm">
                <label for="logUsr">Username </label>
                <input type="text" id="logUsr" name="logUsr">
                <label for="logPw">Password </label>
                <input type="text" id="logPw" name="logPw">
                <input type="submit" id="logSubmit" value="Login">
            </form>
        </div>
    </div>
</section>

<?php require 'indexFooter.php'; ?>

</body>

</html>
