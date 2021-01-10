<?php function draw_ownerMenu($user)
{ ?>
  <div id="owner-page">
    <section id="owner-menu">
      <form action="../pages/add_pets.php">
        <input type="submit" value="Add Pet">
      </form>

      <form action="../pages/owned_pets.php">
        <input type="submit" value="Owned Pets">
      </form>

      <form action="../pages/owner_favorite.php">
        <input type="submit" value="Favorite Pets">
      </form>

      <form action="../pages/owner_que_pro.php">
        <input type="submit" value="Your Proposals and Questions">
      </form>

      <form action="../pages/profile_page.php">
        <input type="hidden" name="user" value="<?= $user ?>">
        <input type="submit" value="Profile Page">
      </form>

      <form action="../pages/edit_account.php">
        <input type="submit" value="Edit Account">
      </form>

      <form action="../actions/action_logout.php">
        <input type="submit" value="Logout">
      </form>
    </section>

    <?php draw_notifications(); ?>
  </div>
<?php } ?>

<?php function draw_notifications()
{ ?>
  <form action="" id="notificationButton">
    <input type="submit" value="Notifications" id="notificationToggle">
  </form>
  <section id="notifications">
    <h1>Notification Centre</h1>
    <?php
    $notifications = getUserNotifications($_SESSION['username']);
    foreach ($notifications as $notification) {
      draw_notification($notification);
      if ($notification['seen'] == 0) setNotificationSeen($notification['notif_id']);
    } ?>
  </section>
<?php } ?>

<?php function draw_notification($notification)
{ ?>
  <article class="notification <?php
                                if ($notification['seen'] == 0)
                                  echo "new-notif"
                                ?>">
    <p class="notif-text"><?= $notification['notif_sender'] ?> <?= $notification['notif_text'] ?></p>
    <p class="notif-date"><?= date("d-m-Y", $notification['published']) ?><br><?= date("H:i", $notification['published']) ?></p>
  </article>
<?php } ?>


<?php function draw_shelterMenu($user)
{ ?>
  <section id="shelter-menu">
    <form action="../pages/owned_pets.php">
      <input type="submit" value="Owned Pets">
    </form>
    <form action="../pages/collaborator_list.php">
      <input type="submit" value="Add Collaborator">
    </form>
    <form action="../pages/profile_page.php">
      <input type="hidden" name="user" value="<?= $user ?>">
      <input type="submit" value="Profile Page">
    </form>
    <form action="../pages/edit_account.php">
      <input type="submit" value="Edit Account">
    </form>
    <form action="../actions/action_logout.php">
        <input type="submit" value="Logout">
    </form>

  </section>
<?php } ?>

<?php function draw_user_questions_proposals($username)
{ ?>
  <section id="owner-qp">
    <header>
      <h1>Your Proposals and Questions</h1>
    </header>
    <header>
      <h2>Proposals</h2>
    </header>

    <?php
    $userPetProposals = getUserProposals($username);
    foreach ($userPetProposals as $proposal) {
      $decision = getProposalStateCode($proposal['decision']); ?>
      <div class='user-proposal' data-decision=<?= $decision ?> data-proposal_id=<?= $proposal['pet_proposal_id'] ?>>
        <div class='user-proposal-header'>
          <a class='proposal-pet' href="petdetails.php?pet_id=<?= $proposal['pet_id'] ?>">
            <h3><?= $proposal['pet_name'] ?></h3>
          </a>
          <p class='proposal-date'><?= date('D, d-m-Y H:i', $proposal['published']) ?></p>
          <i class="fas fa-plus proposal-expand"></i>
        </div>
        <div class='proposal-details'>
          <span class='proposal-motivation'>
            <h4>Your motivation</h4>
            <?= $proposal['motivation'] ?>
          </span>
          <?php if ($proposal['decision'] == 0 || $proposal['decision'] == 1) { ?>
            <span class='proposal-actions'>
              <?php if ($proposal['decision'] == 1) { ?>
                <span class='button confirm'>Confirm</span>
              <?php } ?>
              <span class='button withdraw'>Withdraw</span>
            </span>
          <?php } ?>
          <span class='proposal-state'><?= $decision ?></span>
        </div>
      </div>
    <?php } ?>

    <header>
      <h2>Questions</h2>
    </header>
    <?php
    $userPetQuestions = getPetsFromUserQuestions($username);
    for ($i = 0; $i < count($userPetQuestions); $i++) { ?>
      <header>
        <h3><a href="petdetails.php?pet_id=<?= $userPetQuestions[$i]['pet_id'] ?>"><?= $userPetQuestions[$i]['pet_name'] ?></a></h3>
      </header>
    <?php draw_user_questions($userPetQuestions[$i], $username);
    }
    ?>

  </section>
<?php } ?>


