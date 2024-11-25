-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 26, 2024 at 01:32 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `travel`
--

-- --------------------------------------------------------

--
-- Table structure for table `about_us`
--

CREATE TABLE `about_us` (
  `about_id` int(11) NOT NULL,
  `about_head` varchar(255) NOT NULL,
  `about_subhead` varchar(255) NOT NULL,
  `about_text` varchar(1000) NOT NULL,
  `about_img` varchar(255) NOT NULL,
  `about_img2` varchar(255) NOT NULL,
  `about_img3` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `about_us`
--

INSERT INTO `about_us` (`about_id`, `about_head`, `about_subhead`, `about_text`, `about_img`, `about_img2`, `about_img3`) VALUES
(7, 'ABOUT US', 'We Provide Best Tour Packages In Your Budget.', 'Founded in 2024, Travelers was  out of a passion for exploring the world and sharing those experiences with others. What started as a small venture with a few adventure enthusiasts has grown into a full fledged travel and tours company dedicated to providing exceptional travel experiences to our clients.Our mission is to create unforgettable travel experiences that inspire and enrich the lives of our clients. We strive to offer unique, personalized, and high quality travel services that cater to the diverse interests and needs of every traveler.', 'aboutimage/about.jpg', 'aboutimage/about-1.jpg', 'aboutimage/about-2.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `admin_user`
--

CREATE TABLE `admin_user` (
  `AdminID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Phone` varchar(15) DEFAULT NULL,
  `Role` varchar(255) DEFAULT 'Admin'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_user`
--

INSERT INTO `admin_user` (`AdminID`, `Name`, `Email`, `Password`, `Phone`, `Role`) VALUES
(17, 'fatima', 'fatima@gmail.com', '125', '03214567123', 'Admin'),
(18, 'taha', 'tahaaman26@gmail.com', '125', '03132426124', 'Admin'),
(21, 'ayesha', 'ayesha12@gmail.com', '125', '03426754128', 'Admin');

-- --------------------------------------------------------

--
-- Table structure for table `blog`
--

CREATE TABLE `blog` (
  `blog_id` int(11) NOT NULL,
  `blog_date` varchar(255) NOT NULL,
  `blog_month` varchar(255) NOT NULL,
  `blog_head` varchar(255) NOT NULL,
  `blog_text` varchar(255) NOT NULL,
  `blog_desc` varchar(10000) NOT NULL,
  `img1` varchar(255) NOT NULL,
  `img2` varchar(255) NOT NULL,
  `img3` varchar(255) NOT NULL,
  `blog_img` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blog`
--

INSERT INTO `blog` (`blog_id`, `blog_date`, `blog_month`, `blog_head`, `blog_text`, `blog_desc`, `img1`, `img2`, `img3`, `blog_img`) VALUES
(11, '01', 'Jan', 'Exploring the Enchanting Skardu: A Traveler’s Paradise', ' Skardu is Natural Wonders, Adventure,Cultural and Historical Sites', 'Nestled in the heart of Gilgit-Baltistan, Skardu is a breathtaking destination that beckons adventurers and nature lovers alike. With its towering mountains, crystal-clear lakes, and rich cultural heritage, Skardu offers a perfect blend of natural beauty and cultural experiences.Skardu is home to some of the most stunning natural landscapes in the world:Shangrila Resort (Lower Kachura Lake): Known as \"Heaven on Earth,\" this serene lake is surrounded by snow-capped peaks and lush greenery.\r\nSatpara Lake: A pristine lake that offers boating opportunities and panoramic views of the surrounding mountains.\r\nDeosai National Park: Often referred to as the \"Land of Giants,\" this park is a high-altitude alpine plain that is rich in wildlife and vibrant wildflowers.', 'aboutimage/blog-2.jpg', 'aboutimage/Shangrila-Resort-Skardu-.jpg', 'aboutimage/blog-3.jpg', 'aboutimage/Shangrila-Resort-Skardu-.jpg'),
(12, '10', 'Feb', 'Discover the Magic of Hunza Valley: A Travel Guide', 'Hunza is Scenic Beauty,Adventure Activities AndLocal Cuisine', 'Hunza Valley, often referred to as paradise on earth, is a hidden gem nestled in the northern region of Pakistan. With its stunning landscapes, rich culture, and warm hospitality, Hunza Valley offers a unique and unforgettable experience for travelers seeking adventure and tranquility.Hunza Valley is renowned for its breathtaking natural beauty:\r\n\r\nRakaposhi View Point: Enjoy panoramic views of Rakaposhi, one of the highest peaks in the world, standing majestically at 7,788 meters.\r\nAttabad Lake: A strikingly beautiful lake formed by a landslide in 2010, known for its vivid turquoise waters.', 'aboutimage/blog-1.jpg', 'aboutimage/100.jpg', 'aboutimage/hunza.jpg', 'aboutimage/hunza.jpg'),
(13, '10', 'March', 'Exploring the Majestic Faisal Mosque: A Symbol of Islamic Architecture', 'Faisla Mosque is Largest Mosque in Pakistan', 'Nestled at the foothills of the Margalla Hills in Islamabad, Faisal Mosque is a magnificent structure that stands as a testament to modern Islamic architecture. As the largest mosque in Pakistan and one of the largest in the world, Faisal Mosque is not only a place of worship but also a major tourist attraction.Faisal Mosque holds great historical and cultural significance:Inauguration: The mosque was inaugurated in 1986 and named after King Faisal of Saudi Arabia, who funded the project.', 'aboutimage/100.jpg', 'aboutimage/destination-4.jpg', 'aboutimage/faisal.jpg', 'aboutimage/faisal.jpg'),
(14, '01', 'June', 'Discovering the Enchanting Swat Valley: Pakistan Hidden Gem', 'Natural Beauty,Historical Significance And Must Visit Attractions', 'Nestled in the Khyber Pakhtunkhwa province of Pakistan, Swat Valley is a captivating destination renowned for its stunning landscapes, rich history, and vibrant culture. Often referred to as the \"Switzerland of the East,\" Swat Valley is a paradise for nature lovers, adventure seekers, and history enthusiasts.Swat Valley is blessed with an abundance of natural beauty:\r\nMajestic Mountains: The valley is surrounded by the towering peaks of the Hindu Kush range, offering breathtaking views and opportunities for trekking and mountaineering.', 'aboutimage/Clifton Beach.jpg', 'aboutimage/swat.jpg', 'aboutimage/package-3.jpg', 'aboutimage/swat.jpg'),
(15, '20', 'August', ' Exploring Shahi Qila (Lahore Fort): A Glimpse into Pakistan’s Majestic Past', 'Shahi Qila (Lahore Fort) Historical Significance', 'Shahi Qila, also known as Lahore Fort, stands as a testament to the grandeur and architectural brilliance of the Mughal Empire. Located in the heart of Lahore, this UNESCO World Heritage site is a treasure trove of history, culture, and stunning craftsmanship.Shahi Qila has a rich history that dates back to antiquity, with its most prominent features developed during the M\r\nMughal Era: The fort’s most notable expansions were made under the reign of Emperor Akbar in the 16th century, followed by further embellishments by Shah Jahan and Aurangzeb. Each emperor left his mark, resulting in a diverse blend of architectural styles.', 'aboutimage/hunza.jpg', 'aboutimage/Shangrila-Resort-Skardu-.jpg', 'aboutimage/lahore fort.jpg', 'aboutimage/lahore fort.jpg'),
(16, '20', 'August', 'Discovering Mohenjo-Daro: The Ancient Indus Valley Civilization', ' The optimal time to visit is between November and February when the weather is cooler.', 'Mohenjo-Daro, one of the most important archaeological sites in South Asia, provides a fascinating glimpse into the ancient Indus Valley Civilization. Located in the Sindh province of Pakistan, this UNESCO World Heritage site dates back to around 2500 BCE and showcases the advanced urban planning and sophisticated lifestyle of one of the world earliest civilizations.', 'aboutimage/mohenjodaro.jpg', 'aboutimage/Shangrila-Resort-Skardu-.jpg', 'aboutimage/swat.jpg', 'aboutimage/mohenjodaro.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `blog_form`
--

CREATE TABLE `blog_form` (
  `id` int(11) NOT NULL,
  `blog_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment` varchar(10000) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `parent_comment_id` varchar(1000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blog_form`
--

INSERT INTO `blog_form` (`id`, `blog_id`, `user_id`, `comment`, `created_at`, `parent_comment_id`) VALUES
(21, 11, 1, 'jhvdshg', '2024-07-28 19:45:31', NULL),
(23, 11, 1, 'okay', '2024-07-28 19:49:20', '21'),
(25, 12, 1, 'bhnvre', '2024-07-28 20:25:42', NULL),
(26, 12, 1, 'nhjmdvcfd', '2024-07-28 20:27:01', '25'),
(27, 12, 1, 'bvegwhfdew', '2024-07-28 20:27:10', '25'),
(28, 15, 24, 'rvwerew', '2024-08-24 10:18:43', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `confirmation_status` varchar(20) DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `payment_method`, `confirmation_status`, `created_at`) VALUES
(1, 'Easypaisa', 'pending', '2024-08-24 02:53:22'),
(2, 'JaazCash', 'pending', '2024-08-24 02:54:10'),
(3, 'Sadapay', 'pending', '2024-08-24 02:57:17'),
(4, 'Meezan Bank', 'pending', '2024-08-24 02:57:35');

-- --------------------------------------------------------

--
-- Table structure for table `city`
--

CREATE TABLE `city` (
  `CityID` int(11) NOT NULL,
  `CityName` varchar(255) NOT NULL,
  `Country` varchar(100) DEFAULT 'Pakistan'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `city`
--

INSERT INTO `city` (`CityID`, `CityName`, `Country`) VALUES
(1, 'Karachi', 'Pakistan'),
(3, 'Lahore', 'Pakistan'),
(4, 'Islamabad ', 'Pakistan'),
(5, 'Rawalpindi', 'Pakistan'),
(6, 'Faisalabad', 'Pakistan'),
(8, 'peshawar', 'Pakistan');

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `id` int(11) NOT NULL,
  `con_name` varchar(255) NOT NULL,
  `con_mail` varchar(255) NOT NULL,
  `con_sub` varchar(255) NOT NULL,
  `con_msg` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`id`, `con_name`, `con_mail`, `con_sub`, `con_msg`) VALUES
(1, 'taha', 'tahaaman26@gmail.com', 'Physics', 'dsfdsfs'),
(2, 'sami', 'sami@gmail.com', 'tour', 'hi how are you'),
(7, 'taha', 'tahaaman26@gmail.com', 'travel', 'dbtretret'),
(10, 'Taha Khan', 'tahaaman26@gmail.com', 'travelsrgtbreytne', 'bretyeytbert');

-- --------------------------------------------------------

--
-- Table structure for table `destination`
--

CREATE TABLE `destination` (
  `DestinationID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Description` text DEFAULT NULL,
  `Country` varchar(100) DEFAULT NULL,
  `State` varchar(100) DEFAULT NULL,
  `BestTimeToVisit` varchar(255) DEFAULT NULL,
  `Image1` varchar(255) DEFAULT NULL,
  `Image2` varchar(255) NOT NULL,
  `Image3` varchar(255) NOT NULL,
  `CardImage` varchar(255) DEFAULT NULL,
  `CityID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `destination`
--

INSERT INTO `destination` (`DestinationID`, `Name`, `Description`, `Country`, `State`, `BestTimeToVisit`, `Image1`, `Image2`, `Image3`, `CardImage`, `CityID`) VALUES
(29, 'Clifton Beach', ' Clifton Beach, located along the Arabian Sea in Karachi, is one of the most popular beaches in Pakistan. It is known for its bustling atmosphere, where visitors can enjoy camel and horse rides, as well as a variety of local street food. The beach is a favorite spot for families and friends to gather for picnics and leisure activities.\r\n\r\nIn addition to its natural beauty, Clifton Beach offers a range of recreational activities, including beach volleyball and motorboat rides. The scenic views of the sunset over the Arabian Sea make it an ideal place for evening walks. Despite its popularity, the beach maintains a serene and relaxing environment, making it a must-visit destination in Karachi.', 'Pakistan', 'Sindh', 'November to March', 'images/Clifton Beach 1.jpg', 'images/Clifton Beach 2.jpg', 'images/Clifton Beach 3.jpg', 'images/Clifton Beach 1.jpg', 1),
(30, 'Mohatta Palace', 'The Mohatta Palace, built in 1927, is a stunning example of Indo-Saracenic architecture in Karachi. Originally constructed as a summer residence for the affluent businessman Shivratan Chandraratan Mohatta, the palace now serves as a museum. The intricate design and craftsmanship of the building reflect the rich cultural heritage of the region.\r\n\r\nVisitors to Mohatta Palace can explore various exhibits showcasing Pakistans history and art. The beautifully landscaped gardens and the grandeur of the palace provide a glimpse into the opulent lifestyle of its former inhabitants. The palace is not only a historical monument but also a hub for cultural events and exhibitions.', ' Pakistan', 'Sindh', 'October to April', 'images/Mohatta Palace 1.jpg', 'images/Mohatta Palace 2.jpg', 'images/Mohatta Palace 3.jpg', 'images/Mohatta Palace 2.jpg', 1),
(31, 'Mazar-e-Quaid', ' Mazar-e-Quaid, also known as the Jinnah Mausoleum, is the final resting place of Pakistans founding father, Muhammad Ali Jinnah. Located in Karachi, the mausoleum is an iconic symbol of the nations heritage. The white marble structure, with its striking dome and beautiful gardens, attracts visitors from all over the country.\r\n\r\nThe site is not only a place of historical significance but also a serene environment where people come to pay their respects to Jinnah. The mausoleum is surrounded by a lush green park, providing a tranquil setting for reflection. Mazar-e-Quaid stands as a testament to Jinnahs legacy and his role in the creation of Pakistan.', 'Pakistan', 'Sindh', 'November to March', 'images/Mazar-e-Quaid 1.jpg', 'images/Mazar-e-Quaid 2.jpg', 'images/Mazar-e-Quaid 3.jpg', 'images/Mazar-e-Quaid 3.jpg', 1),
(32, 'Badshahi Mosque', 'The Badshahi Mosque in Lahore is one of the largest and most magnificent mosques in the world. Built in 1673 by Mughal Emperor Aurangzeb, it is an architectural masterpiece that showcases the grandeur of Mughal design. The mosques vast courtyard and intricately decorated prayer hall can accommodate thousands of worshippers.\r\n\r\nThe Badshahi Mosque is not only a place of worship but also a major tourist attraction. Visitors are awed by its beautiful red sandstone structure, marble inlay work, and stunning minarets. The mosque offers a serene and spiritual atmosphere, making it a must-visit destination for those exploring Lahores rich history and culture.', 'Pakistan', 'Punjab', 'October to March', 'images/Badshahi Mosque 1.jpg', 'images/Badshahi Mosque 2.jpg', 'images/Badshahi Mosque 3.jpg', 'images/Badshahi Mosque 3.jpg', 3),
(33, 'Lahore Fort', 'The Lahore Fort, also known as Shahi Qila, is a UNESCO World Heritage site and one of Lahores most significant historical landmarks. Built during the Mughal era, the fort has been expanded and renovated by various rulers over the centuries. It features a complex of beautiful palaces, gardens, and pavilions that reflect the architectural brilliance of the Mughal dynasty.\r\n\r\nVisitors to Lahore Fort can explore its many attractions, including the Sheesh Mahal (Palace of Mirrors), Naulakha Pavilion, and the Moti Masjid (Pearl Mosque). The fort rich history and majestic structures provide a fascinating insight into the grandeur of Mughal architecture. The site is a testament to the cultural and historical legacy of Lahore.', 'Pakistan', 'Punjab', 'October to March', 'images/Lahore Fort 1.jpg', 'images/Lahore Fort 2.jpg', 'images/Lahore Fort 3.jpg', 'images/Lahore Fort 2.jpg', 3),
(34, 'Shalimar Gardens', 'The Shalimar Gardens in Lahore are a stunning example of Mughal garden design. Built in 1641 by Emperor Shah Jahan, the gardens are a perfect blend of nature and architecture. The layout includes three terraces with intricately designed fountains, marble pavilions, and lush greenery, offering a serene and picturesque environment.\r\n\r\nThe gardens are a popular spot for both locals and tourists, providing a peaceful retreat from the hustle and bustle of the city. Visitors can enjoy leisurely strolls along the pathways, take in the beauty of the floral displays, and relax by the flowing water features. Shalimar Gardens are a testament to the Mughals love for nature and artistic expression.', 'Pakistan', 'Punjab', 'October to March', 'images/Shalimar Gardens 1.jpg', 'images/Shalimar Gardens 2.jpg', 'images/Shalimar Gardens 3.jpg', 'images/Shalimar Gardens 3.jpg', 3),
(38, 'Faisal Mosque', 'The Faisal Mosque in Islamabad is the largest mosque in Pakistan and a major landmark of the city. Designed by Turkish architect Vedat Dalokay, the mosques unique and modern design resembles a Bedouin tent. It was completed in 1986 and funded by Saudi King Faisal bin Abdul-Aziz, after whom it is named.\r\n\r\n The mosques stunning architecture and serene surroundings at the foothills of the Margalla Hills make it a popular destination for both worshippers and tourists. The mosques prayer hall can accommodate over 10,000 people, while its vast courtyard and adjoining grounds provide additional space for thousands more. The Faisal Mosque is an iconic symbol of Islamabad and a testament to the citys cultural and religious significance.', 'Pakistan', 'Islamabad Capital Territory', 'October to March', 'images/Faisal Mosque 1.jpg', 'images/Faisal Mosque 2.jpg', 'images/Faisal Mosque 3.jpg', 'images/Faisal Mosque 1.jpg', 4),
(39, 'Daman-e-Koh', 'Daman-e-Koh is a popular viewpoint in Islamabad, located in the Margalla Hills National Park. It offers panoramic views of the city, including the Faisal Mosque and Rawal Lake. The name Daman-e-Koh means foothills,and the location serves as a midpoint for those hiking up the Margalla Hills.\r\n The area is equipped with viewing decks, walking paths, and picnic spots, making it a favorite destination for families and tourists. The lush greenery, fresh air, and scenic beauty provide a perfect escape from the citys hustle and bustle. Wildlife enthusiasts can also spot various species of birds and animals native to the region.', 'Pakistan', 'Islamabad Capital Territory', 'October to March', 'images/Daman-e-Koh 1.jpg', 'images/Daman-e-Koh 2.jpg', 'images/Daman-e-Koh 3.jpg', 'images/Daman-e-Koh 1.jpg', 4),
(40, 'Pakistan Monument', 'The Pakistan Monument in Islamabad is a national symbol representing the country four provinces and three territories. It is situated on the western Shakarparian Hills and was designed by the renowned architect Arif Masood. The monuments unique petal-shaped structure symbolizes the unity of the Pakistani people.\r\n It features a museum that showcases the countrys rich cultural heritage and history. The Pakistan Monument offers a panoramic view of Islamabad, making it a popular spot for tourists and locals alike. The site is beautifully illuminated at night, adding to its charm and significance.', 'Pakistan', 'Islamabad Capital Territory', 'October to March', 'images/Pakistan Monument 1.jpg', 'images/Pakistan Monument 2.jpg', 'images/Pakistan Monument 3.jpg', 'images/Pakistan Monument 2.jpg', 4),
(42, 'Rawalpindi Cricket Stadium', 'The Rawalpindi Cricket Stadium is a prominent cricket ground in Rawalpindi. It is known for hosting international cricket matches including Test matches One Day Internationals and T20s. The stadium has a seating capacity of over 15,000 spectators and provides modern facilities for players and fans alike.\r\n Apart from international matches the Rawalpindi Cricket Stadium also hosts domestic cricket tournaments and local matches. The stadiums vibrant atmosphere and enthusiastic crowd make it a thrilling experience for cricket lovers. It is a key venue for cricket in Pakistan contributing to the countrys rich sporting culture.', 'Pakistan', 'Punjab', 'October to March', 'images/Rawalpindi Cricket Stadium 1.jpg', 'images/Rawalpindi Cricket Stadium 2.jpg', 'images/Rawalpindi Cricket Stadium 3.jpg', 'images/Rawalpindi Cricket Stadium 1.jpg', 5),
(43, 'Jinnah Park', 'Jinnah Park in Rawalpindi is a popular recreational spot named after the founder of Pakistan Muhammad Ali Jinnah. The park features well-manicured lawns jogging tracks and childrens play areas. It also houses a cinema restaurants and an amusement park making it a complete entertainment package for visitors of all ages.\r\n The parks peaceful ambiance and beautiful landscaping provide a relaxing environment for families and friends. It is a great place for picnics outdoor activities and social gatherings. Jinnah Parks diverse attractions make it one of the most visited parks in Rawalpindi offering something for everyone.', 'Pakistan', 'Punjab', 'October to March', 'images/Jinnah Park 1.jpg', 'images/Jinnah Park 2.jpg', 'images/Jinnah Park 3.jpg', 'images/Jinnah Park 3.jpg', 5),
(44, 'Clock Tower', 'The Clock Tower also known as Ghanta Ghar is the most iconic landmark in Faisalabad. Built during the British colonial era it stands at the center of the city and is surrounded by eight bazaars. The Clock Tower symbolizes the rich history and cultural heritage of Faisalabad and is a must-visit for anyone exploring the city. \r\nThe eight bazaars around the Clock Tower are named after different directions and are known for their vibrant atmosphere and variety of goods. Visitors can explore these bustling markets which offer everything from textiles and clothing to electronics and spices. The Clock Tower area is a hub of commercial activity and a reflection of Faisalabads dynamic spirit.', 'Pakistan', 'Punjab', 'October to March', 'images/Clock Tower 1.jpg', 'images/Clock Tower 2.jpg', 'images/Clock Tower 3.jpg', 'images/Clock Tower 1.jpg', 6),
(45, 'Lyallpur Museum', 'Lyallpur Museum in Faisalabad is dedicated to preserving and showcasing the citys history and cultural heritage. The museum features a wide range of exhibits including artifacts photographs and documents that tell the story of Faisalabads evolution from a small town to a major industrial city. It is a valuable resource for anyone interested in the regions history.\r\n The museum is named after the citys original name Lyallpur and offers a comprehensive overview of its development. Visitors can learn about the various aspects of Faisalabads past including its agricultural roots industrial growth and cultural milestones. Lyallpur Museum is a fascinating destination for history enthusiasts and anyone looking to understand the citys heritage.', 'Pakistan', 'Punjab', 'October to March', 'images/Lyallpur Museum 1.jpg', 'images/Lyallpur Museum 2.jpg', 'images/Lyallpur Museum 3.jpg', 'images/Lyallpur Museum 1.jpg', 6),
(48, 'Ibn-e-Qasim Park ', 'Ibn-e-Qasim Park is a well-loved green space in the heart of Faisalabad, offering a serene escape from the city\'s bustle. This spacious park features lush lawns, vibrant flower beds, and shady trees, creating a peaceful environment for relaxation and leisure. Visitors can enjoy walking or jogging along dedicated tracks, while families can take advantage of the playgrounds equipped with modern play structures. The park also includes picnic areas with ample seating, where families and friends can gather for meals and enjoy the tranquil surroundings. With its decorative fountains and water features adding to the park’s charm, Ibn-e-Qasim Park serves as a popular destination for fitness, family outings, and community events, making it a cherished spot for all ages.', NULL, 'Punjab', 'November to March', 'images/3405702862_70f16a869d_b.jpg', 'images/pakistan_1757db2a4a6_large.jpg', 'images/Baghibnqasim.jpg', 'images/3405702862_70f16a869d_b.jpg', 6),
(49, 'islamic college', 'hdbsfhds', NULL, 'kpk', 'May to October', 'images/3405702862_70f16a869d_b.jpg', 'images/Badshahi Mosque 3.jpg', 'images/Baghibnqasim.jpg', 'images/3405702862_70f16a869d_b.jpg', 8);

-- --------------------------------------------------------

--
-- Table structure for table `destination_comments`
--

CREATE TABLE `destination_comments` (
  `id` int(11) NOT NULL,
  `destination_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `parent_comment_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `destination_comments`
--

INSERT INTO `destination_comments` (`id`, `destination_id`, `user_id`, `comment`, `created_at`, `parent_comment_id`) VALUES
(50, 41, 17, ' vvnb fcn', '2024-08-04 07:21:26', NULL),
(51, 43, 17, 'okay', '2024-08-04 07:26:47', NULL),
(52, 43, 17, 'nbmnvb', '2024-08-16 06:23:58', NULL),
(53, 43, 24, 'rebtrt', '2024-08-24 05:18:49', NULL),
(54, 43, 24, 'ewvrwe', '2024-08-24 05:18:53', 43),
(55, 31, 24, 'dbcjghdehc', '2024-08-24 07:28:03', NULL),
(56, 33, 24, 'fhcghffrh', '2024-08-24 07:47:33', NULL),
(57, 44, 24, 'grbrgbg\r\n', '2024-08-24 08:10:15', NULL),
(58, 48, 24, 'nhd', '2024-08-24 08:17:05', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `facility`
--

CREATE TABLE `facility` (
  `FacilityID` int(11) NOT NULL,
  `FacilityName` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `facility`
--

INSERT INTO `facility` (`FacilityID`, `FacilityName`) VALUES
(1, 'Swimming Pool'),
(2, 'Air Conditioning/Heating'),
(3, 'TV'),
(4, 'Private Bathroom'),
(5, 'Room Service'),
(10, 'Desk/Work Area'),
(11, 'Bed Types'),
(12, 'Minibar/Refrigerator'),
(13, 'Safe'),
(14, 'Hair Dryer'),
(15, 'Iron/Ironing Board'),
(16, 'Restaurant/Dining'),
(17, 'Bar/Lounge'),
(18, 'Fitness Center/Gym'),
(19, 'Swimming Pool'),
(20, 'Spa/Wellness Center'),
(21, 'Business Center'),
(22, 'Laundry Service'),
(23, 'Concierge'),
(24, 'Airport Shuttle'),
(25, 'Parking'),
(26, '24-Hour Reception'),
(27, 'Event/Meeting Rooms'),
(28, 'Wheelchair Access'),
(29, 'Elevators'),
(30, 'Accessible Bathrooms'),
(31, 'Smoke Detectors'),
(32, 'Security Cameras'),
(33, 'Emergency Exits');

-- --------------------------------------------------------

--
-- Table structure for table `faqs`
--

CREATE TABLE `faqs` (
  `faq_id` int(11) NOT NULL,
  `faq_ques` varchar(255) NOT NULL,
  `faq_ans` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faqs`
--

INSERT INTO `faqs` (`faq_id`, `faq_ques`, `faq_ans`) VALUES
(2, 'How can I book a trip with Travelers?', 'You can book a trip by contacting us via email, phone, or through our website booking form. Our travel consultants will assist you in planning and booking your trip based on your preferences and needs.'),
(3, 'Can I customize my tour package?', 'Yes, absolutely! We specialize in creating customized tour packages tailored to your interests, schedule, and budget. Simply let us know your preferences, and we will design a personalized itinerary for you.'),
(4, 'What is included in your tour packages?', 'Our tour packages typically include accommodation, transportation, guided tours, and some meals. The specific inclusions depend on the package and destination. For detailed information on what included, please refer to the individual tour package descriptions or contact us.'),
(5, 'Are your tours suitable for solo travelers?', 'Yes, we welcome solo travelers on our tours. We offer group tours where you can meet and connect with fellow travelers. Additionally, we can create personalized itineraries for solo travelers who prefer a private experience.'),
(6, 'What should I do if I need to cancel or change my booking?', 'If you need to cancel or change your booking, please contact us as soon as possible. Our cancellation and change policies vary depending on the tour package and timing. We will provide you with the necessary information and assistance based on your situation.'),
(7, 'Do you offer travel insurance?', 'While we do not offer travel insurance directly, we strongly recommend that all travelers purchase travel insurance for their trips. Insurance can provide coverage for unexpected events such as trip cancellations, medical emergencies, and lost baggage.');

-- --------------------------------------------------------

--
-- Table structure for table `footer`
--

CREATE TABLE `footer` (
  `footer_id` int(255) NOT NULL,
  `footer_desc` varchar(255) NOT NULL,
  `footer_location` varchar(255) NOT NULL,
  `footer_num` int(15) NOT NULL,
  `footer_mail` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `footer`
--

INSERT INTO `footer` (`footer_id`, `footer_desc`, `footer_location`, `footer_num`, `footer_mail`) VALUES
(1, '\"Discover your next adventure with TravelExplorer! Our site offers detailed guides on top destinations, budget tips, and hotel options to help you plan the perfect trip.\"', 'Block-C Nazimabad, Karachi, Pakistan.', 2147483645, 'travelinfo@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `hotel`
--

CREATE TABLE `hotel` (
  `HotelID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Description` mediumtext NOT NULL,
  `Address` text DEFAULT NULL,
  `ContactInfo` varchar(255) DEFAULT NULL,
  `DestinationID` int(11) DEFAULT NULL,
  `Image1` varchar(255) DEFAULT NULL,
  `Image2` varchar(255) NOT NULL,
  `Image3` varchar(255) NOT NULL,
  `CardImage` varchar(255) NOT NULL,
  `CityID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hotel`
--

INSERT INTO `hotel` (`HotelID`, `Name`, `Description`, `Address`, `ContactInfo`, `DestinationID`, `Image1`, `Image2`, `Image3`, `CardImage`, `CityID`) VALUES
(10, 'Heavenly Stays', 'Set in Karachi, 600 metres from Seaview Beach, Heavenly Stays offers accommodation with a shared lounge, free private parking and a terrace. This 4-star hotel offers room service, a 24-hour front desk and free WiFi. The hotel has family rooms.\r\n\r\nSome rooms also feature a kitchen with a fridge and a microwave. At the hotel the rooms are equipped with air conditioning and a flat-screen TV.\r\n\r\nHeavenly Stays offers an American or halal breakfast.\r\n\r\nThe nearest airport is Jinnah International Airport, 24 km from the accommodation.', 'Heavenly Stays | North Nazimabad Town, Karachi', '+92 3311166546', NULL, 'images/hotel1_3.jpg', 'images/hotel1_1.jpg', 'images/hotel1_2.jpg', 'images/hotel1_3.jpg', 1),
(11, 'Hotel Aladin In Karachi', 'Hotel Aladin In Karachi features a garden, terrace, a restaurant and bar in Karachi. This 5-star hotel offers room service and a 24-hour front desk. The hotel has family rooms.\r\n\r\nAt the hotel, all rooms have a balcony. At Hotel Aladin In Karachi, every room is fitted with air conditioning and a flat-screen TV.\r\n\r\nThe nearest airport is Jinnah International Airport, 6 km from the accommodation.', 'Rashid Minhas Road Block 11 Gulshan-e-Iqbal, Karachi,, 75300 Karachi, Pakistan', '+92 3311166542', NULL, 'images/hotel2_1.jpg', 'images/hotel2_2.jpeg', 'images/hotel1_4.jpg', 'images/hotel2_2.jpeg', 1),
(12, 'Ambiance Boutique Art Hotel Karachi', 'Situated in Karachi, 2.7 km from Seaview Beach, Ambiance Boutique Art Hotel Karachi features accommodation with a garden, free private parking, a shared lounge and a terrace. This 5-star hotel offers a concierge service. The accommodation provides a 24-hour front desk, airport transfers, room service and free WiFi throughout the property.\r\n\r\nThe hotel will provide guests with air-conditioned rooms offering a wardrobe, a kettle, a fridge, a minibar, a safety deposit box, a flat-screen TV and a private bathroom with a shower. At Ambiance Boutique Art Hotel Karachi the rooms have bed linen and towels.\r\n\r\nAn à la carte, continental or Full English/Irish breakfast is available each morning at the property. At the accommodation you will find a restaurant serving Mediterranean cuisine. Vegetarian, dairy-free and halal options can also be requested.\r\n', 'F-177 Block 5 Clifton, Clifton, 74000 Karachi, Pakistan', '+92 3311166589', NULL, 'images/hotel3_1.jpg', 'images/hotel3_3.jpg', 'images/hotel3_6.jpg', 'images/hotel3_1.jpg', 1),
(13, 'Serenity Corner', 'Boasting air-conditioned accommodation with a balcony, Serenity Corner is situated in Islamabad. It is located 21 km from Shah Faisal Mosque and provides a 24-hour front desk. The apartment also features free WiFi, free private parking and facilities for disabled guests.\r\n\r\nThe spacious apartment features 2 bedrooms, 2 bathrooms, bed linen, towels, a flat-screen TV with streaming services, a dining area, a fully equipped kitchen, and a terrace with mountain views. Guests can take in the views of the garden from the patio, which also has outdoor furniture. For added privacy, the accommodation has a private entrance and is protected by full-day security.\r\n\r\nA minimarket is available at the apartment.\r\n\r\nThe area is popular for hiking, and car hire is available at the apartment. Guests can relax in the garden at the property.\r\n\r\nTaxila Museum is 18 km from Serenity Corner, while Ayūb National Park is 19 km from the property. The nearest airport is Islamabad International, 18 km from the accommodation, and the property offers a paid airport shuttle service.', 'Street 4 Zarkoon Hights, 44000 Islamabad, Pakistan', '+92 3311176520', NULL, 'images/hotel4_4.jpg', 'images/hotel4_1.jpg', 'images/hotel4_2.jpg', 'images/hotel4_4.jpg', 4),
(14, 'Sky Rise Executive Apartments Facing Centaurus Mall Islambad', 'Offering garden views and a garden, Sky Rise Executive Apartments Facing Centaurus Mall Islambad is set in the Blue Area district of Islamabad, 3.5 km from Shah Faisal Mosque and 12 km from Lake View Park. This property offers access to a balcony and free private parking. The apartment offers mountain views, a sun terrace, a 24-hour front desk, and free WiFi is available throughout the property.\r\n\r\nAll units at the apartment complex come with air conditioning, a seating area, a flat-screen TV with streaming services, a kitchen, a dining area, a safety deposit box and a private bathroom with a bath, bathrobes and slippers. A dishwasher, an oven and microwave are also offered, as well as a coffee machine and a kettle. At the apartment complex, the units include bed linen and towels.\r\n\r\nÀ la carte and continental breakfast options with warm dishes, local specialities and fresh pastries are available every morning at the apartment. The family-friendly restaurant at Sky Rise Executive Apartments Facing Centaurus Mall Islambad specialises in Italian cuisine, and is open for dinner and lunch.\r\n\r\nFor guests with children, the accommodation provides a baby safety gate. A car rental service is available at Sky Rise Executive Apartments Facing Centaurus Mall Islambad.\r\n\r\nAyūb National Park is 19 km from the apartment, while Taxila Museum is 36 km from the property. The nearest airport is Islamabad International, 31 km from Sky Rise Executive Apartments Facing Centaurus Mall Islambad, and the property offers a paid airport shuttle service.', 'Elysium Tower Opposite Centaurus Mall Islambad, Blue Area, 44000 Islamabad, Pakistan', '+92 3318961082', NULL, 'images/hotel5_2.jpg', 'images/hotel5_1.jpg', 'images/hotel5_5.jpg', 'images/hotel5_2.jpg', 4),
(15, 'Hazelton Hotel', 'Situated in Islamabad, 4.3 km from Shah Faisal Mosque, Hazelton Hotel features accommodation with a garden, free private parking, a shared lounge and a restaurant. This 3-star hotel offers room service and an ATM. The accommodation offers a 24-hour front desk, airport transfers, a shared kitchen and free WiFi throughout the property.\r\n\r\nThe hotel will provide guests with air-conditioned rooms offering a desk, a coffee machine, a fridge, a dishwasher, a safety deposit box, a flat-screen TV, a terrace and a private bathroom with a bidet. Hazelton Hotel provides some rooms with city views, and every room comes with a balcony. At the accommodation rooms are equipped with bed linen and towels.\r\n\r\nThe daily breakfast offers buffet, continental or Asian options.\r\n\r\nPopular points of interest near Hazelton Hotel include Shalimar Cricket Ground, Saidpur Village and Khaas Art Gallery. The nearest airport is Islamabad International Airport, 35 km from the hotel.', '4 Hill Road, F-6 Sector, 44000 Islamabad, Pakistan', '+92 333855671', NULL, 'images/hotel6_1.jpg', 'images/hotel6_4.jpg', 'images/hotel6_5.jpg', 'images/hotel6_1.jpg', 4),
(16, 'Best Western Premier Hotel Gulberg Lahore', 'Set in Lahore, 30 km from Wagah Border, Best Western Premier Hotel Gulberg Lahore offers accommodation with a fitness centre, free private parking, a terrace and a restaurant. The property is around 2.5 km from Gaddafi Stadium, 5.7 km from Packages Mall and 6 km from Nairang Galleries. The accommodation provides a 24-hour front desk, airport transfers, room service and free WiFi.\r\n\r\nA buffet, à la carte or continental breakfast is available every morning at the property.\r\n\r\nYou can play billiards at this 4-star hotel, and car hire is available.\r\n\r\nLahore Polo Club is 8 km from the hotel, while Bagh-e-Jinnah is 8.1 km away. The nearest airport is Allama Iqbal International Airport, 6 km from Best Western Premier Hotel Gulberg Lahore.', 'Alam Road Gulberg 3, Gulberg, 54660 Lahore, Pakistan', '+92 3432425128', NULL, 'images/WhatsApp Image 2024-07-18 at 3.36.44 AM.jpeg', 'images/WhatsApp Image 2024-07-18 at 3.36.44 AM (1).jpeg', 'images/WhatsApp Image 2024-07-18 at 3.36.45 AM.jpeg', 'images/WhatsApp Image 2024-07-18 at 3.36.44 AM.jpeg', 3),
(17, 'Gold Crest Luxurious Apartments DHA Lahore by LMY', 'Located 33 km from Wagah Border, Gold Crest Luxurious Apartments DHA Lahore by LMY offers air-conditioned accommodation with a terrace. With city views, this accommodation offers a balcony. The apartment also provides free WiFi, free private parking and facilities for disabled guests.\r\n\r\nFeaturing a well-fitted kitchen with a toaster and a fridge, each unit also comes with a safety deposit box, a satellite flat-screen TV, ironing facilities, desk and a seating area with a sofa. There is a private bathroom with shower in every unit, along with bathrobes, slippers and a hair dryer. At the apartment complex, each unit is equipped with bed linen and towels.\r\n\r\nThe apartment serves a continental and Asian breakfast and breakfast in the room is also available. There is a coffee shop, and packed lunches are also available.\r\n\r\nA car rental service is available at Gold Crest Luxurious Apartments DHA Lahore by LMY.\r\n\r\nChauburji is 5.5 km from the accommodation, while Gaddafi Stadium is 6.8 km away. The nearest airport is Allama Iqbal International, 13 km from Gold Crest Luxurious Apartments DHA Lahore by LMY, and the property offers a paid airport shuttle service.', 'House # 1`218, Floor # 12th, Plaza 456-Gold Crest, Block # DD, Phase - 4, DHA, 54000 Lahore, Pakistan ', '+92 3138976541', NULL, 'images/WhatsApp Image 2024-07-18 at 3.41.24 AM.jpeg', 'images/WhatsApp Image 2024-07-18 at 3.41.24 AM (1).jpeg', 'images/WhatsApp Image 2024-07-18 at 3.41.24 AM (2).jpeg', 'images/WhatsApp Image 2024-07-18 at 3.41.24 AM.jpeg', 3),
(18, 'Pearl Continental Hotel Rawalpindi', 'Pearl Continental Hotel Rawalpindi is a luxury hotel offering elegant rooms and a range of amenities including a restaurant, swimming pool, fitness center, and conference facilities. It\'s well-regarded for its high standards of service and comfort.', 'The Mall, Rawalpindi, Pakistan', '+92 51111505505', NULL, 'images/rawal1.jpg', 'images/rawal2.jpg', 'images/rawal3.jpg', 'images/rawal1.jpg', 5),
(19, 'Saddar Hotel Rawalpindi', 'Saddar Hotel Rawalpindi is a budget-friendly option that provides comfortable accommodations with essential amenities. The hotel is located in the bustling Saddar area, making it convenient for travelers who want to be close to shops and local attractions.', '3rd Floor, Saddar Plaza, Saddar, Rawalpindi, Pakistan', '+92 515561262', NULL, 'images/rawal4.jpg', 'images/rawal5.jpg', 'images/rawal6.jpg', 'images/rawal4.jpg', 5),
(20, 'Faisalabad Serena Hotel', 'Faisalabad Serena Hotel is a luxury property offering upscale rooms and a range of amenities including a restaurant, fitness center, and conference facilities. It is known for its exceptional service and elegant accommodations.', '8-KM, 1-Faisalabad Road, Faisalabad, Pakistan', '+92 41 111133133', NULL, 'images/faisal1.jpg', 'images/faisal2.jpg', 'images/faisal3.jpg', 'images/faisal2.jpg', 6),
(21, 'Millennium Suites Faisalabad', 'Millennium Suites Faisalabad provides comfortable and modern accommodations with essential amenities. The hotel features a restaurant, room service, and business facilities, catering to both business and leisure travelers.', '31-G, Club Road, Faisalabad, Pakistan', '+92 41 850 4888', NULL, 'images/faisal4.jpg', 'images/faisal5.jpg', 'images/faisal6.jpg', 'images/faisal4.jpg', 6),
(23, 'fatima', 'gfehrgf', 'sghjdf', 'gdhef', NULL, 'images/100.jpg', 'images/about.jpg', 'images/blog-1.jpg', 'images/about.jpg', 3);

-- --------------------------------------------------------

--
-- Table structure for table `hotelbookings`
--

CREATE TABLE `hotelbookings` (
  `booking_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `hotel_id` int(11) NOT NULL,
  `check_in_date` date NOT NULL,
  `check_out_date` date NOT NULL,
  `status` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `new_room_id` int(11) NOT NULL,
  `payment_method_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hotelbookings`
--

INSERT INTO `hotelbookings` (`booking_id`, `user_id`, `hotel_id`, `check_in_date`, `check_out_date`, `status`, `created_at`, `updated_at`, `new_room_id`, `payment_method_id`) VALUES
(75, 23, 12, '2024-08-24', '0000-00-00', 'Canceled', '2024-08-24 04:05:43', '2024-08-24 04:08:46', 8, 3),
(76, 24, 10, '2024-08-24', '0000-00-00', 'Canceled', '2024-08-24 04:36:28', '2024-08-24 07:51:09', 6, 1),
(77, 24, 10, '2024-08-31', '0000-00-00', 'Confirmed', '2024-08-24 05:00:09', '2024-08-24 05:00:09', 10, 1),
(78, 24, 10, '2024-09-19', '0000-00-00', 'Canceled', '2024-08-24 05:01:42', '2024-08-24 05:16:47', 7, 1),
(79, 24, 11, '2024-09-06', '0000-00-00', 'Confirmed', '2024-08-24 05:22:26', '2024-08-24 05:22:26', 6, 3),
(80, 24, 11, '2024-08-24', '0000-00-00', 'Confirmed', '2024-08-24 07:44:39', '2024-08-24 07:44:39', 7, 3),
(81, 24, 10, '2024-08-24', '0000-00-00', 'Confirmed', '2024-08-24 07:49:51', '2024-08-24 07:49:51', 6, 3),
(82, 24, 11, '2024-08-29', '0000-00-00', 'Confirmed', '2024-08-24 08:16:23', '2024-08-24 08:16:23', 7, 3),
(83, 24, 10, '2024-08-31', '0000-00-00', 'Confirmed', '2024-08-24 09:06:15', '2024-08-24 09:06:15', 6, 1);

-- --------------------------------------------------------

--
-- Table structure for table `hotel_facility`
--

CREATE TABLE `hotel_facility` (
  `HotelID` int(11) NOT NULL,
  `FacilityID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hotel_facility`
--

INSERT INTO `hotel_facility` (`HotelID`, `FacilityID`) VALUES
(10, 1),
(10, 2),
(10, 3),
(10, 4),
(10, 5),
(10, 10),
(10, 11),
(10, 12),
(10, 13),
(10, 14),
(10, 15),
(10, 16),
(10, 17),
(10, 18),
(10, 19),
(10, 20),
(10, 21),
(10, 22),
(10, 23),
(10, 24),
(10, 25),
(10, 26),
(10, 27),
(10, 28),
(10, 29),
(10, 30),
(10, 31),
(10, 32),
(10, 33),
(11, 1),
(11, 2),
(11, 3),
(11, 4),
(11, 5),
(11, 10),
(11, 11),
(11, 12),
(11, 13),
(11, 14),
(11, 15),
(11, 16),
(11, 17),
(11, 18),
(11, 19),
(11, 20),
(11, 21),
(11, 22),
(11, 23),
(11, 24),
(11, 25),
(11, 26),
(11, 27),
(11, 28),
(11, 29),
(11, 30),
(11, 31),
(11, 32),
(11, 33),
(12, 1),
(12, 2),
(12, 3),
(12, 4),
(12, 5),
(12, 10),
(12, 11),
(12, 12),
(12, 13),
(12, 14),
(12, 15),
(12, 16),
(12, 17),
(12, 18),
(12, 19),
(12, 20),
(12, 21),
(12, 22),
(12, 23),
(12, 24),
(12, 25),
(12, 26),
(12, 27),
(12, 28),
(12, 29),
(12, 30),
(12, 31),
(12, 32),
(12, 33),
(13, 1),
(13, 2),
(13, 3),
(13, 4),
(13, 5),
(13, 10),
(13, 11),
(13, 12),
(13, 13),
(13, 14),
(13, 15),
(13, 16),
(13, 17),
(13, 18),
(13, 19),
(13, 20),
(13, 21),
(13, 22),
(13, 23),
(13, 24),
(13, 25),
(13, 26),
(13, 27),
(13, 28),
(13, 29),
(13, 30),
(13, 31),
(13, 32),
(13, 33),
(14, 1),
(14, 2),
(14, 3),
(14, 4),
(14, 5),
(14, 10),
(14, 11),
(14, 12),
(14, 13),
(14, 14),
(14, 15),
(14, 16),
(14, 17),
(14, 18),
(14, 19),
(14, 20),
(14, 21),
(14, 22),
(14, 23),
(14, 24),
(14, 25),
(14, 26),
(14, 27),
(14, 28),
(14, 29),
(14, 30),
(14, 31),
(14, 32),
(14, 33),
(15, 1),
(15, 2),
(15, 3),
(15, 4),
(15, 5),
(15, 10),
(15, 11),
(15, 12),
(15, 13),
(15, 14),
(15, 15),
(15, 16),
(15, 17),
(15, 18),
(15, 19),
(15, 20),
(15, 21),
(15, 22),
(15, 23),
(15, 24),
(15, 25),
(15, 26),
(15, 27),
(15, 28),
(15, 29),
(15, 30),
(15, 31),
(15, 32),
(15, 33),
(16, 1),
(16, 2),
(16, 3),
(16, 4),
(16, 5),
(16, 10),
(16, 11),
(16, 12),
(16, 13),
(16, 14),
(16, 15),
(16, 16),
(16, 17),
(16, 18),
(16, 19),
(16, 20),
(16, 21),
(16, 22),
(16, 23),
(16, 24),
(16, 25),
(16, 26),
(16, 27),
(16, 28),
(16, 29),
(16, 30),
(16, 31),
(16, 32),
(16, 33),
(17, 1),
(17, 2),
(17, 3),
(17, 4),
(17, 5),
(17, 10),
(17, 11),
(17, 12),
(17, 13),
(17, 14),
(17, 15),
(17, 16),
(17, 17),
(17, 18),
(17, 19),
(17, 20),
(17, 21),
(17, 22),
(17, 23),
(17, 24),
(17, 25),
(17, 26),
(17, 27),
(17, 28),
(17, 29),
(17, 30),
(17, 31),
(17, 32),
(17, 33),
(18, 1),
(18, 2),
(18, 3),
(18, 4),
(18, 5),
(18, 10),
(18, 11),
(18, 12),
(18, 13),
(18, 14),
(18, 15),
(18, 16),
(18, 17),
(18, 18),
(18, 19),
(18, 20),
(18, 21),
(18, 22),
(18, 23),
(18, 24),
(18, 25),
(18, 26),
(18, 27),
(18, 28),
(18, 29),
(18, 30),
(18, 31),
(18, 32),
(18, 33),
(19, 1),
(19, 2),
(19, 3),
(19, 4),
(19, 5),
(19, 10),
(19, 11),
(19, 12),
(19, 13),
(19, 14),
(19, 15),
(19, 16),
(19, 17),
(19, 18),
(19, 19),
(19, 20),
(19, 21),
(19, 22),
(19, 23),
(19, 24),
(19, 25),
(19, 26),
(19, 27),
(19, 28),
(19, 29),
(19, 30),
(19, 31),
(19, 32),
(19, 33),
(20, 1),
(20, 2),
(20, 3),
(20, 4),
(20, 5),
(20, 10),
(20, 11),
(20, 12),
(20, 13),
(20, 14),
(20, 15),
(20, 16),
(20, 17),
(20, 18),
(20, 19),
(20, 20),
(20, 21),
(20, 22),
(20, 23),
(20, 24),
(20, 25),
(20, 26),
(20, 27),
(20, 28),
(20, 29),
(20, 30),
(20, 31),
(20, 32),
(20, 33),
(21, 1),
(21, 2),
(21, 3),
(21, 4),
(21, 5),
(21, 10),
(21, 11),
(21, 12),
(21, 13),
(21, 14),
(21, 15),
(21, 16),
(21, 17),
(21, 18),
(21, 19),
(21, 20),
(21, 21),
(21, 22),
(21, 23),
(21, 24),
(21, 25),
(21, 26),
(21, 27),
(21, 28),
(21, 29),
(21, 30),
(21, 31),
(21, 32),
(21, 33),
(22, 1),
(22, 14),
(22, 22),
(23, 2),
(23, 11),
(23, 16),
(23, 17),
(23, 21);

-- --------------------------------------------------------

--
-- Table structure for table `hotel_rooms`
--

CREATE TABLE `hotel_rooms` (
  `room_id` int(11) NOT NULL,
  `room_type` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `room_size` int(11) DEFAULT NULL,
  `guest_capacity` int(11) DEFAULT NULL,
  `price` int(255) NOT NULL,
  `policy` varchar(255) NOT NULL,
  `img1` varchar(255) DEFAULT NULL,
  `img2` varchar(255) DEFAULT NULL,
  `img3` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hotel_rooms`
--

INSERT INTO `hotel_rooms` (`room_id`, `room_type`, `description`, `room_size`, `guest_capacity`, `price`, `policy`, `img1`, `img2`, `img3`) VALUES
(6, 1, 'Compact and efficient for solo travelers or business guests.', 20, 1, 8000, 'Booking can be cancelled in 24 hours', 'images/hotel3_4.jpg', 'images/hotel6_2.jpg', 'images/hotel1_5.jpg'),
(7, 2, 'Comfortable and well-equipped for standard needs, suitable for couples or small groups.', 15, 2, 10000, 'Booking can be Cancelled in 24 Hours', 'images/WhatsApp Image 2024-07-18 at 3.42.12 AM.jpeg', 'images/WhatsApp Image 2024-07-18 at 3.42.13 AM (1).jpeg', 'images/WhatsApp Image 2024-07-18 at 3.42.13 AM.jpeg'),
(8, 3, 'Spacious with additional living space, ideal for extended stays or luxury travelers.', 25, 3, 20000, 'Booking can be Cancelled in 24 Hours', 'images/WhatsApp Image 2024-07-18 at 3.38.11 AM (1).jpeg', 'images/WhatsApp Image 2024-07-18 at 3.38.11 AM (2).jpeg', 'images/WhatsApp Image 2024-07-18 at 3.38.11 AM.jpeg'),
(9, 4, ' Upscale room with enhanced amenities and comfort, offering a touch of luxury.', 20, 4, 25000, 'Booking can be Cancelled in 24 Hours', 'images/hotel6_3.jpg', 'images/hotel6_5.jpg', 'images/hotel6_6.jpg'),
(10, 5, 'Larger room designed to accommodate families or groups with additional beds ', 30, 5, 30000, 'Booking can be Cancelled in 24 Hours', 'images/hotel4_4.jpg', 'images/hotel6_2.jpg', 'images/hotel5_3.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `hotel_room_facilities`
--

CREATE TABLE `hotel_room_facilities` (
  `room_id` int(11) NOT NULL,
  `facility_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hotel_room_facilities`
--

INSERT INTO `hotel_room_facilities` (`room_id`, `facility_id`) VALUES
(6, 1),
(6, 2),
(6, 3),
(6, 5),
(6, 6),
(6, 7),
(6, 8),
(6, 9),
(6, 18),
(7, 1),
(7, 2),
(7, 3),
(7, 4),
(7, 5),
(7, 6),
(7, 8),
(7, 9),
(7, 10),
(7, 11),
(7, 17),
(7, 18),
(8, 1),
(8, 2),
(8, 3),
(8, 4),
(8, 5),
(8, 6),
(8, 7),
(8, 8),
(8, 9),
(8, 10),
(8, 11),
(8, 12),
(8, 17),
(8, 18),
(8, 20),
(8, 21),
(8, 23),
(8, 24),
(8, 25),
(9, 1),
(9, 2),
(9, 3),
(9, 4),
(9, 5),
(9, 6),
(9, 7),
(9, 8),
(9, 9),
(9, 10),
(9, 11),
(9, 16),
(9, 17),
(9, 18),
(9, 19),
(9, 20),
(9, 21),
(9, 22),
(9, 23),
(9, 24),
(9, 25),
(10, 1),
(10, 2),
(10, 3),
(10, 4),
(10, 5),
(10, 6),
(10, 7),
(10, 8),
(10, 9),
(10, 10),
(10, 11),
(10, 12),
(10, 13),
(10, 14),
(10, 15),
(10, 16),
(10, 17),
(10, 18),
(10, 19),
(10, 20),
(10, 21),
(10, 22),
(10, 23),
(10, 24),
(10, 25);

-- --------------------------------------------------------

--
-- Table structure for table `hr_facilities`
--

CREATE TABLE `hr_facilities` (
  `facility_id` int(11) NOT NULL,
  `facility_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hr_facilities`
--

INSERT INTO `hr_facilities` (`facility_id`, `facility_name`) VALUES
(1, 'Air Conditioning/Heating'),
(2, 'TV'),
(3, 'Private Bathroom'),
(4, 'Room Service'),
(5, 'Desk/Work Area'),
(6, 'Minibar/Refrigerator'),
(7, 'Safe'),
(8, 'Hair Dryer'),
(9, 'Iron/Ironing Board'),
(10, 'Restaurant/Dining'),
(11, 'Bar/Lounge'),
(12, 'Fitness Center/Gym'),
(13, 'Spa/Wellness Center'),
(14, 'Business Center'),
(15, 'Concierge'),
(16, 'Airport Shuttle'),
(17, 'Parking'),
(18, '24-Hour Reception'),
(19, 'Event/Meeting Rooms'),
(20, 'Wheelchair Access'),
(21, 'Elevators'),
(22, 'Accessible Bathrooms'),
(23, 'Smoke Detectors'),
(24, 'Security Cameras'),
(25, 'Emergency Exits');

-- --------------------------------------------------------

--
-- Table structure for table `image`
--

CREATE TABLE `image` (
  `ImageID` int(11) NOT NULL,
  `DestinationID` int(11) DEFAULT NULL,
  `HotelID` int(11) DEFAULT NULL,
  `PackageID` int(11) DEFAULT NULL,
  `Url` varchar(255) NOT NULL,
  `Description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `new_id` int(255) NOT NULL,
  `new_mail` varchar(255) NOT NULL,
  `new_register` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`new_id`, `new_mail`, `new_register`) VALUES
(1, 'tahaaman26@gmail.com', '2023-12-28 08:48:07'),
(7, 'ayesha@gmail.com', '2024-08-02 17:15:39'),
(8, 'taha12@gmail.com', '2024-08-02 17:17:59'),
(9, 'taha121@gmail.com', '2024-08-03 23:38:29'),
(10, 'ayesha1@gmail.com', '2024-08-04 00:07:09'),
(11, 'tahaaman26@gmail.com', '2024-08-24 06:51:30'),
(12, 'tahaaman26@gmail.com', '2024-08-24 06:52:19'),
(13, 'takgamer2003@gmail.com', '2024-08-24 06:53:58'),
(14, 'tahaaman26@gmail.com', '2024-08-24 06:56:31'),
(15, 'takgamer2003@gmail.com', '2024-08-24 06:56:39'),
(16, 'tahakhan19924@gmail.com', '2024-08-24 08:24:15'),
(17, 'tahakhan19924@gmail.com', '2024-08-24 09:29:41'),
(18, 'tahakhan19924@gmail.com', '2024-08-24 09:30:19'),
(19, 'tahakhan19924@gmail.com', '2024-08-24 11:06:30');

-- --------------------------------------------------------

--
-- Table structure for table `package_booking`
--

CREATE TABLE `package_booking` (
  `booking_id` int(11) NOT NULL,
  `package_id` int(11) NOT NULL,
  `date_range_id` int(11) NOT NULL,
  `message` text DEFAULT NULL,
  `booking_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `userid` int(11) NOT NULL,
  `payment_method_id` int(11) DEFAULT NULL,
  `status` varchar(245) NOT NULL,
  `people_count` int(11) NOT NULL,
  `total_price` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `package_booking`
--

INSERT INTO `package_booking` (`booking_id`, `package_id`, `date_range_id`, `message`, `booking_date`, `userid`, `payment_method_id`, `status`, `people_count`, `total_price`) VALUES
(60, 7, 28, 'heheheh', '2024-08-24 03:58:48', 23, 2, 'Canceled', 0, 0),
(61, 5, 12, 'rwrbwer', '2024-08-24 04:37:11', 24, 1, 'confirmed', 0, 0),
(63, 5, 12, 'e33v2e', '2024-08-24 05:02:05', 24, 1, 'Canceled', 0, 0),
(64, 7, 27, 'okay', '2024-08-24 05:31:33', 23, 3, 'Canceled', 0, 0),
(65, 5, 12, 'ht nhtnthth', '2024-08-24 08:00:33', 24, 1, 'confirmed', 0, 0),
(66, 5, 12, 'ghgfh', '2024-08-24 09:03:19', 24, 1, 'confirmed', 0, 0),
(67, 27, 69, 'hjbj', '2024-08-25 18:05:05', 17, 2, 'confirmed', 0, 0),
(68, 29, 71, 'ewwe', '2024-08-26 07:27:03', 23, NULL, 'confirmed', 1, 0),
(69, 29, 71, '', '2024-08-26 07:30:51', 23, 2, 'confirmed', 0, 0),
(70, 19, 44, '', '2024-08-26 07:46:04', 23, 2, 'confirmed', 0, 0),
(71, 19, 45, '', '2024-08-26 07:48:56', 23, 2, 'confirmed', 20, 0),
(73, 19, 45, '', '2024-08-26 07:56:35', 23, 2, 'confirmed', 20, 0),
(74, 19, 44, '', '2024-08-26 08:02:16', 23, 2, 'confirmed', 2, 0),
(75, 19, 44, '', '2024-08-26 08:03:49', 23, 2, 'confirmed', 3, 0),
(76, 19, 44, '', '2024-08-26 08:06:14', 23, 2, 'confirmed', 5, 0),
(77, 19, 44, '', '2024-08-26 08:39:23', 23, 2, 'confirmed', 2, 0),
(78, 19, 44, '', '2024-08-26 08:42:26', 23, 3, 'confirmed', 1, 170000),
(79, 19, 44, '', '2024-08-26 08:42:55', 23, 2, 'confirmed', 2, 340000),
(80, 29, 71, '', '2024-08-26 08:44:56', 23, 3, 'confirmed', 2, 1128),
(81, 19, 47, '', '2024-08-26 11:05:42', 23, 2, 'confirmed', 1, 170000);

-- --------------------------------------------------------

--
-- Table structure for table `package_itinerary`
--

CREATE TABLE `package_itinerary` (
  `ItineraryID` int(11) NOT NULL,
  `PackID` int(11) DEFAULT NULL,
  `DayID` int(11) DEFAULT NULL,
  `Description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `package_itinerary`
--

INSERT INTO `package_itinerary` (`ItineraryID`, `PackID`, `DayID`, `Description`) VALUES
(2, 5, 4, 'Explore Shalimar Gardens and Lahore Museum.'),
(3, 5, 5, 'Tour Iqbal Park and Tomb of Jahangir.'),
(4, 5, 6, 'Day trip to Wagah Border for the flag ceremony'),
(5, 5, 1, 'Arrival, check-in, and enjoy local cuisine.'),
(6, 5, 2, 'Visit Lahore Fort and Badshahi Mosque.'),
(7, 5, 7, 'Visit Lahore Zoo, Jilani Park, and local markets.'),
(8, 5, 8, 'Relax and explore missed attractions before departure.'),
(9, 7, 1, 'Arrival and City Exploration'),
(10, 7, 2, 'Historical and Cultural Tour'),
(11, 7, 4, 'Nature and Departure'),
(12, 11, 1, 'Arrival and Relaxation'),
(13, 11, 2, 'Historical Karachi'),
(14, 11, 4, 'Cultural Exploration'),
(15, 11, 5, 'Island Excursion'),
(16, 11, 6, 'Modern Karachi'),
(18, 11, 8, 'Leisure and Departure'),
(19, 11, 7, 'Day Trip to Hawkes Bay'),
(20, 17, 1, 'Arrival and City Exploration'),
(21, 17, 2, 'Cultural and Historical Tour'),
(22, 17, 4, 'Leisure and Departure'),
(23, 18, 1, 'Arrival and City Exploration'),
(24, 18, 2, 'Cultural and Historical Tour'),
(25, 18, 4, 'Nature and Departure'),
(26, 19, 1, 'Arrival and Relaxation'),
(27, 19, 2, 'City Highlights'),
(28, 19, 4, 'Cultural Experience'),
(29, 19, 5, 'Natural Wonders'),
(30, 19, 6, 'Historical and Cultural Sites'),
(31, 19, 7, 'Day Trip to Taxila'),
(32, 19, 8, 'Leisure and Departure'),
(33, 20, 1, 'Arrival & Local Sightseeing'),
(34, 20, 2, 'Historical & Cultural Tour'),
(35, 20, 4, 'Excursion & Departure'),
(36, 21, 1, 'Arrival & Relaxation'),
(37, 21, 2, 'Rawalpindi Highlights'),
(38, 21, 4, 'Historical & Cultural Tour'),
(39, 21, 5, 'Excursion to Murree Hills'),
(40, 21, 6, 'Nature & Adventure'),
(41, 21, 7, 'Day Trip to Islamabad'),
(42, 21, 8, 'Departure'),
(43, 22, 1, 'Arrival & City Exploration\r\n'),
(44, 22, 2, 'Historical & Cultural Experience'),
(45, 22, 4, 'Excursion & Departure');

-- --------------------------------------------------------

--
-- Table structure for table `room_types`
--

CREATE TABLE `room_types` (
  `RoomTypeID` int(11) NOT NULL,
  `TypeName` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room_types`
--

INSERT INTO `room_types` (`RoomTypeID`, `TypeName`) VALUES
(1, 'Single Room'),
(2, 'Standard Room'),
(3, 'Suite'),
(4, 'Deluxe Room'),
(5, 'Family Room');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `service_id` int(11) NOT NULL,
  `service_name` varchar(255) NOT NULL,
  `service_desc` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`service_id`, `service_name`, `service_desc`) VALUES
(2, 'Booking Engine', 'Online booking system for tours, hotels, flights, and car rentals .'),
(3, 'Customer Support', 'Live chat support Email and phone support FAQ section and help center.'),
(4, 'Travel Planning', 'Custom Itineraries: Personalized trip planning based on user preferences. '),
(5, 'User Engagement', 'User Reviews and Ratings: Allow users to leave reviews and rate their experiences. Travel Blog: Regular blog posts with travel tips. '),
(6, 'Financial Services', 'Travel Financing: Options for financing travel expenses. Expense Tracking: Tools to help users keep track of their travel expenses.'),
(7, 'Environmental and Social Responsibility', ' Social Responsibility Eco-Friendly Options: Highlight eco-friendly travel options and accommodations. ');

-- --------------------------------------------------------

--
-- Table structure for table `team_info`
--

CREATE TABLE `team_info` (
  `team_id` int(11) NOT NULL,
  `team_name` varchar(255) NOT NULL,
  `team_desc` varchar(255) NOT NULL,
  `team_img` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `team_info`
--

INSERT INTO `team_info` (`team_id`, `team_name`, `team_desc`, `team_img`) VALUES
(2, 'Aisha Malik', 'Founder & CEO', 'aboutimage/team-3.jpg'),
(3, 'Ahmad Khan', 'Chief Operations Officer', 'aboutimage/team-2.jpg'),
(4, 'Fatima Raza', 'Tour Guide\r\n', 'aboutimage/team-1.jpg'),
(5, 'Omar Ahmed', 'Travel Consultant\r\n', 'aboutimage/testimonial-1.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tour_card`
--

CREATE TABLE `tour_card` (
  `pack_id` int(11) NOT NULL,
  `pack_name` varchar(10000) NOT NULL,
  `day_id` int(11) DEFAULT NULL,
  `pack_desc` text NOT NULL,
  `pack_price` int(11) NOT NULL,
  `CityID` int(11) DEFAULT NULL,
  `HotelID` int(11) DEFAULT NULL,
  `pack_img` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tour_card`
--

INSERT INTO `tour_card` (`pack_id`, `pack_name`, `day_id`, `pack_desc`, `pack_price`, `CityID`, `HotelID`, `pack_img`) VALUES
(5, 'Lahore Cultural Immersion', 8, 'Experience Lahore rich culture with us', 110000, 3, 16, 'uploads/Badshahi Mosque 3.jpg'),
(7, ' Coastal Karachi Getaway', 4, 'Discover Few Amazing places of the Karachi with us', 90000, 1, 11, 'uploads/Clifton Beach 1.jpg'),
(11, 'Ultimate Karachi Experience', 8, 'hycfncvhdr', 130000, 1, 11, 'uploads/Clifton Beach 2.jpg'),
(17, ' Lahore Highlights', 4, 'hfdyufrgeryrye', 60000, 3, 16, 'uploads/Daman-e-Koh 3.jpg'),
(18, 'Explore Islamabad hidden gems with us', 4, 'Explore Islamabad hidden gems with us', 70000, 4, 13, 'uploads/faisal.jpg'),
(19, 'Discover the beauty of Islamabad with us', 8, 'Discover the beauty of Islamabad with us', 170000, 4, 14, 'uploads/blog-3.jpg'),
(20, 'Rawalpindi Explorer: 3-Day Adventure', 4, 'Rawalpindi Explorer: 3-Day Adventure', 50000, 5, 18, 'uploads/rawalpindi10.jpg'),
(21, 'Rawalpindi & Beyond: 7-Day Ultimate Experience', 8, 'Rawalpindi & Beyond: 7-Day Ultimate Experience', 145000, 5, 19, 'uploads/rawal11.jpg'),
(22, 'Faisalabad Delights: 3-Day Discovery', 4, 'Faisalabad Delights: 3-Day Discovery', 78000, 6, 20, 'uploads/faisal20.jpg'),
(23, 'Faisalabad Discovery: 7-Day Immersion', 8, 'Faisalabad Discovery: 7-Day Immersion', 148000, 6, 21, 'uploads/faisal21.jpg'),
(25, 'gbvgtv', 1, 'gbgtbth', 5353, 3, 16, 'uploads/food poster 1.jpg'),
(27, 'new', 5, 'newwwww', 20000, 1, 11, 'uploads/100.jpg'),
(28, 'new', 4, 'newwwwwwwwwwwwwwwww', 20000, 1, 10, 'uploads/Baghibnqasim.jpg'),
(29, 'ijlughjm', 1, 'gjhmfjgh', 564, 4, 14, 'uploads/blog-1.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tour_package_dates`
--

CREATE TABLE `tour_package_dates` (
  `id` int(11) NOT NULL,
  `pack_id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `max_people` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tour_package_dates`
--

INSERT INTO `tour_package_dates` (`id`, `pack_id`, `start_date`, `end_date`, `max_people`) VALUES
(11, 5, '2024-08-17', '2024-08-24', 0),
(12, 5, '2024-08-25', '2024-09-01', 0),
(13, 5, '2024-09-02', '2024-09-09', 0),
(14, 17, '2024-08-04', '2024-08-07', 0),
(15, 17, '2024-08-09', '2024-08-12', 0),
(16, 17, '2024-08-13', '2024-08-16', 0),
(25, 17, '2024-08-12', '2024-08-15', 0),
(26, 17, '2024-08-16', '2024-08-19', 0),
(27, 7, '2024-09-04', '2024-09-07', 0),
(28, 7, '2024-09-08', '2024-09-11', 0),
(29, 7, '2024-09-12', '2024-09-15', 0),
(30, 7, '2024-08-16', '2024-08-19', 0),
(31, 7, '2024-08-20', '2024-08-23', 0),
(32, 11, '2024-09-01', '2024-09-08', 0),
(33, 11, '2024-09-09', '2024-09-16', 0),
(34, 11, '2024-09-17', '2024-09-24', 0),
(36, 11, '2024-09-25', '2024-10-02', 0),
(37, 11, '2024-10-03', '2024-10-10', 0),
(38, 18, '2024-08-06', '2024-08-09', 0),
(39, 18, '2024-08-10', '2024-08-13', 0),
(40, 18, '2024-08-14', '2024-08-17', 0),
(41, 18, '2024-08-18', '2024-08-21', 0),
(43, 19, '2024-08-23', '2024-08-30', 0),
(44, 19, '2024-08-31', '2024-09-07', 30),
(45, 19, '2024-09-08', '2024-09-15', 50),
(46, 19, '2024-09-15', '2024-09-22', 0),
(47, 19, '2024-09-23', '2024-09-30', 0),
(48, 20, '2024-08-05', '2024-08-08', 0),
(49, 20, '2024-08-09', '2024-08-12', 0),
(50, 20, '2024-08-13', '2024-08-16', 0),
(51, 20, '2024-08-17', '2024-08-20', 0),
(52, 20, '2024-08-21', '2024-08-24', 0),
(53, 21, '2024-08-05', '2024-08-12', 0),
(54, 21, '2024-08-13', '2024-08-20', 0),
(55, 21, '2024-08-21', '2024-08-28', 0),
(56, 21, '2024-08-29', '2024-09-05', 0),
(57, 21, '2024-09-06', '2024-09-13', 0),
(58, 22, '2024-08-06', '2024-08-09', 0),
(59, 22, '2024-08-10', '2024-08-13', 0),
(60, 22, '2024-08-14', '2024-08-17', 0),
(61, 22, '2024-08-18', '2024-08-21', 0),
(62, 22, '2024-08-22', '2024-08-25', 0),
(63, 23, '2024-08-04', '2024-08-11', 0),
(64, 23, '2024-08-12', '2024-08-19', 0),
(65, 23, '2024-08-20', '2024-08-27', 0),
(66, 23, '2024-08-28', '2024-09-04', 0),
(68, 7, '2024-08-23', '2024-08-26', 0),
(69, 27, '2024-08-26', '2024-08-30', 0),
(70, 27, '2024-08-27', '2024-08-31', 20),
(71, 29, '2024-08-27', '2024-08-28', 20);

-- --------------------------------------------------------

--
-- Table structure for table `t_days`
--

CREATE TABLE `t_days` (
  `day_id` int(255) NOT NULL,
  `days` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `t_days`
--

INSERT INTO `t_days` (`day_id`, `days`) VALUES
(1, 1),
(2, 2),
(4, 3),
(5, 4),
(6, 5),
(7, 6),
(8, 7);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `UserID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Phone` varchar(15) DEFAULT NULL,
  `Role` varchar(255) DEFAULT 'User'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`UserID`, `Name`, `Email`, `Password`, `Phone`, `Role`) VALUES
(17, 'fatima', 'fatima@gmail.com', '123', '03437856120', 'user'),
(18, 'ayesha', 'ayesha@gmail.com', '123', '03338775644', 'user'),
(23, 'fatima', 'fatimafarooq183@gmail.com', '123', '03132034749', 'user'),
(24, 'taha khan', 'tahaaman26@gmail.com', '123', '03338556755', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `about_us`
--
ALTER TABLE `about_us`
  ADD PRIMARY KEY (`about_id`);

--
-- Indexes for table `admin_user`
--
ALTER TABLE `admin_user`
  ADD PRIMARY KEY (`AdminID`),
  ADD UNIQUE KEY `Email` (`Email`) USING BTREE;

--
-- Indexes for table `blog`
--
ALTER TABLE `blog`
  ADD PRIMARY KEY (`blog_id`);

--
-- Indexes for table `blog_form`
--
ALTER TABLE `blog_form`
  ADD PRIMARY KEY (`id`),
  ADD KEY `blog_id` (`blog_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `city`
--
ALTER TABLE `city`
  ADD PRIMARY KEY (`CityID`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `destination`
--
ALTER TABLE `destination`
  ADD PRIMARY KEY (`DestinationID`),
  ADD KEY `fk_destination_city` (`CityID`);

--
-- Indexes for table `destination_comments`
--
ALTER TABLE `destination_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `destination_id` (`destination_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `facility`
--
ALTER TABLE `facility`
  ADD PRIMARY KEY (`FacilityID`);

--
-- Indexes for table `faqs`
--
ALTER TABLE `faqs`
  ADD PRIMARY KEY (`faq_id`);

--
-- Indexes for table `footer`
--
ALTER TABLE `footer`
  ADD PRIMARY KEY (`footer_id`);

--
-- Indexes for table `hotel`
--
ALTER TABLE `hotel`
  ADD PRIMARY KEY (`HotelID`),
  ADD KEY `DestinationID` (`DestinationID`),
  ADD KEY `fk_hotel_city` (`CityID`);

--
-- Indexes for table `hotelbookings`
--
ALTER TABLE `hotelbookings`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `hotel_id` (`hotel_id`),
  ADD KEY `fk_new_room_id` (`new_room_id`),
  ADD KEY `fk_payment_method` (`payment_method_id`);

--
-- Indexes for table `hotel_facility`
--
ALTER TABLE `hotel_facility`
  ADD PRIMARY KEY (`HotelID`,`FacilityID`),
  ADD KEY `FacilityID` (`FacilityID`);

--
-- Indexes for table `hotel_rooms`
--
ALTER TABLE `hotel_rooms`
  ADD PRIMARY KEY (`room_id`),
  ADD KEY `room_type` (`room_type`);

--
-- Indexes for table `hotel_room_facilities`
--
ALTER TABLE `hotel_room_facilities`
  ADD PRIMARY KEY (`room_id`,`facility_id`),
  ADD KEY `facility_id` (`facility_id`);

--
-- Indexes for table `hr_facilities`
--
ALTER TABLE `hr_facilities`
  ADD PRIMARY KEY (`facility_id`);

--
-- Indexes for table `image`
--
ALTER TABLE `image`
  ADD PRIMARY KEY (`ImageID`),
  ADD KEY `DestinationID` (`DestinationID`),
  ADD KEY `HotelID` (`HotelID`),
  ADD KEY `PackageID` (`PackageID`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`new_id`);

--
-- Indexes for table `package_booking`
--
ALTER TABLE `package_booking`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `package_id` (`package_id`),
  ADD KEY `date_range_id` (`date_range_id`),
  ADD KEY `userid` (`userid`),
  ADD KEY `payment_method_id` (`payment_method_id`);

--
-- Indexes for table `package_itinerary`
--
ALTER TABLE `package_itinerary`
  ADD PRIMARY KEY (`ItineraryID`),
  ADD KEY `PackID` (`PackID`),
  ADD KEY `DayID` (`DayID`);

--
-- Indexes for table `room_types`
--
ALTER TABLE `room_types`
  ADD PRIMARY KEY (`RoomTypeID`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`service_id`);

--
-- Indexes for table `team_info`
--
ALTER TABLE `team_info`
  ADD PRIMARY KEY (`team_id`);

--
-- Indexes for table `tour_card`
--
ALTER TABLE `tour_card`
  ADD PRIMARY KEY (`pack_id`),
  ADD KEY `day_id` (`day_id`),
  ADD KEY `CityID` (`CityID`),
  ADD KEY `fk_tour_card_hotel` (`HotelID`);

--
-- Indexes for table `tour_package_dates`
--
ALTER TABLE `tour_package_dates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pack_id` (`pack_id`);

--
-- Indexes for table `t_days`
--
ALTER TABLE `t_days`
  ADD PRIMARY KEY (`day_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `about_us`
--
ALTER TABLE `about_us`
  MODIFY `about_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `admin_user`
--
ALTER TABLE `admin_user`
  MODIFY `AdminID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `blog`
--
ALTER TABLE `blog`
  MODIFY `blog_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `blog_form`
--
ALTER TABLE `blog_form`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `city`
--
ALTER TABLE `city`
  MODIFY `CityID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `destination`
--
ALTER TABLE `destination`
  MODIFY `DestinationID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `destination_comments`
--
ALTER TABLE `destination_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `facility`
--
ALTER TABLE `facility`
  MODIFY `FacilityID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `faqs`
--
ALTER TABLE `faqs`
  MODIFY `faq_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `footer`
--
ALTER TABLE `footer`
  MODIFY `footer_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `hotel`
--
ALTER TABLE `hotel`
  MODIFY `HotelID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `hotelbookings`
--
ALTER TABLE `hotelbookings`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `hotel_rooms`
--
ALTER TABLE `hotel_rooms`
  MODIFY `room_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `hr_facilities`
--
ALTER TABLE `hr_facilities`
  MODIFY `facility_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `image`
--
ALTER TABLE `image`
  MODIFY `ImageID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `new_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `package_booking`
--
ALTER TABLE `package_booking`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT for table `package_itinerary`
--
ALTER TABLE `package_itinerary`
  MODIFY `ItineraryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `room_types`
--
ALTER TABLE `room_types`
  MODIFY `RoomTypeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `service_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `team_info`
--
ALTER TABLE `team_info`
  MODIFY `team_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tour_card`
--
ALTER TABLE `tour_card`
  MODIFY `pack_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `tour_package_dates`
--
ALTER TABLE `tour_package_dates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `t_days`
--
ALTER TABLE `t_days`
  MODIFY `day_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `hotelbookings`
--
ALTER TABLE `hotelbookings`
  ADD CONSTRAINT `fk_new_room_id` FOREIGN KEY (`new_room_id`) REFERENCES `hotel_rooms` (`room_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_payment_method` FOREIGN KEY (`payment_method_id`) REFERENCES `bookings` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `hotelbookings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`UserID`),
  ADD CONSTRAINT `hotelbookings_ibfk_2` FOREIGN KEY (`hotel_id`) REFERENCES `hotel` (`HotelID`);

--
-- Constraints for table `hotel_rooms`
--
ALTER TABLE `hotel_rooms`
  ADD CONSTRAINT `hotel_rooms_ibfk_1` FOREIGN KEY (`room_type`) REFERENCES `room_types` (`RoomTypeID`);

--
-- Constraints for table `hotel_room_facilities`
--
ALTER TABLE `hotel_room_facilities`
  ADD CONSTRAINT `hotel_room_facilities_ibfk_1` FOREIGN KEY (`room_id`) REFERENCES `hotel_rooms` (`room_id`),
  ADD CONSTRAINT `hotel_room_facilities_ibfk_2` FOREIGN KEY (`facility_id`) REFERENCES `hr_facilities` (`facility_id`);

--
-- Constraints for table `package_booking`
--
ALTER TABLE `package_booking`
  ADD CONSTRAINT `package_booking_ibfk_2` FOREIGN KEY (`package_id`) REFERENCES `tour_card` (`pack_id`),
  ADD CONSTRAINT `package_booking_ibfk_3` FOREIGN KEY (`date_range_id`) REFERENCES `tour_package_dates` (`id`),
  ADD CONSTRAINT `package_booking_ibfk_4` FOREIGN KEY (`payment_method_id`) REFERENCES `bookings` (`id`);

--
-- Constraints for table `package_itinerary`
--
ALTER TABLE `package_itinerary`
  ADD CONSTRAINT `package_itinerary_ibfk_1` FOREIGN KEY (`PackID`) REFERENCES `tour_card` (`pack_id`),
  ADD CONSTRAINT `package_itinerary_ibfk_2` FOREIGN KEY (`DayID`) REFERENCES `t_days` (`day_id`);

--
-- Constraints for table `tour_card`
--
ALTER TABLE `tour_card`
  ADD CONSTRAINT `fk_tour_card_hotel` FOREIGN KEY (`HotelID`) REFERENCES `hotel` (`HotelID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tour_card_ibfk_1` FOREIGN KEY (`day_id`) REFERENCES `t_days` (`day_id`),
  ADD CONSTRAINT `tour_card_ibfk_2` FOREIGN KEY (`CityID`) REFERENCES `city` (`CityID`);

--
-- Constraints for table `tour_package_dates`
--
ALTER TABLE `tour_package_dates`
  ADD CONSTRAINT `tour_package_dates_ibfk_1` FOREIGN KEY (`pack_id`) REFERENCES `tour_card` (`pack_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
