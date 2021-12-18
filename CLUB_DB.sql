SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS lesson_register;
DROP TABLE IF EXISTS locker_register;
DROP TABLE IF EXISTS register;
DROP TABLE IF EXISTS teacher_info;
DROP TABLE IF EXISTS locker;
DROP TABLE IF EXISTS customer_info;
DROP TABLE IF EXISTS check_in;
SET FOREIGN_KEY_CHECKS = 1;

CREATE TABLE customer_info(
	ID INT AUTO_INCREMENT,
	name varchar(10) NOT NULL,
	mobile varchar(13) NOT NULL,
	sex char(1) NOT NULL DEFAULT 'M',
	dob DATE,
	address varchar(100) DEFAULT '-',
	note varchar(500) DEFAULT '-',
	CONSTRAINT PK_customer PRIMARY KEY (ID)
);

CREATE TABLE locker(
	lockerID INT NOT NULL,
	CONSTRAINT PK_locker PRIMARY KEY (lockerID)
);

CREATE TABLE teacher_info(
	teacherID INT AUTO_INCREMENT,
	name varchar(10) NOT NULL,
	mobile varchar(13) NOT NULL,
	dob DATE NOT NULL,
	address varchar(100) NOT NULL,
	note varchar(500) DEFAULT '-',
	CONSTRAINT PK_teacher PRIMARY KEY (teacherID)
);

CREATE TABLE register(
	customerID INT NOT NULL,
	registered DATE NOT NULL,
	how_long INT NOT NULL,
	CONSTRAINT PK_register PRIMARY KEY (customerID, registered),
	CONSTRAINT FK_register FOREIGN KEY(customerID) REFERENCES customer_info(ID) ON DELETE CASCADE
);

CREATE TABLE locker_register(
	customerID INT NOT NULL,
	lockerID INT NOT NULL,
	registered DATE NOT NULL,
	how_long INT NOT NULL,
	CONSTRAINT PK_lockerR PRIMARY KEY (lockerID, registered),
	CONSTRAINT FK_lockerR1 FOREIGN KEY(customerID) REFERENCES customer_info(ID) ON DELETE CASCADE,
	CONSTRAINT FK_lockerR2 FOREIGN KEY(lockerID) REFERENCES locker(lockerID)
);

CREATE TABLE lesson_register(
	customerID INT NOT NULL,
	teacherID INT NOT NULL,
	registered DATE NOT NULL,
	how_long INT NOT NULL,
	CONSTRAINT PK_lessonR PRIMARY KEY (customerID, registered),
	CONSTRAINT FK_lessonR1 FOREIGN KEY (customerID) REFERENCES customer_info(ID) ON DELETE CASCADE,
	CONSTRAINT FK_lessonR2 FOREIGN KEY (teacherID) REFERENCES teacher_info(teacherID)
);

CREATE TABLE check_in(
	customerID INT NOT NULL,
	checkinDate DATE NOT NULL,
	checkinTime TIME NOT NULL,
	CONSTRAINT PK_checkin PRIMARY KEY (customerID, checkinDate)
);

INSERT INTO customer_info
	(ID, name, mobile , address, note)
VALUES
	(1000, '@ADMIN', '-', '-', '절대 지우지 마세요');

INSERT INTO locker
	(lockerID)
VALUES
	(101), (102), (103), (104), (105), (106), (107), (108), (109), (110), (111), (112), (113), (114), (115), (116), (117), (118), (119), (120), (121), (122), (123), (124), (125), (126), (127), (128), (129), (130), (131), (132), (133), (134), (135), (136), (137), (138), (139), (140), (141), (142), (143), (144), (145), (146), (147), (148), (149), (150), (151), (152), (153), (154), (155), (156), (157), (158), (159), (160), (161), (162), (163), (164), (165), (166), (167), (168), (169), (170), (171), (172), (173), (174), (175), (176), (177), (178), (179), (180), (181), (182), (183), (184), (185), (186), (187), (188), (189), (190), (191), (192), (193), (194), (195), (196), (197), (198), (199), (200), (201), (202), (203), (204), (205), (206), (207), (208), (209), (210), (211), (212), (213), (214), (215), (216), (217), (218), (219), (220), (221), (222), (223), (224), (225), (226), (227), (228), (229), (230), (231), (232), (233), (234), (235), (236), (237), (238), (239), (240), (241), (242), (243), (244), (245), (246), (247), (248), (249), (250), (251), (252), (253), (254), (255), (256), (257), (258), (259), (260), (261), (262), (263), (264), (265), (266), (267), (268), (269), (270), (271), (272), (273), (274), (275), (276), (277), (278), (279), (280), (281), (282), (283), (284), (285), (286), (287), (288), (289), (290), (291), (292), (293), (294), (295), (296), (297), (298), (299), (300), (301), (302), (303), (304), (305), (306), (307), (308), (309), (310), (311), (312), (313), (314), (315), (316), (317), (318), (319), (320);