<?php function draw_owned_questions_proposals($ownedPets)
{ ?>
  <section id="pets-owned">
    <header>
      <h1>Owned Pets</h1>
    </header>
    <?php
    for ($i = 0; $i < count($ownedPets); $i++) { ?>
      <div class="pet-owned" data-pet-id=<?= $ownedPets[$i]['pet_id'] ?>>
        <header>
          <h2><a href="petdetails.php?pet_id=<?= $ownedPets[$i]['pet_id'] ?>"><?= $ownedPets[$i]['pet_name'] ?></a></h2>
        </header>
        <?php
        draw_questions($ownedPets[$i]);
        draw_proposals($ownedPets[$i]);
        ?>
      </div>
    <?php } ?>
  </section>
<?php } ?>

<?php function draw_questions($ownedPet)
{ ?>

  <section id="pet-questions">
    <header>
      <h3>Questions:</h3>
    </header>
    <?php
    $petsQuestions = getPetsQuestions($ownedPet['pet_id']);
    if (count($petsQuestions) == 0) { ?>
      <p>No questions yet...</p>
      <?php
    } else {
      foreach ($petsQuestions as $pet_question) {
        $reply_placeholder = "Reply to this question"; ?>
        <article class="question" data-asker="<?= $pet_question['username'] ?>" data-question_id="<?= $pet_question['question_id'] ?>">
          <span class="user"><?= ucfirst($pet_question['username']) ?></span>
          <span class="date"><?= date('D, d-m-Y H:i', $pet_question['published']) ?></span>
          <p><?= $pet_question['question_text'] ?></p>
          <?php if (hasReplied($pet_question['question_id'])) {
            $reply_placeholder = "You already responded to this question...\nBut you can reply again";
          } ?>
          <form class="reply-form">
            <textarea name="reply-area" placeholder="<?= $reply_placeholder ?>" cols="30" rows="5"></textarea>
            <input type="button" value="Reply" class="reply-button">
          </form>
        </article>
      <?php } ?>
    <?php } ?>
  </section>
<?php } ?>

<?php function draw_user_questions($pet, $username)
{ ?>

  <section id="pet-user-questions">
    <?php
    foreach (getUserQuestions($pet['pet_id'], $username) as $user_question) { ?>
      <article class="question">
        <span class="date"><?= date('D, d-m-Y H:i', $user_question['published']) ?></span>
        <p><?= $user_question['question_text'] ?></p>
      </article>
    <?php } ?>
  </section>

<?php } ?>

<?php function draw_proposals($ownedPet)
{ ?>
  <section id="pet-proposals">
    <header>
      <h3>Proposals:</h3>
    </header>
    <?php $petsProposals = getPetsProposals($ownedPet['pet_id']);
    if (count($petsProposals) == 0) { ?>
      <p>No proposals yet...</p>
      <?php } else {
      foreach ($petsProposals as $proposal) {
        $decision = getProposalStateCode($proposal['decision']); ?>
        <div class='user-proposal' data-decision=<?= $decision ?> data-proposal_id=<?= $proposal['pet_proposal_id'] ?>>
          <div class='user-proposal-header'>
            <a class='proposal-user'>
              <h3><?= $proposal['username'] ?></h3>
            </a>
            <p class='proposal-date'><?= date('D, d-m-Y H:i', $proposal['published']) ?></p>
            <i class="fas fa-plus proposal-expand"></i>
          </div>
          <div class='proposal-details'>
            <span class='proposal-motivation'>
              <h4>Your motivation</h4>
              <?= $proposal['motivation'] ?>
            </span>
            <?php if ($proposal['decision'] == 0 || $proposal['decision'] == 1) { ?>
              <span class='proposal-actions'>
                <?php if ($proposal['decision'] == 0) { ?>
                  <span class='button accept'>Accept</span>
                <?php } ?>
                <span class='button reject'>Reject</span>
              </span>
            <?php } ?>
            <span class='proposal-state'><?= $decision ?></span>
          </div>
        </div>
    <?php }
    } ?>
  </section>

<?php } ?>

