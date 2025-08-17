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
    // 宣告1個類別/Person，2個屬性(變數)/$name和$age，建立物件
    // class + 成員name { 屬性(變數) 方法(函式) }   

    // 1. 宣告類別class 宣告類別 /定義class  成員/藍圖(設計圖)
    // 類別是物件的藍圖，定義了物件的屬性和方法
    // 在類別中，變數稱為屬性，函數稱為方法！
    // php用 關鍵字class + { }大括號 宣告類別

    // 2. 屬性property：宣告變數 設2個變數
    // 3. 方法method-1：一個建構函式 __construct() 初始化屬性 
    // php用 關鍵字$this  
    // 4. 方法method-2：2個方法 getName()跟getAge() 取得和設定 $name $age 屬性
    // 5. 建立物件new 關鍵字實例化類別，建立物件

    // 步驟1 宣告類別
    class Person
    {

        // 步驟2 設屬性property 有三種  "宣告變數"
        /*
         * public: 公開的屬性，可以在任何地方訪問。
         * private: 私有的屬性，只能在類(物件)內部訪問。
         * protected: 受保護的屬性，只能在類(物入)內部或子類中訪問。
        */
        protected $name;
        protected $age;


        // 步驟3 設行為  內有 建構函式  
        // 兩個底線（__）開頭
        // 建立物件時 會自動呼叫 建構函式(步驟5)
        // 取得屬性值(變數)或方法(函式)  初始化屬性(變數)  沒有回傳值
        
        // 英文中自我介紹This is Megan  "我"是Megan
        //   
        // 使用 [$this->屬性名稱(不用$)]  存取 物件的屬性(變數)：$name和$age
        // [$this->屬性名稱(不用$)] = $var  // 使用 "$this" "->" "$var"
        // 左邊傳入的參數 右邊是[]是物件的屬性/變數
        // 類似插入變數 {$資料表名稱}  替換成不同資料表 {$title} 

        // $jason = new Person('jason', 18); 宣告物件後 自動呼叫建構子
        // __construct('jason', 18)
        // 建構函式會接收參數，並將其存入屬性
        // $this->name = $jason; // 將傳入的$name參數存入物件的name屬性
        public function __construct($name, $age)
        {
            $this->name = $name;
            $this->age = $age;
        }

        // 步驟4 設行為 自建函式
        public function greet() 
        {
            echo "Hello, my name is {$this->name} and I am {$this->age} years old.<br>"; 
            // 使用$this->name 和 $this->age 取得屬性值
        }

        public function getName() 
        {
            return $this->name; // 取得 name 屬性值
        }
        public function getAge() 
        {
            return $this->age;  // 取得 age 屬性值
        }
        
        public function setName($name)
        {
            $this->name = $name;  // 設定 name 屬性值
        }
        public function setAge($age)
        {
            $this->age = $age; // 設定 age 屬性值
        }
    }


    // 步驟5 建立物件 具象化 object
    // 使用 關鍵字 new語法 建立物件 實例化類別 
    // 將這個物件指定給一個變數，包含多個參數
    // 物件 是類別的實例，包含類別的屬性
    // 一個類別 可建立 多個物件。
    // 每個物件 都擁有類別中定義的所有屬性和方法，但它們的屬性值會有所不同。

    // $jason 是 Person 類別的實例/物件
    // 建立物件時 會呼叫建構函式 (步驟3)
    // 傳入的參數 會送到建構子 用來初始化屬性值
    // 物件名稱(物件變數) = new 類別名稱(參數1, 參數2, parameter3...)
    $jason = new Person('jason', 18);


    // 步驟6 建立物件後 存取屬性值
    echo $jason->getName(); // 取得 屬性值
    echo "<br>";
    echo $jason->getAge();
    echo "<br>";

    // 步驟7 建立物件後 呼叫方法
    // 使用 物件名稱->方法名稱() 呼叫方法 存取屬性值
    $jason->greet();
    echo "<hr>";

    $jason->setName("Mary");  // 設定 屬性值

    // 使用 物件名稱->屬性名稱=  取得屬性值
    // $jason->age=20;
    // $jason->setAge(20);  // 設定 屬性值
    
    echo $jason->getName();
    echo "<br>";
    echo $jason->getAge();
    echo "<br>";
    $jason->greet();

    ?>
    <hr>
    <h2>繼承</h2>
    <?php

    // 一個類別可以同時包含靜態方法和非靜態方法。
    // static靜態方法可以透過self 關鍵字和雙冒號 (::) 從同一個類別中的方法存取


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

    // JS用(.點)  php用-> [ ]  三種存取用法
        /* 
         * apple.name
         * apple->name
         * apple['name']
        */

    ?>

    
</body>

</html>