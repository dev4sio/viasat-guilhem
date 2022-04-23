<body class="loginBody">

    <?php echo validation_errors(); ?>

    

        <?php echo form_open('welcome/login'); ?>

        <div class="loginForm">
        <div class="loginFields">
            <div class="labelInput">
                <label for="username">Nom d'utilisateur</label>
                <input type="text" name="username" /> 
            </div>
            <div class="labelInput">
                <label for="password">Mot de passe</label>
                <input type="password" name="password">
            </div>
        </div>
        <div class="loginButtons">
            <input type="submit" name="submit" value="Se Connecter" />
            <a href="<?php echo site_url('signin_page'); ?>">S'inscrire</a>
        </div>

        </div>


        <?php if (isset($error_msg)) {
            echo '<br>' . $error_msg;
        } ?>

        </form>
 