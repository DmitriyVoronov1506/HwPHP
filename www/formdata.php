<h2>Формы. Данные форм.</h2>

<form method="get">
  <label>Введите строку: <input name="str" /></label>
  <br/>
  <button>Послать GET</button>
</form>

<form method="post">
  <label>Введите строку: <input name="strp" /></label>
  <br/>
  <button>Послать POST</button>
</form>

<form method="post" enctype="multipart/form-data">

  <label>файл: <input type="file" name="formfile" /></label>
  <br/>
  <label>Введите описание: <input name="descr" value="A file" /></label>
  <label>Введите описание: <input disabled name="bescr" value="B file" /></label>
  <br/>
  <button>Послать файл</button>

</form>

<p>
    Все GET-параметры (передаваемые в адресной строке после ?)
    собираются в глобальный массив $_GET, доступный в любой части кода
    <br/>
    $_GET: <?php print_r( $_GET ) ?>
</p>

<p>
    POST-данные передаются в теле запроса, в адресной строке их
    не видно. Значения попадают в массив 
    <br/>  
    $_POST: <?php print_r( $_POST ) ?>
    <br/>
    GET- и POST- данные могут приходить одновременно, но только 
    не GET-запросом (он не должен иметь тела)
</p>

<p>
    Массив $_REQUEST является объединением GET- и POST- данных
    но для использования не рекомендуется
    <br/>
    $_REQUEST: <?php print_r( $_REQUEST ) ?>
</p>

<p>
    <pre>
        Данные о загруженных (переданных формой) файлах
        собираются в отдельном глобальном массиве
        $_FILES: <?php print_r( $_FILES ) ?>
    </pre>

    Файлы, передаваемые формой, сохраняются в временной папке
    сервера и удаляются после обработки запроса. Если файл нужен
    на постоянной основе, то его необходимо перенести (скопировать)
    в постоянную папку. 
</p>

<?php
        $extantions = ['jpg', 'jpeg', 'png', 'gif'];

        if(isset($_FILES['formfile'])) { // Передача есть

            if( $_FILES['formfile']['error'] === 0 ) {  // Нет ошибки

                if( $_FILES['formfile']['size'] > 0 ) { // Есть данные

                    $full_path = $_FILES['formfile']['full_path'];
                    $position = strrpos( $full_path, '.' ) ;
                    $extension = substr( $full_path, $position + 1 ) ;

                    if(in_array($extension, $extantions)) { // Присутствие в массиве значения

                        move_uploaded_file( 
                            $_FILES['formfile']['tmp_name'],
                            './uploads/' . $_FILES['formfile']['name'] 
                        );

                        echo "<b class=\"filechecker\"> Operation finished successfully!</b>";
                    } 
                    else {
                        echo "<b class=\"filechecker\">'$extension' invalid format. You can send only pictures!<b>";
                    }
                } 
            } 
            else {
                echo "<b class=\"filechecker\"> Error!<b>";
            }
        } 
        
        echo '<br /><br />'
        
?>
