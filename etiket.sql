-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 10, 2025 at 03:23 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `etiket`
--

-- --------------------------------------------------------

--
-- Table structure for table `absen`
--

CREATE TABLE `absen` (
  `id` bigint UNSIGNED NOT NULL,
  `id_peserta` bigint UNSIGNED NOT NULL,
  `tanggal_masuk` datetime NOT NULL,
  `nomor_tiket` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `absen`
--

INSERT INTO `absen` (`id`, `id_peserta`, `tanggal_masuk`, `nomor_tiket`, `created_at`, `updated_at`) VALUES
(11, 5041, '2025-11-10 08:06:54', '3645.250228.CKR', '2025-11-10 01:06:54', '2025-11-10 01:06:54'),
(12, 5042, '2025-11-10 10:22:39', '3075.231201.CKR', '2025-11-10 03:22:39', '2025-11-10 03:22:39');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-eksekusi_whatsapp_peserta_terakhir', 'O:25:\"Illuminate\\Support\\Carbon\":3:{s:4:\"date\";s:26:\"2025-11-10 10:23:23.335412\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:12:\"Asia/Jakarta\";}', 1762745525),
('laravel-cache-illuminate:queue:restart', 'i:1762741865;', 2078101865);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `departemen`
--

CREATE TABLE `departemen` (
  `id` bigint UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nomor` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departemen`
--

INSERT INTO `departemen` (`id`, `nama`, `kode`, `nomor`, `created_at`, `updated_at`) VALUES
(1, 'Information Technology', 'IT', '00', '2025-03-07 06:06:04', '2025-03-07 06:06:05'),
(2, 'Marketing', 'MKT', '11', '2025-03-07 06:06:06', '2025-03-07 06:06:07'),
(3, 'Keuangan', 'KEU', '12', '2025-03-07 06:06:07', '2025-03-07 06:06:08'),
(4, 'Purchasing', 'PCH', '13', '2025-03-07 06:06:09', '2025-03-07 06:06:09'),
(5, 'Human Resource', 'HR', '14', '2025-03-07 06:06:10', '2025-03-07 06:06:11'),
(6, 'General Affair', 'GA', '15', '2025-03-07 06:06:13', '2025-03-07 06:06:14'),
(7, 'Human Safety & Environment', 'HSE', '16', '2025-03-07 06:06:14', '2025-03-07 06:06:15'),
(8, 'Quality Management System', 'QMS', '17', '2025-03-07 06:06:16', '2025-03-07 06:06:16'),
(9, 'Production Planning & Inventory Control', 'PPIC', '18', '2025-03-07 06:06:17', '2025-03-07 06:06:18'),
(10, 'Production', 'PROD', '19', '2025-03-07 06:06:19', '2025-03-07 06:06:20'),
(11, 'Quality Control', 'QC', '20', '2025-03-07 06:06:21', '2025-03-07 06:06:22'),
(12, 'Engineering', 'ENG', '21', '2025-03-07 06:06:22', '2025-03-07 06:06:23'),
(13, 'Diesshop', 'DS', '22', '2025-03-07 06:06:24', '2025-03-07 06:06:25'),
(14, 'Repair & Maintenance', 'RM', '23', '2025-03-07 06:06:26', '2025-03-07 06:06:26'),
(15, 'Welding, Machining & Packing', 'WMP', '24', '2025-03-07 06:25:32', '2025-03-07 06:25:33'),
(16, 'Manajemen', 'MGR', '25', '2025-04-14 02:32:41', '2025-04-14 02:32:42');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `failed_jobs`
--

INSERT INTO `failed_jobs` (`id`, `uuid`, `connection`, `queue`, `payload`, `exception`, `failed_at`) VALUES
(13, '26818fe0-8b07-4436-881f-d146d30b0919', 'database', 'default', '{\"uuid\":\"26818fe0-8b07-4436-881f-d146d30b0919\",\"displayName\":\"App\\\\Jobs\\\\KirimWhatsappPeserta\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\KirimWhatsappPeserta\",\"command\":\"O:29:\\\"App\\\\Jobs\\\\KirimWhatsappPeserta\\\":3:{s:7:\\\"peserta\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:18:\\\"App\\\\Models\\\\Peserta\\\";s:2:\\\"id\\\";i:5041;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:5:\\\"pesan\\\";s:274:\\\"Halo ARDYAN SYAHPUTRA,\\n\\nAnda diundang untuk menghadiri Seminar PT. Mada Wikri Tunggal.\\n\\nNo. Peserta: 3645.250228.CKR\\nTanggal: 5 November 2025\\nWaktu: 09:00 - 17:00 WIB\\nTempat: Hotel Primebiz, Cikarang\\n\\nSilakan scan QR Code yang dikirim via email untuk absensi.\\n\\nTerima kasih.\\\";s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-11-10 08:53:52.512545\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:12:\\\"Asia\\/Jakarta\\\";}}\"},\"createdAt\":1762741134,\"delay\":0}', 'Exception: Token tidak valid. in C:\\laragon\\www\\etiket\\app\\Jobs\\KirimWhatsappPeserta.php:65\nStack trace:\n#0 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): App\\Jobs\\KirimWhatsappPeserta->handle()\n#1 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(43): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#2 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(96): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))\n#3 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#4 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(836): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#5 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(129): Illuminate\\Container\\Container->call(Array)\n#6 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(180): Illuminate\\Bus\\Dispatcher->Illuminate\\Bus\\{closure}(Object(App\\Jobs\\KirimWhatsappPeserta))\n#7 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(137): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(App\\Jobs\\KirimWhatsappPeserta))\n#8 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(133): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#9 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(134): Illuminate\\Bus\\Dispatcher->dispatchNow(Object(App\\Jobs\\KirimWhatsappPeserta), false)\n#10 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(180): Illuminate\\Queue\\CallQueuedHandler->Illuminate\\Queue\\{closure}(Object(App\\Jobs\\KirimWhatsappPeserta))\n#11 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(137): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(App\\Jobs\\KirimWhatsappPeserta))\n#12 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(127): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#13 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(68): Illuminate\\Queue\\CallQueuedHandler->dispatchThroughMiddleware(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(App\\Jobs\\KirimWhatsappPeserta))\n#14 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Jobs\\Job.php(102): Illuminate\\Queue\\CallQueuedHandler->call(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Array)\n#15 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(451): Illuminate\\Queue\\Jobs\\Job->fire()\n#16 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(401): Illuminate\\Queue\\Worker->process(\'database\', Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(Illuminate\\Queue\\WorkerOptions))\n#17 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(187): Illuminate\\Queue\\Worker->runJob(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), \'database\', Object(Illuminate\\Queue\\WorkerOptions))\n#18 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(148): Illuminate\\Queue\\Worker->daemon(\'database\', \'default\', Object(Illuminate\\Queue\\WorkerOptions))\n#19 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(131): Illuminate\\Queue\\Console\\WorkCommand->runWorker(\'database\', \'default\')\n#20 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): Illuminate\\Queue\\Console\\WorkCommand->handle()\n#21 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(43): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#22 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(96): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))\n#23 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#24 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(836): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#25 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(211): Illuminate\\Container\\Container->call(Array)\n#26 C:\\laragon\\www\\etiket\\vendor\\symfony\\console\\Command\\Command.php(318): Illuminate\\Console\\Command->execute(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#27 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(180): Symfony\\Component\\Console\\Command\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#28 C:\\laragon\\www\\etiket\\vendor\\symfony\\console\\Application.php(1073): Illuminate\\Console\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#29 C:\\laragon\\www\\etiket\\vendor\\symfony\\console\\Application.php(356): Symfony\\Component\\Console\\Application->doRunCommand(Object(Illuminate\\Queue\\Console\\WorkCommand), Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#30 C:\\laragon\\www\\etiket\\vendor\\symfony\\console\\Application.php(195): Symfony\\Component\\Console\\Application->doRun(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#31 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Console\\Kernel.php(197): Symfony\\Component\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#32 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Application.php(1235): Illuminate\\Foundation\\Console\\Kernel->handle(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#33 C:\\laragon\\www\\etiket\\artisan(16): Illuminate\\Foundation\\Application->handleCommand(Object(Symfony\\Component\\Console\\Input\\ArgvInput))\n#34 {main}', '2025-11-10 02:18:56'),
(14, '4b708ce5-b859-418b-931a-786823156538', 'database', 'default', '{\"uuid\":\"4b708ce5-b859-418b-931a-786823156538\",\"displayName\":\"App\\\\Jobs\\\\KirimWhatsappPeserta\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\KirimWhatsappPeserta\",\"command\":\"O:29:\\\"App\\\\Jobs\\\\KirimWhatsappPeserta\\\":3:{s:7:\\\"peserta\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:18:\\\"App\\\\Models\\\\Peserta\\\";s:2:\\\"id\\\";i:5041;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:5:\\\"pesan\\\";s:274:\\\"Halo ARDYAN SYAHPUTRA,\\n\\nAnda diundang untuk menghadiri Seminar PT. Mada Wikri Tunggal.\\n\\nNo. Peserta: 3645.250228.CKR\\nTanggal: 5 November 2025\\nWaktu: 09:00 - 17:00 WIB\\nTempat: Hotel Primebiz, Cikarang\\n\\nSilakan scan QR Code yang dikirim via email untuk absensi.\\n\\nTerima kasih.\\\";s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-11-10 08:54:55.512545\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:12:\\\"Asia\\/Jakarta\\\";}}\"},\"createdAt\":1762741443,\"delay\":0}', 'GuzzleHttp\\Exception\\RequestException: cURL error 77: error setting certificate file: D:\\Projects\\Laragon-installer\\8.0-W64\\etc\\ssl\\cacert.pem (see https://curl.haxx.se/libcurl/c/libcurl-errors.html) for https://cikuray.sendnotif.id/api/v1/send/message in C:\\laragon\\www\\etiket\\vendor\\guzzlehttp\\guzzle\\src\\Handler\\CurlFactory.php:278\nStack trace:\n#0 C:\\laragon\\www\\etiket\\vendor\\guzzlehttp\\guzzle\\src\\Handler\\CurlFactory.php(207): GuzzleHttp\\Handler\\CurlFactory::createRejection(Object(GuzzleHttp\\Handler\\EasyHandle), Array)\n#1 C:\\laragon\\www\\etiket\\vendor\\guzzlehttp\\guzzle\\src\\Handler\\CurlFactory.php(159): GuzzleHttp\\Handler\\CurlFactory::finishError(Object(GuzzleHttp\\Handler\\CurlHandler), Object(GuzzleHttp\\Handler\\EasyHandle), Object(GuzzleHttp\\Handler\\CurlFactory))\n#2 C:\\laragon\\www\\etiket\\vendor\\guzzlehttp\\guzzle\\src\\Handler\\CurlHandler.php(47): GuzzleHttp\\Handler\\CurlFactory::finish(Object(GuzzleHttp\\Handler\\CurlHandler), Object(GuzzleHttp\\Handler\\EasyHandle), Object(GuzzleHttp\\Handler\\CurlFactory))\n#3 C:\\laragon\\www\\etiket\\vendor\\guzzlehttp\\guzzle\\src\\Handler\\Proxy.php(28): GuzzleHttp\\Handler\\CurlHandler->__invoke(Object(GuzzleHttp\\Psr7\\Request), Array)\n#4 C:\\laragon\\www\\etiket\\vendor\\guzzlehttp\\guzzle\\src\\Handler\\Proxy.php(48): GuzzleHttp\\Handler\\Proxy::GuzzleHttp\\Handler\\{closure}(Object(GuzzleHttp\\Psr7\\Request), Array)\n#5 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Http\\Client\\PendingRequest.php(1423): GuzzleHttp\\Handler\\Proxy::GuzzleHttp\\Handler\\{closure}(Object(GuzzleHttp\\Psr7\\Request), Array)\n#6 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Http\\Client\\PendingRequest.php(1389): Illuminate\\Http\\Client\\PendingRequest->Illuminate\\Http\\Client\\{closure}(Object(GuzzleHttp\\Psr7\\Request), Array)\n#7 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Http\\Client\\PendingRequest.php(1375): Illuminate\\Http\\Client\\PendingRequest->Illuminate\\Http\\Client\\{closure}(Object(GuzzleHttp\\Psr7\\Request), Array)\n#8 C:\\laragon\\www\\etiket\\vendor\\guzzlehttp\\guzzle\\src\\PrepareBodyMiddleware.php(64): Illuminate\\Http\\Client\\PendingRequest->Illuminate\\Http\\Client\\{closure}(Object(GuzzleHttp\\Psr7\\Request), Array)\n#9 C:\\laragon\\www\\etiket\\vendor\\guzzlehttp\\guzzle\\src\\Middleware.php(38): GuzzleHttp\\PrepareBodyMiddleware->__invoke(Object(GuzzleHttp\\Psr7\\Request), Array)\n#10 C:\\laragon\\www\\etiket\\vendor\\guzzlehttp\\guzzle\\src\\RedirectMiddleware.php(71): GuzzleHttp\\Middleware::GuzzleHttp\\{closure}(Object(GuzzleHttp\\Psr7\\Request), Array)\n#11 C:\\laragon\\www\\etiket\\vendor\\guzzlehttp\\guzzle\\src\\Middleware.php(63): GuzzleHttp\\RedirectMiddleware->__invoke(Object(GuzzleHttp\\Psr7\\Request), Array)\n#12 C:\\laragon\\www\\etiket\\vendor\\guzzlehttp\\guzzle\\src\\HandlerStack.php(75): GuzzleHttp\\Middleware::GuzzleHttp\\{closure}(Object(GuzzleHttp\\Psr7\\Request), Array)\n#13 C:\\laragon\\www\\etiket\\vendor\\guzzlehttp\\guzzle\\src\\Client.php(333): GuzzleHttp\\HandlerStack->__invoke(Object(GuzzleHttp\\Psr7\\Request), Array)\n#14 C:\\laragon\\www\\etiket\\vendor\\guzzlehttp\\guzzle\\src\\Client.php(169): GuzzleHttp\\Client->transfer(Object(GuzzleHttp\\Psr7\\Request), Array)\n#15 C:\\laragon\\www\\etiket\\vendor\\guzzlehttp\\guzzle\\src\\Client.php(189): GuzzleHttp\\Client->requestAsync(\'POST\', Object(GuzzleHttp\\Psr7\\Uri), Array)\n#16 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Http\\Client\\PendingRequest.php(1221): GuzzleHttp\\Client->request(\'POST\', \'https://cikuray...\', Array)\n#17 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Http\\Client\\PendingRequest.php(966): Illuminate\\Http\\Client\\PendingRequest->sendRequest(\'POST\', \'https://cikuray...\', Array)\n#18 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Support\\helpers.php(329): Illuminate\\Http\\Client\\PendingRequest->Illuminate\\Http\\Client\\{closure}(1)\n#19 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Http\\Client\\PendingRequest.php(964): retry(0, Object(Closure), 100, Object(Closure))\n#20 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Http\\Client\\PendingRequest.php(831): Illuminate\\Http\\Client\\PendingRequest->send(\'POST\', \'https://cikuray...\', Array)\n#21 C:\\laragon\\www\\etiket\\app\\Jobs\\KirimWhatsappPeserta.php(45): Illuminate\\Http\\Client\\PendingRequest->post(\'https://cikuray...\', Array)\n#22 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): App\\Jobs\\KirimWhatsappPeserta->handle()\n#23 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(43): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#24 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(96): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))\n#25 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#26 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(836): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#27 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(129): Illuminate\\Container\\Container->call(Array)\n#28 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(180): Illuminate\\Bus\\Dispatcher->Illuminate\\Bus\\{closure}(Object(App\\Jobs\\KirimWhatsappPeserta))\n#29 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(137): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(App\\Jobs\\KirimWhatsappPeserta))\n#30 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(133): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#31 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(134): Illuminate\\Bus\\Dispatcher->dispatchNow(Object(App\\Jobs\\KirimWhatsappPeserta), false)\n#32 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(180): Illuminate\\Queue\\CallQueuedHandler->Illuminate\\Queue\\{closure}(Object(App\\Jobs\\KirimWhatsappPeserta))\n#33 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(137): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(App\\Jobs\\KirimWhatsappPeserta))\n#34 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(127): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#35 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(68): Illuminate\\Queue\\CallQueuedHandler->dispatchThroughMiddleware(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(App\\Jobs\\KirimWhatsappPeserta))\n#36 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Jobs\\Job.php(102): Illuminate\\Queue\\CallQueuedHandler->call(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Array)\n#37 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(451): Illuminate\\Queue\\Jobs\\Job->fire()\n#38 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(401): Illuminate\\Queue\\Worker->process(\'database\', Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(Illuminate\\Queue\\WorkerOptions))\n#39 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(187): Illuminate\\Queue\\Worker->runJob(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), \'database\', Object(Illuminate\\Queue\\WorkerOptions))\n#40 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(148): Illuminate\\Queue\\Worker->daemon(\'database\', \'default\', Object(Illuminate\\Queue\\WorkerOptions))\n#41 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(131): Illuminate\\Queue\\Console\\WorkCommand->runWorker(\'database\', \'default\')\n#42 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): Illuminate\\Queue\\Console\\WorkCommand->handle()\n#43 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(43): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#44 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(96): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))\n#45 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#46 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(836): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#47 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(211): Illuminate\\Container\\Container->call(Array)\n#48 C:\\laragon\\www\\etiket\\vendor\\symfony\\console\\Command\\Command.php(318): Illuminate\\Console\\Command->execute(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#49 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(180): Symfony\\Component\\Console\\Command\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#50 C:\\laragon\\www\\etiket\\vendor\\symfony\\console\\Application.php(1073): Illuminate\\Console\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#51 C:\\laragon\\www\\etiket\\vendor\\symfony\\console\\Application.php(356): Symfony\\Component\\Console\\Application->doRunCommand(Object(Illuminate\\Queue\\Console\\WorkCommand), Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#52 C:\\laragon\\www\\etiket\\vendor\\symfony\\console\\Application.php(195): Symfony\\Component\\Console\\Application->doRun(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#53 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Console\\Kernel.php(197): Symfony\\Component\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#54 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Application.php(1235): Illuminate\\Foundation\\Console\\Kernel->handle(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#55 C:\\laragon\\www\\etiket\\artisan(16): Illuminate\\Foundation\\Application->handleCommand(Object(Symfony\\Component\\Console\\Input\\ArgvInput))\n#56 {main}\n\nNext Illuminate\\Http\\Client\\ConnectionException: cURL error 77: error setting certificate file: D:\\Projects\\Laragon-installer\\8.0-W64\\etc\\ssl\\cacert.pem (see https://curl.haxx.se/libcurl/c/libcurl-errors.html) for https://cikuray.sendnotif.id/api/v1/send/message in C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Http\\Client\\PendingRequest.php:1696\nStack trace:\n#0 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Http\\Client\\PendingRequest.php(1005): Illuminate\\Http\\Client\\PendingRequest->marshalRequestExceptionWithoutResponse(Object(GuzzleHttp\\Exception\\RequestException))\n#1 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Support\\helpers.php(329): Illuminate\\Http\\Client\\PendingRequest->Illuminate\\Http\\Client\\{closure}(1)\n#2 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Http\\Client\\PendingRequest.php(964): retry(0, Object(Closure), 100, Object(Closure))\n#3 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Http\\Client\\PendingRequest.php(831): Illuminate\\Http\\Client\\PendingRequest->send(\'POST\', \'https://cikuray...\', Array)\n#4 C:\\laragon\\www\\etiket\\app\\Jobs\\KirimWhatsappPeserta.php(45): Illuminate\\Http\\Client\\PendingRequest->post(\'https://cikuray...\', Array)\n#5 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): App\\Jobs\\KirimWhatsappPeserta->handle()\n#6 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(43): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#7 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(96): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))\n#8 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#9 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(836): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#10 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(129): Illuminate\\Container\\Container->call(Array)\n#11 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(180): Illuminate\\Bus\\Dispatcher->Illuminate\\Bus\\{closure}(Object(App\\Jobs\\KirimWhatsappPeserta))\n#12 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(137): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(App\\Jobs\\KirimWhatsappPeserta))\n#13 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(133): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#14 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(134): Illuminate\\Bus\\Dispatcher->dispatchNow(Object(App\\Jobs\\KirimWhatsappPeserta), false)\n#15 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(180): Illuminate\\Queue\\CallQueuedHandler->Illuminate\\Queue\\{closure}(Object(App\\Jobs\\KirimWhatsappPeserta))\n#16 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(137): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(App\\Jobs\\KirimWhatsappPeserta))\n#17 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(127): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#18 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(68): Illuminate\\Queue\\CallQueuedHandler->dispatchThroughMiddleware(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(App\\Jobs\\KirimWhatsappPeserta))\n#19 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Jobs\\Job.php(102): Illuminate\\Queue\\CallQueuedHandler->call(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Array)\n#20 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(451): Illuminate\\Queue\\Jobs\\Job->fire()\n#21 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(401): Illuminate\\Queue\\Worker->process(\'database\', Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(Illuminate\\Queue\\WorkerOptions))\n#22 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(187): Illuminate\\Queue\\Worker->runJob(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), \'database\', Object(Illuminate\\Queue\\WorkerOptions))\n#23 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(148): Illuminate\\Queue\\Worker->daemon(\'database\', \'default\', Object(Illuminate\\Queue\\WorkerOptions))\n#24 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(131): Illuminate\\Queue\\Console\\WorkCommand->runWorker(\'database\', \'default\')\n#25 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): Illuminate\\Queue\\Console\\WorkCommand->handle()\n#26 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(43): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#27 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(96): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))\n#28 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#29 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(836): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#30 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(211): Illuminate\\Container\\Container->call(Array)\n#31 C:\\laragon\\www\\etiket\\vendor\\symfony\\console\\Command\\Command.php(318): Illuminate\\Console\\Command->execute(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#32 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(180): Symfony\\Component\\Console\\Command\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#33 C:\\laragon\\www\\etiket\\vendor\\symfony\\console\\Application.php(1073): Illuminate\\Console\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#34 C:\\laragon\\www\\etiket\\vendor\\symfony\\console\\Application.php(356): Symfony\\Component\\Console\\Application->doRunCommand(Object(Illuminate\\Queue\\Console\\WorkCommand), Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#35 C:\\laragon\\www\\etiket\\vendor\\symfony\\console\\Application.php(195): Symfony\\Component\\Console\\Application->doRun(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#36 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Console\\Kernel.php(197): Symfony\\Component\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#37 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Application.php(1235): Illuminate\\Foundation\\Console\\Kernel->handle(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#38 C:\\laragon\\www\\etiket\\artisan(16): Illuminate\\Foundation\\Application->handleCommand(Object(Symfony\\Component\\Console\\Input\\ArgvInput))\n#39 {main}', '2025-11-10 02:24:06'),
(15, 'ef4a97ba-b07c-487d-a791-91c2f2d7673f', 'database', 'default', '{\"uuid\":\"ef4a97ba-b07c-487d-a791-91c2f2d7673f\",\"displayName\":\"App\\\\Jobs\\\\KirimWhatsappPeserta\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\KirimWhatsappPeserta\",\"command\":\"O:29:\\\"App\\\\Jobs\\\\KirimWhatsappPeserta\\\":3:{s:7:\\\"peserta\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:18:\\\"App\\\\Models\\\\Peserta\\\";s:2:\\\"id\\\";i:5041;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:5:\\\"pesan\\\";s:274:\\\"Halo ARDYAN SYAHPUTRA,\\n\\nAnda diundang untuk menghadiri Seminar PT. Mada Wikri Tunggal.\\n\\nNo. Peserta: 3645.250228.CKR\\nTanggal: 5 November 2025\\nWaktu: 09:00 - 17:00 WIB\\nTempat: Hotel Primebiz, Cikarang\\n\\nSilakan scan QR Code yang dikirim via email untuk absensi.\\n\\nTerima kasih.\\\";s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-11-10 08:56:19.512545\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:12:\\\"Asia\\/Jakarta\\\";}}\"},\"createdAt\":1762741754,\"delay\":0}', 'Exception: Token tidak valid. in C:\\laragon\\www\\etiket\\app\\Jobs\\KirimWhatsappPeserta.php:61\nStack trace:\n#0 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): App\\Jobs\\KirimWhatsappPeserta->handle()\n#1 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(43): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#2 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(96): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))\n#3 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#4 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(836): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#5 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(129): Illuminate\\Container\\Container->call(Array)\n#6 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(180): Illuminate\\Bus\\Dispatcher->Illuminate\\Bus\\{closure}(Object(App\\Jobs\\KirimWhatsappPeserta))\n#7 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(137): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(App\\Jobs\\KirimWhatsappPeserta))\n#8 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(133): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#9 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(134): Illuminate\\Bus\\Dispatcher->dispatchNow(Object(App\\Jobs\\KirimWhatsappPeserta), false)\n#10 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(180): Illuminate\\Queue\\CallQueuedHandler->Illuminate\\Queue\\{closure}(Object(App\\Jobs\\KirimWhatsappPeserta))\n#11 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(137): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(App\\Jobs\\KirimWhatsappPeserta))\n#12 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(127): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#13 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(68): Illuminate\\Queue\\CallQueuedHandler->dispatchThroughMiddleware(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(App\\Jobs\\KirimWhatsappPeserta))\n#14 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Jobs\\Job.php(102): Illuminate\\Queue\\CallQueuedHandler->call(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Array)\n#15 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(451): Illuminate\\Queue\\Jobs\\Job->fire()\n#16 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(401): Illuminate\\Queue\\Worker->process(\'database\', Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(Illuminate\\Queue\\WorkerOptions))\n#17 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(187): Illuminate\\Queue\\Worker->runJob(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), \'database\', Object(Illuminate\\Queue\\WorkerOptions))\n#18 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(148): Illuminate\\Queue\\Worker->daemon(\'database\', \'default\', Object(Illuminate\\Queue\\WorkerOptions))\n#19 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(131): Illuminate\\Queue\\Console\\WorkCommand->runWorker(\'database\', \'default\')\n#20 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): Illuminate\\Queue\\Console\\WorkCommand->handle()\n#21 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(43): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#22 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(96): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))\n#23 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#24 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(836): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#25 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(211): Illuminate\\Container\\Container->call(Array)\n#26 C:\\laragon\\www\\etiket\\vendor\\symfony\\console\\Command\\Command.php(318): Illuminate\\Console\\Command->execute(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#27 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(180): Symfony\\Component\\Console\\Command\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#28 C:\\laragon\\www\\etiket\\vendor\\symfony\\console\\Application.php(1073): Illuminate\\Console\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#29 C:\\laragon\\www\\etiket\\vendor\\symfony\\console\\Application.php(356): Symfony\\Component\\Console\\Application->doRunCommand(Object(Illuminate\\Queue\\Console\\WorkCommand), Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#30 C:\\laragon\\www\\etiket\\vendor\\symfony\\console\\Application.php(195): Symfony\\Component\\Console\\Application->doRun(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#31 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Console\\Kernel.php(197): Symfony\\Component\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#32 C:\\laragon\\www\\etiket\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Application.php(1235): Illuminate\\Foundation\\Console\\Kernel->handle(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#33 C:\\laragon\\www\\etiket\\artisan(16): Illuminate\\Foundation\\Application->handleCommand(Object(Symfony\\Component\\Console\\Input\\ArgvInput))\n#34 {main}', '2025-11-10 02:29:17');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2024_01_01_100000_create_departemen_table', 1),
(5, '2024_01_01_100001_create_plant_table', 1),
(6, '2024_01_01_100002_create_pengguna_table', 1),
(7, '2024_01_01_100003_create_karyawan_table', 1),
(8, '2024_01_01_100004_create_absen_table', 1),
(9, '2024_11_05_150000_add_email_and_no_telp_to_karyawan_table', 2),
(10, '2025_11_10_073327_rename_karyawan_to_peserta_and_update_columns', 3),
(11, '2025_11_10_075650_rename_id_karyawan_to_id_peserta_in_absen_table', 4);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pengguna`
--

CREATE TABLE `pengguna` (
  `id` bigint UNSIGNED NOT NULL,
  `id_departemen` bigint UNSIGNED NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_lengkap` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `plant` int DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pengguna`
--

INSERT INTO `pengguna` (`id`, `id_departemen`, `username`, `password`, `nama_lengkap`, `email`, `plant`, `email_verified_at`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 1, 'mwt-iqbal', '$2y$10$VE0qayIK/SE1eHl.fQkruuBD//0t9UCEUWlrOt9QTseh5HPieLrMi', 'Iqbal Febian', 'iqbalfebian.krw@gmail.com', 1, '2025-04-10 11:58:53', 'HWfXL3DjZNVpTYu2fBZrgJl6vARPpIHr3YW1738LNK6wSKwsxippKpgBt2wX', '2024-01-12 00:09:22', '2025-04-16 22:36:56'),
(11, 8, 'mwt-heckel', '$2y$10$EyShL3yLFfhQbhL2BGK9cujFxXJEypwkoF2hnJUEuWKDIl9ALUpSi', 'Heckel', 'heckel@gmail.com', 1, '2025-04-10 11:58:54', NULL, '2025-04-10 11:58:58', '2025-04-10 11:58:58'),
(13, 4, 'mwt-dila', '$2y$10$/W4mtmHZwNc9gz0ZENv9aO6qJA7rmmrtWMo7aEWewnisJgC3l6k96', 'Dila', 'dila@gmail.com', 1, '2025-04-16 22:38:42', NULL, '2025-04-16 22:38:45', '2025-04-16 22:38:46'),
(15, 10, 'mwt-andri', '$2y$10$KEnszWTD2uiD6KAWm/1/IOGVxShlEylBVYhyCpAQkU6esRBy4sHta', 'Andri', 'andri@gmail.com', 1, '2025-04-17 00:02:14', NULL, '2025-04-17 00:02:18', '2025-04-17 00:02:19'),
(16, 4, 'mwt-soffah', '$2y$10$THSscqTCvm8RG0vTGHw7XO5Qqngrul7TTlB1gjmSSuR00QC/VDXqi', 'Soffah', 'soffah@gmail.com', 1, '2025-04-17 00:03:13', NULL, '2025-04-17 00:03:14', '2025-04-17 00:03:16'),
(17, 12, 'mwt-ade', '$2y$12$VTodMmBtYhPMoLDH5qmz.ud.mLUcQAL1bxy9i1HEQoJaWokYiZzim', 'Ade', 'ade@gmail.com', 1, '2025-04-17 00:03:44', NULL, '2025-04-17 00:03:45', '2025-05-13 06:12:32'),
(19, 1, 'superadmin', '$2y$10$jsRD0LBCOBj4s6BBM.KpQO95ZDPoG4P5Ha2LwKOh2C6RuJVqTNTbK', 'Superadmin', NULL, 1, '2025-05-08 23:49:45', NULL, '2025-05-08 23:49:51', '2025-05-08 23:49:52'),
(22, 1, 'mwt-it', '$2y$12$Gh3GEBbSniC72b8rlaE2WOC8ga7Xv7vY9gOVLjV0elJvgigLg/tee', 'IT Kabag', NULL, 1, NULL, NULL, '2025-06-16 05:34:56', '2025-06-16 05:34:56'),
(23, 10, 'mwt-winda', '$2y$12$zJYtSWuSGmt8a.H4TOHkg.LrBR7vkws9aKQmXdBTRdbCLSB6e/sZO', 'Winda', 'winda@mwtpart.co.id', 1, NULL, NULL, '2025-07-02 03:53:29', '2025-07-02 03:53:29'),
(24, 8, 'mwt-hendra', '$2y$12$.AXIzvkoWxFKnUx2YU//fO1o9XKXJ8VKHPMZ65R0n3bLO5Slmrqou', 'Hendra G', 'hendra@mwtpart.co.id', 1, NULL, NULL, '2025-07-04 03:35:00', '2025-07-04 03:35:00'),
(25, 1, 'admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Administrator', 'admin@mwt.com', 1, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `peserta`
--

CREATE TABLE `peserta` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_lengkap` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_peserta` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_kirim_email` tinyint(1) NOT NULL DEFAULT '0',
  `no_hp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_kirim_whatsapp` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `peserta`
--

INSERT INTO `peserta` (`id`, `nama_lengkap`, `no_peserta`, `email`, `status_kirim_email`, `no_hp`, `status_kirim_whatsapp`, `created_at`, `updated_at`) VALUES
(5041, 'ARDYAN SYAHPUTRA', '3645.250228.CKR', 'ardyansyahputra174@gmail.com', 1, '082112960919', 1, '2025-11-10 00:59:15', '2025-11-10 02:32:24'),
(5042, 'IQBAL FEBIAN', '3075.231201.CKR', 'iqbalfebian.krw@gmail.com', 1, '085156587124', 1, '2025-11-10 01:04:25', '2025-11-10 03:06:36'),
(5043, 'ALDI KURNIA YULIANA', '2862.230628.CKR', 'aldi@mwtpart.co.id', 1, '081223155139', 1, '2025-11-10 01:04:25', '2025-11-10 03:07:53'),
(5044, 'SARYA ADIANA', '1971.201208.CKR', 'saryaadiana@gmail.com', 1, '089619696512', 1, '2025-11-10 01:04:25', '2025-11-10 03:09:21'),
(5045, 'SISAM HIDAYAT', '0668.150223.CKR', 'qmsp3@mwtpart.co.id', 1, '082310240642', 1, '2025-11-10 01:04:25', '2025-11-10 03:10:31'),
(5046, 'MOH. AGUNG SUSWANTO', '3414.240902.CKR', 'agung.office109@gmail.com', 1, '082249973301', 1, '2025-11-10 01:04:25', '2025-11-10 03:11:41'),
(5047, 'HAFIZH AYYASY PRATAMA', '1126.25.PSG', NULL, 0, '089606184477', 1, '2025-11-10 01:04:25', '2025-11-10 02:34:47');

-- --------------------------------------------------------

--
-- Table structure for table `plant`
--

CREATE TABLE `plant` (
  `id` bigint UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kota` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `area` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode_area` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nomor` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `plant`
--

INSERT INTO `plant` (`id`, `nama`, `kota`, `area`, `kode_area`, `nomor`, `kode`, `alamat`, `created_at`, `updated_at`) VALUES
(1, 'Plant 1', 'Cikarang', 'Gemalapik', 'GMP', '01', 'P1', 'Jl.Gemalapik, Kawasan Karyadeka Pancamurni Kav. C3 Desa Pasirsari Kec. Cikarang Selatan Kab. Bekasi', NULL, NULL),
(2, 'Plant 2', 'Bandung', 'Bandung', 'BDG', '02', 'P2', 'Jl. Raya Nanjung Cisaat No.25 RT 01/01 Kp. Sukawangi Desa Jelegong Kec. Kutawaringin Kab. Bandung Telp. 022 6866 210 , Fax. 022 6866 211', NULL, NULL),
(3, 'Plant 3', 'Cikarang', 'Pasirgombong', 'PSG', '03', 'P3', 'Jl. Industri Kp. Sempu RT 01/03 Desa Pasirgombong Kec. Cikarang Utara Kab. Bekasi Telp. 021 8910 3070, Fax. 021 8910 3069', NULL, NULL),
(4, 'Plant 4', 'Cikarang', 'Jababeka', 'JBK', '04', 'P4', 'Jl. Tekno 5 Blok E 1 C-D Kawasan Industri Jababeka Tahap III Desa Pasir Gombong, Kec. Cikarang Utara Kab. Bekasi 17550', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('c3siySUTxav2e3xttWJixmzdL0yRZinmKUV1TFy2', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36 Edg/142.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiYVNjSmI0MmRucEx4dmNoWFpOZmsxeVJsNEVDV0JVaU5BNjE0bzVWTCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MTg6Imh0dHA6Ly9ldGlrZXQudGVzdCI7czo1OiJyb3V0ZSI7czoxMToiYWJzZW4uaW5kZXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1762744959);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absen`
--
ALTER TABLE `absen`
  ADD PRIMARY KEY (`id`),
  ADD KEY `absen_id_peserta_foreign` (`id_peserta`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `departemen`
--
ALTER TABLE `departemen`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pengguna_username_unique` (`username`),
  ADD KEY `pengguna_id_departemen_foreign` (`id_departemen`);

--
-- Indexes for table `peserta`
--
ALTER TABLE `peserta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `karyawan_nik_index` (`no_peserta`);

--
-- Indexes for table `plant`
--
ALTER TABLE `plant`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `absen`
--
ALTER TABLE `absen`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `departemen`
--
ALTER TABLE `departemen`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `peserta`
--
ALTER TABLE `peserta`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5048;

--
-- AUTO_INCREMENT for table `plant`
--
ALTER TABLE `plant`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `absen`
--
ALTER TABLE `absen`
  ADD CONSTRAINT `absen_id_peserta_foreign` FOREIGN KEY (`id_peserta`) REFERENCES `peserta` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pengguna`
--
ALTER TABLE `pengguna`
  ADD CONSTRAINT `pengguna_id_departemen_foreign` FOREIGN KEY (`id_departemen`) REFERENCES `departemen` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
