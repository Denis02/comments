    <div class="col-sm-8">
        <div class="panel panel-white post panel-shadow">
            <div class="post-heading">
                <div class="pull-left image">
                    <img src="http://bootdey.com/img/Content/user_1.jpg" class="img-circle avatar" alt="user profile image">
                </div>
                <div class="pull-left meta">
                    <div class="title h5">
                        <b><?=$comment['user_name']?></b>
                        (<?=$comment['date']?>)
                    </div>
                </div>
            </div>
            <div class="post-description">
                <p><?=$comment['text']?></p>
                <div class="stats">
                    <a href="#" class="btn btn-default stat-item">
                        <i class="glyphicon glyphicon-thumbs-up"></i> 2
                    </a>
                    <a href="#" class="btn btn-default stat-item">
                        <i class="glyphicon glyphicon-thumbs-down"></i> 12
                    </a>
                </div>
            </div>
        </div>
    </div>
