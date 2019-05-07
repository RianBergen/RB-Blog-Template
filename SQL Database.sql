-- phpMyAdmin SQL Dump
-- version 4.6.6deb4
-- https://www.phpmyadmin.net/
--
-- Host: db743876852.db.1and1.com
-- Generation Time: May 07, 2019 at 12:35 PM
-- Server version: 5.5.60-0+deb7u1-log
-- PHP Version: 7.0.33-0+deb9u3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db743876852`
--

-- --------------------------------------------------------

--
-- Table structure for table `blog_categories`
--

CREATE TABLE `blog_categories` (
  `categoryID` int(11) UNSIGNED NOT NULL,
  `categoryTitle` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `categorySlug` varchar(255) COLLATE latin1_general_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `blog_categories`
--

INSERT INTO `blog_categories` (`categoryID`, `categoryTitle`, `categorySlug`) VALUES
(1, 'Maintenance', 'maintenance'),
(2, 'Coming Soon', 'coming-soon');

-- --------------------------------------------------------

--
-- Table structure for table `blog_members`
--

CREATE TABLE `blog_members` (
  `memberID` int(11) UNSIGNED NOT NULL,
  `memberUsername` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `memberPassword` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `memberEmail` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `memberDateJoin` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `blog_members`
--

-- Data Removed For Security Purposes

-- --------------------------------------------------------

--
-- Table structure for table `blog_pages`
--

CREATE TABLE `blog_pages` (
  `pageID` int(11) NOT NULL,
  `pageTitle` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `PageContent` text COLLATE latin1_general_ci,
  `PageSlug` varchar(255) COLLATE latin1_general_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `blog_pages`
--

INSERT INTO `blog_pages` (`pageID`, `pageTitle`, `PageContent`, `PageSlug`) VALUES
(1, 'About', '<p>Coming Soon...</p>', 'about'),
(2, 'Contact', '<p>Coming Soon...</p>', 'contact'),
(3, 'Subscribe', '<p>Coming Soon...</p>', 'subscribe'),
(4, 'Terms and Conditions', '<h2>Terms and Conditions Page</h2>\r\n<h3>01. Introduction</h3>\r\n<p>These Website Terms And Conditions (these \"Terms\" or these \"Website Terms And Conditions\") contained herein on this webpage, shall govern your use of this website, including all pages within this website (collectively referred to herein below as this \"Website\"). These Terms apply in full force and effect to your use of this Website and by using this Website, you expressly accept all terms and conditions contained herein in full. You must not use this Website, if you have any objection to any of these Website Terms And Conditions.</p>\r\n<p>This Website is not for use by any minors (defined as those who are not at least 18 years of age), and you must not use this Website if you are a minor.</p>\r\n<h3>02. Intellectual Property Rights</h3>\r\n<p>Other than content you own, which you may have opted to include on this Website, under these Terms, Rian-Pascal Bergen (TM)(C)(All Rights Reserved) (collectively referred to herein below as this \"Company\") and/or its licensors own all rights to the intellectual property and material contained in this Website, and all such rights are reserved.</p>\r\n<p>You are granted a limited license only, subject to the restrictions provided in these Terms, for purposes of viewing the material contained on this Website.</p>\r\n<h3>03. Restrictions</h3>\r\n<p>You are expressly and emphatically restricted from all of the following:</p>\r\n<p class=\"rb-indent\">a. publishing any Website material in any media;</p>\r\n<p class=\"rb-indent\">b. selling, sub licensing and/or otherwise commercializing any Website material;</p>\r\n<p class=\"rb-indent\">c. publicly performing and/or showing any Website material;</p>\r\n<p class=\"rb-indent\">d. using this Website in any way that is, or may be, damaging to this Website;</p>\r\n<p class=\"rb-indent\">e. using this Website in any way that impacts user access to this Website;</p>\r\n<p class=\"rb-indent\">f. using this Website contrary to applicable laws and regulations, or in a way that causes, or may cause, harm to the Website, or to any person or business entity;</p>\r\n<p class=\"rb-indent\">g. engaging in any data mining, data harvesting, data extracting or any other similar activity in relation to this Website, or while using this Website;</p>\r\n<p class=\"rb-indent\">h. using this Website to engage in any advertising or marketing;</p>\r\n<p>Certain areas of this Website are restricted from access by you and this Company may further restrict access by you to any areas of this Website, at any time, in its sole and absolute discretion. Any user ID and password you may have for this Website are confidential and you must maintain confidentiality of such information.</p>\r\n<h3>04. Your Content</h3>\r\n<p>In these Website Terms And Conditions, \"Your Content\" shall mean any audio, video, text, images or other material you choose to display on this Website. With respect to Your Content, by displaying it, you grant this Company a non-exclusive, worldwide, irrevocable, royalty-free, sub-licensable license to use, reproduce, adapt, publish, translate and distribute it in any and all media.</p>\r\n<p>Your Content must be your own and must not be infringing on any third party\'s rights. This Company reserves the right to remove any of Your Content from this Website at any time, and for any reason, without notice.</p>\r\n<h3>05. No warranties</h3>\r\n<p>This Website is provided \"as is,\" with all faults, and this Company makes no express or implied representations or warranties, of any kind related to this Website or the materials contained on this Website. Additionally, nothing contained on this Website shall be construed as providing consult or advice to you.</p>\r\n<h3>06. Limitation of liability</h3>\r\n<p>In no event shall this Company, nor any of its officers, directors and employees, be liable to you for anything arising out of or in any way connected with your use of this Website, whether such liability is under contract, tort or otherwise, and this Company, including its officers, directors and employees shall not be liable for any indirect, consequential or special liability arising out of or in any way related to your use of this Website.</p>\r\n<h3>07. Indemnification</h3>\r\n<p>You hereby indemnify to the fullest extent this Company from and against any and all liabilities, costs, demands, causes of action, damages and expenses (including reasonable attorney\'s fees) arising out of or in any way related to your breach of any of the provisions of these Terms.</p>\r\n<h3>08. Severability</h3>\r\n<p>If any provision of these Terms is found to be unenforceable or invalid under any applicable law, such unenforceability or invalidity shall not render these Terms unenforceable or invalid as a whole, and such provisions shall be deleted without affecting the remaining provisions herein.</p>\r\n<h3>09. Variation of Terms</h3>\r\n<p>This Company is permitted to revise these Terms at any time as it sees fit, and by using this Website you are expected to review such Terms on a regular basis to ensure you understand all terms and conditions governing use of this Website.</p>\r\n<h3>10. Assignment</h3>\r\n<p>This Company shall be permitted to assign, transfer, and subcontract its rights and/or obligations under these Terms without any notification or consent required. However, .you shall not be permitted to assign, transfer, or subcontract any of your rights and/or obligations under these Terms.</p>\r\n<h3>11. Entire Agreement</h3>\r\n<p>These Terms, including any legal notices and disclaimers contained on this Website, constitute the entire agreement between this Company and you in relation to your use of this Website, and supersede all prior agreements and understandings with respect to the same.</p>\r\n<h3>12. Governing Law &amp; Jurisdiction</h3>\r\n<p>These Terms will be governed by and construed in accordance with the laws of the State of Georgia, and you submit to the non-exclusive jurisdiction of the state and federal courts located in Georgia for the resolution of any disputes.</p>\r\n<h3>13. Your Consent</h3>\r\n<p>By using our site, you consent to these Terms.</p>\r\n<h3>14. Software EULA</h3>\r\n<p>Any Software found on our site is subject to our Software EULA. By using our site, you consent to the Software EULA linked below:<br /><a class=\"rb-button rb-button-border rb-padding-1rem-2rem rb-no-margin-left\" href=\"../info/software-eula\">Software EULA</a></p>\r\n<h3>15. Privacy Policy</h3>\r\n<p>By using our site, you consent to the Privacy Policy linked below:<br /><a class=\"rb-button rb-button-border rb-padding-1rem-2rem rb-no-margin-left\" href=\"../info/privacy-policy\">Privacy Policy</a></p>\r\n<h3>16. Changes To Our Terms and Conditions</h3>\r\n<p>If this Company decides to change these Website Terms and Conditions, we will post those changes on this page, send an email notifying you of any changes, and/or update the these Terms Modification Date below.</p>\r\n<h3>17. Contacting Us</h3>\r\n<p>If there are any questions regarding these Website Terms and Conditions you may contact us using the link below:<br /><a class=\"rb-button rb-button-border rb-padding-1rem-2rem rb-no-margin-left\" href=\"../action/contact\">Contact Us</a></p>\r\n<p>Rian-Pascal Bergen (TM)(C)(All Rights Reserved)<br />https://www.rianbergen.com/</p>\r\n<p>Modification Date: January 01, 2019</p>', 'terms-and-conditions'),
(5, 'Software EULA', '<h2>Software EULA Page</h2>\r\n<h3>01. Introduction</h3>\r\n<p>This End-User License Agreement (EULA) is a legal agreement between you (either an individual or a single entity) and the mentioned author (RIANBERGEN.COM) of this software and any other located on the author\'s site, which includes computer software and may include associated media, printed materials, and \"online\" or electronic documentation (\"SOFTWARE PRODUCT\").</p>\r\n<h3>02. End-User License Agreement</h3>\r\n<p>Copyright 2019 Rian-Pascal Bergen (TM)(C)(All Rights Reserved) (https://www.rianbergen.com/)</p>\r\n<p>Licensed under the Apache License, Version 2.0 (the \"License\"); you may not use this file except in compliance with the License. You may obtain a copy of the License at<br /><a class=\"rb-button rb-button-border rb-padding-1rem-2rem rb-no-margin-left\" href=\"https://www.apache.org/licenses/LICENSE-2.0\">Apache License 2.0</a></p>\r\n<p>Unless required by applicable law or agreed to in writing, software distributed under the License is distributed on an \"AS IS\" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the License for the specific language governing permissions and limitations under the License.</p>\r\n<h3>03. Contacting Us</h3>\r\n<p>If there are any questions regarding this End-User License Agreement (EULA), you may contact us using the link below:<br /><a class=\"rb-button rb-button-border rb-padding-1rem-2rem rb-no-margin-left\" href=\"../action/contact\">Contact Us</a></p>\r\n<p>Rian-Pascal Bergen (TM)(C)(All Rights Reserved)<br />https://www.rianbergen.com/</p>\r\n<p>Modification Date: January 01, 2019</p>', 'software-eula'),
(6, 'Privacy Policy', '<h2>Privacy Policy Page</h2>\r\n<h3>01. Introduction</h3>\r\n<p>This privacy policy has been compiled to better serve those who are concerned with how their \'Personally Identifiable Information\' (PII) is being used online. PII, as described in US privacy law and information security, is information that can be used on its own or with other information to identify, contact, or locate a single person, or to identify an individual in context. Please read our privacy policy carefully to get a clear understanding of how we collect, use, protect or otherwise handle your Personally Identifiable Information in accordance with our website.</p>\r\n<h3>02. When do we collect information?</h3>\r\n<p>We collect information from you when you register on our site, subscribe to a newsletter, respond to a survey, fill out a form, or enter information on our site.</p>\r\n<p>This information can consist of: First and Last Name, Email Address, Gender, and any answered questionaire.</p>\r\n<h3>03. How do we use your information?</h3>\r\n<p>We may use the information we collect from you when you register, sign up for our newsletter, respond to a survey or marketing communication, surf the website, or use certain other site features in the following ways:</p>\r\n<p class=\"rb-indent\">a. To personalize your experience and to allow us to deliver the type of content and product offerings in which you are most interested;</p>\r\n<p class=\"rb-indent\">b. To improve our website in order to better serve you;</p>\r\n<p class=\"rb-indent\">c. To allow us to better service you in responding to your customer service requests;</p>\r\n<p class=\"rb-indent\">d. To send periodic emails regarding products and services;</p>\r\n<p>Your information, whether public or private, will not be sold, exchanged, transferred, or given to any other company for any reason whatsoever, without your consent, other than for the express purpose of delivering the purchased product or service requested, to administer a contest, promotion, survey or other site feature or to send periodic emails.</p>\r\n<p>Note: If at any time you would like to unsubscribe from receiving future emails, you may do so at the bottom of each email.</p>\r\n<h3>04. How do we protect your information?</h3>\r\n<p>Your personal information is contained behind secured networks and is only accessible by a limited number of persons who have special access rights to such systems, and are required to keep the information confidential. In addition, all sensitive information you supply is encrypted via Secure Socket Layer (SSL) technology and then encrypted into our Database.</p>\r\n<p>We implement a variety of security measures when a user enters, submits, or accesses their information to maintain the safety of your personal information.</p>\r\n<h3>05. Do we use \'cookies\'?</h3>\r\n<p>Yes. Cookies are small files that a site or its service provider transfers to your computer\'s hard drive through your Web browser (if you allow) that enables the site\'s or service provider\'s systems to recognize your browser and capture and remember certain information. They are also used to help us understand your preferences based on previous or current site activity, which enables us to provide you with improved services. We also use cookies to help us compile aggregate data about site traffic and site interaction so that we can offer better site experiences and tools in the future. We use cookies to:</p>\r\n<p class=\"rb-indent\">a. Understand and save user\'s preferences for future visits;</p>\r\n<p>You can choose to have your computer warn you each time a cookie is being sent, or you can choose to turn off all cookies. You do this through your browser settings. Since each browser is a little different, look at your browser\'s Help Menu to learn the correct way to modify your cookies.</p>\r\n<p>If you turn cookies off, some features will be disabled. Disabling cookies may affect features that make your site experience more efficient and may prevent them from functioning properly.</p>\r\n<h3>06. Third-Party Disclosure</h3>\r\n<p>We do not sell, trade, or otherwise transfer to outside parties your Personally Identifiable Information unless we provide users with advance notice. This does not include website hosting partners and other parties who assist us in operating our website, conducting our business, or serving our users, so long as those parties agree to keep this information confidential. We may also release information when it\'s release is appropriate to comply with the law, enforce our site policies, or protect ours or others\' rights, property or safety.</p>\r\n<h3>07. Third-Party Links</h3>\r\n<p>Occasionally, at our discretion, we may include or offer third-party products or services on our website. These third-party sites have separate and independent privacy policies. We therefore have no responsibility or liability for the content and activities of these linked sites. Nonetheless, we seek to protect the integrity of our site and welcome any feedback about these sites.</p>\r\n<h3>08. Google</h3>\r\n<p>Google\'s advertising requirements can be summed up by Google\'s Advertising Principles. They are put in place to provide a positive experience for users.<br /><a class=\"rb-button rb-button-border rb-padding-1rem-2rem rb-no-margin-left\" href=\"https://support.google.com/adwordspolicy/answer/1316548?hl=en\">Google\'s Advertising Principles</a></p>\r\n<p>We have not enabled Google AdSense on our site but we may do so in the future.</p>\r\n<h3>09. CalOPPA (California Online Privacy Protection Act)</h3>\r\n<p>CalOPPA is the first state law in the nation to require commercial websites and online services to post a privacy policy. The law\'s reach stretches well beyond California to require any person or company in the United States (and conceivably the world) that operates websites collecting Personally Identifiable Information from California consumers to post a conspicuous privacy policy on its website stating exactly the information being collected and those individuals or companies with whom it is being shared. See more at: <br /><a class=\"rb-button rb-button-border rb-padding-1rem-2rem rb-no-margin-left\" href=\"http://consumercal.org/california-online-privacy-protection-act-caloppa/#sthash.0FdRbT51.dpuf\">CalOPPA</a></p>\r\n<p><br />According to CalOPPA, we agree to the following:</p>\r\n<p class=\"rb-indent\">a. Users can visit our site anonymously.</p>\r\n<p class=\"rb-indent\">b. Users of our site may make any changes to their information at anytime by logging into their control panel and going to the \'Edit Profile\' page.</p>\r\n<p>Once this privacy policy is created, we will add a link to it on our home page or as a minimum, on the first significant page after entering our website. Our Privacy Policy link includes the word \'Privacy\' and can easily be found on the page specified above. Our Privacy Policy may change at any time necessary. You will be notified of any Privacy Policy changes:</p>\r\n<p class=\"rb-indent\">a. On our Privacy Policy Page</p>\r\n<h3>10. COPPA (Children\'s Online Privacy Protection Act)</h3>\r\n<p>We are in compliance with the requirements of COPPA (Childrens Online Privacy Protection Act), we do not collect any information from anyone under 13 years of age. Our website, products and services are all directed to people who are at least 13 years old or older.</p>\r\n<h3>11. How does our site handle Do Not Track Signals?</h3>\r\n<p>We honor Do Not Track signals and Do Not Track, plant cookies, or use advertising when a Do Not Track (DNT) browser mechanism is in place.</p>\r\n<h3>12. Does our site allow third-party behavioral tracking?</h3>\r\n<p>We do not allow third-party behavioral tracking.</p>\r\n<h3>13. Fair Information Practices</h3>\r\n<p>The Fair Information Practices Principles form the backbone of privacy law in the United States and the concepts they include have played a significant role in the development of data protection laws around the globe. Understanding the Fair Information Practice Principles and how they should be implemented is critical to comply with the various privacy laws that protect personal information.In order to be in line with Fair Information Practices we will take the following responsive action, should a data breach occur:</p>\r\n<p class=\"rb-indent\">a. We will notify you via email, within 14 business days</p>\r\n<h3>14. CAN SPAM Act</h3>\r\n<p>The CAN-SPAM Act is a law that sets the rules for commercial email, establishes requirements for commercial messages, gives recipients the right to have emails stopped from being sent to them, and spells out tough penalties for violations. We collect your email address in order to:</p>\r\n<p class=\"rb-indent\">a. Send information, respond to inquiries, and/or other requests/questions.</p>\r\n<p class=\"rb-indent\">b. Market to our mailing list or continue to send emails to our clients after the original transaction has occurred.</p>\r\n<p>To be in accordance with CANSPAM, we agree to the following:</p>\r\n<p class=\"rb-indent\">a. Not use false or misleading subjects or email addresses.</p>\r\n<p class=\"rb-indent\">b. Identify the message as an advertisement in some reasonable way.</p>\r\n<p class=\"rb-indent\">c. Monitor third-party email marketing services for compliance, if one is used.</p>\r\n<p class=\"rb-indent\">e. Honor opt-out/unsubscribe requests quickly.</p>\r\n<p class=\"rb-indent\">f. Allow users to unsubscribe by using the link at the bottom of each email.</p>\r\n<p>If at any time you would like to unsubscribe from receiving future emails, you can unsubscribe at the bottom of each email and we will promptly remove you from ALL correspondence.</p>\r\n<h3>15. Online Privacy Policy Only</h3>\r\n<p>This Privacy Policy only applies to information collected on this online website. It does not apply to any offline data that might be retrieved by any downloadable software.</p>\r\n<h3>16. Consent</h3>\r\n<p>By using our site, you consent to this website\'s Privacy Policy.</p>\r\n<h3>17. Terms and Conditions</h3>\r\n<p>This website is subject to the Terms and Conditions linked below:<br /><a class=\"rb-button rb-button-border rb-padding-1rem-2rem rb-no-margin-left\" href=\"../info/terms-and-conditions\">Terms and Conditions</a></p>\r\n<h3>18. Software EULA</h3>\r\n<p>Any Software found on our site is subject to our Software EULA. By using our site, you consent to the Sofware EULA linked below:<br /><a class=\"rb-button rb-button-border rb-padding-1rem-2rem rb-no-margin-left\" href=\"../info/software-eula\">Software EULA</a></p>\r\n<h3>19. Changes To Our Privacy Policy</h3>\r\n<p>If this Company decides to change this Website\'s, we will post those changes on this page, send an email notifying you of any changes, and/or update the this Policy\'s Modification Date below.</p>\r\n<h3>20. Contacting Us</h3>\r\n<p>If there are any questions regarding these Website Privacy Policies, you may contact us using the link below:<br /><a class=\"rb-button rb-button-border rb-padding-1rem-2rem rb-no-margin-left\" href=\"../action/contact\">Contact Us</a></p>\r\n<p>Rian-Pascal Bergen (TM)(C)(All Rights Reserved)<br />https://www.rianbergen.com/</p>\r\n<p>Modification Date: January 01, 2019</p>', 'privacy-policy'),
(7, 'Help', '<h2>Help Page</h2>\r\n<h3>What is this Website about?</h3>\r\n<p>This site was created solely for experimentation with the following languages: HTML, CSS, Javascript, PHP, as well as SQL Querries. You can find out more about what the site does in the About Page:<br /><a class=\"rb-button rb-button-border rb-padding-1rem-2rem rb-no-margin-left\" href=\"../action/about\">About Us</a></p>\r\n<h3>How can I get in contact?</h3>\r\n<p>You may contact us through the Contact Page below:<br /><a class=\"rb-button rb-button-border rb-padding-1rem-2rem rb-no-margin-left\" href=\"../action/contact\">Contact Us</a></p>\r\n<h3>Where can I find the Terms and Conditions?</h3>\r\n<p>You may find our Terms and Conditions here:<br /><a class=\"rb-button rb-button-border rb-padding-1rem-2rem rb-no-margin-left\" href=\"../info/terms-and-conditions\">Terms and Conditions</a></p>\r\n<h3>Where can I fing the Software EULA?</h3>\r\n<p>You may find our Software EULA here:<br /><a class=\"rb-button rb-button-border rb-padding-1rem-2rem rb-no-margin-left\" href=\"../info/software-eula\">Software EULA</a></p>\r\n<h3>Where can I find the Privacy Policy?</h3>\r\n<p>You may find our Privacy Policy here:<br /><a class=\"rb-button rb-button-border rb-padding-1rem-2rem rb-no-margin-left\" href=\"../info/privacy-policy\">Privacy Policy</a></p>', 'help');

-- --------------------------------------------------------

--
-- Table structure for table `blog_posts`
--

CREATE TABLE `blog_posts` (
  `postID` int(11) UNSIGNED NOT NULL,
  `postTitle` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `postDescription` text COLLATE latin1_general_ci,
  `postContent` text COLLATE latin1_general_ci,
  `postTags` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `postDate` datetime DEFAULT NULL,
  `postSlug` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `postImage` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `postViewCount` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `blog_posts`
--

INSERT INTO `blog_posts` (`postID`, `postTitle`, `postDescription`, `postContent`, `postTags`, `postDate`, `postSlug`, `postImage`, `postViewCount`) VALUES
(1, 'Under Maintenance', '<p>We\'ve got something special in store for you!</p>', '<p>We\'ve got something special in store for you! And we can\'t wait for you to see it. Please check back soon.</p>\r\n<p>What to Expect:</p>\r\n<ul>\r\n<li>Brand New Website Design</li>\r\n<li>That Is Finally Fully Functioning</li>\r\n<li>Help and Website Specific Pages</li>\r\n<li>Much, Much More</li>\r\n</ul>\r\n<p>&nbsp;</p>\r\n<p>Stay Tunned!!!</p>', '', '2019-05-06 14:07:33', '2019-05-06-under-maintenance', NULL, 25);

-- --------------------------------------------------------

--
-- Table structure for table `blog_post_categories`
--

CREATE TABLE `blog_post_categories` (
  `pcID` int(11) NOT NULL,
  `pcPostID` int(11) DEFAULT NULL,
  `pcCategoryID` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `blog_post_categories`
--

INSERT INTO `blog_post_categories` (`pcID`, `pcPostID`, `pcCategoryID`) VALUES
(1, 1, 1),
(2, 1, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blog_categories`
--
ALTER TABLE `blog_categories`
  ADD PRIMARY KEY (`categoryID`);

--
-- Indexes for table `blog_members`
--
ALTER TABLE `blog_members`
  ADD PRIMARY KEY (`memberID`);

--
-- Indexes for table `blog_pages`
--
ALTER TABLE `blog_pages`
  ADD PRIMARY KEY (`pageID`);

--
-- Indexes for table `blog_posts`
--
ALTER TABLE `blog_posts`
  ADD PRIMARY KEY (`postID`);

--
-- Indexes for table `blog_post_categories`
--
ALTER TABLE `blog_post_categories`
  ADD PRIMARY KEY (`pcID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blog_categories`
--
ALTER TABLE `blog_categories`
  MODIFY `categoryID` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `blog_members`
--
ALTER TABLE `blog_members`
  MODIFY `memberID` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `blog_pages`
--
ALTER TABLE `blog_pages`
  MODIFY `pageID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `blog_posts`
--
ALTER TABLE `blog_posts`
  MODIFY `postID` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `blog_post_categories`
--
ALTER TABLE `blog_post_categories`
  MODIFY `pcID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
