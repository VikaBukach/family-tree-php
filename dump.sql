create table family_members
(
    id               int auto_increment
        primary key,
    avatar_path        varchar(255)                        null,
    file_description varchar(255)                        null,
    surname          varchar(55)                         null,
    maiden_name      varchar(55)                         null,
    name             varchar(55)                         null,
    fatherly         varchar(55)                         null,
    birth_date       date                                null,
    death_date       date                                null,
    history          text                                null,
    created_at       timestamp default CURRENT_TIMESTAMP null
)