<h1><?= count($comments)?> Comments</h1>
<?php foreach ($comments as $comment) {?>
<article class="comment">
    <span class="user"><?= ucfirst($comment['username'])?></span>
    <span class="date"><?= date(DATE_RSS, $comment['published'])?></span>
    <p><?= $comment['text']?></p>
</article>
<?php }?>