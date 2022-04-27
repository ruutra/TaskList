drop table if exists `tasks`;
create table `tasks` (
    `id` bigint unsigned auto_increment primary key,
    `user_id` bigint (10) unsigned not null,
    `description` varchar(255) not null,
    `status` bool not null,
    `created_at` datetime not null,
    INDEX `IDX_tasksUserid` (`user_id`),
    FOREIGN KEY (`user_id`)  REFERENCES `users` (`id`)
);
insert into `tasks` (`user_id`, `description`,`created_at`,`status`) values
    (1, 'first task', NOW(), 1),
    (1, 'second task', NOW(), 0),
    (1, 'last task', NOW(), 0)
;