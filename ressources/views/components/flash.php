<?php
if(isset($_SESSION['flash'])){
    $flash = $_SESSION['flash'];
    unset($_SESSION['flash']);
}
?>
<div id="container-flashes" class="message">
    <?php if(isset($flash)): ?>
        <div class="alert alert-<?= $flash['type'] ?> message-unique" style="display:none" id="message-flash">
            <div class="message-title"><?= $flash['title'] ?></div>
            <div class="message-content"><?=  $flash['content'] ?? '' ?></div>
            <a href="" class="message-close" data-action="message-close"><span class="glyphicon glyphicon-remove" ></span></a>
        </div>
    <?php endif; ?>
</div>
