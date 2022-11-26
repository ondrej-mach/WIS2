-- PHP compatible password can be obtained like this:
-- echo admin | openssl passwd -stdin
INSERT INTO Account (accountID, accountUsername, accountPassword, accountDateOfBirth, accountEmail, accountAdmin) 
VALUES (1, 'admin', '$1$1.EjW9LX$AAMfewO1RVCKyDyHAiQQ30', "2020/1/1", "admin@fit.vutbr.cz", true);

-- login dvorak, heslo teacher
INSERT INTO Account (accountID, accountUsername, accountRealName, accountAddress, accountPassword, accountDateOfBirth, accountEmail, accountTeacher) 
VALUES (2, 'dvorak', 'Jaroslav Dvořák', 'Masarykovo nam., Brno','$1$fizRusmT$KJ9kwwjzp8ATnmSBMq4o4.', "1979/4/6", "dvorak@fit.vutbr.cz", true);

-- login xnovak00, heslo student
INSERT INTO Account (accountID, accountUsername, accountRealName, accountAddress, accountPassword, accountDateOfBirth, accountEmail, accountStudent) 
VALUES (3, 'xnovak00', 'Jan Novak', 'Vaclavske nam., Praha 1', '$1$J2b.7qT3$C6m3z10By7kfob8Ikx0N10', "1985/8/12", "xnovak00@fit.vutbr.cz", true);

-- login cerna, heslo teacher
INSERT INTO Account (accountID, accountUsername, accountRealName, accountPassword, accountDateOfBirth, accountEmail, accountTeacher) 
VALUES (4, 'cerna', 'Jana Černá', '$1$fizRusmT$KJ9kwwjzp8ATnmSBMq4o4.', "1999/4/4", "cernaj@seznam.cz", true);

-- login havel, heslo teacher
INSERT INTO Account (accountID, accountUsername, accountRealName, accountAddress, accountPassword, accountDateOfBirth, accountEmail, accountTeacher) 
VALUES (5, 'havel', 'Miroslav Havel', 'Vrsovicka 3, Ostrava', '$1$fizRusmT$KJ9kwwjzp8ATnmSBMq4o4.', "2003/6/6", "havelmira@gmail.com", true);

-- login xnovot13, heslo student
INSERT INTO Account (accountID, accountUsername, accountRealName, accountAddress, accountPassword, accountDateOfBirth, accountEmail, accountStudent) 
VALUES (6, 'xnovot13', 'Jarda Novotny', 'Bozetechova 2, Brno', '$1$J2b.7qT3$C6m3z10By7kfob8Ikx0N10', "2001/7/12", "xnovot13@fit.vutbr.cz", true);

-- login xfitko12, heslo student
INSERT INTO Account (accountID, accountUsername, accountRealName, accountAddress, accountPassword, accountDateOfBirth, accountEmail, accountStudent) 
VALUES (7, 'xfitko12', 'Honza Fitak', 'Manesova 12, Brno', '$1$J2b.7qT3$C6m3z10By7kfob8Ikx0N10', "2003/5/8", "xfitko@fit.vutbr.cz", true);

-- login xplagi0b, heslo student
INSERT INTO Account (accountID, accountUsername, accountRealName, accountAddress, accountPassword, accountDateOfBirth, accountEmail, accountStudent) 
VALUES (8, 'xplagi0b', 'Jan Plagiát', '', '$1$J2b.7qT3$C6m3z10By7kfob8Ikx0N10', "2000/3/22", "xplagi@fit.vutbr.cz", true);

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

-- A113 room
INSERT INTO Room (roomID, roomName, roomDescription)
VALUES (3, 'A113', 'Small lab');

