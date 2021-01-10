<?php function draw_search_cards($cards)
{ ?>
  <section id="search-cards">
    <?php
    if (count($cards) == 0)
      draw_empty();
    else {
      draw_checkboxes();
      draw_cards($cards);
    }
    ?>
  </section>
<?php } ?>

<?php function draw_cards($cards)
{ ?>
  <section id="pet-cards">
    <?php
    foreach ($cards as $card) {
      draw_card($card);
    }
    ?>
  </section>
<?php } ?>

<?php function draw_card($card)
{ ?>
  <?php
  $category = "";
  foreach ($card as $key => $val) {
    if ($key == "pet_id" || $key == "pet_state" || $key == "pet_name") continue;
    else if ($key == "pet_age") {
      $category .= getPetAgeName($val) . " ";
      continue;
    } else if ($key == "pet_color") {
      $category .= getColorName($val) . " ";
      continue;
    } else if ($key == "pet_gender") {
      $category .= getPetGenderName($val) . " ";
      continue;
    } else if ($key == "pet_type") {
      $category .= getPetTypeName($val) . " ";
      continue;
    }
    $category .= $val . " ";
  }

  trim($category);

  ?>

  <div class="pet-card" data-category="<?= $category ?>" data-id=<?= $card['pet_id'] ?> data-owner=<?= $card['username'] ?>>
    <div class="card-image">
      <?php $pet_image = getImageFromPets($card['pet_id'])[0];?>
        <img src="../images/thumbs_medium/<?= $pet_image['pet_image_id'] ?>.jpg" width=auto height=auto>
      <?php if (isset($_SESSION['username'])) { ?>
        <div class="fav-icon">
          <i class="material-icons">favorite_border</i>
        </div>
      <?php } ?>
    </div>
    <div class="card-text">
      <span class="species"><?= $card['pet_species'] ?></span>
      <h2><?= $card['pet_name'] ?></h2>
    </div>
    <div class="card-stats">
      <div class="stat">
        <div class="value"><?= $card['pet_age'] ?>y</div>
        <div class="type">age</div>
      </div>
      <div class="stat">
        <div class="value"><?= getColorName($card['pet_color']) ?></div>
        <div class="type">color</div>
      </div>
      <div class="stat">
        <?php $gender = "Male";
        if ($card['pet_gender'] == 2) {
          $gender = "Female";
        } ?>
        <div class="value"><?= $gender ?></div>
        <div class="type">gender</div>
      </div>

      <div class="card-link"><a href="petdetails.php?pet_id=<?= $card['pet_id'] ?>">Adopt Me!</a></div>
    </div>
  </div>
<?php } ?>

<?php function draw_arrow_left()
{ ?>
  <button type="button" class="pet-card-rotate-button" id="rotate-left">&lt;</button>
<?php } ?>

<?php function draw_arrow_right()
{ ?>
  <button type="button" class="pet-card-rotate-button" id="rotate-right">&gt;</button>
<?php } ?>

<?php function draw_empty()
{ ?>
  <section id="pet-cards">
    <p>No results for your search...</p>
  </section>
<?php } ?>

<?php function draw_checkboxes()
{
  $types = getPetTypes();
?>
  <section id="search-filters">
    <h3>Filters</h3>

    <div class="search-parameter searchDropdown">Type
      <label class="dropdown-label">Search</label>
      <div class="dropdown-list">
        <?php $types = getPetTypes();
        foreach($types as $type) { ?>
          <label class="dropdown-option">
            <input type="checkbox" name="pet-type" value="<?=$type['name']?>"/> <?=$type['name']?>
          </label>
        <?php } ?>     
      </div>
    </div>

    <div class="search-parameter searchDropdown">Species
      <label class="dropdown-label">Search</label>
      <div class="dropdown-list">
        <?php $species = getPetSpecies();
        foreach($species as $specie) { ?>
          <label class="dropdown-option">
            <input type="checkbox" name="pet-species" value="<?=$specie['pet_species']?>"/> <?=$specie['pet_species']?>
          </label>
        <?php } ?>     
      </div>
    </div>

    <div class="search-parameter searchDropdown">Age
      <label class="dropdown-label">Search</label>
      <div class="dropdown-list">
        <?php $ages = getPetAges();
        foreach($ages as $age) { ?>
          <label class="dropdown-option">
            <input type="checkbox" name="pet-age" value="<?=$age['name']?>"/> <?=$age['name']?>
          </label>
        <?php } ?>     
      </div>
    </div>
    
    <div class="search-parameter searchDropdown">Gender
      <label class="dropdown-label">Search</label>
      <div class="dropdown-list">
        <?php $genders = getPetGenders();
        foreach($genders as $gender) { ?>
          <label class="dropdown-option">
            <input type="checkbox" name="pet-gender" value="<?=$gender['name']?>"/> <?=$gender['name']?>
          </label>
        <?php } ?>     
      </div>
    </div>

    <div class="search-parameter searchDropdown">Color
      <label class="dropdown-label">Search</label>
      <div class="dropdown-list">
        <?php $colors = getColorNames();
        foreach($colors as $color) { ?>
          <label class="dropdown-option">
            <input type="checkbox" name="pet-color" value="<?=$color['name']?>"/> <?=$color['name']?>
          </label>
        <?php } ?>     
      </div>
    </div>
  </section>
<?php } ?>