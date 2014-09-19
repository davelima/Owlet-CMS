SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS administrators;
DROP TABLE IF EXISTS categories;
DROP TABLE IF EXISTS blog;
DROP TABLE IF EXISTS blogviews;
DROP TABLE IF EXISTS comments;
DROP TABLE IF EXISTS messages;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS mailing;
DROP TABLE IF EXISTS tags;
DROP TABLE IF EXISTS banners;
DROP TABLE IF EXISTS tickets;
DROP TABLE IF EXISTS ticketresponses;
DROP TABLE IF EXISTS rsssources;
DROP TABLE IF EXISTS pagseguroconfig;
DROP TABLE IF EXISTS pagseguroorders;
SET FOREIGN_KEY_CHECKS = 1;

CREATE TABLE administrators (
  name varchar(64) COLLATE utf8_bin NOT NULL,
  username varchar(64) COLLATE utf8_bin NOT NULL,
  email varchar(255) COLLATE utf8_bin DEFAULT NULL,
  password varchar(255) COLLATE utf8_bin NOT NULL,
  permissions text COLLATE utf8_bin,
  root tinyint(1) NOT NULL DEFAULT '0',
  id int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (id),
  UNIQUE KEY username (username)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE categories(
	title VARCHAR(100) NOT NULL,
	description VARCHAR(160),
	parent INT(11),
	id INT(11) AUTO_INCREMENT,
	FOREIGN KEY(parent) REFERENCES categories(id) ON DELETE CASCADE ON UPDATE CASCADE,
	PRIMARY KEY(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE blog(
	title VARCHAR(100) NOT NULL,
	preview TEXT,
	body TEXT NOT NULL,
	slug VARCHAR(255) NOT NULL,
	head TEXT,
	category INT(11),
	tags TEXT,
	visible BOOLEAN DEFAULT 1,
	timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	id INT(11) AUTO_INCREMENT,
	FOREIGN KEY(category) REFERENCES categories(id) ON DELETE SET NULL ON UPDATE CASCADE,
	PRIMARY KEY(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE blogviews(
	post INT(11) NOT NULL,
	timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	ip VARCHAR(15) NOT NULL,
	id INT(11) AUTO_INCREMENT,
	PRIMARY KEY(id),
	FOREIGN KEY(post) REFERENCES blog(id) ON DELETE CASCADE ON UPDATE CASCADE
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE comments(
	name VARCHAR(128) NOT NULL,
	body TEXT NOT NULL,
	timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	post INT(11) NOT NULL,
	reply INT(11),
	id INT(11) AUTO_INCREMENT,
	FOREIGN KEY(post) REFERENCES blog(id) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY(reply) REFERENCES comments(id) ON DELETE CASCADE ON UPDATE CASCADE,
	PRIMARY KEY(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE messages(
	name VARCHAR(128) NOT NULL,
	email VARCHAR(255),
	phone VARCHAR(11),
	subject VARCHAR(128),
	body TEXT NOT NULL,
	isread BOOLEAN NOT NULL DEFAULT false,
	timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	id INT(11) AUTO_INCREMENT,
	PRIMARY KEY(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE tags(
	title VARCHAR(60) NOT NULL,
	id INT(11) AUTO_INCREMENT,
	PRIMARY KEY(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE users(
	name VARCHAR(64) NOT NULL,
	email VARCHAR(255) UNIQUE NOT NULL,
	password VARCHAR(255) NOT NULL,
	address VARCHAR(255),
	number VARCHAR(10) DEFAULT "S/N",
	addresscomplement VARCHAR(64),
	neighborhood VARCHAR(64),
	cep VARCHAR(8),
	city VARCHAR(64),
	state VARCHAR(2),
	phone VARCHAR(11),
	id INT(11) AUTO_INCREMENT,
	PRIMARY KEY(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE mailing(
	email VARCHAR(255) UNIQUE NOT NULL,
	timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	status BOOLEAN NOT NULL DEFAULT false,
	token VARCHAR(40) NOT NULL,
	id INT(11) AUTO_INCREMENT,
	PRIMARY KEY(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE banners (
  title VARCHAR(128) NOT NULL,
  since datetime,
  until datetime,
  permanent tinyint(1) NOT NULL DEFAULT false,
  src VARCHAR(255) NOT NULL,
  position INT(11),
  id INT(11) AUTO_INCREMENT,
  link VARCHAR(255),
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


CREATE TABLE tickets(
	title VARCHAR(128) NOT NULL,
	body TEXT NOT NULL,
	member INT NOT NULL,
	status ENUM('waiting_admin', 'waiting_user', 'closed'),
	timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	id INT(11) AUTO_INCREMENT,
	PRIMARY KEY(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE ticketresponses(
	body TEXT NOT NULL,
	ticket INT NOT NULL,
	member INT,
	admin INT,
	timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	id INT(11) AUTO_INCREMENT,
	PRIMARY KEY(id),
	FOREIGN KEY(member) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY(admin) REFERENCES administrators(id) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY(ticket) REFERENCES tickets(id) ON DELETE CASCADE ON UPDATE CASCADE
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE rsssources(
	url VARCHAR(255) NOT NULL,
	title VARCHAR(255) NOT NULL,
	timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	id INT(11) AUTO_INCREMENT,
	PRIMARY KEY(id)
)ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


/* Apenas para módulos de pagamento */
CREATE TABLE pagseguroconfig(
	email VARCHAR(255) NOT NULL,
	token VARCHAR(255) NOT NULL,
	title VARCHAR(60) DEFAULT 'Conta sem título',
	id INT(11) AUTO_INCREMENT,
	PRIMARY KEY(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE pagseguroorders(
	reference VARCHAR(32) NOT NULL,
	items TEXT NOT NULL,
	customer TEXT NOT NULL,
	status INT NOT NULL,
	description TEXT,
	link TEXT,
	pagsegurocode VARCHAR(40),
	timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	id INT(11) AUTO_INCREMENT,
	PRIMARY KEY(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
