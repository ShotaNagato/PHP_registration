
create table pre_user (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(128) NOT NULL,
    urltoken VARCHAR(255) NOT NULL,
    date DATETIME NOT NULL,
    flag TINYINT(1) NOT NULL DEFAULT 0
);

CREATE TABLE user (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(128) NOT NULL,
    name VARCHAR(128) NOT NULL,
    password VARCHAR(128) NOT NULL,
    status INT(1) NOT NULL DEFAULT 2,
    created_at DATETIME,
    updated_at DATETIME
);