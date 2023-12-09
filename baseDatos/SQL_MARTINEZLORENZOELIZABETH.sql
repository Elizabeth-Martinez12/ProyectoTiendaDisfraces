create database TiendaDisfraces;

use TiendaDisfraces;

drop database TiendaDisfraces;

create table user_profiles (
    id tinyint not null auto_increment,
    profile_name varchar(20) not null unique,
    description varchar(100),
    status boolean default true,
    created_at datetime,
    updated_at datetime null,
    deleted_at datetime null,
    primary key(id)
);


create table users (
    id int not null auto_increment,
    username varchar(50) unique,
    password varchar(150),
    status boolean,
    profile_id tinyint not null,
    created_at datetime,
    updated_at datetime null,
    deleted_at datetime null,
    foreign key (profile_id) references user_profiles(id),
    primary key(id)
);


create table user_info (
    id int not null,
    first_name varchar(50),
    last_name varchar(80),
    birthday date null,
    gender char(1),
    age int not null,
    phone int(15) null,
    photo blob,
    status boolean default true,
    created_at datetime,
    updated_at datetime null,
    deleted_at datetime null,
    foreign key (id) references users(id),
    primary key(id)
);


create table costumes (
    id int not null auto_increment,
    idCategory int not null,
    image blob,
    costume_name varchar(100),
    description text,
    price decimal(10, 2),
    stock int,
    created_at datetime,
    updated_at datetime null,
    deleted_at datetime null,
    foreign key (idCategory) references costume_categories(id),
    primary key(id)
);


create table costume_comments (
    id int not null auto_increment,
    user_id int not null,
    costume_id int not null,
    comment_text text,
    created_at datetime,
    updated_at datetime null,
    deleted_at datetime null,
    primary key(id),
    foreign key (user_id) references users(id),
    foreign key (costume_id) references costumes(id)
);

create table costume_categories (
    id int not null auto_increment,
    name varchar(50) not null unique,
    description varchar(100),
    status boolean default true,
    created_at datetime,
    updated_at datetime null,
    deleted_at datetime null,
    primary key(id)
);


create table accessories (
	id int not null auto_increment,
	idCategory int not null,
	illustration blob,
	name varchar(30),
	quantity int not null,
	type varchar(20),
	material varchar(30),
	category varchar(30),
	price float not null,
	created_at datetime,
    updated_at datetime null,
    deleted_at datetime null,
    foreign key (idCategory) references costume_categories(id),
	primary key (id)
);

create table transactions (
    id int not null auto_increment,
    user_id int not null,
    costume_id int not null,
    quantity int not null,
    total_amount decimal(8, 2) not null,
    transaction_date datetime not null,
    created_at datetime null,
    updated_at datetime null,
    deleted_at datetime null,
    foreign key (user_id) references users(id),
    foreign key (costume_id) references costumes(id),
    primary key(id)
);





INSERT INTO user_profiles (id, profile_name, description,status , created_at)
values
    (1,'Administrador', 'Perfil de administrador del sistema',1,'2020/07/17'),
    (2,'Usuario', 'Perfil de usuario', 1,'2020/07/17');
   
   
INSERT INTO users (username, password, status, profile_id, created_at)
values
    ('Juanito', 'iguana23', 1, 1, '2020/07/17'),
    ('Mary', 'rosapastel', 1, 2, '2020/07/21'),
    ('Kike', 'chinodo', 0, 2, '2022/04/09'),
    ('Laura', 'coqui', 0, 2, '2021/03/13'),
    ('Pedro', 'pedrito23', 1, 2, '2020/11/12'),
    ('Anita', 'karolg', 0, 2, '2021/04/26'),
    ('Lalo', 'fuchalic', 1, 2, '2023/09/16'),
    ('Belle', 'carlos55', 1, 2, '2020/12/21'),
    ('Javy', 'menalu', 0, 2, '2021/03/17'),
    ('Sarita', 'tikkipla', 0, 2, '2022/03/02');


