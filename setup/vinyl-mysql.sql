drop table if exists vinyl;
create table vinyl (
  id int auto_increment primary key not null,
  artist varchar(100) not null,
  title varchar(150) not null,
  records varchar(10) default '?',
  country varchar(30) not null default 'USA',
  cond varchar(10) not null,                    -- opened or sealed
  prod_year int not null, 
  upc varchar(30),                                       -- UPC or CAT#
  category varchar(50) not null,
  description text,
  image varchar(255) not null default '',
  created_at int not null,
  vinyl_size varchar(6)                            -- 7" or 12"
);