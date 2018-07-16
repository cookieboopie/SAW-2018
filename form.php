<!DOCTYPE html>
<html lang="en">
    <head>
    <?php require 'indexHeader2.php'; ?>
    

        <body>

            <section class="navbar">
                <button class="regBtn">Register</button>
                <button class="logBtn">Login</button>
            </section>  
            
            <section class="wrapper">
                <div class="inner">
                    


                    <div class="formHeader">
                        <div class="reg" style="cursor: pointer">Register</div>
                        <div class="log" style="cursor: pointer">Login</div>
                    </div>

                    <div class="formBody">
                        <form id="regForm" autocomplete="off">
                            <span id="regUsr_err"></span>
                            <label for="regUsr">Username </label><input type="text" id="regUsr" name="regUsr">
                            
                            <span id="regEml_err"></span>
                            <label for="regEml">E-mail </label><input type="text" id="regEml" name="regEml">
                            
                            <span id="regPwd_err"></span>
                            <label for="regPwd">Password </label><input type="password" id="regPwd" name="regPwd">
                            
                            <span id="pwdC_err"></span>
                            <label for="pwdC">Conferma Password </label><input type="password" id="pwdC" name="pwdC">
                            
                            <input type="button" id="regSubmit" class="btn btn-primary" value="Crea Account">
                        </form>

                        <form id="logForm" autocomplete="off" > 
                            <span id="logErr"></span> 

                            <label for="logUsr">Username </label><input type="text" id="logUsr" name="logUsr">
                            
                            <span></span>
                            
                            <label for="logPwd">Password </label><input type="password" id="logPwd" name="logPwd">
                            
                            <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                            <label class="form-check-label" for="defaultCheck1">
                                Default checkbox
                            </label>
                            

                            <input type="button" id="logSubmit" class="btn btn-primary" value="Login">
                        </form>
                    </div>
                </div>
            </section>
            
        </body>

</html>