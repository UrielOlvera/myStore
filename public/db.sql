create database myStore
create table Producto(
	producto_id int  AUTO_INCREMENT primary key not null,
	nombre varchar(30) not null,
	precio decimal not null,
	descripcion varchar(100),
	categoria varchar(30) not null,
	stock int not null
);
create table Proveedor(
	proveedor_id int  AUTO_INCREMENT primary key not null,
	nombre varchar(50) not null,
	telefono int not null,
	email varchar(30),
	direccion varchar(50),
	referencia varchar(50)
);
create table Venta(
	venta_id int  AUTO_INCREMENT primary key not null,
	total decimal not null,
	fecha datetime not null,
	stat int default 1 not null
);
create table Detalles_venta(
	detalles_id int  AUTO_INCREMENT primary key not null,
	producto int not null,
	venta int not null,
	cantidad int not null,
	stat int default 1 not null,
	constraint fk_producto foreign key (producto) references Producto (producto_id),
	constraint fk_venta foreign key (venta) references Venta (venta_id)
);
create table Usuario(
	usuario_id int  AUTO_INCREMENT primary key not null,
	username varchar(30) not null,
	pass varchar(30) not null,
	nivel int default 1 not null,
	auth_clv int not null
);
create table Wallet(
	cod int primary key not null,
	puntos int not null
);