INSERT INTO locker_register
VALUES
	(1000, 101, '2000-01-01', 1), (1000, 102, '2000-01-01', 1), (1000, 103, '2000-01-01', 1), (1000, 104, '2000-01-01', 1), (1000, 105, '2000-01-01', 1), (1000, 106, '2000-01-01', 1), (1000, 107, '2000-01-01', 1), (1000, 108, '2000-01-01', 1), (1000, 109, '2000-01-01', 1), (1000, 110, '2000-01-01', 1), (1000, 111, '2000-01-01', 1), (1000, 112, '2000-01-01', 1), (1000, 113, '2000-01-01', 1), (1000, 114, '2000-01-01', 1), (1000, 115, '2000-01-01', 1), (1000, 116, '2000-01-01', 1), (1000, 117, '2000-01-01', 1), (1000, 118, '2000-01-01', 1), (1000, 119, '2000-01-01', 1), (1000, 120, '2000-01-01', 1), (1000, 121, '2000-01-01', 1), (1000, 122, '2000-01-01', 1), (1000, 123, '2000-01-01', 1), (1000, 124, '2000-01-01', 1), (1000, 125, '2000-01-01', 1), (1000, 126, '2000-01-01', 1), (1000, 127, '2000-01-01', 1), (1000, 128, '2000-01-01', 1), (1000, 129, '2000-01-01', 1), (1000, 130, '2000-01-01', 1), (1000, 131, '2000-01-01', 1), (1000, 132, '2000-01-01', 1), (1000, 133, '2000-01-01', 1), (1000, 134, '2000-01-01', 1), (1000, 135, '2000-01-01', 1), (1000, 136, '2000-01-01', 1), (1000, 137, '2000-01-01', 1), (1000, 138, '2000-01-01', 1), (1000, 139, '2000-01-01', 1), (1000, 140, '2000-01-01', 1), (1000, 141, '2000-01-01', 1), (1000, 142, '2000-01-01', 1), (1000, 143, '2000-01-01', 1), (1000, 144, '2000-01-01', 1), (1000, 145, '2000-01-01', 1), (1000, 146, '2000-01-01', 1), (1000, 147, '2000-01-01', 1), (1000, 148, '2000-01-01', 1), (1000, 149, '2000-01-01', 1), (1000, 150, '2000-01-01', 1), (1000, 151, '2000-01-01', 1), (1000, 152, '2000-01-01', 1), (1000, 153, '2000-01-01', 1), (1000, 154, '2000-01-01', 1), (1000, 155, '2000-01-01', 1), (1000, 156, '2000-01-01', 1), (1000, 157, '2000-01-01', 1), (1000, 158, '2000-01-01', 1), (1000, 159, '2000-01-01', 1), (1000, 160, '2000-01-01', 1), (1000, 161, '2000-01-01', 1), (1000, 162, '2000-01-01', 1), (1000, 163, '2000-01-01', 1), (1000, 164, '2000-01-01', 1), (1000, 165, '2000-01-01', 1), (1000, 166, '2000-01-01', 1), (1000, 167, '2000-01-01', 1), (1000, 168, '2000-01-01', 1), (1000, 169, '2000-01-01', 1), (1000, 170, '2000-01-01', 1), (1000, 171, '2000-01-01', 1), (1000, 172, '2000-01-01', 1), (1000, 173, '2000-01-01', 1), (1000, 174, '2000-01-01', 1), (1000, 175, '2000-01-01', 1), (1000, 176, '2000-01-01', 1), (1000, 177, '2000-01-01', 1), (1000, 178, '2000-01-01', 1), (1000, 179, '2000-01-01', 1), (1000, 180, '2000-01-01', 1), (1000, 181, '2000-01-01', 1), (1000, 182, '2000-01-01', 1), (1000, 183, '2000-01-01', 1), (1000, 184, '2000-01-01', 1), (1000, 185, '2000-01-01', 1), (1000, 186, '2000-01-01', 1), (1000, 187, '2000-01-01', 1), (1000, 188, '2000-01-01', 1), (1000, 189, '2000-01-01', 1), (1000, 190, '2000-01-01', 1), (1000, 191, '2000-01-01', 1), (1000, 192, '2000-01-01', 1), (1000, 193, '2000-01-01', 1), (1000, 194, '2000-01-01', 1), (1000, 195, '2000-01-01', 1), (1000, 196, '2000-01-01', 1), (1000, 197, '2000-01-01', 1), (1000, 198, '2000-01-01', 1), (1000, 199, '2000-01-01', 1), (1000, 200, '2000-01-01', 1), (1000, 201, '2000-01-01', 1), (1000, 202, '2000-01-01', 1), (1000, 203, '2000-01-01', 1), (1000, 204, '2000-01-01', 1), (1000, 205, '2000-01-01', 1), (1000, 206, '2000-01-01', 1), (1000, 207, '2000-01-01', 1), (1000, 208, '2000-01-01', 1), (1000, 209, '2000-01-01', 1), (1000, 210, '2000-01-01', 1), (1000, 211, '2000-01-01', 1), (1000, 212, '2000-01-01', 1), (1000, 213, '2000-01-01', 1), (1000, 214, '2000-01-01', 1), (1000, 215, '2000-01-01', 1), (1000, 216, '2000-01-01', 1), (1000, 217, '2000-01-01', 1), (1000, 218, '2000-01-01', 1), (1000, 219, '2000-01-01', 1), (1000, 220, '2000-01-01', 1), (1000, 221, '2000-01-01', 1), (1000, 222, '2000-01-01', 1), (1000, 223, '2000-01-01', 1), (1000, 224, '2000-01-01', 1), (1000, 225, '2000-01-01', 1), (1000, 226, '2000-01-01', 1), (1000, 227, '2000-01-01', 1), (1000, 228, '2000-01-01', 1), (1000, 229, '2000-01-01', 1), (1000, 230, '2000-01-01', 1), (1000, 231, '2000-01-01', 1), (1000, 232, '2000-01-01', 1), (1000, 233, '2000-01-01', 1), (1000, 234, '2000-01-01', 1), (1000, 235, '2000-01-01', 1), (1000, 236, '2000-01-01', 1), (1000, 237, '2000-01-01', 1), (1000, 238, '2000-01-01', 1), (1000, 239, '2000-01-01', 1), (1000, 240, '2000-01-01', 1), (1000, 241, '2000-01-01', 1), (1000, 242, '2000-01-01', 1), (1000, 243, '2000-01-01', 1), (1000, 244, '2000-01-01', 1), (1000, 245, '2000-01-01', 1), (1000, 246, '2000-01-01', 1), (1000, 247, '2000-01-01', 1), (1000, 248, '2000-01-01', 1), (1000, 249, '2000-01-01', 1), (1000, 250, '2000-01-01', 1), (1000, 251, '2000-01-01', 1), (1000, 252, '2000-01-01', 1), (1000, 253, '2000-01-01', 1), (1000, 254, '2000-01-01', 1), (1000, 255, '2000-01-01', 1), (1000, 256, '2000-01-01', 1), (1000, 257, '2000-01-01', 1), (1000, 258, '2000-01-01', 1), (1000, 259, '2000-01-01', 1), (1000, 260, '2000-01-01', 1), (1000, 261, '2000-01-01', 1), (1000, 262, '2000-01-01', 1), (1000, 263, '2000-01-01', 1), (1000, 264, '2000-01-01', 1), (1000, 265, '2000-01-01', 1), (1000, 266, '2000-01-01', 1), (1000, 267, '2000-01-01', 1), (1000, 268, '2000-01-01', 1), (1000, 269, '2000-01-01', 1), (1000, 270, '2000-01-01', 1), (1000, 271, '2000-01-01', 1), (1000, 272, '2000-01-01', 1), (1000, 273, '2000-01-01', 1), (1000, 274, '2000-01-01', 1), (1000, 275, '2000-01-01', 1), (1000, 276, '2000-01-01', 1), (1000, 277, '2000-01-01', 1), (1000, 278, '2000-01-01', 1), (1000, 279, '2000-01-01', 1), (1000, 280, '2000-01-01', 1), (1000, 281, '2000-01-01', 1), (1000, 282, '2000-01-01', 1), (1000, 283, '2000-01-01', 1), (1000, 284, '2000-01-01', 1), (1000, 285, '2000-01-01', 1), (1000, 286, '2000-01-01', 1), (1000, 287, '2000-01-01', 1), (1000, 288, '2000-01-01', 1), (1000, 289, '2000-01-01', 1), (1000, 290, '2000-01-01', 1), (1000, 291, '2000-01-01', 1), (1000, 292, '2000-01-01', 1), (1000, 293, '2000-01-01', 1), (1000, 294, '2000-01-01', 1), (1000, 295, '2000-01-01', 1), (1000, 296, '2000-01-01', 1), (1000, 297, '2000-01-01', 1), (1000, 298, '2000-01-01', 1), (1000, 299, '2000-01-01', 1), (1000, 300, '2000-01-01', 1), (1000, 301, '2000-01-01', 1), (1000, 302, '2000-01-01', 1), (1000, 303, '2000-01-01', 1), (1000, 304, '2000-01-01', 1), (1000, 305, '2000-01-01', 1), (1000, 306, '2000-01-01', 1), (1000, 307, '2000-01-01', 1), (1000, 308, '2000-01-01', 1), (1000, 309, '2000-01-01', 1), (1000, 310, '2000-01-01', 1), (1000, 311, '2000-01-01', 1), (1000, 312, '2000-01-01', 1), (1000, 313, '2000-01-01', 1), (1000, 314, '2000-01-01', 1), (1000, 315, '2000-01-01', 1), (1000, 316, '2000-01-01', 1), (1000, 317, '2000-01-01', 1), (1000, 318, '2000-01-01', 1), (1000, 319, '2000-01-01', 1), (1000, 320, '2000-01-01', 1);


/*
UPDATEs
*/
ALTER TABLE customer_info
ADD COLUMN car VARCHAR(15) DEFAULT '-' AFTER mobile;
