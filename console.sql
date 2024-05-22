create database exp_4;
use exp_4;

drop table users;
create table users
(
    id       int auto_increment primary key,
    username varchar(50)                     not null unique,
    name     varchar(100)                    not null,
    passwd   varchar(256)                    not null,
    identify enum ('管理员','球员','教练')   not null,
    status   enum ('通过','审核中','未通过') not null
);
delete
from users
where username = 'tmp';
alter table users
    modify passwd varchar(256) not null;

drop table person_message;
create table person_message
(
    sex      enum ('男','女','未知'),
    username varchar(50) not null primary key,
    tel      varchar(15)  default (NULL),
    email    varchar(256) default (NULL),
    foreign key (username) references users (username) on update cascade on delete cascade
);

drop view person_users;
create view person_users(id, username, name, sex, identify, tel, email) as
select users.id,
       users.username,
       users.name,
       person_message.sex,
       users.identify,
       person_message.tel,
       person_message.email
from users,
     person_message
where users.username = person_message.username
with cascaded check option;

create trigger person_users_insert
    after insert
    on users
    for each row
begin
    insert into person_message(username) values (new.username);
end;


drop table contract;
create table contract
(
    id    int primary key,
    start date,
    end   date,
    foreign key (id) references users (id) on update cascade on delete cascade
);
#update users set status='通过' where status='通过';
DROP TRIGGER IF EXISTS user_status_insert;
CREATE TRIGGER user_status_insert
    AFTER INSERT
    ON users
    FOR EACH ROW
BEGIN
    IF NEW.status = '通过' AND (NEW.identify = '球员' OR NEW.identify = '教练') THEN
        IF NOT EXISTS (SELECT 1 FROM contract WHERE id = NEW.id) THEN
            INSERT INTO contract(id, start) VALUES (NEW.id, NOW());
        END IF;
    END IF;
END;

DROP TRIGGER IF EXISTS user_status_update;
CREATE TRIGGER user_status_update
    AFTER UPDATE
    ON users
    FOR EACH ROW
BEGIN
    IF NEW.status = '通过' AND (NEW.identify = '球员' OR NEW.identify = '教练') THEN
        IF NOT EXISTS (SELECT 1 FROM contract WHERE id = NEW.id) THEN
            INSERT INTO contract(id, start) VALUES (NEW.id, NOW());
        END IF;
    END IF;
END;

drop view coach_message;
update users
set status='通过'
where username = 'James';
create view coach_message(id, sex,username, name, tel, email, start, end) as
select u.id,p.sex,u.username, u.name, p.tel, p.email, c.start, c.end
from users u,
     person_message p,
     contract c
where u.id = c.id
  and u.username = p.username
  and identify = '教练'
with cascaded check option;


create table player_basic_message
(
    id     int primary key,
    height float,
    weight float,
    foreign key (id) references users (id) on update cascade on delete cascade
);

DROP TRIGGER IF EXISTS player_basic_message_update;
create trigger player_basic_message_update
    after update
    on users
    for each row
begin
    IF NEW.status = '通过' AND NEW.identify = '球员' THEN
        IF NOT EXISTS (SELECT 1 FROM player_basic_message WHERE id = NEW.id) THEN
            INSERT INTO player_basic_message(id) VALUES (NEW.id);
        END IF;
    END IF;
end;
DROP TRIGGER IF EXISTS player_basic_message_insert;
create trigger player_basic_message_insert
    after INSERT
    on users
    for each row
begin
    IF NEW.status = '通过' AND NEW.identify = '球员' THEN
        IF NOT EXISTS (SELECT 1 FROM player_basic_message WHERE id = NEW.id) THEN
            INSERT INTO player_basic_message(id) VALUES (NEW.id);
        END IF;
    END IF;
end;

drop view if exists player_message;
create view player_message as
select u.id,
       p.sex,
       u.username,
       u.name,
       p.tel,
       p.email,
       c.start,
       c.end,
       b.height,
       b.weight
from users u,
     person_message p,
     contract c,
     player_basic_message b
where u.username = p.username
  and u.id = c.id
  and u.id = b.id
  and u.identify = '球员'
with cascaded check option;


