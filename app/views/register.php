<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
</head>
<body>
  <div class="header">
        <h1>Inscription</h1>
  </div>
        
  <form method="post" action="register.php">
        <?php include('errors.php'); ?>
        <div class="input-group">
          <label>Nom d'utilisateur</label>
          <input type="text" name="username" value="<?php echo $username; ?>">
        </div>
        <div class="input-group">
          <label>Mot de passe</label>
          <input type="password" name="password_1">
        </div>
        <div class="input-group">
          <label>Confirmer le mot de passe</label>
          <input type="password" name="password_2">
        </div>
        <div class="input-group">
          <button type="submit" class="btn" name="reg_user">S'inscrire</button>
        </div>
        <p>
        Vous avez déjà un compte ?<a href="login.php">Connectez-vous !</a>
        </p>
  </form>
</body>
</html>
