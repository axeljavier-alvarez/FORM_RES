SELECT * FROM solicitudes;

SELECT * FROM zonas;

SELECT * FROM estados;

SELECT * FROM tramites;

SELECT * FROM requisitos;

SELECT * FROM requisito_tramite;

/* SHOW CREATE TABLE solicitudes;
SHOW CREATE TABLE zonas; */


/* solicitudes con estado pendiente */
SELECT s.*, e.nombre AS estado
FROM solicitudes s
JOIN estados e ON e.id = s.estado_id
WHERE e.nombre = 'Pendiente';

/* requisitos de cada tramite */

/* SELECT r.id, r.nombre
FROM requisitos r
INNER JOIN requisito_tramite rt ON r.id = rt.requisito_id
WHERE rt.tramite_id = 1; */


/* requisitos por nombre */
/* SELECT
t.id AS tramite_id,
t.nombre AS tramite,
r.id AS requisito_id,
r.nombre AS requisito
FROM requisito_tramite rt
INNER JOIN tramites t ON t.id = rt.tramite_id
INNER JOIN requisitos r ON r.id = rt.requisito_id
WHERE t.nombre = 'Magisterio'; */
/* ver los requisitos de cada tramite */
SELECT
t.id AS tramite_id,
t.nombre AS tramite,
r.id AS requisito_id,
r.nombre AS requisito
FROM requisito_tramite rt
INNER JOIN tramites t ON t.id = rt.tramite_id
INNER JOIN requisitos r ON r.id = rt.requisito_id
/* WHERE rt.tramite_id = 1; */
ORDER BY t.id;





