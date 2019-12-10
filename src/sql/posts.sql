CREATE TABLE posts(
    id int(10) not null auto_increment,
    user_id int(10) not null,
    title varchar(255) not null,
    content text not null,
    primary key (id)
);
