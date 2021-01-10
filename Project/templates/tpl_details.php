<?php function draw_petdetails($pet, $username)
{ ?>

  <article id="pet-page" data-pet_id=<?=$pet['pet_id']?>>
    <section id="pet-images">
      <?php
      $i = 0;
      foreach (getImageFromPets($pet['pet_id']) as $pet_image) { 
        if($i==0) {?>
        <img class="pet-images-slideshow" src="../images/originals/<?= $pet_image['pet_image_id'] ?>.jpg" alt="Photo of <?= $pet['pet_name'] ?>">
      <?php
        $i++; 
        }
        else { ?>
          <img class="pet-images-slideshow" src="../images/originals/<?= $pet_image['pet_image_id'] ?>.jpg" alt="Photo of <?= $pet['pet_name'] ?>" style="display: none;">
        <?php } 
       }?>
      <button class="slideshow-button display-left">&#10094;</button>
      <button class="slideshow-button display-right">&#10095;</button>
    </section>

    <section id="details">

      <?php if (isPetOwner($username, $pet['pet_id'], isShelter($username))) { ?>
        <form action="../actions/action_edit_pet.php" method="post" class="edit-details">
          <input type="hidden" name="pet_id" value="<?= $pet['pet_id'] ?>">
          <label for="pet_name">Name:</label>
          <input type="text" name="pet_name" id="pet_name" placeholder="<?= $pet['pet_name'] ?>" pattern="^\s*([a-zA-ZÀ-ÿ][a-zA-ZÀ-ÿ\s]*)$" title="Must only contain letters and spaces (can't contain only spaces)">
          <label for="pet_type">Type:</label>
          <select>
            <?php $types = getPetTypes();
            foreach ($types as $type) { ?>
              <option value=<?=$type['type_id']?> <?php if($pet['pet_type'] == $type['type_id']) {echo 'selected';}?>><?=$type['name']?></option>
            <?php } ?>
          </select>
          <label for="pet_species">Species:</label>
          <input type="text" name="pet_species" id="pet_species" placeholder="<?= $pet['pet_species'] ?>" pattern="^\s*([a-zA-ZÀ-ÿ][a-zA-ZÀ-ÿ\s\-]*)$" title="Must only contain letters and spaces (can't contain only spaces)">
          <label for="pet_age">Age:</label>
          <select name="pet_age">
            <?php $ages = getPetAges();
            foreach ($ages as $age) { ?>
              <option value=<?=$age['age_id']?> <?php if($pet['pet_age'] == $age['age_id']) {echo 'selected';}?>><?=$age['name']?></option>
            <?php } ?>
          </select>
          <label for="pet_gender">Gender:</label>
          <select name="pet_gender">
            <?php $genders = getPetGenders();
            foreach ($genders as $gender) { ?>
              <option value=<?=$gender['gender_id']?> <?php if($pet['pet_gender'] == $gender['gender_id']) {echo 'selected';}?>><?=$gender['name']?></option>
            <?php } ?>
          </select>
          <label for="pet_size">Size:</label>
          <input type="text" name="pet_size" id="pet_size" placeholder="<?= $pet['pet_size'] ?>" pattern="^[0-9]+([,.][0-9]+)?$" title="Must only contain numbers and separators (commas or dots)">
          <label for="pet_weight">Weight:</label>
          <input type="text" name="pet_weight" id="pet_weight" placeholder="<?= $pet['pet_weight'] ?>" pattern="^[0-9]+([,.][0-9]+)?$" title="Must only contain numbers and separators (commas or dots)">
          <label for="pet_color">Color:</label>
          <select name="pet_color">
            <?php $colors = getColorNames();
            foreach ($colors as $color) { ?>
              <option value=<?=$color['color_id']?> <?php if($pet['pet_age'] == $color['color_id']) {echo 'selected';}?>><?=$color['name']?></option>
            <?php } ?>
          </select>
          <label for="pet_location">Location:</label>
          <input type="text" name="pet_location" id="pet_location" placeholder="<?= $pet['pet_location'] ?>" pattern="^\s*([a-zA-ZÀ-ÿ][a-zA-ZÀ-ÿ\s\-.]*)$" title="Must only contain letters">
          <label for="pet_state">Status:</label>
          <select name="pet_state" <?php if ($pet['pet_state'] == 3) {echo 'disabled';}?>>
            <?php $states = getPetStates();
            foreach ($states as $state) { ?>
              <option value=<?=$state['state_id']?> <?php if($pet['pet_state'] == $state['state_id']) {echo 'selected';}?>><?=$state['name']?></option>
            <?php } ?>
          </select>
          <?php if ($pet['pet_state'] == 3) { ?>
            <div class="select-message">You can only change this status by declining the proposal</div>
          <?php } ?>
          <input type="submit" value="Update Info">
        </form>
        <form action="../actions/action_upload_image.php" method="post" enctype="multipart/form-data" class="upload-image">
          <input type="hidden" name="pet_id" value="<?= $pet['pet_id'] ?>">
          <input type="button" id="replace-file-button" value="Choose a file">
          <span id="selected-files">No files chosen, yet</span>
          <input type="file" name="image[]" id="upload-file-button" accept=".jpeg,.jpg,.png,.gif" multiple>
          <input type="submit" value="Update Photos">
        </form>

        <form action="../actions/action_delete_pet.php" method="post" class="delete-pet">
          <?php drawConfirmationForm("Delete Pet", "Are you sure you want to delete this pet?") ?>
          <input type="hidden" name="csrf" value="<?= $_SESSION['csrf'] ?>">
          <input type="hidden" name="pet_id" value="<?= $pet['pet_id'] ?>">
          <input type="submit" value="Delete Pet" id="delete-button">
        </form>
      <?php } else { ?>
        <h1><?= $pet['pet_name'] ?></h1>
        <h3><?= $pet['pet_species'] ?></h3>
        <ul>
            <li name="age" class="pet-age"><span class='tag'>Age:</span> <?=getPetAgeName($pet['pet_age'])?> <span class='age-description'><?=getPetAgeDescription($pet['pet_age'])?></span></li>
            <li name="gender"><span class='tag'>Gender:</span> <?=getPetGenderName($pet['pet_gender'])?></li>
            <li name="size"><span class='tag'>Size:</span> <?=$pet['pet_size']?></li>
            <li name="weight"><span class='tag'>Weight:</span> <?=$pet['pet_weight']?></li>
            <li name="color"><span class='tag'>Color:</span> <?=getColorName($pet['pet_color'])?></li>
            <li name="location"><span class='tag'>Location:</span> <?=$pet['pet_location']?></li>
            <li name="owner"><span class='tag'>Owner:</span> <?=$pet['username']?></li>
            <li class='pet-state'><span class='tag'>State:</span> <?=getPetStateName($pet['pet_state'])?> <span class='state-description'><?=getPetStateDescription($pet['pet_state'])?></span></li>
        </ul>
        <?php 
            if ($pet['pet_state'] == 2 && isset($_SESSION['username'])) { ?>
          <button type="button" id='adopt-button'><span>Adopt me!</span></button>
          <?php if (hasPendingProposal($username, $pet['pet_id'])) { ?>
            <form class='adoption-form error' id='adopt-form'>
              You have already submitted a proposal for this pet that is in pending state.
            </form> 
          <?php } else { ?>
            <form class='adoption-form' id='adopt-form'>
              <textarea maxlength=400 placeholder='Your motivation'></textarea>
              <input class='send' type='button' value='Send proposal'>
              <div class='char-counter'><span id='char-count'>0</span>/400</div>
            </form> 
          <?php } ?>
        <?php } ?>
      <?php } ?>
    </section>
    <section id="questions-replies">
      <h2>Questions Forum:</h2>
      <?php if (!isPetOwner($username, $pet['pet_id'], isShelter($username)) && isset($_SESSION['username'])) { ?>
      <form class='question-form' id='question-form'>
        <textarea maxlength=400 placeholder='Leave your question here'></textarea>
        <input class='send' type='button' value='Send Question'>
        <div class='char-counter'><span id='char-count-question'>0</span>/400</div>
      </form>
      <?php } ?>
      <?php
      $questions = getRepliedQuestions($pet['pet_id']);
      foreach ($questions as $replied_question) { ?>
        <article class="question">
          <span class="user"><a href="../pages/profile_page.php?user=<?= $replied_question['username'] ?>"><?= ucfirst($replied_question['username']) ?></a></span>
          <span class="date"><?= date('D, d-m-Y H:i', $replied_question['published']) ?></span>
          <p><?= $replied_question['question_text'] ?></p>
        </article>
        <?php
        $replies = getReply($replied_question['question_id']); 
        foreach ($replies as $reply) {?>
        <article class="reply">
          <span class="user"><a href="../pages/profile_page.php?user=<?= $reply['username'] ?>"><?= ucfirst($reply['username']) ?></a></span>
          <span class="date"><?= date('D, d-m-Y H:i', $reply['published']) ?></span>
          <p><?= $reply['reply_text'] ?></p>
        </article>
        <?php } ?>
      <?php } ?>
    </section>
  </article>
<?php } ?>
