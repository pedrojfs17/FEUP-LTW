<?php function draw_main_page($featuredPets) { ?>
<section id="search-for-pet">
    <h1>Welcome to PetMe!</h1>
    <img class="main-image" src="../images/page/pets.png" alt="Pets">
    <h2>Are you ready to find your dream pet?</h2>
    
    <form action="search.php">
        <input type="submit" value="FIND DREAM PET" id="search-by-type">
    </form>
</section>

<div id="main-page">

    <div class="main-container" id="adopt-why">
        <h2>Why you should adopt a pet</h2>
        <div id="adopt-reasons">
            <p>If you adopt, you'll save a life</p>
            <p>When you adopt, you get a healthy pet</p>
            <p>Adopting will save you money</p>
            <p>Adopting a pet will make you feel better</p>
            <p>If you adopt, you won't be supporting puppy mills and pet stores</p>
        </div>
    </div>

    <div class="featured-container">
        <h2>FEATURED SHELTER</h2>
        <div class="featured-shelter main-container">
        <?php $shelter = getRandomShelter()?>
            <a href="../pages/profile_page.php?user=<?=$shelter['username']?>">
            <div class="shelter-card">
                <h3><?=$shelter['fullname']?></h3>
                <img class="profile-image" src="../images/thumbs_medium/<?= $shelter['profile_image'] ?>.jpg" alt="Photo of <?= $shelter['username'] ?>">
            </div>
            </a>
        </div>
    </div>

    <div class="featured-container" id="featured-pets">
        <h2>FEATURED PETS</h2>
        <section id="pet-cards">
            <?php for ($i = 0; $i < 3; $i++) {
                draw_card($featuredPets[$i]);
            } ?>
        </section>
    </div>

    <div class="main-container" id="team">
        <h2>Our Team</h2>
        <div id="members">
            <div class="team-member">
                <img src="../images/page/team/antonio_bezerra.png">
                <h3>António Bezerra</h3>
                <p>up201806854</p>
            </div>
            <div class="team-member">
                <img src="../images/page/team/goncalo_alves.png">
                <h3>Gonçalo Alves</h3>
                <p>up201806451</p>
            </div>
            <div class="team-member">
                <img src="../images/page/team/ines_silva.png">
                <h3>Inês Silva</h3>
                <p>up201806385</p>
            </div>
            <div class="team-member">
                <img src="../images/page/team/pedro_seixas.png">
                <h3>Pedro Seixas</h3>
                <p>up201806227</p>
            </div>
        </div>
    </div>

    <div class="featured-container">
        <h2>FEATURED USER</h2>
        <div class="featured-user main-container">
        <?php $user = getRandomUser()?>
            <a href="../pages/profile_page.php?user=<?=$user['username']?>">
            <div class="user-card">
                <h3><?=$user['fullname']?></h3>
                <img class="profile-image" src="../images/thumbs_medium/<?= $user['profile_image'] ?>.jpg" alt="Photo of <?= $user['username'] ?>">
            </div>
            </a>
        </div>
    </div>
</div>

<?php } ?>