INSERT INTO user_info (id, first_name, last_name, birthday, gender, age, phone, photo, status, created_at)
values
    (1, 'Juan', 'Pérez', '1990-05-15', 'M', 33, 1234567890, 'https://img.freepik.com/fotos-premium/cierrese-encima-retrato-cara-feliz-sonriente-hombre-joven-caucasico-cerdas-fondo-gris-claro-aislado-estudio_8087-5198.jpg', 1, '2020/08/25'),
    (2, 'María', 'López', '1985-12-10', 'F', 38, 254587974, 'https://inmofotos.es/wp-content/uploads/2021/10/imagen-1_Mesa-de-trabajo-1.jpg', 1, '2021/06/01'),
    (3, 'Carlos', 'García', '1998-08-20', 'M', 25, 9876543210, 'https://img.freepik.com/foto-gratis/disparo-cabeza-hombre-atractivo-sonriendo-complacido-mirando-intrigado-pie-sobre-fondo-azul_1258-65468.jpg', 1, '2022/01/31'),
    (4, 'Laura', 'Martínez', '2000-03-25', 'F', 23, 5555555555, 'https://static.vecteezy.com/system/resources/thumbnails/030/340/951/small_2x/woman-watching-sunset-in-the-mountains-photo.jpg', 0, '2023/05/15'),
    (5, 'Pedro', 'Ramírez', '1995-11-05', 'M', 28, 459751687, 'https://img.freepik.com/foto-gratis/hombre-joven-guapo-nuevo-corte-pelo-estilo_176420-19637.jpg', 0, '2021/07/17'),
    (6, 'Ana', 'Sánchez', '1992-09-08', 'F', 31, 7777777777, 'https://img.freepik.com/foto-gratis/mujer-joven-guinando-ojo-sacando-lengua-tomando-selfie-contra-fondo-verde_23-2148178147.jpg?size=626&ext=jpg&ga=GA1.1.1826414947.1699228800&semt=ais', 1, '2020/12/13'),
    (7, 'Eduardo', 'Hernández', '1988-06-30', 'M', 35, 9999999999, 'https://pixnio.com/free-images/2019/01/13/2019-01-13-09-51-02.jpg', 0, '2021/03/24'),
    (8, 'Isabel', 'Gómez', '2002-04-12', 'F', 21, 3333333333, 'https://www.cibanco.com/work/models/cibanco/Resource/1983/1/images/bnr-landing-personas-mob.jpg', 0, '2022/11/28'),
    (9, 'Javier', 'Torres', '1993-07-18', 'M', 30, 8888888888, 'https://img.freepik.com/foto-gratis/retrato-hombre-blanco-aislado_53876-40306.jpg?size=626&ext=jpg&ga=GA1.1.1826414947.1699401600&semt=ais', 1, '2020/02/22'),
    (10, 'Sara', 'Fernández', '1997-02-03', 'F', 26, 4444444444, 'https://cdn.forbes.com.mx/2019/04/blackrrock-invertir-1-640x360.jpg', 1, '2023/06/21');

   
   
INSERT INTO costumes (id, idCategory, image, costume_name, description , price, stock, created_at)
values
    (1, 2,'https://m.media-amazon.com/images/I/715uZgIanYL._AC_SX522_.jpg', 'Disfraz de Pirata', 'Disfraz de pirata para hombres', 720, 50,'2020/03/17'),
    (2, 3,'https://m.media-amazon.com/images/I/81mPT0zyGEL._AC_SX466_.jpg', 'Disfraz de Princesa', 'Vestido de princesa para niñas', 500, 100, '2021/03/17'),
    (3, 6,'https://m.media-amazon.com/images/I/61Kc7gJ+ucL._AC_SY550_.jpg', 'Disfraz de Zombi', 'Disfraz de zombi aterrador', 300, 30, '2023/03/17'),
    (4, 1,'https://m.media-amazon.com/images/I/61aLHyV3hvL._AC_SX522_.jpg', 'Disfraz de Superhéroe', 'Disfraz de superhéroe para niños', 470, 75,'2022/03/17'),
    (5, 6,'https://m.media-amazon.com/images/I/81qscoH7gHL._AC_SX679_.jpg', 'Disfraz de Bruja', 'Disfraz de bruja para Halloween', 520, 40, '2022/03/17'),
    (6, 6,'https://m.media-amazon.com/images/I/81sO5Iyj0qL._AC_SY550_.jpg', 'Disfraz de Payaso', 'Disfraz de payaso divertido', 610, 60, '2023/03/17'),
    (7, 5,'https://m.media-amazon.com/images/I/61+yZNsah4L._AC_SX522_.jpg', 'Disfraz de Animales', 'Disfraz de animales para fiestas', 550, 55, '2021/03/17'),
    (8, 4,'https://m.media-amazon.com/images/I/51uSsncAEaL._AC_SX466_.jpg', 'Disfraz de Fantasma', 'Disfraz de fantasma asustadizo', 260, 70, '2020/03/17'),
    (9, 4,'https://m.media-amazon.com/images/I/81KNACr4PhL._AC_SY550_.jpg', 'Disfraz de Vampiro', 'Disfraz de vampiro elegante', 525, 25, '2021/03/17'),
    (10, 3,'https://m.media-amazon.com/images/I/715K1b-cCaL._AC_SX679_.jpg', 'Disfraz de Hada', 'Disfraz de hada mágica', 630, 45, '2023/03/17');

   
 
INSERT INTO costume_comments (id, user_id, costume_id, comment_text, created_at)
values
    (1, 1, 1, '¡Este disfraz es genial!', '2020/03/17'),
    (2, 2, 1, 'Mi hijo lo adoró', '2023/03/17'),
    (3, 3, 2, 'Me asustó mucho', '2021/03/17'),
    (4, 4, 3, 'Un disfraz muy espeluznante', '2020/03/17'),
    (5, 5, 4, 'Mis niños se divirtieron mucho', '2021/03/17'),
    (6, 6, 4, 'Perfecto para fiestas', '2022/03/17 09:40:00'),
    (7, 7, 5, 'Muy cómodo de llevar', '2022/03/17 09:40:00'),
    (8, 8, 6, '¡Me hice muchas fotos!', '2023/03/17 09:40:00'),
    (9, 9, 7, 'Divertido para los más pequeños', '2021/03/17'),
    (10, 10, 8, '¡Qué miedo pasé con este disfraz!', '2022/03/17');

   
