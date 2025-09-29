SET FOREIGN_KEY_CHECKS = 0;

SET FOREIGN_KEY_CHECKS = 1;


INSERT INTO clinics (name, city) VALUES
('Green Paw',        'Kyiv'),
('Happy Tails',      'Lviv'),
('VetCare Center',   'Odesa'),
('Pet Health Plus',  'Dnipro'),
('Animal Life',      'Kharkiv');


INSERT INTO vets (clinic_id, name, specialty) VALUES
(1, 'Dr. Olena Koval',   'Therapy'),
(1, 'Dr. Max Petrenko',  'Surgery'),
(2, 'Dr. Iryna Sydor',   'Dermatology'),
(2, 'Dr. Dmytro Hladky', 'Dentistry'),
(3, 'Dr. Anton Marta',   'Therapy'),
(4, 'Dr. Alina Riznyk',  'Radiology'),
(5, 'Dr. Yaroslav Zub',  'Orthopedics'),
(5, 'Dr. Maria Levchyk', 'Therapy');


INSERT INTO pet_owners (name, phone) VALUES
('Andrii Melnyk',    '+380501112233'),
('Oksana Danylko',   '+380671234567'),
('Serhii Klymchuk',  '+380931112233'),
('Nadiia Ivashko',   '+380661234567'),
('Volodymyr Bondar', '+380991112233'),
('Iryna Kovtun',     '+380501234567');


INSERT INTO pets (owner_id, name, species) VALUES
(1, 'Barsyk',  'Cat'),
(1, 'Rex',     'Dog'),
(2, 'Murchyk', 'Cat'),
(3, 'Frodo',   'Dog'),
(4, 'Luna',    'Cat'),
(5, 'Spike',   'Dog'),
(6, 'Bunny',   'Rabbit'),
(6, 'Chili',   'Parrot');


INSERT INTO appointments (clinic_id, vet_id, pet_id, scheduled_for, status) VALUES
(1, 1, 1, '2025-10-01 10:00:00', 'scheduled'),
(1, 2, 2, '2025-10-01 11:30:00', 'scheduled'),
(2, 3, 3, '2025-10-02 09:00:00', 'done'),
(2, 4, 4, '2025-10-02 12:15:00', 'scheduled'),
(3, 5, 5, '2025-10-03 14:00:00', 'cancelled'),
(4, 6, 6, '2025-10-03 15:45:00', 'scheduled'),
(5, 7, 7, '2025-10-04 10:30:00', 'scheduled'),
(5, 8, 8, '2025-10-04 11:15:00', 'done'),
(1, 2, 1, '2025-10-05 09:30:00', 'scheduled'),
(2, 3, 5, '2025-10-05 16:00:00', 'scheduled');
