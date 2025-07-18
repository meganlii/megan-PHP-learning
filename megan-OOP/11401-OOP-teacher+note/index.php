<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>物件導向</title>
</head>

<body>
    <script>
        /*
        // class 宣告類別 用封裝概念
        class Person
        {
        // 設屬性
        public $name;
        public $age;

        // 設行為 方法1：內建 建構函式

        // 設行為 方法2：自建 函式

        // 建立物件
        }
        */
    </script>

    <?php
    // class 步驟1 宣告類別 定義類別class 成員 藍圖(設計圖)
    // class + 成員name {...} 

    // property 宣告一個 Person 類別，2個屬性 name 和 age
    // method-1 一個建構函式 __construct() 初始化屬性
    // method-2 2個方法 getName()跟getAge() 取得和設定 $name $age 屬性
    // new 關鍵字實例化類別，建立物件

    class Person
    {

        // 步驟2 設屬性property 有三種
        /**
         * public: 公開的屬性，可以在任何地方訪問。
         * private: 私有的屬性，只能在類(物件)內部訪問。
         * protected: 受保護的屬性，只能在類(物入)內部或子類中訪問。
         * 
         **/
        protected $name;
        protected $age;


        // 步驟3 設行為  內有 建構函式 method方法
        // JS用(.點)  php用-> [ ]  三種存取用法
        // apple.name
        // apple->name
        // apple['name']
        public function __construct($name, $age)
        {
            $this->name = $name;
            // $this什麼意思
            // $this指向當前物件的實例
            // 在類別內部使用$this可以訪問當前物件的屬性和方法
            // 在建構函式中使用$this可以初始化物件的屬性

            $this->age = $age;
        }

        // 步驟4 設行為 自建 函式
        public function greet()
        {
            echo "Hello, my name is {$this->name} and I am {$this->age} years old.<br>";
        }

        public function getName()
        {
            return $this->name;
        }
        public function getAge()
        {
            return $this->age;
        }
        public function setName($name)
        {
            $this->name = $name;
        }
        public function setAge($age)
        {
            $this->age = $age;
        }
    }


    // 步驟5 建立物件 具象化 object
    // 使用 new 關鍵字 實例化類別
    // 物件是類別的實例，包含類別的屬性
    // 物件可以呼叫類別的方法
    // 物件可以有自己的屬性值
    $jason = new Person('jason', 18);
    echo $jason->getName();
    echo "<br>";
    echo $jason->getAge();
    echo "<br>";
    $jason->greet();;

    echo "<hr>";
    $jason->setName("Mary");
    //$jason->age=20;
    echo $jason->getName();
    echo "<br>";
    echo $jason->getAge();
    echo "<br>";
    $jason->greet();

    ?>
    <hr>
    <h2>繼承</h2>
    <?php


    interface PersonInterface
    {
        public function getGender();
        public function say();
    }

    class Man extends Person implements PersonInterface
    {
        private $gender = '男性';
        public static  $skin = 'yellow';

        function getGender()
        {
            return $this->gender;
        }
        function say() {}

        static function getSkin()
        {
            return self::$skin;
        }
    }
    class WoMan extends Person implements PersonInterface
    {
        private $gender = '女性';
        public $skin = 'white';

        function getGender()
        {
            return $this->gender;
        }
        function say() {}
        static function getSkin()
        {
            return self::$skin;
        }
    }

    /* $man=new Man('John', 25);
echo $man->getName();
echo "<br>";
echo $man->getGender();
echo "<br>";
$man->greet(); */
    echo Man::$skin;
    echo Man::getSkin();
    echo "<hr>";
    $woman = new Woman('Jane', 22);
    echo $woman->getName();
    echo "<br>";
    echo $woman->getGender();
    echo "<br>";
    $woman->greet();

    ?>
</body>

</html>