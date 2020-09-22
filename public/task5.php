<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Лабораторная работа №5</title>
    <link rel="stylesheet" href="styles.css"/>
</head>
<body>
<main>
<?php
    // 1 Переработать класс Table пример 3 для вывода в формате таблицы с тегами table, th, tr, td
    class Table
    {
        protected $headers = [];
        protected $data = [];
        function Table ( $headers )
        {
            $this->headers = $headers;
        }
        function addRow ( $row )
        {
            $tmp = [];
            foreach ( $this->headers as $header ) {
                if ( ! isset( $row[$header] )) $row[$header] = "";
                $tmp[] = $row[$header];
            }
            array_push ( $this->data, $tmp );
        }
        function output ()
        {
            echo "<table><tr>";
            foreach ( $this->headers as $header )
                echo "<th>$header</th>";
            echo "</tr>";

            foreach ( $this->data as $y )
            {
                echo "<tr>";
                foreach ( $y as $x )
                    echo "<td>$x</td>";
                echo "</tr>";
            }
            echo "</table>";
        }
    }

    $test1 = new Table(["a","b","c"]);
    $test1->addRow(["a"=>1,"b"=>3,"c"=>2]);
    $test1->addRow(["a"=>1,"c"=>3]);
    $test1->addRow(["c"=>1,"b"=>3,"a"=>4]);
    $test1->output();

    echo '<br />';

    // 2 Добавить закрытие тегов tr, th, td в примере 6
    class HTMLTable extends Table
    {
        public $cellpadding = "2";
        public $bgcolor;
        function HTMLTable ( $headers, $bg="FFFFFF" )
        {
            Table::Table( $headers );
            $this->bgcolor = $bg;
        }
        function setCellpadding ( $padding )
        {
            $this->cellpadding = $padding;
        }
        function output ()
        {
            echo "<table cellpadding='".$this->cellpadding."'><tr>";

            foreach ( $this->headers as $header )
                echo "<th bgcolor='".$this->bgcolor."'>$header</th>";

            echo '</tr>';

            foreach ( $this->data as $y ) {
                echo "<tr>";
                foreach ( $y as $x )
                    echo "<td bgcolor='".$this->bgcolor."'>$x</td>";
                echo "</tr>";
            }
            echo "</table>";
        }
    }

    $test2 = new HTMLTable ( array("a","b","c"), "#00FFFF" );
    $test2->setCellpadding ( 7 );

    $test2->addRow(["a"=>1,"b"=>3,"c"=>2]);
    $test2->addRow(["a"=>1,"c"=>3]);
    $test2->addRow(["c"=>1,"b"=>3,"a"=>4]);

    $test2->output();

    echo '<br />';

    // 3 Создать класс с именем baseClass, в свойствах которого сохраняются два числа. Написать к нему метод calculate(), который выводит эти числа на экран.
    class BaseClass
    {
        protected $a;
        protected $b;

        function BaseClass(float $a, float $b)
        {
            $this->a = $a;
            $this->b = $b;
        }

        public function calculate()
        {
            echo '('.$this->a.', '.$this->b.')';
        }
    }

    echo 'new BaseClass(1, 2).calculate(): ', (new BaseClass(1, 2))->calculate();
    echo '<br />';

    // 4 Создать класс с именем addCalc, производный от класса baseClass. Переопределить его метод calculate() так, чтобы он выводил на экран сумму чисел.
    class AddCalc extends BaseClass {
        public function calculate()
        {
            echo $this->a + $this->b;
        }
    }
    echo 'new AddCalc(1, 2).calculate(): ', (new AddCalc(1, 2))->calculate();
    echo '<br />';

    // 5 Создать класс с именем minusCalc, производный от класса baseClass. Переопределить его метод calculate() так, чтобы он выводил на экран разность первого и второго чисел.
    class MinusCalc extends BaseClass {
        public function calculate()
        {
            echo $this->a - $this->b;
        }
    }
    echo 'new MinusCalc(1, 2).calculate(): ', (new MinusCalc(1, 2))->calculate();
    echo '<br />';

    // 6 Создать класс содержащий static метод _GetVar(id, свойство), который создает объект класса и возвращает значение свойтва переданного во втором параметре. Это задание на понимание различий статических и динамических методов. При обращении к (static* методу нужно создать(new) новый экземпляр класса получить у него свойство, переданное в качестве параметра и вернуть его.

    class TestClass
    {
        private $id;
        private $ten = 10;

        public function TestClass($id)
        {
            $this->id = $id;
        }

        public static function _GetVar($id, $prop)
        {
            $obj = new TestClass($id);
            return $obj->$prop;
        }
    }

    echo 'TestClass::_GetVar(5, "id"): ', TestClass::_GetVar(5, "id"), '<br/>';
    echo 'TestClass::_GetVar(5, "ten"): ', TestClass::_GetVar(5, "ten"), '<br/>';

    // 7 Создать класс в котором будут производиться запись и чтение любых свойств этого класса. Использовать массив со свойствами и методы-перехватчики __get, __set, __unset, __isset. Отдокументровать 3 свойства с помощью @property phpDoc
    // 8 Определить волшебный метод Sum(a,b) - суммирования двух "волшебных" свойств переданных в параметре с помощью __call. Отдокументровать этот метод, определенный с помощью phpDoc

    /**
     * @property int $myProperty1
     * @property int $myProperty2
     * @property int $myProperty3
     * @method int Sum(string $prop1, string $prop1)
     */
    class MagicClass
    {
        private $map = [];

        function __get($prop)
        {
            return $this->map[$prop];
        }
           
        function __set($prop, $val)
        {
            $this->map[$prop] = $val;
        }

        function __unset($prop) 
        {
            unset( $this->map[$prop] );
        }

        function __isset($prop)
        {
            return $this->map[$prop] !== null;
        }

        function __call($method, $args)
        {
            if($method === 'Sum') {
                return $this->map[ $args[0] ] + $this->map[ $args[1] ];
            }
            return $this->$method(...$args);
        }
    }

    $test3 = new MagicClass();
    $test3->myProperty1 = 10;
    $test3->myProperty2 = 20;
    $test3->myProperty3 = 30;
    echo '$test3->myProperty1: ', $test3->myProperty1, '<br/>';
    echo '$test3->myProperty2: ', $test3->myProperty2, '<br/>';
    echo '$test3->myProperty3: ', $test3->myProperty3, '<br/>';
    echo '$test3->Sum(\'myProperty2\', \'myProperty3\'): ', $test3->Sum('myProperty2', 'myProperty3'), '<br/>';
?>
</main>
</body>
</html>