INSERT INTO costume_categories (id, name, description, created_at) 
VALUES 
	(1, 'Superhéroes', 'Disfraces inspirados en superhéroes populares','2020/03/17'),
	(2, 'Histórico', 'Trajes de diferentes épocas históricas', '2020/03/18'),
	(3, 'Fantasía', 'Disfraces inspirados en mundos de fantasía', '2020/03/19'),
	(4, 'Ciencia ficción', 'Disfraces del género de ciencia ficción', '2020/03/20'),
	(5, 'Animales', 'Disfraces que se asemejan a varios animales', '2020/03/21'),
	(6, 'Películas', 'Disfraces de películas famosas', '2020/03/22'),
	(7, 'Parejas', 'Disfraces diseñados para parejas', '2020/03/23'),
	(8, 'Clásico', 'Disfraces clásicos y atemporales', '2020/03/24'),
	(9, 'Futurista', 'Disfraces con temática futurista', '2020/03/25'),
	(10, 'Memes', 'Disfraces inspirados en memes populares de Internet', '2020/03/26');

   
INSERT INTO accessories (id,idCategory, illustration, name, quantity, type, material, category, price, created_at) 
VALUES 
	(1,1, 'https://m.media-amazon.com/images/I/41StZmiuk1L._AC_SX679_.jpg', 'Sombrero de Pirata', 50, 'Sombrero', 'Poliéster', 'Histórico', 250, '2020/04/01'),
	(2,2, 'https://m.media-amazon.com/images/I/71lOCfemorL._AC_SX522_.jpg', 'Alas de hada', 100, 'Alas', 'Plumas', 'Fantasía', 400, '2020/04/02'),
	(3,3, 'https://m.media-amazon.com/images/I/51v9J1ffQsL._AC_SX679_.jpg', 'Casco espacial', 30, 'Casco', 'Plástico', 'Ciencia ficción', 520, '2020/04/03'),
	(4,4, 'https://m.media-amazon.com/images/I/9155CH9lYwL._AC_SX679_.jpg', 'Máscara de tigre', 20, 'Máscara', 'Látex', 'Animales', 220, '2020/04/04'),
	(5,5, 'https://m.media-amazon.com/images/I/51blu+5S4hL._AC_SL1500_.jpg', 'Bastón de mago', 40, 'Utilería', 'Madera', 'Fantasía', 150, '2020/04/05'),
	(6,6, 'https://m.media-amazon.com/images/I/61FAKFAFpML._AC_SL1200_.jpg', 'Star Wars Lightsaber', 15, 'Objeto', 'Plástico', 'Películas', 400, '2020/04/06'),
	(7,7, 'https://m.media-amazon.com/images/I/61IYHuRSzQL._AC_SX679_.jpg', 'Parejas', 25, 'Joyas', 'Metal', 'Parejas', 360, '2020/04/07'),
	(8,8, 'https://m.media-amazon.com/images/I/41RispjPBqL._AC_SX522_.jpg', 'Sombrero de copa', 35, 'Sombrero', 'Fieltro', 'Clásico', 310, '2020/04/08'),
	(9,9, 'https://m.media-amazon.com/images/I/61gUVO5a-3L.__AC_SX300_SY300_QL70_ML2_.jpg', 'Gafas futuristas', 50, 'Gafas', 'Plástico', 'Futurista', 120, '2020/04/09'),
	(10,10, 'https://m.media-amazon.com/images/I/61MEVWxrFpL._AC_SX522_.jpg', 'Máscara de vaca', 10, 'Máscara', 'Cartón', 'Memes', 200, '2020/04/10');


INSERT INTO transactions (user_id, costume_id, quantity, total_amount, transaction_date) 
VALUES 
(1, 3, 2, 49.98, '2021/05/17'),
(2, 7, 1, 39.99, '2023/05/17'),
(3, 1, 3, 38.97, '2020/05/17'),
(4, 5, 1, 15.99, '2021/05/17'),
(5, 10, 2, 11.98, '2022/05/17'),
(6, 2, 1, 19.99, '2023/06/17'),
(7, 4, 4, 35.96, '2021/06/17'),
(8, 8, 1, 16.99, '2022/07/17'),
(9, 6, 3, 89.97, '2023/08/17'),
(10, 9, 2, 19.98, '2021/10/17');



call tiendadisfraces.ListaDeDisfracesPorCategoria();

call tiendadisfraces.AgregarNuevoAccesorio(11, 'https://m.media-amazon.com/images/I/71JRuYbIjIL.__AC_SY300_SX300_QL70_ML2_.jpg', 
'Mascara de dinosaurio', 5, 'Mascara', 'Plastico', 'Ciencia Ficcion', 290, '2021/05/23');

call tiendadisfraces.ModificarElEstatusDeLos5PrimerosUsuarios(1);

call tiendadisfraces.EliminarComentariosDelAño2020('2020-01-01 00:00:00', '2020-12-31 23:59:59');

