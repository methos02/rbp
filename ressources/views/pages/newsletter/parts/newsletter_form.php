<div class="row div-mail-news margin-updown">
    <div class="container">
        <div class="row">
            <div class="col-sm-11 col-md-10 col-md-offset-1 reference">
                <label for="news_mail">S'inscrire pour être prévenu des nouvelles news</label>
                <?php if (!isset($_COOKIE['div_mail_news'])): ?>
                    <a href="" class="message-close div-mail-close" data-action="close-news-mail"><span class="glyphicon glyphicon-remove" ></span></a>
                <?php endif; ?>
            </div>
        </div>
        <div class="row">
            <form class="form-mail-news">
                <div class="col-sm-6 col-md-offset-1">
                    <input type="text" class="form-control margin-updown" name="mail" id="news_mail" placeholder="Adresse Email" data-type="mail" data-obliger="1">
                    <input type="submit" class="btn btn-primary hidden-xs" value="S'incrire" data-verif="form-mail-news">
                </div>
                <div class="col-sm-5">
                    <div class="g-recaptcha" data-sitekey="<?php echo SITE_CLE ?>" style="transform:scale(0.77);transform-origin:0 0"></div>
                    <input type="submit" class="btn btn-primary visible-xs" value="S'incrire" data-verif="form-mail-news">
                </div>
            </form>
        </div>
    </div>
</div>
