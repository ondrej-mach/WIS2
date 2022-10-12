-- PHP compatible password can be obtained like this:
-- echo admin | openssl passwd -stdin
INSERT INTO Account (accountUsername, accountPassword) 
VALUES ('admin', '$1$1.EjW9LX$AAMfewO1RVCKyDyHAiQQ30');
INSERT INTO Admin 
VALUES ((SELECT accountID FROM Account WHERE accountUsername='admin'));
