<?php
// одна из задача контроллера - разделить работу по методам запроса
// echo "<pre>" ; print_r( $_SERVER ) ;

$reg_error = [
    'login_err' => [
        0 => 'Login is empty',
        1 => 'Login length must be > 3',
        2 => 'Login exists'
    ],
    'userName_err' => [
        0 => 'Username is empty',
        1 => 'Username cant have spaces'
    ],
    'password_err' => [
        0 => 'Empty password',
        1 => 'Password need minimum 8 characters'
    ],
    'confirm_err' => [
        0 => 'Passwords are different'
    ],
    'email_err' => [
        0 => 'Email is empty',
        1 => 'Email is not like the email pattern'
    ],
    'f_err' => [
        0 => 'Wrong type',
        1 => "Invalid extension",
        2 => 'Upload error'
    ]
];


@session_start() ; // сессии - перед обращением к сессии обязательно. $_SESSION[] - формируется стартом
switch( strtoupper( $_SERVER[ 'REQUEST_METHOD' ] ) ) {
case 'GET'  :
    $view_data = [] ;
    if( isset( $_SESSION[ 'reg_error' ] ) ) {
        $view_data['reg_error'] = $_SESSION[ 'reg_error' ] ;
        unset( $_SESSION[ 'reg_error' ] ) ;
        // при ошибке сохраняются введенные данные - восстанавливаем
        $view_data['login']    = $_SESSION[ 'login' ] ;
        $view_data['email']    = $_SESSION[ 'email' ] ;
        $view_data['userName'] = $_SESSION[ 'userName' ] ;
    }
    if( isset( $_SESSION[ 'reg_ok' ] ) ) {
        $view_data['reg_ok'] = $_SESSION[ 'reg_ok' ] ;
        unset( $_SESSION[ 'reg_ok' ] ) ;
    }
    include "_layout.php" ;  // ~return View
    break ;

case 'POST' :
    // данные формы регистрации - обрабатываем
    if( empty($_POST['login'])) {
        $_SESSION['reg_error'] = $reg_error['login_err'][0] ;
    }
    else if (strlen($_POST['login']) < 3 ) {
        $_SESSION['reg_error'] = $reg_error['login_err'][1] ;
    }
    else if (empty($_POST['userName'])) {
        $_SESSION['reg_error'] = $reg_error['userName_err'][0] ;
    }
    else if(empty( $_POST['userPassword1'])) {
        $_SESSION['reg_error'] = $reg_error['password_err'][0] ;
    }
    else if (!preg_match( "/^(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/", $_POST['userPassword1'])) {
        $_SESSION['reg_error'] = $reg_error['password_err'][1] ;
    }
    else if($_POST['userPassword1'] !== $_POST['confirm']) {
        $_SESSION['reg_error'] = $reg_error['confirm_err'][0] ;
    } 
    else if(empty( $_POST['email'])) {
        $_SESSION['reg_error'] = $reg_error['email_err'][0] ;
    }
    else if(!preg_match( "/^[A-z][A-z\d_]{3,16}@([a-z]{1,10}\.){1,5}[a-z]{2,3}$/", $_POST['email'])) {
        $_SESSION['reg_error'] = $reg_error['email_err'][1] ;
    } 
    else {
        try {
            $prep = $connection->prepare( 
                "SELECT COUNT(id) FROM Users u WHERE u.`login` = ? " ) ;
            $prep->execute( [ $_POST['login'] ] ) ;
            $cnt = $prep->fetch( PDO::FETCH_NUM )[0] ;
        }
        catch( PDOException $ex ) {
            $_SESSION['reg_error'] = $ex->getMessage();
        }
        if( $cnt > 0 ) {
            $_SESSION['reg_error'] = $reg_error['login_err'][2];
        }

        // Проверяем наличие аватарки и загружаем файл:
        // Берем имя файла, отделяем расширение, проверяем на допустимые (изображения)
        // сохраняем расширение, но меняем имя файла (генерируем случайно)
        //  использовать переданные имена опасно (возможный конфликт - перезапись,
        //  возможные DT-атаки со спецсимволами в именах файлов (../../) )
        // Файлы храним в отдельной папке, их имена (с расширениями) - в БД

        if( isset( $_FILES['avatar'] ) ) {  // наличие файлового поля на форме
            if( $_FILES['avatar']['error'] == 0 && $_FILES['avatar']['size'] != 0 ) {
                // есть переданный файл
                $dot_position = strrpos( $_FILES['avatar']['name'], '.' ) ;  // strRpos ~ lastIndexOf
                if( $dot_position == -1 ) {  // нет расширения у файла
                    $_SESSION[ 'reg_error' ] = $reg_error['f_err'][0]
                }
                else {
                    $extension = substr( $_FILES['avatar']['name'], $dot_position ) ;  // расширение файла (с точкой ".png")
                    if( ! in_array( $extension, ['.png','.jpg','.gif','.jpeg','.svg'] ) ) {
                        $_SESSION[ 'reg_error' ] = $reg_error['file_err'][1] ;
                    }
                    else {
                        $avatar_name = $_FILES['avatar']['name'] ;
                        // убеждаемся, что в имени файла нету ../ (защита от DT)
                        if(str_contains($avatar_name, '../')) $avatar_name = str_replace('../', '', $avatar_name);

                        $avatar_path = 'avatars/' ;

                        do {
                            $avatar_name = bin2hex(random_bytes(8)) . $extension ;
                        } while( file_exists( $avatar_path . $avatar_name ) ) ;

                        if( ! move_uploaded_file( $_FILES['avatar']['tmp_name'], $avatar_path . $avatar_name ) )
                            $_SESSION[ 'reg_error' ] = $reg_error['file_err'][2] ;
                    }
                }

            }
        }
    }
    }

    if( empty( $_SESSION[ 'reg_error' ] ) ) {
        // подключаем фукнцию отправки почты
        @include_once "helper/send_email.php" ;
        if( ! function_exists( "send_email" ) ) {
            $_SESSION[ 'reg_error' ] = "Inner error" ;
        }
    }

    if( empty( $_SESSION[ 'reg_error' ] ) ) {  // не было ошибок выше
        // $_SESSION[ 'reg_error' ] = "OK" ;
        $salt = md5( random_bytes(16) ) ;
        $pass = md5( $_POST['confirm'] . $salt ) ;
        $confirm_code = bin2hex( random_bytes(3) ) ;

        send_email( $_POST['email'], 
            "pv011.local Email verification", 
            "<b>Hello, {$_POST['userName']}</b><br/>
            Type code <strong>$confirm_code</strong> to confirm email<br/>
            Or follow next <a href='https://myhw.local/confirm?code={$confirm_code}&email={$_POST['email']}'>link</a>" ) ;

        $sql = "INSERT INTO Users(`id`,`login`,`name`,`salt`,`pass`,`email`,`confirm`,`avatar`)
        VALUES(UUID(),?,?,'$salt','$pass',?,'$confirm_code',?)" ;
        try {
            $prep = $connection->prepare( $sql ) ;
            $prep->execute( [ $_POST['login'], $_POST['userName'], $_POST['email'], isset( $avatar_name ) ? $avatar_name : null ] ) ;
            $_SESSION[ 'reg_ok' ] = "Reg ok" ;
        }
        catch( PDOException $ex ) {
            $_SESSION[ 'reg_error' ] = $ex->getMessage() ;
        }
    }
    else {  // были ошибки - сохраняем в сессии все введенные значения (кроме пароля)
        $_SESSION['login']    = $_POST['login'] ;
        $_SESSION['email']    = $_POST['email'] ;
        $_SESSION['userName'] = $_POST['userName'] ;
    }

    // echo "<pre>" ; print_r( $_POST ) ;
    // на запросы кроме GET (кроме API) всегда возвращается redirect
    header( "Location: /" . $path_parts[1] ) ;
    break ;
}
