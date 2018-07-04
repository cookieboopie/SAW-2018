<!DOCTYPE html>
<html lang="en">

<header>
<title>Sito | Registrati</title>

<?php require 'indexHeader.php'; ?>

<body>

<section class="wrapper">
    <div class="inner">
        <form id="regForm">
            <label for="regUsr">Username: </label>
            <input type="text" id="regUsr" name="regUsr">
            <label for="regMail">E-mail: </label>
            <input type="text" id="regMail" name="regMail">
            <label for="regPwd">Password: </label>
            <input type="password" id="regPwd" name="regPwd">
            <label for="pwdC">Conferma Password: </label>
            <input type="password" id="pwdC" name="pwdC">
            <input type="submit" id="regSubmit" value="Crea Account">
            <span id="inputError"></span>
        </form>
    </div>
</section>

<?php require 'indexFooter.php'; ?>

</body>

</html>
