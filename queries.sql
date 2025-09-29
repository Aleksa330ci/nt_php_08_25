SELECT a.id AS appt_id, a.scheduled_for, a.status,
       c.name   AS clinic,
       v.name   AS vet, v.specialty,
       p.name   AS pet, p.species,
       o.name   AS owner, o.phone
FROM appointments a
JOIN clinics      c ON c.id = a.clinic_id
JOIN vets         v ON v.id = a.vet_id
JOIN pets         p ON p.id = a.pet_id
JOIN pet_owners   o ON o.id = p.owner_id
ORDER BY a.scheduled_for;


SELECT c.name AS clinic,
       COUNT(*) AS appts_this_month
FROM appointments a
JOIN clinics c ON c.id = a.clinic_id
WHERE a.scheduled_for >= DATE_FORMAT(CURDATE(), '%Y-%m-01')
  AND a.scheduled_for <  DATE_ADD(DATE_FORMAT(CURDATE(), '%Y-%m-01'), INTERVAL 1 MONTH)
GROUP BY c.id, c.name
ORDER BY appts_this_month DESC;


SELECT v.name AS vet, v.specialty,
       COUNT(*) AS appts_count
FROM appointments a
JOIN vets v ON v.id = a.vet_id
GROUP BY v.id, v.name, v.specialty
ORDER BY appts_count DESC
LIMIT 5;


SELECT p.id, p.name, p.species, o.name AS owner
FROM pets p
JOIN pet_owners o ON o.id = p.owner_id
LEFT JOIN appointments a ON a.pet_id = p.id
WHERE a.id IS NULL;


SELECT o.id, o.name, COUNT(DISTINCT p.species) AS species_count
FROM pet_owners o
JOIN pets p ON p.owner_id = o.id
GROUP BY o.id, o.name
HAVING COUNT(DISTINCT p.species) > 1
ORDER BY species_count DESC;


SELECT v.id AS vet_id, v.name AS vet_name, v.specialty,
       (
         SELECT a2.scheduled_for
         FROM appointments a2
         WHERE a2.vet_id = v.id
           AND a2.scheduled_for > NOW()
         ORDER BY a2.scheduled_for
         LIMIT 1
       ) AS next_appointment
FROM vets v
ORDER BY next_appointment IS NULL, next_appointment;


SELECT c.name AS clinic, COUNT(DISTINCT v.specialty) AS specialties
FROM clinics c
LEFT JOIN vets v ON v.clinic_id = c.id
GROUP BY c.id, c.name
ORDER BY specialties DESC;


SELECT x.clinic, x.appt_date, x.daily_count
FROM (
  SELECT c.name AS clinic,
         DATE(a.scheduled_for) AS appt_date,
         COUNT(*) AS daily_count,
         ROW_NUMBER() OVER (PARTITION BY c.id ORDER BY COUNT(*) DESC) AS rn
  FROM appointments a
  JOIN clinics c ON c.id = a.clinic_id
  GROUP BY c.id, c.name, DATE(a.scheduled_for)
) x
WHERE x.rn = 1
ORDER BY x.daily_count DESC;
