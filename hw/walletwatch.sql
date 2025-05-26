-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2025-05-23 04:32:46
-- 伺服器版本： 10.4.32-MariaDB
-- PHP 版本： 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `walletwatch`
--

-- --------------------------------------------------------

--
-- 資料表結構 `spending_diary`
--

CREATE TABLE `spending_diary` (
  `id` int(10) UNSIGNED NOT NULL,
  `amount` int(10) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `item` text NOT NULL,
  `category` varchar(12) NOT NULL,
  `note` text NOT NULL,
  `place` varchar(20) NOT NULL,
  `store` varchar(20) NOT NULL,
  `payment` varchar(20) NOT NULL,
  `account` varchar(20) NOT NULL,
  `receipt` varchar(20) NOT NULL,
  `tags` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `spending_diary`
--

INSERT INTO `spending_diary` (`id`, `amount`, `date`, `item`, `category`, `note`, `place`, `store`, `payment`, `account`, `receipt`, `tags`, `created_at`, `updated_at`) VALUES
(1, 150, '2025-05-14', '紙盒林鳳營鮮奶*2', '食', '使用優惠券', '實體', '家樂福超市', 'linepay', '台新gogo卡', '電子發票', '優惠券', '2025-05-21 08:11:44', '2025-05-23 02:26:36'),
(2, 65, '2025-05-21', '台酒黑麥汁*1', '食', '噶瑪蘭不好喝，稀釋還原', '實體', '全聯', '一卡通', '王道銀行活存', '電子發票', '特價', '2025-05-21 08:11:44', '2025-05-23 02:28:09'),
(3, 80, '2025-05-21', '多力多滋*1', '食', '換大包裝變貴，四包64元變五包80元', '實體', '家樂福超市', 'linepay', '永豐gree卡', '電子發票', '', '2025-05-21 08:11:44', '2025-05-23 02:28:20'),
(4, 150, '2025-05-20', '法式大圓*1', '食', '湊永豐卡滿2000送200', '實體', '家樂福超市', 'linepay', '永豐green卡', '電子發票', '早餐', '2025-05-21 08:11:44', '2025-05-23 02:28:28'),
(5, 179, '2025-05-20', '泰山均衡369調和油*1', '食', '歷史低價149', '網購', '家速配-到店自取', 'linepay', '台新gogo卡', '電子發票', '線上購物、LINE導購回饋10%', '2025-05-21 08:22:37', '2025-05-23 02:28:35'),
(6, 72, '2025-05-20', '統一AB優惠乳*1', '食', '效期太短', '網購', '家速配-到店自取', 'linepay', '台新gogo卡', '電子發票', '線上購物、LINE導購回饋10%', '2025-05-21 08:22:37', '2025-05-23 02:28:40'),
(7, 159, '2025-05-06', '萬丹鮮奶-買1送2 *1', '食', '', '實體', '家樂福超市', 'linepay', '台新gogo卡', '電子發票', '優惠券', '2025-05-21 08:11:44', '2025-05-23 02:28:44'),
(8, 45, '2025-05-05', '法式大圓*1', '食', '', '實體', '家樂福超市', 'linepay', '台新gogo卡', '電子發票', '早餐', '2025-05-21 08:11:44', '2025-05-23 02:28:47'),
(9, 65, '2025-05-21', '苜蓿芽*1+綠豆芽*1', '食', '特價28，原價32', '實體', '全聯', '一卡通', '王道銀行活存', '電子發票', '特價', '2025-05-21 08:11:44', '2025-05-23 02:28:14'),
(10, 90, '2025-05-15', '自助加油', '行', '忘記帶手機', '實體', '中油直營店', '刷卡', '元大卡', '電子發票', '自助加油', '2025-05-21 08:11:44', '2025-05-23 02:28:47');

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `spending_diary`
--
ALTER TABLE `spending_diary`
  ADD PRIMARY KEY (`id`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `spending_diary`
--
ALTER TABLE `spending_diary`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
