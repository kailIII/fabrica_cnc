update prop_tarifario SET id_tipo_metodologia = 2 WHERE nom_tipo_metodologia = 'Cualitativos';
update prop_tarifario SET id_tipo_metodologia = 3 WHERE nom_tipo_metodologia = 'Cuantitativos';

update prop_tarifario SET id_metodologia = 1 WHERE nom_metodologia = 'Café conversación';
update prop_tarifario SET id_metodologia = 5 WHERE nom_metodologia = 'Entrevistas en Profundidad';
update prop_tarifario SET id_metodologia = 4 WHERE nom_metodologia = 'Etnografía';
update prop_tarifario SET id_metodologia = 2 WHERE nom_metodologia = 'Grupo focal';
update prop_tarifario SET id_metodologia = 3 WHERE nom_metodologia = 'Historia de Vida';
update prop_tarifario SET id_metodologia = 8 WHERE nom_metodologia = 'Procesos en U';
update prop_tarifario SET id_metodologia = 9 WHERE nom_metodologia = 'Tormenta de Ideas';
update prop_tarifario SET id_metodologia = 12 WHERE nom_metodologia = 'Personal empresas';
update prop_tarifario SET id_metodologia = 13 WHERE nom_metodologia = 'Personal en Hogares';
update prop_tarifario SET id_metodologia = 14 WHERE nom_metodologia = 'Locación Central';
update prop_tarifario SET id_metodologia = 16 WHERE nom_metodologia = 'Telefónica en Hogares';
update prop_tarifario SET id_metodologia = 17 WHERE nom_metodologia = 'Telefónico empresas';
update prop_tarifario SET id_metodologia = 19 WHERE nom_metodologia LIKE '%Auditoria%';
update prop_tarifario SET id_metodologia = 18 WHERE nom_metodologia = 'Reuniones';
update prop_tarifario SET id_metodologia = 20 WHERE nom_metodologia = 'Internet';

update prop_tarifario SET id_duracion = 13 WHERE duracion = 'En promedio de duración de 1 hora';
update prop_tarifario SET id_duracion = 6 WHERE duracion = 'Entre 3 y 4';
update prop_tarifario SET id_duracion = 14 WHERE duracion = 'Entre 3 y 4 días';
update prop_tarifario SET id_duracion = 7 WHERE duracion = 'Entre 3 y 6 horas';
update prop_tarifario SET id_duracion = 8 WHERE duracion = 'Entre 5 y 7 días';
update prop_tarifario SET id_duracion = 9 WHERE duracion = 'Más de 6 horas';
update prop_tarifario SET id_duracion = 11 WHERE duracion = 'Máximo 2 días';
update prop_tarifario SET id_duracion = 12 WHERE duracion = 'Máximo 3 horas';
update prop_tarifario SET id_duracion = 2 WHERE duracion = '< 15 minutos';
update prop_tarifario SET id_duracion = 3 WHERE duracion = 'De 16 a 30 minutos';
update prop_tarifario SET id_duracion = 4 WHERE duracion = 'De 31 a 45 minutos';
update prop_tarifario SET id_duracion = 5 WHERE duracion = 'De 46 a 60 minutos';
update prop_tarifario SET id_duracion = 10 WHERE duracion = 'Más de 60 minutos';

update prop_tarifario SET id_nivel_aceptacion = 1 WHERE des_nivel_aceptacion LIKE '%Dificil (3 o menos aceptación de cada 10 contactos)%';
update prop_tarifario SET id_nivel_aceptacion = 2 WHERE des_nivel_aceptacion LIKE '%Dificil (3 o menos encuestas efectivas de cada 10 contactos)%';
update prop_tarifario SET id_nivel_aceptacion = 5 WHERE des_nivel_aceptacion LIKE '%Facíl (Mas de 6 aceptación de cada 10 contactos)%';
update prop_tarifario SET id_nivel_aceptacion = 6 WHERE des_nivel_aceptacion LIKE '%Facíl (Mas de 6 encuestas de cada 10 contactos)%';
update prop_tarifario SET id_nivel_aceptacion = 8 WHERE des_nivel_aceptacion LIKE '%Media (De 3 a 6 aceptación de cada 10 contactos)%';
update prop_tarifario SET id_nivel_aceptacion = 9 WHERE des_nivel_aceptacion LIKE '%Media (De 3 a 6 encuestas efectivas de cada 10 contactos)%';
update prop_tarifario SET id_nivel_aceptacion = 11 WHERE des_nivel_aceptacion = '';

