/* SELECT * FROM dependientes;

SELECT * FROM estados;

SELECT * FROM solicitudes;

SELECT * FROM users;

SELECT * FROM bitacoras;

*/

SELECT * FROM solicitudes;

SHOW TRIGGERS;


SELECT * FROM bitacoras;


SELECT * FROM estados;

/* 
DELIMITER //

CREATE TRIGGER tr_solicitud_creada_bitacora
AFTER INSERT ON solicitudes
FOR EACH ROW
BEGIN
   INSERT INTO bitacoras (solicitud_id, user_id, evento, descripcion, created_at, updated_at)
   VALUES(NEW.id, NULL, 'CREACION', 'Registro inicial de la solicitud desde el formulario', NOW(), NOW());
END; //


DELIMITER ;  */


DELIMITER //

CREATE TRIGGER tr_bitacora_cambio_estado
AFTER UPDATE ON solicitudes
FOR EACH ROW
BEGIN
    -- Verificar que el estado cambio
    IF OLD.estado_id <> NEW.estado_id THEN
        
        -- Variables de descripcion
        DECLARE nombre_estado VARCHAR(100);
        DECLARE descripcion_texto TEXT;

        -- Buscar nombre del estado
        SELECT nombre INTO nombre_estado 
        FROM estados 
        WHERE id = NEW.estado_id;

        -- descripcion
        IF nombre_estado = 'Cancelado' THEN
            SET descripcion_texto = 'La solicitud ha sido rechazada por el analista';
        ELSEIF nombre_estado = 'En proceso' THEN
            SET descripcion_texto = 'La solicitud ha sido aprobada para análisis';
        ELSE
            SET descripcion_texto = CONCAT('El estado de la solicitud cambió a: ', nombre_estado);
        END IF;

        -- Insercion en tabla bitacoras
        INSERT INTO bitacoras (
            solicitud_id, 
            user_id, 
            evento, 
            descripcion, 
            created_at, 
            updated_at
        )
        VALUES (
            NEW.id, 
            NULL, 
            CONCAT('CAMBIO DE ESTADO: ', nombre_estado), 
            descripcion_texto, 
            NOW(), 
            NOW()
        );
        
    END IF;
END //

DELIMITER ;


/* 
drop trigger if exists tr_solicitud_creada_bitacora */
/* SELECT DE TODAS LAS TABLAS PARA MOSTRAR LOS DATOS POR SOLICITUD Y EN GENERAL*/


