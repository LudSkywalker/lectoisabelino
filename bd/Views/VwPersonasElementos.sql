CREATE VIEW vwpersonaselementos as
SELECT * from vwpersonas vp LEFT JOIN vwelementos ve ON vp.usuario_s_usuId=ve.persona_usuario_s_usuId;  