update prop_tarifario SET id_origen_db = 1 WHERE origen_db = 'BDD del CNC, Confecamaras, Directorio Telefonico, etc.';
update prop_tarifario SET id_origen_db = 1 WHERE origen_db = 'BBDD Confecamaras y/o Directorio Telefonico';
update prop_tarifario SET id_origen_db = 2 WHERE origen_db = 'Base de datos entregada por el cliente';
update prop_tarifario SET id_origen_db = 2 WHERE origen_db = 'Con BDD provista por el Cliente';
update prop_tarifario SET id_origen_db = 3 WHERE origen_db = '';

update prop_tarifario SET id_cobertura = 3 WHERE nom_cobertura = 'Ciudades Intermedias';
update prop_tarifario SET id_cobertura = 2 WHERE nom_cobertura = 'Ciudades Principales';
update prop_tarifario SET id_cobertura = 4 WHERE nom_cobertura = 'Municipios';
update prop_tarifario SET id_cobertura = 6 WHERE nom_cobertura = '';

update prop_tarifario SET id_pob_objetivo = 26 WHERE des_pob_objetivo LIKE 'Acompañamientos';
update prop_tarifario SET id_pob_objetivo = 23 WHERE des_pob_objetivo = 'Entrevistas Cara A Cara';
update prop_tarifario SET id_pob_objetivo = 27 WHERE des_pob_objetivo LIKE 'Entrevistas exploratorias';
update prop_tarifario SET id_pob_objetivo = 24 WHERE des_pob_objetivo = 'Entrevistas telefónica';
update prop_tarifario SET id_pob_objetivo = 18 WHERE des_pob_objetivo = 'Grupo de 2 a 3 personas';
update prop_tarifario SET id_pob_objetivo = 19 WHERE des_pob_objetivo LIKE '%10 a 28 personas%';
update prop_tarifario SET id_pob_objetivo = 20 WHERE des_pob_objetivo LIKE '%Entre 7 y 10 personas%';
update prop_tarifario SET id_pob_objetivo = 28 WHERE des_pob_objetivo LIKE 'Inmersiones / Convivencias';
update prop_tarifario SET id_pob_objetivo = 30 WHERE des_pob_objetivo LIKE 'Internet con preguntas abiertas para codificar';
update prop_tarifario SET id_pob_objetivo = 31 WHERE des_pob_objetivo LIKE 'Internet sin preguntas para codificar';
update prop_tarifario SET id_pob_objetivo = 22 WHERE des_pob_objetivo LIKE '%4 a 6 personas%';
update prop_tarifario SET id_pob_objetivo = 29 WHERE des_pob_objetivo LIKE 'Observación';


update prop_tarifario SET operador_muestra = 'BETWEEN' WHERE muestra LIKE '%Entre %';
update prop_tarifario SET valor_muestra = '13,24' WHERE muestra LIKE '%Entre 13 y 24%';
update prop_tarifario SET valor_muestra = '300,600'  WHERE muestra LIKE '%Entre 300 y 600%';
update prop_tarifario SET valor_muestra = '6,10'  WHERE muestra LIKE '%Entre 6 y 10%';

update prop_tarifario SET operador_muestra = '<=' WHERE muestra LIKE '%hasta%';
update prop_tarifario SET valor_muestra = '12' WHERE muestra LIKE '%hasta 12 entrevistas%';
update prop_tarifario SET valor_muestra = '5' WHERE muestra LIKE '%hasta 5%';
update prop_tarifario SET valor_muestra = '6' WHERE muestra LIKE '%hasta 6 sesiones%';

update prop_tarifario SET operador_muestra = '>'  WHERE muestra LIKE '%más%';
update prop_tarifario SET valor_muestra = '10' WHERE muestra LIKE '%Más de 10%';
update prop_tarifario SET valor_muestra = '24' WHERE muestra LIKE '%Más de 24 entrevistas%';
update prop_tarifario SET valor_muestra = '6' WHERE muestra LIKE '%Más de 6 sesiones%';
update prop_tarifario SET valor_muestra = '600'  WHERE muestra LIKE '%más de 600%';

update prop_tarifario SET operador_muestra = '<', valor_muestra = '300' WHERE muestra LIKE '%menos de 300%';

update prop_tarifario SET operador_muestra = '>', valor_muestra = '0' WHERE muestra = '';