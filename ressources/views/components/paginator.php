<?php
if(!isset($count, $per_page) || $count == 0) return '';

use App\Core\Request;
use App\Helpers\Html;

$count_page = ceil($count / $per_page);
$page = Request::get('page');
?>

<div class="paginator" data-component="paginator">
    <button class="paginator_btn" data-page="0"<?= Html::disabled(is_null($page) || $page == 0)?>> << </button>
    <button class="paginator_btn" data-page="<?= !is_null($page) && $page > 0 ? $page-- : 0 ?>"<?= Html::disabled(is_null($page) || $page == 0)?>> < </button>
    <label class="paginator_label">
        <input name="page_count" class="paginator_input" placeholder="<?= $page ?>">
        <span class="paginator_span">/ <?= $count_page ?></span>
    </label>
    <button class="paginator_btn" data-page="<?= !is_null($page) ? $page++ : 1 ?>"<?= Html::disabled(!is_null($page) && $page++ == $count_page)?>> > </button>
    <button class="paginator_btn" data-page="<?= $count_page-- ?>"<?= Html::disabled(!is_null($page) && $page + 1 == $count_page)?>> >> </button>
</div>

