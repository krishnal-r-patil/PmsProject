SET FOREIGN_KEY_CHECKS = 0;
TRUNCATE TABLE applications;
TRUNCATE TABLE taxes;
TRUNCATE TABLE citizens;
TRUNCATE TABLE users;
SET FOREIGN_KEY_CHECKS = 1;

USE pms_db;

-- 1. Insert Admin (Always ID 1)
INSERT INTO users (id, name, email, password, role, created_at) VALUES 
(1, 'System Admin', 'admin@panchayat.com', 'admin123', 'admin', '2026-01-01 00:00:00');

-- 2. Insert Realistic Users for 2026
INSERT INTO users (id, name, email, password, role, created_at) VALUES 
(2, 'Rahul Deshmukh', 'rahul@mail.com', 'user123', 'user', '2026-01-10 10:00:00'),
(3, 'Priya Sharma', 'priya@mail.com', 'user123', 'user', '2026-01-15 11:30:00'),
(4, 'Amit Patel', 'amit@mail.com', 'user123', 'user', '2026-02-05 09:15:00'),
(5, 'Suresh Kumar', 'suresh@mail.com', 'user123', 'user', '2026-02-20 14:20:00'),
(6, 'Anjali Verma', 'anjali@mail.com', 'user123', 'user', '2026-03-01 16:45:00'),
(7, 'Vikram Singh', 'vikram@mail.com', 'user123', 'user', '2026-03-12 10:10:00'),
(8, 'Meena Devi', 'meena@mail.com', 'user123', 'user', '2026-03-25 12:00:00'),
(9, 'Rohan Gupta', 'rohan@mail.com', 'user123', 'user', '2026-04-05 08:30:00');

-- 3. Insert Corresponding Citizen Details
INSERT INTO citizens (user_id, father_name, aadhar_no, voter_id, phone, gender, dob, category, occupation, house_no, ward_no, village, family_id, created_at) VALUES 
(2, 'Gajanan Deshmukh', '111122223333', 'VOTER001', '9876543210', 'Male', '1990-05-20', 'General', 'Farmer', 'H-10', '01', 'Burhanpur', 'FAM8801', '2026-01-10 10:05:00'),
(3, 'Rajesh Sharma', '222233334444', 'VOTER002', '9876543211', 'Female', '1995-08-12', 'OBC', 'Teacher', 'H-22', '02', 'Burhanpur', 'FAM8802', '2026-01-15 11:35:00'),
(4, 'Lokesh Patel', '333344445555', 'VOTER003', '9876543212', 'Male', '1988-12-01', 'OBC', 'Business', 'H-05', '03', 'Burhanpur', 'FAM8803', '2026-02-05 09:20:00'),
(5, 'Ramprasad Kumar', '444455556666', 'VOTER004', '9876543213', 'Male', '1975-03-15', 'SC', 'Laborer', 'H-45', '01', 'Burhanpur', 'FAM8804', '2026-02-20 14:25:00'),
(6, 'Baldev Verma', '555566667777', 'VOTER005', '9876543214', 'Female', '1992-11-20', 'ST', 'Service', 'H-12', '05', 'Burhanpur', 'FAM8805', '2026-03-01 16:50:00'),
(7, 'Jagdish Singh', '666677778888', 'VOTER006', '9876543215', 'Male', '1985-07-10', 'General', 'Contractor', 'H-09', '02', 'Burhanpur', 'FAM8806', '2026-03-12 10:15:00'),
(8, 'Sundar Lal', '777788889999', 'VOTER007', '9876543216', 'Female', '1980-01-25', 'SC', 'Homemaker', 'H-31', '04', 'Burhanpur', 'FAM8807', '2026-03-25 12:05:00'),
(9, 'Mahesh Gupta', '888899990000', 'VOTER008', '9876543217', 'Male', '1998-09-05', 'General', 'Student', 'H-18', '03', 'Burhanpur', 'FAM8808', '2026-04-05 08:35:00');

-- 4. Insert 2026 Applications
INSERT INTO applications (user_id, service_type, status, application_data, applied_at) VALUES 
(2, 'Income Certificate', 'Approved', 'Purpose: Scholarship', '2026-03-10 10:00:00'),
(3, 'Birth Certificate', 'Pending', 'Child Name: Aarav', '2026-04-01 11:20:00'),
(4, 'Caste Certificate', 'Pending', 'Sub-category: Kurmi', '2026-04-08 09:45:00'),
(5, 'Residency Certificate', 'Approved', 'Duration: 20 years', '2026-02-15 14:00:00'),
(6, 'Death Certificate', 'Rejected', 'Reason: Document missing', '2026-03-20 16:30:00'),
(7, 'Property Valuation', 'Pending', 'Plot No: 45', '2026-04-12 13:10:00'),
(8, 'Income Certificate', 'Pending', 'Annual Income: 50k', '2026-04-13 10:00:00');

-- 5. Insert 2026 Tax Records
INSERT INTO taxes (user_id, tax_type, amount, status, due_date, paid_at) VALUES 
(2, 'Property Tax', 1200.00, 'Paid', '2026-03-31', '2026-03-25 10:00:00'),
(3, 'Water Bill', 450.00, 'Paid', '2026-04-15', '2026-04-10 15:30:00'),
(4, 'Property Tax', 1500.00, 'Unpaid', '2026-03-31', NULL),
(5, 'Professional Tax', 500.00, 'Paid', '2026-03-20', '2026-03-18 09:00:00'),
(6, 'Water Bill', 300.00, 'Unpaid', '2026-04-15', NULL),
(7, 'Cleanup Duty', 200.00, 'Paid', '2026-02-10', '2026-02-05 11:00:00');
