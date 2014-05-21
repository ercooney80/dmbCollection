drop table if exists cd;
create table cd (
  id int auto_increment primary key not null,
  artist varchar(100) not null,
  title varchar(150) not null,
  discs varchar(5) not null,
  country varchar(40) not null,
  cond varchar(10) not null,              
  prod_year int not null,
  upc varchar(30),                             
  category varchar(50) not null,
  description text,
  image varchar(255) not null default '',
  created_at int not null
);
