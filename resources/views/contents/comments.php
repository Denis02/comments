<!--Проверка авторизирован ли пользователь-->
<?php
    if(isset($_SESSION['user']))
        $auth_user = unserialize($_SESSION['user']);
?>


<div class="container">

<!--Отобразить форму создания комментария для авторизированного пользователя-->
    <?php if(isset($auth_user)): ?>
        <form method="POST">
            <div class="form-group">
                <label for="comment">Залишити коментар:</label>
                <textarea name="text" class="form-control" rows="5" id="comment"></textarea>
                <br>
                <input type="submit"  class="btn btn-primary btn-block">
                <br>
            </div>
        </form>
<!--Отобразить ссылки на страницы авторизации и регистрации для не авторизированного пользователя-->
    <?php else: ?>
        <div class="alert alert-warning">
            Щоб <b>залишити або оцінити коментар</b> потрібно
            <b><a href="/login">авторизуватися</a></b> або
            <b><a href="/registration">зареєструватися</a></b> на сайті!
        </div>
    <?php endif; ?>

<!--Вывод десяти последних комментариев-->
    <div id="comments">
        <?php if( isset($data['comments']))
        foreach ($data['comments'] as $comment): ?>
<!--Комментарий содержит: имя пользователя, дату и время создания, текст, функциональные кнопки (описаны ниже) и ответы на комментарий (вложенные комментарии)-->
        <div class="row bg-info">
                <div class="panel panel-white post panel-shadow">
                    <div class="post-heading">
                        <div class="pull-left image">
                            <img src="http://bootdey.com/img/Content/user_1.jpg" class="img-circle avatar" alt="user profile image">
                        </div>
                        <div class="pull-left meta">
                            <div class="title h5">
                                <b><?=$comment->user->name?></b>
                                (<?=$comment->created_at?>)
                            </div>
                        </div>
                    </div>
                    <div class="post-description">
                        <p><?=$comment->text?></p>
<!--Если комментарий написан авторизированным пользователем отобразить:-->
                        <?php if(isset($auth_user) && $comment->isMy($auth_user)): ?>
<!--форма для редактирования комментария -->
                            <div class="form-group" style="display:none">
                                <label for="comment">Редагувати коментар:</label>
                                <textarea name="text" class="form-control" rows="5" id="comment"><?=$comment->text?></textarea>
                                <button  class="btn btn-primary btn-block" onclick="editComment(this,<?=$comment->id?>)">Відправити</button>
                                <br>
                            </div>
                            <div class="stats">
<!--неактивные кнотки оценок комментария-->
                                <span class="btn btn-default stat-item disabled">
                                    <i class="glyphicon glyphicon-thumbs-up"></i> <?= count($comment->rating['plus']) ?>
                                </span>
                                <span class="btn btn-default stat-item disabled">
                                    <i class="glyphicon glyphicon-thumbs-down"></i> <?= count($comment->rating['minus']) ?>
                                </span>
<!--кнопки для отображения формы редактирования комментария и удаления комментария-->
                                <div class="btn-group pull-right">
                                    <button class="btn btn-primary" onclick="showEdit(this)">Редагувати</button>
                                    <button class="btn btn-danger" onclick="deleteComment(this,<?=$comment->id?>)">Видалити</button>
                                </div>
                            </div>
<!--Если комментарий написан другим пользователем отобразить:-->
                        <?php else: ?>
                            <div class="stats">
<!--кнопки для оценки комментария (если авторизированный пользователь уже поставил оценку данному комментарию то пометить соответсвующую кнопку)-->
                                <span class="btn stat-item
                                      <?php if(isset($auth_user) && in_array($auth_user->getId(),$comment->rating['plus']))
                                          echo 'btn-success'; else echo 'btn-default';?> "
                                      onclick="clickRating(this, <?=$comment->id?>, true)">
                                    <i class="glyphicon glyphicon-thumbs-up"></i> <span><?= count($comment->rating['plus']) ?></span>
                                </span>
                                <span class="btn stat-item
                                      <?php if(isset($auth_user) && in_array($auth_user->getId(),$comment->rating['minus']))
                                         echo 'btn-danger'; else echo 'btn-default';?> "
                                      onclick="clickRating(this, <?=$comment->id?>, false)">
                                    <i class="glyphicon glyphicon-thumbs-down"></i> <span><?= count($comment->rating['minus']) ?></span>
                                </span>
<!--кнопка для отображения формы написания ответа на комментарий (вложенного комментария)-->
                                <?php if(isset($auth_user)): ?>
                                <button class="btn btn-primary pull-right" onclick="showAddAnswer(this)">Відповісти</button>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>

                    </div>
                </div>
