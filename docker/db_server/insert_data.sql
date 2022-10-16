-- PHP compatible password can be obtained like this:
-- echo admin | openssl passwd -stdin
INSERT INTO Account (accountUsername, accountPassword, accountAdmin) 
VALUES ('admin', '$1$1.EjW9LX$AAMfewO1RVCKyDyHAiQQ30', true);

-- login dvorak, heslo teacher
INSERT INTO Account (accountUsername, accountPassword, accountTeacher) 
VALUES ('dvorak', '$1$fizRusmT$KJ9kwwjzp8ATnmSBMq4o4.', true);

-- login xnovak00, heslo student
INSERT INTO Account (accountUsername, accountPassword, accountStudent) 
VALUES ('xnovak00', '$1$J2b.7qT3$C6m3z10By7kfob8Ikx0N10', true);

INSERT INTO Room (roomName, roomDescription) 
VALUES ('D105', 'Big lecture room');

INSERT INTO Room (roomName, roomDescription) 
VALUES ('E105', 'Small lecture room');


INSERT INTO Course (courseName, courseFullName, courseDescription) 
VALUES ('IIS', 'Information systems', 'This course will teach student the secrets of universe', 10);
