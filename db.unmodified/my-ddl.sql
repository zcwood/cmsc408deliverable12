

CREATE TABLE GAME_DEVELOPER (
    GAME_DEV_id INT AUTO_INCREMENT PRIMARY KEY,
    Username VARCHAR(255) NOT NULL
);


-- Create the SPRITE_ARTIST table
CREATE TABLE SPRITE_ARTIST (
    SPRITE_ARTIST_id INT AUTO_INCREMENT PRIMARY KEY,
    Username VARCHAR(255) NOT NULL
);

-- Create the SOUND_DESIGNER table
CREATE TABLE SOUND_DESIGNER (
    SOUND_DESIGNER_id INT AUTO_INCREMENT PRIMARY KEY,
    Username VARCHAR(255) NOT NULL
);

-- Create the VIDEO_GAME table
CREATE TABLE VIDEO_GAME (
    game_id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    genre VARCHAR(100),
    suggested_age_for_players INT
);

-- Create the SPRITE table
CREATE TABLE SPRITE (
    SPRITE_ID INT AUTO_INCREMENT PRIMARY KEY,
    Sprite_Name VARCHAR(255) NOT NULL
);

-- Create the SOUND table
CREATE TABLE SOUND (
    SOUND_ID INT AUTO_INCREMENT PRIMARY KEY,
    Sound_Name VARCHAR(255) NOT NULL,
    Length INT
);

-- Create the PROJECTILE table
CREATE TABLE PROJECTILE (
    PROJECTILE_id INT AUTO_INCREMENT PRIMARY KEY,
    Projectile_Name VARCHAR(255) NOT NULL,
    velocity INT,
    AI_type VARCHAR(100),
    lifespan INT,
    starting_health INT,
    contact_damage INT,
    secondary_proj_id INT,
    FOREIGN KEY (secondary_proj_id) REFERENCES PROJECTILE(PROJECTILE_id)
);

-- Create the ITEM_DROPS table
CREATE TABLE ITEM_DROPS (
    ITEM_id INT AUTO_INCREMENT PRIMARY KEY,
    drop_chance INT
);

-- Create the NPC table
CREATE TABLE NPC (
    NPC_id INT AUTO_INCREMENT PRIMARY KEY,
    NPC_Name VARCHAR(255) NOT NULL,
    SPRITE_ID INT,
    Projectile_use_ID INT,
    starting_health INT,
    contact_damage INT,
    defense INT,
    armor INT,
    speed INT,
    aggro_range INT,
    AI_type VARCHAR(100),
    biome VARCHAR(100),
    spawns_during_day BOOLEAN,
    spawns_at_night BOOLEAN,
    is_boss BOOLEAN,
    is_miniboss BOOLEAN,
    team VARCHAR(100),
    spawn_chance INT,
    spawn_cap_contribution INT,
    ignores_spawn_cap BOOLEAN,
    max_number_allowed INT,
    number_defeated_by_player INT,
    player_deaths INT,
    spawns_on_easy_diff BOOLEAN,
    spawns_on_mediumcore_diff BOOLEAN,
    spawns_on_hardcore_diff BOOLEAN,
    SOUND_ID INT,
    ITEM_DROPS_ID INT,
    FOREIGN KEY (SPRITE_ID) REFERENCES SPRITE(SPRITE_ID),
    FOREIGN KEY (Projectile_use_ID) REFERENCES PROJECTILE(PROJECTILE_id),
    FOREIGN KEY (SOUND_ID) REFERENCES SOUND(SOUND_ID),
    FOREIGN KEY (ITEM_DROPS_ID) REFERENCES ITEM_DROPS(ITEM_id)
);


-- Insert the Forest-themed NPC into the NPC table
-- Insert the Forest-themed NPC into the NPC table
-- Insert records into the GAME_DEV table
INSERT INTO GAME_DEVELOPER (GAME_DEV_id, Username) VALUES 
('001', 'MichealG'),
('002', 'German925'),
('003', 'SarahLovesGames2232'),
('004', 'ILikeGrapes'),
('005', 'SolidSnake5Ever');

-- Insert records into the SPRITE_ARTIST table
INSERT INTO SPRITE_ARTIST (SPRITE_ARTIST_id, Username) VALUES 
('001', 'John Smith'),
('002', 'Smith Johnson'),
('003', 'IDontLikeGrapes'),
('004', 'CourtneyW373'),
('005', 'SuperCoolDesigner');

-- Insert records into the SOUND_DESIGNER table
INSERT INTO SOUND_DESIGNER (SOUND_DESIGNER_id, Username) VALUES 
('001', 'Superdesignerson'),
('002', 'Soundsmith'),
('003', 'Sounddesignersmith'),
('004', 'Soundmage'),
('005', 'DSoundman');