<!--форма для написания ответа на комментарий -->
                <div class="form-group" style="display:none">
                    <label for="comment">Відповісти на коментар:</label>
                    <textarea name="text" class="form-control" rows="5" id="comment"></textarea>
                    <button  class="btn btn-primary btn-block" onclick="addAnswer(this,<?=$comment->id?>)">Відправити</button>
                    <br>
                </div>
<!--Вывод двух последних ответов на комментарий-->
                <div class="answers">
                    <?php if( isset($comment->comments) && count($comment->comments)>0)
                    echo '<p>Відповіді:</p>';
                    foreach ($comment->comments as $comment2): ?>
<!--Вложенные комментарии содержат аналогичный контент, но не имеют своих вложенных комментариев-->
                    <div class="row">
                            <div class="panel panel-white post panel-shadow">
                                <div class="post-heading">
                                    <div class="pull-left image">
                                        <img src="http://bootdey.com/img/Content/user_1.jpg" class="img-circle avatar" alt="user profile image">
                                    </div>
                                    <div class="pull-left meta">
                                        <div class="title h5">
                                            <b><?=$comment2->user->name?></b>
                                            (<?=$comment2->created_at?>)
                                        </div>
                                    </div>
                                </div>
                                <div class="post-description">
                                    <p><?=$comment2->text?></p>

                                    <?php if(isset($auth_user) && $comment2->isMy($auth_user)): ?>
                                        <div class="form-group" style="display:none">
                                            <label for="comment">Радагувати коментар:</label>
                                            <textarea name="text" class="form-control" rows="5" id="comment"><?=$comment2->text?></textarea>
                                            <button  class="btn btn-primary btn-block" onclick="editComment(this,<?=$comment2->id?>)">Відправити</button>
                                            <br>
                                        </div>
                                        <div class="stats">
                                            <span class="btn btn-default stat-item disabled">
                                                <i class="glyphicon glyphicon-thumbs-up"></i> <?= count($comment2->rating['plus']) ?>
                                            </span>
                                            <span class="btn btn-default stat-item disabled">
                                                <i class="glyphicon glyphicon-thumbs-down"></i> <?= count($comment2->rating['minus']) ?>
                                            </span>
                                            <div class="btn-group pull-right">
                                                <button class="btn btn-primary" onclick="showEdit(this)">Редагувати</button>
                                                <button class="btn btn-danger" onclick="deleteComment(this,<?=$comment2->id?>)">Видалити</button>
                                            </div>
                                        </div>

                                    <?php else: ?>
                                        <div class="stats">
                                            <span class="btn stat-item
                                                  <?php if(isset($auth_user) && in_array($auth_user->getId(),$comment2->rating['plus']))
                                                    echo 'btn-success'; else echo 'btn-default';?> "
                                                    onclick="clickRating(this, <?=$comment2->id?>, true)">
                                                <i class="glyphicon glyphicon-thumbs-up"></i> <span><?= count($comment2->rating['plus']) ?></span>
                                            </span>
                                            <span class="btn stat-item
                                                  <?php if(isset($auth_user) && in_array($auth_user->getId(),$comment2->rating['minus']))
                                                    echo 'btn-danger'; else echo 'btn-default';?> "
                                                    onclick="clickRating(this, <?=$comment2->id?>, false)">
                                                <i class="glyphicon glyphicon-thumbs-down"></i> <span><?= count($comment2->rating['minus']) ?></span>
                                            </span>
                                        </div>
                                    <?php endif; ?>

                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
<!--Кнопка для отображения всех ответов на комментарий-->
                    <?php if($comment->comments_count >2): ?>
                    <button class="btn btn-primary btn-block" onclick="showAllAnswers(this,<?=$comment->id?>,<?=$comment->comments_count?>)">Всі відповіді</button>
                    <?php endif; ?>
                </div>
        </div>

        <?php endforeach; ?>
    </div>
</div>


<!--Скрипты Ajax-запросов и отображения форм-->
<script type="text/javascript">

