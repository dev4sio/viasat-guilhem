<body class="loginBody">

    <?php echo validation_errors(); ?>

    <?php echo form_open('welcome/signin'); ?>
    <div class="signinForm">
        <div class="loginFields">
            <div class="labelInput">
                <label for="username">Nom d'utilisateur</label>
                <input type="text" name="username" /><br>
            </div>
            <div class="labelInput">
                <label for="password">Mot de passe</label>
                <input type="password" name="password"><br>
            </div>
            <div class="labelInput">
                <label for="passconf"></label>
                <input type="password" name="passconf"><br>
            </div>
            <div class="labelInput">
                <label for="last_name">Nom</label>
                <input type="text" name="last_name"><br>
            </div>
            <div class="labelInput">
                <label for="first_name">Prénom</label>
                <input type="text" name="first_name"><br>
            </div>
            <div class="labelInput">
                <label for="email">Email</label>
                <input type="text" name="email"><br>
            </div>
        </div>
        <div class="loginButtons">
            <input type="submit" name="submit" value="Valider" />
        </div>
    </div>


    </form>