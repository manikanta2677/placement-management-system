DROP DATABASE IF EXISTS placement_system;
CREATE DATABASE placement_system;
USE placement_system;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin','student','company') NOT NULL,
    status ENUM('active','inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    roll_no VARCHAR(50) NOT NULL,
    branch VARCHAR(100) NOT NULL,
    year VARCHAR(20) NOT NULL,
    cgpa DECIMAL(3,2) NOT NULL,
    skills TEXT,
    phone VARCHAR(20),
    resume VARCHAR(255),
    placement_status ENUM('Not Placed','Placed') DEFAULT 'Not Placed',
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE companies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    company_name VARCHAR(150) NOT NULL,
    industry VARCHAR(100),
    location VARCHAR(100),
    website VARCHAR(150),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE jobs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    title VARCHAR(150) NOT NULL,
    description TEXT NOT NULL,
    package VARCHAR(50) NOT NULL,
    eligibility_cgpa DECIMAL(3,2) NOT NULL,
    last_date DATE NOT NULL,
    status ENUM('Open','Closed') DEFAULT 'Open',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (company_id) REFERENCES companies(id) ON DELETE CASCADE
);

CREATE TABLE applications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    job_id INT NOT NULL,
    status ENUM('Applied','Shortlisted','Selected','Rejected') DEFAULT 'Applied',
    applied_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE,
    FOREIGN KEY (job_id) REFERENCES jobs(id) ON DELETE CASCADE
);

INSERT INTO users(name,email,password,role)
VALUES('Admin','admin@gmail.com',MD5('admin123'),'admin');

INSERT INTO users(name,email,password,role)
VALUES
('Rahul Student','student@gmail.com',MD5('student123'),'student'),
('TCS HR','company@gmail.com',MD5('company123'),'company');

INSERT INTO students(user_id, roll_no, branch, year, cgpa, skills, phone)
VALUES
(2, 'AP23110010001', 'CSE', '4th Year', 8.20, 'HTML, CSS, PHP, MySQL, Java', '9876543210');

INSERT INTO companies(user_id, company_name, industry, location, website)
VALUES
(3, 'TCS', 'IT Services', 'Hyderabad', 'www.tcs.com');

INSERT INTO jobs(company_id, title, description, package, eligibility_cgpa, last_date)
VALUES
(1, 'Software Developer', 'Develop and maintain web applications using PHP and MySQL.', '6 LPA', 7.00, '2026-12-31'),
(1, 'Data Analyst', 'Analyze company data and prepare reports using SQL.', '5 LPA', 6.50, '2026-12-31');