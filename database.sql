CREATE DATABASE IF NOT EXISTS student_feedback_system CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE student_feedback_system;

DROP TABLE IF EXISTS feedback;
DROP TABLE IF EXISTS users;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('student','admin') NOT NULL DEFAULT 'student',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE feedback (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(150) NOT NULL,
    category VARCHAR(80) NOT NULL,
    description TEXT NOT NULL,
    status ENUM('Pending','Reviewed','Resolved','Rejected') NOT NULL DEFAULT 'Pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Password for all accounts is: 123456
INSERT INTO users (name, email, password, role) VALUES
('Admin User', 'admin@yic.edu.sa', '$2y$12$eKO8qVqqtz/NzQp/2azjmu6j.RkUUMRcppM.DEyY3fnXrv.LOCx4y', 'admin'),
('Hanan Alanazi', 'hanan@student.yic.edu.sa', '$2y$12$eKO8qVqqtz/NzQp/2azjmu6j.RkUUMRcppM.DEyY3fnXrv.LOCx4y', 'student'),
('Aseel Azoni', 'aseel@student.yic.edu.sa', '$2y$12$eKO8qVqqtz/NzQp/2azjmu6j.RkUUMRcppM.DEyY3fnXrv.LOCx4y', 'student'),
('Student One', 'student1@yic.edu.sa', '$2y$12$eKO8qVqqtz/NzQp/2azjmu6j.RkUUMRcppM.DEyY3fnXrv.LOCx4y', 'student'),
('Student Two', 'student2@yic.edu.sa', '$2y$12$eKO8qVqqtz/NzQp/2azjmu6j.RkUUMRcppM.DEyY3fnXrv.LOCx4y', 'student'),
('Student Three', 'student3@yic.edu.sa', '$2y$12$eKO8qVqqtz/NzQp/2azjmu6j.RkUUMRcppM.DEyY3fnXrv.LOCx4y', 'student'),
('Student Four', 'student4@yic.edu.sa', '$2y$12$eKO8qVqqtz/NzQp/2azjmu6j.RkUUMRcppM.DEyY3fnXrv.LOCx4y', 'student'),
('Student Five', 'student5@yic.edu.sa', '$2y$12$eKO8qVqqtz/NzQp/2azjmu6j.RkUUMRcppM.DEyY3fnXrv.LOCx4y', 'student'),
('Student Six', 'student6@yic.edu.sa', '$2y$12$eKO8qVqqtz/NzQp/2azjmu6j.RkUUMRcppM.DEyY3fnXrv.LOCx4y', 'student'),
('Student Seven', 'student7@yic.edu.sa', '$2y$12$eKO8qVqqtz/NzQp/2azjmu6j.RkUUMRcppM.DEyY3fnXrv.LOCx4y', 'student');

INSERT INTO feedback (user_id, title, category, description, status) VALUES
(2, 'Course Feedback', 'Course', 'The course needs more practical examples.', 'Pending'),
(2, 'WiFi Issue', 'Service', 'The internet connection is slow in the lab.', 'Reviewed'),
(3, 'Library Rooms', 'Service', 'Students need more study rooms in the library.', 'Resolved'),
(4, 'Parking Problem', 'Campus', 'Parking is crowded during morning classes.', 'Pending'),
(5, 'Lab Devices', 'Course', 'Some computers in the lab need maintenance.', 'Reviewed'),
(6, 'Cafeteria Options', 'Campus', 'More healthy food options should be added.', 'Pending'),
(7, 'Exam Schedule', 'Exams', 'Exam schedules should be announced earlier.', 'Resolved'),
(8, 'Instructor Feedback', 'Instructor', 'The instructor explains clearly and uses examples.', 'Reviewed'),
(9, 'Classroom AC', 'Campus', 'The air conditioning is not working well.', 'Pending'),
(10, 'Grading System', 'Grading', 'Grades should be updated faster on the system.', 'Rejected');
