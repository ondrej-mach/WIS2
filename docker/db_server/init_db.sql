-- Table for all accounts including admin
CREATE TABLE Account (
    accountID INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL,
    accountUsername VARCHAR(128) NOT NULL UNIQUE,
    accountPassword VARCHAR(128),
    accountRealName VARCHAR(128),
    accountAddress VARCHAR(128),
    accountDateOfBirth DATE,
    accountEmail VARCHAR(128),
    accountTeacher BOOLEAN,
    accountStudent BOOLEAN,
    accountAdmin BOOLEAN
);

CREATE TABLE Login (
    accountID INTEGER NOT NULL,
    sessionID VARCHAR(128),
    timeout INTEGER,  -- UNIX timestamp when login will be invalidated
    FOREIGN KEY (accountID) REFERENCES Account(accountID)
);


CREATE TABLE Room (
    roomID INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
    roomName VARCHAR(128) NOT NULL UNIQUE,
    roomDescription VARCHAR(128)
);


CREATE TABLE Course (
    courseID INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
    courseName VARCHAR(128) UNIQUE NOT NULL,
    courseFullName VARCHAR(128),
    courseDescription TEXT,
    courseState INTEGER NOT NULL,
    courseCredits INTEGER,
    courseCapacity INTEGER
);

CREATE TABLE Guarantees (
    accountID INTEGER NOT NULL,
    courseID INTEGER UNIQUE NOT NULL,
    approved BOOLEAN,
    FOREIGN KEY (accountID) REFERENCES Account(accountID),
    FOREIGN KEY (courseID) REFERENCES Course(courseID)
);

CREATE TABLE Attends (
    accountID INTEGER NOT NULL,
    courseID INTEGER NOT NULL,
    approved BOOLEAN,
    FOREIGN KEY (accountID) REFERENCES Account(accountID),
    FOREIGN KEY (courseID) REFERENCES Course(courseID)
);

CREATE TABLE Lecture (
    courseID INTEGER NOT NULL,
    roomID INTEGER,
    lectureFrom DATE,
    lectureTo DATE,
    FOREIGN KEY (courseID) REFERENCES Course(courseID),
    FOREIGN KEY (roomID) REFERENCES Room(roomID)
);

CREATE TABLE Lecturer (
    accountID INTEGER NOT NULL,
    courseID INTEGER NOT NULL,
    FOREIGN KEY (accountID) REFERENCES Account(accountID),
    FOREIGN KEY (courseID) REFERENCES Course(courseID)
);

CREATE TABLE Term (
    termID INTEGER PRIMARY KEY NOT NULL AUTO_INCREMENT,
    courseID INTEGER NOT NULL,
    termName VARCHAR(128),
    termDate DATE,
    termMaxPoints INTEGER,
    termAutoregistered BOOLEAN DEFAULT false,
    FOREIGN KEY (courseID) REFERENCES Course(courseID)
);

CREATE TABLE SignedUp (
    termID INTEGER,
    studentID INTEGER,
    lecturerID INTEGER, -- last changed by
    points INTEGER,
    FOREIGN KEY (termID) REFERENCES Term(termID),
    FOREIGN KEY (studentID) REFERENCES Account(accountID),
    FOREIGN KEY (lecturerID) REFERENCES Account(accountID)
);