-- terms for the 2 courses
INSERT INTO Term (termID, courseID, roomID, termName, termDate, termMaxPoints, termAutoregistered, termType, termLength) 
VALUES (1, 2, 1, 'Půlsemestrální zkouška', '2023/02/02 12:00', '15', true, 'Exam', '60');
INSERT INTO Term (termID, courseID, termName, termDescription, termDate, termMaxPoints, termAutoregistered, termType)
VALUES (2, 1, 'Zápočet', 'Předmět lze absolvovat pouze po splnění zápočtu', '2022/12/17', '30', true, 'Other');
INSERT INTO Term (termID, courseID, termName, termDate, termMaxPoints, termAutoregistered, termType) 
VALUES (3, 2, 'Bonusový úkol', '2022/12/31 23:59', '2', false, 'Project');
INSERT INTO Term (termID, courseID, termName, termDate, termMaxPoints, termAutoregistered, termType) 
VALUES (4, 3, 'Bonusový úkol', '2022/12/29 23:59', '4', false, 'Project');
INSERT INTO Term (termID, courseID, roomID, termName, termDescription, termDate, termMaxPoints, termAutoregistered, termType, termLength) 
VALUES (5, 1, 1, 'Zkouška', 'Předmět lze absolvovat pouze po splnění zkoušky', '2023/01/05 08:00', '60', true, 'Exam', 120);
INSERT INTO Term (termID, courseID, roomID, termName, termDate, termMaxPoints, termAutoregistered, termType, termLength) 
VALUES (6, 2, 2, 'Půlsemestrální zkouška', '2023/09/02 08:00', '20', false, 'Exam', '90');
INSERT INTO Term (termID, courseID, termName, termDescription, termDate, termMaxPoints, termAutoregistered, termType) 
VALUES (7, 3, 'Zápočet', 'Předmět lze absolvovat pouze po splnění zápočtu', '2022/11/19', '10', false, 'Other');
INSERT INTO Term (termID, courseID, roomID, termName, termDescription, termDate, termMaxPoints, termAutoregistered, termType, termLength) 
VALUES (8, 1, 3, 'Cvičení', '', '2022/12/21 17:00', '5', false, 'Exercise', 120);
INSERT INTO Term (termID, courseID, roomID, termName, termDescription, termDate, termMaxPoints, termAutoregistered, termType, termLength) 
VALUES (9, 3, 2, 'Přednáška', 'Snad něco zajímavého', '2022/12/18 09:00', '0', true, 'Lecture', 120);

-- student signed up for term
INSERT INTO SignedUp (studentID, termID, lecturerRealName, points, autoregistered) VALUES (3, 1, 'Miroslav Havel', 10, true);
INSERT INTO SignedUp (studentID, termID, autoregistered) VALUES (3, 2, true);
INSERT INTO SignedUp (studentID, termID, lecturerRealName, points) VALUES (3, 3, 'Jana Černá', 5);
INSERT INTO SignedUp (studentID, termID, autoregistered) VALUES (3, 5, true);
INSERT INTO SignedUp (studentID, termID, autoregistered) VALUES (3, 8, true);
INSERT INTO SignedUp (studentID, termID, lecturerRealName, points, autoregistered) VALUES (6, 2, 'Miroslav Havel', 5, true);
INSERT INTO SignedUp (studentID, termID, autoregistered) VALUES (6, 5, true);
INSERT INTO SignedUp (studentID, termID, autoregistered) VALUES (6, 7, true);
INSERT INTO SignedUp (studentID, termID, autoregistered) VALUES (6, 8, true);
INSERT INTO SignedUp (studentID, termID, autoregistered) VALUES (7, 2, true);
INSERT INTO SignedUp (studentID, termID, autoregistered) VALUES (7, 5, true);
INSERT INTO SignedUp (studentID, termID, autoregistered) VALUES (7, 7, true);
INSERT INTO SignedUp (studentID, termID, autoregistered) VALUES (7, 8, true);

-- student attends course
INSERT INTO Attends (accountID, courseID, approved) VALUES (3, 1, true);
INSERT INTO Attends (accountID, courseID, approved) VALUES (3, 2, true);
INSERT INTO Attends (accountID, courseID, approved) VALUES (3, 3, false);
INSERT INTO Attends (accountID, courseID, approved) VALUES (6, 1, true);
INSERT INTO Attends (accountID, courseID, approved) VALUES (6, 3, true);
INSERT INTO Attends (accountID, courseID, approved) VALUES (6, 2, false);
INSERT INTO Attends (accountID, courseID, approved) VALUES (7, 1, true);
INSERT INTO Attends (accountID, courseID, approved) VALUES (7, 2, false);
INSERT INTO Attends (accountID, courseID, approved) VALUES (7, 3, true);
