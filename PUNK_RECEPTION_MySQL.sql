-- BASE DE DATOS DE ROBOT PUNK - PUNK RECEPTION
-- MySQL

CREATE DATABASE IF NOT EXISTS PUNK_RECEPTION;
USE PUNK_RECEPTION;

-- 1. Tabla Tutor
CREATE TABLE Tutor (
    id_tutor INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    apellidos VARCHAR(100) NOT NULL,
    correo VARCHAR(150) UNIQUE NOT NULL,
    contrasena VARCHAR(255) NOT NULL,
    telefono VARCHAR(20) NOT NULL
);

-- 2. Tabla Admin
CREATE TABLE Administrador (
    id_admin INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    apellidos VARCHAR(100) NOT NULL,
    correo VARCHAR(150) UNIQUE NOT NULL,
    contrasena VARCHAR(255) NOT NULL
);

-- 3. Tabla Profesor
CREATE TABLE Profesor (
    id_profesor INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    apellidos VARCHAR(100) NOT NULL,
    correo VARCHAR(150) UNIQUE NOT NULL,
    contrasena VARCHAR(255) NOT NULL,
    telefono VARCHAR(20),
    horario_atencion VARCHAR(100),
    fotografia TEXT
);

-- 4. Tabla Costo
CREATE TABLE Costo (
    id_costo INT AUTO_INCREMENT PRIMARY KEY,
    concepto VARCHAR(255) NOT NULL,
    precio DECIMAL(10,2) NOT NULL
);

-- 5. Tabla Alumno
CREATE TABLE Alumno (
    id_alumno INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    apellidos VARCHAR(100) NOT NULL,
    fecha_nacimiento DATE,
    genero VARCHAR(20),
    escuela VARCHAR(150),
    nivel_escolar VARCHAR(50),
    grado_escolar VARCHAR(50),
    alergias TEXT,
    padecimientos TEXT,
    medicamento TEXT,
    id_tutor INT NOT NULL,
    CONSTRAINT FK_Alumno_Tutor FOREIGN KEY (id_tutor) REFERENCES Tutor(id_tutor)
);

-- 6. Tabla Noticia
CREATE TABLE Noticia (
    id_noticia INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(200) NOT NULL,
    contenido TEXT NOT NULL,
    categoria VARCHAR(200) NOT NULL,
    fecha_publicacion DATETIME NOT NULL,
    id_admin INT NOT NULL,
    CONSTRAINT FK_Noticia_Admin FOREIGN KEY (id_admin) REFERENCES Administrador(id_admin)
);

-- 7. Tabla Evento
CREATE TABLE Evento (
    id_evento INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(200) NOT NULL,
    descripcion TEXT,
    fecha_programada DATETIME NOT NULL,
    id_admin INT NOT NULL,
    CONSTRAINT FK_Evento_Admin FOREIGN KEY (id_admin) REFERENCES Administrador(id_admin)
);

-- 8. Tabla Grupo
CREATE TABLE Grupo (
    id_grupo INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    horario VARCHAR(100),
    aula VARCHAR(50),
    id_admin INT NOT NULL,
    CONSTRAINT FK_Grupo_Admin FOREIGN KEY (id_admin) REFERENCES Administrador(id_admin)
);

-- 9. Tabla Pago_Recibo
CREATE TABLE Pago_Recibo (
    id_pago INT AUTO_INCREMENT PRIMARY KEY,
    fecha DATETIME NOT NULL,
    descuento DECIMAL(5,2) DEFAULT 0.00,
    monto DECIMAL(10,2) NOT NULL,
    estatus VARCHAR(50) NOT NULL,
    recibo_pdf TEXT,
    id_admin INT NOT NULL,
    id_costo INT NOT NULL,
    id_alumno INT NOT NULL,
    CONSTRAINT FK_Pago_Admin FOREIGN KEY (id_admin) REFERENCES Administrador(id_admin),
    CONSTRAINT FK_Pago_Costo FOREIGN KEY (id_costo) REFERENCES Costo(id_costo),
    CONSTRAINT FK_Pago_Alumno FOREIGN KEY (id_alumno) REFERENCES Alumno(id_alumno)
);

-- 10. Tabla Inscripcion
CREATE TABLE Inscripcion (
    id_inscripcion INT AUTO_INCREMENT PRIMARY KEY,
    id_grupo INT NOT NULL,
    id_pago INT NOT NULL,
    id_alumno INT NOT NULL,
    CONSTRAINT FK_Inscripcion_Grupo FOREIGN KEY (id_grupo) REFERENCES Grupo(id_grupo),
    CONSTRAINT FK_Inscripcion_Pago FOREIGN KEY (id_pago) REFERENCES Pago_Recibo(id_pago),
    CONSTRAINT FK_Inscripcion_Alumno FOREIGN KEY (id_alumno) REFERENCES Alumno(id_alumno)
);

