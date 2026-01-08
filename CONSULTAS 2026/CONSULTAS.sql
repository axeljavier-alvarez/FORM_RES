SELECT * FROM dependientes;

SELECT * FROM estados;

SELECT * FROM solicitudes;

SELECT * FROM users;


DELIMITER //

CREATE TRIGGER tr_solicitud_creada_bitacora
AFTER INSERT ON solicitudes
FOR EACH ROW
BEGIN
    INSERT INTO bitacoras (solicitud_id, user_id, evento, descripcion, created_at, updated_at)
    VALUES (NEW.id, NULL, 'CREACION', 'Registro inicial de la solicitud desde el portal.', NOW(), NOW());
END;
//

DELIMITER ;


