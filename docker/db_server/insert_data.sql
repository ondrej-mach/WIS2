-- PHP compatible password can be obtained like this:
-- echo admin | openssl passwd -stdin
INSERT INTO Account (accountID, accountUsername, accountPassword, accountDateOfBirth, accountEmail, accountAdmin) 
VALUES (1, 'admin', '$1$1.EjW9LX$AAMfewO1RVCKyDyHAiQQ30', "2020/1/1", "admin@fit.vutbr.cz", true);

-- login dvorak, heslo teacher
INSERT INTO Account (accountID, accountUsername, accountRealName, accountPassword, accountDateOfBirth, accountEmail, accountTeacher) 
VALUES (2, 'dvorak', 'Jaroslav Dvořák', '$1$fizRusmT$KJ9kwwjzp8ATnmSBMq4o4.', "1979/4/6", "dvorak@fit.vutbr.cz", true);

-- login xnovak00, heslo student
INSERT INTO Account (accountID, accountUsername, accountPassword, accountDateOfBirth, accountEmail, accountStudent) 
VALUES (3, 'xnovak00', '$1$J2b.7qT3$C6m3z10By7kfob8Ikx0N10', "1985/8/12", "xnovak00@fit.vutbr.cz", true);

-- login cerna, heslo teacher
INSERT INTO Account (accountID, accountUsername, accountRealName, accountPassword, accountDateOfBirth, accountEmail, accountTeacher) 
VALUES (4, 'cerna', 'Jana Černá', '$1$fizRusmT$KJ9kwwjzp8ATnmSBMq4o4.', "1999/4/4", "cernaj@seznam.cz", true);

-- login havel, heslo teacher
INSERT INTO Account (accountID, accountUsername, accountRealName, accountPassword, accountDateOfBirth, accountEmail, accountTeacher) 
VALUES (5, 'havel', 'Miroslav Havel', '$1$fizRusmT$KJ9kwwjzp8ATnmSBMq4o4.', "2003/6/6", "havelmira@gmail.com", true);

-- login xnovot13, heslo student
INSERT INTO Account (accountID, accountUsername, accountPassword, accountDateOfBirth, accountEmail, accountStudent) 
VALUES (6, 'xnovot13', '$1$J2b.7qT3$C6m3z10By7kfob8Ikx0N10', "2001/7/12", "xnovot13@fit.vutbr.cz", true);

-- login xfitko12, heslo student
INSERT INTO Account (accountID, accountUsername, accountPassword, accountDateOfBirth, accountEmail, accountStudent) 
VALUES (7, 'xfitko12', '$1$J2b.7qT3$C6m3z10By7kfob8Ikx0N10', "2003/5/8", "xfitko@fit.vutbr.cz", true);


-- IIS course
INSERT INTO Course (courseID, courseName, courseFullName, courseDescription, courseState, courseCredits, courseCapacity, courseOpen)
VALUES (1, 'IIS', 'Information systems', 'This course will teach student the secrets of universe', 10, 4, 500, true);

-- IMA1 course
INSERT INTO Course (courseID, courseName, courseFullName, courseDescription, courseState, courseCredits, courseCapacity, courseOpen)
VALUES (2, 'IMA1', 'Mathematical Analysis', 'math stuff, integrals, ...', 10, 5, 600, false);

-- IMA1 course
INSERT INTO Course (courseID, courseName, courseFullName, courseDescription, courseState, courseCredits, courseCapacity, courseOpen)
VALUES (3, 'ISU', 'Assemblers', 'assemblers x86', 10, 7, 700, true);

-- guarantors for courses
INSERT INTO Guarantees (accountID, courseID) VALUES (2, 1);
INSERT INTO Guarantees (accountID, courseID) VALUES (4, 2);
INSERT INTO Guarantees (accountID, courseID) VALUES (5, 3);

-- teachers for courses
INSERT INTO Lecturer (accountID, courseID) VALUES (2, 1);
INSERT INTO Lecturer (accountID, courseID) VALUES (4, 1);
INSERT INTO Lecturer (accountID, courseID) VALUES (4, 3);
INSERT INTO Lecturer (accountID, courseID) VALUES (5, 1);
INSERT INTO Lecturer (accountID, courseID) VALUES (5, 2);
INSERT INTO Lecturer (accountID, courseID) VALUES (5, 3);

-- D105 room
INSERT INTO Room (roomID, roomName, roomDescription) 
VALUES (1, 'D105', 'Big lecture room');

-- E112 room
INSERT INTO Room (roomID, roomName, roomDescription)
VALUES (2, 'E112', 'Small lecture room');

INSERT INTO Lecture (courseID, roomID) VALUES (1, 2);
INSERT INTO Lecture (courseID, roomID) VALUES (2, 1);

-- terms for the 2 courses
INSERT INTO Term (termID, courseID, termName, termDate, termMaxPoints, termAutoregistered) 
VALUES (1, 2, 'Půlsemestrální zkouška', '2022/11/02', '15', true);
INSERT INTO Term (termID, courseID, termName, termDate, termMaxPoints, termAutoregistered) 
VALUES (2, 1, 'Zápočet', '2022/12/17', '0', true);
INSERT INTO Term (termID, courseID, termName, termDate, termMaxPoints) 
VALUES (3, 2, 'Bonusový úkol', '2022/10/1', '2');

-- student signed up for term
INSERT INTO SignedUp (studentID, termID) VALUES (3, 1);
INSERT INTO SignedUp (studentID, termID) VALUES (6, 2);
INSERT INTO SignedUp (studentID, termID) VALUES (3, 2);

-- student attends course
INSERT INTO Attends (accountID, courseID, approved) VALUES (3, 1, true);
INSERT INTO Attends (accountID, courseID, approved) VALUES (3, 2, true);
INSERT INTO Attends (accountID, courseID, approved) VALUES (6, 1, true);
INSERT INTO Attends (accountID, courseID, approved) VALUES (6, 3, true);
INSERT INTO Attends (accountID, courseID, approved) VALUES (7, 1, true);
INSERT INTO Attends (accountID, courseID, approved) VALUES (7, 2, false);
INSERT INTO Attends (accountID, courseID, approved) VALUES (7, 3, true);