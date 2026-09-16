-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql313.infinityfree.com
-- Generation Time: Sep 16, 2026 at 05:08 AM
-- Server version: 11.4.13-MariaDB
-- PHP Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `if0_42908027_goa_fishing`
--

-- --------------------------------------------------------

--
-- Table structure for table `app_settings`
--

CREATE TABLE `app_settings` (
  `setting_key` varchar(50) NOT NULL,
  `setting_value` varchar(255) NOT NULL,
  `updated_by` varchar(20) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `app_settings`
--

INSERT INTO `app_settings` (`setting_key`, `setting_value`, `updated_by`, `updated_at`) VALUES
('team_signup_code', 'GOA2026', NULL, '2026-09-14 16:36:18');

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

CREATE TABLE `articles` (
  `id` int(11) NOT NULL,
  `slug` varchar(100) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `content` longtext DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `articles`
--

INSERT INTO `articles` (`id`, `slug`, `title`, `content`) VALUES
(1, 'crabs-in-goa', 'Kurli/Kurlio - Crab/Crabs', 'Back\r\nkurlios (crabs)\r\nnext\r\nkurlios (crabs)\r\nKurli/Kurlio – Crab/Crabs\r\nIt is no secret that the tiny state of Goa has extensive shores and inland water bodies that allow a lot of fishing activity. Praying for safety and a great catch, the Goan fishermen set out with their boats at nightfall, only to return at dawn with their nets full of seafood like mackerel, catfish, sharks, shrimps and crabs.\r\nFishing isn’t confined to the fishermen’s community that lives off it. Every Goan has made at least one attempt at fishing (if we are counting even the unsuccessful ones) as a leisure activity. And, catching crabs is something that is done in a unique way in Goa.\r\nCrabs are a big hit with locals as well as tourists\r\nWe would often wake up to Dad looking for that one bag that the koblems/ kubulim (crab traps) were tucked in the previous year. It was only once the entire family volunteered to help look for it, that it would be discovered lying in some corner of the house.\r\nPrepping for the trip to catch crabs would always begin with tending to the last-minute mending of these crab traps. These homemade crab traps have a circular metal ring with a diagonal rod running across in diameter and a loose hanging net attached to one side of the ring.\r\nIn the meantime, Mum would prepare a bag of bait, which usually consisted of chicken feet, intestines or even smaller fish. The kids would dress up for the occasion with matching T-shirts, shorts and caps.\r\nWith the koblems, a spare sack/bucket, bait, pocket knife and some munchies, we’d head to the nearest riverbank, backwaters or brackish waters that are known to be the ultimate breeding grounds for crabs.\r\nBait was then secured to the traps meticulously, and each koblem was then dropped into the river amidst the mangroves, with one loose end (that usually had a Thermocol piece or fishing float ball attached) left on the road to retrieve the trap.\r\nCrabs caught using\r\n\'koblems\'\r\nand some bait. Photo: Venita Gomes\r\nNow, it was the test of patience. To keep the kids occupied, snacks like potato chips, beef patties and chutney sandwiches were handed over. The grown-ups drank chilled beers, while the kids relished soft drinks to help beat the scorching heat.\r\nAfter regular intervals, each trap was removed and checked – either a crab was caught in the net or the bait went missing. If a crab appeared, everyone would exult and celebrate.\r\nThis was followed by absolute silence as the crab was detangled from the net. Since a crab’s defensive claws can cause painful injuries, especially if it has a strong grip, a skilled person was required to release the crab.\r\nThis person would find a way to pressurize the crab\'s shell, after which both the claws were carefully twisted and detached. This was then put into the spare sack that was opened and closed as quickly as possible so that no crab could get away. Then, the process was repeated and bait was tied to the koblem and tossed into the water.\r\nBoth the claws of the crab are carefully twisted and detached. Photo: Venita Gomes\r\nThere are usually two types of crabs found in Goa. The first type is found in the rivers and is locally known as kurle or rock crabs. They are black and have a hard shell. The second type is the sea crabs, which are locally known as jhali/jhale, and are comparatively fleshier than the river crabs. Apart from the koblem, crabs are also caught using nets and fishing rods.\r\nAs clueless kids, we were told how tides affected the catch and that the best time to catch crabs was during the slack tide (a short time when water is the calmest, which occurs right before the reverse of the tidal directions).\r\nAlso, a fun fact that the elders shared was that these ten-legged creatures would help lower cholesterol levels and were threatened by the plastic polluting their habitats and the increased water traffic.\r\nDifferent types of crabs found in Goa. Photo: Venita Gomes\r\nAs it got closer to noon, the sack full of fresh kurlios was taken home and cleaned. And, the most delicious crab curry was prepared, using spices and masalas, for the entire family to feast on.\r\nOther popular crab items that are relished even today with the same appreciation, include crab xacuti, crab xec-xec and stuffed crab. In fact, crab as seafood is a big hit with tourists and is a highly-priced item on the restaurant menus in Goa.\r\nBack in the day, phones and cable television were a rarity and spending so much of our time outdoors catching crabs was a sort of entertainment in its own way.\r\nToday our busy schedules don’t allow us to make many trips, but memories have managed to have the same grip on our hearts as the crabs’ claws, remaining as fresh as the crabs that would once scuttle away from under our feet while strolling on the beach.');

-- --------------------------------------------------------

--
-- Table structure for table `audit_logs`
--

CREATE TABLE `audit_logs` (
  `id` int(11) NOT NULL,
  `user_uid` varchar(20) NOT NULL,
  `action` varchar(50) NOT NULL,
  `target_table` varchar(50) NOT NULL,
  `record_id` int(11) DEFAULT NULL,
  `details` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `audit_logs`
--

INSERT INTO `audit_logs` (`id`, `user_uid`, `action`, `target_table`, `record_id`, `details`, `created_at`) VALUES
(1, 'ADM-9999', 'EDIT_SPECIES', 'fish_species', 6, 'Updated species: Crab', '2026-09-14 19:05:14'),
(2, 'TEM-F4D0B7', 'SUBMIT_DRAFT', 'pending_edits', 1, 'Submitted EDIT request for review', '2026-09-14 19:34:37'),
(3, 'ADM-9999', 'APPROVE_EDIT', 'fish_species', 4, 'Approved edit submitted by TEM-F4D0B7', '2026-09-14 19:36:38'),
(4, 'TEM-F4D0B7', 'SUBMIT_DRAFT', 'pending_edits', 2, 'Submitted ADD request for review', '2026-09-14 19:38:44'),
(5, 'ADM-9999', 'APPROVE_ADD', 'fish_species', 20, 'Approved addition submitted by TEM-F4D0B7', '2026-09-14 19:39:09'),
(6, 'TEM-F4D0B7', 'SUBMIT_DRAFT', 'pending_edits', 3, 'Submitted DELETE request for review', '2026-09-14 19:39:49'),
(7, 'ADM-9999', 'APPROVE_DELETE', 'fish_species', 20, 'Approved deletion submitted by TEM-F4D0B7', '2026-09-14 19:40:07');

-- --------------------------------------------------------

--
-- Table structure for table `contact_info`
--

CREATE TABLE `contact_info` (
  `id` int(11) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `contact_info`
--

INSERT INTO `contact_info` (`id`, `email`, `phone`, `address`) VALUES
(1, 'jk@gmail.com', '+91 1234876757', 'Goa, India');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` longtext DEFAULT NULL,
  `submitted_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `crabs`
--

CREATE TABLE `crabs` (
  `id` int(11) NOT NULL,
  `common_name` varchar(100) NOT NULL,
  `scientific_name` varchar(100) DEFAULT NULL,
  `local_konkani_name` varchar(100) NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `habitat` varchar(150) DEFAULT 'Estuaries & Mangrove Swamps',
  `catch_method` varchar(150) DEFAULT 'Crab Traps (Kotto) / Hand Lines',
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `crabs`
--

INSERT INTO `crabs` (`id`, `common_name`, `scientific_name`, `local_konkani_name`, `image_url`, `habitat`, `catch_method`, `description`) VALUES
(1, 'Mud Crab / Mangrove Crab', 'Scylla serrata', 'Kurli / Kurlio', 'https://media.gettyimages.com/id/2224438214/photo/mud-crab-in-market.webp?s=612x612&w=gi&k=20&c=8cmoLx5tMHC3HDMBNnHsHfPi5dtxOZ-KlWM60U7k99w=', 'Mangrove Creeks & Brackish Estuaries', 'Crab Traps (Kotto), Hand Lines with Bait', 'The iconic mud crab of Goa, found widely in mangrove swamps. Celebrated for its rich, sweet meat and as the main ingredient in authentic Goan Crab Xec Xec.'),
(2, 'Blue Swimmer Crab', 'Portunus pelagicus', 'Pikne Kurli', 'https://media.gettyimages.com/id/558976293/photo/a-pile-of-blue-swimmer-crabs-for-sale-in-a-fish-market.jpg?s=612x612&w=0&k=20&c=L8zGRT9zz7Coo4WsO6OtKxfI8RR0I9vSXGskGHURWoM=', 'Inshore Ocean & Coastal Bays', 'Trawlers, Gillnets', 'Recognized by its blue marbling and swimming paddle legs, this marine crab is commonly landed by coastal fishermen and shacks.'),
(3, 'Three-Spot Swimming Crab', 'Portunus sanguinolentus', 'Tika Kurli', 'https://thumb.wikimedia.org/wikipedia/commons/thumb/9/97/Portunus_sanguinolentus.jpg/250px-Portunus_sanguinolentus.jpg?utm_source=en.wikipedia.org&utm_campaign=parser&utm_content=thumbnail', 'Sandy Bottoms & Shallow Coastal Waters', 'Bottom Trawls, Cast Nets', 'Distinctly marked with three red spots on its shell, this species frequents sandy coastal seabed areas around Goa.');

-- --------------------------------------------------------

--
-- Table structure for table `faqs`
--

CREATE TABLE `faqs` (
  `id` int(11) NOT NULL,
  `sort_order` int(11) DEFAULT NULL,
  `question` varchar(500) DEFAULT NULL,
  `answer` longtext DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `faqs`
--

INSERT INTO `faqs` (`id`, `sort_order`, `question`, `answer`) VALUES
(1, 1, 'Importance of fish in Goa', 'Fish is one of the most important natural resources of the world and holds greater importance to the state of Goa being an integral part of Goan life and culture. It is considered as a staple diet for more than 90% of the population of Goa.'),
(2, 2, 'What is the fishing tradition in Goa?', 'The local method of stake fishing is known as khutani or khutavanni. In this method, wooden poles are staked into the river with a net tied across them to trap fish. The fish are then harvested at low tide.'),
(3, 3, 'Which fish is popular in Goa?', 'There\'s much to choose from Goa\'s fresh catch: the flat lepo (sole fish), chonak (giant sea perch), xinaneo (mussels), visvonn (kingfish), tisryo (clams), kalvam (oysters), black and white pomfrets and more. The simplest way to enjoy this fish is fried (with a generous coating of rava).');

-- --------------------------------------------------------

--
-- Table structure for table `fishing_communities`
--

CREATE TABLE `fishing_communities` (
  `id` int(11) NOT NULL,
  `surname` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `fishing_communities`
--

INSERT INTO `fishing_communities` (`id`, `surname`) VALUES
(1, 'Kharvi'),
(2, 'Nustekar'),
(3, 'Arrikar'),
(4, 'Kantaikar'),
(5, 'Magkar'),
(6, 'Pagelkar'),
(7, 'Ramponkar');

-- --------------------------------------------------------

--
-- Table structure for table `fishing_methods`
--

CREATE TABLE `fishing_methods` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `local_konkani_name` varchar(100) NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `water_body` varchar(150) DEFAULT 'Estuaries & Khazan Lands',
  `target_species` varchar(200) DEFAULT 'Shevtto, Sungtam, Kurli',
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fishing_methods`
--

INSERT INTO `fishing_methods` (`id`, `title`, `local_konkani_name`, `image_url`, `water_body`, `target_species`, `description`) VALUES
(1, 'Sluice Gate Fishing', 'Manus', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSf8d7Yk2g8yt-fgCMxlig-KeLn7ox3xl_1kaMFaV8Gng&s=10', 'Khazan Lands & Brackish Estuaries', 'Shevtto (Mullet), Sungtam (Prawns), Kalundar', 'A centuries-old indigenous aquaculture system in Goa. Wooden sluice gates (Manus) regulate tidal water flow in agricultural Khazan lands. Wooden mesh traps (Thott) capture high-yielding mullet and prawns during high and low tides.'),
(2, 'Cast Netting', 'Pagel', 'https://thumb.wikimedia.org/wikipedia/commons/thumb/3/3a/Murad-Net_Casting.jpg/330px-Murad-Net_Casting.jpg?utm_source=en.wikipedia.org&utm_campaign=parser&utm_content=thumbnail', 'Shallow Estuaries, Rivers & Beaches', 'Shevtto, Sungtam, Buranto', 'A classic circular net weighted with lead along the edges. The fisherman throws the net so it unfolds completely over water, trapping shallow-water fish as it sinks to the bed.'),
(3, 'Traditional Crab Traps', 'Kotto', 'https://princeofsal.com/wp-content/uploads/2017/07/crab-catching-trip.jpg', 'Mangrove Creeks & Estuarine Mudflats', 'Kurli / Kurlio (Mud Crabs)', 'A woven bamboo or wire mesh trap baited with fresh fish offal. Placed along mangrove roots during high tide to entice mud crabs seeking bait.'),
(4, 'Shore Seine Netting', 'Rampani', 'https://thumb.wikimedia.org/wikipedia/commons/thumb/a/ac/Seining_for_wild_fish.jpg/250px-Seining_for_wild_fish.jpg?utm_source=en.wikipedia.org&utm_campaign=parser&utm_content=thumbnail', 'Open Coastal Beaches', 'Bangdo (Mackerel), Tarli (Sardines)', 'A traditional community-driven beach seine technique. A large net is hauled in unison by teams of local fishermen from the shoreline when pelagic schools approach the coast.'),
(5, 'Stake Nets / Tidal Traps', 'Katalli / Ghon', 'https://www.seafish.org/media/iewhvwfr/67-fyke-net.jpg?v=1dadf4981b43ad0', 'Estuarine Intertidal Channels', 'Sungtam, Small Coastal Fish', 'Nets fixed to wooden stakes driven into estuarine mudflats. The nets filter fish moving along natural currents as the tide recedes.');

-- --------------------------------------------------------

--
-- Table structure for table `fish_species`
--

CREATE TABLE `fish_species` (
  `id` int(11) NOT NULL,
  `common_name` varchar(100) NOT NULL,
  `scientific_name` varchar(100) DEFAULT NULL,
  `local_konkani_name` varchar(100) NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `habitat` varchar(150) DEFAULT 'Estuarine & Coastal Waters',
  `catch_method` varchar(150) DEFAULT 'Gillnets / Cast Nets',
  `description` text DEFAULT NULL,
  `is_state_fish` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fish_species`
--

INSERT INTO `fish_species` (`id`, `common_name`, `scientific_name`, `local_konkani_name`, `image_url`, `habitat`, `catch_method`, `description`, `is_state_fish`) VALUES
(1, 'Striped Grey Mullet', 'Mugil cephalus', 'Shevtto', 'https://images.unsplash.com/photo-1544551763-46a013bb70d5?auto=format&fit=crop&w=1200&q=80', 'Estuaries, Lagoons & Khazan Lands', 'Cast Nets (Pagel), Sluice Gates (Manus)', 'Shevtto is Goa’s official state fish. Essential to brackish water ecosystems, it is celebrated for its rich flavor in traditional Goan curry.', 1),
(2, 'Prawns', 'Penaeus monodon', 'Sungtam/Sungot', 'https://images.unsplash.com/photo-1565680018434-b513d5e5fd47?auto=format&fit=crop&w=1200&q=80', 'Estuaries & Coastal Waters', 'Cast Nets, Trawlers, Sluice Gates', 'A cornerstone of Goan cuisine, prawns are integral to everyday meals, from spicy Sungtache Hooman to rava-fried snacks.', 0),
(3, 'Pomfret', 'Pampus argenteus', 'Pamplet', 'https://images.unsplash.com/photo-1534043464124-3be32fe000c9?auto=format&fit=crop&w=1200&q=80', 'Coastal Pelagic Waters', 'Gillnets, Trawlers', 'Highly prized across Goan households and beach shacks for its delicate, soft texture. Perfect for whole rava fry or green Recheado masala.', 0),
(4, 'Squid', 'Uroteuthis duvaucelii', 'Maanki/Bonddas', 'https://images.unsplash.com/photo-1545671913-b89ac1b4ac10?auto=format&fit=crop&w=1200&q=80', '', '', '', 0),
(5, 'Sole Fish / Tongue Fish', 'Cynoglossus macrostomus', 'Lep/Lepo', 'https://images.unsplash.com/photo-1519708227418-c8fd9a32b7a2?auto=format&fit=crop&w=1200&q=80', 'Benthic Muddy Sea Bottoms', 'Shore Seine, Trawlers', 'A flatfish found along coastal waters, Lepo is a favorite comfort food in Goa when shallow-fried with semolina and coastal spices.', 0),
(6, 'Crab', 'Scylla serrata', 'Kurli/Kurlio', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRu_8ttku9u4ayQlzTECGsQDTFasUArWkC_y00s94O3CQ&s=10', '', '', '', 0),
(7, 'Clams / Cockles', 'Meretrix casta', 'Kubo/Kube', 'https://images.unsplash.com/photo-1615141982883-c7ad0e69fd62?auto=format&fit=crop&w=1200&q=80', 'Estuarine Sandbars & Tidal Flats', 'Hand Harvesting (Kube Kaddop)', 'Harvested manually along tidal estuaries, clams are cooked with freshly scraped coconut and spices to make traditional Kube Sukkem.', 0),
(8, 'Pearl Spot', 'Etroplus suratensis', 'Kalundar', 'https://images.unsplash.com/photo-1522069169874-c58ec4b76be5?auto=format&fit=crop&w=1200&q=80', 'Brackish Waters & Rivers', 'Cast Nets, Gillnets', 'An estuarine species thriving in Goa’s inland rivers and backwaters, appreciated for its firm texture and distinct earthy taste.', 0),
(9, 'Oysters', 'Crassostrea madrasensis', 'Kalvam', 'https://images.unsplash.com/photo-1551248429-40975aa4de74?auto=format&fit=crop&w=1200&q=80', 'Estuarine Rocks & Intertidal Zones', 'Manual Chiseling', 'Found attached to estuarine rocks, oysters are a seasonal delicacy harvested locally and enjoyed fried or in spicy gravy.', 0),
(10, 'Shrimps', 'Acetes indicus', 'Galmo', 'https://images.unsplash.com/photo-1565680018434-b513d5e5fd47?auto=format&fit=crop&w=1200&q=80', 'Shallow Coastal & Estuarine Waters', 'Fine Mesh Nets', 'Tiny, high-yield shrimps collected near coastal margins, often sun-dried or cooked fresh in traditional Goan vegetable and coconut dishes.', 0),
(11, 'Grunter Fish', 'Pomadasys hasta', 'Callas', 'https://images.unsplash.com/photo-1534043464124-3be32fe000c9?auto=format&fit=crop&w=1200&q=80', 'Coastal Reefs & Estuaries', 'Hook & Line, Gillnets', 'Known for the grunting noise it makes, Callas is a firm-fleshed coastal fish well suited for Goan fish curries.', 0),
(12, 'Murrels / Snakehead', 'Channa striata', 'Chikale', 'https://images.unsplash.com/photo-1520301251430-802344793740?auto=format&fit=crop&w=1200&q=80', 'Freshwater Ponds & Inland Streams', 'Hand Line, Traps', 'A freshwater fish inhabiting Goa’s lakes and agricultural waterways, highly valued for its nutritional and restorative qualities.', 0),
(13, 'Giant Sea Perch / Barramundi', 'Lates calcarifer', 'Chonak', 'https://images.unsplash.com/photo-1524704654690-b56c05c78a00?auto=format&fit=crop&w=1200&q=80', 'Rivers & Estuaries', 'Hook and Line, Gillnets', 'Chonak is a premier fish in Goan cuisine, highly sought after for its tender white fillets, perfect for Recheado masala stuffing and rava fry.', 0),
(14, 'Glassy Perchlet', 'Parambassis ranga', 'Buranto', 'https://images.unsplash.com/photo-1520301251430-802344793740?auto=format&fit=crop&w=1200&q=80', 'Freshwater Streams & Estuaries', 'Fine Cast Nets', 'Small translucent fish found in inland waters, often fried crisp or cooked in local quick-style curries.', 0),
(15, 'Bluefin Tuna', 'Thunnus thynnus', 'Bakado', 'https://images.unsplash.com/photo-1544551763-46a013bb70d5?auto=format&fit=crop&w=1200&q=80', 'Deep Offshore Pelagic Waters', 'Longline, Trawlers', 'A large pelagic fish caught by deep-sea fishing craft, Bakado provides meaty steaks suitable for rich spicy fish preparations.', 0),
(16, 'Ribbon Fish', 'Trichiurus lepturus', 'Bale', 'https://images.unsplash.com/photo-1519708227418-c8fd9a32b7a2?auto=format&fit=crop&w=1200&q=80', 'Coastal Shelf Waters', 'Trawlers, Shore Seine', 'Characterized by its long, silver ribbon-like body, Bale is commonly sun-dried or fried crisp with traditional spice rubs.', 0),
(17, 'Cuttlefish', 'Sepia pharaonis', 'Bebu', 'https://images.unsplash.com/photo-1545671913-b89ac1b4ac10?auto=format&fit=crop&w=1200&q=80', 'Inshore Coastal Waters', 'Trawlers, Traps', 'Similar to squid, Bebu offers a slightly thicker texture that absorbs local marinades exceptionally well.', 0),
(18, 'Bombay Duck', 'Harpadon nehereus', 'Bombil', 'https://images.unsplash.com/photo-1519708227418-c8fd9a32b7a2?auto=format&fit=crop&w=1200&q=80', 'Estuarine Mudflats & Coastal Waters', 'Dol Nets, Trawlers', 'A soft-boned fish popular across coastal western India. It is frequently pan-fried crisp or dried for monsoon storage.', 0),
(19, 'Indian Mackerel', 'Rastrelliger kanagurta', 'Bangdo', 'https://images.unsplash.com/photo-1534043464124-3be32fe000c9?auto=format&fit=crop&w=1200&q=80', 'Coastal Pelagic Waters', 'Rampani Nets, Gillnets', 'Bangdo is the daily staple seafood of Goa. Rich in flavour, it is famous for crisp Bangda Rava Fry and spicy Bangdyacho Hooman.', 0);

-- --------------------------------------------------------

--
-- Table structure for table `media_assets`
--

CREATE TABLE `media_assets` (
  `id` int(11) NOT NULL,
  `fish_species_id` int(11) DEFAULT NULL,
  `related_page` varchar(100) DEFAULT NULL,
  `file_path` varchar(500) DEFAULT NULL,
  `file_type` varchar(20) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `media_assets`
--

INSERT INTO `media_assets` (`id`, `fish_species_id`, `related_page`, `file_path`, `file_type`) VALUES
(1, NULL, 'Introducton', 'Introducton/header1.jpg', 'jpg'),
(2, NULL, 'about', 'about/Snapchat-1506180828.jpg', 'jpg'),
(3, NULL, 'about', 'about/about-2.jpg', 'jpg'),
(4, NULL, 'about', 'about/blog-3.jpg', 'jpg'),
(5, NULL, 'background', 'background/header1.jpg', 'jpg'),
(6, NULL, 'fish', 'fish/Grey mullet in Goa.jpg', 'jpg'),
(7, NULL, 'fish', 'fish/Grey-Mullet-Cover-1.jpg', 'jpg'),
(8, NULL, 'fish', 'fish/Sluice-gate-1.jpg', 'jpg'),
(9, NULL, 'fish', 'fish/Striped grey mullet12.jpg', 'jpg'),
(10, NULL, 'fish', 'fish/Web capture_25-9-2023_234537_www.fisheries.goa.gov.in.jpeg', 'jpeg'),
(11, NULL, 'fish', 'fish/Web capture_25-9-2023_235339_www.fisheries.goa.gov.in.jpeg', 'jpeg'),
(12, NULL, 'fish', 'fish/Web capture_26-9-2023_0126_www.fisheries.goa.gov.in.jpeg', 'jpeg'),
(13, NULL, 'fish', 'fish/Web capture_26-9-2023_01559_www.fisheries.goa.gov.in.jpeg', 'jpeg'),
(14, NULL, 'fish', 'fish/Web capture_26-9-2023_01851_www.fisheries.goa.gov.in.jpeg', 'jpeg'),
(15, NULL, 'fish', 'fish/Web capture_26-9-2023_02326_www.fisheries.goa.gov.in.jpeg', 'jpeg'),
(16, NULL, 'fish', 'fish/Web capture_26-9-2023_02628_www.fisheries.goa.gov.in.jpeg', 'jpeg'),
(17, NULL, 'fish', 'fish/Web capture_26-9-2023_0439_www.fisheries.goa.gov.in.jpeg', 'jpeg'),
(18, NULL, 'fish', 'fish/Web capture_26-9-2023_0824_www.fisheries.goa.gov.in.jpeg', 'jpeg'),
(19, NULL, 'fish', 'fish/cast-net-fishing-from-boat-kathalli-in-goa.jpg', 'jpg'),
(20, NULL, 'fish', 'fish/crabe.jpg', 'jpg'),
(21, NULL, 'fish', 'fish/crabe1.jpg', 'jpg'),
(22, NULL, 'fish', 'fish/crabe2.jpg', 'jpg'),
(23, NULL, 'fish', 'fish/crabe3.jpg', 'jpg'),
(24, NULL, 'fish', 'fish/crabe4.jpg', 'jpg'),
(25, NULL, 'fish', 'fish/fishing-in-goa-using-trawlers.jpg', 'jpg'),
(26, NULL, 'fish', 'fish/fishing-using-lights-goa.jpg', 'jpg'),
(27, NULL, 'fish', 'fish/i1.png', 'png'),
(28, NULL, 'fish', 'fish/i10.png', 'png'),
(29, NULL, 'fish', 'fish/i11.png', 'png'),
(30, NULL, 'fish', 'fish/i12.png', 'png'),
(31, NULL, 'fish', 'fish/i13.png', 'png'),
(32, NULL, 'fish', 'fish/i14.png', 'png'),
(33, NULL, 'fish', 'fish/i15.png', 'png'),
(34, NULL, 'fish', 'fish/i16.png', 'png'),
(35, NULL, 'fish', 'fish/i17.png', 'png'),
(36, NULL, 'fish', 'fish/i18.png', 'png'),
(37, NULL, 'fish', 'fish/i2.png', 'png'),
(38, NULL, 'fish', 'fish/i3.png', 'png'),
(39, NULL, 'fish', 'fish/i4.png', 'png'),
(40, NULL, 'fish', 'fish/i5.png', 'png'),
(41, NULL, 'fish', 'fish/i6.png', 'png'),
(42, NULL, 'fish', 'fish/i7.png', 'png'),
(43, NULL, 'fish', 'fish/i8.png', 'png'),
(44, NULL, 'fish', 'fish/i9.png', 'png'),
(45, NULL, 'fish', 'fish/jk.jpeg', 'jpeg'),
(46, NULL, 'fish', 'fish/pexels-philippe-donn-1114690.jpg', 'jpg'),
(47, NULL, 'fish', 'fish/ramponn-traditional-fishing-method-in-goa.jpg', 'jpg'),
(48, NULL, 'fish', 'fish/rod-fishing.jpg', 'jpg'),
(49, NULL, 'fish', 'fish/stake-fishing-method-goa.jpg', 'jpg'),
(50, NULL, 'fish', 'fish/traditional-fishing-in-goa.jpg', 'jpg'),
(51, NULL, 'fish', 'fish/traditional-fishing-in-goa.webp', 'webp'),
(52, NULL, 'fish', 'fish/zhari-fish-baskets-fishing-in-goa.jpg', 'jpg'),
(53, NULL, 'fish_-_10531 (Original).mp4', 'fish_-_10531 (Original).mp4', 'mp4'),
(54, NULL, 'image', 'image/fish/crabe.jpg', 'jpg'),
(55, NULL, 'image', 'image/fish/fish1.jpg', 'jpg'),
(56, NULL, 'image', 'image/fish/fish2.jpg', 'jpg'),
(57, NULL, 'image', 'image/fish/fish3.jpg', 'jpg'),
(58, NULL, 'image', 'image/fish/fish4.jpg', 'jpg'),
(59, NULL, 'image', 'image/fish/pronce.jpg', 'jpg'),
(60, NULL, 'image', 'image/fish/pronce1.html.jpg', 'jpg'),
(61, NULL, 'login', 'login/images/google.png', 'png');

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` int(11) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `content` longtext DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `slug`, `title`, `content`, `updated_at`) VALUES
(1, 'home', 'Goa\'s Fish and Fishing techniques', 'Goa\'s Fish and Fishing techniques. Web Tech Assignment.', '2026-09-14 08:18:47'),
(2, 'about', 'About', 'Goa is a state on the southwestern coast of India, with the Arabian Sea forming its western coast. It is the smallest state by area. This website is mainly divided into two main parts: firstly the fish found in Goa, and secondly the fishing techniques found in Goa.\r\n\r\nSources & copyright note: Information collected and published using an authentic set of information by the programmer, and from trusted sources like fishermen, fisherwomen of Goa, Government of Goa, Wikipedia, DevCrud, W3Schools etc. Coding was self-edited and written by the programmer; copyright reserved.', '2026-09-14 08:18:47');

-- --------------------------------------------------------

--
-- Table structure for table `pending_edits`
--

CREATE TABLE `pending_edits` (
  `id` int(11) NOT NULL,
  `user_uid` varchar(50) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `target_table` varchar(50) NOT NULL,
  `target_id` int(11) DEFAULT NULL,
  `action_type` enum('ADD','EDIT','DELETE') NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL
) ;

--
-- Dumping data for table `pending_edits`
--

INSERT INTO `pending_edits` (`id`, `user_uid`, `user_name`, `target_table`, `target_id`, `action_type`, `payload`, `status`, `created_at`) VALUES
(1, 'TEM-F4D0B7', 'test', 'fish_species', 4, 'EDIT', '{\"common_name\":\"Squid\",\"scientific_name\":\"Uroteuthis duvaucelii\",\"local_konkani_name\":\"Maanki\\/Bonddas\",\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1545671913-b89ac1b4ac10?auto=format&fit=crop&w=1200&q=80\",\"habitat\":\"\",\"catch_method\":\"\",\"description\":\"\"}', 'approved', '2026-09-14 19:34:37'),
(2, 'TEM-F4D0B7', 'test', 'fish_species', NULL, 'ADD', '{\"common_name\":\"test\",\"scientific_name\":\"test\",\"local_konkani_name\":\"test\",\"image_url\":\"https:test.com\",\"habitat\":\"test\",\"catch_method\":\"tset\",\"description\":\"tsest\"}', 'approved', '2026-09-14 19:38:44'),
(3, 'TEM-F4D0B7', 'test', 'fish_species', 20, 'DELETE', '{\"common_name\":\"\",\"scientific_name\":\"\",\"local_konkani_name\":\"\",\"image_url\":\"\",\"habitat\":\"\",\"catch_method\":\"\",\"description\":\"\"}', 'approved', '2026-09-14 19:39:49');

-- --------------------------------------------------------

--
-- Table structure for table `site_content`
--

CREATE TABLE `site_content` (
  `id` int(11) NOT NULL,
  `page_name` varchar(50) NOT NULL,
  `element_key` varchar(50) NOT NULL,
  `element_value` text NOT NULL,
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `survey_responses`
--

CREATE TABLE `survey_responses` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `gender` enum('Male','Female','Prefer Not to say') DEFAULT NULL,
  `role` enum('Student','Full Time Job','Full Time Learner','Prefer Not to say','other') DEFAULT NULL,
  `page_rating` enum('Very bad','Bad','neutral','Good','Very Good') DEFAULT NULL,
  `submitted_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `user_uid` varchar(20) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','team') NOT NULL DEFAULT 'team',
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_uid`, `full_name`, `email`, `password`, `role`, `created_at`) VALUES
(3, 'ADM-9999', 'System Admin', 'admin@example.com', '$2y$10$SoE.7CRUKnX9fXiMlLYRWOktMDNTfjVeDk.jNYJMqY24NGbNdi8Q6', 'admin', '2026-09-14 16:50:12'),
(4, 'TEM-F4D0B7', 'test', 'test@gmail.com', '$2y$10$41TVKLdGeRL3XnoNd7liPeATwxIrYOyDjnFWzI/0iMVwhaAS6kQ8C', 'team', '2026-09-14 19:27:25');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `app_settings`
--
ALTER TABLE `app_settings`
  ADD PRIMARY KEY (`setting_key`);

--
-- Indexes for table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_info`
--
ALTER TABLE `contact_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `crabs`
--
ALTER TABLE `crabs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `faqs`
--
ALTER TABLE `faqs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fishing_communities`
--
ALTER TABLE `fishing_communities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fishing_methods`
--
ALTER TABLE `fishing_methods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fish_species`
--
ALTER TABLE `fish_species`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `media_assets`
--
ALTER TABLE `media_assets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `site_content`
--
ALTER TABLE `site_content`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `page_element` (`page_name`,`element_key`);

--
-- Indexes for table `survey_responses`
--
ALTER TABLE `survey_responses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_uid` (`user_uid`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `audit_logs`
--
ALTER TABLE `audit_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `contact_info`
--
ALTER TABLE `contact_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `crabs`
--
ALTER TABLE `crabs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `faqs`
--
ALTER TABLE `faqs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `fishing_communities`
--
ALTER TABLE `fishing_communities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `fishing_methods`
--
ALTER TABLE `fishing_methods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `fish_species`
--
ALTER TABLE `fish_species`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `media_assets`
--
ALTER TABLE `media_assets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pending_edits`
--
ALTER TABLE `pending_edits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `site_content`
--
ALTER TABLE `site_content`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `survey_responses`
--
ALTER TABLE `survey_responses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