-- Insert records into the SOUND table
-- Insert records into SOUND table
INSERT INTO SOUND (SOUND_ID, Sound_Name, Length)
VALUES 
    (001, 'Gloomshade Roar', 5),    -- 5 seconds
    (002, 'Mossling Mumble', 2),    -- 2 seconds
    (003, 'Wisp Boss Scream', 4),   -- 4 seconds
    (004, 'Deep Mossling Mumble', 3), -- 3 seconds
    (005, 'Wisp Squeal', 2),        -- 2 seconds
    (006, 'HellBore Cooing', 10);   -- 10 seconds


-- Insert records into the SPRITE table
INSERT INTO SPRITE (SPRITE_ID, Sprite_Name) VALUES 
('001', 'Gloomshade'),
('002', 'Mossling'),
('003', 'Wisp Boss'),
('004', 'Deep Mossling'),
('005', 'Wisp'),
('006', 'HellBore');

-- Insert records into the ITEM_DROPS table
INSERT INTO ITEM_DROPS (ITEM_id, drop_chance) VALUES 
    (1, 1),
    (2, 0.2),
    (3, 0.15),
    (4, 0.25),
    (5, 0.2),
    (6, 0.3);

-- Step 1: Insert projectiles without secondary references
INSERT INTO PROJECTILE (PROJECTILE_id, Projectile_Name, velocity, AI_type, lifespan, starting_health, contact_damage, secondary_proj_id)
VALUES
    (1, 'Leafling', 15, 'leafling Swarm AI', 200, 50, 20, NULL),
    (2, 'Wisp Flame', 5, 'Flame Attack AI', 10, -1, 30, NULL),
    (3, 'Wisp Fireball', 8, 'Linear projectile AI', 5, 5, 10, NULL); 

-- Step 2: Insert projectiles with secondary references
INSERT INTO PROJECTILE (PROJECTILE_id, Projectile_Name, velocity, AI_type, lifespan, starting_health, contact_damage, secondary_proj_id)
VALUES
    (4, 'Leafling Razor', 20, 'Linear Projectile AI', 4, 10, 25, 1);  -- Valid reference to PROJECTILE_id = 1



-- Insert records into the NPC table
INSERT INTO NPC (NPC_id, NPC_Name, SPRITE_ID, starting_health, contact_damage, defense, armor, speed, aggro_range, AI_type, biome, spawns_during_day, spawns_at_night, is_boss, is_miniboss, team, spawn_chance, spawn_cap_contribution, ignores_spawn_cap, max_number_allowed, number_defeated_by_player, player_deaths, spawns_on_easy_diff, spawns_on_mediumcore_diff, spawns_on_hardcore_diff, Projectile_use_ID, SOUND_ID, ITEM_DROPS_ID) 
VALUES 
    (1, 'Gloomshade', 1, 2000, 50, 15, 500, 5, 100, 'Gloomshade_Miniboss', 'Shaded Wood', TRUE, TRUE, FALSE, TRUE, 'Forest Enemy', 0.1, 20, TRUE, 1, 0, 4, FALSE, TRUE, TRUE, 1, 1, 1),
    (2, 'Mossling', 2, 45, 8, 2, 5, 15, 30, 'Basic Fighter', 'Shaded Wood', TRUE, FALSE, FALSE, FALSE, 'Forest Enemy', 0.8, 2, FALSE, 30, 215, 1, TRUE, TRUE, FALSE, 1, 2, 2),
    (3, 'Wisp Wraith', 3, 150, 20, 15, 50, 25, 100, 'Wisp Wraith AI', 'Shaded Wood', TRUE, FALSE, FALSE, TRUE, 'Forest Enemy', 0.1, 10, FALSE, 3, 0, 8, FALSE, TRUE, TRUE, 2, 3, 3),
    (4, 'Black Mossling', 4, 70, 14, 5, 10, 18, 35, 'Basic Fighter', 'Shaded Wood', FALSE, TRUE, FALSE, FALSE, 'Forest Enemy', 0.8, 2, FALSE, 15, 100, 5, TRUE, TRUE, TRUE, 1, 4, 4),
    (5, 'Wisp', 5, 45, 20, 5, 0, 25, 50, 'Wisp Wraith AI', 'Shaded Wood', TRUE, FALSE, FALSE, FALSE, 'Forest Enemy', 0.4, 2, FALSE, 20, 132, 11, TRUE, TRUE, TRUE, 3, 5, 5),
    (6, 'Hell Bore', 6, 30, 5, 0, 0, 30, 100, 'AoE Coward AI', 'Shaded Wood', TRUE, TRUE, FALSE, FALSE, 'Forest Enemy', 0.2, 2, FALSE, 3, 100, 5, TRUE, TRUE, TRUE, 4, 6, 6);