<?php function draw_add_pet($lastID)
{ ?>

  <section id="add-pet">
    <form action="../actions/action_add_pet.php" method="post" class="pet-add" enctype="multipart/form-data">
      <label for="pet_name">Name:</label>
      <input type="text" name="pet_name" id="pet_name" placeholder="Your pet name..." pattern="^\s*([a-zA-ZÀ-ÿ][a-zA-ZÀ-ÿ\s]*)$" required title="Must only contain letters and spaces">
      <label for="pet_type">Type:</label>
      <select name="pet_type">
        <?php $types = getPetTypes();
        foreach ($types as $type) { ?>
          <option value=<?= $type['type_id'] ?>><?= $type['name'] ?></option>
        <?php } ?>
      </select>
      <label for="pet_species">Species:</label>
      <input type="text" name="pet_species" id="pet_species" placeholder="Your pet species..." pattern="^\s*([a-zA-ZÀ-ÿ][a-zA-ZÀ-ÿ\s\-]*)$" required title="Must only contain letters and spaces">
      <label for="pet_age">Age:</label>
      <select name="pet_age" required>
        <?php $ages = getPetAges();
        foreach ($ages as $age) { ?>
          <option value=<?= $age['age_id'] ?>><?= $age['name'] ?></option>
        <?php } ?>
      </select>
      <label for="pet_gender">Gender:</label>
      <select name="pet_gender" required>
        <?php $genders = getPetGenders();
        foreach ($genders as $gender) { ?>
          <option value=<?= $gender['gender_id'] ?>><?= $gender['name'] ?></option>
        <?php } ?>
      </select>
      <label for="pet_size">Size:</label>
      <input type="text" name="pet_size" id="pet_size" placeholder="Your pet size..." pattern="^[0-9]+([,.][0-9]+)?$" required title="Must only contain numbers and separators (commas or dots)">
      <label for="pet_weight">Weight:</label>
      <input type="text" name="pet_weight" id="pet_weight" placeholder="Your pet weight..." pattern="^[0-9]+([,.][0-9]+)?$" required title="Must only contain numbers and separators (commas or dots)">
      <label for="pet_color">Color:</label>
      <select name="pet_color">
        <?php $colors = getColorNames();
        foreach ($colors as $color) { ?>
          <option value=<?= $color['color_id'] ?>><?= $color['name'] ?></option>
        <?php } ?>
      </select>
      <label for="pet_location">Location:</label>
      <input type="text" name="pet_location" id="pet_location" pattern="^\s*([a-zA-ZÀ-ÿ][a-zA-ZÀ-ÿ\s\-.]*)$" placeholder="Your pet location..." required title="Must only contain letters and spaces">
      <label for="pet_state">State:</label>
      <select name="pet_state" required>
        <option value=1><?= getPetStateName(1) ?></option>
        <option value=2><?= getPetStateName(2) ?></option>
      </select>
      <section class="upload-image">
        <input type="hidden" name="pet_id" value="<?= $lastID ?>">
        <input type="button" id="replace-file-button" value="Choose a file">
        <span id="selected-files">No files chosen, yet</span>
        <input type="file" name="image[]" id="upload-file-button" accept=".jpeg,.jpg,.png,.gif" multiple>
        <input type="submit" value="Upload Photos And Add Pet" id="upload-add-button">
      </section>
      
    </form>
  </section>

<?php } ?>

<?php function draw_profile_page($profileUser, $loggedUser)
{
  if ($profileUser == $loggedUser) { ?>
    <div id="profile-nav">
      <button class="profile-nav-btn" data-tab="profile-page">Profile</button>
      <button class="profile-nav-btn" data-tab="profile-stats">Stats</button>
    </div>
  <?php
    draw_profiledetails($profileUser);
    draw_profile_stats($profileUser);
  } else {
    draw_profiledetails($profileUser);
  } ?>
<?php } ?>

