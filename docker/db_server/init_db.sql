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
    courseState INTEGER NOT NULL
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
    FOREIGN KEY (accountID) REFERENCES Account(accountID)
);

CREATE TABLE Lecture (
    courseID INTEGER NOT NULL,
    roomID INTEGER,
    lectureFrom DATE,
    lectureTo DATE,
    FOREIGN KEY (courseID) REFERENCES Course(courseID),
    FOREIGN KEY (roomID) REFERENCES Room(roomID)
);

CREATE TABLE Lector (
    accountID INTEGER NOT NULL,
    courseID INTEGER NOT NULL,
    FOREIGN KEY (accountID) REFERENCES Account(accountID),
    FOREIGN KEY (courseID) REFERENCES Course(courseID)
);

CREATE TABLE Term (
    courseID INTEGER NOT NULL,
    termID INTEGER PRIMARY KEY NOT NULL,
    termName VARCHAR(128),
    termDate DATE,
    termMaxPoints INTEGER,
    termAutoregistered BOOLEAN,
    FOREIGN KEY (courseID) REFERENCES Course(courseID)
);

CREATE TABLE Points (
    termID INTEGER,
    accountID INTEGER,
    termName VARCHAR(128),
    termDate DATE,
    termMaxPoints INTEGER,
    FOREIGN KEY (termID) REFERENCES Term(termID)
);
