CREATE DATABASE IF NOT EXISTS Cakes;

USE Cakes;

CREATE TABLE IF NOT EXISTS products(
	ID int PRIMARY KEY NOT NULL AUTO_INCREMENT,
	name VARCHAR(255) NOT NULL,
	description VARCHAR(500),
	picture VARCHAR(1000) NOT NULL,
	quantity int NOT NULL,
	price DOUBLE NOT NULL
);

INSERT INTO products(name, description, picture, quantity, price) VALUES('Chocolate Cake', 'Rich chocolate cake stacked with a thick layer of rich chocolate icing coat inbetween stacks & covering the outside.', 'triple-chocolate-cake-4.jpg', '61', '52.99');

INSERT INTO products(name, description, picture, quantity, price) VALUES('Red Velvet Cake', 'Redvelvet cake with vanilla icing covering the outside and in between to cake stacks.', 'Red-Velvet-Cake-IMAGE-43.jpg', '52', '55.99');

INSERT INTO products(name, description, picture, quantity, price) VALUES('Chocolate Molten Cake', 'Mini-chocolate cake with a molten chocolate inside.', 'images.jpeg', '46', '62.90');

INSERT INTO products(name, description, picture, quantity, price) VALUES('Easter Bunny Cake', 'A cake for the one season of the year that hs a rainbow icing coat and multiple cake stacks.', 'easter-bunny-mini-cakes-1200-featured-735x735.jpg', '74', '43.99');

INSERT INTO products(name, description, picture, quantity, price) VALUES('Wedding Cake', 'A special cake for the most special day of a peoples lives.', 'b8161e2c9a7c95d9221d053bbf52a235.jpg', '15', '104.99');

INSERT INTO products(name, description, picture, quantity, price) VALUES('New Year Cake', 'Concept party cake for the event that comes around once a year.', '6ee02a8922c21b2833d0a067f404afb9.jpg', '34', '83.99');

CREATE TABLE IF NOT EXISTS admin(
	Order_ID int not null primary key auto_increment,
	User_ID int NOT NULL,
	Product_ID int NOT NULL,
	p_quantity int,
	Order_date VARCHAR(255),
	delivery_date VARCHAR(255),
	total DOUBLE,
	status VARCHAR(45),
	constraint FK_users foreign key(User_ID) references users(ID),
	constraint FK_Products foreign key(Product_ID) references products(ID)
);

CREATE TABLE IF NOT EXISTS users(
	ID int PRIMARY KEY NOT NULL AUTO_INCREMENT,
	f_name VARCHAR(255) NOT NULL,
	s_name VARCHAR(255) NOT NULL,
	username VARCHAR(255) NOT NULL,
	email VARCHAR(255) NOT NULL,
	role VARCHAR(45) NOT NULL,
	address VARCHAR(500),
	password VARCHAR(1000) NOT NULL
);

INSERT INTO users(f_name, s_name, username, email, role, address, password) VALUES('My', 'User', 'Myuser', 'myuser@test.com', 'admin','', 'SA1@123');