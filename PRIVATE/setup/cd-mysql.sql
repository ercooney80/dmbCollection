drop table if exists cd;
create table cd (
  id int auto_increment primary key not null,
  artist varchar(100) not null,
  title varchar(150) not null,
  discs varchar(10) not null,
  country varchar(30) default 'USA',
  cond varchar(10) not null,                    -- opened or sealed
  prod_year int not null,
  upc varchar(30) not null,                              -- UPC or CAT#
  category varchar(50) not null,
  description text,
  image varchar(255) not null default '',           -- leave for now
  created_at int not null
);
