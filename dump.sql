CREATE TABLE family_members
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
    death_date       date                                null
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
    ('Племіннник')