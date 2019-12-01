CREATE VIEW vwlibros AS
SELECT cp.conPId,cp.conPFechaSal,cp.conPFechaEnt,cp.conPFechaDev,cp.conPPrestado,cp.conPObsSalida, 
cp.conPObsEntrada,cp.persona_usuario_s_usuId,ll.libLecId,ll.libLecCodigo,ll.libLecTitulo,ll.libLecAutor,el.estLibId,el.estLibNombre,
el.estLibObs,cl.catLecId,cl.catLecNombre,cl.catLecDescri FROM 
(((contr_prestamos_libros cp LEFT JOIN libros_lecto ll ON ll.libLecId=cp.libros_lecto_libLecId) 
LEFT join estado_libros el on el.estLibId=ll.estado_libros_estLibId )
left JOIN categoria_libro_lecto cl on cl.catLecId=ll.categoria_libro_lecto_catLecId) 