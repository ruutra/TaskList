drop table if exists `tasks`.`users`;
create table `tasks`.`users` (
    `id` bigint unsigned auto_increment primary key,
    `login` varchar(255) not null,
    `password` varchar(255) not null,
    `created_at` datetime not null
);

insert into `tasks`.`users` (`id`,`login`, `password`,`created_at`) values
(`id`,'test', '$2y$10$8phwzkZ8TFmKTCR/E/zsw.IyEeuIjb9MogKMBFILY7cdkJ2jX2NEi', NOW());
