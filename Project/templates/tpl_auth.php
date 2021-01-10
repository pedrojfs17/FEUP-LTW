<?php function draw_login()
{
  /**
   * Draws the login section.
   */ ?>
  <section id="login">

    <header>
      <h2>Welcome Back</h2>
    </header>

    <form method="post" action="../actions/action_login.php">
      <input type="text" name="username" placeholder="Username" required spellcheck="false" autocomplete="off" autocorrect="off" autocapitalize="off">
      <input type="password" name="password" placeholder="Password" required spellcheck="false" autocomplete="off" autocorrect="off" autocapitalize="off">
      <input type="submit" value="Login">
    </form>

    <footer>
      <p>Don't have an account? <a href="signup.php">Signup!</a></p>
    </footer>

  </section>
<?php } ?>

<?php function draw_signup($shelters)
{
  /**
   * Draws the signup section.
   */ ?>
  <section id="signup">

    <header>
      <h2>New Account</h2>
    </header>

    <form method="post" action="../actions/action_signup.php" class="sensitive">
      <div class="button-box">
        <div id="btn"></div>
        <button type="button" class="toggle-btn">User</button>
        <button type="button" class="toggle-btn">Shelter</button>
      </div>

      <input type="hidden" id="accountType" name="accountType" value="0">
      <input type="text" name="username" placeholder="Username" pattern="^[a-zA-Z0-9]+$" id="username" title="Must only contain numbers and letters" required spellcheck="false" autocomplete="off" autocorrect="off" autocapitalize="off">
      <input type="password" name="password" placeholder="Password" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{8,64}$" id="password" title="Must contain at least 1 number, 1 uppercase and lowercase letters, 1 special character and between 8 or 64 characters" required ~ spellcheck="false" autocomplete="off" autocorrect="off" autocapitalize="off">

      <div id="user-colaborator">
        <p>Are you a shelter collaborator?</p>
        <div class="toggle-colaborator">
          <input type="checkbox" name="">
        </div>
        <div id="shelterSearch">
          <p>Shelter</p>
          <select name="shelter" id="shelter">
            <?php foreach ($shelters as $shelter) { ?>
              <option value="<?= $shelter['username'] ?>"><?= $shelter['username'] ?></option>
            <?php } ?>
          </select>
        </div>
      </div>

      <input type="submit" value="Signup">
    </form>
    <footer>
      <p>Already have an account? <a href="login.php">Login!</a></p>
    </footer>

  </section>
<?php } ?>

<?php function draw_edit_account($user)
{
  /**
   * Draws the edit section.
   */ ?>
  <section id="edit-account">

    <header>
      <h2>Edit Account</h2>
    </header>
    <?php draw_edit_profile($user,0); ?>

    <div id="edit-sensitive">
      <form method="post" action="../actions/action_edit_account.php" class="sensitive">
        <?php drawConfirmationForm("Edit Account", "Are you sure you want to make this changes?") ?>
        <input type="hidden" name="csrf" value="<?= $_SESSION['csrf'] ?>">
        <input type="password" name="oldpassword" placeholder="Old Password" id="oldpassword" required spellcheck="false" autocomplete="off" autocorrect="off" autocapitalize="off">
        <input type="text" name="username" placeholder="Username" required pattern="^[a-zA-Z0-9]+$" id="username" title="Must only contain numbers and letters" spellcheck="false" autocomplete="off" autocorrect="off" autocapitalize="off">
        <input type="password" name="password" placeholder="Password" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{8,64}$" id="password" title="Must contain at least 1 number, 1 uppercase and lowercase letters, 1 special character and between 8 or 64 characters" required spellcheck="false" autocomplete="off" autocorrect="off" autocapitalize="off">
        <input type="submit" value="Edit Sensitive Information">
      </form>

      <form method="post" action="../actions/action_delete_account.php">
        <?php drawConfirmationForm("Delete Account", "Are you sure you want to delete your account?") ?>
        <input type="hidden" name="csrf" value="<?= $_SESSION['csrf'] ?>">
        <input type="submit" value="Delete Account">
      </form>
    </div>
    
  </section>
<?php } ?>

<?php function draw_edit_profile($user,$setup_page)
{
  $profile = getUser($user); 
  if($setup_page) {?>
    <section id="edit-account">
    <h2 id="setup-profile-title">Setup Your Profile</h2>
  <?php }?>

  <form action="../actions/action_edit_profile.php" method="post" class="edit-details" enctype="multipart/form-data">
    <img class="profile-image" src="../images/thumbs_small/<?=$profile['profile_image']?>.jpg" alt="Photo of <?= $profile['username'] ?>">
    <input type="file" name="profilepic" id="upload-profile-button" accept=".jpeg,.jpg,.png,.gif">
    <input type="hidden" name="username" value="<?= $profile['username'] ?>">
    <label for="profile_name">Full Name:</label>
    <input type="text" name="fullname" id="profile_name" placeholder="<?= $profile['fullname'] ?>" pattern="^\s*([a-zA-ZÀ-ÿ][a-zA-Z\s\-À-ÿ]*)$" title="Must only contain letters, spaces and hyphens">
    <label for="profile_age">Age:</label>
    <input type="text" name="age" id="profile_age" placeholder="<?= $profile['age'] ?>" pattern="^[0-9]+$" title="Must only contain numbers">
    <label for="profile_email">E-mail:</label>
    <input type="text" name="email" id="profile_email" placeholder="<?= $profile['email'] ?>" pattern="^[a-zA-Z0-9_.\+\-]+@[a-zA-Z0-9\-]+.[a-zA-Z]{2,3}$" title="Must only contain letters, numbers or one of these symbols [@ _ .]">
    <label for="profile_mobile">Mobile Number:</label>
    <input type="text" name="mobile" id="profile_mobile" placeholder="<?= $profile['mobile'] ?>" pattern="^(\+\d{1,3}[\-]?)?\d{4,12}$" title="Must only contain numbers and plus sign">
    <label for="profile_location">Location:</label>
    <input type="text" name="location" id="profile_location" placeholder="<?= $profile['location'] ?>" pattern="^\s*([a-zA-ZÀ-ÿ][a-zA-ZÀ-ÿ\s\-.]*)$" title="Must only contain letters, spaces, dots or hyphens">
    <label for="profile_bio">Bio:</label>
    <input type="text" name="bio" id="profile_bio" placeholder="<?= $profile['bio'] ?>" pattern="^\s*([a-zA-ZÀ-ÿ][a-zA-ZÀ-ÿ\s,.\-?!:;]*)$" title="Must only contain letters, spaces or punctuation marks">
    <input type="submit" value="Edit Info">
  </form>
  
  <?php if($setup_page) {?>
    <form action="../pages/main.php">
      <input type="submit" value="Skip this step">
    </form>
    </section>
  <?php } ?>
<?php } ?>