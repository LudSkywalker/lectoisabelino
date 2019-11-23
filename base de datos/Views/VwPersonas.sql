CREATE VIEW VwPersonas as
SELECT p.perId, p.perDocumento, p.perNombre, p.perApellido,
u.usuLogin,u.usuPassword,r.rolId,r.rolNombre,r.rolDescripcion FROM 
(((persona p LEFT JOIN usuario_s u on u.usuId=p.usuario_s_usuId) 
LEFT join usuario_s_roles ur on ur.id_usuario_s=p.perId )
left join rol r on r.rolId =ur.id_rol)