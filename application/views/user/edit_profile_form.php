
<body class="loginBody">
<?php echo validation_errors(); ?>


<?php echo form_open('welcome/edit_profile'); ?>
<div class="loginForm">
    <div class="loginFields">


        <div class="labelInput">
            <label for="last_name" class="form-label">Nom</label>
            <input type="text" class="form-control" name="last_name" value="<?php echo $user['last_name'] ?>"><br>
        </div>
        <div class="labelInput">
            <label for="first_name" class="form-label">Prénom</label>
            <input type="text" class="form-control" name="first_name" value="<?php echo $user['first_name'] ?>"><br>
        </div>
        <div class="loginButtons">
            <input type="submit" name="submit" value="Valider">
            <?php echo anchor('map/index', 'Retour sur la map') ?>
        </div>
    </div>
</div>


</form>

<?php
if (isset($msg)) {
    echo $msg;
}
?><br>

