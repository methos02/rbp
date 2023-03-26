<?php
if(!isset($count, $per_page) || $count == 0) return '';

use App\Core\Request;
use App\Helpers\Html;

$count_page = ceil($count / $per_page);
$page = Request::get('page');
?>

<div class="paginator">
    <button class="paginateur-fleche" data-page="0"<?= Html::disabled(is_null($page) || $page == 0)?>> << </button>
    <button class="paginateur-fleche" data-page="<?= !is_null($page) && $page > 0 ? $page - 1 : 0 ?>"<?= Html::disabled(is_null($page) || $page == 0)?>> < </button>
    <label class="paginateur-input">
        <input name="page_count" class="paginateur" placeholder="<?= $page ?>"> / <?= $count_page ?>
    </label>
    <button class="paginateur-fleche" data-page="<?= !is_null($page) ? $page + 1 : 1 ?>"<?= Html::disabled(!is_null($page) && $page + 1 == $count_page)?>> > </button>
    <button class="paginateur-fleche" data-page="<?= $count_page - 1 ?>"<?= Html::disabled(!is_null($page) && $page + 1 == $count_page)?>> >> </button>
</div>

