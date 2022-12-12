<div class="wrapper">
    <main>
        <?php if( isset( $view_data['reg_error'] ) ) : ?>
            <div class="reg-error"><?= $view_data['reg_error'] ?></div>
        <?php endif ?>

        <?php if( isset( $view_data['reg_ok'] ) ) : ?>
            <div class="reg-ok"><?= $view_data['reg_ok'] ?></div>
        <?php endif ?>

        <div class="reg-form-container">
            <div class="reg-form">
                <div class="reg-form-title">Create Account</div>

                <?php if( isset($view_data['reg_error']) && !(in_array($view_data['reg_error'], $reg_error['login_err']) 
                    || in_array($view_data['reg_error'], $reg_error['userName_err']) || in_array($view_data[ 'reg_error'], $reg_error['password_err'])
                    || in_array($view_data['reg_error'], $reg_error['confirm_err']) || in_array($view_data[ 'reg_error'], $reg_error['email_err']))) : ?>

                    <div class="reg-error"><?= $view_data['reg_error'] ?></div>
                    
                <?php endif ?>

                <form class="registerForm" method="post" enctype="multipart/form-data">
                    <div class="reg-form-control-wrapper">
                        <div class="reg-form-control">
                            <label for="login">Login</label>
                            <input name="login" value='<?= (isset($view_data['login'])) ? $view_data['login'] : "" ?>'  />

                            <?php if(isset($view_data['reg_error' ]) && in_array($view_data[ 'reg_error' ], $reg_error[ 'login_err' ] ) ) : ?>
                                <div class="reg-error"><?= $view_data[ 'reg_error' ] ?></div>
                            <?php endif ?>

                        </div>
                    </div>
                    <div class="reg-form-control-wrapper">
                        <div class="reg-form-control">
                            <label for="userName">Username</label>
                            <input name="userName" value='<?= (isset($view_data['userName'])) ? $view_data['userName'] : "" ?>' />

                            <?php if( isset( $view_data[ 'reg_error' ] ) && in_array( $view_data[ 'reg_error' ], $reg_error[ 'userName_err' ] ) ) : ?>
                                 <div class="reg-error"><?= $view_data[ 'reg_error' ] ?></div>
                            <?php endif ?>

                        </div>
                    </div>
                    <div class="reg-form-control-wrapper">
                        <div class="reg-form-control">
                            <label for="userPassword1">Password</label>
                            <input type="password" name="userPassword1" required />

                            <?php if( isset( $view_data[ 'reg_error' ] ) && in_array( $view_data[ 'reg_error' ], $reg_error[ 'password_err' ] ) ) : ?>
                                 <div class="reg-error"><?= $view_data[ 'reg_error' ] ?></div>
                             <?php endif ?>

                        </div>
                    </div>
                    <div class="reg-form-control-wrapper">
                        <div class="reg-form-control">
                            <label for="confirm">Confirm Password</label>
                            <input type="password" name="confirm" />

                            <?php if( isset( $view_data[ 'reg_error' ] ) && in_array( $view_data[ 'reg_error' ], $reg_error[ 'confirm_err' ] ) ) : ?>
                                <div class="reg-error"><?= $view_data[ 'reg_error' ] ?></div>
                            <?php endif ?>

                        </div>
                    </div>
                    <div class="reg-form-control-wrapper">
                        <div class="reg-form-control">
                            <label for="email">Email</label>
                            <input type="email" name="email" required value='<?= (isset($view_data['email'])) ? $view_data['email'] : "" ?>' />

                            <?php if( isset( $view_data[ 'reg_error' ] ) && in_array( $view_data[ 'reg_error' ], $reg_error[ 'email_err' ] ) ) : ?>
                                <div class="reg-error"><?= $view_data[ 'reg_error' ] ?></div>
                             <?php endif ?>

                        </div>
                    </div>
                    <div class="reg-form-control-wrapper">
                        <div class="reg-form-control">
                            <label for="email">Avatar</label>
                            <input type="file" name="avatar" />

                            <?php if( isset( $view_data[ 'reg_error' ] ) && in_array( $view_data[ 'reg_error' ], $reg_error[ 'file_err' ] ) ) : ?>
                                <div class="reg-error"><?= $view_data[ 'reg_error' ] ?></div>
                            <?php endif ?>
                            
                        </div>
                    </div>
                    <button class="reg-button">Registration</button>
                </form>
            </div>
        </div>
    </main>
</div>