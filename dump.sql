create table family_members
(
    id          int auto_increment
        primary key,
    avatar_path varchar(255)                        null,
    surname     varchar(55)                         null,
    maiden_name varchar(55)                         null,
    name        varchar(55)                         null,
    fatherly    varchar(55)                         null,
    birth_date  date                                null,
    history     text                                null,
    created_at  timestamp default CURRENT_TIMESTAMP null,
    status      varchar(20)                         null,
    death_date  date                                null,
    sex         tinyint                             not null,
    user_id     int                                 null,
    constraint fk_family_members_user_id
        foreign key (user_id) references users (id)
            on update cascade on delete set null
);

CREATE TABLE relationships (
                               id INT AUTO_INCREMENT PRIMARY KEY,
                               member_id INT NOT NULL, -- Член родини
                               related_member_id INT NOT NULL, -- Зв'язаний член родини
                               relationship_type INT NOT NULL, -- Тип відносин (тато, мама, брат тощо)
                               FOREIGN KEY (member_id) REFERENCES family_members(id) ON DELETE CASCADE,
                               FOREIGN KEY (related_member_id) REFERENCES family_members(id) ON DELETE CASCADE
);


CREATE TABLE cards (
                       id INT AUTO_INCREMENT PRIMARY KEY,
                       family_member_id INT NOT NULL,
                       image_path VARCHAR(255) NOT NULL,
                       title VARCHAR(255) NOT NULL,
                       description TEXT NOT NULL,
                       FOREIGN KEY (family_member_id) REFERENCES family_members(id) ON DELETE CASCADE
);

create table users
(
    id           int auto_increment
        primary key,
    username     varchar(55)                           not null,
    userlastname varchar(55)                           not null,
    login        varchar(55)                           not null,
    password     varchar(55)                           not null,
    created_at   timestamp   default CURRENT_TIMESTAMP null,
    updated_at   timestamp   default CURRENT_TIMESTAMP null on update CURRENT_TIMESTAMP,
    role         varchar(55) default 'Viewer'          not null,
    constraint username
        unique (username)
);