/* Проверка авторизирован ли пользователь */
    var auth_user;
    <?php if(isset($auth_user)): ?>
    auth_user = <?=json_encode($auth_user)?>;
    auth_user.id = <?=$auth_user->getId()?>
    <?php endif;?>

    $(document).ready(function(){
//Ajax-подгрузка комментариев при прокрутке страницы
        /* Переменная-флаг для отслеживания того, происходит ли в данный момент ajax-запрос */
        var inProgress = false;
        /* С какаго комментария надо делать выборку из базы при ajax-запросе */
        var startFrom = 10;

        $(window).scroll(function() {
            /* Если высота окна + высота прокрутки больше или равны высоте всего документа и ajax-запрос в настоящий момент не выполняется, то запускаем ajax-запрос */
            if($(window).scrollTop() + $(window).height() >= $(document).height() - 200 && !inProgress) {
                $.ajax({
                    url: '/',
                    method: 'POST',
                    data: {"startFrom" : startFrom},
                    beforeSend: function() {
                        /* меняем значение флага на true, т.е. запрос сейчас в процессе выполнения */
                        inProgress = true;}
                }).done(function(data){
                    /* Преобразуем результат, пришедший от обработчика - преобразуем json-строку обратно в массив */
                    data = jQuery.parseJSON(data);
                    /* Если массив не пуст, делаем проход по каждому результату, оказвашемуся в массиве*/
                    if (data) {
                        $.each(data, function(index, data){
                            /* Отбираем по идентификатору блок с комментариями и дозаполняем его новыми данными */
                            $("#comments").append($(newCommentElement(data)));
                        });
                        /* По факту окончания запроса снова меняем значение флага на false */
                        inProgress = false;
                        // Увеличиваем на 10 порядковый номер комментария, с которого надо начинать выборку из базы
                        startFrom += 10;
                    }
                });
            }
        });
    });

//Отображение формы для изменения комментария
    function showEdit(el) {
        var btn = jQuery(el).parent().parent();
        var text = btn.prev('div');
        if(text.css('display') == 'none') {
            text.css('display', 'block');
            text.prev('p').css('display', 'none');
        }
        else {
            text.css('display', 'none');
            text.prev('p').css('display', 'block');
        }
    }
//Ajax-запрос на Изменение комментария
    function editComment(el, id){
        var newText=jQuery(el).prev('textarea').val();
        $.ajax({
            url: '/edit-comment',
            type: 'POST',
            data: {commentId: id, newText: newText},
            success: function (res) {
                var btn = jQuery(el).parent();
                var text = btn.prev('p');
                btn.css('display', 'none');
                text.text(res);
                text.css('display', 'block');
            },
            error: function (msg) {
                console.log(msg);
            }
        });
    }
//Ajax-запрос на Удаление комментария
    function deleteComment(el, id){
        var newText=jQuery(el).prev('textarea').val();
        $.ajax({
            url: '/delete-comment',
            type: 'POST',
            data: {commentId: id},
            success: function (res) {
                var delEl = jQuery(el).closest('.row');
                delEl.css('display', 'none');
            },
            error: function (msg) {
                console.log(msg);
            }
        });
    }

//Ajax-подгрузка ответов к комментарию
    function showAllAnswers(el, id, count) {
        $.ajax({
            url: '/show-answers',
            type: 'POST',
            data: {commentId: id, commentCount: count},
            success: function (res) {
                var data = jQuery.parseJSON(res);
                if (data) {
                    $.each(data, function(index, data){
                        jQuery(el).parent().append($(newCommentElement(data, true)));
                    });
                    jQuery(el).css('display', 'none');
                }
            },
            error: function (msg) {
                console.log(msg);
            }
        });
    }

//Отображение формы для добавления ответа к комментарию
    function showAddAnswer(el) {
        var text = jQuery(el).closest('.post').next('div');
        if(text.css('display') == 'none') {
            text.css('display', 'block');
        }
        else {
            text.css('display', 'none');
        }
    }
///Ajax-запрос на Добавление нового ответа к комментарию
    function addAnswer(el, id) {
        var text=jQuery(el).prev('textarea').val();
        $.ajax({
            url: '/add-comment',
            type: 'POST',
            data: {commentId: id, commentText: text},
            success: function (res) {
                var data = jQuery.parseJSON(res);
                if (data) {
                        jQuery(el).parent().next('div').prepend($(newCommentElement(data,true)));
                    jQuery(el).parent().css('display', 'none');
                }
            },
            error: function (msg) {
                console.log(msg);
            }
        });
    }
//Ajax-запрос на Оценивание комментария
    function clickRating(el, id, val){
        $.ajax({
            url: '/click-rating',
            type: 'POST',
            data: {commentId: id, value: val},
            success: function (res) {
                if(res == true) {
                    jQuery(el).children('span').text(parseInt(jQuery(el).text()) + 1);
                    if(val) jQuery(el).addClass('btn-success');
                    else jQuery(el).addClass('btn-danger');
                }
            },
            error: function (msg) {
                console.log(msg);
            }
        });
    }