-- 11. Tabla Responsable
CREATE TABLE Responsable (
    id_responsable INT AUTO_INCREMENT PRIMARY KEY,
    id_profesor INT NOT NULL,
    id_inscripcion INT NOT NULL,
    CONSTRAINT FK_Responsable_Profesor FOREIGN KEY (id_profesor) REFERENCES Profesor(id_profesor),
    CONSTRAINT FK_Responsable_Inscripcion FOREIGN KEY (id_inscripcion) REFERENCES Inscripcion(id_inscripcion)
);

-- 12. Tabla Proyecto
CREATE TABLE Proyecto (
    id_proyecto INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(200) NOT NULL,
    clase VARCHAR(200) NOT NULL,
    descripcion TEXT,
    archivo_multimedia TEXT,
    fecha DATETIME,
    id_profesor INT NOT NULL,
    id_alumno INT NOT NULL,
    CONSTRAINT FK_Proyecto_Profesor FOREIGN KEY (id_profesor) REFERENCES Profesor(id_profesor),
    CONSTRAINT FK_Proyecto_Alumno FOREIGN KEY (id_alumno) REFERENCES Alumno(id_alumno)
);

-- 13. Tabla Reporte (Incluye id_profesor e id_grupo)
CREATE TABLE Reporte (
    id_reporte INT AUTO_INCREMENT PRIMARY KEY,
    fecha DATETIME NOT NULL,
    desempeno TEXT,
    conducta TEXT,
    id_profesor INT NOT NULL,
    id_alumno INT NOT NULL,
    id_grupo INT NOT NULL,
    CONSTRAINT FK_Reporte_Profesor FOREIGN KEY (id_profesor) REFERENCES Profesor(id_profesor),
    CONSTRAINT FK_Reporte_Alumno FOREIGN KEY (id_alumno) REFERENCES Alumno(id_alumno),
    CONSTRAINT FK_Reporte_Grupo FOREIGN KEY (id_grupo) REFERENCES Grupo(id_grupo)
);

-- 14. Tabla Participacion
CREATE TABLE Participacion (
    id_participacion INT AUTO_INCREMENT PRIMARY KEY,
    id_proyecto INT NOT NULL,
    id_alumno INT NOT NULL,
    CONSTRAINT FK_Participacion_Proyecto FOREIGN KEY (id_proyecto) REFERENCES Proyecto(id_proyecto),
    CONSTRAINT FK_Participacion_Alumno FOREIGN KEY (id_alumno) REFERENCES Alumno(id_alumno)
);


-- INSERTAR DATOS 

-- 1. Inserts para Tabla Tutor
INSERT INTO Tutor (nombre, apellidos, correo, contrasena, telefono) VALUES
('Carlos', 'Mendoza Garza', 'carlos.mendoza@email.com', '1234', '8711234567'),
('Maria', 'Lopez Hernandez', 'maria.lopez@email.com', '1234', '8717654321'),
('Roberto', 'Sanchez Trevino', 'roberto.sanchez@email.com', '1234', '8719876543');

-- 2. Inserts para Tabla Administrador
INSERT INTO Administrador (nombre, apellidos, correo, contrasena) VALUES
('Ana', 'Torres Reyes', 'admin.ana@robotpunk.com', '1234'),
('Luis', 'Ramirez Castro', 'admin.luis@robotpunk.com', '1234'),
('Sofia', 'Villarreal Morales', 'admin.sofia@robotpunk.com', '1234');

-- 3. Inserts para Tabla Profesor
INSERT INTO Profesor (nombre, apellidos, correo, contrasena, telefono, horario_atencion, fotografia) VALUES
('Jorge', 'Gomez Ruiz', 'jorge.gomez@robotpunk.com', '1234', '8711112233', 'Lunes a Viernes 16:00 - 18:00', 'prof_jorge.jpg'),
('Elena', 'Martinez Solis', 'elena.martinez@robotpunk.com', '1234', '8714445566', 'Martes y Jueves 15:00 - 19:00', 'prof_elena.jpg'),
('David', 'Fernandez Vega', 'david.fernandez@robotpunk.com', '1234', '8717778899', 'Sabados 09:00 - 13:00', 'prof_david.jpg');

-- 4. Inserts para Tabla Costo
INSERT INTO Costo (concepto, precio) VALUES
('Inscripcion Anual Robotica', 1500.00),
('Mensualidad Curso Lego Mindstorms', 1200.00),
('Taller de Programacion Python y Arduino', 850.00);

-- 5. Inserts para Tabla Alumno
INSERT INTO Alumno (nombre, apellidos, fecha_nacimiento, genero, escuela, nivel_escolar, grado_escolar, alergias, padecimientos, medicamento, id_tutor) VALUES
('Mateo', 'Mendoza Lopez', '2012-05-14', 'Masculino', 'Instituto Cumbres', 'Primaria', '5to', 'Polen', 'Ninguno', 'Ninguno', 1),
('Valentina', 'Lopez Perez', '2014-08-22', 'Femenino', 'Colegio Cervantes', 'Primaria', '3ro', 'Nueces', 'Asma leve', 'Inhalador si se requiere', 2),
('Diego', 'Sanchez Morales', '2010-11-03', 'Masculino', 'Escuela Federal 1', 'Secundaria', '2do', 'Ninguna', 'Ninguno', 'Ninguno', 1);

