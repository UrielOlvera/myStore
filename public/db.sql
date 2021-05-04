create database myStore
create table Producto(
	producto_id varchar(25) primary key not null,
	nombre varchar(30) not null,
	precio decimal not null,
	descripcion varchar(100),
	categoria varchar(30) not null,
	stock int not null,
	unidad varchar(5)
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
	producto varchar(25) not null,
	venta int not null,
	cantidad int not null,
	stat int default 1 not null,
	constraint fk_producto foreign key (producto) references Producto (producto_id),
	constraint fk_venta foreign key (venta) references Venta (venta_id)
);
create table Usuario(
	username varchar(30) primary key not null,
	pass varchar(30) not null,
	nivel int default 1 not null,
	auth_clv int not null
);
create table Wallet(
	cod int primary key not null,
	puntos int not null
);