
<div class="container">

    <?php if(isset($_SESSION['user'])): ?>
        <form method="POST">
            <div class="form-group">
                <label for="comment">Залишити коментар:</label>
                <textarea name="text" class="form-control" rows="5" id="comment"></textarea>
                <br>
                <input type="submit"  class="btn btn-primary btn-block">
                <br>
            </div>
        </form>
    <?php else: ?>
        <div class="alert alert-warning">
            Щоб <b>залишити коментар</b> потрібно
            <b><a href="/login">авторизуватися</a></b> або
            <b><a href="/registration">зареєструватися</a></b> на сайті!
        </div>
    <?php endif; ?>

    <div id="comments">
        <?php if( isset($data['comments']))
        foreach ($data['comments'] as $comment): ?>
    <hr>
        <div class="row bg-info">
            <div class="col-sm-8">
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

                        <?php if(isset($_SESSION['user']) && $comment->isMy(unserialize($_SESSION['user']))): ?>
                            <div class="form-group" style="display:none">
                                <label for="comment">Радагувати коментар:</label>
                                <textarea name="text" class="form-control" rows="5" id="comment"><?=$comment->text?></textarea>
                                <button  class="btn btn-primary btn-block" onclick="editComment(this,<?=$comment->id?>)">Відправити</button>
                                <br>
                            </div>
                            <div class="stats">
                                <span class="btn btn-default stat-item disabled">
                                    <i class="glyphicon glyphicon-thumbs-up"></i> 2
                                </span>
                                <span class="btn btn-default stat-item disabled">
                                    <i class="glyphicon glyphicon-thumbs-down"></i> 12
                                </span>
                                <div class="btn-group pull-right">
                                    <button class="btn btn-primary" onclick="showEdit(this)">Редагувати</button>
                                    <button class="btn btn-danger" onclick="deleteComment(this,<?=$comment->id?>)">Видалити</button>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="stats">
                                <a href="#" class="btn btn-default stat-item">
                                    <i class="glyphicon glyphicon-thumbs-up"></i> 2
                                </a>
                                <a href="#" class="btn btn-default stat-item">
                                    <i class="glyphicon glyphicon-thumbs-down"></i> 12
                                </a>
                                <?php if(isset($_SESSION['user'])): ?>
                                <button class="btn btn-primary pull-right" onclick="showAddAnswer(this)">Відповісти</button>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>

                    </div>
                </div>
                <div class="form-group" style="display:none">
                    <label for="comment">Відповісти на коментар:</label>
                    <textarea name="text" class="form-control" rows="5" id="comment"></textarea>
                    <button  class="btn btn-primary btn-block" onclick="addAnswer(this,<?=$comment->id?>)">Відправити</button>
                    <br>
                </div>

                <div class="answers">
                    <?php if( isset($comment->comments) && count($comment->comments)>0)
                    echo '<p>Відповіді:</p>';
                    foreach ($comment->comments as $comment2): ?>
                    <div class="row">
                        <div class="col-sm-8">
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

                                    <?php if(isset($_SESSION['user']) && $comment2->isMy(unserialize($_SESSION['user']))): ?>
                                        <div class="form-group" style="display:none">
                                            <label for="comment">Радагувати коментар:</label>
                                            <textarea name="text" class="form-control" rows="5" id="comment"><?=$comment2->text?></textarea>
                                            <button  class="btn btn-primary btn-block" onclick="editComment(this,<?=$comment2->id?>)">Відправити</button>
                                            <br>
                                        </div>
                                        <div class="stats">
                                            <span class="btn btn-default stat-item disabled">
                                                <i class="glyphicon glyphicon-thumbs-up"></i> 2
                                            </span>
                                            <span class="btn btn-default stat-item disabled">
                                                <i class="glyphicon glyphicon-thumbs-down"></i> 12
                                            </span>
                                            <div class="btn-group pull-right">
                                                <button class="btn btn-primary" onclick="showEdit(this)">Редагувати</button>
                                                <button class="btn btn-danger" onclick="deleteComment(this,<?=$comment2->id?>)">Видалити</button>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <div class="stats">
                                            <a href="#" class="btn btn-default stat-item">
                                                <i class="glyphicon glyphicon-thumbs-up"></i> 2
                                            </a>
                                            <a href="#" class="btn btn-default stat-item">
                                                <i class="glyphicon glyphicon-thumbs-down"></i> 12
                                            </a>
                                        </div>
                                    <?php endif; ?>

                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    <?php if($comment->comments_count >2): ?>
                    <button class="btn btn-primary btn-block" onclick="showAllAnswers(this,<?=$comment->id?>,<?=$comment->comments_count?>)">Всі відповіді</button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <hr>
        <?php endforeach; ?>
    </div>