<?php function draw_profile_stats($user)
{ ?>
  <article id="profile-stats" class="tab" style="display: none;">
    <h1 id="profile-stats-title">Your Statistics</h1>
    
    <section class="stats-container">
      <h2 class="stats-title">Pets</h2>
      <p class="stats-text"><span>Adopted pets </span><?= count(getAdoptedPetsFromUser($user)) ?></p>
      <p class="stats-text"><span>Pets for adoption </span><?= count(getPetsUpForAdoptionFromUser($user)) ?></p>
    </section>
    <section class="stats-container">
      <h2 class="stats-title">Proposals</h2>
      <p class="stats-text"><span>Proposals made </span><?= count(getUserProposals($user)) ?></p>
      <p class="stats-text"><span>Proposals received </span><?= count(getAllUserResponses($user)) ?></p>
      <p class="stats-text"><span>Pending proposals </span><?= count(getPendingProposals($user)) ?></p>
    </section>
    <section class="stats-container" id="stats-container-big">
      <h2 class="stats-title">Questions and Answers</h2>
      <p class="stats-text"><span>Questions </span><?= count(getAllUserQuestions($user)) ?></p>
      <p class="stats-text"><span>Replies </span><?= count(getAllUserResponses($user)) ?></p>
      <p class="stats-text"><span>Pets that you asked about </span><?= count(getPetsFromUserQuestions($user)) ?></p>
    </section>
    <section class="stats-container">
      <h2 class="stats-title">Favorites</h2>
      <p class="stats-text"><span>Favorite pets </span><?= count(getFavoritePets($user)) ?></p>
    </section>
    <section class="stats-container">
      <h2 class="stats-title">Notifications</h2>
      <p class="stats-text"><span>Notifications received </span><?= count(getUserNotifications($user)) ?></p>
    </section>
  </article>
<?php } ?>

<?php function draw_profiledetails($user)
{ ?>

  <article id="profile-page" class="tab">
    <section id="profile-header">
      <?php
      $profile = getUser($user); ?>
      <div id="profile-image">
        <img class="profile-image" src="../images/thumbs_medium/<?= $profile['profile_image'] ?>.jpg" alt="Photo of <?= $profile['username'] ?>">
      </div>
      <div id="profile-details">
        <h1 id="profile-name"><?= $profile['fullname'] ?></h1>
        <ul>
          <li><span class="profile-detail">Age </span><?= $profile['age'] ?></li>
          <li><span class="profile-detail">E-mail </span> <?= $profile['email'] ?></li>
          <li><span class="profile-detail">Mobile </span> <?= $profile['mobile'] ?></li>
          <li><span class="profile-detail">Location </span> <?= $profile['location'] ?></li>
          <li><span class="profile-detail">Bio </span> <?= $profile['bio'] ?></li>
        </ul>
      </div>
    </section>
    <section class="profile-container">
      <?php $isShelter = isShelter($user); ?>
      <h2><?php if($isShelter) echo "Pets"; else echo "Your pets";?></h2>
      <div class="profile-container-pets">
        <?php
        $collaborators = [];
        if ($isShelter) {
          $ownedPets = [];
          $collaborators = getCollaborators($user);
          foreach ($collaborators as $collaborator) {
            array_push($ownedPets, ...getPetsUpForAdoptionFromUser($collaborator['username']));
          }
        } else
          $ownedPets = getPetsUpForAdoptionFromUser($user);
        for ($i = 0; $i < count($ownedPets); $i++) { ?>
          <div class="profile-pet-owned">
            <?php draw_card($ownedPets[$i]); ?>
          </div>
        <?php } ?>
      </div>
    </section>
    <section class="profile-container">
      <h2>Previously adopted pets</h2>
      <div class="profile-container-pets">
        <?php
        if ($isShelter) {
          $adoptedPets = [];
          foreach ($collaborators as $collaborator) {
            array_push($ownedPets, ...getAdoptedPetsFromUser($collaborator['username']));
          }
        } else
          $adoptedPets = getAdoptedPetsFromUser($user);
        foreach ($adoptedPets as $adoptedPet) { ?>
          <div class="profile-pet-owned">
            <?php draw_card($adoptedPet); ?>
          </div>
        <?php } ?>
      </div>
    </section>
    <?php if ($isShelter) { ?>
      <section id="shelter-collaborators-section">
        <h1><?= $profile['fullname'] ?>'s collaborators:</h1>
        <section id="shelter-collaborators">
        <?php foreach ($collaborators as $collaborator) { ?>
          <div class="featured-user main-container">
              <a href="../pages/profile_page.php?user=<?=$collaborator['username']?>">
              <div class="user-card">
                  <h3><?=ucfirst($collaborator['username'])?></h3>
                  <img class="profile-image" src="../images/thumbs_medium/<?=$collaborator['profile_image']?>.jpg" alt="Photo of <?=$collaborator['username']?>">
              </div>
              </a>
          </div>
        <?php } ?>
        </section>
      </section>
    <?php } ?>
  </article>

<?php } ?>