CREATE VIEW vwelementos AS 
SELECT ce.conEId, ce.conEFechaSal,ce.conEFechaEnt,ce.conEFechaDev,ce.conEPrestado,ce.conEObsSalida,
ce.conEObsEntrada,ce.persona_usuario_s_usuId,el.eleLecId,el.eleLecCodigo,ee.estEleId,ee.estEleNombre,ee.estEleObs,cel.catEleId,
cel.catEleNombre,cel.catEleDescri FROM 
(((contr_elementos ce LEFT JOIN elementos_lecto el ON el.eleLecId=ce.elementos_lecto_eleLecId) 
LEFT join estado_elementos ee on ee.estEleId=el.estado_elementos_estEleId)
left JOIN categoria_elementos cel on cel.catEleId=el.categoria_elementos_catEleId); 