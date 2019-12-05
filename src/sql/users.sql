CREATE TABLE users(
    id int(10) not null auto_increment,
    first_name varchar(50) not null,
    last_name varchar(50) not null,
    gender enum('0','1') not null,
    name_prefix varchar(50) not null,
    primary key (id)
);

INSERT INTO users(first_name, last_name, gender, name_prefix)
VALUES ('John', 'Doe', '0', 'Prof. Dr.');
