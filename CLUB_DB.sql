SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS Lesson_Register;
DROP TABLE IF EXISTS Locker_Register;
DROP TABLE IF EXISTS Register;
DROP TABLE IF EXISTS Teacher_Info;
DROP TABLE IF EXISTS Locker;
DROP TABLE IF EXISTS Customer_Info;
SET FOREIGN_KEY_CHECKS = 1;

CREATE TABLE Customer_Info(
	ID INT AUTO_INCREMENT,
	name varchar(10) NOT NULL,
	mobile varchar(13) NOT NULL,
	dob DATE NOT NULL,
	address varchar(100) NOT NULL,
	note varchar(500) DEFAULT '-',
	CONSTRAINT PK_Customer PRIMARY KEY (ID)
);

CREATE TABLE Locker(
	lockerID INT NOT NULL,
	occupied CHAR(0) DEFAULT NULL,
	CONSTRAINT PK_Locker PRIMARY KEY (lockerID)
);

CREATE TABLE Teacher_Info(
	teacherID INT AUTO_INCREMENT,
	name varchar(10) NOT NULL,
	mobile varchar(13) NOT NULL,
	dob DATE NOT NULL,
	address varchar(100) NOT NULL,
	note varchar(500) DEFAULT '-',
	CONSTRAINT PK_Teacher PRIMARY KEY (teacherID)
);

CREATE TABLE Register(
	customerID INT NOT NULL,
	registered DATE NOT NULL,
	how_long INT NOT NULL,
	CONSTRAINT PK_Register PRIMARY KEY (customerID, registered),
	CONSTRAINT FK_Register FOREIGN KEY(customerID) REFERENCES Customer_Info(ID) ON DELETE CASCADE
);

CREATE TABLE Locker_Register(
	customerID INT NOT NULL,
	lockerID INT NOT NULL,
	registered DATE NOT NULL,
	how_long INT NOT NULL,
	CONSTRAINT PK_LockerR PRIMARY KEY (lockerID, registered),
	CONSTRAINT FK_LockerR1 FOREIGN KEY(customerID) REFERENCES Customer_Info(ID) ON DELETE CASCADE,
	CONSTRAINT FK_LockerR2 FOREIGN KEY(lockerID) REFERENCES Locker(lockerID)
);

CREATE TABLE Lesson_Register(
	customerID INT NOT NULL,
	teacherID INT NOT NULL,
	registered DATE NOT NULL,
	how_long INT NOT NULL,
	CONSTRAINT PK_LessonR PRIMARY KEY (customerID, registered),
	CONSTRAINT FK_LessonR1 FOREIGN KEY (customerID) REFERENCES Customer_Info(ID) ON DELETE CASCADE,
	CONSTRAINT FK_LessonR2 FOREIGN KEY (teacherID) REFERENCES Teacher_Info(teacherID)
);