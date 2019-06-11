CREATE DATABASE TiendaOnline;
USE TiendaOnline;

CREATE TABLE Admin(
	id INT NOT NULL AUTO_INCREMENT,
	PRIMARY KEY (id),
	username VARCHAR(50),
	password VARCHAR(50),
	name VARCHAR(50)
);

INSERT INTO Admin(username,password,name) VALUES ('a','12345',' ad');

#-------------------------------------------------------------------------------------

CREATE TABLE clientes(
	id INT(255) NOT NULL AUTO_INCREMENT,
	PRIMARY KEY (id),
	username VARCHAR(255) NOT NULL,
	password VARCHAR(255) NOT NULL,
	name VARCHAR(255) NOT NULL
);

#-------------------------------------------------------------------------------------

CREATE TABLE Productos (
  	id INT(255) NOT NULL,
	PRIMARY KEY(id),
	descripcionProducto TEXT,
  	price double(6,3) NOT NULL,
  	imagen varchar(255) NOT NULL,
  	name varchar(255) NOT NULL,
  	id_categoria int(11) NOT NULL,
  	oferta int(11) NOT NULL
);

#-------------------------------------------------------------------------------------

CREATE TABLE EnStock(
	idstock INT(255) NOT NULL AUTO_INCREMENT,
	PRIMARY KEY (idstock),
	id_producto INT (255),
	cantidadStock INT(255),
	TallaS VARCHAR(50)
);

#-------------------------------------------------------------------------------------

CREATE TABLE carro (
	id int(255) NOT NULL AUTO_INCREMENT,
	PRIMARY KEY(id),
  	id_cliente int(255) NOT NULL,
  	id_producto int(255) NOT NULL,
  	cant int(255) NOT NULL,
	talla VARCHAR(50) NOT NULL
);

#-------------------------------------------------------------------------------------

CREATE TABLE Compra (
	id int(255) NOT NULL AUTO_INCREMENT,
	PRIMARY KEY(id),
	id_cliente int(255),
	fecha DATETIME,
	monto FLOAT,
	estado INT
);

#-------------------------------------------------------------------------------------

CREATE TABLE Productos_Compra (
	id int(255) NOT NULL AUTO_INCREMENT,
	PRIMARY KEY(id),
	id_compra INT(255),
	id_producto INT(255),
	cantidad INT(255),
	monto FLOAT
);

#-------------------------------------------------------------------------------------

CREATE TABLE categorias(
	id INT(255) NOT NULL AUTO_INCREMENT,
	PRIMARY KEY(id),
	categoria VARCHAR(255)
);

#-------------------------------------------------------------------------------------

CREATE TABLE pagos (
   	id int(255) NOT NULL AUTO_INCREMENT,
	PRIMARY KEY(id),
   	id_cliente int(255) NOT NULL,
   	id_compra int(255) NOT NULL,
   	comprobante varchar(255) NOT NULL,
   	nombre varchar(255) NOT NULL,
   	fecha datetime NOT NULL,
   	estado int(11) NOT NULL
);









