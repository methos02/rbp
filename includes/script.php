<script src="/jQuery.js"></script>
<script src="/vendor/ckeditor/ckeditor.js" ></script>
<script src="/vendor/ckeditor/adapters/jquery.js" ></script>
<script src="/bootstrap.min.js"></script>
<?php if (strpos ( $_SERVER['PHP_SELF'], 'photo') !== false) { ?>
    <script src="/lightgallery.min.js"></script>
    <script src="/lg-thumbnail.min.js"></script>
<?php } ?>
<script src="/core.js"></script>
<script src="/form.js"></script>
<?php if ($log['droit'] >= Droit::REDAC) { ?>
    <script src="/admin.js"></script>
<?php } ?>