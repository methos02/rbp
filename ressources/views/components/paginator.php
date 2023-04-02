<?php
if(!isset($count, $per_page) || $count == 0) return '';

use App\Core\Request;
use App\Helpers\Html;

$count_page = ceil($count / $per_page);
$page = Request::get('page');
?>

<div class="paginator" data-component="paginator" data-paginator="news">
    <button class="paginator_btn" data-page="0"<?= Html::disabled($page == 0)?>> << </button>
    <button class="paginator_btn" data-page="<?= $page > 0 ? $page - 1: 0 ?>"<?= Html::disabled($page == 0)?>> < </button>
    <label class="paginator_label">
        <input name="page_count" class="paginator_input" placeholder="<?= $page + 1 ?>">
        <span class="paginator_span">/ <?= $count_page ?></span>
    </label>
    <button class="paginator_btn" data-page="<?= $page != 0 ? $page + 1 : 1 ?>"<?= Html::disabled($page + 1 == $count_page)?>> > </button>
    <button class="paginator_btn" data-page="<?= $count_page - 1 ?>"<?= Html::disabled($page + 1 == $count_page)?>> >> </button>
</div>

