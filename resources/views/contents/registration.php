<div class="row login-form">
    <div class="col-md-12">
        <form class="form-horizontal" method="POST">
            <fieldset>
                <legend><h1><small>Реєстрація на сайті</small></h1></legend>
                <div class="form-group">
                    <label class="control-label col-sm-2">Ім'я:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="name" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2">E-mail:</label>
                    <div class="col-sm-10">
                        <input type="email" class="form-control" name="email" placeholder="e-mail" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2">Пароль:</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" name="password" placeholder="пароль" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" >Підтвердження пароля:</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" name="password_confirmation" placeholder="пароль" required>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary btn-md">Відправити</button>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
</div>