</div>

<script type="text/javascript">
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
                            $("#comments").append(
                                '<div class="panel panel-white post panel-shadow">'+
                                '<div class="post-heading">'+
                                '<div class="pull-left image">'+
                                '<img src="http://bootdey.com/img/Content/user_1.jpg" class="img-circle avatar" alt="user profile image">'+
                                '</div>'+
                                '<div class="pull-left meta">'+
                                '<div class="title h5">'+
                                '<b>'+data.user.name+'</b> ('+
                                data.created_at+')'+
                                '</div></div></div>'+
                                '<div class="post-description">'+
                                '<p>'+data.text+'</p>'+
                                '<div class="stats">'+
                                '<a href="#" class="btn btn-default stat-item">'+
                                '<i class="glyphicon glyphicon-thumbs-up"></i></a>'+
                                '<a href="#" class="btn btn-default stat-item">'+
                                '<i class="glyphicon glyphicon-thumbs-down"></i></a>'+
                                '</div></div></div>'
                            );
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
//Изменение комментария
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
//Удаление комментария
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
                        /* Отбираем по идентификатору блок с комментариями и дозаполняем его новыми данными */
                        jQuery(el).parent().append(
                            '<div class="panel panel-white post panel-shadow">'+
                            '<div class="post-heading">'+
                            '<div class="pull-left image">'+
                            '<img src="http://bootdey.com/img/Content/user_1.jpg" class="img-circle avatar" alt="user profile image">'+
                            '</div>'+
                            '<div class="pull-left meta">'+
                            '<div class="title h5">'+
                            '<b>'+data.user.name+'</b> ('+
                            data.created_at+')'+
                            '</div></div></div>'+
                            '<div class="post-description">'+
                            '<p>'+data.text+'</p>'+
                            '<div class="stats">'+
                            '<a href="#" class="btn btn-default stat-item">'+
                            '<i class="glyphicon glyphicon-thumbs-up"></i></a>'+
                            '<a href="#" class="btn btn-default stat-item">'+
                            '<i class="glyphicon glyphicon-thumbs-down"></i></a>'+
                            '</div></div></div>'
                        );
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
//            text.prev('p').css('display', 'none');
        }
        else {
            text.css('display', 'none');
//            text.prev('p').css('display', 'block');
        }
    }
//Добавление нового ответа к комментарию
    function addAnswer(el, id) {
        var text=jQuery(el).prev('textarea').val();
        console.log([id,text]);
        $.ajax({
            url: '/add-answer',
            type: 'POST',
            data: {commentId: id, commentText: text},
            success: function (res) {
                var data = jQuery.parseJSON(res);
                if (data) {
                        jQuery(el).parent().next('div').prepend(
                            '<div class="panel panel-white post panel-shadow">'+
                            '<div class="post-heading">'+
                            '<div class="pull-left image">'+
                            '<img src="http://bootdey.com/img/Content/user_1.jpg" class="img-circle avatar" alt="user profile image">'+
                            '</div>'+
                            '<div class="pull-left meta">'+
                            '<div class="title h5">'+
                            '<b>'+data.user.name+'</b> ('+
                            data.created_at+')'+
                            '</div></div></div>'+
                            '<div class="post-description">'+
                            '<p>'+data.text+'</p>'+
                            '<div class="stats">'+
                            '<a href="#" class="btn btn-default stat-item">'+
                            '<i class="glyphicon glyphicon-thumbs-up"></i></a>'+
                            '<a href="#" class="btn btn-default stat-item">'+
                            '<i class="glyphicon glyphicon-thumbs-down"></i></a>'+
                            '</div></div></div>'
                        );
                    jQuery(el).parent().css('display', 'none');
                }
            },
            error: function (msg) {
                console.log(msg);
            }
        });
    }

</script>