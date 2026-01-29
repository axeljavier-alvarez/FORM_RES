select * from solicitudes;

select * from detalle_solicitud;

select * from estados;

select * from requisitos;

select * from tramites;

select * from estados where id in (4,5);

select * from requisito_tramite;

select * from detalle_solicitud
where solicitud_id = 4;

/*  consulta 1 */
/* ver las solicitudes con zonas, estados y detalle */
-- select 
-- s.no_solicitud,
-- s.nombres,
-- s.apellidos,
-- e.nombre as estado,
-- z.nombre as zona,
-- d.path as detalle_path,
-- d.tipo as detalle_tipo,
-- rt.id as requisito_tramite_id,
-- r.id as requisito_tramite,
-- r.nombre as requisito_nombre,
-- t.id as tramite,
-- t.nombre as tramite
-- 
-- from solicitudes s
-- -- unir zonas 
-- left join zonas z on s.zona_id = z.id
-- -- unir estado
-- left join estados e on s.estado_id = e.id
-- -- unir detalles de la solicitud
-- left join detalle_solicitud d on d.solicitud_id = s.id
-- -- relacion de muchos a muchos
-- -- relacionarlo con solicitud que es la principal
-- left join solicitudes_has_requisitos_tramites shrt
-- on shrt.solicitud_id = s.id
-- 
-- -- relacionarlo con requisito_tramite
-- left join requisito_tramite rt on rt.id = shrt.requisito_tramite_id
-- 
-- -- entrar a requisito
-- left join requisitos r on r.id = rt.requisito_id
-- 
-- -- entra a tramites
-- left join tramites t on t.id = rt.tramite_id
-- 
-- where s.no_solicitud = '5-2026';



SELECT 
    s.no_solicitud,
    s.nombres,
    s.apellidos,
    e.nombre AS estado,
    z.nombre AS zona,
    d.path AS detalle_path,
    d.tipo AS detalle_tipo,
    rt.id AS requisito_tramite_id,
    r.id AS requisito_id,
    r.nombre AS requisito_nombre,
    t.id AS tramite_id,
    t.nombre AS tramite
FROM solicitudes s
LEFT JOIN zonas z ON s.zona_id = z.id
LEFT JOIN estados e ON s.estado_id = e.id
LEFT JOIN detalle_solicitud d ON d.solicitud_id = s.id
LEFT JOIN requisito_tramite rt ON rt.id = d.requisito_tramite_id
LEFT JOIN requisitos r ON r.id = rt.requisito_id
LEFT JOIN tramites t ON t.id = rt.tramite_id
WHERE s.no_solicitud = '5-2026';


