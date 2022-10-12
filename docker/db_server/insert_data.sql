-- PHP compatible password can be obtained like this:
-- echo admin | openssl passwd -stdin
INSERT INTO Account (accountUsername, accountPassword, accountAdmin) 
VALUES ('admin', '$1$1.EjW9LX$AAMfewO1RVCKyDyHAiQQ30', true);

