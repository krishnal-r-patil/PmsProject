USE pms_db;

-- Birth & Death Register (CRS) Table
CREATE TABLE IF NOT EXISTS birth_death_register (
    id INT AUTO_INCREMENT PRIMARY KEY,
    registration_no VARCHAR(30) NOT NULL UNIQUE,
    type ENUM('Birth', 'Death', 'Still Birth') NOT NULL,
    person_name VARCHAR(150) NOT NULL,
    gender ENUM('Male', 'Female', 'Other') NOT NULL,
    age_at_event INT DEFAULT 0,
    father_mother_name VARCHAR(200),
    informant_name VARCHAR(150),
    date_of_event DATE NOT NULL,
    cause_of_death VARCHAR(255) NULL,
    weight_at_birth DECIMAL(4,2) NULL,
    place_of_event VARCHAR(150),
    village_ward VARCHAR(50),
    remarks TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Sample Records (matching what the UI already shows)
INSERT INTO birth_death_register
    (registration_no, type, person_name, gender, age_at_event, father_mother_name, informant_name, date_of_event, weight_at_birth, place_of_event, village_ward)
VALUES
    ('CRS/2026/001', 'Birth', 'Baby of Sunita', 'Male',  0, 'Rahul & Sunita Sharma', 'Rahul Sharma (Father)', '2026-04-10', 3.20, 'CHC Burhanpur',       'Ward 01'),
    ('CRS/2026/002', 'Birth', 'Baby of Priya',  'Female',0, 'Amit & Priya Verma',   'Staff Nurse',           '2026-04-12', 2.95, 'District Hospital',   'Ward 03');

INSERT INTO birth_death_register
    (registration_no, type, person_name, gender, age_at_event, father_mother_name, informant_name, date_of_event, cause_of_death, place_of_event, village_ward)
VALUES
    ('CRS/2026/D-01', 'Death', 'Ramsharan Singh', 'Male',  82, 'S/o Late Baldev Singh',  'Vikram Singh (Son)',           '2026-03-25', 'Senile Debility (Natural)', 'Residential - H.No 44', 'Ward 02'),
    ('CRS/2026/D-02', 'Death', 'Kalpana Devi',    'Female',65, 'W/o Gajanan Deshmukh',  'Gajanan Deshmukh (Husband)',   '2026-04-01', 'Cardiac Arrest',           'CHC Burhanpur',         'Ward 01');
