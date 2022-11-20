<h1>Основы языка PHP</h1>
<h2>Общая характеристика</h2>
<P>
    Процедурный язык интерпретируемого типа. Типизация - динамическая. 
    Есть поддержка ООП. Однопоточный. Есть расширения для многопоточных вариантов, но они менее популярны.
</p>
<h2>Переменные</h2>
<P>
    Переменные появляются в момент первого присваивания. 
    Имя переменной обязательно начинается с "$". Область видимости переменной - глобальная. Функции создают свои области видимости. 
    Видимость переменной не ограничивается файлом, все подключенные файлы видят переменные. 
</p>
<P>
    isset(имя) - проверяет определена ли переменная (не создавая ошибку обращения к несуществующей переменной). 
</p>
<div style="border: 1px solid green">
    <?php 
        $x = 20;
        $x += 10;
        $x .= '.'; // строковый "+" - "."
        $x .= '12';
    
        if(isset($x)) {
            echo "X already defined: $x", is_numeric($x) ? "Numeric" : "NaN";
        }
        else{
            print('<script>console.log("X not defined")</script>');
            echo "X not defined";
        } ;
        // Arrays
        echo "<br />";
        $arr = []; // Новый стиль
        $arr2 = array(); // Старый стиль
        $arr[] = 10;   // push (добавление в массив)
        $arr[] = 20;
        $arr[] = 30;
        foreach($arr as $val){
            echo "$val <br />";
        }
        $arr[10] = 'ten';
        $arr['five'] = 5;
        $arr[] = 'next';
        $arr['2'] = 200;        // 2 число и '2' строка - одно и тоже
        $arr[true] = 'true';    // true == 1
        $arr['true'] = true;
        
        foreach($arr as $key => $val){
            echo "arr[$key] = $val <br />";
        }
        $arr3 = [
            'host' => 'localhost',
            'ip' => '127.0.0.1',
            'auth' => [
                'user' => 'admin',
                'pass' => '123'
            ]
            
        ];
        echo count($arr3), '<br />';
        foreach($arr3 as $key => $val){
            if(is_array($val)){
                foreach($val as $k => $v){
                    echo "arr[$key][$k] = $v <br />";
                }
            }
            else{
                echo "arr[$key] = $val <br />";
            }
        }
        // $arr3['auth']['pass']
        const CONST_VALUE = 100500;
        echo CONST_VALUE, '<br />';
        echo makeHello(), ' ', makeHello("User"), '<br />';
        function makeHello($user = "Admin"){
            global $x;
            return "Hello $user" . CONST_VALUE . $x;            // константы доступны, переменные нет (надо указать global)
        }
    ?>
</div>
