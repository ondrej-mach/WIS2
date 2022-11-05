-- PHP compatible password can be obtained like this:
-- echo admin | openssl passwd -stdin
INSERT INTO Account (accountID, accountUsername, accountPassword, accountAdmin) 
VALUES (1, 'admin', '$1$1.EjW9LX$AAMfewO1RVCKyDyHAiQQ30', true);

-- login dvorak, heslo teacher
INSERT INTO Account (accountID, accountUsername, accountRealName, accountPassword, accountTeacher) 
VALUES (2, 'dvorak', 'Jaroslav Dvořák', '$1$fizRusmT$KJ9kwwjzp8ATnmSBMq4o4.', true);

-- login xnovak00, heslo student
INSERT INTO Account (accountID, accountUsername, accountPassword, accountStudent) 
VALUES (3, 'xnovak00', '$1$J2b.7qT3$C6m3z10By7kfob8Ikx0N10', true);

-- login cerna, heslo teacher
INSERT INTO Account (accountID, accountUsername, accountRealName, accountPassword, accountTeacher) 
VALUES (4, 'cerna', 'Jana Černá', '$1$fizRusmT$KJ9kwwjzp8ATnmSBMq4o4.', true);

-- login havel, heslo teacher
INSERT INTO Account (accountID, accountUsername, accountRealName, accountPassword, accountTeacher) 
VALUES (5, 'havel', 'Miroslav Havel', '$1$fizRusmT$KJ9kwwjzp8ATnmSBMq4o4.', true);




INSERT INTO Room (roomName, roomDescription) 
VALUES ('D105', 'Big lecture room');

INSERT INTO Room (roomName, roomDescription) 
VALUES ('E105', 'Small lecture room');

-- IIS course
INSERT INTO Course (courseID, courseName, courseFullName, courseDescription, courseState, courseCredits, courseCapacity)
VALUES (1, 'IIS', 'Information systems', 'This course will teach student the secrets of universe', 10, 4, 500);

INSERT INTO Guarantees (accountID, courseID) VALUES (2, 1);
INSERT INTO Lecturer (accountID, courseID) VALUES (4, 1);
INSERT INTO Lecturer (accountID, courseID) VALUES (5, 1);

-- IMA course
INSERT INTO Course (courseID, courseName, courseFullName, courseDescription, courseState, courseCredits, courseCapacity)
VALUES (2, 'IMA', 'Mathematical Analysis', 'math stuff, integrals, ...', 10, 5, 600);

INSERT INTO Guarantees (accountID, courseID) VALUES (4, 2);
INSERT INTO Lecturer (accountID, courseID) VALUES (5, 2);

INSERT INTO Term (courseID, termName, termDate, termMaxPoints, termAutoregistered) VALUES (2, 'Půlsemestrální zkouška', '2022-11-02', '15', true);