-- 6. Inserts para Tabla Noticia
INSERT INTO Noticia (titulo, contenido, categoria, fecha_publicacion, id_admin) VALUES
('Apertura de inscripciones 2026', 'Iniciamos las inscripciones para los nuevos talleres de robotica y programacion.', 'Importante', '2026-01-10 10:00:00', 1),
('Torneo Regional de Robotica', 'Nuestros alumnos participaran en el torneo estatal este fin de mes.', 'Importante', '2026-02-15 12:30:00', 2),
('Nuevos Kits Arduino adquiridos', 'Hemos actualizado nuestros laboratorios con kits de sensores de ultima generacion.', 'Materiales', '2026-03-01 09:15:00', 1);

-- 7. Inserts para Tabla Evento
INSERT INTO Evento (titulo, descripcion, fecha_programada, id_admin) VALUES
('Taller de Puertas Abiertas', 'Demostracion en vivo de proyectos para padres de familia.', '2026-03-20 17:00:00', 1),
('Competencia Interna Sumo Bot', 'Competencia divertida entre los estudiantes de nivel avanzado.', '2026-04-10 11:00:00', 2),
('Exposicion Tecnologica Anual', 'Presentacion final de proyectos integradores del semestre.', '2026-06-15 16:00:00', 3);

-- 8. Inserts para Tabla Grupo
INSERT INTO Grupo (nombre, horario, aula, id_admin) VALUES
('Robotica Inicial - Ninos', 'Lunes y Miercoles 16:00 - 17:30', 'Aula A1', 1),
('Arduino Avanzado', 'Martes y Jueves 17:00 - 18:30', 'Lab Electronica', 2),
('Competencia Lego', 'Sabados 09:00 - 12:00', 'Aula B2', 1);

-- 9. Inserts para Tabla Pago_Recibo
INSERT INTO Pago_Recibo (fecha, descuento, monto, estatus, recibo_pdf, id_admin, id_costo, id_alumno) VALUES
('2026-01-12 11:20:00', 0.00, 1500.00, 'Pagado', 'recibo_pago_001.pdf', 1, 1, 1),
('2026-01-15 14:45:00', 10.00, 1080.00, 'Pagado', 'recibo_pago_002.pdf', 2, 2, 2),
('2026-02-01 10:05:00', 0.00, 850.00, 'Pendiente', 'recibo_pago_003.pdf', 3, 3, 3);

-- 10. Inserts para Tabla Inscripcion
INSERT INTO Inscripcion (id_grupo, id_pago, id_alumno) VALUES
(1, 1, 1),
(2, 2, 2),
(3, 3, 3);

-- 11. Inserts para Tabla Responsable
INSERT INTO Responsable (id_profesor, id_inscripcion) VALUES
(1, 1),
(2, 2),
(3, 3);

-- 12. Inserts para Tabla Proyecto
INSERT INTO Proyecto (titulo, clase, descripcion, archivo_multimedia, fecha, id_profesor, id_alumno) VALUES
('Brazo Robotico Bluetooth', 'Makers', 'Proyecto de ensamble y control inalambrico mediante app movil.', 'images/1.jpeg', '2026-02-28 18:00:00', 1, 1),
('Seguidor de Linea Automatico', 'Vex IQ', 'Vehiculo autonomo con sensores infrarrojos para trazados rapidos.', 'images/2.jpeg', '2026-03-05 17:30:00', 2, 2),
('Estacion Meteorologica IoT', 'Makers', 'Medicion de temperatura y humedad enviada por Wi-Fi a dashboard.', 'images/3.jpeg', '2026-03-12 16:00:00', 3, 3);

-- 13. Inserts para Tabla Reporte (Incluye id_grupo e id_profesor)
INSERT INTO Reporte (fecha, desempeno, conducta, id_profesor, id_alumno, id_grupo) VALUES
('2026-02-01 18:00:00', 'Excelente desempeno en la programacion de servomotores.', 'Ejemplar y colaborativo con sus companeros.', 1, 1, 1),
('2026-02-15 18:00:00', 'Buen avance en la logica de programacion y resolucion de algoritmos.', 'Participativa, aunque en ocasiones requiere recordar enfocarse.', 2, 2, 2),
('2026-03-01 18:00:00', 'Sobresaliente en el armado de estructuras mecanicas complejas.', 'Muy responsable, puntual y atento.', 3, 3, 3);

-- 14. Inserts para Tabla Participacion
INSERT INTO Participacion (id_proyecto, id_alumno) VALUES
(1, 1),
(1, 2),
(2, 3);