// Динамическое создание елемента комментария
    // принимает объект комментария - comment
    // и пометку для вложенного класса - is_answer
    function newCommentElement(comment, is_answer) {

        var main_class = 'bg-info';
        // убрать класс 'bg-info' у вложенного комментария
        if(is_answer == true) main_class = '';

        var div = '<div class="row '+main_class+'">'+
                '<div class="panel post">'+
                    '<div class="post-heading">'+
                        '<div class="pull-left image">'+
                            '<img src="http://bootdey.com/img/Content/user_1.jpg" class="img-circle avatar" alt="user profile image">'+
                        '</div>'+
                        '<div class="pull-left meta">'+
                            '<div class="title h5">'+
                            '<b>'+comment.user.name+'</b> ('+
                            comment.created_at+')' +
                            '</div>'+
                        '</div>'+
                    '</div>'+
                    '<div class="post-description">'+
                        '<p>'+comment.text+'</p>';

        if(auth_user != undefined && auth_user.email == comment.user.email){
            div += '<div class="form-group" style="display:none">'+
                '<label for="comment">Редагувати коментар:</label>'+
                '<textarea name="text" class="form-control" rows="5" id="comment">'+comment.text+'</textarea>'+
                '<button  class="btn btn-primary btn-block" onclick="editComment(this,'+comment.id+')">Відправити</button>'+
                '<br>'+
                '</div>'+
                '<div class="stats">'+
                '<span class="btn btn-default stat-item disabled">'+
                '<i class="glyphicon glyphicon-thumbs-up"></i> '+comment.rating['plus'].length+
                '</span>'+
                '<span class="btn btn-default stat-item disabled">'+
                '<i class="glyphicon glyphicon-thumbs-down"></i> '+comment.rating['minus'].length+
                '</span>'+
                '<div class="btn-group pull-right">'+
                '<button class="btn btn-primary" onclick="showEdit(this)">Редагувати</button>'+
                '<button class="btn btn-danger" onclick="deleteComment(this,'+comment.id+')">Видалити</button>'+
                '</div>'+
                '</div>';

        }else {
            var class_btn_up = ' btn-default';
            var class_btn_down = ' btn-default';
            if(auth_user != undefined && $.inArray(auth_user.id.toString(), comment.rating['plus']) != -1){
                class_btn_up = ' btn-success';}
            if(auth_user != undefined && $.inArray(auth_user.id.toString(), comment.rating['minus']) != -1){
                class_btn_down = ' btn-danger';}

            div += '<div class="stats">'+
                '<span class="btn stat-item'+
                class_btn_up+
                '" onclick="clickRating(this, '+comment.id+', true)">'+
                '<i class="glyphicon glyphicon-thumbs-up"></i> <span> '+comment.rating['plus'].length+'</span>'+
                '</span>'+
                '<span class="btn stat-item'+
                class_btn_down+
                '" onclick="clickRating(this, '+comment.id+', false)">'+
                '<i class="glyphicon glyphicon-thumbs-down"></i> <span> '+comment.rating['minus'].length+'</span>'+
                '</span>';

            if (auth_user != undefined && is_answer != true) {
                div += '<button class="btn btn-primary pull-right" onclick="showAddAnswer(this)">Відповісти</button>';
            }

            div += '</div>';
        }

        div += '</div> </div>';

        // убрать форму ответа на комментарий и список ответов у вложенного комментария
        if(is_answer != true) {
            div += '<div class="form-group" style="display:none">' +
                '<label for="comment">Відповісти на коментар:</label>' +
                '<textarea name="text" class="form-control" rows="5" id="comment"></textarea>' +
                '<button  class="btn btn-primary btn-block" onclick="addAnswer(this,' + comment.id + ')">Відправити</button>' +
                '<br>' +
                '</div>' +
                '<div class="answers">';

            if (comment.comments != undefined && comment.comments.length > 0) {
                div += '<p>Відповіді:</p>';

                // рекурсия фуекции для вложенных комментариев
                for (var sub_comment in comment.comments) {
                    div += newCommentElement(comment.comments[sub_comment], true);
                }

                if (comment.comments_count > 2) {
                    div += '<button class="btn btn-primary btn-block" onclick="showAllAnswers(this,' + comment.id + ', ' + comment.comments_count + ' )">Всі відповіді</button>';
                }
            }

            div += '</div>';
        }
        div += '</div>';

        return div;
    }

</script>