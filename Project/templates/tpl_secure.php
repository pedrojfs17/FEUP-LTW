<?php function drawConfirmationForm($title, $message) { ?>
  <div class="confirmationForm">
    <span class="close-confirmation" title="Close">&times;</span>
    <div class="form-content">
      <h1><?=$title?></h1>
      <p><?=$message?></p>
      <div class="clearfix">
        <button class="cancelbtn confirmationBtn">Cancel</button>
        <button class="confirmbtn confirmationBtn">Yes, I'm sure</button>
      </div>
    </div>
  </div>
<?php } ?>