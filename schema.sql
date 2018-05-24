CREATE DATABASE IF NOT EXISTS yeticave
  DEFAULT CHARACTER SET utf8
  DEFAULT COLLATE utf8_general_ci;

  USE yeticave;

  SET FOREIGN_KEY_CHECKS=0;

  CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  reg_date DATETIME,
  email VARCHAR(64),
  name VARCHAR(128),
  password VARCHAR(64),
  avatar VARCHAR(128),
  contact VARCHAR(128)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE categories (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(128)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE bets (
  id INT AUTO_INCREMENT PRIMARY KEY,
  date DATETIME,
  bet_sum INT,
  user_id INT,
  lot_id INT,
  FOREIGN KEY (user_id) REFERENCES users(id),
  FOREIGN KEY (lot_id) REFERENCES lots(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE lots (
  id INT AUTO_INCREMENT PRIMARY KEY,
  creation_date DATETIME,
  name VARCHAR(128),
  description VARCHAR(128),
  image VARCHAR(128),
  start_price INT,
  end_date DATETIME,
  lot_step INT,
  author_id INT,
  win_id INT,
  category_id INT,
  FOREIGN KEY (category_id) REFERENCES categories(id),
  FOREIGN KEY (author_id) REFERENCES users(id),
  FOREIGN KEY (win_id) REFERENCES users(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE INDEX lots ON lots(category_id);

CREATE UNIQUE INDEX name ON lots(name);
CREATE UNIQUE INDEX email ON users(email);