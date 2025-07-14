# 📅 萬年曆製作架構指南

## 🎯 核心概念
萬年曆的本質是：**根據年月參數，計算並顯示該月的日期排列**

## 📋 製作步驟架構

### 步驟1: 設定基本HTML結構
```html
<!DOCTYPE html>
<html>
<head>
    <title>萬年曆</title>
    <style>/* CSS樣式 */</style>
</head>
<body>
    <!-- 日曆內容 -->
</body>
</html>
```

### 步驟2: 取得年月參數
```php
// 從URL取得參數，沒有則使用當前日期
$month = isset($_GET['month']) ? $_GET['month'] : date("m");
$year = isset($_GET['year']) ? $_GET['year'] : date("Y");
```
**目的**：決定要顯示哪個月份的日曆

### 步驟3: 計算月份導航
```php
// 處理跨年情況
if ($month - 1 > 0) {
    $prev = $month - 1;
    $prevyear = $year;
} else {
    $prev = 12;           // 1月的上一月是去年12月
    $prevyear = $year - 1;
}
```
**目的**：產生「上一月」「下一月」的連結

### 步驟4: 計算當月基本資訊
```php
$today = date("Y-$month-d");                      // 今天日期
$firstDay = date("Y-$month-01");                  // 當月第一天
$firstDayWeek = date("w", strtotime($firstDay));  // 第一天是星期幾
$theDaysOfMonth = date("t", strtotime($firstDay)); // 當月總天數
```
**目的**：取得製作日曆所需的基本數據

### 步驟5: 建立特殊日期資料
```php
$spDate = [
    '2025-04-04' => '兒童節',
    '2025-05-01' => '勞動節'
];
$todoList = ['2025-05-01' => '開會'];
```
**目的**：定義節日、生日、待辦事項等特殊標記

### 步驟6: 建立月份日期陣列 ⭐ **最重要的步驟**
```php
$monthDays = [];

// 6-1: 填入空白日期 (月初空格)
for ($i = 0; $i < $firstDayWeek; $i++) {
    $monthDays[] = [];
}

// 6-2: 填入當月所有日期
for ($i = 0; $i < $theDaysOfMonth; $i++) {
    $timestamp = strtotime(" $i days", strtotime($firstDay));
    $monthDays[] = [
        "day" => date("d", $timestamp),
        "fullDate" => date("Y-m-d", $timestamp),
        "weekOfYear" => date("W", $timestamp),
        "week" => date("w", $timestamp),
        "holiday" => $holiday,
        "todo" => $todo
    ];
}
```
**目的**：建立包含所有日期資訊的陣列，這是日曆的核心資料結構

### 步驟7: 輸出HTML日曆結構
```php
// 7-1: 月份導航
echo "<a href='?year=$prevyear&month=$prev'>上一月</a>";

// 7-2: 星期標題
echo "<div>日</div><div>一</div>...";

// 7-3: 日期格子
foreach ($monthDays as $day) {
    echo "<div class='box'>";
    echo $day['day'];           // 日期數字
    echo $day['holiday'];       // 節日
    echo $day['todo'];          // 待辦事項
    echo "</div>";
}
```
**目的**：將資料轉換為視覺化的日曆界面

### 步驟8: 美化CSS樣式
```css
.box {
    width: 60px;
    height: 80px;
    border: 1px solid #ccc;
    display: inline-block;
}
.today { background-color: yellow; }
.weekend { background-color: pink; }
```
**目的**：讓日曆美觀且易於閱讀

## 🔧 關鍵技術點

### 1. 日期計算函數
- `date("m")` - 取得月份
- `date("Y")` - 取得年份
- `date("w")` - 取得星期幾 (0=星期日)
- `date("t")` - 取得當月天數
- `strtotime()` - 將字串轉為時間戳

### 2. 陣列結構設計
```php
$monthDays = [
    [],                    // 空白日期
    [                      // 有效日期
        "day" => "01",
        "fullDate" => "2025-07-01",
        "week" => 1,
        "holiday" => "",
        "todo" => ""
    ]
];
```

### 3. 月份導航邏輯
- 1月的上一月 = 去年12月
- 12月的下一月 = 明年1月
- 其他月份正常加減

## 💡 常見問題解決

### Q1: 為什麼需要空白日期？
A: 因為每個月1號不一定是星期日，前面需要空格對齊

### Q2: 如何判斷今天？
A: 比較 `$day['fullDate']` 和 `date('Y-m-d')`

### Q3: 如何添加新功能？
A: 在步驟5增加資料，步驟6計算，步驟7顯示

## 🚀 擴展建議

### 進階功能
1. **農曆顯示** - 增加農曆計算
2. **事件管理** - 可新增/刪除事件
3. **多種視圖** - 週視圖、年視圖
4. **資料庫整合** - 將事件存入資料庫
5. **RWD響應式** - 適應不同裝置

### 程式碼優化
1. **函數封裝** - 將重複程式碼包成函數
2. **類別設計** - 使用OOP設計
3. **模板分離** - 將HTML和PHP分開
4. **快取機制** - 提升效能

## 📝 下次製作檢查清單

- [ ] 確定年月參數處理
- [ ] 計算月份導航邏輯  
- [ ] 取得當月基本資訊
- [ ] 建立特殊日期資料
- [ ] 正確建立日期陣列
- [ ] 輸出HTML結構
- [ ] 添加CSS美化
- [ ] 測試各種月份
- [ ] 檢查跨年功能
- [ ] 確認今天高亮

記住：**萬年曆的核心就是正確計算日期陣列，其他都是包裝！**