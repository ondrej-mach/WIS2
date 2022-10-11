-- Table for all accounts including admin
CREATE TABLE Account (
    accountID INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL,
    accountUsername VARCHAR(128) NOT NULL UNIQUE,
    accountPassword VARCHAR(128) NOT NULL,
    accountRealName VARCHAR(128),
    accountAddress VARCHAR(128),
    accountDateOfBirth DATE,
    accountEmail VARCHAR(50)
);

CREATE TABLE Admin (
    accountID INTEGER NOT NULL,
    FOREIGN KEY (accountID) REFERENCES Account(accountID)
);

