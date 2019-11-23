CREATE VIEW vwpersonaslibros as
SELECT * from vwpersonas vp LEFT JOIN vwlibros vl ON vp.perId=vl.persona_perId;  