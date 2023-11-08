CREATE DATABASE IF NOT EXISTS GuchuSys;

USE GuchuSys;

CREATE TABLE IF NOT EXISTS remedies(
	rID int PRIMARY KEY NOT NULL AUTO_INCREMENT,
	name VARCHAR(255) NOT NULL,
	description VARCHAR(500),
	picture VARCHAR(1000) NOT NULL,
	tag VARCHAR(255) NOT NULL,
	price DOUBLE NOT NULL
);

CREATE TABLE IF NOT EXISTS orders(
	oID int not null primary key auto_increment,
	User_ID int NOT NULL,
	remedies VARCHAR(1000) NOT NULL,
	Order_date VARCHAR(255),
	delivery_date VARCHAR(255),
	total DOUBLE,
	status VARCHAR(45)
);

CREATE TABLE IF NOT EXISTS admin(
	aID int PRIMARY KEY NOT NULL AUTO_INCREMENT,
	f_name VARCHAR(255) NOT NULL,
	s_name VARCHAR(255) NOT NULL,
	username VARCHAR(255) NOT NULL,
	email VARCHAR(255) NOT NULL,
	role VARCHAR(45) NOT NULL,
	address VARCHAR(500),
	password VARCHAR(1000) NOT NULL
);

INSERT INTO admin(f_name, s_name, username, email, role, address, password) VALUES('My', 'User', 'Myuser', 'myuser@test.com', 'admin','', 'SA1@123');