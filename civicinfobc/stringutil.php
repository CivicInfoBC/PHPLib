<?php


	namespace CivicInfoBC;
	
	
	/**
	 *	Contains utilities for working with strings in
	 *	a Unicode-aware manner.
	 */
	class StringUtil {
		
		
		private static $cfd=array(array('code_point' => 65,'type' => 1,'replacement' => array(97)),array('code_point' => 66,'type' => 1,'replacement' => array(98)),array('code_point' => 67,'type' => 1,'replacement' => array(99)),array('code_point' => 68,'type' => 1,'replacement' => array(100)),array('code_point' => 69,'type' => 1,'replacement' => array(101)),array('code_point' => 70,'type' => 1,'replacement' => array(102)),array('code_point' => 71,'type' => 1,'replacement' => array(103)),array('code_point' => 72,'type' => 1,'replacement' => array(104)),array('code_point' => 73,'type' => 1,'replacement' => array(105)),array('code_point' => 73,'type' => 8,'replacement' => array(305)),array('code_point' => 74,'type' => 1,'replacement' => array(106)),array('code_point' => 75,'type' => 1,'replacement' => array(107)),array('code_point' => 76,'type' => 1,'replacement' => array(108)),array('code_point' => 77,'type' => 1,'replacement' => array(109)),array('code_point' => 78,'type' => 1,'replacement' => array(110)),array('code_point' => 79,'type' => 1,'replacement' => array(111)),array('code_point' => 80,'type' => 1,'replacement' => array(112)),array('code_point' => 81,'type' => 1,'replacement' => array(113)),array('code_point' => 82,'type' => 1,'replacement' => array(114)),array('code_point' => 83,'type' => 1,'replacement' => array(115)),array('code_point' => 84,'type' => 1,'replacement' => array(116)),array('code_point' => 85,'type' => 1,'replacement' => array(117)),array('code_point' => 86,'type' => 1,'replacement' => array(118)),array('code_point' => 87,'type' => 1,'replacement' => array(119)),array('code_point' => 88,'type' => 1,'replacement' => array(120)),array('code_point' => 89,'type' => 1,'replacement' => array(121)),array('code_point' => 90,'type' => 1,'replacement' => array(122)),array('code_point' => 181,'type' => 1,'replacement' => array(956)),array('code_point' => 192,'type' => 1,'replacement' => array(224)),array('code_point' => 193,'type' => 1,'replacement' => array(225)),array('code_point' => 194,'type' => 1,'replacement' => array(226)),array('code_point' => 195,'type' => 1,'replacement' => array(227)),array('code_point' => 196,'type' => 1,'replacement' => array(228)),array('code_point' => 197,'type' => 1,'replacement' => array(229)),array('code_point' => 198,'type' => 1,'replacement' => array(230)),array('code_point' => 199,'type' => 1,'replacement' => array(231)),array('code_point' => 200,'type' => 1,'replacement' => array(232)),array('code_point' => 201,'type' => 1,'replacement' => array(233)),array('code_point' => 202,'type' => 1,'replacement' => array(234)),array('code_point' => 203,'type' => 1,'replacement' => array(235)),array('code_point' => 204,'type' => 1,'replacement' => array(236)),array('code_point' => 205,'type' => 1,'replacement' => array(237)),array('code_point' => 206,'type' => 1,'replacement' => array(238)),array('code_point' => 207,'type' => 1,'replacement' => array(239)),array('code_point' => 208,'type' => 1,'replacement' => array(240)),array('code_point' => 209,'type' => 1,'replacement' => array(241)),array('code_point' => 210,'type' => 1,'replacement' => array(242)),array('code_point' => 211,'type' => 1,'replacement' => array(243)),array('code_point' => 212,'type' => 1,'replacement' => array(244)),array('code_point' => 213,'type' => 1,'replacement' => array(245)),array('code_point' => 214,'type' => 1,'replacement' => array(246)),array('code_point' => 216,'type' => 1,'replacement' => array(248)),array('code_point' => 217,'type' => 1,'replacement' => array(249)),array('code_point' => 218,'type' => 1,'replacement' => array(250)),array('code_point' => 219,'type' => 1,'replacement' => array(251)),array('code_point' => 220,'type' => 1,'replacement' => array(252)),array('code_point' => 221,'type' => 1,'replacement' => array(253)),array('code_point' => 222,'type' => 1,'replacement' => array(254)),array('code_point' => 223,'type' => 4,'replacement' => array(115,115)),array('code_point' => 256,'type' => 1,'replacement' => array(257)),array('code_point' => 258,'type' => 1,'replacement' => array(259)),array('code_point' => 260,'type' => 1,'replacement' => array(261)),array('code_point' => 262,'type' => 1,'replacement' => array(263)),array('code_point' => 264,'type' => 1,'replacement' => array(265)),array('code_point' => 266,'type' => 1,'replacement' => array(267)),array('code_point' => 268,'type' => 1,'replacement' => array(269)),array('code_point' => 270,'type' => 1,'replacement' => array(271)),array('code_point' => 272,'type' => 1,'replacement' => array(273)),array('code_point' => 274,'type' => 1,'replacement' => array(275)),array('code_point' => 276,'type' => 1,'replacement' => array(277)),array('code_point' => 278,'type' => 1,'replacement' => array(279)),array('code_point' => 280,'type' => 1,'replacement' => array(281)),array('code_point' => 282,'type' => 1,'replacement' => array(283)),array('code_point' => 284,'type' => 1,'replacement' => array(285)),array('code_point' => 286,'type' => 1,'replacement' => array(287)),array('code_point' => 288,'type' => 1,'replacement' => array(289)),array('code_point' => 290,'type' => 1,'replacement' => array(291)),array('code_point' => 292,'type' => 1,'replacement' => array(293)),array('code_point' => 294,'type' => 1,'replacement' => array(295)),array('code_point' => 296,'type' => 1,'replacement' => array(297)),array('code_point' => 298,'type' => 1,'replacement' => array(299)),array('code_point' => 300,'type' => 1,'replacement' => array(301)),array('code_point' => 302,'type' => 1,'replacement' => array(303)),array('code_point' => 304,'type' => 8,'replacement' => array(105)),array('code_point' => 304,'type' => 4,'replacement' => array(105,775)),array('code_point' => 306,'type' => 1,'replacement' => array(307)),array('code_point' => 308,'type' => 1,'replacement' => array(309)),array('code_point' => 310,'type' => 1,'replacement' => array(311)),array('code_point' => 313,'type' => 1,'replacement' => array(314)),array('code_point' => 315,'type' => 1,'replacement' => array(316)),array('code_point' => 317,'type' => 1,'replacement' => array(318)),array('code_point' => 319,'type' => 1,'replacement' => array(320)),array('code_point' => 321,'type' => 1,'replacement' => array(322)),array('code_point' => 323,'type' => 1,'replacement' => array(324)),array('code_point' => 325,'type' => 1,'replacement' => array(326)),array('code_point' => 327,'type' => 1,'replacement' => array(328)),array('code_point' => 329,'type' => 4,'replacement' => array(700,110)),array('code_point' => 330,'type' => 1,'replacement' => array(331)),array('code_point' => 332,'type' => 1,'replacement' => array(333)),array('code_point' => 334,'type' => 1,'replacement' => array(335)),array('code_point' => 336,'type' => 1,'replacement' => array(337)),array('code_point' => 338,'type' => 1,'replacement' => array(339)),array('code_point' => 340,'type' => 1,'replacement' => array(341)),array('code_point' => 342,'type' => 1,'replacement' => array(343)),array('code_point' => 344,'type' => 1,'replacement' => array(345)),array('code_point' => 346,'type' => 1,'replacement' => array(347)),array('code_point' => 348,'type' => 1,'replacement' => array(349)),array('code_point' => 350,'type' => 1,'replacement' => array(351)),array('code_point' => 352,'type' => 1,'replacement' => array(353)),array('code_point' => 354,'type' => 1,'replacement' => array(355)),array('code_point' => 356,'type' => 1,'replacement' => array(357)),array('code_point' => 358,'type' => 1,'replacement' => array(359)),array('code_point' => 360,'type' => 1,'replacement' => array(361)),array('code_point' => 362,'type' => 1,'replacement' => array(363)),array('code_point' => 364,'type' => 1,'replacement' => array(365)),array('code_point' => 366,'type' => 1,'replacement' => array(367)),array('code_point' => 368,'type' => 1,'replacement' => array(369)),array('code_point' => 370,'type' => 1,'replacement' => array(371)),array('code_point' => 372,'type' => 1,'replacement' => array(373)),array('code_point' => 374,'type' => 1,'replacement' => array(375)),array('code_point' => 376,'type' => 1,'replacement' => array(255)),array('code_point' => 377,'type' => 1,'replacement' => array(378)),array('code_point' => 379,'type' => 1,'replacement' => array(380)),array('code_point' => 381,'type' => 1,'replacement' => array(382)),array('code_point' => 383,'type' => 1,'replacement' => array(115)),array('code_point' => 385,'type' => 1,'replacement' => array(595)),array('code_point' => 386,'type' => 1,'replacement' => array(387)),array('code_point' => 388,'type' => 1,'replacement' => array(389)),array('code_point' => 390,'type' => 1,'replacement' => array(596)),array('code_point' => 391,'type' => 1,'replacement' => array(392)),array('code_point' => 393,'type' => 1,'replacement' => array(598)),array('code_point' => 394,'type' => 1,'replacement' => array(599)),array('code_point' => 395,'type' => 1,'replacement' => array(396)),array('code_point' => 398,'type' => 1,'replacement' => array(477)),array('code_point' => 399,'type' => 1,'replacement' => array(601)),array('code_point' => 400,'type' => 1,'replacement' => array(603)),array('code_point' => 401,'type' => 1,'replacement' => array(402)),array('code_point' => 403,'type' => 1,'replacement' => array(608)),array('code_point' => 404,'type' => 1,'replacement' => array(611)),array('code_point' => 406,'type' => 1,'replacement' => array(617)),array('code_point' => 407,'type' => 1,'replacement' => array(616)),array('code_point' => 408,'type' => 1,'replacement' => array(409)),array('code_point' => 412,'type' => 1,'replacement' => array(623)),array('code_point' => 413,'type' => 1,'replacement' => array(626)),array('code_point' => 415,'type' => 1,'replacement' => array(629)),array('code_point' => 416,'type' => 1,'replacement' => array(417)),array('code_point' => 418,'type' => 1,'replacement' => array(419)),array('code_point' => 420,'type' => 1,'replacement' => array(421)),array('code_point' => 422,'type' => 1,'replacement' => array(640)),array('code_point' => 423,'type' => 1,'replacement' => array(424)),array('code_point' => 425,'type' => 1,'replacement' => array(643)),array('code_point' => 428,'type' => 1,'replacement' => array(429)),array('code_point' => 430,'type' => 1,'replacement' => array(648)),array('code_point' => 431,'type' => 1,'replacement' => array(432)),array('code_point' => 433,'type' => 1,'replacement' => array(650)),array('code_point' => 434,'type' => 1,'replacement' => array(651)),array('code_point' => 435,'type' => 1,'replacement' => array(436)),array('code_point' => 437,'type' => 1,'replacement' => array(438)),array('code_point' => 439,'type' => 1,'replacement' => array(658)),array('code_point' => 440,'type' => 1,'replacement' => array(441)),array('code_point' => 444,'type' => 1,'replacement' => array(445)),array('code_point' => 452,'type' => 1,'replacement' => array(454)),array('code_point' => 453,'type' => 1,'replacement' => array(454)),array('code_point' => 455,'type' => 1,'replacement' => array(457)),array('code_point' => 456,'type' => 1,'replacement' => array(457)),array('code_point' => 458,'type' => 1,'replacement' => array(460)),array('code_point' => 459,'type' => 1,'replacement' => array(460)),array('code_point' => 461,'type' => 1,'replacement' => array(462)),array('code_point' => 463,'type' => 1,'replacement' => array(464)),array('code_point' => 465,'type' => 1,'replacement' => array(466)),array('code_point' => 467,'type' => 1,'replacement' => array(468)),array('code_point' => 469,'type' => 1,'replacement' => array(470)),array('code_point' => 471,'type' => 1,'replacement' => array(472)),array('code_point' => 473,'type' => 1,'replacement' => array(474)),array('code_point' => 475,'type' => 1,'replacement' => array(476)),array('code_point' => 478,'type' => 1,'replacement' => array(479)),array('code_point' => 480,'type' => 1,'replacement' => array(481)),array('code_point' => 482,'type' => 1,'replacement' => array(483)),array('code_point' => 484,'type' => 1,'replacement' => array(485)),array('code_point' => 486,'type' => 1,'replacement' => array(487)),array('code_point' => 488,'type' => 1,'replacement' => array(489)),array('code_point' => 490,'type' => 1,'replacement' => array(491)),array('code_point' => 492,'type' => 1,'replacement' => array(493)),array('code_point' => 494,'type' => 1,'replacement' => array(495)),array('code_point' => 496,'type' => 4,'replacement' => array(106,780)),array('code_point' => 497,'type' => 1,'replacement' => array(499)),array('code_point' => 498,'type' => 1,'replacement' => array(499)),array('code_point' => 500,'type' => 1,'replacement' => array(501)),array('code_point' => 502,'type' => 1,'replacement' => array(405)),array('code_point' => 503,'type' => 1,'replacement' => array(447)),array('code_point' => 504,'type' => 1,'replacement' => array(505)),array('code_point' => 506,'type' => 1,'replacement' => array(507)),array('code_point' => 508,'type' => 1,'replacement' => array(509)),array('code_point' => 510,'type' => 1,'replacement' => array(511)),array('code_point' => 512,'type' => 1,'replacement' => array(513)),array('code_point' => 514,'type' => 1,'replacement' => array(515)),array('code_point' => 516,'type' => 1,'replacement' => array(517)),array('code_point' => 518,'type' => 1,'replacement' => array(519)),array('code_point' => 520,'type' => 1,'replacement' => array(521)),array('code_point' => 522,'type' => 1,'replacement' => array(523)),array('code_point' => 524,'type' => 1,'replacement' => array(525)),array('code_point' => 526,'type' => 1,'replacement' => array(527)),array('code_point' => 528,'type' => 1,'replacement' => array(529)),array('code_point' => 530,'type' => 1,'replacement' => array(531)),array('code_point' => 532,'type' => 1,'replacement' => array(533)),array('code_point' => 534,'type' => 1,'replacement' => array(535)),array('code_point' => 536,'type' => 1,'replacement' => array(537)),array('code_point' => 538,'type' => 1,'replacement' => array(539)),array('code_point' => 540,'type' => 1,'replacement' => array(541)),array('code_point' => 542,'type' => 1,'replacement' => array(543)),array('code_point' => 544,'type' => 1,'replacement' => array(414)),array('code_point' => 546,'type' => 1,'replacement' => array(547)),array('code_point' => 548,'type' => 1,'replacement' => array(549)),array('code_point' => 550,'type' => 1,'replacement' => array(551)),array('code_point' => 552,'type' => 1,'replacement' => array(553)),array('code_point' => 554,'type' => 1,'replacement' => array(555)),array('code_point' => 556,'type' => 1,'replacement' => array(557)),array('code_point' => 558,'type' => 1,'replacement' => array(559)),array('code_point' => 560,'type' => 1,'replacement' => array(561)),array('code_point' => 562,'type' => 1,'replacement' => array(563)),array('code_point' => 570,'type' => 1,'replacement' => array(11365)),array('code_point' => 571,'type' => 1,'replacement' => array(572)),array('code_point' => 573,'type' => 1,'replacement' => array(410)),array('code_point' => 574,'type' => 1,'replacement' => array(11366)),array('code_point' => 577,'type' => 1,'replacement' => array(578)),array('code_point' => 579,'type' => 1,'replacement' => array(384)),array('code_point' => 580,'type' => 1,'replacement' => array(649)),array('code_point' => 581,'type' => 1,'replacement' => array(652)),array('code_point' => 582,'type' => 1,'replacement' => array(583)),array('code_point' => 584,'type' => 1,'replacement' => array(585)),array('code_point' => 586,'type' => 1,'replacement' => array(587)),array('code_point' => 588,'type' => 1,'replacement' => array(589)),array('code_point' => 590,'type' => 1,'replacement' => array(591)),array('code_point' => 837,'type' => 1,'replacement' => array(953)),array('code_point' => 880,'type' => 1,'replacement' => array(881)),array('code_point' => 882,'type' => 1,'replacement' => array(883)),array('code_point' => 886,'type' => 1,'replacement' => array(887)),array('code_point' => 895,'type' => 1,'replacement' => array(1011)),array('code_point' => 902,'type' => 1,'replacement' => array(940)),array('code_point' => 904,'type' => 1,'replacement' => array(941)),array('code_point' => 905,'type' => 1,'replacement' => array(942)),array('code_point' => 906,'type' => 1,'replacement' => array(943)),array('code_point' => 908,'type' => 1,'replacement' => array(972)),array('code_point' => 910,'type' => 1,'replacement' => array(973)),array('code_point' => 911,'type' => 1,'replacement' => array(974)),array('code_point' => 912,'type' => 4,'replacement' => array(953,776,769)),array('code_point' => 913,'type' => 1,'replacement' => array(945)),array('code_point' => 914,'type' => 1,'replacement' => array(946)),array('code_point' => 915,'type' => 1,'replacement' => array(947)),array('code_point' => 916,'type' => 1,'replacement' => array(948)),array('code_point' => 917,'type' => 1,'replacement' => array(949)),array('code_point' => 918,'type' => 1,'replacement' => array(950)),array('code_point' => 919,'type' => 1,'replacement' => array(951)),array('code_point' => 920,'type' => 1,'replacement' => array(952)),array('code_point' => 921,'type' => 1,'replacement' => array(953)),array('code_point' => 922,'type' => 1,'replacement' => array(954)),array('code_point' => 923,'type' => 1,'replacement' => array(955)),array('code_point' => 924,'type' => 1,'replacement' => array(956)),array('code_point' => 925,'type' => 1,'replacement' => array(957)),array('code_point' => 926,'type' => 1,'replacement' => array(958)),array('code_point' => 927,'type' => 1,'replacement' => array(959)),array('code_point' => 928,'type' => 1,'replacement' => array(960)),array('code_point' => 929,'type' => 1,'replacement' => array(961)),array('code_point' => 931,'type' => 1,'replacement' => array(963)),array('code_point' => 932,'type' => 1,'replacement' => array(964)),array('code_point' => 933,'type' => 1,'replacement' => array(965)),array('code_point' => 934,'type' => 1,'replacement' => array(966)),array('code_point' => 935,'type' => 1,'replacement' => array(967)),array('code_point' => 936,'type' => 1,'replacement' => array(968)),array('code_point' => 937,'type' => 1,'replacement' => array(969)),array('code_point' => 938,'type' => 1,'replacement' => array(970)),array('code_point' => 939,'type' => 1,'replacement' => array(971)),array('code_point' => 944,'type' => 4,'replacement' => array(965,776,769)),array('code_point' => 962,'type' => 1,'replacement' => array(963)),array('code_point' => 975,'type' => 1,'replacement' => array(983)),array('code_point' => 976,'type' => 1,'replacement' => array(946)),array('code_point' => 977,'type' => 1,'replacement' => array(952)),array('code_point' => 981,'type' => 1,'replacement' => array(966)),array('code_point' => 982,'type' => 1,'replacement' => array(960)),array('code_point' => 984,'type' => 1,'replacement' => array(985)),array('code_point' => 986,'type' => 1,'replacement' => array(987)),array('code_point' => 988,'type' => 1,'replacement' => array(989)),array('code_point' => 990,'type' => 1,'replacement' => array(991)),array('code_point' => 992,'type' => 1,'replacement' => array(993)),array('code_point' => 994,'type' => 1,'replacement' => array(995)),array('code_point' => 996,'type' => 1,'replacement' => array(997)),array('code_point' => 998,'type' => 1,'replacement' => array(999)),array('code_point' => 1000,'type' => 1,'replacement' => array(1001)),array('code_point' => 1002,'type' => 1,'replacement' => array(1003)),array('code_point' => 1004,'type' => 1,'replacement' => array(1005)),array('code_point' => 1006,'type' => 1,'replacement' => array(1007)),array('code_point' => 1008,'type' => 1,'replacement' => array(954)),array('code_point' => 1009,'type' => 1,'replacement' => array(961)),array('code_point' => 1012,'type' => 1,'replacement' => array(952)),array('code_point' => 1013,'type' => 1,'replacement' => array(949)),array('code_point' => 1015,'type' => 1,'replacement' => array(1016)),array('code_point' => 1017,'type' => 1,'replacement' => array(1010)),array('code_point' => 1018,'type' => 1,'replacement' => array(1019)),array('code_point' => 1021,'type' => 1,'replacement' => array(891)),array('code_point' => 1022,'type' => 1,'replacement' => array(892)),array('code_point' => 1023,'type' => 1,'replacement' => array(893)),array('code_point' => 1024,'type' => 1,'replacement' => array(1104)),array('code_point' => 1025,'type' => 1,'replacement' => array(1105)),array('code_point' => 1026,'type' => 1,'replacement' => array(1106)),array('code_point' => 1027,'type' => 1,'replacement' => array(1107)),array('code_point' => 1028,'type' => 1,'replacement' => array(1108)),array('code_point' => 1029,'type' => 1,'replacement' => array(1109)),array('code_point' => 1030,'type' => 1,'replacement' => array(1110)),array('code_point' => 1031,'type' => 1,'replacement' => array(1111)),array('code_point' => 1032,'type' => 1,'replacement' => array(1112)),array('code_point' => 1033,'type' => 1,'replacement' => array(1113)),array('code_point' => 1034,'type' => 1,'replacement' => array(1114)),array('code_point' => 1035,'type' => 1,'replacement' => array(1115)),array('code_point' => 1036,'type' => 1,'replacement' => array(1116)),array('code_point' => 1037,'type' => 1,'replacement' => array(1117)),array('code_point' => 1038,'type' => 1,'replacement' => array(1118)),array('code_point' => 1039,'type' => 1,'replacement' => array(1119)),array('code_point' => 1040,'type' => 1,'replacement' => array(1072)),array('code_point' => 1041,'type' => 1,'replacement' => array(1073)),array('code_point' => 1042,'type' => 1,'replacement' => array(1074)),array('code_point' => 1043,'type' => 1,'replacement' => array(1075)),array('code_point' => 1044,'type' => 1,'replacement' => array(1076)),array('code_point' => 1045,'type' => 1,'replacement' => array(1077)),array('code_point' => 1046,'type' => 1,'replacement' => array(1078)),array('code_point' => 1047,'type' => 1,'replacement' => array(1079)),array('code_point' => 1048,'type' => 1,'replacement' => array(1080)),array('code_point' => 1049,'type' => 1,'replacement' => array(1081)),array('code_point' => 1050,'type' => 1,'replacement' => array(1082)),array('code_point' => 1051,'type' => 1,'replacement' => array(1083)),array('code_point' => 1052,'type' => 1,'replacement' => array(1084)),array('code_point' => 1053,'type' => 1,'replacement' => array(1085)),array('code_point' => 1054,'type' => 1,'replacement' => array(1086)),array('code_point' => 1055,'type' => 1,'replacement' => array(1087)),array('code_point' => 1056,'type' => 1,'replacement' => array(1088)),array('code_point' => 1057,'type' => 1,'replacement' => array(1089)),array('code_point' => 1058,'type' => 1,'replacement' => array(1090)),array('code_point' => 1059,'type' => 1,'replacement' => array(1091)),array('code_point' => 1060,'type' => 1,'replacement' => array(1092)),array('code_point' => 1061,'type' => 1,'replacement' => array(1093)),array('code_point' => 1062,'type' => 1,'replacement' => array(1094)),array('code_point' => 1063,'type' => 1,'replacement' => array(1095)),array('code_point' => 1064,'type' => 1,'replacement' => array(1096)),array('code_point' => 1065,'type' => 1,'replacement' => array(1097)),array('code_point' => 1066,'type' => 1,'replacement' => array(1098)),array('code_point' => 1067,'type' => 1,'replacement' => array(1099)),array('code_point' => 1068,'type' => 1,'replacement' => array(1100)),array('code_point' => 1069,'type' => 1,'replacement' => array(1101)),array('code_point' => 1070,'type' => 1,'replacement' => array(1102)),array('code_point' => 1071,'type' => 1,'replacement' => array(1103)),array('code_point' => 1120,'type' => 1,'replacement' => array(1121)),array('code_point' => 1122,'type' => 1,'replacement' => array(1123)),array('code_point' => 1124,'type' => 1,'replacement' => array(1125)),array('code_point' => 1126,'type' => 1,'replacement' => array(1127)),array('code_point' => 1128,'type' => 1,'replacement' => array(1129)),array('code_point' => 1130,'type' => 1,'replacement' => array(1131)),array('code_point' => 1132,'type' => 1,'replacement' => array(1133)),array('code_point' => 1134,'type' => 1,'replacement' => array(1135)),array('code_point' => 1136,'type' => 1,'replacement' => array(1137)),array('code_point' => 1138,'type' => 1,'replacement' => array(1139)),array('code_point' => 1140,'type' => 1,'replacement' => array(1141)),array('code_point' => 1142,'type' => 1,'replacement' => array(1143)),array('code_point' => 1144,'type' => 1,'replacement' => array(1145)),array('code_point' => 1146,'type' => 1,'replacement' => array(1147)),array('code_point' => 1148,'type' => 1,'replacement' => array(1149)),array('code_point' => 1150,'type' => 1,'replacement' => array(1151)),array('code_point' => 1152,'type' => 1,'replacement' => array(1153)),array('code_point' => 1162,'type' => 1,'replacement' => array(1163)),array('code_point' => 1164,'type' => 1,'replacement' => array(1165)),array('code_point' => 1166,'type' => 1,'replacement' => array(1167)),array('code_point' => 1168,'type' => 1,'replacement' => array(1169)),array('code_point' => 1170,'type' => 1,'replacement' => array(1171)),array('code_point' => 1172,'type' => 1,'replacement' => array(1173)),array('code_point' => 1174,'type' => 1,'replacement' => array(1175)),array('code_point' => 1176,'type' => 1,'replacement' => array(1177)),array('code_point' => 1178,'type' => 1,'replacement' => array(1179)),array('code_point' => 1180,'type' => 1,'replacement' => array(1181)),array('code_point' => 1182,'type' => 1,'replacement' => array(1183)),array('code_point' => 1184,'type' => 1,'replacement' => array(1185)),array('code_point' => 1186,'type' => 1,'replacement' => array(1187)),array('code_point' => 1188,'type' => 1,'replacement' => array(1189)),array('code_point' => 1190,'type' => 1,'replacement' => array(1191)),array('code_point' => 1192,'type' => 1,'replacement' => array(1193)),array('code_point' => 1194,'type' => 1,'replacement' => array(1195)),array('code_point' => 1196,'type' => 1,'replacement' => array(1197)),array('code_point' => 1198,'type' => 1,'replacement' => array(1199)),array('code_point' => 1200,'type' => 1,'replacement' => array(1201)),array('code_point' => 1202,'type' => 1,'replacement' => array(1203)),array('code_point' => 1204,'type' => 1,'replacement' => array(1205)),array('code_point' => 1206,'type' => 1,'replacement' => array(1207)),array('code_point' => 1208,'type' => 1,'replacement' => array(1209)),array('code_point' => 1210,'type' => 1,'replacement' => array(1211)),array('code_point' => 1212,'type' => 1,'replacement' => array(1213)),array('code_point' => 1214,'type' => 1,'replacement' => array(1215)),array('code_point' => 1216,'type' => 1,'replacement' => array(1231)),array('code_point' => 1217,'type' => 1,'replacement' => array(1218)),array('code_point' => 1219,'type' => 1,'replacement' => array(1220)),array('code_point' => 1221,'type' => 1,'replacement' => array(1222)),array('code_point' => 1223,'type' => 1,'replacement' => array(1224)),array('code_point' => 1225,'type' => 1,'replacement' => array(1226)),array('code_point' => 1227,'type' => 1,'replacement' => array(1228)),array('code_point' => 1229,'type' => 1,'replacement' => array(1230)),array('code_point' => 1232,'type' => 1,'replacement' => array(1233)),array('code_point' => 1234,'type' => 1,'replacement' => array(1235)),array('code_point' => 1236,'type' => 1,'replacement' => array(1237)),array('code_point' => 1238,'type' => 1,'replacement' => array(1239)),array('code_point' => 1240,'type' => 1,'replacement' => array(1241)),array('code_point' => 1242,'type' => 1,'replacement' => array(1243)),array('code_point' => 1244,'type' => 1,'replacement' => array(1245)),array('code_point' => 1246,'type' => 1,'replacement' => array(1247)),array('code_point' => 1248,'type' => 1,'replacement' => array(1249)),array('code_point' => 1250,'type' => 1,'replacement' => array(1251)),array('code_point' => 1252,'type' => 1,'replacement' => array(1253)),array('code_point' => 1254,'type' => 1,'replacement' => array(1255)),array('code_point' => 1256,'type' => 1,'replacement' => array(1257)),array('code_point' => 1258,'type' => 1,'replacement' => array(1259)),array('code_point' => 1260,'type' => 1,'replacement' => array(1261)),array('code_point' => 1262,'type' => 1,'replacement' => array(1263)),array('code_point' => 1264,'type' => 1,'replacement' => array(1265)),array('code_point' => 1266,'type' => 1,'replacement' => array(1267)),array('code_point' => 1268,'type' => 1,'replacement' => array(1269)),array('code_point' => 1270,'type' => 1,'replacement' => array(1271)),array('code_point' => 1272,'type' => 1,'replacement' => array(1273)),array('code_point' => 1274,'type' => 1,'replacement' => array(1275)),array('code_point' => 1276,'type' => 1,'replacement' => array(1277)),array('code_point' => 1278,'type' => 1,'replacement' => array(1279)),array('code_point' => 1280,'type' => 1,'replacement' => array(1281)),array('code_point' => 1282,'type' => 1,'replacement' => array(1283)),array('code_point' => 1284,'type' => 1,'replacement' => array(1285)),array('code_point' => 1286,'type' => 1,'replacement' => array(1287)),array('code_point' => 1288,'type' => 1,'replacement' => array(1289)),array('code_point' => 1290,'type' => 1,'replacement' => array(1291)),array('code_point' => 1292,'type' => 1,'replacement' => array(1293)),array('code_point' => 1294,'type' => 1,'replacement' => array(1295)),array('code_point' => 1296,'type' => 1,'replacement' => array(1297)),array('code_point' => 1298,'type' => 1,'replacement' => array(1299)),array('code_point' => 1300,'type' => 1,'replacement' => array(1301)),array('code_point' => 1302,'type' => 1,'replacement' => array(1303)),array('code_point' => 1304,'type' => 1,'replacement' => array(1305)),array('code_point' => 1306,'type' => 1,'replacement' => array(1307)),array('code_point' => 1308,'type' => 1,'replacement' => array(1309)),array('code_point' => 1310,'type' => 1,'replacement' => array(1311)),array('code_point' => 1312,'type' => 1,'replacement' => array(1313)),array('code_point' => 1314,'type' => 1,'replacement' => array(1315)),array('code_point' => 1316,'type' => 1,'replacement' => array(1317)),array('code_point' => 1318,'type' => 1,'replacement' => array(1319)),array('code_point' => 1320,'type' => 1,'replacement' => array(1321)),array('code_point' => 1322,'type' => 1,'replacement' => array(1323)),array('code_point' => 1324,'type' => 1,'replacement' => array(1325)),array('code_point' => 1326,'type' => 1,'replacement' => array(1327)),array('code_point' => 1329,'type' => 1,'replacement' => array(1377)),array('code_point' => 1330,'type' => 1,'replacement' => array(1378)),array('code_point' => 1331,'type' => 1,'replacement' => array(1379)),array('code_point' => 1332,'type' => 1,'replacement' => array(1380)),array('code_point' => 1333,'type' => 1,'replacement' => array(1381)),array('code_point' => 1334,'type' => 1,'replacement' => array(1382)),array('code_point' => 1335,'type' => 1,'replacement' => array(1383)),array('code_point' => 1336,'type' => 1,'replacement' => array(1384)),array('code_point' => 1337,'type' => 1,'replacement' => array(1385)),array('code_point' => 1338,'type' => 1,'replacement' => array(1386)),array('code_point' => 1339,'type' => 1,'replacement' => array(1387)),array('code_point' => 1340,'type' => 1,'replacement' => array(1388)),array('code_point' => 1341,'type' => 1,'replacement' => array(1389)),array('code_point' => 1342,'type' => 1,'replacement' => array(1390)),array('code_point' => 1343,'type' => 1,'replacement' => array(1391)),array('code_point' => 1344,'type' => 1,'replacement' => array(1392)),array('code_point' => 1345,'type' => 1,'replacement' => array(1393)),array('code_point' => 1346,'type' => 1,'replacement' => array(1394)),array('code_point' => 1347,'type' => 1,'replacement' => array(1395)),array('code_point' => 1348,'type' => 1,'replacement' => array(1396)),array('code_point' => 1349,'type' => 1,'replacement' => array(1397)),array('code_point' => 1350,'type' => 1,'replacement' => array(1398)),array('code_point' => 1351,'type' => 1,'replacement' => array(1399)),array('code_point' => 1352,'type' => 1,'replacement' => array(1400)),array('code_point' => 1353,'type' => 1,'replacement' => array(1401)),array('code_point' => 1354,'type' => 1,'replacement' => array(1402)),array('code_point' => 1355,'type' => 1,'replacement' => array(1403)),array('code_point' => 1356,'type' => 1,'replacement' => array(1404)),array('code_point' => 1357,'type' => 1,'replacement' => array(1405)),array('code_point' => 1358,'type' => 1,'replacement' => array(1406)),array('code_point' => 1359,'type' => 1,'replacement' => array(1407)),array('code_point' => 1360,'type' => 1,'replacement' => array(1408)),array('code_point' => 1361,'type' => 1,'replacement' => array(1409)),array('code_point' => 1362,'type' => 1,'replacement' => array(1410)),array('code_point' => 1363,'type' => 1,'replacement' => array(1411)),array('code_point' => 1364,'type' => 1,'replacement' => array(1412)),array('code_point' => 1365,'type' => 1,'replacement' => array(1413)),array('code_point' => 1366,'type' => 1,'replacement' => array(1414)),array('code_point' => 1415,'type' => 4,'replacement' => array(1381,1410)),array('code_point' => 4256,'type' => 1,'replacement' => array(11520)),array('code_point' => 4257,'type' => 1,'replacement' => array(11521)),array('code_point' => 4258,'type' => 1,'replacement' => array(11522)),array('code_point' => 4259,'type' => 1,'replacement' => array(11523)),array('code_point' => 4260,'type' => 1,'replacement' => array(11524)),array('code_point' => 4261,'type' => 1,'replacement' => array(11525)),array('code_point' => 4262,'type' => 1,'replacement' => array(11526)),array('code_point' => 4263,'type' => 1,'replacement' => array(11527)),array('code_point' => 4264,'type' => 1,'replacement' => array(11528)),array('code_point' => 4265,'type' => 1,'replacement' => array(11529)),array('code_point' => 4266,'type' => 1,'replacement' => array(11530)),array('code_point' => 4267,'type' => 1,'replacement' => array(11531)),array('code_point' => 4268,'type' => 1,'replacement' => array(11532)),array('code_point' => 4269,'type' => 1,'replacement' => array(11533)),array('code_point' => 4270,'type' => 1,'replacement' => array(11534)),array('code_point' => 4271,'type' => 1,'replacement' => array(11535)),array('code_point' => 4272,'type' => 1,'replacement' => array(11536)),array('code_point' => 4273,'type' => 1,'replacement' => array(11537)),array('code_point' => 4274,'type' => 1,'replacement' => array(11538)),array('code_point' => 4275,'type' => 1,'replacement' => array(11539)),array('code_point' => 4276,'type' => 1,'replacement' => array(11540)),array('code_point' => 4277,'type' => 1,'replacement' => array(11541)),array('code_point' => 4278,'type' => 1,'replacement' => array(11542)),array('code_point' => 4279,'type' => 1,'replacement' => array(11543)),array('code_point' => 4280,'type' => 1,'replacement' => array(11544)),array('code_point' => 4281,'type' => 1,'replacement' => array(11545)),array('code_point' => 4282,'type' => 1,'replacement' => array(11546)),array('code_point' => 4283,'type' => 1,'replacement' => array(11547)),array('code_point' => 4284,'type' => 1,'replacement' => array(11548)),array('code_point' => 4285,'type' => 1,'replacement' => array(11549)),array('code_point' => 4286,'type' => 1,'replacement' => array(11550)),array('code_point' => 4287,'type' => 1,'replacement' => array(11551)),array('code_point' => 4288,'type' => 1,'replacement' => array(11552)),array('code_point' => 4289,'type' => 1,'replacement' => array(11553)),array('code_point' => 4290,'type' => 1,'replacement' => array(11554)),array('code_point' => 4291,'type' => 1,'replacement' => array(11555)),array('code_point' => 4292,'type' => 1,'replacement' => array(11556)),array('code_point' => 4293,'type' => 1,'replacement' => array(11557)),array('code_point' => 4295,'type' => 1,'replacement' => array(11559)),array('code_point' => 4301,'type' => 1,'replacement' => array(11565)),array('code_point' => 5112,'type' => 1,'replacement' => array(5104)),array('code_point' => 5113,'type' => 1,'replacement' => array(5105)),array('code_point' => 5114,'type' => 1,'replacement' => array(5106)),array('code_point' => 5115,'type' => 1,'replacement' => array(5107)),array('code_point' => 5116,'type' => 1,'replacement' => array(5108)),array('code_point' => 5117,'type' => 1,'replacement' => array(5109)),array('code_point' => 7680,'type' => 1,'replacement' => array(7681)),array('code_point' => 7682,'type' => 1,'replacement' => array(7683)),array('code_point' => 7684,'type' => 1,'replacement' => array(7685)),array('code_point' => 7686,'type' => 1,'replacement' => array(7687)),array('code_point' => 7688,'type' => 1,'replacement' => array(7689)),array('code_point' => 7690,'type' => 1,'replacement' => array(7691)),array('code_point' => 7692,'type' => 1,'replacement' => array(7693)),array('code_point' => 7694,'type' => 1,'replacement' => array(7695)),array('code_point' => 7696,'type' => 1,'replacement' => array(7697)),array('code_point' => 7698,'type' => 1,'replacement' => array(7699)),array('code_point' => 7700,'type' => 1,'replacement' => array(7701)),array('code_point' => 7702,'type' => 1,'replacement' => array(7703)),array('code_point' => 7704,'type' => 1,'replacement' => array(7705)),array('code_point' => 7706,'type' => 1,'replacement' => array(7707)),array('code_point' => 7708,'type' => 1,'replacement' => array(7709)),array('code_point' => 7710,'type' => 1,'replacement' => array(7711)),array('code_point' => 7712,'type' => 1,'replacement' => array(7713)),array('code_point' => 7714,'type' => 1,'replacement' => array(7715)),array('code_point' => 7716,'type' => 1,'replacement' => array(7717)),array('code_point' => 7718,'type' => 1,'replacement' => array(7719)),array('code_point' => 7720,'type' => 1,'replacement' => array(7721)),array('code_point' => 7722,'type' => 1,'replacement' => array(7723)),array('code_point' => 7724,'type' => 1,'replacement' => array(7725)),array('code_point' => 7726,'type' => 1,'replacement' => array(7727)),array('code_point' => 7728,'type' => 1,'replacement' => array(7729)),array('code_point' => 7730,'type' => 1,'replacement' => array(7731)),array('code_point' => 7732,'type' => 1,'replacement' => array(7733)),array('code_point' => 7734,'type' => 1,'replacement' => array(7735)),array('code_point' => 7736,'type' => 1,'replacement' => array(7737)),array('code_point' => 7738,'type' => 1,'replacement' => array(7739)),array('code_point' => 7740,'type' => 1,'replacement' => array(7741)),array('code_point' => 7742,'type' => 1,'replacement' => array(7743)),array('code_point' => 7744,'type' => 1,'replacement' => array(7745)),array('code_point' => 7746,'type' => 1,'replacement' => array(7747)),array('code_point' => 7748,'type' => 1,'replacement' => array(7749)),array('code_point' => 7750,'type' => 1,'replacement' => array(7751)),array('code_point' => 7752,'type' => 1,'replacement' => array(7753)),array('code_point' => 7754,'type' => 1,'replacement' => array(7755)),array('code_point' => 7756,'type' => 1,'replacement' => array(7757)),array('code_point' => 7758,'type' => 1,'replacement' => array(7759)),array('code_point' => 7760,'type' => 1,'replacement' => array(7761)),array('code_point' => 7762,'type' => 1,'replacement' => array(7763)),array('code_point' => 7764,'type' => 1,'replacement' => array(7765)),array('code_point' => 7766,'type' => 1,'replacement' => array(7767)),array('code_point' => 7768,'type' => 1,'replacement' => array(7769)),array('code_point' => 7770,'type' => 1,'replacement' => array(7771)),array('code_point' => 7772,'type' => 1,'replacement' => array(7773)),array('code_point' => 7774,'type' => 1,'replacement' => array(7775)),array('code_point' => 7776,'type' => 1,'replacement' => array(7777)),array('code_point' => 7778,'type' => 1,'replacement' => array(7779)),array('code_point' => 7780,'type' => 1,'replacement' => array(7781)),array('code_point' => 7782,'type' => 1,'replacement' => array(7783)),array('code_point' => 7784,'type' => 1,'replacement' => array(7785)),array('code_point' => 7786,'type' => 1,'replacement' => array(7787)),array('code_point' => 7788,'type' => 1,'replacement' => array(7789)),array('code_point' => 7790,'type' => 1,'replacement' => array(7791)),array('code_point' => 7792,'type' => 1,'replacement' => array(7793)),array('code_point' => 7794,'type' => 1,'replacement' => array(7795)),array('code_point' => 7796,'type' => 1,'replacement' => array(7797)),array('code_point' => 7798,'type' => 1,'replacement' => array(7799)),array('code_point' => 7800,'type' => 1,'replacement' => array(7801)),array('code_point' => 7802,'type' => 1,'replacement' => array(7803)),array('code_point' => 7804,'type' => 1,'replacement' => array(7805)),array('code_point' => 7806,'type' => 1,'replacement' => array(7807)),array('code_point' => 7808,'type' => 1,'replacement' => array(7809)),array('code_point' => 7810,'type' => 1,'replacement' => array(7811)),array('code_point' => 7812,'type' => 1,'replacement' => array(7813)),array('code_point' => 7814,'type' => 1,'replacement' => array(7815)),array('code_point' => 7816,'type' => 1,'replacement' => array(7817)),array('code_point' => 7818,'type' => 1,'replacement' => array(7819)),array('code_point' => 7820,'type' => 1,'replacement' => array(7821)),array('code_point' => 7822,'type' => 1,'replacement' => array(7823)),array('code_point' => 7824,'type' => 1,'replacement' => array(7825)),array('code_point' => 7826,'type' => 1,'replacement' => array(7827)),array('code_point' => 7828,'type' => 1,'replacement' => array(7829)),array('code_point' => 7830,'type' => 4,'replacement' => array(104,817)),array('code_point' => 7831,'type' => 4,'replacement' => array(116,776)),array('code_point' => 7832,'type' => 4,'replacement' => array(119,778)),array('code_point' => 7833,'type' => 4,'replacement' => array(121,778)),array('code_point' => 7834,'type' => 4,'replacement' => array(97,702)),array('code_point' => 7835,'type' => 1,'replacement' => array(7777)),array('code_point' => 7838,'type' => 4,'replacement' => array(115,115)),array('code_point' => 7838,'type' => 2,'replacement' => array(223)),array('code_point' => 7840,'type' => 1,'replacement' => array(7841)),array('code_point' => 7842,'type' => 1,'replacement' => array(7843)),array('code_point' => 7844,'type' => 1,'replacement' => array(7845)),array('code_point' => 7846,'type' => 1,'replacement' => array(7847)),array('code_point' => 7848,'type' => 1,'replacement' => array(7849)),array('code_point' => 7850,'type' => 1,'replacement' => array(7851)),array('code_point' => 7852,'type' => 1,'replacement' => array(7853)),array('code_point' => 7854,'type' => 1,'replacement' => array(7855)),array('code_point' => 7856,'type' => 1,'replacement' => array(7857)),array('code_point' => 7858,'type' => 1,'replacement' => array(7859)),array('code_point' => 7860,'type' => 1,'replacement' => array(7861)),array('code_point' => 7862,'type' => 1,'replacement' => array(7863)),array('code_point' => 7864,'type' => 1,'replacement' => array(7865)),array('code_point' => 7866,'type' => 1,'replacement' => array(7867)),array('code_point' => 7868,'type' => 1,'replacement' => array(7869)),array('code_point' => 7870,'type' => 1,'replacement' => array(7871)),array('code_point' => 7872,'type' => 1,'replacement' => array(7873)),array('code_point' => 7874,'type' => 1,'replacement' => array(7875)),array('code_point' => 7876,'type' => 1,'replacement' => array(7877)),array('code_point' => 7878,'type' => 1,'replacement' => array(7879)),array('code_point' => 7880,'type' => 1,'replacement' => array(7881)),array('code_point' => 7882,'type' => 1,'replacement' => array(7883)),array('code_point' => 7884,'type' => 1,'replacement' => array(7885)),array('code_point' => 7886,'type' => 1,'replacement' => array(7887)),array('code_point' => 7888,'type' => 1,'replacement' => array(7889)),array('code_point' => 7890,'type' => 1,'replacement' => array(7891)),array('code_point' => 7892,'type' => 1,'replacement' => array(7893)),array('code_point' => 7894,'type' => 1,'replacement' => array(7895)),array('code_point' => 7896,'type' => 1,'replacement' => array(7897)),array('code_point' => 7898,'type' => 1,'replacement' => array(7899)),array('code_point' => 7900,'type' => 1,'replacement' => array(7901)),array('code_point' => 7902,'type' => 1,'replacement' => array(7903)),array('code_point' => 7904,'type' => 1,'replacement' => array(7905)),array('code_point' => 7906,'type' => 1,'replacement' => array(7907)),array('code_point' => 7908,'type' => 1,'replacement' => array(7909)),array('code_point' => 7910,'type' => 1,'replacement' => array(7911)),array('code_point' => 7912,'type' => 1,'replacement' => array(7913)),array('code_point' => 7914,'type' => 1,'replacement' => array(7915)),array('code_point' => 7916,'type' => 1,'replacement' => array(7917)),array('code_point' => 7918,'type' => 1,'replacement' => array(7919)),array('code_point' => 7920,'type' => 1,'replacement' => array(7921)),array('code_point' => 7922,'type' => 1,'replacement' => array(7923)),array('code_point' => 7924,'type' => 1,'replacement' => array(7925)),array('code_point' => 7926,'type' => 1,'replacement' => array(7927)),array('code_point' => 7928,'type' => 1,'replacement' => array(7929)),array('code_point' => 7930,'type' => 1,'replacement' => array(7931)),array('code_point' => 7932,'type' => 1,'replacement' => array(7933)),array('code_point' => 7934,'type' => 1,'replacement' => array(7935)),array('code_point' => 7944,'type' => 1,'replacement' => array(7936)),array('code_point' => 7945,'type' => 1,'replacement' => array(7937)),array('code_point' => 7946,'type' => 1,'replacement' => array(7938)),array('code_point' => 7947,'type' => 1,'replacement' => array(7939)),array('code_point' => 7948,'type' => 1,'replacement' => array(7940)),array('code_point' => 7949,'type' => 1,'replacement' => array(7941)),array('code_point' => 7950,'type' => 1,'replacement' => array(7942)),array('code_point' => 7951,'type' => 1,'replacement' => array(7943)),array('code_point' => 7960,'type' => 1,'replacement' => array(7952)),array('code_point' => 7961,'type' => 1,'replacement' => array(7953)),array('code_point' => 7962,'type' => 1,'replacement' => array(7954)),array('code_point' => 7963,'type' => 1,'replacement' => array(7955)),array('code_point' => 7964,'type' => 1,'replacement' => array(7956)),array('code_point' => 7965,'type' => 1,'replacement' => array(7957)),array('code_point' => 7976,'type' => 1,'replacement' => array(7968)),array('code_point' => 7977,'type' => 1,'replacement' => array(7969)),array('code_point' => 7978,'type' => 1,'replacement' => array(7970)),array('code_point' => 7979,'type' => 1,'replacement' => array(7971)),array('code_point' => 7980,'type' => 1,'replacement' => array(7972)),array('code_point' => 7981,'type' => 1,'replacement' => array(7973)),array('code_point' => 7982,'type' => 1,'replacement' => array(7974)),array('code_point' => 7983,'type' => 1,'replacement' => array(7975)),array('code_point' => 7992,'type' => 1,'replacement' => array(7984)),array('code_point' => 7993,'type' => 1,'replacement' => array(7985)),array('code_point' => 7994,'type' => 1,'replacement' => array(7986)),array('code_point' => 7995,'type' => 1,'replacement' => array(7987)),array('code_point' => 7996,'type' => 1,'replacement' => array(7988)),array('code_point' => 7997,'type' => 1,'replacement' => array(7989)),array('code_point' => 7998,'type' => 1,'replacement' => array(7990)),array('code_point' => 7999,'type' => 1,'replacement' => array(7991)),array('code_point' => 8008,'type' => 1,'replacement' => array(8000)),array('code_point' => 8009,'type' => 1,'replacement' => array(8001)),array('code_point' => 8010,'type' => 1,'replacement' => array(8002)),array('code_point' => 8011,'type' => 1,'replacement' => array(8003)),array('code_point' => 8012,'type' => 1,'replacement' => array(8004)),array('code_point' => 8013,'type' => 1,'replacement' => array(8005)),array('code_point' => 8016,'type' => 4,'replacement' => array(965,787)),array('code_point' => 8018,'type' => 4,'replacement' => array(965,787,768)),array('code_point' => 8020,'type' => 4,'replacement' => array(965,787,769)),array('code_point' => 8022,'type' => 4,'replacement' => array(965,787,834)),array('code_point' => 8025,'type' => 1,'replacement' => array(8017)),array('code_point' => 8027,'type' => 1,'replacement' => array(8019)),array('code_point' => 8029,'type' => 1,'replacement' => array(8021)),array('code_point' => 8031,'type' => 1,'replacement' => array(8023)),array('code_point' => 8040,'type' => 1,'replacement' => array(8032)),array('code_point' => 8041,'type' => 1,'replacement' => array(8033)),array('code_point' => 8042,'type' => 1,'replacement' => array(8034)),array('code_point' => 8043,'type' => 1,'replacement' => array(8035)),array('code_point' => 8044,'type' => 1,'replacement' => array(8036)),array('code_point' => 8045,'type' => 1,'replacement' => array(8037)),array('code_point' => 8046,'type' => 1,'replacement' => array(8038)),array('code_point' => 8047,'type' => 1,'replacement' => array(8039)),array('code_point' => 8064,'type' => 4,'replacement' => array(7936,953)),array('code_point' => 8065,'type' => 4,'replacement' => array(7937,953)),array('code_point' => 8066,'type' => 4,'replacement' => array(7938,953)),array('code_point' => 8067,'type' => 4,'replacement' => array(7939,953)),array('code_point' => 8068,'type' => 4,'replacement' => array(7940,953)),array('code_point' => 8069,'type' => 4,'replacement' => array(7941,953)),array('code_point' => 8070,'type' => 4,'replacement' => array(7942,953)),array('code_point' => 8071,'type' => 4,'replacement' => array(7943,953)),array('code_point' => 8072,'type' => 4,'replacement' => array(7936,953)),array('code_point' => 8072,'type' => 2,'replacement' => array(8064)),array('code_point' => 8073,'type' => 4,'replacement' => array(7937,953)),array('code_point' => 8073,'type' => 2,'replacement' => array(8065)),array('code_point' => 8074,'type' => 4,'replacement' => array(7938,953)),array('code_point' => 8074,'type' => 2,'replacement' => array(8066)),array('code_point' => 8075,'type' => 4,'replacement' => array(7939,953)),array('code_point' => 8075,'type' => 2,'replacement' => array(8067)),array('code_point' => 8076,'type' => 4,'replacement' => array(7940,953)),array('code_point' => 8076,'type' => 2,'replacement' => array(8068)),array('code_point' => 8077,'type' => 4,'replacement' => array(7941,953)),array('code_point' => 8077,'type' => 2,'replacement' => array(8069)),array('code_point' => 8078,'type' => 2,'replacement' => array(8070)),array('code_point' => 8078,'type' => 4,'replacement' => array(7942,953)),array('code_point' => 8079,'type' => 4,'replacement' => array(7943,953)),array('code_point' => 8079,'type' => 2,'replacement' => array(8071)),array('code_point' => 8080,'type' => 4,'replacement' => array(7968,953)),array('code_point' => 8081,'type' => 4,'replacement' => array(7969,953)),array('code_point' => 8082,'type' => 4,'replacement' => array(7970,953)),array('code_point' => 8083,'type' => 4,'replacement' => array(7971,953)),array('code_point' => 8084,'type' => 4,'replacement' => array(7972,953)),array('code_point' => 8085,'type' => 4,'replacement' => array(7973,953)),array('code_point' => 8086,'type' => 4,'replacement' => array(7974,953)),array('code_point' => 8087,'type' => 4,'replacement' => array(7975,953)),array('code_point' => 8088,'type' => 4,'replacement' => array(7968,953)),array('code_point' => 8088,'type' => 2,'replacement' => array(8080)),array('code_point' => 8089,'type' => 4,'replacement' => array(7969,953)),array('code_point' => 8089,'type' => 2,'replacement' => array(8081)),array('code_point' => 8090,'type' => 4,'replacement' => array(7970,953)),array('code_point' => 8090,'type' => 2,'replacement' => array(8082)),array('code_point' => 8091,'type' => 4,'replacement' => array(7971,953)),array('code_point' => 8091,'type' => 2,'replacement' => array(8083)),array('code_point' => 8092,'type' => 4,'replacement' => array(7972,953)),array('code_point' => 8092,'type' => 2,'replacement' => array(8084)),array('code_point' => 8093,'type' => 2,'replacement' => array(8085)),array('code_point' => 8093,'type' => 4,'replacement' => array(7973,953)),array('code_point' => 8094,'type' => 4,'replacement' => array(7974,953)),array('code_point' => 8094,'type' => 2,'replacement' => array(8086)),array('code_point' => 8095,'type' => 4,'replacement' => array(7975,953)),array('code_point' => 8095,'type' => 2,'replacement' => array(8087)),array('code_point' => 8096,'type' => 4,'replacement' => array(8032,953)),array('code_point' => 8097,'type' => 4,'replacement' => array(8033,953)),array('code_point' => 8098,'type' => 4,'replacement' => array(8034,953)),array('code_point' => 8099,'type' => 4,'replacement' => array(8035,953)),array('code_point' => 8100,'type' => 4,'replacement' => array(8036,953)),array('code_point' => 8101,'type' => 4,'replacement' => array(8037,953)),array('code_point' => 8102,'type' => 4,'replacement' => array(8038,953)),array('code_point' => 8103,'type' => 4,'replacement' => array(8039,953)),array('code_point' => 8104,'type' => 4,'replacement' => array(8032,953)),array('code_point' => 8104,'type' => 2,'replacement' => array(8096)),array('code_point' => 8105,'type' => 4,'replacement' => array(8033,953)),array('code_point' => 8105,'type' => 2,'replacement' => array(8097)),array('code_point' => 8106,'type' => 4,'replacement' => array(8034,953)),array('code_point' => 8106,'type' => 2,'replacement' => array(8098)),array('code_point' => 8107,'type' => 4,'replacement' => array(8035,953)),array('code_point' => 8107,'type' => 2,'replacement' => array(8099)),array('code_point' => 8108,'type' => 4,'replacement' => array(8036,953)),array('code_point' => 8108,'type' => 2,'replacement' => array(8100)),array('code_point' => 8109,'type' => 4,'replacement' => array(8037,953)),array('code_point' => 8109,'type' => 2,'replacement' => array(8101)),array('code_point' => 8110,'type' => 4,'replacement' => array(8038,953)),array('code_point' => 8110,'type' => 2,'replacement' => array(8102)),array('code_point' => 8111,'type' => 4,'replacement' => array(8039,953)),array('code_point' => 8111,'type' => 2,'replacement' => array(8103)),array('code_point' => 8114,'type' => 4,'replacement' => array(8048,953)),array('code_point' => 8115,'type' => 4,'replacement' => array(945,953)),array('code_point' => 8116,'type' => 4,'replacement' => array(940,953)),array('code_point' => 8118,'type' => 4,'replacement' => array(945,834)),array('code_point' => 8119,'type' => 4,'replacement' => array(945,834,953)),array('code_point' => 8120,'type' => 1,'replacement' => array(8112)),array('code_point' => 8121,'type' => 1,'replacement' => array(8113)),array('code_point' => 8122,'type' => 1,'replacement' => array(8048)),array('code_point' => 8123,'type' => 1,'replacement' => array(8049)),array('code_point' => 8124,'type' => 4,'replacement' => array(945,953)),array('code_point' => 8124,'type' => 2,'replacement' => array(8115)),array('code_point' => 8126,'type' => 1,'replacement' => array(953)),array('code_point' => 8130,'type' => 4,'replacement' => array(8052,953)),array('code_point' => 8131,'type' => 4,'replacement' => array(951,953)),array('code_point' => 8132,'type' => 4,'replacement' => array(942,953)),array('code_point' => 8134,'type' => 4,'replacement' => array(951,834)),array('code_point' => 8135,'type' => 4,'replacement' => array(951,834,953)),array('code_point' => 8136,'type' => 1,'replacement' => array(8050)),array('code_point' => 8137,'type' => 1,'replacement' => array(8051)),array('code_point' => 8138,'type' => 1,'replacement' => array(8052)),array('code_point' => 8139,'type' => 1,'replacement' => array(8053)),array('code_point' => 8140,'type' => 4,'replacement' => array(951,953)),array('code_point' => 8140,'type' => 2,'replacement' => array(8131)),array('code_point' => 8146,'type' => 4,'replacement' => array(953,776,768)),array('code_point' => 8147,'type' => 4,'replacement' => array(953,776,769)),array('code_point' => 8150,'type' => 4,'replacement' => array(953,834)),array('code_point' => 8151,'type' => 4,'replacement' => array(953,776,834)),array('code_point' => 8152,'type' => 1,'replacement' => array(8144)),array('code_point' => 8153,'type' => 1,'replacement' => array(8145)),array('code_point' => 8154,'type' => 1,'replacement' => array(8054)),array('code_point' => 8155,'type' => 1,'replacement' => array(8055)),array('code_point' => 8162,'type' => 4,'replacement' => array(965,776,768)),array('code_point' => 8163,'type' => 4,'replacement' => array(965,776,769)),array('code_point' => 8164,'type' => 4,'replacement' => array(961,787)),array('code_point' => 8166,'type' => 4,'replacement' => array(965,834)),array('code_point' => 8167,'type' => 4,'replacement' => array(965,776,834)),array('code_point' => 8168,'type' => 1,'replacement' => array(8160)),array('code_point' => 8169,'type' => 1,'replacement' => array(8161)),array('code_point' => 8170,'type' => 1,'replacement' => array(8058)),array('code_point' => 8171,'type' => 1,'replacement' => array(8059)),array('code_point' => 8172,'type' => 1,'replacement' => array(8165)),array('code_point' => 8178,'type' => 4,'replacement' => array(8060,953)),array('code_point' => 8179,'type' => 4,'replacement' => array(969,953)),array('code_point' => 8180,'type' => 4,'replacement' => array(974,953)),array('code_point' => 8182,'type' => 4,'replacement' => array(969,834)),array('code_point' => 8183,'type' => 4,'replacement' => array(969,834,953)),array('code_point' => 8184,'type' => 1,'replacement' => array(8056)),array('code_point' => 8185,'type' => 1,'replacement' => array(8057)),array('code_point' => 8186,'type' => 1,'replacement' => array(8060)),array('code_point' => 8187,'type' => 1,'replacement' => array(8061)),array('code_point' => 8188,'type' => 4,'replacement' => array(969,953)),array('code_point' => 8188,'type' => 2,'replacement' => array(8179)),array('code_point' => 8486,'type' => 1,'replacement' => array(969)),array('code_point' => 8490,'type' => 1,'replacement' => array(107)),array('code_point' => 8491,'type' => 1,'replacement' => array(229)),array('code_point' => 8498,'type' => 1,'replacement' => array(8526)),array('code_point' => 8544,'type' => 1,'replacement' => array(8560)),array('code_point' => 8545,'type' => 1,'replacement' => array(8561)),array('code_point' => 8546,'type' => 1,'replacement' => array(8562)),array('code_point' => 8547,'type' => 1,'replacement' => array(8563)),array('code_point' => 8548,'type' => 1,'replacement' => array(8564)),array('code_point' => 8549,'type' => 1,'replacement' => array(8565)),array('code_point' => 8550,'type' => 1,'replacement' => array(8566)),array('code_point' => 8551,'type' => 1,'replacement' => array(8567)),array('code_point' => 8552,'type' => 1,'replacement' => array(8568)),array('code_point' => 8553,'type' => 1,'replacement' => array(8569)),array('code_point' => 8554,'type' => 1,'replacement' => array(8570)),array('code_point' => 8555,'type' => 1,'replacement' => array(8571)),array('code_point' => 8556,'type' => 1,'replacement' => array(8572)),array('code_point' => 8557,'type' => 1,'replacement' => array(8573)),array('code_point' => 8558,'type' => 1,'replacement' => array(8574)),array('code_point' => 8559,'type' => 1,'replacement' => array(8575)),array('code_point' => 8579,'type' => 1,'replacement' => array(8580)),array('code_point' => 9398,'type' => 1,'replacement' => array(9424)),array('code_point' => 9399,'type' => 1,'replacement' => array(9425)),array('code_point' => 9400,'type' => 1,'replacement' => array(9426)),array('code_point' => 9401,'type' => 1,'replacement' => array(9427)),array('code_point' => 9402,'type' => 1,'replacement' => array(9428)),array('code_point' => 9403,'type' => 1,'replacement' => array(9429)),array('code_point' => 9404,'type' => 1,'replacement' => array(9430)),array('code_point' => 9405,'type' => 1,'replacement' => array(9431)),array('code_point' => 9406,'type' => 1,'replacement' => array(9432)),array('code_point' => 9407,'type' => 1,'replacement' => array(9433)),array('code_point' => 9408,'type' => 1,'replacement' => array(9434)),array('code_point' => 9409,'type' => 1,'replacement' => array(9435)),array('code_point' => 9410,'type' => 1,'replacement' => array(9436)),array('code_point' => 9411,'type' => 1,'replacement' => array(9437)),array('code_point' => 9412,'type' => 1,'replacement' => array(9438)),array('code_point' => 9413,'type' => 1,'replacement' => array(9439)),array('code_point' => 9414,'type' => 1,'replacement' => array(9440)),array('code_point' => 9415,'type' => 1,'replacement' => array(9441)),array('code_point' => 9416,'type' => 1,'replacement' => array(9442)),array('code_point' => 9417,'type' => 1,'replacement' => array(9443)),array('code_point' => 9418,'type' => 1,'replacement' => array(9444)),array('code_point' => 9419,'type' => 1,'replacement' => array(9445)),array('code_point' => 9420,'type' => 1,'replacement' => array(9446)),array('code_point' => 9421,'type' => 1,'replacement' => array(9447)),array('code_point' => 9422,'type' => 1,'replacement' => array(9448)),array('code_point' => 9423,'type' => 1,'replacement' => array(9449)),array('code_point' => 11264,'type' => 1,'replacement' => array(11312)),array('code_point' => 11265,'type' => 1,'replacement' => array(11313)),array('code_point' => 11266,'type' => 1,'replacement' => array(11314)),array('code_point' => 11267,'type' => 1,'replacement' => array(11315)),array('code_point' => 11268,'type' => 1,'replacement' => array(11316)),array('code_point' => 11269,'type' => 1,'replacement' => array(11317)),array('code_point' => 11270,'type' => 1,'replacement' => array(11318)),array('code_point' => 11271,'type' => 1,'replacement' => array(11319)),array('code_point' => 11272,'type' => 1,'replacement' => array(11320)),array('code_point' => 11273,'type' => 1,'replacement' => array(11321)),array('code_point' => 11274,'type' => 1,'replacement' => array(11322)),array('code_point' => 11275,'type' => 1,'replacement' => array(11323)),array('code_point' => 11276,'type' => 1,'replacement' => array(11324)),array('code_point' => 11277,'type' => 1,'replacement' => array(11325)),array('code_point' => 11278,'type' => 1,'replacement' => array(11326)),array('code_point' => 11279,'type' => 1,'replacement' => array(11327)),array('code_point' => 11280,'type' => 1,'replacement' => array(11328)),array('code_point' => 11281,'type' => 1,'replacement' => array(11329)),array('code_point' => 11282,'type' => 1,'replacement' => array(11330)),array('code_point' => 11283,'type' => 1,'replacement' => array(11331)),array('code_point' => 11284,'type' => 1,'replacement' => array(11332)),array('code_point' => 11285,'type' => 1,'replacement' => array(11333)),array('code_point' => 11286,'type' => 1,'replacement' => array(11334)),array('code_point' => 11287,'type' => 1,'replacement' => array(11335)),array('code_point' => 11288,'type' => 1,'replacement' => array(11336)),array('code_point' => 11289,'type' => 1,'replacement' => array(11337)),array('code_point' => 11290,'type' => 1,'replacement' => array(11338)),array('code_point' => 11291,'type' => 1,'replacement' => array(11339)),array('code_point' => 11292,'type' => 1,'replacement' => array(11340)),array('code_point' => 11293,'type' => 1,'replacement' => array(11341)),array('code_point' => 11294,'type' => 1,'replacement' => array(11342)),array('code_point' => 11295,'type' => 1,'replacement' => array(11343)),array('code_point' => 11296,'type' => 1,'replacement' => array(11344)),array('code_point' => 11297,'type' => 1,'replacement' => array(11345)),array('code_point' => 11298,'type' => 1,'replacement' => array(11346)),array('code_point' => 11299,'type' => 1,'replacement' => array(11347)),array('code_point' => 11300,'type' => 1,'replacement' => array(11348)),array('code_point' => 11301,'type' => 1,'replacement' => array(11349)),array('code_point' => 11302,'type' => 1,'replacement' => array(11350)),array('code_point' => 11303,'type' => 1,'replacement' => array(11351)),array('code_point' => 11304,'type' => 1,'replacement' => array(11352)),array('code_point' => 11305,'type' => 1,'replacement' => array(11353)),array('code_point' => 11306,'type' => 1,'replacement' => array(11354)),array('code_point' => 11307,'type' => 1,'replacement' => array(11355)),array('code_point' => 11308,'type' => 1,'replacement' => array(11356)),array('code_point' => 11309,'type' => 1,'replacement' => array(11357)),array('code_point' => 11310,'type' => 1,'replacement' => array(11358)),array('code_point' => 11360,'type' => 1,'replacement' => array(11361)),array('code_point' => 11362,'type' => 1,'replacement' => array(619)),array('code_point' => 11363,'type' => 1,'replacement' => array(7549)),array('code_point' => 11364,'type' => 1,'replacement' => array(637)),array('code_point' => 11367,'type' => 1,'replacement' => array(11368)),array('code_point' => 11369,'type' => 1,'replacement' => array(11370)),array('code_point' => 11371,'type' => 1,'replacement' => array(11372)),array('code_point' => 11373,'type' => 1,'replacement' => array(593)),array('code_point' => 11374,'type' => 1,'replacement' => array(625)),array('code_point' => 11375,'type' => 1,'replacement' => array(592)),array('code_point' => 11376,'type' => 1,'replacement' => array(594)),array('code_point' => 11378,'type' => 1,'replacement' => array(11379)),array('code_point' => 11381,'type' => 1,'replacement' => array(11382)),array('code_point' => 11390,'type' => 1,'replacement' => array(575)),array('code_point' => 11391,'type' => 1,'replacement' => array(576)),array('code_point' => 11392,'type' => 1,'replacement' => array(11393)),array('code_point' => 11394,'type' => 1,'replacement' => array(11395)),array('code_point' => 11396,'type' => 1,'replacement' => array(11397)),array('code_point' => 11398,'type' => 1,'replacement' => array(11399)),array('code_point' => 11400,'type' => 1,'replacement' => array(11401)),array('code_point' => 11402,'type' => 1,'replacement' => array(11403)),array('code_point' => 11404,'type' => 1,'replacement' => array(11405)),array('code_point' => 11406,'type' => 1,'replacement' => array(11407)),array('code_point' => 11408,'type' => 1,'replacement' => array(11409)),array('code_point' => 11410,'type' => 1,'replacement' => array(11411)),array('code_point' => 11412,'type' => 1,'replacement' => array(11413)),array('code_point' => 11414,'type' => 1,'replacement' => array(11415)),array('code_point' => 11416,'type' => 1,'replacement' => array(11417)),array('code_point' => 11418,'type' => 1,'replacement' => array(11419)),array('code_point' => 11420,'type' => 1,'replacement' => array(11421)),array('code_point' => 11422,'type' => 1,'replacement' => array(11423)),array('code_point' => 11424,'type' => 1,'replacement' => array(11425)),array('code_point' => 11426,'type' => 1,'replacement' => array(11427)),array('code_point' => 11428,'type' => 1,'replacement' => array(11429)),array('code_point' => 11430,'type' => 1,'replacement' => array(11431)),array('code_point' => 11432,'type' => 1,'replacement' => array(11433)),array('code_point' => 11434,'type' => 1,'replacement' => array(11435)),array('code_point' => 11436,'type' => 1,'replacement' => array(11437)),array('code_point' => 11438,'type' => 1,'replacement' => array(11439)),array('code_point' => 11440,'type' => 1,'replacement' => array(11441)),array('code_point' => 11442,'type' => 1,'replacement' => array(11443)),array('code_point' => 11444,'type' => 1,'replacement' => array(11445)),array('code_point' => 11446,'type' => 1,'replacement' => array(11447)),array('code_point' => 11448,'type' => 1,'replacement' => array(11449)),array('code_point' => 11450,'type' => 1,'replacement' => array(11451)),array('code_point' => 11452,'type' => 1,'replacement' => array(11453)),array('code_point' => 11454,'type' => 1,'replacement' => array(11455)),array('code_point' => 11456,'type' => 1,'replacement' => array(11457)),array('code_point' => 11458,'type' => 1,'replacement' => array(11459)),array('code_point' => 11460,'type' => 1,'replacement' => array(11461)),array('code_point' => 11462,'type' => 1,'replacement' => array(11463)),array('code_point' => 11464,'type' => 1,'replacement' => array(11465)),array('code_point' => 11466,'type' => 1,'replacement' => array(11467)),array('code_point' => 11468,'type' => 1,'replacement' => array(11469)),array('code_point' => 11470,'type' => 1,'replacement' => array(11471)),array('code_point' => 11472,'type' => 1,'replacement' => array(11473)),array('code_point' => 11474,'type' => 1,'replacement' => array(11475)),array('code_point' => 11476,'type' => 1,'replacement' => array(11477)),array('code_point' => 11478,'type' => 1,'replacement' => array(11479)),array('code_point' => 11480,'type' => 1,'replacement' => array(11481)),array('code_point' => 11482,'type' => 1,'replacement' => array(11483)),array('code_point' => 11484,'type' => 1,'replacement' => array(11485)),array('code_point' => 11486,'type' => 1,'replacement' => array(11487)),array('code_point' => 11488,'type' => 1,'replacement' => array(11489)),array('code_point' => 11490,'type' => 1,'replacement' => array(11491)),array('code_point' => 11499,'type' => 1,'replacement' => array(11500)),array('code_point' => 11501,'type' => 1,'replacement' => array(11502)),array('code_point' => 11506,'type' => 1,'replacement' => array(11507)),array('code_point' => 42560,'type' => 1,'replacement' => array(42561)),array('code_point' => 42562,'type' => 1,'replacement' => array(42563)),array('code_point' => 42564,'type' => 1,'replacement' => array(42565)),array('code_point' => 42566,'type' => 1,'replacement' => array(42567)),array('code_point' => 42568,'type' => 1,'replacement' => array(42569)),array('code_point' => 42570,'type' => 1,'replacement' => array(42571)),array('code_point' => 42572,'type' => 1,'replacement' => array(42573)),array('code_point' => 42574,'type' => 1,'replacement' => array(42575)),array('code_point' => 42576,'type' => 1,'replacement' => array(42577)),array('code_point' => 42578,'type' => 1,'replacement' => array(42579)),array('code_point' => 42580,'type' => 1,'replacement' => array(42581)),array('code_point' => 42582,'type' => 1,'replacement' => array(42583)),array('code_point' => 42584,'type' => 1,'replacement' => array(42585)),array('code_point' => 42586,'type' => 1,'replacement' => array(42587)),array('code_point' => 42588,'type' => 1,'replacement' => array(42589)),array('code_point' => 42590,'type' => 1,'replacement' => array(42591)),array('code_point' => 42592,'type' => 1,'replacement' => array(42593)),array('code_point' => 42594,'type' => 1,'replacement' => array(42595)),array('code_point' => 42596,'type' => 1,'replacement' => array(42597)),array('code_point' => 42598,'type' => 1,'replacement' => array(42599)),array('code_point' => 42600,'type' => 1,'replacement' => array(42601)),array('code_point' => 42602,'type' => 1,'replacement' => array(42603)),array('code_point' => 42604,'type' => 1,'replacement' => array(42605)),array('code_point' => 42624,'type' => 1,'replacement' => array(42625)),array('code_point' => 42626,'type' => 1,'replacement' => array(42627)),array('code_point' => 42628,'type' => 1,'replacement' => array(42629)),array('code_point' => 42630,'type' => 1,'replacement' => array(42631)),array('code_point' => 42632,'type' => 1,'replacement' => array(42633)),array('code_point' => 42634,'type' => 1,'replacement' => array(42635)),array('code_point' => 42636,'type' => 1,'replacement' => array(42637)),array('code_point' => 42638,'type' => 1,'replacement' => array(42639)),array('code_point' => 42640,'type' => 1,'replacement' => array(42641)),array('code_point' => 42642,'type' => 1,'replacement' => array(42643)),array('code_point' => 42644,'type' => 1,'replacement' => array(42645)),array('code_point' => 42646,'type' => 1,'replacement' => array(42647)),array('code_point' => 42648,'type' => 1,'replacement' => array(42649)),array('code_point' => 42650,'type' => 1,'replacement' => array(42651)),array('code_point' => 42786,'type' => 1,'replacement' => array(42787)),array('code_point' => 42788,'type' => 1,'replacement' => array(42789)),array('code_point' => 42790,'type' => 1,'replacement' => array(42791)),array('code_point' => 42792,'type' => 1,'replacement' => array(42793)),array('code_point' => 42794,'type' => 1,'replacement' => array(42795)),array('code_point' => 42796,'type' => 1,'replacement' => array(42797)),array('code_point' => 42798,'type' => 1,'replacement' => array(42799)),array('code_point' => 42802,'type' => 1,'replacement' => array(42803)),array('code_point' => 42804,'type' => 1,'replacement' => array(42805)),array('code_point' => 42806,'type' => 1,'replacement' => array(42807)),array('code_point' => 42808,'type' => 1,'replacement' => array(42809)),array('code_point' => 42810,'type' => 1,'replacement' => array(42811)),array('code_point' => 42812,'type' => 1,'replacement' => array(42813)),array('code_point' => 42814,'type' => 1,'replacement' => array(42815)),array('code_point' => 42816,'type' => 1,'replacement' => array(42817)),array('code_point' => 42818,'type' => 1,'replacement' => array(42819)),array('code_point' => 42820,'type' => 1,'replacement' => array(42821)),array('code_point' => 42822,'type' => 1,'replacement' => array(42823)),array('code_point' => 42824,'type' => 1,'replacement' => array(42825)),array('code_point' => 42826,'type' => 1,'replacement' => array(42827)),array('code_point' => 42828,'type' => 1,'replacement' => array(42829)),array('code_point' => 42830,'type' => 1,'replacement' => array(42831)),array('code_point' => 42832,'type' => 1,'replacement' => array(42833)),array('code_point' => 42834,'type' => 1,'replacement' => array(42835)),array('code_point' => 42836,'type' => 1,'replacement' => array(42837)),array('code_point' => 42838,'type' => 1,'replacement' => array(42839)),array('code_point' => 42840,'type' => 1,'replacement' => array(42841)),array('code_point' => 42842,'type' => 1,'replacement' => array(42843)),array('code_point' => 42844,'type' => 1,'replacement' => array(42845)),array('code_point' => 42846,'type' => 1,'replacement' => array(42847)),array('code_point' => 42848,'type' => 1,'replacement' => array(42849)),array('code_point' => 42850,'type' => 1,'replacement' => array(42851)),array('code_point' => 42852,'type' => 1,'replacement' => array(42853)),array('code_point' => 42854,'type' => 1,'replacement' => array(42855)),array('code_point' => 42856,'type' => 1,'replacement' => array(42857)),array('code_point' => 42858,'type' => 1,'replacement' => array(42859)),array('code_point' => 42860,'type' => 1,'replacement' => array(42861)),array('code_point' => 42862,'type' => 1,'replacement' => array(42863)),array('code_point' => 42873,'type' => 1,'replacement' => array(42874)),array('code_point' => 42875,'type' => 1,'replacement' => array(42876)),array('code_point' => 42877,'type' => 1,'replacement' => array(7545)),array('code_point' => 42878,'type' => 1,'replacement' => array(42879)),array('code_point' => 42880,'type' => 1,'replacement' => array(42881)),array('code_point' => 42882,'type' => 1,'replacement' => array(42883)),array('code_point' => 42884,'type' => 1,'replacement' => array(42885)),array('code_point' => 42886,'type' => 1,'replacement' => array(42887)),array('code_point' => 42891,'type' => 1,'replacement' => array(42892)),array('code_point' => 42893,'type' => 1,'replacement' => array(613)),array('code_point' => 42896,'type' => 1,'replacement' => array(42897)),array('code_point' => 42898,'type' => 1,'replacement' => array(42899)),array('code_point' => 42902,'type' => 1,'replacement' => array(42903)),array('code_point' => 42904,'type' => 1,'replacement' => array(42905)),array('code_point' => 42906,'type' => 1,'replacement' => array(42907)),array('code_point' => 42908,'type' => 1,'replacement' => array(42909)),array('code_point' => 42910,'type' => 1,'replacement' => array(42911)),array('code_point' => 42912,'type' => 1,'replacement' => array(42913)),array('code_point' => 42914,'type' => 1,'replacement' => array(42915)),array('code_point' => 42916,'type' => 1,'replacement' => array(42917)),array('code_point' => 42918,'type' => 1,'replacement' => array(42919)),array('code_point' => 42920,'type' => 1,'replacement' => array(42921)),array('code_point' => 42922,'type' => 1,'replacement' => array(614)),array('code_point' => 42923,'type' => 1,'replacement' => array(604)),array('code_point' => 42924,'type' => 1,'replacement' => array(609)),array('code_point' => 42925,'type' => 1,'replacement' => array(620)),array('code_point' => 42928,'type' => 1,'replacement' => array(670)),array('code_point' => 42929,'type' => 1,'replacement' => array(647)),array('code_point' => 42930,'type' => 1,'replacement' => array(669)),array('code_point' => 42931,'type' => 1,'replacement' => array(43859)),array('code_point' => 42932,'type' => 1,'replacement' => array(42933)),array('code_point' => 42934,'type' => 1,'replacement' => array(42935)),array('code_point' => 43888,'type' => 1,'replacement' => array(5024)),array('code_point' => 43889,'type' => 1,'replacement' => array(5025)),array('code_point' => 43890,'type' => 1,'replacement' => array(5026)),array('code_point' => 43891,'type' => 1,'replacement' => array(5027)),array('code_point' => 43892,'type' => 1,'replacement' => array(5028)),array('code_point' => 43893,'type' => 1,'replacement' => array(5029)),array('code_point' => 43894,'type' => 1,'replacement' => array(5030)),array('code_point' => 43895,'type' => 1,'replacement' => array(5031)),array('code_point' => 43896,'type' => 1,'replacement' => array(5032)),array('code_point' => 43897,'type' => 1,'replacement' => array(5033)),array('code_point' => 43898,'type' => 1,'replacement' => array(5034)),array('code_point' => 43899,'type' => 1,'replacement' => array(5035)),array('code_point' => 43900,'type' => 1,'replacement' => array(5036)),array('code_point' => 43901,'type' => 1,'replacement' => array(5037)),array('code_point' => 43902,'type' => 1,'replacement' => array(5038)),array('code_point' => 43903,'type' => 1,'replacement' => array(5039)),array('code_point' => 43904,'type' => 1,'replacement' => array(5040)),array('code_point' => 43905,'type' => 1,'replacement' => array(5041)),array('code_point' => 43906,'type' => 1,'replacement' => array(5042)),array('code_point' => 43907,'type' => 1,'replacement' => array(5043)),array('code_point' => 43908,'type' => 1,'replacement' => array(5044)),array('code_point' => 43909,'type' => 1,'replacement' => array(5045)),array('code_point' => 43910,'type' => 1,'replacement' => array(5046)),array('code_point' => 43911,'type' => 1,'replacement' => array(5047)),array('code_point' => 43912,'type' => 1,'replacement' => array(5048)),array('code_point' => 43913,'type' => 1,'replacement' => array(5049)),array('code_point' => 43914,'type' => 1,'replacement' => array(5050)),array('code_point' => 43915,'type' => 1,'replacement' => array(5051)),array('code_point' => 43916,'type' => 1,'replacement' => array(5052)),array('code_point' => 43917,'type' => 1,'replacement' => array(5053)),array('code_point' => 43918,'type' => 1,'replacement' => array(5054)),array('code_point' => 43919,'type' => 1,'replacement' => array(5055)),array('code_point' => 43920,'type' => 1,'replacement' => array(5056)),array('code_point' => 43921,'type' => 1,'replacement' => array(5057)),array('code_point' => 43922,'type' => 1,'replacement' => array(5058)),array('code_point' => 43923,'type' => 1,'replacement' => array(5059)),array('code_point' => 43924,'type' => 1,'replacement' => array(5060)),array('code_point' => 43925,'type' => 1,'replacement' => array(5061)),array('code_point' => 43926,'type' => 1,'replacement' => array(5062)),array('code_point' => 43927,'type' => 1,'replacement' => array(5063)),array('code_point' => 43928,'type' => 1,'replacement' => array(5064)),array('code_point' => 43929,'type' => 1,'replacement' => array(5065)),array('code_point' => 43930,'type' => 1,'replacement' => array(5066)),array('code_point' => 43931,'type' => 1,'replacement' => array(5067)),array('code_point' => 43932,'type' => 1,'replacement' => array(5068)),array('code_point' => 43933,'type' => 1,'replacement' => array(5069)),array('code_point' => 43934,'type' => 1,'replacement' => array(5070)),array('code_point' => 43935,'type' => 1,'replacement' => array(5071)),array('code_point' => 43936,'type' => 1,'replacement' => array(5072)),array('code_point' => 43937,'type' => 1,'replacement' => array(5073)),array('code_point' => 43938,'type' => 1,'replacement' => array(5074)),array('code_point' => 43939,'type' => 1,'replacement' => array(5075)),array('code_point' => 43940,'type' => 1,'replacement' => array(5076)),array('code_point' => 43941,'type' => 1,'replacement' => array(5077)),array('code_point' => 43942,'type' => 1,'replacement' => array(5078)),array('code_point' => 43943,'type' => 1,'replacement' => array(5079)),array('code_point' => 43944,'type' => 1,'replacement' => array(5080)),array('code_point' => 43945,'type' => 1,'replacement' => array(5081)),array('code_point' => 43946,'type' => 1,'replacement' => array(5082)),array('code_point' => 43947,'type' => 1,'replacement' => array(5083)),array('code_point' => 43948,'type' => 1,'replacement' => array(5084)),array('code_point' => 43949,'type' => 1,'replacement' => array(5085)),array('code_point' => 43950,'type' => 1,'replacement' => array(5086)),array('code_point' => 43951,'type' => 1,'replacement' => array(5087)),array('code_point' => 43952,'type' => 1,'replacement' => array(5088)),array('code_point' => 43953,'type' => 1,'replacement' => array(5089)),array('code_point' => 43954,'type' => 1,'replacement' => array(5090)),array('code_point' => 43955,'type' => 1,'replacement' => array(5091)),array('code_point' => 43956,'type' => 1,'replacement' => array(5092)),array('code_point' => 43957,'type' => 1,'replacement' => array(5093)),array('code_point' => 43958,'type' => 1,'replacement' => array(5094)),array('code_point' => 43959,'type' => 1,'replacement' => array(5095)),array('code_point' => 43960,'type' => 1,'replacement' => array(5096)),array('code_point' => 43961,'type' => 1,'replacement' => array(5097)),array('code_point' => 43962,'type' => 1,'replacement' => array(5098)),array('code_point' => 43963,'type' => 1,'replacement' => array(5099)),array('code_point' => 43964,'type' => 1,'replacement' => array(5100)),array('code_point' => 43965,'type' => 1,'replacement' => array(5101)),array('code_point' => 43966,'type' => 1,'replacement' => array(5102)),array('code_point' => 43967,'type' => 1,'replacement' => array(5103)),array('code_point' => 64256,'type' => 4,'replacement' => array(102,102)),array('code_point' => 64257,'type' => 4,'replacement' => array(102,105)),array('code_point' => 64258,'type' => 4,'replacement' => array(102,108)),array('code_point' => 64259,'type' => 4,'replacement' => array(102,102,105)),array('code_point' => 64260,'type' => 4,'replacement' => array(102,102,108)),array('code_point' => 64261,'type' => 4,'replacement' => array(115,116)),array('code_point' => 64262,'type' => 4,'replacement' => array(115,116)),array('code_point' => 64275,'type' => 4,'replacement' => array(1396,1398)),array('code_point' => 64276,'type' => 4,'replacement' => array(1396,1381)),array('code_point' => 64277,'type' => 4,'replacement' => array(1396,1387)),array('code_point' => 64278,'type' => 4,'replacement' => array(1406,1398)),array('code_point' => 64279,'type' => 4,'replacement' => array(1396,1389)),array('code_point' => 65313,'type' => 1,'replacement' => array(65345)),array('code_point' => 65314,'type' => 1,'replacement' => array(65346)),array('code_point' => 65315,'type' => 1,'replacement' => array(65347)),array('code_point' => 65316,'type' => 1,'replacement' => array(65348)),array('code_point' => 65317,'type' => 1,'replacement' => array(65349)),array('code_point' => 65318,'type' => 1,'replacement' => array(65350)),array('code_point' => 65319,'type' => 1,'replacement' => array(65351)),array('code_point' => 65320,'type' => 1,'replacement' => array(65352)),array('code_point' => 65321,'type' => 1,'replacement' => array(65353)),array('code_point' => 65322,'type' => 1,'replacement' => array(65354)),array('code_point' => 65323,'type' => 1,'replacement' => array(65355)),array('code_point' => 65324,'type' => 1,'replacement' => array(65356)),array('code_point' => 65325,'type' => 1,'replacement' => array(65357)),array('code_point' => 65326,'type' => 1,'replacement' => array(65358)),array('code_point' => 65327,'type' => 1,'replacement' => array(65359)),array('code_point' => 65328,'type' => 1,'replacement' => array(65360)),array('code_point' => 65329,'type' => 1,'replacement' => array(65361)),array('code_point' => 65330,'type' => 1,'replacement' => array(65362)),array('code_point' => 65331,'type' => 1,'replacement' => array(65363)),array('code_point' => 65332,'type' => 1,'replacement' => array(65364)),array('code_point' => 65333,'type' => 1,'replacement' => array(65365)),array('code_point' => 65334,'type' => 1,'replacement' => array(65366)),array('code_point' => 65335,'type' => 1,'replacement' => array(65367)),array('code_point' => 65336,'type' => 1,'replacement' => array(65368)),array('code_point' => 65337,'type' => 1,'replacement' => array(65369)),array('code_point' => 65338,'type' => 1,'replacement' => array(65370)),array('code_point' => 66560,'type' => 1,'replacement' => array(66600)),array('code_point' => 66561,'type' => 1,'replacement' => array(66601)),array('code_point' => 66562,'type' => 1,'replacement' => array(66602)),array('code_point' => 66563,'type' => 1,'replacement' => array(66603)),array('code_point' => 66564,'type' => 1,'replacement' => array(66604)),array('code_point' => 66565,'type' => 1,'replacement' => array(66605)),array('code_point' => 66566,'type' => 1,'replacement' => array(66606)),array('code_point' => 66567,'type' => 1,'replacement' => array(66607)),array('code_point' => 66568,'type' => 1,'replacement' => array(66608)),array('code_point' => 66569,'type' => 1,'replacement' => array(66609)),array('code_point' => 66570,'type' => 1,'replacement' => array(66610)),array('code_point' => 66571,'type' => 1,'replacement' => array(66611)),array('code_point' => 66572,'type' => 1,'replacement' => array(66612)),array('code_point' => 66573,'type' => 1,'replacement' => array(66613)),array('code_point' => 66574,'type' => 1,'replacement' => array(66614)),array('code_point' => 66575,'type' => 1,'replacement' => array(66615)),array('code_point' => 66576,'type' => 1,'replacement' => array(66616)),array('code_point' => 66577,'type' => 1,'replacement' => array(66617)),array('code_point' => 66578,'type' => 1,'replacement' => array(66618)),array('code_point' => 66579,'type' => 1,'replacement' => array(66619)),array('code_point' => 66580,'type' => 1,'replacement' => array(66620)),array('code_point' => 66581,'type' => 1,'replacement' => array(66621)),array('code_point' => 66582,'type' => 1,'replacement' => array(66622)),array('code_point' => 66583,'type' => 1,'replacement' => array(66623)),array('code_point' => 66584,'type' => 1,'replacement' => array(66624)),array('code_point' => 66585,'type' => 1,'replacement' => array(66625)),array('code_point' => 66586,'type' => 1,'replacement' => array(66626)),array('code_point' => 66587,'type' => 1,'replacement' => array(66627)),array('code_point' => 66588,'type' => 1,'replacement' => array(66628)),array('code_point' => 66589,'type' => 1,'replacement' => array(66629)),array('code_point' => 66590,'type' => 1,'replacement' => array(66630)),array('code_point' => 66591,'type' => 1,'replacement' => array(66631)),array('code_point' => 66592,'type' => 1,'replacement' => array(66632)),array('code_point' => 66593,'type' => 1,'replacement' => array(66633)),array('code_point' => 66594,'type' => 1,'replacement' => array(66634)),array('code_point' => 66595,'type' => 1,'replacement' => array(66635)),array('code_point' => 66596,'type' => 1,'replacement' => array(66636)),array('code_point' => 66597,'type' => 1,'replacement' => array(66637)),array('code_point' => 66598,'type' => 1,'replacement' => array(66638)),array('code_point' => 66599,'type' => 1,'replacement' => array(66639)),array('code_point' => 68736,'type' => 1,'replacement' => array(68800)),array('code_point' => 68737,'type' => 1,'replacement' => array(68801)),array('code_point' => 68738,'type' => 1,'replacement' => array(68802)),array('code_point' => 68739,'type' => 1,'replacement' => array(68803)),array('code_point' => 68740,'type' => 1,'replacement' => array(68804)),array('code_point' => 68741,'type' => 1,'replacement' => array(68805)),array('code_point' => 68742,'type' => 1,'replacement' => array(68806)),array('code_point' => 68743,'type' => 1,'replacement' => array(68807)),array('code_point' => 68744,'type' => 1,'replacement' => array(68808)),array('code_point' => 68745,'type' => 1,'replacement' => array(68809)),array('code_point' => 68746,'type' => 1,'replacement' => array(68810)),array('code_point' => 68747,'type' => 1,'replacement' => array(68811)),array('code_point' => 68748,'type' => 1,'replacement' => array(68812)),array('code_point' => 68749,'type' => 1,'replacement' => array(68813)),array('code_point' => 68750,'type' => 1,'replacement' => array(68814)),array('code_point' => 68751,'type' => 1,'replacement' => array(68815)),array('code_point' => 68752,'type' => 1,'replacement' => array(68816)),array('code_point' => 68753,'type' => 1,'replacement' => array(68817)),array('code_point' => 68754,'type' => 1,'replacement' => array(68818)),array('code_point' => 68755,'type' => 1,'replacement' => array(68819)),array('code_point' => 68756,'type' => 1,'replacement' => array(68820)),array('code_point' => 68757,'type' => 1,'replacement' => array(68821)),array('code_point' => 68758,'type' => 1,'replacement' => array(68822)),array('code_point' => 68759,'type' => 1,'replacement' => array(68823)),array('code_point' => 68760,'type' => 1,'replacement' => array(68824)),array('code_point' => 68761,'type' => 1,'replacement' => array(68825)),array('code_point' => 68762,'type' => 1,'replacement' => array(68826)),array('code_point' => 68763,'type' => 1,'replacement' => array(68827)),array('code_point' => 68764,'type' => 1,'replacement' => array(68828)),array('code_point' => 68765,'type' => 1,'replacement' => array(68829)),array('code_point' => 68766,'type' => 1,'replacement' => array(68830)),array('code_point' => 68767,'type' => 1,'replacement' => array(68831)),array('code_point' => 68768,'type' => 1,'replacement' => array(68832)),array('code_point' => 68769,'type' => 1,'replacement' => array(68833)),array('code_point' => 68770,'type' => 1,'replacement' => array(68834)),array('code_point' => 68771,'type' => 1,'replacement' => array(68835)),array('code_point' => 68772,'type' => 1,'replacement' => array(68836)),array('code_point' => 68773,'type' => 1,'replacement' => array(68837)),array('code_point' => 68774,'type' => 1,'replacement' => array(68838)),array('code_point' => 68775,'type' => 1,'replacement' => array(68839)),array('code_point' => 68776,'type' => 1,'replacement' => array(68840)),array('code_point' => 68777,'type' => 1,'replacement' => array(68841)),array('code_point' => 68778,'type' => 1,'replacement' => array(68842)),array('code_point' => 68779,'type' => 1,'replacement' => array(68843)),array('code_point' => 68780,'type' => 1,'replacement' => array(68844)),array('code_point' => 68781,'type' => 1,'replacement' => array(68845)),array('code_point' => 68782,'type' => 1,'replacement' => array(68846)),array('code_point' => 68783,'type' => 1,'replacement' => array(68847)),array('code_point' => 68784,'type' => 1,'replacement' => array(68848)),array('code_point' => 68785,'type' => 1,'replacement' => array(68849)),array('code_point' => 68786,'type' => 1,'replacement' => array(68850)),array('code_point' => 71840,'type' => 1,'replacement' => array(71872)),array('code_point' => 71841,'type' => 1,'replacement' => array(71873)),array('code_point' => 71842,'type' => 1,'replacement' => array(71874)),array('code_point' => 71843,'type' => 1,'replacement' => array(71875)),array('code_point' => 71844,'type' => 1,'replacement' => array(71876)),array('code_point' => 71845,'type' => 1,'replacement' => array(71877)),array('code_point' => 71846,'type' => 1,'replacement' => array(71878)),array('code_point' => 71847,'type' => 1,'replacement' => array(71879)),array('code_point' => 71848,'type' => 1,'replacement' => array(71880)),array('code_point' => 71849,'type' => 1,'replacement' => array(71881)),array('code_point' => 71850,'type' => 1,'replacement' => array(71882)),array('code_point' => 71851,'type' => 1,'replacement' => array(71883)),array('code_point' => 71852,'type' => 1,'replacement' => array(71884)),array('code_point' => 71853,'type' => 1,'replacement' => array(71885)),array('code_point' => 71854,'type' => 1,'replacement' => array(71886)),array('code_point' => 71855,'type' => 1,'replacement' => array(71887)),array('code_point' => 71856,'type' => 1,'replacement' => array(71888)),array('code_point' => 71857,'type' => 1,'replacement' => array(71889)),array('code_point' => 71858,'type' => 1,'replacement' => array(71890)),array('code_point' => 71859,'type' => 1,'replacement' => array(71891)),array('code_point' => 71860,'type' => 1,'replacement' => array(71892)),array('code_point' => 71861,'type' => 1,'replacement' => array(71893)),array('code_point' => 71862,'type' => 1,'replacement' => array(71894)),array('code_point' => 71863,'type' => 1,'replacement' => array(71895)),array('code_point' => 71864,'type' => 1,'replacement' => array(71896)),array('code_point' => 71865,'type' => 1,'replacement' => array(71897)),array('code_point' => 71866,'type' => 1,'replacement' => array(71898)),array('code_point' => 71867,'type' => 1,'replacement' => array(71899)),array('code_point' => 71868,'type' => 1,'replacement' => array(71900)),array('code_point' => 71869,'type' => 1,'replacement' => array(71901)),array('code_point' => 71870,'type' => 1,'replacement' => array(71902)),array('code_point' => 71871,'type' => 1,'replacement' => array(71903)));
		
		
		private static function cfd_lower_bound ($cp) {
			
			$c=count(self::$cfd);
			$i=0;
			while ($c>0) {
				
				$step=intval($c/2);
				$curr=$i+$step;
				if (self::$cfd[$curr]['code_point']<$cp) {
					
					$i=$curr+1;
					$c-=$step+1;
					
				} else {
					
					$c=$step;
					
				}
				
			}
			
			return $i;
			
		}
		
		
		private static function cfd_search ($cp) {
			
			$c=count(self::$cfd);
			for ($i=self::cfd_lower_bound($cp);$i<$c;++$i) {
				
				$curr=self::$cfd[$i];
				if ($curr['code_point']===$cp) yield $curr;
				
			}
			
		}
		
		
		//	1	-	Common
		//	2	-	Simple
		//	4	-	Full
		//	8	-	Turkic
		private static function cfd_lookup ($cp, $type=4|1) {
			
			$retr=null;
			foreach (self::cfd_search($cp) as $data) {
				
				//	Establish whether or not this mapping
				//	is accepted
				$t=$data['type'];
				if (($t&$type)===0) continue;
				
				//	Establish whether or not the existing
				//	mapping is "better"
				if ($t<$retr['type']) continue;
				
				$retr=$data;
				
			}
			
			return is_null($retr) ? array($cp) : $retr['replacement'];
			
		}
		
		
		private static function transliterate ($id, $str) {
			
			return \Transliterator::create($id)->transliterate($str);
			
		}
		
		
		/**
		 *	Traverses the bytes of a string.
		 *
		 *	\param [in] $string
		 *		A string.
		 *
		 *	\return
		 *		A Traversable object which yields each
		 *		byte (or character) in \em string in turn
		 *		as an integer.
		 */
		public static function Characters ($string) {
			
			$string=(string)$string;
			$l=strlen($string);
			for ($i=0;$i<$l;++$i) yield ord($string[$i]);
			
		}
		
		
		/**
		 *	Traverses the code points of a string.
		 *
		 *	\param [in] $string
		 *		A string.
		 *
		 *	\return
		 *		A Traversable object which yields each
		 *		code point in \em string in turn as an
		 *		integer.
		 */
		public static function CodePoints ($string) {
			
			$cp=0;
			$i=0;
			foreach (self::Characters(self::ConvertTo($string,'UTF-32BE')) as $c) {
				
				$cp<<=8;
				$cp|=$c;
				if ((++$i)===4) {
					
					yield $cp;
					
					$i=0;
					$cp=0;
					
				}
				
			}
			
		}
		
		
		/**
		 *	Retrieves the UTF-8 encoding of a particular Unicode
		 *	code point.
		 *
		 *	The naming of this function is intended to be consistent
		 *	with the PHP built in function \em chr.
		 *
		 *	\param [in] $cp
		 *		The code point as an integer.
		 *
		 *	\return
		 *		A string containing the UTF-8 encoding of \em cp.
		 */
		public static function Character ($cp) {
			
			$str='';
			for ($i=0;$i<4;++$i) {
				
				$str.=chr($cp&255);
				$cp>>=8;
				
			}
			
			return self::ConvertFrom($str,'UTF-32LE');
			
		}
		
		
		/**
		 *	Performs case folding on a string.
		 *
		 *	\param [in] $string
		 *		A string.
		 *
		 *	\return
		 *		The result of applying case folding to
		 *		\em string.
		 */
		public static function ToCaseFold ($string) {
			
			$retr='';
			foreach (self::CodePoints($string) as $cp) foreach (self::cfd_lookup($cp) as $r) $retr.=self::Character($r);
			
			return $retr;
			
		}
	
	
		/**
		 *	Transforms a string to uppercase.
		 *
		 *	\param [in] $string
		 *		The string.
		 *
		 *	\return
		 *		\em string with all its characters
		 *		transformed to uppercase.
		 */
		public static function ToUpper ($string) {
			
			return self::transliterate('Any-Upper',$string);
		
		}
		
		
		/**
		 *	Transforms a string to lowercase.
		 *
		 *	\param [in] $string
		 *		The string.
		 *
		 *	\return
		 *		\em string with all its characters
		 *		transformed to lowercase.
		 */
		public static function ToLower ($string) {
			
			return self::transliterate('Any-Lower',$string);
		
		}
		
		
		/**
		 *	Transforms a string to titlecase.
		 *
		 *	\param [in] $string
		 *		The string.
		 *
		 *	\return
		 *		\em string with all its characters
		 *		transformed to titlecase.
		 */
		public static function ToTitle ($string) {
			
			return self::transliterate('Any-Title',$string);
			
		}
		
		
		/**
		 *	Normalizes a string to a certain Unicode
		 *	canonical form.
		 *
		 *	\param [in] $string
		 *		The string to normalize.
		 *	\param [in] $normal_form
		 *		A constant from the Normalizer class
		 *		specifying the normal form to use.
		 *		If not provided uses the Normalizer
		 *		class' default.
		 *
		 *	\return
		 *		The equivalent of \em string in the
		 *		specified normal form.
		 */
		public static function Normalize ($string, $normal_form=null) {
			
			return is_null($normal_form) ? \Normalizer::normalize($string) : \Normalizer::normalize($string,$normal_form);
		
		}
		
		
		/**
		 *	Tests to see if two strings are equivalent.
		 *
		 *	\param [in] $a
		 *		A string.
		 *	\param [in] $b
		 *		A string.
		 *
		 *	\return
		 *		\em true if \em a and \em b should be
		 *		treated as equal, \em false otherwise.
		 */
		public static function Equals ($a, $b, $ignore_case=false) {
		
			if ($ignore_case) {
			
				$a=self::ToCaseFold($a);
				$b=self::ToCaseFold($b);
			
			}
		
			$a=self::Normalize($a);
			$b=self::Normalize($b);
			
			return $a===$b;
		
		}
		
		
		/**
		 *	Fetches a callback which may be used to
		 *	compare two strings for equality.
		 *
		 *	\param [in] $ignore_case
		 *		If \em true the returned callback will
		 *		ignore case when comparing strings.
		 *		Defaults to \em false.
		 *
		 *	\return
		 *		A callback which accepts two arguments
		 *		and returns \em true if they're Unicode
		 *		equivalent, \em false otherwise.
		 */
		public static function GetComparer ($ignore_case=false) {
		
			return function ($a, $b) use ($ignore_case) {
			
				return self::Equals($a,$b,$ignore_case);
			
			};
		
		}
		
		
		/**
		 *	Determines the number of code points in
		 *	a string.
		 *
		 *	\param [in] $string
		 *		A string.
		 *
		 *	\return
		 *		The number of code points in \em string.
		 */
		public static function Length ($string) {
			
			$i=\IntlCodePointBreakIterator::createCodePointInstance();
			$i->setText($string);
			return iterator_count($i)-1;
		
		}
		
		
		private static function collator_raise (\Collator $c) {
			
			throw new \Exception($c->getErrorMessage(),$c->getErrorCode());
			
		}
		
		
		private static function collator_set (\Collator $c, $o, $v) {
			
			if (!$c->setAttribute($o,$v)) self::collator_raise($c);
			
		}
		
		
		/**
		 *	Compares two strings.
		 *
		 *	\param [in] $a
		 *		A string.
		 *	\param [in] $b
		 *		A string.
		 *	\param [in] $collation
		 *		A constant from the Collator class
		 *		specifying the Unicode collation to
		 *		use.  If not provided uses the
		 *		Collator class' default.
		 *
		 *	\return
		 *		A negative number if \em a less than \em b,
		 *		zero if \em a is ordered the same as \em b,
		 *		a positive number if \em a greater than \em b.
		 */
		public static function Compare ($a, $b, $collation=null) {
			
			$c=new \Collator($collation);
			
			self::collator_set($c,\Collator::NORMALIZATION_MODE,\Collator::ON);
			
			$retr=$c->compare($a,$b);
			if ($retr===false) self::collator_raise($c);
			
			return $retr;
		
		}
		
		
		/**
		 *	Compares two strings.
		 *
		 *	\param [in] $a
		 *		A string.
		 *	\param [in] $b
		 *		A string.
		 *	\param [in] $collation
		 *		A constant from the Collator class
		 *		specifying the Unicode collation to
		 *		use.  If not provided uses the
		 *		Collator class' default.
		 *
		 *	\return
		 *		\em true if \em a is greater than \em b,
		 *		\em false otherwise.
		 */
		public static function Greater ($a, $b, $collation=null) {
		
			return self::Compare($a,$b,$collation)>0;
		
		}
		
		
		/**
		 *	Compares two strings.
		 *
		 *	\param [in] $a
		 *		A string.
		 *	\param [in] $b
		 *		A string.
		 *	\param [in] $collation
		 *		A constant from the Collator class
		 *		specifying the Unicode collation to
		 *		use.  If not provided uses the
		 *		Collator class' default.
		 *
		 *	\return
		 *		\em true if \em a is less than \em b,
		 *		\em false otherwise.
		 */
		public static function Less ($a, $b, $collation=null) {
		
			return self::Compare($a,$b,$collation)<0;
		
		}
		
		
		/**
		 *	Compares two strings.
		 *
		 *	\param [in] $a
		 *		A string.
		 *	\param [in] $b
		 *		A string.
		 *	\param [in] $collation
		 *		A constant from the Collator class
		 *		specifying the Unicode collation to
		 *		use.  If not provided uses the
		 *		Collator class' default.
		 *
		 *	\return
		 *		\em true if \em a and \em b should be
		 *		ordered the same.  Note that this does
		 *		not imply that \em a and \em b are
		 *		equivalent.
		 */
		public static function OrderedSame ($a, $b, $collation=null) {
		
			return self::Compare($a,$b,$collation)===0;
		
		}
		
		
		/**
		 *	Compares two strings.
		 *
		 *	\param [in] $a
		 *		A string.
		 *	\param [in] $b
		 *		A string.
		 *	\param [in] $collation
		 *		A constant from the Collator class
		 *		specifying the Unicode collation to
		 *		use.  If not provided uses the
		 *		Collator class' default.
		 *
		 *	\return
		 *		\em true if \em a is greater than or
		 *		ordered the same as \em b.
		 */
		public static function GreaterOrEquals ($a, $b, $collation=null) {
		
			return self::Compare($a,$b,$collation)>=0;
		
		}
		
		
		/**
		 *	Compares two strings.
		 *
		 *	\param [in] $a
		 *		A string.
		 *	\param [in] $b
		 *		A string.
		 *	\param [in] $collation
		 *		A constant from the Collator class
		 *		specifying the Unicode collation to
		 *		use.  If not provided uses the
		 *		Collator class' default.
		 *
		 *	\return
		 *		\em true if \em a is less than or
		 *		ordered the same as \em b.
		 */
		public static function LessOrEquals ($a, $b, $collation=null) {
		
			return self::Compare($a,$b,$collation)<=0;
		
		}
		
		
		/**
		 *	Fetches a callback which may be passed
		 *	to usort and other such functions to
		 *	sort strings.
		 *
		 *	\param [in] $asc
		 *		Whether the return callback should
		 *		sort in ascending order or not.
		 *		Defaults to \em true.
		 *	\param [in] $collation
		 *		The collation to use.  Defaults to
		 * 		the default collation.
		 *
		 *	\return
		 *		A callback which orders strings as
		 *		specified.
		 */
		public static function GetSorter ($asc=true, $collation=null) {
		
			return function ($a, $b) use ($asc, $collation) {
			
				$val=self::Compare($a,$b,$collation);
				
				if (!$asc) $val*=-1;
				
				return $val;
			
			};
		
		}
		
		
		/**
		 *	Removes all whitespace from the beginning
		 *	and end of a string.
		 *
		 *	\param [in] $string
		 *		A string.
		 *
		 *	\return
		 *		\em string with all trailing and leading
		 *		whitespace removed.
		 */
		public static function Trim ($string) {
		
			return Regex::Replace(
				'/^\\s+|\\s+$/u',
				'',
				$string
			);
		
		}
		
		
		/**
		 *	Converts a string from one arbitrary encoding
		 *	to another arbitrary encoding.
		 *
		 *	\param [in] $string
		 *		The string to convert.  If this string is
		 *		not encoded as specified by \em from, the
		 *		behaviour of this function will be erratic.
		 *	\param [in] $to
		 *		The encoding to which to convert \em string.
		 *	\param [in] $from
		 *		The current encoding of \em string.
		 *
		 *	\return
		 *		\em string encoded with the encoding specified
		 *		by \em to.
		 */
		public static function Convert ($string, $to, $from) {
		
			if (function_exists('mb_convert_encoding')) return mb_convert_encoding(
				$string,
				$to,
				$from
			);
			
			throw new \Exception('mb_convert_encoding unavailable');
		
		}
		
		
		/**
		 *	Converts a string from UTF-8 to some other
		 *	encoding.
		 *
		 *	\param [in] $string
		 *		The string to convert.
		 *	\param [in] $encoding
		 *		The target encoding.
		 *
		 *	\return
		 *		\em string encoded with \em encoding.
		 */
		public static function ConvertTo ($string, $encoding) {
		
			return self::Convert($string,$encoding,'utf-8');
		
		}
		
		
		/**
		 *	Converts a string from an arbitrary encoding
		 *	to UTF-8.
		 *
		 *	\param [in] $string
		 *		The string to convert.  If this string
		 *		is not encoded as specified by \em encoding,
		 *		the behaviour of this function will be
		 *		erratic.
		 *	\param [in] $encoding
		 *		The current encoding of \em string.
		 *
		 *	\return
		 *		The UTF-8 encoding of \em string.
		 */
		public static function ConvertFrom ($string, $encoding) {
		
			return self::Convert($string,'utf-8',$encoding);
		
		}
	
	
	}


?>