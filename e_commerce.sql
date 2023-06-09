SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+03:00";

DROP TABLE IF EXISTS Persona;
DROP TABLE IF EXISTS Producto;
DROP TABLE IF EXISTS Carrito;
DROP TABLE IF EXISTS Factura;
DROP TABLE IF EXISTS Compra;

CREATE TABLE Persona (
    id_Persona		INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Email		    VARCHAR(255) UNIQUE,
    Passw		    VARCHAR(255) NOT NULL,
    Nombre		    VARCHAR(100) NOT NULL,
    Apellido		VARCHAR(100) NOT NULL,
    Direccion		VARCHAR(100) NOT NULL,
    Ciudad 		    VARCHAR(100) NOT NULL,
    Sexo 		    VARCHAR(100) NULL,
    Provincia 		VARCHAR(100) NOT NULL,
    Pais 		    VARCHAR(100) NOT NULL,
    Codigo_Postal	VARCHAR(100) NOT NULL,
    Otros_Datos 	TEXT NULL,
    Date_update		timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    Date_register	timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
)DEFAULT CHARSET=utf8mb3;

CREATE TABLE Producto (
    id_Producto 	INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Nombre 		    VARCHAR(255) NOT NULL,
    Descripcion 	VARCHAR(255) NOT NULL,
    Costo 		    DECIMAL(19 , 4) NOT NULL,
    Imagen 		    VARCHAR(100) NULL,
    Date_update 	timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    Date_register 	timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
)DEFAULT CHARSET=utf8mb3;

CREATE TABLE Carrito (
    fk_id_Persona 	INT NOT NULL,
    fk_id_Producto 	INT NOT NULL,
    Cantidad 		INT NOT NULL,
    Date_update 	timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    Date_register 	timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
)DEFAULT CHARSET=utf8mb3;

CREATE TABLE Factura (
    id_Factura 		INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Total 		    DECIMAL(19 , 4) NOT NULL,
    Metodo_Pago 	VARCHAR(50) NOT NULL, /**/
    Estado_Transaccion 	VARCHAR(20) NOT NULL, /*PENDIENTE - APROBADO - RECHAZADO*/
    Date_update 	timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    Date_register 	timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
)DEFAULT CHARSET=utf8mb3;

CREATE TABLE Compra (
    fk_id_Factura 	INT NOT NULL,
    fk_id_Persona 	INT NOT NULL,
    fk_id_Producto 	INT NOT NULL,
    Cantidad 		INT NOT NULL,
    Date_update 	timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    Date_register 	timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
)DEFAULT CHARSET=utf8mb3;

ALTER TABLE Carrito
  ADD CONSTRAINT `fk_Carrito_Persona` FOREIGN KEY (`fk_id_Persona`) 
  REFERENCES `Persona` (`id_Persona`) 
  ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_Carrito_Producto` FOREIGN KEY (`fk_id_Producto`) 
  REFERENCES `Producto` (`id_Producto`) 
  ON DELETE CASCADE ON UPDATE CASCADE,
  ADD PRIMARY KEY (`fk_id_Persona`,`fk_id_Producto`);

ALTER TABLE Compra
  ADD CONSTRAINT `fk_Factura` FOREIGN KEY (`fk_id_Factura`) 
  REFERENCES `Factura` (`id_Factura`)
  ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_Compra_Persona` FOREIGN KEY (`fk_id_Persona`) 
  REFERENCES `Persona` (`id_Persona`)
  ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_Compra_Producto` FOREIGN KEY (`fk_id_Producto`) 
  REFERENCES `Producto` (`id_Producto`) 
  ON DELETE CASCADE ON UPDATE CASCADE,
  ADD PRIMARY KEY (`fk_id_Factura`,`fk_id_Persona`,`fk_id_Producto`);

-- PARA INSERTAR REGISTROS NO NECESITAMOS ESPECIFICAR LAS FECHAS
-- AL UTILIZAR CURRENT_TIMESTAMP ES SUFICIENTE
-- CUANDO ALGUN CAMPO DE LA FILA ES ACTUALIZADO SE EJECUTA EL METODO 'ON UPDATE'
-- Y GUARDA LA ULTIMA FECHA DE EDICIÓN DE LA TABLA 


INSERT INTO Persona
( Email, Passw, Nombre, Apellido, Direccion, Ciudad, Sexo, Provincia, Pais, Codigo_Postal )
VALUES
( 'usuario@gmail.com', 'passw123', 'Diego', 'Perez', 'C 73 N 1502', 'Necochea', 'Masculino', 'Bs As', 'Argentina', '6350');