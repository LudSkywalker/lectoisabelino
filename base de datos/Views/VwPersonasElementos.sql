CREATE VIEW vwpersonaselementos as
SELECT * from vwpersonas vp LEFT JOIN vwelementos ve ON vp.perId=ve.persona_perId;  