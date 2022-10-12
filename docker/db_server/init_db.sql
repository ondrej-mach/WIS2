-- Table for all accounts including admin
CREATE TABLE Account (
    accountID INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL,
    accountUsername VARCHAR(128) NOT NULL UNIQUE,
    accountPassword VARCHAR(128) NOT NULL,
    accountRealName VARCHAR(128),
    accountAddress VARCHAR(128),
    accountDateOfBirth DATE,
    accountEmail VARCHAR(128)
);

CREATE TABLE Login (
    accountID INTEGER NOT NULL,
    sessionID VARCHAR(128),
    timeout INTEGER,  -- UNIX timestamp when login will be invalidated
    FOREIGN KEY (accountID) REFERENCES Account(accountID)
);


CREATE TABLE Admin (
    accountID INTEGER NOT NULL,
    FOREIGN KEY (accountID) REFERENCES Account(accountID)
);

