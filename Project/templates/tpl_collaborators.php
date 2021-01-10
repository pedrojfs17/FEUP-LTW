<?php function draw_collaboration($shelter)
{ ?>

  <section id="shelter-collaboration">
    <header>
      <h3>Collaboration:</h3>
    </header>
    <?php
    draw_noncollaborators($shelter);
    draw_collaborators($shelter);
    ?>
  </section>
<?php } ?>


<?php function draw_noncollaborators($shelter)
{ ?>

  <section id="shelter-noncollaborators">
    <header>
      <h3>Users:</h3>
    </header>
    <?php
    $noncollaborators = getNonCollaborators($shelter);
    if (count($noncollaborators) == 0) { ?>
      <p>No collaborators available...</p>
      <?php
    } else {
      foreach ($noncollaborators as $noncollaborator) { ?>
        <article class="collaborator">
          <span class="user"><?= ucfirst($noncollaborator['username']) ?></span>
          <form method="POST" action="../actions/action_add_collaborator.php">
            <input type="hidden" name="username" value="<?=$noncollaborator['username']?>">
            <input type="submit" name="request_button" value="Add Collaborator">
          </form>
        </article>
    <?php }
    } ?>
  </section>
<?php } ?>


<?php function draw_collaborators($shelter)
{ ?>

  <section id="shelter-collaborators">
    <header>
      <h3>Your Collaborators:</h3>
    </header>
    <?php
    $collaborators = getCollaborators($shelter);
    if (count($collaborators) == 0) { ?>
      <p>No collaborators yet...</p>
      <?php
    } else {
      foreach ($collaborators as $collaborator) { ?>
        <article class="collaborator">
          <span class="user"><?= ucfirst($collaborator['username']) ?></span>
          <form method="POST" action="../actions/action_remove_collaborator.php">
            <input type="hidden" name="username" value="<?=$collaborator['username']?>">
            <input type="submit" name="remove_button" value="Remove Collaborator">
          </form>
        </article>
    <?php }
    } ?>
  </section>
<?php } ?>