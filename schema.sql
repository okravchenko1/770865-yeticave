CREATE DATABASE IF NOT EXISTS yeticave
  DEFAULT CHARACTER SET utf8
  DEFAULT COLLATE utf8_general_ci;

  USE yeticave;

  SET FOREIGN_KEY_CHECKS=0;

  CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  reg_date DATETIME,
  email VARCHAR(64) NOT NULL,
  username VARCHAR(128) NOT NULL,
  password VARCHAR(64) NOT NULL,
  avatar VARCHAR(128),
  contact VARCHAR(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE categories (
  id INT AUTO_INCREMENT PRIMARY KEY,
  category_name VARCHAR(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE bets (
  id INT AUTO_INCREMENT PRIMARY KEY,
  date DATETIME,
  bet_sum INT,
  user_id INT NOT NULL,
  lot_id INT NOT NULL,
  FOREIGN KEY (user_id) REFERENCES users(id),
  FOREIGN KEY (lot_id) REFERENCES lots(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE lots (
  id INT AUTO_INCREMENT PRIMARY KEY,
  creation_date DATETIME,
  name VARCHAR(128) NOT NULL,
  description VARCHAR(128) NOT NULL,
  image VARCHAR(128) NOT NULL,
  start_price INT NOT NULL,
  end_date DATETIME NOT NULL,
  lot_step INT NOT NULL,
  author_id INT NOT NULL,
  win_id INT,
  category_id INT NOT NULL,
  FOREIGN KEY (category_id) REFERENCES categories(id),
  FOREIGN KEY (author_id) REFERENCES users(id),
  FOREIGN KEY (win_id) REFERENCES users(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE INDEX lots ON lots(category_id);

CREATE UNIQUE INDEX name ON lots(name);
CREATE UNIQUE INDEX email ON users(email);