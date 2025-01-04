create table family_members
(
    id               int auto_increment
        primary key,
    avatar_path      varchar(255)                        null,
    file_description varchar(255)                        null,
    surname          varchar(55)                         null,
    maiden_name      varchar(55)                         null,
    name             varchar(55)                         null,
    fatherly         varchar(55)                         null,
    birth_date       date                                null,
    history          text                                null,
    created_at       timestamp default CURRENT_TIMESTAMP null,
    status           varchar(20)                         null,
    death_date       date                                null,
    sex              tinyint                             not null
);

CREATE TABLE relationships (
                               id INT AUTO_INCREMENT PRIMARY KEY,
                               member_id INT NOT NULL, -- Член родини
                               related_member_id INT NOT NULL, -- Зв'язаний член родини
                               relationship_type INT NOT NULL, -- Тип відносин (тато, мама, брат тощо)
                               FOREIGN KEY (member_id) REFERENCES family_members(id) ON DELETE CASCADE,
                               FOREIGN KEY (related_member_id) REFERENCES family_members(id) ON DELETE CASCADE
);

create table roles
(
    id_role        int auto_increment
        primary key,
    role_name varchar(50) not null
);

INSERT INTO roles (role_name)
VALUES
    ('Батько'),
    ('Мати'),
    ('Дідусь'),
    ('Бабуся'),
    ('Брат'),
    ('Сестра'),
    ('Син'),
    ('Чоловік'),
    ('Дружина'),
    ('Дядько'),
    ('Тітка'),
    ('Двоюрідні сестра'),
    ('Двоюрідний брат'),
    ('Прабабка'),
    ('Прадід'),
    ('Племінниця'),
    ('Племіннник'),
    ('Онука'),
    ('Онук'),
    ('Донька'),
    ('Прадід'),
    ('Прабабуся'),
    ('Невістка'),
    ('Зять'),
    ('Теща'),
    ('Тесть'),

CREATE TABLE cards (
                       id INT AUTO_INCREMENT PRIMARY KEY,
                       family_member_id INT NOT NULL,
                       image_path VARCHAR(255) NOT NULL,
                       title VARCHAR(255) NOT NULL,
                       description TEXT NOT NULL,
                       FOREIGN KEY (family_member_id) REFERENCES family_members(id) ON DELETE CASCADE
);

CREATE TABLE users(
                      id INT AUTO_INCREMENT PRIMARY KEY,
                      username VARCHAR(255) NOT NULL UNIQUE,
                      email VARCHAR(255) NOT NULL UNIQUE,
                      password VARCHAR(255) NOT NULL,
                      created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                      updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

ALTER TABLE family_members
    ADD COLUMN  user_id INT DEFAULT NULL,
    ADD CONSTRAINT fk_family_members_user_id FOREIGN KEY(user_id) REFERENCES users (id) ON DELETE SET NULL ON UPDATE CASCADE;

SELECT * FROM family_members fm JOIN users u ON fm.user_id = u.id

alter table users
    modify role VARCHAR(55) default 'Viewer' not null;