create table team
(
    team_id      int auto_increment primary key,
    team_name    varchar(50) unique not null,
    team_clothes varchar(50),
    team_badge   varchar(50)
);
insert into team (team_name, team_clothes, team_badge)
values ('冬日', 'champion winter', 'winter winner'),
       ('Atlanta Hawks', 'Hawks Uniform', 'Hawks Badge'),
       ('Boston Celtics', 'Celtics Uniform', 'Celtics Badge'),
       ('Brooklyn Nets', 'Nets Uniform', 'Nets Badge'),
       ('Chicago Bulls', 'Bulls Uniform', 'Bulls Badge'),
       ('Cleveland Cavaliers', 'Cavaliers Uniform', 'Cavaliers Badge'),
       ('Dallas Mavericks', 'Mavericks Uniform', 'Mavericks Badge'),
       ('Denver Nuggets', 'Nuggets Uniform', 'Nuggets Badge'),
       ('Los Angeles Lakers', 'Lakers Uniform', 'Lakers Badge'),
       ('Golden State Warriors', 'Warriors Uniform', 'Warriors Badge');

drop table  compete_message;
create table compete_message
(
    com_id int auto_increment primary key ,
    team1 varchar(50) not null default ('冬日'),
    team2 varchar(50) not null,
    location varchar(100) not null ,
    start datetime not null,
    end datetime not null,
    state enum('主场','客场') not null ,
    foreign key(team2) references team(team_name) on update cascade on delete cascade
);
INSERT INTO compete_message (team2, location, start, end, state) VALUES
('Atlanta Hawks', 'Atlanta Arena', '2024-06-01 18:00:00', '2024-06-01 20:00:00', '主场'),
('Boston Celtics', 'Boston Stadium', '2024-06-02 19:00:00', '2024-06-02 21:00:00', '客场'),
('Brooklyn Nets', 'Brooklyn Center', '2024-06-03 17:00:00', '2024-06-03 19:00:00', '主场'),
('Chicago Bulls', 'Chicago Coliseum', '2024-06-04 18:30:00', '2024-06-04 20:30:00', '客场'),
('Cleveland Cavaliers', 'Cleveland Arena', '2024-06-05 19:30:00', '2024-06-05 21:30:00', '主场'),
('Dallas Mavericks', 'Dallas Center', '2024-06-06 18:00:00', '2024-06-06 20:00:00', '客场'),
('Denver Nuggets', 'Denver Stadium', '2024-06-07 17:30:00', '2024-06-07 19:30:00', '主场'),
('Los Angeles Lakers', 'Los Angeles Coliseum', '2024-06-08 18:45:00', '2024-06-08 20:45:00', '客场'),
('Golden State Warriors', 'Golden State Center', '2024-06-09 19:15:00', '2024-06-09 21:15:00', '主场'),
('Atlanta Hawks', 'Atlanta Arena', '2024-06-10 18:30:00', '2024-06-10 20:30:00', '客场'),
('Boston Celtics', 'Boston Stadium', '2024-06-11 19:00:00', '2024-06-11 21:00:00', '主场'),
('Brooklyn Nets', 'Brooklyn Center', '2024-06-12 17:45:00', '2024-06-12 19:45:00', '客场'),
('Chicago Bulls', 'Chicago Coliseum', '2024-06-13 18:15:00', '2024-06-13 20:15:00', '主场'),
('Cleveland Cavaliers', 'Cleveland Arena', '2024-06-14 19:30:00', '2024-06-14 21:30:00', '客场'),
('Dallas Mavericks', 'Dallas Center', '2024-06-15 17:30:00', '2024-06-15 19:30:00', '主场'),
('Denver Nuggets', 'Denver Stadium', '2024-06-16 18:00:00', '2024-06-16 20:00:00', '客场'),
('Los Angeles Lakers', 'Los Angeles Coliseum', '2024-06-17 19:15:00', '2024-06-17 21:15:00', '主场'),
('Golden State Warriors', 'Golden State Center', '2024-06-18 18:45:00', '2024-06-18 20:45:00', '客场'),
('Atlanta Hawks', 'Atlanta Arena', '2024-06-19 19:30:00', '2024-06-19 21:30:00', '主场'),
('Boston Celtics', 'Boston Stadium', '2024-06-20 18:00:00', '2024-06-20 20:00:00', '客场');




