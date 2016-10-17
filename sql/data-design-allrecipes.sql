DROP TABLE IF EXISTS favorite;
DROP TABLE IF EXISTS image;
DROP TABLE IF EXISTS recipe;
DROP TABLE IF EXISTS profile;


CREATE TABLE profile (
	-- primary key
	profileUserId      INT UNSIGNED AUTO_INCREMENT NOT NULL,
	profileEmail       VARCHAR(128)                NOT NULL,
	-- avatarId is a foreign key
	-- should this reference an image file directly?
	-- VARCHAR(260)
	profileAvatarImage VARCHAR(260),
	UNIQUE (profileEmail),
	-- index foreign key

	PRIMARY KEY (profileUserId)

);

CREATE TABLE recipe (
	recipeIngredients VARCHAR(5000) NOT NULL,
	recipeDirections VARCHAR(10000) NOT NULL,
	-- primary key
	recipeId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	-- foreign key
	recipeUserId INT UNSIGNED NOT NULL,
	recipePrepTime INT UNSIGNED,
	recipeCookTime INT UNSIGNED,
	recipeFootnotes VARCHAR(420),
	-- index foreign key
	INDEX(recipeUserId),
	FOREIGN KEY(recipeUserId) REFERENCES profile(profileUserId),
	PRIMARY KEY(recipeId)
);

CREATE TABLE image (
	-- primary key
	imageId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	imageFile VARCHAR(260) NOT NULL,
	-- foreign key
	imageRecipeId INT UNSIGNED NOT NULL,
	-- index foreign key
	INDEX (imageRecipeId),
	FOREIGN KEY(imageRecipeId) REFERENCES recipe(recipeId),
	PRIMARY KEY(imageId)
);


CREATE TABLE favorite (
	-- both attributes are foreign keys
	favoriteRecipeId INT UNSIGNED NOT NULL,
	favoriteUserId INT UNSIGNED NOT NULL,
	-- index foreign keys
	INDEX(favoriteRecipeId),
	INDEX (favoriteUserId),
	-- create the foreign key relations
	FOREIGN KEY(favoriteRecipeId) REFERENCES recipe(recipeId),
	FOREIGN KEY (favoriteUserId) REFERENCES profile (profileUserId),
	PRIMARY KEY (favoriteRecipeId, favoriteUserId)
);

