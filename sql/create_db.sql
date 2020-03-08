CREATE DATABASE IF NOT EXISTS viravira;
USE viravira;

CREATE TABLE account(
  account_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  username VARCHAR(64) NOT NULL,
  password CHAR(60) NOT NULL,
  email VARCHAR(128)
);

CREATE TABLE excursion(
    excursion_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(512) NOT NULL,
    type VARCHAR(256) NOT NULL,
    thumbnail_url VARCHAR(512) NOT NULL
);

CREATE TABLE excursion_description(
    excursion_id INT NOT NULL,
    header VARCHAR(128) NOT NULL,
    description VARCHAR(1024),
    PRIMARY KEY (excursion_id, header),
    FOREIGN KEY (excursion_id) REFERENCES excursion(excursion_id)
);

CREATE TABLE excursion_detail(
    excursion_id INT NOT NULL,
    detail_key VARCHAR(128) NOT NULL,
    detail_value VARCHAR(512),
    PRIMARY KEY (excursion_id, detail_key),
    FOREIGN KEY (excursion_id) REFERENCES excursion(excursion_id)
);

CREATE TABLE excursion_image(
    excursion_id INT NOT NULL,
    image_url VARCHAR(512) NOT NULL,
    description VARCHAR(512),
    PRIMARY KEY (excursion_id, image_url),
    FOREIGN KEY (excursion_id) REFERENCES excursion(excursion_id)
);