CREATE VIEW vwpersonaslibros as
SELECT * from vwpersonas vp LEFT JOIN vwlibros vl ON vp.usuario_s_usuId=vl.persona_usuario_s_usuId;  