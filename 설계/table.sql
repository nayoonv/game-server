create table user_account (
	hive_id bigint auto_increment primary key,
    nation_id int not null,
    language_id int not null,
    name varchar(20) not null,
    email varchar(30) not null unique key,
    password varchar(100) not null
);

create table user_account_user (
	hive_id bigint,
    user_id int,
    primary key (hive_id, user_id)
);

create table user (
	user_id int auto_increment primary key,
    level int not null default 1,
    experience int not null default 20000,
    gold int not null default 0,
    pearl int not null default 0,
    fatigue int not null default 0
);

create table user_gift_box (
	user_gift_box_id int not null primary key,
	user_id int not null,
    gift_type_id int not null,
    gift_id int not null,
    count int not null,
    received_date DATETIME not null default now(),
    received tinyint not null default 0
);

create table user_boat (
	user_id int not null primary key,
    user_boat_level int not null,
    user_boat_durability int not null,
    user_boat_fuel int not null
);

create table user_book (
    user_id int not null,
    fish_id int not null,
    catch_date  DATETIME not null,
    primary key(user_id, fish_id)
);

create table user_fish_auction (
    user_id int not null,
    gold int not null,
    sell_date DATETIME not null,
    primary key(user_id, sell_date)
);

create table user_weather (
    user_id int not null,
    time datetime not null,
    temperature int not null,
    wind_direction_id int not null,
    wind_speed int not null,
    tide_time datetime not null,
    tide_type int not null,
    tide_power int not null,
    primary key (user_id, time)
);

create table user_fish_cost(
    user_id int not null,
    fish_id int not null,
    map_id int not null,
    cost int not null,
    time datetime not null,
    length int not null,
    weight int not null,
    fish_grade_id int not null,
    primary key(user_id, fish_id, map_id, time)
);

create table inventory (
    inventory_id int not null,
	user_id int not null,
    inventory_type_id int not null,
    item_id int not null,
    get_date datetime not null
);

create table inventory_type (
	inventory_type_id int not null primary key,
    inventory_type_name varchar(10) not null
);

create table user_equip (
	user_equip_id int not null primary key,
    user_id int not null,
    equip_id int not null,
    upgrade_available tinyint not null
);

create table user_upgrade_equip (
	user_equip_id int not null primary key,
    level int not null,
    value_for_level_up int not null default 0,
    durability int not null
);

create table user_fish (
    user_fish_id int not null primary key auto_increment,
    user_id int not null,
    fish_id int not null,
    freshness int not null default 3,
    catch_date datetime not null,
    length int not null,
    weight int not null,
    before_cal tinyint default 0
);

create table user_current_equip (
	user_id  int not null primary key,
    user_rod_id int,
    user_line_id int,
    user_reel_id int,
    user_hook_id int,
    user_bait_id int,
    user_sinker_id int
);

create table user_fishing_place (
	user_id int not null primary key,
    map_id int not null,
    access_time datetime not null
);

create table user_book_prize (
	user_id int not null primary key,
    book_prize_id int not null,
    get_date datetime not null
);

create table fish (
    fish_id int not null primary key,
    map_id int not null,
    fish_name varchar(10) not null,
    favorith_depth int not null,
    depth_error_range int not null,
    fish_grade_id int not null,
    max_length int not null,
    max_weight int not null,
    price int not null,
    experience int not null
);

create table fish_grade (
  fish_grade_id int not null primary key,
  fish_grade_name varchar(2) not null,
  fish_grade_rarity int not null
);

create table map (
    map_id int not null primary key,
    map_name varchar(10) not null,
    distance int not null,
    max_depth int  not null,
    cost_to_sail int not null,
    time_to_sail int not null,
    level_limit int not null,
    reduced_durability int not null
);

create table wind_direction (
    wind_direction_id int not null primary key,
    wind_direction_name varchar(3) not null
);

create table tide (
    tide_date int not null,
    tide_time int not null,
    tide_type tinyint not null,
    tide_power int not null,
    primary key (tide_date, tide_time)
);

create table equip_map (
    map_id int not null,
    equip_id int not null,
    primary key (map_id, equip_id)
);

create table user_level (
    level int not null primary key,
    experience int not null,
    fatigue int not null,
    advantage int not null
);

create table nation (
	nation_id int not null primary key,
	nation_name varchar(10) not null
);

create table language (
	language_id int not null primary key,
    language_name varchar(10) not null
);

create table boat_level (
	level int not null primary key,
    durability int not null,
    fuel int not null
);

create table asset (
    asset_id int not null primary key,
    asset_name varchar(3) not null
);

create table book_prize (
	book_prize_id int not null primary key,
    fish_count int not null,
    asset_id int not null,
    cost int not null
);

create table gift_type (
	gift_type_id int not null primary key,
    gift_type_name varchar(10) not null
);

create table store (
    store_id int not null primary key auto_increment,
    goods_id int not null,
    goods_type_id int not null,
    asset_id int not null,
    cost int not null,
    unique key (goods_id, goods_type_id)
);

create table preparation_type (
    preparation_type_id int not null primary key,
    preparation_type_name varchar(20) not null
);

create table equip (
    equip_id int not null auto_increment primary key,
    preparation_id int not null,
    preparation_type_id int not null,
    unique key (preparation_id, preparation_type_id)
);

create table rod (
    rod_id int not null primary key,
    rod_name varchar(10),
    rod_grade_id int not null,
    rod_type_id int not null
);

create table rod_grade (
	rod_grade_id int not null primary key,
    rod_grade_name varchar(3) not null,
    rod_max_upgrade_level int not null
);

create table rod_level (
	rod_id int not null,
    rod_level int not null,
    rod_durability int not null,
    hardness int not null,
    hooking_probability int not null,
    success_probability int not null,
    value_for_next_level int not null,
    primary key (rod_id, rod_level)
);

create table rod_type (
	rod_type_id int not null primary key,
    rod_type_name varchar(20) not null
);

create table line (
	line_id int not null primary key,
    line_name varchar(20) not null,
    strength int not null,
    line_max_upgrade_level int not null
);

create table line_level (
	line_id int not null,
    line_level int not null,
	hooking_probability int not null,
    success_probability int not null,
    value_for_next_level int not null,
    primary key (line_id, line_level)
);

create table reel (
	reel_id int not null primary key,
    reel_name varchar(20) not null,
    reel_grade_id int not null,
    reel_winding_amount int not null
);

create table reel_grade (
	reel_grade_id int not null primary key,
    reel_grade_name varchar(3) not null,
    reel_max_upgrade_level int not null
);

create table reel_level (
	reel_id int not null,
    reel_level int not null,
    reel_durability int not null,
    value_for_next_level int not null,
    primary key (reel_id, reel_level)
);

create table bait (
	bait_id int not null primary key,
    bait_name varchar(20) not null,
    bait_grade_id int not null
);

create table bait_grade (
	bait_grade_id int not null primary key,
	bait_grade_name varchar(3) not null,
    advanced_appearance_probability int not null
);

create table hook (
	hook_id int not null primary key,
    hook_name varchar(20) not null,
    appearance_probability int not null,
    success_probability int not null
);

create table piece (
	piece_id int not null primary key,
    piece_name varchar(20) not null,
    piece_value int not null
);

create table sinker (
	sinker_id int not null primary key,
    sinker_name varchar(20) not null,
    sinker_weight int not null
);

create table tool (
	tool_id int not null primary key,
    tool_name varchar(20) not null,
    increased_durability int not null
);

create table fuel (
	fuel_id int not null primary key,
    fuel_name varchar(20) not null,
    increased_fuel int not null
);